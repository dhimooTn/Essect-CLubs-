<?php 
require_once CORE . 'View.php';
class Controller 
{

    
    protected $view;

    protected function view($template,$params=[])
    {
        $this->view = new View($template,$params);
        return $this->view;
    }
}
?>