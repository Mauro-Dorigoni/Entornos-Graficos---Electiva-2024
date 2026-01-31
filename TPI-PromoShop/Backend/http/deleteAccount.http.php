<?php
require_once __DIR__ . "/../shared/frontendRoutes.dev.php";
require_once __DIR__ . "/../structs/user.class.php"; 
require_once __DIR__ ."/../logic/user.controller.php";
require_once __DIR__ ."/../shared/userType.enum.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    if (!isset($_SESSION['user'])) {
        $_SESSION['error_message'] = "No tienes permisos para realizar esta acción";
        header("Location: " . frontendURL . "/index.php");
        exit;
        //throw new Exception("No hay usuario");
    }
    $user = $_SESSION['user'];
    if ($user->getID() === null) {
        $_SESSION['error_message'] = "No tienes permisos para realizar esta acción";
        header("Location: " . frontendURL . "/index.php");
        exit;
        //throw new Exception("No hay ID");
    }
    UserController::delete($user);
    $_SESSION = [];
    session_destroy();
    header("Location: " . frontendURL . "/index.php");
    exit;
} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    header("Location: " . frontendURL . "/index.php");
    exit;
    //die("ERROR CRÍTICO: " . $e->getMessage());
}