<?php
require_once "../shared/authFunctions.php/user.auth.function.php";
include "../components/messageModal.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Tu Shopping</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <style>
        /* Estilos Personalizados */

        /* BOTÓN NARANJA */
        .btn-orange {
            background-color: #ff8c00;
            color: white;
            border: none;
            font-weight: bold;
            transition: transform 0.2s;
        }

        .btn-orange:hover {
            background-color: #e07b00;
            color: white;
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
    </style>
</head>

<body>

    <?php include "../components/header.php" ?>
    <div class="position-relative d-flex align-items-center justify-content-center text-center" style="height: 85vh; overflow: hidden;">

        <img src="https://static.wixstatic.com/media/290684_bee75ee23dd9460c9e87f6a2286eeab6~mv2.png/v1/fill/w_1920,h_1080,al_c/290684_bee75ee23dd9460c9e87f6a2286eeab6~mv2.png"
            alt="Fondo Shopping"
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1;">

        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2;
                    background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.7) 100%);">
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

                    <form action="shopsCardsPage.php" method="GET">
                        <div class="input-group input-group-lg shadow-lg" style="border-radius: 50px; overflow: hidden;">
                            <input type="text" name="q" class="form-control border-0 pl-4" placeholder="Buscar local, comida o servicio...">
                            <div class="input-group-append">
                                <button class="btn btn-orange px-4" type="submit">
                                    <i class="fas fa-search mr-2"></i> BUSCAR
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="mt-4">
                        <small class="mr-2">Sugerencias:</small>
                        <a href="shopsCardsPage.php?cat=Ropa" class="badge badge-light text-dark p-2 mx-1">Ropa</a>
                        <a href="shopsCardsPage.php?cat=Comida" class="badge badge-light text-dark p-2 mx-1">Comida</a>
                        <a href="shopsCardsPage.php?cat=Cine" class="badge badge-light text-dark p-2 mx-1">Cine</a>
                    </div>

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
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h4 class="font-weight-bold">Locales</h4>
                        <p class="text-muted small">Descubre las mejores marcas y tiendas.</p>
                        <a href="shopsCardsPage.php" class="btn btn-outline-dark btn-sm rounded-pill mt-auto mx-auto px-4">Ver Todos</a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                        <div class="icon-circle">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h4 class="font-weight-bold">Gastronomía</h4>
                        <p class="text-muted small">Patios de comida, restaurantes y cafés.</p>
                        <a href="shopsCardsPage.php?shopType=2" class="btn btn-outline-dark btn-sm rounded-pill mt-auto mx-auto px-4">Ir a Comer</a>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="cat-card p-4 text-center shadow-sm d-flex flex-column">
                        <div class="icon-circle">
                            <i class="fas fa-store-alt"></i>
                        </div>
                        <h4 class="font-weight-bold">Soy Dueño</h4>
                        <p class="text-muted small">Gestiona tu local y actualiza tus productos.</p>

                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="dashboard.php" class="btn btn-orange btn-sm rounded-pill mt-auto mx-auto px-4">Mi Panel</a>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-orange btn-sm rounded-pill mt-auto mx-auto px-4">Ingresar</a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include "../components/footer.php" ?>

</body>

</html>