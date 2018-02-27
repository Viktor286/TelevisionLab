<?
header('Cache-Control: no-store');

/* Global elements */
require_once('_global/core.php');
require_once('_global/model/TvLabQuery.php');
require_once('_global/controllers/Forms.php');

/* Local elements */
require_once('desktop/controllers/Snippets.php');

$TvLab = new TvLab;
$q = new TvLabQuery;

/*---------------- Inputs */

$Http_query = str_replace("/%5B0%5D/", "[]", http_build_query($_GET, '', '&'));

$Input = array(
    'qSet' => $_GET['set'],
    'VideoId' => $_GET['video'],
    'Tags' => $_GET['tags'],
    'Mode' => $_GET['md'],
    'MenuState' => $_COOKIE['TagMenuState'],
    'AutoPlayState' => $_COOKIE['AutoPlayState'],
    'Http_query' => $Http_query // displayed here to see full list of inputs
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );
$Tags = strtolower($Tags);

if ( empty ($_GET['video']) ) {$emptyVid = 1;} else {$emptyVid = 0;}
$xCol = '319';

?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Motion Design and Broadcast Graphics. Television Lab database desktop</title>
        <base href="http://www.televisionlab.net/" /><!--[if IE]></base><![endif]-->
        <meta name="description" content="Motion Design and Broadcast Graphics database">

        <link rel="icon" href="favicon.ico" />

        <link rel="stylesheet" type="text/css" href="/_global/css/reset.css" />
        <link rel="stylesheet" type="text/css" href="/_global/css/general.css" />
        <link rel="stylesheet" type="text/css" href="/_global/css/common.css" />

        <link rel="stylesheet" type="text/css" href="/_global/css/main_player_controls.css" />

        <link rel="stylesheet" type="text/css" href="/_global/css/jquery.tagit.css" />
        <link rel="stylesheet" type="text/css" href="/_global/css/tagit.ui-zendesk.css" />
        <link rel="stylesheet" type="text/css" href="/_global/css/fonts-google-opensans.css" />
<!--        <link rel="stylesheet" type="text/css" href="/_global/css/balloon.css" />-->

        <link rel="stylesheet" type="text/css" href="/desktop/css/top_panel.css" />
        <link rel="stylesheet" type="text/css" href="/desktop/css/layout.css" />
        <link rel="stylesheet" type="text/css" href="/desktop/css/general.css" />

        <script type="text/javascript" src="/_global/js/compatibility.js"></script>
        <script type="text/javascript" src="/_global/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="/_global/js/handlebars.js"></script>
        <script type="text/javascript" src="/_global/js/waterfall.js"></script>
        <script type="text/javascript" src="/_global/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/_global/js/tag-it.js"></script>
        <script type="text/javascript" src="/_global/js/vimeo.api.player.js"></script>

        <script type="text/javascript" src="/_global/js/scripts.js"></script>
        <script type="text/javascript" src="/desktop/js/scripts.js"></script>

        <script type="text/javascript" src="/desktop/js/player.js"></script>

        <? print '<link rel="stylesheet" type="text/css" href="/desktop/css/dynamic.php?xcol='.$xCol.'&ev='.$emptyVid.'" />' ?>
    </head>
<body>

<script type="text/javascript">
    var NowUrl = "<?= $Http_query; ?>";
    var NowSet = "<?= $qSet; ?>";
    var NowVid = "<?= $VideoId; ?>";
    var NowTags ="<?= $Tags; ?>";
    var menuState = <? if (isset($MenuState)) {echo $MenuState;} else {echo "0";} ?>;
    var AutoPlayState = <? if (isset($AutoPlayState)) {echo $AutoPlayState;} else {echo "0";} ?>;
    var xCol = <?= $xCol; ?>;
    <? if (isset( $VideoId )) {echo 'LoadVideoOnPage(' . $VideoId . ');';} ?>
</script>

<script type="text/x-handlebars-template" id="waterfall-tpl">
<? include 'desktop/views/waterfall_cell_tpl.php';  ?>
</script>

<? include 'desktop/views/top_panel.php'; ?>

<main>
    <div class="Wr50">
        <div class="table">
            <aside id="LeftPanel">
                <div class="Accordion">
                <? include 'desktop/controllers/tags_overview_left.php'; ?>
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

<? include 'desktop/js/waterfall.php'; ?>

<? insertFooter ('_global/views/FooterTpl.php'); ?>