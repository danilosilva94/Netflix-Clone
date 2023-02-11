<?php
    //Includes
    require_once("../includes/config.php");

    //Check if variabkes are passed in
    if(isset($_POST["videoId"]) && isset($_POST["username"])){
        //Check if videoProgress already exists
        $query = $con->prepare("SELECT * FROM videoProgress WHERE videoId=:videoId AND username=:username");
        //Bind values
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->bindValue(":username", $_POST["username"]);

        //Execute query
        $query->execute();

        //Check if query returned any results
        if($query->rowCount() == 0){
            //Insert video progress
            $query = $con->prepare("INSERT INTO videoProgress(username, videoId) VALUES(:username, :videoId)");
            //Bind values
            $query->bindValue(":videoId", $_POST["videoId"]);
            $query->bindValue(":username", $_POST["username"]);

            //Execute query
            $query->execute();
        }
    } else{
        //Error
        echo "No videoId or username passed into file";
    }
?>