
//------------------------------------------------------------------------------------
// Desktop. General
module.exports = function() {

    $(document).ready(function () {

        tvLab.nowVid ? tvLab.loadVideoOnPage(tvLab.nowVid) : null;

        tvLab.checkAlert = function (text) {
            alert(text);
        };

        tvLab.indexOfMin = function (arr) {
            if (arr.length === 0) {
                return -1; // this will return on empty array
            }

            var min = arr[0];
            var minIndex = 0;

            for (var i = 1; i < arr.length; i++) {
                if (arr[i] < min) {
                    minIndex = i;
                    min = arr[i];
                }
            }

            return minIndex;
        };

        tvLab.isEmpty = function (str) {
            return ( !str || 0 === str.length );
        };

        tvLab.dropTypeOnClick = function () {
            // Drops filters state and reloads
            $('input#set').val("c0d0s0a0t0v0");
            $('#top-panel__search').submit();
        };

        tvLab.resetSet = function (tag) {
            // Drops filters state, reloads, select new tag
            $("ul.top-panel__search-field").tagit("removeAll");
            $("ul.top-panel__search-field").tagit("createTag", tag);
            $('#set').val("c0d0s0a0t0v0");
            $('#top-panel__search').submit();
        };

        tvLab.urlVideo = function (param) {
            // Select new video input param

            var url = tvLab.nowUrl;
            var Rgx = /(video=)(\d*)/;

            if (typeof param !== 'undefined') {

                if (!url.match(Rgx)) {
                    url = url + '&' + "video=" + param;
                }

                var newUrl = url.replace(Rgx, "$1" + param);
                window.history.pushState("", "", "?" + newUrl);
                tvLab.nowUrl = newUrl;
                return newUrl;

            } else {

                //--Shows URLs video param
                var Rslt = "";
                if (Rslt = url.match(Rgx)) {
                    if (!tvLab.isEmpty(Rslt[2])) {
                        return Rslt[2];
                    } else {
                        return undefined;
                    }
                }
            }

        };

        tvLab.loadVideoOnClick = function (id, thisObj) {
            // Load Video On Click + some actions on this event
            // Update Video Input param
            tvLab.urlVideo(id);

            // Update Video Input param
            $('input#InputVideo').val(id);

            // Update Logo Button
            //$('.tpLogo').html('<a href="?video=' + id + '"></a>');

            // Update Item Box Here class
            $("div.item.here").removeClass("here");
            $(thisObj).parent().parent().addClass("here");

            //Load Video
            tvLab.loadVideoOnPage(id);
        };

        /**
         * Video display Tag here highlight when entire document ready */

        var tags_arr = tvLab.nowTags.split(' ');
        $.each(tags_arr, function (index, value) {
            $('a.tag-item[data-tag=' + value + ']').addClass("here");
        });


        /**
         * AdjustH1InfoOutput Line */
        //-- Remove tag on x click
        $("div#main-output > h1.state-info > span.Tags > span.tag span.x-close")
            .on("click", function (event) {

                // Recognize tag text
                var TagText = $(this).parent().text();
                TagText = TagText.replace("⨯", "");
                TagText = TagText.replace("# ", "");

                // Remove tag
                $("ul.top-panel__search-field").tagit("removeTagByLabel", TagText);

                // Remove div tag
                $(this).parent().fadeOut(200, function () {
                    TagText.remove();
                });
                // Submit with delay
                setTimeout(function () {
                    $('#top-panel__search').submit();
                }, 100);
            });


        /**
         * Video display tag click event */

        $(document).on('click', 'a.tag', function (event) {
            event.preventDefault();
            var tag = $(event.target).data('tag');
            $("ul.top-panel__search-field").tagit("removeAll");
            $("ul.top-panel__search-field").tagit("createTag", tag);
            $('#top-panel__search').submit();
        });

        // Tags overview Tag click event
        $(document).on('click', 'a.tag-item', function (event) {
            event.preventDefault();
            var tag = $(event.target).data('tag');
            $("ul.top-panel__search-field").tagit("removeAll");
            $("ul.top-panel__search-field").tagit("createTag", tag);
            // $('input#InputVideo').val(""); // Drop displayed video to ""
            $('#top-panel__search').submit();
        });


        /**
         *  Accordion Left Panel with Tags overview
         *  Tag "here" highlighted with entire document */

        $.each(tvLab.nowTags.split(' '), function (index, value) {
            $('a.tag-item[data-tag=' + value + ']').addClass("here");
        });


        // tvLab.menuState = 3; // is works
        // let menuState = document.cookie[document.cookie.length-1];
        // COOKIE NOT WORKING WITH ACCORDION

        $("aside#left-panel div.accordion").accordion({
            collapsible: true,
            active: tvLab.menuState,
            heightStyle: "content",

            create: function (event, ui) {
                $('aside#left-panel div.accordion').css("display", "block");
                // console.log('accordion create: '+ $("aside#left-panel div.accordion").accordion("option", "active"), tvLab.menuState);
            },

            activate: function (event, ui) {
                var tagMenuActive = $("aside#left-panel div.accordion").accordion("option", "active");
                document.cookie = "TagMenuState=" + tagMenuActive;

            }

        });

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

                    if (!tvLab.nowVid) {
                        if (data.page === 1) {
                            tvLab.loadVideoOnPage( data.FirstVideo );
                        }
                    }

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
                return 'desktop/json/waterfall_page.php?'+tvLab.nowUrl+'&page=' + page;
            }
        });

    });
};
