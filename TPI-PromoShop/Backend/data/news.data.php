<?php
require_once __DIR__."/../shared/BD.data.dev.php";
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
            $imageUUID = $news->getImageUUID();
            $id = $news->getId();

            $stmt->bind_param("ssssiiss", $text, $from, $to, $dateDeleted, $adminId, $categoryId, $imageUUID, $id);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error al actualizar la novedad: " . $e->getMessage());
        } finally {
            if (isset($stmt) && $stmt !== false) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    }

    public static function getAll() {
        $list = [];
        try {
            $conn = new mysqli(servername, username, password, dbName);
            $query = "SELECT n.*, uc.categoryType 
                  FROM news n 
                  INNER JOIN userCategory uc ON n.idUserCategory = uc.id 
                  WHERE n.dateDeleted IS NULL 
                  ORDER BY n.dateFrom DESC";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                $news = new News();
                $news->setId($row['id']);
                $news->setNewsText($row['newsText']);
                $news->setDateFrom($row['dateFrom']);
                $news->setDateTo($row['dateTo']);
                $news->setImageUUID($row['imageUUID']);
                
                $cat = new UserCategory();
                $cat->setId($row['idUserCategory']);
                $cat->setCategoryType($row['categoryType']);
                $news->setUserCategory($cat);

                // El admin lo seteamos solo con el ID por ahora
                $admin = new User();
                $admin->setId($row['idAdmin']);
                $news->setAdmin($admin);

                $list[] = $news;
            }
            return $list;
        } catch (Exception $e) {
            throw new Exception("Error al obtener novedades: " . $e->getMessage());
        } finally {
            if (isset($conn)) $conn->close();
        }
    }

    public static function findById(int $id) {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }

        // Seleccionamos todos los campos, incluyendo imageUUID
            $stmt = $conn->prepare("SELECT * FROM news WHERE id = ? AND dateDeleted IS NULL");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $news = new News();
                $news->setId($row['id']);
                $news->setNewsText($row['newsText']);
                $news->setDateFrom($row['dateFrom']);
                $news->setDateTo($row['dateTo']);
                $news->setImageUUID($row['imageUUID']);
                
                $cat = new UserCategory();
                $cat->setId($row['idUserCategory']);
                $news->setUserCategory($cat);

                $admin = new User();
                $admin->setId($row['idAdmin']);
                $news->setAdmin($admin);

                return $news;
            }
        return null;
        } catch (Exception $e) {
            throw new Exception("Error al buscar la novedad en la BD: " . $e->getMessage());
        } finally {
            if (isset($conn)) $conn->close();
        }
    }

    public static function softDelete(int $id) {
    try {
        $conn = new mysqli(servername, username, password, dbName);
        $stmt = $conn->prepare("UPDATE news SET dateDeleted = NOW() WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } catch (Exception $e) {
        throw new Exception("Error al realizar la baja lógica: " . $e->getMessage());
    } finally {
        if (isset($conn)) $conn->close();
    }
}

}
?>