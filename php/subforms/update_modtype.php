<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/update_modtype.php
*
* process script for updating the modtype of an item (paired with sf)
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_interp.php
* @since      File available since Release 0.8
*/

// ---------- Evaluation ------------

// Assume no errors yet!
if (!$error) {
    $error = FALSE;
    $qrys = FALSE;
}

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
            if ($field['dataclass'] == 'attr') {
                echo "ADMIN ERROR: as of v1.0 dataclass in fields must be declared as 'attribute' not 'attr'<br/>";
                $field['dataclass'] = 'attribute';
            }
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

// Include the validation functions
include_once ('php/validation_functions.php');

// ---- QUERIES ---- //
// if there are no frags to handle, go straight to the itemkey
if (!isset($conflicted_frags) or !is_array($conflicted_frags) or count($conflicted_frags) < 1) {
    $qrys = FALSE;
    // check to see if this item code is valid
    $mod = splitItemkey($sf_key);
    if (!chkValid($sf_val, FALSE, FALSE, $mod.'_tbl_'.$mod, $sf_key)) {
        // add in the item
        $qry =
            array(
                'qtype' => 'edt',
                'dataclass' => 'modtype',
                'itemkey' => $sf_key,
                'itemval' => $sf_val,
                'cre_by' => $user_id,
                'cre_on' => 'NOW()',
                'modtype' => $target_modtype
        );
        $qrys[] = $qry;
    } else {
        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_notvalid');
    }
// otherwise, handle the frags first then the item
} else {
    // loop over each conflicted frag
    foreach ($conflicted_frags as $key => $frag) {
        $qry =
            array(
                'qtype' => 'del',
                'dataclass' => $frag['dataclass'],
                'frag_id' => $frag['id'],
                'cre_by' => $user_id,
                'cre_on' => 'NOW()'
        );
        $qrys[] = $qry;
    }
    // finally add in the item itself
    // check to see if this is a proper item
    if (isItemkey($sf_key)) {
        // for itemkeys put in a query as follows
        $qry =
            array(
                'qtype' => 'edt',
                'dataclass' => 'modtype',
                'itemkey' => $sf_key,
                'itemval' => $sf_val,
                'cre_by' => $user_id,
                'cre_on' => 'NOW()',
                'modtype' => $target_modtype
        );
        $qrys[] = $qry;
    }
}

//check if this is an anonymous login - if it is then prevent the edits
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']) {
    $error[]['vars'] = "Sorry, you are not authorised to edit the data.";
} else {
    $dry_run = FALSE;   
}
// put this on for dev
if ($dry_run) {
    printPre($qrys);
}
// the query routine
if (!$error && $qrys && !$dry_run) {
    if (!$error) {
        // execute the delete frag routines
        foreach ($qrys as $key => $qry) {
            // ALL CLASSES - del
            if ($qry['dataclass'] != 'delete' && $qry['qtype'] == 'del') {
                $qry_results[] =
                    delFrag(
                        $qry['dataclass'],
                        $qry['frag_id'],
                        $qry['cre_by'],
                        $qry['cre_on']
                );
                unset ($qrys[$key]);
            }
            // items - edt
            if ($qry['dataclass'] == 'itemkey' && $qry['qtype'] == 'edt' || $qry['dataclass'] == 'modtype') {
                $qry_results[] =
                    edtItemKey(
                        $qry['itemkey'],
                        $qry['itemval'],
                        $qry['cre_by'],
                        $qry['cre_on'],
                        $qry['modtype']
                );
                unset ($qrys[$key]);
            }
        }
    }
}

if (!$error && !isset($qry_results)) {
    $message[] = getMarkup('cor_tbl_markup', $lang, 'andyet');
}
if (!empty($qrys) && !$dry_run) {
    foreach ($qrys as $qry) {
        $message[] = "'{$qry['qtype']}' '{$qry['dataclass']}' was not executed (no handler in update_modtype?)";
    }
}

$res = array_pop($qry_results);
if (isset($qry_results) && $res['success']) {
    $message[] = getMarkup('cor_tbl_markup', $lang, 'modtypechanged');
    $changemodtype_success = TRUE;
} else {
    $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_modtypefail');    
    $changemodtype_success = FALSE;
}

?>
