<?php
require_once "../../Backend/structs/user.class.php";
require_once "../../Backend/logic/shop.controller.php";
require_once "../../Backend/logic/promotion.controller.php";
require_once __DIR__ . "/../shared/nextcloud.public.php";
require_once __DIR__ . "/../../Backend/logic/news.controller.php";

require_once "../shared/UserType.enum.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//0:no log. - 1: user - 2:admin - 3: owner -
//LOCALES
//Despues se cambia tarjeta_1["url"][3] por la url de "Mi local"
$tarjeta_1 = [
    "iconos" => ["fas fa-shopping-bag", "fas fa-shopping-bag", "fas fa-shopping-bag", "fas fa-shopping-bag"],
    "titulos" => ["Locales", "Locales", "Locales", "Mi Local"],
    "descripcion" => ["Descubre las mejores marcas y tiendas.", "Descubre las mejores marcas y tiendas.", "Gestione el listado de locales.", "Gestiona la información de tu marca."],
    "url" => ["shopsCardsPage.php", "shopsCardsPage.php", "shopsCardsPage.php", "shopsCardsPage.php"],
    "boton" => ["Ver Todos", "Ver Todos", "Ver Todos", "Ver"]
];
//PROMOCIONES
$tarjeta_2 = [
    "iconos" => ["fas fa-percentage", "fas fa-percentage", "fas fa-percentage", "fas fa-percentage"],
    "titulos" => ["Promociones", "Mis Promociones", "Promociones", "Mis Promociones"],
    "descripcion" => ["Todas las promociones de nuestro shopping.", "Gestiona tus promociones seleccionadas.", "Ingrese al panel de gestión de promociones", "Gestione las promociones del local."],
    "url" => ["allPromotionsPage.php", "myPromotionsPage.php", "promoManagementPage.php", "allShopPromotionsPage.php"],
    "boton" => ["Ver Todas", "Ver Todas", "Ver Todas", "Ver Todas"]
];

//PONER PARA EL Promociones tarjeta_2 [0] una pag que liste todas las promociones. TODO - LAUTARO

$tarjeta_3 = [
    "iconos" => ["fas fa-user", "fas fa-newspaper", "fas fa-newspaper", "fas fa-ticket-alt"],
    "titulos" => ["Iniciar Sesión", "Novedades", "Novedades", "Canje de Promo"],
    "descripcion" => ["Comience a utilizar Tu Shopping", "Mantente al día con el listado de novedades.", "Gestione las novedades.", "Valida el codigo de una promoción."],
    "url" => ["loginPage.php", "newsPage.php", "newsPage.php", "promotionValidationPage.php"],
    "boton" => ["Ingresar", "Ver Todas", "Ver Todas", "Canjear"]
];

$indice = 0;

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    $userType = $_SESSION["userType"];

    if ($user != null && $userType === UserType_enum::Admin) {
        $indice = 2;
    } elseif ($user != null && $userType === UserType_enum::Owner) {
        $indice = 3;
        if ($user != null && $userType == UserType_enum::Owner) {
            //buscamos los atributos del shop.
            $shop = ShopController::getOneByOwner($user);
            $idShop = $shop->getId();
            $urlShop = "shopDetailPage.php?id=" . $idShop;
        } else {
            //no debería entrar nunca aca....
            $urlShop = "shopsCardsDetail.php";
        }
        $tarjeta_1["url"][3] = $urlShop;
    } elseif ($user != null && $userType === UserType_enum::User) {
        $indice = 1;
        //buscamos las novedades
        $novedades = NewsController::getFilteredNews($user, null, null, null, null);
        //limitamos la cantidad a 4 cortando el array (en memoria traemos todo. poco optimo, lautaro.)
        $novedadesResumen = array_slice($novedades, 0, 4);
    }
}

//BUSCAMOS TODAS LAS NOVEDADES
$allPromos = [];
$chunks = [];
$limit = 15;
$allPromos = PromotionContoller::getAll($limit);
if (!empty($allPromos)) {
    $chunks = array_chunk($allPromos, 3);
}



?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Shopping</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <style>
        /* Estilos Personalizados */
        body {
            background-color: #eae8e0 !important;
        }
        /* BOTÓN NARANJA */
        .btn-orange {
            background-color: #ff8c00 !important;
            color: white !important;
            border-color: #ff8c00 !important;
            font-weight: bold !important;
            transition: transform 0.2s;
        }

        .btn-orange:hover {
            background-color: #e07b00 !important;
            color: white !important;
            transform: scale(1.05);
        }

        /* TARJETAS DE CATEGORÍA */
        .cat-card {
            border: none;
            border-radius: 12px;
            background: white;
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
        }

        .cat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            border-bottom: 4px solid #ff8c00;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background-color: #fff3e0;
            /* Naranja muy clarito */
            color: #ff8c00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 15px auto;
        }

        /* Ajuste para solapar el contenido sobre el banner */
        .overlap-container {
            margin-top: -80px;
            /* Sube las tarjetas sobre la foto */
            position: relative;
            z-index: 10;
        }

        /* ESTILOS CARRUSEL NOVEDADES */
        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
            /* Hacemos las flechas más angostas para no tapar contenido */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #ff8c00;
            /* Flechas naranjas */
            border-radius: 50%;
            padding: 20px;
            background-size: 60% 60%;
            /* Ajuste del icono dentro del circulo */
        }

        .card-novedad {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            height: 100%;
            /* Para que todas midan lo mismo */
        }

        .card-novedad:hover {
            transform: translateY(-5px);
        }

        .card-novedad img {
            height: 200px;
            /* Altura fija para la imagen */
            object-fit: cover;
            /* Recorte inteligente */
            width: 100%;
        }

        .card-novedad .card-body {
            background-color: #fff;
            border-top: 4px solid #ff8c00;
        }

        /* Estilo de los indicadores (las linitas) */
        .carousel-indicators li {
            background-color: #ff8c00;
            /* Naranja base */
            width: 30px;
            /* Largo de la línea */
            height: 4px;
            /* Grosor de la línea */
            border-radius: 2px;
            opacity: 0.5;
            /* Un poco transparentes las inactivas */
        }

        .carousel-indicators .active {
            background-color: #cc7000;
            /* Naranja más oscuro para la activa */
            opacity: 1;
            /* Totalmente visible */
            width: 40px;
            /* Un poquito más larga la activa (efecto visual lindo) */
        }

        .news-card-summary {
            cursor: pointer;
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .news-card-summary:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: #fcfcfc;
        }

        .text-orange {
            color: #CC6600 !important;
        }

        .btn-outline-orange {
            color: #CC6600;
            border-color: #CC6600;
            font-weight: bold;
        }

        .btn-outline-orange:hover {
            background-color: #CC6600;
            color: white;
        }

        .user-info-badge {
            background-color: #fff3e0;
            color: #CC6600;
            border: 1px solid #CC6600;
            border-radius: 50px;
            padding: 5px 20px;
            display: inline-block;
            margin-top: 10px;
        }

        .cat-card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        
        h4.card-title,
        h4.font-weight-bold {
            font-size: 1.25rem;
        }
    </style>
</head>

<body>

    <?php include "../components/header.php" ?>

    <?php include "../components/navBarByUserType.php" ?>

    <div class="position-relative d-flex   justify-content-center text-center" style="height: 75vh; overflow: hidden; padding-top: 15vh;">

        <img src="https://static.wixstatic.com/media/290684_bee75ee23dd9460c9e87f6a2286eeab6~mv2.png/v1/fill/w_1920,h_1080,al_c/290684_bee75ee23dd9460c9e87f6a2286eeab6~mv2.png"
            alt="Imagen de Fondo Shopping. Decorativa"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1;">

        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2;
                    background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.3) 70%, rgba(0,0,0,0.7) 100%);">
        </div>

        <div class="container position-relative" style="z-index: 3;">
            <div class="row justify-content-center">
                <div class="col-md-8 text-white">

                    <h1 class="display-4 font-weight-bold mb-3" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.6);">
                        Tu Shopping Favorito
                    </h1>
                    <p class="lead mb-5" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.6);">
                        Encuentra locales, gastronomía y entretenimiento en un solo lugar.
                    </p>

                    <!-- BARRA DE BUSQUEDA. No la implementamos aca. LAUTARO -->
                    <!-- <form action="shopsCardsPage.php" method="GET">
                        <div class="input-group input-group-lg shadow-lg" style="border-radius: 50px; overflow: hidden;">
                            <input type="text" name="q" class="form-control border-0 pl-4" placeholder="Buscar local, comida o servicio...">
                            <div class="input-group-append">
                                <button class="btn btn-orange px-4" type="submit">
                                    <i class="fas fa-search mr-2"></i> BUSCAR
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- <div class="mt-4">
                        <small class="mr-2">Sugerencias:</small>
                        <a href="shopsCardsPage.php?cat=Ropa" class="badge badge-light text-dark p-2 mx-1">Ropa</a>
                        <a href="shopsCardsPage.php?cat=Comida" class="badge badge-light text-dark p-2 mx-1">Comida</a>
                        <a href="shopsCardsPage.php?cat=Cine" class="badge badge-light text-dark p-2 mx-1">Cine</a>
                    </div> -->

                </div>
            </div>
        </div>
    </div>

    <div class="bg-light pb-5">
        <div class="container overlap-container">
            <div class="row">

                <div class="col-md-4 mb-4">
                    <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                        <div class="icon-circle">
                            <i class="<?= $tarjeta_1["iconos"][$indice] ?>"></i>
                        </div>
                        <h2 class="cat-card-title"><?= $tarjeta_1["titulos"][$indice] ?></h2>
                        <p class="text-muted small"><?= $tarjeta_1["descripcion"][$indice] ?></p>
                        <a href="<?= $tarjeta_1["url"][$indice] ?>" class="btn  btn-orange btn-sm rounded-pill mt-auto mx-auto px-4"><?= $tarjeta_1["boton"][$indice] ?></a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                        <div class="icon-circle">
                            <i class="<?= $tarjeta_2["iconos"][$indice] ?>"></i>
                        </div>
                        <h2 class="cat-card-title"><?= $tarjeta_2["titulos"][$indice] ?></h2>
                        <p class="text-muted small"><?= $tarjeta_2["descripcion"][$indice] ?></p>
                        <a href="<?= $tarjeta_2["url"][$indice] ?>" class="btn  btn-orange btn-sm rounded-pill mt-auto mx-auto px-4"><?= $tarjeta_2["boton"][$indice] ?></a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                        <div class="icon-circle">
                            <i class="<?= $tarjeta_3["iconos"][$indice] ?>"></i>
                        </div>
                        <h2 class="cat-card-title"><?= $tarjeta_3["titulos"][$indice] ?></h2>
                        <p class="text-muted small"><?= $tarjeta_3["descripcion"][$indice] ?></p>
                        <a href="<?= $tarjeta_3["url"][$indice] ?>" class="btn  btn-orange btn-sm rounded-pill mt-auto mx-auto px-4"><?= $tarjeta_3["boton"][$indice] ?></a>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- CARRUSEL DE PROMOCIONES -->
    <!-- <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold">Últimas <span style="color: #ff8c00;">Novedades</span></h2>
            <p class="text-muted">Descubre las promociones destacadas</p>
        </div>

        <?php if (!empty($chunks)): ?>
            <div id="carouselNews" class="carousel slide carousel-fade" data-ride="carousel">
                <ol class="carousel-indicators" style="bottom: -40px;"> <?php foreach ($chunks as $index => $group): ?>
                        <li data-target="#carouselNews"
                            data-slide-to="<?= $index ?>"
                            class="<?= $index === 0 ? 'active' : '' ?>">
                        </li>
                    <?php endforeach; ?>
                </ol>
                <div class="carousel-inner px-4"> <?php foreach ($chunks as $index => $group): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="row">
                                <?php foreach ($group as $promo): ?>
                                    <?php
                                                            // Validación segura de datos
                                                            $img = NEXTCLOUD_PUBLIC_BASE . urlencode($promo->getImageUUID());
                                                            $shopName = $promo->getShop() ? $promo->getShop()->getName() : 'Promo';
                                                            $desc = $promo->getPromoText();
                                    ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card card-novedad h-100">
                                            <img src="<?= $img ?>" class="card-img-top" alt="Promo">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title font-weight-bold" style="color: #ff8c00;">
                                                    <?= htmlspecialchars($shopName) ?>
                                                </h5>
                                                <p class="card-text text-muted small flex-grow-1">
                                                    <?= htmlspecialchars(substr($desc, 0, 80)) ?>...
                                                </p>
                                                <a href="promoDetailPage.php?id=<?= $promo->getId() ?>" class="btn btn-outline-warning btn-sm btn-block mt-3" style="border-color: #ff8c00; color: #ff8c00; font-weight: bold;">
                                                    Ver Detalle
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>


                </div>

                <?php if (count($chunks) > 1): ?>
                    <a class="carousel-control-prev" href="#carouselNews" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselNews" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Siguiente</span>
                    </a>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <div class="alert alert-light text-center border">
                No hay novedades para mostrar en este momento.
            </div>
        <?php endif; ?>
    </div> -->

    <div class="container py-5 px-5">
        <div class="text-center mb-5">
            <h2 class="font-weight-bold">Últimas <span style="color: #ff8c00;">Promociones</span></h2>
            <p class="text-muted">Descubre las promociones destacadas</p>
        </div>

        <?php if (!empty($chunks)): ?>
            <?php
            // 1. CALCULOS PREVIOS
            // Obtenemos el último grupo para saber si está lleno
            $lastChunk = end($chunks);
            // Si el último grupo tiene 3 elementos, necesitamos un slide extra para la tarjeta final
            $needsExtraSlide = (count($lastChunk) === 3);
            // Total de slides actuales
            $totalSlides = count($chunks);
            ?>

            <div id="carouselNews" class="carousel slide carousel-fade" data-ride="carousel">

                <ol class="carousel-indicators" style="bottom: -40px;">
                    <?php foreach ($chunks as $index => $group): ?>
                        <li data-target="#carouselNews"
                            data-slide-to="<?= $index ?>"
                            class="<?= $index === 0 ? 'active' : '' ?>">
                        </li>
                    <?php endforeach; ?>

                    <?php if ($needsExtraSlide): ?>
                        <li data-target="#carouselNews" data-slide-to="<?= $totalSlides ?>"></li>
                    <?php endif; ?>
                </ol>

                <div class="carousel-inner px-4">
                    <?php foreach ($chunks as $index => $group): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="row">

                                <?php foreach ($group as $promo): ?>
                                    <?php
                                    $img = defined('NEXTCLOUD_PUBLIC_BASE') ? NEXTCLOUD_PUBLIC_BASE . urlencode($promo->getImageUUID()) : '';
                                    $shopName = $promo->getShop() ? $promo->getShop()->getName() : 'Promo';
                                    $desc = $promo->getPromoText();
                                    ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card card-novedad h-100">
                                            <img src="<?= $img ?>" class="card-img-top" alt="Promo">
                                            <div class="card-body d-flex flex-column">
                                                <h4 class="card-title font-weight-bold" style="color: #ff8c00;">
                                                    <?= htmlspecialchars($shopName) ?>
                                                </h4>
                                                <p class="card-text text-muted small flex-grow-1">
                                                    <?= htmlspecialchars(substr($desc, 0, 80)) ?>...
                                                </p>
                                                <a href="promoDetailPage.php?id=<?= $promo->getId() ?>" class="btn btn-outline-warning btn-sm btn-block mt-3" style="border-color: #ff8c00; color: #ff8c00; font-weight: bold;">
                                                    Ver Detalle
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <?php
                                $isLastSlide = ($index === $totalSlides - 1);
                                $itemsInThisSlide = count($group);
                                ?>

                                <?php if ($isLastSlide && $itemsInThisSlide < 3): ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card card-novedad h-100 text-center"
                                            style="cursor: pointer; border: 1px solid #ff8c00;"
                                            onclick="window.location.href='allPromotionsPage.php'">
                                            <div class="d-flex justify-content-center align-items-center w-100"
                                                style="height: 180px; background-color: #fff3e0; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                                <i class="fas fa-plus fa-4x" style="color: #ff8c00;"></i>
                                            </div>
                                            <div class="card-body d-flex flex-column justify-content-center">
                                                <h4 class="font-weight-bold mt-2" style="color: #ff8c00;">Ver Todo</h4>
                                                <p class="text-muted small">Explora todas las promociones.</p>
                                                <a href="allPromotionsPage.php" class="btn btn-orange btn-sm rounded-pill mt-auto px-4">Ir al Catálogo</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div> <?php endforeach; ?>

                    <?php if ($needsExtraSlide): ?>
                        <!-- ACA TE MANDA A NOVEDADES.   -->
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card card-novedad h-100 text-center"
                                        style="cursor: pointer; border: 1px solid #ff8c00;"
                                        onclick="window.location.href='allPromotionsPage.php'">
                                        <div class="d-flex justify-content-center align-items-center w-100"
                                            style="height: 180px; background-color: #fff3e0; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                            <i class="fas fa-plus fa-4x" style="color: #ff8c00;"></i>
                                        </div>
                                        <div class="card-body d-flex flex-column justify-content-center">
                                            <h4 class="font-weight-bold mt-2" style="color: #ff8c00;">Ver Todo</h4>
                                            <p class="text-muted small">Explora todas las promociones.</p>
                                            <a href="allPromotionsPage.php" class="btn btn-orange btn-sm rounded-pill mt-auto px-4">Ir al Catálogo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                <!-- CONTROLES. PREFIERO SACARLOS, MOLESTAN VISUALMENTE. LAUTARO -->
                <!-- <?php if (count($chunks) > 1 || $needsExtraSlide): ?>
                    <a class="carousel-control-prev" href="#carouselNews" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon shadow" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselNews" role="button" data-slide="next">
                        <span class="carousel-control-next-icon shadow" aria-hidden="true"></span>
                        <span class="sr-only">Siguiente</span>
                    </a>
                <?php endif; ?> -->
            </div>

        <?php else: ?>
            <div class="alert alert-light text-center border">
                No hay promociones para mostrar en este momento.
            </div>
        <?php endif; ?>
    </div>

    <!-- NOVEDADES - Solo las mostramos si es un cliente logueado -->
    <?php if ($indice === 1): ?>
        <div class="bg-light">
            <div class="container px-5">
                <div class="text-center mb-5 pt-5">
                    <h2 class="font-weight-bold">Mis <span style="color: #ff8c00;">Novedades</span></h2>
                    <p class="text-muted">Mantente informado de las últimas novedades publicadas.</p>
                    <?php if ($user): ?>
                        <div class="user-info-badge">
                            <i class="fas fa-user-circle mr-2"></i>
                            <strong><?= htmlspecialchars($user->getEmail()) ?></strong>
                            <span class="mx-2">|</span>
                            Categoría: <strong><?= htmlspecialchars($user->getUserCategory()?->getCategoryType()) ?></strong>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php if (empty($novedadesResumen)): ?>
                            <div class="alert alert-light text-center border shadow-sm">
                                No hay novedades recientes para mostrar en tu categoría.
                            </div>
                        <?php else: ?>
                            <?php foreach ($novedadesResumen as $news): ?>
                                <div class="news-card-summary" onclick="window.location.href='newsDetailPage.php?id=<?= $news->getId() ?>'">
                                    <div class="row align-items-center">

                                        <div class="col-md-2 text-center mb-3 mb-md-0">
                                            <?php
                                            $imgUrl = defined('NEXTCLOUD_PUBLIC_BASE') ? NEXTCLOUD_PUBLIC_BASE . urlencode($news->getImageUUID()) : 'https://via.placeholder.com/150';
                                            ?>
                                            <img src="<?= $imgUrl ?>" class="img-fluid rounded" style="max-height: 100px; width: auto;" alt="Imagen Novedad">
                                        </div>

                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <h4 class="font-weight-bold text-orange mb-1">
                                                Novedad #<?= $news->getId() ?>
                                            </h4>
                                            <p class="text-muted mb-0">
                                                <?= htmlspecialchars(substr($news->getNewsText(), 0, 110)) ?>...
                                            </p>
                                        </div>

                                        <div class="col-md-3 text-center mb-3 mb-md-0">
                                            <div class="bg-light rounded p-2 border">
                                                <small class="d-block text-muted">Vigencia:</small>
                                                <strong><?= date("d/m/y", strtotime($news->getDateFrom())) ?></strong>
                                                al
                                                <strong><?= $news->getDateTo() ? date("d/m/y", strtotime($news->getDateTo())) : '∞' ?></strong>
                                            </div>
                                        </div>

                                        <div class="col-md-3 text-center">
                                            <span class="badge badge-warning text-white p-2" style="background-color: #CC6600; font-size: 0.9rem;">
                                                <?= htmlspecialchars($news->getUserCategory()->getCategoryType()) ?>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mt-4 pb-5">
                    <div class="col-12 text-center">
                        <a href="newsPage.php" class="btn btn-orange btn-lg rounded-pill px-5">
                            Ver más Novedades <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php include "../components/footer.php" ?>
    <?php include "../components/messageModal.php" ?>

</body>

</html>