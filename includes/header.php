<?php
/** @var string $page_title */
/** @var string $page_description */
require_once __DIR__ . '/bootstrap.php';
$flash = get_flash();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= escape($page_description ?? 'A modern PHP business website template.') ?>">
    <title><?= escape($page_title ?? 'Nexa Studio') ?> | Nexa Studio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="index.php" aria-label="Nexa Studio home"><span class="brand-mark">N</span><span>Nexa<span>Studio</span></span></a>
        <nav class="main-nav" aria-label="Primary navigation">
            <a class="<?= is_current_page('index.php') ? 'active' : '' ?>" href="index.php">Home</a>
            <a class="<?= is_current_page('about.php') ? 'active' : '' ?>" href="about.php">About</a>
            <a class="<?= is_current_page('services.php') ? 'active' : '' ?>" href="services.php">Services</a>
            <a class="<?= is_current_page('blog.php') ? 'active' : '' ?>" href="blog.php">Blog</a>
            <a class="<?= is_current_page('contact.php') ? 'active' : '' ?>" href="contact.php">Contact</a>
        </nav>
        <div class="nav-actions">
            <?php if (is_logged_in()): ?>
                <a class="text-link" href="dashboard.php">Dashboard</a><a class="button button-small" href="logout.php">Log out</a>
            <?php else: ?>
                <a class="text-link" href="login.php">Log in</a><a class="button button-small" href="register.php">Get started</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<main>
    <?php if ($flash): ?>
        <div class="container flash-wrap"><div class="flash flash-<?= escape($flash['type']) ?>" role="status"><?= escape($flash['message']) ?></div></div>
    <?php endif; ?>
