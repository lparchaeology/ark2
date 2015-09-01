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
if (isset($user_home_left_panel) && is_array($user_home_left_panel)) {
    if (array_key_exists('subforms', $user_home_left_panel)) {
        $leftpanelmode = 'subforms';
    } elseif (array_key_exists('href', $user_home_left_panel[0])) {
        $leftpanelmode = 'linklist';
    }
} else {
    $leftpanelmode = 'err';
}

switch ($leftpanelmode){
	case 'subforms':
	    print '<div class="leftpanelwrapper">';
        // Left Panel is only ever one column
	    $cur_col_id = 0;
	    foreach ($user_home_left_panel['subforms'] as $cur_sf_id => $subform){
	       // set the sf_state
	           $sf_state = getSfState(
	                   'left_lanel',
	                   $subform['view_state'],
	                   $subform['edit_state']
                );
	            // set the sf_conf
	            $sf_conf = $subform;
	            // if the sf is conditional
	            if (array_key_exists('op_condition', $subform)) {
	                // check the condition
                    if (chkSfCond($item_key, $$item_key, $subform['op_condition'])) {
	                   include($subform['script']);
	                   }
	            } else {
	                include($subform['script']);
	            }
	            // cleanup this sf
	            unset($sf_state);
	            unset($subform);

	        }	   
	    print '</div>';
	    
	    break;
	case 'linklist':
	    

// ---- OUTPUT ---- //

// output a header for the panel
?>
        
            <div class="menubtn"><a href="#">Quick Add</a></div>
            <nav class="sidemenu">
                <div class="prompt">Add a New&hellip;</div>
                <?php include('php/subforms/sf_modulelist.php') ?>
            </nav>
            <?php include('php/subforms/sf_profilepane.php') ?>
        </div>
<?php 
        break;
    case 'err':
    default:
        echo "\$data_entry_left_panel is not set correctly";
}
?>
