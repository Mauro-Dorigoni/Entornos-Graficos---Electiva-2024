<?php
require_once "../shared/frontendRoutes.dev.php";
require_once "../shared/backendRoutes.dev.php";
?>
<link rel="stylesheet" href="../assets/styles/footer.css">
<!-- Footer con todas sus opciones -->
<footer>
    <div class="footer-container">
        <div class="row text-center text-md-start">
            <div class="col-12 col-md-4 mb-3">
                <h3>Contacto</h3>
                <p>
                    <img src="../assets/icons8-teléfono-50.png" alt="Icono de un Telefono" class="icon-footer">
                    (0341)123-426-789
                </p>
                <p>
                    <img src="../assets/icons8-correo-50.png" alt="Icono de un Email" class="icon-footer">
                    graficosentornos@gmail.com
                </p>
                <span>
                    <img src="../assets/icons8-formulario-64.png" alt="Icono de un Formulario" class="icon-footer">
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
                    <img src="../assets/icons8-privacidad-50.png" alt="Icono de Privacidad" class="icon-footer">
                    <a href=<?php echo frontendURL . "/privacyPage.php" ?> class="text-white">Política de Privacidad</a>
                </p>
                <p>
                    <img src="../assets/icons8-términos-y-condiciones-50.png" alt="Iconos de Terminos" class="icon-footer">
                    <a href=<?php echo frontendURL . "/termsPage.php" ?> class="text-white">Términos y Condiciones</a>
                </p>
                <p>
                    <img src="../assets/icons8-mapa-50.png" alt="Icono de un Mapa" class="icon-footer">
                    <a href=<?php echo frontendURL . "/siteMapPage.php" ?> class="text-white">Mapa del sitio</a>
                </p>
                <p>
                    <img src="../assets/icons8-pregunta-50.png" alt="Pregunta icono" class="icon-footer ">
                    <a href=<?php echo frontendURL . "/faqPage.php" ?> class="text-white">Preguntas Frecuentes</a>
                </p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-12 mt-3">
                <p>
                    <img src="../assets/icons8-derechos-de-autor-50.png" alt="Terminos Icono" class="icon-footer">
                    Todos los derechos reservados Universidad Tecnologica Nacional Facultad Regional Rosario
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Modal de contacto. No creo que lo usemos en ninguna otra parte, entonces por ahora lo dejo aca. Sino, va en componente aparte -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="contactModalLabel">Formulario de Contacto</h4>
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