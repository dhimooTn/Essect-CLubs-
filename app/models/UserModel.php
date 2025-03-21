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
            if (!empty($types)) {
                $stmt->bindParam(1, $params[0], $types);
                for ($i = 1; $i < count($params); $i++) {
                    $stmt->bindParam($i + 1, $params[$i], $types);
                }
            }
            if (!$stmt->execute()) {
                throw new Exception("Erreur d'exécution : " . implode(", ", $stmt->errorInfo()));
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
            "SELECT * FROM users WHERE email = ?",
            PDO::PARAM_STR,
            $email
        );
        if (!$stmt) return null;
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers()
    {
        $stmt = $this->prepareAndExecute(
            "SELECT u.id, u.first_name, u.last_name, u.email, c.name AS club_name, u.role 
            FROM users u LEFT JOIN clubs c ON u.club_id = c.id"
        );
        if (!$stmt) return [];
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        return $this->fetchSingleValue(
            "SELECT u.id, u.first_name, u.last_name, u.email, c.name AS club_name, u.role 
            FROM users u LEFT JOIN clubs c ON u.club_id = c.id WHERE u.id = ?",
            PDO::PARAM_INT,
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
            PDO::PARAM_STR,
            $firstName, $lastName, $email, $hashedPassword, $phone, $photoPath, $niveau, $specialite, $clubId, $role
        );

        if (!$stmt) return ["status" => "error", "message" => "Erreur lors de la création de l'utilisateur."];
        return ["status" => "success", "user_id" => $this->db->lastInsertId()];
    }

    private function clubExists($clubId)
    {
        return (bool) $this->fetchSingleValue(
            "SELECT id FROM clubs WHERE id = ?",
            PDO::PARAM_INT,
            $clubId
        );
    }

    public function updateUser($id, $firstName, $lastName, $email, $password)
    {
        // Prepare the SQL query with placeholders
        $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?";
    
        // Prepare the statement
        $stmt = $this->db->prepare($sql);
    
        // Bind parameters
        $stmt->bindParam(1, $firstName, PDO::PARAM_STR);
        $stmt->bindParam(2, $lastName, PDO::PARAM_STR);
        $stmt->bindParam(3, $email, PDO::PARAM_STR);
        $stmt->bindParam(4, $password, PDO::PARAM_STR);
        $stmt->bindParam(5, $id, PDO::PARAM_INT);
    
        // Execute the statement
        $stmt->execute();
    
        // Return true if at least one row was updated
        return $stmt->rowCount() > 0;
    }
    

    public function deleteUser($id)
    {
        $stmt = $this->prepareAndExecute(
            "DELETE FROM users WHERE id = ?",
            PDO::PARAM_INT,
            $id
        );

        return $stmt ? $stmt->rowCount() > 0 : false;
    }

    public function getTotalUsers()
    {
        return $this->fetchSingleValue("SELECT COUNT(*) AS total FROM users");
    }

    public function getUsersByRole()
    {
        $sql = "SELECT role, COUNT(*) AS count FROM users GROUP BY role";
    
        // Prepare the SQL statement
        $stmt = $this->db->prepare($sql);
        
        // Execute the query
        $stmt->execute();
    
        // Fetch the results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getUsersByNiveau()
    {
        $sql = "SELECT niveau, COUNT(*) AS count FROM users GROUP BY niveau";
    
        // Prepare the SQL statement
        $stmt = $this->db->prepare($sql);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch the results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getUsersByDepartment()
    {
        $sql = "SELECT specialite AS department, COUNT(*) AS count FROM users GROUP BY specialite";
    
        // Prepare the SQL statement
        $stmt = $this->db->prepare($sql);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch the results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getUsersByClub()
    {
        $sql = "SELECT COALESCE(c.name, 'No Club') AS club_name, COUNT(u.id) AS count 
                FROM users u 
                LEFT JOIN clubs c ON u.club_id = c.id 
                GROUP BY c.name";
    
        // Prepare the SQL statement
        $stmt = $this->db->prepare($sql);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch the results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getUsersByRegistrationMonth()
    {
        $sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS count 
                FROM users 
                GROUP BY month 
                ORDER BY month ASC";
    
        // Prepare the SQL statement
        $stmt = $this->db->prepare($sql);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch the results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getTotalMembers($clubId)
    {
        $sql = "SELECT COUNT(*) AS total FROM users WHERE club_id = :club_id";
        
        // Prepare the statement
        $stmt = $this->db->prepare($sql);
        
        // Bind the parameter securely
        $stmt->bindParam(':club_id', $clubId, PDO::PARAM_INT);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch the total count
        return (int) $stmt->fetchColumn();
    }
    

    public function getMembersByDepartment($clubId)
    {
        $sql = "SELECT specialite AS department, COUNT(*) AS count 
                FROM users 
                WHERE club_id = :club_id 
                GROUP BY specialite";
        
        // Prepare the statement
        $stmt = $this->db->prepare($sql);
        
        // Bind the club ID parameter securely
        $stmt->bindParam(':club_id', $clubId, PDO::PARAM_INT);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch all results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getMembersByNiveau($clubId)
    {
        $sql = "SELECT niveau, COUNT(*) AS count 
                FROM users 
                WHERE club_id = :club_id 
                GROUP BY niveau";
    
        // Prepare the statement
        $stmt = $this->db->prepare($sql);
    
        // Bind the club ID securely
        $stmt->bindParam(':club_id', $clubId, PDO::PARAM_INT);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch all results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getMembersByRole($clubId)
    {
        $sql = "SELECT role, COUNT(*) AS count 
                FROM users 
                WHERE club_id = :club_id 
                GROUP BY role";
    
        // Prepare the statement
        $stmt = $this->db->prepare($sql);
    
        // Bind the club ID securely
        $stmt->bindParam(':club_id', $clubId, PDO::PARAM_INT);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch all results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    private function fetchSingleValue($query, $type = PDO::PARAM_STR, ...$params)
    {
        $stmt = $this->prepareAndExecute($query, $type, ...$params);
        return $stmt ? (int)$stmt->fetchColumn() : 0;
    }

    private function fetchGroupedData($query, $type = PDO::PARAM_STR, ...$params)
    {
        $stmt = $this->prepareAndExecute($query, $type, ...$params);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function addUser($firstName, $lastName, $email, $password, $role, $clubId)
    {
        $sql = "INSERT INTO users (first_name, last_name, email, password, club_id, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->prepareAndExecute($sql, PDO::PARAM_STR, $firstName, $lastName, $email, $password, $clubId, $role);
        return $stmt ? $this->db->lastInsertId() : false;
    }

    public function generatePassword($length = 8)
    {
        return bin2hex(random_bytes($length / 2)); // Example: "8f6a2b1c"
    }

    public function creatUser($data)
    {
        $sql = "INSERT INTO users (first_name, last_name, email, password, phone, photo_path, niveau, specialite, department, club_id, role) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'member')";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $data['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(3, $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(4, $data['password'], PDO::PARAM_STR);
        $stmt->bindParam(5, $data['phone'], PDO::PARAM_STR);
        $stmt->bindParam(6, $data['photo_path'], PDO::PARAM_STR);
        $stmt->bindParam(7, $data['niveau'], PDO::PARAM_STR);
        $stmt->bindParam(8, $data['specialite'], PDO::PARAM_STR);
        $stmt->bindParam(9, $data['department'], PDO::PARAM_STR);
        $stmt->bindParam(10, $data['club_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }
    public function getUsersByClubId($clubId) {
        // Implement the logic to get users by club ID
        // Example:
        $stmt = $this->db->prepare("SELECT * FROM users WHERE club_id = :club_id");
        $stmt->bindParam(':club_id', $clubId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getNiveauByClubId($clubId)
    {
        // Implement the logic to get the niveau by club ID
        // Example:
        $stmt = $this->db->prepare("SELECT niveau FROM users WHERE club_id = :club_id");
        $stmt->bindParam(':club_id', $clubId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDepartementByClubId($clubId)
    {
        // Implement the method logic here
        // Example:
        $stmt = $this->db->prepare("SELECT department FROM users WHERE club_id = :club_id");
        $stmt->bindParam(':club_id', $clubId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getClubIdByUserId($userId)
{
    $stmt = $this->db->prepare("SELECT club_id FROM clubs WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}

?>
