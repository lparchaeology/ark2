<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_frame.php
*
* pseudo subform for nesting subforms
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
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_xmi.php
* @since      File available since Release 0.7
*
*
* NOTE 1: This acts as a container for subforms. It is handled exactly like any
* other subform by the column handling functions within the page. When called, it
* will expect an sf_conf containing nested sf_confs. It will then behave a bit 
* like a column, looping over the subforms and displaying them as appropriate.
* The subforms will be displayed without any naviagtional tools or title which
* will be displayed at the top of the frame. This is effectively a way to group
* subforms together for display and user interface purposes. Changes to the edit
* status will be passed down to the child subforms as a group.
*
* NOTE 2: This form also permits conditional display of subforms. This frame checks
* a condition to decide whether to display the form. In future versions of ARK this
* may be handled by JS. This script loops over an array of subforms checking the
* condition and deciding to display the sf. Conditions are either set or not in
* the sf_conf of the individual child sf's.
*
*/


// ---- SETUP ---- //
// Set a switch to indicate to subforms that they are in a frame (they may hook into this var)
$sf_frame_used = TRUE;


// -- OPTIONS -- //
// op_sf_cssclass
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}
if (array_key_exists('op_sfrm_cssclass', $sf_conf)) {
    $sfrm_cssclass = $sf_conf['op_sfrm_cssclass'];
} else {
    $sfrm_cssclass = 'frm_subform';
}
// configure the wrapped SFs
foreach ($sf_conf['subforms'] as $key => $sf) {
    // force all child sf's to have no title bars/navigation
    $sf_conf['subforms'][$key]['sf_nav_type'] = 'none';
    // force all child sf's to have no title bars/navigation
    $sf_conf['subforms'][$key]['op_sf_cssclass'] = $sfrm_cssclass;
    // force all child sf's to be set to the same edit state as the frame itself
    $sf_conf['subforms'][$key]['edit_state'] = $sf_conf['edit_state'];
}


// -- MARKUP -- //
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);


// ---- PROCESS ---- //
// This form doesnt submit data to the database
// Handle requests to change the edit state to the child subforms


// ---- STATE SPECFIC OUTPUT
// for each state get specific elements and then produce output

switch ($sf_state) {
    // MIN views
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        // Temporarily suspend the dynamic columns until the frame is over (see EoF)
        $temp_cols = $$disp_cols;
        // Temporarily set the cur_col_id to zero until frame is over (see EoF)
        $temp_cur_col_id = $cur_col_id;
        $cur_col_id = 0;
        // Make up a fake column
        $fake_cols =
            array(
                array(
                    'col_id' => 'fake',
                    'subforms' => $sf_conf['subforms']
            )
        );
        print("<div id=\"{$sf_conf['sf_html_id']}_frame\" class=\"{$sf_cssclass}\">\n");
        // Print the navigation bar only
        // put in the navigation bar
        if ($sf_title) {
            print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        }
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        $$disp_cols = $fake_cols;
        print("</div>\n\n");
        break;
        
    // MAX Views
    case 'p_max_view': 
    case 's_max_view':
    // ENTER and EDIT VIEW
    case 'p_max_edit':
    case 'p_max_ent':
    case 's_max_edit':
    case 's_max_ent':
        print("<div id=\"{$sf_conf['sf_html_id']}_frame\" class=\"{$sf_cssclass}\">\n");
        // put in the navigation bar
        if ($sf_title) {
            print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        }
        // Temporarily suspend the dynamic columns until the frame is over (see EoF)
        $temp_cols = $$disp_cols;
        // Temporarily set the cur_col_id to zero until frame is over (see EoF)
        $temp_cur_col_id = $cur_col_id;
        $cur_col_id = 0;
        // Make up a fake column
        $fake_cols =
            array(
                array(
                    'col_id' => $cur_col_id,
                    'col_type' => $temp_cols[$temp_cur_col_id]['col_type'],
                    'subforms' => $sf_conf['subforms']
            )
        );
        $$disp_cols = $fake_cols;
        // Loop over the subforms in this frame
        foreach ($sf_conf['subforms'] as $cur_sf_id => $sf) {
            if (array_key_exists('op_condition', $sf)) {
                if (chkSfCond($item_key, $$item_key, $sf['op_condition'])) {
                    $col_type = $temp_cols[$temp_cur_col_id]['col_type'];
                    $sf_state = 
                        getSfState(
                            $col_type,
                            $sf['view_state'],
                            $sf['edit_state']
                    );
                    $sf_conf_temp = $sf_conf;
                    $sf_conf = $sf;
                    include($sf['script']);
                    unset ($sf_state);
                    unset ($col_type);
                    unset($sf);
                    unset($sf_conf);
                    $sf_conf = $sf_conf_temp;
                }
            } else {
                $col_type = $temp_cols[$temp_cur_col_id]['col_type'];
                $sf_state = 
                    getSfState(
                        $col_type,
                        $sf['view_state'],
                        $sf['edit_state']
                );
                $sf_conf_temp = $sf_conf;
                $sf_conf = $sf;
                include($sf['script']);
                unset ($sf_state);
                unset ($col_type);
                unset($sf);
                unset($sf_conf);
                $sf_conf = $sf_conf_temp;
            }
        }
        print("</div>\n\n");
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_frame\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for the sf_frame subform was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
} // ends switch

// tidy up
unset ($sf_conf);
unset ($elem);
unset ($sf_state);
unset ($fields);
// make the temp cols dynamic again
$$disp_cols = $temp_cols;
$cur_col_id = $temp_cur_col_id;
unset($temp_cols);
// unset the frame in use switch
unset($sf_frame_used);

?>
