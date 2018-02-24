$(document).ready(function() {


    // Tabs Menu
    $(".tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn(0);
    });


    // Simple HowItWorks Button
    $("#HowItWorks").click(function(event) {
        $("#HowItWorks-Img").slideToggle();
    });


    // Set Rating and Tempo sliders
    $(function() {
        $( "#Rating" ).slider({value: getRating});
        $( "#RatingAmount" ).val($("#Rating").slider("value"));
        $( "#RatingDisplay" ).text($("#Rating").slider("value"));


        $( "#Tempo" ).slider({value: getTempo});
        $( "#TempoAmount" ).val($("#Tempo").slider("value"));
        $( "#TempoDisplay" ).text( $("#Tempo").slider("value"));


        RatingComment($( "#RatingDisplay" ).text());
        TempoComment($( "#TempoDisplay" ).text());

    });

});