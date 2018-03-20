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

extract(SecureVars($Input), EXTR_OVERWRITE);
$Tags = strtolower($Tags);

empty ($_GET['video']) ? $emptyVid = 1 : $emptyVid = 0 ;

?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Motion Design and Broadcast Graphics. Television Lab database desktop</title>
        <base href="http://www.televisionlab.net/"/>
        <!--[if IE]></base><![endif]-->
        <meta name="description" content="Motion Design and Broadcast Graphics database">
        <link rel="icon" href="favicon.ico"/>
        <link rel="stylesheet" type="text/css" href="/desktop/css/bundle.min.css"/>

        <script type="text/javascript" src="/_global/js/compatibility.js"></script>
        <script type="text/javascript" src="/_global/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="/_global/js/handlebars.js"></script>
        <script type="text/javascript" src="/_global/js/waterfall.js"></script>
        <script type="text/javascript" src="/_global/js/jquery-ui.js"></script>
        <script type="text/javascript" src="/_global/js/tag-it.js"></script>
        <script type="text/javascript" src="/_global/js/vimeo.api.player.js"></script>

        <script type="text/javascript" src="/desktop/js/app.js" defer></script>
    </head>
<body>
    <script type="text/javascript">
        'use strict';

        window.tvLab = {
            nowUrl : "<?= $Http_query; ?>",
            nowSet : "<?= $qSet; ?>",
            nowVid : "<?= $VideoId; ?>",
            nowTags : "<?= $Tags; ?>",
            menuState : <? echo((isset($MenuState)) ? $MenuState : 0); ?>,
            autoPlayState : <? echo((isset($AutoPlayState)) ? $AutoPlayState : 0); ?>
        };

        document.addEventListener('DOMContentLoaded', function () {
            <? echo((isset($VideoId)) ? 'window.loadVideoOnPage(' . $VideoId . ');' : ''); ?>

        });

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
<? include 'desktop/js/waterfall.php'; ?>

<? insertFooter('_global/views/FooterTpl.php'); ?>