function initialisePickMap() {

    // TODO Get from ark_map tables.
    var baseSource = new ol.source.BingMaps({
        key: 'Ak5AqjsEQ44KtAl7jHhrjGuzNshN1fZv3MOx2MUi0p4zFmq6XeWLKmyqeP2UgJK3',
        imagerySet: 'AerialWithLabels',
        maxZoom: 19,
    });
    var center = [1155972, 7580813];
    var extent = [831000, 7230000, 1750000, 7950000];
    var zoom = 6;
    var target = 'mappick';

    function makeDecimal(value) {
        return parseFloat(parseFloat(value).toFixed(6));
    }

    function makeUtm(value) {
        return parseInt(value);
    }

    function makeDecimalPoint(easting, northing) {
        return { 'easting': makeDecimal(easting), 'northing': makeDecimal(northing), 'srid': 4326 };
    }

    function makeUtmPoint(easting, northing, srid) {
        return { 'easting': makeUtm(easting), 'northing': makeUtm(northing), 'srid': 32632 };
    }

    function utmToDecimal(utm) {
        var result = ol.proj.transform([utm.easting, utm.northing], 'EPSG:32632', 'EPSG:4326');
        return makeDecimalPoint(result[0], result[1]);
    }

    function decimalToUtm(decimal) {
        var result = ol.proj.transform([decimal.easting, decimal.northing], 'EPSG:4326', 'EPSG:32632');
        return makeUtmPoint(result[0], result[1]);
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
        return makeDecimalPoint(easting, northing);
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
        return makeUtmPoint(easting, northing);
    }

    function setDecimal(decimal) {
        if (isNaN(decimal.easting) || isNaN(decimal.northing)) {
            return;
        }
        $('#find_location_easting').val(decimal.easting);
        $('#find_location_northing').val(decimal.northing);
    }

    function setUtm(decimal) {
        if (isNaN(decimal.easting) || isNaN(decimal.northing)) {
            return;
        }
        var utm = decimalToUtm(decimal);
        if (isNaN(utm.easting) || isNaN(utm.northing)) {
            return;
        }
        $('#find_location_utmEasting').val(utm.easting);
        $('#find_location_utmNorthing').val(utm.northing);
    }

    function setMunicipality(municipality) {
        $('#find_municipality_term').val(municipality).trigger("change");
    }

    function setMuseum(museum) {
        $('#find_museum_id').val(museum).trigger("change");
    }

    function setLocation(decimal, municipality, museum) {
        locationPicker.setLocation(decimal);
        setDecimal(decimal);
        setUtm(decimal);
        setMunicipality(municipality);
        setMuseum(museum);
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
        locationPicker.clear();
        clearDecimal();
        clearUtm();
        clearMunicipality();
        clearMuseum();
    }

    function updateLocation(decimal) {
        var wkt = 'POINT(' + decimal.easting + ' ' + decimal.northing + ')';
        $.post(path + 'api/geo/find', wkt, function (result) {
            if (result.municipality === null || result.museum === null || isNaN(result.x) || isNaN(result.y)) {
                bootbox.alert(Translator.trans('dime.mappick.invalidpointlocation'));
                locationPicker.setLocation(getDecimal());
            } else {
                var decimal = makeDecimalPoint(result.x, result.y);
                clearLocation();
                setLocation(decimal, result.municipality.term, result.museum.id);
            }
        });
    }

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
        updateLocation(getDecimal());
    });

    $('.mappick-utm-control').on('change', function () {
        var decimal = utmToDecimal(getUtm());
        updateLocation(decimal);
    });

    $(".mappick-fields").keydown(function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.activeElement.blur();
        }
    });

    var locationPicker = new Location();

    // MOVE INTO WIDGET?!?
    var ondraw = function ondraw() {
        bootbox.confirm(Translator.trans("dime.mappick.newpointconfirmmessage"), function (result) {
            if (result) {
                updateLocation(locationPicker.location(4326));
            } else {
                locationPicker.setLocation(getDecimal());
            }
        });
    };

    locationPicker.init(baseSource, mapPin, 3857, center, extent, zoom, target, ondraw);

    var decimal = getDecimal();
    console.log(decimal);
    locationPicker.setLocation(decimal);
    setUtm(decimal);
}
