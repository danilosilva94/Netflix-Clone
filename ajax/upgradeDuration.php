<?php
    require_once("../includes/config.php");

    //Check if variables are passed in
    if(isset($_POST["videoId"]) && isset($_POST["username"]) && isset($_POST["progress"])){
        //Update video progress
        $query = $con->prepare("UPDATE videoProgress SET progress=:progress, dateModified=NOW() WHERE videoId=:videoId AND username=:username");
        //Bind values
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->bindValue(":username", $_POST["username"]);
        $query->bindValue(":progress", $_POST["progress"]);
        //Execute query
        $query->execute();
        
    } else{
        //Error
        echo "No videoId or username passed into file";
    }

?>