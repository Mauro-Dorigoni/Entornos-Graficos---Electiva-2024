<?php 
    require_once __DIR__."/../structs/shop.class.php";
    require_once __DIR__."/../structs/user.class.php";
    require_once __DIR__."/../structs/shopType.class.php";
    require_once __DIR__."/../data/shop.data.php";

    class ShopController{
        public static function registerShop(Shop $shop){
            try {
                ShopData::add($shop);
            } catch (Exception $e) {
                throw new Exception("Error en el registro de local. ".$e->getMessage());
            }
            return $shop;
        }
        public static function addShopImages (Shop $shop){
            try {
                ShopData::addImages($shop);
            } catch (Exception $e) {
                throw new Exception("Error en el registro de imagenes del local. ".$e->getMessage());
            }
        }
        public static function getOne(Shop $shop){
            $shopFound = null;
            try {
                $shopFound = ShopData::findOne($shop);
                $shopFound->setImagesUUIDS(ShopData::findShopImages($shopFound));
            } catch (Exception $e) {
                throw new Exception("Error al recuperar el local. ".$e->getMessage());
            }
            return $shopFound;
        }

        public static function getOneByOwner(User $owner){
            $shopFound = null;
            try {
                $shopFound = ShopData::findByOwner($owner);
                $shopFound->setImagesUUIDS(ShopData::findShopImages($shopFound));
            } catch (Exception $e) {
                throw new Exception("Error al recuperar el local. ".$e->getMessage());
            }
            return $shopFound;
        }

    } 