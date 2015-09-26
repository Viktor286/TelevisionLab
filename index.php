<?
header("Cache-Control: no-store");

require_once("lib/core.php");
$TvLab = new TvLab;
$q = new TvLabQuery;

/*---------------- Обработка входных данных */

$Http_query = str_replace("/%5B0%5D/", "[]", http_build_query($_GET, '', '&'));

$Input = array(
    "qSet" => $_GET['set'],
    "VideoId" => $_GET['video'],
    "Tags" => $_GET['tags'],
    "Mode" => $_GET['md'],
    "MenuState" => $_COOKIE["TagMenuState"],
    "Http_query" => $Http_query
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );

$Tags = strtolower($Tags);


//CSS Variables to css/dynamic.php
if ( empty ($_GET['video']) ) {$emptyVid = 1;} else {$emptyVid = 0;}


if ( $emptyVid == 1 ) { $xCol = "400"; } else { $xCol = "319"; } /* <!-- 6=260, 5=319 and 3=317, 4=400, 3 = 540 --> */
$yCol = round($xCol/ 1.78);





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
// test

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
    var menuState = <? if (isset($MenuState)) {echo $MenuState;} else {echo "2";} ?>;
    var xCol = <?= $xCol; ?>;
    <? if (isset( $VideoId )) {echo "LoadVideoOnPage(" . $VideoId . ");";} ?>
</script>

<!--
p:first-child
p:first-letter {}
-->

<script type="text/x-handlebars-template" id="waterfall-tpl">
{{#result}}
    <div class="item">
        <div class="box{{CurrentClass}}">
            <!--
            <div class="min-icons">{{Motion_Type}}</div>
            <div class="wf-rating"><div class="RateText">{{Rating}}</div></div>
            -->
            <div class="wf-info">

                <div class="wf-title"><a href="javascript:void(0);" onclick="LoadVideoOnClick('{{OutId}}',this);return true">{{Title}}</a></div>
                <div class="wf-desc">{{Year}} {{Brand}} {{Location}}</div>

            </div>

            <a href="javascript:void(0);" onclick="LoadVideoOnClick('{{OutId}}',this);return true"> <img src="{{Img}}" /></a>
        </div>
    </div>
{{/result}}
</script>

<? include 'nodes/top_panel.php';  ?>


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

        <? include 'nodes/VideoInfoPost.php'; ?>

        <? include 'nodes/VideoInfoPost.php'; ?>

        <!--<div id="container"></div>-->
    </section>
</main>

<script>
    $('#container').waterfall({
        itemCls: 'item',
        colWidth: xCol,
        gutterWidth: 19,
        gutterHeight: 15,
        align: 'left',
        minCol: 3,
        maxCol: undefined,
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

                                //console.log(mt[0] + '<<<------------')
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
            return 'data.php?<? echo $Http_query; ?>&page=' + page + '<? echo $jsDataRef; ?>';
        }
    });


</script>

<? insertFooter ("nodes/FooterTpl.php"); ?>