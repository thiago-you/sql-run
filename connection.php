<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    
    try {
        // create connection with DB
        $connection = new PDO("mysql:host={$servername}; dbname={$database_log}", $username, $password);
        // set the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die("Connection failed: {$e->getMessage()}");
    }
?>