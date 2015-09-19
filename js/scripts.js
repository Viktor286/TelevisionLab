//hide the divs depends of size
/*
function hideBlocks(){

    if ($(window).width() < 1024) {

        $(".infoline").fadeOut("slow");

    }else{

        $(".infoline").fadeIn("slow");

    }

}
*/

//on parent document load init
/*
 $(document).ready(function () {

 //on load resizable blocks
 hideBlocks();

 //hive resizable blocks
 $(window).resize(function(){
 hideBlocks();
 });

 });




 document.getElementById("tpSearch").submit();
 */

function isEmpty(str) {
    return (!str || 0 === str.length);
}


/*  AdjustH1InfoOutput Line */
$( document ).ready(function() {
    $( "span.tag span.x-close" ).on( "click", function( event ) {

        $("#singleFieldTags").tagit("removeAll");
        document.getElementById("tpSearch").submit();

    });
});


/*  ??? */
$( document ).ready(function() {

    $( "#BoardSetup div.BoardTitle" ).on( "click", function( event ) {

        BoardState = $( "#BoardSetup div.BoardTitle" ).data( "state" );

        if ( BoardState == 1 ) { BoardState = 0; } else { BoardState = 1; }

        $.ajax('ajax_handler.php', {
            method: "POST",
            success: function(response) {
                location.reload();
            },
            data: {"boardstate": BoardState},
            cache: false
        });

    });

});

//------------------------------------------------------------------------------------
// Display Video On page load
function LoadVideoOnPage(VideoId) {

    $.ajax('video.php', {
        success: function(response) {
            $('#PreviewWindow').html('<iframe src="//player.vimeo.com/video/' + VideoId + '?portrait=0" width="650" height="366" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
            $('#InformationWindow').hide().html(response).fadeIn(250);
        },
        data: {"VideoId": VideoId},
        cache: false
    });

}


//------------------------------------------------------------------------------------
// Load Video On Click + some actions on this event

function LoadVideoOnClick (id,ThisLink) {
    if (isEmpty(NowVid)) {
        var wasEmpty = 1;
    }

    //Url Update
    if (!NowUrl.match(/&{0,1}video=\d*/)) {
        NowUrl = NowUrl.replace(/&{0,1}video=/, ""); //исключаем случай, когда из GET передался пустой параметр &video= в URL
        NowUrl = NowUrl + '&video=' + id;
    }

    NewUrl = NowUrl.replace(/video=\d*/, 'video=' + id);
    NowUrl = NewUrl;
    NewUrl = "?" + NewUrl;

    window.history.pushState("", "", NewUrl);

    // At this moment check to reload or continue
    if (wasEmpty == 1) {
        location.reload();
    } else {
        //Set Video Input param
        $('#InputVideo').val(id)

        //Logo Button Update
        $('.tpLogo').html('<a href="?video=' + id + '"></a>');

        //Item Box Here update
        $("div.item .box.here").removeClass( "here" );
        $( ThisLink ).parent().addClass( "here" );

        //Use existing function to Load Video
        LoadVideoOnPage(id);
    }

}

//------------------------------------------------------------------------------------
// Drop Type On Click

function DropTypeOnClick() {
    $('#set').val("c0d0s0a0t0v0");
    $('#tpSearch').submit();
}


//------------------------------------------------------------------------------------
// Tag managment system (Accordion Left)

function ResetSet (tag) {
    $("#singleFieldTags").tagit("removeAll");
    $("#singleFieldTags").tagit("createTag", tag);
    $('#set').val("c0d0s0a0t0v0");
    $('#tpSearch').submit();
}

function LPoTC (tag) {

    $("#singleFieldTags").tagit("removeAll");
    $("#singleFieldTags").tagit("createTag", tag);
    document.getElementById("tpSearch").submit();

}



//------------------------------------------------------------------------------------
// Accordion Left Panel (LeftPanel)
$(function() {
    $( "aside#LeftPanel" ).accordion({
        collapsible: true,
        active: menuState,
        heightStyle: "content",
        create: function( event, ui ) {$('aside#LeftPanel').css("display","block")},
        activate: function( event, ui ) {
            var TagMenuActive = $( "aside#LeftPanel" ).accordion( "option", "active" );

            $.ajax({
                url: 'ajax_handler.php',
                type: 'POST',
                data: {tmstate: '"' + TagMenuActive + '"'},
                dataType : 'json',
                success: function(data, textStatus, xhr) {
                    console.log(data); // do with data e.g success message
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(textStatus.reponseText);
                }
            });
        }
    });
});


/* ScrewDefaultButtons v2.0.6 Adjustments -------------------------*/
/* Locate on Top Panel

 */(function(e,t,n,r){var i={init:function(t){var n=e.extend({image:null,width:50,height:50,disabled:!1},t);return this.each(function(){var t=e(this),r=n.image,i=t.data("sdb-image");i&&(r=i);r||e.error("There is no image assigned for ScrewDefaultButtons");t.wrap("<div >").css({display:"none"});var s=t.attr("class"),o=t.attr("onclick"),u=t.parent("div");u.addClass(s);u.attr("onclick",o);u.css({"background-image":r,width:n.width,height:n.height,cursor:"pointer"});var a=0,f=-n.height;if(t.is(":disabled")){a=-(n.height*2);f=-(n.height*3)}t.on("disableBtn",function(){t.attr("disabled","disabled");a=-(n.height*2);f=-(n.height*3);t.trigger("resetBackground")});t.on("enableBtn",function(){t.removeAttr("disabled");a=0;f=-n.height;t.trigger("resetBackground")});t.on("resetBackground",function(){t.is(":checked")?u.css({backgroundPosition:"0 "+f+"px"}):u.css({backgroundPosition:"0 "+a+"px"})});t.trigger("resetBackground");if(t.is(":checkbox")){u.on("click",function(){t.is(":disabled")||t.change()});u.addClass("styledCheckbox");t.on("change",function(){if(t.prop("checked")){t.prop("checked",!1);u.css({backgroundPosition:"0 "+a+"px"})}else{t.prop("checked",!0);u.css({backgroundPosition:"0 "+f+"px"})}})}else if(t.is(":radio")){u.addClass("styledRadio");var l=t.attr("name");u.on("click",function(){!t.prop("checked")&&!t.is(":disabled")&&t.change()});t.on("change",function(){if(t.prop("checked")){t.prop("checked",!1);u.css({backgroundPosition:"0 "+a+"px"})}else{t.prop("checked",!0);u.css({backgroundPosition:"0 "+f+"px"});var n=e('input[name="'+l+'"]').not(t);n.trigger("radioSwitch")}});t.on("radioSwitch",function(){u.css({backgroundPosition:"0 "+a+"px"})});var c=e(this).attr("id"),h=e('label[for="'+c+'"]');h.on("click",function(){u.trigger("click")})}if(!e.support.leadingWhitespace){var c=e(this).attr("id"),h=e('label[for="'+c+'"]');h.on("click",function(){u.trigger("click")})}})},check:function(){return this.each(function(){var t=e(this);i.isChecked(t)||t.change()})},uncheck:function(){return this.each(function(){var t=e(this);i.isChecked(t)&&t.change()})},toggle:function(){return this.each(function(){var t=e(this);t.change()})},disable:function(){return this.each(function(){var t=e(this);t.trigger("disableBtn")})},enable:function(){return this.each(function(){var t=e(this);t.trigger("enableBtn")})},isChecked:function(e){return e.prop("checked")?!0:!1}};e.fn.screwDefaultButtons=function(t,n){if(i[t])return i[t].apply(this,Array.prototype.slice.call(arguments,1));if(typeof t=="object"||!t)return i.init.apply(this,arguments);e.error("Method "+t+" does not exist on jQuery.screwDefaultButtons")};return this})(jQuery);

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

     $('div.hideBeforeInit').css("display","block")

		});


//------------------------------------------------------------------------------------
// Filter Buttons Assemble by Javascript Function

$(document).ready(function(){

//Объявляем ключ-код запроса
    if (NowSet.match(/[\d\w]{12}/)) {
        var mQ = NowSet;
    }else {
        var mQ = "c0d0s0a0t0v0";
    }

/*

function mQSetup2() {
	//Ставим mQ в скрытый параметр в форме
	$('#set').val(mQ);
	
	//Проверяем имеет ли url параметр &set=mQ, если нет, то ставим принудительно, поскольку дальше будет его редакция.
	//Достаем NowUrl, объявленый в index.php с помощью http_build_query($_GET, '', '&')
	
	if (!NowUrl.match(/&{0,1}set=[\d\w]{12}/)) {
		NowUrl = NowUrl.replace(/&{0,1}set=/, ""); //исключаем случай, когда из GET передался пустой параметр &set= в URL
		NowUrl = NowUrl + "&set=c0d0s0a0t0v0";
		}

	//и заменяем на обновленный код mQ
	NewUrl = NowUrl.replace(/set=.{12}/, "set=" + mQ);
	NowUrl = NewUrl;
	
	//Корректируем полученный URL для текущей дирректории
	NewUrl = "?" + NewUrl;


	//window.history.pushState("", "", NewUrl); //Меняем URL в адресной строке
	//location.reload(); //перезагружаем страницу
	}
*/


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



