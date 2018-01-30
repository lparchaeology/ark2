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

    function mapToDecimal(map) {
        var result = ol.proj.transform(map, 'EPSG:3857', 'EPSG:4326');
        var easting = parseFloat(result[0]).toFixed(6);
        var northing = parseFloat(result[1]).toFixed(6);
        return { 'easting': easting, 'northing': northing, 'srid': 4326 };
    }

    function decimalToMap(decimal) {
        var result = ol.proj.transform([decimal['easting'], decimal['northing']], 'EPSG:4326', 'EPSG:3857');
        var easting = parseFloat(result[0]).toFixed(6);
        var northing = parseFloat(result[1]).toFixed(6);
        return { 'easting': easting, 'northing': northing, 'srid': 4326 };
    }

    function utmToDecimal(utm) {
        var result = ol.proj.transform([utm['easting'], utm['northing']], 'EPSG:32632', 'EPSG:4326');
        var easting = parseFloat(result[0]).toFixed(6);
        var northing = parseFloat(result[1]).toFixed(6);
        return { 'easting': easting, 'northing': northing, 'srid': 4326 };
    }

    function decimalToUtm(decimal) {
        var result = ol.proj.transform([decimal['easting'], decimal['northing']], 'EPSG:4326', 'EPSG:32632');
        var easting = parseInt(result[0]);
        var northing = parseInt(result[1]);
        return { 'easting': easting, 'northing': northing, 'srid': 32632 };
    }

    function getMap() {
        if (mapPickSource.getFeatures().length === 1) {
            var feature = mapPickSource.getFeatures()[0];
            var map = feature.getGeometry().getCoordinates();
            var easting = parseFloat(map[0]).toFixed(6);
            var northing = parseFloat(map[1]).toFixed(6);
            return { 'easting': easting, 'northing': northing, 'srid': 3857 };
        }
        return { 'easting': null, 'northing': null, 'srid': 3857 };
    }

    function getDecimal() {
        var easting;
        var northing;
        if ($('#find_location_easting').is('input')) {
            easting = $('#find_location_easting').val();
            northing = $('#find_location_northing').val();
        } else if ($('#find_location_easting').is('div')) {
            easting = $('#find_location_easting').text();
            northing = $('#find_location_northing').text();
        }
        easting = parseFloat(easting).toFixed(6);
        northing = parseFloat(northing).toFixed(6);
        return { 'easting': easting, 'northing': northing, 'srid': 4326 };
    }

    function getUtm() {
        var easting;
        var northing;
        if ($('#find_location_utmEasting').is('input')) {
            easting = $('#find_location_utmEasting').val();
            northing = $('#find_location_utmNorthing').val();
        } else if ($('#find_location_utmEasting').is('div')) {
            easting = $('#find_location_utmEasting').text();
            northing = $('#find_location_utmNorthing').text();
        }
        return { 'easting': parseInt(easting), 'northing': parseInt(northing), 'srid': 32632 };
    }

    function setMap(decimal) {
        var map = decimalToMap(decimal);
        var geometry = new ol.geom.Point([map['easting'], map['northing']]);
        var feature = new ol.Feature({ geometry: geometry });
        mapPickSource.clear();
        mapPickSource.addFeature(feature);
        mapPickMap.getView().setCenter(geometry.getCoordinates());
        mapPickMap.getView().setZoom(12);
    }

    function setDecimal(decimal) {
        $('#find_location_easting').val(decimal['easting']);
        $('#find_location_northing').val(decimal['northing']);
    }

    function setUtm(decimal) {
        utm = decimalToUtm(decimal);
        $('#find_location_utmEasting').val(utm['easting']);
        $('#find_location_utmNorthing').val(utm['northing']);
    }

    function setMunicipality(municipality) {
        $('#find_municipality_term').val(municipality).trigger("change");
    }

    function setMuseum(museum) {
        $('#find_museum_id').val(museum).trigger("change");
    }

    function setLocation(decimal, municipality, museum) {
        setMap(decimal);
        setDecimal(decimal);
        setUtm(decimal);
        setMunicipality(municipality);
        setMuseum(museum);
    }

    function clearMap() {
        mapPickSource.clear();
    }

    function clearDecimal() {
        $('#find_location_easting').val('');
        $('#find_location_northing').val('');
    }

    function clearUtm() {
        $('#find_location_utmEasting').val('');
        $('#find_location_utmNorthing').val('');
    }

    function clearMunicipality() {
        $('#find_municipality_term').val('').trigger("change");
    }

    function clearMuseum() {
        $('#find_museum_id').val('').trigger("change");
    }

    function clearLocation() {
        clearMap();
        clearDecimal();
        clearUtm();
        clearMunicipality();
        clearMuseum();
    }

    function updateLocation(decimal) {
        var wkt = 'POINT(' + decimal['easting'] + ' ' + decimal['northing'] + ')';
        $.post(path + 'api/geo/find', wkt, function (result) {
            clearLocation();
            if (result.municipality == null || result.museum == null) {
                bootbox.alert(Translator.trans('dime.mappick.invalidpointlocation'));
                return;
            }
            var decimal = { 'easting': result.x, 'northing': result.y, 'srid': 4326 };
            setLocation(decimal, result.municipality.term, result.museum.id);
        });
    }

    draw.on('drawend', function (e) {
        bootbox.confirm(Translator.trans("dime.mappick.newpointconfirmmessage"), function(result) {
            if (result) {
                map = getMap();
                decimal = mapToDecimal(map);
                updateLocation(decimal);
            } else {
                decimal = getDecimal();
                setMap(decimal);
            }
        });
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
        decimal = getDecimal();
        updateLocation(decimal);
    });

    $('.mappick-utm-control').on('change', function () {
        utm = getUtm();
        decimal = utmToDecimal(decimal);
        updateLocation(decimal);
    });

    $(".mappick-fields").keydown(function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.activeElement.blur();
        }
    });

    mapPickMap.addInteraction(draw);

    decimal = getDecimal();
    setMap(decimal);
    setUtm(decimal);
}
