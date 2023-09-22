<?php
// Set the cookie
session_start(); 
setcookie('remember_me', $_SESSION['user'] . ':' . $_SESSION['token'], time() + (365 * 24 * 60 * 60), '/');
// setcookie('cookie_name', 'cookie_value', time() + 3600, '/');

// Redirect to another page
header('Location: flash.php');
exit;
?>