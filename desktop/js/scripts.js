



/*  AdjustH1InfoOutput Line */
$( document ).ready(function() {

    //-- Remove tag on x click
    $( "div#MainOutput > h1.setInfo > span.Tags > span.tag span.x-close" )
        .on( "click", function( event ) {

            //Recognize tag text
            var TagText = $( this ).parent().text();
            TagText = TagText.replace("⨯","");
            TagText = TagText.replace("# ","");

            // Remove tag
            $("#singleFieldTags").tagit("removeTagByLabel", TagText);
            // Remove div tag
            $( this ).parent().fadeOut(200, function() { TagText.remove(); });
            // Submit with delay
            setTimeout(function() { $('#tpSearch').submit(); }, 100);
        });

});


// Display Video On page load
function LoadVideoOnPage(VideoId) {

    $.ajax('desktop/ajax/video.php', {
        success: function(response) {
            $('#PreviewWindow').html('<div class="box"><iframe src="//player.vimeo.com/video/' + VideoId + '?title=0&byline=0&portrait=0&autoplay=1"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>').load(function(e){
                $(this).contents().find('body').addClass('Z');
            });
            $('#InformationWindow').hide().html(response).fadeIn(0);
        },
        data: {"VideoId": VideoId},
        cache: false

    }).done(function() {
        //-------- When Ajax Video Loaded
        // This will fire when video loaded

        // Highlight tags
        var tags_arr = NowTags.split(' ');
        $.each(tags_arr, function( index, value ) {
            $('a.tag[data-tag='+ value +']').addClass("here");
        });


        // Play-Pause of top panel player
        var iframe = document.querySelector('iframe');
        var mainPlayer = new Vimeo.Player(iframe);
        var playPauseBt = $("div#MPC div#PlayPause");
        var init_bug = mainPlayer; // initialization of mainPlayer object, which is inactive till first usage

        // Time code result: playback is jumpy, no way to make decent time code
/*        mainPlayer.on('timeupdate', function(data) {
            console.log(data.seconds);
            $('div.timecode').html("000" + data.seconds);
        });*/

        // Set On PlayPause Button Event
        $(document).on('click','div#MPC div#PlayPause',function( event ){
            event.preventDefault();
            mainPlayer.getPaused().then(function(paused) {
                if (paused == true) {
                    mainPlayer.play();
                }else{
                    mainPlayer.pause();
                }
            }).catch(function(error) {  // an error occurred
                console.log("an error occurred during on('click') mainPlayer.getPaused()");
            });
        });

        //------ Player play/pause Actions
        function playPauseSwitch(paused_state) {
            if (paused_state == true) {
                // Pause was ON, switch to play
                playPauseBt.removeClass( "pause" );
                playPauseBt.addClass( "play" );
                //console.log("Pause was ON. Show Play Button");
            }else{
                // Pause was OFF, turn it on
                playPauseBt.removeClass( "play" );
                playPauseBt.addClass( "pause" );
                //console.log("Pause was OFF. Show Pause Button");
            }
        }

        mainPlayer.on('play', function(data) {
            // data is an object containing properties specific to that event (play data: duration, percent, seconds)
            mainPlayer.getPaused().then(function(paused) {
                playPauseSwitch(paused);
            }).catch(function(error) {
                // an error occurred
                console.log("an error occurred during mainPlayer.getPaused()");
            });
        });

        mainPlayer.on('pause', function(data) {
            // data is an object containing properties specific to that event
            mainPlayer.getPaused().then(function(paused) {
                playPauseSwitch(paused);
            }).catch(function(error) {
                // an error occurred
                console.log("an error occurred during mainPlayer.getPaused()");
            });
        });

        // Init AutoPlay param and UI by getting AutoPlayState from cookie (php-cookie-pipe).
        if (AutoPlayState == 1) {
            SetAutoPlayUI("Next");
            mainPlayer.setLoop(false);
            //console.log("init AutoPlayState == 1");
        } else {
            SetAutoPlayUI("Cycle");
            mainPlayer.setLoop(true);
            //console.log("init AutoPlayState == 0");
        }


        //------ Auto Next Play Button
        // AutoPlay button on.click Actions
        $(document).on('click','div#MPC div.AutoPlay',function( event ){
            event.preventDefault();
            if (AutoPlayState == 1) {
                // If AutoPlayState toggle was ON, then switch this back to 0, Cycle
                mainPlayer.setLoop(true).then(function(loop) { // Set player loop on
                    SetAutoPlayUI("Cycle"); // Change UI
                    AutoPlayState = 0; // Change UI state
                    document.cookie="AutoPlayState=" + AutoPlayState; // Change cookie state
                    //console.log("Set loop on: player, UI, var, cookie.");
                }).catch(function(error) {
                    console.log("an error occurred during mainPlayer.setLoop(true)");
                });
            } else {
                // If AutoPlayState toggle is ON, then switch this to Cycle
                mainPlayer.setLoop(false).then(function(loop) { // Set player loop off
                    SetAutoPlayUI("Next"); // Change UI
                    AutoPlayState = 1; // Change UI state
                    document.cookie="AutoPlayState=" + AutoPlayState; // Change cookie state
                    //console.log("Set loop off, autoplay on: player, UI, var, cookie.");
                }).catch(function(error) {
                    console.log("an error occurred during mainPlayer.setLoop(true)");
                });
            }
        });

        //------ Auto Next Play Video Functionality
        mainPlayer.on('ended', function(data) { // This event fires only if loop is off
            // data is an object containing properties specific to that event
            VideoGoAndPlay("Next");
        });


        //------ CuePoints Prev/Next init

        // 1. Get all CuePoints for video
        //console.log('1. Get all CuePoints for video.');
        mainPlayer.getCuePoints().then(function(cuePoints) {
            //console.log('Primary collection getCuePoints() worked fine: ');
            // console.log(cuePoints);

            // 2. Delete all existing CuePoints for loaded media
            if (cuePoints.length > 0) {
                console.log('Some CuePoints already exist for loaded media.');
                console.log('Deleting all existing CuePoints for loaded media');
                for (var i = 0; i < cuePoints.length; i++) {

                    mainPlayer.removeCuePoint(cuePoints[i].id).then(function(id) { // cuePoints = an array of cue point objects
                        console.log('cue point ' + id + ' was removed successfully: ');
                    }).catch(function(error) {
                        switch (error.name) {
                            case 'UnsupportedError':
                                console.log('cue points are not supported with the current player or browser');
                                break;
                            case 'InvalidCuePoint':
                                console.log('a cue point with the id passed wasn’t found');
                                break;
                            default:
                                console.log('some other error occurred');
                                break;
                        }
                    });
                }
            } else {
                //console.log('No CuePoints found for loaded media.');
            }

        }).catch(function(error) { // catch for mainPlayer.getCuePoints()
            switch (error.name) {
                case 'UnsupportedError':
                    console.log('cue points are not supported with the current player or browser');
                    break;
                default:
                    console.log('some other error occurred during mainPlayer.getCuePoints()');
                    break;
            }
        });

        // ------------------------------------------------

        // 3. Assign all CuePoints in cycle for loaded media (add CuePoints for current video) from DB data

        // temp data object
        var videoCuePoints = [
            {
                "time": 3,
                "data": {
                    "ShotTag": "Nice",
                    "ShotName": "Nice 3s shot" // this is "customKey": "customValue"
                },
                "id": "videoCuePoint-0"
            },
            {
                "time": 8,
                "data": {
                    "ShotTag": "Great",
                    "ShotName": "Great 8 too"
                },
                "id": "videoCuePoint-1"
            },
            {
                "time": 16,
                "data": {
                    "ShotTag": "custom",
                    "ShotName": "custom 16 Value custom 16 Value custom 16 Value custom 16 Value custom 16 Value custom 16 Value"
                },
                "id": "videoCuePoint-2"
            },
            {
                "time": 24,
                "data": {
                    "ShotTag": "Cool",
                    "ShotName": "Cool 24 shoot"
                },
                "id": "videoCuePoint-3"
            },
            {
                "time": 30,
                "data": {
                    "ShotTag": "Far",
                    "ShotName": "Far far 30 sec"
                },
                "id": "videoCuePoint-0"
            }
        ];

        // Adding timecode formatted time
        for (i = 0; i < videoCuePoints.length; i++) {

            var mins = Math.floor(videoCuePoints[i].time / 60 % 60).toString();
            var secs = Math.floor(videoCuePoints[i].time % 60).toString();

            if (mins.length < 2) {
                mins = '0' + mins;
            }

            if (secs.length < 2) {
                secs = '0' + secs;
            }

            videoCuePoints[i].timecode = mins + ':' + secs;
        }

        // Debug timecode list
        /*for (i = 0; i < videoCuePoints.length; i++) {
            console.log(videoCuePoints[i].timecode);
        }*/


        // Make short version of data set
        var cuePointsIdList = [];
        for (var i = 0; i < videoCuePoints.length; i++) {
            cuePointsIdList.push(videoCuePoints[i].time);
        }

        //  Add videoCuePoints items from data set to video player
        for (i = 0; i < videoCuePoints.length; i++) {
            // console.log('----- begin extraction of new videoCuePoints item ' + i + ' ... ');

            mainPlayer.addCuePoint(videoCuePoints[i].time, videoCuePoints[i].data).then(function(id) {
                //console.log('cue point ' + i + ' was added successfully with id: ' + id);

            });
        }

        // 4. Get all CuePoints again
        mainPlayer.getCuePoints().then(function(videoCuePoints) {
            // 5. Make CuePoints Listener action (for visual indicating).
            if (videoCuePoints.length > 0) {
                //console.log('There is some final videoCuePoints in object.');
            } else {
                //console.log('Final videoCuePoints not found in object.');
            }
        });

        var nearestCuePoint = 0,
        nearestIndex = 0,
        nextCuePoint = 0,
        nextCuePointIndex = 0,
        prevCuePoint = 0,
        prevCuePointIndex = 0,
        thisIndex = 0,
        absDiffArr = [];

        var KeyShotsDiv = 'div#InformationWindow > .left > div.KeyShots > ul';
        var KeyShotsNameDiv = 'div#InformationWindow > .left > div.KeyShots > div.ShotName > span';

        // div#NextShot controller
        $(document).on('click','div#MPC div#NextShot',function( event ){
            event.preventDefault();

            var buttonNextShot = $( this );
            buttonNextShot.addClass( "disabled" );

            // Get Current Time to calculate where we are and where to go
            mainPlayer.getCurrentTime().then(function(currentTime) {

                // Find nearest point for currentTime
                // Find absolute difference between currentTime and all cuePoints in data set
                for (i = 0; i < cuePointsIdList.length; i++) {
                    absDiffArr[i] = Math.abs(cuePointsIdList[i]-currentTime);
                }
                nearestIndex = indexOfMin(absDiffArr); // Get Index of nearest element
                nearestCuePoint = cuePointsIdList[nearestIndex]; // Get nearest CuePoint through this Index

                // Compare currentTime and nearestCuePoint to define correct nextCuePoint.
                if (currentTime*1000 >= nearestCuePoint*1000) {
                    nextCuePointIndex = nearestIndex + 1; // just NEXT item in array

                    // if we pass the nearest point, next point will be just NEXT item in array
                    if (nextCuePointIndex >= videoCuePoints.length) { // But. If this index went beyond array,
                        nextCuePoint = videoCuePoints[0]; // then return to first cuePoint
                        thisIndex = 0;
                    } else {
                        nextCuePoint = videoCuePoints[nextCuePointIndex];
                        thisIndex = nextCuePointIndex;
                    }
                } else {
                    nextCuePoint = videoCuePoints[nearestIndex]; // if we are after nearest point at this moment, prev point will be THIS current nearestPoint
                    thisIndex = nearestIndex;
                }

                // Start load the Cue Point ( VideoShot )
                $(KeyShotsDiv + ' > li').removeClass( "load" );
                $(KeyShotsDiv + ' > li').eq(thisIndex).addClass('load');
                // $(KeyShotsNameDiv).text('loading...');

                // Set current nextCuePoint time

                mainPlayer.setCurrentTime(nextCuePoint.time).then(function(second) {
                    //mainPlayer.pause();
                    buttonNextShot.removeClass( "disabled" );
                    $(KeyShotsDiv + ' > li').removeClass( "load" );
                    LoadVideoShotSwitch(nextCuePoint);
                    //console.log('Set time by div#NextShot to ' + second);
                });

            });
        });

        // div#PrevShot controller
        $(document).on('click','div#MPC div#PrevShot',function( event ){
            event.preventDefault();
            var buttonPrevShot = $( this );
            buttonPrevShot.addClass( "disabled" );

            // Get Current Time to calculate where we are and where to go
            mainPlayer.getCurrentTime().then(function(currentTime) {

                // Find nearest point for currentTime
                // Find absolute difference between currentTime and all cuePoints in data set
                for (i = 0; i < cuePointsIdList.length; i++) {
                    absDiffArr[i] = Math.abs(cuePointsIdList[i]-currentTime);
                }
                nearestIndex = indexOfMin(absDiffArr); // Get Index of nearest element
                nearestCuePoint = cuePointsIdList[nearestIndex]; // Get nearest CuePoint through this Index

                // Compare currentTime and nearestCuePoint to define correct prevCuePoint.
                if (currentTime*1000 <= nearestCuePoint*1000+1000) { // add additional delay for back clicking
                    prevCuePointIndex = nearestIndex - 1;

                    // if we pass the nearest point, prev point will be just prev item in array
                    if (prevCuePointIndex < 0) { // But. If this index went beyond array, then return to last cuePoint in array
                        prevCuePointIndex = videoCuePoints.length-1;
                        prevCuePoint = videoCuePoints[prevCuePointIndex];
                        thisIndex = prevCuePointIndex;
                    } else {
                        prevCuePoint = videoCuePoints[prevCuePointIndex];
                        thisIndex = prevCuePointIndex;
                    }
                } else {
                    prevCuePoint = videoCuePoints[nearestIndex]; // if we are after nearest point at this moment, prev point will be THIS current nearestPoint
                    thisIndex = nearestIndex;
                }


                // Start load the Cue Point ( VideoShot )
                $(KeyShotsDiv + ' > li').removeClass( "load" );
                $(KeyShotsDiv + ' > li').eq(thisIndex).addClass('load');
                // $(KeyShotsNameDiv).text('loading...');

                // Set current prevCuePoint time

                mainPlayer.setCurrentTime(prevCuePoint.time).then(function(second) {
                    //mainPlayer.pause();
                    buttonPrevShot.removeClass( "disabled" );
                    $(KeyShotsDiv + ' > li').removeClass( "load" );
                    LoadVideoShotSwitch(prevCuePoint);
                    // console.log('Set time by div#PrevShot to ' + second);
                });

            });
        });



        // Set the first ShotName in videoCuePoints and set all the LI
        $(KeyShotsNameDiv).html('<span style="color:#878787;">' + videoCuePoints.length + ' shot points...</span>');
        // $('div#InformationWindow > .left > div.KeyShots > div.ShotName').hide();

        // Set the LI elements
        for ( i = 0; i < videoCuePoints.length; i++) {
           $(KeyShotsDiv).append('<li data-time="' + videoCuePoints[i].time + '">' + videoCuePoints[i].data.ShotTag + '</li>');
        }

        function LoadVideoShotSwitch(keyShot){ // keyShot = object by numerical order from videoCuePoints data set
                // Write Shot Name in state text block
                // remove old .here
                $(KeyShotsDiv + ' > li.here').removeClass( "here" );
                // set new .here and delete .load
                $(KeyShotsDiv + ' > li[data-time='+keyShot.time+']').removeClass( "load" ).addClass( "here" );
                // $(KeyShotsNameDiv).hide().fadeIn(400).text(keyShot.data.ShotName);
        }

        // Controller to key shots link list
        $(document).on('click',KeyShotsDiv + ' > li',function( event ){
            event.preventDefault();

            //if (!$( this ).hasClass( "here" )){ // don't do on .here class
            var keyShot = videoCuePoints[$( this ).index()]; // object by numerical order from videoCuePoints data set
            // Start load the Cue Point
            $(KeyShotsDiv + ' > li').removeClass( "load" );
            $( this ).addClass('load');
            // $(KeyShotsNameDiv).text('loading...');
            // Jump to ney key shot
            mainPlayer.setCurrentTime(keyShot.time).then(function(second) {
                LoadVideoShotSwitch(keyShot);
                });
            //}
        });


        // looks like Vimeo.Player() can't hold values below 0.1s
        // object can give and accept only seconds starts from 0.11s
        // which timecode interprets as 00:00:02 and duplicates this with true 00:00:02

        // We also have autoplay cycle problem, which starts video from the begining at near of the end


        // set on nextFrame button
        var nextFrame = 'div#InformationWindow span.nextFrame';
        $(document).on('click', nextFrame, function( event ){
            mainPlayer.getCurrentTime().then(function(seconds) {
                // define very start (zero time) of playback
                console.log('Seconds init as ' + seconds);
                if (seconds == 0 || seconds < 0.11) { // this is hack to convert all unsupported results by player < 1.1 values to 0.2 and adjust current time to the same round value
                    mainPlayer.pause(); // init pause first time for further condition
                    mainPlayer.setCurrentTime(0.11); // looks like Vimeo.Player(iframe); can't hold below 0.1s
                } else {
                    // If player already on pause -- perform time jump

                    // This duration end will be use to define when to stop iterate nextFrame button
                    var videoDuration = 0.0;
                    mainPlayer.getDuration().then(function(duration) { // duration = the duration of the video in seconds
                        videoDuration = duration;
                        console.log('videoDuration init is ' + duration);
                    });

                    mainPlayer.getPaused().then(function(paused) {
                        if (paused == true) {
                            // perform the time jump
                            // Set loading indicator class
                            var sInc = (parseFloat(seconds.toFixed(1)) + 0.1).toFixed(1);

                            // console.log('----------');
                            // console.log('Seconds init as ' + seconds);
                            // console.log('sInc is ' + sInc);
                            // console.log('videoDuration is ' + videoDuration);

                            if (seconds < videoDuration - 0.7){ // this will make sure to make action and show load class only if we not reached end of the video (AND BEFORE AUTO PLAY STARTS)
                                $(nextFrame).addClass("loading");
                                mainPlayer.setCurrentTime(sInc);
                            }
                        }else{
                            mainPlayer.pause();
                        }
                    });
                }
            });
        });

        // set on prevFrame button
        var prevFrame = 'div#InformationWindow span.prevFrame';
        $(document).on('click', prevFrame, function( event ){
            mainPlayer.getCurrentTime().then(function(seconds) {
                // define very start (zero time) of playback
                console.log('Seconds init as ' + seconds);
                if (seconds == 0 || seconds <= 0.11) { // this is hack to prevent zero result that duplicates others < 1.1 values (unsupported by player) (those looks the same for timecode)
                    return true;
                } else {
                    // If player already on pause -- perform time jump
                    mainPlayer.getPaused().then(function(paused) {
                        if (paused == true) {
                            // perform the time jump
                            // Set loading indicator class

                            if (seconds > 0.2){ // this is hack to prevent subtraction that result unsupported < 1.1 values by player
                                $(prevFrame).addClass("loading");
                                var sInc = (parseFloat(seconds.toFixed(1)) - 0.1).toFixed(1);
                                mainPlayer.setCurrentTime(sInc);
                            } else {
                                mainPlayer.setCurrentTime(0.11); // return to default working minimal value
                            }
                            console.log('Result as ' + seconds);
                        }else{
                            mainPlayer.pause();
                        }
                    });
                }
            });
        });

        // convert milliseconds to timecode
        function msToTime(duration) {
            var milliseconds = parseInt((duration%1000)/10) // parseInt
                , seconds = parseInt((duration/1000)%60) // parseInt
                , minutes = parseInt((duration/(1000*60))%60); // parseInt
            /*, hours = parseInt((duration/(1000*60*60))%24);*/

            /*hours = (hours < 10) ? '0' + hours : hours;*/
            minutes = (minutes < 10) ? '0' + minutes : minutes;
            seconds = (seconds < 10) ? '0' + seconds : seconds;
            milliseconds = (milliseconds < 10) ? '0' + milliseconds : milliseconds;

            return /*hours + ':' + */'<span class="prevFrame"></span> ' + minutes + ':' + seconds + '<span>:' + milliseconds + ' </span><span class="nextFrame"></span>';
        }

        // Time update + current que point recognition
        mainPlayer.on('timeupdate', function(data) {

            var seconds = data.seconds;
            if (seconds < 0.2) {
                seconds = 0.1;
            }
            // Refresh timecode
            // var timecode = msToTime(data.seconds * 1000); // get current time and convert to proper ms
            var timecode = msToTime(Math.ceil(seconds * 10)*100); // get current time and convert to proper ms
            $('div.TimeCode').html(timecode); // put recalculated timecode to DOM

            // Looking for match each event in entire object of CuePoints
            for ( i = 0; i < videoCuePoints.length; i++) {
                if (videoCuePoints[i].time >= data.seconds - 0 && videoCuePoints[i].time <= data.seconds + .8) {
                    //console.log("!We got match on key " + videoCuePoints[i].time);

                    // Check the presence of .here in current li [data-time]
                    if ($(KeyShotsDiv + ' > li[data-time='+videoCuePoints[i].time+']').hasClass("here")) {
                        // already has .here, do nothing
                    } else {
                        $(KeyShotsDiv + ' > li').removeClass( "here" ); // delete .here from all others
                        $(KeyShotsDiv + ' > li[data-time='+videoCuePoints[i].time+']').addClass( "here" ); // add .here
                        $(KeyShotsNameDiv).hide().fadeIn(400).html('<span style="color:#899ebb;">' + videoCuePoints[i].timecode + '</span><div class="keyShot"></div>' + videoCuePoints[i].data.ShotName); // load caption
                    }
                }
            }
        });

    });

}


function urlVideo(param) {

    var Url = NowUrl;
    var prmStr = "video=";
    var Rgx = /(video=)(\d*)/;


    if ( typeof param != 'undefined' ) {

        if ( !Url.match( Rgx ) ) {
            Url = Url + '&' + prmStr + param;
        }

        var NewUrl = Url.replace( Rgx , "$1" + param );

        window.history.pushState("", "", "?" + NewUrl);

        NowUrl = NewUrl;
        return NewUrl;

    }else{
        //--Shows URLs video param
        var Rslt = "";
        if ( Rslt = Url.match( Rgx ) ) {
            if ( !isEmpty( Rslt[2] ) ) { return Rslt[2]; } else { return undefined; }
        }
    }
}



//------------------------------------------------------------------------------------
// Load Video On Click + some actions on this event

function LoadVideoOnClick (id,thisObj) {

    //Update Video Input param
    urlVideo(id);

    //Update Video Input param
    $('input#InputVideo').val(id);

    //Update Logo Button
    //$('.tpLogo').html('<a href="?video=' + id + '"></a>');

    //Update Item Box Here class
    $("div.item.here").removeClass( "here" );
    $( thisObj ).parent().parent().addClass( "here" );

    //Load Video
    LoadVideoOnPage(id);
}


//------------------------------------------------------------------------------------
// Accordion Left Panel (*Tags overview)

// *Tags overview Tag click event
$(document).on('click','a.tag-item',function( event ){
    event.preventDefault();
    var tag = $(event.target).data('tag');
    $("#singleFieldTags").tagit("removeAll");
    $("#singleFieldTags").tagit("createTag", tag);
    $('input#InputVideo').val(""); //Drop displayed video to ""
    $('#tpSearch').submit();
});

// *Tags overview Tag "here" highlight when entire document ready
$( document ).ready(function() {
    var tags_arr = NowTags.split(' ');
    $.each(tags_arr, function( index, value ) {
        $('a.tag-item[data-tag='+ value +']').addClass("here");
    });
});

$(function() {
    $( "aside#LeftPanel div.Accordion" ).accordion({
        collapsible: true,
        active: menuState,
        heightStyle: "content",
        create: function( event, ui ) {$('aside#LeftPanel div.Accordion').css("display","block")},
        activate: function( event, ui ) {
            var TagMenuActive = $( "aside#LeftPanel div.Accordion" ).accordion( "option", "active" );
            document.cookie="TagMenuState=" + TagMenuActive;
        }
    });
});




//------------------------------------------------------------------------------------
// Filter Bar Buttons

/* ScrewDefaultButtons v2.0.6 Adjustments -------------------------*/

(function(e,t,n,r){var i={init:function(t){var n=e.extend({image:null,width:50,height:50,disabled:!1},t);return this.each(function(){var t=e(this),r=n.image,i=t.data("sdb-image");i&&(r=i);r||e.error("There is no image assigned for ScrewDefaultButtons");t.wrap("<div >").css({display:"none"});var s=t.attr("class"),o=t.attr("onclick"),u=t.parent("div");u.addClass(s);u.attr("onclick",o);u.css({"background-image":r,width:n.width,height:n.height,cursor:"pointer"});var a=0,f=-n.height;if(t.is(":disabled")){a=-(n.height*2);f=-(n.height*3)}t.on("disableBtn",function(){t.attr("disabled","disabled");a=-(n.height*2);f=-(n.height*3);t.trigger("resetBackground")});t.on("enableBtn",function(){t.removeAttr("disabled");a=0;f=-n.height;t.trigger("resetBackground")});t.on("resetBackground",function(){t.is(":checked")?u.css({backgroundPosition:"0 "+f+"px"}):u.css({backgroundPosition:"0 "+a+"px"})});t.trigger("resetBackground");if(t.is(":checkbox")){u.on("click",function(){t.is(":disabled")||t.change()});u.addClass("styledCheckbox");t.on("change",function(){if(t.prop("checked")){t.prop("checked",!1);u.css({backgroundPosition:"0 "+a+"px"})}else{t.prop("checked",!0);u.css({backgroundPosition:"0 "+f+"px"})}})}else if(t.is(":radio")){u.addClass("styledRadio");var l=t.attr("name");u.on("click",function(){!t.prop("checked")&&!t.is(":disabled")&&t.change()});t.on("change",function(){if(t.prop("checked")){t.prop("checked",!1);u.css({backgroundPosition:"0 "+a+"px"})}else{t.prop("checked",!0);u.css({backgroundPosition:"0 "+f+"px"});var n=e('input[name="'+l+'"]').not(t);n.trigger("radioSwitch")}});t.on("radioSwitch",function(){u.css({backgroundPosition:"0 "+a+"px"})});var c=e(this).attr("id"),h=e('label[for="'+c+'"]');h.on("click",function(){u.trigger("click")})}if(!e.support.leadingWhitespace){var c=e(this).attr("id"),h=e('label[for="'+c+'"]');h.on("click",function(){u.trigger("click")})}})},check:function(){return this.each(function(){var t=e(this);i.isChecked(t)||t.change()})},uncheck:function(){return this.each(function(){var t=e(this);i.isChecked(t)&&t.change()})},toggle:function(){return this.each(function(){var t=e(this);t.change()})},disable:function(){return this.each(function(){var t=e(this);t.trigger("disableBtn")})},enable:function(){return this.each(function(){var t=e(this);t.trigger("enableBtn")})},isChecked:function(e){return e.prop("checked")?!0:!1}};e.fn.screwDefaultButtons=function(t,n){if(i[t])return i[t].apply(this,Array.prototype.slice.call(arguments,1));if(typeof t=="object"||!t)return i.init.apply(this,arguments);e.error("Method "+t+" does not exist on jQuery.screwDefaultButtons")};return this})(jQuery);

$(function(){
    $('input:radio').screwDefaultButtons({
        image: 'url("img/radioSmall.jpg")',
        width: 40,
        height: 40
    });

    $('input:checkbox').screwDefaultButtons({
        image: 'url("img/checkboxSmall.jpg")',
        width: 40,
        height: 40
    });

    $('.hideBeforeInit').css("display","block");
});

// Other Filter bar func
function DropTypeOnClick() {
    $('input#set').val("c0d0s0a0t0v0");
    $('#tpSearch').submit();
}

function ResetSet(tag) {
    alert("ok")
    $("#singleFieldTags").tagit("removeAll");
    $("#singleFieldTags").tagit("createTag", tag);
    $('#set').val("c0d0s0a0t0v0");
    $('#tpSearch').submit();
}


//------------------------------------------------------------------------------------
// Filter Buttons Assemble

$(document).ready(function(){

    //Объявляем ключ-код запроса
    if (NowSet.match(/[\d\w]{12}/)) {
        var mQ = NowSet;
    }else {
        var mQ = "c0d0s0a0t0v0";
    }

    function mQSetup() {
        $('#set').val(mQ);
        $('#tpSearch').submit();
    }

    //Проверяем, есть ли уже установленные chk на странице, если да - предварительно изменяем ключ-код mQ
    if ($('#comp')[0].checked == true) {mQ = mQ.replace(/c0/, 'c1')};
    if ($('#3d')[0].checked == true) {mQ = mQ.replace(/d0/, 'd1')};
    if ($('#sim')[0].checked == true) {mQ = mQ.replace(/s0/, 's1')};
    if ($('#anim')[0].checked == true) {mQ = mQ.replace(/a0/, 'a1')};
    if ($('#stpm')[0].checked == true) {mQ = mQ.replace(/t0/, 't1')};
    if ($('#vid')[0].checked == true) {mQ = mQ.replace(/v0/, 'v1')};

    //По нажатию на кнопку фильтра производим операции с mQ
    $('.styledCheckbox:has(#md)').on('click', function(){
        mQSetup();
    });

    $('.styledCheckbox:has(#comp)').on('click', function(){
        if ($('#comp').is(':checked'))
        //если кнопка уже была активирован, меняем флаг на противоположный
        {if (!mQ.match(/c1/)){mQ = mQ.replace(/c0/, 'c1')};} else
        {if (!mQ.match(/c0/)){mQ = mQ.replace(/c1/, 'c0')};}
        mQSetup();
    });

    $('.styledCheckbox:has(#3d)').on('click', function(){
        if ($('#3d').is(':checked'))
        {if (!mQ.match(/d1/)){mQ = mQ.replace(/d0/, 'd1')};} else
        {if (!mQ.match(/d0/)){mQ = mQ.replace(/d1/, 'd0')};}
        mQSetup();
    });

    $('.styledCheckbox:has(#sim)').on('click', function(){
        if ($('#sim').is(':checked'))
        {if (!mQ.match(/s1/)){mQ = mQ.replace(/s0/, 's1')};} else
        {if (!mQ.match(/s0/)){mQ = mQ.replace(/s1/, 's0')};}
        mQSetup();
    });

    $('.styledCheckbox:has(#anim)').on('click', function(){
        if ($('#anim').is(':checked'))
        {if (!mQ.match(/a1/)){mQ = mQ.replace(/a0/, 'a1')};} else
        {if (!mQ.match(/a0/)){mQ = mQ.replace(/a1/, 'a0')};}
        mQSetup();
    });

    $('.styledCheckbox:has(#stpm)').on('click', function(){
        if ($('#stpm').is(':checked'))
        {if (!mQ.match(/t1/)){mQ = mQ.replace(/t0/, 't1')};} else
        {if (!mQ.match(/t0/)){mQ = mQ.replace(/t1/, 't0')};}
        mQSetup();
    });

    $('.styledCheckbox:has(#vid)').on('click', function(){
        if ($('#vid').is(':checked'))
        {if (!mQ.match(/v1/)){mQ = mQ.replace(/v0/, 'v1')};} else
        {if (!mQ.match(/v0/)){mQ = mQ.replace(/v1/, 'v0')};}
        mQSetup();
    });

});



// Autocomplete top bar input area

$(function(){
    var sampleTags = ['realism', 'abstract', 'minimalism', 'futurism', 'surrealism', 'contemporary', 'cinematic', 'Cartoon', 'Art', 'Beauty', 'Adventures', 'Story', 'Fantasy', 'Spiritual', 'Culture', 'Sport', 'Games', 'Enertament', 'Mans', 'Womens', 'Comedy', 'Show', 'Cinema', 'Fun', 'Weird', 'News', 'Info', 'Promo', 'Test', 'Science', 'Education', 'History', 'Political', 'Social', 'Nature', 'Health', 'Industry', 'Buisness', 'Finance', 'Services', 'Vehicles', 'Technology', 'Digital', 'CG', 'Crafts', 'War', 'Criminal'];

    //-------------------------------
    // Single field
    //-------------------------------
    $('#singleFieldTags').tagit({
        showAutocompleteOnFocus: false,
        autocomplete: {delay: 0, minLength: 0},
        tagLimit: 3,
        availableTags: sampleTags,
        singleField: true,
        singleFieldNode: $('#mySingleField'),
        afterTagRemoved: function(evt, ui) {
            //document.getElementById("tpSearch").submit();
        }

    });

    // singleFieldTags2 is an INPUT element, rather than a UL as in the other
    // examples, so it automatically defaults to singleField.
    $('#singleFieldTags2').tagit({
        availableTags: sampleTags
    });

    //-------------------------------
    // Preloading data in markup
    //-------------------------------
    $('#myULTags').tagit({
        availableTags: sampleTags, // this param is of course optional. it's for autocomplete.
        // configure the name of the input field (will be submitted with form), default: item[tags]
        itemName: 'item',
        fieldName: 'tags'
    });

    //-------------------------------
    // Tag events
    //-------------------------------
    var eventTags = $('#eventTags');

    var addEvent = function(text) {
        $('#events_container').append(text + '<br>');
    };

    eventTags.tagit({
        availableTags: sampleTags,
        beforeTagAdded: function(evt, ui) {
            if (!ui.duringInitialization) {
                addEvent('beforeTagAdded: '+ eventTags.tagit('tagLabel', ui.tag));
            }
        },
        afterTagAdded: function(evt, ui) {
            if (!ui.duringInitialization) {
                addEvent('afterTagAdded: '+ eventTags.tagit('tagLabel', ui.tag));
            }
        },
        beforeTagRemoved: function(evt, ui) {
            addEvent('beforeTagRemoved: '+ eventTags.tagit('tagLabel', ui.tag));
        },
        afterTagRemoved: function(evt, ui) {
            addEvent('afterTagRemoved: '+ eventTags.tagit('tagLabel', ui.tag));
        },
        onTagClicked: function(evt, ui) {
            addEvent('onTagClicked: '+ eventTags.tagit('tagLabel', ui.tag));
        },
        onTagExists: function(evt, ui) {
            addEvent('onTagExists: '+ eventTags.tagit('tagLabel', ui.existingTag));
        }
    });

    //-------------------------------
    // Read-only
    //-------------------------------
    $('#readOnlyTags').tagit({
        readOnly: false
    });

    //-------------------------------
    // Tag-it methods
    //-------------------------------
    $('#methodTags').tagit({
        availableTags: sampleTags
    });

    //-------------------------------
    // Allow spaces without quotes.
    //-------------------------------
    $('#allowSpacesTags').tagit({
        availableTags: sampleTags,
        allowSpaces: true
    });

    //-------------------------------
    // Remove confirmation
    //-------------------------------
    $('#removeConfirmationTags').tagit({
        availableTags: sampleTags,
        removeConfirmation: true
    });

});