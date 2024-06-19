<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Periodico</title>
</head>

<body>
    <h1>Bienvenidos</h1>
    <form action="" method="post">
        <input name="pagina" id="deporte" value="deporte" type="radio" <?php if (isset($_COOKIE["pagina"]) && $_COOKIE["pagina"] == 'deporte') echo 'checked' ?>>
        <label for="deporte">Deporte</label>
        <input name="pagina" id="politica" value="politica" type="radio" <?php if (isset($_COOKIE["pagina"]) && $_COOKIE["pagina"] == 'politica') echo 'checked' ?>>
        <label for="politica">Politica</label>
        <input name="pagina" id="economia" value="economia" type="radio" <?php if (isset($_COOKIE["pagina"]) && $_COOKIE["pagina"] == 'economia') echo 'checked' ?>>
        <label for="economia">Economia</label>
        <button type="submit">Aplicar</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pagina'])) {
        $paginaSeleccionada = $_POST['pagina'];
        setcookie('pagina', $paginaSeleccionada, time() + (86400 * 30), "/");
        echo "<script>window.location.href=window.location.href;</script>";
    }

    if (isset($_COOKIE['pagina'])) {
        $paginaSeleccionada = $_COOKIE['pagina'];
        echo "<h2>Noticia seleccionada: ";
        if ($paginaSeleccionada == 'politica') {
            echo "Últimas noticias de política";
        } elseif ($paginaSeleccionada == 'economia') {
            echo "Últimas noticias económicas";
        } elseif ($paginaSeleccionada == 'deporte') {
            echo "Últimas noticias deportivas";
        }
        echo "</h2>";
    } else {
        echo "<h2>Últimas noticias de política, economía y deportes</h2>";
    }
    ?>

    <a href="borrar-cookie.php">Borrar</a>
</body>

</html>