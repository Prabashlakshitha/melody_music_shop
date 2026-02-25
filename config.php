<?php
//database configuration
define('DB_HOST', 'localhost:3307');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'melody');

//busines rules
define('shipping_cost', 5.99);
define('shipping_cost_threshold', 100);

//database connection
function db_connect(){
    static $conn=null;
    if($conn === null){
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }
        
    }
    return $conn;
}

//start session

if(session_status() == PHP_SESSION_NONE){
    session_start();
}