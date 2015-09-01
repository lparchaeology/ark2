<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_wfs_spat.php
*
* subform for wfs spatial display
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

if (array_key_exists($sf_key, $authitems)){
	if (!in_array($sf_val,$authitems[$sf_key])){
		$sf_val = FALSE;
	}
} else {
	$sf_val = FALSE;
}

// MARKUP
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

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
        $var .= "<div class=\"{$sf_cssclass}\">";
        $var .= sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        //first check if view_map has been set in the settings (i.e. to display the maps by default)
        include_once ('php/map/map_functions.php');
        //grab the wmc array
        if (array_key_exists('background_map',$sf_conf)) {
            $wmc = getMulti('cor_tbl_wmc', 'name =  "' .$sf_conf['background_map'] .'"');
            if (is_array($wmc)) {
                $wmc_code = addslashes($wmc[0]['wmc']);
                $var .= loadWMCMap($wmc_code, $wmc[0]['id'], "map", 'single');
                //now let's check if we want to include a place search
                if (array_key_exists('op_placetypes',$sf_conf)) {
                    $var .= mkPlace($sf_conf['op_placetypes']);
                    $var .= "<div><ul id=\"place_ul\"></ul></div>";
                }
            } else {
                echo "ADMIN ERROR: Error with the sf_conf, the map set in background map doesn't seem to exist";
            }
        } else {
            echo "ADMIN ERROR: There is an error with the sf_conf, no background_map set";
        }
        break;
        
    case 'transclude':
        include_once ('../map/map_functions.php');
        if (array_key_exists('op_buffer',$sf_conf)) {
            $var .= mkSingleMap($sf_conf['wfs_layers'], $sf_conf['wms_layers'], $sf_val,$sf_conf['op_buffer'],TRUE);
        } else {
            $var .= mkSingleMap($sf_conf['wfs_layers'], $sf_conf['wms_layers'], $sf_val,FALSE,TRUE);    
        }
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
// echo
echo $var;

?>
