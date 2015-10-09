<?
header("Cache-Control: no-store");

require_once("lib/core.php");
$TvLab = new TvLab;
$q = new TvLabQuery;

/*---------------- Processing the input data */

$Http_query = str_replace("/%5B0%5D/", "[]", http_build_query($_GET, '', '&'));

$Input = array(
    "qSet" => $_GET['set'],
    "VideoId" => $_GET['video'],
    "Tags" => $_GET['tags'],
    "Mode" => $_GET['md'],
    "MenuState" => $_COOKIE["TagMenuState"],
    "Http_query" => $Http_query // displayed here to see full list of inputs
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );

$Tags = strtolower($Tags);


//CSS Variables to css/dynamic.php
if ( empty ($_GET['video']) ) {$emptyVid = 1;} else {$emptyVid = 0;}

/*
if ( $emptyVid == 1 ) { $xCol = "400"; } else { $xCol = "319"; }
*/
/* <!-- 6=260, 5=319 and 3=317, 4=400, 3 = 540 --> */
/* $yCol = round($xCol/ 1.78); */

$xCol = "319";


//TODO: ROAD MAP
//https://thenounproject.com/ icons for tags
// Related nodes formats atom type http://www.graphdracula.net/showcase/    http://arborjs.org/
// Category Lines welcome page. May be auto group by tags
// Feed + History display mainpage
// FastList video addition
// TvLab wiki or another library
// History column
// Studio Maps (or list, or somewhat to display hall of fame and get picture of the industry)
// Email post-video notification to authors of video
// Artist profile approved by editor, author, community

//------------------------------------ SNIPPET <HTML> STARTS -->
$HeadLayoutSet = array(
    "SiteName" => SITE_TITLE,
    "PageTitle" => "Television Lab database desktop",
    "Description" => "Motion Design and Broadcast Graphics database",
    "css" => array ("reset", "general","common", "jquery.tagit", "tagit.ui-zendesk", "google_fonts"),
    "js" => array ("compatibility", "jquery-1.11.0.min", "handlebars", "waterfall", "jquery-ui", "tag-it", "scripts", "desktop_cfg"),
    "Prepend" => '',
    "Append" => '<link rel="stylesheet" type="text/css" href="/css/dynamic.php?xcol='.$xCol.'&ev='.$emptyVid.'" />'
);

insertHead ($HeadLayoutSet, "nodes/HeadTpl.php");
?>

<script type="text/javascript">
    var NowUrl = "<?= $Http_query; //Bring data from $_GET for farther json request to data.php ?>";
    var NowSet = "<?= $qSet; ?>";
    var NowVid = "<?= $VideoId; ?>";
    var menuState = <? if (isset($MenuState)) {echo $MenuState;} else {echo "0";} ?>;
    var xCol = <?= $xCol; ?>;
    <? if (isset( $VideoId )) {echo "LoadVideoOnPage(" . $VideoId . ");";} ?>
</script>

<script type="text/x-handlebars-template" id="waterfall-tpl">
<? include 'desktop/wtfll-handlebars-tpl.php';  ?>
</script>

<? include 'nodes/top_panel.php'; ?>
<main>
    <aside id="LeftPanel">
        <? include 'nodes/left_panel.php'; ?>
    </aside>

    <section id="FixedDisplay">
        <div id="PreviewWindow"></div>
        <div id="InformationWindow"></div>
    </section>

    <section id="MainOutput">
        <? AdjustH1InfoOutput($qSet, $Mode, $Tags); ?>
        <? $TvLab->showDebugCookie();  ?>

        <div id="container"></div>
    </section>
</main>

<? include 'desktop/wtfll-js-init.php'; ?>

<? insertFooter ("nodes/FooterTpl.php"); ?>