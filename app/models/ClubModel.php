<?php
/**
 * ClubModel Class
 * 
 * This class handles all database operations related to clubs.
 * It provides methods for creating, reading, updating, and deleting club records.
 */

require_once '../app/core/Db.php'; // Include the database connection class

class ClubModel
{
    /**
     * @var Db $db The database connection object.
     */
    private $db;

    /**
     * Constructor
     * 
     * Initializes the ClubModel class and establishes a database connection.
     */
    public function __construct()
    {
        $this->db = (new Db())->connect(); // Establish a database connection
    }

    /**
     * Get All Clubs
     * 
     * Fetches all clubs from the database.
     * 
     * @return array An array of club records.
     */
    public function getAllClubs()
    {
        $query = "SELECT * FROM clubs";
        $stmt = $this->db->prepare($query);

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get Club by ID
     * 
     * Fetches a single club by its ID.
     * 
     * @param int $id The ID of the club.
     * @return array|null The club record, or null if not found.
     */
    public function getClubById($id)
    {
        $query = "SELECT * FROM clubs WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getClubByName($name)
    {
        $query = "SELECT * FROM clubs WHERE name = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Create a New Club
     * 
     * Inserts a new club into the database.
     * 
     * @param string $name The name of the club.
     * @param string $description The description of the club.
     * @return bool True if the club was created successfully, false otherwise.
     */
    public function createClub($name, $description)
    {
        $query = "INSERT INTO clubs (name, description) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $name, $description);
        return $stmt->execute();
    }

    /**
     * Update a Club
     * 
     * Updates an existing club in the database.
     * 
     * @param int $id The ID of the club to update.
     * @param string $name The new name of the club.
     * @param string $description The new description of the club.
     * @return bool True if the club was updated successfully, false otherwise.
     */
    public function updateClub($id, $name, $description)
    {
        $query = "UPDATE clubs SET name = ?, description = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssi", $name, $description, $id);
        return $stmt->execute();
    }

    /**
     * Delete a Club
     * 
     * Deletes a club from the database by its ID.
     * 
     * @param int $id The ID of the club to delete.
     * @return bool True if the club was deleted successfully, false otherwise.
     */
    public function deleteClub($id)
    {
        $query = "DELETE FROM clubs WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>