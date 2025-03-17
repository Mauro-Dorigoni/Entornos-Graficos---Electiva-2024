<?php 
require_once "../structs/user.class.php";
require_once "../logic/user.controller.php";
require_once "../shared/frontendRoutes.dev.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $user = new User();
    $user->setEmail($email);
    $user->setPass($pass);
    try {
        $user = UserController::getByMail($user);
        if($user === null){
            throw new Exception("Error al logearse");
        }
        if($user->getPass() != $pass){
            throw new Exception("Contraseña");
        }
        if($user->isAdmin() == 1){
            header("Location: ".frontendURL."/landingPageAdmin.php");
            exit;
        }
        if($user->isOwner() == 1){
            header("Location: ".frontendURL."/landingPageOwner.php"); 
            exit;
        }
        header("Location: ".frontendURL."/landingPage.php"); 
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "Método de solicitud no permitido.";
}

?>