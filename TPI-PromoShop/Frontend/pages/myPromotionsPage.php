<?php
require_once __DIR__ . "/../shared/authFunctions.php/user.auth.function.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";
require_once __DIR__ . "/../../Backend/logic/promotion.controller.php";
require_once __DIR__ . "/../../Backend/logic/shopType.controller.php";

require_once __DIR__ . "/../shared/nextcloud.public.php";
require_once __DIR__ . "/../shared/dayLabels.php";
require_once __DIR__ . "/../shared/promoStatusColour.php";
require_once __DIR__ . "/../../Backend/structs/promoUse.class.php";

include "../components/messageModal.php";


$search = isset($_GET['search']) ? htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8') : '';
$filtroTipoLocal = isset($_GET['f_loc']) ? filter_var($_GET['f_loc'], FILTER_SANITIZE_NUMBER_INT) : '';
$filtroPromoUse = isset($_GET['f_promoUse']) ? htmlspecialchars($_GET['f_promoUse'], ENT_QUOTES, 'UTF-8') : '';

//promoUse puede ser Usada o Pendiente

try {
    $shopTypes = ShopTypeController::getAll();
    $t = new ShopType();
    if ($filtroTipoLocal === '') {
        $t = null; //podria ser null
    } else {
        $t->setId((int) $filtroTipoLocal);
    };

    $user = $_SESSION['user']; //ya debe estar logeado por la authFunctions.

    //Filtrar por tipo de local y por si esta o no usado. - Se puede hacer con 
    $promoUses = PromotionContoller::getAllUsesByUser($user, $t, $filtroPromoUse, $search);
} catch (Exception $e) {
    echo ($e);
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


    <style>
        body {
            background-color: #eae8e0 !important;
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

<body>
    <?php include "../components/header.php" ?>
    <?php include "../components/userNavBar.php" ?>

    <main class="container py-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-4">
                <h1 class="font-weight-bold display-4">Mis Promociones</h1>
            </div>
            <div class="col-md-8">
                <form action="myPromotionsPage.php" method="GET">
                    <div class="search-wrapper">
                        <input type="text" name="search" class="form-control" placeholder="Buscar..." value="<?= htmlspecialchars($search ?? '') ?>">

                        <?php if ($filtroTipoLocal || $filtroPromoUse || $search): ?>
                            <a href="myPromotionsPage.php" class="btn-unified bg-orange-btn" title="Limpiar"><i class="fas fa-times"></i></a>
                        <?php endif; ?>

                        <button type="submit" class="btn-unified bg-orange-btn"><i class="fas fa-search"></i></button>
                        <button type="button" class="btn-unified bg-grey-btn" data-toggle="collapse" data-target="#filterBox"><i class="fas fa-filter"></i></button>
                    </div>

                    <div class="collapse mt-3" id="filterBox">
                        <div class="card card-body shadow-sm">
                            <div class="row">
                                <div class="col-md-4"><label class="small font-weight-bold">Estado</label>
                                    <select name="f_promoUse" class="form-control">
                                        <option value="">Todas</option>
                                        <option value="Usada" <?= ($filtroPromoUse == "Usada") ? 'selected' : '' ?>>Usada</option>
                                        <option value="Pendiente" <?= ($filtroPromoUse == "Pendiente") ? 'selected' : '' ?>>Pendiente</option>
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