<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Optional: delete the session cookie (for better cleanup)
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Redirect to login page (or change this to index.php if preferred)
header("Location: login.php");
exit();
?>
