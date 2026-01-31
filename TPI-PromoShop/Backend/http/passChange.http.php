<?php
require_once __DIR__."/../structs/user.class.php";
require_once __DIR__."/../logic/user.controller.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/sendEmail.php";
require_once __DIR__."/../shared/backendRoutes.dev.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"];
    $newPass = $_POST["pass"];
    $newPass2 = $_POST["pass2"];
    if($newPass!=$newPass2){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['error_message'] = "Las contraseñas no coinciden.";
        header("Location: ".frontendURL."/registerPage.php");
        exit;
    }
    try {
        $user = new User();
        $user->setEmailToken($token);
        $existingUser = UserController::getByEmailToken($user);
        if(!$existingUser){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = "No existe el usuario";
            header("Location: ".frontendURL."/loginPage.php"); 
            exit;
        }else{
            $existingUser->setPass(password_hash($newPass, PASSWORD_DEFAULT));
            UserController::update($existingUser);
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            unset($_SESSION['token']);
            unset($_SESSION['action']);
            $_SESSION['success_message'] = "Se ha cambiado la contraeña. Le pediremos que se loguee nuevamente";
            header("Location: ".frontendURL."/loginPage.php"); 
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

}else {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['error_message'] = "Método de solicitud no permitido.";
    header("Location: ".frontendURL."/loginPage.php"); 
    exit;
}
?>