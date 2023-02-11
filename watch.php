<?php
    require_once("includes/header.php");

    //Show error if no id is passed
    if(!isset($_GET["id"])) {
        ErrorMessage::show("No id passed to page");
    }

    //Create video object
    $video = new Video($con, $_GET["id"]);

    //Increment views
    $video->incrementViews();
?>

<!-- Video player -->
<div class="watchContainer">

    <!-- Video player controls -->
    <div class="videoControls watchNav">
        <button onclick="goBack()"><i class="fas fa-arrow-left"></i></button>
        <h1><?php echo $video->getTitle(); ?></h1>
    </div>

    <video controls autoplay>
        <source src="<?php echo $video->getFilePath(); ?>" type="video/mp4">
    </video>
</div>

<script>
    //Start video
    initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn; ?>");
</script>