
<?
$q->getVideo(53532205, $isStack, "SetGlobals");
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
            <img src="<?= $Img ?>" />
            <div class="left">
                <h1><?= $Title ?></h1>

                <div class="Authors">
                    <div class="IconCol"><img src="img/ShotInfo_iconUser.png" /></div>
                    <div class="Names"><?= $Authors ?></div>
                </div>

                <div class="Location"><? if ( !empty($Location)) { echo $Location.", ".$Year; } else { echo '<div class="min_cap">Year: </div>'.$Year; }?></div>

                <? if ( !strstr( $Authors, $Brand ) and !empty( $Brand ) ) { echo '<div class="Brand"><div class="min_cap">Brand: </div>'.$Brand.'</div>'; } ?>

                <? if ( !empty ($Tv_Channel) ) { echo '<div class="Tv_Channel"><div class="min_cap">Tv channel: </div>'.$Tv_Channel.' </div>'; }

                foreach( explode(',',$Motion_Type) as $val){
                    switch ($val) {
                        case "0": $mts .= '<img class="min-icon m_compositing" src="img/min-compositing.png" />'; break;
                        case "1": $mts .= '<img class="min-icon m_graphics" src="img/min-graphics.png" />'; break;
                        case "2": $mts .= '<img class="min-icon m_simulation" src="img/min-simulation.png" />'; break;
                        case "3": $mts .= '<img class="min-icon m_animation" src="img/min-animation.png" />'; break;
                        case "4": $mts .= '<img class="min-icon m_rd_stop_motion" src="img/min-rd_stop_motion.png" />'; break;
                        case "5": $mts .= '<img class="min-icon m_rd_video" src="img/min-rd_video.png" />'; break;
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

                <span class="Tags"><? foreach ($TagsArr as $Tag) { echo '<span class="tag">'.$Tag.'</span> '; } //$rate_math = round() ?></span>

                <span class="Tags"><? foreach ($TagsArr as $Tag) { echo '<span class="tag">'.$Tag.'</span> '; } //$rate_math = round() ?></span>
            </div>
            <div class="clear"></div>
        </div>

    </article>
</section>