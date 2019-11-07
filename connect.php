<?php
    define('DB_DSN','mysql:host=localhost:3306;dbname=webdevproject');
    define('DB_USER','id11413473_bjadmin');
    define('DB_PASS','ZIBA6fFyjDTn&3uiCk2#');     
    	
    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); // Force execution to stop on errors.
    }
?>