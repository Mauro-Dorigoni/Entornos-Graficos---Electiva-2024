<?php
require_once __DIR__."/../structs/promotion.class.php";
require_once __DIR__."/../logic/promotion.controller.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/userType.enum.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['user']->isAdmin() === false || $_SESSION['userType'] !== UserType_enum::Admin) {
            throw new Exception("No tienes permisos para realizar esta acción.");
        }
        if (!isset($_POST['promotion_id']) || (int)$_POST['promotion_id'] <= 0) {
            throw new Exception("ID de promoción inválido.");
        }
        $promo = new Promotion();
        $promo->setId((int)$_POST['promotion_id']);
        $promo = PromotionContoller::getOne($promo);
        if ($promo === null) {
            throw new Exception("La promoción no existe o fue eliminada.");
        }
        $admin = $_SESSION['user'];
        $promo->setAdmin($admin);
        PromotionContoller::approvePromotion($promo);
        $_SESSION['success_message'] = "Promoción aceptada correctamente.";
        header("Location: " . frontendURL . "/promoManagementPage.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error al aceptar la promoción: " . $e->getMessage();
        header("Location: " . frontendURL . "/promoManagementPage.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Método de solicitud no permitido.";
    header("Location: " . frontendURL . "/promoManagementPage.php");
    exit;
}
