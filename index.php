<?php
    require_once("includes/config.php");
    require_once("includes/classes/PreviewProvider.php");
    require_once("includes/classes/Entity.php");

    //Check if user is logged in
    if(!isset($_SESSION['userLoggedIn'])){
        header("Location: register.php");
    }

    //Set user logged in
    $userLoggedIn = $_SESSION['userLoggedIn'];

    //Create new preview provider object
    $previewProvider = new PreviewProvider($con, $userLoggedIn);

    $previewProvider->createPreviewVideo(null);
?>