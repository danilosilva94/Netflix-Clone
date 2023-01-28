<?php
    class PreviewProvider{
        //Variables
        private $con, $username;

        //Constructor
        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
        }

        //Function to create preview video
        public function createPreviewVideo($entity){
            //Check if does not exist
            if($entity == null){
                //Get random entity
                $entity = $this->getRandomEntity();
            }

            //Assign entity value
            $id = $entity->getId();
            $name = $entity->getName();
            $preview = $entity->getPreview();
            $thumbnail = $entity->getThumbnail();

            //Return preview video html
            echo "<div class='previewContainer'>
                        <img src='$thumbnail' class='previewImage' hidden>
                        <video autoplay muted class='previewVideo' onended='previewEnded()'>
                            <source src='$preview' type='video/mp4'>
                        </video>

                        <div class='previewOverlay'>
                            <div class='mainDetails'>
                                <h3>$name</h3>
                                <div class='buttons'>
                                    <button onclick='watchVideo($id)'><i class='fas fa-play'></i> Play</button>
                                    <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>";

        }

        //Get random entity
        private function getRandomEntity(){
            //Get random entity through random id
            $query = $this->con->prepare("SELECT * FROM entities ORDER BY RAND() LIMIT 1");
            //Execute query
            $query->execute();
            //Fetch query
            $row = $query->fetch(PDO::FETCH_ASSOC);
            
            //Return entity
            return new Entity($this->con, $row);
        }
    }
?>  