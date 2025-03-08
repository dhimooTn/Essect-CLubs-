<?php
require_once 'app/core/Controller.php';
require_once 'app/models/UserModel.php';
require_once 'app/config/config.php';
require_once 'app/core/View.php';

class SessionController extends Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $_SESSION['error'] = "Méthode non autorisée.";
            header("Location: " . BURL);
            $this->view('HomeView', ["error" => $_SESSION['error']]);
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            header("Location: " . BURL);
            $this->view('HomeView', ["error" => $_SESSION['error']]);
            $this->logout();
            exit;
        }

        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);
        //var_dump($user); 
          

        if (!$user  || $password != $user['password']) {
            $_SESSION['error'] = "Identifiants incorrects.";
            header("Location: " . BURL);
            $this->view('HomeView', ["error" => $_SESSION['error']]);
            exit;
            
        }

        // 🔥 Sécurisation : régénération de la session
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['role'] = $user['role'];

        // 🔥 Redirection selon le rôle
        switch ($user['role']) {
            case 'admin':
                $this->view('Admin/AdminView', []);
                break;
            case 'membre':
                $this->view('Membre/MembreView', []);
                break;
            case 'president':
                $this->view('President/PresidentView', []);
                break;
            default:
                // 🔥 Redirection par défaut si le rôle est inconnu
                header("Location: " . BURL);
                break;
        }
        exit;
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: " . BURL);
        exit;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
}
?>