<?php 
require_once __DIR__."/../structs/user.class.php";
require_once __DIR__."/../logic/user.controller.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/userType.enum.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Me traigo los campos del formulario de Login
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $user = new User();
    $user->setEmail($email);
    $user->setPass($pass);
    try {
        //Le pido al controlador que encuentre el usuario
        $user = UserController::getByMail($user);
        if($user === null  || !password_verify($pass, $user->getPass())){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = "Usuario o contraseña incorrectos";
            header("Location: ".frontendURL."/loginPage.php");
            exit;
        }
        //Inicializo la variable se sesion para autenticacion
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        //Le encajo el usuario a la variable de sesion
        $_SESSION['user'] = $user;
        //redirijo a la pagina apropiada por el tipo de usuario, y establezco el tipo de usuario en la variable de sesion para corroborar en el front
        if($user->isAdmin()){
            $_SESSION["userType"] = UserType_enum::Admin;
            header("Location: ".frontendURL."/landingPageAdmin.php");
            exit;
        }
        if($user->isOwner()){
            $_SESSION["userType"] = UserType_enum::Owner;
            header("Location: ".frontendURL."/landingPageOwner.php"); 
            exit;
        }
        $_SESSION["userType"] = UserType_enum::User;
        header("Location: ".frontendURL."/landingPage.php"); 
        exit;
    } catch (Exception $e) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['error_message'] = $e->getMessage();
    }

} else {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['error_message'] = "Metodo de solicitud no permitido";
}

?>