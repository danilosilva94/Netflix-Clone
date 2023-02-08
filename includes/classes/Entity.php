<?php
    class Entity{
        //Variables
        private $con, $sqlData;

        //Constructor
        public function __construct($con, $input){
            $this->con = $con;

            //Check if input is array
            if(is_array($input)){
                //Assign input to array
                $this->sqlData = $input;
            } else{
                //If input is not an array, get input from database
                $query = $this->con->prepare("SELECT * FROM entities WHERE id=:id");
                //Bind value
                $query->bindValue(":id", $input);
                //Execute query
                $query->execute();
                //Assign input to array
                $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
            }
        }

        //Get entity id
        public function getId(){
            //Return id
            return $this->sqlData["id"];
        }

        //Get entity name
        public function getName(){
            //Return name
            return $this->sqlData["name"];
        }

        //Get entity thumbnail
        public function getThumbnail(){
            //Return thumbnail
            return $this->sqlData["thumbnail"];
        }

        //Get entity preview
        public function getPreview(){
            //Return preview
            return $this->sqlData["preview"];
        }

        //Get entity category
        public function getCategoryId(){
            //Return category
            return $this->sqlData["categoryId"];
        }

        //Get seasons
        public function getSeasons() {
            //Get seasons from database
            $query = $this->con->prepare("SELECT * FROM videos WHERE entityId=:id
                                        AND isMovie=0 ORDER BY season, episode ASC");
            //Bind value
            $query->bindValue(":id", $this->getId());
            //Execute query
            $query->execute();
            
            //Create array
            $seasons = array();
            //Create array
            $videos = array();

            //Create variable
            $currentSeason = null;

            //Loop through query
            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                //Check if current season is not null and current season is not equal to row season
                if($currentSeason != null && $currentSeason != $row["season"]) {
                    //Add season to array
                    $seasons[] = new Season($currentSeason, $videos);
                    //Clear array
                    $videos = array();
                }
                
                //Assign current season to row season
                $currentSeason = $row["season"];
                //Add video to array
                $videos[] = new Video($this->con, $row);
    
            }
            
            //Handle last season
            //Check if array size is not equal to 0
            if(sizeof($videos) != 0) {
                //Add season to array
                $seasons[] = new Season($currentSeason, $videos);
            }
            //Return seasons
            return $seasons;
        }
    }
?>