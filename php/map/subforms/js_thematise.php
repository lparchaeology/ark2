<script>

<?php

echo "var json_array = ";
echo $json_array;
echo ";";
echo "console.log(json_array);";

?>

/**
* FUNCTIONS
*/

function getRandomColor() {
    var color = 'rgba(';
    color += Math.floor((Math.random() * 255) + 1);
    color += ',';
    color += Math.floor((Math.random() * 255) + 1);
    color += ',';
    color += Math.floor((Math.random() * 255) + 1);
    color += ', 0.7)';
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
    map<?php echo $map['id']?>.getLayers().forEach(function(i,e,a){
        if (i.get('selectable')){
            console.log(i.get('name'));
            var features = i.getSource().getFeatures();
            for ( i=0; i < features.length; i++) {
                var feature_id = features[i].getId();
                console.log(features[i].get('ark_id'));
                var ark_id = features[i].get('ark_id').toUpperCase();
                if (ark_json.hasOwnProperty(ark_id) && ark_json[ark_id].hasOwnProperty(req_field)) {
                    field_id =ark_json[ark_id][req_field]['attribute'];
                    field_value = ark_json[ark_id][req_field]['aliases']['en'];
                    if (rules.hasOwnProperty(field_id)) {
                        style = rules[field_id];
                    } else {
                        color = getRandomColor();
                        var style = new ol.style.Style({
                         image: new ol.style.Circle({
                               radius: 4,
                               fill: new ol.style.Fill({color: color}),
                               stroke: new ol.style.Stroke({color:"white", width:1})
                             }),
                          fill: new ol.style.Fill({color: color}),
                          });
                          $(style).data('Alias', field_value);
                          rules[field_id] = style;
                    }
                } else {
                    //set up a default style
                    var style = new ol.style.Style({
                     image: new ol.style.Circle({
                           radius: 3,
                           fill: new ol.style.Fill({color: "white"}),
                           stroke: new ol.style.Stroke({color: 'darkgrey', width: 0.4}),
                         }),
                     stroke: new ol.style.Stroke({color: 'white', width: 2}),
                     fill: new ol.style.Fill({color:'rgba(179,179,179,0.2)'})
                    });
                }
                features[i].setStyle(style);
             };   
        }
    });
}

/**
* CONFIGURATION (SHOULD BE BOUGHT IN FROM SOMEWHERE ELSE -SETTINGS?)
*/

req_fields = ['conf_field_visit_year','conf_field_geomorph'];

rules = {};


/**
* Load up the ARK features
*
*/

function makeShape(rule) {
     var NS="http://www.w3.org/2000/svg";
    var svgdoc = document.createElementNS(NS,"svg");
    svgdoc.setAttributeNS(null, "width", 10);
    svgdoc.setAttributeNS(null, "height", 10);
    var shape = document.createElementNS(NS, "circle");
    shape.setAttributeNS(null, "cx", 5);
    shape.setAttributeNS(null, "cy", 5);
    shape.setAttributeNS(null, "r",  3);
    shape.setAttributeNS(null, "fill", rule.getImage().getFill().getColor());
    svgdoc.appendChild(shape);
    return svgdoc;
}

$(document).ready(function(){
    themeatiseThis(json_array,'none');
    $('.thematisebtn').click(function(){
        document.getElementById('legend_panel').innerHTML = "";
        rules = {};
        var req_field = $(this).val();
        themeatiseThis(json_array, req_field);
        legend = document.createElement('ul');
        var rulesarr = [],
        i;
        for (i in rules) {
            if (rules.hasOwnProperty(i)) {
                rulesarr.push(i);
            }
        }
        rulesarr.sort();
        for (i = 0; i < rulesarr.length; i++) {
            var rule = rules[rulesarr[i]];
            shape = makeShape(rule);
            legenditem = document.createElement('li');
            legenditemlink = document.createElement('a');
            legenditemlink.appendChild(document.createTextNode($(rule).data('Alias')));
            console.log(window.location.href);
            
            legenditemlink.setAttribute('href','data_view.php?ftype=atr&atrtype='+req_field+'&bv=1&ftr_id=new&disp_mode=thumb&atr='+rulesarr[i]);
            legenditem.appendChild(shape);
            legenditem.appendChild(legenditemlink);
            $(legenditem).data('attributename',rulesarr[i]);
            $(legenditem).hover(function() {
                    $( this ).addClass( "hover" );
                    console.log(req_field);
                    var req_attr = $( this ).data('attributename');
                    console.log(req_attr);
                    map<?php echo $map['id']?>.getLayers().forEach(function(i,e,a){
                        if (i.get('selectable')){
                            var features = i.getSource().getFeatures();
                            for ( i=0; i < features.length; i++) {
                                var feature_id = features[i].getId();
                                var ark_id = features[i].get('ark_id').toUpperCase();
                                if (json_array.hasOwnProperty(ark_id) && json_array[ark_id].hasOwnProperty(req_field)) {
                                    field_id = json_array[ark_id][req_field]['attribute'];
                                    if (field_id==req_attr){
                                        features[i].set('inactiveStyle',features[i].getStyle());
                                        features[i].setStyle(featureOverlay.getStyle());
                                        featureOverlay.addFeature(features[i]);
                                        console.log(featureOverlay.getFeatures().getLength());
                                    }
                                }
                            }
                        }
                    });
                }, function() {
                    $( this ).removeClass( "hover" );
                    featureOverlay.getFeatures().forEach(
                        function(e,i,a){e.setStyle(e.get('inactiveStyle'));}
                    );
                    featureOverlay.getFeatures().clear();
                }
            );
            legend.appendChild(legenditem);
        }
        var legendtitle = document.createElement('h5');
        legendtitle.appendChild(document.createTextNode($(this).text()));
        document.getElementById('legend_panel').appendChild(legendtitle);
        document.getElementById('legend_panel').appendChild(legend);
    })
})

</script>
