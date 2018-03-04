<div class="top-panel-box">
    <div class="top-panel">
        <div class="top-panel__logo">
            <?
            // if (isset($VideoId)) {echo '<a href="?video='.$VideoId.'"></a>';} else {echo '<a href="/"></a>';}
            echo '<a href="/"></a>';
            ?>
        </div>
        <div class="top-panel__db-state-icon"
             data-balloon="The current selected database is connected for demonstration purposes."
             data-balloon-pos="down" data-balloon-length="medium"></div>
        <form method="get" id="top-panel__search">

            <div class="top-panel__input-wrap">
                <input type="text" name="tags" class="top-panel__search-field" value="<? if (isset($Tags)) { echo $Tags;} ?>">
                <ul class="top-panel__search-field"></ul>
                <input type="submit" value="" class="top-panel__search-btn"/>
            </div>

            <div class="top-panel__search-filters">
                <div class="top-panel__search-filters_fixwrap">
                    <div class="filters_icon_title_line"></div>
                    <div class="filters_icon_left"></div>
                    <input type="checkbox" class="cbx" data-sdb-image="url('_global/img/bt40_compositing.png')"
                           title="Select all the media which made mostly with composition production type." id="comp"
                           alt="Compositing" <? matchChecked($qSet, '/c1/'); ?> />
                    <input type="checkbox" class="cbx" data-sdb-image="url('_global/img/bt40_graphics.png')" id="3d"
                           alt="3d Graphics" <? matchChecked($qSet, '/d1/'); ?> />
                    <input type="checkbox" class="cbx" data-sdb-image="url('_global/img/bt40_simulation.png')" id="sim"
                           alt="Simulation" <? matchChecked($qSet, '/s1/'); ?> />
                    <input type="checkbox" class="cbx" data-sdb-image="url('_global/img/bt40_animation.png')" id="anim"
                           alt="Cartoon (Drawing)" <? matchChecked($qSet, '/a1/'); ?> />
                    <input type="checkbox" class="cbx" data-sdb-image="url('_global/img/bt40_stop_motion.png')"
                           id="stpm" alt="Stop Motion" <? matchChecked($qSet, '/t1/'); ?> />
                    <input type="checkbox" class="cbx" data-sdb-image="url('_global/img/bt40_video.png')" id="vid"
                           alt="Video" <? matchChecked($qSet, '/v1/'); ?> />
                    <input type="hidden" name="set" id="set" value="<? echo $qSet ?>">
                    <input type="checkbox" class="cbx" data-sdb-image="url('_global/img/bt40_only.png')" id="md"
                           name="md" alt="Mode" <? matchChecked($Mode, '/on/'); ?> />
                    <div class="filters_icon_right"></div>
                </div>
            </div>
        </form>

        <div class="top-panel__infoline">Television Lab is a prototype of an online motion graphics database. For more information
            or for participation please contact with just.viktor@gmail.com
        </div>
        <!--<div class="add_bt"><a href="/add"><img src="_global/img/add.png" title="<? /* echo $VideoCount */ ?>"></a></div>-->
        <div class="top-panel__to-board-btn"></div>
        <div class="top-panel__help"></div>

        <?
        // Panel LoggedInfo
        if (isset($_SESSION['user_name'])) {
            echo '
			<table class="PersonalInfo"><tr>
				<td width="200">
					<div class="UserInfo">
						<a class="UserLogout" href="?logout"></a><div class="UserName"><a href="board/' . $_SESSION['user_name'] . '">' . $_SESSION['user_name'] . '</a></div>
					</div>
					<div class="Activity">activity <span class="Ratio">' . $_SESSION['user_activity'] . '</span>
				</td>
				<td>
					<div class="UserStat">
						<div class="Add">Add <span class="Sum">' . $_SESSION['user_added'] . '</span></div>
						<div class="Edit">Edit <span class="Sum">' . $_SESSION['user_edit'] . '</span></div>
					</div>
				</td>
				</tr>
			</table>';
        }
        ?>
    </div>
    <div class="top-panel-border"></div>
</div>
<div class="top-panel-margin"></div>