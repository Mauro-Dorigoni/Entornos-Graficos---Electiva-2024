

<?php
if (isset($_POST)) {
        $fecha=date("d-m-Y");
        $hora= date("H :i:s");
        $destinatario = 'brancattilautygoretti@gmail.com';
        $asunto = 'Consulta WEB';
        $cuerpo = "\n
             Nombre:".$_POST['nombre']."\n".
            "Apellido:". $POST['apellido']."\n".
            "Email:". $_POST['email']."\n".
            "Consulta:". $_POST['texto']."\n".
            " Enviado:". $fecha ."a las". $hora. "\n";


        $headers = 'From:'.$_POST['correo']. "\r\n" .
                   'Reply-To:'.$_POST['correo']. "\r\n" .
                   'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
    
    if(
        mail($destinatario, $asunto, $cuerpo, $headers)
        
        ) {
        echo 'El correo se ha enviado correctamente. En breve recibira una respuesta';
     } else {
        echo 'Hubo un error al enviar el correo. Lamentamos las molestias';
        sleep(10);
        header('Location: formulario.html');
        exit();
     }
} else 
    {   echo 'Pase por el php';
        sleep(5);
        header('Location: formulario.html');
        exit();
    }
?>
