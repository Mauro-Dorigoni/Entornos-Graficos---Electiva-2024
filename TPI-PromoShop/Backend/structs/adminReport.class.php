<?php 
require_once __DIR__."/promotion.class.php";
require_once __DIR__."/user.class.php";
class AdminReport {
    private $shops = [];
    private $promoUsedByShop = [];
    private Promotion $topUsedPromotion;
    private User $topUser;

    public function setShops(array $shops): void {
        $this->shops = $shops;
    }
    public function getShops(): array {
        return $this->shops;
    }
    public function setPromoUsedByShop(array $promoUsedByShop): void {
        $this->promoUsedByShop = $promoUsedByShop;
    }
    public function getPromoUsedByShop(): array {
        return $this->promoUsedByShop;
    }
    public function setTopUsedPromotion(Promotion $topUsedPromotion): void {
        $this->topUsedPromotion = $topUsedPromotion;
    }
    public function getTopUsedPromotion(): Promotion {
        return $this->topUsedPromotion;
    }
    public function setTopUser(User $topUser): void {
        $this->topUser = $topUser;
    }
    public function getTopUser(): User {
        return $this->topUser;
    }
}