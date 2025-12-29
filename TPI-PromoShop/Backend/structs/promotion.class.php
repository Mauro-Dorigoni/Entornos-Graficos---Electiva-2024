<?php
require_once "./user.class.php";
require_once "./userCategory.class.php";
require_once "./shop.class.php";

class Promotion{
    private int $id;
    private string $promoText;
    private string $status;
    private string $motivoRechazo;
    private string $imageUUID;
    private $dateFrom;

    private $dateTo;
    private $validDays = [];

    private $dateDeleted;
    private Shop $shop;

    private User $admin;

    private UserCategory $userCategory;

    public function __construct() {
    }

    public function setId(int $id){
            $this->id=$id;
    }
    public function setPromoText(string $promoText){
        $this->promoText=$promoText;
    }
    public function setMotivoRechazo(string $motivoRechazo){
        $this->motivoRechazo=$motivoRechazo;
    }
    public function setStatus(string $status){
        $this->status=$status;
    }
    public function setImageUUID(string $imageUUID){
        $this->imageUUID=$imageUUID;
    }
    public function setDateFrom ($dateFrom){
            $this->dateFrom=$dateFrom;
    }
    public function setDateTo ($dateTo){
        $this->dateTo=$dateTo;
    }
    public function setValidDays(array $validDays){
        $this->validDays=$validDays;
    }
    public function setDateDeleted ($dateDeleted){
        $this->dateDeleted=$dateDeleted;
    }
    public function setShop(Shop $shop){
        $this->shop=$shop;
    }
    public function setAdmin (User $admin){
        $this->admin=$admin;
    }
    public function setUserCategory(UserCategory $userCategory){
        $this->userCategory=$userCategory;
    }
    public function getId(){
        return $this->id;
    }
    public function getPromoText(){
        return $this->promoText;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getMotivoRechazo(){
        return $this->motivoRechazo;
    }  
    public function getDateDeleted() {
        return $this->dateDeleted;
    }
    public function getDateFrom() {
        return $this->dateFrom;
    }
    public function getDateTo() {
        return $this->dateTo;
    }
    public function getValidDays(){
        return $this->validDays;
    }
    public function getShop(){
        return $this->shop;
    }
    public function getAdmin(){
        return $this->admin;
    }
    public function getUserCategory(){
        return $this->userCategory;
    }
}
?>
