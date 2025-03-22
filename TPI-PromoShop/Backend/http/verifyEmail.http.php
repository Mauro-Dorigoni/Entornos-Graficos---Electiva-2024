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
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['success_message'] = "¡Email verificado exitosamente! Te pediremos que vuelvas a iniciar sesión.";
            }
            header("Location: ".frontendURL."/loginPage.php"); 
            exit;
        } else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = "Token inválido o expirado.";
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
} else {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['error_message'] = "Token no proporcionado.";
    header("Location: ".frontendURL."/loginPage.php"); 
    exit;
}
?>
