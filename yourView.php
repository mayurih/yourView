<?php
/*
 * Developed for Department of Educational Technology - Saarland University
 * http://edutech.uni-saarland.de/
 * 
 */

/**
 * Error Reporting off
 */
ini_set("display_errors", FALSE);
// error_reporting(E_ALL ^ E_NOTICE);

/*
 * Start session
 */
session_start();

/*
 * Autoloader Section
 */
// Loader for the Facebook classes
function facebook_loader($class) {
    include_once 'facebook/' . $class . '.php';
}
// Loader for other classes
function class_loader($class) {
    include_once 'classes/' . $class . '.php';
}
// register autoloaders
spl_autoload_register('facebook_loader');
spl_autoload_register('class_loader');


/*
 * Initialize Routing object with $config
 */

$config = (object)parse_ini_file('configuration.ini', TRUE);


try {
    $app = new app($config);
    $app->output();    
} catch (Exception $ex) {
    echo "<pre>";
    var_dump($ex);
    var_dump($GLOBALS);
    echo "</pre>";
}

      
?>
