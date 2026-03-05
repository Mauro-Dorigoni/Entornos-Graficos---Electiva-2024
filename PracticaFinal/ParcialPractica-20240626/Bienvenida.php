<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bienvenido</h1>
    <a href="#">Anda pa alla bobo</a>

    <div class="col-6">
        <form action="post.php" method="post">
            Nombre: <input type="text" name="nombre" id="nombre" required><br>
            Email: <input type="text" name="email" id="email" required><br>
            Nombre del producto: <input type="text" name="nombreProducto" id="nombreProducto" required><br>
            Mes: <select name="mes" id="mes" required>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select><br>
            <br>
            <legend></legend>
            Cantidad: <input type="number" name="cantidad" id="cantidad" required><br>
            <input type="checkbox" name="terminos" id="terminos" required> Acepto los términos y condiciones</input><br>
            <input type="submit" value="Enviar">
        </form>
    </div>
    
</body>
</html>