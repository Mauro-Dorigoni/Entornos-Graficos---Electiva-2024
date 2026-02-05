<?php
require_once __DIR__ . "/../shared/authFunctions.php/owner.auth.function.php";
require_once __DIR__ . "/../../Backend/logic/report.controller.php";
require_once __DIR__ . "/../../Backend/logic/shop.controller.php";

try {
    $owner = $_SESSION['user'];
    $shop = ShopController::getOneByOwner($owner);
    
    // Obtenemos el reporte usando el controlador
    $report = ReportController::ownerReport($shop);
    
    $promotions = $report->getPromotions();
    $uses = $report->getPromotionUses();
    $topDay = $report->getDay();
    $dateGen = $report->getDateGenerated();

} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Gestión - <?= htmlspecialchars($shop->getName()) ?></title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { background-color: #eae8e0 !important; }
        .report-card {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .stat-box {
            border: 1px solid #CC6600;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            background-color: #fffaf5;
        }
        .text-orange { color: #CC6600 !important; }
        
        /* Estilos para impresión */
        @media print {
            .no-print, .btn, footer, nav, header {
                display: none !important;
            }
            body { background-color: white !important; }
            .container { max-width: 100% !important; width: 100% !important; }
            .report-card { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body>
    <?php include "../components/header.php" ?>
    <div class="no-print">
        <?php include "../components/ownerNavBar.php" ?>
    </div>

    <main class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-4 font-weight-bold">Reporte de Local</h1>
            <button onclick="window.print()" class="btn btn-warning no-print">
                <i class="fas fa-file-pdf"></i> Imprimir PDF
            </button>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php else: ?>

            <div class="report-card">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h3><?= htmlspecialchars($shop->getName()) ?></h3>
                        <p class="text-muted">Generado el: <?= $dateGen->format('d/m/Y H:i') ?></p>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <div class="stat-box d-inline-block">
                            <small class="text-uppercase font-weight-bold">Día de semana con mayor uso de promociones</small>
                            <h4 class="text-orange mb-0"><?= htmlspecialchars($topDay ?? 'N/D') ?></h4>
                        </div>
                    </div>
                </div>

                <hr>

                <h4 class="mb-3 text-orange">Rendimiento de Promociones</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Descripción de Promoción</th>
                                <th class="text-center">Usos Totales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($promotions as $index => $promo): ?>
                                <tr>
                                    <td>#<?= $promo->getId() ?></td>
                                    <td><?= htmlspecialchars(substr($promo->getPromoText(), 0, 80)) ?>...</td>
                                    <td class="text-center font-weight-bold">
                                        <?= $uses[$index] ?? 0 ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (empty($promotions)): ?>
                    <p class="text-center text-muted">No hay promociones activas para analizar.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>

    <div class="no-print">
        <?php include "../components/footer.php" ?>
    </div>
</body>
</html>
