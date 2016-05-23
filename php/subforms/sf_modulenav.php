<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_modulenav.php
*
* global subform for lists of links
*
* PHP versions 5 and 7
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
* @author     John Layt <john@layt.net>
* @copyright  1999-2016 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/php/subforms/sf_modulenav.php
* @since      2.0
*/

// ---- SETUP ---- //

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mv_subform';
}

if (array_key_exists('modules', $sf_conf)) {
    $modules = $sf_conf['modules'];
} else {
    $modules = array();
}

$selected = reqArkVar('item_key', $default_itemkey);

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch ($sf_state) {
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
    case 'p_max_ent':
    case 'p_max_view':
    case 's_max_view':
    case 'lpanel':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"$sf_cssclass\" >\n";
        echo sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        echo "<ul>\n";
        echo "<li>".mkModNav($modules, $selected)."</li>\n";
        echo "</ul>\n";
        echo "</div>\n";
        break;
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_modulenav\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_modulenav was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;
}

// clean up
unset ($modules);
unset ($selected);
unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($links);
unset ($alias_lang_info);

?>
