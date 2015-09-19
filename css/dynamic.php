<?php
header("Content-type: text/css; charset: UTF-8");
require_once("../lib/functions.php");


$Input = array(
    "xCol" => $_GET['xcol'],
    "emptyVid" => $_GET['ev'],
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );

$yCol = round($xCol/ 1.78);


//-- Start Output

if ($emptyVid == 1) {
echo '

main > section#FixedDisplay { display:none; }
main > section#MainOutput { margin-left:190px; }

';
}

?>

div#container div.item, div#container div.item .box { width: <?= $xCol ?>px; height: <?= $yCol ?>px; }




