<?php
require_once '../app/models/RequestModel.php'; // Inclure la classe RequestModel

class RequestController
{
    private $requestModel;

    public function __construct()
    {
        $this->requestModel = new RequestModel();
    }

    public function createRequest($data)
    {
        // Validation des champs obligatoires
        $requiredFields = ['first_name', 'last_name', 'email', 'phone', 'facebook_url', 'niveau', 'specialite', 'club_experience', 'previous_club', 'department', 'motivation', 'interview_availability', 'cv_path', 'photo_path'];
        
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("Le champ $field est obligatoire.");
            }
        }

        // Validation de l'email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("L'email n'est pas valide.");
        }

        // Validation du numéro de téléphone (exemple simple)
        if (!preg_match("/^[0-9]{10}$/", $data['phone'])) {
            throw new Exception("Le numéro de téléphone n'est pas valide.");
        }

        // Déterminer le club_id en fonction du département
        $clubId = $this->determineClubId($data['department']);

        // Préparer les données pour la création de la requête
        $requestData = [
            'first_name' => htmlspecialchars($data['first_name']),
            'last_name' => htmlspecialchars($data['last_name']),
            'email' => htmlspecialchars($data['email']),
            'phone' => htmlspecialchars($data['phone']),
            'facebook_url' => htmlspecialchars($data['facebook_url']),
            'niveau' => htmlspecialchars($data['niveau']),
            'specialite' => htmlspecialchars($data['specialite']),
            'club_experience' => htmlspecialchars($data['club_experience']),
            'previous_club' => htmlspecialchars($data['previous_club']),
            'department' => htmlspecialchars($data['department']),
            'motivation' => htmlspecialchars($data['motivation']),
            'interview_availability' => htmlspecialchars($data['interview_availability']),
            'cv_path' => htmlspecialchars($data['cv_path']),
            'photo_path' => htmlspecialchars($data['photo_path']),
            'club_id' => $clubId
        ];

        // Créer la requête
        $this->requestModel->createRequest($requestData);
    }

    private function determineClubId($department)
    {
        $clubId = 1; // Valeur par défaut

        if (in_array($department, ['Relations externes', 'Projet', 'Comm'])) {
            $clubId = 2;
        } elseif (in_array($department, ['Marketing', 'Design', 'Diffusion', 'Finance'])) {
            $clubId = 3;
        }

        return $clubId;
    }
}

// Traitement de la requête
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $requestController = new RequestController();

        // Récupérer et nettoyer les données POST
        $data = [
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'facebook_url' => $_POST['facebook_url'] ?? '',
            'niveau' => $_POST['niveau'] ?? '',
            'specialite' => $_POST['specialite'] ?? '',
            'club_experience' => $_POST['club_experience'] ?? '',
            'previous_club' => $_POST['previous_club'] ?? '',
            'department' => $_POST['department'] ?? '',
            'motivation' => $_POST['motivation'] ?? '',
            'interview_availability' => $_POST['interview_availability'] ?? '',
            'cv_path' => $_POST['cv_path'] ?? '',
            'photo_path' => $_POST['photo_path'] ?? ''
        ];

        $requestController->createRequest($data);
        echo "La demande a été créée avec succès.";
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Méthode non autorisée.";
}
?>