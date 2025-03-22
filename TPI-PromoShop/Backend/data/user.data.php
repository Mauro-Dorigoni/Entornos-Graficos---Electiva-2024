<?php
require_once "../shared/BD.data.dev.php";
require_once "../structs/user.class.php";
require_once __DIR__."/../structs/userCategory.class.php";

class UserData {
    public static function add(User $user) {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("INSERT INTO user (email, pass, isAdmin, isOwner, dateDeleted, emailToken, isEmailVerified, idUserCategory) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
            $email = $user->getEmail();
            $pass = $user->getPass();
            $isOwner = $user->isOwner();
            $isAdmin = $user->isAdmin();
            $dateDeleted = null;
            $emailToken = $user->getEmailToken();
            $isEmailVerified = false;
            $idUserCategory = 1;
            $stmt->bind_param("ssiiisii", $email, $pass, $isAdmin, $isOwner, $dateDeleted, $emailToken, $isEmailVerified, $idUserCategory);
            $stmt->execute();
            echo "Usuario agregado exitosamente.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
    }

    public static function findByMail(User $user){
        $userFound = null;
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT usu.id, usu.email, usu.pass, usu.isAdmin, usu.isOwner, usu.dateDeleted, usu.emailToken, usu.isEmailVerified, usu.idUserCategory, cat.categoryType, cat.dateDeleted as catDateDeleted FROM user usu inner join usercategory cat on usu.idUserCategory=cat.id WHERE usu.email = ? and usu.dateDeleted is null;");
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $conn->error);
            };
            $email = $user->getEmail();
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $userFound = new User();
                $userFound->setId($row['id']);
                $userFound->setEmail($row['email']);
                $userFound->setPass($row['pass']);
                $userFound->setIsAdmin((bool)$row['isAdmin']);
                $userFound->setIsOwner((bool)$row['isOwner']);
                $userFound->setIsEmailVerified((bool)$row['isEmailVerified']);
                $userFoundCategory = new UserCategory();
                $userFoundCategory->setId($row['idUserCategory']);
                $userFoundCategory->setCategoryType($row['categoryType']);
                $userFound->setUserCategory($userFoundCategory);

            };
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
        return $userFound;
    }

    public static function findByMailToken(User $user){
        $userFound = null;
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT usu.id, usu.email, usu.pass, usu.isAdmin, usu.isOwner, usu.dateDeleted, usu.emailToken, usu.isEmailVerified, usu.idUserCategory, cat.categoryType, cat.dateDeleted as catDateDeleted FROM user usu inner join usercategory cat on usu.idUserCategory=cat.id WHERE usu.emailToken = ? and usu.dateDeleted is null;");
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $conn->error);
            };
            $emailToken = $user->getEmailToken();
            $stmt->bind_param("s", $emailToken);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $userFound = new User();
                $userFound->setId($row['id']);
                $userFound->setEmail($row['email']);
                $userFound->setPass($row['pass']);
                $userFound->setIsAdmin((bool)$row['isAdmin']);
                $userFound->setIsOwner((bool)$row['isOwner']);
                $userFound->setEmailToken($row['emailToken']);
                $userFound->setIsEmailVerified((bool)$row['isEmailVerified']);
                $userFoundCategory = new UserCategory();
                $userFoundCategory->setId($row['idUserCategory']);
                $userFoundCategory->setCategoryType($row['categoryType']);
                $userFound->setUserCategory($userFoundCategory);

            };
            
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
        return $userFound;
    }

    public static function updateUser(User $user){
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("UPDATE user set email=?, pass=?, isAdmin=?, isOwner=?, dateDeleted=?, emailToken=?, isEmailVerified=?, idUserCategory=? WHERE id=?");
            if (!$stmt) {
                throw new Exception("Error al preparar consulta: " . $conn->error);
            };
            $email=$user->getEmail();
            $pass=$user->getPass();
            $isAdmin=$user->isAdmin();
            $isOwner=$user->isOwner();
            $dateDeleted=$user->getDateDeleted();
            $emailToken=$user->getEmailToken();
            $isEmailVerified=$user->isEmailVerified();
            $idUserCategory=$user->getUserCategory()->getID();
            $id=$user->getId();
            echo "EL ID:".$id." EL Verifie:".$isEmailVerified;
            $stmt->bind_param("ssiiisiii", $email, $pass, $isAdmin, $isOwner, $dateDeleted, $emailToken, $isEmailVerified, $idUserCategory, $id);
            $stmt->execute();
            if ($stmt->affected_rows === 0) {
                throw new Exception("No se actualizó ningún registro.");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conn)) {
                $conn->close();
            }
        }
    }
}
?>
