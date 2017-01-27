var wkt1 = 'POINT(8.67 56.11)';
var wkt2 = 'POINT(8.71 56.12)';

var wkt3 = 'POINT(8.66 56.14)';
var wkt4 = 'POINT(8.65 56.10)';

var format = new ol.format.WKT();
ywkts = [wkt1,wkt2];
twkts = [wkt3,wkt4];
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

for(wkt in ywkts){
    yourfeatures.push(format.readFeature(ywkts[wkt], {
        dataProjection: 'EPSG:4326',
        featureProjection: 'EPSG:3857'
    }));
}

for(wkt in twkts){
    theirfeatures.push(format.readFeature(twkts[wkt], {
        dataProjection: 'EPSG:4326',
        featureProjection: 'EPSG:3857'
    }));
}

var yours = new ol.layer.Vector({
  source: new ol.source.Vector({
        features: yourfeatures
      }),
  style:dimestyles['yours']
});

var theirs = new ol.layer.Vector({
  source: new ol.source.Vector({
        features: theirfeatures
      }),
  style:dimestyles['theirs']
});

 var styles = [
   'Road',
   'Aerial',
   'AerialWithLabels',
   'collinsBart',
   'ordnanceSurvey'
 ];
 var layers = [];
 var i, ii;
 for (i = 0, ii = styles.length; i < ii; ++i) {
   layers.push(new ol.layer.Tile({
     visible: false,
     preload: Infinity,
     source: new ol.source.BingMaps({
       key: 'Ak5AqjsEQ44KtAl7jHhrjGuzNshN1fZv3MOx2MUi0p4zFmq6XeWLKmyqeP2UgJK3',
       imagerySet: styles[i]
       // use maxZoom 19 to see stretched tiles instead of the BingMaps
       // "no photos at this zoom level" tiles
       // maxZoom: 19
     })
   }));
 }
 var map = new ol.Map({
   layers: layers,
   controls: [],
   // Improve user experience by loading tiles while dragging/zooming. Will make
   // zooming choppy on mobile or slow devices.
   loadTilesWhileInteracting: true,
   target: 'map',
   view: new ol.View({
           center: [965972, 7580813],
           zoom: 12
   })
 });

 map.addLayer(theirs);
 map.addLayer(yours);

 var select = new ol.interaction.Select({
     style: new ol.style.Style({
          image: new ol.style.Circle({
            radius: 10,
            fill: new ol.style.Fill({color: '#ff0'}),
            stroke: new ol.style.Stroke({color: '#000', width: 1})
          })
        }),
 });
 map.addInteraction(select);
 layers[2].setVisible(true);
 $('a.layer-select').on('click',function(){
	 var style = $(this).attr('value');
	 for (var i = 0, ii = layers.length; i < ii; ++i) {
	     layers[i].setVisible(styles[i] === style);
	   }
 });

