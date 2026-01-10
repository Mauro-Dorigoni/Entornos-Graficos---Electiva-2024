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
        public static function getOne (Promotion $promo) {
            try {
                $foundPromo = PromotionData::findById($promo);
            } catch (Exception $e) {
                throw new Exception("No se pudo encontrar la promocion. ".$e->getMessage());
            }
            return $foundPromo;
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
        public static function getAllActiveByShop(Shop $shop): array{
            try {
                $promotions = PromotionData::findAllByShop($shop);

                $activePromotions = array_filter(
                    $promotions,
                    fn ($promo) => $promo->getStatus() === PromoStatus_enum::Vigente
                );

                return array_values($activePromotions);
            } catch (Exception $e) {
                throw new Exception(
                    "Error al buscar las promociones activas del local. " . $e->getMessage()
                );
            }
        }
        public static function getAllByShop(Shop $shop){ 
            $activePromotions = []; 
            try{ 
                $activePromotions = PromotionData::findAllByShop($shop); 
            } catch (Exception $e) { 
                throw new Exception("Error al buscar las promociones activas del locals. ".$e->getMessage()); 
            } 
            return $activePromotions; 
        }
        public static function approvePromotion(Promotion $promo): void {
        try {
            PromotionData::approvePromotion($promo);
        } catch (Exception $e) {
            throw new Exception(
                "Error al aprobar la promoción. " . $e->getMessage()
            );
        }
        }
        public static function rejectPromotion(Promotion $promo): void {
            try {
                PromotionData::rejectPromotion($promo);
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