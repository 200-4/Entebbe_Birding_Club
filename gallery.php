<?php
$pageTitle = 'Gallery — Entebbe Birding Club';
$pageDescription = 'Explore photos from Entebbe Birding Club activities, birding excursions and nature outings across Uganda.';
include 'header.php';

$activityImages = glob(__DIR__ . '/images/entebbe_birding*.jpg');
if ($activityImages === false) {
  throw new RuntimeException('Unable to load Entebbe Birding Club activity photos.');
}
natsort($activityImages);
$activityImages = array_values($activityImages);
?>

<main>
  <section class="section section--parchment gallery-section">
    <div class="container">
      <div class="section-head gallery-head reveal">
        <span class="eyebrow">Moments in the field</span>
        <h1>Entebbe Birding Club Gallery</h1>
        <p>A look back at our birding excursions, learning experiences and time spent exploring nature together.</p>
      </div>

      <div class="gallery-grid" aria-label="Entebbe Birding Club activity photos">
        <?php foreach ($activityImages as $index => $image): ?>
          <?php $imagePath = 'images/' . basename($image); ?>
          <figure class="gallery-item reveal">
            <img
              src="<?= htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8') ?>"
              alt="Entebbe Birding Club activity <?= $index + 1 ?>"
              loading="lazy"
            >
            <figcaption>Club activity <?= $index + 1 ?></figcaption>
          </figure>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</main>

<?php include 'footer.php'; ?>
