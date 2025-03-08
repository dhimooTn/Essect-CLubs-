<?php
require_once 'app\config\config.php';

class Db
{
    protected $db;

    public function connect()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $this->db->set_charset("utf8mb4");
            return $this->db;
        } catch (mysqli_sql_exception $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}
?>