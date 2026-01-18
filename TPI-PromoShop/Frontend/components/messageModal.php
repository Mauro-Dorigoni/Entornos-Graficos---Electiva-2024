<!-- La logica de este componente tiene que ser retrabajada. Si bien hace lo que se supone, 
 impide navegar hacia atras en la pagina, ya que cierra la session, por lo cual tira error
 al intenta recuperar los mensajes -->
<?php
require_once "../shared/userType.enum.php";
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (isset($_SESSION['error_message']) || isset($_SESSION['success_message']) || isset($_SESSION['info_message'])):
?>
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

    <div class="modal-header" style="background-color: #006633; color: white; display: flex; align-items: center; justify-content: flex-start;">
        <img src="../assets/LogoPromoShopFondoVerde.png" alt="PromoShop Logo" style="width: 60px; margin-right: 10px;">
        <strong><h2 class="modal-title" id="messageModalLabel" style="margin: 0; color:#CC6600">PromoShop</h2></strong>
    </div>
      <div class="modal-body text-center" style="background-color: #eae8e0;">
        <?php 
          if (isset($_SESSION['error_message'])) {
              echo "<p style='color: red; font-size: 16px;'>"
                  . nl2br(htmlspecialchars($_SESSION['error_message'])) .
                  "</p>";
              unset($_SESSION['error_message']);
          }

          if (isset($_SESSION['success_message'])) {
              echo "<p style='color: green; font-size: 16px;'>"
                  . nl2br(htmlspecialchars($_SESSION['success_message'])) .
                  "</p>";
              unset($_SESSION['success_message']);
          }

          if (isset($_SESSION['info_message'])) {
              echo "<p style='font-size: 16px;'>"
                  . nl2br(htmlspecialchars($_SESSION['info_message'])) .
                  "</p>";
              unset($_SESSION['info_message']);
          }
        ?>
        <button type="button" class="btn" style="background-color: #CC6600; color: white;" data-bs-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
    messageModal.show();
</script>

<?php endif; ?>
