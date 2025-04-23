<?php
require_once "../shared/frontendRoutes.dev.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = array(); // Clear all session variables
session_destroy(); // Destroy the session

header("Location: ".frontendURL."/loginPage.php"); 
exit;

?>