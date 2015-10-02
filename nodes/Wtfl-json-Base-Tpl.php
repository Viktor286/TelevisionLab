<?
/*
Usages:
desktop/waterfall-json.php
showcase/waterfall-json.php
*/

echo '
{
"total": '.$TotalRows[0].',
"pages": '.$MaxPages.',
"page": '.$page.',
"result": [';


while ($row = $result->fetch_assoc()) {

    //--- Prepare some data for display
    //Round rating
    $Rating = $row['Rating'] / 10000;
    $Rating = round($Rating,1);

    //Check "here" element
    if ($video == $row['OutId']) { $CurrentClass = " here"; } else {$CurrentClass = ""; }

    //Convert Motion_Type type to html icons
    foreach( explode(',',$row['Motion_Type']) as $val){
        switch ($val) {
            case "0": $Motion_Type_Str .= '<img class="min-icon m_compositing" src="img/min-compositing.png" />'; break;
            case "1": $Motion_Type_Str .= '<img class="min-icon m_graphics" src="img/min-graphics.png" />'; break;
            case "2": $Motion_Type_Str .= '<img class="min-icon m_simulation" src="img/min-simulation.png" />'; break;
            case "3": $Motion_Type_Str .= '<img class="min-icon m_animation" src="img/min-animation.png" />'; break;
            case "4": $Motion_Type_Str .= '<img class="min-icon m_rd_stop_motion" src="img/min-rd_stop_motion.png" />'; break;
            case "5": $Motion_Type_Str .= '<img class="min-icon m_rd_video" src="img/min-rd_video.png" />'; break;
        }

    }
    $Motion_Type_Str = str_replace('"','\"', $Motion_Type_Str);

    //Convert broadcast type to text strings
    switch ($row['Broadcast_Type']) {
        case "0": $Broadcast_Type .= 'Identity'; break;
        case "1": $Broadcast_Type .= 'Advertising'; break;
        case "2": $Broadcast_Type .= 'Presentation and PR'; break;
        case "3": $Broadcast_Type .= 'Information and Analytics'; break;
        case "4": $Broadcast_Type .= 'Entertainment and show'; break;
        case "5": $Broadcast_Type .= 'Artistic'; break;
        case "6": $Broadcast_Type .= 'Educational'; break;
    }



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
