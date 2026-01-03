<?php
require_once __DIR__."/user.class.php";
require_once __DIR__."/userCategory.class.php";
require_once __DIR__."/shop.class.php";
require_once __DIR__."/../shared/promoStatus.enum.php";

class Promotion{
    private int $id;
    private string $promoText;
    private PromoStatus_enum $status;
    private string $motivoRechazo;
    private string $imageUUID;
    private ?DateTimeImmutable $dateFrom;

    private ?DateTimeImmutable $dateTo;
    private $validDays = [];

    private ?DateTimeImmutable $dateDeleted;
    private Shop $shop;

    private User $admin;

    private UserCategory $userCategory;

    public function __construct() {
    }

 public function setId(int $id): void {
        $this->id = $id;
    }

    public function setPromoText(string $promoText): void {
        $this->promoText = $promoText;
    }

    public function setStatus(PromoStatus_enum $status): void {
        $this->status = $status;
    }

    public function setStatusFromString(string $status): void {
        $this->status = PromoStatus_enum::from($status);
    }

    public function setMotivoRechazo(?string $motivoRechazo): void {
        $this->motivoRechazo = $motivoRechazo;
    }

    public function setImageUUID(?string $imageUUID): void {
        $this->imageUUID = $imageUUID;
    }

    public function setDateFrom(DateTimeInterface $dateFrom): void {
        $this->dateFrom = DateTimeImmutable::createFromInterface($dateFrom);
    }

    public function setDateFromString(string $date): void {
        $this->dateFrom = new DateTimeImmutable($date);
    }

    public function setDateTo(DateTimeInterface $dateTo): void {
        $this->dateTo = DateTimeImmutable::createFromInterface($dateTo);
    }

    public function setDateToString(string $date): void {
        $this->dateTo = new DateTimeImmutable($date);
    }

    public function setDateDeleted(?DateTimeInterface $dateDeleted): void {
        $this->dateDeleted = $dateDeleted
            ? DateTimeImmutable::createFromInterface($dateDeleted)
            : null;
    }

    public function setDateDeletedString(?string $date): void {
        $this->dateDeleted = $date ? new DateTimeImmutable($date) : null;
    }

    public function setValidDays(array $validDays): void {
        $this->validDays = $validDays;
    }
    public function setShop(Shop $shop): void {
        $this->shop = $shop;
    }

    public function setAdmin(User $admin): void {
        $this->admin = $admin;
    }

    public function setUserCategory(UserCategory $userCategory): void {
        $this->userCategory = $userCategory;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getPromoText(): string {
        return $this->promoText;
    }

    public function getStatus(): PromoStatus_enum {
        return $this->status;
    }

    public function getStatusValue(): string {
        return $this->status->value;
    }

    public function getMotivoRechazo(): ?string {
        return $this->motivoRechazo;
    }
    public function getImageUUID(){
        return $this->imageUUID;
    }

    public function getDateFrom(): ?DateTimeInterface {
        return $this->dateFrom;
    }

    public function getDateFromMysql(): ?string {
        return $this->dateFrom?->format('Y-m-d');
    }

    public function getDateTo(): ?DateTimeInterface {
        return $this->dateTo;
    }

    public function getDateToMysql(): ?string {
        return $this->dateTo?->format('Y-m-d');
    }

    public function getDateDeleted(): ?DateTimeInterface {
        return $this->dateDeleted;
    }

    public function getDateDeletedMysql(): ?string {
        return $this->dateDeleted?->format('Y-m-d');
    }

    public function getValidDays(): array {
        return $this->validDays;
    }

    public function getShop(): Shop {
        return $this->shop;
    }

    public function getAdmin(): User {
        return $this->admin;
    }

    public function getUserCategory(): UserCategory {
        return $this->userCategory;
    }
}
?>
