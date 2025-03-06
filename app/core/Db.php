<?php
/**
 * Db Class
 * 
 * This class is responsible for establishing a connection to the MySQL database
 * using the configuration settings defined in the config file.
 */

require_once 'app/config/config.php'; // Include the configuration file

class Db
{
    /**
     * @var Mysqli $db The MySQLi database connection object.
     */
    protected $db;

    /**
     * Connect to the Database
     * 
     * Establishes a connection to the MySQL database using the credentials
     * defined in the configuration file.
     * 
     * @return Mysqli Returns the MySQLi database connection object.
     * @throws Exception If the connection to the database fails.
     */
    public function connect()
    {
        // Create a new MySQLi connection using the constants from the config file
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Check if the connection was successful
        if (!$this->db) {
            // If the connection fails, terminate the script with an error message
            die("Connection Error: " . $this->db->connect_error);
        }

        // Return the database connection object
        return $this->db;
    }
    public function prepare($query) {
        return $this->db->prepare($query);
    }
}
?>