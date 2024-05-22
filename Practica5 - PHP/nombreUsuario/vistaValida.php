<!-- Página que va a contener a solicitar el nombre de usuario -->
<html>

<head></head>

<body>
    <?php include("funcionValida.php") ?>
    <?php if (!isset($_POST['submit'])) { ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Nombre Usuario: <input name="usuario" size="2">
    <input type="submit" name="submit" value="Ir">
    </form>
    <?php }
    else {
        // Llamar a la función para validar el nombre de usuario -solo si lleno el formulario-
        if (isset($_POST['usuario'])) {
            $resultado = comprobar_nombre_usuario($_POST['usuario']); } }
?>
</body>

</html>