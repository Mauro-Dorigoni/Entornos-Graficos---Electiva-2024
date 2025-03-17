<?php
require_once "../shared/BD.data.dev.php";
require_once "../structs/user.class.php";

class UserData {
    public static function add(User $user) {
        try {
            $conn = new mysqli(servername, username, password, dbName);
            if ($conn->connect_error) {
                throw new Exception("Error de conexión: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("INSERT INTO user (email, pass, isAdmin, isOwner) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
            $email = $user->getEmail();
            $pass = $user->getPass();
            $isOwner = $user->isOwner();
            $isAdmin = $user->isAdmin();
            $stmt->bind_param("ssii", $email, $pass, $isAdmin, $isOwner);
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
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
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
                $userFound->setIsAdmin($row['isAdmin']);
                $userFound->setIsOwner($row['isOwner']);
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
}
?>
