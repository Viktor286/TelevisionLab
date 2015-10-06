<?php
require_once("../lib/core.php");

if (!isset ($TvLab)) {
    $TvLab = new TvLab;
}
$q = new TvLabQuery;

//Inputs
//------------------------------------------------------------------------------------------

$Input = array(

    "VideoId" => $_GET['VideoId'],
    "VideoHistory" => $_COOKIE["VideoHistory"]
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );


//--- Test VideoId
if (preg_match ("/(\d{4,20})/", $VideoId)) {

    //--- get Video Info Variables into globals
    $q->getVideo($VideoId, $isStack, "SetGlobals");


    //--- EditButton and ApproveButton
    $EditButton = '<a href="edit/?video='.$VideoId.'" class="EditButton"></a>';
    $ApproveButton = '<a href="edit/?video='.$VideoId.'" class="ApproveButton"></a>';

    if ($_SESSION['user_role'] == "0" or $_SESSION['user_name'] == $By_User) {
        echo $EditButton;
    }

    //--- Here comes output template
    include "../nodes/VideoInfoSection.php";

    //-- After all, set VideoHistory cookie ($_COOKIE["VideoHistory"]) of watched video
    if (!empty ($VideoHistory)) {

        //if possibly need an images with ids, vars $Img, $Img_Small available
        $VideoHistoryArr = explode(",",$VideoHistory);

        if ($VideoHistoryArr[0] != $VideoId)  {

            //add new $VideoId to array if id unique
            array_unshift($VideoHistoryArr, $VideoId);

            //Clear all grater than 5, witch is size of history buffer
            while (count($VideoHistoryArr) > 5) array_pop($VideoHistoryArr);

            $VideoHistory = implode(",", $VideoHistoryArr);
            setcookie("VideoHistory", $VideoHistory,0,"/","",0,1);
        }

     } else {

        setcookie("VideoHistory", $VideoId,0,"/","",0,1);

    }


}
