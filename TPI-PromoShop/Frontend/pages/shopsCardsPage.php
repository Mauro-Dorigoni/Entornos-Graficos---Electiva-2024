<?php
//Apta para todo publico
//require_once "../shared/authFunctions.php/admin.auth.function.php"; //NECESARIO??
require_once "../shared/backendRoutes.dev.php"; //NECESARIO??
require_once "../../Backend/logic/shopType.controller.php";
require_once "../shared/nextcloud.public.php";
require_once "../../Backend/logic/shop.controller.php";


include "../components/messageModal.php";

// 1. Sanitización básica de entradas (Seguridad)
$busquedaNombre = isset($_GET['localName']) ? htmlspecialchars($_GET['localName'], ENT_QUOTES, 'UTF-8') : '';
$filtroTipo = isset($_GET['localType']) ? filter_var($_GET['localType'], FILTER_SANITIZE_NUMBER_INT) : '';

// 2. Obtención de datos
$shopTypes = ShopTypeController::getAll();

//RECIBE el FILTRO con NOMBRE del LOCAL y ID del TIPO.
$s = new Shop();
$s->setName($busquedaNombre);

$t = new ShopType();
if ($filtroTipo === '') {
    $t->setId(0); //podria ser null
} else {
    $t->setId((int) $filtroTipo);
};
$shops = ShopController::getByNameAndType($s, $t);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Listado de locales y promociones del Shopping Fisherton Plaza. Encuentra tu tienda favorita.">

    <title>Listado de Locales - Fisherton Plaza</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="../assets/styles/shopsCardsPage.css">

</head>

<body>
    <?php include "../components/header.php" ?>

    <?php include "../components/navBarByUserType.php" ?>

    <main id="main-content" class="container-fluid py-4">

        <section class="container mb-5" aria-labelledby="filter-heading">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 id="filter-heading" class="h4 mb-4">Buscar Locales</h1>

                    <form method="GET" action="" role="search">
                        <div class="form-row align-items-end">

                            <div class="col-md-5 col-sm-12 mb-3">
                                <label for="search-input" class="font-weight-bold">Nombre del local</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text"
                                        id="search-input"
                                        name="localName"
                                        class="form-control"
                                        placeholder="Ej: Nike, Starbucks..."
                                        value="<?= $busquedaNombre ?>"
                                        aria-label="Escribe el nombre del local que buscas">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 mb-3">
                                <label for="type-select" class="font-weight-bold">Tipo</label>
                                <select id="type-select" name="localType" class="form-control">
                                    <option value="">Todos los Tipos</option>
                                    <!-- Lista todos los shopType -->
                                    <?php foreach ($shopTypes as $shopType): ?>
                                        <option value="<?= $shopType->getId(); ?>" <?= ($filtroTipo == $shopType->getId()) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($shopType->getType()); ?>

                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-12 mb-3">
                                <button type="submit" class="btn btn-outline-orange btn-block font-weight-bold">
                                    Aplicar Filtros
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="container" aria-label="Resultados de búsqueda">
            <div class="row">
                <?php if (!empty($shops)): ?>
                    <?php foreach ($shops as $shop): ?>
                        <article class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card shop-card">
                                <!-- Cambiar con la imagen que sea Portada -->

                                <?php

                                if (!is_null($shop->getMainImage())) {
                                    $portada = $shop->getMainImage();
                                } else {
                                    //Si ninguna es portada, y el arreglo esta vacío se asigna foto default. 
                                    $portada = new Image();
                                    $portada->setUUID("placeholder.png");
                                }
                                ?>
                                <!-- TODO: VER TEMA DE UBICACIÓN DE IMAGENES. -->
                                <img class="card-img-top"
                                    src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($portada->getUUID()) ?>"
                                    alt="Logo o fachada de <?= htmlspecialchars($shop->getName()); ?>">

                                <div class="card-body d-flex flex-column">
                                    <h2 class="card-title h5 text-dark">
                                        <?= htmlspecialchars($shop->getName()); ?>
                                    </h2>

                                    <p class="card-subtitle mb-2 text-muted">
                                        <i class="fas fa-tag mr-1" aria-hidden="true"></i>
                                        <span class="sr-only">Categoría:</span>
                                        <?= htmlspecialchars($shop->getShopType()?->getType()); ?>
                                    </p>

                                    <p class="card-text flex-grow-1">
                                        <i class="fas fa-map-marker-alt mr-1" aria-hidden="true"></i>
                                        <span class="sr-only">Ubicación:</span>
                                        <?= htmlspecialchars($shop->getLocation()); ?>
                                    </p>

                                    <!-- REFIERE A LA VENTANA DE LOCAL.-->
                                    <a href="shopDetailPage.php?id=<?= $shop->getId(); ?>"
                                        class="btn btn-block mt-3 font-weight-bold"
                                        style="color:#CC6600 !important; border:2px solid #CC6600 !important; background:transparent !important;">
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-light" role="alert">
                            <h3 class="h4 text-muted">No se encontraron locales</h3>
                            <p>Intenta con otros términos de búsqueda o borra los filtros.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <?php include "../components/footer.php" ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>