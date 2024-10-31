<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (logout.php)
*/

// Start the session if it hasn't already been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set a cookie for the logout time
$logout_time = date('Y-m-d H:i:s');
setcookie('last_logout_time', $logout_time, time() + (86400 * 30), "/"); // 30 days

// Unset all session variables
$_SESSION = array();

// Destroy session cookie if it's set
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to the login page in the `public` folder
header("Location: ../public/login.php");
exit();
