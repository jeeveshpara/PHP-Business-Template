<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
$errors = [];
$user = $_SESSION['user'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user['name'] = trim((string) ($_POST['name'] ?? ''));
    $user['company'] = trim((string) ($_POST['company'] ?? ''));
    if (!verify_csrf()) $errors[] = 'Your form expired. Please try again.';
    if ($user['name'] === '') $errors[] = 'Please enter your name.';
    if (!$errors) {
        $_SESSION['user'] = $user;
        if (isset($_SESSION['registered_user'])) {
            $_SESSION['registered_user']['name'] = $user['name'];
            $_SESSION['registered_user']['company'] = $user['company'];
        }
        set_flash('Your profile has been updated.');
        header('Location: profile.php'); exit;
    }
}
$page_title = 'Your profile';
$page_description = 'Update your Nexa Studio profile.';
require __DIR__ . '/includes/header.php';
?>
<section class="member-section"><div class="container profile-layout"><aside class="profile-aside"><span class="profile-avatar"><?= escape(strtoupper(substr($user['name'], 0, 1))) ?></span><h1><?= escape($user['name']) ?></h1><p><?= escape($user['email']) ?></p><a class="text-arrow" href="dashboard.php">← Back to dashboard</a></aside><div class="profile-form-wrap"><p class="eyebrow">Account settings</p><h2>Your profile</h2><p>Update the details we use to keep in touch with you.</p><?php if ($errors): ?><div class="form-errors" role="alert"><?php foreach ($errors as $error): ?><p><?= escape($error) ?></p><?php endforeach; ?></div><?php endif; ?><form class="auth-form" method="post" novalidate><input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>"><label>Your name<input type="text" name="name" value="<?= escape($user['name']) ?>" autocomplete="name" required></label><label>Email address<input type="email" value="<?= escape($user['email']) ?>" disabled></label><label>Company<input type="text" name="company" value="<?= escape($user['company']) ?>" autocomplete="organization"></label><button class="button" type="submit">Save changes <span>→</span></button></form></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
