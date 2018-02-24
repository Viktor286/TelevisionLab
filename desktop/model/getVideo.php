<?php

/* This path from parented file desktop/video.php */
require_once '../../_global/model/BasicQuery.php';


function getVideo($VideoId) {

    $IdQuery = 'SELECT * FROM u186876_tvarts.contents WHERE OutId = '.$VideoId;
    $result = BasicQuery($IdQuery);

    while ($row = $result->fetch_object()) {
        global $Title; $Title = $row->Title;
        global $OutId; $OutId = $row->OutId;
        global $OutHost; $OutHost = $row->OutHost;
        global $Img; $Img = $row->Img;
        global $Img_Small; $Img_Small = $row->Img_Small;
        global $Authors; $Authors = $row->Authors;
        global $Authors_Aliases; $Authors_Aliases = $row->Authors_Aliases;
        global $Location; $Location = $row->Location;
        global $Brand; $Brand = $row->Brand;
        global $Tv_Channel; $Tv_Channel = $row->Tv_Channel;
        global $Likes; $Likes = $row->Likes;
        global $Rating; $Rating = $row->Rating;
        global $Cost; $Cost = $row->Cost;
        global $Motion_Type; $Motion_Type = $row->Motion_Type;
        global $Broadcast_Type; $Broadcast_Type = $row->Broadcast_Type;
        global $Tempo; $Tempo = $row->Tempo;
        global $Tags_SA; $Tags_SA = $row->Tags_SA;
        global $Tags_Fashion; $Tags_Fashion = $row->Tags_Fashion;
        global $Tags_Arts; $Tags_Arts = $row->Tags_Arts;
        global $Tags_Music; $Tags_Music = $row->Tags_Music;
        global $Tags_Others; $Tags_Others = $row->Tags_Others;
        global $Date_Origin; $Date_Origin = $row->Date_Origin;
        global $Year; $Year = $row->Year;
        global $Duration; $Duration = $row->Duration;
        global $Date_Create; $Date_Create = $row->Date_Create;
        global $By_User; $By_User = $row->By_User;
        global $Width; $Width = $row->Width;
        global $Height; $Height = $row->Height;
        global $State; $State = $row->State;
    }
    $result->close();

}