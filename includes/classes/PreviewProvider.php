<?php
class PreviewProvider {

    // Create private variables
    private $con, $username;

    // Create constructor
    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
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

        // TODO: ADD SUBTITLE

        // Return html
        return "<div class='previewContainer'>

                    <img src='$thumbnail' class='previewImage' hidden>

                    <video autoplay muted class='previewVideo' onended='previewEnded()'>
                        <source src='$preview' type='video/mp4'>
                    </video>

                    <div class='previewOverlay'>
                        
                        <div class='mainDetails'>
                            <h3>$name</h3>

                            <div class='buttons'>
                                <button><i class='fas fa-play'></i> Play</button>
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