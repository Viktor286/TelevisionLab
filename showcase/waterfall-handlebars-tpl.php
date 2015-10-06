{{#result}}
<section id="PostBox">
    <div class="DateTag">
        <div class="Day">{{Pub_Day}}</div> <!-- need Pub_Day eg 17 -->
        <div class="Hr"></div>
        <div class="Month">{{Pub_Month}}</div> <!-- need Pub_Month eg SPT-->
        <div class="Year">{{Pub_Year}}</div> <!-- need Pub_Year eg 2015 -->
    </div>
    <article>
        <div class="wrapper">
            <div class="info">
                <h1>{{Title}}</h1>
                <div class="Authors">
                    <div class="IconCol"><img src="img/ShotInfo_iconUser.png" alt="Authors" /></div>
                    <div class="Names">{{Authors}}</div> <!-- $Authors_Aliases function output line -->
                </div>
                <div class="Location">{{Location}}, {{Year}}</div> <!-- func output line -->
                <div class="Motion_Type"><div class="min_cap">Production type: </div>{{Motion_Type}}</div> <!-- func output line -->
                <div class="Broadcast_Type"><div class="min_cap">Function type: </div>{{Broadcast_Type}}</div> <!-- func output line -->
                <div class="Rating">
                    <div class="Num"><div class="RateText">{{Rating}}</div></div>
                    <div class="AwesomeRate">
                        <div class="min_cap">internal rating</div>
                        <div class="MeterGhost"></div>
                        <div class="MeterExist" style="width: 48%;"></div> <!-- need $RatingWidth-->
                    </div>
                </div>
                <span class="Tags">{{Tags}}</span> <!-- need $Tags func output line -->
            </div>
            <div class="thumb">
                <img src="{{Img}}" />
            </div>
            <div class="clear"></div>
        </div>
    </article>
</section>
{{/result}}
