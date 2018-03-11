<script type="text/javascript">
    'use strict';
    $('#container').waterfall({
        itemCls: 'item',
        fitWidth: false,
        colWidth: 319,
        gutterWidth: 19,
        gutterHeight: 15,
        align: 'center',
        minCol: 1,
        maxCol: 3,
        debug: false,
        checkImagesLoaded: false,
        callbacks: {

            loadingFinished: function ($loading, isBeyondMaxPage) {

                !isBeyondMaxPage ? $loading.fadeOut() : $loading.remove();

                //-- Check for not selected video
                if (tvLab.urlVideo() === undefined) { // If url video param does not exist
                    if ($(".waterfall-container .item.here").length === 0) { // if .box.here does not exist too
                        $(".waterfall-container .item:first-child").addClass("here"); // add class to first one
                    }
                }

                $(document).on('click', '.waterfall-container a.wf-load-video', function (event) {
                    event.preventDefault();
                    tvLab.loadVideoOnClick($(this).data('id'), $(this));
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
                window.loadVideoOnPage( data.FirstVideo );
                }';
            } ?>

                if (dataType === 'json' || dataType === 'jsonp') {
                    // json or jsonp format
                    var tpl = $('#waterfall-tpl').html();
                    var template = Handlebars.compile(tpl);
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