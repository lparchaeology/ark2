<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_places.php
*
* Subform for places
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2008  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @category   subforms
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_place.php
* @since      File available since Release 1.1
*
*/

// ---- COMMON ---- //
// get common elements for all states

include_once('php/map/map_functions.php');

// The default for modules with several modtypes is to have one field list,
// which is the same for all the different modtypes
// If you want to use different field lists for each modtype add to the subform
// settings 'op_modtype'=> TRUE and instead of 'fields' => array( add
// 'type1_fields' => array( for each type. 
if (array_key_exists('op_modtype', $sf_conf)) {
    $modtype = $sf_conf['op_modtype'];
} else {
    $modtype = FALSE;
}

// If modtype is FALSE the fields will only come from one list , if TRUE the 
// fields will come from different field lists. 
if (chkModType($mod_short) && $modtype != FALSE) {
    $modtype = getModType($mod_short, $sf_val);
    $fields = $sf_conf["type{$modtype}_fields"];
} else {
    $fields = $sf_conf['fields'];
}

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// ---- PROCESS ---- //

// get the attrs for each field
foreach ($fields as $key => $field) {
    //get the places for each field
    //now foreach through the query layers - getting the intersects
    foreach ($wxs_qlayers as $layer_key => $layer) {
        if ($layer['mod'] . "_cd" == $sf_key) {
            $wfs_place_query = "{$layer['url']}&VERSION=1.1.0&SERVICE=WFS&REQUEST=GetFeature&TYPENAME=$layer_key&FILTER=<Filter><PropertyIsEqualTo><PropertyName>ark_id</PropertyName><Literal>$sf_val</Literal></PropertyIsEqualTo></Filter>";
            $gml = @file_get_contents($wfs_place_query, 0);
            //now we have to grab the geometry out
            //DEV NOTE: PUT IN HANDLER FOR OTHER WFS SERVER TYPES (NOT JUST MAPSERVER)
            $geometry_namespace = 'ms:msGeometry';
            $geometry = parseGeometry($gml,$geometry_namespace);
            
            //now get the places for the specified placetype
            $placetype_uris = array();
            $intersect = array();
            if (!is_numeric($field['classtype'])) {
                // Get the code we need
                $placetype = getSingle('id', 'cor_lut_placetype', "placetype = \"{$field['classtype']}\"");
            } else {
                $placetype = $field['classtype'];
            }
            $layer = getMulti(
                  'cor_lut_place',
                  "placetype=$placetype"
            );
            //now get the spatial server uris
            if (is_array($layer)) {
                foreach ($layer as $layername) {
                    $placetype_uris[$layername['layername']]['uri'] = $layername['spatial_server_uri'];
                }
            }
            foreach ($placetype_uris as $uri_key => $uri) {
              $wfs_intersect_query = "&VERSION=1.1.0&SERVICE=WFS&REQUEST=GetFeature&TYPENAME=$uri_key&FILTER=<Filter><Intersects><PropertyName>Geometry</PropertyName>$geometry</Intersects></Filter>";
              //these queries can get quite big so lets POST it
              $opts = array('http' =>
                  array(
                      'method'  => 'POST',
                      'header'  => 'Content-type: application/x-www-form-urlencoded',
                      'content' => $wfs_intersect_query
                  )
              );           
              $context  = stream_context_create($opts);  
              $gml = @file_get_contents($uri['uri'] . $wfs_intersect_query, 0, $context);
              if ($gml) {
                  $intersects[$placetype] = parseArkIDs($gml,FALSE,'ark_id');
                  $intersects[$placetype]['layername'] = $layername['layername'];
              }
            }
        }
    }
    if ($intersects) {
        foreach ($intersects as $place_array) {
            foreach ($place_array as $place) {
                if (is_numeric($place)) {
                    $placeid = getSingle('id', 'cor_lut_place', "layerid = {$place} AND layername = \"{$place_array['layername']}\"");
                    $alias = getAlias('cor_lut_place',$lang, 'id', $placeid,1);
                    $places[] = array('id' => $placeid, 'alias' => $alias);
                }
            }
        }
        //add them to the field
        if (isset($places)) {
            $fields[$key]['places'] = $places;
            unset($places);
        }
    }
    // In most cases where there is a single field in this sf, the header bar is used to
    // display the alias of the attributetype in question. Where there is more than one
    // field, the alias needs to be added in for display. Also if the sf is within a frame,
    // it will also need an alias, as the headerbar will be turned off.
    if (count($fields) > 1 or isset($sf_frame_used)) {
        $alias_classtype = getAlias('cor_lut_placetype', $lang, 'placetype', $field['classtype'], 1);
        $fields[$key]['alias_classtype'] = $alias_classtype;
    }
}
unset($key);

// ---- MARKUP ----
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_noplaces = getMarkup('cor_tbl_markup', $lang, 'noplaces');


// ---- STATE SPECFIC
// for each state get specific elements and then produce output
switch ($sf_state) {
    // minimised views
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        printf("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        printf("</div>");
        // end the min views
        break;
        
    // maximised edit and enter routines (there is no edit routine for this form)
    case 'p_max_edit':
    case 's_max_edit':
    case 'p_max_ent':
    case 's_max_ent':
    case 'p_max_view':
    case 's_max_view':
        // start the sf div
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        // start an hz list
        $var = "\n<ul class=\"field_list\">";
        $field_var = '';
        $label_var = '';
        $place_var = '';
        $places = array();
        foreach ($fields as $field) {
            // set up attributes
            if (array_key_exists('places', $field)){
                   $places = $field['places'];
            }
            // set up a label for the field if needed
            if (array_key_exists('alias_classtype', $field) && isset($places)) { 
                $label_var = "<label class=\"form_label\">{$field['alias_classtype']}</label>";
            }
            if (!empty($places)) {
                // this first li is for the attr field as a whole
                $field_var = "<li class=\"row\">\n";
                // add the label if needed
                $field_var .= $label_var;
                // this list is to contain the attributes themselves
                $field_var .= "<span class=\"data\"><ul class=\"attr_list\">\n";
                foreach ($places as $place) {
                    $place_id = $place['id'];
                    $alias = $place['alias'];
                    $place_var .= "<li>"; 
                    $place_var .= "$alias";
                    $place_var .= "</li>\n";
                    $field_var .= $place_var;
                    $place_var = '';
                }
                unset ($placess);
                // close out the list of attrs
                $field_var .= "</ul></span>\n";
                // close out this attr field
                $field_var .= "</li>\n";
            } else {
                // we must not leave the list empty so lets put in a message
                // if there is an alias for the classtype (set above), use it
                if (array_key_exists('alias_classtype', $field)) {
                    $leader = "<label class=\"form_label\">{$field['alias_classtype']}</label>"; 
                } else {
                    $leader = FALSE;
                }
                $field_var = "<li class=\"row\">";
                $field_var .= "{$leader}<span class=\"value\">{$mk_noplaces}</span>";
                $field_var .= "</li>\n";
            }
            $var .= $field_var;
            $field_var = '';
        }
        $var .= "\n</ul>";
        // output the sf
        print $var;
        // close the sf div
        echo "</div>\n";
        // clean up
        unset ($sf_conf);
        unset ($val);
        unset ($sf_state);
        unset ($fields);
        break;
    
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_attribute_by_type was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
    // do some cleanup - applies to all cases
    unset ($sf_conf);
    unset ($val);
    unset ($sf_state);
    unset ($fields);
}

?>
