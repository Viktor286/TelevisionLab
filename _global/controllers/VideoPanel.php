<?php

/* Controllers for display video block */

function compAuthors($Authors, $Authors_Aliases) {
    if ( !empty($Authors_Aliases) ) {
        //assemble array of Author => Alias
        $AA_Arr = array_combine (explode(',', $Authors), explode(',', $Authors_Aliases));

        unset($AuthorLine);
        $AuthorLine = "";

        foreach( $AA_Arr as $Author => $Alias) {

            if ($Alias == "Na" || $Alias == "na") {
                $AuthorLine .= $Author.', ';
            } else {
                $AuthorLine .= '<a href="artist/'.$Alias.'">'.$Author.'</a>, ';
            }
        }

        echo( chop($AuthorLine, ', \n') );

    } else {
        //If there is no $Authors_Aliases
        return $Authors;
    }
}


function compLocationYear($Location, $Year) {
    if ( !empty($Location)) {
        return '<a href="/?tags='.str_replace(",","", $Location).'">'.$Location.'</a>, <a href="/?tags='.$Year.'">'.$Year.'</a>';
    } else {
        return '<div class="min_cap">Year: </div><a href="/?tags='.$Year.'">'.$Year.'</a>';
    }
}

function compBrand($Authors, $Brand) {
    if ( !strstr( $Authors, $Brand ) and !empty( $Brand ) ) {
        return '<div class="Brand"><div class="min_cap">Brand: </div><a href="/?tags='.$Brand.'">'.$Brand.'</a></div>';
    }
}

function compTvChannel($Tv_Channel) {
    if ( !empty ($Tv_Channel) ) { return '<div class="Tv_Channel"><div class="min_cap">Tv channel: </div><a href="/?tags='.$Tv_Channel.'">'.$Tv_Channel.'</a></div>'; }
}


function compTags($Tags_SA, $Tags_Fashion, $Tags_Arts, $Tags_Music, $Tags_Others) {

    $TagsArr = array_merge (
        explode(", " , $Tags_SA),
        explode(", " , $Tags_Fashion),
        explode(", " , $Tags_Arts),
        explode(", " , $Tags_Music),
        explode(", " , $Tags_Others)
    );

    $TagsArr = array_filter($TagsArr);

    $TagLine = "";
    foreach ($TagsArr as $Tag) {
        $TagLine .= '<a class="tag" href="?tags='.$Tag.'" data-tag="'.$Tag.'"><span class="hashtag">#</span> '.$Tag.'</a> ';
    }
    //<a href="javascript:void(0);" onclick="LPoTC('micrographics');return true">micrographics</a>
    return $TagLine;
}

/* Global Controller */
function compDate($PubDate, $Format){
    $PubDate = strtotime($PubDate);
    return date($Format, $PubDate);
}
