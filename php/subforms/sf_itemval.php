<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_itemval.php
*
* global subform for itemvals
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
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_modtype.php
* @since      File available since Release 0.8
*
* This is largely envisioned as an overlay, but has view and edit modes if needed
*
*/

// ---- SETUP ---- //

// We always show the same thing for an itemval form! Modtype independant
$fields = $sf_conf['fields'];

// establish a module
$mod = splitItemkey($sf_key);

// Request the target itemval
// this uses the reqItemVal() func from validation functions to call the itemval
// in a smart way that will check for site code if needed
// setup
$vars =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);
$target_itemval = reqItemVal($vars, FALSE);


// CSS
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

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
// We also want to know whether the form is being accessed from data entry or micro view
// so that on completion the correct page is reloaded
$reloadpage = reqQst($_REQUEST, 'reloadpage');

// ---- PROCESS ---- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id']) {
    include_once ('php/subforms/update_itemval.php');
    $process = 'underway';
} else {
    $process = FALSE;
    $update_success = FALSE;
}

// This entire data gathering routine will be run by the update script IF we are on an update routine
// ONLY run this code if we are not on an update
// Maintain this code exactly the same as the code in the update script AND the sf_modtypeconflicts.php
// $conflicted_frag_count = FALSE;
if (!$process && $target_itemval) {
    // ---- DATA ----
    // do some validation on this key
    if (!chkValid($target_itemval, FALSE, FALSE, $mod.'_tbl_'.$mod, $mod.'_cd')) {
        $armed = FALSE;
        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_notvalid');
    }
    // do the number crunching (output below)
    $record =
        array(
            'itemkey' => $sf_key,
            'itemvalue' => $sf_val,
            'target_itemvalue' => $target_itemval,
            'data' => 0,
    );
    // if there are frags, get the chained data
    if ($data_chains = getChData(FALSE, $sf_key, $sf_val)) {
        $record['data'] = $data_chains;
    } else {
        $record['data'] = FALSE;
    }
    $frags = array();
    collateFrags($record['data'], 'frags');
    $conflicted_frag_count = count($frags);
}

// KEY VAL CHECK
if (!$sf_key) {
    $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_nosfkey');
}
if (!$sf_val) {
    $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_nosfval');
}

// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);
$mk_input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
$mk_change = getMarkup('cor_tbl_markup', $lang, 'change');
$mk_currkey = getMarkup('cor_tbl_markup', $lang, 'currkey');
$mk_tgtkey = getMarkup('cor_tbl_markup', $lang, 'tgtkey');
$mk_numconflictfrags = getMarkup('cor_tbl_markup', $lang, 'numconflictfrags');
$mk_changevalwarn = getMarkup('cor_tbl_markup', $lang, 'changevalwarn');
$mk_succsreload = getMarkup('cor_tbl_markup', $lang, 'succsreload');

// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch ($sf_state) {
    // MIN STATES
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n";
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        echo "</div>\n";
        break;
    
    // MAX VIEWS
    case 'p_max_view':
    case 's_max_view':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n";
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // process the fields array
        $fields = resTblTh($fields, 'silent');
        printf("<ul class=\"view_fields\">\n");
        // loop thru each field
        foreach ($fields as $field) {
            //attempt to get 'current'
            if ($current = getRow($mod.'_tbl_'.$mod,FALSE,"WHERE ".$mod."_cd = '$sf_val'")) {
                $field['current'] =
                    array(
                        'id' => $current[$mod.'_cd'],
                        'current' => $current[$mod.'_cd']
                );
            } else {
                $field['current'] = FALSE;
            }
            // process the current value using the standard routine
            $val = resTblTd($field, $sf_key, $sf_val);
            if ($val) {
                $var = "<li class=\"row\">";
                $var .= "<label>{$field['field_alias']}</label>";
                $var .= "<span>$val</span>";
                $var .= "</li>\n";
                echo $var;
            }
        }
        echo "</ul>\n";
        echo "</div>\n";
        break;
    
    // MAX EDITS
    case 'p_max_edit':
    case 's_max_edit':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n";
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // if this was a successful update routine give feedback otherwise dsplay the forms
        if ($process && $update_success) {
            // success, now reload
            $var = "<a href=\"{$_SERVER['PHP_SELF']}?{$item_key}={$sf_val}";
            $var .= "&amp;sf_key={$sf_key}&amp;sf_val={$sf_val}&amp;disp_reset=default\" ";
            $var .= "class=\"delete\">";
            $var .= "$mk_succsreload";
            $var .= "</a>";
            echo "$var";
        } else {
            // process the fields array
            $fields = resTblTh($fields, 'silent');
            // this form must be armed by the user before use
            if (!$armed) {
                // this means we want to display the initial form
                $form = "<form method=\"$form_method\" id=\"{$sf_conf['sf_html_id']}\" action=\"{$_SERVER['PHP_SELF']}\">\n";
                $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                $form .= "<input type=\"hidden\" name=\"item_key\" value=\"$sf_key\" />\n";
                $form .= "<input type=\"hidden\" name=\"$sf_key\" value=\"{$sf_val}\" />\n";
                $form .= "<input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />\n";
                $form .= "<input type=\"hidden\" name=\"armed\" value=\"{$sf_conf['sf_html_id']}\" />\n";
                echo "$form";
                echo "<ul>\n";
                // loop thru each field
                foreach ($fields as $field) {
                    //attempt to get 'current'
                    if ($current = getRow($mod.'_tbl_'.$mod,FALSE,"WHERE ".$mod."_cd = '$sf_val'")) {
                        $field['current'] =
                            array(
                                'id' => $current[$mod.'_cd'],
                                'current' => $current[$mod.'_cd']
                        );
                    } else {
                        $field['current'] = FALSE;
                    }
                    $val = frmElem($field, $sf_key, $sf_val);
                    print("
                        <li class=\"row\">
                            <label class=\"form_label\">{$field['field_alias']}</label>
                            <span class=\"inp\">$val</span>
                        </li>\n
                    
                    ");
                }
                // put in the options row
                print("
                    <li class=\"row\">
                        <label class=\"form_label\">$mk_label</label>
                        <span class=\"inp\">
                            <button type=\"submit\">$mk_input</button>
                        </span>
                    </li>\n"
                );
                print("
                    </ul>\n
                    </form>\n
                ");
            } else {
                // in this case the form IS armed... give a warning and offer the trigger
                // trigger
                $trigger = "<a href=\"{$_SERVER['PHP_SELF']}?{$item_key}={$$item_key}";
                //$trigger .= "&amp;modtype={$target_modtype}";
                $trigger .= "&amp;armed={$sf_conf['sf_html_id']}&amp;sf_key={$sf_key}&amp;sf_val={$sf_val}";
                $trigger .= "&amp;itemval={$target_itemval}";
                $trigger .= "&amp;update_db={$sf_conf['sf_html_id']}\" class=\"delete\">$mk_change</a>";
                // output
                echo "<h4>{$mk_currkey}: {$sf_val}</h4>";
                echo "<p>{$mk_tgtkey}: {$target_itemval}</p>";
                // $mag the magnifying glass link
                $mag = "<a href=\"overlay_holder.php?overlay=true&amp;item_key={$item_key}&amp;{$item_key}={$$item_key}";
                $mag .= "&amp;sf_key={$sf_key}&amp;sf_val={$sf_val}&amp;";
                $mag .= "sf_conf=$conflict_res_sf\" rel=\"lightbox\">";
                $mag .= "<img src=\"$skin_path/images/plusminus/view.png\" alt=\"[view]\" class=\"med\"/>";
                $mag .= "</a>\n";
                // a warning about conflicted frags
                if ($conflicted_frag_count > 0) {
                    echo "<p>{$mk_numconflictfrags}: {$conflicted_frag_count} {$mag}</p>";
                    $warn = "<p class=\"message\">$mk_changevalwarn</p>\n";
                    echo "$warn";
                }
                echo "$trigger\n";
            }
        }
        echo "</div>\n";
        break;

    // OVERLAY
    case 'overlay':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n";
        // Feedback
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // if this was a successful update routine give feedback otherwise dsplay the forms
        if ($process && $update_success) {
            // do nothing
        } else {
            // process the fields array
            $fields = resTblTh($fields, 'silent');
            // this form must be armed by the user before use
            if (!$armed) {
                // this means we want to display the initial form
                $form = "<form method=\"$form_method\" id=\"{$sf_conf['sf_html_id']}\" action=\"{$_SERVER['PHP_SELF']}\">\n";
                $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                $form .= "<input type=\"hidden\" name=\"item_key\" value=\"$sf_key\" />\n";
                $form .= "<input type=\"hidden\" name=\"$sf_key\" value=\"{$sf_val}\" />\n";
                $form .= "<input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />\n";
                $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"{$sf_conf_name}\" />\n";
                $form .= "<input type=\"hidden\" name=\"armed\" value=\"{$sf_conf['sf_html_id']}\" />\n";
                echo "$form";
                echo "<ul>\n";
                // loop thru each field
                foreach ($fields as $field) {
                    //attempt to get 'current'
                    if ($current = getRow($mod.'_tbl_'.$mod,FALSE,"WHERE ".$mod."_cd = '$sf_val'")) {
                        $field['current'] =
                            array(
                                'id' => $current[$mod.'_cd'],
                                'current' => $current[$mod.'_cd']
                        );
                    } else {
                        $field['current'] = FALSE;
                    }
                    $val = frmElem($field, $sf_key, $sf_val);
                    print("
                        <li class=\"row\">
                            <label class=\"form_label\">{$field['field_alias']}</label>
                            <span class=\"inp\">$val</span>
                        </li>\n
                    
                    ");
                }
                // put in the options row
                print("
                    <li class=\"row\">
                        <label class=\"form_label\">$mk_label</label>
                        <span class=\"inp\">
                            <button type=\"submit\">$mk_input</button>
                        </span>
                    </li>\n"
                );
                print("
                    </ul>\n
                    </form>\n
                ");
            } else {
                // a URL to act as a target
                $reload_url = "{$reloadpage}?item_key={$item_key}&amp;{$item_key}={$target_itemval}&amp;disp_reset=default";
                // trigger (form)
                $trigger = "<form method=\"$form_method\" name=\"change_modtype_overlay_form\" id=\"change_modtype_overlay_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
                $trigger .= "<fieldset>";
                $trigger .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                $trigger .= "<input type=\"hidden\" name=\"overlay\" value=\"true\" />";
                $trigger .= "<input type=\"hidden\" name=\"sf_key\" value=\"{$sf_key}\" />";
                $trigger .= "<input type=\"hidden\" name=\"sf_val\" value=\"{$sf_val}\" />";
                $trigger .= "<input type=\"hidden\" name=\"lang\" value=\"{$lang}\" />";
                $trigger .= "<input type=\"hidden\" name=\"itemval\" value=\"{$target_itemval}\" />";
                $trigger .= "<input type=\"hidden\" name=\"lboxreload\" value=\"$reload_url\" />";
                $trigger .= "<input type=\"hidden\" name=\"sf_conf\" value=\"$sf_conf_name\" />";
                $trigger .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />";
                // Contain the input elements in a list
                $trigger .= "<ul>\n";
                $trigger .= "<li class=\"row\">";
                $trigger .= "<label class=\"form_label\">&nbsp;</label>";
                $trigger .= "<span class=\"inp\"><button type=\"submit\" class=\"delete\" />$mk_change</button></span>";
                $trigger .= "</li>\n";
                $trigger .= "</ul>\n";
                $trigger .= "</fieldset>";
                $trigger .= "</form>\n";
                echo "<h4>{$mk_currkey}: {$sf_val}</h4>";
                echo "<p>{$mk_tgtkey}: {$target_itemval}</p>";
                // $mag the magnifying glass link
                $mag = "<a href=\"overlay_holder.php?overlay=true&amp;item_key={$item_key}&amp;{$item_key}={$$item_key}";
                $mag .= "&amp;sf_key={$sf_key}&amp;sf_val={$sf_val}&amp;";
                $mag .= "sf_conf=$conflict_res_sf&amp;lboxreload=0\">";
                $mag .= "<img src=\"$skin_path/images/plusminus/view.png\" alt=\"[view]\" class=\"med\" />";
                $mag .= "</a>\n";
                // a warning about conflicted frags
                if ($conflicted_frag_count > 0) {
                    echo "<p>{$mk_numconflictfrags}: {$conflicted_frag_count} {$mag}</p>";
                    $warn = "<p class=\"message\">$mk_changevalwarn</p>\n";
                    echo "$warn";
                }
                echo "$trigger\n";
            }
        }
        echo "</div>\n";
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_itemval\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_itemval was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;

} // ends switch

unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);

?>
