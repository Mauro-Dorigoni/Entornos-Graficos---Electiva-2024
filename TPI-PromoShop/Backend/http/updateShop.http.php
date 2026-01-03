<?php
require_once __DIR__ . "/../structs/shop.class.php";
require_once __DIR__ . "/../logic/shop.controller.php";
require_once __DIR__ . "/../logic/user.controller.php";
require_once __DIR__ . "/../logic/shopType.controller.php";
require_once __DIR__ . "/../structs/user.class.php";
require_once __DIR__ . "/../shared/frontendRoutes.dev.php";
require_once __DIR__ . "/../shared/userType.enum.php";
require_once __DIR__ . "/../shared/backendRoutes.dev.php";


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$uploadDir = __DIR__ . '/../shared/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $isAdmin = false;
        $isOwner = false;
        //El administrador y Owner tienen permitido editar un local...TODO modificar para que ambos puedan.
        if(!isset($_SESSION['user']) || $_SESSION['userType'] == UserType_enum::User) {
            $_SESSION['error_message'] = "No tienes permisos para acceder a esta pagina";
            header("Location: " . frontendURL . "/loginPage.php");
            exit;
            
        }

        if (isset($_SESSION['user']) && ($_SESSION['user']->isAdmin() == true || $_SESSION['userType'] == UserType_enum::Admin)) {
            $isAdmin = true;
        } elseif (isset($_SESSION['user']) && ($_SESSION['user']->isOwner() == true || $_SESSION['userType'] == UserType_enum::Owner)) {
            $isOwner = true;
        } 



        $idShop = $_POST['idShop'];
        $shop = new Shop();
        $shop->setId($idShop);
        $shop = ShopController::getOne($shop);

        if (is_null($shop)) {
            throw new Exception("El local ingresado no existe");
        }


        
        //RECUPERO LOS DATOS ENVIADOS
        if (!is_null($_POST['emailOwner']) && $isAdmin) {
            //si es null es porque no lo esta intentando editar un owner y no tiene permisos para hacerlo
            $owner = UserController::getOwnerByShopId($shop);
            $emailOwner = $_POST['emailOwner'];
            $owner->setEmail($emailOwner);
            UserController::update($owner);
        }
        if (!is_null($_POST['location'] && $isAdmin)) {
            //si es null es porque no lo esta intentando editar un owner y no tiene permisos para hacerlo
            $location = $_POST['location'];
            $shop->setLocation($location);
        } 

        $shopName = $_POST['shopName'];
        $shopDescription = $_POST['shopDescription'];
        $hoursText = $_POST['hoursText'];
        
        $shop->setName($shopName);
        $shop->setDescription($shopDescription);
        $shop->setOpeningHours($hoursText);

        //Verificar existencia. 
        $shopTypeId = $_POST['shopType'];
        $st = new ShopType();
        $st->setId($shopTypeId);
        $stFound = ShopTypeController::getOne($st);         
        if ($stFound == null ) {
            throw new Exception("EL TIPO DE LOCAL NO EXISTE");
        }
        //ACTUALIZAR ATRIBUTOS SHOP
        $shop->setShopType($stFound);
        ShopController::updateShop($shop);

        //IMAGENES

        //NUEVAS IMAGENES
        $newImages = [];
        $imagesObjects = [];
        if (isset($_FILES['newImages']) && !empty($_FILES['newImages']['tmp_name'][0])) {
            //si hay imagenes las recorro.
            foreach ($_FILES['newImages']['tmp_name'] as $key => $tmpName) {
                //para cada imagen que se envío en el arreglo
                if ($_FILES['newImages']['error'][$key] === UPLOAD_ERR_OK) {
                    //si la imagen fue cargada sin errores.
                    $originalName = $_FILES['newImages']['name'][$key];
                    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                    $uuid = uniqid('', true);
                    $newFileName = $uuid . '.' . $extension;
                    $destination = $uploadDir . $newFileName;

                    $i = new Image();
                    $i->setUUID($newFileName);
                    $i->setIsMain(false);


                    if (move_uploaded_file($tmpName, $destination)) {
                        //agrego el nombre de la imagen que guarde
                        $newImages[$key] = $newFileName;
                        $imagesObjects[] = $i;
                    } else {
                        throw new Exception("Error subiendo la imagen: $originalName");
                    }
                } else {
                    throw new Exception("Error en el archivo: " . $_FILES['newImages']['name'][$key]);
                }
            }
            try {
                $shop->setImages($imagesObjects);
                ShopController::addShopImages($shop);
            } catch (Exception $e) {
                throw new Exception("ERROR AL CARGAR IMAGENES." . $e->getMessage());
            }
        }

        //ELIMINAR IMAGENES EXISTENTES

        try {
            if (isset($_POST['deleteUuids']) && is_array($_POST['deleteUuids'])) {
                $uuidsToDelete = $_POST['deleteUuids'];
                $listado = implode(',', $uuidsToDelete);
                ShopController::deleteImages($uuidsToDelete);
            }
        } catch (Exception $e) {
            throw new Exception("ERROR AL ELIMINAR IMAGENES" . $e->getMessage());
        }

        //SELECCIONAR PORTADA.
        if (isset($_POST['setMainUuid'])) {
            $selectedMain = $_POST['setMainUuid'];

            // CASO A: El usuario eligió una foto NUEVA (valor tipo "new_0", "new_1")
            if (strpos($selectedMain, 'new_') === 0) {

                // Extraemos el número del índice (ej: "new_1" -> 1)
                $index = (int) str_replace('new_', '', $selectedMain);

                // Verificamos si esa foto se subió correctamente
                if (isset($newImages[$index])) {
                    $realUuid = $newImages[$index];
                    $shopFounded = ShopController::getOne($shop);
                    $imageFound = $shopFounded->getImages();
                    $mainImage = null;
                    foreach($imageFound as $img) {
                        if($img->getUUID()== $realUuid){
                            $mainImage = $img;
                        }
                    }

                    if (is_null($mainImage)) {
                        throw new Exception("LA IMAGEN DE PORTADA NO ESTA EN LA BBDD.");
                    }
                    $shopFounded -> setMainImage($mainImage);

                    ShopController::updateMainImage($shopFounded);
                }
            }
            // CASO B: El usuario eligió una foto VIEJA (valor es un UUID real)
            else {
                // Solo actualizamos si NO fue marcada para borrar
                // (Aunque el JS lo previene, validamos en backend por seguridad)
                $isDeleted = isset($_POST['deleteUuids']) && in_array($selectedMain, $_POST['deleteUuids']);

                if (!$isDeleted) {
                    $mainImage = new Image();
                    $mainImage->setUUID($selectedMain);
                    //VERIFICAMOS QUE LA IMAGEN EXISTA EN LA BBDD
                    //DEBERIA VERIFICARSE SOLA EN EL UPDATE??
                    $shopFounded = ShopController::getOne($shop);
                    $imageFound = $shopFounded->getImages();
                    $mainImage = null;
                    foreach ($imageFound as $img) {
                        if ($img->getUUID() == $selectedMain) {
                            $mainImage = $img;
                        }
                    }

                    if (is_null($mainImage)) {
                        throw new Exception("LA IMAGEN DE PORTADA NO ESTA EN LA BBDD.");
                    }
                    $shopFounded->setMainImage($mainImage);
                    ShopController::updateMainImage($shopFounded);
                }
            }
        }

        $_SESSION['success_message'] = "Local actualizado exitosamente. Gracias por sus cambios.";
        header("Location: " . frontendURL . "/shopDetailPage.php?id=".$shop->getId());
        exit;


    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error al actualizar el local" . $e->getMessage();
        header("Location: " . frontendURL . "/shopsCardsPage.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Metodo de solicitud no permitido";
    header("Location: " . frontendURL . "/shopsCardsPage.php");
}
