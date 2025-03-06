<?php
/**
 * App Class
 * 
 * This class is responsible for handling incoming requests, parsing the URL,
 * and invoking the appropriate controller and method based on the URL.
 */

require_once(CORE . 'View.php'); // Include the View class

class App
{
    // Default controller name
    protected $controller = "HomeController";
    // Default method name
    protected $action = "index";
    // Parameters passed to the method
    protected $params = [];

    /**
     * Constructor
     * 
     * Initializes the App class, prepares the URL, and renders the appropriate controller and method.
     */
    public function __construct()
    {
        $this->prepareURL($_SERVER['REQUEST_URI']); // Parse the URL
        $this->render(); // Invoke the controller and method
    }

    /**
     * Prepare URL
     * 
     * Extracts the controller, method, and parameters from the URL.
     * 
     * @param string $url The request URL
     */
    private function prepareURL($url)
    {
        $url = trim($url, "/"); // Remove leading and trailing slashes
        if (!empty($url)) {
            $url = explode('/', $url); // Split the URL into parts

            // Define the controller based on the first part of the URL
            $this->controller = isset($url[0]) ? ucwords($url[0]) . "Controller" : "HomeController";

            // Define the method based on the second part of the URL
            $this->action = isset($url[1]) ? $url[1] : "index";

            // Define parameters (remaining parts of the URL)
            unset($url[0], $url[1]); // Remove controller and method from the array
            $this->params = !empty($url) ? array_values($url) : []; // Reindex the array and assign to params
        }
    }

    /**
     * Render
     * 
     * Instantiates the controller, checks if the method exists, and invokes it with the parameters.
     * If the controller or method does not exist, it renders an error view.
     */
    private function render()
    {
        // Check if the controller class exists
        if (class_exists($this->controller)) {
            $controller = new $this->controller; // Instantiate the controller

            // Check if the method exists in the controller
            if (method_exists($controller, $this->action)) {
                // Invoke the method with the parameters
                call_user_func_array([$controller, $this->action], $this->params);
            } else {
                // Method does not exist, render an error view
                new View('error', ['message' => "Method '" . $this->action . "' does not exist in controller '" . $this->controller . "'."]);
            }
        } else {
            // Controller class does not exist, render an error view
            new View('error', ['message' => "Controller class '" . $this->controller . "' not found."]);
        }
    }
}
?>