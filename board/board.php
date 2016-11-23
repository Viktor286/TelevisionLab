<?
header("Cache-Control: no-store");
require_once("../lib/core.php");

$TvLab = new TvLab;
$q = new TvLabQuery;


//-- TODO: ROAD MAP
// 1. Timeline design feed
// 2. Timeline click action inside div block
// 3. Approved play in pop up screen on click
// 4. Approved design inside pop up screen
// 5. Stacked -> go to edit on click
// 6. Come Back from Edit Section
// 7. Review Separate feed by Name of User, remove all info from video icons, -> go to edit on click
// 8. Review Change "Save" button to "Approve" in Review-Edit section.
// 9. Private Massage Section


//-- User Board Inputs
//------------------------------------------------------------------------------------------
$Input = array("InputUser" => $_GET["user"], "Section" => $_GET["section"]);
extract( SecureVars( $Input ), EXTR_OVERWRITE );


if ( isset ($_SESSION['user_name']) ) { $AuthUser = $_SESSION['user_name']; }

$SectionList = array(
    "timeline",
    "approved",
    "stacked",
    "review",
);

//-- Output review Section only for Auth User
if ( !isset($AuthUser) ) {  if (($SLkey = array_search('review', $SectionList)) !== false) { unset($SectionList[$SLkey]); } }

//-- Give first name from SectionList (timeline)  to empty section
if ( empty ($Section) ) { $Section = $SectionList[0]; }


//-- Logic
if (!empty ($InputUser)) {

    //Test the right name of sections or die
    if ( !in_array( $Section, $SectionList ) and !empty( $Section ) )  {echo "no such section"; die();}

    //User Info Model
    $UserQuery = 'SELECT * FROM u186876_tvarts.users WHERE user_name = "'.$InputUser.'"';
    $result = $q->Query($UserQuery);

    //If there is no such User, kill the page
    if ($result->num_rows != 1) { die(); } else {
        //Extract User variables
        while ( $row = $result->fetch_assoc() ) {

            $UserName = $row['user_name'];
            $UserEmail = $row['user_email'];
            $Role = $row['Role'];
            $Activity = $row['Activity'];
            $Added = $row['Added'];
            $Edit = $row['Edit'];
        }
    }

    //If we've got a User here, who looking on his own page
    if ($_SESSION['user_name '] == $UserName) {
        //do somethig
    }

} else { die(); }


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

// Waterfall script depends on section. "Position absolute problem".
if ($Section == $SectionList[0]) {
    $HeadLayoutSet["js"][] = "waterfall-showcase";
} else {
    $HeadLayoutSet["js"][] = "waterfall";
}

insertHead ($HeadLayoutSet, "../nodes/HeadTpl.php");

?>

    <script type="text/x-handlebars-template" id="waterfall-tpl">
        <? // Display Handlebars tpl depend on section
        if ($Section == $SectionList[0]) {
            include '../showcase/wtfll-handlebars-tpl.php';
        } else {
            include '../desktop/wtfll-handlebars-tpl.php';
        }
        ?>
    </script>

    <header class="<? echo $Section ?>">
        <section class="Dashboard">

            <a href="/" class="bt-ToTheMain"></a>
            <?
            if ( isset($AuthUser) ) { echo '<a class="bt-LogOut-sml" href="?logout"></a>'; } else { echo '<a href="add/" class="bt-LogIn-sml"></a>';}
            ?>

            <section class="UserInfo">
                <div class="UserName"><? echo $UserName; ?></div>
                <div>Approves <span class="Sum">28</span></div>
                <div>Reviewed <span class="Sum">28</span></div>
                <div>Added <span class="Sum">77</span></div>
                <div>Activity <span class="Sum">1.0</span></div>
            </section>

            <nav<? if ( !isset($AuthUser) ) {echo ' class="noAuth"';} ?>>
                <?

                //Output first section with root url
                if ( $Section == $SectionList[0] ) {echo '<div class="Button here '.$Section.'">'.$SectionList[0].'</div>'."\n";
                } else {
                    echo '<div class="Button"><a href="board/'.$UserName.'/">'.$SectionList[0].'</a></div>'."\n";
                }

                //Skip first and output others
                foreach ($SectionList as $Item) {
                    if ( $Section == $Item ) {
                        if ( $Item == $SectionList[0] ) { continue; } else {
                            echo '<div class="Button here '.$Section.'">'.$Item.'</div>'."\n";}
                    } else {
                        if ( $Item == $SectionList[0] ) { continue; } else {
                            echo '<div class="Button"><a href="board/'.$UserName.'/'.$Item.'/">'.$Item.'</a></div>'."\n";
                        }
                    }
                }

                //Output Add Video only for Auth User
                if ( isset($AuthUser) ) {
                    if (!empty ($_GET['code'])) {if (!Check_Valid_Id($_GET['code'])) {$input_error = 'class="input_error"';}}
                    echo '
                <div class="Button-VideoInput">
                    <form action="add/" method="get" autocomplete="off">
                        <div '.$input_error.'>
                        <input name="code" class="code" placeholder="New Video..."  /></textarea>
                        <input type="submit" value="" class="SendVideo"/></p>
                        </div>
                    </form>
                </div>
                ';
                }
                ?>
            </nav>
        </section>
    </header>


    <div class="Main-Indent"></div>
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