<?php
    //Include header
    include("includes/header.php");

    //Create new preview provider object
    $previewProvider = new PreviewProvider($con, $userLoggedIn);

    $previewProvider->createPreviewVideo(null);
?>