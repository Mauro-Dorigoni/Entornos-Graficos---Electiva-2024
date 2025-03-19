<?php
require_once "./userCategory.class.php";
class User {
    private int $id;
    private $email;
    private $pass;
    private bool $isAdmin;
    private bool $isOwner;
    private $dateDeleted;
    private bool $isEmailVerified;

    private UserCategory $userCategory;

    public function __construct() {
    }
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function setEmail($email){
        $this->email=$email;
    }
    public function setPass($pass){
        $this->pass=$pass;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPass(){
        return $this->pass;
    }
    public function isOwner(){
        return $this->isOwner;
    }
    public function isAdmin(){
        return $this->isAdmin;
    }
    public function setIsOwner(bool $isOwner){
        $this->isOwner=$isOwner;
    }
    public function setIsAdmin(bool $isAdmin){
        $this->isAdmin=$isAdmin;   
    }
    public function setDateDeleted($dateDeleted){
        $this->dateDeleted=$dateDeleted;
    }
    public function getDateDeleted(){
        return $this->dateDeleted;
    }
    public function setIsEmailVerified(bool $isEmailVerified){
        $this->isAdmin=$isEmailVerified;   
    }
    public function isEmailVerified(){
        return $this->isEmailVerified;
    }
    public function setUserCategory(UserCategory $userCategory){
        $this->userCategory=$userCategory;
    }
    public function getUserCategory(){
        return $this->userCategory;
    }
}
?>