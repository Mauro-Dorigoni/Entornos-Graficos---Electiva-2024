<?php 
    require_once __DIR__."/../structs/user.class.php";
    require_once __DIR__."/../data/user.data.php";
    require_once __DIR__."/../structs/userCategory.class.php";
    require_once __DIR__."/../data/promoUse.data.php";
    require_once __DIR__."/../data/user.data.php";

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
                throw new Exception("Error en el registro de usuario. ".$e->getMessage());
            }
            return $user;
        }
        public static function registerOwner(User $owner){
            try {
                $owner->setDateDeleted(null);
                $owner->setIsAdmin(false);
                $owner->setIsEmailVerified(true);
                $owner->setIsOwner(true);
                $userCategory = new UserCategory();
                $userCategory->setId(1);
                $owner->setUserCategory($userCategory);
                UserData::add($owner);
            } catch (Exception $e) {
                throw new Exception("Error en el registro de usuario. ".$e->getMessage());
            }
            return $owner;
        }
        public static function getByEmailToken(User $user){
            $userFound = null;
            try {
                $userFound = UserData::findByMailToken($user);
            } catch (Exception $e) {
                throw new Exception("Error al tratar de buscar el usuario por mail Token. ".$e->getMessage());
            }
            return $userFound;
        }

        public static function getOne(User $user){
            $userFound = null;
            try {
                $userFound = UserData::findOne($user);
            } catch (Exception $e) {
                throw new Exception("Error al tratar de buscar el usuario por id. ".$e->getMessage());
            }
            return $userFound;
        }

        public static function validateUserEmail(User $user){
            $user->setIsEmailVerified(true);
            try {
                UserData::updateUser($user);
            } catch (Exception $e) {
                throw new Exception("Error al tratar de validar el mail del usuario. ".$e->getMessage());
            }
        }
        public static function getByMail(User $user){
            $userFound = null;
            try {
                $userFound = UserData::findByMail($user);
                /* if($userFound === null){
                    throw new Exception("Usuario no encontrado");
                }; */
                /* if($userFound->getPass() != $user->getPass()){
                    throw new Exception("Contraseña incorrecta");
                } */
                /* if($userFound!=null and !$userFound->isEmailVerified()){
                    throw new Exception("Email no verificado");
                } */
                return $userFound;
            } catch (Exception $e) {
                throw new Exception("Error al tratar de encontrar al usuario por su mail. ".$e->getMessage());
            }
        }
        public static function delete(User $user){
            try {
                UserData::deleteUser($user);
            } catch (Exception $e) {
                throw new Exception("Error al tratar de borrar su cuenta. ".$e->getMessage());
            }
        }

        public static function update($user){
            try {
                UserData::updateUser($user);
            } catch (Exception $e) {
                throw new Exception("Error al tratar de actualizar los datos del usuario. ".$e->getMessage());
            }
        }

        /*Devuelve un usuario (Owner) dado un id de local.*/
        public static function getOwnerByShopId(Shop $shop): User {
            $owner = null;
            try { 
                $owner = UserData::findOwnerByShopId($shop);
            } catch (Exception $e) {
                throw new Exception("Error al buscar el usuario duseño de un local ".$e->getMessage());
            }
            return $owner;
        }

        public static function getPromoCount(User $user){
            try { 
                $uses = UserData::findPromoUses($user);
            } catch (Exception $e) {
                throw new Exception("Error al buscar la cantidad de promociones usadas por el usuario ".$e->getMessage());
            }
            return $uses;
        }
    }
?>