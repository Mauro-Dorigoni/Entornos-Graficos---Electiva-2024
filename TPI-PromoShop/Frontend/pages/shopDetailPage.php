<?php

//debería ser abierto a cualquier usuario, no solo al admin. En todo caso el admin solo puede editar. 
require_once "../shared/authFunctions.php/admin.auth.function.php";
require_once "../../Backend/logic/shop.controller.php";
require_once "../components/shopAction.php";


include "../components/messageModal.php";

// ID del local desde GET (Sanitizado)
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;
//verifica que el dato exista, valida que sea un número y asigna un valor por defecto si algo falla. [Operador ? :] Si existe, ejecuta función filter_var, sino asigna cero. 
//FILTER_VAR Esta función nativa de PHP toma el valor que vino por la URL e intenta validarlo como un número entero (INT). Si no logra hacerlo, devuelve FALSE evitando Injections. 


$s = new Shop();
$s -> setId($id);
$shop = ShopController::getOne($s);
$promotions=[];
//$promotions = PromotionController::getByShopId($shopId);
$promotions = [
    (object) ['id' => 1, 'title' => '2x1 en Calzado Running', 'validTo' => '2025-12-31', 'description' => 'Llevando dos pares de la línea Air Zoom, pagas solo uno.', 'image' => null],
    (object) ['id' => 2, 'title' => '30% OFF con Tarjeta Santander', 'validTo' => '2025-11-20', 'description' => 'Tope de reintegro $5000. Solo miércoles.', 'image' => null],
    (object) ['id' => 3, 'title' => 'Camiseta de Regalo', 'validTo' => '2025-10-15', 'description' => 'Con compras superiores a $100.000.', 'image' => null],
];

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
<body>

  <?php include "../components/header.php"?>
  <?php include "../components/adminNavBar.php"?>

<main id="main-content" class="container py-4">

    <div class="row mb-5">
        <div class="d-flex align-items-center p-3">
            <div>
                <h2 id="promo-heading" class="mb-3">
                        <?= $shop-> getName(); ?>
                </h2>
            </div>
            <div class="ml-auto">
                <?=renderUserShopAction($shop);?>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 mb-4">
            
            <div class="card shadow-sm border-0">
                <div class="card-body p-2">
                    <div id="carouselShop" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php foreach ($shop->getImages() as $index => $img): ?>
                                <li data-target="#carouselShop" data-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"></li>
                            <?php endforeach; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php foreach ($shop->getImages() as $index => $img): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img class="d-block w-100" src="<?= "../../Backend/shared/uploads/".$img->getUUID() ?>" alt="Foto del local <?= htmlspecialchars($shop->getName()) ?> - Vista <?= $index + 1 ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselShop" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Anterior</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselShop" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <h3>Sobre el local</h3>
                <p><?= htmlspecialchars($shop->getDescription()) ?></p>
            </div>
        </div>

        <aside class="col-lg-4 col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white font-weight-bold">
                    <i class="fas fa-map text-orange"></i> Ubicación en el Shopping
                </div>
                <div class="card-body text-center p-2">
                    <div class="map-container mb-3">
                        <!-- ACA VA UNA IMAGEN DE UN MAPA!!  -->
                         <img class="" src="<?= $direccionEjemplo ?>" alt="Mapa del Local <?= htmlspecialchars($shop->getName()) ?>">
                    </div>
                    <p class="card-text small text-muted"><?= htmlspecialchars($shop->getLocation()) ?></p>
                    <a href="#" class="btn btn-outline-dark btn-sm btn-block">
                        <i class="fas fa-directions"></i> Cómo llegar
                    </a>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="h6 font-weight-bold">Horarios de Atención</h5>
                    <p class="small mb-0"><?= htmlspecialchars($shop->getOpeningHours()) ?></p>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h5 class="h6 font-weight-bold">Tipo de Local</h5>
                    <p class="small mb-0"><?= htmlspecialchars( $shop -> getShopType() ?-> getType() ) ?></p>
                </div>
            </div>
        </aside>
    </div>

    <hr class="my-5">

    <section aria-labelledby="promo-heading">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 id="promo-heading" class="mb-0">
                <i class="fas fa-percentage text-orange"></i> Promociones Activas
            </h2>
            <span class="badge badge-secondary "><?= count($promotions) ?> Disponibles</span>
        </div>

        <div class="row">
            <?php if (!empty($promotions)): ?>
                <?php foreach ($promotions as $promo): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <article class="card h-100 shadow-sm promo-card">
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <small class="text-uppercase text-orange font-weight-bold">Oferta</small>
                                </div>
                                <h3 class="card-title h5 font-weight-bold"><?= htmlspecialchars($promo->title) ?></h3>
                                <p class="card-text text-muted flex-grow-1"><?= htmlspecialchars($promo->description) ?></p>
                                
                                <div class="mt-3 pt-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt"></i> Vence: <?= date("d/m/Y", strtotime($promo->validTo)) ?>
                                        </small>
                                    </div>
                                    <button type="button" class="btn btn-outline-orange btn-block mt-3">

                                        <a href="detallePromo.php?id=<?= $promo->id ?>" class="btn btn-block btn-orange  font-weight-bold">
                                            Obtener Beneficio
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No hay promociones activas para este local en este momento.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
</main>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<?php include "../components/footer.php"?>

</body>
</html>