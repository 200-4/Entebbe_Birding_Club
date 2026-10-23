<?php
require_once __DIR__ . '/../private/bootstrap.php';

start_admin_session();
require_admin();

$error = '';
$success = isset($_GET['created']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  verify_csrf();
  $username = trim((string) ($_POST['username'] ?? ''));
  $password = (string) ($_POST['password'] ?? '');

  if (!preg_match('/^[A-Za-z0-9_.-]{3,80}$/', $username)) {
    $error = 'Use 3–80 letters, numbers, dots, underscores or hyphens for the username.';
  } elseif (strlen($password) < 12) {
    $error = 'Choose a password with at least 12 characters.';
  } else {
    try {
      $insert = db()->prepare('INSERT INTO admin_users (username, password_hash) VALUES (:username, :hash)');
      $insert->execute(['username' => $username, 'hash' => password_hash($password, PASSWORD_DEFAULT)]);
      header('Location: add_admin.php?created=1');
      exit;
    } catch (PDOException $exception) {
      if ($exception->getCode() === '23505') {
        $error = 'That username is already in use.';
      } else {
        render_db_error($exception);
      }
    } catch (Throwable $exception) {
      render_db_error($exception);
    }
  }
}

$pageTitle = 'Add an Admin — Entebbe Birding Club';
$isPostsPage = true;
include __DIR__ . '/../header.php';
?>
<main><section class="section section--parchment admin-section"><div class="container admin-wrap">
  <div class="admin-heading"><span class="eyebrow">Club publishing</span><h1>Add an admin</h1><p>Create another account with access to manage posts and photos.</p></div>
  <?php if ($success): ?><p class="admin-success" role="status">Admin account created.</p><?php endif; ?>
  <form class="admin-form admin-login" method="post" action="add_admin.php">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <?php if ($error): ?><p class="admin-error" role="alert"><?= e($error) ?></p><?php endif; ?>
    <label>Admin username<input name="username" autocomplete="username" required maxlength="80" pattern="[A-Za-z0-9_.-]{3,80}"></label>
    <label>Password (at least 12 characters)<input type="password" name="password" autocomplete="new-password" minlength="12" required></label>
    <div class="admin-form-actions"><button class="btn btn--solid" type="submit">Create admin account</button><a class="btn btn--outline on-light" href="index.php">Back to posts</a></div>
  </form>
</div></section></main>
<?php include __DIR__ . '/../footer.php'; ?>
