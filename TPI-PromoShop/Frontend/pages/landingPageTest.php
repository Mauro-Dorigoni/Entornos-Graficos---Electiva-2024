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

$tarjeta_1 = [
    "iconos" => ["fas fa-shopping-bag", "fas fa-shopping-bag", "fas fa-shopping-bag", "fas fa-shopping-bag"],
    "titulos" => ["Locales", "Locales", "Locales", "Mi Local"],
    "descripcion" => ["Descubre las mejores marcas y tiendas.", "Descubre las mejores marcas y tiendas.", "Gestione el listado de locales.", "Gestiona la información de tu marca."],
    "url" => ["shopsCardsPage.php", "shopsCardsPage.php", "shopsCardsPage.php", "shopsCardsPage.php"],
    "boton" => ["Ver Todos", "Ver Todos", "Ver Todos", "Ver"]
];

$tarjeta_2 = [
    "iconos" => ["fas fa-percentage", "fas fa-percentage", "fas fa-percentage", "fas fa-percentage"],
    "titulos" => ["Promociones", "Mis Promociones", "Promociones", "Mis Promociones"],
    "descripcion" => ["Todas las promociones de nuestro shopping.", "Gestiona tus promociones seleccionadas.", "Ingrese al panel de gestión de promociones", "Gestione las promociones del local."],
    "url" => ["allPromotionsPage.php", "myPromotionsPage.php", "promoManagementPage.php", "allShopPromotionsPage.php"],
    "boton" => ["Ver Todas", "Ver Todas", "Ver Todas", "Ver Todas"]
];

$tarjeta_3 = [
    "iconos" => ["fas fa-user", "fas fa-newspaper", "fas fa-newspaper", "fas fa-ticket-alt"],
    "titulos" => ["Iniciar Sesión", "Novedades", "Novedades", "Canje de Promo"],
    "descripcion" => ["Comience a utilizar Tu Shopping", "Mantente al día con el listado de novedades.", "Gestione las novedades.", "Valida el codigo de una promoción."],
    "url" => ["loginPage.php", "newsPage.php", "newsPage.php", "promotionValidationPage.php"],
    "boton" => ["Ingresar", "Ver Todas", "Ver Todas", "Canjear"]
];

$indice = 0;
$novedadesResumen = [];
$user = null;

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    $userType = $_SESSION["userType"];

    if ($user != null && $userType === UserType_enum::Admin) {
        $indice = 2;
    } elseif ($user != null && $userType === UserType_enum::Owner) {
        $indice = 3;
        $shop = ShopController::getOneByOwner($user);
        $idShop = $shop ? $shop->getId() : 0;
        $urlShop = $shop ? "shopDetailPage.php?id=" . $idShop : "shopsCardsDetail.php";
        $tarjeta_1["url"][3] = $urlShop;
    } elseif ($user != null && $userType === UserType_enum::User) {
        $indice = 1;
        $novedades = NewsController::getFilteredNews($user, null, null, null, null);
        $novedadesResumen = array_slice($novedades, 0, 4);
    }
}

$limit = 15;
$allPromos = PromotionContoller::getAll($limit);
$chunks = !empty($allPromos) ? array_chunk($allPromos, 3) : [];
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
        /* Corrección: Background con unidad y color */
        body { background-color: #eae8e0 !important; }
        
        /* Estilos generales */
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
            width: 70px; height: 70px;
            background-color: #fff3e0;
            color: #ff8c00;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin: 0 auto 15px auto;
        }
        .overlap-container { margin-top: -80px; position: relative; z-index: 10; }
        .card-novedad {
            border: none; border-radius: 15px; overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s; height: 100%;
        }
        .card-novedad:hover { transform: translateY(-5px); }
        .card-novedad img { height: 200px; object-fit: cover; width: 100%; }
        .card-novedad .card-body { background-color: #fff; border-top: 4px solid #ff8c00; }
        
        .carousel-indicators li {
            background-color: #ff8c00; width: 30px; height: 4px;
            border-radius: 2px; opacity: 0.5;
        }
        .carousel-indicators .active { background-color: #cc7000; opacity: 1; width: 40px; }
        
        .news-card-summary {
            cursor: pointer; background: white; border-radius: 8px;
            padding: 1.5rem; margin-bottom: 1rem; border: 1px solid #ddd;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .news-card-summary:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: #fcfcfc;
        }
        .text-orange { color: #CC6600 !important; }
        .user-info-badge {
            background-color: #fff3e0; color: #CC6600;
            border: 1px solid #CC6600; border-radius: 50px;
            padding: 5px 20px; display: inline-block; margin-top: 10px;
        }

        /* Estilos extraídos de otras partes del código para evitar etiquetas <style> en el body */
        *:focus-visible { outline: 2px solid #e606ff; } 
    </style>
</head>

<body>
    <?php include "../components/header.php" ?>
    <?php include "../components/navBarByUserType.php" ?>

    <header class="position-relative d-flex justify-content-center text-center" style="height: 75vh; overflow: hidden; padding-top: 15vh;">
        <img src="https://static.wixstatic.com/media/290684_bee75ee23dd9460c9e87f6a2286eeab6~mv2.png/v1/fill/w_1920,h_1080,al_c/290684_bee75ee23dd9460c9e87f6a2286eeab6~mv2.png"
            alt="Fondo Shopping"
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
                </div>
            </div>
        </div>
    </header>

    <main class="bg-light pb-5">
        <div class="container overlap-container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                        <div class="icon-circle"><i class="<?= $tarjeta_1["iconos"][$indice] ?>"></i></div>
                        <h2 class="h4 font-weight-bold"><?= $tarjeta_1["titulos"][$indice] ?></h2>
                        <p class="text-muted small"><?= $tarjeta_1["descripcion"][$indice] ?></p>
                        <a href="<?= $tarjeta_1["url"][$indice] ?>" class="btn btn-orange btn-sm rounded-pill mt-auto mx-auto px-4"><?= $tarjeta_1["boton"][$indice] ?></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                        <div class="icon-circle"><i class="<?= $tarjeta_2["iconos"][$indice] ?>"></i></div>
                        <h2 class="h4 font-weight-bold"><?= $tarjeta_2["titulos"][$indice] ?></h2>
                        <p class="text-muted small"><?= $tarjeta_2["descripcion"][$indice] ?></p>
                        <a href="<?= $tarjeta_2["url"][$indice] ?>" class="btn btn-orange btn-sm rounded-pill mt-auto mx-auto px-4"><?= $tarjeta_2["boton"][$indice] ?></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                        <div class="icon-circle"><i class="<?= $tarjeta_3["iconos"][$indice] ?>"></i></div>
                        <h2 class="h4 font-weight-bold"><?= $tarjeta_3["titulos"][$indice] ?></h2>
                        <p class="text-muted small"><?= $tarjeta_3["descripcion"][$indice] ?></p>
                        <a href="<?= $tarjeta_3["url"][$indice] ?>" class="btn btn-orange btn-sm rounded-pill mt-auto mx-auto px-4"><?= $tarjeta_3["boton"][$indice] ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container py-5 px-5">
            <div class="text-center mb-5">
                <h2 class="font-weight-bold">Últimas <span style="color: #ff8c00;">Promociones</span></h2>
                <p class="text-muted">Descubre las promociones destacadas</p>
            </div>

            <?php if (!empty($chunks)): 
                $lastChunk = end($chunks);
                $needsExtraSlide = (count($lastChunk) === 3);
                $totalSlides = count($chunks);
            ?>
                <div id="carouselNews" class="carousel slide carousel-fade" data-ride="carousel">
                    <ol class="carousel-indicators" style="bottom: -40px;">
                        <?php foreach ($chunks as $index => $group): ?>
                            <li data-target="#carouselNews" data-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"></li>
                        <?php endforeach; ?>
                        <?php if ($needsExtraSlide): ?>
                            <li data-target="#carouselNews" data-slide-to="<?= $totalSlides ?>"></li>
                        <?php endif; ?>
                    </ol>

                    <div class="carousel-inner px-4">
                        <?php foreach ($chunks as $index => $group): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="row">
                                    <?php foreach ($group as $promo): 
                                        $img = defined('NEXTCLOUD_PUBLIC_BASE') ? NEXTCLOUD_PUBLIC_BASE . urlencode($promo->getImageUUID()) : '';
                                        $shopName = $promo->getShop() ? $promo->getShop()->getName() : 'Promo';
                                    ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card card-novedad h-100">
                                                <img src="<?= $img ?>" class="card-img-top" alt="Promo <?= htmlspecialchars($shopName) ?>">
                                                <div class="card-body d-flex flex-column">
                                                    <h3 class="h5 card-title font-weight-bold" style="color: #ff8c00;">
                                                        <?= htmlspecialchars($shopName) ?>
                                                    </h3>
                                                    <p class="card-text text-muted small flex-grow-1">
                                                        <?= htmlspecialchars(substr($promo->getPromoText(), 0, 80)) ?>...
                                                    </p>
                                                    <a href="promoDetailPage.php?id=<?= $promo->getId() ?>" class="btn btn-outline-warning btn-sm btn-block mt-3" style="border-color: #ff8c00; color: #ff8c00; font-weight: bold;">Ver Detalle</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                    <?php if (($index === $totalSlides - 1) && count($group) < 3): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card card-novedad h-100 text-center" style="cursor: pointer; border: 1px solid #ff8c00;" onclick="window.location.href='allPromotionsPage.php'">
                                                <div class="d-flex justify-content-center align-items-center w-100" style="height: 180px; background-color: #fff3e0;">
                                                    <i class="fas fa-plus fa-4x" style="color: #ff8c00;"></i>
                                                </div>
                                                <div class="card-body d-flex flex-column justify-content-center">
                                                    <h3 class="h5 font-weight-bold mt-2" style="color: #ff8c00;">Ver Todo</h3>
                                                    <p class="text-muted small">Explora todas las promociones.</p>
                                                    <a href="allPromotionsPage.php" class="btn btn-orange btn-sm rounded-pill mt-auto px-4">Ir al Catálogo</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php if ($needsExtraSlide): ?>
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div class="card card-novedad h-100 text-center" style="cursor: pointer; border: 1px solid #ff8c00;" onclick="window.location.href='allPromotionsPage.php'">
                                            <div class="d-flex justify-content-center align-items-center w-100" style="height: 180px; background-color: #fff3e0;">
                                                <i class="fas fa-plus fa-4x" style="color: #ff8c00;"></i>
                                            </div>
                                            <div class="card-body d-flex flex-column justify-content-center">
                                                <h3 class="h5 font-weight-bold mt-2" style="color: #ff8c00;">Ver Todo</h3>
                                                <p class="text-muted small">Explora todas las promociones.</p>
                                                <a href="allPromotionsPage.php" class="btn btn-orange btn-sm rounded-pill mt-auto px-4">Ir al Catálogo</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-light text-center border">No hay promociones para mostrar.</div>
            <?php endif; ?>
        </div>

        <?php if ($indice === 1): ?>
            <section class="bg-white border-top">
                <div class="container px-5 py-5">
                    <div class="text-center mb-5">
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
                                <div class="alert alert-light text-center border shadow-sm">No hay novedades para tu categoría.</div>
                            <?php else: ?>
                                <?php foreach ($novedadesResumen as $news): 
                                    $imgUrl = defined('NEXTCLOUD_PUBLIC_BASE') ? NEXTCLOUD_PUBLIC_BASE . urlencode($news->getImageUUID()) : 'https://via.placeholder.com/150';
                                ?>
                                    <div class="news-card-summary" onclick="window.location.href='newsDetailPage.php?id=<?= $news->getId() ?>'">
                                        <div class="row align-items-center">
                                            <div class="col-md-2 text-center mb-3 mb-md-0">
                                                <img src="<?= $imgUrl ?>" class="img-fluid rounded" style="max-height: 80px;" alt="Imagen Novedad">
                                            </div>
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                <h3 class="h5 font-weight-bold text-orange mb-1">Novedad #<?= $news->getId() ?></h3>
                                                <p class="text-muted mb-0"><?= htmlspecialchars(substr($news->getNewsText(), 0, 100)) ?>...</p>
                                            </div>
                                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                                <div class="bg-light rounded p-2 border">
                                                    <small class="d-block text-muted">Vigencia:</small>
                                                    <strong><?= date("d/m/y", strtotime($news->getDateFrom())) ?></strong> al 
                                                    <strong><?= $news->getDateTo() ? date("d/m/y", strtotime($news->getDateTo())) : '∞' ?></strong>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <span class="badge badge-warning text-white p-2" style="background-color: #CC6600;">
                                                    <?= htmlspecialchars($news->getUserCategory()->getCategoryType()) ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="newsPage.php" class="btn btn-orange btn-lg rounded-pill px-5">Ver más Novedades</a>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="h5 modal-title" id="contactModalLabel">Formulario de Contacto</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
            </div>
        </div>
    </div>

    <?php include "../components/footer.php" ?>
    <?php include "../components/messageModal.php" ?>

    <script>
        console.log("Página cargada y validada.");
    </script>
</body>
</html>