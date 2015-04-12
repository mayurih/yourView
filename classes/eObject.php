<?php

/*
 * Developed for Department of Educational Technology - Saarland University
 * http://edutech.uni-saarland.de/
 */

/**
 * Description of eObject
 *
 * @author Thomas Mang <thomas.mang@mx.uni-saarland.de>
 */
class eObject {

    private static      $configuration;
    private static      $db;
    private static      $fb;

    /*
     * Constructor
     */
    protected function __construct($config = NULL) {
        
        if(isset($config)) {
            $this->setConfig($config);
        }
        $this->config = $this->getConfig();
        
        // $this->config = parse_ini_file($this->configuration_file, TRUE);
        
        // Debug Loop
        foreach ($this->config->debug AS $key=>$value) {
            if($value) {
                $debug_func = "print_" . $key;
                $this->$debug_func();
            }
        }

    }
    


    /*
     * Log Function
     */
    protected function log($log_text) {
        // log to file
        $today = date("Ymd");
        $file = fopen("." . $this->config->folders['log'] . "/" . $today . ".log", "a+");
        fwrite($file, (filesize("." . $this->config->folders['log'] . "/" . $today . ".log")) ? (utf8_encode(date("H:i:s") . ": " . $log_text . "\r\n")) : ("\xEF\xBB\xBF" . utf8_encode(date("H:i:s") . ": " . $log_text . "\r\n"))); 
        fclose($file);
        
        // log to database
        $stmt = $this->getDb()->prepare("INSERT INTO log (text) VALUES (:log_text)");
        $stmt->execute(array(':log_text'=>$log_text));
    }
    
    /*
     * Main Debug Function
     */
    protected function debug($debug) {
        
        $debug_text = print_r($debug, true);
        
        // log to file
        $file = fopen("." . $this->config->folders['debug'] . "/debug.log", "a+");
        fwrite($file, (filesize("." . $this->config->folders['debug'] . "/debug.log")) ? (utf8_encode(date("Y.m.d-H:i:s") . " : " . get_class($this) . "\n" . $debug_text . "\n")) : ("\xEF\xBB\xBF" . utf8_encode(date("Y.m.d-H:i:s") . ": " . $debug_text . "\n"))); 
        fclose($file);
        
        // log to database
        $stmt = $this->getDb()->prepare("INSERT INTO debug (class, text) VALUES (:class, :debug_text)");
        $stmt->execute(array(':class'=>get_class($this), ':debug_text'=>$debug_text));        
    }
    
    /*
     * Specialized Debug Functions
     */
    protected function print_get() {
        $this->debug("GET: " . print_r($_GET, true));
        //$this->debuginformations->get = print_r($_GET, true);
    }
    protected function print_post() {
        $this->debug("POST: " . print_r($_POST, true));
        //$this->debuginformations->post = print_r($_POST, true);
    }
    protected function print_session() {
        $this->debug("SESSION: " . print_r($_SESSION, true));
        //$this->debuginformations->session = print_r($_SESSION, true);
    }
    protected function print_files() {
        $this->debug("FILES: " . print_r($_FILES, true));
        //$this->debuginformations->files = print_r($_FILES, true);
    }
    protected function print_cookie() {
        $this->debug("COOKIE: " . print_r($_COOKIE, true));
        //$this->debuginformations->cookie = print_r($_COOKIE, true);
    }
    protected function print_server() {
        $this->debug("SERVER: " . print_r($_SERVER, true));
        //$this->debuginformations->server = print_r($_SERVER, true);
    }
    protected function print_headers() {
        $this->debug("HEADERS: " . print_r(getallheaders(), true));
        //$this->debuginformations->headers = print_r(getallheaders(), true);
    }  

    /**
     * Get the configuration Array
     * @return array
     */
    protected function getConfig() {
        return self::$configuration;
    }
    /**
     * Set the configuration Array
     */
    protected function setConfig($config) {
        self::$configuration = $config;
    }        
    
    /**
     * Constructs a PDO Object and returns it
     * @return PDO connection to the database
     */
    protected function getDB() {
        if(self::$db === NULL) {
            self::$db = new PDO(
                "mysql:host=".$this->config->database['host'].";".
                "dbname=".$this->config->database['database'].";".
                "port=".$this->config->database['port'], 
                $this->config->database['user'], 
                $this->config->database['password'], 
                array( 
                    PDO::ATTR_PERSISTENT => true, 
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                ) 
            );
        }
        return self::$db;
    }
    
    /**
     * Constructs a Facebook Object and returns it
     * @return Facebook connection to the database
     */
    protected function getFB() {
        if(self::$fb === NULL) {
            self::$fb = new Facebook(array(
                'appId'     => $this->config->facebook['appid'],
                'secret'    => $this->config->facebook['appsecret'],
                'cookie'    => $this->config->facebook['cookie']
            ));
        }
        return self::$fb;
    }    
}

?>
