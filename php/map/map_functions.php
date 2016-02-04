<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * map_functions.php
 *
 * map functions for use with the new ol3 sf's
 *
 * PHP versions 4 and 5
 *
 * LICENSE:
 * ARK - The Archaeological Recording Kit.
 * An open-source framework for displaying and working with
 * archaeological data
 * Copyright (C) 2007 L - P : Partnership Ltd.
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category map
 * @package ark
 * @author Mike Johnson <m.johnson@lparchaeology.com>
 * @copyright 1999-2014 L - P : Partnership Ltd.
 * @license http://ark.lparchaeology.com/license
 * @link http://ark.lparchaeology.com/svn/php/map/map_functions.php
 * @since File available since Release 1.2
 *       
 */

// {{{ allLayerDD()
/**
 * Generates a dd of all of the current layers on the map
 *
 * @return an html formatted select drop down of all the map layers on a db
 * @author Michael Johnson <m.johnson@lparchaeology.com>
 * @access public
 * @since 1.2
 *       
 *        Used in sf_newlayer
 */
function allLayerDD()
{
    global $lang;
    // this returns all the maplayers on the db ( 'where 1' is always true )
    $layerids = getMulti('cor_tbl_maplayer', 1, 'id');
    $dd = "<select id=\"addExistingLayer\"name=\"{" . getMarkup('cor_tbl_markup', $lang, 'addExistingLayer') . "\">";
    // set up a blank in case we need it
    $dd .= "<option value=\"- -\">- -</option>";
    if ($layerids) {
        foreach ( $layerids as $layerid ) {
            $dd .= "<option value=\"{$layerid}\">";
            $dd .= getSingleText('cor_tbl_maplayer', $layerid, 'ark_name');
            $dd .= "</option>";
        }
    }
    $dd .= "</select>";
    return $dd;
}
// }}}
// {{{ allMapsDD()

/**
 * Generates a dd of all of the current layers on the map
 *
 * @return an html formatted select drop down of all the maps on a db
 * @author Michael Johnson <m.johnson@lparchaeology.com>
 * @access public
 * @since 1.2
 *       
 *        Used in sf_newlayer
 */
function allMapsDD()
{
    global $lang;
    $map_ids = getMulti('cor_tbl_map', 1, 'id');
    $dd = "<select id=\"allMaps\" name=\"map_id\">";
    $dd .= "<option value=\"new\">New Map</option>";
    if ($map_ids) {
        foreach ( $map_ids as $map_id ) {
            $dd .= "<option value=\"{$map_id}\">";
            $dd .= getAlias('cor_tbl_map', $lang, 'id', $map_id, 1);
            $dd .= "</option>";
        }
    }
    $dd .= "</select>";
    return $dd;
}
// }}}
// {{{ createWFSFilterString()
/**
 * writes a string that can be used to filter a WFS layer
 * this is a rewrite of Stuart Eve's code from teh 0.6 version
 *
 * @param array $wfs_qlayer the layer name (in the wfs map) to query
 * @param array $results_array the results array
 * @return string $wfs_filter_string the string to append to the URL
 * @author Michael Johnson <m.johnson@lparchaeology.com>
 * @access public
 * @since 1.2
 */
function createWFSFilterString($wfs_qlayer, $results_array)
{
    $have_mod_results = 0;
    $count = count($results_array);
    // the filter is in xml and will use ogc namespace
    $filter = "<ogc:Filter>";
    // if we have more than one we need to wrap it in an or
    if ($count > 1) {
        $filter .= "<ogc:Or>";
    }
    // loop over the results
    foreach ( $results_array as $key => $result ) {
        // only get the results from the module that ww are querying
        if (substr($result['itemkey'], 0, 3) == substr($wfs_qlayer['module'], 0, 3)) {
            // we will assume that the target layer source has an ark_id
            $filter .= "<ogc:PropertyIsEqualTo>
                            <ogc:PropertyName>ark_id</ogc:PropertyName>
                            <ogc:Literal>{$ark_id}</ogc:Literal>
                        </ogc:PropertyIsEqualTo>";
            $have_mod_results = 1;
        }
    }
    if ($count > 1) {
        $filter .= "</ogc:Or>";
    }
    $filter .= "</ogc:Filter>";
    // if we have had nothing then make something to return
    if ($have_mod_results == 0) {
        $filter = 0;
    }
    return $filter;
}
// }}}
// {{{ duplicateLayers()
/**
 * creates a duplicate of a list of space separated layers on the database
 * getting a new id and posting all the same data onto the database
 *
 * @param string the mapid to add the new layers to
 * @param string the list of layer ids (space separated) to clone
 * @return array the details of the layers added, or false on failure
 * @author Michael Johnson <m.johnson@lparchaeology.com>
 * @access public
 * @since 1.2
 */
function duplicateLayers($mapid, $layer_list)
{
    global $user_id, $lang, $default_site_cd;
    // get rid of the whitespace and split the list of layers into an array
    $layerids = split(" ", trim($layer_list));
    // get layer details needs an array
    $layers = getLayerDetails($layerids);
    // set up some useful variables
    $itemkey = 'cor_tbl_maplayer';
    $cre_by = $user_id;
    $cre_on = "NOW()";
    $text_properties = array(
                    'remotename',
                    'layeruri',
                    'layerstyle'
    );
    $attr_properties = array(
                    'layerformat',
                    'projection',
                    'servertype'
    );
    // loop over all the layers being duplicated, this will often only be one
    foreach ( $layers as $layer ) {
        // get a new maplayerid
        $layerid = addMapLayer($mapid, $cre_by);
        // when we get one we can go ahead and add the properties
        if ($layerid['success']) {
            $itemvalue = $layerid['new_itemvalue'];
            // pulling from the arrays above
            foreach ( $text_properties as $text ) {
                $txttype = getClassType('txt', $text);
                $$text = addTxt($txttype, $itemkey, $itemvalue, $layer[$text], $lang, $cre_by, $cre_on);
                if (!${$text}[0]['success']) {
                    $errors[]['message'] = "failed on $text for layer $layerid";
                    return $$text['failed_sql'];
                }
            }
            foreach ( $attr_properties as $attr ) {
                printPre($layer);
                $data = getChData('attribute', 'cor_tbl_maplayer', $layer['id'], $attr, FALSE);
                printPre($data);
                $attrid = $data[0]['attribute'];
                printPre(array(
                                $attrid,
                                $attr
                ));
                $$attr = addAttr($attrid, $itemkey, $itemvalue, $cre_by, $cre_on, true);
                if (!${$attr}[0]['success']) {
                    $errors[]['message'] = "failed on $attrid for layer $layerid";
                    return $$attr['failed_sql'];
                }
            }
        }
    }
    if (isset($errors)) {
        return false;
    } else {
        return $layers;
    }
}
// }}}
// {{{ genAddFeatureOverlay()
/**
 * a function for generating the javascript to create a feature overlay on a
 * given map
 *
 * @param array $map the map to add the overlay to
 * @return string the javascript for making a feature overlay
 */
function genAddFeatureOverlay($map, $name = "featureOverlay")
{
    $script = "
        var $name = new ol.FeatureOverlay({
            map: map{$map['id']},
            style: new ol.style.Style({
                image: new ol.style.Circle({ 
                    radius: 6, 
                    fill: new ol.style.Fill({color: 'rgba(255, 255, 255, 0.6)'}),
                    stroke: new ol.style.Stroke({color: '#e29446', width: 1}) 
                }),
                fill: new ol.style.Fill({color: 'rgba(255, 86, 29, 0.6)'}),
                stroke: new ol.style.Stroke({color: '#e29446', width: 2})
            }),
            projection:'EPSG:900913',
        });
    ";
    return $script;
}
// }}}
// {{{ genAddFilter()
/**
 * code for creating a filter for spatial layers from an ARK filter request
 *
 * @param unknown $results_array an ARK results array
 * @param unknown $wxs_qlayer the layer to filter
 * @param unknown $map the map to add the filtered layer to
 * @return string the javascript that will create the map view
 */
function genAddFilter($results_array, $wxs_qlayer, $map)
{
    $filterJS = '';
    // the filter map have several results for a layer - so add anew number to each result
    $layer_number = 1;
    // switch for the layer, so far only wfs and geojson
    switch($wxs_qlayer['format']) {
        case 'wfs' :
            // use a modification of Stu Eve's filter string
            $filter = createWFSFilterString($wxs_qlayer, $result_array_copy);
            // make the wxs_qlayer more like other layers
            if ($filter) {
                $wxs_qlayer['filter'] = $filter;
                $wxs_qlayer['id'] = $wxs_qlayer['id'] . $layer_number;
                // this style should be on a request
                $wxs_qlayer['style'] = "new ol.style.Style({image: new ol.style.Circle({ radius: 6, fill: new ol.style.Fill({color: 'rgba(255, 255, 255, 0.6)'}), stroke: new ol.style.Stroke({color: '#ffff00', width: 2}) }), fill: new ol.style.Fill({color: 'rgba(255, 255, 255, 0.6)'}), stroke: new ol.style.Stroke({color: '#ffff00', width: 2}) })";
                $filterJS .= genAddLayer($wxs_qlayer, $map);
                $layer_number += 1;
            }
            break;
        case 'geojson' :
            // geojson is handled in the loading of the layer
            $wxs_qlayer['filter'] = $results_array;
            $filterJS .= genAddLayer($wxs_qlayer, $map);
            break;
    }
    return $filterJS;
}
// }}}
// {{{ genAddLayer
/**
 *
 *
 * a function that generates code for adding a layer to a map
 *
 * @param array $layer the layer to add
 * @param array $map the map to add the layer to
 * @return string of javascript to add the layer to the map
 *        
 *         This is the meat of the map functions - generating the code for the layer
 *         it is made up of a big switch. might be good to split these out
 *        
 */
function genAddLayer($layer, $map)
{
    global $authitems;
    switch($layer['format']) {
        // TILEJSON
        case 'tilejson' :
            $var = "
    	       layer{$layer['id']} = new ol.layer.Tile({
    	           source: new ol.source.TileJSON({
    	               url: '{$layer['layeruri']}',
    	               crossOrigin: 'anonymous'
                    })
                });

                layer{$layer['id']}.set('name', '{$layer['name']}');

                map{$map['id']}.addLayer(layer{$layer['id']});
            ";
            break;
        
        // WMS
        case 'wms' :
            $var = "
                var layer{$layer['id']}Source = new ol.source.TileWMS({
                    url: '{$layer['layeruri']}',";
            if (array_key_exists('remotename', $layer)) {
                $var .= "params: {'LAYERS': '{$layer['remotename']}', 'TRANSPARENT': 'true'},";
            }
            $var .= "
                    serverType: '{$layer['serverType']}'
                });

                var layer{$layer['id']} = new ol.layer.Tile({
                    source: layer{$layer['id']}Source,
                });

                console.log('{$layer['name']}');

                layer{$layer['id']}.set('name', '{$layer['name']}');";
            
            $var .= "map{$map['id']}.addLayer(layer{$layer['id']});";
            
            if (array_key_exists('visible', $layer)) {
                $var .= "layer{$layer['id']}.setVisible({$layer['visible']});";
            } else {
                $var .= "layer{$layer['id']}.setVisible( false );";
            }
            break;
        
        // WFS
        case 'wfs' :
            if (isset($layer['filter'])) {
                $filter = $layer['filter'];
            } else {
                $filter = "<ogc:Box><ogc:coordinates>' + extent.join(',') + ',{$layer['projection']}</ogc:coordinates></ogc:Box>";
            }
            $wfs_query = "<GetCapabilities service=\"WFS\" xmlns=\"http://www.opengis.net/wfs\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.opengis.net/wfs http://schemas.opengis.net/wfs/1.1.0/wfs.xsd\"/>";
            
            $url = "{$layer['layeruri']}";
            $var = "
                var first{$layer['id']} = true;
                var parseResponse = function(response) {
                    //this is where we style on a per feature basis
                    features = {$layer['id']}Source.readFeatures(response);
                    first{$layer['id']} = false;
                    features.forEach(function(e,i,a){
                        var properties = e.getProperties();
                        properties.ark_id = properties.site+'_'+properties.context;
                        e.setProperties(properties);
                });
                {$layer['id']}Source.addFeatures(features);";
            if ($layer['op_zoomtolayer']) {
                $var .= "
                    if(first){
                        view = map{$map['id']}.getView();
                        extent = {$layer['id']}Source.getExtent();
                        console.log(extent);
                        view.fitExtent(extent, map{$map['id']}.getSize());
                    }";
            }
            
            $var .= "};

                var {$layer['id']}Source = new ol.source.ServerVector({
                    format: new ol.format.GeoJSON(),
                    loader: function(extent, resolution, projection) {
                        var url = '$url';
                        jQuery.ajax({
                            url: url,
                            contentType: 'text/xml',
                            data: '$wfs_query',
                            type: 'POST',
                            dataType: 'json',
                        });
                    },
                    strategy: ol.loadingstrategy.bbox,
                });
                var layer{$layer['id']} = new ol.layer.Vector({
                    source:{$layer['id']}Source,
                });
                layer{$layer['id']}.set('name', '{$layer['name']}');";
            
            $hidden = reqQst($layer, 'hidden');
            if ($hidden) {
                $var .= "layer{$layer['id']}.set('hidden', true);\n";
            }
            $style = reqQst($layer, 'style');
            if ($style) {
                $var .= "layer{$layer['id']}.setStyle({$style});\n";
            }
            $select = reqQst($layer, 'selectable');
            if ($select) {
                $var .= "layer{$layer['id']}.set('selectable', true);\n";
            }
            $var .= "map{$map['id']}.addLayer(layer{$layer['id']});";
            break;
        
        // GEOJSON
        case 'geojson' :
            $var = "
                var layer{$layer['id']}Source = new ol.source.GeoJSON({ projection: '{$layer['projection']}', url: '{$layer['layeruri']}' });";
            $merge = reqQst($layer, 'op_merge');
            if ($merge) {
                // we are going to merge the polygons from the href file based on their relationships in ARK
                $var .= "
                    //flag so we only do this once
                    var layer{$layer['id']}SourceMerged = false;
                    var listenerKey = layer{$layer['id']}Source.on('change', function() {
                    if (layer{$layer['id']}Source.getState() == 'ready') {
                    //the first time the sorce returs 'ready'
                    if(!layer{$layer['id']}SourceMerged){
                    var merge = { ";
                // merge variable will be built using get xmi
                $mod_code = $layer['module'] . '_cd';
                foreach ( $authitems[$mod_code] as $mergekey ) {
                    $xmis = getXmi($mod_code, $mergekey, $merge);
                    if ($xmis) {
                        foreach ( $xmis as $xmi ) {
                            $var .= "\"{$xmi['xmi_itemvalue']}\":\"$mergekey\",";
                        }
                    }
                }
                $var .= "};
                    var mergePolys = {};
                    var geojson  = new ol.format.GeoJSON();
                    
                    // loop through the features in the root source
                    layer{$layer['id']}Source.forEachFeature(function(feature) {
                        // if the feature has a lookup in the merge array
                        if (merge.hasOwnProperty(feature.get('ark_id'))){
                            //the id of the feature to be merged
                            var ark_id = feature.get('ark_id');
                            //the id of the feature to be merged to
                            var mergeid= merge[feature.get('ark_id')];
                            // if we already have a feature for this
                            if(mergePolys.hasOwnProperty(mergeid)){
                                //get the existing geom
                                existgeom = mergePolys[mergeid].getGeometry();
                                // check that it actually had one
                                if(typeof existgeom !== 'undefined'){
                                    // get the geometry of the feature we are wroking with
                                    var newgeom = feature.getGeometry();
                                    // append the new geom
                                    existgeom.appendPolygon(newgeom);
                                    //create a new feature with a clone of that geometry
                                    var grpfeat = new ol.Feature({
                                        geometry: existgeom.clone(),
                                    });
                                } else {
                                    var coords = feature.getGeometry().getCoordinates();
                                    var grpfeat = new ol.Feature({
                                        geometry: new ol.geom.MultiPolygon([coords]),
                                    });
                                }
                                grpfeat.set('ark_id',mergeid);
                                mergePolys[mergeid] = grpfeat;
                            } else {
                                //create new poly
                                var coords = feature.getGeometry().getCoordinates();
                                var grpfeat = new ol.Feature({
                                    geometry: new ol.geom.MultiPolygon(coords),
                                });
                                grpfeat.set('ark_id',mergeid);
                                mergePolys[mergeid] = grpfeat;
                            }
                        }
                    });
                    layer{$layer['id']}SourceMerged = true;
                    layer{$layer['id']}MergedSource = new ol.source.Vector();
                    $.each(mergePolys, function(i,v){
                        try{
                            layer{$layer['id']}MergedSource.addFeature(v);
                        } catch (Error){
                            console.log(Error);
                        }
                    });
                    layer{$layer['id']}.setSource(layer{$layer['id']}MergedSource);
                }
                }
                });";
            }
            $var .= "var layer{$layer['id']} = new ol.layer.Vector({ source: layer{$layer['id']}Source });";
            $style = reqQst($layer, 'style');
            if ($style) {
                $var .= "layer{$layer['id']}.setStyle({$style});\n";
            }
            $select = reqQst($layer, 'selectable');
            if ($select) {
                $var .= "layer{$layer['id']}.set('selectable', true);\n";
            }
            if (reqQst($layer, 'op_zoomtolayer')) {
                $var .= "
                        view = map{$map['id']}.getView();
                        extent = layer{$layer['id']}Source.getExtent();
                        view.fitExtent(extent, map{$map['id']}.getSize());";
            }
            $var .= "
                    layer{$layer['id']}.set('name', '{$layer['name']}');
                    map{$map['id']}.addLayer(layer{$layer['id']});
                    ";
            $filter = reqQst($layer, 'filter');
            if ($filter) {
                $var .= "
                        var listenerKey = layer{$layer['id']}Source.on('change', function() {
                         
                        if (layer{$layer['id']}Source.getState() == 'ready') {
                        var filter = [ ";
                foreach ( $filter as $code ) {
                    $var .= "'{$code['itemval']}',";
                }
                $var .= "];
                        layer{$layer['id']}Source.forEachFeature(function(feature) {
                            if (filter.indexOf(feature.get('ark_id')) === -1){
                                layer{$layer['id']}Source.removeFeature(feature);
                            }
                        });
                        console.log(new Date().getTime());
                        console.log(layer{$layer['id']}Source.getFeatures());
                        view = map{$map['id']}.getView();
                        extent = layer{$layer['id']}Source.getExtent();
                        view.fitExtent(extent, map{$map['id']}.getSize());
                    }
                });";
            }
            unset($filter);
            break;
        default :
            $var = "TYPE ERROR {$layer['format']}";
    }
    return $var;
}
// }}}
// {{{ genDataViewInteraction ()
/**
 * generates the javascript for the data view page interaction
 *
 * @param unknown $map the map to use for the data view map view
 * @param unknown $field the spatial field - or layer to interact with
 * @return string javascript to determine behaviour of the data view page
 */
function genDataViewInteraction($map, $field)
{
    global $skin_path, $lang;
    
    $mod_cd = $field['module'] . "_cd";
    
    $mod_alias = getAlias('cor_tbl_module', $lang, 'shortform', $field['module'], 1);
    
    $interactionJS = "
        select = new ol.interaction.Select({
            layers: function(layer) {
                return layer.get('selectable');
            },
            style: new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 6,
                    fill: new ol.style.Fill({color: 'rgba(255, 255, 255, 0.6)'}),
                    stroke: new ol.style.Stroke({color: '#ff561d', width: 3})
                }),
                fill: new ol.style.Fill({color: 'rgba(255, 255, 255, 0.6)'}),
                stroke: new ol.style.Stroke({color: '#ff561d', width: 3})
            })
        });
        map{$map['id']}.addInteraction(select);
        var collection = select.getFeatures();
        collection.on('add', function(evt) {
            var elements = document.getElementsByClassName(\"search_item selected\");
            for (var i = 0; i < elements.length; i++) {
                elements[i].className = \"search_item\";
            }
            collection.forEach(function(e,i,a) {
                console.log(e);
                var ark_id = e.get('ark_id').toUpperCase();
                var chat = document.getElementById(\"{$mod_cd}_\"+ark_id);
                if(chat){
                    chat.className = chat.className + \" selected\";
                    chat.scrollIntoView({block: \"start\", behavior: \"smooth\"});      
                }
            })
        });
        
        collection.on('remove', function(evt) {
            var elements = document.getElementsByClassName(\"search_item selected\");
            for (var i = 0; i < elements.length; i++) {
                console.log(elements[i].className);
                elements[i].className = \"search_item\";
            }
        });
    ";
    $interactionJS .= "
        $(document).ready(function(){
            $('.search_item').click(function(e) {
                self = $(this).attr('id');
                self_split = self.split('_');
                ark_id = self_split[2]+'_'+self_split[3];
                map{$map['id']}.getLayers().forEach(function(i,e,a){
                    if (i.get('name')=='{$field['name']}'){
                        collection.clear();
                        i.getSource().getFeatures().forEach(function(i,e,a){
                            if(i.get('ark_id').toUpperCase()==ark_id){
                                collection.push(i);
                            }
                        });
                    }
                });
                var elements = document.getElementsByClassName(\"search_item selected\");
                for (var i = 0; i < elements.length; i++) {
                    console.log(elements[i].className);
                    elements[i].className = \"search_item\";
                }
                if(this.className == 'search_item'){
                    this.className = this.className + \" selected\";
                }
            });
        });
    ";
    
    return $interactionJS;
}
// }}}
// {{{ genMap()
/**
 * this function generates javascript to create a map
 * it will create it's own view and overlay
 *
 * @param unknown $target the id of the html object that will contain the map
 * @param unknown $map an ARK map array
 * @return JS snippet
 * @author Michael Johnson <m.johnson@lparchaeology.com>
 * @access public
 * @since 1.2
 */
function genMap($target, $map)
{
    $script = genView($map);
    
    $script .= genOverlay($map);
    $script .= "var map{$map['id']} = new ol.Map({
            controls: ol.control.defaults({attribution: false}).extend([
                new ol.control.FullScreen(),
                new ol.control.ZoomSlider(),
                new ol.control.ScaleLine(),
            ]),
            interactions: ol.interaction.defaults(),
            // Use the canvas renderer because it's currently the fastest
            renderer: 'canvas',
            target: '$target',
            view: view,
            overlays: [overlay],
        });
        
        $(document).ready(function() {
            map{$map['id']}.updateSize();
        });
    ";
    
    return $script;
}
// {{{
// }}} genOverlay()
/**
 * creates a JS snippet that will add an info overlay
 * to the map object passed to it
 *
 * @param array $map Ark map array
 * @return string the JS snippet
 * @author Michael Johnson <m.johnson@lparchaeology.com>
 * @access public
 * @since 1.2
 */
function genOverlay($map)
{
    $script = "
        var container = document.getElementById('popup');
        var content = document.getElementById('popup-content');

        var overlay = new ol.Overlay({
        element: container,
        map: map{$map['id']},
    });";
    
    return $script;
}
// }}}
// {{{ genproj4Defs()
/**
 * generates a JS snippet that will define a projection,
 * the proj4 library must be included or this will fail
 * ol3 ships with only ESPG:900913 and ESPG:4326
 *
 * @param string $name the name of the projection E.G ESPG:27700
 * @param string $definition the proj4 definiton (found at spatialreference.org)
 * @return the line of JS to define this projection
 * @author Michael Johnson <m.johnson@lparchaeology.com>
 * @access public
 * @since 1.2
 */
function genproj4Defs($name, $definition)
{
    $script = "proj4.defs(\"$name\",\"$definition\");";
    return $script;
}
// }}}
// {{{ genSelected()
/**
 * If there is a pre selected feature eg on a microview page
 * this will generate an overlay layer for a map
 *
 * @param string $sf_key teh subforms key (eg cxt)
 * @param string $sf_val the subforms value (eg MNO12_12)
 * @param array $field the field/layer to get the feature from
 * @param array $map the map to add to
 *       
 * @return string javascript for adding the overlay to the map
 */
function genSelected($sf_key, $sf_val, $field, $map)
{
    global $lang;
    $mk_nospat = htmlentities(getMarkup('cor_tbl_markup', $lang, 'nospat'));
    $buffer = reqQst($field, 'op_buffer');
    if (!$buffer) {
        $buffer = 0;
    }
    $selectedOverlay = genAddFeatureOverlay($map, "selectedOverlay");
    $selectJS = "
        firstselect{$field['id']} =true;
        map{$map['id']}.getLayers().forEach(function(i,e,a){
            i.on('change', function (event) {
                var source = i.getSource();
                if (source.getState() == 'ready' && firstselect{$field['id']} ) {
                    if (i.get('name')=='{$field['name']}'){
                        collection.clear();
                        i.getSource().getFeatures().forEach(function(e,i,a){
                            if(e.get('ark_id').toUpperCase()=='$sf_val'){
                                firstselect{$field['id']} = false;
                                $selectedOverlay
                                selectedOverlay.addFeature(e);
                                overlay.getElement().style.display = 'none';
                                spat = true;
                                map{$map['id']}.updateSize();
                                extent  = e.getGeometry().getExtent();
                                if($buffer){
                                    extent[0]=extent[0]-$buffer;
                                    extent[1]=extent[1]-$buffer;
                                    extent[2]=extent[2]+$buffer;
                                    extent[3]=extent[3]+$buffer;
                                }
                                map{$map['id']}.getView().fitExtent(
                                    extent,
                                    map{$map['id']}.getSize()
                                );
                            }
                        });
                        if(!spat){
                            console.log($('#'+map{$map['id']}.getTarget()));
                            var nospat = document.createElement('div');
                            nospat.setAttribute(\"id\",\"message\");
                            $(nospat).html(\"$mk_nospat\");
                            $('#'+map{$map['id']}.getTarget()).prepend(nospat);
                            map{$map['id']}.getView().fitExtent(
                                layer{$field['id']}Source.getExtent(),
                                map{$map['id']}.getSize()
                            );
                        }
                    }
                }
            });
        });
    ";
    
    return $selectJS;
}
// }}}
// {{{ genSelectInteraction()
/**
 *
 * @param array $map the map to add the interaction to
 * @param array $field the field/layer to interact with
 * @return a JS snippet for select interactions
 * @author Michael Johnson <m.johnson@lparchaeology.com>
 * @access public
 * @since 1.2
 *       
 *        this is not used - as the MultiInteraction has replaced it
 */
function genSelectInteraction($map, $field)
{
    global $ark_root_path, $skin_path, $lang;
    
    $mod_cd = $field['module'] . "_cd";
    
    $mod_alias = getAlias('cor_tbl_module', $lang, 'shortform', $field['module'], 1);
    
    $interactionJS = "
    select = new ol.interaction.Select({
        layers: function(layer) {
            return layer.get('selectable');
        },
        style: new ol.style.Style({
            stroke: new ol.style.Stroke({color: '#e29446', width: 1}),
            fill: new ol.style.Fill({
                color: 'rgba(0, 0, 255, 0)'
            }),
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({
                    color: '#872929'
                })
            })
        })
    });
    
    map{$map['id']}.addInteraction(select);
    var collection = select.getFeatures();
    collection.on('add', function(evt) {
        collection.forEach(function(e,i,a) {
            var ark_id = e.getProperties().ark_id.toUpperCase();
            var geometry = e.getGeometry();
            console.log(geometry.getType());
            switch(geometry.getType()){
                case \"Polygon\":
                    var featcoords = geometry.getInteriorPoint().getCoordinates();
                    break;
                
                default:
                    var featcoords = geometry.getCoordinates();
            }
            var featpix = map{$map['id']}.getPixelFromCoordinate(featcoords);
            console.log(featpix);
            overlay.getElement().style.display = 'inline-block';
            overlay.setPosition(featcoords);
            overlay.getElement().innerHTML = '<a href=\"$ark_root_path/micro_view.php?item_key=$mod_cd&$mod_cd='+ark_id+'\"><h4>$mod_alias '+ark_id.split('_')[1]+'</h4></a>';
            overlay.getElement().innerHTML += '<img class=\"loading\" src=\"$skin_path/images/lightbox/loading.gif\"></img>';
            var iframe = document.createElement('iframe');
            iframe.setAttribute(\"id\",\"popupiframe\");
            iframe.setAttribute(\"scrolling\",\"no\");
            iframe.setAttribute(\"src\",\"api.php?req=transcludeSubform&itemkey=$mod_cd&$mod_cd=\"+ark_id+\"&sf_conf={$field['module']}_map_pop_conf\");
            if (iframe.attachEvent){
                iframe.attachEvent(\"onload\", function(){
                    $('.loading').css('z-index', '-1');
                });
            } else {
                iframe.onload = function(){
                    $('.loading').css('z-index', '-1');
                };
            }
            overlay.getElement().appendChild(iframe);
        });
    });
    collection.on('remove', function(evt) {
        overlay.getElement().style.display = 'none';
    });
    ";
    
    return $interactionJS;
}
// }}}
// {{{ genSelectMultiInteraction()
/**
 *
 * @param unknown $map
 * @param unknown $layer
 * @return a JS snippet for select interactions
 * @author Michael Johnson <m.johnson@lparchaeology.com>
 * @access public
 * @since 1.2
 */
function genSelectMultiInteraction($map, $field)
{
    global $ark_root_path, $skin_path, $lang;
    
    $mod_cd = $field['module'] . "_cd";
    
    $mod_alias = getAlias('cor_tbl_module', $lang, 'shortform', $field['module'], 1);
    
    $multiSelectOverlay = genAddFeatureOverlay($map, "multiSelectOverlay");
    
    $interactionJS = "
        var overlayStyle = (function(){
                var focusstyle = new ol.style.Style({
                        image: new ol.style.Circle({ 
                            radius: 6, 
                            fill: new ol.style.Fill({color: 'rgba(255, 255, 0, 0.6)'}),
                            stroke: new ol.style.Stroke({color: '#e29446', width: 1}) 
                        }),
                        fill: new ol.style.Fill({color: 'rgba(255, 255, 0, 0.6)'}),
                        stroke: new ol.style.Stroke({color: '#e29446', width: 2})
                });
                var style = new ol.style.Style({
                        image: new ol.style.Circle({ 
                            radius: 6, 
                            stroke: new ol.style.Stroke({color: '#e29446', width: 1}) 
                        }),
                        stroke: new ol.style.Stroke({color: '#e29446', width: 2})
                    });
                return function(feature, resolution) {
                    if ( typeof ark_id!=='undefined' ) {
                        if(feature.getProperties().ark_id.toUpperCase() == ark_id){
                            return [focusstyle];
                        } else {
                            return [style];
                        }
                    } else {
                        return [style];
                    }
                };
            })();
            
        $multiSelectOverlay
        multiSelectOverlay.setStyle(overlayStyle);
        
        var collection = new ol.Collection();
        
        var cycleFeatureData = function(iframeids, iframes ,direction) {
            console.log(iframeids);
            var index = iframeids.indexOf(ark_id);
            if(direction!='back'){
                index -= 1;
            } else {
                index += 1;
            }
            if(index<0){
                index=iframeids.length-1;
            }
            if(index>iframeids.length-1){
                      index=0;
            }
            console.log(index);
            iframes[ark_id].style.display = 'none';
            ark_id = iframeids[index];
            multiSelectOverlay.setStyle(overlayStyle);
            iframes[ark_id].style.display = 'inline';
            var titleElem = document.getElementById('overlayTitleElem');
            titleElem.href='$ark_root_path/micro_view.php?itemkey=$mod_cd&$mod_cd='+ark_id;
            titleElem.innerHTML = '<h5>$mod_alias '+ark_id.split('_')[1]+'</h5>';
        }
        
        var displayFeatureInfo = function(pixel) {
            var iframes = {};
            var iframeids = [];
            collection.clear();
            
            multiSelectOverlay.setFeatures(collection);
            overlay.getElement().innerHTML = '<img class=\"loading\" src=\"$skin_path/images/lightbox/loading.gif\"></img>';
            overlay.setPosition(map{$map['id']}.getCoordinateFromPixel(pixel));
            overlay.getElement().style.display = 'block';
            var data = document.createElement('div');
            if(map{$map['id']}.hasFeatureAtPixel(pixel, function(layer) {return layer.get('selectable')})){
                map{$map['id']}.forEachFeatureAtPixel(pixel, function(feature, layer) {
                    ark_id = feature.getProperties().ark_id.toUpperCase();
                    console.log(ark_id);
                    iframes[ark_id] = document.createElement('iframe');
                    iframes[ark_id].setAttribute(\"id\",\"popupiframe\"+ark_id);
                    iframes[ark_id].setAttribute(\"scrolling\",\"no\");
                    iframes[ark_id].setAttribute(\"src\",\"api.php?req=transcludeSubform&item_key=$mod_cd&$mod_cd=\"+ark_id+\"&sf_conf={$field['module']}_map_pop_conf\");
                    iframes[ark_id].style.display = 'none';
                    iframes[ark_id].onload= function(){
                        $('.loading').css('z-index', '-1');
                    };    
                    if(iframeids.indexOf(ark_id)==-1){
                         iframeids.push(ark_id);
                     };
                    data.appendChild(iframes[ark_id]);
                    collection.push(feature);
                });
                var titlebar = document.createElement('div');
                var backbtn = document.createElement('a');
                backbtn.id='backbtn';
                backbtn.innerHTML = '<<';
                backbtn.onclick = function(){cycleFeatureData(iframeids, iframes, 'back')};
                titlebar.appendChild(backbtn);
                var forebtn = document.createElement('a');
                forebtn.id='forebtn';
                forebtn.innerHTML = '>>';
                forebtn.onclick = function(){cycleFeatureData(iframeids, iframes, 'fore')};
                titlebar.appendChild(forebtn);
                var titleElem = document.createElement('a');
                titleElem.id = 'overlayTitleElem';
                titleElem.href='$ark_root_path/micro_view.php?itemkey=$mod_cd&$mod_cd='+ark_id;
                titleElem.innerHTML = '<h5>$mod_alias '+ark_id.split('_')[1]+'</h5>';
                titlebar.appendChild(titleElem);
                iframes[ark_id].style.display = 'inline';
                overlay.getElement().appendChild(titlebar);
                overlay.getElement().appendChild(data);
                
            }
            else {
                overlay.getElement().style.display = 'none';
            }
        };
        
        map{$map['id']}.on('click', function(evt) {
            var pixel = map{$map['id']}.getEventPixel(evt.originalEvent);
            displayFeatureInfo(pixel);
        });
        
    ";
    
    return $interactionJS;
}
// }}}
// {{{ genView()
/**
 * Generates javascript string to create a view based on the properties of an ARK $map array
 *
 * @param array $map ARK array with map settings
 * @return string a javascript snippet to generate a view
 * @author Michael Johnson <m.johnson@lparchaeology.com>
 * @access public
 * @since 1.2
 */
function genView($map)
{
    // put errors in a global variable that we can access later
    global $error;
    // some very basic checks
    if (!array_key_exists('zoom', $map)) {
        $error[] = "Map zoom level not defined correctly";
    }
    if (!array_key_exists('projection', $map)) {
        $error[] = "Map projection not defined correctly";
    }
    // the map centre may be a function, define it separately
    $script = "var center = {$map['center']};\n";
    // here we generate the ol3 view object
    $script .= "
        view =  new ol.View({
            center: center,
            zoom: '{$map['zoom']}',
                projection: '{$map['projection']}',
        });";
    
    return $script;
}
// }}}
// {{{ genZoomToLayer ()
/**
 * generates a snippet to zoom a layer to a map
 *
 * @param unknown $map the map to effect
 * @param unknown $layer the layer to zoom to
 * @return string javascript to zoom a map to a layer
 */
function genZoomToLayer($map, $layer)
{
    $zoomJS = "
        console.log('{$layer['name']}');
        first{$layer['id']} = true;
        map{$map['id']}.getLayers().forEach(function(i,e,a){
            if (i.get('name')=='{$layer['name']}'){
                console.log(i.get('name'));
                var source = i.getSource();
                console.log(source);
                source.on('change', function (event) {
                    if (source.getState() == 'ready') {
                        if(first{$layer['id']}){
                            map{$map['id']}.updateSize();
                            map{$map['id']}.getView().fitExtent(source.getExtent(),  map{$map['id']}.getSize());
                            console.log(source.getFeatures().length);
                            map{$map['id']}.render();
                            first{$layer['id']} =false;
                        }
                    }
                });
            }
        });
    ";
    
    return $zoomJS;
}
// }}}
// {{{ getAttribute()

/**
 * a wrapper for get attribute which gets the attribute from the lut
 *
 * @param string $itemkey the itemkey to get the attribute
 * @param string $itemvalue the value to get the attribute
 * @param string $attribute the attribute - either id or hrname
 * @return string the attribute text or false on failure
 *        
 *         gets the attribute from the
 */
function getAttribute($itemkey, $itemvalue, $attribute)
{
    $data = getChData('attribute', $itemkey, $itemvalue, $attribute, FALSE);
    if ($data) {
        return getSingle('attribute', 'cor_lut_attribute', 'id=' . $data[0]['attribute']);
    }
    return FALSE;
}
// }}}
// {{{ getLayerDetails()
/**
 * this is used to get details of an array of layers from the database
 *
 * @param unknown $layerids an array of layer ids to get details for
 * @return multitype:multitype:Ambigous <string, boolean> Ambigous <Ambigous, boolean> unknown Ambigous <string, boolean, unknown> Ambigous <Ambigous, boolean, unknown>
 */
function getLayerDetails($layerids)
{
    $layers = array();
    if (is_array($layerids)) {
        foreach ( $layerids as $layerid ) {
            $layer = array(
                            'id' => $layerid,
                            'name' => getSingleText('cor_tbl_maplayer', $layerid, 'map_name'),
                            'remotename' => getSingleText('cor_tbl_maplayer', $layerid, 'remotename'),
                            'format' => getAttribute('cor_tbl_maplayer', $layerid, 'layerformat'),
                            'projection' => getAttribute('cor_tbl_maplayer', $layerid, 'projection'),
                            'serverType' => getAttribute('cor_tbl_maplayer', $layerid, 'servertype'),
                            'layeruri' => getSingleText('cor_tbl_maplayer', $layerid, 'layeruri')
            );
            $style = getStyle($layerid);
            if ($style) {
                $layer['style'] = $style;
            }
            $layers[$layerid] = $layer;
        }
    }
    return $layers;
}
// }}}
// {{{ getLayers
/**
 * this is a wrapper for get layer details, that gets all of the layers and their details from
 * the database
 *
 * @param string $mapId the mapId to get the layers for
 * @return array the layers with ther details
 */
function getLayers($mapId)
{
    $where = 'map="' . $mapId . '"';
    $layerids = getMulti('cor_tbl_maplayer', $where, 'id');
    $layers = getLayerDetails($layerids);
    return $layers;
}
// }}}
// {{{ getMap()
/**
 * getting the map from the database, with layers
 * 
 * @param integer $map_id the map id to get 
 * @return $map the array of the map from the database - all the information to generate the javascript
 */
function getMap($map_id)
{
    global $conf_field_zoomlevel;
    $zoom = resFdCurr($conf_field_zoomlevel, 'cor_tbl_map', $map_id);
    $map = array(
                    'id' => $map_id,
                    'name' => getSingleText('cor_tbl_map', $map_id, 'map_name'),
                    'comments' => getSingleText('cor_tbl_map', $map_id, 'comments'),
                    'projection' => strtoupper(getAttribute('cor_tbl_map', $map_id, 'projection')),
                    'center' => getSingleText('cor_tbl_map', $map_id, 'mapcenter'),
                    'zoom' => $zoom[0]['current'],
                    'layers' => getLayers($map_id)
    );
    return $map;
}
// }}}
// {{{ getStyle()
/**
 * get style - currently hard coded options
 * 
 * @param string $layerid the id of the layer
 * @return string the javascript style or false on failure 
 * 
 * This should be updated to get styles from the database
 * styles can contain functions and are very flexible in ol3
 * some examples are included here
 * 
 */
function getStyle($layerid)
{
    // get styles attached to this layer/map
    // or return a default
    $style = getSingleText('cor_tbl_maplayer', $layerid, 'layerstyle');
    if (!$style) {
        $style = "
        new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(255, 255, 255, 0.2)'
            }),
            stroke: new ol.style.Stroke({
                color: '#ffcc33',
                width: 2
            }),
            image: new ol.style.Circle({
                radius: 7,
                fill: new ol.style.Fill({
                    color: '#ffcc33'
                })
            })
        })";
    }
    if ($layerid == 'conf_field_grp_schm') {
        $style = "
            (function() {
                var getText = function(feature, resolution, maxResolution) {
                    var text = feature.getProperties().ark_id.toString();
                    if (resolution > maxResolution) {
                        text = '';
                    }
                    return text;
                };
        
        
                var createTextStyle = function(feature, resolution) {

            var align = 'center';
            var baseline = 'middle';
            var size = '10px';
            var offsetX = 0;
            var offsetY = 0;
            var weight = 'normal';
            var rotation = 0;
            var font = weight + ' ' + size + ' arial';
            var fillColor = 'black';
            var outlineColor = 'white';
            var outlineWidth = 1;
        
            return new ol.style.Text({
                textAlign: align,
                textBaseline: baseline,
                font: font,
                text: getText(feature, resolution, 0.1),
                fill: new ol.style.Fill({color: fillColor}),
                stroke: new ol.style.Stroke({color: outlineColor, width: outlineWidth}),
                offsetX: offsetX,
                offsetY: offsetY,
                rotation: rotation
            });
        };
        
        var createStrokeStyle = function(feature) {
            var style = feature.getProperties().ark_id.toString();

            var colour = '#'+Math.floor(Math.random()*16777215).toString(16);
            return new ol.style.Stroke({
                        color: '#'+Math.floor(Math.random()*16777215).toString(16),
                        width: 1
                    });
        };
        
        // Polygons
        var createPolygonStyleFunction = function() {
            return function(feature, resolution) {
                var style = new ol.style.Style({
                    stroke: createStrokeStyle(feature),
                    fill: new ol.style.Fill({
                        color: 'rgba(0, 0, 255, 0)'
                    }),
                    text: createTextStyle(feature, resolution)
                });
                return [style];
            };
        };
    return createPolygonStyleFunction();
        
    }())
        ";
    }
    if ($layerid == 'conf_field_cxt_schm_geos' || $layerid == 'conf_field_sgr_schm') {
        $style = " (function() {
                var getText = function(feature, resolution, maxResolution) {
  var text = feature.getProperties().ark_id.toString();
  if (resolution > maxResolution) {
    text = '';
  }

  return text;
};
                
                
        var createTextStyle = function(feature, resolution) {
                 var polygons = {
    align: 'center',
    baseline: 'middle',
    rotation: 0,
    font: 'arial',
    weight: 'normal',
    size: '10px',
    offsetX: 0,
    offsetY: 0,
    color: 'black',
    outline: 'white',
    outlineWidth: 1,
    maxreso: 0.1
  };
            var align = polygons.align;
            var baseline = polygons.baseline;
            var size = polygons.size;
            var offsetX = parseInt(polygons.offsetX, 10);
            var offsetY = parseInt(polygons.offsetY, 10);
            var weight = polygons.weight;
            var rotation = parseFloat(polygons.rotation);
            var font = weight + ' ' + size + ' ' + polygons.font;
            var fillColor = polygons.color;
            var outlineColor = polygons.outline;
            var outlineWidth = parseInt(polygons.outlineWidth, 10);
        
            return new ol.style.Text({
                textAlign: align,
                textBaseline: baseline,
                font: font,
                text: getText(feature, resolution, polygons.maxreso),
                fill: new ol.style.Fill({color: fillColor}),
                stroke: new ol.style.Stroke({color: outlineColor, width: outlineWidth}),
                offsetX: offsetX,
                offsetY: offsetY,
                rotation: rotation
            });
        };
        
        
        // Polygons
        var createPolygonStyleFunction = function() {
            return function(feature, resolution) {
                var style = new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: 'rgba(0, 0, 255, 0)',
                        width: 1
                    }),
                    fill: new ol.style.Fill({
                        color: 'rgba(0, 0, 255, 0)'
                    }),
                    text: createTextStyle(feature, resolution)
                });
                return [style];
            };
        };
    return createPolygonStyleFunction();
                
    }())
        ";
    }
    
    if ($layerid == 3) {
        $style = "new ol.style.Style({stroke: new ol.style.Stroke({color: 'lightgrey', width: 0.5})})";
    }
    return $style;
}
// }}}
// {{{ parseGetCap()

/**
 * parses a url of a GetCapabilities request and returns a fully formed-legend array
 *
 *
 * @param string $url the url to query
 * @param string $extra_params any extra parameters that need passing to the form OPTIONAL
 * @param string $admin if you want to print the admin legend
 * @return string $var a fully resolved html string
 * @access public
 * @author Mike Johnson <m.johnson@lparchaeology.com>
 * @author Stuart Eve <stuarteve@lparchaeology.com>
 * @since 0.6
 *       
 *        Modified for 1.2 for ol3
 */
function parseGetCap($url, $extra_params = FALSE, $admin = FALSE)
{
    global $lang;
    $layer_array = array();
    $map = reqArkVar('map');
    $err_markup = getMarkup('cor_tbl_markup', $lang, 'getcap_err');
    
    // check url
    if (strrpos('&amp;', $url)) {
        $url = html_entity_decode($url);
    }
    $url_array = parse_url($url);
    $postdata = array(
                    "service" => "WMS",
                    "request" => "getCapabilities"
    );
    if (!empty($url_array['query'])) {
        $explode = explode('&', $url_array['query']);
        foreach ( $explode as $key => $value ) {
            $explode_query = explode('=', $value);
            if (isset($explode_query[1])) {
                $postdata[$explode_query[0]] = $explode_query[1];
            }
        }
    }
    $postdata = http_build_query($postdata);
    // we need to be careful with timeouts here, so insert a handler
    // create the stream context to enable timeout
    
    $context = stream_context_create(array(
                    'http' => array(
                                    'timeout' => 100,
                                    'method' => 'GET'
                    )
    ));
    $get_cap_url = 'http://' . $url_array['host'];
    if (!empty($url_array['port'])) {
        $get_cap_url .= ':' . $url_array['port'];
    }
    if (!empty($url_array['path'])) {
        $get_cap_url .= $url_array['path'];
    }
    $err_markup .= "<br> URL: " . $get_cap_url;
    $data = file_get_contents($get_cap_url . "?$postdata", 0, $context);
    try {
        if (!$xml = @simplexml_load_string($data)) {
            throw new Exception($err_markup);
        }
    } catch ( Exception $e ) {
        echo $e->getMessage();
        exit();
    }
    // now we have our XML as a simplexml object, we want to go through and find all the available layers
    // loop through all the nodes and find any that are layers
    // first the WMS responses
    if (array_key_exists('Capability', $xml)) {
        foreach ( $xml->Capability->children() as $child ) {
            if (array_key_exists('Layer', $child)) {
                // add all the layers to a multidim array , so that we can then build a legend up
                foreach ( $child->Layer as $layer ) {
                    if (array_key_exists('Layer', $layer)) {
                        // looks like we have a group
                        $layer_key = end(array_keys($layer_array));
                        foreach ( $layer as $sublayer ) {
                            $layer_array[] = array(
                                            'name' => (string) $sublayer->Name,
                                            'title' => (string) $sublayer->Title,
                                            'projection' => (string) $child->CRS,
                                            'layer_key' => $layer_key
                            );
                        }
                    } else {
                        // no group just add the layer in
                        $layer_array[] = array(
                                        'name' => (string) $layer->Name,
                                        'title' => (string) $layer->Title,
                                        'projection' => (string) $child->CRS
                        );
                    }
                }
            } else {
                $err_nolayers = getMarkup('cor_tbl_markup', $lang, 'err_nolayers');
            }
        }
    }
    return $layer_array;
}
//}}}
