<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function escape(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function current_page(): string
{
    return basename(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: 'index.php');
}

function is_current_page(string $page): bool
{
    return current_page() === $page;
}

function is_logged_in(): bool
{
    return isset($_SESSION['user']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        set_flash('Please log in to access that page.', 'error');
        header('Location: login.php');
        exit;
    }
}

function set_flash(string $message, string $type = 'success'): void
{
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function get_flash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf(): bool
{
    $token = $_POST['csrf_token'] ?? '';
    return is_string($token) && isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
