<?php

require_once '../app/core/DB.php'; // Connexion à la base

class EventModel {
    private $db;

    public function __construct() {
        $this->db = new Db(); // Connexion DB
    }
}
?>