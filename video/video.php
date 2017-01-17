<?
header("Cache-Control: no-store");

require_once("../lib/core.php");
$TvLab = new TvLab;


//-------- COMENTS TEST
$q = new TvLabQuery;
require_once('../lib/vimeo/vimeo.php'); //классы для работы с vimeo API
//-------- COMENTS TEST

$Input = array(
    "VideoId" => $_GET['video'],
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );

$HeadLayoutSet = array(
    "SiteName" => SITE_TITLE,
    "PageTitle" => "Exact page",
    "Description" => "Cool Description",
    "css" => array ("reset", "common", "general"),
    "js" => array ("compatibility", "jquery-1.11.0.min", "handlebars", "waterfall", "jquery-ui"),
    "Prepend" => '<link rel="icon" type="image/png" href="img/favicon-board.ico" />',
    "Append" => ''
);


insertHead ($HeadLayoutSet, "../nodes/HeadTpl.php");

//-- May be made a Context Variable here?
//--- Include same module
include "../desktop/video.php";

echo '
<div id="PreviewWindow">
<iframe src="//player.vimeo.com/video/'.$VideoId.'?portrait=0" width="650" height="366" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</div>
';

//-------- COMENTS TEST
$q->getComments_for_VideoFromVimeo($VideoId);
//-------- COMENTS TEST

insertFooter ("../nodes/FooterTpl.php");