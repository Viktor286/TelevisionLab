
<?
$q->getVideo(109111165, $isStack, "SetGlobals");
//--- Prepare tag line from data to $TagsArr
prepareTagsArrVar();

?>

<section id="PostBox">
    <div class="DateTag">
        <div class="Day">27</div>
        <div class="Hr"></div>
        <div class="Month">SPT</div>
        <div class="Year">2015</div>
    </div>
    <article>
        <div class="wrapper">

            <div class="info">
                <h1><?= $Title ?> and more amazing workaround words</h1>

                <div class="Authors">
                    <div class="IconCol"><img src="img/ShotInfo_iconUser.png" /></div>
                    <div class="Names"><?= $Authors ?></div>
                </div>

                <div class="Location"><? if ( !empty($Location)) { echo '<a href="/?tags='.$Location.'">'.$Location.'</a>, <a href="/?tags='.$Year.'">'.$Year.'</a>'; } else { echo '<div class="min_cap">Year: </div><a href="/?tags='.$Year.'">'.$Year.'</a>'; }?></div>

                <? if ( !strstr( $Authors, $Brand ) and !empty( $Brand ) ) { echo '<div class="Brand"><div class="min_cap">Brand: </div><a href="/?tags='.$Brand.'">'.$Brand.'</a></div>'; } ?>

                <? if ( !empty ($Tv_Channel) ) { echo '<div class="Tv_Channel"><div class="min_cap">Tv channel: </div><a href="/?tags='.$Tv_Channel.'">'.$Tv_Channel.'</a></div>'; }

                foreach( explode(',',$Motion_Type) as $val){
                    switch ($val) {
                        case "0": $mts .= '<a href="/?set=c1d0s0a0t0v0"><img class="min-icon m_compositing" src="img/min-compositing.png" /></a>'; break;
                        case "1": $mts .= '<a href="/?set=c0d1s0a0t0v0"><img class="min-icon m_graphics" src="img/min-graphics.png" /></a>'; break;
                        case "2": $mts .= '<a href="/?set=c0d0s1a0t0v0"><img class="min-icon m_simulation" src="img/min-simulation.png" /></a>'; break;
                        case "3": $mts .= '<a href="/?set=c0d0s0a1t0v0"><img class="min-icon m_animation" src="img/min-animation.png" /></a>'; break;
                        case "4": $mts .= '<a href="/?set=c0d0s0a0t1v0"><img class="min-icon m_rd_stop_motion" src="img/min-rd_stop_motion.png" /></a>'; break;
                        case "5": $mts .= '<a href="/?set=c0d0s0a0t0v1"><img class="min-icon m_rd_video" src="img/min-rd_video.png" /></a>'; break;
                    }
                }
                ?>

                <div class="Motion_Type"><div class="min_cap">Production type: </div><?= $mts ?></div>
                <div class="Broadcast_Type"><div class="min_cap">Function type: </div><?

                    switch ($Broadcast_Type) {
                        case "0": $bct .= 'Identity'; break;
                        case "1": $bct .= 'Advertising'; break;
                        case "2": $bct .= 'Presentation and PR'; break;
                        case "3": $bct .= 'Information and Analytics'; break;
                        case "4": $bct .= 'Entertainment and show'; break;
                        case "5": $bct .= 'Artistic'; break;
                        case "6": $bct .= 'Educational'; break;
                    }
                    echo $bct;
                    ?></div>

                <div class="Rating">
                    <div class="Num"><div class="RateText"><?= round($Rating/10000,1) ?></div></div>
                    <div class="AwesomeRate">
                        <div class="min_cap">internal rating</div>
                        <div class="MeterGhost"></div>
                        <div class="MeterExist" style="width: <?= round($Rating/1000,0) ?>%;"></div>
                    </div>
                </div>

                <span class="Tags">
                    <? foreach ($TagsArr as $Tag) { echo '<a class="tag" href="/?tags='.$Tag.'">'.$Tag.'</a> '; } ?>
                </span>

            </div>

            <div class="thumb">
                <img src="<?= $Img ?>" />
            </div>

            <div class="clear"></div>
        </div>

    </article>
</section>