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
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            /* Importante para que la imagen no se salga de las curvas */
            border: none;
        }

        /* --- CORRECCIÓN RESPONSIVE DE IMAGEN --- */

        .img-container {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            /* En móvil, altura fija para que se vea la foto */
            min-height: 250px;
            height: 100%;
            /* Ocupa todo el alto en escritorio */
        }

        .news-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Recorta la imagen para llenar el espacio sin deformar */
            object-position: center;
        }

        .info-section {
            padding: 30px;
            /* Un poco menos de padding para móviles */
        }

        /* Ajuste específico para escritorio (md en adelante) */
        @media (min-width: 768px) {
            .info-section {
                padding: 40px;
            }

            .img-container {
                min-height: 100%;
            }

            /* En escritorio, que estire */
        }
    </style>
</head>

<body>
    <?php include "../components/header.php" ?>
    <?php include "../components/navBarByUserType.php" ?>

    <main class="container py-5">
        <div class="card detail-card shadow-lg">
            <div class="row no-gutters">

                <div class="col-12 col-md-5">
                    <div class="img-container">
                        <img src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($news->getImageUUID()) ?>" class="news-img" alt="Imagen Novedad">
                    </div>
                </div>

                <div class="col-12 col-md-7">
                    <div class="info-section">
                        <h1 class="text-orange font-weight-bold" style="font-size: clamp(1.5rem, 4vw, 2.5rem);">
                            Novedad #<?= $news->getId() ?>
                        </h1>

                        <hr class="mb-4" style="border-top: 2px solid #CC6600; opacity: 0.3;">

                        <div class="mb-4">
                            <h5 class="text-dark font-weight-bold"><i class="fas fa-list-alt text-orange mr-2"></i>Detalles</h5>
                            <p class="text-secondary mb-1"><strong>Vigencia desde:</strong> <?= date("d/m/Y", strtotime($news->getDateFrom())) ?></p>
                            <p class="text-secondary"><strong>Vigencia hasta:</strong> <?= $news->getDateTo() ? date("d/m/Y", strtotime($news->getDateTo())) : '-' ?></p>
                        </div>

                        <div class="description-box mb-5">
                            <h5 class="font-weight-bold"><i class="fas fa-info-circle text-orange"></i> Descripción:</h5>
                            <p class="text-secondary text-justify" style="line-height: 1.6;">
                                <?= nl2br(htmlspecialchars($news->getNewsText())) ?>
                            </p>
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <a href="newsPage.php" class="btn btn-light btn-lg mb-3 mb-md-0">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>

                            <?php if ($isAdmin): ?>
                                <a href="editNewsPage.php?id=<?= $news->getId() ?>" id="btn-outline-orange" class="font-weight-bold text-center">
                                    <i class="fas fa-edit mr-1"></i> Editar Novedad
                                </a>
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

</body>

</html>