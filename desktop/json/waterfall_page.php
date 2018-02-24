<?
header('Cache-Control: no-store');
require_once('../../_global/core.php');
require_once('../../_global/model/TvLabQuery.php');
require_once('../../_global/controllers/InlineParsers.php');

$TvLab = new TvLab;
$q = new TvLabQuery;

/* All GET URL params of index.php transfer here from $HttpQuery = http_build_query($_GET, '', '&'); */

/*---------------- Inputs */
$Input = array(
    'getSet' => $_GET['set'],
    'Mode' => $_GET['md'],
    'Tags' => $_GET['tags'],
    'Page' => $_GET['page'],
    'Video' => $_GET['video']
);

extract( SecureVars( $Input ), EXTR_OVERWRITE );

$q->getCollection($getSet, $Mode, $Tags, $Page, 10, $Video);

// If Collection is ok, assemble Json respond
if ($Collection->num_rows > 0){
    /*
    Usages:
    desktop/wtfll-controller.php
    */
        $c = 0;
        echo '
    {
    "total": '.$TotalRows[0].',
    "pages": '.$MaxPages.',
    "page": '.$Page.',
    "result": [';

        while ($row = $Collection->fetch_assoc()) {

            //--- Prepare some data for display
            extract($row);

            // Detect info about first video in first array
            if ($c == 0) {
                $FirstVideoId = $OutId;
                $FirstTitle = $Title;
            }

            //Check "here" element
            if ($Video == $OutId) { $CurrentClass = " here"; } else {$CurrentClass = ""; }

            //$Authors = addslashes( compAuthors($Authors, $Authors_Aliases) );

            //$Location = addslashes( compLocationYear($Location, $Year) );

            //$Brand = addslashes( compBrand($Authors, $Brand) );

            //$Tv_Channel = addslashes( compTvChannel($Tv_Channel) );

            $Motion_Type_Str = addslashes( compMotionType($Motion_Type) );

            $Broadcast_Type = addslashes( compBroadcastType($Broadcast_Type) );

            //Round rating
            $Rating = round($Rating/10000,1);
            $RatingWidth = round($Rating/10000,0);


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
        "Rating": "'.$Rating.'",
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
        "OutId": "'.$OutId.'"
        },';

            $c++;
        };

    //Remove last comma and output
        echo chop($Collect_JSON_Attr, ',\n').'
    
    ],
    "FirstVideo": "'.$FirstVideoId.'",
    "FirstTitle": "'.$FirstTitle.'"
    
    }
    ';
}

// debug url desktop/wtfll-controller.php?tags=test
// echo $specificQuery;
