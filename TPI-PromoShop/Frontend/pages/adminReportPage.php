<?php
require_once __DIR__ . "/../shared/authFunctions.php/admin.auth.function.php";
require_once __DIR__ . "/../../Backend/logic/report.controller.php"; 
require_once __DIR__ . "/../../Backend/structs/adminReport.class.php";

try {
    // Llamada al método del controlador
    $reportData = ReportController::adminReport();
    
    // Extracción de objetos para facilitar el uso en el HTML
    $topPromo = $reportData->getTopUsedPromotion();
    $topUser  = $reportData->getTopUser();
    $shops    = $reportData->getShops();
    
    $dateGen = new DateTime();
} catch (Exception $e) {
    // Manejo básico de errores: podrías redirigir o mostrar un mensaje
    die("Error crítico: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General - Fisherton Plaza</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body { background-color: #eae8e0 !important; }
        .text-orange { color: #CC6600 !important; }
        .bg-orange { background-color: #CC6600 !important; }
        
        .report-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            border: none;
        }

        .top-stat-box {
            background: #fff;
            border-left: 5px solid #CC6600;
            border-radius: 10px;
            padding: 20px;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .icon-circle {
            width: 45px;
            height: 45px;
            background: #fffaf5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #CC6600;
            margin-bottom: 15px;
        }

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
        <?php include "../components/adminNavBar.php" ?>
    </div>

    <main class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="display-4 font-weight-bold">Reporte Gerencial</h1>
            </div>
            <button onclick="window.print()" class="btn btn-warning no-print shadow-sm">
                <i class="fas fa-file-pdf"></i> Imprimir PDF
            </button>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="top-stat-box">
                    <div class="icon-circle">
                        <i class="fas fa-crown fa-lg"></i>
                    </div>
                    <small class="text-uppercase font-weight-bold text-muted">Promoción más utilizada</small>
                    <h4 class="mt-2 font-weight-bold text-orange"><?= htmlspecialchars($topPromo->getPromoText()) ?></h4>
                    <p class="mb-0 small text-secondary">ID Promoción: #<?= $topPromo->getId() ?></p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="top-stat-box">
                    <div class="icon-circle">
                        <i class="fas fa-user-check fa-lg"></i>
                    </div>
                    <small class="text-uppercase font-weight-bold text-muted">Usuario con más canjes</small>
                    <h4 class="mt-2 font-weight-bold"><?= htmlspecialchars($topUser->getEmail()) ?></h4>
                    <p class="mb-0 small text-success">Líder en beneficios utilizados</p>
                </div>
            </div>
        </div>

        <div class="report-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="font-weight-bold mb-0 text-orange">Uso por Local</h4>
                <span class="text-muted small">Generado: <?= $dateGen->format('d/m/Y H:i') ?></span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Local</th>
                            <th class="text-center">Descuentos Usados</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Iteramos sobre el array de objetos Shop
                        foreach ($shops as $shop): 
                            // Nota: Asumo que el objeto Shop tiene métodos getName() o similares
                            // Y que necesitas llamar a PromoUseData para el conteo si no está en el objeto
                            $uses = PromoUseData::countUsedByShop($shop);
                        ?>
                            <tr>
                                <td class="font-weight-bold"><?= htmlspecialchars($shop->getName()) ?></td>
                                <td class="text-center">
                                    <span class="badge badge-pill bg-orange text-white py-2 px-3">
                                        <?= $uses ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="no-print">
        <?php include "../components/footer.php" ?>
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>
</html>