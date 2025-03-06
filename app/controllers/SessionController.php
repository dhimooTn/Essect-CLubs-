<?php
require_once '../models/UserModel.php'; // Inclure la classe UserModel

class SessionController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel(); // Initialiser le UserModel
    }

    /**
     * Affiche la page de connexion.
     */
    public function index()
    {
        // Afficher le formulaire de connexion
        echo "Bienvenue sur la page de connexion.";
    }

    /**
     * Gère la connexion de l'utilisateur.
     * 
     * @param array $data Les données du formulaire de connexion (email et mot de passe).
     * @throws Exception Si la connexion échoue.
     */
    public function login($data)
    {
        // Valider les champs obligatoires
        $requiredFields = ['email', 'password'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("Le champ $field est obligatoire.");
            }
        }

        // Valider le format de l'email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'email n'est pas valide.");
        }

        // Nettoyer les entrées
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password = $data['password']; // Pas besoin de htmlspecialchars pour les mots de passe

        // Authentifier l'utilisateur
        $user = $this->userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Démarrer une session sécurisée
            $this->startSecureSession();

            // Régénérer l'ID de session pour éviter la fixation de session
            session_regenerate_id(true);

            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Générer un token CSRF

            // Rediriger en fonction du rôle
            $this->redirectBasedOnRole($user['role']);
        } else {
            throw new Exception("Email ou mot de passe invalide.");
        }
    }

    /**
     * Démarre une session sécurisée.
     */
    private function startSecureSession()
    {
        // Configurer les paramètres de session pour plus de sécurité
        ini_set('session.cookie_httponly', 1); // Empêcher l'accès aux cookies via JavaScript
        ini_set('session.cookie_secure', 1); // Utiliser uniquement HTTPS pour les cookies
        ini_set('session.use_strict_mode', 1); // Utiliser le mode strict pour les sessions

        session_start();
    }

    /**
     * Redirige l'utilisateur en fonction de son rôle.
     * 
     * @param string $role Le rôle de l'utilisateur (admin, membre, président).
     * @throws Exception Si le rôle est inconnu.
     */
    private function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 'admin':
                header("Location:app\views\Admin\AdminView.php");
                break;
            case 'membre':
                header("Location: app\views\Membre\MembreView.php");
                break;
            case 'president':
                header("Location: app\views\President\President.php");
                break;
            default:
                throw new Exception("Rôle utilisateur inconnu.");
        }
        exit(); // Arrêter l'exécution du script après la redirection
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout()
    {
        // Démarrer la session si ce n'est pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Supprimer toutes les variables de session
        $_SESSION = [];

        // Détruire la session
        session_destroy();

        // Rediriger vers la page de connexion
        header("Location: /login.php");
        exit();
    }
}

// Gérer la requête de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Vérifier le token CSRF
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            throw new Exception("Token CSRF invalide.");
        }

        $sessionController = new SessionController();

        // Récupérer et nettoyer les données POST
        $data = [
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? ''
        ];

        $sessionController->login($data);
    } catch (Exception $e) {
        // Journaliser l'erreur (ne pas afficher de détails sensibles)
        error_log("Erreur de connexion : " . $e->getMessage());
        echo "Une erreur s'est produite. Veuillez réessayer.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>