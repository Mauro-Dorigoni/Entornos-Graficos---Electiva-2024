<?php
require_once __DIR__."/../logic/user.controller.php";
require_once __DIR__."/../structs/user.class.php";
require_once __DIR__."/../shared/userType.enum.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $user=new User();
    $user->setEmailToken($token);
    try {
        $userFound=UserController::getByEmailToken($user);
        echo $userFound->getEmail();
        if ($userFound!=null) {
            if ($userFound->isEmailVerified()) {
                echo "Tu email ya fue verificado previamente.";
            } else {
                UserController::validateUserEmail($userFound);
                echo "¡Email verificado exitosamente! Ahora puedes iniciar sesión.";
            }
            header("Location: ".frontendURL."/loginPage.php"); 
            exit;
        } else {
            echo "Token inválido o expirado.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Token no proporcionado.";
}
?>
