<?php
require_once "../shared/frontendRoutes.dev.php";
require_once "../shared/backendRoutes.dev.php";
require_once "../shared/userType.enum.php";

require_once __DIR__ . "/../shared/breadcrumbManager.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$userType = isset($_SESSION['userType']) ? $_SESSION['userType'] : null;
switch ($userType) {
    case UserType_enum::Admin:
        $redirectTo = "/index.php";
        break;
    case UserType_enum::Owner:
        $redirectTo = "/index.php";
        break;
    case UserType_enum::User:
        $redirectTo = "/index.php";
        break;
    default:
        $redirectTo = "/index.php";
        break;
}
?>
<link rel="stylesheet" href="../assets/styles/header.css">
<style>
    .logo-container:hover {
        text-decoration: none;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 16px;
        /* separación entre Ingresar y Registrarse */
    }

    .nav-links .nav-link {
        display: inline-block;
        padding: 6px 12px;
        text-decoration: none;
    }
</style>
<div class="header">
    <a href=<?php echo frontendURL . $redirectTo ?> class="logo-container">
        <img src="../assets/LogoPromoShopFondoVerde.png" alt="Logo de PromoShop">
        <div class="welcome-message">
            <h2>PromoShop</h2>
        </div>
    </a>
    <div class="nav-links">
        <?php if (!isset($_SESSION["user"])): ?>

            <a class="nav-link" href=<?php echo frontendURL . "/loginPage.php" ?>>Ingresar</a>
            <a class="nav-link" href=<?php echo frontendURL . "/registerPage.php" ?>>Registrarse</a>
        <?php else: ?>
            <div class="user-icon">
                <p class="d-flex p-2 font-weight-bold text-white"><?= $userType->name ?></p>
                <i class="fas fa-user" id="user-icon"></i>
                <div class="user-dropdown-menu" id="user-dropdown-menu" style="display: none;">
                    <a href=<?php echo frontendURL . "/myProfilePage.php" ?>>Mi Perfil</a>
                    <hr>
                    <a href=<?php echo backendHTTPLayer . "/logout.http.php" ?>>Cerrar Sesion</a>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var userIcon = document.getElementById('user-icon');
        var dropdownMenu = document.getElementById('user-dropdown-menu');

        userIcon.addEventListener('click', function(event) {
            event.stopPropagation();
            if (dropdownMenu.style.display === 'none') {
                dropdownMenu.style.display = 'block';
            } else {
                dropdownMenu.style.display = 'none';
            }
        });

        document.addEventListener('click', function(event) {
            if (!dropdownMenu.contains(event.target) && !userIcon.contains(event.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    });
</script>