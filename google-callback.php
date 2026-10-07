<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

if (!google_oauth_is_configured()) {
    set_flash('Google sign-in is not configured yet.', 'error');
    header('Location: login.php');
    exit;
}

$state = $_GET['state'] ?? '';
$expectedState = $_SESSION['google_oauth_state'] ?? '';
$error = $_GET['error'] ?? '';
$code = $_GET['code'] ?? '';

if (!is_string($state) || !is_string($expectedState) || $expectedState === '' || !hash_equals($expectedState, $state)) {
    unset($_SESSION['google_oauth_state']);
    set_flash('Google sign-in could not be verified. Please try again.', 'error');
    header('Location: login.php');
    exit;
}

unset($_SESSION['google_oauth_state']);

if ($error !== '' || !is_string($code) || $code === '') {
    set_flash('Google sign-in was cancelled or could not be completed.', 'error');
    header('Location: login.php');
    exit;
}

if (!function_exists('curl_init')) {
    set_flash('Google sign-in needs the PHP cURL extension to be enabled.', 'error');
    header('Location: login.php');
    exit;
}

$config = google_oauth_config();
$tokenRequest = curl_init('https://oauth2.googleapis.com/token');
curl_setopt_array($tokenRequest, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'code' => $code,
        'client_id' => $config['client_id'],
        'client_secret' => $config['client_secret'],
        'redirect_uri' => $config['redirect_uri'],
        'grant_type' => 'authorization_code',
    ], '', '&', PHP_QUERY_RFC3986),
    CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
]);
$tokenResponse = curl_exec($tokenRequest);
$tokenStatus = (int) curl_getinfo($tokenRequest, CURLINFO_HTTP_CODE);
curl_close($tokenRequest);
$token = is_string($tokenResponse) ? json_decode($tokenResponse, true) : null;

if ($tokenStatus !== 200 || !is_array($token) || empty($token['access_token'])) {
    set_flash('Google sign-in could not exchange the authorisation code. Please try again.', 'error');
    header('Location: login.php');
    exit;
}

$profileRequest = curl_init('https://openidconnect.googleapis.com/v1/userinfo');
curl_setopt_array($profileRequest, [
    CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token['access_token']],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
]);
$profileResponse = curl_exec($profileRequest);
$profileStatus = (int) curl_getinfo($profileRequest, CURLINFO_HTTP_CODE);
curl_close($profileRequest);
$profile = is_string($profileResponse) ? json_decode($profileResponse, true) : null;

$emailVerified = is_array($profile) && filter_var($profile['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN);
if ($profileStatus !== 200 || !is_array($profile) || empty($profile['sub']) || empty($profile['email']) || !$emailVerified) {
    set_flash('Google did not return a verified account email. Please use email sign-in instead.', 'error');
    header('Location: login.php');
    exit;
}

$name = trim((string) ($profile['name'] ?? ''));
$_SESSION['user'] = [
    'name' => $name !== '' ? $name : (string) $profile['email'],
    'email' => (string) $profile['email'],
    'company' => '',
    'google_sub' => (string) $profile['sub'],
];

set_flash('Welcome to Nexa Studio, ' . $_SESSION['user']['name'] . '!');
header('Location: dashboard.php');
exit;
