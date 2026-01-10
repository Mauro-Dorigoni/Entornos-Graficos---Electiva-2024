<?php
//no solo es para admin. Lo sacamos
//require_once "../shared/authFunctions.php/admin.auth.function.php";
//require_once "../shared/authFunctions.php/owner.auth.function.php";

require_once "../shared/backendRoutes.dev.php";
require_once "../shared/frontendRoutes.dev.php";
require_once "../shared/nextcloud.public.php";
require_once "../../Backend/logic/shopType.controller.php";
require_once "../../Backend/logic/shop.controller.php";
require_once "../../Backend/structs/shop.class.php";
include "../components/messageModal.php";

//Obtener ID y Datos del Local
$idLocal = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : 0;
$shop = null;

if ($idLocal) {
    $s = new Shop();
    $s->setId($idLocal);
    $shop = ShopController::getOne($s);
}

// Si no existe el local [solo editando id desde url], redirigir o mostrar error. NO SE SI ES LA FORMA CORRECTA. LAUTARO
if (is_null($shop)) {
    header("Location: " . frontendURL . "/shopsCardsPage.php");
    $_SESSION['error_message'] = "Local Inexistente. Intente nuevamente.";
    exit;
}

if (!isset($_SESSION['user']) || $_SESSION['userType'] == UserType_enum::User) {
    $_SESSION['error_message'] = "No tienes permisos para acceder a esta pagina";
    header("Location: " . frontendURL . "/loginPage.php");
    exit;
}

// Obtener Tipos para el Select
$shopTypes = ShopTypeController::getAll();
$soloLectura = true;
// Si es Admin puede editar propiedades
if (isset($_SESSION['user']) && $_SESSION['userType'] === UserType_enum::Admin) {
    $soloLectura = false;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Local - <?= htmlspecialchars($shop->getName()) ?></title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/editShopPage.css">

</head>

<body>
    <?php include "../components/header.php" ?>

    <?php include "../components/navBarByUserType.php" ?>

    <div class="container py-5 ">

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="page-header d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="font-weight-bold text-dark mb-0">Editar Local</h2>
                        <p class="text-muted mb-0 mt-1">Modificando datos de: <strong><?= htmlspecialchars($shop->getName()) ?></strong>- SoloLectura: <?= htmlspecialchars($soloLectura) ?></p>
                    </div>
                    <i class="fas fa-store-alt fa-3x text-black-50 opacity-25"></i>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form method="post" action="<?php echo backendHTTPLayer . '/updateShop.http.php'; ?>" enctype="multipart/form-data">
                    <input type="hidden" name="idShop" value="<?= $shop->getId() ?>">

                    <h5 class="text-muted mb-3 h6 font-weight-bold">Información del Dueño</h5>

                    <div class="form-row mb-4">
                        <div class="col-md-4 mb-3">
                            <label class="form-label small text-muted">ID Dueño</label>
                            <input type="text" class="form-control form-control-locked" value="<?= $shop->getOwner()->getId() ?>" readonly>
                            <!-- DUDA: Le dejamos editar el ID del dueño o solo el correo. Porque sino debemos verificar que sea existente... FUERA DE ALCANCE CAMBIAR UN LOCAL DE DUEÑO - SOLO MODIFICA EMAIL (EL ADMIN) -->
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small text-muted">Email de contacto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-transparent pl-0"><i class="fas fa-envelope icon-orange"></i></span>
                                </div>
                                <input name="emailOwner" type="text" class="form-control <?= $soloLectura ? "form-control-locked" : '' ?>" value="<?= htmlspecialchars($shop->getOwner()->getEmail()) ?>" <?= $soloLectura ? 'readonly' : '' ?>>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">


                    <div class="form-row mb-4">
                        <div class="col-md-4">
                            <label class="form-label small text-muted">ID Local</label>
                            <input type="text" class="form-control form-control-locked" value="<?= $shop->getId() ?>" readonly>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small text-muted">Ubicación</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-transparent pl-0"><i class="fas fa-map-marker-alt icon-orange"></i></span>
                                </div>
                                <input name="location" type="text" class="form-control <?= $soloLectura  ? "form-control-locked" : '' ?>" value="<?= htmlspecialchars($shop->getLocation()) ?>" <?= $soloLectura ? 'readonly' : '' ?>>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label"><i class="fas fa-signature icon-orange"></i> Nombre del Local</label>
                        <input type="text" name="shopName" class="form-control form-control-modern" value="<?= htmlspecialchars($shop->getName()) ?>" required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label"><i class="fas fa-tags icon-orange"></i> Categoría</label>
                        <select name="shopType" class="form-control form-control-modern" required>
                            <?php foreach ($shopTypes as $type): ?>
                                <option value="<?= $type->getId() ?>"
                                    <?= ($shop->getShopType()->getId() == $type->getId()) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($type->getType()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label"><i class="fas fa-align-left icon-orange"></i> Descripción</label>
                        <textarea name="shopDescription" class="form-control form-control-modern" rows="4"><?= htmlspecialchars($shop->getDescription() ?? '') ?></textarea>

                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label"><i class="far fa-clock icon-orange"></i> Horarios de Atención (Texto)</label>
                        <input type="text" name="hoursText" class="form-control form-control-modern"
                            value="<?= htmlspecialchars($shop->getOpeningHours() ?? 'Lunes a Domingo 9-21hs'); ?>"
                            placeholder="Ej: Lun a Vie 09:00 - 18:00">
                    </div>

                    <hr class="my-5">

                    <!-- GALERIA DE IMAGENES -->

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="font-weight-bold text-dark mb-1">Galería de Imágenes</h5>
                            <p class="text-muted small mb-0" id="instructionText">Haz clic para seleccionar <strong>Portada</strong>.</p>
                        </div>

                        <button type="button" class="btn btn-outline-secondary btn-sm shadow-sm" id="btnToggleDelete" onclick="toggleDeleteMode()">
                            <i class="fas fa-trash-alt mr-2"></i> <span>Eliminar Imágenes</span>
                        </button>
                    </div>

                    <div class="row" id="galleryGrid">

                        <?php
                        $images = $shop->getImages();
                        ?>

                        <?php if (empty($images)): ?>
                            <div class="col-12 text-center text-muted py-4" id="emptyMessage">
                                <i class="far fa-images fa-2x mb-2"></i>
                                <p>No hay imágenes cargadas.</p>
                            </div>
                        <?php else: ?>

                            <?php foreach ($images as $img): ?>
                                <?php
                                $uuid = $img->getUuid();
                                $isMain = $img->isMain();
                                // Asegúrate que la ruta sea correcta
                                $url =  NEXTCLOUD_PUBLIC_BASE . urlencode($img->getUUID());
                                ?>
                                <div class="col-6 col-md-4 col-lg-3 mb-4">

                                    <div class="gallery-item w-100 h-100 bg-light shadow-sm <?= $isMain ? 'is-main' : '' ?>"
                                        onclick="handleCardClick(this)">

                                        <img src="<?= $url ?>" class="w-100 h-100" style="object-fit: cover; height: 160px;">

                                        <span class="badge-main"><i class="fas fa-star"></i> PORTADA</span>

                                        <span class="badge-trash"><i class="fas fa-trash-alt"></i></span>

                                        <input type="radio" name="setMainUuid" value="<?= $uuid ?>" class="d-none" <?= $isMain ? 'checked' : '' ?>>

                                        <input type="checkbox" name="deleteUuids[]" value="<?= $uuid ?>" class="d-none">
                                    </div>

                                </div>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </div>

                    <div class="card bg-light border-0 mt-3">
                        <div class="card-body">
                            <label class="form-label font-weight-bold"><i class="fas fa-cloud-upload-alt icon-orange"></i> Agregar Nuevas</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="newImages" name="newImages[]" multiple accept="image/*" onchange="previewFiles(this)">
                                <label class="custom-file-label" for="newImages">Seleccionar archivos...</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-5">
                        <a href="shopsCardsPage.php" class="btn btn-light btn-lg mr-3 text-muted">Cancelar</a>
                        <button type="submit" class="btn btn-lg px-5 font-weight-bold btn-outline-orange" id="btn-outline-orange">
                            Guardar Cambios
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php include "../components/footer.php" ?>
</body>

<script>
    // ESTADO GLOBAL: ¿Estamos borrando o seleccionando?
    let isDeleteMode = false;

    // 1. FUNCIÓN PARA CAMBIAR DE MODO (Toggle)
    function toggleDeleteMode() {
        isDeleteMode = !isDeleteMode; // Invertir estado

        const btn = document.getElementById('btnToggleDelete');
        const grid = document.getElementById('galleryGrid');
        const text = document.getElementById('instructionText');
        const span = btn.querySelector('span');

        if (isDeleteMode) {
            // MODO BORRAR ACTIVO
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-danger'); // Botón rojo
            span.innerText = "Terminar Selección";

            grid.classList.add('mode-delete-active'); // CSS para cambiar hover
            text.innerHTML = "Haz clic en las fotos que quieras <strong class='text-danger'>BORRAR</strong>.";
        } else {
            // MODO NORMAL (PORTADA)
            btn.classList.remove('btn-danger');
            btn.classList.add('btn-outline-secondary');
            span.innerText = "Eliminar Imágenes";

            grid.classList.remove('mode-delete-active');
            text.innerHTML = "Haz clic en una foto para seleccionarla como <strong>Portada</strong>.";
        }
    }

    // 2. FUNCIÓN MAESTRA DEL CLICK
    function handleCardClick(card) {

        if (isDeleteMode) {
            // --- ESTAMOS EN MODO BORRAR ---

            // Protección: No dejar borrar la que es portada actualmente
            // (Si quieres permitirlo, borra este if)
            if (card.classList.contains('is-main') && !card.classList.contains('is-deleted')) {
                alert("Esta imagen es la portada actual. Elige otra portada antes de borrarla.");
                return;
            }

            // Toggle visual (Gris + Icono Basura)
            card.classList.toggle('is-deleted');

            // Toggle lógico (Checkbox oculto)
            const checkbox = card.querySelector('input[type="checkbox"]');
            if (checkbox) checkbox.checked = !checkbox.checked;

        } else {
            // --- ESTAMOS EN MODO SELECCIÓN DE PORTADA ---

            // Si la imagen está marcada para borrar, no hacemos nada
            if (card.classList.contains('is-deleted')) return;

            // 1. Limpiar todas las otras portadas
            document.querySelectorAll('.gallery-item').forEach(el => el.classList.remove('is-main'));

            // 2. Marcar esta visualmente
            card.classList.add('is-main');

            // 3. Marcar el Radio Button oculto
            const radio = card.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        }
    }

    // 3. PREVISUALIZAR IMÁGENES NUEVAS
    function previewFiles(input) {
        const grid = document.getElementById('galleryGrid');
        const files = input.files;
        const label = input.nextElementSibling;

        // Actualizar texto input
        if (files.length > 0) {
            label.classList.add("selected");
            label.innerHTML = files.length + " archivos seleccionados";
        } else {
            label.innerHTML = "Seleccionar archivos...";
        }

        // Limpiar previsualizaciones viejas
        document.querySelectorAll('.is-new-preview').forEach(el => el.remove());

        // Ocultar mensaje de "vacio" si existe
        const emptyMsg = document.getElementById('emptyMessage');
        if (emptyMsg) emptyMsg.style.display = 'none';

        Array.from(files).forEach((file, index) => {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const tempId = 'new_' + index;

                // GENERAMOS EL MISMO HTML QUE EN PHP
                const html = `
                <div class="col-6 col-md-4 col-lg-3 mb-4 fade-in is-new-preview">
                    <div class="gallery-item w-100 h-100 bg-light shadow-sm" onclick="handleCardClick(this)">
                        
                        <img src="${e.target.result}" class="w-100 h-100" style="object-fit: cover; height: 160px;">
                        
                        <span class="badge-main"><i class="fas fa-star"></i> PORTADA</span>
                        <span class="badge-trash"><i class="fas fa-trash-alt"></i></span>
                        
                        <span class="badge badge-success" style="position:absolute; bottom:5px; right:5px; z-index:20;">NUEVA</span>

                        <input type="radio" name="setMainUuid" value="${tempId}" class="d-none">
                        </div>
                </div>
                `;
                grid.insertAdjacentHTML('beforeend', html);
            }
            reader.readAsDataURL(file);
        });
    }

    // Animación de entrada
    document.write('<style>.fade-in { animation: fadeIn 0.5s; } @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }</style>');
</script>


</html>