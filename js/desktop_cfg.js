// Autocomplete

        $(function(){
            var sampleTags = ['realism', 'abstract', 'minimalism', 'futurism', 'surrealism', 'contemporary', 'cinematic', 'Cartoon', 'Art', 'Beauty', 'Adventures', 'Story', 'Fantasy', 'Spiritual', 'Culture', 'Sport', 'Games', 'Enertament', 'Mans', 'Womens', 'Comedy', 'Show', 'Cinema', 'Fun', 'Weird', 'News', 'Info', 'Promo', 'Test', 'Science', 'Education', 'History', 'Political', 'Social', 'Nature', 'Health', 'Industry', 'Buisness', 'Finance', 'Services', 'Vehicles', 'Technology', 'Digital', 'CG', 'Crafts', 'War', 'Criminal'];



            //-------------------------------
            // Single field
            //-------------------------------
            $('#singleFieldTags').tagit({
				showAutocompleteOnFocus: false,
				autocomplete: {delay: 0, minLength: 0},
				tagLimit: 3,
                availableTags: sampleTags,
                singleField: true,
                singleFieldNode: $('#mySingleField'),
				afterTagRemoved: function(evt, ui) {
					document.getElementById("tpSearch").submit();
					}
				
            });

            // singleFieldTags2 is an INPUT element, rather than a UL as in the other 
            // examples, so it automatically defaults to singleField.
            $('#singleFieldTags2').tagit({
                availableTags: sampleTags
            });

            //-------------------------------
            // Preloading data in markup
            //-------------------------------
            $('#myULTags').tagit({
                availableTags: sampleTags, // this param is of course optional. it's for autocomplete.
                // configure the name of the input field (will be submitted with form), default: item[tags]
                itemName: 'item',
                fieldName: 'tags'
            });

            //-------------------------------
            // Tag events
            //-------------------------------
            var eventTags = $('#eventTags');

            var addEvent = function(text) {
                $('#events_container').append(text + '<br>');
            };

            eventTags.tagit({
                availableTags: sampleTags,
                beforeTagAdded: function(evt, ui) {
                    if (!ui.duringInitialization) {
                        addEvent('beforeTagAdded: '+ eventTags.tagit('tagLabel', ui.tag));
                    }
                },
                afterTagAdded: function(evt, ui) {
                    if (!ui.duringInitialization) {
                        addEvent('afterTagAdded: '+ eventTags.tagit('tagLabel', ui.tag));
                    }
                },
                beforeTagRemoved: function(evt, ui) {
                    addEvent('beforeTagRemoved: '+ eventTags.tagit('tagLabel', ui.tag));
                },
                afterTagRemoved: function(evt, ui) {
                    addEvent('afterTagRemoved: '+ eventTags.tagit('tagLabel', ui.tag));
                },
                onTagClicked: function(evt, ui) {
                    addEvent('onTagClicked: '+ eventTags.tagit('tagLabel', ui.tag));
                },
                onTagExists: function(evt, ui) {
                    addEvent('onTagExists: '+ eventTags.tagit('tagLabel', ui.existingTag));
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
                availableTags: sampleTags
            });

            //-------------------------------
            // Allow spaces without quotes.
            //-------------------------------
            $('#allowSpacesTags').tagit({
                availableTags: sampleTags,
                allowSpaces: true
            });

            //-------------------------------
            // Remove confirmation
            //-------------------------------
            $('#removeConfirmationTags').tagit({
                availableTags: sampleTags,
                removeConfirmation: true
            });
            
        });