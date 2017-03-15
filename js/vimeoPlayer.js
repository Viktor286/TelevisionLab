// https://github.com/vimeo/player.js

var iframe = document.querySelector('iframe');
var player = new Vimeo.Player(iframe);

player.getVideoId().then(function(id) {
    // id = the video id
    console.log('ID:', id);
}).catch(function(error) {
    // an error occurred
});


player.getCurrentTime().then(function(seconds) {
    // seconds = the current playback position
    console.log('Time:', seconds);
}).catch(function(error) {
    // an error occurred
});


player.setCurrentTime(14.518).then(function(seconds) {
    // seconds = the actual time that the player seeked to
}).catch(function(error) {
    switch (error.name) {
        case 'RangeError':
            // the time was less than 0 or greater than the video’s duration
            break;

        default:
            // some other error occurred
            break;
    }
});


player.pause().then(function() {
    // the video was paused
}).catch(function(error) {
    switch (error.name) {
        case 'PasswordError':
            // the video is password-protected and the viewer needs to enter the
            // password first
            break;

        case 'PrivacyError':
            // the video is private
            break;

        default:
            // some other error occurred
            break;
    }
});


player.getPaused().then(function(paused) {
    // paused = whether or not the player is paused
}).catch(function(error) {
    // an error occurred
});


player.getCuePoints().then(function(cuePoints) {
    // cuePoints = an array of cue point objects
    console.log('cuePoints:', cuePoints);
})



player.on('cuepoint', function(data) {
    console.log('data:', data);
    // data is an object containing properties specific to that event
});

player.pause()
player.setCurrentTime(14.518)