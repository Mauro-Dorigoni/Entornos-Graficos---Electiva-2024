<?php
require_once __DIR__ . "/../logic/promotion.controller.php";
require_once __DIR__ . "/../logic/shop.controller.php";

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

        $isOwner = false;
        //El  Owner y Admin (por ser super usuario) tienen permitido entrar
        if (!isset($_SESSION['user']) || $_SESSION['userType'] == UserType_enum::User) {
            $_SESSION['error_message'] = "No tienes permisos para acceder a esta pagina";
            header("Location: " . frontendURL . "/loginPage.php");
            exit;
        }

        $code = $_POST['uniqueCode'];


        if (isset($_SESSION['user']) && ($_SESSION['user']->isOwner() == true || $_SESSION['userType'] == UserType_enum::Owner)) {
            $user = $_SESSION['user'];
            $isOwner = true;
            $shopOfUser = ShopController::getOneByOwner($user);
            $promotionShop = PromotionContoller::getShopByPromotionCode($code);
            //if ($user->getId() !== $promotionShop->getOwner()->getId()) {
            if ($shopOfUser->getId() !== $promotionShop->getId()) {
                throw new Exception("Usted no es dueño del local para el cual intenta canjear una promoción.");
            }
        }


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