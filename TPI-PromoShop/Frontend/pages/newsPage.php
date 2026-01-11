<?php
require_once __DIR__ . "/../shared/authFunctions.php/admin.auth.function.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";
require_once __DIR__ . "/../../Backend/logic/news.controller.php";
require_once __DIR__ . "/../shared/nextcloud.public.php";
include "../components/messageModal.php";
include "../components/confirmationModal.php"; 

// Capturamos el término de búsqueda si existe
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : null;

try {
    if ($searchTerm) {
        $novedades = NewsController::search($searchTerm); 
    } else {
        $novedades = NewsController::getAll(); 
    }
} catch (Exception $e) {
    $novedades = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Novedades - Fisherton Plaza</title>
    
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/newLocalPage.css">

    <style>
        body {
            background-color: #eae8e0 !important;
        }
        .news-card {
            cursor: pointer;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            transition: transform 0.2s;
            border: 1px solid #ddd;
        }
        .news-card:hover { transform: scale(1.01); background-color: #f9f9f9; }
        .text-orange { color: #CC6600 !important; }
        
        /* Estilos para la barra de búsqueda */
        .search-container .form-control:focus {
            border-color: #CC6600;
            box-shadow: 0 0 0 0.2rem rgba(204, 102, 0, 0.25);
        }
        .btn-search {
            background-color: #CC6600;
            color: white;
            border: none;
        }
        .btn-search:hover {
            background-color: #a35200;
            color: white;
        }
        
        .news-img-container { display: flex; justify-content: center; align-items: center; margin-bottom: 1rem; }
        .news-img { max-width: 150px; width: 100%; height: auto; border-radius: 4px; object-fit: cover; }
        .info-box { border: 1px solid #ccc; padding: 8px; text-align: center; background: #f8f9fa; border-radius: 4px; min-width: 110px; }
        .category-badge { color: #CC6600; font-weight: bold; text-decoration: underline; }
        .action-icons { display: flex; gap: 20px; justify-content: center; align-items: center; }
    </style>
</head>
<body>
    <?php include "../components/header.php"?>
    <?php include "../components/adminNavBar.php"?>

    <main class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 text-center text-md-left">
            <h1 class="display-4 font-weight-bold">Novedades</h1>
            
            <form action="newsPage.php" method="GET" class="search-container input-group col-12 col-md-5 mt-3 mt-md-0 p-0 shadow-sm">
                <input type="text" name="search" class="form-control" placeholder="Buscar por contenido..." 
                       value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <div class="input-group-append">
                    <button class="btn btn-search" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    <?php if($searchTerm): ?>
                        <a href="newsPage.php" class="btn btn-secondary shadow-none">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <section>
            <?php if (empty($novedades)): ?>
                <div class="alert alert-info text-center py-4">
                    <i class="fas fa-info-circle mr-2"></i>
                    <?= $searchTerm ? "No se encontraron resultados para '$searchTerm'." : "No hay novedades vigentes para mostrar." ?>
                </div>
            <?php endif; ?>

            <?php foreach ($novedades as $news): ?>
                <div class="news-card" onclick="window.location.href='newsDetailPage.php?id=<?= $news->getId() ?>'">
                    <div class="row align-items-center text-center text-md-left">
                        
                        <div class="col-12 col-md-2 news-img-container">
                            <img src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($news->getImageUUID()) ?>" class="news-img" alt="Novedad">
                        </div>
                        
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <h3 class="h5 font-weight-bold text-orange">Novedad #<?= $news->getId() ?></h3>
                            <p class="text-muted mb-0 small"><?= htmlspecialchars(substr($news->getNewsText(), 0, 100)) ?>...</p>
                        </div>

                        <div class="col-12 col-md-3 d-flex flex-column flex-sm-row flex-md-column justify-content-center align-items-center gap-2 mb-3 mb-md-0">
                            <div class="info-box m-1">
                                <small class="d-block font-weight-bold">Vigencia desde</small>
                                <span class="small"><?= date("d/m/Y", strtotime($news->getDateFrom())) ?></span>
                            </div>
                            <div class="info-box m-1">
                                <small class="d-block font-weight-bold">Vigencia hasta</small>
                                <span class="small"><?= date("d/m/Y", strtotime($news->getDateTo())) ?></span>
                            </div>
                        </div>

                        <div class="col-6 col-md-2 mb-3 mb-md-0">
                            <span class="category-badge"><?= htmlspecialchars($news->getUserCategory()->getCategoryType()) ?></span>
                        </div>

                        <div class="col-6 col-md-1">
                            <div class="action-icons">
                                <a href="editNewsPage.php?id=<?= $news->getId() ?>" class="text-orange" onclick="event.stopPropagation();">
                                    <i class="fas fa-edit fa-lg"></i>
                                </a>
                                <a href="javascript:void(0)" class="text-orange" 
                                   onclick="event.stopPropagation(); openConfirmModal('¿Quiere eliminar la novedad <strong><?= $news->getId() ?></strong>?', '../../Backend/http/deleteNews.http.php?id=<?= $news->getId() ?>', 'Confirmar Eliminación')">
                                    <i class="fas fa-times fa-2x"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>

    <?php include "../components/footer.php"?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>