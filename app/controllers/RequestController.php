<?php 
require_once 'app/core/Controller.php';
require_once 'app/models/UserModel.php';
require_once 'app/config/config.php';
require_once 'app/core/View.php';
class RequestController extends Controller {    
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function login()
    {
        // Afficher la vue AdminView
        $this->view('AdminView', []);
    }
}
?>