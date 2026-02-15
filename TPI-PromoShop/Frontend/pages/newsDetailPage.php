<?php
require_once __DIR__ . "/../shared/authFunctions.php/user.auth.function.php";
require_once "../../Backend/logic/news.controller.php";
require_once "../../Backend/structs/news.class.php";
require_once __DIR__ . "/../shared/nextcloud.public.php";
include "../components/messageModal.php";

$user = $_SESSION['user'];
$isAdmin = $user->isAdmin();

$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;
$n = new News();
$n->setId($id);
$news = NewsController::getOne($n);

if (!$news) {
    header("Location: newsPage.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle de Novedad - Fisherton Plaza</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #eae8e0 !important;
            min-height: 100vh;
        }

        .text-orange {
            color: #CC6600 !important;
        }

        #btn-outline-orange {
            color: white !important;
            background-color: #CC6600 !important;
            border: none;
            padding: 10px 30px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
        }

        #btn-outline-orange:hover {
            background-color: #a35200 !important;
        }

        .detail-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            border: none;
        }

        .img-container {
            height: 100%;
            min-height: 300px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .news-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info-section {
            padding: 40px;
        }
    </style>
</head>

<body>
    <?php include "../components/header.php" ?>
    <?php include "../components/navBarByUserType.php" ?>

    <main class="container py-5">
        <div class="card detail-card shadow-lg">
            <div class="row no-gutters">
                <div class="col-md-5">
                    <div class="img-container">
                        <img src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($news->getImageUUID()) ?>" class="news-img" alt="Imagen de la novedad">
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="info-section">
                        <h1 class="text-orange font-weight-bold display-4">Novedad #<?= $news->getId() ?></h1>
                        <hr class="mb-4" style="border-top: 2px solid #CC6600; opacity: 0.3;">

                        <div class="mb-4">
                            <h5 class="text-dark font-weight-bold"><i class="fas fa-list-alt text-orange mr-2"></i>Detalles de la publicación</h5>
                            <p class="text-secondary mb-1"><strong>Vigencia desde:</strong> <?= date("d/m/Y", strtotime($news->getDateFrom())) ?></p>
                            <p class="text-secondary"><strong>Vigencia hasta:</strong> <?= $news->getDateTo() ? date("d/m/Y", strtotime($news->getDateTo())) : '-' ?></p>
                        </div>

                        <div class="description-box mb-5">
                            <h5 class="font-weight-bold"><i class="fas fa-info-circle text-orange"></i> Descripción:</h5>
                            <p class="text-secondary" style="line-height: 1.6;">
                                <?= nl2br(htmlspecialchars($news->getNewsText())) ?>
                            </p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="newsPage.php" class="btn btn-light btn-lg"><i class="fas fa-arrow-left"></i> Volver</a>

                            <?php if ($isAdmin): ?>
                                <a href="editNewsPage.php?id=<?= $news->getId() ?>" id="btn-outline-orange" class="font-weight-bold">Editar Novedad</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include "../components/footer.php" ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>