<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurable Styles Page</title>
    <?php
    // Verificar si existe la cookie de estilo
    if (isset($_COOKIE['preferredStyle'])) {
        $style = $_COOKIE['preferredStyle'];
    } else {
        $style = 'default'; // Estilo por defecto
    }
    ?>
    <link id="themeStylesheet" rel="stylesheet" href="<?php echo $style; ?>.css">
</head>

<body>
    <h1>Bienvenidos</h1>
    <form id="styleForm" action="" method="post">
        <label for="styleSelect">Elegi el estilo:</label>
        <select id="styleSelect" name="style">
            <option value="default" <?php echo $style == 'default' ? 'selected' : ''; ?>>Default</option>
            <option value="dark" <?php echo $style == 'dark' ? 'selected' : ''; ?>>Dark</option>
            <option value="light" <?php echo $style == 'light' ? 'selected' : ''; ?>>Light</option>
        </select>
        <button type="submit">Aplicar estilo</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedStyle = $_POST['style'];
        setcookie('preferredStyle', $selectedStyle, time() + (86400 * 30), "/");
        echo "<script>window.location.href=window.location.href;</script>";
    }
    ?>
</body>

</html>