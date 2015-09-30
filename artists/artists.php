<?
header("Cache-Control: no-store");
require_once("../lib/core.php");

$TvLab = new TvLab;
$q = new TvLabQuery;


//-- Inputs
//------------------------------------------------------------------------------------------
$Input = array("AuthorName" => $_GET["name"], "AuthorId" => $_GET["id"]);
extract( SecureVars( $Input ), EXTR_OVERWRITE );


//------------------------------------ SNIPPET <HTML> STARTS -->
$HeadLayoutSet = array(
    "SiteName" => SITE_TITLE,
    "PageTitle" => "Television Lab database Board",
    "Description" => "Description",
    "css" => array ("reset", "board", "general", "google_fonts", "placeholder-big"),
    "js" => array ("compatibility", "jquery-1.11.0.min", "handlebars", "waterfall-board", "jquery-ui"),
    "Prepend" => '<link rel="icon" type="image/png" href="img/favicon-board.ico" />',
    "Append" => ''
);

insertHead ($HeadLayoutSet, "../nodes/HeadTpl.php");
?>

<div>Module in progress</div>

<?

echo "AuthorName $AuthorName <br />";
echo "AuthorId $AuthorId <br />";

insertFooter ("../nodes/FooterTpl.php");

?>