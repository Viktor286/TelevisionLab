<div class="TopPanelBox">
    <div class="TopPanel">
    	<div class="tpLogo">
            <?  if (isset($VideoId)) {echo '<a href="?video='.$VideoId.'"></a>';} else {echo '<a href="/"></a>';} ?>
        </div>
        <form method="get" id="tpSearch">
            <div class="tpSearch">
                <input type="text" name="tags" class="tpSearch_field" id="mySingleField" value="<? if (isset($Tags)) {echo $Tags;}?>">
                <ul id="singleFieldTags" class="tpSearch_field"></ul>
                <input type="hidden" name="video" id="InputVideo" value="<? if (isset($VideoId)) {echo $VideoId;};?>">
                <input type="submit" value="" class="tpSearch_Bt"/>
            </div>
            <div class="tpSearch_filters">
                <div class="hideBeforeInit">
                <input type="checkbox" class="cbx"  data-sdb-image="url('img/bt40_compositing.png')"  id="comp" alt="Compositing" <? matchChecked ($qSet,'/c1/'); ?> />
                <input type="checkbox" class="cbx"  data-sdb-image="url('img/bt40_graphics.png')"  id="3d" alt="3d Graphics" <? matchChecked ($qSet,'/d1/'); ?> />
                <input type="checkbox" class="cbx"  data-sdb-image="url('img/bt40_simulation.png')" id="sim" alt="Simulation" <? matchChecked ($qSet,'/s1/'); ?> />
                <input type="checkbox" class="cbx"  data-sdb-image="url('img/bt40_animation.png')"  id="anim" alt="Cartoon (Drawing)" <? matchChecked ($qSet,'/a1/'); ?> />
                <input type="checkbox" class="cbx"  data-sdb-image="url('img/bt40_stop_motion.png')"  id="stpm" alt="Stop Motion" <? matchChecked ($qSet,'/t1/'); ?> />
                <input type="checkbox" class="cbx"  data-sdb-image="url('img/bt40_video.png')"  id="vid" alt="Video" <? matchChecked ($qSet,'/v1/'); ?> />
                <input type="hidden" name="set" id="set" value="<? echo $qSet ?>">
                <input type="checkbox" class="cbx"  data-sdb-image="url('img/bt40_only.png')"  id="md" name="md" alt="Mode" <? matchChecked ($Mode,'/on/'); ?> />
                </div>
            </div>
        </form>
        <div class="infoline">This site is a rough prototype of an online database of motion graphics. For more information or for participation please contact with just.viktor@gmail.com</div>
		<div class="add_bt"><a href="/add"><img src="img/add.png" title="<? echo $VideoCount ?>"></a></div>
<? 
			//Панель LoggedInfo
			if (isset($_SESSION['user_name'])) {
				echo '
			<table class="PersonalInfo"><tr>
				<td width="200">
					<div class="UserInfo">
						<a class="UserLogout" href="?logout"></a><div class="UserName"><a href="board/'.$_SESSION['user_name'].'">'.$_SESSION['user_name'].'</a></div>
					</div>
					<div class="Activity">activity <span class="Ratio">'.$_SESSION['user_activity'].'</span>
				</td>
				<td>
					<div class="UserStat">
						<div class="Add">Add <span class="Sum">'.$_SESSION['user_added'].'</span></div>
						<div class="Edit">Edit <span class="Sum">'.$_SESSION['user_edit'].'</span></div>
					</div>
				</td>
				</tr>
			</table>';
			}
?>
    </div>
    <div class="TopPanelBorder"></div>
</div>
<div class="TopPanelMargin"></div>