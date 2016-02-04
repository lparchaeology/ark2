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

// MARKUP
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_pickmap = getMarkup('cor_tbl_markup', $lang, 'pickmap');
$mk_newmap = getMarkup('cor_tbl_markup', $lang, 'newmap');

// Check the user permissions for admin tools
$admin_int = array_intersect($record_admin_grps, $_SESSION['sgrp_arr']);
if (!empty($admin_int)) {
    $is_record_admin = TRUE;
} else {
    $is_record_admin = FALSE;
}
// GET THE MAPS

$maparray = getMulti('cor_tbl_map', '1','id');

//Something to render each map option
$maps = "";
foreach ($maparray as $map){
    $maps .= "<li>";
    $maps .= "<a id=\"map$map\" class=\"maplink\" href=\"{$ark_root_path}/map_view.php?mapId={$map}&reset_map=true\">";
    $maps .= getAlias('cor_tbl_map', $lang, 'id', $map, 1);
    $maps .= "</a>";
    if ($is_record_admin == TRUE) {
        $del = "<a class=\"smalldelete\" href=\"overlay_holder.php?";
        $del .= "overlay=true&amp;";
        $del .= "delete_key=cor_tbl_map&amp;";
        $del .= "delete_val={$map}&amp;";
        $del .= "lang=$lang&amp;";
        $del .= "lboxreload=1&amp;";
        $del .= "sf_conf=conf_mcd_deleterecord\" >";
        $del .= "<img class=\"smalldelete\" alt=\"X\" src=\"$skin_path/images/plusminus/delete_small.png\">";
        $del .= "</a>";
        $maps .= $del;
    }
    $maps .= "</li>";
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
    case 'overlay':
        echo "<div id=\"choosemap\" class=\"{$sf_cssclass}\">\n";
        $layeroptions = $mk_pickmap;
		$layeroptions .= "<div id=\"choosemap\">";
		$layeroptions .= "<ul id=\"map_list\">";
		$layeroptions .= $maps;
		$layeroptions .= "</ul>";
		$layeroptions .= "</div>";
		print $layeroptions;
		$newmap = '<a class="colorbox cboxElement" href="overlay_holder.php?sf_conf=conf_map_savemap&lboxreload=0">';
		$newmap .= $mk_newmap;
		$newmap .= '</a>';
		print $newmap;
		include_once 'js_choosemap.php';
       
        break;
        
    case 'transclude':
        echo "<div id=\"sf_layermanager\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No Transclude </h3>\n";
        echo "<p>ADMIN ERROR: There is no transclude option available for this subform</p>\n";
        echo "</div>\n";
        break;
        
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_wfs_spat\" class=\"{$sf_cssclass}\">\n";
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
 unset($sf_conf);
 unset($sf_state);
?>
