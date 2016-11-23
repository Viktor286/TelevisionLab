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

// Count index of each element
if ( $Page > 1 ) { $i = ($Page * $inPage) - ($inPage-1);} else { $i = 1; }

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

    // Proportion 22:5 ratio where 22 is A and 5 is B): B / (A / 100) = C%. So 22:5 is 5 / .22 = 22.72%.
    // 1,777777777777778 x W = 56.25%;
    $RatioPercent = $Height / ($Width / 100);

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
    "Width": "'.$Width.'",
    "Height": "'.$Height.'",
    "CurrentClass": "'.$CurrentClass.'",
    "OutId": "'.$OutId.'",
    "Pub_Day": "'.$PubDay.'",
    "Pub_Month": "'.$PubMonth.'",
    "Pub_Year": "'.$PubYear.'",
    "Index": "'.$i.'",
    "RatioPercent": "'.$RatioPercent.'"
    },';

    unset ($Motion_Type_Str);
    $i++;
};

// Remove last comma and output
echo chop($Collect_JSON_Attr, ',\n').'

]
}
';
