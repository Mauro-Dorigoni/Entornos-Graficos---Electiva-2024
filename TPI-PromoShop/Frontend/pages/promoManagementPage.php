<?php
require_once __DIR__ . "/../shared/authFunctions.php/admin.auth.function.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";
require_once __DIR__ . "/../../Backend/logic/promotion.controller.php";
require_once __DIR__ . "/../shared/nextcloud.public.php";
require_once __DIR__ . "/../shared/dayLabels.php";
require_once __DIR__ . "/../../Backend/logic/userCategory.controller.php";
require_once __DIR__ . "/../../Backend/logic/ShopType.controller.php";

include "../components/messageModal.php";
include "../components/confirmationModal.php";

$user = $_SESSION['user'];



// 1. Sanitización básica de entradas (Seguridad)
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : '';
$filtroTipoLocal = isset($_GET['f_loc']) ? filter_var($_GET['f_loc'], FILTER_SANITIZE_NUMBER_INT) : '';
$filtroCategoria = isset($_GET['f_cat']) ? filter_var($_GET['f_cat'], FILTER_SANITIZE_NUMBER_INT) : '';

// 2. Obtención de datos
$shopTypes = ShopTypeController::getAll();
$userCategories = UserCategoryController::getAll();

//RECIBE el FILTRO con NOMBRE del Promocion y ID del TIPO Local y ID CATEGORIA.
$p = new Promotion();
$p->setPromoText($search);

$t = new ShopType();
if ($filtroTipoLocal === '') {
    $t->setId(0); //podria ser null
} else {
    $t->setId((int) $filtroTipoLocal);
};

$c = new UserCategory();
if ($filtroCategoria === '') {
    $c->setId(0); //podria ser null
} else {
    $c->setId((int) $filtroCategoria);
};


//Uso un metodo y le paso el ShopName (Shop) - ShopType (id) - UserCategori (id)
$pendingPromotions = PromotionContoller::getAllPendingFilter($p, $t, $c);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Promociones</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #eae8e0 !important;
        }

        main {
            flex: 1;
        }

        .news-card {
            cursor: pointer;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            transition: transform 0.2s;
            border: 1px solid #ddd;
        }

        .news-card:hover {
            transform: scale(1.01);
            background-color: #f9f9f9;
        }

        .text-orange {
            color: #CC6600 !important;
        }

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
            margin-bottom: 12px;
        }

        /* Barra de búsqueda unificada según requerimiento visual */
        .search-wrapper {
            background: white;
            border-radius: 8px;
            display: flex;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .search-wrapper .form-control {
            border: none;
            height: 50px;
            box-shadow: none;
        }

        .btn-unified {
            border: none;
            width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white !important;
            cursor: pointer;
            border-radius: 0;
            /* Puntas no redondeadas entre botones */
            text-decoration: none !important;
        }

        .btn-unified:hover {
            opacity: 0.9;
            text-decoration: none !important;
        }

        .bg-orange-btn {
            background-color: #CC6600 !important;
        }

        .bg-grey-btn {
            background-color: #6c757d !important;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }
    </style>
</head>

<form id="acceptPromotionForm" method="POST"
    action="<?= backendHTTPLayer . '/acceptPromotion.http.php' ?>"
    style="display:none;">
    <input type="hidden" name="promotion_id" id="acceptPromotionId">
</form>

<body>
    <?php include "../components/header.php" ?>
    <?php include "../components/adminNavBar.php" ?>

    <main class="container py-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-4">
                <h1 class="font-weight-bold display-4">Promociones Pendientes</h1>
            </div>
            <div class="col-md-8">
                <form action="promoManagementPage.php" method="GET">
                    <div class="search-wrapper">
                        <input type="text" name="search" class="form-control" placeholder="Buscar..." value="<?= htmlspecialchars($search ?? '') ?>">

                        <?php if ($search || $filtroTipoLocal || $filtroCategoria): ?>
                            <a href="promoManagementPage.php" class="btn-unified bg-orange-btn" title="Limpiar"><i class="fas fa-times"></i></a>
                        <?php endif; ?>

                        <button type="submit" class="btn-unified bg-orange-btn"><i class="fas fa-search"></i></button>
                        <button type="button" class="btn-unified bg-grey-btn" data-toggle="collapse" data-target="#filterBox"><i class="fas fa-filter"></i></button>
                    </div>

                    <div class="collapse mt-3" id="filterBox">
                        <div class="card card-body shadow-sm">
                            <div class="row">
                                <div class="col-md-4"><label class="small font-weight-bold">Categoría</label>
                                    <select name="f_cat" class="form-control">
                                        <option value="">Todas</option>
                                        <?php foreach ($userCategories as $c): ?>
                                            <option value="<?= $c->getId() ?>" <?= ($filtroCategoria == $c->getId()) ? 'selected' : '' ?>><?= $c->getCategoryType() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4"><label class="small font-weight-bold">Tipo Local</label>
                                    <select name="f_loc" class="form-control">
                                        <option value="">Todas</option>
                                        <?php foreach ($shopTypes as $s): ?>
                                            <option value="<?= $s->getId() ?>" <?= ($filtroTipoLocal == $s->getId()) ? 'selected' : '' ?>><?= $s->getType() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="text-right"><button type="submit" class="btn mt-3 text-white font-weight-bold px-4" style="background:#CC6600;">Aplicar Filtros</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php if (empty($pendingPromotions)): ?>
            <div class="alert alert-info text-center">
                No hay promociones pendientes para mostrar.
            </div>
        <?php endif; ?>

        <?php foreach ($pendingPromotions as $promo): ?>
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
                            <?= $promo->getShop()->getName() ?> Promoción #<?= $promo->getId() ?>
                        </h4>
                        <div class="mb-1">
                            <strong>Categoría:</strong>
                            <?= htmlspecialchars($promo->getUserCategory()->getCategoryType()) ?>
                        </div>
                        <p class="mb-0">
                            <?= nl2br(htmlspecialchars($promo->getPromoText())) ?>
                        </p>
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

                    <div class="col-md-1 d-flex flex-column align-items-center action-icons">
                        <a class="text-success"
                            onclick="openAcceptModal(event, <?= $promo->getId() ?>)">
                            <i class="fas fa-check fa-2x"></i>
                        </a>

                        <a class="text-danger"
                            onclick="openRejectModal(event, <?= $promo->getId() ?>)">
                            <i class="fas fa-times fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </main>

    <div class="modal fade" id="rejectActionModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header border-0"
                    style="background-color: #006633; color: white; padding: 1rem 1.5rem;">
                    <img src="../assets/LogoPromoShopFondoVerde.png" alt="PS" style="width: 45px; margin-right: 15px;">
                    <h2 class="modal-title font-weight-bold" id="rejectModalLabel" style="margin: 0; color:#CC6600; font-size: 1.5rem;"> Rechazar Promoción</h2>
                </div>
                <div class="modal-body text-center" style="background-color: #eae8e0; padding: 2.5rem 2rem;">
                    <form method="POST" action="<?= backendHTTPLayer . '/rejectPromotion.http.php' ?>">
                        <input type="hidden" name="promotion_id" id="rejectPromotionId">
                        <p style="font-size: 18px; color: #333; margin-bottom: 1.5rem;">Por favor indique el motivo del rechazo:</p>
                        <textarea name="motivoRechazo" class="form-control mb-4" rows="4" required style="border-radius: 8px; resize: none;"></textarea>
                        <div class="d-flex justify-content-center" style="gap: 15px;">
                            <button type="button" class="btn px-4 py-2 font-weight-bold"  data-dismiss="modal" style="background-color: #6c757d; color: white; border: none; border-radius: 8px;">
                                Cancelar
                            </button>
                            <button type="submit" class="btn px-4 py-2 font-weight-bold" style="background-color: #CC6600; color: white; border: none; border-radius: 8px;">
                                Rechazar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include "../components/footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        function openAcceptModal(event, promotionId) {
            event.stopPropagation();
            event.preventDefault();

            document.getElementById('acceptPromotionId').value = promotionId;

            openConfirmModal(
                '¿Aceptar la promoción <strong>#' + promotionId + '</strong>?',
                '#',
                'Confirmar aprobación'
            );

            const confirmBtn = document.getElementById('confirmModalBtnAction');
            confirmBtn.onclick = function(e) {
                e.preventDefault();
                document.getElementById('acceptPromotionForm').submit();
            };
        }

        function openRejectModal(event, promotionId) {
            event.stopPropagation();
            event.preventDefault();

            document.getElementById('rejectPromotionId').value = promotionId;

            const modal = new bootstrap.Modal(
                document.getElementById('rejectActionModal')
            );
            modal.show();
        }
    </script>

</body>

</html>