<?php
require_once "../../Backend/structs/user.class.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mapa del Sitio - PromoShop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #eae8e0 !important;
        }

        .sitemap-card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .text-orange {
            color: #CC6600 !important;
        }

        .sitemap-card h2 {
            margin-top: 30px;
        }

        .sitemap-card ul {
            padding-left: 20px;
        }

        .sitemap-card li {
            margin-bottom: 8px;
            color: #444;
        }

        .sitemap-card a {
            color: #006633;
            text-decoration: none;
            font-weight: 500;
        }

        .sitemap-card a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php include "../components/header.php"; ?>
    <?php include "../components/navBarByUserType.php"; ?>

    <main class="container py-5">
        <div class="sitemap-card">
            <h1 class="display-4 font-weight-bold text-orange mb-4">
                Mapa del Sitio
            </h1>

            <p>
                El presente mapa del sitio permite visualizar de forma general las secciones
                disponibles dentro de la plataforma <strong>PromoShop</strong> y facilita la
                navegación entre sus principales funcionalidades.
            </p>

            <h2 class="h4 font-weight-bold">Secciones públicas</h2>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="allPromotionsPage.php">Promociones vigentes</a></li>
                <li><a href="shopsCardsPage.php">Locales adheridos</a></li>
                <li><a href="termsAndConditionsPage.php">Términos y Condiciones</a></li>
                <li><a href="privacyPolicyPage.php">Política de Privacidad</a></li>
                <li><a href="siteMapPage.php">Mapa del sitio</a></li>
            </ul>

            <h2 class="h4 font-weight-bold">Usuarios registrados</h2>
            <ul>
                <li><a href="loginPage.php">Inicio de sesión</a></li>
                <li><a href="registerPage.php">Registro</a></li>
                <li><a href="myProfilePage.php">Perfil de usuario</a></li>
                <li><a href="myPromotionsPage.php">Historial de promociones utilizadas</a></li>
            </ul>

            <h2 class="h4 font-weight-bold">Comercios</h2>
            <ul>
                <li><a href="shopsCardsPage.php">Panel del comercio</a></li>
                <li><a href="newPromotionPage.php">Crear promoción</a></li>
                <li><a href="allShopPromotionsPage.php">Mis promociones</a></li>
                <li><a href="shopsCardsPage.php">Editar Comercio</a></li>
            </ul>

            <h2 class="h4 font-weight-bold">Administración</h2>
            <ul>
                <li><a href="promoManagementPage.php">Gestión de promociones</a></li>
                <li><a href="promoManagementPage.php">Promociones pendientes</a></li>
                <li><a href="promoManagementPage.php">Aprobación / Rechazo de promociones</a></li>
                <li><a href="shopsCardsPage.php">Gestión de locales</a></li>
                <li><a href="newShopTypePage.php">Gestión de tipos de locales</a></li>
                <li><a href="myProfilePage.php">Usuarios del sistema</a></li>
            </ul>

            <hr class="my-4">

            <p class="text-muted">
                Última actualización: <?= date('d/m/Y') ?>
            </p>

            <div class="mt-4">
                <a href="javascript:history.back()" class="btn btn-light btn-lg">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </main>

    <?php include "../components/footer.php"; ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>

</html>