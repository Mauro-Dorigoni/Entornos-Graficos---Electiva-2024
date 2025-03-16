<?php

class User {
    private $id;
    private $email;
    private $pass;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function __construct() {
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
}
?>