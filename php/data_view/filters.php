<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* data_view/filters.php
*
* executes filters
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
* @link       http://ark.lparchaeology.com/svn/php/data_view/filters.php
* @since      File available since Release 0.6
*
* pulls the user strings, handles filters, calls the relevant filter functions makes
* an ARK standard results array
*
* sets the var $filters_exec to 'on' or 'off' according to whether any filters are on
*
*/

// Include the Functions
include_once ('php/filter_functions.php');

// Get filters from session
$filters = reqQst($_SESSION, 'filters');

// Get results from session
$results_array = reqQst($_SESSION, 'results_array');

// set flag to false
$new_ftr_added = FALSE;

// ---- PRE PROCESS ---- //

// RESET FILTERS
// Handle reset requests
$reset = reqQst($_REQUEST, 'reset');
if ($reset) {
    unset($_SESSION['filters']);
    $filters = FALSE;
    unset($_SESSION['results_array']);
    $results_array = FALSE;
}


// ADDING FILTERS
// 1 - Manualy building filters
// incomplete filters are as of v0.9 added to the filters array (but not run)
// any adding or editing must now refer to the relevant filter id
// NEW FILTERS
// $ftype is the command that calls the function builder command
$ftr_id = reqQst($_REQUEST, 'ftr_id');
$ftype = reqQst($_REQUEST, 'ftype');
if ($filters && $ftr_id){
    if (!$ftype && array_key_exists($ftr_id, $filters)) {
        // try setting it from an existing filter
        $ftype = $filters[$ftr_id]['ftype'];
    }
}

// if needed call the relevant filter building function
if ($ftr_id && $ftype) {
    // if filters array doesn't exist yet, it is needed now
    if (!isset($filters) or !is_array($filters)) {
        $filters = array();
    }
    $num_ftrs = countFilters($filters);
    $func = 'buildFlt'.$ftype;
    $filters = $func($filters, $_REQUEST);
    unset($func);
    // Test to see if a new filter has been added or not
    if (countFilters($filters) > $num_ftrs) {
        // set the flag to run the new filter against the old results (case 1)
        $new_ftr_added = TRUE;
    }
}

// 2 - Retrieving filtersets
$retftrset = reqQst($_REQUEST, 'retftrset');
if ($retftrset) {
    // force a rerun of all filters
    unset($_SESSION['results_array']);
    $results_array = FALSE;
    // clean out any old filters
    unset($filters);
    // set up the new filters
    $filters = getFtr($retftrset);
}


// EDITING FILTERS
// not yet built


// Handle filter del requests
$resetftr = explode('_', reqQst($_REQUEST, 'resetftr'));
if (isset($resetftr[1])) {
    // unset filter
    $resetftr = $resetftr[1];
    unset($filters[$resetftr]);
    // force a rerun of all filters
    unset($_SESSION['results_array']);
    $results_array = FALSE;
    // if this is the last filter, turn off the lights
    $filters_still_present = FALSE;
    foreach ($filters as $key => $filter) {
        if (is_numeric($key)) {
            $filters_still_present = TRUE;
        }
    }
    if (!$filters_still_present) {
        $filters = FALSE;
    }
}


// SAVE to session
// Save the filters back to the session
if (isset($filters)) {
    $_SESSION['filters'] = $filters;
}


// FORCE RERUN
// Handle request to rerun all filters
$runall = reqQst($_REQUEST, 'runall');
// also flag up changes to the view (filters.php will rerun the filters if this is set)
$view_test = reqQst($_REQUEST, 'view');
if ($runall || $view_test) {
    unset($_SESSION['results_array']);
    $results_array = FALSE;
}


// SORT ORDER
// handle user sort order requests
$sort_type = reqQst($_REQUEST, 'sort_type');
$sort_field = reqQst($_REQUEST, 'sort_field');
if ($sort_type && $sort_field) {
    $sort_order['sort_order'] =
        array(
            'sort_type' => $sort_type,
            'sort_field' => $sort_field
    );
    // this puts the sort order to the beginning of the filters array
    $filters = $sort_order + $filters;
    $_SESSION['filters'] = $filters;
} else {
    if (is_array($filters)) {
        if (!array_key_exists('sort_order', $filters)) {
            $sort_order['sort_order'] = FALSE;
            // this puts the sort order to the beginning of the filters array
            $filters = $sort_order + $filters;
        }
    }
}
// change existing sort order directives
if ($filters['sort_order']) {
    if ($sort_type) {
        $filters['sort_order']['sort_type'] = $sort_type;
        $_SESSION['filters'] = $filters;
    }
}


// SET OPERATOR CHANGES
// handle user set operator change requests
$chg_set_op = reqQst($_REQUEST, 'chg_set_op');
$chg_ftr_id = reqQst($_REQUEST, 'chg_ftr_id');
if ($chg_set_op && $chg_ftr_id) {
    $filters[$chg_ftr_id]['set_operator'] = $chg_set_op;
    $_SESSION['filters'] = $filters;
    // force a rerun of the filters
    unset($_SESSION['results_array']);
    $results_array = FALSE;
}


// DISPLAY OPTION CHANGES
// handle user set display change requests
$op_display = reqQst($_REQUEST, 'op_display');
$ftr_id = reqQst($_REQUEST, 'ftr_id');
if ($op_display && $ftr_id) {
    $filters[$ftr_id]['op_display'] = $op_display;
    $_SESSION['filters'] = $filters;
}


// TRAVERSE TO ITEM CHANGES
// handle user traverse to requests
if (array_key_exists('trav_to', $_REQUEST)) {
    $chg_trav_to = 1;
    $trav_to = reqArkVar('trav_to',FALSE);
} else {
    $chg_trav_to = FALSE;
    $trav_to = FALSE;
}
if ($filters) {
    // make sure that something is always set up
    if (!array_key_exists('traverse_to', $filters)) {
        // handle a default, unless something has actually been sent via qstr
        if (!$chg_trav_to) {
            if (isset($conf_dv_traverse_to)) {
                $trav_to = $conf_dv_traverse_to;
            }
        }
        // this puts the traverse_to directive to the beginning of the filters array
        $trav_info['traverse_to'] = $trav_to;
        $filters = $trav_info + $filters;
        $_SESSION['filters'] = $filters;
    }
    // change existing sort order directives
    if ($chg_trav_to) {
        $filters['traverse_to'] = $trav_to;
        $_SESSION['filters'] = $filters;
        // now force a rerun
        unset($_SESSION['results_array']);
        $results_array = FALSE;
    }
    // finally, set the global scope var to match the currently set filter
    $traverse_to = $filters['traverse_to'];
}

// ---- RUN FILTERS ---- //
// As of v0.9, only numerically IDed filters will be run
// NB this test for filters will return false if:
//  1 - Filters is not set
//  2 - Filters is an empty array which is possible
if ($filters) {
    // 1 - run last aginst existing $results_array (ONLY IN CASE OF NEW FILTER)
    if ($results_array && $new_ftr_added) {
        // rename the results array
        $old_results_array = $results_array;
        $results_array = FALSE;
        // get the last filter in the array
        $filter = end($filters);
        $ftr_id = key($filters);
        if (is_int($ftr_id)) {
            $ftype = $filter['ftype'];
            // run the relevant filter
            $func = 'execFlt'.$ftype;
            $new_results_array = $func($filter);
            unset($func);
            $oride_page = TRUE;
            if ($new_results_array && $old_results_array) {
                $set_operator_func = 'res'.$filter['set_operator'];
                $results_array =
                    $set_operator_func(
                        $new_results_array,
                        $old_results_array
                );
            }
        }
    }
    // 2 - run all
    if (!$results_array) {
        foreach ($filters as $ftr_id => $filter) {
            if (is_int($ftr_id)) {
                $ftype = $filter['ftype'];
                // run the relevant filter
                $func = 'execFlt'.$ftype;
                if ($results_array && $new_res = $func($filter)) {
                    $set_operator_func = 'res'.$filter['set_operator'];
                    $results_array =
                        $set_operator_func(
                            $new_res,
                            $results_array
                    );
                } else {
                    $results_array = $func($filter);
                }
                unset($func);
                $oride_page = TRUE;
            }
        }
    }
    // 3 - flag the fact that something was run (result set may be empty)
    $filters_exec = 'on';
    // 4 - Sort Results
    if ($filters['sort_order']) {
        $sort_field = $filters['sort_order']['sort_field'];
        // retrieve the field on which the search is to be performed (check on it carefully)
        // config failsafe
        if (!isset($$sort_field)) {
            // look for it in the module settings
            foreach ($loaded_modules as $key => $mod) {
                include('config/mod_'.$mod.'_settings.php');
            }
        }
        if (isset($$sort_field)) {
            $temp_col['fields'] = $$sort_field;
            $col = resTblTh($temp_col, 'silent');
            foreach ($results_array as $key => $res) {
                $sort_criterium = resTblTd($col['fields'], $res['itemkey'], $res['itemval']);
                $results_array[$key]['sort_on'] = $sort_criterium;
            }
            $results_array = sortResArr($results_array, $filters['sort_order']['sort_type'], 'sort_on');
        } else {
            echo "ADMIN ERROR: Field '$sort_field' cannot be found.";
        }
    }
    // 5 - Save the results back to the session
    $_SESSION['results_array'] = $results_array;
}

// ---- POST PROCESS ---- //

// SAVING/DELETING FILTERS IN THE DB

// Handle request to save filters
$nname = reqQst($_REQUEST, 'nname');
$saveftr = reqQst($_REQUEST, 'saveftr');
$publicftr = reqQst($_REQUEST, 'publicftr');
$prvftr = reqQst($_REQUEST, 'prvftr');

// save a filterset
if ($saveftr && $saveftr == 'set' && $nname) {
    $s_ftr = $filters;
    $ret = addFtr($s_ftr, 'set', $nname, 0, $user_id);
}

// save a single filter
if ($saveftr && $saveftr != 'set' && $nname) {
    $saveftr = substr(reqQst($_REQUEST, 'saveftr'), 3);
    $s_ftr = $filters[$saveftr];
    $ret = addFtr($s_ftr, 'single', $nname, 0, $user_id);
}

// Handle requests to make filters public
// test to see if this user has the required perms
if (!isset($ftr_admin_grps)) {
    echo 'As of v0.7 admins must set up an array $ftr_admin_grps see trac ticket #104<br/>';
}
$int = array_intersect($ftr_admin_grps, $_SESSION['sgrp_arr']);
if(!empty($int)) {
    $is_an_admin = TRUE;
}else {
    $is_an_admin = FALSE;
}
if ($is_an_admin && $publicftr) {
    // get a fresh copy of the filter from the db as we dont want to change it
    $copy_ftr = getFtr($publicftr);
    // run the edit
    $ret = edtFtr($copy_ftr, $copy_ftr['nname'], 3, $publicftr);
}
// Handle requests to make filters private
// test to see if this user has the required perms
if ($is_an_admin && $prvftr) {
    // get a fresh copy of the filter from the db as we dont want to change it
    $copy_ftr = getFtr($prvftr);
    // run the edit
    $ret = edtFtr($copy_ftr, $copy_ftr['nname'], 0, $prvftr);
}

// Handle request to del filters
$delftr = reqQst($_REQUEST, 'delftr');
if ($delftr) {
    // del the filter
    delFtr($delftr);
}

?>
