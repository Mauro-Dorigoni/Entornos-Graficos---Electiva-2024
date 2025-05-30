<?php
require_once __DIR__."/user.class.php";
require_once __DIR__."/shopType.class.php";
class Shop{
    private int $id;
    private string $name;
    private string $location;
    private $dateDeleted;
    private $imagesUUIDS = [];
    private User $owner;
    private ShopType $shopType;

    public function __construct() {
    }
    public function setId(int $id){
        $this->id=$id;
    }
    public function setName(string $name){
        $this->name=$name;
    }
    public function setLocation(string $location){
        $this->location=$location;
    }
    public function setDateDeleted($dateDeleted){
        $this->dateDeleted=$dateDeleted;
    }
    public function setImagesUUIDS(array $imagesUUIDS){
        $this->imagesUUIDS=$imagesUUIDS;
    }
    public function setOwner(User $owner){
        $this->owner=$owner;
    }
    public function setShopType(ShopType $shopType){
        $this->shopType=$shopType;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getLocation(){
        return $this->location;
    }
    public function getDateDeleted(){
        return $this->dateDeleted;
    }
    public function getImagesUUIDS(){
        return $this->imagesUUIDS;
    }
    public function getOwner(){
        return $this->owner;
    }
    public function getShopType(){
        return $this->shopType;
    }

}
?>