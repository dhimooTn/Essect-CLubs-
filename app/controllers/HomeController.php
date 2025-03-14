<?php 


require_once 'C:\xampp\htdocs\Project Ds1\app\core\Controller.php';
class HomeController extends Controller
{
    public function index()
    {
        
        $this->view('HomeView',[]);
    }

}

?>