<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_mapinteraction.php
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
* @author     Michael Johnson <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_wfs_spat.php
* @since      File available since Release 0.6
*/

// ---- SETUP ---- //

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'contextmenu';
}

if (array_key_exists('interaction',$sf_conf)){
    $interaction = $sf_conf['interaction']; 
    $interaction .= "interaction";   
} else {
    $error['vars'] = "ADMIN ERROR: interaction must be set for {$sf_conf['field_id']}";
}


// MARKUP
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_ARK_ID = getMarkup('cor_tbl_markup', $lang, 'map_add_ark_id');

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
		echo "<div id=\"sf_$interaction\" class=\"$sf_cssclass\">";
		include_once ("js_{$interaction}.php");
	    $sf_interaction = "";
		switch ($interaction){
			case 'addinteraction':
			    $sf_interaction .= "<label for=\"new_feature_ark_id\">$mk_ARK_ID</label>";
			    $sf_interaction .= "<input id=\"new_feature_ark_id\"></input>";
			    break;
			default:
			    break;
		}
		$sf_interaction .= "</div>";
		print $sf_interaction;
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

 unset($sf_conf);
 unset($sf_state);
?>
