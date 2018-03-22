
//------------------------------------------------------------------------------------
// Television Lab Player link with waterfall output grid: prev/next video bond ability
module.exports = function() {
    $(document).ready(function () {
        // References for Vimeo Player API
        // https://github.com/vimeo/player.js

        tvLab.setAutoPlayUI = function (type) { // "Cycle" or "Next"
            var AutoPlayButton = $("div#MPC div.AutoPlay");

            if (type === "Next") {
                AutoPlayButton.removeClass("Cycle");
                AutoPlayButton.addClass("Next");
            } else if (type === "Cycle") {
                AutoPlayButton.removeClass("Next");
                AutoPlayButton.addClass("Cycle");
            }
        };

        tvLab.videoGoAndPlay = function (state) {
            var this_Vid_Obj = $("#container.waterfall-container div.item.here");
            var first_Vid_Obj = $("#container.waterfall-container").children().first();
            var next_Vid_Obj = this_Vid_Obj.next();
            var prev_Vid_Obj = this_Vid_Obj.prev();
            var next_Vid_Id = next_Vid_Obj.data("id");
            var prev_Vid_Id = prev_Vid_Obj.data("id");

            if (state === "Next") {
                if (typeof next_Vid_Id !== 'undefined') {
                    this_Vid_Obj.removeClass("here");
                    next_Vid_Obj.addClass("here");
                    tvLab.loadVideoOnPage(next_Vid_Id);
                } else {
                    // If no data-id then drop .here class to the first element
                    this_Vid_Obj.removeClass("here");
                    first_Vid_Obj.addClass("here");
                    tvLab.loadVideoOnPage(first_Vid_Obj.data("id"));
                }
            }

            if (state === "Prev") {
                if (typeof prev_Vid_Id !== 'undefined') {
                    this_Vid_Obj.removeClass("here");
                    prev_Vid_Obj.addClass("here");
                    tvLab.loadVideoOnPage(prev_Vid_Id);
                } else {
                    // If no data-id then drop .here class to the first element
                    this_Vid_Obj.removeClass("here");
                    first_Vid_Obj.addClass("here");
                    tvLab.loadVideoOnPage(first_Vid_Obj.data("id"));
                }
            }
        };

        /* Desktop player listeners extends Main Player */
        $(document).on('click', 'div#MPC div#NextVideo', function (event) {
            event.preventDefault();
            tvLab.videoGoAndPlay("Next");
        });

        $(document).on('click', 'div#MPC div#PrevVideo', function (event) {
            event.preventDefault();
            tvLab.videoGoAndPlay("Prev");
        });
    });
};
