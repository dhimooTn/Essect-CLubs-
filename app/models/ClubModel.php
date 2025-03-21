<?php
require_once CORE . 'Db.php';

class ClubModel {
    private $db;

    public function __construct() {
        $dbInstance = new Db();
        $this->db = $dbInstance->connect();
    }

    /**
     * Get all clubs.
     */
    public function getAllClubs() {
        $query = "SELECT id, name FROM clubs ORDER BY id ASC"; // Sort by ID in ascending order
    
        // Prepare the query
        $stmt = $this->db->prepare($query);
    
        // Execute the query
        if (!$stmt->execute()) {
            throw new Exception("Error executing the query: " . $stmt->errorInfo()[2]);
        }
    
        // Fetch the results
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
    
        if (!$result) {
            throw new Exception("Error fetching the results: " . implode(", ", $stmt->errorInfo()));
        }
    
        return $result; // Return the clubs
    }

    /**
     * Get a club by ID.
     */
    public function getClubById($id) {
        $query = "SELECT id, name FROM clubs WHERE id = ?";
        $stmt = $this->db->prepare($query);
        
        if (!$stmt->execute([$id])) {
            throw new Exception("Error executing the query: " . implode(", ", $stmt->errorInfo()));
        }

        $club = $stmt->fetch(PDO::FETCH_ASSOC);

        return $club;
    }

    /**
     * Add a new club.
     */
    public function addClub($name) {
        if (empty($name)) {
            throw new Exception("The club name cannot be empty.");
        }

        // Check if the club already exists
        $query = "SELECT COUNT(*) FROM clubs WHERE name = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt->execute([$name])) {
            throw new Exception("Error executing the check query: " . implode(", ", $stmt->errorInfo()));
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result['COUNT(*)'] > 0) {
            throw new Exception("A club with this name already exists.");
        }

        // Add the new club
        $query = "INSERT INTO clubs (name) VALUES (?)";
        $stmt = $this->db->prepare($query);
        
        if (!$stmt->execute([$name])) {
            throw new Exception("Error executing the add query: " . implode(", ", $stmt->errorInfo()));
        }

        return true;
    }

    /**
     * Update a club.
     */
    public function updateClub($id, $name) {
        if (empty($name)) {
            throw new Exception("The club name cannot be empty.");
        }

        $query = "UPDATE clubs SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        
        if (!$stmt->execute([$name, $id])) {
            throw new Exception("Error executing the update query: " . implode(", ", $stmt->errorInfo()));
        }

        return true;
    }

    /**
     * Delete a club.
     */
    public function deleteClub($id) {
        $query = "DELETE FROM clubs WHERE id = ?";
        $stmt = $this->db->prepare($query);
        
        if (!$stmt->execute([$id])) {
            throw new Exception("Error executing the delete query: " . implode(", ", $stmt->errorInfo()));
        }

        return true;
    }

    /**
     * Get the club ID associated with a user ID.
     */
    public function getClubIdByUserId($userId) {
        $sql = "SELECT club_id FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt->execute([$userId])) {
            throw new Exception("Error executing the query: " . implode(", ", $stmt->errorInfo()));
        }

        $clubId = $stmt->fetch(PDO::FETCH_ASSOC);

        return $clubId ? $clubId : null;
    }

    /**
     * Close the database connection when the object is destroyed.
     */
    public function __destruct() {
        $this->db = null;
    }
}
?>
