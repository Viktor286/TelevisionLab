
function isEmpty(str) {
    return ( !str || 0 === str.length );
}

function indexOfMin(arr) {
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
}




// Video display Tag here highlight when entire document ready
// (similar to desktop/js/scripts.js when LoadVideoOnPage ajax done)
$( document ).ready(function() {
    var tags_arr = NowTags.split(' ');
    $.each(tags_arr, function( index, value ) {
        $('a.tag-item[data-tag='+ value +']').addClass("here");
    });
});


