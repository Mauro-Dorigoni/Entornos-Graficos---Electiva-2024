<?php
require_once __DIR__."/../structs/user.class.php";
require_once __DIR__."/../logic/user.controller.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/sendEmail.php";
require_once __DIR__."/../shared/backendRoutes.dev.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Me traigo los campos del formulario de Registro
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    if($pass!=$pass2){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['error_message'] = "Las contraseñas no coinciden.";
        header("Location: ".frontendURL."/registerPage.php");
        exit;
    }
    $user = new User();
    $user->setEmail($email);
    try {
        $repeatedUser = UserController::getByMail($user);
        if($repeatedUser){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = "Ya existe una cuenta asociada a la direccion de mail ingresada.";
            header("Location: ".frontendURL."/registerPage.php");
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
    $user->setPass(password_hash($pass, PASSWORD_DEFAULT));
    $token = bin2hex(random_bytes(16)); 
    $user->setEmailToken($token);
    try {
        UserController::registerUser($user);
        $verificationLink = "localhost".backendHTTPLayer."/verifyEmail.http.php?token=".$token;
        $destinatario = $user->getEmail();
        $asunto = 'PromoShop - Validacion de Email';
        $cuerpo = "
            <div style='background-color:#006633; padding: 20px; text-align: center;'>
                <h1 style='color: #CC6600; font-family: Arial, sans-serif;'>PromoShop</h1>
            </div>
            <div style='background-color: #eae8e0; padding: 30px; text-align: center;'>
                <h3 style='color: #333;'>¡Bienvenido a PromoShop!</h3>
                <p style='color: #555; font-family: Arial, sans-serif; font-size: 16px;'>
                    Por favor, verifica tu email haciendo clic en el siguiente botón:
                </p>
                <a href='$verificationLink' 
                style='display: inline-block; margin-top: 20px; padding: 12px 24px; background-color: #CC6600; color: #fff; text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif; font-size: 16px;'>
                Verificar Email
                </a>
            </div>
        ";

        $headers = 'From: graficosentornos@gmail.com'. "\r\n" .
                   'Reply-To:'.$user->getEmail(). "\r\n" .
                   'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
    
        if(enviar($destinatario, $asunto, $cuerpo)) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['success_message'] = "Registro exitoso. Se le ha enviado un email para verificar su correo. Recuerde revisar su casilla de spam.";
            header("Location: ".frontendURL."/loginPage.php"); 
            exit;
        } else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = 'Hubo un error al enviar el correo. Lamentamos las molestias';
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
    $_SESSION['error_message'] = "Método de solicitud no permitido.";
    header("Location: ".frontendURL."/loginPage.php"); 
    exit;
}
?>