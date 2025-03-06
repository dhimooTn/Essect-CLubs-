<?php
/**
 * RequestModel Class
 * 
 * This class handles all database operations related to membership requests.
 * It provides methods for creating, reading, updating, and deleting request records.
 */

require_once '../app/core/DB.php'; // Include the database connection class

class RequestModel
{
    /**
     * @var Db $db The database connection object.
     */
    private $db;

    /**
     * Constructor
     * 
     * Initializes the RequestModel class and establishes a database connection.
     */
    public function __construct()
    {
        $this->db = (new Db())->connect(); // Establish a database connection
    }

    /**
     * Get All Requests
     * 
     * Fetches all membership requests from the database.
     * 
     * @return array An array of request records.
     */
    public function getAllRequests()
    {
        $query = "SELECT * FROM requests";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get Request by ID
     * 
     * Fetches a single request by its ID.
     * 
     * @param int $id The ID of the request.
     * @return array|null The request record, or null if not found.
     */
    public function getRequestById($id)
    {
        $query = "SELECT * FROM requests WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Get Requests by Club ID
     * 
     * Fetches all requests associated with a specific club.
     * 
     * @param int $clubId The ID of the club.
     * @return array An array of request records.
     */
    public function getRequestsByClubId($clubId)
    {
        $query = "SELECT * FROM requests WHERE club_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $clubId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Create a New Request
     * 
     * Inserts a new membership request into the database.
     * 
     * @param array $requestData An associative array containing request data.
     * @return bool True if the request was created successfully, false otherwise.
     */
    public function createRequest($requestData)
    {
        $query = "INSERT INTO requests (
            first_name, last_name, email, phone, facebook_url, niveau, specialite, 
            club_experience, previous_club, department, motivation, interview_availability, 
            cv_path, photo_path, club_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "ssssssssisssssi",
            $requestData['first_name'],
            $requestData['last_name'],
            $requestData['email'],
            $requestData['phone'],
            $requestData['facebook_url'],
            $requestData['niveau'],
            $requestData['specialite'],
            $requestData['club_experience'],
            $requestData['previous_club'],
            $requestData['department'],
            $requestData['motivation'],
            $requestData['interview_availability'],
            $requestData['cv_path'],
            $requestData['photo_path'],
            $requestData['club_id']
        );
        return $stmt->execute();
    }

    /**
     * Update a Request
     * 
     * Updates an existing membership request in the database.
     * 
     * @param int $id The ID of the request to update.
     * @param array $requestData An associative array containing updated request data.
     * @return bool True if the request was updated successfully, false otherwise.
     */
    public function updateRequest($id, $requestData)
    {
        $query = "UPDATE requests SET 
            first_name = ?, last_name = ?, email = ?, phone = ?, facebook_url = ?, 
            niveau = ?, specialite = ?, club_experience = ?, previous_club = ?, 
            department = ?, motivation = ?, interview_availability = ?, 
            cv_path = ?, photo_path = ?, club_id = ? 
            WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "ssssssssisssssii",
            $requestData['first_name'],
            $requestData['last_name'],
            $requestData['email'],
            $requestData['phone'],
            $requestData['facebook_url'],
            $requestData['niveau'],
            $requestData['specialite'],
            $requestData['club_experience'],
            $requestData['previous_club'],
            $requestData['department'],
            $requestData['motivation'],
            $requestData['interview_availability'],
            $requestData['cv_path'],
            $requestData['photo_path'],
            $requestData['club_id'],
            $id
        );
        return $stmt->execute();
    }

    /**
     * Delete a Request
     * 
     * Deletes a membership request from the database by its ID.
     * 
     * @param int $id The ID of the request to delete.
     * @return bool True if the request was deleted successfully, false otherwise.
     */
    public function deleteRequest($id)
    {
        $query = "DELETE FROM requests WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Get Requests by Department
     * 
     * Fetches all requests for a specific department.
     * 
     * @param string $department The department to filter by (e.g., 'comm', 'design', 'event').
     * @return array An array of request records.
     */
    public function getRequestsByDepartment($department)
    {
        $query = "SELECT * FROM requests WHERE department = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $department);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get Requests by Interview Availability
     * 
     * Fetches all requests with a specific interview availability.
     * 
     * @param string $availability The interview availability (e.g., 'Lundi', 'Mardi').
     * @return array An array of request records.
     */
    public function getRequestsByInterviewAvailability($availability)
    {
        $query = "SELECT * FROM requests WHERE interview_availability = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $availability);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>