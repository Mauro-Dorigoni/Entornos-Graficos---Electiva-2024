<div?php
    require_once "../shared/frontendRoutes.dev.php";
?>
<link rel="stylesheet" href="../assets/styles/footer.css">
<footer>
    <div class="footer-container">
        <div class="row text-center text-md-left">
        <div class="col-12 col-md-4 mb-3">
                <h3>Contacto</h3>
                <p>
                    <img src="../assets/icons8-teléfono-50.png" alt="Phone icon" class="icon-footer">
                    (0341)123-426-789
                </p>
                <p>
                    <img src="../assets/icons8-correo-50.png" alt="Email icon" class="icon-footer">
                    graficosentornos@gmail.com
                </p>
                <span>
                    <img src="../assets/icons8-formulario-64.png" alt="Form icon" class="icon-footer">
                    Formulario de Contacto
                </span>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <h3>Horarios</h3>
                <p>Lunes a Viernes: 9:00 - 18:00</p>
                <p>Sábados y Domingos: 10:00 - 14:00</p>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <h3>Sitio</h3>
                <p>
                    <img src="../assets/icons8-privacidad-50.png" alt="Privacy icon" class="icon-footer">
                    <a href=<?php echo frontendURL."/termsPage.php"?> class="text-white">Política de Privacidad</a>
                </p>
                <p>
                    <img src="../assets/icons8-términos-y-condiciones-50.png" alt="Terms icon" class="icon-footer">
                    <a href=<?php echo frontendURL."/privacyPage.php"?> class="text-white">Términos y Condiciones</a>
                </p>
                <p>
                    <img src="../assets/icons8-mapa-50.png" alt="Map icon" class="icon-footer">
                    <a href=<?php echo frontendURL."/siteMapPage.php"?> class="text-white">Mapa del sitio</a>
                </p>
            </div>
        </div>
        <div class="row text-center text-md-left">
            <div class="col-12 text-center mt-3">
                <p>
                    <img src="../assets/icons8-derechos-de-autor-50.png" alt="Terms icon" class="icon-footer">
                    Todos los derechos reservados Universidad Tecnologica Nacional Facultad Regional Rosario
                </p>
            </div>
        </div>
    </div>
</footer>