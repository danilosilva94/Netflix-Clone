<?php
require_once("includes/config.php");
require_once("includes/classes/PreviewProvider.php");
require_once("includes/classes/CategoryContainers.php");
require_once("includes/classes/Entity.php");
require_once("includes/classes/EntityProvider.php");
require_once("includes/classes/ErrorMessage.php");
require_once("includes/classes/SeasonProvider.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/Season.php");
require_once("includes/classes/VideoProvider.php");
require_once("includes/classes/User.php");

//Check if user is logged in
if (!isset($_SESSION['userLoggedIn'])) {
    header("Location: register.php");
}

//Set user logged in
$userLoggedIn = $_SESSION['userLoggedIn'];
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to Movies</title>
        <link rel="stylesheet" href="assets/style/style.css">
        <script src="https://kit.fontawesome.com/06a651c8da.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
        <script src="assets/js/script.js"></script>
    </head>

    <body>
        <div class="wrapper">
        
        <?php
            //Check if nav bar must be hidden
            if (!isset($hideNav)) {
                //Include nav bar
                include_once("includes/navBar.php");
            }
        ?>

        