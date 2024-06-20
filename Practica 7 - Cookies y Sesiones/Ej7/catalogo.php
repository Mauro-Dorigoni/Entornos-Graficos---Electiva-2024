<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado</title>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['carro'])) {
    $_SESSION['carro'] = [];
}

function agregarProductoAlCarro($id, $nombre, $cantidad) {
    if (isset($_SESSION['carro'][$id])) {
        $_SESSION['carro'][$id]['cantidad'] += $cantidad;
    } else {
        $_SESSION['carro'][$id] = [
            'id' => $id,
            'nombre' => $nombre,
            'cantidad' => $cantidad
        ];
    }
}
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "compras";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$resultados=mysqli_query($conn,"SELECT * from catalogo");
?>
<table>
<tr>
    <td>ID</td>
    <td>Producto</td>
    <td>Precio</td>

</tr>
<?php
while($fila = mysqli_fetch_array($resultados))
    {
    ?>
    <tr>
    <td><?php echo ($fila[0]); ?></td>
    <td><?php echo ($fila[1]); ?></td>
    <td><?php echo ($fila[2]); ?></td>
    <td>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                <input type="hidden" name="nombre" value="<?php echo $fila['producto']; ?>">
                <input type="hidden" name="cantidad" value="1">
                <button type="submit" name="agregar_carrito">Agregar al Carrito</button>
            </form>
    <td colspan="5">
    </tr>
    <?php
}
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_carrito'])) {
    $idProducto = $_POST['id'];
    $nombreProducto = $_POST['nombre'];
    $cantidadProducto = $_POST['cantidad'];
    agregarProductoAlCarro($idProducto, $nombreProducto, $cantidadProducto);
    header("Location: carrito.php");

};
mysqli_free_result($resultados);
mysqli_close($conn);
?>
</body>
</html>