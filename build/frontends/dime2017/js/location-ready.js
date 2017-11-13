$(document).ready(function () {
    //we should check here for user auth to update the map
    if ($('#mappick').length) {
        $('#mappick').height($('#mappick').width());
        initialisePickMap();
        $(window).resize(function () {
            if ($('button[title="Toggle full-screen"]').hasClass('ol-full-screen-false')) {
                $('#mappick').height($('#mappick').width());
            } else {
                $('#mappick').height('100%');
            }
        });
    }
});
