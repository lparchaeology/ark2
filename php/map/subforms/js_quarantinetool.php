<?php 

?>

<script>

$(document).ready(function() {

    <?php echo $quarantinedlayers; ?>
    
    var zoom = $('button.zoom');
    zoom.click(function(e) {
        var layername = $(e.target).closest('li').attr('id').replace('quarantine_','');
        layername = layername + '.geojson';
        map<?php echo $map['id']?>.getLayers().forEach(function(i,e,a){
            if (i.get('name')==layername){
                var source = i.getSource();
                map<?php echo $map['id']?>.updateSize();
                map<?php echo $map['id']?>.getView().fitExtent(source.getExtent(),  map<?php echo $map['id']?>.getSize());
            }
        });
	});
    
    var confirmbtn = $('button.true');
    confirmbtn.click(function(e) {
        e.preventDefault();
        var clicked = $(e.target);
        var layername = clicked.closest('li').attr('id').replace('quarantine_','');
        layername = layername + '.geojson';
        var currentFeatures = layerconf_field_cxt_schmSource.getFeatures();
        map<?php echo $map['id']?>.getLayers().forEach(function(i,e,a){
            if (i.get('name')==layername){
                var newFeatures = i.getSource().getFeatures();
                newFeatures.forEach(function(i,e,a){
                    currentFeatures.push(i);
                });
            }
        });
	    var geojson = new ol.format.GeoJSON;
	    var geojson = geojson.writeFeatures(currentFeatures);
	    url = "<?php echo $ark_dir;?>api.php?req=update_mapfile";
	    data = { target : "data/mapping/cxt_schm.geojson", json: geojson };
	    $.ajax({
            type: "POST",
            url: url,
            data: data,
        }).always(function(response) {
            clicked.closest('form').submit();
     	});
	});

});

</script>
