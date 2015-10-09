<script>
    $('#container').waterfall({
        itemCls: 'item',
        colWidth: 870,
        gutterWidth: 5,
        gutterHeight: 5,
        align: 'left',
        minCol: 1,
        maxCol: 1,
        // resizable: false,
        debug: true,
        //isFadeIn: true,
        checkImagesLoaded: false,
        callbacks: {
            loadingStart: function($loading) {

            },

            loadingFinished: function($loading, isBeyondMaxPage) {
                if ( !isBeyondMaxPage ) {
                    $loading.fadeOut();
                    //console.log('loading finished');
                } else {
                    //console.log('loading isBeyondMaxPage');
                    $loading.remove();
                }
                // $('section#PostBox.item').css("position","relative");
            },

            renderData: function (data, dataType) {
                var Total = data.total;
                var Pages = data.pages;
                var Page = data.page;

                if ( Pages == Page) {
                    $('#container').waterfall('pause', function() {
                        $('#waterfall-message').html('<!--No more result from database-->')
                    });
                }

                if ( dataType === 'json' ||  dataType === 'jsonp'  ) { // json or jsonp format
                    tpl = $('#waterfall-tpl').html();
                    template = Handlebars.compile(tpl);
                    return template(data);

                } else { // html format

                    return data;
                }
            }
        },
        path: function(page) {
            return 'showcase/wtfll-controller.php?<? echo $Http_query; ?>&page=' + page + '<? echo $jsDataRef; ?>';
        }
    });

</script>