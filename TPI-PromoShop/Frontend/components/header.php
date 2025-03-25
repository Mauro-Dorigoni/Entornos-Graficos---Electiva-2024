<?php
require_once "../shared/frontendRoutes.dev.php";
?>
<link rel="stylesheet" href="../assets/styles/header.css">
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
                <a href="">Placeholder</a>
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

    userIcon.addEventListener('click', function (event) {
        event.stopPropagation(); 
        if (dropdownMenu.style.display === 'none') {
            dropdownMenu.style.display = 'block'; 
        } else {
            dropdownMenu.style.display = 'none'; 
        }
    });

    document.addEventListener('click', function (event) {
        if (!dropdownMenu.contains(event.target) && !userIcon.contains(event.target)) {
            dropdownMenu.style.display = 'none'; 
        }
    });
});
</script>
