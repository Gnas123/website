<?php
    require __DIR__ . '/vendor/autoload.php';
   
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    // Load the environment variables from the .env file
    $dotenv->load();
    // connect to database
    $svname = $_ENV['DB_HOSTNAME']; 
    $user_svname = $_ENV['DB_USERNAME'];
    $sv_password = $_ENV['DB_PASSWORD'];
    $sv_dbname = $_ENV['DB_DATABASE'];

    // Create connection
    $conn = new mysqli($svname, $user_svname, $sv_password, $sv_dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>