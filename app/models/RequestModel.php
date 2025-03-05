<?php

require_once '../app/core/DB.php'; // Connexion à la base

class RequestModel {
    private $db;

    public function __construct() {
        $this->db = new Db(); // Connexion DB
    }
}
?>