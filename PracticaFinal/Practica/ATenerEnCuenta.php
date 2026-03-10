<?php
    if(!isset($_SESSION)){
        session_start();
    }

    try{
        //busco recibir los campos de un form y validar que esten completos
        $campos = ['nombre','email','nombreProd','mes','cantidad','acepto'];
        foreach($campos as $campo){
            if(!isset($_POST[$campo])||trim($_POST[$campo])===""){
                throw new Exception("Error");
            }
        }

        //validaciones
        if(!is_int($cantidad)){

        };

        if(!is_string($nombre)){

        };

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){

        };

        if($mes <1 || $mes > 12){

        };
        //busco conectarme a la base de datos y preparar el statement
        $conn = new mysqli('hostname','username','pass','dbname');
        $stmt = $conn->prepare('INSERT INTO TABLA(nombre,email,nombreProd,mes,cantidad,acepto,fechaHora) values (?,?,?,?,?,?,?,?)');

        //valido que sea un metodo post. 
        //condicion de validacion $_SERVER['REQUEST_METHOD'] == 'POST'
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //ahora tengo que preparar los bind params para luego ejecutar la query

            $nombre = $_POST['nombre'];            
            $email = $_POST['email'];
            $nombreProd = $_POST['nombreProd'];
            $mes = $_POST['mes'];
            $cantidad = $_POST['cantidad'];
            $acepto = $_POST['acepto'];
            $fechaHora = date('d M Y H:i:s');

            $stmt -> bind_param("sssiis",$nombre,$email,$nombreProd,$mes,$cantidad,$acepto,$fechaHora);
            $stmt -> execute();
        }

        //quiero guardar una session con los datos envidos
        $_SESSION['registro'][$fechaHora] = [
            'nombre' => $nombre,
            'email' => $email
            // asi susesivamente
        ];

    }catch(Exception $e){
        throw new Exception("Error ". $e -> getMessage());
    }
    

?>