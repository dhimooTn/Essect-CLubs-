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
                cv_path, photo_path, club_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception("Erreur de préparation : " . $this->db->error);
        }

        if (!$stmt->bind_param(
            "ssssssssisssssi",
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
            $data['photo_path'],
            $data['club_id']
        )) {
            throw new Exception("Erreur lors du binding des paramètres : " . $stmt->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution : " . $stmt->error);
        }

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
        $query = "SELECT COUNT(*) AS total FROM requests WHERE club_id = ? AND status = 'pending'";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception("Erreur de préparation : " . $this->db->error);
        }

        $stmt->bind_param("i", $clubId);
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

        $stmt->bind_param("i", $clubId);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution : " . $stmt->error);
        }

        $result = $stmt->get_result();
        $requests = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $requests;
    }
}
?>
