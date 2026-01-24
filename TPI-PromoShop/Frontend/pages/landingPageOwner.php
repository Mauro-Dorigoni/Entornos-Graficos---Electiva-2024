<?php
require_once "../shared/authFunctions.php/owner.auth.function.php";
require_once "../shared/backendRoutes.dev.php";
require_once "../../Backend/structs/user.class.php";
require_once "../../Backend/logic/shop.controller.php";

//Esta solucion (para mi) viola las capas y no considera un dueño con mas de un local

$shop = ShopController::getOneByOwner($user);
$imagenes = $shop->getImagesUUIDS();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Owner landing page</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>

<body>
  <?php include "../components/header.php" ?>
  <?php include "../components/ownerNavBar.php" ?>

  <div class="content">
    <h1>Landing Page Owner</h1>
    <h2>Bienvenido <?php echo $user->getEmail() ?></h2>
    <h2>Su local <?php echo $shop->getName() ?></h2>

  </div>

  <div id="shopGalleryCarousel" class="carousel slide" data-bs-ride="carousel" style="max-width: 600px;">
    <div class="carousel-inner">

      <?php if (!empty($imagenes)): ?>
        <?php foreach ($imagenes as $index => $imagen): ?>
          <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
            <img src="<?php echo serverUploads . "/$imagen" ?>" class="d-block w-100" alt="Imagen del local">
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="carousel-item active">
          <img src="/assets/no-image-available.png" class="d-block w-100" alt="Sin imágenes">
        </div>
      <?php endif; ?>

    </div>

    <!-- Controles -->
    <button class="carousel-control-prev" type="button" data-bs-target="#shopGalleryCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#shopGalleryCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>

    <!-- Indicadores -->
    <div class="carousel-indicators">
      <?php foreach ($imagenes as $index => $imagen): ?>
        <button type="button" data-bs-target="#shopGalleryCarousel" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>" aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
      <?php endforeach; ?>
    </div>
  </div>

  <?php include "../components/footer.php" ?>
</body>

</html>