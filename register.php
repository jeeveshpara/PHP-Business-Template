<?php
require_once __DIR__ . '/includes/bootstrap.php';
if (is_logged_in()) { header('Location: dashboard.php'); exit; }
$errors = [];
$values = ['name' => '', 'email' => '', 'company' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $key => $_) $values[$key] = trim((string) ($_POST[$key] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if (!verify_csrf()) $errors[] = 'Your form expired. Please try again.';
    if ($values['name'] === '') $errors[] = 'Please enter your name.';
    if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if (strlen($password) < 8) $errors[] = 'Use a password with at least 8 characters.';
    if (!$errors) {
        $_SESSION['registered_user'] = ['name' => $values['name'], 'email' => $values['email'], 'company' => $values['company'], 'password' => password_hash($password, PASSWORD_DEFAULT)];
        $_SESSION['user'] = ['name' => $values['name'], 'email' => $values['email'], 'company' => $values['company']];
        set_flash('Your account is ready. Welcome to Nexa Studio!');
        header('Location: dashboard.php'); exit;
    }
}
$page_title = 'Create account';
$page_description = 'Create a Nexa Studio demo account.';
require __DIR__ . '/includes/header.php';
?>
<section class="auth-section"><div class="auth-card"><p class="eyebrow">Join Nexa Studio</p><h1>Set up your account.</h1><p>Create a demo account to explore the member area.</p><div class="social-auth"><a class="google-button" href="google-auth.php"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M21.8 12.2c0-.7-.1-1.4-.2-2H12v3.8h5.5a4.7 4.7 0 0 1-2 3.1v2.5h3.2c1.9-1.7 3.1-4.3 3.1-7.4Z"/><path fill="#34A853" d="M12 22c2.7 0 5-.9 6.7-2.4l-3.2-2.5c-.9.6-2 1-3.5 1-2.7 0-5-1.8-5.8-4.3H2.9v2.6A10 10 0 0 0 12 22Z"/><path fill="#FBBC05" d="M6.2 13.8a6 6 0 0 1 0-3.7V7.5H2.9a10 10 0 0 0 0 8.9l3.3-2.6Z"/><path fill="#EA4335" d="M12 5.8c1.7 0 3.2.6 4.4 1.8l3.3-3.2C17.8 2.7 15.2 2 12 2A10 10 0 0 0 2.9 7.5l3.3 2.6C7 7.6 9.3 5.8 12 5.8Z"/></svg>Continue with Google</a><div class="auth-divider"><span>or continue with email</span></div></div><?php if ($errors): ?><div class="form-errors" role="alert"><?php foreach ($errors as $error): ?><p><?= escape($error) ?></p><?php endforeach; ?></div><?php endif; ?><form class="auth-form" method="post" novalidate><input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>"><label>Your name<input type="text" name="name" value="<?= escape($values['name']) ?>" autocomplete="name" required></label><label>Email address<input type="email" name="email" value="<?= escape($values['email']) ?>" autocomplete="email" required></label><label>Company <span>(optional)</span><input type="text" name="company" value="<?= escape($values['company']) ?>" autocomplete="organization"></label><label>Password<input type="password" name="password" autocomplete="new-password" minlength="8" required></label><button class="button full-button" type="submit">Create account <span>→</span></button></form><p class="auth-switch">Already have an account? <a href="login.php">Log in</a></p></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
