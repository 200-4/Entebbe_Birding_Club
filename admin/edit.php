<?php
require_once __DIR__ . '/../private/bootstrap.php';
require_admin();
try { $pdo = db(); } catch (Throwable $error) { render_db_error($error); }
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
$isEdit = $id > 0;
$error = '';
$post = ['title' => '', 'category' => '', 'summary' => '', 'body' => ''];
$images = [];

if ($isEdit) {
  $query = $pdo->prepare('SELECT * FROM posts WHERE id = :id');
  $query->execute(['id' => $id]);
  $post = $query->fetch() ?: null;
  if (!$post) { header('Location: index.php'); exit; }
  $query = $pdo->prepare('SELECT * FROM post_images WHERE post_id = :id ORDER BY sort_order, id');
  $query->execute(['id' => $id]);
  $images = $query->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  verify_csrf();
  $post = [
    'title' => trim((string) ($_POST['title'] ?? '')),
    'category' => trim((string) ($_POST['category'] ?? '')),
    'summary' => trim((string) ($_POST['summary'] ?? '')),
    'body' => trim((string) ($_POST['body'] ?? '')),
  ];
  $newFiles = [];
  try {
    $length = static fn(string $value): int => function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
    if ($post['title'] === '' || $length($post['title']) > 200) throw new RuntimeException('Add a title of up to 200 characters.');
    if ($post['category'] === '' || $length($post['category']) > 120) throw new RuntimeException('Add a category of up to 120 characters.');
    if ($post['summary'] === '' || $length($post['summary']) > 500) throw new RuntimeException('Add a short summary of up to 500 characters.');
    if ($post['body'] === '') throw new RuntimeException('Add the full story.');

    $current = [];
    if ($isEdit) {
      $query = $pdo->prepare('SELECT * FROM post_images WHERE post_id = :id ORDER BY sort_order, id');
      $query->execute(['id' => $id]);
      $current = $query->fetchAll();
    }
    $removeIds = array_values(array_unique(array_filter(array_map('intval', (array) ($_POST['remove_images'] ?? [])))));
    $currentById = [];
    foreach ($current as $image) $currentById[(int) $image['id']] = $image;
    foreach ($removeIds as $removeId) if (!isset($currentById[$removeId])) throw new RuntimeException('An image selection was invalid. Reload the form and try again.');
    $kept = array_values(array_filter($current, static fn(array $image): bool => !in_array((int) $image['id'], $removeIds, true)));

    $uploads = [];
    if (isset($_FILES['photos']) && is_array($_FILES['photos']['name'])) {
      foreach ($_FILES['photos']['name'] as $key => $name) {
        $code = (int) ($_FILES['photos']['error'][$key] ?? UPLOAD_ERR_NO_FILE);
        if ($code === UPLOAD_ERR_NO_FILE) continue;
        if ($code !== UPLOAD_ERR_OK) throw new RuntimeException('One of the photos could not be uploaded. Check the file size and try again.');
        $uploads[] = ['tmp_name' => $_FILES['photos']['tmp_name'][$key], 'size' => (int) $_FILES['photos']['size'][$key]];
      }
    }
    if (count($uploads) > 3 || count($kept) + count($uploads) !== 3) {
      throw new RuntimeException('Each post needs exactly three photos. Remove the photos you want to replace, then select enough new photos to keep the total at three.');
    }

    $uploadDir = __DIR__ . '/../uploads/posts';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) throw new RuntimeException('The post image folder could not be created.');
    if (!is_writable($uploadDir)) throw new RuntimeException('The post image folder is not writable by PHP.');
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    foreach ($uploads as $upload) {
      if ($upload['size'] < 1 || $upload['size'] > 5 * 1024 * 1024) throw new RuntimeException('Each photo must be smaller than 5 MB.');
      $mime = $finfo->file($upload['tmp_name']);
      $size = @getimagesize($upload['tmp_name']);
      if (!isset($allowed[$mime]) || !$size || $size[0] > 8000 || $size[1] > 8000 || ($size[0] * $size[1]) > 30000000) {
        throw new RuntimeException('Use valid JPG, PNG or WebP photos up to 8,000 pixels per side.');
      }
      $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
      if (!move_uploaded_file($upload['tmp_name'], $uploadDir . '/' . $filename)) throw new RuntimeException('A photo could not be saved. Check folder permissions.');
      $newFiles[] = 'uploads/posts/' . $filename;
    }

    $pdo->beginTransaction();
    $base = function_exists('iconv') ? iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $post['title']) : $post['title'];
    $base = trim(strtolower((string) preg_replace('/[^A-Za-z0-9]+/', '-', $base)), '-');
    if ($base === '') $base = 'club-story';
    $slug = substr($base, 0, 160);
    $suffix = 2;
    while (true) {
      $check = $pdo->prepare('SELECT id FROM posts WHERE slug = :slug' . ($isEdit ? ' AND id <> :id' : '') . ' LIMIT 1');
      $params = ['slug' => $slug];
      if ($isEdit) $params['id'] = $id;
      $check->execute($params);
      if (!$check->fetchColumn()) break;
      $ending = '-' . $suffix++;
      $slug = substr($base, 0, 180 - strlen($ending)) . $ending;
    }

    if ($isEdit) {
      $save = $pdo->prepare('UPDATE posts SET slug = :slug, title = :title, category = :category, summary = :summary, body = :body, updated_at = CURRENT_TIMESTAMP WHERE id = :id');
      $save->execute(['slug' => $slug, 'title' => $post['title'], 'category' => $post['category'], 'summary' => $post['summary'], 'body' => $post['body'], 'id' => $id]);
      if ($removeIds) {
        $placeholders = [];
        $params = ['post_id' => $id];
        foreach ($removeIds as $index => $removeId) { $placeholders[] = ':image' . $index; $params['image' . $index] = $removeId; }
        $delete = $pdo->prepare('DELETE FROM post_images WHERE post_id = :post_id AND id IN (' . implode(',', $placeholders) . ')');
        $delete->execute($params);
      }
      foreach ($kept as $order => $image) {
        $sort = $pdo->prepare('UPDATE post_images SET sort_order = :sort_order WHERE id = :id AND post_id = :post_id');
        $sort->execute(['sort_order' => $order + 1, 'id' => $image['id'], 'post_id' => $id]);
      }
    } else {
      $save = $pdo->prepare('INSERT INTO posts (slug, title, category, summary, body) VALUES (:slug, :title, :category, :summary, :body) RETURNING id');
      $save->execute(['slug' => $slug, 'title' => $post['title'], 'category' => $post['category'], 'summary' => $post['summary'], 'body' => $post['body']]);
      $id = (int) $save->fetchColumn();
    }

    $addImage = $pdo->prepare('INSERT INTO post_images (post_id, image_path, alt_text, sort_order) VALUES (:post_id, :path, :alt, :sort_order)');
    foreach ($newFiles as $offset => $path) $addImage->execute(['post_id' => $id, 'path' => $path, 'alt' => $post['title'], 'sort_order' => count($kept) + $offset + 1]);
    $pdo->commit();
    foreach ($removeIds as $removeId) {
      $oldPath = $currentById[$removeId]['image_path'] ?? '';
      if (is_managed_post_image($oldPath)) @unlink(__DIR__ . '/../' . $oldPath);
    }
    header('Location: index.php?saved=1');
    exit;
  } catch (Throwable $exception) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    foreach ($newFiles as $path) @unlink(__DIR__ . '/../' . $path);
    if ($exception instanceof RuntimeException) $error = $exception->getMessage();
    else { error_log('EBC post save error: ' . $exception->getMessage()); $error = 'The post could not be saved. Check the server error log and try again.'; }
  }
}

$pageTitle = ($isEdit ? 'Edit Post' : 'Create Post') . ' — Entebbe Birding Club';
$isPostsPage = true;
include __DIR__ . '/../header.php';
?>
<main><section class="section section--parchment admin-section"><div class="container admin-wrap admin-editor">
  <a class="story-back" href="index.php">← Back to posts</a>
  <div class="admin-heading"><span class="eyebrow">Club publishing</span><h1><?= $isEdit ? 'Edit post' : 'Create a post' ?></h1><p>Write the story and choose three JPG, PNG or WebP photos. Photos can be up to 5 MB each.</p></div>
  <?php if ($error): ?><p class="admin-error" role="alert"><?= e($error) ?></p><?php endif; ?>
  <form class="admin-form" method="post" enctype="multipart/form-data" action="<?= $isEdit ? 'edit.php?id=' . (int) $id : 'edit.php' ?>">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <label>Post title<input name="title" maxlength="200" required value="<?= e($post['title']) ?>"></label>
    <label>Category<input name="category" maxlength="120" required placeholder="Excursion · Entebbe" value="<?= e($post['category']) ?>"></label>
    <label>Short summary<textarea name="summary" rows="3" maxlength="500" required><?= e($post['summary']) ?></textarea><small>Up to 500 characters. This appears on the post card and search preview.</small></label>
    <label>Full story<textarea name="body" rows="12" required><?= e($post['body']) ?></textarea><small>Separate paragraphs with a blank line.</small></label>
    <?php if ($images): ?>
      <fieldset class="admin-photo-options"><legend>Current photos</legend><p>Tick any photos you want to replace, then upload the same number of new photos.</p>
        <div class="admin-photo-list">
          <?php foreach ($images as $image): ?><label class="admin-photo-choice"><img src="../<?= e($image['image_path']) ?>" alt="<?= e($image['alt_text']) ?>"><span><input type="checkbox" name="remove_images[]" value="<?= (int) $image['id'] ?>"> Replace this photo</span></label><?php endforeach; ?>
        </div>
      </fieldset>
    <?php endif; ?>
    <label>Upload photos<input type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple <?= $isEdit ? '' : 'required' ?>><small><?= $isEdit ? 'Select replacement photos for any photos you marked above.' : 'Select exactly three photos.' ?> Maximum 5 MB per photo.</small></label>
    <div class="admin-form-actions"><button class="btn btn--solid" type="submit">Save post</button><a class="btn btn--outline on-light" href="index.php">Cancel</a></div>
  </form>
</div></section></main>
<?php include __DIR__ . '/../footer.php'; ?>
