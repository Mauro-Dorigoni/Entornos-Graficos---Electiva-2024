<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurable Styles Page</title>
    <?php
    // Verificar si la cookie "nombre" existe
    if (isset($_COOKIE['nombre'])) {
        $nombre = $_COOKIE['nombre'];
        $texto = "Bienvenido $nombre";
    } else {
        // Si no existe, es la primera visita
        $texto = 'Bienvenido';
    }
    ?>
</head>

<body>
    <h1><?php echo $texto ?></h1>
    <form action="" method="post">
        <label for="nombre">Elegi el nombre:</label>
        <input type="text" id="nombre" placeholder="nombre" name="nombre">
        <button type="submit">Submit</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        // Establecer la cookie con el nombre seleccionado por 30 días
        setcookie('nombre', $nombre, time() + (86400 * 30), "/");
        // Recargar la página para aplicar el nuevo nombre
        echo "<script>window.location.href=window.location.href;</script>";
    }
    ?>
</body>

</html>