<?php
require_once "../../Backend/logic/promotion.controller.php";
require_once "../../Backend/structs/promotion.class.php";
require_once __DIR__ . "/../shared/nextcloud.public.php";
require_once __DIR__ . "/../../Backend/shared/promoStatus.enum.php";
require_once __DIR__ . "/../shared/dayLabels.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";

include "../components/messageModal.php";

$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;

$p = new Promotion();
$p->setId($id);
$promo = PromotionContoller::getOne($p);

$user = $_SESSION['user'];

if (!$promo) {
    header("Location landingPageTest.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Promoción - Fisherton Plaza</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { background-color: #eae8e0 !important; min-height: 100vh; }
        .text-orange { color: #CC6600 !important; }

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

        .detail-card { background: white; border-radius: 15px; overflow: hidden; border: none; }
        .img-container { min-height: 300px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; }
        .promo-img { width: 100%; height: 100%; object-fit: cover; }
        .info-section { padding: 40px; }
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
                    <img
                        src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($promo->getImageUUID()) ?>"
                        class="promo-img"
                        alt="Imagen de la promoción"
                    >
                </div>
            </div>

            <div class="col-md-7">
                <div class="info-section">
                    <h1 class="text-orange font-weight-bold display-4">
                       <?= $promo->getShop()->getName() ?> Promoción #<?= $promo->getId() ?>
                    </h1>

                    <hr class="mb-4" style="border-top: 2px solid #CC6600; opacity: 0.3;">

                    <div class="mb-4">
                        <h5 class="font-weight-bold">
                            <i class="fas fa-tag text-orange mr-2"></i>
                            Detalles de la promoción
                        </h5>

                        <p class="text-secondary mb-1">
                            <strong>Estado:</strong>
                            <?= htmlspecialchars($promo->getStatus()->value) ?>
                        </p>

                        <p class="text-secondary mb-1">
                            <strong>Categoria:</strong>
                            <?= htmlspecialchars($promo->getUserCategory()->getCategoryType()) ?>
                        </p>

                        <p class="text-secondary mb-1">
                            <strong>Vigencia desde:</strong>
                            <?= $promo->getDateFrom()->format("d/m/Y") ?>
                        </p>

                        <p class="text-secondary">
                            <strong>Vigencia hasta:</strong>
                            <?= $promo->getDateTo()->format("d/m/Y") ?>
                        </p>
                        <div class="mb-4">
                            <h5 class="font-weight-bold">
                                <i class="fas fa-calendar-day text-orange"></i>
                                Días de validez
                            </h5>

                            <p class="text-secondary mb-0">
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
                        </div>

                    </div>

                    <?php if (
                        $promo->getStatus() === PromoStatus_enum::Rechazada &&
                        $promo->getMotivoRechazo() !== null
                    ): ?>
                        <div class="alert alert-danger">
                            <strong>Motivo de rechazo:</strong><br>
                            <?= nl2br(htmlspecialchars($promo->getMotivoRechazo())) ?>
                        </div>
                    <?php endif; ?>

                    <div class="description-box mb-5">
                        <h5 class="font-weight-bold">
                            <i class="fas fa-info-circle text-orange"></i>
                            Descripción
                        </h5>
                        <p class="text-secondary" style="line-height: 1.6;">
                            <?= nl2br(htmlspecialchars($promo->getPromoText())) ?>
                        </p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="javascript:history.back()" class="btn btn-light btn-lg">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <?php if ($promo->getStatus() === PromoStatus_enum::Vigente && !$user === null && !$user->isAdmin() && !$user->isOwner()) { ?>
                            <form method="POST" action="<?php echo backendHTTPLayer . '/getPromoCode.http.php'; ?>" class="d-inline">
                                <input type="hidden" name="promotion_id" value="<?= $promo->getId() ?>">
                                <button type="submit" id="btn-orange" class="font-weight-bold">
                                    <i class="fas fa-check-circle mr-1"></i>Utilizar promoción
                                </button>
                            </form>
                        <?php } ?>
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
