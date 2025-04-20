<?php
require_once __DIR__."/../structs/shop.class.php";
require_once __DIR__."/../logic/shop.controller.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/sendEmail.php";
require_once __DIR__."/../shared/userType.enum.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$uploadDir = __DIR__ . '/../shared/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idShop = (int)$_POST["idLocal"];
    try {
        $shop = new Shop();
        $shop->setId($idShop);
        $shop = ShopController::getOne($shop);
        if($shop==null){
            throw new Exception("El local no existe");
        }
        $images = [];
        foreach ($_FILES['imagen']['tmp_name'] as $key => $tmpName) {
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
        }
        $shop->setImagesUUIDS($images);
        ShopController::addShopImages($shop);
        $_SESSION['success_message'] = "Imagenes Registradas correctamente";
        header("Location: ".frontendURL."/newShopGalleryPage.php"); 
        exit;
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: ".frontendURL."/newShopGalleryPage.php"); 
        exit;
    }
} else {
    $_SESSION['error_message'] = "Método de solicitud no permitido.";
    header("Location: ".frontendURL."/newShopGalleryPage.php"); 
    exit;
}
?>