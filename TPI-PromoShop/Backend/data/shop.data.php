<?php
require_once __DIR__."/../shared/BD.data.dev.php";
require_once __DIR__."/../structs/shop.class.php";
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

    //Este metodo es peligroso si pensamos que un dueño puede tener mas de un local, y debe considerarse temporal mas que nada - Mauro//
    public static function findByOwner(User $owner){
        $shopFound = null;
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT shp.id, shp.name, shp.location, shp.dateDeleted, shp.idOwner, shp.idShopType, sht.type, sht.description, sht.dateDeleted as typeDateDeleted, usu.email, usu.pass, usu.isAdmin, usu.dateDeleted as ownerDateDeleted, usu.emailToken, usu.isEmailVerified, usu.idUserCategory, cat.categoryType, cat.dateDeleted as catDateDeleted from shop shp 
            inner join shoptype sht on shp.idShopType=sht.id 
            inner join user usu on shp.idOwner=usu.id 
            inner join usercategory cat on usu.idUserCategory=cat.id
            where shp.idOwner=? and shp.dateDeleted is null;");
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $conn->error);
            };
            $id = $owner->getId();
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $userCat = new UserCategory();
                $userCat->setId($row['idUserCategory']);
                $userCat->setCategoryType($row["categoryType"]);
                $userCat->setDateDeleted($row["catDateDeleted"]);

                $owner = new User();
                $owner->setId($row["idOwner"]);
                $owner->setEmail($row["email"]);
                $owner->setPass($row["pass"]);
                $owner->setIsAdmin((bool)$row["isAdmin"]);
                $owner->setDateDeleted($row["ownerDateDeleted"]);
                $owner->setEmailToken($row["emailToken"]);
                $owner->setIsEmailVerified((bool)$row["isEmailVerified"]);
                $owner->setUserCategory($userCat);

                $shopType = new ShopType();
                $shopType->setId($row["idShopType"]);
                $shopType->setType($row["type"]);
                $shopType->setDescription($row["description"]);
                $shopType->setDateDeleted($row["typeDateDeleted"]);

                $shopFound = new Shop();
                $shopFound->setId($row["id"]);
                $shopFound->setName($row["name"]);
                $shopFound->setLocation($row["location"]);
                $shopFound->setDateDeleted($row["dateDeleted"]);
                $shopFound->setOwner($owner);
                $shopFound->setShopType($shopType);
            }
        } catch (Exception $e) {
            throw new Exception("No se pudo recuperar el Local de la BD ".$e->getMessage());
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
        return $shopFound;
    }

    public static function addImages(Shop $shop){
        try {
            foreach($shop->getImagesUUIDS() as $image){
                try {
                    $conn = new mysqli(servername, username, password, dbName);
                    if ($conn->connect_error) {
                        throw new Exception("Error de conexión: " . $conn->connect_error);
                    }
                    $stmt = $conn->prepare("INSERT INTO shopimages (imageUUID, idShop) VALUES (?, ?)");
                    if (!$stmt) {
                        throw new Exception("Error al preparar la consulta: " . $conn->error);
                    }
                    $shopID = $shop->getId();
                    $stmt->bind_param("si", $image, $shopID);
                    $stmt->execute();
                } catch (Exception $e1) {
                    throw new Exception("Error al agregar la imagen a la BD. ".$e1->getMessage());
                } finally {
                    if (isset($stmt) && $stmt !== false) {
                        $stmt->close();
                    }
                    if (isset($conn)) {
                        $conn->close();
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception("Error al agregar las imagenes a la BD. ".$e->getMessage());
        } 
    }

    public static function findOne(Shop $shop){
        $shopFound = null;
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT shp.id, shp.name, shp.location, shp.dateDeleted, shp.idOwner, shp.idShopType, sht.type, sht.description, sht.dateDeleted as typeDateDeleted, usu.email, usu.pass, usu.isAdmin, usu.dateDeleted as ownerDateDeleted, usu.emailToken, usu.isEmailVerified, usu.idUserCategory, cat.categoryType, cat.dateDeleted as catDateDeleted from shop shp 
            inner join shoptype sht on shp.idShopType=sht.id 
            inner join user usu on shp.idOwner=usu.id 
            inner join usercategory cat on usu.idUserCategory=cat.id
            where shp.id=? and shp.dateDeleted is null;");
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $conn->error);
            };
            $id = $shop->getId();
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $userCat = new UserCategory();
                $userCat->setId($row['idUserCategory']);
                $userCat->setCategoryType($row["categoryType"]);
                $userCat->setDateDeleted($row["catDateDeleted"]);

                $owner = new User();
                $owner->setId($row["idOwner"]);
                $owner->setEmail($row["email"]);
                $owner->setPass($row["pass"]);
                $owner->setIsAdmin((bool)$row["isAdmin"]);
                $owner->setDateDeleted($row["ownerDateDeleted"]);
                $owner->setEmailToken($row["emailToken"]);
                $owner->setIsEmailVerified((bool)$row["isEmailVerified"]);
                $owner->setUserCategory($userCat);

                $shopType = new ShopType();
                $shopType->setId($row["idShopType"]);
                $shopType->setType($row["type"]);
                $shopType->setDescription($row["description"]);
                $shopType->setDateDeleted($row["typeDateDeleted"]);

                $shopFound = new Shop();
                $shopFound->setId($row["id"]);
                $shopFound->setName($row["name"]);
                $shopFound->setLocation($row["location"]);
                $shopFound->setDateDeleted($row["dateDeleted"]);
                $shopFound->setOwner($owner);
                $shopFound->setShopType($shopType);
            }
        } catch (Exception $e) {
            throw new Exception("No se pudo recuperar el Local de la BD ".$e->getMessage());
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
        return $shopFound;
    }

    public static function findShopImages(Shop $shop){
        $images = [];
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT imageUUID FROM shopimages si INNER JOIN shop sh ON si.idShop = sh.id WHERE sh.id = ?");
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }
            $id = $shop->getId();
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                throw new Exception("Error en la ejecución de la consulta: " . $stmt->error);
            }
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $images[] = $row['imageUUID'];
            }   
        } catch (Exception $e) {
            throw new Exception("No se pudieron recuperar las imagenes del local de la BD ".$e->getMessage());
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
        return $images;
    }
}