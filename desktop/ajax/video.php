<?php
require_once('../../_global/core.php');
require_once('../../_global/controllers/VideoPanel.php');
require_once('../../_global/controllers/InlineParsers.php');
require_once('../model/getVideo.php');

// For Session purposes
$TvLab = new TvLab;

// Inputs
//------------------------------------------------------------------------------------------

$Input = array(
    "VideoId" => $_GET['VideoId'],
    "VideoHistory" => $_COOKIE["VideoHistory"]
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );


//--- Test VideoId
if (preg_match ("/(\d{4,20})/", $VideoId)) {

    //--- get Video Info Variables into globals
    getVideo($VideoId);

    //--- EditButton and ApproveButton
    $EditButton = '<a href="edit/?video='.$VideoId.'" class="EditButton"></a>';
    $ApproveButton = '<a href="edit/?video='.$VideoId.'" class="ApproveButton"></a>';

    // This gear could be replaced by universal function $UserRole's vars are mapped in TvLab class
    if ($_SESSION['user_role'] == "0" or $_SESSION['user_name'] == $By_User) {
        echo $EditButton;
    }

    //--- Here comes output template
    include "../../_global/views/VideoInfoSection.php";

    //-- After all, set VideoHistory cookie ($_COOKIE["VideoHistory"]) of watched video
    if (!empty ($VideoHistory)) {

        //if possibly need an images with ids, vars $Img, $Img_Small available
        $VideoHistoryArr = explode(",",$VideoHistory);

        if ($VideoHistoryArr[0] != $VideoId)  {

            //add new $VideoId to array if id unique
            array_unshift($VideoHistoryArr, $VideoId);

            //Clear all grater than 5, which is size of history buffer
            while (count($VideoHistoryArr) > 5) array_pop($VideoHistoryArr);

            $VideoHistory = implode(",", $VideoHistoryArr);
            setcookie("VideoHistory", $VideoHistory,0,"/","",0,1);
        }

     } else {

        setcookie("VideoHistory", $VideoId,0,"/","",0,1);

    }

}
