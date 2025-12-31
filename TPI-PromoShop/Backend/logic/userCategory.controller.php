<?php
require_once __DIR__ . "/../data/userCategory.data.php";

class UserCategoryController {
    public static function getAll() {
        try {
            return UserCategoryData::findAll();
        } catch (Exception $e) {
            throw new Exception("Error en el controlador de categorías: " . $e->getMessage());
        }
    }
}
?>