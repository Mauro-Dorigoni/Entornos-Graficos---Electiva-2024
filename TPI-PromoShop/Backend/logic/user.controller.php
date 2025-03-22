<?php 
    require_once "../structs/user.class.php";
    require_once "../data/user.data.php";
    require_once "../structs/userCategory.class.php";

    class UserController {
        public static function registerUser(User $user){
            try {
                $user->setDateDeleted(null);
                $user->setIsAdmin(false);
                $user->setIsEmailVerified(false);
                $user->setIsOwner(false);
                $userCategory = new UserCategory();
                $userCategory->setId(1);
                $user->setUserCategory($userCategory);
                UserData::add($user);
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            return $user;
        }
        public static function getByEmailToken(User $user){
            $userFound = null;
            try {
                $userFound = UserData::findByMailToken($user);
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            return $userFound;
        }

        public static function validateUserEmail(User $user){
            $user->setIsEmailVerified(true);
            try {
                UserData::updateUser($user);
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
                if($userFound!=null and !$userFound->isEmailVerified()){
                    throw new Exception("Email no verificado");
                }
                return $userFound;
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
            return $userFound;
        }
    }
?>