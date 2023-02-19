//Create function based on the scrolling of the page
$(document).scroll(function(){
    //Change the class of the top bar if the page is scrolled
    $(".topBar").toggleClass("scrolled", $(this).scrollTop() > $(".topBar").height());
})

//Toggle video volume
function volumeToggle(button) {
    //Get the value of the video's muted property
    //If it's true, change it to false
    var muted = $(".previewVideo").prop("muted");

    //If it's false, change it to true
    $(".previewVideo").prop("muted", !muted);

    //Remove the fa-volume-up class and add the fa-volume-mute class
    //Toggle adds and removes the class
    $(button).find("i").toggleClass("fa-volume-mute");
    $(button).find("i").toggleClass("fa-volume-up");
}

//Check if the video has ended
function previewEnded(){
    //Hide the video
    $(".previewVideo").toggle();
    //Show the image
    $(".previewImage").toggle();
}

//Go to prevous page
function goBack(){
    window.history.back();
}

//Hide buttons timer
function startHideTimer(){
    var timeout = null;

    //If the mouse is moved, clear the timeout
    $(document).on("mousemove", function(){
        //Reset timer
        clearTimeout(timeout);

        //Show the buttons
        $(".watchNav").fadeIn();

        //Set a timeout to hide the buttons
        timeout = setTimeout(function(){
            //Hide the buttons
            $(".watchNav").fadeOut();
        }, 2000);
    });
}

//Initiate the video
function initVideo(videoId, username){
    startHideTimer();
    setStartTime(videoId, username);
    updateProgressTimer(videoId, username);
}

//Update the progress bar
function updateProgressTimer(videoId, username){
    //If video is not already in progress tablle, add it
    addDuration(videoId, username);

    //Update the progress bar every second
    var timer;

    //While the video is playing
    $("video").on("playing", function(event){
        //Clear timer on window
        window.clearInterval(timer);

        //Set new timer
        timer = setInterval(function(){
            //Take current time value of video and send it to updateProgress.php
            updateProgress(videoId, username, event.target.currentTime);
        }, 3000);

        //On video end
    }).on("ended", function(){
        //Set finished
        setFinished(videoId, username);

        //Clear timer on window
        window.clearInterval(timer);
    });
}

//Add duration
function addDuration(videoId, username){
    $.post("ajax/addDuration.php", {videoId:videoId, username: username},  function(data){
        //Check for errors
        if(data !== null && data !== ""){
            //Show error
            alert(data);
        }
    });
}

//Update progress bar
function updateProgress(videoId, username, progress){
    //Send data to updateProgress.php
    $.post("ajax/upgradeDuration.php", {videoId:videoId, username: username, progress: progress},  function(data){
        //Check for errors
        if(data !== null && data !== ""){
            //Show error
            alert(data);
        }
    });
}

//Set finished
function setFinished(videoId, username){
    $.post("ajax/setFinished.php", {videoId:videoId, username: username},  function(data){
        //Check for errors
        if(data !== null && data !== ""){
            //Show error
            alert(data);
        }
    });
}

//Set start time
function setStartTime(videoId, username){
    $.post("ajax/getProgress.php", {videoId:videoId, username: username},  function(data){
        //Check for errors
        if(isNaN(data)){
            //Show error
            alert(data);
        }

        //Set the video progress
        $("video").on("canplay", function(){
            this.currentTime = data;
            $("video").off("canplay");
        });
    });
}

//Restart video
function restartVideo(){
    //Set the video progress to 0
    $("video")[0].currentTime = 0;
    //Play the video
    $("video")[0].play();

    //Hide the replay button
    $(".upNext").fadeOut();
}

//Watch video
function watchVideo(videoId){
    //Redirect to watch.php?id=videoId
    window.location.href = "watch.php?id=" + videoId;
}

//Show the next video
function showUpNext(){
    //Fade in the up next container
    $(".upNext").fadeIn();
}