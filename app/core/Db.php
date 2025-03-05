<?php 
require_once 'app/config/config.php';
class Db 
{
    protected $db;

    public function connect()
    {
        $this->db = new Mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if(!$this->db)
            die("Connection Error : ");
        return $this->db;
    }


}