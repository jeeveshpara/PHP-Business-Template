<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: blog.php');
    exit;
}

$email = trim((string) ($_POST['email'] ?? ''));

if (!verify_csrf() || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    set_flash('Please enter a valid email address to subscribe.', 'error');
    header('Location: blog.php');
    exit;
}

// Demo-only: connect this endpoint to your preferred email service in production.
set_flash('You’re on the list. We’ll only write when we have something worth sharing.');
header('Location: blog.php');
exit;
