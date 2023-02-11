<?php
    require_once("../includes/config.php");

    //Check if variables are passed in
    if(isset($_POST["videoId"]) && isset($_POST["username"])){
        //Set video as finished and reset progress
        $query = $con->prepare("UPDATE videoProgress SET finished=1, progress=0 WHERE videoId=:videoId AND username=:username");
        //Bind values
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->bindValue(":username", $_POST["username"]);
        //Execute query
        $query->execute();
        
    } else{
        //Error
        echo "No videoId or username passed into file";
    }
?>