<?php
require_once __DIR__ . "/../logic/news.controller.php";
require_once __DIR__ . "/../shared/frontendRoutes.dev.php";
require_once __DIR__ . "/../shared/userType.enum.php";
require_once __DIR__ . "/../structs/user.class.php"; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    if (!isset($_SESSION['user']) || $_SESSION['user']->isAdmin() == false || $_SESSION['userType'] != UserType_enum::Admin) {
        $_SESSION['error_message'] = "No tienes permisos para realizar esta acción";
        header("Location: " . frontendURL . "/loginPage.php");
        exit;
    }

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($id > 0) {
        NewsController::delete($id); 
        $_SESSION['success_message'] = "La novedad " . $id . " ha sido eliminada correctamente.";
    } else {
        throw new Exception("ID de novedad no válido.");
    }

} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
}
header("Location: " . frontendURL . "/newsPage.php");
exit;