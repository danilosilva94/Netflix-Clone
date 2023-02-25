<?php
    require_once("includes/header.php");

    //Check if id is set
    if(!isset($_GET["id"])) {
        //Show error message
        ErrorMessage::show("No id passed into page");
    }

    //Create preview
    $preview = new PreviewProvider($con, $userLoggedIn);
    echo $preview->createCategoryPreviewVideo($_GET["id"]);

    //Create categories
    $containers = new CategoryContainers($con, $userLoggedIn);
    echo $containers->showCategory($_GET["id"]);
?>