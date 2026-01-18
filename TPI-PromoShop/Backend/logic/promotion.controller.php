<?php
    require_once __DIR__."/../structs/shop.class.php";
    require_once __DIR__."/../structs/user.class.php";
    require_once __DIR__."/../structs/promotion.class.php";
    require_once __DIR__."/../structs/shopType.class.php";
    require_once __DIR__."/../data/promotion.data.php";
    require_once __DIR__."/../data/user.data.php";
    require_once __DIR__."/../data/promoUse.data.php";

    class PromotionContoller{
        public static function registerPromotion (Promotion $promo) {
            try {
                PromotionData::add($promo);
            } catch (Exception $e) {
                throw new Exception("Error en el registro de la promocion. ".$e->getMessage());
            }
            return $promo;
        }
        public static function getAllUsesByUser(){
            $userUses = [];
            try{
                $user = $_SESSION['user'];
                $userUses = PromoUseData::findAllByUser($user);
            } catch (Exception $e) {
                throw new Exception("Error al buscar las promociones usadas por el usuario ".$e->getMessage());
            }
            return $userUses;
        }
        public static function registerPromoUseCode(PromoUse $use) {
            try {
                PromoUseData::add($use);
            } catch (Exception $e) {
                throw new Exception("Error en el registro del codigo de uso de la promocion".$e->getMessage());
            }
            return $use;
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

        public static function checkSingleUse(PromoUse $use){
            try {
                $total = PromoUseData::checkSingleUse($use);
                if ($total === 0){
                    return true;
                }else
                    return false;
            } catch(Exception $e) {
                throw new Exception(
                    "Error verificar uso unico por usuario. " . $e->getMessage()
                );
            }
        }

        public static function usePromotionCode(string $code) {
            $promoUse = PromoUseData::findByCode($code);
            if (!$promoUse) throw new Exception("El código de promoción no es válido.");
            if ($promoUse->wasUsed()) throw new Exception("Este código ya ha sido utilizado.");

            $promo = $promoUse->getPromo();
            $today = new DateTimeImmutable('today');

            if ($promo->getStatus() !== PromoStatus_enum::Vigente) {
                throw new Exception("La promoción no se encuentra vigente o aprobada.");
            }
            if ($promo->getDateTo() < $today) {
                throw new Exception("La promoción ha vencido.");
            }
            $fullPromo = PromotionData::findById($promo); 
            $dayOfWeek = strtolower($today->format('l'));
            $validDays = $fullPromo->getValidDays();
            
            if (!isset($validDays[$dayOfWeek]) || !$validDays[$dayOfWeek]) {
                throw new Exception("La promoción no es válida para el día de hoy.");
            }
            $owner = $_SESSION['user'];
            $promoUse->setOwner($owner);
            PromoUseData::markAsUsed($promoUse);
            $total = PromoUseData::countUsedByUser($promoUse->getUser());
            $user = UserData::findOne($promoUse->getUser());
            $idCategory = $user->getUserCategory();

            if ($total >= 25 and $idCategory != 3) {
                $user->getUserCategory()->setId(3); 
                UserData::updateUser($user);
            } elseif ($total >= 10 and $idCategory = 1) {
                $user->getUserCategory()->setId(2); 
                UserData::updateUser($user);
            }
            return true;
        }
    }
    
?>