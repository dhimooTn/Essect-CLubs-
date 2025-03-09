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
        $stmt = $this->db->prepare("
            INSERT INTO requests (
                first_name, last_name, email, phone, facebook_url, niveau, specialite, 
                club_experience, previous_club, department, motivation, interview_availability, 
                cv_path, photo_path, club_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
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
        );

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }
}
?>