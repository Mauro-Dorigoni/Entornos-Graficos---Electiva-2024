<?php
require_once __DIR__."/../structs/shopType.class.php";
require_once __DIR__."/../data/shopType.data.php";

class ShopTypeController{
    public static function registerShopType(ShopType $type){
        try {
            ShopTypeData::add($type);
        } catch (Exception $e) {
            throw new Exception("Error en el registro de tipo de local(logic). ".$e->getMessage());
        }
    }
    public static function getAll(){
        try {
            $shopTypes = ShopTypeData::findAll();
            return $shopTypes;
        } catch (Exception $e) {
            throw new Exception("Error al recuperar todos los tipos de local(logic). ".$e->getMessage());
        }
    }
}
?>