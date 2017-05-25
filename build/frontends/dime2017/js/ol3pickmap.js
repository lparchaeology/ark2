$(document).ready(function() {
    if ($('#mappick').length) {
        var mapPickLayers;
        var mapPickSource;
        var mapPickMap;
        initialisePickMap();
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

    var mapPickMap = new ol.Map({
        layers: mapPickLayers,
        loadTilesWhileInteracting: true,
        target: 'mappick',
        view: new ol.View({
            center: [965972, 7575813],
            //center: [531578, 6295675],
            zoom: 5
        }),
        controls: [new ol.control.FullScreen()],
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
            $('#dime_find_item_location_easting').val(parseFloat(coords[0].toFixed(6)));
            $('#dime_find_item_location_northing').val(parseFloat(coords[1].toFixed(6)));
            updateUtmPoint()
            mapPickMap.getView().setCenter(feature.getGeometry().getCoordinates());
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
};

function updateMunicipality() {
    easting = $('#dime_find_item_location_easting').val();
    northing = $('#dime_find_item_location_northing').val();
    var wkt = 'POINT(' + easting + ' ' + northing + ')';
    $.post(path + 'api/geo/find', wkt, function(result) {
        // TODO Find way without using actual form IDs
        $('#dime_find_item_municipality_term').val(result['municipality']['term']).trigger("change");
        $('#dime_find_item_museum_module').val(result['museum']['module']);
        $('#dime_find_item_museum_item').val(result['museum']['item']);
        $('#dime_find_item_museum_content').val(result['museum']['name']).trigger("change");
    });
}

function updateMapPoint() {
    easting = $('#dime_find_item_location_easting').val();
    northing = $('#dime_find_item_location_northing').val();
    if (easting && northing) {
        coords = ol.proj.transform([parseFloat(easting), parseFloat(northing)], 'EPSG:4326', 'EPSG:3857');
        mapPickSource.clear();
        mapPickSource.addFeature(new ol.Feature({
            geometry: new ol.geom.Point(coords),
        }));
    }
}

function updateDecimalPoint() {
    easting = $('#dime_find_item_location_utmEasting').val();
    northing = $('#dime_find_item_location_utmNorthing').val();
    if (easting && northing) {
        coords = ol.proj.transform([parseFloat(easting), parseFloat(northing)], 'EPSG:32632', 'EPSG:4326');
        $('#dime_find_item_location_easting').val(coords[0].toFixed(6));
        $('#dime_find_item_location_northing').val(coords[1].toFixed(6));
    }
}

function updateUtmPoint() {
    easting = $('#dime_find_item_location_easting').val();
    northing = $('#dime_find_item_location_northing').val();
    if (easting && northing) {
        coords = ol.proj.transform([parseFloat(easting), parseFloat(northing)], 'EPSG:4326', 'EPSG:32632');
        $('#dime_find_item_location_utmEasting').val(coords[0].toFixed(0));
        $('#dime_find_item_location_utmNorthing').val(coords[1].toFixed(0));
    }
}
