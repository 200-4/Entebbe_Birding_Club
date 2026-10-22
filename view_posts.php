<?php
require_once __DIR__ . '/private/bootstrap.php';
try {
  $posts = db()->query("SELECT p.*, (SELECT image_path FROM post_images i WHERE i.post_id = p.id ORDER BY i.sort_order, i.id LIMIT 1) AS cover_image FROM posts p ORDER BY p.created_at DESC, p.id DESC")->fetchAll();
} catch (Throwable $error) {
  render_db_error($error);
}
$pageTitle = 'Stories & Field Notes — Entebbe Birding Club';
$pageDescription = 'Stories and field notes from Entebbe Birding Club excursions and learning experiences across Uganda.';
$isPostsPage = true;
include 'header.php';
?>

<main>
  <section class="section section--parchment gallery-section">
    <div class="container">
      <div class="section-head gallery-head reveal">
        <span class="eyebrow">From the field</span>
        <h1>Stories &amp; Field Notes</h1>
        <p>Updates from our birding excursions, learning experiences and the people exploring Uganda's rich natural heritage with us.</p>
      </div>

      <?php if (!$posts): ?>
        <div class="posts-empty"><h2>No stories have been published yet</h2><p>Check back soon for field notes from the club.</p></div>
      <?php else: ?>
        <div class="posts-grid" aria-label="Entebbe Birding Club posts">
          <?php foreach ($posts as $post): ?>
            <article class="post-card reveal">
              <?php if ($post['cover_image']): ?>
                <a class="post-card-image" href="post.php?slug=<?= rawurlencode($post['slug']) ?>" aria-label="Read <?= e($post['title']) ?>">
                  <img src="<?= e($post['cover_image']) ?>" alt="<?= e($post['title']) ?>" loading="lazy">
                </a>
              <?php endif; ?>
              <div class="post-card-body">
                <span class="post-card-meta"><?= e($post['category']) ?></span>
                <h2><?= e($post['title']) ?></h2>
                <p><?= e($post['summary']) ?></p>
                <a class="post-read-more" href="post.php?slug=<?= rawurlencode($post['slug']) ?>">Explore story <span aria-hidden="true">→</span></a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php include 'footer.php'; ?>
