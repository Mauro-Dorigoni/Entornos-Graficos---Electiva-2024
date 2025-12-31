<?php
require_once "../shared/authFunctions.php/admin.auth.function.php";
require_once "../shared/backendRoutes.dev.php";
require_once __DIR__ . "/../../Backend/logic/userCategory.controller.php";

include "../components/messageModal.php";

try {
    $userCategories = UserCategoryController::getAll();
} catch (Exception $e) {
    $userCategories = [];
    $_SESSION['error_message'] = "No se pudieron cargar las categorías.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Novedad</title>
    
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/newLocalPage.css">

    <style>
        /* Estilos Personalizados "Flat" */
        body {
            background-color: #fff; /* Fondo blanco limpio */
        }
        
        /* Título con línea inferior sutil */
        .page-header {
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
        }
        
        /* Inputs modernos: Fondo gris suave, sin bordes duros */
        .form-control-modern {
            background-color: #f8f9fa; /* bg-light de bootstrap */
            border: 1px solid #e9ecef;
            border-radius: 8px; /* Bordes un poco más redondeados */
            padding: 1.2rem 1rem; /* Más espacio interno */
            transition: all 0.3s;
        }
        
        .form-control-modern:focus {
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(255, 140, 0, 0.15); /* Sombra naranja suave */
            border-color: #ff8c00;
        }

        /* Íconos Naranjas */
        .icon-orange {
            color: #ff8c00;
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }

        /* Labels más visibles */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Previsualización de imagen */
        #imagePreviewContainer {
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s;
        }
        #imagePreviewContainer:hover {
            border-color: #ff8c00;
        }
        #imagePreview {
            max-height: 250px;
            max-width: 100%;
            border-radius: 5px;
            display: none;
            margin: 0 auto;
        }
    </style>
</head>
<body>
  <?php include "../components/header.php"?>
  <?php include "../components/adminNavBar.php"?>
  
  <div class="container py-5">
    
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="page-header d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="font-weight-bold text-dark mb-0">Nueva Novedad</h2>
                    <p class="text-muted mb-0 mt-1">Completa la información para publicar una noticia.</p>
                </div>
                <i class="fas fa-bullhorn fa-3x text-black-50 opacity-25"></i>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form method="post" action="<?php echo backendHTTPLayer . '/newNews.http.php'; ?>" enctype="multipart/form-data">
              
              <div class="form-group mb-4">
                <label class="form-label">
                    <i class="fas fa-pen icon-orange"></i> Contenido
                </label>
                <textarea name="newsText" class="form-control form-control-modern" rows="4" placeholder="¿Qué quieres comunicar hoy?" required></textarea>
              </div>

              <div class="row">
                  <div class="col-md-6 mb-4">
                    <label class="form-label">
                        <i class="far fa-calendar-alt icon-orange"></i> Vigencia Desde
                    </label>
                    <input type="date" name="dateFrom" class="form-control form-control-modern" required>
                  </div>
                  <div class="col-md-6 mb-4">
                    <label class="form-label">
                        <i class="far fa-calendar-times icon-orange"></i> Hasta (Opcional)
                    </label>
                    <input type="date" name="dateTo" class="form-control form-control-modern">
                  </div>
              </div>

              <div class="form-group mb-4">
                <label class="form-label">
                    <i class="fas fa-image icon-orange"></i> Imagen Destacada
                </label>
                
                <div id="imagePreviewContainer" onclick="document.getElementById('imageFile').click()">
                    <input type="file" id="imageFile" name="image" accept="image/*" style="display:none;" onchange="previewImage(event)">
                    
                    <div id="uploadPlaceholder">
                        <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Haz clic aquí para subir una imagen</p>
                        <small class="text-muted">(JPG, PNG - Máx 2MB)</small>
                    </div>
                    
                    <img id="imagePreview" src="#" alt="Previsualización">
                </div>
              </div>

              <div class="form-group mb-5">
                <label class="form-label">
                    <i class="fas fa-users icon-orange"></i> Dirigido a
                </label>
                <select name="userCategory" class="form-control form-control-modern" required>
                    <option value="" disabled selected>Seleccione el público objetivo...</option>
                    <?php foreach ($userCategories as $cat): ?>
                        <option value="<?= $cat->getID(); ?>">
                            <?= htmlspecialchars($cat->getCategoryType()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
              </div>

              <hr class="mb-4">
              <div class="d-flex justify-content-end">
                  <a href="listaNovedades.php" class="btn btn-light btn-lg mr-3 text-muted">Cancelar</a>
                  <button type="submit" class="btn btn-outline-orange btn-lg px-5 font-weight-bold">
                      Publicar
                  </button>
              </div>

            </form>
        </div>
    </div>
  </div>

  <?php include "../components/footer.php"?>

  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  
  <script>
      function previewImage(event) {
          var input = event.target;
          var preview = document.getElementById('imagePreview');
          var placeholder = document.getElementById('uploadPlaceholder');
          
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              
              reader.onload = function(e) {
                  preview.src = e.target.result;
                  preview.style.display = 'block';
                  placeholder.style.display = 'none'; // Ocultar el texto de "Subir"
              }
              
              reader.readAsDataURL(input.files[0]);
          }
      }
  </script>

</body>
</html>