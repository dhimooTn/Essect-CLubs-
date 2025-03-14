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
            if ($types) {
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
        return $user;
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
        $stmt = $this->prepareAndExecute(
            "SELECT u.id, u.first_name, u.last_name, u.email, c.name AS club_name, u.role 
            FROM users u LEFT JOIN clubs c ON u.club_id = c.id WHERE u.id = ?",
            "i",
            $id
        );
        if (!$stmt) return null;
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
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
        $stmt = $this->prepareAndExecute(
            "SELECT id FROM clubs WHERE id = ?",
            "i",
            $clubId
        );
        if (!$stmt) return false;
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function updateUser($id, $firstName, $lastName, $email, $role)
    {
        $stmt = $this->prepareAndExecute(
            "UPDATE users SET first_name = ?, last_name = ?, email = ?, role = ? WHERE id = ?",
            "ssssi",
            $firstName, $lastName, $email, $role, $id
        );
        if (!$stmt) return false;
        $stmt->close();
        return true;
    }

    public function deleteUser($id)
    {
        $stmt = $this->prepareAndExecute(
            "DELETE FROM users WHERE id = ?",
            "i",
            $id
        );
        if (!$stmt) return false;
        $stmt->close();
        return true;
    }

    public function getTotalUsers()
    {
        $result = $this->db->query("SELECT COUNT(*) AS total FROM users");
        return $result ? $result->fetch_assoc()['total'] : 0;
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

    private function fetchGroupedData($query, $types = "", ...$params)
    {
        $stmt = $this->prepareAndExecute($query, $types, ...$params);
        if (!$stmt) return [];
        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }
}
?>
