<?php
$servername = "localhost";
$username = "root"; 
$password = "Julianalvarezbrasil19";
$dbname = "capitales";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $pais = $_POST['pais'];
    $cantidad_habitantes = $_POST['cantidad_habitantes'];
    $superficie = $_POST['superficie'];
    $tiene_metro = $_POST['tiene_metro'];
    $tiene_metro = $tiene_metro === '1' ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO ciudades (ciudad, pais, habitantes, superficie, tieneMetro) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $nombre, $pais, $cantidad_habitantes, $superficie, $tiene_metro);

    if ($stmt->execute()) {
        header("Location: listado.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>

