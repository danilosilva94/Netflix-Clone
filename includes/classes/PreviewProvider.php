<?php
class PreviewProvider {

    // Create private variables
    private $con, $username;

    // Create constructor
    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    // Create preview video for categories
    public function createCategoryPreviewVideo($categoryId){
        //Get TV show entity
        $entitiesArray = EntityProvider::getEntities($this->con, $categoryId, 1);

        //Check if entity is not null
        if(sizeof($entitiesArray) == 0) {
            //Show error message
            ErrorMessage::show("No movies to display");
        }

        //Return preview video
        return $this->createPreviewVideo($entitiesArray[0]);
    }

    // Create preview video for tv shows
    public function crateTVShowPreviewVideo(){
        //Get TV show entity
        $entitiesArray = EntityProvider::getTVShowEntities($this->con, null, 1);

        //Check if entity is not null
        if(sizeof($entitiesArray) == 0) {
            //Show error message
            ErrorMessage::show("No TV shows to display");
        }

        //Return preview video
        return $this->createPreviewVideo($entitiesArray[0]);
    }

    // Create preview video for movies
    public function crateMoviesPreviewVideo(){
        //Get TV show entity
        $entitiesArray = EntityProvider::getMoviesEntities($this->con, null, 1);

        //Check if entity is not null
        if(sizeof($entitiesArray) == 0) {
            //Show error message
            ErrorMessage::show("No movies to display");
        }

        //Return preview video
        return $this->createPreviewVideo($entitiesArray[0]);
    }

    // Create preview video
    public function createPreviewVideo($entity) {
        // Check if entity is null
        if($entity == null) {
            // Get random entity
            $entity = $this->getRandomEntity();
        }

        // Get entity details
        $id = $entity->getId();
        $name = $entity->getName();
        $preview = $entity->getPreview();
        $thumbnail = $entity->getThumbnail();

        // Get video id of entity
        $videoId = VideoProvider::getEntityVideoForUser($this->con, $id, $this->username);

        //Create video object
        $video = new Video($this->con, $videoId);

        //Check if video is in progress
        $inProgress = $video->isInProgress($this->username);

        //Get season episode
        $seasonEpisode = $video->getSeasonAndEpisode();

        //Subheading
        $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";

        //Play button text
        $playButtonText = $inProgress ? "Continue Watching" : "Play";

        // Return html
        return "<div class='previewContainer'>

                    <img src='$thumbnail' class='previewImage' hidden>

                    <video autoplay muted class='previewVideo' onended='previewEnded()'>
                        <source src='$preview' type='video/mp4'>
                    </video>

                    <div class='previewOverlay'>
                        
                        <div class='mainDetails'>
                            <h3>$name</h3>
                            $subHeading
                            <div class='buttons'>
                                <button onclick='watchVideo($videoId)'><i class='fas fa-play'></i> $playButtonText</button>
                                <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                            </div>

                        </div>

                    </div>
        
                </div>";

    }

    public function createEntityPreviewSquare($entity) {
        // Get entity details
        $id = $entity->getId();
        $name = $entity->getName();
        $thumbnail = $entity->getThumbnail();

        // Return html
        return "<a href='entity.php?id=$id'>
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title='$name'>
                    </div>
                </a>";
    }

    // Get random entity
    private function getRandomEntity() {

        // Get single entity in array
        $entity = EntityProvider::getEntities($this->con, null, 1);
        // Return entity
        return $entity[0];
    }

}
?>