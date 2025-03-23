<?php
require_once __DIR__."/../structs/user.class.php";
require_once __DIR__."/../logic/user.controller.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/sendEmail.php";
require_once __DIR__."/../shared/backendRoutes.dev.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    try {
        $user = new User();
        $user->setEmail($email);
        $existingUser = UserController::getByMail($user);
        if(!$existingUser){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = "No existe una cuenta asociada a la direccion de mail ingresada.";
            header("Location: ".frontendURL."/loginPage.php"); 
            exit;
        }else{
            if(!$existingUser->isEmailVerified()){
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['error_message'] = "Su email no fue verificado. Revise su bandeja de entrada";
                header("Location: ".frontendURL."/loginPage.php"); 
                exit; 
            }
            $token=$existingUser->getEmailToken();
            $recoveryLink = "localhost".backendHTTPLayer."/recoveryVerification.http.php?token=".$token."&action=recovery";
            $destinatario = $existingUser->getEmail();
            $asunto = 'PromoShop - Recuperacion de Cuenta';
            $cuerpo = "
                <div style='background-color:#006633; padding: 20px; text-align: center;'>
                    <h1 style='color: #CC6600; font-family: Arial, sans-serif;'>PromoShop</h1>
                </div>
                <div style='background-color: #eae8e0; padding: 30px; text-align: center;'>
                    <h3 style='color: #333;'>Recuperacion de Cuenta</h3>
                    <p style='color: #555; font-family: Arial, sans-serif; font-size: 16px;'>
                        Parece que te has olvidado tu contraseña. Haciendo click en el siguiente boton podras cambiarla asi podras seguir haciendo uso de nuestras promociones.
                    </p>
                    <a href='$recoveryLink' 
                    style='display: inline-block; margin-top: 20px; padding: 12px 24px; background-color: #CC6600; color: #fff; text-decoration: none; border-radius: 5px; font-family: Arial, sans-serif; font-size: 16px;'>
                    Cambio de Contraseña
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
                $_SESSION['success_message'] = "Se le ha enviado un mail con instrucciones para la recuperacion de cuenta. Recuerde revisar su casilla de spam.";
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