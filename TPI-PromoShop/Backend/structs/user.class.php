<?php

class User {
    private int $id;
    private $email;
    private $pass;

    private bool $isAdmin;

    private bool $isOwner;

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

}
?>