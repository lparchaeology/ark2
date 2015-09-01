<?php

$fields = $sf_conf['fields'];
$field = $fields[0];
$mod_cd = $sf_conf['target_module']."_cd";

$mod_alias = getAlias('cor_tbl_module', $lang, 'shortform',  $sf_conf['target_module'], 1);

$available_ark_ids = "var availableArkids = [";
if (array_key_exists($sf_conf['target_module'].'_cd', $authitems)){
    foreach ($authitems[$sf_conf['target_module'].'_cd'] as $authitem){
        $available_ark_ids .="\"$authitem\",";
    }
}
$available_ark_ids .= "];";

if($field['classtype'] == 'xmi_list' && array_key_exists('xmi_mod', $field)){
    $field['classtype'] = $field['classtype'] . '_' . $field['xmi_mod'];
}

$groupinteraction = "
        <script>
$(document).ready(function() {
    var colour = '#E0E000';
    var group = new ol.interaction.Select({
        toggleCondition:ol.events.condition.singleClick,
        layers: function(layer) {
            return layer.get('selectable');
        },
        style: new ol.style.Style({
            stroke: new ol.style.Stroke({color: colour, width: 1}),
            fill: new ol.style.Fill({
                color: 'rgba(224, 224, 0, 0.224)'
            }),
            image: new ol.style.Circle({
                radius: 7,
                fill: new ol.style.Fill({
                    color: '#FF561D'
                })
            })
        })
    });
    map{$map['id']}.removeInteraction(select);
    map{$map['id']}.addInteraction(group);
    var potentialgroup = group.getFeatures();
    var groupcontainer = $('#group_container');
    potentialgroup.on('add', function(evt) {
        var current_potential_ids = [];
        groupcontainer.children().each(function(){
            current_potential_ids.push($(this).attr('id').split('-')[1]);
        });
        potentialgroup.forEach(function(e,i,a) {
            console.log(e);
            var ark_id = e.getProperties().ark_id.toUpperCase();
            if(current_potential_ids.indexOf(ark_id)==-1){
                var collectionitem = document.createElement('div');
                collectionitem.setAttribute(\"id\",\"collectionitem-\"+ark_id);
                collectionitem.className = \"collectionitem\";
                var collectionheader = document.createElement('h3');
                collectionheadertitle = document.createElement('a');
                collectionheadertitle.href = 'micro_view.php?item_key=$mod_cd&$mod_cd='+ark_id;
                collectionheadertitle.appendChild(document.createTextNode(ark_id));
                collectionheader.appendChild(collectionheadertitle);
                var zoomButton = document.createElement('a');
                zoomButton.appendChild(document.createTextNode('Zoom'));
                zoomButton.className='delete';
                $(zoomButton).attr('ark_id',ark_id);
                zoomButton.onclick = function(){
                    ark_id = $(this).attr('ark_id');
                	potentialgroup.forEach(function(e,i,a) {
                        console.log(e.getProperties().ark_id.toUpperCase());
                        console.log(ark_id);
           				if( ark_id === e.getProperties().ark_id.toUpperCase()){
           				    view = map{$map['id']}.getView();
                            extent = e.getGeometry().getExtent();
                            console.log(extent);
                            view.fitExtent(extent, map{$map['id']}.getSize());
                        }
        			});
				};
                var removeButton = document.createElement('a');
                removeButton.appendChild(document.createTextNode('X'));
                removeButton.className='delete';
                removeButton.onclick = function(){
                	potentialgroup.forEach(function(e,i,a) {
           				console.log(e);
           				if( ark_id == e.getProperties().ark_id.toUpperCase()){
           					potentialgroup.remove(e);
           				}
        			});
				};
                collectionheader.appendChild(removeButton);
                collectionheader.appendChild(zoomButton);
                var iframe = document.createElement('iframe');
                iframe.setAttribute(\"id\",\"popupiframe-\"+ark_id);
                iframe.setAttribute(\"scrolling\",\"yes\");
                iframe.setAttribute(\"src\",\"api.php?req=transcludeSubform&itemkey=$mod_cd&$mod_cd=\"+ark_id+\"&sf_conf={$sf_conf['target_module']}_map_pop_conf\"); 
                if (iframe.attachEvent){
                    iframe.attachEvent(\"onload\", function(){
                        $('.loading').css('z-index', '-1');
                    });
                } else {
                    iframe.onload = function(){
                        $('.loading').css('z-index', '-1');
                    };
                }
                collectionitem.appendChild(collectionheader);
                collectionitem.appendChild(iframe);
                groupcontainer.append(collectionitem);
            }
        });
    });
    potentialgroup.on('remove', function(evt) {
        var current_selection_ids = [];
        potentialgroup.forEach(function(e,i,a) {
           console.log(e);
           var ark_id = e.getProperties().ark_id.toUpperCase();
           current_selection_ids.push(ark_id);
        });
        console.log(current_selection_ids);
        groupcontainer.children().each(function(){
            console.log($(this).attr('id').split('-')[1]);
            if(current_selection_ids.indexOf($(this).attr('id').split('-')[1])==-1){
                this.remove();
            }
        });
        overlay.getElement().style.display = 'none';
    });
    
    $available_ark_ids
    
    function pushtocontainer(testvalue){
        map{$map['id']}.getLayers().forEach(function(i,e,a){
                if ('{$geomfield['name']}'==i.get('name')){
                    var current_potential_ids = [];
                    groupcontainer.children().each(function(){
                        current_potential_ids.push($(this).attr('id').split('-')[1]);
                    });
                    i.getSource().getFeatures().forEach(function(i,e,a){
                        if(i.get('ark_id').toUpperCase()==testvalue &&current_potential_ids.indexOf(testvalue)==-1){
                            potentialgroup.push(i);
                        }
                    });
                }
            });
    }
    
    $( \"#textselect_ark_id\" ).autocomplete({
    	source: availableArkids,
    	select: function (event, ui) { 
            pushtocontainer(ui.item.value);   
        },
    });
    
    $( \"#textselect_ark_id\" ).change(function(){
        console.log($( \"#textselect_ark_id\" ).val());
        pushtocontainer($( \"#textselect_ark_id\" ).val());
    });
    
    $('#$form_id').find('button[type=submit]').hide();
    $('#working').hide();
    
    $('#$form_id').find('input[name={$field['classtype']}]').change(function(){
        console.log($(this).val());
        var ajaxurl = 'api.php?req=getFields&fields=conf_field_grpsgrxmi&itemkey=grp_cd&grp_cd='+$(this).val();
        console.log(ajaxurl);
        $.get( ajaxurl, function( data ) {
            if(data.conf_field_grpsgrxmi){
                for ( var xmi in data.conf_field_grpsgrxmi){
                    var this_xmi = data.conf_field_grpsgrxmi[xmi];
                    console.log(this_xmi.xmi_itemvalue);
                    pushtocontainer(this_xmi.xmi_itemvalue);
                }
            }
        });
    });
    
    $('#txtHintType').click(function(){
        console.log('click');
        function getdelayed(){
            var ark_id = $('#$form_id').find('input[name={$field['classtype']}]').val();
            console.log('run');
            var ajaxurl = 'api.php?req=getFields&fields=conf_field_grpsgrxmi&itemkey=grp_cd&grp_cd='+ark_id;
            console.log(ajaxurl);
            $.get( ajaxurl, function( data ) {
                if(data.conf_field_grpsgrxmi){
                    for ( var xmi in data.conf_field_grpsgrxmi){
                        var this_xmi = data.conf_field_grpsgrxmi[xmi];
                        console.log(this_xmi.xmi_itemvalue);
                        pushtocontainer(this_xmi.xmi_itemvalue);
                    }
                }
            });
            $('#xmi_panel').empty();
            
                var collectionheader = document.createElement('h3');
                collectionheadertitle = document.createElement('a');
                collectionheadertitle.href = 'micro_view.php?item_key=grp_cd&grp_cd='+ark_id;
                collectionheadertitle.appendChild(document.createTextNode(ark_id));
                collectionheader.appendChild(collectionheadertitle);
                var zoomButton = document.createElement('a');
                zoomButton.appendChild(document.createTextNode('Zoom'));
                zoomButton.className='delete';
                $(zoomButton).attr('ark_id',ark_id);
                zoomButton.onclick = function(){
                    var groupminx = Number.MAX_VALUE;
                    var groupminy = Number.MAX_VALUE;
                    var groupmaxx = Number.MAX_VALUE*-1;
                    var groupmaxy = Number.MAX_VALUE*-1;
                    var groupExtent = [groupminx,groupminy,groupmaxx,groupmaxy];
                    console.log(groupExtent);
                	potentialgroup.forEach(function(e,i,a) {
                        var extent = e.getGeometry().getExtent();
                        console.log(extent);
                        groupExtent[0] = min(groupExtent[0],extent[0]);
                        groupExtent[1] = min(groupExtent[1],extent[1]);
                        groupExtent[2] = max(groupExtent[2],extent[2]);
                        groupExtent[3] = max(groupExtent[3],extent[3]);
                    });
                    console.log(groupExtent);
           		    view = map{$map['id']}.getView();
                    view.fitExtent(groupExtent, map{$map['id']}.getSize());
				};
                collectionheader.appendChild(zoomButton);
            var iframe = document.createElement('iframe');
                iframe.setAttribute(\"id\",\"popupiframe-\"+ark_id);
                iframe.setAttribute(\"scrolling\",\"yes\");
                iframe.setAttribute(\"src\",\"api.php?req=transcludeSubform&itemkey=grp_cd&grp_cd=\"+ark_id+\"&sf_conf=grp_short_description\");
                console.log(iframe); 
                if (iframe.attachEvent){
                    iframe.attachEvent(\"onload\", function(){
                        $('.loading').css('z-index', '-1');
                    });
                } else {
                    iframe.onload = function(){
                        $('.loading').css('z-index', '-1');
                    };
                }
                $('#xmi_panel').append(collectionheader);
                $('#xmi_panel').append(iframe);
        }
        window.setTimeout(function() { getdelayed()},500);
    });
    
    function deleteExisting(){
        var ajaxexistingurl = 'api.php?req=getFields&fields=conf_field_grpsgrxmi&itemkey=grp_cd&grp_cd='+$('#$form_id').find('input[name={$field['classtype']}]').val();
        $.ajax({
            url: ajaxexistingurl,
            async:   false,
            success: function( data ) {
                if(data.conf_field_grpsgrxmi){
                    for ( var frag in data.conf_field_grpsgrxmi){
                        var this_frag = data.conf_field_grpsgrxmi[frag];
                        var ajaxdel = 'api.php?req=putField&update_db=delfrag&dclass={$field['dataclass']}&field=conf_field_grpsgrxmi&delete_qtype=del&frag_id='+this_frag.id;
                        $.ajax({
                            url:    ajaxdel,
                            success: function(result) {
                                if(result.message == false){
                                    alert(result.errors);
                                }
                            },
                            async:   false,
                        });
                    }
                }
            },
        });
    }
    $(\"#clearbtn\").click(function(e){
        e.preventDefault();
        console.log(potentialgroup);
        potentialgroup.clear();
    });
    
    $(\"#gobtn\").click(function(e){
        e.preventDefault();
        $(this).hide();
        $('#working').show();
        $.when(deleteExisting()).done(function() {
            var form = $('#$form_id');
            form.find('button[type=submit]').hide();
            var ajaxurl = 'api.php';
            groupcontainer.children().each(function(){
                form.find('input[name=$mod_cd]').val($(this).attr('id').split('-')[1]);
                form.find('input[name=itemval]').val($(this).attr('id').split('-')[1]);
                var s = form.serialize();
                s = s+'&field={$field['field_id']}';
                s = s+'&req=putField';
                s = s+'&item_key=$mod_cd';
                $.post( ajaxurl,s, function( data ) {
                    $(\"#gobtn\").show();
                    $('#working').hide();
                    $('#message').append(data.messages);
                    window.setTimeout(function(){ $('#message').empty()},500);
                });
            });
        });
    });
});
</script>
";
echo $groupinteraction;
