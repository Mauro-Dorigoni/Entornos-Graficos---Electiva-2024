<?php 
require_once __DIR__."/shop.class.php";
class OwnerReport {
    private string $day;
    private $promotions = [];
    private $promotionUses = [];
    private DateTimeImmutable $dateGenerated;
    private Shop $shop;

    public function _constructor() {
    }
    public function setDay(string $day){
        $this->day=$day;
    }
    public function getDay(){
        return $this->day;
    }
    public function setPromotions(array $promotions): void {
        $this->promotions = $promotions;
    }
    public function getPromotions(): array {
        return $this->promotions;
    }
    public function setPromotionUses(array $promotionUses): void {
        $this->promotionUses = $promotionUses;
    }
    public function getPromotionUses(): array {
        return $this->promotionUses;
    }
    public function setDateGenerated(DateTimeInterface $dateGenerated): void {
        $this->dateGenerated = DateTimeImmutable::createFromInterface($dateGenerated);
    }
    public function getDateGenerated(): ?DateTimeInterface {
        return $this->dateGenerated;
    }
    public function setShop(Shop $shop): void {
        $this->shop = $shop;
    }
    public function getShop(): Shop {
        return $this->shop;
    }
}
?>