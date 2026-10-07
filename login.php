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
<section class="auth-section"><div class="auth-card"><p class="eyebrow">Welcome back</p><h1>Log in to your account.</h1><p>Access your project space and account information.</p><div class="social-auth"><a class="google-button" href="google-auth.php"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M21.8 12.2c0-.7-.1-1.4-.2-2H12v3.8h5.5a4.7 4.7 0 0 1-2 3.1v2.5h3.2c1.9-1.7 3.1-4.3 3.1-7.4Z"/><path fill="#34A853" d="M12 22c2.7 0 5-.9 6.7-2.4l-3.2-2.5c-.9.6-2 1-3.5 1-2.7 0-5-1.8-5.8-4.3H2.9v2.6A10 10 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.2 13.8a6 6 0 0 1 0-3.7V7.5H2.9a10 10 0 0 0 0 8.9l3.3-2.6Z"/><path fill="#EA4335" d="M12 5.8c1.7 0 3.2.6 4.4 1.8l3.3-3.2C17.8 2.7 15.2 2 12 2A10 10 0 0 0 2.9 7.5l3.3 2.6C7 7.6 9.3 5.8 12 5.8Z"/></svg>Continue with Google</a><div class="auth-divider"><span>or continue with email</span></div></div><?php if ($errors): ?><div class="form-errors" role="alert"><?php foreach ($errors as $error): ?><p><?= escape($error) ?></p><?php endforeach; ?></div><?php endif; ?><form class="auth-form" method="post" novalidate><input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>"><label>Email address<input type="email" name="email" value="<?= escape($email) ?>" autocomplete="email" required></label><label>Password<input type="password" name="password" autocomplete="current-password" required></label><button class="button full-button" type="submit">Log in <span>→</span></button></form><p class="auth-switch">New here? <a href="register.php">Create an account</a></p></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
