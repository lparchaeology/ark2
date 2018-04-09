findSource = new ol.source.Vector();

function getPointsFromTable() {
    var features = [];

    var format = new ol.format.WKT();

    data = $(".dime-table").bootstrapTable('getData', { useCurrentPage: 'true' });
    console.log(data.length);

    findSource.clear();

    for (row in data) {
        id = data[row]._data['unique-id'];
        feature = format.readFeature(points[id], {
            dataProjection: 'EPSG:4326',
            featureProjection: 'EPSG:3857'
        });
        feature.set('ark_id', id.toString());
        findSource.addFeature(feature);
    }
    findSource.refresh();
    view = map.getView();
    extent = findSource.getExtent();
    view.fit(extent);

}

function initialiseMapView() {
    var layers = [];
    for (var i = 0; i < mapConfig.layers.length; ++i) {
        var config = mapConfig.layers[i];
        layer = new ol.layer.Tile({
            name: config.name,
            visible: config.visible,
            preload: config.preload,
            source: mapSource(config.class, config.source)
        });
        layer.set('name', config.name);
        layers.push(layer);
    }

    var map = new ol.Map({
        layers: layers,
        controls: [],
        loadTilesWhileInteracting: true,
        target: 'map',
        view: new ol.View(mapConfig.view)
    });
    map.addControl(new ol.control.Zoom());
    map.addControl(new ol.control.ZoomSlider());

    $('a.layer-select').on('click', function () {
        var name = $(this).attr('value');
        $('a.layer-select').removeClass('selected');
        $(this).addClass('selected');
        for (var i = 0; i < layers.length; ++i) {
            var layer = layers[i];
            layer.setVisible(layer.get('name') === name);
        }
    });

    if (points.length > 0) {

        var style = new ol.style.Style({
            image: new ol.style.Circle({
                radius: 5,
                fill: new ol.style.Fill({ color: '#f00' }),
                stroke: new ol.style.Stroke({ color: '#000', width: 1 })
            })
        });

        var layer = new ol.layer.Vector({
            source: findSource,
            style: style
        });

        layer.set('name', 'finds');

        layer.set('selectable', true);
        map.addLayer(layer);

        var select = new ol.interaction.Select({
            layers: function (layer) {
                return layer.get('selectable');
            },
            style: new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 8,
                    fill: new ol.style.Fill({ color: '#00f' }),
                    stroke: new ol.style.Stroke({ color: '#000', width: 1 })
                })
            }),
        });

        map.addInteraction(select);

        var collection = select.getFeatures();

        window.mapcollection = collection;

        collection.on('add', function (evt) {

            var elements = $('.dime-table tr');

            for (var i = 0; i < elements.length; i++) {
                $(elements[i]).removeClass('selected');
                $(elements[i]).find('.tablecheckbox').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
            }

            var extent = [Infinity, Infinity, -Infinity, -Infinity];

            collection.forEach(function (e, i, a) {
                var ark_id = e.get('ark_id');
                $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").addClass('selected');
                $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").find('.tablecheckbox').removeClass('glyphicon-unchecked').addClass('glyphicon-check');

                if ($('.bootstrap-table button[name=tableView]').hasClass('active') != true) {
                    $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").parent().prepend($(".dime-table tr[data-unique-id='" + ark_id.toString() + "']"));
                }

                var featureextent = e.getGeometry().getExtent();

                if (typeof featureextent != 'undefined') {
                    extent = [
                        Math.min(featureextent[0], extent[0]),
                        Math.min(featureextent[1], extent[1]),
                        Math.max(featureextent[2], extent[2]),
                        Math.max(featureextent[3], extent[3])
                    ];

                }


            });

            map.getView().fit(extent);

        });

        collection.on('remove', function (evt) {

            var elements = $('.dime-table tr');

            for (var i = 0; i < elements.length; i++) {
                $(elements[i]).removeClass('selected');
                $(elements[i]).find('.tablecheckbox').removeClass('glyphicon-check').addClass('glyphicon-unchecked');
            }

            collection.forEach(function (e, i, a) {
                var ark_id = e.get('ark_id');
                console.log('ark_id');
                console.log(ark_id);


                $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").addClass('selected')
                $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").find('.tablecheckbox').removeClass('glyphicon-unchecked').addClass('glyphicon-check');

            })
        });

    }

    $('.style-select-option').on('click', function () {

        if ($(this).attr("value") == 'choropleth') {

            var $div = $("<div>", {
                id: "navbar-fade",
                "class": "modal-backdrop fade in map-cover"
            });

            $(".ol-viewport").append($div);
            var prerun = false;
            map.getLayers().forEach(function (e, i, a) {
                if (e.get("name") === "municipalitylayer") {
                    e.setVisible(true);
                    $('.modal-backdrop').detach();
                    view = map.getView();
                    extent = e.getSource().getExtent();
                    view.fit(extent);
                    $('.map-legend').show();
                    prerun = true;
                } else if (e.get("name") === "finds") {
                    e.setVisible(false);
                }
            });
            if (prerun == false) {

                var payload = {
                    "concept": "dime.denmark.municipality",
                    "module": itemkey,
                    "attribute": "location",
                    "itemlist": itemlist
                }

                $.get(path + 'api/geo/choropleth', payload, function (result) {
                    var format = new ol.format.WKT();
                    var municipalitysource = [];
                    var municipalities = result['municipality'];
                    for (municipality in municipalities) {
                        feature = format.readFeature(municipalities[municipality]['geometry'], {
                            dataProjection: 'EPSG:' + municipalities[municipality]['srid'],
                            featureProjection: 'EPSG:3857'
                        });
                        feature.set('count', municipalities[municipality]['count']);
                        feature.set('band', municipalities[municipality]['band']);
                        municipalitysource.push(feature);
                    }

                    var bands = {
                        "4": [225, 38, 42],
                        "3": [235, 111, 77],
                        "2": [241, 227, 50],
                        "1": [104, 176, 56],
                    };

                    var height = 200;
                    var width = 10;
                    var opacity = 0.5;

                    bandslength = Object.keys(bands).length;

                    var bandheight = height / bandslength;

                    var styles = {};

                    var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                    svg.setAttribute('width', width);
                    svg.setAttribute('height', height);
                    svg.setAttribute('style', "border: 1px solid black");
                    for (band in bands) {
                        rect = document.createElementNS("http://www.w3.org/2000/svg", "rect");
                        style = "fill:rgb(" + bands[band][0] + "," + bands[band][1] + "," + bands[band][2] + ")"
                        rect.setAttribute('style', style);
                        rect.setAttribute('height', bandheight);
                        rect.setAttribute('width', width);
                        rect.setAttribute('fill-opacity', opacity);
                        rect.setAttribute('y', bandheight * (bandslength - band));
                        svg.append(rect);
                        bands[band].push(opacity);
                        styles[band] = new ol.style.Style({
                            fill: new ol.style.Fill({
                                color: bands[band]
                            }),
                            stroke: new ol.style.Stroke({
                                color: '#000',
                                width: 1
                            })
                        })
                    }

                    svg.setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:xlink", "http://www.w3.org/1999/xlink");

                    $('.legend-image').append(svg);

                    $('.map-legend').show();

                    var municipalitylayer = new ol.layer.Vector({
                        source: new ol.source.Vector({
                            features: municipalitysource
                        }),
                        style: function (feature, resolution) {
                            return [styles[feature.get('band')]];
                        }

                    });
                    municipalitylayer.set('name', "municipalitylayer");
                    municipalitylayer.set('selectable', false);
                    map.addLayer(municipalitylayer);
                    view = map.getView();
                    extent = municipalitylayer.getSource().getExtent();
                    view.fit(extent);
                    $('.modal-backdrop').detach();
                }).fail(function () {
                    $('.modal-backdrop').detach();
                });
            }
        } else if ($(this).attr("value") == 'distribution') {
            view = map.getView();

            extent = [Infinity, Infinity, -Infinity, -Infinity];

            map.getLayers().forEach(function (e, i, a) {
                if (e.get("name") === "municipalitylayer") {
                    e.setVisible(false);
                } else {
                    if (e.get("name") === "finds") {
                        e.setVisible(true);
                        newextent = e.getSource().getExtent();
                        if (newextent[0] != Infinity) {
                            extent = [
                                Math.min(newextent[0], extent[0]),
                                Math.min(newextent[1], extent[1]),
                                Math.max(newextent[2], extent[2]),
                                Math.max(newextent[3], extent[3])
                            ];
                            view.fit(extent);
                        }
                    }
                }
            });

            $('.map-legend').hide();

        } else {
            map.getLayers().forEach(function (e, i, a) {
                if (e.get("name") === "municipalitylayer" || e.get("name") === "finds") {
                    e.setVisible(false);
                }
            });

            $('.map-legend').hide();
        }

    });

    switch (default_overlay) {
        case "distribution":
            $('.style-select-option[value="distribution"]').click();
            break;
        case "choropleth":
            $('.style-select-option[value="choropleth"]').click();
            break;
        default:

    }

    return map;
}

function mapSource(source, config) {
    if (source == 'BingMaps') {
        return new ol.source.BingMaps(config)
    }
    if (source == 'TileWMS') {
        return new ol.source.TileWMS(config)
    }
}
