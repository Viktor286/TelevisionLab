/*---  Most of the JS controls for VimeoVideoPlayer initializes inside ajax-responded block VideoInfo
 inside function LoadVideoOnPage(VideoId); in \desktop\js\scripts.js  ------*/

// References for Vimeo Player API
// https://github.com/vimeo/player.js

/* Creating a player control object
 // Select with the DOM API

 var iframe = document.querySelector('iframe');
 var mainPlayer = new Vimeo.Player(iframe);

 // Select with jQuery
 // If multiple elements are selected, it will use the first element.
 var jqueryPlayer = new Vimeo.Player($('iframe'));

 // Select with the `<iframe>`’s id
 // Assumes that there is an <iframe id="player1"> on the page.
 var idPlayer = new Vimeo.Player('player1');
 */


// Television Lab Player: prev/next video

function SetAutoPlayUI(type) { // "Cycle" or "Next"
    var AutoPlayButton = $("div#MPC div.AutoPlay");
    if (type == "Next") {
        AutoPlayButton.removeClass( "Cycle" );
        AutoPlayButton.addClass( "Next" );
    } else if (type == "Cycle") {
        AutoPlayButton.removeClass( "Next" );
        AutoPlayButton.addClass( "Cycle" );
    }
}

function VideoGoAndPlay(state){
    var this_Vid_Obj = $("#container.waterfall-container div.item.here");
    var first_Vid_Obj = $("#container.waterfall-container").children().first();

    var next_Vid_Obj = this_Vid_Obj.next();
    var prev_Vid_Obj = this_Vid_Obj.prev();
    var next_Vid_Id = next_Vid_Obj.data("id");
    var prev_Vid_Id = prev_Vid_Obj.data("id");

    if (state == "Next"){
        if (typeof next_Vid_Id != 'undefined') {
            this_Vid_Obj.removeClass( "here" );
            next_Vid_Obj.addClass( "here" );
            LoadVideoOnPage(next_Vid_Id);
        } else {
            // If no data-id then drop .here class to the first element
            this_Vid_Obj.removeClass( "here" );
            first_Vid_Obj.addClass( "here" );
            LoadVideoOnPage(first_Vid_Obj.data("id"));
        }
    }

    if (state == "Prev"){
        if (typeof prev_Vid_Id != 'undefined') {
            this_Vid_Obj.removeClass( "here" );
            prev_Vid_Obj.addClass( "here" );
            LoadVideoOnPage(prev_Vid_Id);
        } else {
            // If no data-id then drop .here class to the first element
            this_Vid_Obj.removeClass( "here" );
            first_Vid_Obj.addClass( "here" );
            LoadVideoOnPage(first_Vid_Obj.data("id"));
        }
    }

}

/* Timecode based on  setTimeout and getCurrentTime() */
// setTimeout(function() { console.log('Timer'); }, 1000);


$(document).on('click','div#MPC div#NextVideo',function( event ){
    event.preventDefault();
    VideoGoAndPlay("Next");
});

$(document).on('click','div#MPC div#PrevVideo',function( event ){
    event.preventDefault();
    VideoGoAndPlay("Prev");
});


