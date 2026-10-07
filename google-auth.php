<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

if (!google_oauth_is_configured()) {
    set_flash('Google sign-in is not configured yet. Add the Google OAuth environment variables described in README.md.', 'error');
    header('Location: login.php');
    exit;
}

$config = google_oauth_config();
$_SESSION['google_oauth_state'] = bin2hex(random_bytes(32));

$parameters = [
    'client_id' => $config['client_id'],
    'redirect_uri' => $config['redirect_uri'],
    'response_type' => 'code',
    'scope' => 'openid email profile',
    'state' => $_SESSION['google_oauth_state'],
    'prompt' => 'select_account',
];

header('Location: https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($parameters, '', '&', PHP_QUERY_RFC3986));
exit;
