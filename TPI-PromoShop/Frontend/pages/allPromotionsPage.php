<?php
require_once __DIR__ . "/../shared/backendRoutes.dev.php";
require_once __DIR__ . "/../../Backend/logic/promotion.controller.php";
require_once __DIR__ . "/../../Backend/logic/shop.controller.php";
require_once __DIR__ . "/../shared/nextcloud.public.php";
require_once __DIR__ . "/../shared/dayLabels.php";
require_once __DIR__ . "/../shared/promoStatusColour.php";
require_once "../../Backend/logic/shopType.controller.php";
require_once "../../Backend/logic/userCategory.controller.php";

include "../components/messageModal.php";
include "../components/confirmationModal.php";



$shopTypes = ShopTypeController::getAll();

$userCategories = UserCategoryController::getAll();

// 1. CAPTURA DE FILTROS Y PAGINACIÓN
$paginaActual = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($paginaActual < 1) $paginaActual = 1;

$f_shopType = isset($_GET['shopType']) ? filter_var($_GET['shopType'], FILTER_SANITIZE_NUMBER_INT) : '';
$f_userCat = isset($_GET['userCategory']) ? filter_var($_GET['userCategory'], FILTER_SANITIZE_NUMBER_INT) : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';


try {
    //solo trae 30, limitamos el no ver todas
    $promotions = PromotionContoller::getAll();

    $totalPromotions = count($promotions);

    // Cantidad por página
    $limit = 10;
    $totalPaginas = ceil($totalPromotions / $limit);
} catch (Exception $e) {
    $promotions = [];
    $totalPaginas = 0;
}


//LOGICA DE FILTRADO. SE HACE A NIVEL DE MEMORIA. POCO EFICIENTE. LAUTARO
// Aplicar el filtro
$promocionesFiltradas = array_filter(
    $promotions, 
    function (Promotion $promo) use ($f_shopType, $f_userCat, $search) {
        //  FILTRO: ShopType 
        // Si el filtro viene con datos, verificamos. Si no, pasamos.
        if ($f_shopType !== '') {
            $shopTypeId = $promo->getShop()->getShopType()->getId();

            // Si el ID no coincide, descartamos esta promo (return false)
            if ($shopTypeId != $f_shopType) {
                return false;
            }
        }

        //  FILTRO 2: UserCategory) 
        if ($f_userCat!== '') {
            $catId = $promo->getUserCategory()->getId();

            if ($catId != $f_userCat) {
                return false;
            }
        }

        //  FILTRO 3: Search
        // Busca coincidencias en el texto de la promo
        if ($search !== '') {
            $promoText = (string) $promo->getPromoText();

            // stripos: Busca sin importar mayúsculas/minúsculas
            // !== false: Significa que encontró el texto
            $encontroEnTexto = stripos($promoText, $search) !== false;

            // Si NO está en el texto, descartar
            if (!$encontroEnTexto) {
                return false;
            }
        }

        // Si pasó todos los "if", la promoción es válida
        return true;
    });

// 3. Reordenar índices (Opcional pero recomendado para JSON o bucles simples)
$promocionesFiltradas = array_values($promocionesFiltradas);


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todas las Promociones</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #eae8e0 !important;
        }

        .text-orange {
            color: #CC6600 !important;
        }

        /* --- BARRA DE BÚSQUEDA ESTILO NOVEDADES --- */
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

        /* --- TARJETAS HORIZONTALES --- */
        .news-card {
            cursor: pointer;
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            transition: transform 0.2s;
        }

        .news-card:hover {
            transform: scale(1.01);
            background-color: #fcfcfc;
        }

        .news-img {
            max-width: 140px;
            border-radius: 4px;
        }

        .info-box {
            border: 1px solid #ccc;
            padding: 5px 10px;
            text-align: center;
            background: #f8f9fa;
            border-radius: 4px;
            min-width: 100px;
        }

        .promo-content-center {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* --- PAGINACIÓN NARANJA --- */
        .page-link {
            color: #CC6600;
            background-color: #fff;
            border: 1px solid #dee2e6;
        }

        .page-link:hover {
            color: #a35200;
            background-color: #fff3e0;
            border-color: #dee2e6;
            text-decoration: none;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #CC6600;
            border-color: #CC6600;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }
    </style>
</head>

<body>
    <?php include "../components/header.php" ?>
    <?php include "../components/navBarByUserType.php" ?>

    <main class="container py-5">

        <div class="row mb-4 align-items-center">
            <div class="col-md-4">
                <h1 class="font-weight-bold display-4">Todas las Promociones</h1>
            </div>
            <div class="col-md-8">
                <form action="" method="GET">
                    <div class="search-wrapper">
                        <input type="text" name="search" class="form-control" placeholder="Buscar promo..." value="<?= htmlspecialchars($search ?? '') ?>">

                        <?php if ($search || $f_shopType || $f_userCat): ?>
                            <a href="?" class="btn-unified bg-orange-btn" title="Limpiar"><i class="fas fa-times"></i></a>
                        <?php endif; ?>

                        <button type="submit" class="btn-unified bg-orange-btn"><i class="fas fa-search"></i></button>
                        <button type="button" class="btn-unified bg-grey-btn" data-toggle="collapse" data-target="#filterBox"><i class="fas fa-filter"></i></button>
                    </div>

                    <div class="collapse mt-3" id="filterBox">
                        <div class="card card-body shadow-sm">
                            <div class="row">

                                <div class="col-md-4">
                                    <label for="type-select" class="font-weight-bold">Categoría Cliente</label>
                                    <select id="type-select" name="userCategory" class="form-control">
                                        <option value="">Todas las categorías</option>
                                        <!-- Lista todos los shopType -->
                                        <?php foreach ($userCategories as $uc): ?>
                                            <option value="<?= $uc->getId(); ?>" <?= ($f_userCat == $uc->getId()) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($uc->getCategoryType()); ?>

                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="type-select" class="font-weight-bold">Tipo Local</label>
                                    <select id="type-select" name="shopType" class="form-control">
                                        <option value="">Todos los Tipos</option>
                                        <!-- Lista todos los shopType -->
                                        <?php foreach ($shopTypes as $shopType): ?>
                                            <option value="<?= $shopType->getId(); ?>" <?= ($f_shopType == $shopType->getId()) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($shopType->getType()); ?>

                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn mt-3 text-white font-weight-bold px-4" style="background:#CC6600;">Aplicar Filtros</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php if (empty($promocionesFiltradas)): ?>
            <div class="alert alert-info text-center">
                No hay promociones que coincidan con tu búsqueda.
            </div>
        <?php endif; ?>

        <?php foreach ($promocionesFiltradas as $promo): ?>
            <div class="news-card" onclick="window.location.href='promoDetailPage.php?id=<?= $promo->getId() ?>'">
                <div class="row align-items-center">

                    <div class="col-md-2 text-center">
                        <img src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($promo->getImageUUID()) ?>" class="img-fluid news-img" alt="Promo">
                    </div>

                    <div class="col-md-5 promo-content-center">
                        <h4 class="h5 font-weight-bold text-orange mb-1">
                            <?= htmlspecialchars($promo->getShop()->getName()) ?> #<?= $promo->getId() ?>
                        </h4>

                        <div class="mb-2">
                            <span class="badge <?= $statusClasses[$promo->getStatus()->value] ?? 'badge-secondary' ?>">
                                <?= htmlspecialchars($promo->getStatus()->value) ?>
                            </span>
                            <span class="text-muted ml-2 small">
                                <i class="fas fa-tag"></i> <?= htmlspecialchars($promo->getUserCategory()->getCategoryType()) ?>
                            </span>
                        </div>

                        <p class="text-muted small mb-1">
                            <?= nl2br(htmlspecialchars(substr($promo->getPromoText(), 0, 120))) ?>...
                        </p>

                        <?php if ($promo->getStatus() === PromoStatus_enum::Rechazada && $promo->getMotivoRechazo()): ?>
                            <div class="text-danger small font-weight-bold mt-1">
                                <i class="fas fa-exclamation-circle"></i> Rechazo: <?= htmlspecialchars(substr($promo->getMotivoRechazo(), 0, 50)) ?>...
                            </div>
                        <?php endif; ?>

                        <div class="mt-1 small text-muted">
                            <?php
                            $activeDays = [];
                            foreach ($dayLabels as $key => $label) {
                                if (!empty($promo->getValidDays()[$key])) $activeDays[] = $label;
                            }
                            echo '<i class="far fa-calendar-alt"></i> ' . implode(' · ', $activeDays);
                            ?>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex justify-content-center flex-column align-items-center">
                        <div class="info-box mb-2 w-75">
                            <small class="d-block font-weight-bold">Desde</small>
                            <span><?= $promo->getDateFrom()?->format('d/m/Y') ?></span>
                        </div>
                        <div class="info-box w-75">
                            <small class="d-block font-weight-bold">Hasta</small>
                            <span><?= $promo->getDateTo()?->format('d/m/Y') ?></span>
                        </div>
                    </div>


                </div>
            </div>
        <?php endforeach; ?>

        <?php if ($totalPaginas > 1): ?>
            <nav aria-label="Navegación de páginas">
                <ul class="pagination justify-content-center">

                    <?php
                    $queryParams = "&search=" . urlencode($search) .
                        "&f_desde=" . urlencode($dateFrom) .
                        "&f_hasta=" . urlencode($dateTo) .
                        "&f_status=" . urlencode($filterStatus);
                    ?>

                    <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $paginaActual - 1 . $queryParams ?>">Anterior</a>
                    </li>

                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?= ($i == $paginaActual) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i . $queryParams ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= ($paginaActual >= $totalPaginas) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $paginaActual + 1 . $queryParams ?>">Siguiente</a>
                    </li>

                </ul>
                <div class="text-center text-muted small mt-2">
                    Página <?= $paginaActual ?> de <?= $totalPaginas ?>
                </div>
            </nav>
        <?php endif; ?>

    </main>



    <?php include "../components/footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</body>

</html>