<?php

class Orm {
    protected $id;
    protected $table;
    protected $db;

    public function __construct($id, $table, $concection){
        $this->id = $id;
        $this->table = $table;
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->stmt_init();
        $stmt->prepare("SELECT * FROM ?");
        $stmt->bind_param("s",$this->table);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $stmt->bind_result(/*nombre de las variables*/ );
        /* fetch value */
        $stmt->fetch();
    }

    public function getById($id) {}

    public function deleteById($id) {}

    public function updateById($id, $data) {}

    public function insert($data) {}
}
