<?php
    //Turn on output buffering
    ob_start();

    //Start session
    session_start();

    //Set timezone
    date_default_timezone_set("Europe/Dublin");

    //Attempt to connect to database
    try{
        $con = new PDO("mysql:dbname=netflix;host=localhost", "root", "");
        //Enable error reporting on the connection
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }catch(PDOException $e){
        exit("Connection failed: " . $e->getMessage());
    }
?>