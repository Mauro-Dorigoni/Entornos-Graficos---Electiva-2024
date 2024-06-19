<?php
class Model {
    protected $table;
    protected $conexion;

    public function __construct() {
        $database = new Database();
        $this->conexion = $database->connect();
    }

    public function findOne($id) {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function findAll() {
        $sql = "SELECT * FROM $this->table";
        $result = $this->conexion->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function save($data) {
        if (isset($data['id'])) {
            // Actualizamos existentes
            $fields = array_map(function($field) {
                return "$field = ?";
            }, array_keys($data));
            $fields = implode(", ", $fields);

            $sql = "UPDATE $this->table SET $fields WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);

            $types = str_repeat('s', count($data)) . 'i';
            $stmt->bind_param($types, ...array_values($data), $data['id']);
        } else {
            // Incorporamos uno nuevo
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), '?'));

            $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
            $stmt = $this->conexion->prepare($sql);

            $types = str_repeat('s', count($data));
            $stmt->bind_param($types, ...array_values($data));
        }

        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function addOne($data) {
           $columns = implode(", ", array_keys($data));
           $placeholders = implode(", ", array_fill(0, count($data), '?'));

           $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
           $stmt = $this->conexion->prepare($sql);

           $types = str_repeat('s', count($data));
           $stmt->bind_param($types, ...array_values($data));
    }

    public function deleteOne($id) {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
?>