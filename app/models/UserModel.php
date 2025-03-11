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

    /**
     * Get a user by email.
     */
    public function getUserByEmail($email)
    {
        $query = "SELECT id, first_name, last_name, password, role FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }

        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête : " . $stmt->error);
        }

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();
        return $user;
    }

    /**
     * Get all users.
     */
    public function getAllUsers()
    {
        $query = "SELECT users.id, users.first_name, users.last_name, users.email, 
                         clubs.name AS club_name, users.role 
                  FROM users 
                  LEFT JOIN clubs ON users.club_id = clubs.id";
        
        $stmt = $this->db->prepare($query);
    
        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }
    
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête : " . $stmt->error);
        }
    
        $result = $stmt->get_result();
        $users = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
    
        $stmt->close();
        return $users;
    }

    /**
     * Get a user by ID.
     */
    public function getUserById($id)
    {
        $query = "SELECT users.id, users.first_name, users.last_name, users.email, 
                         clubs.name AS club_name, users.role 
                  FROM users 
                  LEFT JOIN clubs ON users.club_id = clubs.id 
                  WHERE users.id = ?";
        
        $stmt = $this->db->prepare($query);
    
        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }
    
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête : " . $stmt->error);
        }
    
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    
        $stmt->close();
        return $user;
    }

    /**
     * Create a new user.
     */
    public function createUser($firstName, $lastName, $email, $password, $phone, $photoPath, $niveau, $specialite, $clubId, $role = 'member')
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (first_name, last_name, email, password, phone, photo_path, niveau, specialite, club_id, role) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }

        $stmt->bind_param("ssssssssss", $firstName, $lastName, $email, $hashedPassword, $phone, $photoPath, $niveau, $specialite, $clubId, $role);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête : " . $stmt->error);
        }

        $stmt->close();
        return $this->db->insert_id;
    }

    /**
     * Add a new user (simplified version for admin).
     */
    public function addUser($firstName, $lastName, $email, $password, $club, $role)
    {
        // Check if email already exists
        $checkSql = "SELECT id FROM users WHERE email = ?";
        $checkStmt = $this->db->prepare($checkSql);
    
        if (!$checkStmt) {
            return "Erreur de préparation (email check) : " . $this->db->error;
        }
    
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
    
        if ($result->num_rows > 0) {
            $checkStmt->close();
            return "Erreur : Cet email est déjà utilisé.";
        }
        $checkStmt->close();
    
        // Insert user if email doesn't exist
        $sql = "INSERT INTO users (first_name, last_name, email, password, club_id, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
    
        if (!$stmt) {
            return "Erreur de préparation (insertion) : " . $this->db->error;
        }
    
        // Hash password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Bind parameters
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $hashedPassword, $club, $role);
    
        if (!$stmt->execute()) {
            return "Erreur d'exécution : " . $stmt->error;
        }
    
        $stmt->close();
        return "Utilisateur ajouté avec succès!";
    }

    /**
     * Update a user.
     */
    public function updateUser($id, $firstName, $lastName, $email, $role)
    {
        $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, role = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }

        $stmt->bind_param("ssssi", $firstName, $lastName, $email, $role, $id);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête : " . $stmt->error);
        }

        $stmt->close();
        return true;
    }

    /**
     * Delete a user.
     */
    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            throw new Exception("Erreur de préparation de la requête : " . $this->db->error);
        }

        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            throw new Exception("Erreur d'exécution de la requête : " . $stmt->error);
        }

        $stmt->close();
        return true;
    }

    /**
     * Get total number of users.
     */
    public function getTotalUsers()
    {
        $query = "SELECT COUNT(*) AS total FROM users";
        $result = $this->db->query($query);
        return $result->fetch_assoc()['total'];
    }

    /**
     * Get users by role.
     */
    public function getUsersByRole()
    {
        $query = "SELECT role, COUNT(*) AS count FROM users GROUP BY role";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get users by niveau.
     */
    public function getUsersByNiveau()
    {
        $query = "SELECT niveau, COUNT(*) AS count FROM users GROUP BY niveau";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get users by department.
     */
    public function getUsersByDepartment()
    {
        $query = "SELECT department, COUNT(*) AS count FROM users GROUP BY department";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get users by club.
     */
    public function getUsersByClub()
    {
        $query = "SELECT clubs.name AS club_name, COUNT(users.id) AS count 
                  FROM users 
                  LEFT JOIN clubs ON users.club_id = clubs.id 
                  GROUP BY clubs.name";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get user registrations by month.
     */
    public function getUsersByRegistrationMonth()
    {
        $query = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS count 
                  FROM users 
                  GROUP BY DATE_FORMAT(created_at, '%Y-%m') 
                  ORDER BY month";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>