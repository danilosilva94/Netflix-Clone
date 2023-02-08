<?php
    class Season {
        //Variables
        private $seasonNumber, $videos;

        //constructor
        public function __construct($seasonNumber, $videos){
            $this->seasonNumber = $seasonNumber;
            $this->videos = $videos;
        }

        //Get season number
        public function getSeasonNumber(){
            //Return season number
            return $this->seasonNumber;
        }

        //Get videos
        public function getVideos(){
            //Return videos
            return $this->videos;
        }
    }
?>