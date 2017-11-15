function initialisePickMap() {
    var removefeature = null;

    proj4.defs("EPSG:32633", "+proj=utm +zone=33 +datum=WGS84 +units=m +no_defs");
    proj4.defs("EPSG:32632", "+proj=utm +zone=32 +datum=WGS84 +units=m +no_defs");

    var mapPickSource = new ol.source.Vector({
        wrapX: false,
    });

    var mapPickLayers = [
        new ol.layer.Tile({
            visible: true,
            preload: Infinity,
            source: new ol.source.BingMaps({
                key: 'Ak5AqjsEQ44KtAl7jHhrjGuzNshN1fZv3MOx2MUi0p4zFmq6XeWLKmyqeP2UgJK3',
                imagerySet: 'AerialWithLabels',
                maxZoom: 19,
            }),
        }),
    ];

    var iconStyle = new ol.style.Style({
        image: new ol.style.Icon( /** @type {olx.style.IconOptions} */ {
            anchor: [0.5, 44],
            anchorXUnits: 'fraction',
            anchorYUnits: 'pixels',
            src: mapPin,
        }),
    });

    var vector = new ol.layer.Vector({
        source: mapPickSource,
        style: iconStyle,
    });

    mapPickLayers.push(vector);

    // TODO Get from ark_map tables.
    var mapPickView = new ol.View({
        center: [1155972, 7580813],
        zoom: 6,
        extent: [831000, 7230000, 1750000, 7950000],
        minZoom: 6,
    });

    var mapPickMap = new ol.Map({
        layers: mapPickLayers,
        loadTilesWhileInteracting: true,
        target: 'mappick',
        view: mapPickView,
        controls: [new ol.control.FullScreen(), new ol.control.Zoom()],
    });

    var draw = new ol.interaction.Draw({
        source: mapPickSource,
        type: "Point",
        style: new ol.style.Style({
            image: new ol.style.RegularShape({
                fill: new ol.style.Fill({
                    color: 'white',
                }),
                points: 4,
                radius1: 6,
                radius2: 1,
            }),
        }),
    });

    function updateMapPoint() {
        var easting = null;
        var northing = null;
        if ($('#find_location_easting').is('input')) {
            easting = $('#find_location_easting').val();
            northing = $('#find_location_northing').val();
        } else if ($('#find_location_easting').is('div')) {
            easting = $('#find_location_easting').text();
            northing = $('#find_location_northing').text();
        }
        if (easting && northing) {
            var coords = ol.proj.transform([parseFloat(easting), parseFloat(northing)], 'EPSG:4326', 'EPSG:3857');
            mapPickSource.clear();
            mapPickSource.addFeature(new ol.Feature({
                geometry: new ol.geom.Point(coords),
            }));
        }
    }

    function updateDecimalPoint() {
        var easting = $('#find_location_utmEasting').val();
        var northing = $('#find_location_utmNorthing').val();
        if (easting && northing) {
            var coords = ol.proj.transform([parseFloat(easting), parseFloat(northing)], 'EPSG:32632', 'EPSG:4326');
            $('#find_location_easting').val(coords[0].toFixed(6));
            $('#find_location_northing').val(coords[1].toFixed(6));
        }
    }

    function updateUtmPoint() {
        var easting = $('#find_location_easting').val();
        var northing = $('#find_location_northing').val();
        if (easting && northing) {
            var coords = ol.proj.transform([parseFloat(easting), parseFloat(northing)], 'EPSG:4326', 'EPSG:32632');
            $('#find_location_utmEasting').val(coords[0].toFixed(0));
            $('#find_location_utmNorthing').val(coords[1].toFixed(0));
        }
    }

    function updateMunicipality() {
        var easting = $('#find_location_easting').val();
        var northing = $('#find_location_northing').val();
        var wkt = 'POINT(' + easting + ' ' + northing + ')';

        $.post(path + 'api/geo/find', wkt, function (result) {
            // TODO Find way without using actual form IDs
            console.log(result);
            try {
                $('#find_municipality_term').val(result.municipality.term).trigger("change");
                $('#find_museum_id').val(result.museum.id).trigger("change");
                return true;
            } catch (typeError) {
                alert(window.invalidpointlocation);
                $('#find_location_easting').val('');
                $('#find_location_northing').val('');
                $('#find_location_utmEasting').val('');
                $('#find_location_utmNorthing').val('');
                mapPickSource.clear();
                return false;
            }
        });
    }


    mapPickSource.on('addfeature', function () {
        if (mapPickSource.getFeatures().length === 1) {
            mapPickSource.forEachFeature(function (feature) {
                var coords = ol.proj.transform(feature.getGeometry().getCoordinates(), 'EPSG:3857', 'EPSG:4326');
                $('#find_location_easting').val(parseFloat(coords[0].toFixed(6)));
                $('#find_location_northing').val(parseFloat(coords[1].toFixed(6)));
                updateUtmPoint();
                if (updateMunicipality()) {
                    mapPickMap.getView().setCenter(feature.getGeometry().getCoordinates());
                    mapPickMap.getView().setZoom(12);
                }
            });
        } else {
            mapPickSource.removeFeature(removefeature);
        }

    });

    draw.on('drawend', function (e) {
        if (confirm(window.newpointconfirmmessage)) {
            mapPickSource.clear();
        } else {
            removefeature = e.feature;
        }
    });

    $('.mappick-fields input').on('change', function () {
        switch ($('input[name=mappick-coordinates-radio]:checked', '.mappick-fields').attr('id')) {
            case 'mappick-decimal':
                $(".mappick-decimal-control").attr("readonly", false);
                $(".mappick-utm-control").attr("readonly", true);
                break;

            case 'mappick-utm':
            default:
                $(".mappick-decimal-control").attr("readonly", true);
                $(".mappick-utm-control").attr("readonly", false);
        }
    });

    $('.mappick-decimal-control').on('change', function () {
        updateUtmPoint();
        updateMapPoint();
    });

    $('.mappick-utm-control').on('change', function () {
        updateDecimalPoint();
        updateMapPoint();
    });

    $(".mappick-fields").keydown(function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.activeElement.blur();
        }
    });

    mapPickMap.addInteraction(draw);

    updateUtmPoint();

    updateMapPoint();

}