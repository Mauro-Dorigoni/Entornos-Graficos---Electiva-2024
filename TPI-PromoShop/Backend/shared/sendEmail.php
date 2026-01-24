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

        // --- DEBUG (Opcional: Descomenta si sigue fallando para ver el error real) ---
        // $mail->SMTPDebug = 3; 
        // $mail->Debugoutput = 'html';

        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = emailAdress;
        $mail->Password = emailPassword;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // --- SOLUCIÓN XAMPP (Fix SSL) ---
        // Esto evita el error de "Certificate verification failed" en local
        // $mail->SMTPOptions = array(
        //     'ssl' => array(
        //         'verify_peer' => false,
        //         'verify_peer_name' => false,
        //         'allow_self_signed' => true
        //     )
        // );
        // -------------------------------

        $mail->isHTML(true);
        $mail->setFrom(emailAdress, "PromoShop");
        $mail->addAddress($email, "Receptor");
        $mail->Subject = $asunto;
        $mail->Body = $body;

        $mail->send();
        return true; 

    } catch (Exception $e) {
        
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
        error_log("Error PHPMailer: " . $mail->ErrorInfo);
        sleep(15);
        return false; 
    }
}
?>