<?php
    if(!isset($_SESSION)){
        session_start();
    }
    extract($_POST);
    try{
        if ($_REQUEST === 'POST'){
            $conn = new mysqli('host','username','password','dbname');
            //puedo meter una validacion
            if($conn -> connect_error){
                throw new Exception('Error');
            }
            $stmt = $conn -> prepare('INSERT INTO TABLA (nombre,email,nombreProd,mes,cantidad,acepto,fehcaHora) VALUES (?,?,?,?,?,?,?,?)');
            
            $nombre -> $_POST['nombre'];
            $email -> $_POST['email'];
            $nombreProd -> $_POST['nombreProd'];
            $mes -> $_POST['mes'];
            $cantidad -> $_POST['cantidad'];
            $acpeto -> $_POST['acepto'];
            $fechaHora -> date('Y-m-d H:i:s');
            
            $stmt -> bind_param($nombre, $email, $nombreProd, $mes, $cantidad, $acepto,$fechaHora);
            $stmt -> execute();
        }

        $_SESSION["registro"][$fechaHora] = [
            "nombre" => $nombre,
            "email" => $email,
            "nombreProd" => $nombreProd,
            "mes" => $mes,
            "cantidad" => $cantidad,
            "acepto" => $acepto,
            "fechaHora" => $fechaHora,
        ];
        
    } catch (Exception $e){
        throw new Exception("Error Processing Request", $e->getMessage());
        
    }

?>