<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* data_entry/left_panel.php
*
* panel displayed on left of data_entry pages (setup in settings.php)
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
* @category   data_entry
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_entry/left_panel.php
* @since      File available since Release 0.6
*
* The left panel within the data entry area up to v0.7 has been used as a list of
* links to data entry pages links were defined in an array format in settings.php
*
* As of v0.8 the panel will be able to display 'subforms' which may be set on a
* conditional basis. The panel will continue to display links in v0.8 although this
* may become deprecated in v0.9
*
*/

// ---- COMMON ---- //
// get common elements

// Labels and so on
$datentlp_header = getMarkup('cor_tbl_markup', $lang, 'forms');

// ---- PROCESS ---- //
// discover which type of setup is being used
if (isset($data_entry_left_panel) && is_array($data_entry_left_panel)) {
    if (array_key_exists('subforms', $data_entry_left_panel)) {
        $delpoutput = 'subforms';
    } elseif (array_key_exists('href', $data_entry_left_panel[0])) {
        $delpoutput = 'linklist';
    }
} else {
    $delpoutput = 'err';
}

// This panel makes use of the $disp_cols variable. As this variable is already set up
// by the page, this needs to be saved elsewhere for the duration of this script and reset
// at the end
$cols_name_store = $disp_cols;
$cols_store = $$disp_cols;

// ---- OUTPUT ---- //

// output a header for the panel
print("<h1>$datentlp_header</h1>\n");

// OPTION 1 - OLD STYLE LINK LIST
// in this case, the link list is put into a subform wrapper and sf_linklist.php is called
// the link list is supplied as an array called $data_entry_left_panel
if ($delpoutput == 'linklist') {
    $sf_conf = 
        array(
            'sf_nav_type' => 'none',
            'sf_title' => 'linklist', 
            'sf_html_id' => 'linklist', // Must be unique
            'script' => 'php/subforms/sf_linklist.php',
            'op_label' => 'space',
            'op_input' => 'save',
            'op_modtype' => FALSE, //if each modtype uses same fields (see below)
            'fields' => $data_entry_left_panel
    );
    // fake up cols for the benefit of the sfNav func
    $disp_cols = 'fake_cols';
    $fake_cols[0]['subforms'][0]['sf_nav_type'] = $sf_conf['sf_nav_type'];
    $cur_col_id = 0;
    $cur_sf_id = 0;
    //set the sf state
    $sf_state = 'lpanel';
    //include the subform script
    include($sf_conf['script']);
    unset($sf_state);
    unset($disp_cols);
    unset($sf_conf);
}

// OPTION 2 - SUBFORMS
// in this case, the link list is put into a subform wrapper and sf_linklist.php is called
// The linkl list is supplied within the field of the subform sf_conf array
if ($delpoutput == 'subforms') {
    // set the left panel column as the disp cols for not unset below
    $disp_cols = 'fake_cols';
    // put the column into the fake cols array
    $fake_cols[] = $data_entry_left_panel;
    // This is always 0 in data entry as there is only a single col
    $cur_col_id = 0;
    // now loop over the sf's
    foreach ($data_entry_left_panel['subforms'] as $cur_sf_id => $sf_conf) {
        if (array_key_exists('op_condition', $sf_conf)) {
            if (chkSfCond($item_key, $$item_key, $sf_conf['op_condition'])) {
                //set the sf state
                $sf_state = 'lpanel';
                //include the subform script
                include($sf_conf['script']);
                unset ($sf_state);
                unset($sf_conf);
            }
        } else {
            //set the sf state
            $sf_state = 'lpanel';
            //include the subform script
            include($sf_conf['script']);
            unset ($sf_state);
            unset($sf_conf);
        }
    }
    unset($disp_cols);
}

// Error handling
if ($delpoutput == 'err') {
    echo "ADMIN ERROR: left_panel.php has revised settings from v0.8<br/>";
}

// Reset the DISP COLS
$disp_cols = $cols_name_store;
$$disp_cols = $cols_store;

?>
