<?php
require_once __DIR__ . "/../shared/authFunctions.php/user.auth.function.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";
require_once __DIR__ . "/../../Backend/logic/news.controller.php";
require_once __DIR__ . "/../../Backend/logic/userCategory.controller.php";
require_once __DIR__ . "/../shared/nextcloud.public.php";
include "../components/messageModal.php";
include "../components/confirmationModal.php"; 

$user = $_SESSION['user'];
$isAdmin = $user->isAdmin();

$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$dateFrom = !empty($_GET['f_desde']) ? $_GET['f_desde'] : null;
$dateTo = !empty($_GET['f_hasta']) ? $_GET['f_hasta'] : null;
$filterCatId = !empty($_GET['f_cat']) ? (int)$_GET['f_cat'] : null;

try {
    $userCategories = UserCategoryController::getAll();
    $novedades = NewsController::getFilteredNews($user, $search, $dateFrom, $dateTo, $filterCatId);
} catch (Exception $e) {
    $novedades = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novedades - PromoShop</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { background-color: #eae8e0 !important; }
        .text-orange { color: #CC6600 !important; }
        
        /* Barra de búsqueda unificada según requerimiento visual */
        .search-wrapper {
            background: white;
            border-radius: 8px;
            display: flex;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .search-wrapper .form-control { border: none; height: 50px; box-shadow: none; }

        .btn-unified {
            border: none;
            width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white !important;
            cursor: pointer;
            border-radius: 0; /* Puntas no redondeadas entre botones */
            text-decoration: none !important;
        }
        .btn-unified:hover { opacity: 0.9; text-decoration: none !important; }

        .bg-orange-btn { background-color: #CC6600 !important; }
        .bg-grey-btn { background-color: #6c757d !important; border-top-right-radius: 8px; border-bottom-right-radius: 8px; }

        /* Tarjetas de Novedades */
        .news-card {
            cursor: pointer;
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            transition: transform 0.2s;
        }
        .news-card:hover { transform: scale(1.01); background-color: #fcfcfc; }
        .news-img { max-width: 140px; border-radius: 4px; }
        .info-box { border: 1px solid #ccc; padding: 5px 10px; text-align: center; background: #f8f9fa; border-radius: 4px; }
        .category-badge { color: #CC6600; font-weight: bold; text-decoration: underline; white-space: nowrap; font-size: 1.1rem; }
        
        .news-content-center {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        /* Botones de acción horizontales y grandes */
        .action-btn-large {
            font-size: 1.6rem;
            transition: transform 0.2s;
            text-decoration: none !important;
        }
        .action-btn-large:hover { transform: scale(1.2); text-decoration: none !important; }
    </style>
</head>
<body>
    <?php include "../components/header.php"?>
    <?php include "../components/navBarByUserType.php"?>

    <main class="container py-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-4"> <h1 class="font-weight-bold display-4">Novedades</h1> </div>
            <div class="col-md-8">
                <form action="newsPage.php" method="GET">
                    <div class="search-wrapper">
                        <input type="text" name="search" class="form-control" placeholder="Buscar..." value="<?= htmlspecialchars($search ?? '') ?>">
                        
                        <?php if($search || $dateFrom || $dateTo || $filterCatId): ?>
                            <a href="newsPage.php" class="btn-unified bg-orange-btn" title="Limpiar"><i class="fas fa-times"></i></a>
                        <?php endif; ?>

                        <button type="submit" class="btn-unified bg-orange-btn"><i class="fas fa-search"></i></button>
                        <button type="button" class="btn-unified bg-grey-btn" data-toggle="collapse" data-target="#filterBox"><i class="fas fa-filter"></i></button>
                    </div>

                    <div class="collapse mt-3" id="filterBox">
                        <div class="card card-body shadow-sm">
                            <div class="row">
                                <div class="col-md-4"><label class="small font-weight-bold">Vigencia desde</label><input type="date" name="f_desde" class="form-control" value="<?= $dateFrom ?>"></div>
                                <div class="col-md-4"><label class="small font-weight-bold">Vigencia hasta</label><input type="date" name="f_hasta" class="form-control" value="<?= $dateTo ?>"></div>
                                <?php if($isAdmin): ?>
                                <div class="col-md-4"><label class="small font-weight-bold">Categoría</label>
                                    <select name="f_cat" class="form-control">
                                        <option value="">Todas</option>
                                        <?php foreach($userCategories as $c): ?>
                                            <option value="<?= $c->getId() ?>" <?= ($filterCatId == $c->getId()) ? 'selected' : '' ?>><?= $c->getCategoryType() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="text-right"><button type="submit" class="btn mt-3 text-white font-weight-bold px-4" style="background:#CC6600;">Aplicar Filtros</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php foreach ($novedades as $news): ?>
            <div class="news-card" onclick="window.location.href='newsDetailPage.php?id=<?= $news->getId() ?>'">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="<?= NEXTCLOUD_PUBLIC_BASE . urlencode($news->getImageUUID()) ?>" class="img-fluid news-img">
                    </div>
                    
                    <div class="col-md-3 news-content-center">
                        <h4 class="h5 font-weight-bold text-orange mb-1">Novedad #<?= $news->getId() ?></h4>
                        <p class="text-muted small mb-0"><?= htmlspecialchars(substr($news->getNewsText(), 0, 100)) ?></p>
                    </div>

                    <div class="col-md-3 d-flex justify-content-center">
                        <div class="info-box mx-1"><small class="d-block font-weight-bold">Desde</small><span><?= date("d/m/Y", strtotime($news->getDateFrom())) ?></span></div>
                        <div class="info-box mx-1"><small class="d-block font-weight-bold">Hasta</small><span><?= $news->getDateTo() ? date("d/m/Y", strtotime($news->getDateTo())) : '-' ?></span></div>
                    </div>

                    <div class="col-md-2 text-center">
                        <span class="category-badge"><?= htmlspecialchars($news->getUserCategory()->getCategoryType()) ?></span>
                    </div>

                    <div class="col-md-2 text-center">
                        <?php if($isAdmin): ?>
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="editNewsPage.php?id=<?= $news->getId() ?>" class="text-orange mx-3 action-btn-large" onclick="event.stopPropagation();">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)" class="text-orange mx-3 action-btn-large" 
                                   onclick="event.stopPropagation(); openConfirmModal('¿Desea eliminar la novedad #<?= $news->getId() ?>?', '../../Backend/http/deleteNews.http.php?id=<?= $news->getId() ?>')">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </main>

    <?php include "../components/footer.php"?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>