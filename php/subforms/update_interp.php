<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/update_interp.php
*
* Subform for updating the interp, paired with sf_interp
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
* @since      File available since Release 0.6
*/

// ---------- Evaluation ------------

// Assume no errors yet!
if (!$error) {
    $error = FALSE;
    $qrys = FALSE;
}

// Include the validation functions
include_once ('php/validation_functions.php');
if ($fields) {
    foreach ($fields AS $field) {
        if ($field['editable'] === TRUE) {
            // only run this if we have an edit function set up for the field and can get a qtype for it
            // we need to check if we have an xmi field - if so we need to append the xmi_op onto the classtype
            if($field['classtype'] == 'xmi_list' && array_key_exists('xmi_mod',$field)){
                $field['classtype'] = $field['classtype'] . '_' . $field['xmi_mod'];
            }
            if ($qtype = reqQst($_REQUEST, $field['classtype'].'_qtype')) {
                if ($field[$qtype.'_validation'] != 'none') {
                    // set up the basic info for this field
                    $qry['qtype'] = $qtype;
                    $qry['dataclass'] = $field['dataclass'];
                    if (!empty($field[$qtype.'_validation'])) {
                        // loop thru all the validation needed for this var (might be more than one per var)
                        foreach ($field[$qtype.'_validation'] AS $validation_vars) {
                            // set up the request function
                            $func = $validation_vars['rq_func'];
                            $temp_var_name = 'tvar_'.$validation_vars['var_name'];
                            // if it hasnt already been requested - request the var
                            if (!isset($$temp_var_name) && isset($func)) {
                                $$temp_var_name = $func($validation_vars, $field);
                            }
                            unset ($func);
                            // set up the validation function
                            $func = $validation_vars['vd_func'];
                            $v_res[$validation_vars['var_name']] = $func($$temp_var_name, $validation_vars, $field);
                            unset ($func);
                            unset ($$temp_var_name);
                            //check for errors
                            if (is_array($v_res[$validation_vars['var_name']])){
                                // if the v_res contains an error add it to the errors
                                if ($v_res[$validation_vars['var_name']]['err'] == 'on') {
                                    $error[] = $v_res[$validation_vars['var_name']];
                                    // also remove it from the array if previously added
                                    unset($qry[$validation_vars['var_name']]);
                                    // if not add it to the valid vars for this field
                                } elseif ($v_res[$validation_vars['var_name']]['err'] == 'skip') {
                                    // set a flag to make sure we don't add the query
                                    $skip = TRUE;
                                }
                            } else {
                                $qry[$validation_vars['var_name']] = $v_res[$validation_vars['var_name']];
                            }
                        }
                    }
                    //Now put the query vars for this field into the main row array and try the next field
                    if (!isset($skip)) {
                        $qrys[] = $qry;
                    }
                    unset($skip);
                }
                unset($qry);
                unset($qtype);
            } else {
                if (isset($field['alias_src_key'])) {
                    $name = $field['alias_src_key'];
                } else {
                    $name = 'BLANK';
                }
                $error[]['vars'] = "Config err:
                    qtype '$qtype' was not properly set
                    for '$name'<br/>
                ";
                unset ($name);
            }
        }
    }
} else {
    echo "update_db.php: fields array not set";
}
//check if this is an anonymous login - if it is then prevent the edits
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    $error[]['vars'] = "Sorry, you are not authorised to edit the data.";
}else{
 $dry_run = FALSE;   
}
// put this on for dev
if ($dry_run) {
    printPre($qrys);
}
// the query routine
if (!$error && $qrys && !$dry_run) {
    // loop once over the array to ensure that if this is a register set up the keys correctly
    foreach ($qrys as $key => $qry) {
        if ($qry['dataclass'] != 'txt') {
            $xqrys[] = $qry;
            unset($qrys[$key]);
        } else {
            // remve any spurious edit text routines
            if ($qry['qtype'] == 'edt') {
                $xqrys[] = $qry;
                unset($qrys[$key]);
            } else {
                // add new text (acting as itemkey)
                if ($qry['dataclass'] == 'txt') {
                    $qry_results[] =
                        addTxt(
                            $qry['txttype'],
                            $qry['itemkey'],
                            $qry['itemval'],
                            $qry['txt'],
                            $qry['lang'],
                            $qry['cre_by'],
                            $qry['cre_on']
                    );
                    if (!isset($qry_results[0][0]['new_id'])) {
                        $error[]['vars'] = "The ADD Text went wrong. Query halted";
                        $error[]['vars'] = "Failed SQL: <br/> {$qry_results[0]['failed_sql']}";
                    } else {
                        $new_key = $qry_results[0][0]['new_id'];
                    }
                unset($qrys[$key]);
                }
            }
        }
    }
    if (!$error) {
        // now execute all non remaining routines
        foreach ($xqrys as $xkey => $xqry) {
            if (isset($new_key)) {
                $xqry['itemval'] = $new_key;
                $xqry['itemkey'] = 'cor_tbl_txt';
            }
            // items - edt
            if ($xqry['dataclass'] == 'itemkey' && $xqry['qtype'] == 'edt') {
                if (array_key_exists('modtype', $xqry)) {
                    $qry_results[] =
                        edtItemKey(
                            $xqry['itemkey'],
                            $xqry['itemval'],
                            $xqry['cre_by'],
                            $xqry['cre_on'],
                            $xqry['modtype']
                    );
                } else {
                    $qry_results[] =
                        edtItemKey(
                            $xqry['itemkey'],
                            $xqry['itemval'],
                            $xqry['cre_by'],
                            $xqry['cre_on']
                    );
                }
                unset ($xqrys[$xkey]);
            }
            // ALL CLASSES - del
            if ($xqry['dataclass'] != 'delete' && $xqry['qtype'] == 'del') {
                $qry_results[] =
                    delFrag(
                        $xqry['dataclass'],
                        $xqry['frag_id'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // txt - edt
            if ($xqry['dataclass'] == 'txt' && $xqry['qtype'] == 'edt') {
                $qry_results[] =
                    edtTxt(
                        $xqry['frag_id'],
                        $xqry['txt'],
                        $xqry['lang'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // txt - add
            if ($xqry['dataclass'] == 'txt' && $xqry['qtype'] == 'add') {
                $qry_results[] =
                    addTxt(
                        $xqry['txttype'],
                        $xqry['itemkey'],
                        $xqry['itemval'],
                        $xqry['txt'],
                        $xqry['lang'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // number - edt
            if ($xqry['dataclass'] == 'number' && $xqry['qtype'] == 'edt') {
                $qry_results[] =
                    edtNumber(
                        $xqry['frag_id'],
                        $xqry['number'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // number - add
            if ($xqry['dataclass'] == 'number' && $xqry['qtype'] == 'add') {
                $qry_results[] =
                    addNumber(
                        $xqry['numbertype'],
                        $xqry['itemkey'],
                        $xqry['itemval'],
                        $xqry['number'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // date - edt
            if ($xqry['dataclass'] == 'date' && $xqry['qtype'] == 'edt') {
                $qry_results[] =
                    edtDate(
                        $xqry['date'],
                        $xqry['frag_id'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // date - add
            if ($xqry['dataclass'] == 'date' && $xqry['qtype'] == 'add') {
                $qry_results[] =
                    addDate(
                        $xqry['datetype'],
                        $xqry['itemkey'],
                        $xqry['itemval'],
                        $xqry['date'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // attr - add
            // attr, handle erroneous dataclass naming
            if ($xqry['dataclass'] == 'attr') {
                echo "ADMIN ERROR: as of v1.0 dataclass in fields must be declared as 'attribute' not 'attr'<br/>";
                $xqry['dataclass'] = 'attribute';
            }
            if ($xqry['dataclass'] == 'attribute' && $xqry['qtype'] == 'add') {
                $qry_results[] =
                    addAttr(
                        $xqry['attribute'],
                        $xqry['itemkey'],
                        $xqry['itemval'],
                        $xqry['cre_by'],
                        $xqry['cre_on'],
                        $xqry['bv']
                );
                unset ($xqrys[$xkey]);
            }
            // attr - edt
            if ($xqry['dataclass'] == 'attribute' && $xqry['qtype'] == 'edt') {
                $qry_results[] =
                    edtAttr(
                        $xqry['frag_id'],
                        $xqry['bv'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // action - add
            if ($xqry['dataclass'] == 'action' && $xqry['qtype'] == 'add') {
                $qry_results[] =
                    addAction(
                        $xqry['actiontype'],
                        $xqry['itemkey'],
                        $xqry['itemval'],
                        $xqry['actor_itemkey'],
                        $xqry['actor'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // action - edt
            if ($xqry['dataclass'] == 'action' && $xqry['qtype'] == 'edt') {
                $qry_results[] =
                    edtAction(
                        $xqry['frag_id'],
                        $xqry['actor_itemkey'],
                        $xqry['actor'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // span - add
            if ($xqry['dataclass'] == 'span' && $xqry['qtype'] == 'add') {
                $qry_results[] =
                    addSpan(
                        $xqry['spantype'],
                        $xqry['itemkey'],
                        $xqry['itemval'],
                        $xqry['beg'],
                        $xqry['end'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // span - edt
            if ($xqry['dataclass'] == 'span' && $xqry['qtype'] == 'edt') {
                $qry_results[] =
                    edtSpan(
                        $xqry['frag_id'],
                        $xqry['bv'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
            // xmi - add
            if ($xqry['dataclass'] == 'xmi' && $xqry['qtype'] == 'add') {
                $qry_results[] =
                    addXmi(
                        $xqry['itemkey'],
                        $xqry['itemval'],
                        $xqry['xmi_itemkey'],
                        $xqry['xmi_list'],
                        $xqry['ste_cd'],
                        $xqry['cre_by'],
                        $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
        }
    }
}

if (!$error && !isset($qry_results)) {
    $message[] = "No errors were present AND YET no query was executed";
}
if (!empty($xqrys)) {
    foreach ($xqrys as $xqry) {
        $message[] = "'{$xqry['qtype']}' '{$xqry['dataclass']}' was not executed (no handler in update_db?)";
    }
}
?>
