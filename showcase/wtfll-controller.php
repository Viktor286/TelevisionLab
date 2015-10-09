<?
header("Cache-Control: no-store");
require_once("../lib/core.php"); 

$TvLab = new TvLab;
$q = new TvLabQuery;

/* All GET URL params of index.php transfer here from $HttpQuery = http_build_query($_GET, '', '&'); */

/*---------------- Inputs */
$Input = array(
    "getSet" => $_GET['set'],
    "Mode" => $_GET['md'],
    "Tags" => $_GET['tags'],
    "Page" => $_GET['page'],
    "Video" => $_GET['video']
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );

$q->getCollection($getSet, $Mode, $Tags, $Page, 3, $Video);

// If Collection is ok, assemble Json respond
if ($Collection->num_rows > 0){
    include("wtfll-json-tpl.php"); //json output template
}

// debug url showcase/wtfll-controller.php?tags=test
// echo $specificQuery;


