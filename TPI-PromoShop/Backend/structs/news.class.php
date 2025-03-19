<?php
require_once "./user.class.php";
require_once "./userCategory.class.php";

class News {
    private int $id;
    private string $newsText;
    private $dateFrom;
    private $dateTo;
    private $dateDeleted;
    private User $admin;
    private UserCategory $userCategory;

    public function __construct() {
    }

    public function setId(int $id){
        $this->id=$id;
    }
    public function setNewsText (string $newsText){
        $this->newsText=$newsText;
    }
    public function setDateFrom ($dateFrom){
        $this->dateFrom=$dateFrom;
    }
    public function setDateTo ($dateTo){
        $this->dateTo=$dateTo;
    }
    public function setDateDeleted ($dateDeleted){
        $this->dateDeleted=$dateDeleted;
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
    public function getNewsText(){
        return $this->newsText;
    }
    public function getDateFrom() {
        return $this->dateFrom;
    }
    public function getDateTo() {
        return $this->dateTo;
    }
    public function getDateDeleted() {
        return $this->dateDeleted;
    }
    public function getAdmin(){
        return $this->admin;
    }
    public function getUserCategory(){
        return $this->userCategory;
    }
}
?>