<?php
/**
 * UserModel Class
 * 
 * This class handles all database operations related to users.
 * It provides methods for creating, reading, updating, and deleting user records.
 */

require_once '../app/core/DB.php'; // Include the database connection class

class UserModel
{
    /**
     * @var Db $db The database connection object.
     */
    private $db;

    /**
     * Constructor
     * 
     * Initializes the UserModel class and establishes a database connection.
     */
    public function __construct()
    {
        $this->db = (new Db())->connect(); // Establish a database connection
    }

    /**
     * Get All Users
     * 
     * Fetches all users from the database.
     * 
     * @return array An array of user records.
     */
    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get User by ID
     * 
     * Fetches a single user by their ID.
     * 
     * @param int $id The ID of the user.
     * @return array|null The user record, or null if not found.
     */
    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Get User by Email
     * 
     * Fetches a single user by their email address.
     * 
     * @param string $email The email address of the user.
     * @return array|null The user record, or null if not found.
     */
    public function getUserByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Create a New User
     * 
     * Inserts a new user into the database.
     * 
     * @param array $userData An associative array containing user data.
     * @return bool True if the user was created successfully, false otherwise.
     */
    public function createUser($userData)
    {
        $query = "INSERT INTO users (first_name, last_name, email, phone, photo_path, niveau, specialite, department, club_id, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "ssssssssis",
            $userData['first_name'],
            $userData['last_name'],
            $userData['email'],
            $userData['phone'],
            $userData['photo_path'],
            $userData['niveau'],
            $userData['specialite'],
            $userData['department'],
            $userData['club_id'],
            $userData['role']
        );
        return $stmt->execute();
    }

    /**
     * Update a User
     * 
     * Updates an existing user in the database.
     * 
     * @param int $id The ID of the user to update.
     * @param array $userData An associative array containing updated user data.
     * @return bool True if the user was updated successfully, false otherwise.
     */
    public function updateUser($id, $userData)
    {
        $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, photo_path = ?, niveau = ?, specialite = ?, department = ?, club_id = ?, role = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "ssssssssisi",
            $userData['first_name'],
            $userData['last_name'],
            $userData['email'],
            $userData['phone'],
            $userData['photo_path'],
            $userData['niveau'],
            $userData['specialite'],
            $userData['department'],
            $userData['club_id'],
            $userData['role'],
            $id
        );
        return $stmt->execute();
    }

    /**
     * Delete a User
     * 
     * Deletes a user from the database by their ID.
     * 
     * @param int $id The ID of the user to delete.
     * @return bool True if the user was deleted successfully, false otherwise.
     */
    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Get Users by Club ID
     * 
     * Fetches all users belonging to a specific club.
     * 
     * @param int $clubId The ID of the club.
     * @return array An array of user records.
     */
    public function getUsersByClubId($clubId)
    {
        $query = "SELECT * FROM users WHERE club_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $clubId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get Users by Role
     * 
     * Fetches all users with a specific role.
     * 
     * @param string $role The role of the users (e.g., 'member', 'president', 'admin').
     * @return array An array of user records.
     */
    public function getUsersByRole($role)
    {
        $query = "SELECT * FROM users WHERE role = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $role);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getUsersByClub($cid)
    {
        $query = "SELECT * FROM users WHERE club_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $cid);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>