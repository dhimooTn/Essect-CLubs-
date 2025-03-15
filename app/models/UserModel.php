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

    private function prepareAndExecute($query, $types = "", ...$params)
    {
        try {
            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                throw new Exception("Erreur de préparation : " . $this->db->error);
            }
            if (!empty($types)) {
                $stmt->bind_param($types, ...$params);
            }
            if (!$stmt->execute()) {
                throw new Exception("Erreur d'exécution : " . $stmt->error);
            }
            return $stmt;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->prepareAndExecute(
            "SELECT id, first_name, last_name, password, role FROM users WHERE email = ?",
            "s",
            $email
        );
        if (!$stmt) return null;
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user ?: null;
    }

    public function getAllUsers()
    {
        $stmt = $this->prepareAndExecute(
            "SELECT u.id, u.first_name, u.last_name, u.email, c.name AS club_name, u.role 
            FROM users u LEFT JOIN clubs c ON u.club_id = c.id"
        );
        if (!$stmt) return [];
        $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $users;
    }

    public function getUserById($id)
    {
        return $this->fetchSingleValue(
            "SELECT u.id, u.first_name, u.last_name, u.email, c.name AS club_name, u.role 
            FROM users u LEFT JOIN clubs c ON u.club_id = c.id WHERE u.id = ?",
            "i",
            $id
        );
    }

    public function createUser($firstName, $lastName, $email, $password, $phone, $photoPath, $niveau, $specialite, $clubId, $role = 'member')
    {
        if (!$this->clubExists($clubId)) {
            return ["status" => "error", "message" => "Le club sélectionné n'existe pas."];
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->prepareAndExecute(
            "INSERT INTO users (first_name, last_name, email, password, phone, photo_path, niveau, specialite, club_id, role) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            "ssssssssss",
            $firstName, $lastName, $email, $hashedPassword, $phone, $photoPath, $niveau, $specialite, $clubId, $role
        );

        if (!$stmt) return ["status" => "error", "message" => "Erreur lors de la création de l'utilisateur."];
        $stmt->close();
        return ["status" => "success", "user_id" => $this->db->insert_id];
    }

    private function clubExists($clubId)
    {
        return (bool) $this->fetchSingleValue(
            "SELECT id FROM clubs WHERE id = ?",
            "i",
            $clubId
        );
    }

    public function updateUser($id, $firstName, $lastName, $email, $role)
    {
        return (bool) $this->prepareAndExecute(
            "UPDATE users SET first_name = ?, last_name = ?, email = ?, role = ? WHERE id = ?",
            "ssssi",
            $firstName, $lastName, $email, $role, $id
        );
    }

    public function deleteUser($id)
    {
        return (bool) $this->prepareAndExecute(
            "DELETE FROM users WHERE id = ?",
            "i",
            $id
        );
    }

    public function getTotalUsers()
    {
        return $this->fetchSingleValue("SELECT COUNT(*) AS total FROM users");
    }

    public function getUsersByRole()
    {
        return $this->fetchGroupedData("SELECT role, COUNT(*) AS count FROM users GROUP BY role");
    }

    public function getUsersByNiveau()
    {
        return $this->fetchGroupedData("SELECT niveau, COUNT(*) AS count FROM users GROUP BY niveau");
    }

    public function getUsersByDepartment()
    {
        return $this->fetchGroupedData("SELECT specialite AS department, COUNT(*) AS count FROM users GROUP BY specialite");
    }

    public function getUsersByClub()
    {
        return $this->fetchGroupedData(
            "SELECT c.name AS club_name, COUNT(u.id) AS count 
            FROM users u LEFT JOIN clubs c ON u.club_id = c.id GROUP BY c.name"
        );
    }

    public function getUsersByRegistrationMonth()
    {
        return $this->fetchGroupedData(
            "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS count 
            FROM users GROUP BY DATE_FORMAT(created_at, '%Y-%m') ORDER BY month"
        );
    }

    public function getTotalMembers($clubId)
    {
        return $this->fetchSingleValue(
            "SELECT COUNT(*) AS total FROM users WHERE club_id = ?", 
            "i", 
            $clubId
        );
    }

    public function getMembersByDepartment($clubId)
    {
        return $this->fetchGroupedData(
            "SELECT specialite AS department, COUNT(*) AS count FROM users WHERE club_id = ? GROUP BY specialite",
            "i",
            $clubId
        );
    }

    public function getMembersByNiveau($clubId)
    {
        return $this->fetchGroupedData(
            "SELECT niveau, COUNT(*) AS count FROM users WHERE club_id = ? GROUP BY niveau",
            "i",
            $clubId
        );
    }

    public function getMembersByRole($clubId)
    {
        return $this->fetchGroupedData(
            "SELECT role, COUNT(*) AS count FROM users WHERE club_id = ? GROUP BY role",
            "i",
            $clubId
        );
    }

    private function fetchSingleValue($query, $types = "", ...$params)
    {
        $stmt = $this->prepareAndExecute($query, $types, ...$params);
        if (!$stmt) return 0;
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result ? (int) $result['total'] : 0;
    }

    private function fetchGroupedData($query, $types = "", ...$params)
    {
        $stmt = $this->prepareAndExecute($query, $types, ...$params);
        if (!$stmt) return [];
        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    // Fetch users by club ID
    public function getUsersByClubId($id) {
        $sql = "SELECT * FROM users WHERE club_id = ?";
        $stmt = $this->prepareAndExecute($sql, "i", $id);
        if (!$stmt) return [];
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch distinct levels (niveaux) by club ID
    public function getNiveuByClubId($clubId)
    {
        $query = "SELECT DISTINCT niveau FROM users WHERE club_id = ?";
        $stmt = $this->prepareAndExecute($query, "i", $clubId);
        if (!$stmt) return [];
        $result = $stmt->get_result();
        $niveaux = $result->fetch_all(MYSQLI_ASSOC);
        return $niveaux;
    }

    // Fetch distinct departments (specialite) by club ID
    public function getDepartementByClubId($clubId)
    {
        $query = "SELECT DISTINCT specialite AS department FROM users WHERE club_id = ?";
        $stmt = $this->prepareAndExecute($query, "i", $clubId);
        if (!$stmt) return [];
        $result = $stmt->get_result();
        $departments = $result->fetch_all(MYSQLI_ASSOC);
        return $departments;
    }
}
?>
