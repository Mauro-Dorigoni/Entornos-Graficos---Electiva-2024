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

    <main id="main-content" class="container py-5">
        <article class="card detail-card shadow-lg" aria-labelledby="news-title">
            <div class="row no-gutters">

                <div class="col-12 col-md-5">
                    <div class="img-container h-100 bg-light d-flex align-items-center justify-content-center">
                        <?php
                        // Asignamos fallback por si no hay UUID
                        $imgUrl = $news->getImageUUID() ? NEXTCLOUD_PUBLIC_BASE . urlencode($news->getImageUUID()) : 'https://via.placeholder.com/600x400?text=Novedad';
                        ?>
                        <img src="<?= $imgUrl ?>"
                            class="news-img img-fluid w-100"
                            style="object-fit: cover; min-height: 100%;"
                            alt="Imagen ilustrativa de la Novedad número <?= $news->getId() ?>">
                    </div>
                </div>

                <div class="col-12 col-md-7">
                    <div class="info-section p-4 p-md-5">

                        <h1 id="news-title" class="text-orange font-weight-bold" style="font-size: clamp(1.5rem, 4vw, 2.5rem);" tabindex="0">
                            Novedad #<?= $news->getId() ?>
                        </h1>

                        <hr class="mb-4" style="border-top: 2px solid #CC6600; opacity: 0.3;">

                        <section aria-labelledby="details-heading" class="mb-4">
                            <h2 id="details-heading" class="h5 text-dark font-weight-bold mb-3">
                                <i class="fas fa-list-alt text-orange mr-2" aria-hidden="true"></i>Detalles
                            </h2>

                            <?php
                            // 4. Preparación de fechas seguras (Fix del 1970 y formato humano)
                            $visualDesde = is_object($news->getDateFrom()) ? $news->getDateFrom()->format('d/m/Y') : date("d/m/Y", strtotime($news->getDateFrom()));
                            $visualHasta = $news->getDateTo()
                                ? (is_object($news->getDateTo()) ? $news->getDateTo()->format('d/m/Y') : date("d/m/Y", strtotime($news->getDateTo())))
                                : 'Sin límite';

                            $meses = ['01' => 'enero', '02' => 'febrero', '03' => 'marzo', '04' => 'abril', '05' => 'mayo', '06' => 'junio', '07' => 'julio', '08' => 'agosto', '09' => 'septiembre', '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'];

                            $timestampDesde = is_object($news->getDateFrom()) ? $news->getDateFrom()->getTimestamp() : strtotime($news->getDateFrom());
                            $lectorDesde = date('d', $timestampDesde) . " de " . $meses[date('m', $timestampDesde)] . " de " . date('Y', $timestampDesde);

                            $lectorHasta = 'sin límite de tiempo';
                            if ($news->getDateTo() !== null) {
                                $timestampHasta = is_object($news->getDateTo()) ? $news->getDateTo()->getTimestamp() : strtotime($news->getDateTo());
                                $lectorHasta = date('d', $timestampHasta) . " de " . $meses[date('m', $timestampHasta)] . " de " . date('Y', $timestampHasta);
                            }
                            ?>

                            <div aria-label="Período de vigencia: del <?= $lectorDesde ?> al <?= $lectorHasta ?>">
                                <dl class="row text-secondary mb-0" aria-hidden="true">
                                    <dt class="col-sm-4 mb-1 mb-sm-0">Vigencia desde:</dt>
                                    <dd class="col-sm-8 text-dark"><?= $visualDesde ?></dd>

                                    <dt class="col-sm-4 mb-1 mb-sm-0">Vigencia hasta:</dt>
                                    <dd class="col-sm-8 text-dark mb-0"><?= $visualHasta ?></dd>
                                </dl>
                            </div>
                        </section>

                        <section aria-labelledby="desc-heading" class="description-box mb-5">
                            <h2 id="desc-heading" class="h5 font-weight-bold mb-3">
                                <i class="fas fa-info-circle text-orange mr-2" aria-hidden="true"></i>Descripción
                            </h2>
                            <p class="text-secondary text-justify" style="line-height: 1.6;">
                                <?= nl2br(htmlspecialchars($news->getNewsText())) ?>
                            </p>
                        </section>

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-auto pt-3 border-top">
                            <a href="newsPage.php" class="btn btn-light btn-lg mb-3 mb-md-0 w-100 w-md-auto" aria-label="Volver al listado de novedades">
                                <i class="fas fa-arrow-left" aria-hidden="true"></i> Volver
                            </a>

                            <?php if ($isAdmin): ?>
                                <a href="editNewsPage.php?id=<?= $news->getId() ?>"
                                    class="btn btn-outline-orange btn-lg font-weight-bold text-center w-100 w-md-auto"
                                    aria-label="Editar esta novedad">
                                    <i class="fas fa-edit mr-2" aria-hidden="true"></i> Editar Novedad
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </main>
    <?php include "../components/footer.php" ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

</body>

</html>