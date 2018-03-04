    <div class="video-info__controls">
        <div id="MPC" class="MainPlayerControls">
            <div id="PrevVideo"></div>
            <div id="PrevShot"></div>
            <div id="PlayPause" class="pause"></div>
            <div id="NextShot"></div>
            <div id="NextVideo"></div>
            <div class="AutoPlay Cycle"></div>
        </div>
    </div>

    <div class="block right">
        <div class="Authors">
            <div class="IconCol"><div class="UserIcon"></div></div>
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
            <div class="KeyShots">
                <ul><!-- js generated --></ul>
                <div class="TimeCode"><span class="prevFrame"></span>00:00<span>:00</span><span class="nextFrame"></span></div>
                <div class="ShotName"><span><!-- js generated --></span></div>
            </div>
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