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

//FILTROS PARA SIGUIENTE Y ANTERIOR:
//En caso de que existan filtros se agregan a la variable
$hrefUrl = '';
if ($busquedaNombre != '' || $filtroTipo != '') {
    //Si hay algún filtro...
    $hrefUrl .= ('localName=' . $busquedaNombre);
    $hrefUrl .= '&';
    $hrefUrl .= ('localType=' . $filtroTipo);
    $hrefUrl .= '&';
    //queda listo para agregar otro parametro.
}


//PAGINACIÓN
//No valida que por url ingrese a una pagina que no existe, sin embargo no genera error. Lautaro.
$paginaActual = isset($_GET['page']) ? htmlspecialchars($_GET['page'], FILTER_SANITIZE_NUMBER_INT) : '';
if ($paginaActual === '') {
    $paginaActual = 1;
} else {
    $paginaActual = (int) $paginaActual;
}




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
//CANTIDAD DE PROMOS QUE MUESTRO EN UNA PAGINA:
$amountPerPage = 3;
$shops = ShopController::getByNameAndTypePagination($s, $t, $paginaActual, $amountPerPage);

$totalLocales = ShopController::getCountByNameAndType($s, $t);
$totalPaginas = ceil($totalLocales / $amountPerPage);
//se le puede pasar como tercer parametro la cantidad de elemntos por pag, por defecto 4.
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
                    <h2 id="filter-heading" class="h4 mb-4" tabindex="0">Buscar Locales</h2>

                    <form method="GET" role="search" aria-label="Formulario de filtros de locales">
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
                                        title="Escribe el nombre del local que buscas">
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 mb-3">
                                <label for="type-select" class="font-weight-bold">Tipo de local</label>
                                <select id="type-select" name="localType" class="form-control">
                                    <option value="">Todos los Tipos</option>
                                    <?php foreach ($shopTypes as $shopType): ?>
                                        <option value="<?= $shopType->getId(); ?>" <?= ($filtroTipo == $shopType->getId()) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($shopType->getType()); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-12 mb-3">
                                <div class="d-flex w-100">

                                    <button type="submit" class="btn btn-outline-orange font-weight-bold flex-grow-1" aria-label="Aplicar filtros de búsqueda">
                                        Aplicar Filtros
                                    </button>

                                    <?php if ($busquedaNombre != '' || $filtroTipo != ''): ?>
                                        <a href="shopsCardsPage.php"
                                            class="btn btn-secondary ml-2 px-3 d-flex align-items-center justify-content-center"
                                            title="Limpiar búsqueda"
                                            aria-label="Limpiar todos los filtros y mostrar el listado completo">
                                            <i class="fas fa-times" aria-hidden="true"></i>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section id="resultados" class="container" aria-labelledby="titulo-resultados">

            <h2 id="titulo-resultados" class="sr-only" tabindex="-1">
                Resultados de búsqueda, página <?= htmlspecialchars($paginaActual) ?> de <?= htmlspecialchars($totalPaginas) ?>.
            </h2>

            <div class="row">
                <?php if (!empty($shops)): ?>
                    <?php foreach ($shops as $shop): ?>
                        <article class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card shop-card h-100 position-relative shadow-sm">

                                <?php
                                if (!is_null($shop->getMainImage())) {
                                    $portada = $shop->getMainImage();
                                } else {
                                    $portada = new Image();
                                    $portada->setUUID("placeholder.png");
                                }
                                ?>

                                <img class="card-img-top"
                                    src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($portada->getUUID()) ?>"
                                    alt="Fachada del local <?= htmlspecialchars($shop->getName()); ?>"
                                    style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h3 class="card-title h5 text-dark font-weight-bold mb-3">
                                        <?= htmlspecialchars($shop->getName()); ?>
                                    </h3>

                                    <p class="card-subtitle mb-2 text-muted">
                                        <i class="fas fa-tag mr-2" aria-hidden="true"></i>
                                        <span class="sr-only">Categoría del local:</span>
                                        <?= htmlspecialchars($shop->getShopType()?->getType()); ?>
                                    </p>

                                    <p class="card-text flex-grow-1 text-muted">
                                        <i class="fas fa-map-marker-alt mr-2" aria-hidden="true"></i>
                                        <span class="sr-only">Ubicación en el shopping:</span>
                                        <?= htmlspecialchars($shop->getLocation()); ?>
                                    </p>

                                    <a href="shopDetailPage.php?id=<?= $shop->getId(); ?>"
                                        class="btn btn-block mt-3 font-weight-bold stretched-link"
                                        style="color:#CC6600 !important; border:2px solid #CC6600 !important; background:transparent !important; transition: all 0.2s;"
                                        aria-label="Ver detalles y promociones del local <?= htmlspecialchars($shop->getName()); ?>">
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-light border shadow-sm" role="alert">
                            <h2 class="h4 text-muted mb-3">No se encontraron locales</h2>
                            <p class="mb-0">Intenta con otros términos de búsqueda o borra los filtros.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($totalPaginas > 1): ?>
                <nav aria-label="Navegación de resultados de búsqueda" class="mt-5">
                    <ul class="pagination justify-content-center mb-4">

                        <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="<?= ($paginaActual <= 1) ? '#' : '?' . $hrefUrl . 'page=' . ($paginaActual - 1) ?>"
                                <?= ($paginaActual <= 1) ? 'tabindex="-1" aria-disabled="true"' : '' ?>
                                aria-label="Ir a la página anterior">
                                Anterior
                            </a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <li class="page-item <?= ($i == $paginaActual) ? 'active' : '' ?>" <?= ($i == $paginaActual) ? 'aria-current="page"' : '' ?>>
                                <a class="page-link"
                                    href="?<?= $hrefUrl ?>page=<?= $i ?>"
                                    aria-label="<?= ($i == $paginaActual) ? "Página actual, página $i" : "Ir a la página $i" ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= ($paginaActual >= $totalPaginas) ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="<?= ($paginaActual >= $totalPaginas) ? '#' : '?' . $hrefUrl . 'page=' . ($paginaActual + 1) ?>"
                                <?= ($paginaActual >= $totalPaginas) ? 'tabindex="-1" aria-disabled="true"' : '' ?>
                                aria-label="Ir a la página siguiente">
                                Siguiente
                            </a>
                        </li>

                    </ul>

                    <div class="text-center text-muted small" aria-live="polite">
                        <p class="mb-1">Mostrando página <strong><?= htmlspecialchars($paginaActual) ?></strong> de <strong><?= htmlspecialchars($totalPaginas) ?></strong></p>
                        <p class="mb-0">Se encontraron <strong><?= htmlspecialchars($totalLocales) ?></strong> locales en total.</p>
                    </div>
                </nav>
            <?php endif; ?>
        </section>

    </main>

    <?php include "../components/footer.php" ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Verificamos si la URL termina en #resultados
            const urlActual = window.location.href;
            if (urlActual.includes("?page=")) {
                // Buscamos la sección de resultados
                const seccionResultados = document.getElementById("titulo-resultados");
                if (seccionResultados) {
                    seccionResultados.focus({
                        preventScroll: true
                    });
                    
                }
            }
        });
    </script>
</body>

</html>