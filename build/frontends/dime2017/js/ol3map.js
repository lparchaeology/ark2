  var styles = [
    'Road',
'Aerial',
'AerialWithLabels',
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

if(ywkts.length!=0){

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
   style:dimestyles['yours']
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
    var elements = $('#dime_find_list tr');
    for (var i = 0; i < elements.length; i++) {
        $(elements[i]).removeClass('selected');
    }
    collection.forEach(function(e,i,a) {
        var ark_id = e.get('ark_id');
        var item = $("#dime_find_list tr[data-unique-id='"+ark_id.toString()+"']");
        if(item){
            $(item).addClass('selected');
        }
    })
});

collection.on('remove', function(evt) {
	var elements = $('#dime_find_list tr');
    for (var i = 0; i < elements.length; i++) {
        $(elements[i]).removeClass('selected');
    }
    collection.forEach(function(e,i,a) {
        var ark_id = e.get('ark_id');
        var item = $("#dime_find_list tr[data-unique-id='"+ark_id.toString()+"']");
        if(item){
            $(item).addClass('selected');
        }
    })
});

$(document).ready(function(){
    $('#dime_find_list tr').click(function(evt) {
        self = $(this);
        console.log(self);
        ark_id = self.attr('data-unique-id');
        console.log(ark_id);
        map.getLayers().forEach(function(i,e,a){
            if (i.get('name')=='yours'){
                console.log(evt.shiftKey);
                if(!evt.shiftKey){
                    collection.clear();
                }
                if (typeof i.getSource().getFeatures == 'function') {
                    i.getSource().getFeatures().forEach(function(i,e,a){
                        if(i.get('ark_id').toUpperCase()==ark_id){
                            if(self.hasClass('selected')){
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
});


}
