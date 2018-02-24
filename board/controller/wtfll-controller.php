<?php

header("Cache-Control: no-store");
require_once("../../_global/core.php");
require_once('../../_global/model/TvLabQuery.php');

$TvLab = new TvLab;
$q = new TvLabQuery;

$Input = array(
    "Page" => $_GET['page'],
    "User" => $_GET['user'],
    "Section" => $_GET['section']
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );

$SectionList = array(
    "timeline",
    "approved",
    "stacked",
    "review"
);

// Give first name from SectionList (timeline) to empty section
if ( empty ($Section) ) { $Section = $SectionList[0]; }

//Test for right section or die
if ( !in_array( $Section, $SectionList ) )  {echo "no section"; die();}

// 3 or 10 per page depend on section
if ($Section == $SectionList[0] ) { $inPage = 8; } else { $inPage = 10; }

$q->getBoardContent($Section, $inPage, $User);

$Tmp = $TotalRows; unset ($TotalRows); $TotalRows[0] = $Tmp;

if ($Collection->num_rows > 0){
    include("wtfll-json-tpl.php"); //json output template
}


