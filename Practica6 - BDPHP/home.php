<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>CRUD - Ciudades</title>
</head>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CRUD Ciudades</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Alta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Baja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Modificacion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Eliminar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<body>
    <div class="contenier">
        <div class="conteiner m-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">CP</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Pais</th>
                    <th scope="col">Habitantes</th>
                    <th scope="col">Superficie</th>
                    <th scope="col">Tiene Metro</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                $con = mysqli_connect('localhost','root','');
                $status = mysqli_select_db($con,'capitales');
                $result = mysqli_query($con, "SELECT * FROM ciudades");
                $datos= mysqli_fetch_array($result);
                foreach ($datos as $d){
                echo "<tr>";
                    //$id = strval($d['id']);
                    //echo "<th scope=\"row\">".$id."</th>";
                    echo "<td>".$d['ciudad']."</td>";
                    echo "<td>".$d['pais']."</td>";
                    echo "<td>".strval($d['habitantes'])."</td>";
                    echo "<td>".strval($d['superficie'])."</td>";
                    echo "<td>".strval($d['metro'])."</td>";
                echo "</tr>";
                }
                mysqli_close($con);
                ?>
            </tbody>
        </table>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>
