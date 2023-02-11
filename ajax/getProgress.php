<?php
    require_once("../includes/config.php");

    //Check if variables are passed in
    if(isset($_POST["videoId"]) && isset($_POST["username"])){
        //Get video progress
        $query = $con->prepare("SELECT progress FROM videoProgress WHERE videoId=:videoId AND username=:username");
        //Bind values
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->bindValue(":username", $_POST["username"]);
        //Execute query
        $query->execute();
        //Return progress
        echo $query->fetchColumn();
        
    } else{
        //Error
        echo "No videoId or username passed into file";
    }
?>