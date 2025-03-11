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
        // Requête SQL corrigée
        $query = "SELECT id, name FROM clubs ORDER BY id ASC"; // Trier par ID en ordre croissant
    
        // Préparation de la requête
        $stmt = $this->db->prepare($query);
    
        // Vérification de la préparation de la requête
        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }
    
        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête : " . $stmt->error);
        }
    
        // Récupération des résultats
        $result = $stmt->get_result();
    
        // Vérification des résultats
        if (!$result) {
            throw new Exception("Erreur lors de la récupération des résultats : " . $stmt->error);
        }
    
        // Extraction des données sous forme de tableau associatif
        $clubs = $result->fetch_all(MYSQLI_ASSOC);
    
        // Fermeture du statement
        $stmt->close();
    
        // Retour des clubs
        return $clubs;
    }

    /**
     * Get a club by ID.
     */
    public function getClubById($id) {
        $query = "SELECT id, name FROM clubs WHERE id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }

        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête : " . $stmt->error);
        }

        $result = $stmt->get_result();
        $club = $result->fetch_assoc();

        // Close statement
        $stmt->close();

        return $club;
    }

    /**
     * Add a new club.
     */
    public function addClub($name) {
        // Check if name is empty
        if (empty($name)) {
            throw new Exception("Le nom du club ne peut pas être vide.");
        }
    
        // Check if the club already exists
        $query = "SELECT COUNT(*) FROM clubs WHERE name = ?";
        $stmt = $this->db->prepare($query);
    
        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête de vérification : " . $this->db->error);
        }
    
        $stmt->bind_param("s", $name);
    
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête de vérification : " . $stmt->error);
        }
    
        $stmt->bind_result($count);
        $stmt->fetch();
    
        // If the club already exists, throw an error
        if ($count > 0) {
            $stmt->close();
            throw new Exception("Un club avec ce nom existe déjà.");
        }
    
        // Proceed with the insert if the club doesn't exist
        $stmt->close();
        $query = "INSERT INTO clubs (name) VALUES (?)";
        $stmt = $this->db->prepare($query);
    
        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête d'ajout : " . $this->db->error);
        }
    
        $stmt->bind_param("s", $name);
    
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête d'ajout : " . $stmt->error);
        }
    
        // Close statement
        $stmt->close();
    
        return true;
    }
    

    /**
     * Update a club.
     */
    public function updateClub($id, $name) {
        $query = "UPDATE clubs SET name = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }

        $stmt->bind_param("si", $name, $id);

        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête : " . $stmt->error);
        }

        // Close statement
        $stmt->close();

        return true;
    }

    /**
     * Delete a club.
     */
    public function deleteClub($id) {
        $query = "DELETE FROM clubs WHERE id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }

        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête : " . $stmt->error);
        }

        // Close statement
        $stmt->close();

        return true;
    }

    /**
     * Close the database connection when the object is destroyed.
     */
    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}
?>