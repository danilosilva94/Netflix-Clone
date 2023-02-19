<?php
    class VideoProvider{
        //Get up next video
        public static function getUpNext($con, $currentVideo){
            //Query
            $query = $con->prepare("SELECT * FROM videos 
            WHERE entityId = :entityId AND id != :videoId 
            AND (
                (season = :season AND episode > :episode) OR season > :season
            )
            ORDER BY season, episode ASC LIMIT 1");

            //Bind values
            $query->bindValue(":entityId", $currentVideo->getEntityId());
            $query->bindValue(":videoId", $currentVideo->getId());
            $query->bindValue(":season", $currentVideo->getSeasonNumber());
            $query->bindValue(":episode", $currentVideo->getEpisodeNumber());

            //Execute query
            $query->execute();

            //Check if there is a result
            if($query->rowCount() == 0){
                //No result so select different video
                $query = $con->prepare("SELECT * FROM videos
                WHERE season <= 1 AND episode <= 1
                AND id != :videoId
                ORDER BY views DESC LIMIT 1");

                //Bind values
                $query->bindValue(":videoId", $currentVideo->getId());

                //Execute query
                $query->execute();
            }

            //Fetch result
            $row = $query->fetch(PDO::FETCH_ASSOC);

            //Return video
            return new Video($con, $row);
        }

        //Get video details for index page
        public static function getEntityVideoForUser($con, $entityId, $username){
            //Query
            $query = $con->prepare("SELECT videoId FROM videoProgress
            INNER JOIN videos
            ON videoProgress.videoId = videos.id
            WHERE videos.entityId = :entityId
            AND videoProgress.username = :username
            ORDER BY videoProgress.dateModified DESC
            LIMIT 1");

            //Bind values
            $query->bindValue(":entityId", $entityId);
            $query->bindValue(":username", $username);

            //Execute query
            $query->execute();

            //Check if there is a result
            if($query->rowCount() == 0){
                //No result so select lowest episode
                $query = $con->prepare("SELECT id FROM videos
                WHERE entityId = :entityId
                ORDER BY season, episode ASC LIMIT 1");

                //Bind values
                $query->bindValue(":entityId", $entityId);

                //Execute query
                $query->execute();
            }

            //Return single column
            return $query->fetchColumn();
        }
    }
?>