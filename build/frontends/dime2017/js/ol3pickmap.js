$(document).ready(function() {
    if ($('#mappick').length) {
        var mapPickLayers;
        var mapPickSource;
        var mapPickMap;
        $('#mappick').height($('#mappick').width());
        initialisePickMap();
        $( window ).resize(function() {
            if( $('button[title="Toggle full-screen"]').hasClass('ol-full-screen-false')) {
                $('#mappick').height($('#mappick').width());
            } else {
                $('#mappick').height('100%');
            }
        });
    }
});

function initialisePickMap() {

    proj4.defs("EPSG:32633", "+proj=utm +zone=33 +datum=WGS84 +units=m +no_defs");

    proj4.defs("EPSG:32632", "+proj=utm +zone=32 +datum=WGS84 +units=m +no_defs");

    mapPickLayers = [
        new ol.layer.Tile({
            visible: true,
            preload: Infinity,
            source: new ol.source.BingMaps({
                key: 'Ak5AqjsEQ44KtAl7jHhrjGuzNshN1fZv3MOx2MUi0p4zFmq6XeWLKmyqeP2UgJK3',
                imagerySet: 'AerialWithLabels',
                maxZoom: 19
            })
        })
    ];

    mapPickSource = new ol.source.Vector({
        wrapX: false
    });

    var iconStyle = new ol.style.Style({
        image: new ol.style.Icon( /** @type {olx.style.IconOptions} */ ({
            anchor: [0.5, 44],
            anchorXUnits: 'fraction',
            anchorYUnits: 'pixels',
            src: mapPin
        }))
    });

    var vector = new ol.layer.Vector({
        source: mapPickSource,
        style: iconStyle
    });

    mapPickLayers.push(vector);

    var denmarkExtent = [813900, 7262100, 1798900, 7959750];

    var mapPickView = new ol.View({
        center: [(denmarkExtent[0]+denmarkExtent[2])/2, (denmarkExtent[1]+denmarkExtent[3])/2],
        zoom: 6,
        minZoom: 6
    });

    var mapPickMap = new ol.Map({
        layers: mapPickLayers,
        loadTilesWhileInteracting: true,
        target: 'mappick',
        view: mapPickView,
        controls: [ new ol.control.FullScreen(), new ol.control.Zoom() ],
    });

    var draw = new ol.interaction.Draw({
        source: mapPickSource,
        type: "Point",
        style: new ol.style.Style({
            image: new ol.style.RegularShape({
                fill: new ol.style.Fill({
                    color: 'white'
                }),
                points: 4,
                radius1: 6,
                radius2: 1
            })
        })
    });

    mapPickSource.on('addfeature', function() {
        mapPickSource.forEachFeature(function(feature) {
            coords = ol.proj.transform(feature.getGeometry().getCoordinates(), 'EPSG:3857', 'EPSG:4326');
            $('#find_location_easting').val(parseFloat(coords[0].toFixed(6)));
            $('#find_location_northing').val(parseFloat(coords[1].toFixed(6)));
            updateUtmPoint()
            mapPickMap.getView().setCenter(feature.getGeometry().getCoordinates());
            mapPickMap.getView().setZoom(12);
            updateMunicipality();
        });
    });

    draw.on('drawstart', function() {
        mapPickSource.clear();
    });

    $('.mappick-fields input').on('change', function() {
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

    $('.mappick-decimal-control').on('change', function() {
        updateUtmPoint();
        updateMapPoint();
    });

    $('.mappick-utm-control').on('change', function() {
        updateDecimalPoint();
        updateMapPoint();
    });

    $(".mappick-fields").keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            document.activeElement.blur();
        }
    });

    mapPickMap.addInteraction(draw);

    updateUtmPoint();

    //$('.mappick-fields input').change();
    updateMapPoint();

/* This does not work well
    var constrainPan = debounce(function() {

        var visible = mapPickView.calculateExtent(mapPickMap.getSize());
        var centre = mapPickView.getCenter();
        var delta;
        var adjust = false;
        if ((delta = denmarkExtent[0] - visible[0]) > 0) {
            adjust = true;
            centre[0] += delta;
        } else if ((delta = denmarkExtent[2] - visible[2]) < 0) {
            adjust = true;
            centre[0] += delta;
        }
        if ((delta = denmarkExtent[1] - visible[1]) > 0) {
            adjust = true;
            centre[1] += delta;
        } else if ((delta = denmarkExtent[3] - visible[3]) < 0) {
            adjust = true;
            centre[1] += delta;
        }
        if (adjust) {
            mapPickView.setZoom(Math.max(6,mapPickView.getZoom()));
            mapPickView.setCenter(centre);
        }
    }, 10, false);

    mapPickView.on('change:resolution', constrainPan);
    mapPickView.on('change:center', constrainPan);
    */
};

function updateMunicipality() {
    easting = $('#find_location_easting').val();
    northing = $('#find_location_northing').val();
    var wkt = 'POINT(' + easting + ' ' + northing + ')';

    $.post(path + 'api/geo/find', wkt, function(result) {
        // TODO Find way without using actual form IDs
        $('#find_municipality_term').val(result['municipality']['term']).trigger("change");
        $('#find_museum_item').val(result['museum']['item']).trigger("change");
    });
}

function updateMapPoint() {
    if($('#find_location_easting').is('input')){
        easting = $('#find_location_easting').val();
        northing = $('#find_location_northing').val();
    } else if ($('#find_location_easting').is('div')){
        easting = $('#find_location_easting').text();
        northing = $('#find_location_northing').text();

    }
    if (easting && northing) {
        coords = ol.proj.transform([parseFloat(easting), parseFloat(northing)], 'EPSG:4326', 'EPSG:3857');
        mapPickSource.clear();
        mapPickSource.addFeature(new ol.Feature({
            geometry: new ol.geom.Point(coords),
        }));
    }
}

function updateDecimalPoint() {
    easting = $('#find_location_utmEasting').val();
    northing = $('#find_location_utmNorthing').val();
    if (easting && northing) {
        coords = ol.proj.transform([parseFloat(easting), parseFloat(northing)], 'EPSG:32632', 'EPSG:4326');
        $('#find_location_easting').val(coords[0].toFixed(6));
        $('#find_location_northing').val(coords[1].toFixed(6));
    }
}

function updateUtmPoint() {
    easting = $('#find_location_easting').val();
    northing = $('#find_location_northing').val();
    if (easting && northing) {
        coords = ol.proj.transform([parseFloat(easting), parseFloat(northing)], 'EPSG:4326', 'EPSG:32632');
        $('#find_location_utmEasting').val(coords[0].toFixed(0));
        $('#find_location_utmNorthing').val(coords[1].toFixed(0));
    }
}
