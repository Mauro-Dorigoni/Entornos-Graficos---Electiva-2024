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
        public static function getByMail(User $user){
            $userFound = null;
            try {
                $userFound = UserData::findByMail($user);
                if($userFound === null){
                    throw new Exception("Usuario no encontrado");
                };
                if($userFound->getPass() != $user->getPass()){
                    throw new Exception("Contraseña incorrecta");
                }
                return $userFound;
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            return $userFound;
        }
    }
?>