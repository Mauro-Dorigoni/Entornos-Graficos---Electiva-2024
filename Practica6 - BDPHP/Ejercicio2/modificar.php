<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Ciudad</title>
</head>
<body>
<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "capitales";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "SELECT * FROM ciudades WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $ciudad = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar'])) {
    $id = $_POST['id'];
    $ciudad = $_POST['ciudad'];
    $pais = $_POST['pais'];
    $habitantes = $_POST['habitantes'];
    $superficie = $_POST['superficie'];
    $tieneMetro = isset($_POST['tieneMetro']) ? 1 : 0; 

    $update_sql = "UPDATE ciudades SET ciudad=?, pais=?, habitantes=?, superficie=?, tieneMetro=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssidis", $ciudad, $pais, $habitantes, $superficie, $tieneMetro, $id);

    if ($stmt->execute()) {
        header("Location: listado.php");
    } else {
        echo "<div>Error al actualizar el registro: " . $conn->error . "</div>";
    }

    $stmt->close();
}

?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label for="ciudad">Ciudad:</label>
    <input type="text" id="ciudad" name="ciudad" value="<?php echo $ciudad['ciudad']; ?>" required><br><br>
    <label for="pais">País:</label>
    <input type="text" id="pais" name="pais" value="<?php echo $ciudad['pais']; ?>" required><br><br>
    <label for="habitantes">Habitantes:</label>
    <input type="number" id="habitantes" name="habitantes" value="<?php echo $ciudad['habitantes']; ?>" required><br><br>
    <label for="superficie">Superficie:</label>
    <input type="number" id="superficie" name="superficie" value="<?php echo $ciudad['superficie']; ?>" required><br><br>
    <label for="tieneMetro">Tiene metro?</label>
    <input type="checkbox" id="tieneMetro" name="tieneMetro" <?php echo $ciudad['tieneMetro'] ? 'checked' : ''; ?>><br><br>
    <button type="submit" name="modificar">Guardar Cambios</button>
</form>

<a href="listado.php"><button>Volver al Listado</button></a>

<?php
mysqli_close($conn);
?>
</body>
</html>
