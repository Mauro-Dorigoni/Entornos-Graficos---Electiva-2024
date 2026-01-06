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
require_once __DIR__."/../shared/nextcloudUpload.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        if (!isset($_SESSION['user']) || $_SESSION['user']->isOwner() === false || $_SESSION['userType'] !== UserType_enum::Owner) {
            throw new Exception("No tienes permisos para acceder a esta página");
        }

        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error en el archivo de imagen");
        }

        $originalName = $_FILES['image']['name'];
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $uuid = uniqid('', true);
        $newFileName = $uuid . '.' . $extension;

        uploadToNextcloud($_FILES['image']['tmp_name'], $newFileName);

        $userCategory = new UserCategory();
        $userCategory->setId((int) $_POST['userCategory']);

        $owner = new User();
        $owner->setId($_SESSION['user']->getId());

        $shop = ShopController::getOneByOwner($owner);

        $promo = new Promotion();
        $promo->setUserCategory($userCategory);
        $promo->setShop($shop);
        $promo->setPromoText($_POST['promoText']);
        $promo->setDateFromString($_POST['dateFrom']);
        $promo->setDateToString($_POST['dateTo']);
        $promo->setImageUUID($newFileName);

        $dayMap = [
            'mon' => 0, 'tue' => 1, 'wed' => 2, 'thu' => 3,
            'fri' => 4, 'sat' => 5, 'sun' => 6
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
        PromotionContoller::registerPromotion($promo);

        $_SESSION['success_message'] = "Promoción registrada correctamente";
        header("Location: ".frontendURL."/newPromotionPage.php");
        exit;

    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        header("Location: ".frontendURL."/newPromotionPage.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Método de solicitud no permitido.";
    header("Location: ".frontendURL."/newPromotionPage.php"); 
    exit;
}
