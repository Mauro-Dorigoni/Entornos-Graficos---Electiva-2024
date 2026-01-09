<?php
require_once __DIR__."/../structs/news.class.php";
require_once __DIR__."/../structs/user.class.php";
require_once __DIR__."/../structs/userCategory.class.php";
require_once __DIR__."/../logic/news.controller.php";
require_once __DIR__."/../shared/frontendRoutes.dev.php";
require_once __DIR__."/../shared/userType.enum.php";

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$uploadDir = __DIR__ . '/../shared/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    try{
        if(!isset($_SESSION['user']) || $_SESSION['user']->isAdmin() == false || $_SESSION['userType'] != UserType_enum::Admin){
            $_SESSION['error_message'] = "No tienes permisos para realizar esta acción";
            header("Location: ".frontendURL."/loginPage.php");
            exit;
        }

        $newsText = $_POST['newsText'];
        $dateFrom = $_POST['dateFrom'];
        $dateTo = $_POST['dateTo'];
        $idUserCategory = (int)$_POST['userCategory']; 

        $news = new News();
        $news->setNewsText($newsText);
        $news->setDateFrom($dateFrom);
        $news->setDateTo($dateTo);
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) 
        {
            $originalName = $_FILES['image']['name'];
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $uuid = uniqid('', true);
            $newFileName = $uuid . '.' . $extension;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                $news->setImageUUID($newFileName);
            } else {
                throw new Exception("Error al mover la imagen al servidor.");
            }
        }
         
        $news->setAdmin($_SESSION['user']);

        $userCategory = new UserCategory();
        $userCategory->setId($idUserCategory);
        $news->setUserCategory($userCategory);

        NewsController::registerNews($news);

        $_SESSION['success_message'] = "Novedad publicada exitosamente";
        header("Location: ".frontendURL."/newNewsPage.php"); 
        exit;

    } catch (Exception $e){
        $_SESSION['error_message'] = "Error al registrar la novedad: ".$e->getMessage();
        header("Location: ".frontendURL."/newNewsPage.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Método de solicitud no permitido";
    header("Location: ".frontendURL."/newNewsPage.php");
}
?>