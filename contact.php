<?php
require_once __DIR__ . '/includes/bootstrap.php';

$errors = [];
$values = ['name' => '', 'email' => '', 'company' => '', 'message' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $key => $_) {
        $values[$key] = trim((string) ($_POST[$key] ?? ''));
    }
    if (!verify_csrf()) $errors[] = 'Your form expired. Please try again.';
    if ($values['name'] === '') $errors[] = 'Please enter your name.';
    if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if ($values['message'] === '') $errors[] = 'Please tell us a little about your project.';
    if (!$errors) {
        set_flash('Thanks, ' . $values['name'] . '! Your message has been received.');
        header('Location: contact.php');
        exit;
    }
}
$page_title = 'Contact';
$page_description = 'Get in touch with Nexa Studio.';
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero compact"><div class="container narrow"><p class="eyebrow">Get in touch</p><h1>Got something <em>good</em> in mind?</h1><p class="lead">Tell us about the challenge. We will get back to you within two working days.</p></div></section>
<section class="section"><div class="container contact-layout"><aside><h2>Let’s start a conversation.</h2><p>Whether the idea is fully formed or just taking shape, we would love to hear where you are headed.</p><div class="contact-detail"><span>Email us</span><a href="mailto:hello@nexastudio.test">hello@nexastudio.test</a></div><div class="contact-detail"><span>Based in</span><p>Working globally, from everywhere</p></div></aside><form class="contact-form" method="post" novalidate>
<?php if ($errors): ?><div class="form-errors" role="alert"><?php foreach ($errors as $error): ?><p><?= escape($error) ?></p><?php endforeach; ?></div><?php endif; ?>
<input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>"><label>Your name<input type="text" name="name" value="<?= escape($values['name']) ?>" autocomplete="name" required></label><label>Email address<input type="email" name="email" value="<?= escape($values['email']) ?>" autocomplete="email" required></label><label>Company <span>(optional)</span><input type="text" name="company" value="<?= escape($values['company']) ?>" autocomplete="organization"></label><label>How can we help?<textarea name="message" rows="5" required><?= escape($values['message']) ?></textarea></label><button class="button" type="submit">Send message <span>→</span></button></form></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
