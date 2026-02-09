<?php
require_once __DIR__ . "/../structs/ownerReport.class.php";
require_once __DIR__ . "/../data/promotion.data.php";
require_once __DIR__ . "/../data/promoUse.data.php";
require_once __DIR__ . "/../data/shop.data.php";
require_once __DIR__ . "/../data/user.data.php";

class ReportController {

    public static function ownerReport(Shop $shop) {
        $ownerReport = new OwnerReport();
         try {
            $promotions = PromotionData::findAllByShop($shop);

            $notRejectedPromotions = array_filter(
                $promotions,
                fn($promo) => $promo->getMotivoRechazo() === null
            );

            $ownerReport -> setPromotions($notRejectedPromotions);
            $ownerReport -> setDateGenerated(new DateTimeImmutable("now"));
            $ownerReport -> setShop($shop);

            $day = PromoUseData::topWeekDay($shop);

            $ownerReport -> setDay($day);

            $countPromotionUsage = [];

            foreach($notRejectedPromotions as $promo): 
                $countPromotionUsage[] = PromoUseData::countUsedByPromo($promo);
            endforeach;

            $ownerReport -> setPromotionUses($countPromotionUsage);

            return $ownerReport;

        } catch (Exception $e) {
            throw new Exception(
                "Error al generar el reporte. " . $e->getMessage()
            );
        }
    }

    public static function adminReport(){
        $adminReport = new AdminReport();
        try {
            $shops = ShopData::findAll();

            $adminReport -> setShops($shops);

            $countPromotionUsageByShop = [];

            foreach($shops as $s):
                $countPromotionUsageByShop[] = PromoUseData::countUsedByShop($s);
            endforeach; 

            $topUsedPromo = PromotionData::topUsedPromo();
            $adminReport -> setTopUsedPromotion($topUsedPromo);

            $topUser = UserData::topUser();
            $adminReport -> setTopUser($topUser);

            return $adminReport;
        }
        catch(Exception $e) {
            throw new Exception(
                "Error al generar el reporte. " . $e->getMessage()
            );
        }
    }

}