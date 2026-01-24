<?php
require_once __DIR__."/../shared/sendEmail.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__ . "/../shared/userType.enum.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $nombre = $_POST["nombre"];
        $emailContacto = $_POST["email"];
        $consulta = $_POST["mensaje"];

        $destinatarioConsulta = "graficosentornos@gmail.com";
        $asuntoConsulta = 'PromoShop - Consulta de Usuario';
        $cuerpoConsulta = "
            <div style='background-color:#006633; padding: 20px; text-align: center;'>
                <h1 style='color: #CC6600; font-family: Arial, sans-serif;'>PromoShop</h1>
            </div>
            <div style='background-color: #eae8e0; padding: 30px; text-align: center;'>
                <h3 style='color: #333;'>Consulta de usuario de sitio web</h3>
                <p style='color: #555; font-family: Arial, sans-serif; font-size: 16px;'>
                    $nombre realizo la siguiente consulta en el sitio web:
                </p>
                <p style='color: #555; font-family: Arial, sans-serif; font-size: 16px;'>
                    $consulta
                </p>
                <p style='color: #555; font-family: Arial, sans-serif; font-size: 16px;'>
                    Contestar a: $emailContacto
                </p>
            </div>
        ";
        $headers = 'From: graficosentornos@gmail.com'. "\r\n" .
                   'Reply-To:'.$emailContacto. "\r\n" .
                   'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        $cuerpoRespuesta = "
            <div style='background-color:#006633; padding: 20px; text-align: center;'>
                <h1 style='color: #CC6600; font-family: Arial, sans-serif;'>PromoShop</h1>
            </div>
            <div style='background-color: #eae8e0; padding: 30px; text-align: center;'>
                <h3 style='color: #333;'>Consulta de usuario de sitio web</h3>
                <p style='color: #555; font-family: Arial, sans-serif; font-size: 16px;'>
                    $nombre le agradecemos por su consulta. En brevedad un administrador se pondra en contacto con usted.
                </p>
                <p style='color: #555; font-family: Arial, sans-serif; font-size: 16px;'>
                    Cuerpo de su consulta: $consulta
                </p>
            </div>
        ";
        
        if(enviar($destinatarioConsulta, $asuntoConsulta, $cuerpoConsulta) && enviar($emailContacto, $asuntoConsulta, $cuerpoRespuesta)) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['success_message'] = "Gracias con su consulta! Contestaremos en breve";
            //deberia reenviarlo a la pagina de donde vino, pero no se me ocurre de momento como hacerlo
            $redirect = $_SERVER['HTTP_REFERER'] ?? (frontendURL . "/landingPageTest.php");
            header("Location: " . $redirect);
            exit;

        } else {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['error_message'] = 'Hubo un error al enviar su consulta. Lamentamos las molestias';
            //deberia reenviarlo a la pagina de donde vino, pero no se me ocurre de momento como hacerlo
            $redirect = $_SERVER['HTTP_REFERER'] ?? (frontendURL . "/landingPageTest.php");
            header("Location: " . $redirect);
            exit;
        }
    } catch (Exception $th) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['error_message'] = $th->getMessage();
        error_log("Error en contact.http.php: " . $th->getMessage());
    }
}else{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['error_message'] = "Metodo de solicitud no permitido";
}
?>