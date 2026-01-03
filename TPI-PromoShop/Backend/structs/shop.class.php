<?php
require_once __DIR__."/user.class.php";
require_once __DIR__."/shopType.class.php";
require_once __DIR__."/image.class.php";
class Shop{
    private int $id;
    private string $name;
    private string $location;
    private $dateDeleted;
    private $imagesUUIDS = [];
    private $images = [];
    private $mainImage;
    private User $owner;
    private ShopType $shopType;
    private string $description;
    private string $openingHours;

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
    //ARRAY DEL TIPO IMAGE
    public function setImages(array $images) {
        $this-> images = $images;
        foreach ($images as $img) {
            if ($img->isMain()) {
                $this->setMainImage($img);
            }
        }
    }
    public function setOwner(User $owner){
        $this->owner=$owner;
    }
    public function setShopType(ShopType $shopType){
        $this->shopType=$shopType;
    }
    public function setDescription(string|null $description){
        $this->description=$description?:'No hay datos.';
        //TODO -> Es correcto ponerlo aca?? Dejarle pasar el null o hay que solucionarlo en capa de datos?????P
    }
    public function setOpeningHours(string|null $openingHours){
        $this->openingHours=$openingHours?:'No hay datos.';
    }
    public function setMainImage(Image $mainImage) {
        $this->mainImage=$mainImage;
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
    public function getImages(){
        return $this->images;
    }
    public function getOwner(){
        return $this->owner;
    }
    public function getShopType(){
        return $this->shopType;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getOpeningHours(){
        return $this->openingHours;
    }
    public function getMainImage() {
        return $this->mainImage;
    }

}
?>