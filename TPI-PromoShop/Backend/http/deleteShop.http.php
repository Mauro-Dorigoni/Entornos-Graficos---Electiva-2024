<?php
require_once __DIR__ . "/../structs/shop.class.php";
require_once __DIR__ . "/../logic/shop.controller.php";
require_once __DIR__ . "/../shared/frontendRoutes.dev.php";
require_once __DIR__ . "/../shared/userType.enum.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $isAdmin = false;
        $isOwner = false;
        //El administrador  tienen permitido eliminar un local
        if(!isset($_SESSION['user']) || $_SESSION['userType'] == UserType_enum::User) {
            $_SESSION['error_message'] = "No tienes permisos para acceder a esta pagina";
            header("Location: " . frontendURL . "/loginPage.php");
            exit;
            
        }

        if (isset($_SESSION['user']) && ($_SESSION['user']->isAdmin() == false || $_SESSION['userType'] != UserType_enum::Admin)) {
            $_SESSION['error_message'] = "No tienes permisos para acceder a esta pagina";
            header("Location: " . frontendURL . "/loginPage.php");
            exit;
        } 


        //Podemos verificar que exista o no hacerlo....
        $idShop = $_POST['idShop'];
        $shop = new Shop();
        $shop->setId($idShop);
        $shop = ShopController::getOne($shop);

        if (is_null($shop)) {
            throw new Exception("El local ingresado no existe");
        }

        ShopController::deleteShop($shop);

        $_SESSION['success_message'] = "Local eliminado exitosamente.";
        header("Location: " . frontendURL . "/shopsCardsPage.php");
        exit;


    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error al eliminar el local" . $e->getMessage();
        header("Location: " . frontendURL . "/shopsCardsPage.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Metodo de solicitud no permitido";
    header("Location: " . frontendURL . "/shopsCardsPage.php");
}
?>