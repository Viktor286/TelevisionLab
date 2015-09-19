<script type="text/x-handlebars-template" id="waterfall-tpl">
    {{#result}}
    <div class="item">
        <div class="min-icons">{{Motion_Type}}</div>
        <div class="wf-rating"><div class="RateText">{{Rating}}</div></div>
        <div class="wf-info">
            <div class="wf-title"><a href="edit/?video={{OutId}}">{{Title}}</a></div>
            <div class="wf-desc">{{Year}} {{Brand}} {{Location}}</div>
        </div>
        <a href="edit/?video={{OutId}}"> <img src="{{Img}}" width="330" height="186" /></a>
    </div>
    {{/result}}
</script>