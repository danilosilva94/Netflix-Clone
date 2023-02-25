<?php
    include_once("includes/header.php");
?>

<div class="textboxContainer">
    <input type="text" class="searchInput" placeholder="Search for something...">
</div>

<div class="results"></div>

<script>
    $(function(){
        // get user logged in
        var username = '<?php echo $userLoggedIn; ?>';
        var timer;

        // Do Something when user types
        $(".searchInput").keyup(function(){
            //Clear timer
            clearTimeout(timer);

            //Set timer and wait 500ms before displaying results
            timer = setTimeout(function(){
                //Get value from input field
                var val = $(".searchInput").val();
                
                //Check if value is empty
                if(val != ""){
                    //Send ajax request
                    $.post("ajax/getSearchResults.php", {term: val, username: username}, 
                    function(data){
                        //Display results in results div
                        $(".results").html(data);
                    })
                } else{
                    //Clear results div
                    $(".results").html("");
                }

            }, 500)
        })
    })
</script>