<?php

require_once '../app/core/Db.php'; // Connexion à la base

class ClubModel {
    private $db;

    public function __construct() {
        $this->db = new Db(); // Connexion DB
    }
}
?>