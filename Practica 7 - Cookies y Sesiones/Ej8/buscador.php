<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  session_start();
  $link = mysqli_connect("localhost", "root","") or die ("Problemas de conexión a la base de datos");
  mysqli_select_db($link, "prueba");
  $cancion = $_POST['cancion'];
  $vSql = "SELECT * FROM buscador where cancion LIKE '%" . $cancion . "%'";
  $vResultado = mysqli_query($link, $vSql);
  $total_registros = mysqli_num_rows($vResultado);
  if ($total_registros > 0) {
    while ($fila=mysqli_fetch_array($vResultado)) {
        $canciones= $fila['cancion'];
        setcookie('canciones', $canciones, time()+ 3600*24*365);
    }
  }else{
    setcookie('canciones', null, time() + 3600 * 24 * 365);
  }
  header("Location: index.php");
  ?>


</body>

</html>