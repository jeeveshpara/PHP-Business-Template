<?php
require_once __DIR__ . '/includes/bootstrap.php';
unset($_SESSION['user']);
set_flash('You have been logged out.');
header('Location: index.php');
exit;
