<?php
//COPIADO DE GPT - Debemos tener el PHPMailer en la misma carpeta del proyecto. 

// Incluir los archivos necesarios de PHPMailer manualmente
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); // Crear una nueva instancia de PHPMailer

try {
    // Configuración del servidor SMTP
    $mail->SMTPDebug = 2;                                        // Habilitar salida de depuración
    $mail->isSMTP();                                             // Configurar el mailer para usar SMTP
    $mail->Host       = 'smtp.example.com';                      // Especificar servidor SMTP principal y de respaldo
    $mail->SMTPAuth   = true;                                    // Habilitar autenticación SMTP
    $mail->Username   = 'usuario@example.com';                   // Nombre de usuario SMTP
    $mail->Password   = 'password';                              // Contraseña SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Habilitar encriptación TLS; `PHPMailer::ENCRYPTION_SMTPS` también aceptado
    $mail->Port       = 587;                                     // Puerto TCP para conectarse

    // Destinatarios
    $mail->setFrom('remitente@example.com', 'Remitente');
    $mail->addAddress('destinatario@example.com', 'Destinatario');     // Añadir un destinatario

    // Contenido del correo
    $mail->isHTML(true);                                  // Configurar formato de correo a HTML
    $mail->Subject = 'Asunto del correo';
    $mail->Body    = 'Este es el cuerpo del mensaje en <b>HTML</b>';
    $mail->AltBody = 'Este es el cuerpo del mensaje en texto plano';

    $mail->send();
    echo 'El correo se ha enviado correctamente';
} catch (Exception $e) {
    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
}
?>
