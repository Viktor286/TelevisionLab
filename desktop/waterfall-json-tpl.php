<?
/*
Usages:
desktop/waterfall-handler.php
*/

echo '
{
"total": '.$TotalRows[0].',
"pages": '.$MaxPages.',
"page": '.$Page.',
"result": [';


while ($row = $Collection->fetch_assoc()) {

    //--- Prepare some data for display
    //Round rating
    $Rating = $row['Rating'] / 10000;
    $Rating = round($Rating,1);

    //Check "here" element
    if ($Video == $row['OutId']) { $CurrentClass = " here"; } else {$CurrentClass = ""; }

    //Convert Motion_Type to html icons
    $Motion_Type_Str = str_replace('"','\"',
        compMotionType($row['Motion_Type'])
    );

    //Convert broadcast type to text strings
    $Broadcast_Type = compBroadcastType($row['Broadcast_Type']);


    //-----------------
    //--- Pack to json
    $Collect_JSON_Attr .= '
    {
    "Title": "'.$row['Title'].'",
    "Img": "'.$row['Img'].'",
    "Authors": "'.$row['Authors'].'",
    "Location": "'.$row['Location'].'",
    "Brand": "'.$row['Brand'].'",
    "Tv_Channel": "'.$row['Tv_Channel'].'",
    "Likes": "'.$row['Likes'].'",
    "Rating": "'.$Rating.'",
    "Motion_Type": "'.$Motion_Type_Str.'",
    "Broadcast_Type": "'.$Broadcast_Type.'",
    "Tempo": "'.$row['Tempo'].'",
    "Tags_SA": "'.$row['Tags_SA'].'",
    "Tags_Fashion": "'.$row['Tags_Fashion'].'",
    "Tags_Arts": "'.$row['Tags_Arts'].'",
    "Tags_Music": "'.$row['Tags_Music'].'",
    "Tags_Others": "'.$row['Tags_Others'].'",
    "Year": "'.$row['Year'].'",
    "Img_Small": "'.$row['Img_Small'].'",
    "Width": 640,
    "Height": 360,
    "CurrentClass": "'.$CurrentClass.'",
    "OutId": "'.$row['OutId'].'"
    },';

    unset ($Motion_Type_Str);

};

//Remove last comma and output
echo chop($Collect_JSON_Attr, ',\n').'

]
}
';
