<?php
require_once __DIR__."/../logic/user.controller.php";
require_once __DIR__."/../structs/user.class.php";
require_once __DIR__."/../shared/userType.enum.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";

if(isset($_GET["token"]) && isset($_GET["action"])){
    $token=$_GET["token"];
    $action=$_GET["action"];
    $user=new User();
    $user->setEmailToken($token);
    try {
        $existingUser=UserController::getByEmailToken($user);
        if(!$existingUser || $action!="recovery"){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = "Token inválido o expirado.";
            header("Location: ".frontendURL."/loginPage.php"); 
            exit;
        }else{
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION["token"]=$token;
            $_SESSION["action"]=$action;
            header("Location: ".frontendURL."/passwordChangePage.php"); 
            exit;
            
        }
    } catch (Exception $e) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: ".frontendURL."/loginPage.php"); 
        exit;
    }
}else{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['error_message'] = "Token no proporcionado.";
    header("Location: ".frontendURL."/loginPage.php"); 
    exit;
}
?>