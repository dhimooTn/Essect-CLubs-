<?php
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\Project Ds1\vendor\phpmailer\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\Project Ds1\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\Project Ds1\vendor\phpmailer\phpmailer\src\SMTP.php';



      // Update with the correct path

require_once CORE . 'Controller.php';
require_once MODELS . 'UserModel.php';
require_once MODELS . 'RequestModel.php';
require_once MODELS . 'EventModel.php';
require_once CONFIG . 'config.php';
require_once CORE . 'View.php';

class PresidentController extends Controller
{
    private $userModel;
    private $requestModel;
    private $eventModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->requestModel = new RequestModel();
        $this->eventModel = new EventModel();
    }

    public function index($id = 1)
    {
        if (!is_numeric($id)) {
            $_SESSION['errorMessage'] = 'Invalid club ID.';
            header('Location: /president');
            exit();
        }

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
            'request' => $request,
            'membersByNiveau' => $membersByNiveau,
            'membersByDepartment' => $membersByDepartment
        ]);
    }

    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = htmlspecialchars($_POST['first_name']);
            $lastName = htmlspecialchars($_POST['last_name']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if (empty($password)) {
                $_SESSION['errorMessage'] = 'Password cannot be empty.';
                header('Location: /president/addUser');
                exit();
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $role = 'member';
            $clubId = 1;

            $userAdded = $this->userModel->addUser($firstName, $lastName, $email, $hashedPassword, $role, $clubId);

            if ($userAdded) {
                $_SESSION['successMessage'] = 'User added successfully!';
            } else {
                $_SESSION['errorMessage'] = 'Failed to add user.';
            }

            header('Location: /president');
            exit();
        }

        return $this->view('President/addUser');
    }

    public function updateUser($id)
    {
        if (empty($id) || !is_numeric($id)) {
            $_SESSION['errorMessage'] = 'Invalid user ID.';
            header('Location: /president');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = htmlspecialchars($_POST['first_name']);
            $lastName = htmlspecialchars($_POST['last_name']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            } else {
                $user = $this->userModel->getUserById($id);
                if (is_array($user)) {
                    $password = $user['password'];
                } else {
                    $_SESSION['errorMessage'] = 'Failed to retrieve user data.';
                    header('Location: /president');
                    exit();
                }
            }

            $userUpdated = $this->userModel->updateUser($id, $firstName, $lastName, $email, $password);

            if ($userUpdated) {
                $_SESSION['successMessage'] = 'User updated successfully!';
            } else {
                $_SESSION['errorMessage'] = 'Failed to update user.';
            }

            header('Location: /president');
            exit();
        }

        $user = $this->userModel->getUserById($id);
        if ($user) {
            return $this->view('President/updateUser', ['user' => $user]);
        } else {
            $_SESSION['errorMessage'] = 'User not found.';
            header('Location: /president');
            exit();
        }
    }

    public function deleteUser($id)
    {
        if (empty($id) || !is_numeric($id)) {
            $_SESSION['errorMessage'] = 'Invalid user ID.';
            header('Location: /president');
            exit();
        }

        $userDeleted = $this->userModel->deleteUser($id);

        if ($userDeleted) {
            $_SESSION['successMessage'] = 'User deleted successfully!';
        } else {
            $_SESSION['errorMessage'] = 'Failed to delete user.';
        }

        header('Location: /president');
        exit();
    }

    public function rejectRequest($id)
    {
        $requestId = filter_var($id, FILTER_VALIDATE_INT);
        if ($requestId === false || $requestId <= 0) {
            $_SESSION['errorMessage'] = 'Invalid request ID.';
            header('Location: /president');
            exit();
        }

        try {
            $requestRejected = $this->requestModel->rejectRequest($requestId);

            if ($requestRejected) {
                $_SESSION['successMessage'] = 'Request rejected successfully!';
            } else {
                $_SESSION['errorMessage'] = 'Failed to reject request. The request may not exist.';
            }
        } catch (Exception $e) {
            $_SESSION['errorMessage'] = 'Error: ' . $e->getMessage();
        }

        header('Location: /president');
        exit();
    }

    public function acceptRequest($id)
    {
        $requestId = filter_var($id, FILTER_VALIDATE_INT);
        if (!$requestId || $requestId <= 0) {
            $_SESSION['errorMessage'] = 'Invalid request ID.';
            header('Location: /president');
            exit();
        }

        $request = $this->requestModel->getRequestById($requestId);
        if (!$request) {
            $_SESSION['errorMessage'] = 'Request not found.';
            header('Location: /president');
            exit();
        }

        $plainPassword = $this->userModel->generatePassword();
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

        $userData = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => $hashedPassword,
            'phone' => $request['phone'],
            'niveau' => $request['niveau'],
            'specialite' => $request['specialite'],
            'department' => $request['department'],
            'club_id' => $request['club_id']
        ];

        if ($this->userModel->creatUser($userData)) {
            $this->requestModel->rejectRequest($requestId);

            if ($this->sendAcceptanceEmail($request['email'], $request['first_name'], $plainPassword)) {
                $_SESSION['successMessage'] = 'User accepted and email sent successfully!';
            } else {
                $_SESSION['errorMessage'] = 'User accepted, but failed to send email.';
            }
        } else {
            $_SESSION['errorMessage'] = 'Failed to add user.';
        }

        header('Location: /president');
        exit();
    }

    private function sendAcceptanceEmail($email, $name, $password)
    {
        $mail = new PHPMailer(true);
    
        try {
            // Configuration SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'email@gmail.com'; // Remplace avec ton e-mail
            $mail->Password = '********'; // Remplace par un mot de passe d'application Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 465;
    
            // Configuration du mail
            $mail->setFrom('boukhdhirdhia@gmail.com', 'Club Team');
            $mail->addAddress($email, $name);
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = 'Bienvenue au Club !';
    
            // Contenu HTML + texte brut
            $mail->Body = "
                <html>
                <head>
                    <title>Bienvenue au Club !</title>
                </head>
                <body>
                    <h2>Bonjour $name,</h2>
                    <p>Félicitations ! Votre demande d'adhésion a été acceptée.</p>
                    <p>Voici vos identifiants :</p>
                    <ul>
                        <li><strong>Email :</strong> $email</li>
                        <li><strong>Mot de passe :</strong> $password</li>
                    </ul>
                    <p>Merci de vous connecter et de changer votre mot de passe dès que possible.</p>
                    <p>Cordialement,</p>
                    <p>L'équipe du Club</p>
                </body>
                </html>
            ";
            $mail->AltBody = "Bonjour $name,\n\nVotre demande d'adhésion a été acceptée.\n\nIdentifiants :\nEmail: $email\nMot de passe: $password\n\nMerci de vous connecter et de changer votre mot de passe.\n\nL'équipe du Club.";
    
            // Envoi du mail
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Erreur d'envoi d'email : " . $mail->ErrorInfo);
            return false;
        }
    }
    

    public function addEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['title'], $_POST['description'], $_POST['date'], $_POST['location'])) {
                $title = htmlspecialchars($_POST['title']);
                $description = htmlspecialchars($_POST['description']);
                $date = htmlspecialchars($_POST['date']);
                $location = htmlspecialchars($_POST['location']);
                $club_id = $_SESSION['club_id'] ?? null;

                if ($club_id) {
                    $event_id = $this->eventModel->addEvent($title, $description, $date, $location, $club_id);
                    $_SESSION[$event_id ? 'successMessage' : 'errorMessage'] = $event_id ? 'Event added successfully!' : 'Failed to add event.';
                }
            }
        }
        header('Location: /president');
        exit();
    }

    public function events()
    {
        $club_id = $_SESSION['club_id'] ?? null;
        if ($club_id) {
            $events = $this->eventModel->getEvents($club_id);
            include 'app/views/president/events.php';
        } else {
            $_SESSION['errorMessage'] = 'Club ID not found in session.';
            header("Location: /president");
            exit();
        }
    }

    public function deleteEvent($event_id)
    {
        if (is_numeric($event_id)) {
            $this->eventModel->deleteEvent($event_id);
        }
        header('Location: /president');
        exit();
    }
}
?>