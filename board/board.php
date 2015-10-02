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
    "js" => array ("compatibility", "jquery-1.11.0.min", "handlebars", "waterfall-board", "jquery-ui"),
    "Prepend" => '<link rel="icon" type="image/png" href="img/favicon-board-v2.ico" />',
    "Append" => ''
);

insertHead ($HeadLayoutSet, "../nodes/HeadTpl.php");


//------------------------------------ CHUNK <script> -->
// Output handlebar template for ribbon grid
if ($Section == $SectionList[0]) {
    include '../nodes/board_OutputCell_Blog.tpl';
} else {
    include '../nodes/board_OutputCell_Grid.tpl';
}


?>
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
        $('#container').waterfall({
            itemCls: 'item',
            <? if ($Section == $SectionList[0]) { echo "colWidth: 720, maxCol: 1, "; } else { echo "colWidth: 330, maxCol: 3, ";} ?>
            gutterWidth: 19,
            gutterHeight: 15,
            align: 'left',
            debug: false,
            //isFadeIn: true,
            checkImagesLoaded: false,
            callbacks: {
                loadingFinished: function($loading, isBeyondMaxPage) {
                    if ( !isBeyondMaxPage ) {
                        $loading.fadeOut();
                        $($('.min-icons')).each(function(index, value) {

                            if ($(this).html().length < 20) {

                                var mt = $(this).html().split(',');
                                var mts = "";

                                console.log(mt[0] + '<<<------------')
                                for (var i = 0, l = mt.length; i < l; i++){ // цикл по количеству элементов в массиве mt

                                    switch(mt[i]){ //
                                        case '0':
                                            mts += '<img class="min-icon m_compositing" src="img/min-compositing.png" />';
                                            break;
                                        case '1':
                                            mts += '<img class="min-icon m_graphics" src="img/min-graphics.png" />';
                                            break;
                                        case '2':
                                            mts += '<img class="min-icon m_simulation" src="img/min-simulation.png" />';
                                            break;
                                        case '3':
                                            mts += '<img class="min-icon m_animation" src="img/min-animation.png" />';
                                            break;
                                        case '4':
                                            mts += '<img class="min-icon m_rd_stop_motion" src="img/min-rd_stop_motion.png" />';
                                            break;
                                        case '5':
                                            mts += '<img class="min-icon m_rd_video" src="img/min-rd_video.png" />';
                                            break;
                                        default:
                                        // none :)
                                    }

                                }
                                $(this).html(mts);
                            }
                        });
                        //console.log('loading finished');
                    } else {
                        //console.log('loading isBeyondMaxPage');
                        $loading.remove();
                    }
                },

                renderData: function (data, dataType) {
                    var Total = data.total;
                    var Pages = data.pages;
                    var Page = data.page;


                    if ( Pages == Page) {
                        $('#container').waterfall('pause', function() {
                            $('#waterfall-message').html('<!--No more result from database-->')
                        });
                    }

                    if ( dataType === 'json' ||  dataType === 'jsonp'  ) { // json or jsonp format
                        tpl = $('#waterfall-tpl').html();
                        template = Handlebars.compile(tpl);
                        return template(data);

                    } else { // html format

                        return data;
                    }
                }
            },
            path: function(page) {
                return 'http://www.televisionlab.ru/board/waterfall-json.php?<? echo "section=".$Section."&user=".$UserName; ?>&page=' + page;
            }
        });
    </script>

<? insertFooter ("../nodes/FooterTpl.php"); ?>