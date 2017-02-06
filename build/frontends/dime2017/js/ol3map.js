if(ywkts.length!=0){

var styles = [
    'Road',
    'Aerial',
    'AerialWithLabels',
    'districtLayer'
  ];

var layers = [];
var i, ii;
for (i = 0, ii = styles.length; i < ii; ++i) {
    layers.push(
        new ol.layer.Tile({
            visible: false,
            preload: Infinity,
            source: new ol.source.BingMaps({
                key: 'Ak5AqjsEQ44KtAl7jHhrjGuzNshN1fZv3MOx2MUi0p4zFmq6XeWLKmyqeP2UgJK3',
                imagerySet: styles[i]
            })
        })
    );
}
//http://kortforsyningen.kms.dk/service?request=GetCapabilities&version=1.1.1&ticket=5e1b579892dc719ede8e82528bde1ff8&servicename=orto_foraar&service=WMS
var orto_foraar = new ol.layer.Tile({
    source: new ol.source.TileWMS({
        url: 'http://kortforsyningen.kms.dk/service?servicename=orto_foraar&service=WMS&ticket=5e1b579892dc719ede8e82528bde1ff8&',
        params: {
            'LAYERS': 'orto_foraar',
            'VERSION': '1.1.1',
            'FORMAT': 'image/png',
            'TILED': true
        },
    })
});

layers.push(orto_foraar);

//http://kortforsyningen.kms.dk/service?request=GetCapabilities&version=1.1.1&ticket=2afbc1eca7a5cb1d8c315a229b1f1307&servicename=topo_skaermkort&service=WMS

var topo_skaermkort = new ol.layer.Tile({
    source: new ol.source.TileWMS({
        url: 'http://kortforsyningen.kms.dk/service?ticket=2afbc1eca7a5cb1d8c315a229b1f1307&servicename=topo_skaermkort&',
        params: {
            'LAYERS': 'topo_skaermkort',
            'VERSION': '1.1.1',
            'FORMAT': 'image/png',
            'TILED': true
        },
    })
});

layers.push(topo_skaermkort);

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

layers[2].setVisible(true);

map.on('moveend',function(){
    console.log('wha');
        var center = map.getView().get('center');
        var extents = map.getView().calculateExtent(map.getSize());
        centerstring = '['+center.toString()+']';
        var zoom = map.getView().getZoom();
        console.log(zoom);
});

$('a.layer-select').on('click',function(){
    var style = $(this).attr('value');
     for (var i = 0, ii = layers.length; i < ii; ++i) {
         layers[i].setVisible(styles[i] === style);
     }
});

    yourfeatures = [];

    theirfeatures = [];

    var dimestyles = {
        'yours': new ol.style.Style({
            image: new ol.style.Circle({
                radius: 5,
                fill: new ol.style.Fill({color: '#f00'}),
                stroke: new ol.style.Stroke({color: '#000', width: 1})
            })
        }),
        'theirs': new ol.style.Style({
            image: new ol.style.Circle({
                radius: 5,
                fill: new ol.style.Fill({color: '#00f'}),
                stroke: new ol.style.Stroke({color: '#000', width: 1})
            })
        })
    };

    var format = new ol.format.WKT();

    for(wkt in ywkts){
        feature = format.readFeature(ywkts[wkt], {
            dataProjection: 'EPSG:4326',
            featureProjection: 'EPSG:3857'
        });
        feature.set('ark_id',wkt);
        yourfeatures.push(feature);
    }

    for(wkt in twkts){
        theirfeatures.push(format.readFeature(twkts[wkt], {
            dataProjection: 'EPSG:4326',
            featureProjection: 'EPSG:3857'
        }).set('ark_id',wkt));
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
        style:dimestyles['theirs']
    });

    yours.set('name','yours');

    map.addLayer(theirs);
    map.addLayer(yours);

    view = map.getView();
    extent = yours.getSource().getExtent();
    view.fit(extent, map.getSize());

    var select = new ol.interaction.Select({
        style: new ol.style.Style({
            image: new ol.style.Circle({
                radius: 8,
                fill: new ol.style.Fill({color: '#f00'}),
                stroke: new ol.style.Stroke({color: '#000', width: 1})
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

        collection.forEach(function(e,i,a) {
            var ark_id = e.get('ark_id');

            $(".dime-table tr[data-unique-id='"+ark_id.toString()+"']").addClass('selected');
        })
    });

    collection.on('remove', function(evt) {
        var elements = $('.dime-table tr');
        for (var i = 0; i < elements.length; i++) {
            $(elements[i]).removeClass('selected');
        }
        collection.forEach(function(e,i,a) {
            var ark_id = e.get('ark_id');

            $(".dime-table tr[data-unique-id='"+ark_id.toString()+"']").addClass('selected');
        })
    });

    $('table.dime-table').on('click-row.bs.table', function (evt, row, element, field) {
        ark_id = element.attr('data-unique-id');
        map.getLayers().forEach(function(i,e,a){
            if (i.get('name')=='yours'){
                console.log(evt.shiftKey);
                if(!evt.shiftKey){
                    collection.clear();
                }
                if (typeof i.getSource().getFeatures == 'function') {
                    i.getSource().getFeatures().forEach(function(i,e,a){
                        if(i.get('ark_id').toUpperCase()==ark_id){
                            if(element.hasClass('selected')){
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

    $('.layer-select').on('click', function(){
        map.getLayers().forEach(function(e,i,a) {
            if(e.get("name") === "kommunelayer"){
                e.setVisible(false);
             }
        });
    });


    $('.heatmap-select').on('click', function(){

        var $div = $("<div>", {id: "navbar-fade", "class": "modal-backdrop fade in"});
        $("#map").append($div);

        map.getLayers().forEach(function(e,i,a) {
            if(e.get("name") === "kommunelayer"){
                e.setVisible(true);
                $('.modal-backdrop').detach();
             }
        });

        $.get('/dime/api/geo/heatmap', wkt, function(result){
            var kommunesource = [];
            var kommunes = result['kommune'];
            for(kommune in kommunes){
                feature = format.readFeature(kommunes[kommune]['geometry'], {
                    dataProjection: 'EPSG:4326',
                    featureProjection: 'EPSG:3857'
                });
                feature.set('count',kommunes[kommune]['count']);
                feature.set('band',kommunes[kommune]['band']);
                kommunesource.push(feature);
            }
            var kommunelayer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: kommunesource
                }),
                style: function(feature, resolution){
                    var styles = {
                          "4":new ol.style.Style({
                                fill: new ol.style.Fill({color: '#68b038'}),
                                stroke: new ol.style.Stroke({color: '#000', width: 1})
                            }),
                          "3": new ol.style.Style({
                                fill: new ol.style.Fill({color: '#eb6f4d'}),
                                stroke: new ol.style.Stroke({color: '#000', width: 1})
                            }),
                          "2": new ol.style.Style({
                                fill: new ol.style.Fill({color: '#f1e332'}),
                                stroke: new ol.style.Stroke({color: '#000', width: 1})
                            }),
                          "1": new ol.style.Style({
                                fill: new ol.style.Fill({color: '#e1262a'}),
                                stroke: new ol.style.Stroke({color: '#000', width: 1})
                            })
                    };

                    return [styles[feature.get('band')]];
                }

            });
            kommunelayer.set('name',"kommunelayer");
            map.addLayer(kommunelayer);
            view = map.getView();
            extent = kommunelayer.getSource().getExtent();
            view.fit(extent, map.getSize());
            $('.modal-backdrop').detach();
        });
    });

}
