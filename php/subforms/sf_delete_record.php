<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_linklist.php
*
* global subform for lists of links
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_txt.php
* @since      File available since Release 0.6
*/

// ---- SETUP ---- //

// ALL MODES - IMPORTANT The user MUST pre-arm this form
$armed = reqQst($_REQUEST, 'armed');
if ($armed != $sf_conf['sf_html_id']) {
    $armed = FALSE;
}
// This form needs to know where to send users for conflict resolution
if (array_key_exists('conflict_res_sf', $sf_conf)) {
    $conflict_res_sf = $sf_conf['conflict_res_sf'];
} else {
    $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_noconflictres');
}

// OVERLAY MODE
if ($sf_state == 'overlay') {
    // set up anything that is needed
    // a distinctive key val pair
    $delete_key = reqQst($_REQUEST, 'delete_key');
    $delete_val = reqQst($_REQUEST, 'delete_val');
    $overlay = TRUE;
    // KEY VAL CHECK
    if (!$delete_key) {
        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_nodelkey');
    }
    if (!$delete_val) {
        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_nodelval');
    }
}

// NORMAL MODES
if (!isset($transclude) && !isset($overlay)) {
    // a distinctive key val pair
    $delete_key = reqQst($_REQUEST, 'delete_key');
    $delete_val = reqQst($_REQUEST, 'delete_val');
}

// FIELDS
// The default for modules with several modtypes is to have one field list,
// which is the same for all the differnt modtypes
// If you want to use different field lists for each modtype add to the subform
// settings 'op_modtype'=> TRUE and instead of 'fields' => array( add
// 'type1_fields' => array( for each type. 
if (array_key_exists('op_modtype', $sf_conf)) {
    $modtype = $sf_conf['op_modtype'];
} else {
    $modtype = FALSE;
}
// If modtype is FALSE the fields will only come from one list , if TRUE the 
// fields will come from different field lists. 
if (chkModType($mod_short) && $modtype!=FALSE) {
    $modtype = getModType($mod_short, $sf_val);
    $fields = $sf_conf["type{$modtype}_fields"];
} else {
    $fields = $sf_conf['fields'];
}

// CSS
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// Get the data for the record
$record =
    array(
        'itemkey' => $delete_key,
        'itemvalue' => $delete_val,
        'data' => 0,
);
// if there are frags, get the chained data
if ($data_chains = getChData(FALSE, $delete_key, $delete_val, FALSE, 'R')) {
    $record['data'] = $data_chains;
    // Collate this data into a flat array of frags
    unset($del_frags);
    $del_frags = array();
    collateFrags($record['data'], 'del_frags');
    // Count them
    $num_del_frags = count($del_frags);
} else {
    $record['data'] = FALSE;
    $num_del_frags = 0;
    $del_frags = FALSE;
}

// ---- PROCESS ---- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id']) {
    include_once ('php/subforms/update_delete_record.php');
    $process = 'underway';
} else {
    $process = FALSE;
}

// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_delete = getMarkup('cor_tbl_markup', $lang, 'delete');
$mk_delwarn = getMarkup('cor_tbl_markup', $lang, 'delwarn');
$mk_reclabel = getMarkup('cor_tbl_markup', $lang, 'reclabel');
$mk_numfrags = getMarkup('cor_tbl_markup', $lang, 'numfrags');
$mk_armdelete = getMarkup('cor_tbl_markup', $lang, 'armdelete');

// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch ($sf_state) {
    // Min Views
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        print("</div>");
    break;
    
    // Overlay Views
    case 'overlay':
        // form
        $form = "<form method=\"POST\" name=\"delete_record_overlay_form\" id=\"delete_record_overlay_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
        $form .= "<fieldset>";
        $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $form .= "<input type=\"hidden\" name=\"overlay\" value=\"true\" />";
        $form .= "<input type=\"hidden\" name=\"delete_key\" value=\"{$delete_key}\" />";
        $form .= "<input type=\"hidden\" name=\"delete_val\" value=\"{$delete_val}\" />";
        $form .= "<input type=\"hidden\" name=\"lang\" value=\"{$lang}\" />";
        $form .= "<input type=\"hidden\" name=\"lboxreload\" value=\"$lboxreload\" />";
        $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"$sf_conf_name\" />";
        $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />";
        // Contain the input elements in a list
        $form .= "<ul>\n";
        $form .= "<li class=\"row\">";
        $form .= "<label class=\"form_label\">&nbsp;</label>";
        $form .= "<span class=\"inp\"><button type=\"submit\" />$mk_delete</button></span>";
        $form .= "</li>\n";
        $form .= "</ul>\n";
        $form .= "</fieldset>";
        $form .= "</form>\n";
        // output
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // PROCESS routine | USER INPUT routine depending on progress
        if ($process) {
            // do nothing and let the feedback do its business
        } else {
            if ($delete_key && $delete_val) {
                echo "<h4>{$mk_reclabel}: {$delete_key} = $delete_val</h4>";
                if ($num_del_frags > 0) {
                    // mag - the maginfying glass link
                    $mag = "<a href=\"overlay_holder.php?";
                    $mag .= "overlay=true&amp;item_key={$item_key}&amp;{$item_key}={$$item_key}";
                    $mag .= "&amp;sf_key={$delete_key}&amp;sf_val={$delete_val}&amp;lang=$lang";
                    $mag .= "&amp;sf_conf=$conflict_res_sf&amp;lboxreload=0\">";
                    $mag .= "<img src=\"$skin_path/images/plusminus/view.png\" alt=\"[view]\" class=\"med\"/>";
                    $mag .= "</a>";
                } else {
                    $mag = FALSE;
                }
                echo "<p>{$mk_numfrags}: {$num_del_frags} {$mag}</p>";
                echo "$form\n";
                echo "<p class=\"message\">$mk_delwarn</p>\n";
            }
        }
        print("</div>\n");
        // exit
        break;
        
    // Max Views
    case 'p_max_view':
    case 's_max_view':
        // in the case that thsi form is not editable, just put in the nav
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        print("</div>\n");
        break;
        
    // Max Edits
    case 'p_max_edit':
    case 's_max_edit':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        if (!$armed) {
            // $arm_sw is a switch for the user to arm the deletion form
            $arm_sw = "<span class=\"inp\">";
            $arm_sw .= "<a href=\"{$_SERVER['PHP_SELF']}?{$item_key}={$$item_key}";
            $arm_sw .= "&amp;armed={$sf_conf['sf_html_id']}&amp;delete_key={$sf_key}&amp;delete_val={$sf_val}\"";
            $arm_sw .= " class=\"delete\">$mk_armdelete</a></span>";
            echo "$arm_sw";
        } else {
            // trigger
            $trigger = "<a href=\"{$_SERVER['PHP_SELF']}?{$item_key}={$$item_key}";
            $trigger .= "&amp;armed={$sf_conf['sf_html_id']}&amp;delete_key={$sf_key}&amp;delete_val={$sf_val}";
            $trigger .= "&amp;update_db={$sf_conf['sf_html_id']}\" class=\"delete\">$mk_delete</a>";
            // output
            echo "<h4>{$mk_reclabel}: {$delete_key} = $delete_val</h4>";
            if ($num_del_frags > 0) {
                // $mag the magnifying glass link
                $mag = "<a href=\"overlay_holder.php?overlay=true&amp;item_key={$item_key}&amp;{$item_key}={$$item_key}";
                $mag .= "&amp;sf_key={$delete_key}&amp;sf_val={$delete_val}&amp;lang=$lang&amp;";
                $mag .= "sf_conf=$conflict_res_sf\" rel=\"lightbox\">";
                $mag .= "<img src=\"$skin_path/images/plusminus/view.png\" alt=\"[view]\"/>";
                $mag .= "</a>";
            } else {
                $mag = FALSE;
            }
            echo "<p>{$mk_numfrags}: {$num_del_frags} {$mag}</p>";
            echo "$trigger\n";
            echo "<p class=\"warning\">$mk_delwarn</p>\n";
        }
        print("</div>\n");
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_delete_record\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_delete_record was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;

// ends switch
}
// clean up
unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);
unset ($alias_lang_info);

?>
