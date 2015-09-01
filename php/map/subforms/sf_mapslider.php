<?php

$mk_noFeatures = getMarkup('cor_tbl_markup',$lang,'nofeatures');
?>

<link rel="stylesheet" href="lib/js/jquery-ui-slider-pips.css" />
<script type="text/javascript" src="lib/js/jquery.ui.slider.custom.js"></script>
<script type="text/javascript" src="lib/js/jquery-ui-slider-pips.js"></script>

<div id="slider_holder">
	<div id="slider"></div>
	<div></div>
</div>

<script type="text/javascript">
( function($) {
$(document).ready(function() {
    
    var bins = ["600", "550", "500", "450", "400", "350", "300", "250","200","150","100","50"];
    $.each(bins, function( index, value ) {
        var wmsLayers = {};
        wmsLayers[value] = new ol.layer.Tile({
            source: new ol.source.TileWMS({
                url: 'http://<?php echo $_SERVER['SERVER_NAME'] ?>/geoserver/MetSur/wms?',
                params: {'LAYERS': 'MetSur:SurveySites'+value},
                serverType: 'geoserver'
            }),
        });
        wmsLayers[value].set('name', 'MetSur:SurveySites'+value);
        jQuery( "#slider" ).data(wmsLayers);
        map1.addLayer(wmsLayers[value]);
    });
    
    jQuery( "#slider" ).dragslider({
        range: true,
        rangeDrag: true,
        min: 0,
        max: 550,
        values: [ 0, 550 ],
        step: 50,
        slide: function( event, ui ) {
            $.each(bins, function (index,value){
                layers = jQuery( "#slider" ).data();
                earlydate = 600-ui.values[0];
                latedate = 600-ui.values[1];
                console.log(earlydate+'>'+latedate);
                if (value <= earlydate && value >= latedate ) {
                    console.log(layers[value]);
                    layers[value].setVisible(true);
                } else {
                    layers[value].setVisible(false);
                }
            });
        }
    });
    
    jQuery( "#slider" ).dragslider("pips", { rest: "label",
        labels: bins,
    	suffix: "BC"});

var pushToGlobal = function(e,i,a){
	console.log(window.features.getLength());
	window.features.push(e);
	console.log(window.features.getLength());
}

var handlefeatures = function( data ) {
	var features = data.features;
	features.forEach(pushToGlobal);
}

var processFeatures = function(){
var	features = window.features;
if (features.getLength()){
    features.forEach(function (e,i,a){
        if (typeof(e.properties.ark_id) !== 'undefined') {
            console.log(e.geometry.coordinates);
            var featcoords = proj4(proj4('EPSG:32633'),proj4('EPSG:900913'),e.geometry.coordinates);
        	var featpix = map1.getPixelFromCoordinate(featcoords);
        	displayFeatureInfo(featpix, e.properties.ark_id);
            overlay.setPosition(featcoords);
            //selected = features[feature];
            var ark_id = e.properties.ark_id.toUpperCase()
            overlay.getElement().innerHTML = '<a href="<?php echo $ark_dir?>/micro_view.php?item_key=loc_cd&loc_cd='+ark_id+'"><h4>Location '+ark_id.split('_')[1]+'</h4></a>';
            overlay.getElement().innerHTML += '<img class="loading" src=<?php echo $skin_path."/images/lightbox/loading.gif"?>></img>';
            var iframe = document.createElement('iframe');
            iframe.setAttribute("id","popupiframe");
            iframe.setAttribute("scrolling","yes");
            iframe.setAttribute("src","api.php?req=transcludeSubform&itemkey=loc_cd&loc_cd="+ark_id+"&sf_conf=loc_map_pop_conf"); 
            if (iframe.attachEvent){
                iframe.attachEvent("onload", function(){
                    $('.loading').css('z-index', '-1');
                });
            } else {
                iframe.onload = function(){
                    $('.loading').css('z-index', '-1');
                };
            }
            overlay.getElement().appendChild(iframe);
         }
        else {
            overlay.getElement().style.display = 'none';
        }
    });
} else {
    overlay.getElement().style.display = 'none';
}
}

map1.on('click', function(evt) {
    window.features = new ol.Collection();
	featureOverlay.getFeatures().clear();
    overlay.getElement().style.display = 'block';
    $("#popupiframe").ready(function () {
        $('.loading').css('z-index', '5');
    });
    overlay.getElement().innerHTML = '<img src=<?php echo $skin_path."/images/lightbox/loading.gif"?>></img>';
    var coordinate = evt.coordinate,
        viewResolution = /** @type {number} */ (view.getResolution()),
        getReq;
    overlay.setPosition(coordinate);
    var loop = $.each(bins, function (index,value){
        layers = jQuery( "#slider" ).data();
        if (layers[value].getVisible()){
        	var qry = layers[value].getSource().getGetFeatureInfoUrl(
                coordinate, viewResolution, 'EPSG:900913',
                {'INFO_FORMAT': 'application/json'}
            );
        	get = $.get( qry, handlefeatures );
        }
    });
    $.when(loop).done(function(){$.when(get).done(processFeatures);});
});

target = $('body');
$('html,body').animate({
    scrollTop: target.offset().top
});

});

} ) ( jQuery );
</script>
</div>
