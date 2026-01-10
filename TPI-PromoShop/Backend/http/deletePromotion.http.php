<?php
require_once __DIR__ . "/../structs/promotion.class.php";
require_once __DIR__ . "/../logic/promotion.controller.php";
require_once __DIR__ . "/../shared/frontendRoutes.dev.php";
require_once __DIR__ . "/../shared/userType.enum.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['user']->isOwner() === false || $_SESSION['userType'] !== UserType_enum::Owner
        ) {
            throw new Exception("No tienes permisos para realizar esta acción.");
        }
        if (!isset($_POST['promotion_id']) || (int)$_POST['promotion_id'] <= 0
        ) {
            throw new Exception("ID de promoción inválido.");
        }
        $promo = new Promotion();
        $promo->setId((int)$_POST['promotion_id']);
        PromotionContoller::deletePromotion($promo);
        $_SESSION['success_message'] = "Promoción eliminada correctamente.";
        header("Location: " . frontendURL . "/allShopPromotionsPage.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error al eliminar la promoción: " . $e->getMessage();
        header("Location: " . frontendURL . "/allShopPromotionsPage.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Método de solicitud no permitido.";
    header("Location: " . frontendURL . "/allShopPromotionsPage.php");
    exit;
}
