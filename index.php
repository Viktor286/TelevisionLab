<?
header("Cache-Control: no-store");

require_once("lib/core.php");
$TvLab = new TvLab;
$q = new TvLabQuery;

/*---------------- Processing the input data*/

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

$xCol = "319";

//------------------------------------ SNIPPET <HTML> STARTS -->
$HeadLayoutSet = array(
    "SiteName" => SITE_TITLE,
    "PageTitle" => "Television Lab database desktop",
    "Description" => "Motion Design and Broadcast Graphics database",
    "css" => array ("reset", "general","common", "jquery.tagit", "tagit.ui-zendesk", "google_fonts"),
    "js" => array ("compatibility", "jquery-1.11.0.min", "handlebars", "waterfall", "jquery-ui", "tag-it", "scripts", "desktop_cfg", "url"),
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
    <div class="Wr50">
        <div class="table">
            <aside id="LeftPanel">
                <div class="Accordion">
                <? include 'nodes/left_panel.php'; ?>
            </aside>
            <section id="FixedDisplay">
                <div id="PreviewWindow"></div>
                <div id="InformationWindow"></div>
            </section>
        </div>
    </div>
    <div id="MainOutput">
        <? AdjustH1InfoOutput($qSet, $Mode, $Tags); ?>
        <? $TvLab->showDebugCookie();  ?>
        <div id="container"></div>
    </div>
</main>

<? include 'desktop/wtfll-js-init.php'; ?>

<? insertFooter ("nodes/FooterTpl.php"); ?>