<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Recomendar a un amigo</title>
</head>

<body>
    <div class="container">
        <h2 class="p3 mt-5  text-center">¡Recomendar a un amigo!</h2>
        <form action="enviar.php" method="post">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Tu nombre</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Juan">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Tu apellido</label>
                        <input type="text" name="apellido" class="form-control" id="apellido" placeholder="Perez">
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de Tu amigo</label>
                        <input type="text" name="nombre_amigo" class="form-control" id="nombre_amigo" placeholder="Juan">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Apellido de tu amigo</label>
                        <input type="text" name="apellido_amigo" class="form-control" id="nombre_amigo" placeholder="Juan">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Direccion de Correo Electronico de Tu amigo</label>
                <input type="email" name="correo" class="form-control" id="correo" placeholder="juanperez@example.com">
            </div>
            <button type="submit" class="btn btn-primary ">ENVIAR RECOMENDACION</button>

        </form>
    </div>





    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>