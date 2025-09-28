<?php
// ---------------------- Session Settings ----------------------
session_set_cookie_params([
    'lifetime' => 0,   // expire on browser close
    'path' => '/',
    'domain' => '',    // set your domain if needed
    'secure' => false, // true if using HTTPS
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

// ---------------------- Cache Control ----------------------
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// ---------------------- Login Check ----------------------
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
