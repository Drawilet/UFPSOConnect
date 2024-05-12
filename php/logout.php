<?php
require 'config.php';
session_start(); // START THE SESSION BEFORE MANIPULATING IT 

// CLEAN ALL SESSION VARIABLES
$_SESSION = [];

// DESTROY THE SESSION DATA ON THE SERVER
session_destroy();

// CLEAR THE SESSION COOKIES
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// REDIRECT TO THE LOGIN PAGE
header('Location: login.php');
exit;