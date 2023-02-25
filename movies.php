<?php
    require_once("includes/header.php");

    //Create preview
    $preview = new PreviewProvider($con, $userLoggedIn);
    echo $preview->crateMoviesPreviewVideo();

    //Create categories
    $containers = new CategoryContainers($con, $userLoggedIn);
    echo $containers->showMoviesCategories();
?>