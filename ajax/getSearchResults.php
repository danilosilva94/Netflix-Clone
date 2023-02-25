<?php
    require_once("../includes/config.php");
    require_once("../includes/classes/SearchResultsProvider.php");
    require_once("../includes/classes/EntityProvider.php");
    require_once("../includes/classes/Entity.php");
    require_once("../includes/classes/PreviewProvider.php");

    //Check if variables are passed in
    if(isset($_POST["term"]) && isset($_POST["username"])){
        
        //Create new SearchResultsProvider object
        $srp = new SearchResultsProvider($con, $_POST["username"]);
        
        //Get results
        echo $srp->getResults($_POST["term"]);
    } else{
        //Error
        echo "No term or username passed into file";
    }
?>