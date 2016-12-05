<?
header("Cache-Control: no-store");
require_once("../lib/core.php");

$TvLab = new TvLab;
$q = new TvLabQuery;


$UserName = "JustViktor";
$Section = "timeline";

//------------------------------------ SNIPPET <HTML> STARTS -->
$HeadLayoutSet = array(
    "SiteName" => SITE_TITLE,
    "PageTitle" => "Television Lab database Board",
    "Description" => "Description",
    "css" => array ("reset", "board", "general", "google_fonts", "placeholder-big"),
    "js" => array ("compatibility", "jquery-1.11.0.min", "handlebars", "jquery-ui", "scripts[board]"),
    "Prepend" => '<link rel="icon" href="img/favicon-star.ico" />',
    "Append" => ''
);

$HeadLayoutSet["js"][] = "waterfall-showcase";

insertHead ($HeadLayoutSet, "../nodes/HeadTpl.php");

?>

    <script type="text/x-handlebars-template" id="waterfall-tpl">
        <? include '../showcase/wtfll-handlebars-tpl.php'; ?>
    </script>

    <header class="<? echo $Section ?>">
        <section class="Dashboard" style="height: 70px;">

            <a href="/" class="bt-ToTheMain"></a>
            <?
            if ( isset($AuthUser) ) { echo '<a class="bt-LogOut-sml" href="?logout"></a>'; } else { echo '<a href="add/" class="bt-LogIn-sml"></a>';}
            ?>

            <section class="UserInfo">
                <div class="UserName">Television Lab</div>
                <div>Latest updates<span class="Sum"></span></div>
            </section>



        </section>
    </header>


    <div class="Main-Indent" style="height: 110px;"></div>
    <main>
        <div id="container"></div>
    </main>

    <script>

        var page = 1;
        var pageurl = 'http://www.televisionlab.net/board/wtfll-controller.php?<? echo "section=".$Section."&user=".$UserName; ?>&page=';
        var isPreviousEventComplete = true, isDataAvailable = true;

        window.onload = function(){
            load_PostBox(pageurl, page);
        };

        $(window).scroll(function() {

            if($(window).scrollTop() + $(window).height() > $(document).height() - 500) {
                if (isPreviousEventComplete && isDataAvailable) {

                    isPreviousEventComplete = false;
                    $(".LoaderImage").css("display", "block");

                    page++;
                    load_PostBox(pageurl, page);
                    // console.log("---> Loaded "+page+" PostBox");
                }

            }
        });

    </script>

<? // include 'wtfll-js-init.php'; ?>

<? insertFooter ("../nodes/FooterTpl.php"); ?>