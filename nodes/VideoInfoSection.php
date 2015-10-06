<div id="InformationWindow">
    <div class="block right">
        <div class="Authors">
            <div class="IconCol"><img src="img/ShotInfo_iconUser.png" /></div>
            <div class="Names"><?= compAuthors($Authors, $Authors_Aliases) ?></div>
        </div>
        <div class="Location"><?= compLocationYear($Location, $Year) ?></div>
        <?= compBrand($Authors, $Brand) ?>
        <?= compTvChannel($Tv_Channel) ?>
        <div class="Motion_Type"><div class="min_cap">Production type: </div><?= compMotionType($Motion_Type) ?></div>
        <div class="Broadcast_Type"><div class="min_cap">Function type: </div><?= compBroadcastType($Broadcast_Type) ?></div>
    </div>
    <div class="block left">
            <div class="Title"><?= $Title ?></div>
            <span class="Tags"><?= compTags($Tags_SA, $Tags_Fashion, $Tags_Arts, $Tags_Music, $Tags_Others) ?></span>
            <div class="Rating">
                <div class="Num"><div class="RateText"><?= round($Rating/10000,1) ?></div></div>
                <div class="AwesomeRate">
                    <div class="min_cap">internal rating</div>
                    <div class="MeterGhost"></div>
                    <div class="MeterExist" style="width: <?= round($Rating/1000,0) ?>%;"></div>
                </div>
            </div>
    </div>
    <div class="clear"></div>
</div>
<!--'.$Date_Create.'-->
<!--'.$By_User.'-->