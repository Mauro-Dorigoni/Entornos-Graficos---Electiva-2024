<?php
require_once "../shared/authFunctions.php/admin.auth.function.php";
require_once "../shared/backendRoutes.dev.php";
require_once "../../Backend/logic/news.controller.php";
require_once "../../Backend/logic/userCategory.controller.php";
require_once __DIR__ . "/../shared/nextcloud.public.php"; 
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
    header("Location: newsPage.php");
    exit;
}

try {
    $userCategories = UserCategoryController::getAll();
} catch (Exception $e) {
    $userCategories = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Novedad - PromoShop</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/newNewsPage.css"> 
    <style>
        /* Iconos en negro */
        .icon-black { color: #000; margin-right: 10px; }
        
        /* Estilo para el botón naranja solicitado */
        #btn-outline-orange {
            background-color: #CC6600;
            color: white;
            border: none;
            transition: background-color 0.3s;
        }
        #btn-outline-orange:hover {
            background-color: #a35200;
        }

        /* Estilo para el botón cancelar */
        .btn-cancelar {
            background-color: #6c757d;
            color: white;
            border: none;
        }
        .btn-cancelar:hover {
            background-color: #5a6268;
            color: white;
            text-decoration: none;
        }

        /* Recuadro de imagen igual a newNews */
        #imagePreviewContainer {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        #imagePreview {
            max-width: 100%;
            max-height: 300px;
            margin-top: 15px;
            border-radius: 4px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <?php include "../components/header.php" ?>
    <?php include "../components/adminNavBar.php" ?>

    <div class="container-fluid my-5" id="center-container">
        <div class="card card-custom" id="card-custom">
            <div class="card-body p-4 p-lg-5 text-black">
                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Editar Novedad #<?= $news->getId() ?></h5>
                <hr>

                <form method="post" action="<?php echo backendHTTPLayer . '/updateNews.http.php'; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $news->getId() ?>">

                    <div class="form-outline mb-4">
                        <label>
                            <i class="fas fa-pen icon-black"></i> Contenido
                        </label>
                        <textarea name="newsText" class="form-control form-control-lg" rows="4" required><?= htmlspecialchars($news->getNewsText()) ?></textarea>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6 form-outline mb-4">
                            <label>
                                <i class="far fa-calendar-alt icon-black"></i> Vigencia desde
                            </label>
                            <input type="date" name="dateFrom" class="form-control form-control-lg" value="<?= $news->getDateFrom() ?>" required>
                        </div>
                        <div class="col-md-6 form-outline mb-4">
                            <label>
                                <i class="far fa-calendar-times icon-black"></i> Vigencia hasta (opcional)
                            </label>
                            <input type="date" name="dateTo" class="form-control form-control-lg" value="<?= $news->getDateTo() ?>">
                        </div>
                    </div>
                    <hr>

                    <div class="form-outline mb-4">
                        <label>
                            <i class="fas fa-image icon-black"></i> Imagen destacada
                        </label>
                        <div id="imagePreviewContainer" onclick="document.getElementById('imageFile').click()">
                            <input type="file" id="imageFile" name="image" accept="image/*" style="display:none;" onchange="previewImage(event)">
                            <p class="text-muted mb-0"> Click para cambiar imagen (JPG / PNG)</p>
                            <?php 
                                $url = $news->getImageUUID() ? NEXTCLOUD_PUBLIC_BASE . urlencode($news->getImageUUID()) : "../../Backend/shared/uploads/placeholder.jpg";
                            ?>
                            <img id="imagePreview" src="<?= $url ?>">
                        </div>
                    </div>
                    <hr>

                    <div class="form-outline mb-4">
                        <label>
                            <i class="fas fa-users icon-black"></i> Público objetivo
                        </label>
                        <select name="userCategory" class="form-control form-control-lg" required>
                            <?php foreach ($userCategories as $cat): ?>
                                <option value="<?= $cat->getID(); ?>" <?= ($news->getUserCategory()->getID() == $cat->getID()) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat->getCategoryType()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <hr>

                    <div class="row pt-1 mb-4">
                        <div class="col-6">
                            <a href="newsPage.php" class="btn btn-lg btn-block btn-cancelar">Cancelar</a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-lg btn-block" id="btn-outline-orange">Guardar Cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "../components/footer.php" ?>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
    </script>
</body>
</html>