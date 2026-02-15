<?php
require_once __DIR__ . "/../shared/authFunctions.php/user.auth.function.php";
require_once __DIR__ . "/../shared/userType.enum.php";
require_once __DIR__ . "/../../Backend/logic/userCategory.controller.php";
require_once __DIR__ . "/../../Backend/logic/user.controller.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'];
$userType = $_SESSION["userType"];
$uses = UserController::getPromoCount($user);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #eae8e0 !important;
        }

        .profile-card {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
            border: 1px solid #ddd;
        }

        .text-orange {
            color: #CC6600 !important;
        }

        .section-divider {
            border-top: 1px solid #ddd;
            margin: 2rem 0;
        }

        .progress {
            height: 20px;
        }

        .progress-bar {
            background-color: #CC6600;
        }

        .danger-zone {
            background: #fff5f5;
            border: 1px solid #f1c0c0;
            border-radius: 6px;
            padding: 1.5rem;
        }

        .progress-orange {
            background-color: #CC6600 !important;
        }
    </style>
</head>

<body>

    <?php include "../components/header.php" ?>
    <?php include "../components/navBarByUserType.php" ?>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-card">

                    <h1 class="font-weight-bold mb-4">Mi Perfil:</h1>
                    <div class="alert alert-info">
                         <?php echo ($user->getEmail()) ?>
                    </div>


                    <!-- USER -->
                    <?php if ($userType === UserType_enum::User): ?>
                        <?php
                        $uses = UserController::getPromoCount($user);

                        if ($uses < 10) {
                            $currentCategory = 'Inicial';
                            $nextCategory = 'Medium';
                            $currentBase = 0;
                            $nextThreshold = 10;
                        } elseif ($uses < 25) {
                            $currentCategory = 'Medium';
                            $nextCategory = 'Premium';
                            $currentBase = 10;
                            $nextThreshold = 25;
                        } else {
                            $currentCategory = 'Premium';
                            $nextCategory = null;
                        }

                        if ($nextCategory) {
                            $progress = (($uses - $currentBase) / ($nextThreshold - $currentBase)) * 100;
                            $remaining = $nextThreshold - $uses;
                        } else {
                            $progress = 100;
                            $remaining = 0;
                        }
                        ?>

                        <h4 class="text-orange">Categoría de usuario</h4>
                        <p class="mb-1">
                            <strong><?= $currentCategory ?></strong>
                        </p>

                        <?php if ($nextCategory): ?>
                            <small class="text-muted">
                                Próximo nivel: <?= $nextCategory ?>
                            </small>

                            <div class="progress my-3">
                                <div class="progress-bar progress-orange"
                                    role="progressbar"
                                    style="width: <?= (int)$progress ?>%;">
                                    <?= (int)$progress ?>%
                                </div>
                            </div>

                            <p class="mb-0">
                                Usos restantes para subir de nivel:
                                <strong><?= $remaining ?></strong>
                            </p>
                        <?php else: ?>
                            <div class="alert alert-success mt-3">
                                Ya alcanzaste la categoría máxima (Premium).
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>


                    <!-- OWNER -->
                    <?php if ($userType === UserType_enum::Owner): ?>
                        <?php
                        require_once __DIR__ . "/../../Backend/logic/shop.controller.php";
                        $shop = ShopController::getOneByOwner($user);
                        $shop = ShopController::getOne($shop);
                        ?>

                        <h4 class="text-orange">Mi Local</h4>

                        <?php if ($shop): ?>
                            <p class="mb-1"><strong>Nombre:</strong> <?= htmlspecialchars($shop->getName()) ?></p>
                            <p class="mb-1"><strong>Tipo:</strong> <?= htmlspecialchars($shop->getShopType()->getType()) ?></p>

                        <?php else: ?>
                            <div class="alert alert-warning">
                                No se encontró un local asociado a este usuario.
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- ADMIN -->
                    <?php if ($userType === UserType_enum::Admin): ?>
                        <h4 class="text-orange">Rol</h4>
                        <div class="alert alert-info">
                            Administrador del sitio
                        </div>
                    <?php endif; ?>

                    <div class="section-divider"></div>

                    <!-- ACCOUNT ACTIONS -->
                    <h4 class="text-orange mb-3">Cuenta</h4>

                    <div class="mb-3">
                        <button class="btn btn-outline-secondary btn-block"
                            data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">
                            Cambiar contraseña
                        </button>
                    </div>
                    <div class="mb-3">
                        <a href="<?= backendHTTPLayer . '/logout.http.php' ?>"
                            class="btn btn-outline-secondary btn-block">
                            Cerrar sesión
                        </a>
                    </div>
                    <div class="danger-zone text-center">
                        <button class="btn btn-danger"
                            onclick="openConfirmModal(
                            '¿Estás seguro de que deseas eliminar tu cuenta?',
                            '<?= backendHTTPLayer ?>/deleteAccount.http.php',
                            'Eliminar cuenta'
                        )">
                            Eliminar mi cuenta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- CHANGE PASSWORD MODAL -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header" style="background-color: #006633; color: white;">
                    <img src="../assets/LogoPromoShopFondoVerde.png" style="width:60px; margin-right:10px;">
                    <h5 class="modal-title" style="color:#CC6600;">Cambiar contraseña</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="background-color:#eae8e0;">
                    <form method="POST" action="<?= backendHTTPLayer ?>/changePasswordProfile.http.php">

                        <div class="mb-3">
                            <label>Contraseña actual</label>
                            <input type="password" name="current_pass" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Nueva contraseña</label>
                            <input type="password" name="new_pass" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Confirmar nueva contraseña</label>
                            <input type="password" name="new_pass2" class="form-control" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn" style="background-color:#CC6600; color:white;">
                                Actualizar contraseña
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php include "../components/footer.php" ?>
    <?php include "../components/confirmationModal.php" ?>
    <?php include "../components/messageModal.php" ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>