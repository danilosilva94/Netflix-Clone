<?php
    require_once("includes/header.php");

    //Check if the id is set
    if(!isset($_GET["id"])) {
        ErrorMessage::show("No id passed into page");
    }

    //Get the id
    $entityId = $_GET["id"];

    //Create a new Entity
    $entity = new Entity($con, $entityId);

    //Create a PreviewProvider object
    $preview = new PreviewProvider($con, $userLoggedIn);
    echo $preview->createPreviewVideo($entity);

    //Show seasons
    $seasonProvider = new SeasonProvider($con, $userLoggedIn);
    echo $seasonProvider->create($entity);

    //Show categories
    $categoryContainers = new CategoryContainers($con, $userLoggedIn);
    echo $categoryContainers->showCategory($entity->getCategoryId(), "You Might Also Like");
?>