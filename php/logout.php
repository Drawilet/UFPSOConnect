<?php
require 'config.php';
session_start(); // Start the session before manipulating it

// Clear all session variables
$_SESSION = [];

// Destroy the session data on the server
session_destroy();

// Optionally, you can clear the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to the login page
header('Location: login.php');
exit; // It's good practice to call exit after a header redirect to make sure the script stops executing.
