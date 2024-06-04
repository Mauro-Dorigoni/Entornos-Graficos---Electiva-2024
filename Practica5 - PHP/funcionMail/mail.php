
<?php
    $destinatario = 'brancattilautygoretti@gmail.com';
    $asunto = 'Ejercicio 1 - Practica 5';
    $cuerpo = file_get_contents("\cuerpoCorreo.html");
    $headers = 'From: remitente@example.com' . "\r\n" .
               'Reply-To: remitente@example.com' . "\r\n" .
               'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    
    if(mail($destinatario, $asunto, $cuerpo, $headers)) {
        echo 'El correo se ha enviado correctamente';
    } else {
        echo 'Hubo un error al enviar el correo';
    }

?>

