<?php
require_once __DIR__."/../structs/shop.class.php"; 
require_once __DIR__."/../logic/shop.controller.php";
require_once __DIR__."/../logic/user.controller.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/userType.enum.php";

if(session_status() == PHP_SESSION_NONE){
    session_start();
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
        if(!isset($_SESSION['user']) || $_SESSION['user'] -> isAdmin() == false || $_SESSION['userType'] != UserType_enum::Admin){
            $_SESSION['error_message'] = "No tienes permisos para acceder a esta pagina";
            header("Location: ".frontendURL."/loginPage.php");
            exit;
        }
        $emailOwner = $_POST['emailOwner']; 
        $passwordOwner = $_POST['passwordOwner'];
        $owner = new User();
        $token = bin2hex(random_bytes(16)); 
        $owner->setEmailToken($token);
        $owner->setEmail($emailOwner);
        $owner->setPass(password_hash($passwordOwner, PASSWORD_DEFAULT));
        $userFound = UserController::getByMail($owner);
        if($userFound != null){
            $_SESSION['error_message'] = "El usuario ya se encuentra registrado";
            header("Location: ".frontendURL."/newLocalPage.php");
            exit;
        }
        UserController::registerOwner($owner);
        $owner = UserController::getByMail($owner);
    
        $nombreLocal = $_POST['local'];
        $ubiLocal = $_POST['ubiLocal'];
        $idShopType = (int)$_POST['shopType'];
        $shopType = new ShopType();
        $shopType->setId($idShopType);
        $local = new Shop();
        $local->setName($nombreLocal);
        $local->setLocation($ubiLocal);
        $local->setOwner($owner);
        $local->setShopType($shopType);
        ShopController ::registerShop($local);
        $_SESSION['success_message'] = "Local registrado exitosamente";
        header("Location: ".frontendURL."/newLocalPage.php"); 
        exit;
    }
    catch (Exception $e){
        $_SESSION['error_message'] = "Error al registrar el local".$e -> getMessage();
        header("Location: ".frontendURL."/newLocalPage.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Metodo de solicitud no permitido";
    header("Location: ".frontendURL."/newLocalPage.php");
}

?>