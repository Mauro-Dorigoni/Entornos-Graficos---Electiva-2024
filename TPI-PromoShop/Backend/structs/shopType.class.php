<?php
class ShopType{
    private int $id;
    private string $type;
    private string $description;
    private $dateDeleted;

    public function __construct(){}

    public function setId(int $id){
        $this->id=$id;
    }
    public function setType(string $type){
        $this->type=$type;
    }
    public function setDescription(string $desc){
        $this->description=$desc;
    }
    public function setDateDeleted($dateDeleted){
        $this->dateDeleted=$dateDeleted;
    }
    public function getId(){
        return $this->id;
    }
    public function getType(){
        return $this->type;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getDateDeleted(){
        return $this->dateDeleted;
    }

}
?>