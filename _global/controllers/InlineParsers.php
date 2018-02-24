<?php


function compMotionType($Motion_Type) {
    $mts = '';
    foreach( explode(',',$Motion_Type) as $val){
        switch ($val) {
            case "0": $mts .= '<a href="/?set=c1d0s0a0t0v0"><img class="min-icon m_compositing" src="_global/img/min-compositing.png" /></a>'; break;
            case "1": $mts .= '<a href="/?set=c0d1s0a0t0v0"><img class="min-icon m_graphics" src="_global/img/min-graphics.png" /></a>'; break;
            case "2": $mts .= '<a href="/?set=c0d0s1a0t0v0"><img class="min-icon m_simulation" src="_global/img/min-simulation.png" /></a>'; break;
            case "3": $mts .= '<a href="/?set=c0d0s0a1t0v0"><img class="min-icon m_animation" src="_global/img/min-animation.png" /></a>'; break;
            case "4": $mts .= '<a href="/?set=c0d0s0a0t1v0"><img class="min-icon m_rd_stop_motion" src="_global/img/min-rd_stop_motion.png" /></a>'; break;
            case "5": $mts .= '<a href="/?set=c0d0s0a0t0v1"><img class="min-icon m_rd_video" src="_global/img/min-rd_video.png" /></a>'; break;
        }
    }

    return $mts;
}


function compBroadcastType($Broadcast_Type) {
    $bct = '';
    switch ($Broadcast_Type) {
        case "0": $bct .= 'Identity'; break;
        case "1": $bct .= 'Advertising'; break;
        case "2": $bct .= 'Presentation and PR'; break;
        case "3": $bct .= 'Information and Analytics'; break;
        case "4": $bct .= 'Entertainment and show'; break;
        case "5": $bct .= 'Artistic'; break;
        case "6": $bct .= 'Educational'; break;
    }

    return $bct;
}