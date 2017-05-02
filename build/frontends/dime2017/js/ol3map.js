$(document).ready(function() {
    if ($('#mapview').length) {
        window.map = initialiseMapView();
    }
});

function initialiseMapView() {

    var layers = [];
    for (var i = 0; i < layerConfig.length; ++i) {
        var config = layerConfig[i];
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
        view: new ol.View({
            center: [1155972, 7580813],
            zoom: 7,
            maxZoom: 16,
        })
    });

    map.on('moveend', function() {
        var center = map.getView().get('center');
        var extents = map.getView().calculateExtent(map.getSize());
        centerstring = '[' + center.toString() + ']';
        var zoom = map.getView().getZoom();
    });

    $('a.layer-select').on('click', function() {
        var name = $(this).attr('value');
        $('a.layer-select').removeClass('selected');
        $(this).addClass('selected');
        for (var i = 0; i < layers.length; ++i) {
            var layer = layers[i];
            layer.setVisible(layer.get('name') === name);
        }
    });

    if (ywkts.length != 0) {

        yourfeatures = [];

        theirfeatures = [];

        var dimestyles = {
            'yours': new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 5,
                    fill: new ol.style.Fill({
                        color: '#f00'
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#000',
                        width: 1
                    })
                })
            }),
            'theirs': new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 5,
                    fill: new ol.style.Fill({
                        color: '#00f'
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#000',
                        width: 1
                    })
                })
            })
        };

        var format = new ol.format.WKT();

        for (wkt in ywkts) {
            feature = format.readFeature(ywkts[wkt], {
                dataProjection: 'EPSG:4326',
                featureProjection: 'EPSG:3857'
            });
            feature.set('ark_id', wkt);
            yourfeatures.push(feature);
        }

        for (wkt in twkts) {
            theirfeatures.push(format.readFeature(twkts[wkt], {
                dataProjection: 'EPSG:4326',
                featureProjection: 'EPSG:3857'
            }).set('ark_id', wkt));
        }

        var yours = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: yourfeatures
            }),
            style: dimestyles['yours']
        });

        var theirs = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: theirfeatures
            }),
            style: dimestyles['theirs']
        });

        yours.set('name', 'yours');

        yours.set('selectable', true);


        theirs.set('name', 'theirs');

        theirs.set('selectable', true);


        map.addLayer(theirs);
        map.addLayer(yours);

        view = map.getView();
        extent = yours.getSource().getExtent();
        view.fit(extent, map.getSize());

        var select = new ol.interaction.Select({
            layers: function(layer) {
                return layer.get('selectable');
            },
            style: new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 8,
                    fill: new ol.style.Fill({
                        color: '#f00'
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#000',
                        width: 1
                    })
                })
            }),
        });

        map.addInteraction(select);

        var collection = select.getFeatures();

        window.mapcollection = collection;

        collection.on('add', function(evt) {
            var elements = $('.dime-table tr');

            for (var i = 0; i < elements.length; i++) {
                $(elements[i]).removeClass('selected');
            }

            collection.forEach(function(e, i, a) {
                var ark_id = e.get('ark_id');

                $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").addClass('selected');
            })
        });

        collection.on('remove', function(evt) {
            var elements = $('.dime-table tr');
            for (var i = 0; i < elements.length; i++) {
                $(elements[i]).removeClass('selected');
            }
            collection.forEach(function(e, i, a) {
                var ark_id = e.get('ark_id');

                $(".dime-table tr[data-unique-id='" + ark_id.toString() + "']").addClass('selected');
            })
        });

    }

    $('.style-select-option').on('click', function() {

        if ($(this).attr("value") == 'choropleth') {

            var $div = $("<div>", {
                id: "navbar-fade",
                "class": "modal-backdrop fade in map-cover"
            });

            $(".ol-viewport").append($div);
            var prerun = false;
            map.getLayers().forEach(function(e, i, a) {
                if (e.get("name") === "kommunelayer") {
                    e.setVisible(true);
                    $('.modal-backdrop').detach();
                    view = map.getView();
                    extent = e.getSource().getExtent();
                    view.fit(extent, map.getSize());
                    $('.map-legend').show();
                    prerun = true;
                } else if (e.get("name") === "yours" || e.get("name") === "theirs") {
                    e.setVisible(false);
                }
            });
            if (prerun == false) {
                $.get(path + 'api/geo/choropleth', false, function(result) {
                    var format = new ol.format.WKT();
                    var kommunesource = [];
                    var kommunes = result['kommune'];
                    for (kommune in kommunes) {
                        feature = format.readFeature(kommunes[kommune]['geometry'], {
                            dataProjection: 'EPSG:'+kommunes[kommune]['srid'],
                            featureProjection: 'EPSG:3857'
                        });
                        feature.set('count', kommunes[kommune]['count']);
                        feature.set('band', kommunes[kommune]['band']);
                        kommunesource.push(feature);
                    }

                    var bands = {
                            "4" : [225,38,42],
                            "3" : [235,111,77],
                            "2" : [241,227,50],
                            "1" : [104,176,56],
                    };

                    var height = 200;
                    var width = 10;
                    var opacity = 0.5;

                    bandslength = Object.keys(bands).length;

                    var bandheight = height/bandslength;

                    var styles = {};

                    var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                    svg.setAttribute('width', width);
                    svg.setAttribute('height', height);
                    svg.setAttribute('style', "border: 1px solid black");
                    for (band in bands) {
                        rect = document.createElementNS("http://www.w3.org/2000/svg", "rect");
                        style = "fill:rgb("+bands[band][0]+","+bands[band][1]+","+bands[band][2]+")"
                        rect.setAttribute('style', style);
                        rect.setAttribute('height', bandheight);
                        rect.setAttribute('width', width);
                        rect.setAttribute('fill-opacity', opacity);
                        rect.setAttribute('y',bandheight*(bandslength-band));
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

                    var kommunelayer = new ol.layer.Vector({
                        source: new ol.source.Vector({
                            features: kommunesource
                        }),
                        style: function(feature, resolution) {
                            return [styles[feature.get('band')]];
                        }

                    });
                    kommunelayer.set('name', "kommunelayer");
                    kommunelayer.set('selectable', false);
                    map.addLayer(kommunelayer);
                    view = map.getView();
                    extent = kommunelayer.getSource().getExtent();
                    view.fit(extent, map.getSize());
                    $('.modal-backdrop').detach();
                }).fail(function() {
                    $('.modal-backdrop').detach();
                });
            }

        } else {
            view = map.getView();

            //[minx,miny,maxx,maxy]

            extent = [Infinity, Infinity, -Infinity, -Infinity];

            map.getLayers().forEach(function(e, i, a) {
                if (e.get("name") === "kommunelayer") {
                    e.setVisible(false);
                } else {
                    if (e.get("name") === "yours" || e.get("name") === "theirs") {
                        e.setVisible(true);
                        newextent = e.getSource().getExtent();
                        if(newextent[0] != Infinity){
                            extent = [
                                      Math.min(newextent[0],extent[0]),
                                      Math.min(newextent[1],extent[1]),
                                      Math.max(newextent[2],extent[2]),
                                      Math.max(newextent[3],extent[3])
                                      ];
                            view.fit(extent, map.getSize());
                        }
                    }
                }
            });

            $('.map-legend').hide();

        }

    });

    switch(default_overlay) {
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
