<?php
require_once "../../Backend/logic/news.controller.php";
require_once "../../Backend/shared/frontendRoutes.dev.php";

if (session_status() == PHP_SESSION_NONE) session_start();

try {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($id > 0) {
        NewsController::delete($id); 
        $_SESSION['success_message'] = "La novedad " . $id . " ha sido eliminada correctamente.";
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
}

header("Location: ../../Frontend/pages/newsPage.php");
exit;