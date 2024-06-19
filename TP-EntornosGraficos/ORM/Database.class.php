
<?php 

class Database {

    private $host = 'localhost';
    private $usuario = 'root';
    private $contrasena = '';
    private $db_name = 'capitales';
    private $conection;

  /*  public __constructor($h, $u, $p, $dbn) {
        $this->$host = 'localhost';
        $this->$usuario = 'root';
        $this->$contrasena = '';
        $this->$db_name = 'entornos';
    } */


    public function connect() {
        $this->conection = new mysqli($this->host, $this->usuario, $this->contrasena, $this->db_name);
        if ($this->conection->connect_error) {
            die("Error de conexión: " . $this->conection->connect_error);
        }
        return $this->conection;
    }


}

?>