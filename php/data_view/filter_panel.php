<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* data_view/filter_panel.php
*
* outputs the filter panel, used to choose and execute filters
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
* @category   data_view
* @package    ark
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_view/filter_panel.php
* @since      File available since Release 0.6
*
* NOTE: Filter mode $ftr_mode is requested at page level (arkVar - persists in sesh)
*
*/

//get the markup needed
$mk_filterpanel = getMarkup('cor_tbl_markup', $lang, 'filterpanel');
$mk_saveas = getMarkup('cor_tbl_markup', $lang, 'saveas');
$mk_filters = getMarkup('cor_tbl_markup', $lang, 'filters');
$mk_clearall = getMarkup('cor_tbl_markup', $lang, 'clearall');
$mk_rerunall = getMarkup('cor_tbl_markup', $lang, 'rerunall');

// redo
$mk_make_filter = getMarkup('cor_tbl_markup', $lang, 'make_filter');
$mk_ftx = getMarkup('cor_tbl_markup', $lang, 'ftx');
$mk_filteritem = getMarkup('cor_tbl_markup', $lang, 'filteritem');
$mk_filteratt = getMarkup('cor_tbl_markup', $lang, 'filteratt');
$mk_filterstecd = getMarkup('cor_tbl_markup', $lang, 'filterstecd');
$mk_filteractor = getMarkup('cor_tbl_markup', $lang, 'filteractor');
$mk_filterspan = getMarkup('cor_tbl_markup', $lang, 'filterspan');
$mk_publicfilters = getMarkup('cor_tbl_markup', $lang, 'publicfilters');
$mk_savedfilters = getMarkup('cor_tbl_markup', $lang, 'savedfilters');
$mk_your = getMarkup('cor_tbl_markup', $lang, 'your');

// MANUAL
$sf_key = FALSE;
$sf_val = FALSE;

// NAV for filters
// make up the nav
$ftr_mode_nav = mkFtrModeNav($ftr_mode);

// ---- PROCESS ---- //
// check to see if subforms are set up
if (isset($data_view_left_panel) && is_array($data_view_left_panel)) {
    // check for subforms (arbitrarily look for the basic ones)
    if (array_key_exists('basic_subforms', $data_view_left_panel)) {
        $dvlpoutput = 'subforms';
    } else {
        $dvlpoutput = 'old_style'; // pre ?1.0? the left panel used to... GH 30/7/12
    }
    // check to see if we need a drawer
    if (array_key_exists('op_dr_subforms', $data_view_left_panel)) {
        $dr_flag = 'on';
    } else {
        $dr_flag = FALSE;
    }
} else {
    $dvlpoutput = 'err';
    $dr_flag = FALSE;
}


// SEARCH CRITERIA
// set up a nav for the current live filters
$search_criteria = "Live Filters";


// SETUP SUBFORMS
// case specific
switch ($ftr_mode) {
    // BASIC
    case 'basic':
        // no subforms are used in the left panel
        $subforms = reqQst($_REQUEST, 'basic_subforms');
        break;
        
    // STANDARD
    case 'standard':
        // get the subforms to display for std mode
        if (array_key_exists('standard_subforms', $data_view_left_panel)) {
            $subforms = $data_view_left_panel['standard_subforms'];
        } else {
            $subforms = FALSE; // nothing will output to the panel for standard mode
        }
        break;
        
    // ADVANCED
    case 'advanced':
        // get the subforms to display for adv mode
        if (array_key_exists('adv_subforms', $data_view_left_panel)) {
            $subforms = $data_view_left_panel['adv_subforms'];
        } else {
            $subforms = FALSE; // nothing will output to the panel for advanced mode
        }
        break;
}

// TOOLBAR
// Make up the toolbar
$tools = "<ul id=\"ftr_options\">";
$tools .= "<li><a href=\"{$_SERVER['PHP_SELF']}?reset=1\" class=\"clear_ftr\" title=\"Clear all filters\">&nbsp;</a></li>";
$tools .= "<li><a href=\"{$_SERVER['PHP_SELF']}?runall=1\" class=\"refresh\" title=\"Rerun all filters\">&nbsp;</a></li>";
$tools .= "<li><a href=\"overlay_holder.php?sf_conf=userhome_my_saved_filters\" class=\"save dr_toggle\">&nbsp;</a></li>";
// end toolbar cleanly
$tools .= "</ul>";



// ---- OUTPUT ---- //
// START THE FILTER PANEL
echo "<div id=\"filter_panel\">";

// 1 of 4 - HEADER
echo "<h1>$mk_filterpanel</h1>";
// The tools are case specific
switch ($ftr_mode) {
    // BASIC
    case 'basic':
        // no tools are used in the left panel
        break;
        
    // STANDARD or // ADVANCED
    case 'standard':
    case 'advanced':
        echo "$tools";
        break;
}


// 2 of 4 - ACTIVE FILTERS
// this is a routine for active and complete filters
if ($filters) {
    // header (mimic a subform nav bar)
    echo "<div class=\"sf_nav\"><h4>$mk_filters</h4></div>\n";
    // start a <ul> list to hold the active filters
    echo "<ul id=\"active_filters\">\n";
    // The display of active filters will change depending on the filters view
    switch ($ftr_mode) {
    case 'basic':
        foreach ($filters as $ftr_id => $filter) {
            if (is_int($ftr_id)) {
                $ftype = $filter['ftype'];
                printf("<li class=\"active_filter\">");
                // display the relevant filter
                $func = 'dispFlt'.$ftype;
                $func($filter, $ftr_id);
                unset($func);
                printf("</li>\n");
            }
        }
        break;
        
    case 'standard':
        foreach ($filters as $ftr_id => $filter) {
            if (is_int($ftr_id)) {
                $ftype = $filter['ftype'];
                printf("<li class=\"active_filter\">");
                // display the relevant filter
                $func = 'dispFlt'.$ftype;
                $func($filter, $ftr_id);
                unset($func);
                printf("</li>\n");
            }
        }
        break;
        
    case 'advanced':
        // this flag prevents printing of set operator on the first filter
        $flag = FALSE;
        foreach ($filters as $ftr_id => $filter) {
            if (is_int($ftr_id)) {
                if ($flag) {
                    // display the set operator
                    $set_operator_nav = '<li class="set_operator">';
                    $set_operator_nav .= dispSetOperator($filter, $ftr_id);
                    $set_operator_nav .= '</li>';
                    echo "$set_operator_nav";
                }
                $flag = TRUE;
                $ftype = $filter['ftype'];
                printf("<li class=\"active_filter\">");
                // display the relevant filter
                $func = 'dispFlt'.$ftype;
                $func($filter, $ftr_id);
                unset($func);
                printf("</li>\n");
            }
        }
        break;
    }
    // end list of active filters
    echo "</ul>\n";
} else {
    // header (could change the header to say "No filters" or similar)
    echo "<div class=\"sf_nav\"><h4>$mk_filters</h4></div>\n";
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




// 3 of 4 - SUBFORMS
// as per config
// loop over any subforms that have been set up for this panel (dvlp)
if ($dvlpoutput == 'subforms' && $ftr_mode != 'basic') {
    // set the left panel column as the disp cols for not unset below
    $disp_cols = 'fake_cols';
    // put the current SFs into the 'subforms' key of the array (for sfNav)
    $data_view_left_panel['subforms'] = $subforms;
    // put the column into the fake cols array
    $fake_cols[] = $data_view_left_panel;
    // The column still needs a col_id
    $cur_col_id = 0;
    // now loop over the sf's
    foreach ($subforms as $cur_sf_id => $sf_conf) {
        if (array_key_exists('op_condition', $sf_conf)) {
            if (chkSfCond(FALSE, FALSE, $sf_conf['op_condition'])) {
                //set the sf state
                $sf_state = 'lpanel';
                //include the subform script
                include($sf_conf['script']);
                unset($sf_state);
                unset($sf_conf);
            }
        } else {
            //set the sf state
            $sf_state = 'lpanel';
            //include the subform script
            include($sf_conf['script']);
            unset($sf_state);
            unset($sf_conf);
        }
    }
    unset($disp_cols);
}


// 4 of 4 - Navigation to other ftr_modes
// Temporary place holder to change views
echo "$ftr_mode_nav";

// Error handling
if ($dvlpoutput == 'err') {
    echo "ADMIN ERROR: filter_panel.php has revised settings from v0.9<br/>";
}

// Close out the panel
echo "</div>";

// LPANEL DRAWER - optional in lpanel conf (op_dr_subforms)
if ($dr_flag && $ftr_mode != 'basic') {
    // Make up drawer
    // (actually a child of the lpanel itself)
    echo "<div id=\"drawer_1\" class=\"dr\">";
    echo "<h1>Save/Saved";
    echo "<a href=\"#\" class=\"dr_toggle\">[<<]</a></h1>";
    // This is a routine for saving a filterset
    $sv = FALSE;
    if ($filters) {
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
    // as per config
    $dr_subforms = $data_view_left_panel['op_dr_subforms'];
    // loop over any subforms that have been set up for this drawer (dvdr)
    // set the drawer column as the disp cols for now - unset below
    $disp_cols = 'fake_cols';
    // put the current SFs into the 'subforms' key of the array (for sfNav)
    $data_view_left_panel['subforms'] = $dr_subforms;
    // put the column into the fake cols array
    $fake_cols[] = $data_view_left_panel;
    // The column still needs a col_id
    $cur_col_id = 0;
    // now loop over the sf's
    foreach ($dr_subforms as $cur_sf_id => $sf_conf) {
        if (array_key_exists('op_condition', $sf_conf)) {
            if (chkSfCond(FALSE, FALSE, $sf_conf['op_condition'])) {
                //set the sf state
                $sf_state = 'lpanel';
                //include the subform script
                include($sf_conf['script']);
                unset($sf_state);
                unset($sf_conf);
            }
        } else {
            //set the sf state
            $sf_state = 'lpanel';
            //include the subform script
            include($sf_conf['script']);
            unset($sf_state);
            unset($sf_conf);
        }
    }
    unset($disp_cols);
    echo "</div>";
}


// ---- CLEAN UP ---- //
unset($subforms);

?>
