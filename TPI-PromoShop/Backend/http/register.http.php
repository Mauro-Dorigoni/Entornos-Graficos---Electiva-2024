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
        throw new Exception("Las contraseñas no coinciden");
    }
    $user = new User();
    $user->setEmail($email);
    $user->setPass($pass);
    $token = bin2hex(random_bytes(16)); 
    $user->setEmailToken($token);
    try {
        UserController::registerUser($user);
        $verificationLink = "localhost".backendHTTPLayer."/verifyEmail.http.php?token=".$token;
        $destinatario = $user->getEmail();
        $asunto = 'PromoShop - Validacion de Email';
        $cuerpo = "
            <h3>Bienvenido a PromoShop</h3>
            <p>Por favor, verifica tu email haciendo clic en el siguiente enlace:</p>
            <a href='$verificationLink'>Verificar Email</a>
        ";
        $headers = 'From: graficosentornos@gmail.com'. "\r\n" .
                   'Reply-To:'.$user->getEmail(). "\r\n" .
                   'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
    
        if(enviar($destinatario, $asunto, $cuerpo)) {
            echo 'El correo se ha enviado correctamente. En breve recibira una respuesta';
            $_SESSION['user'] = $user;
            header("Location: ".frontendURL."/loginPage.php"); 
            exit;
        } else {
            echo 'Hubo un error al enviar el correo. Lamentamos las molestias';
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "Método de solicitud no permitido.";
}
?>