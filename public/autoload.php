<?php
/**
 * Bootstrap file for initializing the application.
 * This script sets up directory constants, includes necessary configuration files,
 * registers an autoloader for classes, and initializes the application.
 */

// Define directory separator
define("DS", DIRECTORY_SEPARATOR);

// Define root path (one level up from the current directory)
define("ROOT_PATH", dirname(__DIR__) . DS);

// Define application paths
define("APP", ROOT_PATH . 'app' . DS); // Path to the 'app' directory
define("CORE", APP . 'core' . DS); // Path to the 'core' directory inside 'app'
define("CONFIG", APP . 'config' . DS); // Path to the 'config' directory inside 'app'
define("CONTROLLERS", APP . 'controllers' . DS); // Path to the 'controllers' directory inside 'app'
define("MODELS", APP . 'models' . DS); // Path to the 'models' directory inside 'app'
define("VIEWS", APP . 'views' . DS); // Path to the 'views' directory inside 'app'
define("UPLOADS", ROOT_PATH . 'public' . DS . 'uploads' . DS); // Path to the 'uploads' directory inside 'public'

// Include configuration files
if (file_exists(CONFIG . 'config.php')) {
    require_once(CONFIG . 'config.php'); // Include the main configuration file
} else {
    die("Error: config.php file not found in " . CONFIG); // Terminate if the config file is missing
}

if (file_exists(CORE . 'App.php')) {
    require_once(CORE . 'App.php'); // Include the core App class
} else {
    die("Error: App.php file not found in " . CORE); // Terminate if the App class file is missing
}

// Autoload all classes
$modules = [ROOT_PATH, APP, CORE, VIEWS, CONTROLLERS, MODELS, CONFIG]; // Directories to search for classes
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules)); // Add directories to the include path

// Register autoload function
spl_autoload_register(function ($class) {
    // Loop through each directory in the include path
    foreach (explode(PATH_SEPARATOR, get_include_path()) as $path) {
        // Construct the full path to the class file
        $file = $path . DS . $class . '.php';
        // Check if the class file exists
        if (file_exists($file)) {
            require_once($file); // Include the class file
            return; // Stop searching once the class is found
        }
    }
    // If the class file is not found, terminate with an error message
    die("Error: Class '$class' not found.");
});

// Initialize the application
new App(); // Create an instance of the App class to start the application
?>