$(document).ready(function() {

    function source(source, config) {
        if (source == 'BingMaps') {
            return new ol.source.BingMaps(config)
        }
        if (source == 'TileWMS') {
            return new ol.source.TileWMS(config)
        }
    }

    var layers = [];
    for (var i = 0; i < layerConfig.length; ++i) {
        var config = layerConfig[i];
        layer = new ol.layer.Tile({
            name: config.name,
            visible: config.visible,
            preload: config.preload,
            source: source(config.type, config.source)
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
        console.log('wha');
        var center = map.getView().get('center');
        var extents = map.getView().calculateExtent(map.getSize());
        centerstring = '[' + center.toString() + ']';
        var zoom = map.getView().getZoom();
        console.log(zoom);
    });

    $('a.layer-select').on('click', function() {
        var name = $(this).attr('value');
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

        map.addLayer(theirs);
        map.addLayer(yours);

        view = map.getView();
        extent = yours.getSource().getExtent();
        view.fit(extent, map.getSize());

        var select = new ol.interaction.Select({
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

        $('table.dime-table').on('click-row.bs.table', function(evt, row, element, field) {
            ark_id = element.attr('data-unique-id');
            map.getLayers().forEach(function(i, e, a) {
                if (i.get('name') == 'yours') {
                    console.log(evt.shiftKey);
                    if (!evt.shiftKey) {
                        collection.clear();
                    }
                    if (typeof i.getSource().getFeatures == 'function') {
                        i.getSource().getFeatures().forEach(function(i, e, a) {
                            if (i.get('ark_id').toUpperCase() == ark_id) {
                                if (element.hasClass('selected')) {
                                    collection.remove(i);
                                } else {
                                    collection.push(i);
                                }
                            }
                        });
                    }
                }
            });
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
                    prerun = true;
                }
            });
            if (prerun == false) {
                $.get(path + 'api/geo/choropleth', false, function(result) {
                    var kommunesource = [];
                    var kommunes = result['kommune'];
                    for (kommune in kommunes) {
                        feature = format.readFeature(kommunes[kommune]['geometry'], {
                            dataProjection: 'EPSG:4326',
                            featureProjection: 'EPSG:3857'
                        });
                        feature.set('count', kommunes[kommune]['count']);
                        feature.set('band', kommunes[kommune]['band']);
                        kommunesource.push(feature);
                    }
                    var kommunelayer = new ol.layer.Vector({
                        source: new ol.source.Vector({
                            features: kommunesource
                        }),
                        style: function(feature, resolution) {
                            var styles = {
                                "4": new ol.style.Style({
                                    fill: new ol.style.Fill({
                                        color: '#68b038'
                                    }),
                                    stroke: new ol.style.Stroke({
                                        color: '#000',
                                        width: 1
                                    })
                                }),
                                "3": new ol.style.Style({
                                    fill: new ol.style.Fill({
                                        color: '#eb6f4d'
                                    }),
                                    stroke: new ol.style.Stroke({
                                        color: '#000',
                                        width: 1
                                    })
                                }),
                                "2": new ol.style.Style({
                                    fill: new ol.style.Fill({
                                        color: '#f1e332'
                                    }),
                                    stroke: new ol.style.Stroke({
                                        color: '#000',
                                        width: 1
                                    })
                                }),
                                "1": new ol.style.Style({
                                    fill: new ol.style.Fill({
                                        color: '#e1262a'
                                    }),
                                    stroke: new ol.style.Stroke({
                                        color: '#000',
                                        width: 1
                                    })
                                })
                            };

                            return [styles[feature.get('band')]];
                        }

                    });
                    kommunelayer.set('name', "kommunelayer");
                    map.addLayer(kommunelayer);
                    view = map.getView();
                    extent = kommunelayer.getSource().getExtent();
                    view.fit(extent, map.getSize());
                    $('.modal-backdrop').detach();
                });
            }

        } else {
            map.getLayers().forEach(function(e, i, a) {
                if (e.get("name") === "kommunelayer") {
                    e.setVisible(false);
                }
            });

            view = map.getView();
            extent = yours.getSource().getExtent();
            view.fit(extent, map.getSize());

        }


    });

});
