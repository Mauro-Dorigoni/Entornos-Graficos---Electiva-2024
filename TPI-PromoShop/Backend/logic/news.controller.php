<?php
require_once "../structs/news.class.php";
require_once "../data/news.data.php";

class NewsController {
    public static function registerNews(News $news) {
        try {
            if (strtotime($news->getDateTo()) < strtotime($news->getDateFrom())) {
                throw new Exception("La fecha de finalización no puede ser anterior a la de inicio.");
            }
            
            $news->setDateDeleted(null);
            NewsData::add($news);
            return $news;
        } catch (Exception $e) {
            throw new Exception("Error en el controlador al crear novedad: " . $e->getMessage());
        }
    }

    public static function update(News $news) {
        try {
            NewsData::updateNews($news);
        } catch (Exception $e) {
            throw new Exception("Error en el controlador al actualizar novedad: " . $e->getMessage());
        }
    }
}
?>