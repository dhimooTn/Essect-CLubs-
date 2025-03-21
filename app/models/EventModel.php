<?php
require_once CONFIG . 'config.php';
require_once CORE . 'Db.php';

class EventModel extends Db
{
    // Add a new event
    public function addEvent($title, $description, $date, $location, $club_id)
    {
        $sql = "INSERT INTO events (title, description, date, location, club_id) 
                VALUES (:title, :description, :date, :location, :club_id)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':date' => $date,
            ':location' => $location,
            ':club_id' => $club_id
        ]);
        return $this->connect()->lastInsertId();
    }

    // Fetch all events for a specific club
    public function getEvents($club_id)
    {
        $sql = "SELECT * FROM events WHERE club_id = :club_id ORDER BY date DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':club_id' => $club_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete an event by ID
    public function deleteEvent($event_id)
    {
        $sql = "DELETE FROM events WHERE id = :event_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([':event_id' => $event_id]);
        return $stmt->rowCount(); // Returns the number of rows affected
    }
}
?>