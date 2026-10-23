<?php
require_once __DIR__ . '/../private/bootstrap.php';
try {
  $pdo = db();
  start_admin_session();
  $error = '';
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_SESSION['admin_id'])) {
    verify_csrf();
    if (!empty($_SESSION['login_lock_until']) && $_SESSION['login_lock_until'] > time()) {
      $error = 'Too many sign-in attempts. Please wait a few minutes and try again.';
    } else {
      $username = trim((string) ($_POST['username'] ?? ''));
      $password = (string) ($_POST['password'] ?? '');
      $query = $pdo->prepare('SELECT id, username, password_hash FROM admin_users WHERE username = :username LIMIT 1');
      $query->execute(['username' => $username]);
      $user = $query->fetch();
      if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int) $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['login_failures'] = 0;
        unset($_SESSION['login_lock_until']);
        header('Location: index.php');
        exit;
      }
      $_SESSION['login_failures'] = (int) ($_SESSION['login_failures'] ?? 0) + 1;
      if ($_SESSION['login_failures'] >= 5) {
        $_SESSION['login_lock_until'] = time() + 900;
        $_SESSION['login_failures'] = 0;
      }
      $error = 'The username or password was not recognized.';
    }
  }

  if (!empty($_SESSION['admin_id'])) {
    require_admin();
    $posts = $pdo->query('SELECT p.id, p.slug, p.title, p.category, p.updated_at, (SELECT image_path FROM post_images i WHERE i.post_id = p.id ORDER BY i.sort_order, i.id LIMIT 1) AS cover_image FROM posts p ORDER BY p.updated_at DESC, p.id DESC')->fetchAll();
  } else {
    $adminExists = (int) $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn() > 0;
  }
} catch (Throwable $error) {
  render_db_error($error);
}

$pageTitle = 'Post Admin — Entebbe Birding Club';
$isPostsPage = true;
include __DIR__ . '/../header.php';
?>
<main>
  <section class="section section--parchment admin-section">
    <div class="container admin-wrap">
      <?php if (empty($_SESSION['admin_id'])): ?>
        <div class="admin-heading"><span class="eyebrow">Club publishing</span><h1>Post admin</h1><p>Sign in to manage stories and photos.</p></div>
        <?php if (empty($adminExists)): ?><p class="admin-notice">No admin account exists yet. Complete the one-time setup at <a href="setup.php">admin/setup.php</a>.</p><?php endif; ?>
        <form class="admin-form admin-login" method="post" action="index.php">
          <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
          <?php if ($error): ?><p class="admin-error" role="alert"><?= e($error) ?></p><?php endif; ?>
          <label>Username<input name="username" autocomplete="username" required maxlength="80"></label>
          <label>Password<input type="password" name="password" autocomplete="current-password" required></label>
          <button class="btn btn--solid" type="submit">Sign in</button>
        </form>
      <?php else: ?>
        <div class="admin-heading admin-heading-row"><div><span class="eyebrow">Club publishing</span><h1>Manage posts</h1><p>Signed in as <?= e($_SESSION['admin_username'] ?? 'admin') ?></p></div><form method="post" action="logout.php"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><button class="btn btn--outline on-light" type="submit">Sign out</button></form></div>
        <div class="admin-actions"><a class="btn btn--solid" href="edit.php">Create a post</a><a class="btn btn--outline on-light" href="add_admin.php">Add an admin</a><a class="admin-public-link" href="../view_posts.php">View public posts →</a></div>
        <?php if (isset($_GET['saved'])): ?><p class="admin-success" role="status">Post saved.</p><?php elseif (isset($_GET['deleted'])): ?><p class="admin-success" role="status">Post deleted.</p><?php endif; ?>
        <?php if (!$posts): ?><p class="admin-notice">There are no posts yet. Create the first one above.</p><?php else: ?>
          <div class="admin-post-list">
            <?php foreach ($posts as $post): ?>
              <article class="admin-post-row">
                <?php if ($post['cover_image']): ?><img src="../<?= e($post['cover_image']) ?>" alt="" loading="lazy"><?php endif; ?>
                <div class="admin-post-info"><h2><?= e($post['title']) ?></h2><p><?= e($post['category']) ?></p><a href="../post.php?slug=<?= rawurlencode($post['slug']) ?>" target="_blank" rel="noopener">View post ↗</a></div>
                <div class="admin-post-actions"><a class="btn btn--outline on-light" href="edit.php?id=<?= (int) $post['id'] ?>">Edit</a><form method="post" action="delete.php" onsubmit="return confirm('Delete this post and its uploaded photos?')"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int) $post['id'] ?>"><button class="btn btn--danger" type="submit">Delete</button></form></div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php include __DIR__ . '/../footer.php'; ?>
