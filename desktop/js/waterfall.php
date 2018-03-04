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

            loadingFinished: function ($loading, isBeyondMaxPage) {
                if (!isBeyondMaxPage) {
                    $loading.fadeOut();
                } else {
                    $loading.remove();
                }

                //-- Check for not selected video
                if (urlVideo() === undefined) { // If url video param does not exist
                    if ($(".waterfall-container .item.here").length === 0) { // if .box.here does not exist too
                        $(".waterfall-container .item:first-child").addClass("here"); // add class to first one
                    }
                }

                $(document).on('click', '.waterfall-container a.wf-load-video', function (event) {
                    event.preventDefault();
                    LoadVideoOnClick($(this).data('id'), $(this));
                });

            },

            renderData: function (data, dataType) {

                if (data.pages === data.page) {
                    $('#container').waterfall('pause', function () {
                        $('#waterfall-message').html('<!--No more result from database-->')
                    });
                }

                <? if (!isset($VideoId)) {
                echo '
                if (data.page == 1) {
                LoadVideoOnPage( data.FirstVideo );
                }';
            } ?>

                if (dataType === 'json' || dataType === 'jsonp') {
                    // json or jsonp format
                    tpl = $('#waterfall-tpl').html();
                    template = Handlebars.compile(tpl);
                    return template(data);
                } else {
                    // html format
                    return data;
                }

            }
        },
        path: function (page) {
            return 'desktop/json/waterfall_page.php?<? echo $Http_query; ?>&page=' + page + '<? echo $jsDataRef; ?>';
        }
    });


</script>