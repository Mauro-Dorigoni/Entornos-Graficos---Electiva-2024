<?php


class Ciudad {
    public $id;
    public $ciudad;
    public $pais;
    public $habitantes;
    public $superficie;
    public $metro;

    public function __construct($i=null, $c=null, $p=null, $h=null, $s=null, $m=null){
        $this->id = $i;
        $this->ciudad = $c;
        $this->pais = $p;
        $this->habitantes = $h;
        $this->superficie = $s;
        $this->metro = $m;
    }
}


class CiudadModel {
    private $db;
    private $table = 'ciudades';

    public function __construct($con) {
        $this->db = $con;
    }

    public function getById($id) {
        $stmt = $this->db->stmt_init();
        $stmt->prepare("SELECT * FROM ciudades WHERE id =".$id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo $result;
        return $result->fetch_object('Ciudad');
    }

    public function getAll() {
        $stmt = $this->db->stmt_init();
        $stmt->prepare("SELECT * FROM ciudades");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $objects = [];
        while ($obj = $result->fetch_object('Ciudad')) {
            $objects[] = $obj;
        }
        return $objects;
    }

}



/* $conexion = mysqli_connect('localhost','root','');

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
} 
echo "Conexión exitosa"; 

$status = mysqli_select_db($conexion, 'capitales'); */

$mysqli = new mysqli('localhost', 'root', '', 'capitales');
$mysqli->set_charset('utf8mb4');
printf("Success... %s\n", $mysqli->host_info);



$ciudadModel = new CiudadModel($mysqli);
$ciudad = $ciudadModel->getById(2000);
//print_r($ciudades);
echo "ID: " . $ciudad->id . ", Nombre: " . $ciudad->ciudad . ", País: " . $ciudad->pais . "<br>";

?>
