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
<section class="auth-section"><div class="auth-card"><p class="eyebrow">Join Nexa Studio</p><h1>Set up your account.</h1><p>Create a demo account to explore the member area.</p><?php if ($errors): ?><div class="form-errors" role="alert"><?php foreach ($errors as $error): ?><p><?= escape($error) ?></p><?php endforeach; ?></div><?php endif; ?><form class="auth-form" method="post" novalidate><input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>"><label>Your name<input type="text" name="name" value="<?= escape($values['name']) ?>" autocomplete="name" required></label><label>Email address<input type="email" name="email" value="<?= escape($values['email']) ?>" autocomplete="email" required></label><label>Company <span>(optional)</span><input type="text" name="company" value="<?= escape($values['company']) ?>" autocomplete="organization"></label><label>Password<input type="password" name="password" autocomplete="new-password" minlength="8" required></label><button class="button full-button" type="submit">Create account <span>→</span></button></form><p class="auth-switch">Already have an account? <a href="login.php">Log in</a></p></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
