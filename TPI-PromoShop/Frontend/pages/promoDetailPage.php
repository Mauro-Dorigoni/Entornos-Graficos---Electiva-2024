<?php
require_once "../../Backend/logic/promotion.controller.php";
require_once "../../Backend/structs/promotion.class.php";
require_once __DIR__ . "/../shared/nextcloud.public.php";
require_once __DIR__ . "/../../Backend/shared/promoStatus.enum.php";
require_once __DIR__ . "/../shared/dayLabels.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";
require_once __DIR__ . "/../../Backend/structs/user.class.php";
require_once __DIR__ . "/../shared/userType.enum.php";

include "../components/messageModal.php";

$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;

$p = new Promotion();
$p->setId($id);
$promo = PromotionContoller::getOne($p);

$user = $_SESSION['user'] ?? null;;

if (!$promo) {
    header("Location landingPageTest.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle de Promoción - Fisherton Plaza</title>
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

        #btn-orange {
            color: white !important;
            background-color: #CC6600 !important;
            border: none;
            padding: 10px 30px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
        }

        #btn-orange:hover {
            background-color: #a35200 !important;
        }

        .detail-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            border: none;
        }

        .img-container {
            min-height: 300px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .promo-img {
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

    <main id="main-content" class="container py-5">
        <article class="card detail-card shadow-lg" aria-labelledby="promo-title">
            <div class="row no-gutters">
                <div class="col-md-5">
                    <div class="img-container h-100 bg-light d-flex align-items-center justify-content-center">
                        <img src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($promo->getImageUUID()) ?>"
                            class="promo-img img-fluid w-100"
                            style="object-fit: cover; min-height: 100%;"
                            alt="Folleto de la promoción de <?= htmlspecialchars($promo->getShop()->getName()) ?>">
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="info-section p-4 p-md-5">
                        <h1 id="promo-title" class="text-orange font-weight-bold display-4 mb-3" tabindex="0">
                            <?= htmlspecialchars($promo->getShop()->getName()) ?> Promoción #<?= $promo->getId() ?>
                        </h1>

                        <hr class="mb-4" style="border-top: 2px solid #CC6600; opacity: 0.3;">

                        <section aria-labelledby="details-heading">
                            <h2 id="details-heading" class="h5 font-weight-bold mb-3" tabindex="0">
                                <i class="fas fa-tag text-orange mr-2" aria-hidden="true"></i>
                                Detalles de la promoción
                            </h2>

                            <dl class="row text-secondary mb-4">
                                <dt class="col-sm-4 mb-2 mb-sm-0" tabindex="0">Estado:</dt>
                                <dd class="col-sm-8 text-dark font-weight-bold" tabindex="0">
                                    <?= htmlspecialchars($promo->getStatus()->value) ?>
                                </dd>

                                <dt class="col-sm-4 mb-2 mb-sm-0" tabindex="0">Categoría:</dt>
                                <dd class="col-sm-8 text-dark" tabindex="0">
                                    <?= htmlspecialchars($promo->getUserCategory()->getCategoryType()) ?>
                                </dd>

                                <div class="col-12">
                                    <dl class="row" tabindex="0" aria-label="Válido desde el <?= $promo->getDateFrom()?->format('d/m/Y') ?> hasta el <?= $promo->getDateTo()?->format('d/m/Y') ?>">
                                        <dt class="col-sm-4 mb-2 mb-sm-0">Desde:</dt>
                                        <dd class="col-sm-8 text-dark"><?= $promo->getDateFrom()->format("d/m/Y") ?></dd>

                                        <dt class="col-sm-4 mb-2 mb-sm-0">Hasta:</dt>
                                        <dd class="col-sm-8 text-dark"><?= $promo->getDateTo()->format("d/m/Y") ?></dd>
                                    </dl>
                                </div>
                            </dl>
                        </section>

                        <section class="mb-4" aria-labelledby="days-heading">
                            <h2 id="days-heading" class="h5 font-weight-bold mb-2" tabindex="0">
                                <i class="fas fa-calendar-day text-orange mr-2" aria-hidden="true"></i>
                                Días de validez
                            </h2>
                            <p class="text-secondary mb-0" tabindex="0">
                                <?php
                                $activeDays = [];
                                foreach ($dayLabels as $key => $label) {
                                    if (!empty($promo->getValidDays()[$key])) {
                                        $activeDays[] = $label;
                                    }
                                }
                                echo !empty($activeDays)
                                    ? implode(' · ', $activeDays)
                                    : 'No especificados';
                                ?>
                            </p>
                        </section>

                        <?php if (
                            $promo->getStatus() === PromoStatus_enum::Rechazada &&
                            $promo->getMotivoRechazo() !== null
                        ): ?>
                            <div class="alert alert-danger" role="alert">
                                <strong><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i>Motivo de rechazo:</strong><br>
                                <?= nl2br(htmlspecialchars($promo->getMotivoRechazo())) ?>
                            </div>
                        <?php endif; ?>

                        <section class="description-box mb-5" aria-labelledby="desc-heading">
                            <h2 id="desc-heading" class="h5 font-weight-bold mb-2" tabindex="0">
                                <i class="fas fa-info-circle text-orange mr-2" aria-hidden="true"></i>
                                Descripción
                            </h2>
                            <p class="text-secondary" style="line-height: 1.6;" tabindex="0"> 
                                <?= nl2br(htmlspecialchars($promo->getPromoText())) ?>
                            </p>
                        </section>

                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <a href="javascript:history.back()"
                                class="btn btn-light btn-lg"
                                aria-label="Volver a la página anterior">
                                <i class="fas fa-arrow-left" aria-hidden="true"></i> Volver
                            </a>

                            <?php if ($promo->getStatus() === PromoStatus_enum::Vigente && $user && !$user->isAdmin() && !$user->isOwner()) { ?>
                                <form method="POST" action="<?php echo backendHTTPLayer . '/getPromoCode.http.php'; ?>" class="d-inline">
                                    <input type="hidden" name="promotion_id" value="<?= $promo->getId() ?>">

                                    <button type="submit" class="btn btn-orange btn-lg font-weight-bold shadow-sm" aria-label="Generar código para utilizar esta promoción">
                                        <i class="fas fa-check-circle mr-2" aria-hidden="true"></i>Utilizar promoción
                                    </button>
                                </form>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </article>
    </main>

    <?php include "../components/footer.php" ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script>
        //ARREGLAR BUG DE BREADCRUMB DINAMICO

        const etiqueta = document.getElementById("Detalle-del-Local");
        etiqueta.onclick = function(e) {
            e.preventDefault(); // Evita que el "#" te suba arriba en la página
            window.history.back();
        };
    </script>
</body>

</html>