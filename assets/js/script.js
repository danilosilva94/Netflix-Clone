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