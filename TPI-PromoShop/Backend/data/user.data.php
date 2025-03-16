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
            $stmt = $conn->prepare("INSERT INTO user (email, pass) VALUES (?, ?)");
            if (!$stmt) {
                throw new Exception("Error al preparar la consulta: " . $conn->error);
            }
            $email = $user->getEmail();
            $pass = $user->getPass();
            $stmt->bind_param("ss", $email, $pass);
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
}
?>
