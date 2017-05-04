$(document).ready(function() {
    if ($('#mappick').length) {
        var mapPickLayers;
        var mapPickSource;
        var mapPickMap;
        initialisePickMap();
    }
});

function initialisePickMap() {
    
    proj4.defs("EPSG:32633","+proj=utm +zone=33 +datum=WGS84 +units=m +no_defs");

    proj4.defs("EPSG:32632","+proj=utm +zone=32 +datum=WGS84 +units=m +no_defs");
    
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
            zoom: 14
        }),
        controls: [],
    });

    var draw = new ol.interaction.Draw({
        source: mapPickSource,
        type: "Point",
        style: new ol.style.Style({
            image:
                new ol.style.RegularShape({
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
            $('.mappick_easting').val(parseFloat(coords[0].toFixed(6)));
            $('.mappick_northing').val(parseFloat(coords[1].toFixed(6)));
            updateUtmpoint()
            mapPickMap.getView().setCenter(feature.getGeometry().getCoordinates());
            updateMunicipality();
        });
    });

    draw.on('drawstart', function() {
        mapPickSource.clear();
    });

    $('.mappick_fields input').on('change', function() {
        switch($('input[name=koordinater]:checked', '.mappick_fields').attr('id')) {
            case 'mappick_utm':
                $(".mappick_easting").attr("readonly", true);
                $(".mappick_northing").attr("readonly", true);
                $(".mappick-utm").attr("readonly", false);
                break;
                
            case 'decimalgrader':
                $(".mappick_easting").attr("readonly", false);
                $(".mappick_northing").attr("readonly", false);
                $(".mappick-utm").attr("readonly", true);
                break;
                
            default:
                $(".mappick_easting").attr("readonly", true);
                $(".mappick_northing").attr("readonly", true);
                $(".mappick-utm").attr("readonly", false);
        }
     });
    
     $('.mappick_easting').on('change', function() {
         updateUtmpoint();
         updateMappoint();
     });

     $('.mappick_northing').on('change', function() {
         updateUtmpoint();
         updateMappoint();
     });
     
     $('.mappick-utm').on('change', function() {
         updateDecimalgrader();
         updateMappoint();
     });
     
     $(".mappick_fields").keydown(function (event) {
         if (event.keyCode == 13) {
             event.preventDefault();
             document.activeElement.blur();
         }
     });
     
    mapPickMap.addInteraction(draw);

    updateUtmpoint();
    
    //$('.mappick_fields input').change();
    updateMappoint();
};

function updateMunicipality() {
    var easting = $('.mappick_easting').val();
    var northing = $('.mappick_northing').val();
    var wkt = 'POINT(' + easting + ' ' + northing + ')';
    $.post(path + 'api/geo/find', wkt, function(result) {
        // TODO Find way without using actual form IDs
        $('#dime_find_item_kommune_term').val(result['kommune']['term']).trigger("change");
        $('#dime_find_item_museum_module').val(result['museum']['module']);
        $('#dime_find_item_museum_item').val(result['museum']['item']);
        $('#dime_find_item_museum_content').val(result['museum']['name']).trigger("change");
    });
}

function updateMappoint() {
    lat = $('.mappick_easting').val();
    lon = $('.mappick_northing').val();
    if ( lat && lon) {
        coords = ol.proj.transform([parseFloat(lat), parseFloat(lon)], 'EPSG:4326', 'EPSG:3857');
        mapPickSource.clear();
        mapPickSource.addFeature(new ol.Feature({
            geometry: new ol.geom.Point(coords),
        }));
    }
}

function updateDecimalgrader() {
    decimalgrader = $('#mappick-utm').val();
    if ($.inArray(",",decimalgrader)>0){
        [lat, lon] = decimalgrader.split(",");
     } else if ($.inArray(" ",decimalgrader)>0){
         [lat, lon] = decimalgrader.split(" ");
     } else if ($.inArray("  ",decimalgrader)>0){
         [lat, lon]=decimalgrader.split("   ");
     }
    coords = ol.proj.transform([parseFloat(lat), parseFloat(lon)], 'EPSG:32632', 'EPSG:4326');
    $('.mappick_easting').val(coords[0].toFixed(6));
    $('.mappick_northing').val(coords[1].toFixed(6));
}

function updateUtmpoint() {
    lat = $('.mappick_easting').val();
    lon = $('.mappick_northing').val();
    if ( lat && lon) {
        coords = ol.proj.transform([parseFloat(lat), parseFloat(lon)], 'EPSG:4326', 'EPSG:32632');
        $('#mappick-utm').val(coords[0].toFixed(0)+', '+coords[1].toFixed(0));
    }
}
