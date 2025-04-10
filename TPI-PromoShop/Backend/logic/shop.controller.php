<?php 
    require_once "../structs/shop.class.php";
    require_once "../structs/user.class.php";
    require_once "../structs/shopType.class.php";
    require_once "../data/shop.data.php";

    class ShopController{
        public static function registerShop(Shop $shop){
            try {
                ShopData::add($shop);
            } catch (Exception $e) {
                throw new Exception("Error en el registro de local. ".$e->getMessage());
            }
            return $shop;
        }
    } 