<?php
require_once '../models/UserModel.php';

class SessionController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login($email, $password)
    {
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_destroy();
        header("Location: ../index.php");
        exit;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
}

$sessionController = new SessionController();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($sessionController->login($email, $password)) {
            header("Location: ../views/Admin/AdminView.php");
            exit;
        } else {
            $error = "Identifiants incorrects.";
            header("Location: ../index.php?error=" . urlencode($error));
            exit;
        }
    }
}
?>