<?php
class UserCategory {
    private int $id;
    private string $categoryType;
    private $dateDeleted;

    public function __construct() {
    }

    public function setId (int $id){
        $this->id=$id;
    }
    public function setCategoryType(string $categoryType){
        $this->categoryType=$categoryType;
    }
    public function setDateDeleted($dateDeleted){
        $this->dateDeleted=$dateDeleted;
    }
    public function getID(){
        return $this->id;
    }
    public function getCategoryType(){
        return $this->categoryType;
    }
    public function getDateDeleted(){
        return $this->dateDeleted;
    }
}
?>