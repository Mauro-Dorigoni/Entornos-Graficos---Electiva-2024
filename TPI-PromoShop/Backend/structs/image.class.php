<?php 
class Image {
    private int $id;
    private string $uuid;
    private bool $isMain;

    public function _constructor() {
    }
    public function setId(int $id){
        $this->id=$id;
    }
    public function getId(){
        return $this->id;
    }
    public function setUUID(string $uuid){
        $this->uuid=$uuid;
    }
    public function getUUID(){
        return $this->uuid;
    }
    public function setIsMain(bool $isMain){
        $this->isMain=$isMain;
    }
    public function isMain(){
        return $this->isMain;
    }


}
?>