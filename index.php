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
    'AutoPlayState' => $_COOKIE['AutoPlayState']
);

extract(SecureVars($Input), EXTR_OVERWRITE);
$Tags = strtolower($Tags);

empty ($_GET['video']) ? $emptyVid = 1 : $emptyVid = 0 ;

$bundleCss = json_decode(file_get_contents('desktop/css/manifest/bundle.css.json'), true);
$bundleJs = json_decode(file_get_contents('desktop/js/manifest/build.js.json'), true);
$bundleJsVnd = json_decode(file_get_contents('desktop/js/manifest/vendors.js.json'), true);

?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Motion Design and Broadcast Graphics. Television Lab database desktop</title>
        <base href="http://www.televisionlab.net/"/>
        <!--[if IE]></base><![endif]-->
        <meta name="description" content="Motion Design and Broadcast Graphics database">
        <link rel="icon" href="favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="/desktop/css/<?= $bundleCss['bundle.min.css'] ?>"/>
        <script type="text/javascript" src="/desktop/js/<?= $bundleJsVnd['vendors.js'] ?>"></script>
        <script type="text/javascript" src="/desktop/js/<?= $bundleJs['build']['js'] ?>"></script>
    </head>
<body>
    <script type="text/javascript">
        'use strict'; window.tvLab={nowUrl:"<?= $Http_query; ?>",nowSet:"<?= $qSet; ?>",nowVid:"<?= $VideoId; ?>",nowTags:"<?= $Tags; ?>",menuState:<? echo((isset($MenuState)) ? $MenuState : 0); ?>,autoPlayState : <? echo((isset($AutoPlayState)) ? $AutoPlayState : 0); ?>};
    </script>
    <script type="text/x-handlebars-template" id="waterfall-tpl">
<? include 'desktop/views/waterfall_cell_tpl.php'; ?>
    </script>
<? include 'desktop/views/top_panel.php'; ?>
    <main>
        <div class="wr50">
            <div class="table">
                <aside id="left-panel">
                    <div class="accordion">
                        <? include 'desktop/controllers/tags_overview_left.php'; ?>
                    </div>
                </aside>
                <section id="fixed-display">
                    <div id="preview-window"></div>
                    <div id="video-info"></div>
                </section>
            </div>
        </div>
        <div id="main-output">
            <? AdjustH1InfoOutput($qSet, $Mode, $Tags); ?>
            <? $TvLab->showDebugCookie(); ?>
            <div id="container"></div>
        </div>
    </main>
<? insertFooter('_global/views/FooterTpl.php'); ?>