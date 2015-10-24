<script>
    $('#container').waterfall({
        itemCls: 'item',
        fitWidth: false,
        colWidth: xCol,
        gutterWidth: 19,
        gutterHeight: 15,
        align: 'center',
        minCol: 1,
        maxCol: 3,
        debug: false,
        //isFadeIn: true,
        checkImagesLoaded: false,
        callbacks: {
            loadingFinished: function($loading, isBeyondMaxPage) {
                if ( !isBeyondMaxPage ) {
                    $loading.fadeOut();
                    //console.log('loading finished');
                } else {
                    //console.log('loading isBeyondMaxPage');
                    $loading.remove();
                }

            },

            renderData: function (data, dataType) {
                var Total = data.total;
                var Pages = data.pages;
                var Page = data.page;

                if ( Pages == Page ) {
                    $('#container').waterfall('pause', function() {
                        $('#waterfall-message').html('<!--No more result from database-->')
                    });
                }

                <? if (!isset( $VideoId )) { echo '
                if (Page == 1) {
                //alert(data.FirstTitle);
                LoadVideoOnPage( data.FirstVideo );
                }'; } ?>

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
            return 'desktop/wtfll-controller.php?<? echo $Http_query; ?>&page=' + page + '<? echo $jsDataRef; ?>';
        }
    });

</script>