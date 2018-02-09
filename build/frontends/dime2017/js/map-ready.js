$(document).ready(function () {
    if ($('#mapview').length) {
        window.map = initialiseMapView();
        getPointsFromTable();
        $(".dime-table").on('post-body.bs.table', function (e) {
          window.selected = [];
          window.mapcollection.clear();
          getPointsFromTable();
        });
        /*
        $(".dime-table").on('page-change.bs.table', function (e) {
          getPointsFromTable();
        });
        */
    }

    if ($('#mapmodal').length) {
        window.map = initialiseMapModal();
    }

    //we should check here for user auth to update the map
    if ($('#mappick').length) {
        $('#mappick').height($('#mappick').width());
        initialisePickMap('mappick');
        $(window).resize(function () {
            if ($('button[title="Toggle full-screen"]').hasClass('ol-full-screen-false')) {
                $('#mappick').height($('#mappick').width());
            } else {
                $('#mappick').height('100%');
            }
        });

    }
});
