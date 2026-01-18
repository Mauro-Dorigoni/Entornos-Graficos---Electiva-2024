<?php
require_once __DIR__ . "/../logic/promotion.controller.php";
require_once __DIR__ . "/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/userType.enum.php";
require_once __DIR__."/../structs/promoUse.class.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['user']->isAdmin() === true || $_SESSION['user']->isOwner() === true || $_SESSION['userType'] !== UserType_enum::User) {
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
        $user = $_SESSION['user'];
        $use = new PromoUse();
        $use->setPromo($promo);
        $use->setUser($user);
        if (!PromotionContoller::checkSingleUse($use)){
            throw new Exception("Usted ya obtuvo un codigo para esta promocion. Revise la pagina Mis promociones");
        }
        $useCode = substr(uniqid('', true), 0, 8);
        $use->setUniqueCode($useCode);
        PromotionContoller::registerPromoUseCode($use);
        $_SESSION['success_message'] = "Codigo generado correctamente. \n El codigo para utilizar la promocion es: ".$use->getUniqueCode().".\n Podra verlo tambien en la pagina de Mis promociones";
        header("Location: " . frontendURL . "/promoDetailPage.php?id=".$promo->getId());
        exit;
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error al generar un codigo para la promocion: " . $e->getMessage();
        header("Location: " . frontendURL . "/promoDetailPage.php?id=".$promo->getId());
        exit;
    }
} else {
    $_SESSION['error_message'] = "Método de solicitud no permitido.";
    header("Location: " . frontendURL . "/promoDetailPage.php?id=".$promo->getId());
    exit;
}
