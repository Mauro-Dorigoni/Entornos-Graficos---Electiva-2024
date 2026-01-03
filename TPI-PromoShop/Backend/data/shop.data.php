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
            $stmt = $conn->prepare("SELECT shp.id, shp.name, shp.location, shp.dateDeleted, shp.idOwner, shp.idShopType, shp.openinghours, sht.type, sht.description, sht.dateDeleted as typeDateDeleted, usu.email, usu.pass, usu.isAdmin, usu.dateDeleted as ownerDateDeleted, usu.emailToken, usu.isEmailVerified, usu.idUserCategory, cat.categoryType, cat.dateDeleted as catDateDeleted from shop shp 
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
                $shopFound->setDescription($row["description"]);
                $shopFound->setOpeningHours($row["openinghours"]);
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
            foreach($shop->getImages() as $image){
                try {
                    $conn = new mysqli(servername, username, password, dbName);
                    if ($conn->connect_error) {
                        throw new Exception("Error de conexión: " . $conn->connect_error);
                    }
                    $stmt = $conn->prepare("INSERT INTO shopimages (imageUUID, idShop, ismain) VALUES (?, ?, ?)");
                    if (!$stmt) {
                        throw new Exception("Error al preparar la consulta: " . $conn->error);
                    }
                    $shopID = $shop->getId();
                    $imageUUID = $image->getUUID();
                    $isMain = $image->isMain();
                    $stmt->bind_param("sii", $imageUUID, $shopID, $isMain);
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

    //Encuentra un local. Si no existe ID devuelve NULL.
    public static function findOne(Shop $shop){
        $shopFound = null;
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT shp.id, shp.name, shp.location, shp.dateDeleted, shp.idOwner, shp.idShopType, shp.openinghours , shp.description as shopDescription,sht.type, sht.description, sht.dateDeleted as typeDateDeleted, usu.email, usu.pass, usu.isAdmin, usu.dateDeleted as ownerDateDeleted, usu.emailToken, usu.isEmailVerified, usu.idUserCategory, cat.categoryType, cat.dateDeleted as catDateDeleted from shop shp 
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
                $shopFound->setDescription($row["shopDescription"]);
                $shopFound->setOpeningHours($row["openinghours"]);
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
            $stmt = $conn->prepare("SELECT imageUUID, ismain, si.id as imageId FROM shopimages si INNER JOIN shop sh ON si.idShop = sh.id WHERE sh.id = ?");
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
                
                $image = new Image();
                $image -> setId($row['imageId']);
                $image -> setUUID($row['imageUUID']);
                $image -> setIsMain($row['ismain']);

                $images[] = $image;


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

    //Lautaro. No devuelve las imagenes. Solo popula con Owner y Tipo [no todos los atributos].
    public static function findAll(){
        $shops=[];
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $query = "SELECT s.id AS shopId, name, description, openinghours, location, st.id AS stypeId, st.type AS stName, u.id AS userId, u.email AS userEmail 
                    FROM shop AS s 
                    INNER JOIN shoptype AS st ON s.idShopType = st.id
                    INNER JOIN user AS u ON s.idOwner = u.id
                    WHERE s.dateDeleted IS NULL AND st.dateDeleted IS NULL AND u.dateDeleted is NULL;";
            $result = $conn->query($query);
            if (!$result) {
                throw new Exception("Error en la consulta: " . $conn->error);
            }
    
            while ($row = $result->fetch_assoc()) {
                $shopType = new ShopType();
                $shop = new Shop();
                $owner = new User();
                $owner -> setId($row['userId']);
                $owner -> setEmail($row['userEmail']);
                $owner -> setIsOwner(TRUE);

                $shopType->setId($row['stypeId']);
                $shopType->setType($row['stName']);

                $shop -> setShopType( $shopType);
                $shop -> setId($row['shopId']); 
                $shop -> setName($row['name']);
                $shop -> setLocation($row['location']);  
                $shop -> setOwner($owner);
                $shop->setDescription($row["description"]);
                $shop->setOpeningHours($row["openinghours"]);
                $shops[] = $shop;
            }
    
        } catch (Exception $e) {
            throw new Exception("Error al recuperar los local en la BD ".$e->getMessage());
        }finally{
            if (isset($result)) {
                $result->free();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
        return $shops;
    }

   
    //Solo popula con Owner y Tipo. No todos los atributos. Puede recibir nombre: '' y tipo: 0, lo cual genera un return equivalente a un getAll. 
    public static function findByNameAndType(?ShopType $type, Shop $name) {
        $shops = [];
        $conn = null;
        $stmt = null;

        try {
        
            $conn = new mysqli(servername, username, password, dbName);
            
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }

            $sql = "SELECT s.id AS shopId, s.name, s.location, s.description, s.openinghours,
                        st.id AS stypeId, st.type AS stName, 
                        u.id AS userId, u.email AS userEmail
                    FROM shop AS s 
                    INNER JOIN shoptype AS st ON s.idShopType = st.id
                    INNER JOIN user AS u ON s.idOwner = u.id
                  
                    WHERE s.dateDeleted IS NULL";

            //Construcción Dinámica según los parametros enviados.
            $params = [];    // Array para los valores
            $types = "";     // String para los tipos ("s", "i", etc.)

            // Condición Nombre. Si hay nombre, entonces se incluye a la consulta.
            if (!empty($name->getName())) {
                $sql .= " AND s.name LIKE ?";
                $types .= "s"; // 's' de String
                $params[] = "%" . $name->getName() . "%";
            }

            // Condición Tipo (si no es null y tiene ID válido). Si hay ID se incluye a la consulta
            if ($type !== null && $type->getId() > 0) {
                $sql .= " AND st.id = ?";
                $types .= "i"; // 'i' de Integer
                $params[] = $type->getId();
            }

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $conn->error);
            }

            // Solo hacemos bind si hay parámetros
            if (!empty($params)) {
                // bind_param requiere que los parámetros se pasen individualmente, no como array.
                // Usamos la desestructuración (...) que es nativa de PHP moderno (8.2)
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();

            $result = $stmt->get_result(); 

            while ($row = $result->fetch_assoc()) {
                
                $owner = new User();
                $owner->setId($row["userId"]);
                $owner->setEmail($row["userEmail"]);
                
                $shopTypeObj = new ShopType();
                $shopTypeObj->setId($row["stypeId"]);
                $shopTypeObj->setType($row["stName"]);

                $shopFound = new Shop();
                $shopFound->setId($row["shopId"]);
                $shopFound->setName($row["name"]);
                $shopFound->setLocation($row["location"]);
                $shopFound->setOwner($owner);
                $shopFound->setShopType($shopTypeObj);
                $shopFound->setDescription($row["description"]);
                $shopFound->setOpeningHours($row["openinghours"]);


                $shops[] = $shopFound;

                foreach($shops as $s) {
                    $images = ShopData::findShopImages($s);
                    $s->setImages($images);
                }

            }

        } catch (Exception $e) {
            throw new Exception("Error al buscar locales: " . $e->getMessage());
        } finally {
            // Cerrar recursos si existen
            if ($stmt) $stmt->close();
            if ($conn) $conn->close();
        }
        
        return $shops;
    }

    public static function deleteImages($imagesUUIDs) {
        try{
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            // 1. Crear los placeholders dinámicos (?, ?, ?)
            // Si hay 3 uuids, esto genera string: "?,?,?"
            $placeholders = implode(',', array_fill(0, count($imagesUUIDs), '?'));
            $types = implode('', array_fill(0, count($imagesUUIDs), 's'));
            // 2. Construir la consulta
            $sql = "DELETE FROM shopimages WHERE imageUUID IN ($placeholders)";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $conn->error);
            }

            if (!empty($imagesUUIDs)) {
                // bind_param requiere que los parámetros se pasen individualmente, no como array.
                // Usamos la desestructuración (...) que es nativa de PHP moderno (8.2)
                // El operador ... convierte el array en argumentos separados: 'a1', 'b2', 'c3'
                $stmt->bind_param($types, ...$imagesUUIDs);
            }

            $stmt->execute();

        }
        catch (Exception $e) {
            throw new Exception("Error al intentar eliminar las imagenes de la BBDD. ".$e->getMessage());
        } finally {
            // Cerrar recursos si existen
            if ($stmt) $stmt->close();
            if ($conn) $conn->close();
        }
    }

    public static function updateMainImage($shop) {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }

            $sql = "UPDATE shopimages SET ismain = 0 WHERE idShop = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $conn->error);
            }
            $stmt->bind_param('i', $shop->getId());
            $stmt->execute();

            $sqlSet = "UPDATE shopimages SET ismain = 1 WHERE imageUUID = ? AND idShop = ?";
            $stmt = $conn->prepare($sqlSet);
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $conn->error);
            }
            $uuidMain = $shop->getMainImage()->getUUID();
            $idShop = $shop->getId();
            $stmt->bind_param('si', $uuidMain, $idShop );
            $stmt->execute();


        }
        catch (Exception $e) {
            throw new Exception("Error al intentar asignar una foto de portada en la BBDD. " . $e->getMessage());
        } finally {
            // Cerrar recursos si existen
            if ($stmt) $stmt->close();
            if ($conn) $conn->close();
        }
    }

    public static function update(Shop $shop)
    {
        try {
            $conn = new mysqli(servername, username, password, dbName);

            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }

            $query = "UPDATE shop SET 
                        name = ?, 
                        location = ?, 
                        idShopType = ?, 
                        description = ?, 
                        openingHours = ? 
                      WHERE id = ?";

            $stmt = $conn->prepare($query);

            if (!$stmt) {
                throw new Exception("Error al preparar update: " . $conn->error);
            }

            $name = $shop->getName();
            $loc  = $shop->getLocation();

            $typeId = $shop->getShopType()->getId();

            $desc  = $shop->getDescription();
            $hours = $shop->getOpeningHours();
            $id    = $shop->getId();

            $stmt->bind_param("ssissi", $name, $loc, $typeId, $desc, $hours, $id);

            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar update: " . $stmt->error);
            }

            //  if ($stmt->affected_rows === 0) { 
            //     throw new Exception ("Ningun registro de locales modificado. ID del Shop=".$shop->getId());
            //   }

        } catch (Exception $e) {
            throw new Exception("Error al actualizar el Shop: " . $e->getMessage());
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