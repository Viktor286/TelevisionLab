<script>
    $('#container').waterfall({
        itemCls: 'item',
        <? if ($Section == $SectionList[0]) { echo "colWidth: 720, maxCol: 1, "; } else { echo "colWidth: 330, maxCol: 3, ";} ?>
        gutterWidth: 19,
        gutterHeight: 15,
        align: 'left',
        debug: false,
        //isFadeIn: true,
        checkImagesLoaded: false,
        callbacks: {
            loadingFinished: function($loading, isBeyondMaxPage) {
                if ( !isBeyondMaxPage ) {
                    $loading.fadeOut();

                } else {
                    //console.log('loading isBeyondMaxPage');
                    $loading.remove();
                }
            },

            loadingError: function($message, xhr) {

                $message.load('nodes/NoResultBlock-board.php').html();

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
            return 'http://www.televisionlab.ru/board/wtfll-controller.php?<? echo "section=".$Section."&user=".$UserName; ?>&page=' + page;
        }
    });
</script>