<?php
require_once __DIR__."/../structs/promotion.class.php"; 
require_once __DIR__."/../structs/shop.class.php";
require_once __DIR__."/../structs/userCategory.class.php";  
require_once __DIR__."/../logic/promotion.controller.php";
require_once __DIR__."/../logic/shop.controller.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/backendRoutes.dev.php";
require_once __DIR__."/../shared/userType.enum.php";

$uploadDir = __DIR__ . '/../shared/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if(session_status() == PHP_SESSION_NONE){
    session_start();
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    try {
        if(!isset($_SESSION['user']) || $_SESSION['user'] -> isOwner() == false || $_SESSION['userType'] != UserType_enum::Owner){
            $_SESSION['error_message'] = "No tienes permisos para acceder a esta pagina";
            header("Location: ".frontendURL."/loginPage.php");
            exit;
        }
        if ($_FILES['imagen']['error'][$key] === UPLOAD_ERR_OK) {
                $originalName = $_FILES['imagen']['name'][$key];
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $uuid = uniqid('', true); 
                $newFileName = $uuid . '.' . $extension;
                $destination = $uploadDir . $newFileName;
        
                if (move_uploaded_file($tmpName, $destination)) {
                    $images[] = $newFileName;
                } else {
                    throw new Exception("Error subiendo la imagen: $originalName");
                }
            } else {
                throw new Exception("Error en el archivo: " . $_FILES['imagen']['name'][$key]);
            }
        
        $promo = new Promotion();
        $promo->setPromoText($_POST['promoText']);
        $promo->setDateFromString($_POST['dateFrom']);
        $promo->setDateToString($_POST['dateTo']);
        $promo->setImageUUID($uuid);

    }catch (Exception $e){
        $_SESSION['error_message'] = "Error al registrar la Promocion".$e -> getMessage();
        header("Location: ".frontendURL."/newPromotionPage.php");
        exit;
    }
} else {
$_SESSION['error_message'] = "Método de solicitud no permitido.";
header("Location: ".frontendURL."/newPromotionPage.php"); 
exit;
}
?>