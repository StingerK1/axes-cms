<?php
    /*
        Name: April Donne Pecson
        Project - A(xes) CMS Application (connect.php) 
        Connects to the a(xes) database.
    */

    define('DB_DSN','mysql:host=localhost;dbname=a(xes);charset=utf8');
    define('DB_USER','april');
    define('DB_PASS','password123');  
    
    try {
        // To create new PDO connection to MySQL.
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
        
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
    
?>