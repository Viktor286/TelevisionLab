<?php

function NewDetect($Old,$New) {
    if ($Old != $New) {return $New;} else {return false;}
};


function DetectVideoChanges () {
    global $Log_Actions; $Log_Actions = "";

    global $Title, $getTitle; if (NewDetect($Title,$getTitle)) {$Log_Actions .= "Title = ".$getTitle."; ";}
    global $Authors, $getAuthors; if (NewDetect($Authors,$getAuthors)) {$Log_Actions .= "Authors = ".$getAuthors."; ";}
    global $Location, $getLocation; if (NewDetect($Location,$getLocation)) {$Log_Actions .= "Location = ".$getLocation."; ";}
    global $Brand, $getBrand; if (NewDetect($Brand,$getBrand)) {$Log_Actions .= "Brand = ".$getBrand."; ";}
    global $Tv_Channel, $getTv_Channel; if (NewDetect($Tv_Channel,$getTv_Channel)) {$Log_Actions .= "Tv_Channel = ".$getTv_Channel."; ";}
    global $Rating, $getRating; if (NewDetect($Rating,$getRating)) {$Log_Actions .= "Rating = ".$getRating."; ";}
    global $Motion_Type, $getMotion_Type; if (NewDetect($Motion_Type,$getMotion_Type)) {$Log_Actions .= "Motion_Type = ".$getMotion_Type."; ";}
    global $Broadcast_Type, $getBroadcast_Type; if (NewDetect($Broadcast_Type,$getBroadcast_Type)) {$Log_Actions .= "Broadcast_Type = ".$getBroadcast_Type."; ";}
    global $Tags_SA, $getTags_SA; if (NewDetect($Tags_SA,$getTags_SA)) {$Log_Actions .= "Tags_SA = ".$getTags_SA."; ";}
    global $Tempo, $getTempo; if (NewDetect($Tempo,$getTempo)) {$Log_Actions .= "Tempo = ".$getTempo."; ";}
    global $Tags_Fashion, $getTags_Fashion; if (NewDetect($Tags_Fashion,$getTags_Fashion)) {$Log_Actions .= "Tags_Fashion = ".$getTags_Fashion."; ";}
    global $Tags_Arts, $getTags_Arts; if (NewDetect($Tags_Arts,$getTags_Arts)) {$Log_Actions .= "Tags_Arts = ".$getTags_Arts."; ";}
    global $Tags_Music, $getTags_Music; if (NewDetect($Tags_Music,$getTags_Music)) {$Log_Actions .= "Tags_Music = ".$getTags_Music."; ";}
    global $Tags_Others, $getTags_Others; if (NewDetect($Tags_Others,$getTags_Others)) {$Log_Actions .= "Tags_Others = ".$getTags_Others."; ";}
    global $Year, $getYear; if (NewDetect($Year,$getYear)) {$Log_Actions .= "Year = ".$getYear."; ";}

}