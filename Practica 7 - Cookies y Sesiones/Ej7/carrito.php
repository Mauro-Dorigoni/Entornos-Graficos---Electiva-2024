<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Su carrito</title>
</head>
<body>
        <table>
        <tr>
            <td>Producto</td>
            <td>Cantidad</td>
        </tr>
        <?php
        session_start();
        foreach ($_SESSION['carro'] as $producto) {
            echo "<tr>";
            echo "<td>{$producto['nombre']}</td>";
            echo "<td>{$producto['cantidad']}</td>";
            echo "</td>"
        ;
        echo "</ul>";

    };
    echo "<a href="."catalogo.php"."><button>Volver al catalogo</button></a>";
    ?>
</body>
</html>