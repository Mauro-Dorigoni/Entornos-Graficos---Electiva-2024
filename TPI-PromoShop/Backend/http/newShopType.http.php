<?php
require_once __DIR__."/../structs/shopType.class.php"; 
require_once __DIR__."/../logic/shopType.controller.php";
require_once __DIR__."/../shared/userType.enum.php";
require_once __DIR__."/../structs/user.class.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";


if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    try {
        if(!isset($_SESSION['user']) || $_SESSION['user'] -> isAdmin() == false || $_SESSION['userType'] != UserType_enum::Admin){
            $_SESSION['error_message'] = "No tienes permisos para acceder a esta pagina";
            header("Location: ".frontendURL."/loginPage.php");
            exit;
        }
        $type = $_POST["tipoLocal"];
        $descripcion = $_POST["descTipoLocal"];
        $shopType = new ShopType();
        $shopType->setType($type);
        $shopType->setDescription($descripcion);    
        ShopTypeController::registerShopType($shopType);
        $_SESSION['success_message'] = "Tipo de Local registrado exitosamente";
        header("Location: ".frontendURL."/newShopTypePage.php"); 
        exit;
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error al registrar el local".$e -> getMessage();
        header("Location: ".frontendURL."/newShopTypePage.php");
        exit;
    }

}else{
    $_SESSION['error_message'] = "Metodo de solicitud no permitido";
    header("Location: ".frontendURL."/newShopTypePage.php");
    exit;
}
?>