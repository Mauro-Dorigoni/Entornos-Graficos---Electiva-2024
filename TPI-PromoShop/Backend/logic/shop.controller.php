<?php
require_once __DIR__ . "/../structs/shop.class.php";
require_once __DIR__ . "/../structs/user.class.php";
require_once __DIR__ . "/../structs/shopType.class.php";
require_once __DIR__ . "/../data/shop.data.php";

class ShopController
{
    public static function registerShop(Shop $shop)
    {
        try {
            ShopData::add($shop);
        } catch (Exception $e) {
            throw new Exception("Error en el registro de local. " . $e->getMessage());
        }
        return $shop;
    }
    public static function addShopImages(Shop $shop)
    {
        try {
            ShopData::addImages($shop);
        } catch (Exception $e) {
            throw new Exception("Error en el registro de imagenes del local. " . $e->getMessage());
        }
    }
    //BUSCA UN LOCAL. Si no existe devuelve null. Manejarlo con error??? LAUTARO.
    public static function getOne(Shop $shop)
    {
        $shopFound = null;
        try {
            $shopFound = ShopData::findOne($shop);
            if (!is_null($shopFound)) {
                $shopFound->setImages(ShopData::findShopImages($shopFound));
            }
        } catch (Exception $e) {
            throw new Exception("Error al recuperar el local. " . $e->getMessage());
        }
        return $shopFound;
    }



    public static function getOneByOwner(User $owner)
    {
        $shopFound = null;
        try {
            $shopFound = ShopData::findByOwner($owner);
            $shopFound->setImages(ShopData::findShopImages($shopFound));
        } catch (Exception $e) {
            throw new Exception("Error al recuperar el local. " . $e->getMessage());
        }
        return $shopFound;
    }

    public static function getAll()
    {
        $shops = null;
        try {
            $shops = ShopData::findAll();
            //Lautaro. No popula imagenes. Ver como lo manejamos. 
            //$shops->setImagesUUIDS(ShopData::findShopImages($shopFound));
        } catch (Exception $e) {
            throw new Exception("Error al recuperar los locales. " . $e->getMessage());
        }
        return $shops;
    }

    //Recibe un local con nombre y un tipo con id. Puede recibir nombre: '' y tipo: 0, lo cual sería equivalente a un getAll.
    public static function getByNameAndType(Shop $shopName, ShopType $filtroTipo)
    {
        $shops = [];
        $typeFinded = null;
        try {
            $shopTypes = ShopTypeData::findAll();
            //Valida que exista parametro filtro. Si es '' es porque campo fue enviado en blanco.
            if ($filtroTipo->getId() != 0) {
                $idFiltro = $numero = filter_var($filtroTipo->getId(), FILTER_VALIDATE_INT);
                if ($numero === false) {
                    throw new Error("El ID de Tipo no es un Integer valido.");
                }

                foreach ($shopTypes as $type) {
                    if ($type->getId() === $idFiltro) {
                        $typeFinded = $type;
                        break;
                    }
                }
                if (!$typeFinded) {
                    throw new Exception("El Tipo de Local no existe.");
                }
            }



            $shops = ShopData::findByNameAndType($typeFinded, $shopName);
            //Lautaro. No popula imagenes. Ver como lo manejamos. 
            //$shops->setImagesUUIDS(ShopData::findShopImages($shopFound));
        } catch (Exception $e) {
            throw new Exception("Error al recuperar los locales. " . $e->getMessage());
        }
        return $shops;
    }

    public static function getByNameAndTypePagination(Shop $shopName, ShopType $filtroTipo, int|null $pagNumb = null, int $cantPag = 4)
    {
        $shops = [];
        $typeFinded = null;
        try {
            $shopTypes = ShopTypeData::findAll();
            //Valida que exista parametro filtro. Si es '' es porque campo fue enviado en blanco.
            if ($filtroTipo->getId() != 0) {
                $idFiltro = $numero = filter_var($filtroTipo->getId(), FILTER_VALIDATE_INT);
                if ($numero === false) {
                    throw new Error("El ID de Tipo no es un Integer valido.");
                }

                foreach ($shopTypes as $type) {
                    if ($type->getId() === $idFiltro) {
                        $typeFinded = $type;
                        break;
                    }
                }
                if (!$typeFinded) {
                    throw new Exception("El Tipo de Local no existe.");
                }
            }



            $shops = ShopData::findByNameAndTypePagination($typeFinded, $shopName, $pagNumb, $cantPag);
            //Lautaro. No popula imagenes. Ver como lo manejamos. 
            //$shops->setImagesUUIDS(ShopData::findShopImages($shopFound));
        } catch (Exception $e) {
            throw new Exception("Error al recuperar los locales paginando:  " . $e->getMessage());
        }
        return $shops;
    }

    public static function getCountByNameAndType(Shop $shopName, ShopType $filtroTipo)
    {
        $cantidad = 0;
        $typeFinded = null;

        try {
            $shopTypes = ShopTypeData::findAll();
            //Valida que exista parametro filtro. Si es '' es porque campo fue enviado en blanco.
            if ($filtroTipo->getId() != 0) {
                $idFiltro = $numero = filter_var($filtroTipo->getId(), FILTER_VALIDATE_INT);
                if ($numero === false) {
                    throw new Error("El ID de Tipo no es un Integer valido.");
                }

                foreach ($shopTypes as $type) {
                    if ($type->getId() === $idFiltro) {
                        $typeFinded = $type;
                        break;
                    }
                }
                if (!$typeFinded) {
                    throw new Exception("El Tipo de Local no existe.");
                }
            }
            $cantidad = ShopData::findCountByNameAndType($typeFinded, $shopName);
            //Lautaro. No popula imagenes. Ver como lo manejamos. 
            //$shops->setImagesUUIDS(ShopData::findShopImages($shopFound));
        } catch (Exception $e) {
            throw new Exception("Error al recuperar la cantidad de los locales. " . $e->getMessage());
        }
        return $cantidad;
    }


    /* Recibe un array de UUIDs para eliminar */
    public static function deleteImages($images)
    {
        try {
            if (!empty($images)) {
                ShopData::deleteImages($images);
            }
        } catch (Exception $e) {
            throw new Exception("Error al eliminar las imagenes" . $e->getMessage());
        }
    }


    public static function updateMainImage(Shop $shop)
    {
        try {
            if (!is_null($shop->getMainImage()?->getUUID())) {
                ShopData::updateMainImage($shop);
            }
        } catch (Exception $e) {
            throw new Exception("Error al asignar imagen portada" . $e->getMessage());
        }
    }

    public static function updateShop (Shop $shop) {
        try {
            ShopData::update($shop);
        } catch (Exception $e) {
            throw new Exception("Error al actualizar los datos del local" . $e->getMessage());
        }
    }

    public static function deleteShop (Shop $shop) {
        try {
            ShopData::delete($shop);
        } catch (Exception $e) {
            throw new Exception("Error al eliminar el local" . $e->getMessage());
        }
    }
}
