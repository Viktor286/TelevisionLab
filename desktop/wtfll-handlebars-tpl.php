{{#result}}
<div class="item" data-id="{{OutId}}">
    <div class="box{{CurrentClass}}">
        <div class="min-icons">{{{Motion_Type}}}</div>
        <div class="wf-rating"><div class="RateText">{{Rating}}</div></div>
        <div class="wf-info">
            <div class="wf-title"><a href="javascript:void(0);" onclick="LoadVideoOnClick('{{OutId}}',this);return true">{{Title}}</a></div>
            <div class="wf-desc">{{Year}} {{Brand}} {{Location}}</div>
        </div>
        <a href="javascript:void(0);" onclick="LoadVideoOnClick('{{OutId}}',this);return true"> <img src="{{Img}}" /></a>
    </div>
</div>
{{/result}}
