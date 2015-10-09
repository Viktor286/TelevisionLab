<?
/*
Usages:
showcase/wtfll-controller.php
*/

echo '
{
"total": '.$TotalRows[0].',
"pages": '.$MaxPages.',
"page": '.$Page.',
"result": [';

while ($row = $Collection->fetch_assoc()) {

    //--- Prepare some data for display
    extract($row);

    // Check "here" element
    if ($Video == $OutId) { $CurrentClass = " here"; } else {$CurrentClass = ""; }

    // Compile output info
    $Authors = addslashes( compAuthors($Authors, $Authors_Aliases) );

    $Location = addslashes( compLocationYear($Location, $Year) );

    $Brand = addslashes( compBrand($Authors, $Brand) );

    $Tv_Channel = addslashes( compTvChannel($Tv_Channel) );

    $Motion_Type_Str = addslashes( compMotionType($Motion_Type) );

    $Broadcast_Type = addslashes( compBroadcastType($Broadcast_Type) );

    // Round rating
    $RatingIndex = round($Rating/10000,1);
    $RatingWidth = round($Rating/10000,1)*10;

    // Get Dates
    $PubDay = compDate($Date_Create, "d");
    $PubMonth = compDate($Date_Create, "M");
    $PubYear = compDate($Date_Create, "Y");

    //-----------------
    //--- Pack to json
    $Collect_JSON_Attr .= '
    {
    "Title": "'.$Title.'",
    "Img": "'.$Img.'",
    "Authors": "'.$Authors.'",
    "Location": "'.$Location.'",
    "Brand": "'.$Brand.'",
    "Tv_Channel": "'.$Tv_Channel.'",
    "Likes": "'.$Likes.'",
    "Rating": "'.$RatingIndex.'",
    "RatingWidth": "'.$RatingWidth.'",
    "Motion_Type": "'.$Motion_Type_Str.'",
    "Broadcast_Type": "'.$Broadcast_Type.'",
    "Tempo": "'.$Tempo.'",
    "Tags_SA": "'.$Tags_SA.'",
    "Tags_Fashion": "'.$Tags_Fashion.'",
    "Tags_Arts": "'.$Tags_Arts.'",
    "Tags_Music": "'.$Tags_Music.'",
    "Tags_Others": "'.$Tags_Others.'",
    "Year": "'.$Year.'",
    "Img_Small": "'.$Img_Small.'",
    "Width": 640,
    "Height": 360,
    "CurrentClass": "'.$CurrentClass.'",
    "OutId": "'.$OutId.'",
    "Pub_Day": "'.$PubDay.'",
    "Pub_Month": "'.$PubMonth.'",
    "Pub_Year": "'.$PubYear.'"
    },';

    unset ($Motion_Type_Str);

};

// Remove last comma and output
echo chop($Collect_JSON_Attr, ',\n').'

]
}
';
