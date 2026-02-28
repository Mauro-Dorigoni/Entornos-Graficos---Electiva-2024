<?php
require_once __DIR__ . "/../structs/news.class.php";
require_once __DIR__ . "/../data/news.data.php";

class NewsController {
    public static function registerNews(News $news) {
        try {
            if (strtotime($news->getDateTo()) < strtotime($news->getDateFrom())) {
                throw new Exception("La fecha de finalización no puede ser anterior a la de inicio.");
            }
            $currentDate = date('Y-m-d');

            if (strtotime($news->getDateFrom()) < strtotime($currentDate)) {
                throw new Exception("La fecha de inicio no puede ser anterior a la fecha actual.");
            }
            
            $news->setDateDeleted(null);
            NewsData::add($news);
            return $news;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function update(News $news) {
        try {
            NewsData::updateNews($news);
        } catch (Exception $e) {
            throw new Exception("Error en el controlador al actualizar novedad: " . $e->getMessage());
        }
    }

    public static function getAll() {
        try{
            return NewsData::getAll();
        } catch (Exception $e) {
            throw new Exception("Error al cargar las novedades: " . $e->getMessage());
        }
    }

    public static function getOne(News $news) { // Recibe el objeto News
        $newsFound = null;
        try {
            $id = $news->getId(); 
            $newsFound = NewsData::findById($id);
        } catch (Exception $e) {
            throw new Exception("Error al recuperar la novedad. " . $e->getMessage());
        }
        return $newsFound;
    }

    public static function delete(int $id) {
        try {
            NewsData::softDelete($id);
        } catch (Exception $e) {
            throw new Exception("Error en el controlador al eliminar: " . $e->getMessage());
        }
    }

    public static function filter($search, $dateFrom, $dateTo, $catId) {
        return NewsData::filter($search, $dateFrom, $dateTo, $catId);
    }

    public static function filterForUser($search, $dateFrom, $dateTo, $maxCategory) {
        return NewsData::filterForUser($search, $dateFrom, $dateTo, $maxCategory);
    }

    public static function getFilteredNews(User $user, $search, $dateFrom, $dateTo, $filterCatId = null) {
        try {
            if ($user->isAdmin()) {
                return NewsData::filter($search, $dateFrom, $dateTo, $filterCatId);
            } else {
                $userLevel = $user->getUserCategory()->getId();
                return NewsData::filterForUser($search, $dateFrom, $dateTo, $userLevel);
            }
        } catch (Exception $e) {
            throw new Exception("Error al obtener las novedades: " . $e->getMessage());
        }
    }
}
?>