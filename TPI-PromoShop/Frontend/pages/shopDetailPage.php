<?php

//debería ser abierto a cualquier usuario, no solo al admin. En todo caso el admin solo puede editar. 
//require_once "../shared/authFunctions.php/admin.auth.function.php";
require_once "../../Backend/logic/shop.controller.php";
require_once "../../Backend/logic/promotion.controller.php";

require_once "../components/shopAction.php";
require_once "../shared/nextcloud.public.php";
require_once "../shared/dayLabels.php";
include "../components/messageModal.php";

// ID del local desde GET (Sanitizado)
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;
//verifica que el dato exista, valida que sea un número y asigna un valor por defecto si algo falla. [Operador ? :] Si existe, ejecuta función filter_var, sino asigna cero. 
//FILTER_VAR Esta función nativa de PHP toma el valor que vino por la URL e intenta validarlo como un número entero (INT). Si no logra hacerlo, devuelve FALSE evitando Injections. 


$s = new Shop();
$s->setId($id);
$shop = ShopController::getOne($s);
$promotions = [];
$promotions = PromotionContoller::getAllActiveByShop($s);

$direccionEjemplo = "https://media.lacapital.com.ar/p/65432e5860da904722add77bedf2d66b/adjuntos/203/imagenes/027/732/0027732077/1200x675/smart/galeriasjpg.jpg"
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detalles y promociones de <?= htmlspecialchars($shop->getName()) ?>">

    <title><?= htmlspecialchars($shop->getName()) ?> - Fisherton Plaza</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="../assets/styles/shopDetailPage.css">


</head>

<body style="background-color: #eae8e0">

    <?php include "../components/header.php" ?>

    <?php include "../components/navBarByUserType.php" ?>


    <main id="main-content" class="container py-4">

        <article class="row mb-5" aria-labelledby="shop-heading">
            <div class="col-12 d-flex align-items-center p-3">
                <div>
                    <h1 id="shop-heading" class="mb-3 h2" tabindex="0">
                        <?= htmlspecialchars($shop->getName()); ?>
                    </h1>
                </div>
                <div class="ml-auto d-flex">
                    <?= renderUserShopAction($shop); ?>
                </div>
            </div>

            <div class="col-lg-8 col-md-12 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-2">

                        <div id="carouselShop" class="carousel slide" data-ride="carousel" aria-roledescription="carousel" aria-label="Galería de imágenes de <?= htmlspecialchars($shop->getName()) ?>">

                            <ol class="carousel-indicators">
                                <?php $totalImages = count($shop->getImages()); ?>
                                <?php foreach ($shop->getImages() as $index => $img): ?>
                                    <li data-target="#carouselShop"
                                        data-slide-to="<?= $index ?>"
                                        class="<?= $index === 0 ? 'active' : '' ?>"
                                        aria-label="Ir a la imagen <?= $index + 1 ?> de <?= $totalImages ?>"
                                        <?= $index === 0 ? 'aria-current="true"' : '' ?>></li>
                                <?php endforeach; ?>
                            </ol>

                            <div class="carousel-inner">
                                <?php foreach ($shop->getImages() as $index => $img): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>"
                                        role="group"
                                        aria-roledescription="slide"
                                        aria-label="Imagen <?= $index + 1 ?> de <?= $totalImages ?>">
                                        <img class="d-block w-100"
                                            src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($img->getUUID()) ?>"
                                            alt="Vista interior o producto <?= $index + 1 ?> del local <?= htmlspecialchars($shop->getName()) ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <a class="carousel-control-prev" href="#carouselShop" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Imagen anterior</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselShop" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Imagen siguiente</span>
                            </a>
                        </div>
                    </div>
                </div>

                <section class="mt-4" aria-labelledby="about-heading">
                    <h2 id="about-heading" class="h3" tabindex="0">Sobre el local</h2>
                    <p tabindex="0"><?= htmlspecialchars($shop->getDescription()) ?></p>
                </section>
            </div>

            <aside class="col-lg-4 col-md-12" aria-label="Información útil del local">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white font-weight-bold" tabindex="0">
                        <i class="fas fa-map text-orange" aria-hidden="true"></i> Ubicación en el Shopping
                    </div>
                    <div class="card-body text-center p-2">
                        <div class="map-container mb-3">

                            <img class="img-fluid rounded border" src="<?= htmlspecialchars($direccionEjemplo) ?>" alt="Plano del shopping destacando la ubicación del local <?= htmlspecialchars($shop->getName()) ?>">
                        </div>
                        <p class="card-text small text-muted" tabindex="0">
                            <span class="sr-only">Nivel y sector:</span>
                            <?= htmlspecialchars($shop->getLocation()) ?>
                        </p>
                        <a href="#" class="btn btn-outline-dark btn-sm btn-block">
                            <i class="fas fa-directions" aria-hidden="true"></i> Cómo llegar
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="h6 font-weight-bold mb-2" tabindex="0">Horarios de Atención</h2>
                        <p class="small mb-0" tabindex="0"><?= htmlspecialchars($shop->getOpeningHours()) ?></p>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h6 font-weight-bold mb-2" tabindex="0">Categoría</h2>
                        <p class="small mb-0" tabindex="0"><?= htmlspecialchars($shop->getShopType()?->getType()) ?></p>
                    </div>
                </div>
            </aside>
        </article>

        <hr class="my-5">

        <section aria-labelledby="promo-heading">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 id="promo-heading" class="mb-0" tabindex="0">
                    <i class="fas fa-percentage text-orange" aria-hidden="true"></i> Promociones Activas
                </h2>
                <span class="badge badge-secondary" tabindex="0" aria-label="<?= count($promotions) ?> promociones disponibles">
                    <?= count($promotions) ?> Disponibles
                </span>
            </div>

            <div class="row">
                <?php if (!empty($promotions)): ?>
                    <?php foreach ($promotions as $promo): ?>
                        <div class="col-md-6 col-lg-4 mb-4">

                            <article class="card h-100 shadow-sm promo-card position-relative">
                                <div class="card-body d-flex flex-column">

                                    <div class="mb-2" aria-hidden="true">
                                        <small class="text-uppercase text-orange font-weight-bold">Oferta</small>
                                    </div>

                                    <h3 class="card-title h5 font-weight-bold" tabindex="0">
                                        <?= htmlspecialchars($promo->getPromoText()) ?>
                                    </h3>

                                    <?php
                                    $imgUrl = $promo->getImageUUID() !== null
                                        ? NEXTCLOUD_PUBLIC_BASE . urlencode($promo->getImageUUID())
                                        : NEXTCLOUD_PUBLIC_BASE . urlencode("placeholder.png");
                                    ?>

                                    <div class="flex-grow-1 mb-3">
                                        <img src="<?= $imgUrl ?>"
                                            alt="" aria-hidden="true"
                                            class="w-100 rounded"
                                            style="height: 200px; object-fit: cover;">
                                    </div>

                                    <div class="mb-3">
                                        <?php if ($promo->getUserCategory() !== null): ?>
                                            <small class="text-muted d-block mb-2" tabindex="0">
                                                <strong>Categoría:</strong>
                                                <?= htmlspecialchars($promo->getUserCategory()->getCategoryType()) ?>
                                            </small>
                                        <?php endif; ?>
                                        <small class="text-muted font-weight-bold" tabindex="0">Días válidos:</small>
                                        <span class="text-muted" tabindex="0">
                                            <?php
                                            $activeDays = [];
                                            foreach ($dayLabels as $key => $label) {
                                                if (!empty($promo->getValidDays()[$key])) {
                                                    $activeDays[] = $label;
                                                }
                                            }
                                            echo !empty($activeDays)
                                                ? implode(' · ', $activeDays)
                                                : 'Todos los días';
                                            ?>
                                        </span>
                                    </div>

                                    <div class="mt-auto pt-3 border-top">

                                        <div class="mb-3">
                                            <span aria-label="Válido desde el <?= $promo->getDateFrom()?->format('d/m/Y') ?> hasta el <?= $promo->getDateTo()?->format('d/m/Y') ?>" tabindex="0">
                                                <small class="text-muted d-block mb-1">
                                                    <i class="far fa-calendar-alt"></i> Desde: <?= $promo->getDateFrom()?->format('d/m/Y') ?>
                                                </small>
                                                <small class="text-muted d-block">
                                                    <i class="far fa-calendar-alt"></i> Vence: <?= $promo->getDateTo()?->format('d/m/Y') ?>
                                                </small>
                                            </span>
                                        </div>

                                        <a href="promoDetailPage.php?id=<?= $promo->getId() ?>"
                                            class="btn btn-block btn-outline-orange text-orange font-weight-bold stretched-link mt-3"
                                            aria-label="Ver detalles de la oferta: <?= htmlspecialchars($promo->getPromoText()) ?>">
                                            Ver Más
                                        </a>

                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="alert alert-info text-center shadow-sm border-0" 
                        tabindex="0">
                        No hay promociones activas para este local en este momento.
                        </p> 
                    </div>          
                <?php endif; ?>
            </div>
        </section>

    </main>


    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <?php include "../components/footer.php" ?>


    <!-- MODAL TO DELETE -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header" style="background-color: #006633; color: white; display: flex; align-items: center; justify-content: flex-start;">
                    <img src="../assets/LogoPromoShopFondoVerde.png" alt="PromoShop Logo" style="width: 60px; margin-right: 10px;">
                    <h2 class="modal-title" id="deleteLabel" style="margin: 0; color:#CC6600"><strong>PromoShop</strong></h2>
                </div>

                <div class="modal-body text-center" style="background-color: #eae8e0; padding: 2rem;">

                    <p style="font-size: 18px; color: #333; margin-bottom: 20px;">
                        ¿Estás seguro de que deseas eliminar este elemento?
                    </p>
                    <p class="text-muted small mb-4">Esta acción no se puede deshacer.</p>

                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">
                            Cancelar
                        </button>

                        <button type="button" class="btn" id="btnConfirmDeleteAction" style="background-color: #CC6600; color: white; font-weight: bold;">
                            Eliminar
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        // Variable para guardar qué formulario quiere borrar
        let formToDelete = null;
        // Instancia del modal (Bootstrap 5)
        let deleteModalInstance = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Inicializamos el modal una sola vez
            const modalElement = document.getElementById('deleteConfirmationModal');
            if (modalElement) {
                deleteModalInstance = new bootstrap.Modal(modalElement);
            }

            // Lógica del botón "Sí, Eliminar" del modal
            const confirmBtn = document.getElementById('btnConfirmDeleteAction');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function() {
                    if (formToDelete) {
                        formToDelete.submit(); // Enviar el formulario
                    }
                });
            }
        });

        // Función que llamaremos desde el botón de la tarjeta
        function confirmarBorrado(boton) {
            // 1. Buscamos el formulario padre del botón clickeado
            formToDelete = boton.closest('form');

            // 2. Mostramos el modal
            if (deleteModalInstance) {
                deleteModalInstance.show();
            } else {
                console.error("El modal de borrado no se cargó correctamente.");
            }
        }
    </script>

</body>


</html>