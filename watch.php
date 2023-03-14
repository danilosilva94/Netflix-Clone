<?php
    //Set hide nav bar
    $hideNav = true;
    
    require_once("includes/header.php");

    //Show error if no id is passed
    if(!isset($_GET["id"])) {
        ErrorMessage::show("No id passed to page");
    }

    //Create user
    $user = new User($con, $userLoggedIn);

    //Check if user is subscribed
    if(!$user->getIsSubscribed()) {
        ErrorMessage::show("You must be subscribed to watch videos
        <a href='profile.php'>Click here to subscribe!</a>");
    }

    //Create video object
    $video = new Video($con, $_GET["id"]);

    //Increment views
    $video->incrementViews();

    //Get up next video
    $upNextVideo = VideoProvider::getUpNext($con, $video);
?>

<!-- Video player -->
<div class="watchContainer">

    <!-- Video player controls -->
    <div class="videoControls watchNav">
        <button onclick="goBack()"><i class="fas fa-arrow-left"></i></button>
        <h1><?php echo $video->getTitle(); ?></h1>
    </div>

    <div class="videoControls upNext" style="display: none;">
        <button onclick="restartVideo();"><i class="fas fa-redo"></i></button>

        <div class="upNextContainer">
            <h2>Up Next:</h2>
            <h3><?php echo $upNextVideo->getTitle(); ?></h3>
            <h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?></h3>

            <button class="play" onclick="watchVideo(<?php echo $upNextVideo->getId(); ?>);">
                <i class="fas fa-play"></i>
                Play
            </button>
        </div>
    </div>

    <video controls autoplay onended="showUpNext();">
        <source src="<?php echo $video->getFilePath(); ?>" type="video/mp4">
    </video>
</div>

<script>
    //Start video
    initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn; ?>");
</script>