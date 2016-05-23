<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* common/page_nav.php
*
* Standard Page <nav> panel
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
* @category   user
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2016 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/common/page_nav.php
* @since      2.0
*/

$nav_layout = $page_conf->layout($mod_short, 'page_nav');

// ---- PROCESS ---- //

// This panel makes use of the $disp_cols variable. As this variable is already set up
// by the page, this needs to be saved elsewhere for the duration of this script and reset
// at the end
if (isset($disp_cols)) {
    $cols_store = $disp_cols;
}
if (isset($cur_col_id)) {
    $cols_id_store = $cur_col_id;
}

// ---- OUTPUT ---- //

echo '<!-- BEGIN leftpanel -->';
// TODO Change to HTML5 <nav> with new id/class
echo '<div id="lpanel" class="leftpanel">';

// output a header for the panel
if ($nav_layout->markup()) {
    echo '<h1>'.getMarkup('cor_tbl_markup', $lang, $nav_layout->markup()).'</h1>';
}
echo '<div class="leftpanelwrapper">';

// set the left panel column as the disp cols for not unset below
$disp_cols = 'fake_cols';
// put the column into the fake cols array
$fake_cols = $nav_layout->config()['columns'];
// The column still needs a col_id
$cur_col_id = 0;
// now loop over the sf's
foreach ($fake_cols[$cur_col_id]['subforms'] as $cur_sf_id => $sf_conf) {
    //set the sf state
    $sf_state = 'lpanel';
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
unset($sf_state);
echo '</div>'; // leftpanelwrapper
echo '</div>'; // leftpanel

// Reset the DISP COLS
if (isset($cols_store)) {
    $disp_cols = $cols_store;
} else {
    unset($disp_cols);
}
if (isset($cols_id_store)) {
    $cur_col_id = $cols_id_store;
} else {
    unset($cur_col_id);
}

?>
