<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado</title>
</head>
<body>
<?php
$servername = "localhost";
$username = "root"; 
$password = "Julianalvarezbrasil19";
$dbname = "capitales";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM ciudades WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<div>Registro eliminado correctamente.</div>";
    } else {
        echo "<div>Error al eliminar el registro: " . $conn->error . "</div>";
    }

    $stmt->close();
}

$resultados = mysqli_query($conn, "SELECT * FROM ciudades");

?>
<table>
    <tr>
        <th>ID</th>
        <th>Ciudad</th>
        <th>País</th>
        <th>Habitantes</th>
        <th>Superficie</th>
        <th>Tiene metro?</th>
        <th>Acción</th>
    </tr>
    <?php
    while ($fila = mysqli_fetch_array($resultados)) {
        ?>
        <tr>
            <td><?php echo $fila['id']; ?></td>
            <td><?php echo $fila['ciudad']; ?></td>
            <td><?php echo $fila['pais']; ?></td>
            <td><?php echo $fila['habitantes']; ?></td>
            <td><?php echo $fila['superficie']; ?></td>
            <td><?php echo $fila['tieneMetro'] ? 'Sí' : 'No'; ?></td>
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                    <button type="submit">Borrar</button>
                </form>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<a href="index.html"><button>Volver</button></a>

<?php
mysqli_free_result($resultados);
mysqli_close($conn);
?>
</body>
</html>