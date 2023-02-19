<?php
    class Video{
        //Variables
        private $con, $sqlData, $entity;

        //Constructor
        public function __construct($con, $input){
            $this->con = $con;

            //Check if input is array
            if(is_array($input)){
                //Assign input to array
                $this->sqlData = $input;
            } else{
                //If input is not an array, get input from database
                $query = $this->con->prepare("SELECT * FROM videos WHERE id=:id");
                //Bind value
                $query->bindValue(":id", $input);
                //Execute query
                $query->execute();
                //Assign input to array
                $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
            }

            //Create a new Entity
            $this->entity = new Entity($con, $this->sqlData["entityId"]);
        }
        
        //Get video id
        public function getId(){
            //Return id
            return $this->sqlData["id"];
        }

        //Get video title
        public function getTitle(){
            //Return title
            return $this->sqlData["title"];
        }

        //Get video description
        public function getDescription(){
            //Return description
            return $this->sqlData["description"];
        }

        //Get video filePath
        public function getFilePath(){
            //Return filePath
            return $this->sqlData["filePath"];
        }

        //Get video thumbnail
        public function getThumbnail(){
            //Return thumbnail
            return $this->entity->getThumbnail();
        }

        //Get episode number
        public function getEpisodeNumber(){
            //Return episode number
            return $this->sqlData["episode"];
        }

        //Get season number
        public function getSeasonNumber(){
            //Return season number
            return $this->sqlData["season"];
        }

        //Get entity id
        public function getEntityId(){
            //Return entity id
            return $this->sqlData["entityId"];
        }

        //Increment views
        public function incrementViews(){
            //query to increment views
            $query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
            //Bind value
            $query->bindValue(":id", $this->getId());
            //Execute query
            $query->execute();
        }

        //Get season and episode
        public function getSeasonAndEpisode(){
            //Check if video is a movie
            if($this->isMovie()){
                //Return empty string
                return;
            }

            $season = $this->getSeasonNumber();
            $episode = $this->getEpisodeNumber();

            //Return season and episode
            return "Season $season, Episode $episode";
        }

        //Check if video is a movie
        public function isMovie(){
            //Check if season and episode are 1
            return $this->sqlData["isMovie"] == 1;
        }

        //Check if video is in progress
        public function isInProgress($username){
            //Query
            $query = $this->con->prepare("SELECT * FROM videoProgress
            WHERE videoId=:videoId AND username=:username
            AND finished=0");

            //Bind values
            $query->bindValue(":videoId", $this->getId());
            $query->bindValue(":username", $username);

            //Execute query
            $query->execute();

            //Check if there is a result
            return $query->rowCount() != 0;
        }

        //Check if video has been seen
        public function hasSeen($username){
            //Query
            $query = $this->con->prepare("SELECT * FROM videoProgress
            WHERE videoId=:videoId AND username=:username
            AND finished=1");

            //Bind values
            $query->bindValue(":videoId", $this->getId());
            $query->bindValue(":username", $username);

            //Execute query
            $query->execute();

            //Check if there is a result
            return $query->rowCount() != 0;
        }

    }
?>