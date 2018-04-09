function initialiseMapModal() {

    $('#mapmodal').data('map', initialisePickMap('mapmodal'));
    $('#modal_mapbtn').on('click', function () {
        $('#mapmodal').height('100vw');
        //this needs a delay, not sure why but it won't work without it
        setTimeout(function () { $('#mapmodal').data('map').updateSize(); }, 200);
    });

    var geolocation = new ol.Geolocation({
        // take the projection to use from the map's view
        projection: $('#mapmodal').data('map').getView().getProjection()
    });
    console.log(geolocation);

    $('#mapmodal').data('mapPickSource').clear();

    geolocation.setTracking(false);

    var positionFeature = new ol.Feature();
    var coordinates = geolocation.getPosition();
    positionFeature.setGeometry(coordinates
        ? new ol.geom.Point(coordinates) : null);

    geolocation.on('change:position', function () {
        mapPickSource = $('#mapmodal').data('mapPickSource');

        mapPickSource.clear();
        var coordinates = geolocation.getPosition();
        positionFeature.setGeometry(coordinates
            ? new ol.geom.Point(coordinates) : null);

        mapPickSource.addFeature(positionFeature);
        mapView = $('#mapmodal').data('map').getView();
        mapView.setCenter(coordinates);
        mapView.setZoom(14);
        $('#mapmodal').data('positionFeature', positionFeature);

        confirmLocation = $('#mapmodal').data('confirmLocation');

        confirmLocation($('#mapmodal').data('positionFeature'));

        geolocation.setTracking(false);
    });

    $('#getuserlocation').on('click', function (e) {
        e.preventDefault();
        geolocation.setTracking(true);
        geolocation.changed();
    });

    $('#mappickclose').on('click', function (e) { e.preventDefault();
        $("#mapmodal").modal('hide'); });

    $("#map-modal").on("hidden.bs.modal", function () {
        // potentially remove the event listeners when the dialog is dismissed
        console.log("hide");
        $("#find-registered-alert").alert("close");
    });

    return $('#mapmodal').data('map');

};
