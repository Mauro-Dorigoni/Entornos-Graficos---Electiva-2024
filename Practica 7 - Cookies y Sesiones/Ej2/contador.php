<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    // Verificar si la cookie "contador" existe
    if (isset($_COOKIE['contador'])) {
        // Incrementar el valor del contador
        $contador = $_COOKIE['contador'] + 1;
        $texto = "Has visitado esta página $contador veces.";
    } else {
        // Si no existe, es la primera visita
        $contador = 1;
        $texto = 'Bienvenido';
    }
    // Establecer la cookie con el valor actualizado
    setcookie('contador', $contador, time() + (86400 * 30), "/"); // 30 días de duración
    ?>
</head>

<body>
    <h1><?php echo $texto ?></h1>
</body>

</html>