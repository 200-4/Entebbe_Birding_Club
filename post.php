<?php
require_once __DIR__ . '/private/bootstrap.php';
$slug = isset($_GET['slug']) && is_string($_GET['slug']) ? $_GET['slug'] : '';
try {
  $statement = db()->prepare('SELECT * FROM posts WHERE slug = :slug LIMIT 1');
  $statement->execute(['slug' => $slug]);
  $post = $statement->fetch();
  if ($post) {
    $imageQuery = db()->prepare('SELECT image_path, alt_text FROM post_images WHERE post_id = :post_id ORDER BY sort_order, id LIMIT 3');
    $imageQuery->execute(['post_id' => $post['id']]);
    $post['images'] = $imageQuery->fetchAll();
  }
} catch (Throwable $error) {
  render_db_error($error);
}

$isPostsPage = true;
if (!$post) {
  http_response_code(404);
  $pageTitle = 'Story Not Found — Entebbe Birding Club';
  $pageDescription = 'The requested Entebbe Birding Club story could not be found.';
  include 'header.php';
  ?>
  <main><section class="section section--parchment"><div class="container story-not-found">
    <span class="eyebrow">Field notes</span><h1>We couldn't find that story</h1>
    <p>The post may have moved. Browse the latest club stories and field notes.</p>
    <a class="btn btn--solid" href="view_posts.php">Browse all posts</a>
  </div></section></main>
  <?php include 'footer.php'; exit;
}

$pageTitle = $post['title'] . ' — Entebbe Birding Club';
$pageDescription = $post['summary'];
include 'header.php';
$paragraphs = preg_split('/\R\s*\R/', trim($post['body'])) ?: [];
?>

<main>
  <article class="section section--parchment story-section">
    <div class="container">
      <header class="story-header reveal">
        <a class="story-back" href="view_posts.php">← All stories</a>
        <span class="eyebrow"><?= e($post['category']) ?></span>
        <h1><?= e($post['title']) ?></h1>
        <p class="story-summary"><?= e($post['summary']) ?></p>
      </header>

      <?php if (!empty($post['images'])): ?>
        <figure class="story-feature-image reveal">
          <img src="<?= e($post['images'][0]['image_path']) ?>" alt="<?= e($post['images'][0]['alt_text'] ?: $post['title']) ?>">
        </figure>
      <?php endif; ?>

      <div class="story-content reveal">
        <?php foreach ($paragraphs as $paragraph): ?>
          <p><?= nl2br(e($paragraph)) ?></p>
        <?php endforeach; ?>
      </div>

      <?php if (!empty($post['images'])): ?>
        <section class="story-gallery-section" aria-labelledby="story-gallery-title">
          <div class="story-gallery-heading"><span class="eyebrow">In pictures</span><h2 id="story-gallery-title">More moments from the outing</h2></div>
          <div class="story-photo-grid">
            <?php foreach ($post['images'] as $index => $image): ?>
              <figure class="story-photo"><img src="<?= e($image['image_path']) ?>" alt="<?= e($image['alt_text'] ?: ($post['title'] . ' — photo ' . ($index + 1))) ?>" loading="lazy"></figure>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endif; ?>

      <div class="story-share reveal">
        <p>Enjoyed this story? Share it with your birding community.</p>
        <div class="story-share-links">
          <a class="btn btn--outline on-light share-link" data-share="facebook" href="https://www.facebook.com/sharer/sharer.php" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i> Share on Facebook</a>
          <a class="btn btn--outline on-light share-link" data-share="x" href="https://twitter.com/intent/tweet" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i> Share on X</a>
        </div>
      </div>
    </div>
  </article>
</main>

<?php include 'footer.php'; ?>
