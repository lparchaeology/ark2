<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_itemadmin.php
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
* @link       http://ark.lparchaeology.com/code/php/subforms/sf_itemadmin.php
* @since      2.0
*/


// Check the user permissions for admin tools
$admin_int = array_intersect($record_admin_grps, $_SESSION['sgrp_arr']);
if (empty($admin_int)) {
    return;
}

// ---- SETUP ---- //

// Force a mod_short
$item_key = reqArkVar('item_key', $default_itemkey);
$item_val = $$item_key;

// Check if modtype exists and get alias
if (chkModtype($mod_short)) {
    $modtype = getModType($mod_short, $item_val);
} else {
    $modtype = FALSE;
}

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mv_subform';
}

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
        echo "<ul id=\"item_admin\" >\n";

        // Delete Item
        $mk_title = getMarkup('cor_tbl_markup', $lang, 'del');
        $link = "overlay_holder.php?overlay=true&delete_key={$item_key}&delete_val={$item_val}&lang=$lang&lboxreload=1&sf_conf=conf_mcd_deleterecord";
        echo "<li>";
        echo "<label>".getMarkup('cor_tbl_markup', $lang, 'delete')."</label>";
        echo "<a href=\"$link\" class=\"delimg colorbox\" title=\"$mk_title\" >";
        echo "<img src=\"$skin_path/images/recordnav/delete.png\" class=\"med\" />";
        echo "</a>\n";
        echo "</li>\n";

        // Change Item Mod Type
        // Only include this nav if the module is using types
        if ($modtype) {
            $mk_title = getMarkup('cor_tbl_markup', $lang, 'changemod');
            $link = "overlay_holder.php?overlay=true&item_key={$item_key}&$item_key={$item_val}&lang=$lang&lboxreload=1&sf_conf=conf_mcd_modtype";
            echo "<li>";
            echo "<label>".getMarkup('cor_tbl_markup', $lang, 'chgtype')."</label>";
            echo "<a href=\"$link\" class=\"recedit colorbox\" title=\"$mk_title\" >";
            echo "<img src=\"$skin_path/images/recordnav/edit.png\" class=\"med\" />";
            echo "</a>\n";
            echo "</li>\n";
        }

        // Change Item Value
        $mk_title = getMarkup('cor_tbl_markup', $lang, 'changeval');
        $link = "overlay_holder.php?overlay=true&item_key={$item_key}&$item_key={$item_val}&lang=$lang&lboxreload=1&reloadpage={$_SERVER['PHP_SELF']}&sf_conf=conf_mcd_itemval";
        echo "<li>";
        echo "<label>".getMarkup('cor_tbl_markup', $lang, 'chgkey')."</label>";
        echo "<a href=\"$link\" class=\"recedit colorbox\" title=\"$mk_title\" >";
        echo "<img src=\"$skin_path/images/recordnav/edit.png\" class=\"med\" />";
        echo "</a>\n";
        echo "</li>\n";

        echo "</ul>\n";
        echo "</div>\n";
        break;
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_itemadmin\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_itemadmin was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;
}

// clean up
unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($links);
unset ($alias_lang_info);

?>
