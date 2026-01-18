<?php
require_once __DIR__ . "/../shared/authFunctions.php/user.auth.function.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";
require_once __DIR__ . "/../../Backend/logic/promotion.controller.php";
require_once __DIR__ . "/../shared/nextcloud.public.php";
require_once __DIR__ . "/../shared/dayLabels.php";
require_once __DIR__ . "/../shared/promoStatusColour.php";
require_once __DIR__ . "/../../Backend/structs/promoUse.class.php";

include "../components/messageModal.php";

try {
    $user = $_SESSION['user'];
    $promoUses = PromotionContoller::getAllUsesByUser();
} catch (Exception $e) {
    echo($e);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis promociones</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { background-color: #eae8e0 !important; }
        .news-card {
            cursor: pointer;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            transition: transform 0.2s;
            border: 1px solid #ddd;
        }
        .news-card:hover { transform: scale(1.01); background-color: #f9f9f9; }
        .text-orange { color: #CC6600 !important; }
        .news-img { max-width: 140px; border-radius: 4px; }
        .info-box {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
            background: #f8f9fa;
            border-radius: 4px;
            min-width: 110px;
        }
    </style>
</head>

<body>
<?php include "../components/header.php" ?>
<?php include "../components/userNavBar.php" ?>

<main class="container py-5">
    <h1 class="display-4 font-weight-bold mb-4">Mis promociones</h1>

    <?php if (empty($promoUses)): ?>
        <div class="alert alert-info text-center">
            No tenés promociones disponibles.
        </div>
    <?php endif; ?>

    <?php foreach ($promoUses as $use): ?>
        <?php $promo = $use->getPromo(); ?>

        <div class="news-card"
             onclick="window.location.href='promoDetailPage.php?id=<?= $promo->getId() ?>'">

            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($promo->getImageUUID()) ?>"
                         class="news-img"
                         alt="Promoción">
                </div>

                <div class="col-md-6">
                    <h4 class="text-orange mb-1">
                        <?= htmlspecialchars($promo->getShop()->getName()) ?>
                        · Promoción #<?= $promo->getId() ?>
                    </h4>

                    <div class="mb-1">
                        <span class="badge <?= $statusClasses[$promo->getStatus()->value] ?? 'badge-secondary' ?>">
                            <?= htmlspecialchars($promo->getStatus()->value) ?>
                        </span>
                    </div>

                    <p class="mb-1">
                        <?= nl2br(htmlspecialchars($promo->getPromoText())) ?>
                    </p>

                    <div class="mt-2">
                        <small class="font-weight-bold">Código:</small>
                        <code><?= htmlspecialchars($use->getUniqueCode()) ?></code>
                    </div>

                    <div class="mt-1">
                        <small class="font-weight-bold">Estado de uso:</small>
                        <?php if ($use->isUsed()): ?>
                            <span class="text-success font-weight-bold">Usada</span>
                        <?php else: ?>
                            <span class="text-warning font-weight-bold">No usada</span>
                        <?php endif; ?>
                    </div>

                    <?php if ($use->getUseDate() !== null): ?>
                        <div class="mt-1">
                            <small class="font-weight-bold">Fecha de uso:</small>
                            <?= $use->getUseDate()->format('d/m/Y H:i') ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($use->getOwner() !== null): ?>
                        <div class="mt-1">
                            <small class="font-weight-bold">Canjeada en local:</small>
                            <?= htmlspecialchars($use->getOwner()->getId() ?? 'Local') ?>
                        </div>
                    <?php endif; ?>

                    <div class="mt-2">
                        <small class="font-weight-bold">Días válidos:</small>
                        <span>
                            <?php
                            $activeDays = [];
                            foreach ($dayLabels as $key => $label) {
                                if (!empty($promo->getValidDays()[$key])) {
                                    $activeDays[] = $label;
                                }
                            }
                            echo implode(' · ', $activeDays);
                            ?>
                        </span>
                    </div>
                </div>

                <div class="col-md-3 d-flex flex-column align-items-center">
                    <div class="info-box mb-2">
                        <strong>Desde</strong><br>
                        <?= $promo->getDateFrom()?->format('d/m/Y') ?>
                    </div>
                    <div class="info-box">
                        <strong>Hasta</strong><br>
                        <?= $promo->getDateTo()?->format('d/m/Y') ?>
                    </div>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
</main>

<?php include "../components/footer.php" ?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
