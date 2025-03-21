<?php
// app/models/RequestModel.php

require_once CORE . 'Db.php';

class RequestModel
{
    protected $db;

    public function __construct()
    {
        $dbInstance = new Db();
        $this->db = $dbInstance->connect();
    }

    /**
     * Insère une nouvelle demande dans la table `requests`.
     *
     * @param array $data Les données de la demande
     * @return int|false L'ID de la demande insérée ou false en cas d'échec
     */
    public function insertRequest($data)
    {
        $query = "
            INSERT INTO requests (
                first_name, last_name, email, phone, facebook_url, niveau, specialite, 
                club_experience, previous_club, department, motivation, interview_availability, 
                cv_path, club_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception("Erreur de préparation : " . $this->db->error);
        }

        // Binding des paramètres avec les bons types
        if (
            !$stmt->bind_param(
                "ssssssssissssi", // 14 paramètres, correspond bien aux données
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['phone'],
                $data['facebook_url'],
                $data['niveau'],
                $data['specialite'],
                $data['club_experience'],
                $data['previous_club'],
                $data['department'],
                $data['motivation'],
                $data['interview_availability'],
                $data['cv_path'],
                $data['club_id'] // Assurez-vous que ce paramètre est bien un entier
            )
        ) {
            throw new Exception("Erreur lors du binding des paramètres : " . $stmt->error);
        }

        // Exécution de la requête
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution : " . $stmt->error);
        }

        // Récupération de l'ID de la demande insérée
        $insertId = $this->db->insert_id;
        $stmt->close();
        return $insertId;
    }

    /**
     * Récupère le nombre total de demandes en attente pour un club donné.
     *
     * @param int $clubId ID du club
     * @return int Nombre de demandes en attente
     */
    public function getPendingRequests($clubId)
    {
        $query = "SELECT COUNT(*) AS total FROM requests WHERE club_id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception("Erreur de préparation : " . $this->db->error);
        }

        $stmt->bind_param("i", $clubId); // Le clubId est un entier
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution : " . $stmt->error);
        }

        $result = $stmt->get_result();
        $total = $result->fetch_assoc()['total'];
        $stmt->close();
        return $total;
    }

    /**
     * Récupère les demandes d'adhésion à un club donné.
     *
     * @param int $clubId ID du club
     * @return array Liste des demandes
     */
    public function getClubRequests($clubId)
    {
        $query = "SELECT id, first_name, last_name, email, status FROM requests WHERE club_id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception("Erreur de préparation : " . $this->db->error);
        }

        $stmt->bind_param("i", $clubId); // Le clubId est un entier
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution : " . $stmt->error);
        }

        $result = $stmt->get_result();
        $requests = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $requests;
    }

    /**
     * Récupère toutes les demandes pour un club donné.
     *
     * @param int $clubId ID du club
     * @return array Liste de toutes les demandes pour un club
     */
    public function getAllRequestsByClubId($clubId)
    {
        $query = "SELECT * FROM requests WHERE club_id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception("Erreur de préparation : " . $this->db->error);
        }

        $stmt->bind_param("i", $clubId); // Le clubId est un entier
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution : " . $stmt->error);
        }

        $result = $stmt->get_result();
        $requests = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $requests;
    }
    /**
 * Supprime une demande de la base de données.
 *
 * @param int $requestId ID de la demande à supprimer
 * @return bool True si la suppression a réussi, False sinon
 */
public function rejectRequest($requestId)
{
    $query = "DELETE FROM requests WHERE id = ?";

    $stmt = $this->db->prepare($query);
    if (!$stmt) {
        throw new Exception("Erreur de préparation : " . $this->db->error);
    }

    $stmt->bind_param("i", $requestId); // Le requestId est un entier
    if (!$stmt->execute()) {
        throw new Exception("Erreur d'exécution : " . $stmt->error);
    }

    $affectedRows = $stmt->affected_rows;
    $stmt->close();
    
    // Si aucune ligne n'a été affectée, cela signifie que la suppression a échoué (requestId introuvable)
    return $affectedRows > 0;
}
public function getRequestById($requestId) {
    $stmt = $this->db->prepare("
        SELECT first_name, last_name, email, phone, niveau, specialite, department, club_id 
        FROM requests WHERE id = ?
    ");
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $result = $stmt->get_result();
    $request = $result->fetch_assoc();
    $stmt->close();
    return $request;
}

}
?>
