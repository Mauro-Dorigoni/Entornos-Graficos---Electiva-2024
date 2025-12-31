<?php
    require_once __DIR__."/../structs/shop.class.php";
    require_once __DIR__."/../structs/user.class.php";
    require_once __DIR__."/../structs/promotion.class.php";
    require_once __DIR__."/../structs/shopType.class.php";
    require_once __DIR__."/../data/promotion.data.phps";

    class PromotionContoller{
        public static function registerPromotion (Promotion $promo) {
            try {
                PromotionData::add($promo);
            } catch (Exception $e) {
                throw new Exception("Error en el registro de la promocion. ".$e->getMessage());
            }
            return $promo;
        }
    }
?>