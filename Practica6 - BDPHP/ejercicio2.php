<?php
//Concectamos con la BBDD
$con = mysqli_connect('localhost','root','');
//Seleccionamos la base
$status = mysqli_select_db($con,'capitales');

if ($status){
    echo "Concetado Exitosamente";

} else {
   echo "Error al conectar. Intente otra vez.";
}


$result = mysqli_query($con, "SELECT * FROM ciudades")
$result = mysqli_query($con, "SELECT * FROM ciudades WHERE id =")