<?php
require_once "../shared/frontendRoutes.dev.php";
?>
<link rel="stylesheet" href="../assets/styles/header.css">
<style>
    .logo-container:hover {
        text-decoration: none;
    }
    
    /* Estilo para el subrayado naranja en hover */
    .nav-menu .nav-link {
        position: relative;
        color: white !important;
        transition: all 0.3s ease;
    }
    
    .nav-menu .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #FF8C00; /* Color naranja */
        transition: width 0.3s ease;
    }
    
    .nav-menu .nav-link:hover::after {
        width: 100%;
    }
    
    /* Ajuste para el menú de navegación */
    .nav-menu {
        padding-bottom: 20px ;
    }
    
    .nav-menu .navbar {
        background-color: #006633 !important;
    }
</style>
<div class="header-container" style="background-color: #006633;">
    <div class="header">
        <a href=<?php echo frontendURL."/landingPage.php"?> class="logo-container">
            <img src="../assets/LogoPromoShopFondoVerde.png" alt="Logo de PromoShop">
            <div class="welcome-message"><h2>PromoShop</h2></div>
        </a>
        <div class="nav-links">
        <?php if (!isset($_SESSION["user"]) || session_status() == PHP_SESSION_NONE): ?>
            <a class="nav-link" href=<?php echo frontendURL."/loginPage.php"?>>Ingresar</a>
            <a class="nav-link" href=<?php echo frontendURL."/registerPage.php"?>>Registrarse</a>
        <?php else:?>
            <div class="user-icon">
                <i class="fas fa-user" id="user-icon"></i>
                <div class="user-dropdown-menu" id="user-dropdown-menu" style="display: none;">
                    <a href=<?php echo frontendURL."/landingPageAdmin.php"?>>Admin Panel</a>
                    <a href="">Placeholder</a>
                    <hr>
                    <a href="">Cambiar Contraseña</a>
                    <hr>
                    <a href="">Cerrar Sesion</a>
                </div> 
            </div>
        <?php endif?>
        </div>
    </div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
    var userIcon = document.getElementById('user-icon');
    var dropdownMenu = document.getElementById('user-dropdown-menu');

    if (userIcon) {
        userIcon.addEventListener('click', function (event) {
            event.stopPropagation(); 
            if (dropdownMenu.style.display === 'none') {
                dropdownMenu.style.display = 'block'; 
            } else {
                dropdownMenu.style.display = 'none'; 
            }
        });
    }

    document.addEventListener('click', function (event) {
        if (dropdownMenu && !dropdownMenu.contains(event.target) && (!userIcon || !userIcon.contains(event.target))) {
            dropdownMenu.style.display = 'none'; 
        }
    });
});
</script>