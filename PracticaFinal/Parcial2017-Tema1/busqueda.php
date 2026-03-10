<?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "****";
    $dbname = "sanatorios_x";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $resultado = "";
    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["busqueda"])) {
            $stmt = $conn -> prepare("SELECT * FROM medicos_s WHERE nombreApellido LIKE ? LIMIT 1;");
            $busqueda = "%" . $_POST["busqueda"] . "%";
        
            $stmt -> bind_param('s',$busqueda);
            $stmt -> execute();
            
            $query = $stmt -> get_result();
            
            if ($query->num_rows > 0) {
                $_SESSION['medico'] = $query->fetch_assoc();
                header("Location: /Entornos-Graficos---Electiva-2024/PracticaFinal/Parcial2017-Tema1/edit.php");
                exit();
            } else {
                throw new Exception("No se encontraron resultados");
            }
        }
    }catch(Exception $e){
        throw new Exception($e);
    };

?>