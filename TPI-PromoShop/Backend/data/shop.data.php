<?php
require_once "../shared/BD.data.dev.php";
require_once "../structs/shop.class.php";
require_once __DIR__."/../structs/user.class.php";

class ShopData {
    public static function add(Shop $shop) {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("INSERT INTO shop (name, location, dateDeleted, idOwner, idShopType) VALUES (?, ?, ?,?,?)");
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
            $name = $shop->getName();
            $location = $shop->getLocation();
            $dateDeleted = null;
            $idOwner = $shop->getOwner()->getId();
            $idShopType = $shop->getShopType()->getId();
            $stmt->bind_param("ssiii", $name, $location, $dateDeleted,$idOwner,$idShopType);
            $stmt->execute();
            echo "Local agregada exitosamente.";
        } catch (Exception $e) {
            throw new Exception("Error al agregar la tienda a la BD. ".$e->getMessage());
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
    }
}