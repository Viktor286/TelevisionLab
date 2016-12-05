{{#result}}
<section id="PostBox{{Index}}" class="PostBox item">
    <!--<div class="DateTag">
        <div class="Day">{{Pub_Day}}</div>
        <div class="Hr"></div>
        <div class="Month">{{Pub_Month}}</div>
        <div class="Year">{{Pub_Year}}</div>
    </div>-->

    <article>
        <div class="wrapper">
            <div class="info">
                <div class="pad">
                    <h1>{{Title}} N {{Index}}</h1>
                    <div class="Authors">
                        <div class="IconCol"><img src="img/ShotInfo_iconUser.png" alt="Authors" /></div>
                        <div class="Names">{{{Authors}}}</div> <!-- $Authors_Aliases function output line -->
                    </div>
                    <div class="Location">{{{Location}}}</div> <!-- func output line -->
                    <div class="Motion_Type"><div class="min_cap">Production type: </div>{{{Motion_Type}}}</div> <!-- func output line -->
                    <div class="Broadcast_Type"><div class="min_cap">Function type: </div>{{{Broadcast_Type}}}</div> <!-- func output line -->
                    <div class="Rating">
                        <div class="Num"><div class="RateText">{{Rating}}</div></div>
                        <div class="AwesomeRate">
                            <div class="min_cap">internal rating</div>
                            <div class="MeterGhost"></div>
                            <div class="MeterExist" style="width: {{RatingWidth}}%;"></div> <!-- need $RatingWidth-->
                        </div>
                    </div>
                    <span class="Tags">{{{Tags}}}</span> <!-- need $Tags func output line -->
                </div>
            </div>
            <div class="thumb">

                <div class="wrapper" style="padding-top: {{RatioPercent}}%">
                        <div class="main">
                            <img src="{{Img}}" class="VideoThumb" data-outid="{{OutId}}" onclick="javascript:ShowVideoFrame(this,{{OutId}},{{Index}} );" />
                        </div>
                </div>

                <!--<img src="{{Img}}" />-->
                <!--<br class="clear" />-->
            </div>
            <div class="clear"></div>
        </div>
    </article>
</section>
{{/result}}
