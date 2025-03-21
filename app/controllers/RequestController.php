<?php
require_once CORE . 'Controller.php';
require_once MODELS . 'RequestModel.php';

class RequestController extends Controller
{
    protected $db;  // Instance de la base de données
    protected $requestModel;

    public function __construct()
    {
        
        $dbInstance = new Db();
        $this->db = $dbInstance->connect();
        $this->requestModel = new RequestModel();
    }

    public function registre($club_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $data = [
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone_number'] ?? '',
                'facebook_url' => $_POST['facebook_url'] ?? '',
                'niveau' => $_POST['niveau'] ?? '',
                'specialite' => $_POST['specialite'] ?? '',
                'club_experience' => $_POST['club_experience'] ?? '',
                'previous_club' => $_POST['club_details'] ?? '',
                'department' => $_POST['departement'] ?? '',
                'motivation' => $_POST['motivation'] ?? '',
                'interview_availability' => $_POST['entretien_jour'] ?? '',
                'cv_path' => $_POST['cv'],
                'club_id' => $club_id
            ];

            // Gestion du téléchargement des fichiers
            if (!empty($_FILES['cv']['tmp_name'])) {
                move_uploaded_file($_FILES['cv']['tmp_name'], UPLOADS . $_FILES['cv']['name']);
            }

            if (!empty($_FILES['photo']['tmp_name'])) {
                move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS . $_FILES['photo']['name']);
            }

            // Insérer la demande dans la base de données
            $insertedId = $this->requestModel->insertRequest($data);
            
            if ($insertedId) {
                header("Location: " . BURL);
            } else {
                header("Location: " . BURL);
            }
        } else {
            header("Location: " . BURL);
        }
    }

}
?>