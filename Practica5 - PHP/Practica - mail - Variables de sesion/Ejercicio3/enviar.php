

<?php
 require "PHPMailer-master/PHPMailer-master/src/Exception.php";
 require "PHPMailer-master/PHPMailer-master/src/PHPMailer.php";
 require "PHPMailer-master/PHPMailer-master/src/SMTP.php";
 
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
function enviar($email,$nombre,$apellido,$asunto,$body){
    $mail = new PHPMailer(true);
    try {
    // Configuración del servidor SMTP

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'graficosentornos@gmail.com'; // Tu correo de Gmail
    $mail->Password = '***************'; // Tu contraseña de Gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587; // Puerto SMTP para TLS

    // Configuración del correo
    $mail->isHTML(true);
    $mail->setFrom('graficosentornos@gmail.com',"Recomendador");
    $mail->addAddress("$email", "$nombre $apellido");
    $mail->Subject = "$asunto";
    $mail->Body = $body;

    // Enviar el correo
    $enviado = ($mail->send());
    if (!$enviado) {
        return true;
    }
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
        sleep(15);
        return false;
    }
}
if (isset($_POST)){
    
        $fecha=date("d-m-Y");
        $hora= date("H :i:s");
        $destinatario = $_POST["correo"];
        $asunto = 'Recomendacion WEB';
        $cuerpo = "Hola"." ".$_POST["nombre_amigo"]." ".$_POST["apellido_amigo"]." Tu amigo".$_POST["nombre"]." ".$_POST["apellido"]." te esta recomendando nuestro sitio web";
        $headers = 'From: graficosentornos@gmail.com'. "\r\n" .
                   'Reply-To:'.$_POST['correo']. "\r\n" .
                   'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
    
    if(enviar($destinatario,$_POST["nombre"], $_POST["apellido"], $asunto, $cuerpo)) {
        echo 'El correo se ha enviado correctamente. En breve recibira una respuesta';
     } else {
        echo 'Hubo un error al enviar el correo. Lamentamos las molestias';
     }
} else 
    {   echo 'No se lleno el formulario';
    } 
?>
