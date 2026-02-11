<?php
require_once "../shared/authFunctions.php/admin.auth.function.php";
require_once "../shared/backendRoutes.dev.php";
include "../components/messageModal.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Tipo de Local</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/newShopTypePage.css">
</head>
<style>
    #center-container {
    min-height: 62vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>

<body>
  <?php include "../components/header.php"?>
  <?php include "../components/adminNavBar.php"?>
  
  <div class="container-fluid my-5 center-container" id="center-container">
    <div class="card card-custom" id="card-custom">
      <div class="row no-gutters">
        <div class="col-12 d-flex align-items-center">
          <div class="card-body p-4 p-lg-5 text-black w-100">
            <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Alta de Tipo Local</h5>
            <hr>
            <form method="post" action="<?php echo backendHTTPLayer . '/newShopType.http.php'; ?>">
              <div class="form-outline mb-4">
                <label for="form2Example17">Nombre del Tipo</label>
                <input type="text" id="form2Example17" name="tipoLocal" class="form-control form-control-lg" required>
              </div>
              <div class="form-outline mb-4">
                <label for="descTipoLocal">Breve descipcion</label>
                <textarea id="descTipoLocal" name="descTipoLocal" class="form-control form-control-lg" rows="3" required></textarea>
              </div>
              <hr>
              <div class="pt-1 mb-4">
                <button type="submit" class="btn btn-lg btn-block btn-outline-orange" id="btn-outline-orange">Aceptar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include "../components/footer.php"?>
</body>
</html>