<?php
declare(strict_types=1);

// Lets PHP's built-in server display the custom 404 page for unknown paths.
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$file = __DIR__ . DIRECTORY_SEPARATOR . ltrim($path, '/');

if ($path !== '/' && is_file($file)) {
    return false;
}

if ($path === '/') {
    require __DIR__ . '/index.php';
    return true;
}

require __DIR__ . '/404.php';
return true;
