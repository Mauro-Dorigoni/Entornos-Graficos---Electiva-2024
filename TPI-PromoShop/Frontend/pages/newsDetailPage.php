<?php
require_once "../../Backend/logic/news.controller.php";
require_once "../../Backend/structs/news.class.php";

$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;
$n = new News();
$n->setId($id);
$news = NewsController::getOne($n);

if (!$news) {
    header("Location: adminNewsPage.php");
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
        body { background-color: #eae8e0; min-height: 100vh; }
        .text-orange { color: #CC6600 !important; }
        .btn-orange { background-color: #CC6600; color: white; border: none; }
        .btn-orange:hover { background-color: #a35200; color: white; }
        
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
            object-fit: cover; /* La imagen llena el espacio sin deformarse */
        }

        .info-section {
            padding: 40px;
        }

        .date-badge {
            display: inline-block;
            background: #fff3e6;
            color: #CC6600;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include "../components/header.php" ?>
    <?php include "../components/navBarByUserType.php" ?>

    <main class="container py-5">
        <div class="card detail-card shadow-lg">
            <div class="row no-gutters"> <div class="col-md-5">
                    <div class="img-container">
                        <?php 
                            $urlImg = $news->getImageUUID() ? "../../Backend/shared/uploads/" . $news->getImageUUID() : "../../Backend/shared/uploads/placeholder.jpg";
                        ?>
                        <img src="<?= $urlImg ?>" class="news-img" alt="Imagen de la novedad">
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="info-section">
                        <div class="mb-1">
                            <h1 class="text-orange font-weight-bold display-4">Novedad #<?= $news->getId() ?></h1>
                        </div>
                        
                        <hr class="mb-4" style="border-top: 2px solid #CC6600; opacity: 0.3;">

                        <div class="mb-4">
                            <h5 class="text-dark font-weight-bold">
                                <i class="fas fa-list-alt text-orange mr-2"></i>Detalles de la publicación
                            </h5>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <p class="text-secondary mb-1" style="font-size: 1.1rem;">
                                    <i class="far fa-calendar-alt mr-2"></i><strong>Fecha Inicio:</strong> <?= date("d/m/Y", strtotime($news->getDateFrom())) ?>
                                </p>
                                <p class="text-secondary" style="font-size: 1.1rem;">
                                    <i class="far fa-calendar-check mr-2"></i><strong>Fecha Fin:</strong> <?= date("d/m/Y", strtotime($news->getDateTo())) ?>
                                </p>
                            </div>
                        </div>

                        <div class="description-box mb-5">
                            <h5 class="font-weight-bold"><i class="fas fa-info-circle text-orange"></i> Descripción:</h5>
                            <p class="text-secondary" style="font-size: 1.1rem; line-height: 1.6;">
                                <?= nl2br(htmlspecialchars($news->getNewsText())) ?>
                            </p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="newsPage.php" class="btn btn-light btn-lg">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <a href="editNewsPage.php?id=<?= $news->getId() ?>" class="btn btn-outline-orange btn-lg font-weight-bold">
                                <i class="fas fa-edit"></i> Editar Novedad
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <?php include "../components/footer.php" ?>
</body>
</html>