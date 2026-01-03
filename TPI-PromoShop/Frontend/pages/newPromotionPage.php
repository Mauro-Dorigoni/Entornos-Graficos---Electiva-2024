<?php
require_once "../shared/authFunctions.php/owner.auth.function.php";
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
    <title>Alta de Promoción</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/newPromoPage.css">
</head>
<body>
<?php include "../components/header.php" ?>
<?php include "../components/ownerNavBar.php" ?>
<div class="container-fluid my-5" id="center-container">
    <div class="card card-custom" id="card-custom">
        <div class="card-body p-4 p-lg-5 text-black">
            <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Alta de Promoción</h5>
            <hr>
            <form method="post" action="<?php echo backendHTTPLayer . '/newPromotion.http.php'; ?>" enctype="multipart/form-data">
                <div class="form-outline mb-4">
                    <label>
                        <i class="fas fa-pen mr-2"></i> Contenido
                    </label>
                    <textarea name="promoText" class="form-control form-control-lg" rows="4" required></textarea>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 form-outline mb-4">
                        <label>
                            <i class="far fa-calendar-alt mr-2"></i> Vigencia desde
                        </label>
                        <input type="date" name="dateFrom" class="form-control form-control-lg" required>
                    </div>
                    <div class="col-md-6 form-outline mb-4">
                        <label>
                            <i class="far fa-calendar-times mr-2"></i> Vigencia hasta
                        </label>
                        <input type="date" name="dateTo" class="form-control form-control-lg" required>
                    </div>
                </div>
                <hr>
                <div class="form-outline mb-4">
                    <label>
                        <i class="fas fa-image mr-2"></i> Imagen asociada
                    </label>
                    <div id="imagePreviewContainer"
                         onclick="document.getElementById('imageFile').click()">
                        <input type="file" id="imageFile" name="image" accept="image/*" style="display:none;" onchange="previewImage(event)">
                        <p class="text-muted mb-0">Click para subir imagen (JPG / PNG)</p>
                        <img id="imagePreview">
                    </div>
                </div>
                <hr>
                <div class="form-outline mb-4">
                    <label>
                        <i class="fas fa-users mr-2"></i> Público objetivo
                    </label>
                    <select name="userCategory" class="form-control form-control-lg" required>
                        <option value="" disabled selected>
                            Seleccione una categoría
                        </option>
                        <?php foreach ($userCategories as $cat): ?>
                            <option value="<?= $cat->getID(); ?>">
                                <?= htmlspecialchars($cat->getCategoryType()); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <hr>
                <div class="form-outline mb-4">
                    <label>
                        <i class="fas fa-calendar-check mr-2"></i> Días válidos
                    </label>
                    <div class="d-flex flex-wrap">
                        <?php
                        $days = [
                            'mon'=>'Lunes','tue'=>'Martes','wed'=>'Miércoles',
                            'thu'=>'Jueves','fri'=>'Viernes','sat'=>'Sábado','sun'=>'Domingo'
                        ];
                        foreach ($days as $key => $label): ?>
                            <div class="custom-control custom-checkbox mr-4">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="<?= $key ?>"
                                       name="validDays[]"
                                       value="<?= $key ?>"
                                       checked>
                                <label class="custom-control-label" for="<?= $key ?>">
                                    <?= $label ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <hr>
                <div class="pt-1 mb-4">
                    <button type="submit" class="btn btn-lg btn-block" id="btn-outline-orange"> Enviar a Revisión</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "../components/footer.php" ?>
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
