<?php
    require_once("includes/config.php");

    //Check if user is logged in
    if(!isset($_SESSION['userLoggedIn'])){
        header("Location: register.php");
    }
?>