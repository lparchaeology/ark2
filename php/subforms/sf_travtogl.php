<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * subforms/sf_travtogl.php
*
* a simple UI for dealing with traversing to other modules
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
* @author     Mike Johnson m.johnson@lparchaeology.com>
* @copyright  1999-2014 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_txt.php
* @since      File available since Release 1.1.2
*/


// ---- SETUP ---- //


// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}
$filters = reqQst($_SESSION, 'filters');
printPre($filters);
// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$toglmod = getAlias('cor_tbl_module', $lang, 'itemkey', $sf_conf['op_trav_to'], 1);

$href =  $_SERVER['PHP_SELF'];
// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch ($sf_state) {
    // Min Views
	case 'min_view':
	case 'min_edit':
	case 'min_ent':
	    print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
	    // put in the nav
	    print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
	    if ($error) {
	        feedBk('error');
	    }
	    if ($message) {
	        feedBk('message');
	    }
	    print("</div>");
	    break;

	    // Max Views
	case 'p_max_ent':
	case 'p_max_view':
	case 's_max_view':
	case 'lpanel':
	    // put in the nav
	    print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
	    $togl = "<ul><li>";
	    $togl .= getMarkup('cor_tbl_markup', $lang, 'traverseto');
	    $togl .= " $toglmod";
	    if($filters['traverse_to']!='FALSE' && $filters['traverse_to']){
	        $togl .= "<span class=\"filter_set_operator\">";
	        $togl .= "<a href=\"$href?trav_to=FALSE\"><img src=\"$skin_path/images/filters/travtoglon.png\" alt=\"[-]\" title=\"travtoglon\"/></a>";
	        $togl .= "</span>";
	    } else {
	        $togl .= "<span class=\"filter_set_operator\">";
	        $togl .= "<a href=\"$href?trav_to={$sf_conf['op_trav_to']}\"><img src=\"$skin_path/images/filters/travtogloff.png\" alt=\"[-]\" title=\"travtogloff\"/></a>";
	        $togl .= "</span>";
	    }
	    $togl .= "</li></ul>";
	    print $togl;
	    // clean up
	    break;

	    // a default - in case the sf_state is incorrect
	default:
	    echo "<div id=\"sf_linklist\" class=\"{$sf_cssclass}\">\n";
	    echo "<h3>No SF State</h3>\n";
	            echo "<p>ADMIN ERROR: the sf_state for sf_linklist was incorrectly set</p>\n";
	            echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
	            echo "</div>\n";
	            break;
	             
	            // ends switch
}
// clean up
unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);
unset ($alias_lang_info);
    if ($cleanup) {
    unset($link_list);
}

?>
