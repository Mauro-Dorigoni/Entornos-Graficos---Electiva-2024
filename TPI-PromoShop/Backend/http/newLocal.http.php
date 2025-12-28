<?php
require_once __DIR__."/../structs/shop.class.php"; 
require_once __DIR__."/../logic/shop.controller.php";
require_once __DIR__."/../logic/user.controller.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/userType.enum.php";
require_once __DIR__."/../shared/sendEmail.php";
require_once __DIR__."/../shared/backendRoutes.dev.php";

if(session_status() == PHP_SESSION_NONE){
    session_start();
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
        if(!isset($_SESSION['user']) || $_SESSION['user'] -> isAdmin() == false || $_SESSION['userType'] != UserType_enum::Admin){
            $_SESSION['error_message'] = "No tienes permisos para acceder a esta pagina";
            header("Location: ".frontendURL."/loginPage.php");
            exit;
        }
        $emailOwner = $_POST['emailOwner']; 
        $passwordOwner = $_POST['passwordOwner'];
        $owner = new User();
        $token = bin2hex(random_bytes(16)); 
        $owner->setEmailToken($token);
        $owner->setEmail($emailOwner);
        $owner->setPass(password_hash($passwordOwner, PASSWORD_DEFAULT));
        $userFound = UserController::getByMail($owner);
        if($userFound != null){
            $_SESSION['error_message'] = "El usuario ya se encuentra registrado";
            header("Location: ".frontendURL."/newLocalPage.php");
            exit;
        }
        UserController::registerOwner($owner);
        $registeredOwner = UserController::getByMail($owner);
        $nombreLocal = $_POST['local'];
        $ubiLocal = $_POST['ubiLocal'];
        $idShopType = (int)$_POST['shopType'];
        $shopType = new ShopType();
        $shopType->setId($idShopType);
        $local = new Shop();
        $local->setName($nombreLocal);
        $local->setLocation($ubiLocal);
        $local->setOwner($registeredOwner);
        $local->setShopType($shopType);
        ShopController ::registerShop($local);
        $verificationLink = "http://localhost" . backendHTTPLayer . "/verifyEmail.http.php?token=" . $token;
        $destinatario = $owner->getEmail();
        $asunto = 'PromoShop - Nuevo local a su nombre';
        $cuerpo = "
            <div style='background-color:#006633; padding:20px; text-align:center;'>
                <h1 style='color:#CC6600; font-family:Arial, sans-serif;'>PromoShop</h1>
            </div>
            <div style='background-color:#eae8e0; padding:30px; text-align:center;'>
                <h3 style='color:#333;'>¡Bienvenido a PromoShop!</h3>
                <p style='color:#555; font-family:Arial, sans-serif; font-size:16px;'>
                    Un nuevo local fue dado de alta a su nombre.
                    Por favor, verifique su email haciendo clic en el siguiente botón:
                </p>
                <a href='$verificationLink'
                style='display:inline-block; margin-top:20px; padding:12px 24px;
                background-color:#CC6600; color:#fff; text-decoration:none;
                border-radius:5px; font-family:Arial, sans-serif; font-size:16px;'>
                    Verificar Email
                </a>
            </div>
        ";

        $headers =
            'From: graficosentornos@gmail.com' . "\r\n" .
            'Reply-To: graficosentornos@gmail.com' . "\r\n" .
            'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if (!enviar($destinatario, $asunto, $cuerpo, $headers)) {
            $_SESSION['error_message'] = "El local fue registrado pero ocurrió un error al enviar el email";
            header("Location: " . frontendURL . "/newLocalPage.php");
            exit;
        }
        $_SESSION['success_message'] = "Local registrado exitosamente. Se envió un email de verificación.";
        header("Location: " . frontendURL . "/newLocalPage.php");
        exit;
    }
    catch (Exception $e){
        $_SESSION['error_message'] = "Error al registrar el local".$e -> getMessage();
        header("Location: ".frontendURL."/newLocalPage.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Metodo de solicitud no permitido";
    header("Location: ".frontendURL."/newLocalPage.php");
}
?>