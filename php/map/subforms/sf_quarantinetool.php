<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_tooltox.php
*
* subform that has admin tools for a map
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
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_wfs_spat.php
* @since      File available since Release 0.6
*/

// ---- SETUP ---- //
// a fresh var
$var = FALSE;


// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// get request variables
$target = reqQst($_REQUEST,'target');
$action = reqQst($_REQUEST,'action');

$quarantine = "data/mapping/proposed_additions/";

switch ($action){
    case 'confirm':
        unlink($quarantine.$target);
        $message[] = "confirmed $target";
    break;
    case 'reject':
        unlink($quarantine.$target);
        $message[] = "rejected $target";
    break;
}

$quarantined = scandir($quarantine);

if(array_key_exists('op_switchmode',$sf_conf)){
    $switchmode = $sf_conf['op_switchmode'];
} else {
    $switchmode = "home";
}
// ---- OUTPUT ---- //
switch ($sf_state) {
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        $var .= "<div class=\"{$sf_cssclass}\">";
        // put in the nav
        $var .= sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        break;
        
    case 'p_max_view':
    case 'p_max_edit':
    case 'p_max_ent':
    case 's_max_view':
    case 's_max_edit':
    case 's_max_ent':
    case 'lpanel':
        $var .=  "<div id=\"sf_quarantinetool\" class=\"$sf_cssclass\">";
        
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        
        $var .= "<h4>Proposed Shapes</h4>";
        $var .= "<ul>";
        
        $quarantinedlayers = "";
        
        foreach( $quarantined as $key=>$layer){
            if(array_pop(explode(".", $layer))==='geojson'){
                $layername = array_pop(explode('_LA_', $layer));
                $layer_id = explode(".", $layername)[0];
                $layer_label = explode(".", $layer)[0];
                
                $layertool = "<li id=\"quarantine_{$layer_id}\" class=\"quarantinelayer\"><span class=\"label\">$layer_label</span>";
                $layertool .= "<div class=\"quarantinelayertools\">";
                $layertool .= "<form action=\"#\" method=\"POST\">";
                $layertool .= "<input type=\"hidden\" value=\"confirm\" name=\"action\">";
                $layertool .= "<input type=\"hidden\" value=\"$layer\" name=\"target\">";
                $layertool .= "<button class=\"quarantinetool true\" type=\"submit\"><img class=\"confirm\" alt=\"on/off_switch\" src=\"/leiston-abbey/ddt/skins/dvskin/images/onoff/chk_on.png\"></button>";
                $layertool .= "</form>";
                $layertool .= "<form action=\"#\" method=\"POST\">";
                $layertool .= "<input type=\"hidden\" value=\"reject\" name=\"action\">";
                $layertool .= "<input type=\"hidden\" value=\"$layer\" name=\"target\">";
                $layertool .= "<button class=\"quarantinetool false\" type=\"submit\"><img class=\"true reject\" alt=\"on/off_switch\" src=\"/leiston-abbey/ddt/skins/dvskin/images/onoff/chk_off.png\"></button>";
                $layertool .= "</form>";
                $layertool .= "<button class=\"quarantinetool zoom\"><img class=\"true reject\" alt=\"on/off_switch\" src=\"/leiston-abbey/ddt/skins/dvskin/images/plusminus/view_mag.png\"></button>";
                $layertool .= "</div>";
                $layertool .= "</li>";
                $var .= $layertool;
                $quarantinedlayers .= 
                    genAddLayer(
                        array(
                            'id'=>$layer_id,
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
                                        text: '$layer_label',
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
        }
        $var .= "</div>";
        break;
		echo '</div>';

       
        break;
        
    case 'transclude':
        echo "<div id=\"sf_layermanager\" class=\"{$css_class}\">\n";
        echo "<h3>No Transclude </h3>\n";
        echo "<p>ADMIN ERROR: There is no transclude option available for this subform</p>\n";
        echo "</div>\n";
        break;
        
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_wfs_spat\" class=\"{$css_class}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_wfs_spat was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
} // ends switch

// close SF
$var .= "</div>";

print $var;
include_once ("js_quarantinetool.php");
// echo
 unset($sf_conf);
 unset($sf_state);
 unset($var);
?>
