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
    
}
?>
