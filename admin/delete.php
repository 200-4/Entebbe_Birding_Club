<?php
require_once __DIR__ . '/../private/bootstrap.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
verify_csrf();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) { header('Location: index.php'); exit; }
try {
  $pdo = db();
  $query = $pdo->prepare('SELECT image_path FROM post_images WHERE post_id = :id');
  $query->execute(['id' => $id]);
  $paths = $query->fetchAll(PDO::FETCH_COLUMN);
  $delete = $pdo->prepare('DELETE FROM posts WHERE id = :id');
  $delete->execute(['id' => $id]);
  foreach ($paths as $path) if (is_managed_post_image($path)) @unlink(__DIR__ . '/../' . $path);
  header('Location: index.php?deleted=1');
  exit;
} catch (Throwable $error) {
  error_log('EBC post delete error: ' . $error->getMessage());
  http_response_code(500);
  exit('The post could not be deleted. Please return to the admin page and try again.');
}
