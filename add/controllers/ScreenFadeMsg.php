<?php

function ScreenFadeMsg($objectTitle, $msgTxt, $TargetUrl) {
    echo '
	<div class="ScreenFade">
		<div class="SuccessMsg">
		<p><img src="_global/img/tv_a.png"><p /><br /> 
		<p style="font-size:18px;">'.$objectTitle.'<p /><br />
		<p>'.$msgTxt.'<p />
		</div>
	</div>';

    echo '<script type="text/javascript">setTimeout(function () {window.location.href = "'.$TargetUrl.'";}, 2000);</script>';

}