<?php
require_once CORE . 'Db.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        $dbInstance = new Db();
        $this->db = $dbInstance->connect();
    }

    public function getUserByEmail($email)
    {
        // Requête SQL mise à jour pour utiliser first_name et last_name
        $query = "SELECT id, first_name, last_name, password, role FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $this->db->error);
        }

        $stmt->bind_param("s", $email);

        if (!$stmt->execute()) {
            die("Erreur d'exécution de la requête : " . $stmt->error);
        }

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Fermer le statement et la connexion
        $stmt->close();
        $this->db->close();

        return $user;
    }
}
?>