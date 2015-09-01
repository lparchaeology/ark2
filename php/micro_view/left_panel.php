<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* micro_view/left_panel.php.php
*
* left panel for micro view
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
* @category   base
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Henriette Roued Olsen <henriette@roued.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/micro_view/left_panel.php
* @since      File available since Release 0.6
*/

// ---- COMMON ---- //
// turn off the minimiser (which is set globally) on this micro_view
$minimiser = FALSE;


// Labels and so on
$mk_microview = getMarkup('cor_tbl_markup', $lang, 'micro_view_forms');
$mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
$alias =
    getAlias(
        'cor_tbl_module',
        $lang,
        'itemkey',
        $item_key,
        1
);


// ---- PROCESS ---- //
// discover which type of setup is being used
if (isset($micro_view_left_panel) && is_array($micro_view_left_panel)) {
    if (array_key_exists('subforms', $micro_view_left_panel)) {
        $mvlpoutput = 'subforms';
    } elseif (array_key_exists('href', $micro_view_left_panel[0])) {
        $mvlpoutput = 'linklist';
    }
} else {
    $mvlpoutput = 'err';
}

// This panel makes use of the $disp_cols variable. As this variable is already set up
// by the page, this needs to be saved elsewhere for the duration of this script and reset
// at the end
$cols_store = $disp_cols;
if (isset($cur_col_id)) {
    $cols_id_store = $cur_col_id;
}

// ---- OUTPUT ---- //

// output a header for the panel
echo "<h1>$mk_microview</h1>";

// OPTION 1 - OLD STYLE LINK LIST
// in this case, the link list is put into a subform wrapper and sf_linklist.php is called
// the link list is supplied as an array called $data_entry_left_panel
if ($mvlpoutput == 'linklist') {
    $sf_conf = 
        array(
            'sf_nav_type' => 'none',
            'sf_title' => 'linklist', 
            'sf_html_id' => 'linklist', // Must be unique
            'script' => 'php/subforms/sf_linklist.php',
            'op_label' => 'space',
            'op_input' => 'save',
            'op_modtype' => FALSE, //if each modtype uses same fields (see below)
            'fields' => $micro_view_left_panel
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
if ($mvlpoutput == 'subforms') {
    // set the left panel column as the disp cols for not unset below
    $disp_cols = 'fake_cols';
    // put the column into the fake cols array
    $fake_cols[] = $micro_view_left_panel;
    // The column still needs a col_id
    $cur_col_id = 0;
    // now loop over the sf's
    foreach ($micro_view_left_panel['subforms'] as $cur_sf_id => $sf_conf) {
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
if ($mvlpoutput == 'err') {
    echo "ADMIN ERROR: left_panel.php has revised settings from v0.8<br/>";
}

// Reset the DISP COLS
$disp_cols = $cols_store;
if (isset($cols_id_store)) {
    $cur_col_id = $cols_id_store;
}

?>
