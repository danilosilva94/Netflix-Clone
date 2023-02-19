<?php
    class SeasonProvider{
        //Variables
        private $con, $username;

        //Constructor
        public function __construct($con, $username){
            $this->con = $con;
            $this->username = $username;
        }

        //Create season section
        public function create($entity){
            //Get seasons
            $seasons = $entity->getSeasons();

            //Check if there are seasons
            if(sizeof($seasons) == 0){
                //Return empty string
                return;
            }

            //Create season container
            $seasonsHtml = "";

            //Create season container
            foreach($seasons as $season){
                //Get season number
                $seasonNumber = $season->getSeasonNumber();

                //Create video html
                $videosHtml = "";
                foreach($season->getVideos() as $video){
                    //Append videos to videos container
                    $videosHtml .= $this->createVideoSquare($video);
                }

                //Create season container
                $seasonsHtml .= "<div class='season'>
                                    <h3>Season $seasonNumber</h3>
                                    <div class='videos'>
                                        $videosHtml
                                    </div>
                                <div class='videos'>";
            }

            return $seasonsHtml;
        }

        //Create video container
        private function createVideoSquare($video){
            //Get video id
            $id = $video->getId();
            //Get video thumbnail
            $thumbnail = $video->getThumbnail();
            //Get video name
            $name = $video->getTitle();
            //Get video description
            $description = $video->getDescription();
            //Get episode number
            $episodeNumber = $video->getEpisodeNumber();
            //Check if video has been seen
            $hasSeen = $video->hasSeen($this->username) ? "<i class='fas fa-check-circle seen'></i>" : "";

            //Return video container
            return "<a href='watch.php?id=$id'>
                        <div class='episodeContainer'>
                            <div class='contents'>
                                <img src='$thumbnail'>
                                <div class='videoInfo'>
                                    <h4>$episodeNumber. $name</h4>
                                    <span>$description</span>
                                </div>
                                $hasSeen
                            </div>
                        </div>
                    </a>";
        }
    }
?>