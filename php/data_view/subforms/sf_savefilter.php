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
* @link       http://ark.lparchaeology.com/svn/php/data_view/subforms/sf_savefilter.php
* @since      File available since Release 2.0
*/

// LPANEL DRAWER - optional in lpanel conf (op_dr_subforms)
if ($ftr_mode != 'basic') {
    // Make up drawer
    // (actually a child of the lpanel itself)
    echo "<div id=\"drawer_1\" class=\"dr\">";
    echo "<h1>Save/Saved";
    echo "<a href=\"#\" class=\"dr_toggle\">[<<]</a></h1>";
    // This is a routine for saving a filterset
    $sv = FALSE;
    if ($filters) {
        $mk_saveas = getMarkup('cor_tbl_markup', $lang, 'saveas');
        // make the save filter form
        $sv = "<ul><li id=\"save_ftr\">";
        $sv .= "<label>$mk_saveas</label>";
        // save a filterset
        $sv .= dispSaveOp('set', 'data_view.php');
        // close out cleanly
        $sv .= "</li></ul>";
        // DEV NOTE: this is only in a list for CSS convenience
        // DEV NOTE: check user perms for save rights
    }
    echo "$sv";

    // SUBFORMS
    $sf_conf_store = $sf_conf;
    // now loop over the sf's
    foreach ($sf_conf['subforms'] as $cur_sf_id => $sf_conf) {
        if (array_key_exists('op_condition', $sf_conf)) {
            if (chkSfCond($item_key, $$item_key, $sf_conf['op_condition'])) {
                //include the subform script
                include($sf_conf['script']);
            }
        } else {
            //include the subform script
            include($sf_conf['script']);
        }
    }
    $sf_conf = $sf_conf_store;
    echo "</div>";
}

?>
