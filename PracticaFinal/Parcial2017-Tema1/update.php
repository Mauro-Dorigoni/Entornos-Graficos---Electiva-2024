<?php
    $servername = "localhost";
    $username = "root";
    $password = "****";
    $dbname = "sanatorios_x";


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $stmt = $conn -> prepare("UPDATE MEDICOS_S SET diasConsulta = ? where matricula = ?");
        $dias = $_POST['diasConsulta'];
        $id = $_POST['matricula'];

        $stmt -> bind_param('ss',$dias,$id);
        $stmt -> execute();

        unset($_SESSION['medico']);
        echo "Actualizado correctamente.";
        exit();
    }
?>