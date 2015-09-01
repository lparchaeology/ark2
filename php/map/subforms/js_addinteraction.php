<?php 

$fields = $sf_conf['fields'];
// for now only one field is editable lets use the first one
$field = $fields[0];
if(array_key_exists('op_geom',$field)){
    $geom = $field['op_geom'];
} else {
    $geom = 'Polygon';
}


$mk_reallydelete = getMarkup('cor_tbl_markup', $lang, 'reallydelete');
$mk_arkidnotset  = getMarkup('cor_tbl_markup', $lang, 'arkidnotset');

$username = getSingle('username','cor_tbl_users',"id=$user_id");

$quarantine = "data/mapping/proposed_additions/";

$target = $quarantine.$username;

$available_ark_ids = "var availableArkids = [";
foreach ($authitems[$field['module'].'_cd'] as $authitem){
    $available_ark_ids .="\"$authitem\",";
}
$available_ark_ids .= "];";

$quarantined = scandir($quarantine);

$my_quarantined = [];

foreach( $quarantined as $key=>$val){
    if(split('_LA_', $val)[0]==$username){
        $my_quarantined[] = $val;
    }
}

$quarantinedlayers = "";
foreach ($my_quarantined as $layer){
    $layername = explode('_LA_', $layer)[1];
    $layer_id = explode(".", $layername)[0];
    $quarantinedlayers .= 
        genAddLayer(
            array(
                'id'=>split('.', $layer)[0],
                'name'=>$layername,
                'layeruri'=>$quarantine.$layer,
                'projection'=>$map['projection'],
                'format'=>'geojson',
                'selectable'=>false,
                'style'=>
                    "new ol.style.Style({
                        fill: new ol.style.Fill({
                            color: 'rgba(255, 255, 255, 0.2)'
                        }),
                        stroke: new ol.style.Stroke({
                            color: '#D53039',
                            width: 2
                        }),
                        image: new ol.style.Circle({
                            radius: 7,
                            fill: new ol.style.Fill({
                                color: '#D53039'
                            })
                        }),
                        text: new ol.style.Text({
                            font: '\"source-sans-pro\",Helvetica,Arial,sans-serif',
                            text: '$layer_id',
                            fill: new ol.style.Fill({
                                color: '#D53039'
                            }),
                            stroke: new ol.style.Stroke({
                                color: '#fff',
                                width: 3
                            })
                        })
                    })",
                ),
            $map
        );
}

?>

<script>

    //User needs a working layer


function clearMapInteractions(){
    active = $('.interaction.active');
    if(active.is($('#modifyinteraction_icon'))){
        <?php echo "map{$map['id']}";?>.removeInteraction(active.data('modselect'));
    }
    active.removeClass('active');
    active.data('active',false);
    <?php echo "map{$map['id']}";?>.removeInteraction(active.data('interaction'));
    <?php echo "map{$map['id']}";?>.addInteraction(select);
    collection.clear();
    $('.contextmenu').hide();
}

$(document).ready(function() {

    <?php echo $quarantinedlayers; ?>
    
    var geojsonObject = {
          'type': 'FeatureCollection',
          'crs': {
            'type': 'name',
            'properties': {
              'name': 'EPSG:27700'
            }
          },
          'features': []
        };

    var working<?php echo $user_id;?>Source = new ol.source.Vector({
      features: (new ol.format.GeoJSON()).readFeatures(geojsonObject)
    });

    var workinglayer<?php echo $user_id;?> = new ol.layer.Vector({
      source: working<?php echo $user_id;?>Source,
      style: new ol.style.Style({
          stroke: new ol.style.Stroke({
            color: 'green',
            width: 1
          })
        })
    });

        workinglayer<?php echo $user_id;?>.set('selectable',true);

        <?php echo "map{$map['id']}";?>.addLayer(workinglayer<?php echo $user_id;?>);
    
    
    <?php echo $available_ark_ids ?>
    var add = $('#addinteraction_icon');
    add.data('active',false);
    var map = <?php echo "map{$map['id']}";?>;
    var draw = new ol.interaction.Draw({
          source: working<?php echo $user_id; ?>Source,
          type: /** @type {ol.geom.GeometryType} */ ("<?php echo $geom;?>")
        });
        draw.on("drawend", function(e){
            e.feature.set('ark_id', $( "#new_feature_ark_id" ).val());
        })
    add.data('interaction',draw);
    $( "#new_feature_ark_id" ).autocomplete({
        source: availableArkids,
        });
    add.click(function() {
        if(availableArkids.indexOf($( "#new_feature_ark_id" ).val())!==-1){
            if (add.data('active')){
               clearMapInteractions();
            } else {
                clearMapInteractions();
                add.data('active',true);
                add.addClass('active');
                map.removeInteraction(select);
                map.addInteraction(draw);
                console.log(map.getInteractions());
            }
        } else {
            alert("<?php echo $mk_arkidnotset;?>");
        }
    });

    var delint = $('#deleteinteraction_icon');
    var deleteinteraction = new ol.interaction.Select({

        });
    var deletecollection = deleteinteraction.getFeatures();
    deletecollection.on('add', function(evt) {
        deletecollection.forEach(function(e,i,a) {
            var reallydelete = confirm("<?php echo $mk_reallydelete?> "+e.getProperties().ark_id);
            if (reallydelete){
                working<?php echo $user_id;?>Source.removeFeature(e);
            }
            deletecollection.clear();
        });
    });
    delint.data('active',false);
    var map = <?php echo "map{$map['id']};";?>
    delint.data('interaction',deleteinteraction);
    delint.click(function() {
        if (delint.data('active')){
            clearMapInteractions();
        } else {
            clearMapInteractions();
            delint.data('active',true);
            delint.addClass('active');
            collection.clear();
            map.addInteraction(deleteinteraction);
        }
    });
    
    var modify = $('#modifyinteraction_icon');
    modify.data('active',false);
    var map = <?php echo "map{$map['id']};";?>
    var modselect = new ol.interaction.Select({
            layers: function(layer) {
                return layer.get('selectable');
            }});
    var mod = new ol.interaction.Modify({
            features: modselect.getFeatures(),
          });
    modify.data('interaction',mod);
    modify.data('modselect',modselect);
    modify.click(function() {
        if (modify.data('active')){
            clearMapInteractions();
        } else {
            clearMapInteractions();
            modify.data('active',true);
            modify.addClass('active');
            collection.clear();
            map.addInteraction(modselect);
            map.addInteraction(mod);
        }
    });
    
    var save = $('#saveinteraction_icon');
    save.data('active',false);
    var map = <?php echo "map{$map['id']};";?>
    

    function saveLayer(context) {
        var workingfeatures = working<?php echo $user_id;?>Source.getFeatures();
        var geojson  = new ol.format.GeoJSON;
        var geojson     = geojson.writeFeatures(workingfeatures);
        url = "<?php echo $ark_dir;?>api.php?req=update_mapfile";
        data = { target : "<?php echo $target;?>_"+context+".geojson", json: geojson };
        $.ajax({
            type: "POST",
            url: url,
            data: data,
        }).always(function(response) {
            location.reload();
         });
    }
    save.click(function() {

        var context = $( "#new_feature_ark_id" ).val();
        if(context!==''){
            saveLayer(context);
        } else {
            alert("<?php echo $mk_arkidnotset;?>");
        }
    });

});

</script>
