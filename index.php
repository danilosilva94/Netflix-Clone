<?php
    //Include header
    include("includes/header.php");

    //Create new preview provider object
    $previewProvider = new PreviewProvider($con, $userLoggedIn);
    echo $previewProvider->createPreviewVideo(null);

    //Show all categories
    $containers = new CategoryContainers($con, $userLoggedIn);
    echo $containers->showAllCategories();
?>