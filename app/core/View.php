<?php
/**
 * View Class
 * 
 * This class is responsible for rendering views and passing data to them.
 * It extracts data into variables, includes the view file, and outputs the rendered content.
 */

class View
{
    /**
     * @var string $view_file The name of the view file to render.
     */
    protected $view_file;

    /**
     * @var array $view_data The data to be passed to the view file.
     */
    protected $view_data;

    /**
     * Constructor
     * 
     * Initializes the View class with the view file and data.
     * 
     * @param string $view The name of the view file (without the .php extension).
     * @param array $data The data to be passed to the view file (optional).
     */
    public function __construct($view, $data = [])
    {
        $this->view_file = $view; // Set the view file name
        $this->view_data = $data; // Set the data to be passed to the view
        $this->render(); // Render the view
    }

    /**
     * Render
     * 
     * Renders the view file by extracting the data into variables and including the file.
     * If the view file does not exist, it outputs an error message.
     */
    private function render()
    {
        // Construct the full path to the view file
        $file = VIEWS . $this->view_file . '.php';

        // Check if the view file exists
        if (file_exists($file)) {
            // Start output buffering
            ob_start();

            // Extract the data array into variables
            extract($this->view_data);

            // Include the view file
            require_once($file);

            // Output the buffered content and end buffering
            ob_end_flush();
        } else {
            // If the view file does not exist, output an error message
            echo "This file: " . $this->view_file . " does not exist.";
        }
    }
}
?>