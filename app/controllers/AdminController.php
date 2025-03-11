<?php
require_once 'app/core/Controller.php';
require_once 'app/models/UserModel.php';
require_once 'app/models/ClubModel.php';

class AdminController extends Controller {
    private $userModel;
    private $clubModel;
    private $users;
    private $clubs;

    public function __construct() {
        // Vérification si l'admin est connecté
        session_start(); // Assurez-vous que la session est bien démarrée
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . BURL);
            exit;
        }

        // Initialisation des modèles
        $this->userModel = new UserModel();
        $this->clubModel = new ClubModel();

        // Récupération des données
        $this->users = $this->userModel->getAllUsers();
        $this->clubs = $this->clubModel->getAllClubs();
    }

    /**
     * Ajoute un nouvel utilisateur.
     */
    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération et nettoyage des données
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $club = trim($_POST['club'] ?? '1');  // Valeur par défaut : 1
            $role = trim($_POST['role'] ?? 'member'); // Valeur par défaut : member
    
            // Vérification des champs obligatoires
            if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
                echo "Erreur : Tous les champs sont obligatoires.";
                return;
            }
    
            // Debugging : Afficher les données reçues (à enlever en production)
            error_log("Adding user: $firstName $lastName, Email: $email, Club: $club, Role: $role");
    
            // Ajouter l'utilisateur à la base de données
            $result = $this->userModel->addUser($firstName, $lastName, $email, $password, $club, $role);
    
            if ($result === "Utilisateur ajouté avec succès!") {
                // Récupérer les nouvelles données pour la vue
                $users = $this->userModel->getAllUsers(); // Fonction à implémenter
                $clubs = $this->clubModel->getAllClubs(); // Fonction à implémenter si nécessaire
    
                // Rediriger vers la page admin après ajout réussi
                $this->view('Admin/AdminView', [
                    'users' => $users,
                    'clubs' => $clubs
                ]);
                exit;
            } else {
                echo "Erreur : " . $result;
            }
        }
    }
    

    /**
     * Met à jour un utilisateur existant.
     */
    public function updateUser($id) {
        // Récupérer l'utilisateur à partir de l'ID
        $user = $this->userModel->getUserById($id);

        if (!$user) {
            echo "Utilisateur introuvable!";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $role = $_POST['role'] ?? 'member';

            // Mise à jour de l'utilisateur
            $success = $this->userModel->updateUser($id, $firstName, $lastName, $email, $role);
            if ($success) {
                $this->view('Admin/AdminView', [
                    'users' => $this->users,
                    'clubs' => $this->clubs,
             // Send the user data to pre-fill the form
                ]);
                exit;
            } else {
                echo "Erreur : L'utilisateur n'a pas pu être mis à jour.";
            }
        }

        // Passer les données de l'utilisateur à la vue pour pré-remplir le formulaire

    }

    /**
     * Supprime un utilisateur.
     */
    public function deleteUser($id) {
        // Essayer de supprimer l'utilisateur
        $success = $this->userModel->deleteUser($id);
    
        // Vérifier si la suppression a réussi
        if ($success) {
            // Rediriger vers la page d'administration (liste des utilisateurs)
            $this->view('Admin/AdminView', [
                'users' => $this->users, // Now passed correctly
                'clubs' => $this->clubs
            ]);
            exit; // Assurez-vous que 'BURL' est bien défini
            
        } else {
            // Afficher un message d'erreur en cas d'échec
            echo "Erreur : L'utilisateur n'a pas pu être supprimé. Vérifiez la connexion à la base de données et la requête SQL.";
        }
    }
    

    /**
     * Ajoute un nouveau club.
     */
    public function addClub() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['club_name'] ?? '';
    
            // Validate the club name
            if (empty($name)) {
                // Optionally, you can set an error message here or redirect back
                echo "Le nom du club ne peut pas être vide.";
                return; // Exit the function to prevent further processing
            }
    
            // Ajouter le club à la base de données
            try {
                $this->clubModel->addClub($name);
            } catch (Exception $e) {
                // Handle the exception (e.g., club already exists or database issues)
                echo $e->getMessage();
                return;
            }
    
            // Rediriger vers l'admin
            $this->view('Admin/AdminView', [
                'users' => $this->users, // Now passed correctly
                'clubs' => $this->clubs
            ]);
            exit;
        }
    }
    

    /**
     * Met à jour un club existant.
     */
    public function updateClub($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';

            // Mise à jour du club
            $this->clubModel->updateClub($id, $name);

            // Rediriger vers l'admin
            header("Location: " . BURL . "/admin");
            exit;
        }
    }

    /**
     * Supprime un club.
     */
    public function deleteClub($id) {
        $this->clubModel->deleteClub($id);

        // Rediriger vers l'admin
        header("Location: " . BURL . "/admin");
        exit;
    }

    /**
     * Déconnecte l'administrateur.
     */
    public function logout() {
        session_unset();
        session_destroy();
        header("Location: " . BURL);
        exit;
    }
}
?>

