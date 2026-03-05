<?php

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    try {
        $conn = new mysqli("localhost", "root", "123456", "practica_final");
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        $campos = ["nombre", "email", "nombreProducto", "mes", "cantidad", "terminos"];
        foreach ($campos as $campo) {
            if (!isset($_POST[$campo]) || trim($_POST[$campo]) === "") {
                throw new Exception("El campo '$campo' es obligatorio.");
            }
        }

        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El email '$email' no es válido.");
        }
        
        $mes = $_POST["mes"];
        if ($mes < 1 || $mes > 12) {
            throw new Exception("El mes '$mes' no es válido.");
        }

        $nombre = $_POST["nombre"];
        $nombreProducto = $_POST["nombreProducto"];
        if (strlen($nombre) < 3 || strlen($nombreProducto) < 3) {
            throw new Exception("El nombre o el nombre del producto no pueden tener menos de tres caracteres.");
        }

        $cantidad = $_POST["cantidad"];
        if (!is_numeric($cantidad) || $cantidad <= 0) {
            throw new Exception("La cantidad '$cantidad' no es válida.");
        }

        $selectSql = "SELECT 1 FROM tabla WHERE email = ? and mes = ? and cantidad = ? LIMIT 1";
        $stmt = $conn->prepare($selectSql);
        $stmt->bind_param("sii", $email, $mes, $cantidad);
        $result = $conn->query($selectSql);
        if (!$result) {
            throw new Exception("Ya existe ese registro");
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $terminos = isset($_POST["terminos"]);
            $fechaHora = date("Y-m-d H:i:s");

            $sql = "INSERT INTO pedidos (nombre, email, nombre_producto, mes, cantidad, terminos, fecha_hora) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssiiis", $nombre, $email, $nombreProducto, $mes, $cantidad, $terminos, $fechaHora);
            $stmt->execute();
        } else {
            throw new Exception("Método de solicitud no permitido.");
        }

        $_SESSION["registroForm"][$fechaHora] = [
            "nombre" => $_POST["nombre"],
            "email" => $_POST["email"],
            "nombreProducto" => $_POST["nombreProducto"],
            "mes" => $_POST["mes"],
            "cantidad" => $_POST["cantidad"],
            "terminos" => isset($_POST["terminos"]) ? 1 : 0
        ];

        setcookie("fechaHora", $fechaHora, time() + (3600), "/");
    }catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

?>