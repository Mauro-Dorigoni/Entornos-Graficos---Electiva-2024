<?php
    require_once __DIR__."/../structs/shop.class.php";
    require_once __DIR__."/../structs/user.class.php";
    require_once __DIR__."/../structs/promotion.class.php";
    require_once __DIR__."/../structs/shopType.class.php";
    require_once __DIR__."/../data/promotion.data.php";

    class PromotionContoller{
        public static function registerPromotion (Promotion $promo) {
            try {
                PromotionData::add($promo);
            } catch (Exception $e) {
                throw new Exception("Error en el registro de la promocion. ".$e->getMessage());
            }
            return $promo;
        }
        public static function getAllPending(){
            $pendingPromotions = [];
            try{
                $pendingPromotions = PromotionData::findPending();
            } catch (Exception $e) {
                throw new Exception("Error al buscar las promociones pendientes. ".$e->getMessage());
            }
            return $pendingPromotions;
        }
        public static function getAllActiveByShop(Shop $shop){
            $activePromotions = [];
            try{
                $activePromotions = PromotionData::findAllActiveByShop($shop);
            } catch (Exception $e) {
                throw new Exception("Error al buscar las promociones activas del locals. ".$e->getMessage());
            }
            return $activePromotions;
        }
        public static function approvePromotion(Promotion $promo,User $admin): void {
        try {
            PromotionData::approvePromotion($promo, $admin);
        } catch (Exception $e) {
            throw new Exception(
                "Error al aprobar la promoción. " . $e->getMessage()
            );
        }
        }
        public static function rejectPromotion(Promotion $promo,User $admin,string $motivoRechazo): void {
            try {
                PromotionData::rejectPromotion($promo, $admin, $motivoRechazo);
            } catch (Exception $e) {
                throw new Exception(
                    "Error al rechazar la promoción. " . $e->getMessage()
                );
            }
        }
        public static function deletePromotion(Promotion $promo): void
        {
            try {
                PromotionData::softDeletePromotion($promo);
            } catch (Exception $e) {
                throw new Exception(
                    "Error al eliminar la promoción. " . $e->getMessage()
                );
            }
        }
    }
    
?>