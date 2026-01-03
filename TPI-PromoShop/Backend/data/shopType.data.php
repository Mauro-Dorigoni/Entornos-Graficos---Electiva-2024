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

    public static function findOne(ShopType $shopType)
    {
        $conn = null;
        $stmt = null;
        $result = null;
        $shopTypeFounded=null;

        try {
            // 1. Conexión
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }

            // 2. Consulta Preparada (Seguridad contra SQL Injection)
            $query = "SELECT id, type, description FROM shopType WHERE id = ? AND dateDeleted IS NULL";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error preparando la consulta: " . $conn->error);
            }

            // 3. Vincular el parámetro ('i' significa que $id es un integer)
            $idShopType = $shopType->getId();
            $stmt->bind_param("i", $idShopType );

            // 4. Ejecutar
            if (!$stmt->execute()) {
                throw new Exception("Error ejecutando la consulta: " . $stmt->error);
            }

            // 5. Obtener resultado
            $result = $stmt->get_result();

            // 6. Mapear el objeto (Solo si encontramos una fila)
            if ($row = $result->fetch_assoc()) {
                $shopTypeFounded = new ShopType();
                $shopTypeFounded->setId($row['id']);
                $shopTypeFounded->setType($row['type']);
                $shopTypeFounded->setDescription($row['description']);
            }
        } catch (Exception $e) {
            throw new Exception("Error al buscar el tipo de local: " . $e->getMessage());
        } finally {
            // 7. Limpieza de recursos
            if (isset($result) && $result instanceof mysqli_result) {
                $result->free();
            }
            if (isset($stmt)) {
                $stmt->close();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }

        // Devuelve el objeto ShopType o null si no se encontró
        return $shopTypeFounded;
    }
}

?>