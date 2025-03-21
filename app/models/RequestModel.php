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
     * Enregistre une erreur dans le fichier log.
     *
     * @param string $message Le message d'erreur à enregistrer
     */
    private function logError($message)
    {
        // Enregistrement des erreurs dans un fichier log
        file_put_contents('errors.log', date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    }

    /**
     * Insère une nouvelle demande dans la table `requests`.
     *
     * @param array $data Les données de la demande
     * @return int|false L'ID de la demande insérée ou false en cas d'échec
     */
    public function insertRequest($data)
    {
        // Validation des données
        if (empty($data['first_name']) || empty($data['last_name']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Les données sont invalides.");
        }
    
        // Vérifier si l'email existe déjà
        $checkEmailQuery = "SELECT COUNT(*) FROM requests WHERE email = :email";
        $stmt = $this->db->prepare($checkEmailQuery);
        $stmt->bindParam(':email', $data['email']);
        
        try {
            $stmt->execute();
            $emailExists = $stmt->fetchColumn();
    
            if ($emailExists) {
                throw new Exception("L'email est déjà utilisé.");
            }
        } catch (PDOException $e) {
            $this->logError("Erreur lors de la vérification de l'email: " . $e->getMessage());
            throw new Exception("Erreur lors de la vérification de l'email: " . $e->getMessage());
        }
    
        // Requête d'insertion
        $query = "
            INSERT INTO requests (
                first_name, last_name, email, phone, facebook_url, niveau, specialite, 
                club_experience, previous_club, department, motivation, interview_availability, 
                cv_path, club_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
    
        try {
            $stmt = $this->db->prepare($query);
            // Binding des paramètres avec les bons types
            $stmt->execute([
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
                $data['club_id']
            ]);
    
            // Récupération de l'ID de la demande insérée
            $insertId = $this->db->lastInsertId();
            return $insertId;
        } catch (PDOException $e) {
            $this->logError("Erreur lors de l'insertion de la demande: " . $e->getMessage());
            throw new Exception("Erreur lors de l'insertion de la demande: " . $e->getMessage());
        }
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
            $this->logError("Erreur de préparation : " . implode(" ", $this->db->errorInfo()));
            throw new Exception("Erreur de préparation : " . implode(" ", $this->db->errorInfo()));
        }

        $stmt->bindValue(1, $clubId, PDO::PARAM_INT); // Le clubId est un entier
        if (!$stmt->execute()) {
            $this->logError("Erreur d'exécution : " . implode(" ", $stmt->errorInfo()));
            throw new Exception("Erreur d'exécution : " . implode(" ", $stmt->errorInfo()));
        }

        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $stmt = null;
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
            $this->logError("Erreur de préparation : " . implode(" ", $this->db->errorInfo()));
            throw new Exception("Erreur de préparation : " . implode(" ", $this->db->errorInfo()));
        }

        $stmt->bindValue(1, $clubId, PDO::PARAM_INT); // Le clubId est un entier
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $this->logError("Erreur d'exécution : " . implode(" ", $errorInfo));
            throw new Exception("Erreur d'exécution : " . implode(" ", $errorInfo));
        }

        $stmt->execute();
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
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
            $this->logError("Erreur de préparation : " . implode(" ", $this->db->errorInfo()));
            throw new Exception("Erreur de préparation : " . implode(" ", $this->db->errorInfo()));
        }

        $stmt->bindValue(1, $clubId, PDO::PARAM_INT); // Le clubId est un entier
        if (!$stmt->execute()) {
            $this->logError("Erreur d'exécution : " . implode(" ", $stmt->errorInfo()));
            throw new Exception("Erreur d'exécution : " . implode(" ", $stmt->errorInfo()));
        }

        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
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
            $this->logError("Erreur de préparation : " . implode(" ", $this->db->errorInfo()));
            throw new Exception("Erreur de préparation : " . implode(" ", $this->db->errorInfo()));
        }

        $stmt->bindValue(1, $requestId, PDO::PARAM_INT); // Le requestId est un entier
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $this->logError("Erreur d'exécution : " . implode(" ", $errorInfo));
            throw new Exception("Erreur d'exécution : " . implode(" ", $errorInfo));
        }

        $affectedRows = $stmt->rowCount();
        $stmt = null;
        
        // Si aucune ligne n'a été affectée, cela signifie que la suppression a échoué (requestId introuvable)
        return $affectedRows > 0;
    }

    /**
     * Récupère les détails d'une demande par son ID.
     *
     * @param int $requestId ID de la demande
     * @return array|false Les détails de la demande ou false si non trouvée
     */
    public function getRequestById($requestId)
    {
        $stmt = $this->db->prepare("
            SELECT first_name, last_name, email, phone, niveau, specialite, department, club_id 
            FROM requests WHERE id = ?
        ");
        $stmt->bindValue(1, $requestId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->execute();
        $request = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = null;
        return $request;
    }
}
?>
