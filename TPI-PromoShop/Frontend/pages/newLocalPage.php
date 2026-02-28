<?php
require_once "../shared/authFunctions.php/admin.auth.function.php";
require_once "../shared/backendRoutes.dev.php";
require_once "../../Backend/logic/shopType.controller.php";
include "../components/messageModal.php";

$shopTypes = ShopTypeController::getAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alta de Local</title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../assets/styles/newLocalPage.css">
</head>

<body>
  <?php include "../components/header.php" ?>
  <?php include "../components/navBarByUserType.php" ?>

  <div class="container-fluid my-5 center-container" id="center-container">
    <div class="card card-custom" id="card-custom">
      <div class="row no-gutters">
        <div class="col-12 d-flex align-items-center">
          <div class="card-body p-4 p-lg-5 text-black w-100">
            <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Alta de Local</h5>
            <hr>
            <form method="post" action="<?php echo backendHTTPLayer . '/newLocal.http.php'; ?>" onsubmit="return validatePasswords();">
              <div class="form-outline mb-4">
                <label for="form2Example17">Nombre Local</label>
                <input type="text" id="form2Example17" name="local" class="form-control form-control-lg" required>
              </div>
              <div class="form-outline mb-4">
                <label for="ubiLocal">Ubicación Relativa</label>
                <input type="text" id="ubiLocal" name="ubiLocal" class="form-control form-control-lg" required>
              </div>
              <hr>
              <div class="form-outline mb-4">
                <label for="emailOwner">Email del dueño:</label>
                <input type="email" id="emailOwner" name="emailOwner" class="form-control form-control-lg" required>
              </div>
              <div class="form-group">
                  <label for="passwordOwner">Contraseña del Dueño</label>
                  <div class="input-group">
                      <input
                          type="password"
                          id="passwordOwner"
                          name="passwordOwner"
                          class="form-control form-control-lg"
                          pattern="^(?=.*[!@#$%^&*(),.?&quot;:{}|<>]).{8,}$"
                          title="La contraseña debe tener al menos 8 caracteres y un carácter especial."
                          required
                      />

                      <div class="input-group-append">
                          <button 
                              class="btn btn-outline-secondary toggle-password"
                              type="button"
                              data-target="passwordOwner">
                              <i class="fas fa-eye-slash"></i>
                          </button>
                      </div>
                  </div>
              </div>
              <div class="form-group">
                <label for="passwordOwner">Repita la Contraseña del Dueño</label>
                  <div class="input-group">
                      <input
                          type="password"
                          id="passwordOwner2"
                          name="passwordOwner2"
                          class="form-control form-control-lg"
                          pattern="^(?=.*[!@#$%^&*(),.?&quot;:{}|<>]).{8,}$"
                          title="La contraseña debe tener al menos 8 caracteres y un carácter especial."
                          required
                      />

                      <div class="input-group-append">
                          <button 
                              class="btn btn-outline-secondary toggle-password"
                              type="button"
                              data-target="passwordOwner2">
                              <i class="fas fa-eye-slash"></i>
                          </button>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                      <p id="error-message" class="error-message">Las contraseñas no coinciden.</p>
                  </div>
              </div>
              <hr>
              <div class="form-outline mb-4">
                <label for="opcion">Tipo de Local</label>
                <select id="opcion" name="shopType" class="form-control">
                  <?php foreach ($shopTypes as $shopType): ?>
                    <option value="<?= $shopType->getId(); ?>">
                      <?= htmlspecialchars($shopType->getType()); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="pt-1 mb-4">
                <button type="submit" class="btn btn-lg btn-block btn-outline-orange" id="btn-outline-orange">Aceptar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include "../components/footer.php" ?>
</body>
<script>
  function validatePasswords() {
        const password = document.getElementById("passwordOwner").value;
        const confirmPassword = document.getElementById("passwordOwner2").value;
        const errorMessage = document.getElementById("error-message");

        // mínimo 8 caracteres + al menos 1 carácter especial
        const regex = /^(?=.*[!@#$%^&*(),.?{}|<>]).{8,}$/;

        // Validar formato
        if (!regex.test(password)) {
            errorMessage.innerText = "La contraseña debe tener al menos 8 caracteres y un carácter especial.";
            errorMessage.style.display = "block";
            return false;
        }

        // Validar coincidencia
        if (password !== confirmPassword) {
            errorMessage.innerText = "Las contraseñas no coinciden.";
            errorMessage.style.display = "block";
            return false;
        }

        errorMessage.style.display = "none";
        return true;
    }

    document.addEventListener("DOMContentLoaded", function () {

  document.getElementById("error-message").style.display = "none";

  const toggleButtons = document.querySelectorAll(".toggle-password");

  toggleButtons.forEach(button => {
    button.addEventListener("click", function () {
      const targetId = this.getAttribute("data-target");
      const input = document.getElementById(targetId);
      const icon = this.querySelector("i");

      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      } else {
        input.type = "password";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      }
    });
  });
});
</script>
</html>