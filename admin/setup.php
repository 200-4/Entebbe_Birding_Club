<?php
require_once __DIR__ . '/../private/bootstrap.php';
try {
  $pdo = db();
  start_admin_session();
  $exists = (int) $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn() > 0;
  $error = '';
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$exists) {
    verify_csrf();
    $config = app_config();
    $setupKey = (string) ($config['setup_key'] ?? '');
    $providedKey = (string) ($_POST['setup_key'] ?? '');
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if (strlen($setupKey) < 32 || strncmp($setupKey, 'REPLACE_WITH_', 13) === 0 || !hash_equals($setupKey, $providedKey)) {
      $error = 'The setup key is invalid or has not been configured.';
    } elseif (!preg_match('/^[A-Za-z0-9_.-]{3,80}$/', $username)) {
      $error = 'Use 3–80 letters, numbers, dots, underscores or hyphens for the username.';
    } elseif (strlen($password) < 12) {
      $error = 'Choose a password with at least 12 characters.';
    } else {
      $pdo->beginTransaction();
      $pdo->query("SELECT pg_advisory_xact_lock(804213771)");
      $exists = (int) $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn() > 0;
      if ($exists) {
        $pdo->rollBack();
        $error = 'Admin setup has already been completed.';
      } else {
        $insert = $pdo->prepare('INSERT INTO admin_users (username, password_hash) VALUES (:username, :hash) RETURNING id');
        $insert->execute(['username' => $username, 'hash' => password_hash($password, PASSWORD_DEFAULT)]);
        $adminId = (int) $insert->fetchColumn();
        $pdo->commit();
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $adminId;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit;
      }
    }
  }
} catch (Throwable $error) {
  render_db_error($error);
}
$pageTitle = 'Set Up Post Admin — Entebbe Birding Club';
$isPostsPage = true;
include __DIR__ . '/../header.php';
?>
<main><section class="section section--parchment admin-section"><div class="container admin-wrap">
  <div class="admin-heading"><span class="eyebrow">One-time setup</span><h1>Create the first admin</h1><p>After this account is created, this setup form locks automatically.</p></div>
  <?php if ($exists): ?>
    <p class="admin-notice">Admin setup is already complete. <a href="index.php">Go to sign in</a>.</p>
  <?php else: ?>
    <form class="admin-form admin-login" method="post" action="setup.php">
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
      <?php if ($error): ?><p class="admin-error" role="alert"><?= e($error) ?></p><?php endif; ?>
      <label>One-time setup key<input type="password" name="setup_key" autocomplete="off" required></label>
      <label>Admin username<input name="username" autocomplete="username" required maxlength="80"></label>
      <label>Password (at least 12 characters)<input type="password" name="password" autocomplete="new-password" minlength="12" required></label>
      <button class="btn btn--solid" type="submit">Create admin account</button>
    </form>
  <?php endif; ?>
</div></section></main>
<?php include __DIR__ . '/../footer.php'; ?>
