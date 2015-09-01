<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_modtype.php
*
* global subform for modtypes
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
* @since      File available since Release 0.6
*
* As of v0.8 this has been updated to include edit functionality (GH - Aug 2010)
*
*/

// ---- SETUP ---- //

// We always show the same thing for a modtype form!
$mod = substr($sf_key, 0, 3);
$fields = $sf_conf['fields'];

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


// Labels for the modtypes
$modtype = getModtype($mod_short, $sf_val);
$modtype_alias = getAlias($mod_short.'_lut_'.$mod_short.'type', $lang, 'id', $modtype, 1);
$target_modtype = reqQst($_REQUEST, 'modtype');
$target_modtype_alias = getAlias($mod_short.'_lut_'.$mod_short.'type', $lang, 'id', $target_modtype, 1);

// ---- PROCESS ---- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id']) {
    include_once ('php/subforms/update_modtype.php');
    $process = 'underway';
} else {
    $process = FALSE;
    $update_success = FALSE;
}

// This entire data gathering routine will be run by the update script IF we are on an update routine
// ONLY run this code if we are not on an update
// Maintain this code exactly the same as the code in the update script AND the sf_modtypeconflicts.php
if (!$process && $target_modtype) {
    // ---- DATA ----
    // do the number crunching (output below)
    // get the subforms for this module
    $sfs = getSfs($mod_short);
    // count them for output later
    $num_sfs = count($sfs);
    // split out the SFs using op_modtype to define modtype specifc fields
    $modtype_sfs = array();
    foreach ($sfs as $key => $sf) {
        if (array_key_exists('op_modtype', $sf)) {
            if ($sf['op_modtype']) {
                $modtype_sfs[$key] = $sf;
                $modtype_sfs[$key]['op_modtype'] = 'Modtypes used';
                $sfs[$key]['op_modtype'] = 'Modtypes used';
            } else {
                $sfs[$key]['op_modtype'] = FALSE;
            }
        } else {
            $sfs[$key]['op_modtype'] = FALSE;
        }
    }
    // split out relevant chkModTypeCond SFs
    foreach ($sfs as $key => $sf) {
        // 1 - Are conditions used?
        if (array_key_exists('op_condition', $sf) && $sf['op_condition']) {
            // set a marker for display later
            $sfs[$key]['op_cond_used'] = 'Conditions used';
            // 2 - Is the chkModTypeCond() used?
            // check over all the conditions
            // first set these two markers (to FALSE) before looping over the conditions
            // we assume no conflict unless triggered in the loop
            $sfs[$key]['chkModTypeCond_used'] = FALSE;
            $sfs[$key]['op_condition_conflict'] = FALSE;
            // loop over the conditions
            foreach ($sf['op_condition'] as $cond_key => $cond) {
                if ($cond['func'] == 'chkModTypeCond') {
                    // if so, set the marker for display later
                    $sfs[$key]['chkModTypeCond_used'] = 'chkModTypeCond used';
                    // 3 - is the condition refering to this modtype?
                    if ($cond['args'] == $modtype) {
                        $sfs[$key]['op_condition_conflict'] = TRUE;
                        // if all 3 conditions evaluate true, then we need to add this to the
                        // modtype_sfs (assuming it isnt already there)
                        if (!array_key_exists($key, $modtype_sfs)) {
                            $modtype_sfs[$key] = $sf;
                        }
                    }
                }
            }
        } else {
            $sfs[$key]['op_cond_used'] = FALSE;
            // also set the markers for questions 2 and 3 to off
            $sfs[$key]['chkModTypeCond_used'] = FALSE;
            $sfs[$key]['op_condition_conflict'] = FALSE;
        }
    }
    // Count the number of modtype conflicted SFs
    $num_modtype_sflist = count($modtype_sfs);

    // Now examine each of the conflicted subforms
    // First do the op_modtypes (conditional sf's below)
    // put informnation for output into an array
    $conflicted_frags = array();
    // loop over each sf
    foreach ($modtype_sfs as $key => $sf) {
        // examine op_modtype tables
        if (array_key_exists('op_modtype', $sf) && $sf['op_modtype']) {
            // Set up three vars to hold data for output
            $conflict_count = 0;
            $conflict_frag_count = 0;
            $prc_fields = array();
            // Get the mod fields
            $mod_fields = $sf["type{$modtype}_fields"];
            foreach ($mod_fields as $fd_key => $field) {
                $field_id = "{$key}-{$field['dataclass']}-{$field['classtype']}";
                $field['this_mod'] = TRUE;
                $field['target_mod'] = FALSE;
                $prc_fields[$field_id] = $field;
            }
            // get the target fields
            $tgt_fields = $sf["type{$target_modtype}_fields"];
            foreach ($tgt_fields as $fd_key => $field) {
                $field_id = "{$key}-{$field['dataclass']}-{$field['classtype']}";
                if (!array_key_exists($field_id, $prc_fields)) {
                    $field['target_mod'] = TRUE;
                    $field['this_mod'] = FALSE;
                    $prc_fields[$field_id] = $field;
                } else {
                    $prc_fields[$field_id]['target_mod'] = TRUE;
                }
            }
            // Now process the fields
            foreach ($prc_fields as $fd_key => $field) {
                if ($field['target_mod'] && $field['this_mod']) {
                    $prc_fields[$fd_key]['conflict'] = FALSE;
                    $prc_fields[$fd_key]['data'] = FALSE;
                }
                if (!$field['target_mod'] && $field['this_mod']) {
                    $prc_fields[$fd_key]['conflict'] = TRUE;
                    // as there is a possible conflict, check for data
                    if ($ch = getCh($field['dataclass'], $sf_key, $sf_val, $field['classtype'])) {
                        $data = array();
                        foreach ($ch as $key => $frag) {
                            $data[$key]['dataclass'] = $field['dataclass'];
                            $data[$key]['frag_id'] = $frag;
                            // record this frag to the conflicted frags array
                            $conflicted_frags[] =
                                array(
                                    'dataclass' => $field['dataclass'],
                                    'id' => $frag
                            );
                            $conflict_frag_count++;
                        }
                        $prc_fields[$fd_key]['data'] = $data;
                        $conflict_count++;
                    } else {
                        $prc_fields[$fd_key]['data'] = FALSE;
                    }
                }
                if ($field['target_mod'] && !$field['this_mod']) {
                    $prc_fields[$fd_key]['conflict'] = FALSE;
                    $prc_fields[$fd_key]['data'] = 'not chkd';
                }
            }
            // place this processed data into an array for output and clean up vars for reuse
            $op_modtype_output[$sf['sf_html_id']]['fields'] = $prc_fields;
            unset($prc_fields);
            $op_modtype_output[$sf['sf_html_id']]['conflict_count'] = $conflict_count;
            unset($conflict_count);
            $op_modtype_output[$sf['sf_html_id']]['conflict_frag_count'] = $conflict_frag_count;
            unset($conflict_frag_count);
        }
        // Now examine conditional sf's
        if (array_key_exists('op_condition', $sf) && $sf['op_condition']) {
            $conflict_frag_count = 0;
            $conflict_count = 0;
            // loop over the relevant fields   
            $fields = $sf['fields'];
            foreach ($fields as $fd_key => $field) {
                $field_id = "{$key}-{$field['dataclass']}-{$field['classtype']}";
                $prc_fields[$field_id] = $field;
            }
            foreach ($prc_fields as $fd_key => $field) {
                if ($ch = getCh($field['dataclass'], $sf_key, $sf_val, $field['classtype'])) {
                    $data = array();
                    foreach ($ch as $key => $frag) {
                        $data[$key]['dataclass'] = $field['dataclass'];
                        $data[$key]['frag_id'] = $frag;
                        // record this frag to the conflicted frags array
                        $conflicted_frags[] =
                            array(
                                'dataclass' => $field['dataclass'],
                                'id' => $frag
                        );
                        $conflict_frag_count++;
                    }
                    $prc_fields[$fd_key]['data'] = $data;
                    $conflict_count++;
                } else {
                    $prc_fields[$fd_key]['data'] = FALSE;
                }
            }
            // place this processed data into an array for output and clean up vars for reuse
            $conditionals_output[$sf['sf_html_id']]['fields'] = $prc_fields;
            unset($prc_fields);
            $conditionals_output[$sf['sf_html_id']]['conflict_count'] = $conflict_count;
            unset($conflict_count);
            $conditionals_output[$sf['sf_html_id']]['conflict_frag_count'] = $conflict_frag_count;
            unset($conflict_frag_count);
        }
    }
}
if (isset($conflicted_frags)) {
    $conflicted_frag_count = count($conflicted_frags);
} else {
    $conflicted_frag_count = FALSE;
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
$mk_reclabel = getMarkup('cor_tbl_markup', $lang, 'reclabel');
$mk_curmodtype = getMarkup('cor_tbl_markup', $lang, 'curmodtype');
$mk_tgtmodtype = getMarkup('cor_tbl_markup', $lang, 'tgtmodtype');
$mk_numconflictsfs = getMarkup('cor_tbl_markup', $lang, 'numconflictsfs');
$mk_numconflictfrags = getMarkup('cor_tbl_markup', $lang, 'numconflictfrags');
$mk_changewarn = getMarkup('cor_tbl_markup', $lang, 'changewarn');
$mk_succsreload = getMarkup('cor_tbl_markup', $lang, 'succsreload');
$mk_conflictwarn = getMarkup('cor_tbl_markup', $lang, 'conflictwarn');

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
            if ($current =
                    getRow(
                        $mod . '_tbl_' . $mod,
                        FALSE,
                        "WHERE " . $mod . "_cd = '{$sf_val}'"
                )) {
                    if(isset($current['id']) AND isset($current[$mod . 'type'])){
                        $field['current'] =
                        array(
                            'id' => $current['id'],
                            'current' => $current[$mod . 'type']
                        );
                    }
            } else {
                $field['current'] = FALSE;
            }
            //try to get the current value
            $val = resTblTd($field, $sf_key, $sf_val);
            if ($val) {
                $var = "<li class=\"row\">";
                $var .= "<label class=\"form_label\">{$field['field_alias']}</label>";
                $var .= $val;
                $var .= "</li>\n";
                echo "$var";
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
        if ($process && $changemodtype_success) {
            // success, now reload
            $var = "<a href=\"{$_SERVER['PHP_SELF']}?{$item_key}={$$item_key}";
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
                    if ($current =
                        getRow(
                            $mod . '_tbl_' . $mod,
                            FALSE,
                            "WHERE " . $mod . "_cd = '{$sf_val}'"
                            )) {
                        $field['current'] =
                            array(
                            'id' => $current[$mod . '_cd'],
                            'current' => $current[$mod . 'type']
                            );
                    } else {
                        $field['current'] = FALSE;
                    }
                    $val = frmElem($field, $sf_key, $sf_val);
                    //try to get the current value
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
                $trigger .= "&amp;modtype={$target_modtype}";
                $trigger .= "&amp;armed={$sf_conf['sf_html_id']}&amp;sf_key={$sf_key}&amp;sf_val={$sf_val}";
                $trigger .= "&amp;update_db={$sf_conf['sf_html_id']}\" class=\"delete\">$mk_change</a>";
                // output
                echo "<h4>{$mk_reclabel}: {$sf_key} = {$sf_val}</h4>";
                echo "<p>{$mk_curmodtype}: {$modtype_alias} ({$modtype})</p>";
                echo "<p>{$mk_tgtmodtype}: {$target_modtype_alias} ({$target_modtype})</p>";
                // $mag the magnifying glass link
                $mag = "<a href=\"overlay_holder.php?overlay=true&amp;item_key={$item_key}&amp;{$item_key}={$$item_key}";
                $mag .= "&amp;sf_key={$sf_key}&amp;sf_val={$sf_val}&amp;modtype=$target_modtype&amp;";
                $mag .= "sf_conf=$conflict_res_sf\" rel=\"lightbox\">";
                $mag .= "<img src=\"$skin_path/images/plusminus/view.png\" alt=\"[view]\" class=\"med\" />";
                $mag .= "</a>\n";
                // a warning about conflicted sfs
                if ($num_modtype_sflist > 0) {
                    echo "<p>{$mk_numconflictsfs}: {$num_modtype_sflist} {$mag}</p>";
                    $warn = "<p class=\"message\">$mk_changewarn</p>\n";
                    echo "$warn";
                }
                if ($conflicted_frag_count > 0) {
                    echo "<p>{$mk_numconflictfrags}: {$conflicted_frag_count} {$mag}</p>";
                    $warn = "<p class=\"message\">$mk_conflictwarn</p>\n";
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
        if ($process && $changemodtype_success) {
            // success, now reload
        } else {
            // process the fields array
            $fields = resTblTh($fields, 'silent');
            // this form must be armed by the user before use
            if (!$armed) {
                // output
                echo "<h4>{$mk_reclabel}: {$sf_key} = {$sf_val}</h4>";
                echo "<p>{$mk_curmodtype}: {$modtype_alias} ({$modtype})</p>";
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
                    if ($current =
                        getRow(
                            $mod . '_tbl_' . $mod,
                            FALSE,
                            "WHERE " . $mod . "_cd = '{$sf_val}'"
                            )) {
                        $field['current'] =
                            array(
                            'id' => $current[$mod . '_cd'],
                            'current' => $current[$mod . 'type']
                            );
                    } else {
                        $field['current'] = FALSE;
                    }
                    $val = frmElem($field, $sf_key, $sf_val);
                    //try to get the current value
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
                // trigger (form)
                $trigger = "<form method=\"$form_method\" name=\"change_modtype_overlay_form\" id=\"change_modtype_overlay_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
                $trigger .= "<fieldset>";
                $trigger .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                $trigger .= "<input type=\"hidden\" name=\"overlay\" value=\"true\" />";
                $trigger .= "<input type=\"hidden\" name=\"sf_key\" value=\"{$sf_key}\" />";
                $trigger .= "<input type=\"hidden\" name=\"sf_val\" value=\"{$sf_val}\" />";
                $trigger .= "<input type=\"hidden\" name=\"lang\" value=\"{$lang}\" />";
                $trigger .= "<input type=\"hidden\" name=\"modtype\" value=\"{$target_modtype}\" />";
                $trigger .= "<input type=\"hidden\" name=\"lboxreload\" value=\"1\" />";
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
                // output
                echo "<h4>{$mk_reclabel}: {$sf_key} = {$sf_val}</h4>";
                echo "<p>{$mk_curmodtype}: {$modtype_alias} ({$modtype})</p>";
                echo "<p>{$mk_tgtmodtype}: {$target_modtype_alias} ({$target_modtype})</p>";
                // $mag the magnifying glass link
                $mag = "<a href=\"overlay_holder.php?overlay=true&amp;item_key={$item_key}&amp;{$item_key}={$$item_key}";
                $mag .= "&amp;sf_key={$sf_key}&amp;sf_val={$sf_val}&amp;modtype=$target_modtype&amp;";
                $mag .= "sf_conf=$conflict_res_sf&amp;lboxreload=0\">";
                $mag .= "<img src=\"$skin_path/images/plusminus/view.png\" alt=\"[view]\" class=\"med\" />";
                $mag .= "</a>\n";
                // a warning about conflicted sfs
                if ($num_modtype_sflist > 0) {
                    echo "<p>{$mk_numconflictsfs}: {$num_modtype_sflist} {$mag}</p>";
                    $warn = "<p class=\"message\">$mk_changewarn</p>\n";
                    echo "$warn";
                }
                if ($conflicted_frag_count > 0) {
                    echo "<p>{$mk_numconflictfrags}: {$conflicted_frag_count} {$mag}</p>";
                    $warn = "<p class=\"message\">$mk_conflictwarn</p>\n";
                    echo "$warn";
                }
                echo "$trigger\n";
            }
        }
        echo "</div>\n";
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_modtype\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_modtype was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;

} // ends switch

unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);

?>
