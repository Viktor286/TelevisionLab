
//------------------------------------------------------------------------------------
// Async Display Video On page + build show video module
module.exports = function() {
    $(document).ready(function () {

        tvLab.loadVideoOnPage = function (VideoId) {
            'use strict';

            // set the background gif
            $('div#preview-window').css('background-image', 'url(_global/img/loader_0.gif)');

            $.ajax('desktop/ajax/video.php', {
                success: function (response) {

                    // $('#preview-window').hide().fadeIn(150);

                    $('#preview-window').html('<div class="box">' +
                        '<iframe src="//player.vimeo.com/video/' + VideoId +
                        '?title=0&byline=0&portrait=0&autoplay=1"  frameborder="0" ' +
                        'webkitallowfullscreen mozallowfullscreen allowfullscreen>' +
                        '</iframe></div>')
                        // .load(function (e) {
                        // $(this).contents().find('body').addClass('Z');})
                    ;

                    $('#video-info').hide().html(response).fadeIn(100);

                    // remove background image
                    setTimeout(function () {
                        $('div#preview-window').css('background-image', 'none');
                    }, 1000);
                },
                data: {"VideoId": VideoId},
                cache: false

            }).done(function () {

                //-------- When Ajax Video Loaded
                // This will fire when video loaded

                // Highlight tags
                var tags_arr = tvLab.nowTags.split(' ');
                $.each(tags_arr, function (index, value) {
                    $('a.tag[data-tag=' + value + ']').addClass("here");
                });

                // Play-Pause of top panel player
                var iframe = document.querySelector('iframe');
                var mainPlayer = new Vimeo.Player(iframe);
                var playPauseBt = $("div#MPC div#PlayPause");
                var init = mainPlayer; // initialization of mainPlayer object, which is inactive till first usage

                // Time code result: playback is jumpy, no way to make decent time code
                /*        mainPlayer.on('timeupdate', function(data) {
                 console.log(data.seconds);
                 $('div.timecode').html("000" + data.seconds);
                 });*/

                // Set On PlayPause Button Event
                $(document).on('click', 'div#MPC div#PlayPause', function (event) {
                    event.preventDefault();
                    mainPlayer.getPaused().then(function (paused) {
                        if (paused === true) {
                            mainPlayer.play();
                        } else {
                            mainPlayer.pause();
                        }
                    }).catch(function (error) {  // an error occurred
                        console.log("an error occurred during on('click') mainPlayer.getPaused()");
                    });
                });

                //------ Player play/pause Actions
                var playPauseSwitch = function (paused_state) {
                    if (paused_state === true) {
                        // Pause was ON, switch to play
                        playPauseBt.removeClass("pause");
                        playPauseBt.addClass("play");
                        //console.log("Pause was ON. Show Play Button");
                    } else {
                        // Pause was OFF, turn it on
                        playPauseBt.removeClass("play");
                        playPauseBt.addClass("pause");
                        //console.log("Pause was OFF. Show Pause Button");
                    }
                }

                mainPlayer.on('play', function (data) {
                    // data is an object containing properties specific to that event (play data: duration, percent, seconds)
                    mainPlayer.getPaused().then(function (paused) {
                        playPauseSwitch(paused);
                    }).catch(function (error) {
                        // an error occurred
                        console.log("an error occurred during mainPlayer.getPaused()");
                    });
                });

                mainPlayer.on('pause', function (data) {
                    // data is an object containing properties specific to that event
                    mainPlayer.getPaused().then(function (paused) {
                        playPauseSwitch(paused);
                    }).catch(function (error) {
                        // an error occurred
                        console.log("an error occurred during mainPlayer.getPaused()");
                    });
                });

                // Init AutoPlay param and UI by getting tvLab.autoPlayState from cookie (php-cookie-pipe).
                if (tvLab.autoPlayState === 1) {
                    tvLab.setAutoPlayUI("Next");
                    mainPlayer.setLoop(false);
                    //console.log("init tvLab.autoPlayState == 1");
                } else {
                    tvLab.setAutoPlayUI("Cycle");
                    mainPlayer.setLoop(true);
                    //console.log("init tvLab.autoPlayState == 0");
                }


                //------ Auto Next Play Button
                // AutoPlay button on.click Actions
                $(document).on('click', 'div#MPC div.AutoPlay', function (event) {
                    event.preventDefault();
                    if (tvLab.autoPlayState === 1) {
                        // If tvLab.autoPlayState toggle was ON, then switch this back to 0, Cycle
                        mainPlayer.setLoop(true).then(function (loop) { // Set player loop on
                            tvLab.setAutoPlayUI("Cycle"); // Change UI
                            tvLab.autoPlayState = 0; // Change UI state
                            document.cookie = "tvLab.autoPlayState=" + tvLab.autoPlayState; // Change cookie state
                            //console.log("Set loop on: player, UI, var, cookie.");
                        }).catch(function (error) {
                            console.log("an error occurred during mainPlayer.setLoop(true)");
                        });
                    } else {
                        // If tvLab.autoPlayState toggle is ON, then switch this to Cycle
                        mainPlayer.setLoop(false).then(function (loop) { // Set player loop off
                            tvLab.setAutoPlayUI("Next"); // Change UI
                            tvLab.autoPlayState = 1; // Change UI state
                            document.cookie = "tvLab.autoPlayState=" + tvLab.autoPlayState; // Change cookie state
                            //console.log("Set loop off, autoplay on: player, UI, var, cookie.");
                        }).catch(function (error) {
                            console.log("an error occurred during mainPlayer.setLoop(true)");
                        });
                    }
                });

                //------ Auto Next Play Video Functionality
                mainPlayer.on('ended', function (data) { // This event fires only if loop is off
                    // data is an object containing properties specific to that event
                    tvLab.videoGoAndPlay("Next");
                });


                //------ CuePoints Prev/Next init

                // 1. Get all CuePoints for video
                //console.log('1. Get all CuePoints for video.');
                mainPlayer.getCuePoints().then(function (cuePoints) {
                    //console.log('Primary collection getCuePoints() worked fine: ');
                    // console.log(cuePoints);

                    // 2. Delete all existing CuePoints for loaded media
                    if (cuePoints.length > 0) {
                        // console.log('Some CuePoints already exist for loaded media.');
                        // console.log('Deleting all existing CuePoints for loaded media');
                        for (var i = 0; i < cuePoints.length; i++) {

                            mainPlayer.removeCuePoint(cuePoints[i].id).then(function (id) { // cuePoints = an array of cue point objects
                                // console.log('cue point ' + id + ' was removed successfully: ');
                            }).catch(function (error) {
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

                }).catch(function (error) { // catch for mainPlayer.getCuePoints()
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

                mainPlayer.getDuration().then(function (duration) { // duration = the duration of the video in seconds
                    // this getDuration callback need to calculate time point for test demo
                    // and it will be replaced by 'DB CuePoints data' callback

                    var equalPart = Math.floor(parseInt(duration) / 5);
                    var videoCuePointsForDemo = [1, equalPart * 2, equalPart * 3, equalPart * 4, duration - 1];

                    // console.log('videoCuePointsForDemo: '+videoCuePointsForDemo);

                    // temp data object
                    var videoCuePoints = [
                        {
                            "time": videoCuePointsForDemo[0],
                            "data": {
                                "ShotTag": "KeyShot-1",
                                "ShotName": "First key shot looks nice." // this is "customKey": "customValue"
                            },
                            "id": "videoCuePoint-0"
                        },
                        {
                            "time": videoCuePointsForDemo[1],
                            "data": {
                                "ShotTag": "ShotTag",
                                "ShotName": "This one not bad too!"
                            },
                            "id": "videoCuePoint-1"
                        },
                        {
                            "time": videoCuePointsForDemo[2],
                            "data": {
                                "ShotTag": "CustomTag",
                                "ShotName": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
                            },
                            "id": "videoCuePoint-2"
                        },
                        {
                            "time": videoCuePointsForDemo[3],
                            "data": {
                                "ShotTag": "CoolTag",
                                "ShotName": "Composition and color are worth to checkout."
                            },
                            "id": "videoCuePoint-3"
                        },
                        {
                            "time": videoCuePointsForDemo[4],
                            "data": {
                                "ShotTag": "LastKeyShot",
                                "ShotName": "Well, this is just last key shot in this cue."
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

                        mainPlayer.addCuePoint(videoCuePoints[i].time, videoCuePoints[i].data).then(function (id) {
                            //console.log('cue point ' + i + ' was added successfully with id: ' + id);

                        });
                    }

                    // 4. Get all CuePoints again
                    mainPlayer.getCuePoints().then(function (videoCuePoints) {
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

                    var KeyShotsDiv = 'div#video-info > .left > div.KeyShots > ul';
                    var KeyShotsNameDiv = 'div#video-info > .left > div.KeyShots > div.ShotName > span';

                    // div#NextShot controller
                    $(document).on('click', 'div#MPC div#NextShot', function (event) {
                        event.preventDefault();

                        var buttonNextShot = $(this);
                        buttonNextShot.addClass("disabled");

                        // Get Current Time to calculate where we are and where to go
                        mainPlayer.getCurrentTime().then(function (currentTime) {

                            // Find nearest point for currentTime
                            // Find absolute difference between currentTime and all cuePoints in data set
                            for (i = 0; i < cuePointsIdList.length; i++) {
                                absDiffArr[i] = Math.abs(cuePointsIdList[i] - currentTime);
                            }
                            nearestIndex = tvLab.indexOfMin(absDiffArr); // Get Index of nearest element
                            nearestCuePoint = cuePointsIdList[nearestIndex]; // Get nearest CuePoint through this Index

                            // Compare currentTime and nearestCuePoint to define correct nextCuePoint.
                            if (currentTime * 1000 >= nearestCuePoint * 1000) {
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
                            $(KeyShotsDiv + ' > li').removeClass("load");
                            $(KeyShotsDiv + ' > li').eq(thisIndex).addClass('load');
                            // $(KeyShotsNameDiv).text('loading...');

                            // Set current nextCuePoint time

                            mainPlayer.setCurrentTime(nextCuePoint.time).then(function (second) {
                                //mainPlayer.pause();
                                buttonNextShot.removeClass("disabled");
                                $(KeyShotsDiv + ' > li').removeClass("load");
                                LoadVideoShotSwitch(nextCuePoint);
                                //console.log('Set time by div#NextShot to ' + second);
                            });

                        });
                    });

                    // div#PrevShot controller
                    $(document).on('click', 'div#MPC div#PrevShot', function (event) {
                        event.preventDefault();
                        var buttonPrevShot = $(this);
                        buttonPrevShot.addClass("disabled");

                        // Get Current Time to calculate where we are and where to go
                        mainPlayer.getCurrentTime().then(function (currentTime) {

                            // Find nearest point for currentTime
                            // Find absolute difference between currentTime and all cuePoints in data set
                            for (i = 0; i < cuePointsIdList.length; i++) {
                                absDiffArr[i] = Math.abs(cuePointsIdList[i] - currentTime);
                            }
                            nearestIndex = tvLab.indexOfMin(absDiffArr); // Get Index of nearest element
                            nearestCuePoint = cuePointsIdList[nearestIndex]; // Get nearest CuePoint through this Index

                            // Compare currentTime and nearestCuePoint to define correct prevCuePoint.
                            if (currentTime * 1000 <= nearestCuePoint * 1000 + 1000) { // add additional delay for back clicking
                                prevCuePointIndex = nearestIndex - 1;

                                // if we pass the nearest point, prev point will be just prev item in array
                                if (prevCuePointIndex < 0) { // But. If this index went beyond array, then return to last cuePoint in array
                                    prevCuePointIndex = videoCuePoints.length - 1;
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
                            $(KeyShotsDiv + ' > li').removeClass("load");
                            $(KeyShotsDiv + ' > li').eq(thisIndex).addClass('load');
                            // $(KeyShotsNameDiv).text('loading...');

                            // Set current prevCuePoint time

                            mainPlayer.setCurrentTime(prevCuePoint.time).then(function (second) {
                                //mainPlayer.pause();
                                buttonPrevShot.removeClass("disabled");
                                $(KeyShotsDiv + ' > li').removeClass("load");
                                LoadVideoShotSwitch(prevCuePoint);
                                // console.log('Set time by div#PrevShot to ' + second);
                            });

                        });
                    });


                    // Set the first ShotName in videoCuePoints and set all the LI
                    $(KeyShotsNameDiv).html('<span style="color:#878787;">' + videoCuePoints.length + ' shot points...</span>');
                    // $('div#video-info > .left > div.KeyShots > div.ShotName').hide();

                    // Set the LI elements
                    for (i = 0; i < videoCuePoints.length; i++) {
                        $(KeyShotsDiv).append('<li data-time="' + videoCuePoints[i].time + '">' + videoCuePoints[i].data.ShotTag + '</li>');
                    }

                    var LoadVideoShotSwitch = function (keyShot) { // keyShot = object by numerical order from videoCuePoints data set
                        // Write Shot Name in state text block
                        // remove old .here
                        $(KeyShotsDiv + ' > li.here').removeClass("here");
                        // set new .here and delete .load
                        $(KeyShotsDiv + ' > li[data-time=' + keyShot.time + ']').removeClass("load").addClass("here");
                        // $(KeyShotsNameDiv).hide().fadeIn(400).text(keyShot.data.ShotName);
                    }

                    // Controller to key shots link list
                    $(document).on('click', KeyShotsDiv + ' > li', function (event) {
                        event.preventDefault();

                        //if (!$( this ).hasClass( "here" )){ // don't do on .here class
                        var keyShot = videoCuePoints[$(this).index()]; // object by numerical order from videoCuePoints data set
                        // Start load the Cue Point
                        $(KeyShotsDiv + ' > li').removeClass("load");
                        $(this).addClass('load');
                        // $(KeyShotsNameDiv).text('loading...');
                        // Jump to ney key shot
                        mainPlayer.setCurrentTime(keyShot.time).then(function (second) {
                            LoadVideoShotSwitch(keyShot);
                        });
                        //}
                    });

                    // convert milliseconds to timecode
                    var msToTime = function (duration) {
                        var milliseconds = parseInt((duration % 1000) / 10) // parseInt
                            , seconds = parseInt((duration / 1000) % 60) // parseInt
                            , minutes = parseInt((duration / (1000 * 60)) % 60); // parseInt
                        /*, hours = parseInt((duration/(1000*60*60))%24);*/

                        /*hours = (hours < 10) ? '0' + hours : hours;*/
                        minutes = (minutes < 10) ? '0' + minutes : minutes;
                        seconds = (seconds < 10) ? '0' + seconds : seconds;
                        milliseconds = (milliseconds < 10) ? '0' + milliseconds : milliseconds;

                        return /*hours + ':' + */'<span class="prevFrame"></span> ' + minutes + ':' + seconds + '<span>:' + milliseconds + ' </span><span class="nextFrame"></span>';
                    }

                    // Time update + current que point recognition
                    mainPlayer.on('timeupdate', function (data) {

                        var seconds = data.seconds;
                        if (seconds < 0.2) {
                            seconds = 0.1;
                        }
                        // Refresh timecode
                        // var timecode = msToTime(data.seconds * 1000); // get current time and convert to proper ms
                        var timecode = msToTime(Math.ceil(seconds * 10) * 100); // get current time and convert to proper ms
                        $('div.TimeCode').html(timecode); // put recalculated timecode to DOM

                        // Looking for match each event in entire object of CuePoints
                        for (i = 0; i < videoCuePoints.length; i++) {
                            if (videoCuePoints[i].time >= data.seconds - 0 && videoCuePoints[i].time <= data.seconds + .8) {
                                //console.log("!We got match on key " + videoCuePoints[i].time);

                                // Check the presence of .here in current li [data-time]
                                if ($(KeyShotsDiv + ' > li[data-time=' + videoCuePoints[i].time + ']').hasClass("here")) {
                                    // already has .here, do nothing
                                } else {
                                    $(KeyShotsDiv + ' > li').removeClass("here"); // delete .here from all others
                                    $(KeyShotsDiv + ' > li[data-time=' + videoCuePoints[i].time + ']').addClass("here"); // add .here
                                    $(KeyShotsNameDiv).hide().fadeIn(200).html('<span style="color:#899ebb;">' + videoCuePoints[i].timecode + '</span><div class="keyShot"></div>' + videoCuePoints[i].data.ShotName); // load caption
                                }
                            }
                        }
                    });
                });


                // prevFrame/nextFrame buttons
                //---------------------------------------------------
                // looks like Vimeo.Player() can't hold values below 0.1s
                // object can give and accept only seconds starts from 0.11s
                // which timecode interprets as 00:00:02 and duplicates this with true 00:00:02
                // We also have autoplay cycle problem, which starts video from the beginning at near of the end

                // set on nextFrame button
                var nextFrame = 'div#video-info span.nextFrame';
                $(document).on('click', nextFrame, function (event) {
                    mainPlayer.getCurrentTime().then(function (seconds) {
                        // define very start (zero time) of playback
                        // console.log('Seconds init as ' + seconds);
                        if (seconds === 0 || seconds < 0.11) { // this is hack to convert all unsupported results by player < 1.1 values to 0.2 and adjust current time to the same round value
                            mainPlayer.pause(); // init pause first time for further condition
                            mainPlayer.setCurrentTime(0.11); // looks like Vimeo.Player(iframe); can't hold below 0.1s
                        } else {
                            // If player already on pause -- perform time jump

                            // This duration end will be use to define when to stop iterate nextFrame button
                            var videoDuration = 0.0;
                            mainPlayer.getDuration().then(function (duration) { // duration = the duration of the video in seconds
                                videoDuration = duration;
                                // console.log('videoDuration init is ' + duration);
                            });

                            mainPlayer.getPaused().then(function (paused) {
                                if (paused === true) {
                                    // perform the time jump
                                    // Set loading indicator class
                                    var sInc = (parseFloat(seconds.toFixed(1)) + 0.1).toFixed(1);

                                    // console.log('----------');
                                    // console.log('Seconds init as ' + seconds);
                                    // console.log('sInc is ' + sInc);
                                    // console.log('videoDuration is ' + videoDuration);

                                    if (seconds < videoDuration - 0.7) { // this will make sure to make action and show load class only if we not reached end of the video (AND BEFORE AUTO PLAY STARTS)
                                        $(nextFrame).addClass("loading");
                                        mainPlayer.setCurrentTime(sInc);
                                    }
                                } else {
                                    mainPlayer.pause();
                                }
                            });
                        }
                    });
                });

                // set on prevFrame button
                var prevFrame = 'div#video-info span.prevFrame';
                $(document).on('click', prevFrame, function (event) {
                    mainPlayer.getCurrentTime().then(function (seconds) {
                        // define very start (zero time) of playback
                        // console.log('Seconds init as ' + seconds);
                        if (seconds === 0 || seconds <= 0.11) { // this is hack to prevent zero result that duplicates others < 1.1 values (unsupported by player) (those looks the same for timecode)
                            return true;
                        } else {
                            // If player already on pause -- perform time jump
                            mainPlayer.getPaused().then(function (paused) {
                                if (paused === true) {
                                    // perform the time jump
                                    // Set loading indicator class

                                    if (seconds > 0.2) { // this is hack to prevent subtraction that result unsupported < 1.1 values by player
                                        $(prevFrame).addClass("loading");
                                        var sInc = (parseFloat(seconds.toFixed(1)) - 0.1).toFixed(1);
                                        mainPlayer.setCurrentTime(sInc);
                                    } else {
                                        mainPlayer.setCurrentTime(0.11); // return to default working minimal value
                                    }
                                    // console.log('Result as ' + seconds);
                                } else {
                                    mainPlayer.pause();
                                }
                            });
                        }
                    });
                });

            });

        };

    });
};
