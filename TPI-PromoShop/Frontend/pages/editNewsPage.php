<?php
require_once "../shared/authFunctions.php/admin.auth.function.php";
require_once "../shared/backendRoutes.dev.php";
require_once "../../Backend/logic/news.controller.php";
require_once "../../Backend/logic/userCategory.controller.php";
include "../components/messageModal.php";

$idNews = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;
$news = null;

if ($idNews) {
    $n = new News();
    $n->setId($idNews);
    $news = NewsController::getOne($n);
}

if (is_null($news)) {
    $_SESSION['error_message'] = "Novedad Inexistente.";
    header("Location: adminNewsPage.php");
    exit;
}

$userCategories = UserCategoryController::getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Novedad - PromoShop</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/editShopPage.css"> 
    <style>
        .icon-orange { color: #ff8800; margin-right: 10px; }
        .form-control-locked { background-color: #e9ecef !important; opacity: 1; border: 1px solid #ced4da; }
        .page-header h2 { font-size: 1.8rem; color: #333; }
        .preview-img-edit { max-width: 200px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <?php include "../components/header.php" ?>
    <?php include "../components/adminNavBar.php" ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="page-header d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h2 class="font-weight-bold mb-0">Editar Novedad</h2>
                        <p class="text-muted mb-0">Modificando datos de la Novedad: <strong>#<?= $news->getId() ?></strong></p>
                    </div>
                    <i class="fas fa-bullhorn fa-3x text-black-50 opacity-25"></i>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="<?php echo backendHTTPLayer . '/updateNews.http.php';?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $news->getId() ?>">

                    <h5 class="text-muted mb-3 h6 font-weight-bold text-uppercase">Información de Registro</h5>
                    <div class="form-row mb-4">
                        <div class="col-md-4 mb-3">
                            <label class="form-label small text-muted">ID Novedad</label>
                            <input type="text" class="form-control form-control-locked" value="<?= $news->getId() ?>" readonly>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small text-muted">ID Administrador responsable</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-transparent pl-0"><i class="fas fa-user-shield icon-orange"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-locked" value="<?= $news->getAdmin()->getId() ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="form-group mb-4">
                        <label class="form-label font-weight-bold"><i class="fas fa-pen icon-orange"></i> Contenido de la Novedad</label>
                        <textarea name="newsText" class="form-control form-control-modern" rows="4" required><?= htmlspecialchars($news->getNewsText()) ?></textarea>
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold"><i class="far fa-calendar-alt icon-orange"></i> Fecha Desde</label>
                            <input type="date" name="dateFrom" class="form-control form-control-modern" value="<?= $news->getDateFrom() ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-weight-bold"><i class="far fa-calendar-check icon-orange"></i> Fecha Hasta</label>
                            <input type="date" name="dateTo" class="form-control form-control-modern" value="<?= $news->getDateTo() ?>" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label font-weight-bold"><i class="fas fa-users icon-orange"></i> Público Objetivo (Categoría)</label>
                        <select name="userCategory" class="form-control form-control-modern" required>
                            <?php foreach ($userCategories as $cat): ?>
                                <option value="<?= $cat->getID() ?>" <?= ($news->getUserCategory()->getID() == $cat->getID()) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat->getCategoryType()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <hr class="my-4">

                    <div class="form-group mb-4">
                        <h5 class="font-weight-bold text-dark mb-3">Imagen de la Novedad</h5>
                        <div class="text-center bg-light p-4 rounded border mb-3">
                            <?php 
                                $url = $news->getImageUUID() ? "../../Backend/shared/uploads/".$news->getImageUUID() : "../../Backend/shared/uploads/placeholder.jpg";
                            ?>
                            <img id="imagePreview" src="<?= $url ?>" class="preview-img-edit mb-3">
                            <div class="custom-file text-left">
                                <input type="file" name="image" class="custom-file-input" id="imageInput" accept="image/*" onchange="previewImage(event)">
                                <label class="custom-file-label" for="imageInput">Cambiar imagen...</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                        <a href="adminNewsPage.php" class="btn btn-light btn-lg mr-3 text-muted">Cancelar</a>
                        <button type="submit" class="btn btn-outline-orange btn-lg px-5 font-weight-bold">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "../components/footer.php" ?>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
            
            // Actualizar etiqueta del input file
            const fileName = event.target.files[0].name;
            const label = event.target.nextElementSibling;
            label.innerHTML = fileName;
        }
    </script>
</body>
</html>