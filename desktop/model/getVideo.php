<?php

/* This path from parented file desktop/video.php */
require_once '../../_global/model/BasicQuery.php';


function getVideo($VideoId)
{

    $IdQuery = 'SELECT * FROM u186876_tvarts.contents WHERE OutId = ' . $VideoId;
    $result = BasicQuery($IdQuery);

    while ($row = $result->fetch_object()) {
        global $Title;
        global $OutId;
        global $OutHost;
        global $Img;
        global $Img_Small;
        global $Authors;
        global $Authors_Aliases;
        global $Location;
        global $Brand;
        global $Tv_Channel;
        global $Likes;
        global $Rating;
        global $Cost;
        global $Motion_Type;
        global $Broadcast_Type;
        global $Tempo;
        global $Tags_SA;
        global $Tags_Fashion;
        global $Tags_Arts;
        global $Tags_Music;
        global $Tags_Others;
        global $Date_Origin;
        global $Year;
        global $Duration;
        global $Date_Create;
        global $By_User;
        global $Height;
        global $Width;
        global $State;

        $Title = $row->Title;
        $OutId = $row->OutId;
        $OutHost = $row->OutHost;
        $Img = $row->Img;
        $Img_Small = $row->Img_Small;
        $Authors = $row->Authors;
        $Authors_Aliases = $row->Authors_Aliases;
        $Location = $row->Location;
        $Brand = $row->Brand;
        $Tv_Channel = $row->Tv_Channel;
        $Likes = $row->Likes;
        $Rating = $row->Rating;
        $Cost = $row->Cost;
        $Motion_Type = $row->Motion_Type;
        $Broadcast_Type = $row->Broadcast_Type;
        $Tempo = $row->Tempo;
        $Tags_SA = $row->Tags_SA;
        $Tags_Fashion = $row->Tags_Fashion;
        $Tags_Arts = $row->Tags_Arts;
        $Tags_Music = $row->Tags_Music;
        $Tags_Others = $row->Tags_Others;
        $Date_Origin = $row->Date_Origin;
        $Year = $row->Year;
        $Duration = $row->Duration;
        $Date_Create = $row->Date_Create;
        $By_User = $row->By_User;
        $Width = $row->Width;
        $Height = $row->Height;
        $State = $row->State;
    }
    $result->close();

}