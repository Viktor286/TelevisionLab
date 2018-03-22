
//------------------------------------------------------------------------------------
// Top panel
module.exports = function() {
    $(document).ready(function () {

        //------------------------------------------------------------------------------------
        // Filter Buttons Assemble

        var mQ;

        // screw-default-buttons init
        $('input:radio').screwDefaultButtons({
            image: 'url("img/radioSmall.jpg")',
            width: 40,
            height: 40
        });

        $('input:checkbox').screwDefaultButtons({
            image: 'url("img/checkboxSmall.jpg")',
            width: 40,
            height: 40
        });

        // Hide before build completely
        $('.top-panel__search-filters_fixwrap').css("display", "block");

        // Sync with php passed url 'set code'
        tvLab.nowSet.match(/[\d\w]{12}/) ? mQ = tvLab.nowSet : mQ = "c0d0s0a0t0v0";

        // Shorthand for submit
        tvLab.mqSetSubmit = function () {
            $('#set').val(mQ);
            $('#top-panel__search').submit();
        };

        // Check the 'chk' in form, if so -- changing filter code mQ
        $('#comp')[0].checked === true ? mQ = mQ.replace(/c0/, 'c1') : null;
        $('#3d')[0].checked === true ? mQ = mQ.replace(/d0/, 'd1') : null;
        $('#sim')[0].checked === true ? mQ = mQ.replace(/s0/, 's1') : null;
        $('#anim')[0].checked === true ? mQ = mQ.replace(/a0/, 'a1') : null;
        $('#stpm')[0].checked === true ? mQ = mQ.replace(/t0/, 't1') : null;
        $('#vid')[0].checked === true ? mQ = mQ.replace(/v0/, 'v1') : null;

        // Event Callbacks
        $('.styledCheckbox:has(#md)').on('click', function () {
            tvLab.mqSetSubmit();
        });

        $('.styledCheckbox:has(#comp)').on('click', function () {
            if ($('#comp').is(':checked')) {
                if (!mQ.match(/c1/)) {
                    mQ = mQ.replace(/c0/, 'c1')
                }
            } else {
                if (!mQ.match(/c0/)) {
                    mQ = mQ.replace(/c1/, 'c0')
                }
            }
            tvLab.mqSetSubmit();
        });

        $('.styledCheckbox:has(#3d)').on('click', function () {
            if ($('#3d').is(':checked')) {
                if (!mQ.match(/d1/)) {
                    mQ = mQ.replace(/d0/, 'd1')
                }
            } else {
                if (!mQ.match(/d0/)) {
                    mQ = mQ.replace(/d1/, 'd0')
                }
            }
            tvLab.mqSetSubmit();
        });

        $('.styledCheckbox:has(#sim)').on('click', function () {
            if ($('#sim').is(':checked')) {
                if (!mQ.match(/s1/)) {
                    mQ = mQ.replace(/s0/, 's1')
                }
            } else {
                if (!mQ.match(/s0/)) {
                    mQ = mQ.replace(/s1/, 's0')
                }
            }
            tvLab.mqSetSubmit();
        });

        $('.styledCheckbox:has(#anim)').on('click', function () {
            if ($('#anim').is(':checked')) {
                if (!mQ.match(/a1/)) {
                    mQ = mQ.replace(/a0/, 'a1')
                }
            } else {
                if (!mQ.match(/a0/)) {
                    mQ = mQ.replace(/a1/, 'a0')
                }
            }
            tvLab.mqSetSubmit();
        });

        $('.styledCheckbox:has(#stpm)').on('click', function () {
            if ($('#stpm').is(':checked')) {
                if (!mQ.match(/t1/)) {
                    mQ = mQ.replace(/t0/, 't1')
                }
            } else {
                if (!mQ.match(/t0/)) {
                    mQ = mQ.replace(/t1/, 't0')
                }
            }
            tvLab.mqSetSubmit();
        });

        $('.styledCheckbox:has(#vid)').on('click', function () {
            if ($('#vid').is(':checked')) {
                if (!mQ.match(/v1/)) {
                    mQ = mQ.replace(/v0/, 'v1')
                }
            } else {
                if (!mQ.match(/v0/)) {
                    mQ = mQ.replace(/v1/, 'v0')
                }
            }
            tvLab.mqSetSubmit();
        });


        //------------------------------------------------------------------------------------
        // Tagit auto complete. top panel input area

        tvLab.sampleTags = ['realism', 'abstract', 'minimalism', 'futurism', 'surrealism', 'contemporary', 'cinematic', 'Cartoon', 'Art', 'Beauty', 'Adventures', 'Story', 'Fantasy', 'Spiritual', 'Culture', 'Sport', 'Games', 'Enertament', 'Mans', 'Womens', 'Comedy', 'Show', 'Cinema', 'Fun', 'Weird', 'News', 'Info', 'Promo', 'Test', 'Science', 'Education', 'History', 'Political', 'Social', 'Nature', 'Health', 'Industry', 'Buisness', 'Finance', 'Services', 'Vehicles', 'Technology', 'Digital', 'CG', 'Crafts', 'War', 'Criminal'];

        //-------------------------------
        // Single field
        //-------------------------------
        $('ul.top-panel__search-field').tagit({
            showAutocompleteOnFocus: false,
            autocomplete: {delay: 0, minLength: 0},
            tagLimit: 3,
            availableTags: tvLab.sampleTags,
            singleField: true,
            singleFieldNode: $('input.top-panel__search-field'),
            afterTagRemoved: function (evt, ui) {
                //document.getElementById("top-panel__search").submit();
            }

        });

        //-------------------------------
        // Preloading data in markup
        //-------------------------------
        $('#myULTags').tagit({
            availableTags: tvLab.sampleTags, // this param is of course optional. it's for autocomplete.
            // configure the name of the input field (will be submitted with form), default: item[tags]
            itemName: 'item',
            fieldName: 'tags'
        });

        //-------------------------------
        // Tag events
        //-------------------------------
        tvLab.eventTags = $('#eventTags');

        tvLab.addEvent = function (text) {
            $('#events_container').append(text + '<br>');
        };

        tvLab.eventTags.tagit({
            availableTags: tvLab.sampleTags,
            beforeTagAdded: function (evt, ui) {
                if (!ui.duringInitialization) {
                    tvLab.addEvent('beforeTagAdded: ' + tvLab.eventTags.tagit('tagLabel', ui.tag));
                }
            },
            afterTagAdded: function (evt, ui) {
                if (!ui.duringInitialization) {
                    tvLab.addEvent('afterTagAdded: ' + tvLab.eventTags.tagit('tagLabel', ui.tag));
                }
            },
            beforeTagRemoved: function (evt, ui) {
                tvLab.addEvent('beforeTagRemoved: ' + tvLab.eventTags.tagit('tagLabel', ui.tag));
            },
            afterTagRemoved: function (evt, ui) {
                tvLab.addEvent('afterTagRemoved: ' + tvLab.eventTags.tagit('tagLabel', ui.tag));
            },
            onTagClicked: function (evt, ui) {
                tvLab.addEvent('onTagClicked: ' + tvLab.eventTags.tagit('tagLabel', ui.tag));
            },
            onTagExists: function (evt, ui) {
                tvLab.addEvent('onTagExists: ' + tvLab.eventTags.tagit('tagLabel', ui.existingTag));
            }
        });

        //-------------------------------
        // Read-only
        //-------------------------------
        $('#readOnlyTags').tagit({
            readOnly: false
        });

        //-------------------------------
        // Tag-it methods
        //-------------------------------
        $('#methodTags').tagit({
            availableTags: tvLab.sampleTags
        });

        //-------------------------------
        // Allow spaces without quotes.
        //-------------------------------
        $('#allowSpacesTags').tagit({
            availableTags: tvLab.sampleTags,
            allowSpaces: true
        });

        //-------------------------------
        // Remove confirmation
        //-------------------------------
        $('#removeConfirmationTags').tagit({
            availableTags: tvLab.sampleTags,
            removeConfirmation: true
        });

    });
};
