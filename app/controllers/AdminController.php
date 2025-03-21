<?php

require_once 'app/core/Controller.php';
require_once 'app/models/UserModel.php';
require_once 'app/models/ClubModel.php';
require_once 'app/config/config.php';
require_once 'app/core/View.php';

class AdminController extends Controller
{
    private $userModel;
    private $clubModel;

    public function __construct() {
        // Instantiate models
        $this->userModel = new UserModel();
        $this->clubModel = new ClubModel();
    }

    // Method to display all users and clubs (Admin Dashboard)
    public function index() {
        $users = $this->userModel->getAllUsers();
        $clubs = $this->clubModel->getAllClubs();

        // Fetch additional data for the dashboard
        // Total number of users
        $totalUsers = count($users);

        // Users by role
        $usersByRole = $this->userModel->getUsersByRole();

        // Users by niveau (level)
        $usersByNiveau = $this->userModel->getUsersByNiveau();

        // Users by department
        $usersByDepartment = $this->userModel->getUsersByDepartment();
        
        // Users by club
        $usersByClub = $this->userModel->getUsersByClub();

        // Users by registration month
        $usersByRegistrationMonth = $this->userModel->getUsersByRegistrationMonth();

        // Render the view from the 'Admin' folder (Admin/AdminView.php)
        return $this->view('Admin/AdminView', [
            'users' => $users,
            'clubs' => $clubs,
            'totalUsers' => $totalUsers,
            'usersByRole' => $usersByRole,
            'usersByNiveau' => $usersByNiveau,
            'usersByDepartment' => $usersByDepartment,
            'usersByClub' => $usersByClub,
            'usersByRegistrationMonth' => $usersByRegistrationMonth
        ]);
    }

    // Method to add a new user
    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = $_POST['role'];
            $clubId = $_POST['club'];

            // Call model to add user
            $userAdded = $this->userModel->addUser($firstName, $lastName, $email, $password, $role, $clubId);

            if ($userAdded) {
                $_SESSION['successMessage'] = 'User added successfully!';
            } else {
                $_SESSION['errorMessage'] = 'Failed to add user.';
            }

            // Redirect to the admin dashboard
            header('Location: /admin');
            exit();
        }

        // Render the add user form view if not POST request
        return $this->view('Admin/addUser');
    }

    // Method to edit a user (by user ID)
    public function updateUser($userId)
{
    // Ensure that the userId is valid and numeric
    if (empty($userId) || !is_numeric($userId)) {
        $_SESSION['errorMessage'] = 'Invalid user ID.';
        header('Location: /admin');
        exit();
    }

    // If the request method is POST, proceed with updating the user
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // Call the model to update the user
        $userUpdated = $this->userModel->updateUser($userId, $firstName, $lastName, $email, $role);

        if ($userUpdated) {
            $_SESSION['successMessage'] = 'User updated successfully!';
        } else {
            $_SESSION['errorMessage'] = 'Failed to update user.';
        }

        // Redirect to the admin dashboard
        header('Location: /admin');
        exit();
    }

    // For GET requests, retrieve user details to pre-fill the form
    $user = $this->userModel->getUserById($userId);
    if ($user) {
        return $this->view('Admin/updateUser', ['user' => $user]);
    } else {
        $_SESSION['errorMessage'] = 'User not found.';
        header('Location: /admin');
        exit();
    }
}

public function deleteUser($userId)
{
    // Ensure that the userId is valid and numeric
    if (empty($userId) || !is_numeric($userId)) {
        $_SESSION['errorMessage'] = 'Invalid user ID.';
        header('Location: /admin');
        exit();
    }

    // Call the model to delete the user
    $userDeleted = $this->userModel->deleteUser($userId);

    if ($userDeleted) {
        $_SESSION['successMessage'] = 'User deleted successfully!';
    } else {
        $_SESSION['errorMessage'] = 'Failed to delete user.';
    }

    // Redirect to the admin dashboard
    header('Location: /admin');
    exit();
}


    // Method to add a new club
    public function addClub() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clubName = $_POST['club_name'];
            $clubDescription = $_POST['club_description'];

            $clubAdded = $this->clubModel->addClub($clubName);

            if ($clubAdded) {
                $_SESSION['successMessage'] = 'Club added successfully!';
            } else {
                $_SESSION['errorMessage'] = 'Failed to add club.';
            }

            // Redirect to the admin dashboard
            header('Location: /admin');
            exit();
        }

        // Render the add club form view if not POST request
        return $this->view('Admin/addClub');
    }

    // Method to edit a club (by club ID)
    public function updateClub($params = []) {
        $clubId = $params[0];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clubName = $_POST['club_name'];
            $clubDescription = $_POST['club_description'];

            $clubUpdated = $this->clubModel->updateClub($clubId, $clubName);

            if ($clubUpdated) {
                $_SESSION['successMessage'] = 'Club updated successfully!';
            } else {
                $_SESSION['errorMessage'] = 'Failed to update club.';
            }

            // Redirect to the admin dashboard
            header('Location: /admin');
            exit();
        }

        // Get club details for pre-filled form (if GET request)
        $club = $this->clubModel->getClubById($clubId);
        return $this->view('Admin/editClub', ['club' => $club]);
    }

    // Method to delete a club (by club ID)
    public function deleteClub($params = []) {
        $clubId = $params[0];

        $clubDeleted = $this->clubModel->deleteClub($clubId);

        if ($clubDeleted) {
            $_SESSION['successMessage'] = 'Club deleted successfully!';
        } else {
            $_SESSION['errorMessage'] = 'Failed to delete club.';
        }

        // Redirect to the admin dashboard
        header('Location: /admin');
        exit();
    }
}
?>
