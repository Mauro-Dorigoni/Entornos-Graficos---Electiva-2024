<?php
require_once __DIR__."/../logic/user.controller.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/backendRoutes.dev.php";
require_once __DIR__ ."/../shared/userType.enum.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['error_message'] = "Método no permitido.";
    header("Location: ".frontendURL."/myProfilePage.php");
    exit;
    //throw new Exception("metodo no permitido");
}

if (!isset($_SESSION['user'])) {
    $_SESSION['error_message'] = "Sesión expirada.";
    header("Location: ".frontendURL."/myProfilePage.php");
    exit;
    //throw new Exception("usuario no encontrado");

}

$currentPass = $_POST["current_pass"];
$newPass     = $_POST["new_pass"];
$newPass2    = $_POST["new_pass2"];

if ($newPass !== $newPass2) {
    $_SESSION['error_message'] = "Las nuevas contraseñas no coinciden.";
    header("Location: ".frontendURL."/myProfile.php");
    exit;
        //throw new Exception("contraeeñas no coinciden");

}

try {

    $sessionUser = $_SESSION['user'];
    $dbUser = UserController::getOne($sessionUser);

    if (!$dbUser) {
       // throw new Exception("Usuario no encontrado.");
    }

    if (!password_verify($currentPass, $dbUser->getPass())) {
        $_SESSION['error_message'] = "La contraseña actual es incorrecta.";
        header("Location: ".frontendURL."/myProfile.php");
        exit;
            //throw new Exception("contra inicial mal");

    }

    $dbUser->setPass(password_hash($newPass, PASSWORD_DEFAULT));
    UserController::update($dbUser);
    //session_destroy();

    //session_start();
    $_SESSION['success_message'] = "Contraseña actualizada.";

    header("Location: ".frontendURL."/myProfilePage.php");
    exit;

} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    header("Location: ".frontendURL."/myProfile.php");
    exit;
   //die("ERROR CRÍTICO: " . $e->getMessage());
}
