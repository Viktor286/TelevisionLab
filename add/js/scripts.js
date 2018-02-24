
/* -------- div class="ExpandDesc   AutoExpand System */



$(document).ready(function() {

	var StartHeight = $('div.Description pre').height();
	if ($('div.Description pre').height() >= 160)
	{
		$('div.Description pre').height(160);
		var State = "closed";
		
		$( 'div.ExpandDesc' ).click(function() {
			
			if (State == "closed"){
				
			$('div.Description pre').animate({
					height: StartHeight,
					class: 'ExpandDescUp'
					}, 500, function() {
					// Animation complete.
					State = "open";
				});
			} else {
			$('div.Description pre').animate({
					height: 160

					}, 500, function() {
					// Animation complete.
					State = "closed";
				});
			}
		});
		
	} else {$( 'div.ExpandDesc' ).hide();}


});



/* --------    AutoTagSystem */


$(document).ready(function() {
	$('span.tagInsertSa').on("click",function(){

		var state = $('textarea#sa').val();
		var tag = $( this ).text();

		if (!state.match(new RegExp(tag, "i")) ) 
			{
				if (state.length == 0) {
				$('textarea#sa').val( tag );
					}else{
				$('textarea#sa').val( state + ", " + tag );
					}
			}

        //$( this ).fadeOut(300)
        $( this ).css({"border-color": "#3d5e8e", "color": "#4D4D4D"})
		});

});

$(document).ready(function() {
	$('span.tagInsertFashion').on("click",function(){
		var state = $('textarea#fashion').val();
		var tag = $( this ).text();

		if (!state.match(new RegExp(tag, "i")) ) 
			{
				if (state.length == 0) {
				$('textarea#fashion').val( tag );
					}else{
				$('textarea#fashion').val( state + ", " + tag );
					}
			}
        $( this ).css("border-color", "#3d5e8e")

		});
});


$(document).ready(function() {
	$('span.tagInsertMusic').on("click",function(){
		var state = $('textarea#music').val();
		var tag = $( this ).text();
		if (!state.match(new RegExp(tag, "i")) ) 
			{
				if (state.length == 0) {
				$('textarea#music').val( tag );
					}else{
				$('textarea#music').val( state + ", " + tag );
					}
			}
        $( this ).css("border-color", "#3d5e8e")
		});
});

$(document).ready(function() {
	$('span.tagInsertArts').on("click",function(){
		var state = $('textarea#arts').val();
		var tag = $( this ).text();
		if (!state.match(new RegExp(tag, "i")) ) 
			{
				if (state.length == 0) {
				$('textarea#arts').val( tag );
					}else{
				$('textarea#arts').val( state + ", " + tag );
					}
			}
        $( this ).css("border-color", "#3d5e8e")
		});
});


$(document).ready(function() {
	$('span.tagInsertTags').on("click",function(){
		var state = $('textarea#tags').val();
		var tag = $( this ).text();
		if (!state.match(new RegExp(tag, "i")) ) 
			{
				if (state.length == 0) {
				$('textarea#tags').val( tag );
					}else{
				$('textarea#tags').val( state + ", " + tag );
					}
			}
        $( this ).css("border-color", "#3d5e8e")
		});
});







//$('#usernames').val( $('#usernames').val().replace('.html',''));




/*!
 * ScrewDefaultButtons v2.0.6
 * http://screwdefaultbuttons.com/
 *
 * Licensed under the MIT license.
 * Copyright 2013 Matt Solano http://mattsolano.com
 *
 * Date: Mon February 25 2013
 */(function(e,t,n,r){var i={init:function(t){var n=e.extend({image:null,width:50,height:50,disabled:!1},t);return this.each(function(){var t=e(this),r=n.image,i=t.data("sdb-image");i&&(r=i);r||e.error("There is no image assigned for ScrewDefaultButtons");t.wrap("<div >").css({display:"none"});var s=t.attr("class"),o=t.attr("onclick"),u=t.parent("div");u.addClass(s);u.attr("onclick",o);u.css({"background-image":r,width:n.width,height:n.height,cursor:"pointer"});var a=0,f=-n.height;if(t.is(":disabled")){a=-(n.height*2);f=-(n.height*3)}t.on("disableBtn",function(){t.attr("disabled","disabled");a=-(n.height*2);f=-(n.height*3);t.trigger("resetBackground")});t.on("enableBtn",function(){t.removeAttr("disabled");a=0;f=-n.height;t.trigger("resetBackground")});t.on("resetBackground",function(){t.is(":checked")?u.css({backgroundPosition:"0 "+f+"px"}):u.css({backgroundPosition:"0 "+a+"px"})});t.trigger("resetBackground");if(t.is(":checkbox")){u.on("click",function(){t.is(":disabled")||t.change()});u.addClass("styledCheckbox");t.on("change",function(){if(t.prop("checked")){t.prop("checked",!1);u.css({backgroundPosition:"0 "+a+"px"})}else{t.prop("checked",!0);u.css({backgroundPosition:"0 "+f+"px"})}})}else if(t.is(":radio")){u.addClass("styledRadio");var l=t.attr("name");u.on("click",function(){!t.prop("checked")&&!t.is(":disabled")&&t.change()});t.on("change",function(){if(t.prop("checked")){t.prop("checked",!1);u.css({backgroundPosition:"0 "+a+"px"})}else{t.prop("checked",!0);u.css({backgroundPosition:"0 "+f+"px"});var n=e('input[name="'+l+'"]').not(t);n.trigger("radioSwitch")}});t.on("radioSwitch",function(){u.css({backgroundPosition:"0 "+a+"px"})});var c=e(this).attr("id"),h=e('label[for="'+c+'"]');h.on("click",function(){u.trigger("click")})}if(!e.support.leadingWhitespace){var c=e(this).attr("id"),h=e('label[for="'+c+'"]');h.on("click",function(){u.trigger("click")})}})},check:function(){return this.each(function(){var t=e(this);i.isChecked(t)||t.change()})},uncheck:function(){return this.each(function(){var t=e(this);i.isChecked(t)&&t.change()})},toggle:function(){return this.each(function(){var t=e(this);t.change()})},disable:function(){return this.each(function(){var t=e(this);t.trigger("disableBtn")})},enable:function(){return this.each(function(){var t=e(this);t.trigger("enableBtn")})},isChecked:function(e){return e.prop("checked")?!0:!1}};e.fn.screwDefaultButtons=function(t,n){if(i[t])return i[t].apply(this,Array.prototype.slice.call(arguments,1));if(typeof t=="object"||!t)return i.init.apply(this,arguments);e.error("Method "+t+" does not exist on jQuery.screwDefaultButtons")};return this})(jQuery);
 
/* ScrewDefaultButtons v2.0.6 Adjustments -------------------------*/
 $(function(){
			$('input:radio').screwDefaultButtons({
				image: 'url("img/radioSmall.jpg")',
				width: 49,
				height: 56
			});
			
			$('input:checkbox').screwDefaultButtons({
				image: 'url("img/checkboxSmall.jpg")',
				width: 40,
				height: 40
			});
		});
 


/*
slider widget
http://jqueryui.com/slider/#rangemin
-----------------#Rating */

function RatingComment(value) {
		if (value > 1000 && value < 16000) {
		$( "#RatingComment" ).text( 'Might be better' );}
		
		if (value > 16000 && value < 25000) {
		$( "#RatingComment" ).text( 'Ok' );}
		
		if (value > 25000 && value < 35000) {
		$( "#RatingComment" ).text( 'Just fine' );}
		
		if (value > 35000 && value < 45000) {
		$( "#RatingComment" ).text( 'Good enough' );}
		
		if (value > 45000 && value < 55000) {
		$( "#RatingComment" ).text( 'Cool' );}
		
		if (value > 55000 && value < 65000) {
		$( "#RatingComment" ).text( 'Ice cold' );}
		
		if (value > 65000 && value < 75000) {
		$( "#RatingComment" ).text( 'Superb' );}
		
		if (value > 75000 && value < 85000) {
		$( "#RatingComment" ).text( 'Glorious' );}
		
		if (value > 85000 && value < 95000) {
		$( "#RatingComment" ).text( 'Magnificent!' );}
		
		if (value > 95000 && value < 100500) {
		$( "#RatingComment" ).text( 'GODLIKE' );}
}

function TempoComment(value) {
		if (value >= 45 && value <= 55) {
		$( "#TempoComment" ).html( 'Медленно<br /><i>(Adagio)</i>' );}
		
		if (value > 55 && value < 75) {
		$( "#TempoComment" ).html( 'Умеренно<br /><i>(Andante)</i>' );}
		
		if (value > 75 && value < 95) {
		$( "#TempoComment" ).html( 'Средний темп <br /><i>(Moderato)</i>' );}
		
		if (value > 95 && value < 115) {
		$( "#TempoComment" ).html( 'Оживленно <br /><i>(Animato)</i>' );}
		
		if (value > 115 && value < 135) {
		$( "#TempoComment" ).html( 'Скоро<br /><i>(Allegro)</i>' );}
		
		if (value > 135 && value < 155) {
		$( "#TempoComment" ).html( 'Живо<br /><i>(Vivo)</i>' );}
		
		if (value > 155 && value < 175) {
		$( "#TempoComment" ).html( 'Быстро<br /><i>(Presto)</i>' );}
		
		if (value > 175 && value < 200) {
		$( "#TempoComment" ).html( 'Очень быстро<br /><i>(Prestissimo)</i>' );}
	}



$(function() {
    $( "#Rating" ).slider({
      range: "min",
      min: 1000,
      max: 100500,
      slide: function( event, ui ) {
        $( "#RatingAmount" ).val( ui.value );
		$( "#RatingDisplay" ).text( ui.value );
		RatingComment(ui.value);
      }
    });
	
  });
  

/*----------------- #Tempo */
  
$(function() {
    $( "#Tempo" ).slider({
      range: "min",
      value: 75,
	  step: 20,
      min: 45,
      max: 185,
      slide: function( event, ui ) {
        $( "#TempoAmount" ).val( ui.value );
		$( "#TempoDisplay" ).text( ui.value);
		TempoComment(ui.value);
      }
    });

  });
 

  /* Indicators
  
largo (очень медленно), 45
adagio (спокойно), 55
andante (умеренно), 65
moderato (средний темп), 85
animato (оживленно), 110
allegro (скоро), 130
vivo (быстро, живо), 170
presto (очень быстро) 190
  
  
		if (ui.value > 60 && ui.value < 90) {
		$( "#TempoComment" ).text( 'Dub/Reggae' );}
		
		if (ui.value > 90 && ui.value < 120) {
		$( "#TempoComment" ).text( 'Downtempo/Chillout' );}
		
		if (ui.value > 120 && ui.value < 130) {
		$( "#TempoComment" ).text( 'House' );}
		
		if (ui.value > 130 && ui.value < 135) {
		$( "#TempoComment" ).text( 'Trance' );}
		
		if (ui.value > 135 && ui.value < 145) {
		$( "#TempoComment" ).text( 'Dubstep' );}
		
		if (ui.value > 145 && ui.value < 155) {
		$( "#TempoComment" ).text( 'Techno' );}
		
		if (ui.value > 155 && ui.value < 165) {
		$( "#TempoComment" ).text( 'Jungle' );}
		
		if (ui.value > 165 && ui.value < 185) {
		$( "#TempoComment" ).text( 'Drum and Bass' );}
		
		if (ui.value > 185 && ui.value < 200) {
		$( "#TempoComment" ).text( 'Hardcore/Gabber' );}
*/


