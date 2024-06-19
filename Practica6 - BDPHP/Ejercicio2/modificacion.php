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
$password = "";
$dbname = "capitales";

$conn = new mysqli($servername, $username, $password, $dbname);
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
    while ($fila = mysqli_fetch_assoc($resultados)) {
        ?>
        <tr>
            <td><?php echo $fila['id']; ?></td>
            <td><?php echo $fila['ciudad']; ?></td>
            <td><?php echo $fila['pais']; ?></td>
            <td><?php echo $fila['habitantes']; ?></td>
            <td><?php echo $fila['superficie']; ?></td>
            <td><?php echo $fila['tieneMetro'] ? 'Sí' : 'No'; ?></td>
            <td>
                <form action="modificar.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                    <button type="submit">Modificar</button>
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
