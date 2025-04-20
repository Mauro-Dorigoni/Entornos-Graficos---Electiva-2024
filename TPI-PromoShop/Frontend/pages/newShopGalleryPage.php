<?php
require_once "../shared/authFunctions.php/owner.auth.function.php";
require_once "../shared/backendRoutes.dev.php";
include "../components/messageModal.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Galeria de Local</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/newShopGalleryPage.css">
</head>
<body>
  <?php include "../components/header.php"?>
  <?php include "../components/ownerNavBar.php"?>
  <div class="container-fluid center-container" id="center-container">
  <div class="card card-custom" id="card-custom">
    <div class="row no-gutters">
      <div class="col-12 d-flex align-items-center">
        <div class="card-body p-4 p-lg-5 text-black w-100">
          <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Alta de Galeria del Local</h5>
          <hr>
          <form method="post" action="<?php echo backendHTTPLayer . '/shopGallery.http.php'; ?>" enctype="multipart/form-data">
            <div class="form-outline mb-4">
              <label for="imagenes">Seleccione Imágenes. 
                Puede seleccionar hasta 5 imagenes (subalas todas de una sola vez)</label>
              <input type="file" id="imagenes" name="imagen[]" accept="image/*" class="form-control form-control-lg" multiple required onchange="checkFiles(this)">
              <div id="fileList" class="mt-3"></div>
              <input type="hidden" name="idLocal" id="hiddeninput" value="2">
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

  <?php include "../components/footer.php"?>
</body>
</html>

<script>
  function checkFiles(input) {
  const maxFiles = 5;
  const fileList = document.getElementById('fileList');
  
  fileList.innerHTML = "";

  if (input.files.length > maxFiles) {
    alert(`Solo podés seleccionar hasta ${maxFiles} imágenes.`);
    input.value = ""; 
    return;
  }

  const ul = document.createElement('ul');
  ul.classList.add('list-unstyled');

  for (let i = 0; i < input.files.length; i++) {
    const li = document.createElement('li');
    li.textContent = `📷 ${input.files[i].name}`;
    ul.appendChild(li);
  }

  fileList.appendChild(ul);
  }
</script>