<?php
require __DIR__."/PHPMailer-master/PHPMailer-master/src/Exception.php";
require __DIR__."/PHPMailer-master/PHPMailer-master/src/PHPMailer.php";
require __DIR__."/PHPMailer-master/PHPMailer-master/src/SMTP.php";
require_once __DIR__."/mail.dev.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function enviar($email, $asunto, $body) {
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = emailAdress;
        $mail->Password = emailPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->isHTML(true);
        $mail->setFrom(emailAdress, "PromoShop");
        $mail->addAddress($email, "Receptor");
        $mail->Subject = $asunto;
        $mail->Body = $body;

        $mail->send();
        return true; 

    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
        sleep(15);
        return false; 
    }
}
?>