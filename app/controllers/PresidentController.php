<?php

require_once 'app/core/Controller.php';
require_once 'app/models/UserModel.php';
require_once 'app/models/RequestModel.php';
require_once 'app/config/config.php';
require_once 'app/core/View.php';

class PresidentController extends Controller
{
    private $userModel;
    private $requestModel;

    public function __construct() {
        // Instantiate models
        $this->userModel = new UserModel();
        $this->requestModel = new RequestModel();
    }

    public function index($id = 1) {  // Default value of $id if none provided
        // Ensure $id is valid, if needed
        if (!is_numeric($id)) {
            $_SESSION['errorMessage'] = 'Invalid club ID.';
            header('Location: /president');
            exit();
        }

        // Get data for club id
        $totalMembers = $this->userModel->getTotalMembers($id);
        $pendingRequests = $this->requestModel->getPendingRequests($id);
        $clubMembers = $this->userModel->getUsersByClubId($id);
        $request = $this->requestModel->getAllRequestsByClubId($id);
        $membersByNiveau = $this->userModel->getNiveauByClubId($id);
        $membersByDepartment = $this->userModel->getDepartementByClubId($id);

        $this->view('President/PresidentView', [
            'totalMembers' => $totalMembers,
            'pendingRequests' => $pendingRequests,
            'clubMembers' => $clubMembers,
            'request'=> $request,
            'membersByNiveau' => $membersByNiveau,
            'membersByDepartment' => $membersByDepartment
        ]);
    }
    public function addUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validate password
            if (empty($password)) {
                $_SESSION['errorMessage'] = 'Password cannot be empty.';
                header('Location: /president/addUser');
                exit();
            }
            
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            // Default values for role and clubId
            $role = 'member';
            $clubId = 1;

            // Call model to add user
            $userAdded = $this->userModel->addUser($firstName, $lastName, $email, $hashedPassword, $role, $clubId);

            if ($userAdded) {
                $_SESSION['successMessage'] = 'User added successfully!';
            } else {
                $_SESSION['errorMessage'] = 'Failed to add user.';
            }

            // Redirect to the president dashboard
            header('Location: /president');
            exit();
        }

        // Render the add user form view if not a POST request
        return $this->view('President/addUser');
    }
    public function updateUser($id)
    {
        // Ensure that the userId is valid and numeric
        if (empty($id) || !is_numeric($id)) {
            $_SESSION['errorMessage'] = 'Invalid user ID.';
            header('Location: /president');
            exit();
        }
    
        // If the request method is POST, proceed with updating the user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
    
            // Determine if a new password was provided
            if (!empty($_POST['password'])) {
                // Hash the new password before saving it
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            } else {
                // Keep the existing password if no new password is provided
                $user = $this->userModel->getUserById($id);
                if (is_array($user)) {
                    $password = $user['password'];  // Retain the existing password
                } else {
                    $_SESSION['errorMessage'] = 'Failed to retrieve user data.';
                    header('Location: /president');
                    exit();
                }
            }
    
            // Call the model to update the user
            $userUpdated = $this->userModel->updateUser($id, $firstName, $lastName, $email, $password);
    
            if ($userUpdated) {
                $_SESSION['successMessage'] = 'User updated successfully!';
            } else {
                $_SESSION['errorMessage'] = 'Failed to update user.';
            }
    
            // Redirect to the president dashboard
            header('Location: /president');
            exit();
        }
    
        // For GET requests, retrieve user details to pre-fill the form
        $user = $this->userModel->getUserById($id);
        if ($user) {
            return $this->view('President/updateUser', ['user' => $user]);
        } else {
            $_SESSION['errorMessage'] = 'User not found.';
            header('Location: /president');
            exit();
        }
    }
    

    public function deleteUser($id) {
        // Ensure that the id is valid before proceeding
        if (empty($id) || !is_numeric($id)) {
            $_SESSION['errorMessage'] = 'Invalid user ID.';
            header('Location: /president');
            exit();
        }

        // Call the model's delete function with the user ID
        $userDeleted = $this->userModel->deleteUser($id);

        // Set the appropriate session message based on whether the deletion was successful
        if ($userDeleted) {
            $_SESSION['successMessage'] = 'User deleted successfully!';
        } else {
            $_SESSION['errorMessage'] = 'Failed to delete user.';
        }

        // Redirect to the president dashboard
        header('Location: /president');
        exit();
    }

    public function rejectRequest($id) {
        // Validate the ID
        $requestId = filter_var($id, FILTER_VALIDATE_INT);
        if ($requestId === false || $requestId <= 0) {
            $_SESSION['errorMessage'] = 'Invalid request ID.';
            header('Location: /president');
            exit();
        }

        try {
            // Call the model to reject the request
            $requestRejected = $this->requestModel->rejectRequest($requestId);

            if ($requestRejected) {
                $_SESSION['successMessage'] = 'Request rejected successfully!';
            } else {
                $_SESSION['errorMessage'] = 'Failed to reject request. The request may not exist.';
            }
        } catch (Exception $e) {
            $_SESSION['errorMessage'] = 'Error: ' . $e->getMessage();
        }

        // Redirect to the president dashboard
        header('Location: /president');
        exit();
    }

    public function acceptRequest($id) {
        // Validate the request ID
        $requestId = filter_var($id, FILTER_VALIDATE_INT);
        if (!$requestId || $requestId <= 0) {
            $_SESSION['errorMessage'] = 'Invalid request ID.';
            header('Location: /president');
            exit();
        }

        // Fetch request details
        $request = $this->requestModel->getRequestById($requestId);
        if (!$request) {
            $_SESSION['errorMessage'] = 'Request not found.';
            header('Location: /president');
            exit();
        }

        // Generate password and hash it
        $plainPassword = $this->userModel->generatePassword();
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

        // Prepare user data
        $userData = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => $hashedPassword,
            'phone' => $request['phone'],
            'photo_path' => $request['photo_path'],
            'niveau' => $request['niveau'],
            'specialite' => $request['specialite'],
            'department' => $request['department'],
            'club_id' => $request['club_id']
        ];

        // Insert into users table
        if ($this->userModel->creatUser($userData)) {
            // Delete request from requests table
            $this->requestModel->rejectRequest($requestId);

            // Send an email with login credentials
            if ($this->sendAcceptanceEmail($request['email'], $request['first_name'], $plainPassword)) {
                $_SESSION['successMessage'] = 'User accepted and email sent successfully!';
            } else {
                $_SESSION['errorMessage'] = 'User accepted, but failed to send email.';
            }
        } else {
            $_SESSION['errorMessage'] = 'Failed to add user.';
        }

        // Redirect to the president dashboard
        header('Location: /president');
        exit();
    }

    private function sendAcceptanceEmail($email, $name, $password) {
        $subject = "Welcome to the Club!";
        $message = "
            <html>
            <head>
                <title>Welcome to the Club!</title>
            </head>
            <body>
                <h2>Dear $name,</h2>
                <p>Congratulations! Your membership request has been accepted.</p>
                <p>Here are your login details:</p>
                <ul>
                    <li><strong>Email:</strong> $email</li>
                    <li><strong>Password:</strong> $password</li>
                </ul>
                <p>Please log in and change your password as soon as possible.</p>
                <p>Best regards,</p>
                <p>The Club Team</p>
            </body>
            </html>
        ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1" . "\r\n";
        $headers .= "From: club@example.com" . "\r\n";

        return mail($email, $subject, $message, $headers);
    }
}
?>
