<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["name"];
    $email = $_POST["email"];
    $producto = $_POST["producto"];
    $mes = $_POST["mes"];
    $cantidad = $_POST["cantidad"];
    $tyc = $_POST["tyc"];
    $pago = $_POST["pago"];
    $fecha = date('Y-m-d H:i:s');

    if(isset($_SESSION["formularios"])) {
        $lista = $_SESSION["formularios"];
        $lista[] = [$nombre, $email, $producto, $mes, $cantidad, $tyc, $pago, $fecha];
        $_SESSION["formularios"] = $lista;
        //IGUAL A PONER 
       // $_SESSION["formularios"][] = [$nombre, $email, $producto, $mes, $cantidad, $tyc, $pago, $fecha];
    } else {
        $lista = [];
        $lista[] = [$nombre, $email, $producto, $mes, $cantidad, $tyc, $pago, $fecha];
        $_SESSION["formularios"] = $lista;
    }

  try {

    $conn = mysqli_connect(hostname, username, password, database);

    $stmt = $conn->prepare("INSERT INTO pedidos (nombre, email, producto, mes, cantidad, tyc, pago, fecha) VALUES (?, ?, ?, ?, ?, ?, ?, ')");

    $stmt->bind_param("sssiisss", $nombre, $email, $producto, $mes, $cantidad, $tyc, $pago, $fecha );
    $stmt->execute();

    echo("Realizado correctamente"); }
    
    catch (Exception $e) {
        echo($e);
    } finally {
        if (isset($stmt) && $stmt !== false) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        } }

}
?>