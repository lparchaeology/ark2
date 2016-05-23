<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_itemnav.php
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
* @link       http://ark.lparchaeology.com/code/php/subforms/sf_itemnav.php
* @since      2.0
*/

// ---- SETUP ---- //

// Force a mod_short
$item_key = reqArkVar('item_key', $default_itemkey);
$item_val = $$item_key;
$mod_short = substr($item_key, 0, 3);

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

// Set up variables in case we don't set them later
$first_itemkey = FALSE;
$first_itemval = FALSE;
$prev_itemkey = FALSE;
$prev_itemval = FALSE;
$next_itemkey = FALSE;
$next_itemval = FALSE;
$last_itemkey = FALSE;
$last_itemval = FALSE;
$total_results = 0;
$current_result = 0;
$mk_result = 'Item';
// Set up navigation variables
// Use the result set
$item_loop = reqQst($_SESSION, 'results_array');
if (is_array($item_loop)) {
    $mk_result = 'Result';
    $total_results = count($item_loop);
    $first_itemval_arr = reset($item_loop);
    $first_itemkey = $first_itemval_arr['itemkey'];
    $first_itemval = $first_itemval_arr['itemval'];
    $last_itemval_arr = end($item_loop);
    $last_itemkey = $last_itemval_arr['itemkey'];
    $last_itemval = $last_itemval_arr['itemval'];
    //NEXT-PREV
    // Sort out the next and previous
    $key_of_item = $item_key.$item_val;
    $current_result = array_search($key_of_item, array_keys($item_loop)) + 1;
    // next
    arraySetCurrent($item_loop, $key_of_item);
    $next_itemval_arr = next($item_loop);
    $next_itemval = $next_itemval_arr['itemval'];
    $next_itemkey = $next_itemval_arr['itemkey'];
    // prev
    arraySetCurrent($item_loop, $key_of_item);
    $prev_itemval_arr = prev($item_loop);
    $prev_itemval = $prev_itemval_arr['itemval'];
    $prev_itemkey = $prev_itemval_arr['itemkey'];
} else {
    // Use the authitems
    if(!is_array($authitems)){
        $authitems = array();
    } else {
        $total_results = count($authitems[$item_key]);
        $first_itemval = $authitems[$item_key][0];
        $last_itemval = end($authitems[$item_key]);
        if ($item_val && array_key_exists($item_key, $authitems)) {
            //NEXT-PREV
            // Sort out the next and previous
            $key_of_item = array_search($item_val, $authitems[$item_key]);
            $current_result = $key_of_item + 1;
            // next
            arraySetCurrent($authitems[$item_key], $key_of_item);
            $next_itemval = next($authitems[$item_key]);
            // prev
            arraySetCurrent($authitems[$item_key], $key_of_item);
            $prev_itemval = prev($authitems[$item_key]);
        }
    }
    // keys the same
    $first_itemkey = $item_key;
    $prev_itemkey = $item_key;
    $next_itemkey = $item_key;
    $last_itemkey = $item_key;
}
// Wrap around if we're at the first or last item
if (!$prev_itemval) {
    $prev_itemval = $last_itemval;
}
if (!$next_itemval) {
    $next_itemval = $first_itemval;
}


// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
$mod_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $item_key, 1);

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
        if (!is_array($item_loop)) {
            echo sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
            // Module selector
            echo "<ul>\n";
            echo "<li>".mkModNav($modules, $item_key)."</li>\n";
            // Item jumper
            echo "<li>";
            echo "<div id=\"record_jumper\">\n";
            echo mkNavItem($search_mode, $mk_go, $item_key, '', $_SERVER['PHP_SELF'], FALSE);
            echo "</div>\n";
            echo "</li>";
        } else {
            echo "<ul>\n";
        }
        // Item nav buttons
        echo "<li><div>\n";
        echo "<ul id=\"record_nav\" class=\"record_nav\">\n";
        echo "<li>".dynLink('first', $first_itemkey, $first_itemval)."</li>\n";
        echo "<li>".dynLink('prev', $prev_itemkey, $prev_itemval)."</li>\n";
        $mk_refresh = getMarkup('cor_tbl_markup', $lang, 'refresh');
        echo "<li><a href=\"{$_SERVER['PHP_SELF']}?disp_reset=default&item_key=$item_key&$item_key=$item_val\" class=\"refresh\" title=\"$mk_refresh\"\"></a></li>\n";
        echo "<li>".dynLink('next', $next_itemkey, $next_itemval)."</li>\n";
        echo "<li>".dynLink('last', $last_itemkey, $last_itemval)."</li>\n";
        echo "</ul>\n";
        echo "</div></li>\n";
        echo "<li>$mk_result $current_result of $total_results</li>\n";
        echo "</ul>\n";
        echo "</div>\n";
        break;
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_itemnav\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_itemnav was incorrectly set</p>\n";
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
