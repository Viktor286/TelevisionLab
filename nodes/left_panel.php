 <div><a href="javascript:void(0)" ><div class="icn_sml_other"></div><div class="tag_title">Misc Keywords</div></a></div>
        <div class="LeftMenuRow">
            <ul class="LeftMenuRow_Inner"><?
            if (!mysql_connect(DB_HOST, DB_USER, DB_PASS)) {echo "<h2>MySQL Error!</h2>";exit;}
            mysql_query('set names utf8');
            ShowRating("Tags_Others", 30, $Tags); ?>
            </ul>
            <div class="indent"></div>
        </div>

        <div><a href="javascript:void(0)" ><div class="icn_sml_art"></div><div class="tag_title">Visual</div></a></div>
        <div class="LeftMenuRow">
            <ul class="LeftMenuRow_Inner">
            <? ShowRating("Tags_Arts", 30, $Tags);?>
            </ul>
            <div class="indent"></div>
        </div>

        <div><a href="javascript:void(0)" ><div class="icn_sml_fashion"></div><div class="tag_title">Style</div></a></div>
        <div class="LeftMenuRow">
            <ul class="LeftMenuRow_Inner">
                <? ShowRating("Tags_Fashion", 30, $Tags); ?>
            </ul>
            <div class="indent"></div>
        </div>

        <div><a href="javascript:void(0)" ><div class="icn_sml_sphere"></div><div class="tag_title">Fields</div></a></div>
        <div class="LeftMenuRow">
            <ul class="LeftMenuRow_Inner">
            <? ShowRating("Tags_SA", 30, $Tags);?>
            </ul>
            <div class="indent"></div>
        </div>

        <div><a href="javascript:void(0)" ><div class="icn_sml_music"></div><div class="tag_title">Music</div></a></div>
        <div class="LeftMenuRow">
            <ul class="LeftMenuRow_Inner">
            <? ShowRating("Tags_Music", 30, $Tags); mysql_close();?>
            </ul>
            <div class="indent"></div>
        </div>

        <div><a href="javascript:void(0)" ><div class="icn_sml_worldmap"></div><div class="tag_title">World Map</div></a></div>
        <div class="LeftMenuRow"></div>
        <div><a href="javascript:void(0)" ><div class="icn_sml_authors"></div><div class="tag_title">Authors</div></a></div>
        <div class="LeftMenuRow"></div>

