<?php
require_once __DIR__ . "/../structs/news.class.php";
require_once __DIR__ . "/../logic/news.controller.php";
require_once __DIR__ . "/../logic/userCategory.controller.php";
require_once __DIR__ . "/../shared/frontendRoutes.dev.php";
require_once __DIR__ . "/../shared/userType.enum.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$uploadDir = __DIR__ . '/../shared/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $idNews = (int)$_POST['id'];
        $n = new News();
        $n->setId($idNews);
        
        $news = NewsController::getOne($n);

        if (is_null($news)) {
            throw new Exception("La novedad no existe.");
        }

        $news->setNewsText($_POST['newsText']);
        $news->setDateFrom($_POST['dateFrom']);
        $news->setDateTo($_POST['dateTo']);
        
        $cat = new UserCategory();
        $cat->setId((int)$_POST['userCategory']);
        $news->setUserCategory($cat);

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            
            $oldImage = $news->getImageUUID();
            if ($oldImage && file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage);
            }

            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $newFileName = uniqid('', true) . '.' . $extension;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                $news->setImageUUID($newFileName);
            } else {
                throw new Exception("Error al subir la nueva imagen.");
            }
        } 

        NewsController::update($news);

        $_SESSION['success_message'] = "Novedad actualizada correctamente.";
        header("Location: " . frontendURL . "/newsDetailPage.php?id=" . $news->getId());
        exit;

    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}