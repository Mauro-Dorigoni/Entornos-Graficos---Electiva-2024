<?php
require_once __DIR__ . "/../shared/BD.data.dev.php";
require_once __DIR__ . "/../structs/userCategory.class.php";

class UserCategoryData {
    public static function findAll() {
        $list = [];
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }

            // Obtenemos solo las categorías que no están eliminadas lógicamente
            $result = $conn->query("SELECT id, categoryType, dateDeleted FROM userCategory WHERE dateDeleted IS NULL");
            
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $cat = new UserCategory();
                    $cat->setId((int)$row['id']);
                    $cat->setCategoryType($row['categoryType']);
                    $cat->setDateDeleted($row['dateDeleted']);
                    $list[] = $cat;
                }
            }
        } catch (Exception $e) {
            throw new Exception("Error al obtener categorías: " . $e->getMessage());
        } finally {
            if (isset($conn)) $conn->close();
        }
        return $list;
    }
}
?>