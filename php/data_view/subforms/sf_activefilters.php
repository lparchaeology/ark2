<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_view/subforms/sf_activefilters.php
*
* a data_view subform for showing active filters
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
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_view/subforms/sf_activefilters.php
* @since      File available since Release 2.0
*/

// ---- SETUP ---- //

$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

// ---- OUTPUT ---- //

echo sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);

// Set up if in micro_view_left_panel
if (!isset($filters)) {
    $filters = reqQst($_SESSION, 'filters');
}
if ($filters) {
    // start a <ul> list to hold the active filters
    echo "<ul id=\"active_filters\">\n";
    // this flag prevents printing of set operator on the first filter
    $show_set_op = FALSE;
    foreach ($filters as $ftr_id => $filter) {
        if (is_int($ftr_id)) {
            if ($ftr_mode == 'advanced' && $show_set_op) {
                // display the set operator
                echo '<li class="set_operator">'.dispSetOperator($filter, $ftr_id).'</li>';
            }
            $show_set_op = TRUE;
            echo "<li class=\"active_filter\">";
            // display the relevant filter
            $func = 'dispFlt'.$filter['ftype'];
            $func($filter, $ftr_id);
            echo "</li>\n";
        }
    }
    unset($func);
    unset($show_set_op);
    // end list of active filters
    echo "</ul>\n";
} else {
    // if there are no filters display a message
    if (!$filters and !isset($_SESSION['temp_ftr'])) {
        // feedback
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
    }
}

?>
