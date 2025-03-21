<?php
require_once 'app/core/Controller.php';
require_once 'app/models/UserModel.php';
require_once 'app/models/ClubModel.php';
require_once 'app/models/RequestModel.php';
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
            $this->view('HomeView', ["error" => $_SESSION['error']]);
            exit;
        }
    
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
    
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Veuillez remplir tous les champs.";
            $this->view('HomeView', ["error" => $_SESSION['error']]);
            
            exit;
        }
    
        $userModel = new UserModel();
        $clubModel = new ClubModel();
        $requestModel = new RequestModel();
        $user = $userModel->getUserByEmail($email);
        $clubs = $clubModel->getAllClubs();
        $users = $userModel->getAllUsers();
        $totalUsers = $userModel->getTotalUsers();
        $usersByRole = $userModel->getUsersByRole();
        $usersByNiveau = $userModel->getUsersByNiveau();
        $usersByDepartment = $userModel->getUsersByDepartment();
        $usersByClub = $userModel->getUsersByClub();
        $usersByRegistrationMonth = $userModel->getUsersByRegistrationMonth();
        $totalMembers = $userModel->getTotalMembers($user['club_id']);
        $pendingRequests = $requestModel->getPendingRequests($user['club_id']);
        $clubMembers = $userModel->getUsersByClubId($user['club_id']);
        $request=$requestModel-> getAllRequestsByClubId($user['club_id']);
        $membersByNiveau=$userModel->getNiveauByClubId($user['club_id']);
        $membersByDepartment=$userModel->getDepartementByClubId($user['club_id']);

    
        if (!$user || $password != $user['password']) {
            session_destroy();
            $_SESSION['error'] = "❌ Identifiants incorrects.";
            $this->view('HomeView', ["error" => $_SESSION['error']]);
            exit;
        }
    
        // Regenerate session ID for security
        session_regenerate_id(true);
    
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['first_name'] . ' ' . $user['last_name'];
        $_SESSION['role'] = $user['role'];
    
        // Get the club_id of the president (from the user's data)
        $clubId = $clubModel->getClubIdByUserId($user['id']);
        $club = $clubModel->getClubById($clubId['club_id']); // Assuming you have a method to fetch a club by ID
    
        // Redirect based on role
        switch ($user['role']) {
            case 'admin':
                $this->view('Admin/AdminView', [
                    'users' => $users,
                    'totalMembers' => $totalMembers,
                    'clubs' => $clubs,
                    'totalUsers' => $totalUsers,
                    'usersByRole' => $usersByRole,
                    'usersByNiveau' => $usersByNiveau,
                    'usersByDepartment' => $usersByDepartment,
                    'usersByClub' => $usersByClub,
                    'usersByRegistrationMonth' => $usersByRegistrationMonth
                ]);
                break;
            case 'membre':
                $this->view('Membre/MembreView', [
                    'users' => $users,
                    'clubs' => $clubs,
                    'totalUsers' => $totalUsers,
                    'usersByRole' => $usersByRole,
                    'usersByNiveau' => $usersByNiveau,
                    'usersByDepartment' => $usersByDepartment,
                    'usersByClub' => $usersByClub,
                    'usersByRegistrationMonth' => $usersByRegistrationMonth
                ]);
                break;
            case 'president':
                // Pass the president's specific club to the view
                $this->view('President/PresidentView', [
                    'totalMembers' => $totalMembers,
                    'pendingRequests' => $pendingRequests,
                    'clubMembers' => $clubMembers,
                    'request'=> $request,
                    'totalUsers' => $totalUsers,
                    'membersByNiveau' => $membersByNiveau,
                    'membersByDepartment' => $membersByDepartment
            
                ]);
                break;
            default:
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