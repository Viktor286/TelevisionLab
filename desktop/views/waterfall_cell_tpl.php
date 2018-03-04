{{#result}}
<div class="item{{CurrentClass}}" data-id="{{OutId}}">
    <div class="box">
        <div class="min-icons">{{{Motion_Type}}}</div>
        <div class="wf-rating">
            <div class="rate-text">{{Rating}}</div>
        </div>
        <div class="wf-info">
            <div class="wf-title"><a class="wf-load-video" data-id="{{OutId}}">{{Title}}</a></div>
            <div class="wf-desc">{{Year}} {{Brand}} {{Location}}</div>
        </div>
        <a class="wf-load-video" data-id="{{OutId}}"> <img src="{{Img}}"/></a>
    </div>
</div>
{{/result}}
