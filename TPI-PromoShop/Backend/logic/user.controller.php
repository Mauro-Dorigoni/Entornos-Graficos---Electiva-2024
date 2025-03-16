<?php 
    require_once "../structs/user.class.php";
    require_once "../data/user.data.php";
    class UserController {
        public static function registerUser(User $user){
            try {
                UserData::add($user);
                echo "\n Registro exitoso";
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
?>