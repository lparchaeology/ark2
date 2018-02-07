// Location Picker object using Revealing Module pattern

var Location = (function () {

    var mapSrid = null;
    var mapEpsg = null;
    var baseLayer = null;
    var locationSource = null;
    var locationLayer = null;
    var locationStyle = null;
    var mapLayers = [];
    var mapView = null;
    var map = null;

    var clear = function clear() {
        this.locationSource.clear();
    };

    var coordinates = function coordinates() {
        if (this.locationSource.getFeatures().length === 1) {
            return this.locationSource.getFeatures()[0].getGeometry().getCoordinates();
        }
        return [null, null];
    };

    var setCoordinates = function setCoordinates(coords) {
        if (isNaN(coords[0]) || isNaN(coords[0])) {
            return;
        }
        var feature = new ol.Feature({ geometry: new ol.geom.Point(coords), });
        this.locationSource.clear();
        this.locationSource.addFeature(feature);
        this.map.getView().setCenter(coords);
        this.map.getView().setZoom(12);
    };

    var makeDecimal = function makeDecimal(value) {
        return parseFloat(parseFloat(value).toFixed(6));
    };

    var location = function location(srid) {
        var coords = coordinates();
        if (srid === null) {
            srid = this.mapSrid;
        } else if (srid !== this.mapSrid) {
            coords = ol.proj.transform(coords, this.mapEpsg, 'EPSG:' + srid);
        }
        return {
            'easting': makeDecimal(coords[0]),
            'northing': makeDecimal(coords[1]),
            'srid': srid,
        };
    };

    var setLocation = function setLocation(location) {
        if (isNaN(location.easting) || isNaN(location.northing)) {
            return;
        }
        var coords = [location.easting, location.northing];
        if (location.srid !== this.mapSrid) {
            var epsg = 'EPSG:' + location.srid;
            coords = ol.proj.transform(coords, epsg, this.mapEpsg);
        }
        setCoordinates(coords);
    };

    var geolocate = function geolocate() {
        var geolocation = new ol.Geolocation({
            projection: this.mapView.getProjection(),
        });
        setCoordinates(geolocation.getPosition());
        return geolocation.getAccuracy();
    };

    var init = function (baseSource, pinIconSrc, srid, center, extent, zoom, target, ondraw) {

        this.mapSrid = srid;
        this.mapEpsg = 'EPSG:' + srid;

        this.baseLayer = new ol.layer.Tile({
            visible: true,
            preload: Infinity,
            source: baseSource,
        });

        this.locationSource = new ol.source.Vector({ wrapX: false, });
        this.locationStyle = new ol.style.Style({
            image: new ol.style.Icon( /** @type {olx.style.IconOptions} */ {
                anchor: [0.5, 44],
                anchorXUnits: 'fraction',
                anchorYUnits: 'pixels',
                src: pinIconSrc,
            }),
        });
        this.locationLayer = new ol.layer.Vector({
            source: this.locationSource,
            style: this.locationStyle,
        });
        this.locationDraw = new ol.interaction.Draw({
            source: this.locationSource,
            type: "Point",
            style: new ol.style.Style({
                image: new ol.style.RegularShape({
                    fill: new ol.style.Fill({ color: 'white', }),
                    points: 4,
                    radius1: 6,
                    radius2: 1,
                }),
            }),
        });
        this.locationDraw.on('drawend', ondraw);

        this.mapView = new ol.View({
            center: center,
            zoom: zoom,
            extent: extent,
            minZoom: zoom,
        });
        this.map = new ol.Map({
            layers: [this.baseLayer, this.locationLayer, ],
            loadTilesWhileInteracting: true,
            target: target,
            view: this.mapView,
            controls: [new ol.control.FullScreen(), new ol.control.Zoom(), ],
        });
        this.map.addInteraction(this.locationDraw);
    };

    return {
        init: init,
        location: location,
        setLocation: setLocation,
        clear: clear,
        geolocate: geolocate,
    };

});
