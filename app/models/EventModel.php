<?php
/**
 * EventModel Class
 * 
 * This class handles all database operations related to events.
 * It provides methods for creating, reading, updating, and deleting event records.
 */

require_once '../app/core/DB.php'; // Include the database connection class

class EventModel
{
    /**
     * @var Db $db The database connection object.
     */
    private $db;

    /**
     * Constructor
     * 
     * Initializes the EventModel class and establishes a database connection.
     */
    public function __construct()
    {
        $this->db = (new Db())->connect(); // Establish a database connection
    }

    /**
     * Get All Events
     * 
     * Fetches all events from the database.
     * 
     * @return array An array of event records.
     */
    public function getAllEvents()
    {
        $query = "SELECT * FROM events";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get Event by ID
     * 
     * Fetches a single event by its ID.
     * 
     * @param int $id The ID of the event.
     * @return array|null The event record, or null if not found.
     */
    public function getEventById($id)
    {
        $query = "SELECT * FROM events WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Get Events by Club ID
     * 
     * Fetches all events associated with a specific club.
     * 
     * @param int $clubId The ID of the club.
     * @return array An array of event records.
     */
    public function getEventsByClubId($clubId)
    {
        $query = "SELECT * FROM events WHERE club_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $clubId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Create a New Event
     * 
     * Inserts a new event into the database.
     * 
     * @param array $eventData An associative array containing event data.
     * @return bool True if the event was created successfully, false otherwise.
     */
    public function createEvent($eventData)
    {
        $query = "INSERT INTO events (title, description, date, location, photo_path, club_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "sssssi",
            $eventData['title'],
            $eventData['description'],
            $eventData['date'],
            $eventData['location'],
            $eventData['photo_path'],
            $eventData['club_id']
        );
        return $stmt->execute();
    }

    /**
     * Update an Event
     * 
     * Updates an existing event in the database.
     * 
     * @param int $id The ID of the event to update.
     * @param array $eventData An associative array containing updated event data.
     * @return bool True if the event was updated successfully, false otherwise.
     */
    public function updateEvent($id, $eventData)
    {
        $query = "UPDATE events SET title = ?, description = ?, date = ?, location = ?, photo_path = ?, club_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "sssssii",
            $eventData['title'],
            $eventData['description'],
            $eventData['date'],
            $eventData['location'],
            $eventData['photo_path'],
            $eventData['club_id'],
            $id
        );
        return $stmt->execute();
    }

    /**
     * Delete an Event
     * 
     * Deletes an event from the database by its ID.
     * 
     * @param int $id The ID of the event to delete.
     * @return bool True if the event was deleted successfully, false otherwise.
     */
    public function deleteEvent($id)
    {
        $query = "DELETE FROM events WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Get Upcoming Events
     * 
     * Fetches all events that are scheduled to occur in the future.
     * 
     * @return array An array of upcoming event records.
     */
    public function getUpcomingEvents()
    {
        $query = "SELECT * FROM events WHERE date > NOW() ORDER BY date ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get Past Events
     * 
     * Fetches all events that have already occurred.
     * 
     * @return array An array of past event records.
     */
    public function getPastEvents()
    {
        $query = "SELECT * FROM events WHERE date <= NOW() ORDER BY date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}