<?php
header("Content-type: text/css; charset: UTF-8");

include "../../_global/controllers/SecureVars.php";

$Input = array(
    "xCol" => $_GET['xcol'],
    "emptyVid" => $_GET['ev'],
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );

$yCol = round($xCol/ 1.78);

?>

div#container div.item, div#container div.item .box { width: <?= $xCol ?>px; height: <?= $yCol ?>px; }

