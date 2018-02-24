
// Display One Video from list
function ShowVideoFrame(a,id,pId) {
    // Images ON
    $(a).parents().find(".VideoThumb").css("display","block");
    $(a).parents().find(".main").css("background","none");

    // Iframes OFF
    $(a).parents().find("iframe").remove();


    // this IMG OFF
    $(a).fadeOut(100);
    $(a).parent().css("background","#000");

/*    setTimeout( function(){
        $(a).parent().css("background","url(../img/loader_0.gif) no-repeat center #27292a");
    },500);
    */


    // this IFRAME ON
    $(a).parent().append('<iframe id="player'+ pId +'" name="player'+ pId +'" src="//player.vimeo.com/video/' + id + '?api=1&player_id=player'+ pId +'&autoplay=1&loop=1&title=0&byline=0&portrait=0"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');

}


/*
var player = $('iframe#player1');
var message = "";
iframe = document.getElementById('player1');
var playerOrigin = '*';
// Helper function for sending a message to the player
function post(action, value) {
    var data = {
        method: action
    };

    if (value) {
        data.value = value;
    }

    var message = JSON.stringify(data);
    console.log(message);
    //  player.contentWindow.postMessage(message, playerOrigin);
    iframe
}

document.getElementById('player1').contentWindow.postMessage('{"method":"play"}', '*');
*/

function vimeoPlayer(act, plId, vl) { // vl can be 'addEventListener', more at https://developer.vimeo.com/player/js-api#function-compatibility
    plId = plId - 1;
    var win = window.frames[plId]; // by name = window.frames['player2']

    var data = { method: act };
    if (vl) { data.value = value; }

    var message = JSON.stringify(data);

    win.postMessage( message, '*' );
}


// Helper function for sending a message to the player
function post(action, value) {
    var data = {
        method: action
    };

    if (value) {
        data.value = value;
    }

    var message = JSON.stringify(data);
    player[0].contentWindow.postMessage(message, '*');
}

function onReady() {
    status.text('ready');

    post('addEventListener', 'pause');
    post('addEventListener', 'finish');
    post('addEventListener', 'playProgress');
}

// Infinity feed AJAX
function load_PostBox(pageurl, page){

    pageurl = pageurl + page;

    $.ajax({
        url: pageurl,
        dataType: "json",
        success: function(data){

            var jsonDataObj = data,
                Total = data.total,
                Pages = data.pages,
                thisPage = data.page;

            if ( Pages == thisPage) {
                $('main > #container').append().html('<!--No more result from database-->')
            }

            // Compile handlebar
            var tpl = $('#waterfall-tpl').html();
            var template = Handlebars.compile(tpl);

            // Append handlebar parsed
            $(document.body).find("main > #container").append(template( jsonDataObj ));

            isPreviousEventComplete = true;

            if (result == '') // When data is not available
                isDataAvailable = false;

            $(".LoaderImage").css("display", "none");
        }
    });
}


//---- Key up and down functionality with ShowVideoFrame() function
// CTRL + KEYCODE event.keyCode == 38 && event.ctrlKey

$(document).keydown(function (event) {
    //console.log(event.keyCode);
    if (event.keyCode == 38) {
        event.preventDefault();

        // console.log(getCurrentlyVisibleSection());
        scrollToPrevious();

    } else if (event.keyCode == 40) {
        event.preventDefault();

        // console.log(getCurrentlyVisibleSection());
        scrollToNext();
    }
});

function scrollToPrevious() {
    var prevElement = getCurrentlyVisibleSection().prevAll('section.PostBox');

    if (prevElement.length > 0) {
        scrollToElement(prevElement);
        prevVideoThumb = getCurrentlyVisibleSection().prev().find("img.VideoThumb");
        ShowVideoFrame( prevVideoThumb, prevVideoThumb.data('outid') );
    }
}

function scrollToNext() {
    var nextElement = getCurrentlyVisibleSection().nextAll('section.PostBox');

    /*console.log(nextElement);*/

    if (nextElement.length > 0) {
        scrollToElement(nextElement);
        nextVideoThumb = getCurrentlyVisibleSection().next().find("img.VideoThumb");
        ShowVideoFrame( nextVideoThumb, nextVideoThumb.data('outid') );
    }
}

function scrollToElement(ctrl) {

     var topIndent = 150;
     var Wd = $(window).width();


     if (Wd > 1000) topIndent = 150;
     if (Wd > 1100) topIndent = 200;
     if (Wd > 1200) topIndent = 230;
    if (Wd > 1300) topIndent = 250;
     if (Wd > 1400) topIndent = 300;

    $('html, body').animate({
        scrollTop: ctrl.offset().top - topIndent
    }, 120);

    console.log( $(window).width() + " with " + topIndent );
    //console.log( "offset - " + ctrl.offset().top );
}

function getCurrentlyVisibleSection() {

    $("section#PostBox1").visible(true);
    var rtn;

    $.each($('section.PostBox'), function (ind, val) {
        if ($(this).visible(false)) {
            //true here means ALL the element has to be visible.. change to False if you want ANY Part of the item to be visible..
            rtn = $(this);
        }
    });
    return rtn;
}

(function ($) {
    /**
     * Copyright 2012, Digital Fusion
     * Licensed under the MIT license.
     * http://teamdf.com/jquery-plugins/license/
     *
     * @author Sam Sehnert
     * @desc A small plugin that checks whether elements are within
     *       the user visible viewport of a web browser.
     *       only accounts for vertical position, not horizontal.
     */
    var $w = $(window);
    $.fn.visible = function (partial, hidden, direction) {

        if (this.length < 1) return;

        var $t = this.length > 1 ? this.eq(0) : this,
            t = $t.get(0),
            vpWidth = $w.width(),
            vpHeight = $w.height(),
            direction = (direction) ? direction : 'both',
            clientSize = hidden === true ? t.offsetWidth * t.offsetHeight : true;

        if (typeof t.getBoundingClientRect === 'function') {

            // Use this native browser method, if available.
            var rec = t.getBoundingClientRect(),
                tViz = rec.top >= 0 && rec.top < vpHeight,
                bViz = rec.bottom > 0 && rec.bottom <= vpHeight,
                lViz = rec.left >= 0 && rec.left < vpWidth,
                rViz = rec.right > 0 && rec.right <= vpWidth,
                vVisible = partial ? tViz || bViz : tViz && bViz,
                hVisible = partial ? lViz || lViz : lViz && rViz;

            if (direction === 'both') return clientSize && vVisible && hVisible;
            else if (direction === 'vertical') return clientSize && vVisible;
            else if (direction === 'horizontal') return clientSize && hVisible;
        } else {

            var viewTop = $w.scrollTop(),
                viewBottom = viewTop + vpHeight,
                viewLeft = $w.scrollLeft(),
                viewRight = viewLeft + vpWidth,
                offset = $t.offset(),
                _top = offset.top,
                _bottom = _top + $t.height(),
                _left = offset.left,
                _right = _left + $t.width(),
                compareTop = partial === true ? _bottom : _top,
                compareBottom = partial === true ? _top : _bottom,
                compareLeft = partial === true ? _right : _left,
                compareRight = partial === true ? _left : _right;

            if (direction === 'both') return !!clientSize && ((compareBottom <= viewBottom) && (compareTop >= viewTop)) && ((compareRight <= viewRight) && (compareLeft >= viewLeft));
            else if (direction === 'vertical') return !!clientSize && ((compareBottom <= viewBottom) && (compareTop >= viewTop));
            else if (direction === 'horizontal') return !!clientSize && ((compareRight <= viewRight) && (compareLeft >= viewLeft));
        }
    };

})(jQuery);