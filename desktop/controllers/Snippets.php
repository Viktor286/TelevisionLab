<?php

/* Status Bar on search output */
function AdjustH1InfoOutput($getSet, $Mode, $tags) {

    $SetTitleLine = "";

    //Prepare chunks
    $SetChunk = "<span class='TitlePrepend'>Production&nbsp;Type:</span>&nbsp;";

    $TagChunk = "<span class='TitlePrepend'>Keyword:</span>";


    $isSetActive = 0;
    if(preg_match("/c1/", $getSet)) {$SetTitleLine .= '<nobr><span class="type-tag"><nobr><img src="_global/img/min-compositing.png" /> Compositing FX</span></nobr> + '; $isSetActive = 1;}
    if(preg_match("/d1/", $getSet)) {$SetTitleLine .= '<nobr><span class="type-tag"><nobr><img src="_global/img/min-graphics.png" /> 3d Graphics</span></nobr> + '; $isSetActive = 1;}
    if(preg_match("/s1/", $getSet)) {$SetTitleLine .= '<nobr><span class="type-tag"><nobr><img src="_global/img/min-simulation.png" /> Simulation</span></nobr> + '; $isSetActive = 1;}
    if(preg_match("/a1/", $getSet)) {$SetTitleLine .= '<nobr><span class="type-tag"><nobr><img src="_global/img/min-animation.png" /> Animation</span></nobr> + '; $isSetActive = 1;}
    if(preg_match("/t1/", $getSet)) {$SetTitleLine .= '<nobr><span class="type-tag"><nobr><img src="_global/img/min-rd_stop_motion.png" /> Stop Motion</span></nobr> + '; $isSetActive = 1;}
    if(preg_match("/v1/", $getSet)) {$SetTitleLine .= '<nobr><span class="type-tag"><nobr><img src="_global/img/min-rd_video.png"  /></span> Video</nobr>'; $isSetActive = 1;}

    $SetTitleLine = preg_replace("/ \+ $/", "", $SetTitleLine);

    if ( !isset($SetTitleLine) ) {$SetTitleLine = " All";}


    if ($Mode == "on") {$OnlyWrap = "<span class='TitleOnly'> only&nbsp;(&nbsp;</span>"; $OnlyWrapClose = "<span class='TitleOnly'> )</span>";}

    if ($tags != "") {

        //Repack each tag separatly
        $close_button = '<span class="x-close">⨯</span>';

        $tags = str_replace(" ", $close_button.'</span> + <span class="tag">', $tags);
        $tags = '<span class="tag"><span class="hashtag">#</span> '.$tags.$close_button.'</span>';

        $tagLine = $TagChunk.' <span class="Tags">'.$tags.'</span>';
    }

    if ($isSetActive == 0) {unset ($SetChunk,$OnlyWrap, $OnlyWrapClose);}


    if ($isSetActive == 1 or $tags != "") {
        if ($isSetActive == 1 and $tags != "")
        {$tagIndent = " <span class='TitlePrepend'>and</span>&nbsp;";}

        $OutputLine = '<h1 class="setInfo">' . $tagLine . $tagIndent . $SetChunk . $OnlyWrap . $SetTitleLine . $OnlyWrapClose . "</h1>";
    }

    //$x = SetTitle($qSet, $Mode); if ($x != "") {echo "<h1>".$x."</h1>";}

    echo $OutputLine;
}


