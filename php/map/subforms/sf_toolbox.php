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
        echo '<div class="tools">
		          <img src="'.$skin_path.'/images/maptools/'.$view.'.png">';
		$icons = "";
		$subforms = $sf_conf['subforms'];
		foreach ($subforms as $sf_conf){
		    if (isset($sf_conf['op_overlay'])){
		        $overlay = reqQst($sf_conf,'op_overlay');
		    } else {
		        $overlay = true;
		    }
		    $class = "tool";
		    if (array_key_exists('op_class', $sf_conf)){
		        $class .= " {$sf_conf['op_class']}";
		    }
		    $icons .= "<div class=\"$class\" id=\"{$sf_conf['sf_html_id']}_icon\">";
		    if($overlay){
		        $icons .= "<a class=\"colorbox\" href=\"overlay_holder.php?sf_conf={$sf_conf['sf_conf_id']}\">";
		        $icons .= "<img src=\"$skin_path/images/maptools/{$sf_conf['op_icon']}\">";
		        $icons .= "</a>";
		    } else {
		        $icons .= "<img src=\"$skin_path/images/maptools/{$sf_conf['op_icon']}\">";
                $sf_state = getSfState('primary_col', $sf_conf['view_state'], $sf_conf['edit_state']);
		        include $sf_conf['script'];
		    }
		    $icons .= '</div>';
		}
		// Make the mode switcher
		$icons .= "<div class=\"tool\" id=\"edit_mode_icon\">";
		$icons .= "<a href=\"{$ark_dir}map_view.php?view=$switchmode\">";
		$icons .= "<img src=\"$skin_path/images/maptools/$switchmode.png\">";
		$icons .= "</a>";
		$icons .= '</div>';
		echo '</div><div class="ol-viewport" ></div><div class="toolbox" id="toolbox">';
		echo $icons;
		echo '</div>';
		print "<script src=\"js/map_toolbox.js\"></script>";

       
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
// echo
echo $var;
 unset($sf_conf);
 unset($sf_state);
?>