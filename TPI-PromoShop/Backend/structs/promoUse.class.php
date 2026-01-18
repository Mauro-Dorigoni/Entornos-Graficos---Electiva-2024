<?php
require_once __DIR__."/user.class.php";
require_once __DIR__."/promotion.class.php";

class PromoUse{
    private int $id;
    private $useDate;
    private string $uniqueCode;
    private ?bool $wasUsed;
    private Promotion $promo;
    private User $user;
    private ?User $owner = null;

    public function setId(int $id){
        $this->id=$id;
    }
    public function setUseDate($useDate){
        $this->useDate=$useDate;
    }
    public function setUniqueCode(string $uniqueCode){
        $this->uniqueCode=$uniqueCode;
    }
    public function setWasUsed(?bool $wasUsed){
        $this->wasUsed=$wasUsed;
    }
    public function setPromo(Promotion $promotion){
        $this->promo=$promotion;
    }
    public function setUser(User $user){
        $this->user=$user;
    }
    public function setOwner(?User $owner){
        $this->owner=$owner;
    }
    public function getId(){
        return $this->id;
    }
    public function getUseDate(){
        return $this->useDate;
    }
    public function getUniqueCode(){
        return $this->uniqueCode;
    }
    public function isUsed(){
        return $this->wasUsed;
    }
    public function wasUsed(){
        return $this->wasUsed;
    }
    public function getPromo(){
        return $this->promo;
    }
    public function getUser(){
        return $this->user;
    }
    public function getOwner(){
        return $this->owner;
    }
}
?>