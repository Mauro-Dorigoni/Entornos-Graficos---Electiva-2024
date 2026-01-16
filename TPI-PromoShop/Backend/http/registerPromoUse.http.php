<?php
require_once __DIR__ . "/../logic/promotion.controller.php";
require_once __DIR__ . "/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/userType.enum.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (!isset($_POST['uniqueCode']) || empty($_POST['uniqueCode'])) {
            throw new Exception("Debe ingresar el código dictado por el cliente.");
        }

        $code = $_POST['uniqueCode'];

        PromotionContoller::usePromotionCode($code);

        $_SESSION['success_message'] = "Promoción aplicada correctamente.";
        header("Location: " . frontendURL . "/promotionValidationPage.php");
        exit;

    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: " . frontendURL . "/promotionValidationPage.php");
        exit;
    }
}