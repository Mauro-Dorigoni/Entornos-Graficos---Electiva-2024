<?php
    require_once "../shared/frontendRoutes.dev.php";
    require_once "../shared/backendRoutes.dev.php";
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="../assets/styles/footer.css">
<!-- NO ME PREGUNTEN PQ SI PONGO ESTE CSS EN EL ARCHIVO SEPARADO NO ANDA, NO SUPE RESOLVERLO EN JAVA, NO PUEDO RESOVERLO ACA -->
<style>
    @media (max-width: 840px) {
        .footer-container{
        margin-left: 0px;
    }
    }
    #contactModal #contactModalLabel {
        color: #CC6600;
        font-weight: bolder;
    }
    #contactModal .modal-header {
        background-color: #006633;
    }
    #contactModal .modal-content {
        background-color: #eae8e0;
    }
    #contactModal #submitContactFormButton {
        background-color: #CC6600;
        border-color: #CC6600;
    }
    #contactModal .btn-close.custom-close {
        background-color: #CC6600;
        border-radius: 10%;
        opacity: 1;
    }
    p, a {
        text-decoration: none;
    }
    span a {
        text-decoration: none;
    }
</style>
<!-- Footer con todas sus opciones -->
<footer>
    <div class="footer-container">
        <div class="row text-center text-md-start">
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#contactModal" class="text-white">Formulario de Contacto</a>
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
        <div class="row text-center">
            <div class="col-12 mt-3">
                <p>
                    <img src="../assets/icons8-derechos-de-autor-50.png" alt="Terms icon" class="icon-footer">
                    Todos los derechos reservados Universidad Tecnologica Nacional Facultad Regional Rosario
                </p>
            </div>
        </div>
    </div>
</footer>
<!-- Modal de contacto. No creo que lo usemos en ninguna otra parte, entonces por ahora lo dejo aca. Sino, va en componente aparte -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contactModalLabel">Formulario de Contacto</h5>
        <button type="button" class="btn-close custom-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action=<?php echo backendHTTPLayer . '/contact.http.php'; ?>>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="mb-3">
            <!-- Se podria hacer que cuando el usuario esta logeado que precomplete el campo con el email del usuario. Por ahora queda simple -->
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="mensaje" class="form-label">Consulta</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success" id="submitContactFormButton">Enviar</button>
        </div>
      </form>
    </div>
  </div>
</div>