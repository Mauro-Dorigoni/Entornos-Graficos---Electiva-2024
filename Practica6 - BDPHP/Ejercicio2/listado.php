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

$resultados=mysqli_query($conn,"SELECT * from ciudades");
?>
<table>
<tr>
    <td>ID</td>
    <td>Ciudad</td>
    <td>Pais</td>
    <td>Habitantes</td>
    <td>Superficie</td>
    <td>Tiene metro?</td>
</tr>
<?php
while($fila = mysqli_fetch_array($resultados))
    {
    ?>
    <tr>
    <td><?php echo ($fila[0]); ?></td>
    <td><?php echo ($fila[1]); ?></td>
    <td><?php echo ($fila[2]); ?></td>
    <td><?php echo ($fila[3]); ?></td>
    <td><?php echo ($fila[4]); ?></td>
    <td><?php echo ($fila[5]); ?></td>
    </tr>
    <tr>
    <td colspan="5">
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
