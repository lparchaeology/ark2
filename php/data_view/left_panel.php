<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* user_home/left_panel.php
*
* left panel in user home page
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
* @category   user
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/user_home/left_panel.php
* @since      File available since Release 0.6
*/

// Labels and so on
$mk_user_home = getMarkup('cor_tbl_markup', $lang, 'user_home');
    
// ---- PROCESS ---- //
// discover which type of setup is being used
if (isset($data_entry_left_panel) && is_array($data_entry_left_panel)) {
    if (array_key_exists('subforms', $data_entry_left_panel)) {
        $leftpanelmode = 'subforms';
    } elseif (array_key_exists('href', $data_entry_left_panel[0])) {
        $leftpanelmode = 'linklist';
    }
} else {
    $leftpanelmode = 'err';
}

// This panel makes use of the $disp_cols variable. As this variable is already set up
// by the page, this needs to be saved elsewhere for the duration of this script and reset
// at the end
$cols_name_store = $disp_cols;
$cols_store = $$disp_cols;

switch($leftpanelmode) {
    case 'subforms' :
        print "<div class=\"leftpanelwrapper\">";
        // set the left panel column as the disp cols for not unset below
        $disp_cols = 'fake_cols';
        // put the column into the fake cols array
        $fake_cols[] = $data_entry_left_panel;
        // This is always 0 in data entry as there is only a single col
        $cur_col_id = 0;
        // now loop over the sf's
        foreach ( $data_entry_left_panel['subforms'] as $cur_sf_id => $sf_conf ) {
            if (array_key_exists('op_condition', $sf_conf)) {
                if (chkSfCond($item_key, $$item_key, $sf_conf['op_condition'])) {
                    // set the sf state
                    $sf_state = 'lpanel';
                    // include the subform script
                    include ($sf_conf['script']);
                    unset($sf_state);
                    unset($sf_conf);
                }
            } else {
                // set the sf state
                $sf_state = 'lpanel';
                // include the subform script
                include ($sf_conf['script']);
                unset($sf_state);
                unset($sf_conf);
            }
        }
        unset($disp_cols);
        print "</div>";
        break;
	case 'linklist':
	    

// ---- OUTPUT ---- //

// output a header for the panel
?>

<div class="menubtn">
	<a href="#">Quick Add</a>
</div>
<nav class="sidemenu">
	<div class="prompt">Add a New&hellip;</div>
                <?php include('php/subforms/sf_modulelist.php') ?>
            </nav>
<div class="userprofile">
                <?php include('php/subforms/sf_profilepane.php') ?>
            </div>
</div>
<?php 
        break;
    case 'err':
    default:
        echo "\$data_entry_left_panel is not set correctly";
}

// Reset the DISP COLS
$disp_cols = $cols_name_store;
$$disp_cols = $cols_store;

?>
