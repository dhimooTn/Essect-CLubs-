<?php 


require_once 'C:\xampp\htdocs\Project Ds1\Essect-Clubs-Website\app\core\Controller.php';
class HomeController extends Controller
{
    public function index()
    {
        
        $this->view('HomeView',[]);
    }
    public function login()
    {
        // Afficher la vue AdminView
        $this->view('AdminView', []);
    }
}

?>