<?php
try {
    $servername = "localhost";
    $conn = new mysqli($servername, "root", "123456", "practica_final");
    if ($conn->connect_error) {
        throw new Exception("Error Processing Request", 1);
    } 

    $createtable = "CREATE TABLE IF NOT EXISTS pedidos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        nombre_producto VARCHAR(255) NOT NULL,
        mes INT NOT NULL,
        cantidad INT NOT NULL,
        terminos BOOLEAN NOT NULL,
        fecha_hora DATETIME NOT NULL
    )";

    $stmt = $conn->prepare($createtable);
    $stmt->execute();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>