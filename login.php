<?php
require_once __DIR__ . '/includes/bootstrap.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }
$errors = [];
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $registered = $_SESSION['registered_user'] ?? null;
    if (!verify_csrf()) {
        $errors[] = 'Your form expired. Please try again.';
    } elseif (!$registered || strtolower($email) !== strtolower($registered['email']) || !password_verify($password, $registered['password'])) {
        $errors[] = 'The email or password is incorrect. Create a demo account first if needed.';
    } else {
        $_SESSION['user'] = ['name' => $registered['name'], 'email' => $registered['email'], 'company' => $registered['company']];
        set_flash('Welcome back, ' . $registered['name'] . '!');
        header('Location: dashboard.php'); exit;
    }
}
$page_title = 'Log in';
$page_description = 'Log in to your Nexa Studio account.';
require __DIR__ . '/includes/header.php';
?>
<section class="auth-section"><div class="auth-card"><p class="eyebrow">Welcome back</p><h1>Log in to your account.</h1><p>Access your project space and account information.</p><?php if ($errors): ?><div class="form-errors" role="alert"><?php foreach ($errors as $error): ?><p><?= escape($error) ?></p><?php endforeach; ?></div><?php endif; ?><form class="auth-form" method="post" novalidate><input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>"><label>Email address<input type="email" name="email" value="<?= escape($email) ?>" autocomplete="email" required></label><label>Password<input type="password" name="password" autocomplete="current-password" required></label><button class="button full-button" type="submit">Log in <span>→</span></button></form><p class="auth-switch">New here? <a href="register.php">Create an account</a></p></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
