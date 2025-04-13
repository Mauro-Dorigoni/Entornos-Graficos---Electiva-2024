<?php
require_once __DIR__."/../shared/BD.data.dev.php";
require_once __DIR__."/../structs/shopType.class.php";

class ShopTypeData{
    public static function add (ShopType $type){
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("INSERT INTO shopType (type, description, dateDeleted) VALUES (?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
            $newType = $type->getType();
            $description = $type->getDescription();
            $dateDeleted = null;
            $stmt->bind_param("ssi", $newType, $description, $dateDeleted);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error al agregar el tipo a la BD. ".$e->getMessage());
        }finally{
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
    }

    public static function findAll(){
        $shopTypes=[];
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $query = "SELECT id, type, description, dateDeleted FROM shopType WHERE dateDeleted IS NULL";
            $result = $conn->query($query);
            if (!$result) {
                throw new Exception("Error en la consulta: " . $conn->error);
            }
    
            while ($row = $result->fetch_assoc()) {
                $shopType = new ShopType();
                $shopType->setId($row['id']);
                $shopType->setType($row['type']);
                $shopType->setDescription($row['description']);
                $shopType->setDateDeleted($row['dateDeleted']);
                $shopTypes[] = $shopType;
            }
    
        } catch (Exception $e) {
            throw new Exception("Error al recuperar los tipos de local en la BD ".$e->getMessage());
        }finally{
            if (isset($result)) {
                $result->free();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
        return $shopTypes;
    }
}

?>