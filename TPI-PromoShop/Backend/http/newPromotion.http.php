<?php
require_once __DIR__."/../structs/promotion.class.php"; 
require_once __DIR__."/../structs/shop.class.php";
require_once __DIR__."/../structs/userCategory.class.php";  
require_once __DIR__."/../logic/promotion.controller.php";
require_once __DIR__."/../logic/userCategory.controller.php";
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
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $originalName = $_FILES['image']['name'];
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $uuid = uniqid('', true);
            $newFileName = $uuid . '.' . $extension;
            $destination = $uploadDir . $newFileName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                throw new Exception("Error subiendo la imagen");
            }
        } else {
            throw new Exception("Error en el archivo de imagen");
        }
        $userCategory = new UserCategory();
        $userCategory->setId((int)$_POST['userCategory']);
        $owner = new User();
        $owner->setId($_SESSION['user']->getId());
        $shop = ShopController::getOneByOwner($owner);
        $promo = new Promotion();
        $promo->setUserCategory($userCategory);
        $promo->setShop($shop);
        $promo->setPromoText($_POST['promoText']);
        $promo->setDateFromString($_POST['dateFrom']);
        $promo->setDateToString($_POST['dateTo']);
        $promo->setImageUUID($uuid);
        $dayMap = [
            'mon' => 0,
            'tue' => 1,
            'wed' => 2,
            'thu' => 3,
            'fri' => 4,
            'sat' => 5,
            'sun' => 6
        ];
        $validDaysArray = array_fill(0, 7, 0);
        if (!empty($_POST['validDays'])) {
            foreach ($_POST['validDays'] as $dayKey) {
                if (isset($dayMap[$dayKey])) {
                    $validDaysArray[$dayMap[$dayKey]] = 1;
                }
            }
        }
        $promo->setValidDays($validDaysArray);
        $promo = PromotionContoller::registerPromotion($promo);
        $_SESSION['success_message'] = "Promocion registrada exitosamente";
        header("Location: ".frontendURL."/newPromotionPage.php");
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