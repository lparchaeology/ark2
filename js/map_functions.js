/**
 * 
 */


function addLayer(layer){
	if (layer.type=='WMS'){
		addTile(layer);
	} else{
		alert('Admin Error');
	}
};

//adds a ARK layer to the map
function addTile(layer){
	alert(layer);
	var wmsSource = new ol.source.Vector({
	    url: layer.url,
	    params: {'LAYERS': layer.name},
		projection: ol.proj.get(layer.projection), 
		serverType: layer.serverType,
    });
    newlayer = new ol.layer.Tile({
       	source: wmsSource
    });
    map.addLayer(newlayer);
		
	
};

/**
 * FUNCTIONS
 */

function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

//gets the JSON array from the ARK API for each feature

// function getARKItems(itemkey){
//     url = "api.php?req=getItems&item_key=" + itemkey;
//     jQuery.ajax({
//     url: url,
//     success: function(result){
//         getARKFields(result,req_fields);
//     }
//     });
// }

//gets the JSON array for the specified fields for each feature

function getARKFields(req_fields){
    url = "api.php?req=getFields&";
    jQuery(req_fields).each(function(){
        url = url + "&fields[]=" + this;
    }
        );
        jQuery.ajax({
            url: url + "&itemkey=loc_cd&loc_cd=all&aliased=true",
            complete: function(result){
                ark_json = jQuery.parseJSON(result.responseText);
                themeatiseThis(ark_json,req_fields[1]);
            }
        });
}


//runs the Themeatiser

function themeatiseThis(ark_json,req_field){
    features = vector.getSource().getFeatures();
    for (var i=0; i < features.length; i++) {

        var feature_id = features[i].getId();
        var ark_id = features[i].get('ark_id').toUpperCase();

        if (ark_json.hasOwnProperty(ark_id) && ark_json[ark_id].hasOwnProperty(req_field)) {
            console.log(ark_json);
            field_value = ark_json[ark_id][req_field][0]['aliases']['en']['attribute'];
            if (rules.hasOwnProperty(field_value)) {
                style = rules[field_value];
            } else {
                var style = new ol.style.Style({
                    image: new ol.style.Circle({
                        radius: 3,
                        fill: new ol.style.Fill({color: getRandomColor()})
                    })
                });
                rules[field_value] = style;
            }
        } else {
            //set up a default style
            var style = new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 3,
                    fill: new ol.style.Fill({color: "red"})
                })
            });
        }
        features[i].setStyle(style);
    };
}

/**
 * CONFIGURATION (SHOULD BE BOUGHT IN FROM SOMEWHERE ELSE -SETTINGS?)
 */

req_fields = ['conf_field_visit_year','conf_field_geomorph'];

rules = [];

ark_json = "";


    /**
     * Elements that make up the popup.
    
    var container = document.getElementById('popup');
    var content = document.getElementById('popup-content');
    var closer = document.getElementById('popup-closer');


    /**
     * Add a click handler to hide the popup.
     * @return {boolean} Don't follow the href.
    
    closer.onclick = function() {
        container.style.display = 'none';
        closer.blur();
        return false;
    };


    /**
     * Create an overlay to anchor the popup to the map.
     
    var overlay = new ol.Overlay({
        element: container
    });


        /**
         * Load up the ARK features
         *
        

        //getARKFields(req_fields);

        var loadFeatures = function(response) {
            //this is where we style on a per feature basis
            features = vectorSource.readFeatures(response);
            vectorSource.addFeatures(features);
        };

        var vectorSource = new ol.source.ServerVector({
            format: new ol.format.GeoJSON(),
            loader: function(extent, resolution, projection) {
                var url = 'http://ica.tacc.utexas.edu:8080/geoserver/MetSur/wfs?service=WFS&' +
                'version=1.1.0&request=GetFeature&typename=MetSur:all_locs_xy_joined&' +
                'outputFormat=text/javascript&format_options=callback:loadFeatures' +
                '&srsname=EPSG:3857';
                jQuery.ajax({
                    url: url,
                    dataType: 'jsonp',
                });
            },
            strategy: ol.loadingstrategy.createTile(new ol.tilegrid.XYZ({
                maxZoom: 19
            })),
        });

            var style = new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 3,
                    fill: new ol.style.Fill({color: getRandomColor()})
                })
            });

                var initialWMSDates = 'MetSur:SurveySites50,MetSur:SurveySites100,MetSur:SurveySites150,MetSur:SurveySites200,MetSur:SurveySites250,MetSur:SurveySites300,MetSur:SurveySites350,MetSur:SurveySites400,MetSur:SurveySites450,MetSur:SurveySites500,MetSur:SurveySites550,MetSur:SurveySites600';
                var wmsSource = new ol.source.TileWMS({
                    url: 'http://ica.tacc.utexas.edu:8080/geoserver/MetSur/wms?',
                    params: {'LAYERS': initialWMSDates},
                    serverType: 'geoserver'
                });


                    var wmsLayer = new ol.layer.Tile({
                        source: wmsSource
                    });

                        var vector = new ol.layer.Vector({
                            source:vectorSource
                        });

                            var OSMLayer = new ol.layer.Tile({
                                source: new ol.source.OSM()
                            });

                                var view = new ol.View({
                                    center: [1862765,4925900],
                                    zoom: 12
                                });

                                    var map = new ol.Map({
                                        layers: [OSMLayer,vector],
                                        target: 'map',
                                        view: view
                                    });

                                        map.on('singleclick', function(evt) {
                                            getARKFields(req_fields);
                                            //console.log(wmsSource.getParams());
                                        });


                                        **/
