<?php
    session_start();
    $resultado = $_SESSION['medico'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="update.php" method="POST">
        <input type="text" name="matricula" value="<?= $resultado['matricula']?>">
        <input type="text" name="nombreApellido" value="<?= $resultado['nombreApellido']?>">
        <input type="text" name="especialidad" value="<?= $resultado['especialidad']?>">
        <input type="text" name="diasConsulta" value="<?= $resultado['diasConsulta']?>">
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>

