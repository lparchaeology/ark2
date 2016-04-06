<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* subforms/sf_register_tbl.php
*
* a subform to register new items in a table type of view
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2007  L - P : Partnership Ltd.
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
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2011 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_entry/register.php
* @since      File available since Release 1.0
*
* Note 1: This script was available since 0.6 in the form of data_entry/register.php.
*
* Note 2: As of v1.1 this has been remodelled by GH to work as a subform for use in
* any page or as an overlay.
*
* Note 3: Up to v1.1 (including the v1.0 release) the register had a table - single
* mode option. This is now split into two scripts.
*
* Note 4: When used in an overlay, it is most likely that the overlayed register will
* be aimed at module different to the underlying page. If this is the case, the
* 'op_register_mode' is important as it indicates to the register which module is in
* play. In addition, the system has to change calls for the item_key to the sf_key
* in any validation rules to sf_key by brute force.
*
*/


// ---- SETUP ---- //

// in some cases 'op_register_mod' can be used to change the sf_key of this SF
// on the fly to the module specified in the $sf_conf
if (array_key_exists('op_register_mod', $sf_conf)) {
    // sf_key comes from the conf
    $sf_key = $sf_conf['op_register_mod'].'_cd';
    // unset the sf_val to avoid confusion
    $sf_val = FALSE;
    // in this case we also need to make sure any validation uses sf_key not itemkey
    $fields = $sf_conf['fields'];
    foreach ($fields as $fkey => $field) {
        if (array_key_exists('add_validation', $field) && is_array($field['add_validation'])) {
            foreach ($field['add_validation'] as $rkey => $rule) {
                if (array_key_exists('lv_name', $rule)) {
                    if ($rule['lv_name'] == 'item_key') {
                        $sf_conf['fields'][$fkey]['add_validation'][$rkey]['lv_name'] = 'sf_key';
                    }
                }
            }
        }
    }
}

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// Check if there are any instructions for users of this form
if (array_key_exists('op_mk_instructions', $sf_conf)) {
    $mk_instructions = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_mk_instructions']);
} else {
    $mk_instructions = FALSE;
}

// Check for an optional sidecar script
if (array_key_exists('op_scriptpath', $sf_conf)) {
    $scriptpath = $sf_conf['op_scriptpath'];
} else {
    $scriptpath = FALSE;
}

// Sort out the language to apply to text frags
// This allows us to specify a lang for the texts
if (array_key_exists('op_sf_lang', $sf_conf)) {
    $sf_lang = $sf_conf['op_sf_lang'];
} else {
    $sf_lang = $lang;
}

// This allows us to exclude texts in a certain lang
if (array_key_exists('op_sf_exclude_lang', $sf_conf)) {
    $sf_exclude_lang = $sf_conf['op_sf_exclude_lang'];;
} else {
    $sf_exclude_lang = FALSE;
}

// supply a mod_short
$mod_short = substr($sf_key, 0, 3);


// ---- COMMON ---- //
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_noregisterdatayet = getMarkup('cor_tbl_markup', $lang, 'noregisterdatayet');


// ---- PROCESS ---- //
if ($update_db == 'register-'.$sf_key) {
    $fields = $sf_conf['fields'];
    include_once('php/update_db.php');
}
// feedback on process
if (isset($qry_results)) {
    if (isset($qry_results[0]['new_itemvalue'])) {
        // run optional sidecar script
        if ($scriptpath) {
            include_once($scriptpath);
        }
        // set up msg
        if ($sf_state == 'overlay') {
            // no link
            $msg = "New $sf_key: {$qry_results[0]['new_itemvalue']}";
        } else {
            // link to the record
            $msg = "<a href=\"data_entry.php?view=detfrm&";
            $msg .= "item_key=$sf_key&amp;";
            $msg .= "$sf_key={$qry_results[0]['new_itemvalue']}\"";
            $msg .= ">New $sf_key: {$qry_results[0]['new_itemvalue']}</a>";
        }
        $message[] = $msg;
        unset ($msg);
    }
}

// ---- OUTPUT ---- //

// STATE SPECFIC
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
        
    // Max
    case 'p_max_ent':
    case 'p_max_view':
    case 'p_max_edit':
        // put in the entry nav for overlays (other states delegate this to the page)
        if ($sf_state == 'overlay') {
            echo mkRecordNav($conf_entry_nav, 'data_entry', 'overlay');
        }
        // start the SF
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        echo sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        // feedback
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // instructions
        if ($mk_instructions){
            echo $mk_instructions;
        }
        
        // start a form
        $out_p = "<form method=\"$form_method\" id=\"register-$sf_key\" action=\"{$_SERVER['PHP_SELF']}\">\n";
        $out_p .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $out_p .= "<input type=\"hidden\" name=\"$item_key\" value=\"{$$item_key}\" />\n";
        $out_p .= "<input type=\"hidden\" name=\"sf_lang\" value=\"$sf_lang\" />\n";
        // put in the top of the table
        $out_p .= "<table class=\"register_tbl\">\n";
        
        // process the fields array
        $fields = resTblTh($sf_conf['fields']);
        
        // handle option for admin config number of rows
        if (array_key_exists('op_num_rows', $sf_conf)) {
            $num_reg_rows = $sf_conf['op_num_rows'];
        } else {
            $num_reg_rows = '15'; // a default
        }
        
        // get the data for the table
        $table_row_data = getRegisterRows($mod_short, $item_key, $ste_cd, $num_reg_rows);
        
        // make the header row
        $out_p .= mkTblTh($fields);
        
        // loop thru existing records
        if ($table_row_data) {
            foreach ($table_row_data as $key => $row) {
                // start this row
                $out_p .= "<tr>";
                // QUICKEDIT ROW - if this row is up for edit do this
                if ($quickedit == $row[$sf_key]) {
                    // put in hidden fields for the q.ed form
                    $hidden_1 = "<input type=\"hidden\" name=\"update_db\" value=\"register-{$sf_key}\" />\n";
                    $hidden_2 = "<input type=\"hidden\" name=\"qtype\" value=\"edt\" />\n";
                    // loop thru the cols
                    foreach($fields as $key => $col) {
                        // make the table cell's val - for itemkeys force hidden fields
                        if ($col['dataclass'] != 'itemkey') {
                            // skip all option rows
                            if ($col['dataclass'] != 'op') {
                                //check if there is a current value for this field and add to the field
                                if ($cur_val = resFdCurr($col, $sf_key, $row[$sf_key])) {
                                    $col['current'] = $cur_val;
                                } else {
                                    $col['current'] = FALSE;
                                }
                            }
                            $td_val = frmElem($col, $sf_key, $row[$sf_key]);
                        // process itemkeys
                        } else {
                            // hide the field
                            $col['hidden'] = 'this_sf_valu';
                            // set it's 'current' as this itemvalue
                            $col['current'] = $row[$sf_key];
                            $td_val = frmElem($col, $sf_key, $row[$sf_key]);
                            // tack on the 'view' output over the hidden field
                            $td_val .= resTblTd($col, $sf_key, $row[$sf_key]);
                        }
                        // for the first col put in the hidden fields too
                        if ($key < 1) {
                            $td_val = $hidden_1.$hidden_2.$td_val;
                        }
                        // add the table cell
                        $out_p .= "<td>$td_val</td>";
                    }
                // NORMAL ROWS
                } else {
                    // loop thru the cols
                    foreach($fields as $key => $col) {
                        if ($col['dataclass'] == 'file') {
                                $file_selection = TRUE;
                        }
                        // make the val
                        $td_val = resTblTd($col, $sf_key, $row[$sf_key]);
                        // print the item
                        $out_p .= "<td>$td_val</td>";
                    }
                }
                // end the row
                $out_p .= "</tr>\n";
            }
        } else {
            // no table data yet on this site code
            echo "<div class=\"message\">$mk_noregisterdatayet</div>\n";
        }
        // ADD ROW - if there is no qedit on
        if (!$quickedit) {
            // start row
            printf('<tr>');
            // put in hidden for the normal form
            $hidden_1 = "<input type=\"hidden\" name=\"update_db\" value=\"register-{$item_key}\" />\n";
            $hidden_2 = "<input type=\"hidden\" name=\"qtype\" value=\"add\" />\n";
            // loop thru the cols
            foreach($fields as $key => $col) {
                // check for defaults
                if (array_key_exists('default', $col)) {
                    $default = $col['default'];
                } else {
                    $default = FALSE;
                }
                // make the val
                $td_val = frmElem($col, $sf_key, $$sf_key);
                // for the first col put in the hidden fields too
                if ($key < 1) {
                    $td_val = $hidden_1.$hidden_2.$td_val;
                }
                if ($col['dataclass'] == 'file') {
                    $file_selection = TRUE;
                }
                // print the item
                $out_p .= "<td>$td_val</td>";
            }
           // end the row
           $out_p .= "</tr>\n";
        }
        // end the table
        $out_p .= "</table>\n";
        // end the form
        $out_p .= "</form>\n";
        // output
        echo $out_p;
        // close out the SF
        echo "</div>";
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_register_tbl\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>Admin Error: the sf_state for sf_register_tbl was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
}

?>
