<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * subforms/sf_ol3map.php
 *
 * subform for producing openlayers 3 maps
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
* @author     Michael Johnson
* @copyright  1999-2014 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_txt.php
* @since      File available since Release 1.2
*/

// lets assume it hasn't gone wrong yet!
$error= FALSE;
$message = FALSE;

include_once('php/map/map_functions.php');

$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

$map = reqQst($_SESSION, 'map'.$view);

$reset_map = reqQst($_REQUEST,'reset_map');

if(reqQst($_REQUEST, 'mapId')){
    $reset_map = 'true';
    $mapId = reqQst($_REQUEST, 'mapId');
    $_SESSION['mapId'.$view] = $mapId;
}

if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

if (!$map || $reset_map==TRUE) {
    //printPre($sf_conf);
    $mapId = reqArkVar('mapId'.$view, $sf_conf['op_map']);
    if ($mapId) {
        $map = getMap($mapId);
        $_SESSION['map'.$view] = $map;
    } else {
        echo getMarkup('cor_tbl_markup', $lang, 'nomaprequested');
    }
}

$css = "<link rel=\"stylesheet\" href=\"$ark_lib_path/js/ol3/ol.css\" />";
$css .= "<link rel=\"stylesheet\" href=\"$skin_path/stylesheets/map_view.css\" />";

$script = "<script src=\"http://cdnjs.cloudflare.com/ajax/libs/proj4js/2.2.1/proj4.js\" type=\"text/javascript\"></script>";

$script .= "<script type=\"text/javascript\">";
$script .= genproj4Defs("EPSG:27700","+proj=tmerc +lat_0=49 +lon_0=-2 +k=0.9996012717 +x_0=400000 +y_0=-100000 +ellps=airy +towgs84=446.448,-125.157,542.06,0.15,0.247,0.842,-20.489 +units=m +no_defs");
$script .= genproj4Defs("EPSG:32633","+proj=utm +zone=33 +datum=WGS84 +units=m +no_defs");

$script .= genMap($sf_conf['sf_html_id'], $map);

$fields = $sf_conf['fields'];
foreach($map['layers'] as $layer){
    $script .= genAddLayer($layer, $map);
}

$selectInteraction = '';

foreach ($fields as $field){
    $field['selectable']=true;
    $style = getStyle($field['id']);
    if ($style){
       $field['style'] = $style;
    }
    if (array_key_exists('op_traverseto', $sf_conf)){
        $xmis=getXmi($sf_key, $sf_val,$sf_conf['op_traverseto']);
        if(empty($xmis)){
            $xmis=array();
            $bridgexmis=getXmi($sf_key, $sf_val);
            foreach($bridgexmis as $bridge){
                $travxmi= getXmi($bridge['xmi_itemkey'], $bridge['xmi_itemvalue'],$sf_conf['op_traverseto']);
                $xmis = array_merge($xmis, $travxmi);
            }
        }
        foreach($xmis as $xmi){
            $results_array[$xmi['id']]=
            array(
                'itemval'=>$xmi['xmi_itemvalue'],
                'itemkey'=>$xmi['xmi_itemkey'],
            );
        }
        $script .= genAddFilter($results_array, $field, $map);
        $selectInteraction .= genSelectMultiInteraction($map, $field);
        $selectInteraction .= genZoomToLayer($map, $field);
    
    } else {
        $script .= genAddLayer($field,$map);
        $selectInteraction .= genSelectMultiInteraction($map, $field);
        if (isset($sf_key)&&isset($sf_val)){
            $selectInteraction .= genSelected($sf_key, $sf_val, $field, $map);
        } else {
            if(array_key_exists('op_zoomtolayer', $field)){
                if ($field['op_zoomtolayer']){
                    $selectInteraction .= genZoomToLayer($map, $field);
                }
            }
        }
    }
    // need a new interaction for sfs?
}
$script .= $selectInteraction;


switch ($sf_state) {
    // MIN STATES
    case 'min_view' :
    case 'min_edit' :
    case 'min_ent' :
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n";
        // put in the nav
        printf ( sfNav ( $sf_title, $cur_col_id, $cur_sf_id, $$disp_cols ) );
        if ($error) {
            feedBk ( 'error' );
        }
        if ($message) {
            feedBk ( 'message' );
        }
        echo "</div>\n";
        break;
    
    // MAX VIEWS
    case 'p_max_view' :
    case 's_max_view' :
        // put in the nav
        if ($error) {
            feedBk ( 'error' );
        }
        if ($message) {
            feedBk ( 'message' );
        }
        // process the fields array
        
        if(isset($disp_cols)){
            echo '<div id="'.$sf_conf['sf_html_id'].'_sf" class="'.$sf_cssclass.'">';
            print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        }
        
        echo '<div id="'.$sf_conf['sf_html_id'].'" class="mapview '.$view.'">';
        
        if (array_key_exists('subforms', $sf_conf)) {
            $map_sf_conf = $sf_conf['subforms'];

            foreach ($map_sf_conf as $sf_conf ) {
                if (array_key_exists('op_condition', $sf_conf)) {
                    // check the condition
                    if (chkSfCond($item_key, $$item_key, $sf_conf['op_condition'])) {
                        include ($sf_conf['script']);
                    }
                } else {
                    include ($sf_conf['script']);
                }
            }
        }

        echo '<div id="popup"></div>';
        print $script;
        echo '</script>';
        echo $css;
        echo '</div>';
        echo '</div>';
        break;
    
    // MAX EDITS
    case 'p_max_edit' :
    case 's_max_edit' :
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n";
        // put in the nav
        printf ( sfNav ( $sf_title, $cur_col_id, $cur_sf_id, $$disp_cols ) );
        if ($error) {
            feedBk ( 'error' );
        }
        if ($message) {
            feedBk ( 'message' );
        }
        echo '<p class="message">There is no edit option for this SF</p>';
        echo "</div>\n";
        break;
    // a default - in case the sf_state is incorrect
    default :
        echo "<div id=\"sf_itemval\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_itemval was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
} // ends switch

unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);


?>
