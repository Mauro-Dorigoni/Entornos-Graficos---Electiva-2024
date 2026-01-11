<?php
require_once __DIR__ . "/../shared/authFunctions.php/owner.auth.function.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";
require_once __DIR__ . "/../../Backend/logic/promotion.controller.php";
require_once __DIR__ . "/../../Backend/logic/shop.controller.php";
require_once __DIR__ . "/../shared/nextcloud.public.php";
require_once __DIR__ . "/../shared/dayLabels.php";
require_once __DIR__ . "/../shared/promoStatusColour.php";

include "../components/messageModal.php";
include "../components/confirmationModal.php";

try {
    $owner = $_SESSION['user'];
    $shop = new Shop();
    $shop = ShopController::getOneByOwner($owner);
    $promotions = PromotionContoller::getAllByShop($shop);
} catch (Exception $e) {
    $promotions = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promociones</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #eae8e0 !important;
        }
        .news-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            border: 1px solid #ddd;
        }
        .text-orange { color: #CC6600 !important; }
        .news-img {
            max-width: 140px;
            border-radius: 4px;
        }
        .info-box {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
            background: #f8f9fa;
            border-radius: 4px;
            min-width: 110px;
        }
        .action-icons a {
            cursor: pointer;
        }
    </style>
</head>

<body>
<?php include "../components/header.php" ?>
<?php include "../components/ownerNavBar.php" ?>

<main class="container py-5">
    <h1 class="display-4 font-weight-bold mb-4">Promociones</h1>

    <?php if (empty($promotions)): ?>
        <div class="alert alert-info text-center">
            No hay promociones para mostrar.
        </div>
    <?php endif; ?>

    <?php foreach ($promotions as $promo): ?>
        <div class="news-card">
            <div class="row align-items-center">

                <div class="col-md-2 text-center">
                    <img src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($promo->getImageUUID()) ?>"
                         class="news-img"
                         alt="Promoción">
                </div>

                <div class="col-md-6">
                    <h4 class="text-orange mb-1">
                        Promoción #<?= $promo->getId() ?>
                    </h4>

                    <div class="mb-1">
                        <span class="badge <?= $statusClasses[$promo->getStatus()->value] ?? 'badge-secondary' ?>">
                            <?= htmlspecialchars($promo->getStatus()->value) ?>
                        </span>
                    </div>

                    <div class="mb-1">
                        <strong>Categoría:</strong>
                        <?= htmlspecialchars($promo->getUserCategory()->getCategoryType()) ?>
                    </div>

                    <p class="mb-0">
                        <?= nl2br(htmlspecialchars($promo->getPromoText())) ?>
                    </p>

                    <?php if (
                        $promo->getStatus() === PromoStatus_enum::Rechazada &&
                        $promo->getMotivoRechazo() !== null
                    ): ?>
                        <div class="alert alert-danger mt-2 mb-2 p-2">
                            <small class="font-weight-bold d-block mb-1">
                                Motivo del rechazo:
                            </small>
                            <small>
                                <?= nl2br(htmlspecialchars($promo->getMotivoRechazo())) ?>
                            </small>
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

                <div class="col-md-1 d-flex justify-content-center action-icons">
                    <a class="text-danger"
                       onclick="openDeleteModal(<?= $promo->getId() ?>)">
                        <i class="fas fa-trash fa-2x"></i>
                    </a>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
</main>

<!-- FORM OCULTO DELETE -->
<form id="deletePromotionForm"
      method="POST"
      action="<?= backendHTTPLayer . '/deletePromotion.http.php' ?>"
      style="display:none;">
    <input type="hidden" name="promotion_id" id="deletePromotionId">
</form>

<?php include "../components/footer.php" ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
function openDeleteModal(promotionId) {
    document.getElementById('deletePromotionId').value = promotionId;

    openConfirmModal(
        '¿Eliminar la promoción <strong>#' + promotionId + '</strong>?<br><small>Esta acción no se puede deshacer.</small>',
        '#',
        'Confirmar eliminación'
    );

    const confirmBtn = document.getElementById('confirmModalBtnAction');
    confirmBtn.onclick = function (e) {
        e.preventDefault();
        document.getElementById('deletePromotionForm').submit();
    };
}
</script>

</body>
</html>
