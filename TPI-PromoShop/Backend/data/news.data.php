<?php
require_once "../shared/BD.data.dev.php";
require_once __DIR__."/../structs/news.class.php";

class NewsData {
    public static function add(News $news) {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO news (newsText, dateFrom, dateTo, dateDeleted, idAdmin, idUserCategory, imageUUID) VALUES (?, ?, ?, ?, ?, ?,?)");
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }

            $text = $news->getNewsText();
            $from = $news->getDateFrom();
            $to = $news->getDateTo();
            $dateDeleted = null;
            $imageUUID = $news->getImageUUID();
            $adminId = $news->getAdmin()->getId();
            $categoryId = $news->getUserCategory()->getId();

            $stmt->bind_param("ssssiis", $text, $from, $to, $dateDeleted, $adminId, $categoryId, $imageUUID);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error al agregar la novedad: " . $e->getMessage());
        } finally {
            if (isset($stmt) && $stmt !== false) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    }

    public static function updateNews(News $news) {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("UPDATE news SET newsText=?, dateFrom=?, dateTo=?, dateDeleted=?, idAdmin=?, idUserCategory=?, imageUUID=? WHERE id=?");
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }

            $text = $news->getNewsText();
            $from = $news->getDateFrom();
            $to = $news->getDateTo();
            $dateDeleted = $news->getDateDeleted();
            $adminId = $news->getAdmin()->getId();
            $categoryId = $news->getUserCategory()->getId();
            $id = $news->getId();

            $stmt->bind_param("ssssiis", $text, $from, $to, $dateDeleted, $adminId, $categoryId, $id);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error al actualizar la novedad: " . $e->getMessage());
        } finally {
            if (isset($stmt) && $stmt !== false) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    }
}
?>