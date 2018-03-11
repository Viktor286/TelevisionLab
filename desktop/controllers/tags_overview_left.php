<?php

# require_once('/_global/config/private/db.php');
// Cache system for "tags overview" module
$cache_mode = 1; // on/off
$cache_file = 'desktop/cache/tags_overview.html';

$time_range = $d1 = 86400; // $d30 = 2592000; $d20 = 1728000; $d10 = 864000; $d7 = 604800; $d5 = 432000; $d4 = 345600; $d3 = 259200; $1 = 86400; $d0 = 0;
$time_shift = time() - $time_range;

if (True) {
# if (file_exists( $cache_file ) and $cache_mode == 1 and filemtime($cache_file) > $time_shift) {

    print '<!-- cached '.gmdate("Y-m-d H:i:s", filemtime($cache_file)).' time shift '.gmdate("Y-m-d H:i:s", $time_shift).' -->';
    include "$cache_file";

} else {
    print '<!-- generate now and create new cached file -->';
    ob_start();
    /* !!!!!! remove this and refactor used function to BasicQuery */
    function BasicQuery_mod($Query) {
        $mysql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($mysql->connect_errno > 0){
            print ('Unable to connect to database [' . $mysql->connect_error . ']');
        } else {$mysql->set_charset("utf8");}

        if(!$result = $mysql->query($Query)){die('Error [' . $mysql->error . ']');}

        // $result->close();
        return $result;
    }


// Model + Controller for tags overview

    function ShowRating ($Tags_Table_Name, $Limit, $Tags) {
        /**
         *  $Tags_Table_Name - tags table's name,
         *  $Limit - amount of tags to display in <li> list
         *  $Tags - Current page tag, to show "here" tag effect
         */

        /*
            // Cache "by sql query" logic
            $cache_mode = 1;
            $cache_file = 'desktop/cache/'.$Tags_Table_Name.'_cache.json';

            $time_range = $d1 = 86400; // $d30 = 2592000; $d20 = 1728000; $d10 = 864000; $d7 = 604800; $d5 = 432000; $d4 = 345600; $d3 = 259200; $1 = 86400; $d0 = 0;
            $time_shift = time() - $time_range;


            if (file_exists( $cache_file ) and $cache_mode == 1 and filemtime($cache_file) > $time_shift) {

                print '<!-- cached '.gmdate("Y-m-d H:i:s", filemtime($cache_file)).' time shift '.gmdate("Y-m-d H:i:s", $time_shift).' -->';
                $arr = json_decode(file_get_contents('desktop/cache/'.$Tags_Table_Name.'_cache.json'), true);

            } else {

                print '<!-- generated now -->';

                $Query = 'SELECT Title, COUNT(Title) FROM '.$Tags_Table_Name.' LEFT JOIN videos_has_'.$Tags_Table_Name.' ON id = tags_id GROUP BY 1 ORDER BY COUNT( Title ) DESC LIMIT 0 , 50;';
                $result = BasicQuery_mod($Query);

                while ($row = mysqli_fetch_assoc($result)) {
                    //print 'Packing rows in array '.$row;
                    if (strlen($row['Title']) > 1) { $arr[] = $row; }
                }

                file_put_contents('desktop/cache/'.$Tags_Table_Name.'_cache.json', json_encode($arr));
            }
        */
        $Query = 'SELECT Title, COUNT(Title) FROM '.$Tags_Table_Name.' LEFT JOIN videos_has_'.$Tags_Table_Name.' ON id = tags_id GROUP BY 1 ORDER BY COUNT( Title ) DESC LIMIT 0 , 50;';
        $result = BasicQuery_mod($Query);

        while ($row = mysqli_fetch_assoc($result)) {
            //print 'Packing rows in array '.$row;
            if (strlen($row['Title']) > 1) { $arr[] = $row; }
        }


        // Prepare relative font-size of tags depends of frequent
        $MaxTags = 1; $MinTags = 1;
        for ($x=0; $x<$Limit; $x++) {
            if ($MaxTags < $arr[$x]['COUNT(Title)']) {$MaxTags = $arr[$x]['COUNT(Title)'];}
            if ($MinTags > $arr[$x]['COUNT(Title)']) {$MinTags = $arr[$x]['COUNT(Title)'];}
        }

        $min_size = 10;
        $max_size = 16;
        $Output = "";
        $TagsArr = explode(" ", $Tags);


        // Output <li> list with data control
        for ( $x=0; $x < $Limit; $x++ ) {
            $Size = ($arr[$x]['COUNT(Title)'] - $MinTags) / ($MaxTags - $MinTags) * ($max_size - $min_size) + $min_size; // size and amount relation formula
            $Output .= '<li><a class="tag-item" href="?tags='.$arr[$x]['Title'].'" title="'.$arr[$x]['Title'].' ('.$arr[$x]['COUNT(Title)'].')" data-tag="'.$arr[$x]['Title'].'" style="font-size:'.round ($Size,1).'px"><span class="hashtag">#</span> '.$arr[$x]['Title'].'</a></li>'."\r\n";
/*            // tag "here" server-side functionality
            if ( in_array($arr[$x]['Title'], $TagsArr) ) {
                $here = ' class="here"';
                $Output .= '<li><span style="font-size:'.round ($Size,1).'px"'.$here.'>'.$arr[$x]['Title'].'</span></li>'."\r\n";
            } else {
                $Output .= '<li><a style="font-size:'.round ($Size,1).'px" href="javascript:void(0);" title="'.$arr[$x]['Title'].' ('.$arr[$x]['COUNT(Title)'].')" onclick="LPoTC('."'".$arr[$x]['Title']."'".');return true">'.$arr[$x]['Title'].'</a></li>'."\r\n";
                // $Output .= '<button class="tag" data-tag="'.$arr[$x]['Title'].'" title="'.$arr[$x]['Title'].' ('.$arr[$x]['COUNT(Title)'].')" style="font-size:'.round ($Size,1).'px">'.$arr[$x]['Title'].'</button></li>';
            }
*/
        }

        echo $Output;
    }

    include 'desktop/views/left_panel.php';

    $output = ob_get_contents();
    file_put_contents("desktop/cache/tags_overview.html", $output);
    ob_end_flush();
}


/* Full cache wrapper
ob_start();
$output = ob_get_contents();
file_put_contents("desktop/cache/tags_overview.html", $output);
ob_end_flush();
*/