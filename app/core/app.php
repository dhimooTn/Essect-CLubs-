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
            // Supprimer les barres obliques de début et de fin
            $url = trim($url, "/");
        
            if (!empty($url)) {
                // Diviser l'URL en segments
                $url = explode('/', $url);
        
                // Ignorer les segments inutiles (exemple : "dashboard", "Essect-Clubs-Website-dhia-feature", "public")
                // Vous pouvez ajuster cette logique en fonction de votre structure d'URL
                $relevantSegments = array_slice($url, 3); // Ignorer les 3 premiers segments
        
                // Définir le contrôleur (premier segment pertinent)
                $this->controller = isset($relevantSegments[0]) ? ucwords($relevantSegments[0]) . "Controller" : "HomeController";
        
                // Définir l'action (deuxième segment pertinent)
                $this->action = isset($relevantSegments[1]) ? $relevantSegments[1] : "index";
        
                // Définir les paramètres (segments restants)
                unset($relevantSegments[0], $relevantSegments[1]); // Supprimer le contrôleur et l'action du tableau
                $this->params = !empty($relevantSegments) ? array_values($relevantSegments) : []; // Réindexer et assigner les paramètres
            } else {
                // Si l'URL est vide, utiliser les valeurs par défaut
                $this->controller = "HomeController";
                $this->action = "index";
                $this->params = [];
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