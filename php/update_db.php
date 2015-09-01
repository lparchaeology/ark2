<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* update_db.php
*
* executes all the functions to update the database
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
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See thea
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @category   base
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/update_db.php
* @since      File available since Release 0.6
*/

//The universal update script
//     This script provides validation and db access for the forms
//      
//      The field list for each form is required to be sent to this script as $fields
//        This script simply loops through each field checks for validity if valid executes to db
// Requires and assumes itemkey and mod settings is being handle properly elsewhere

// ---------- Evaluation ------------

// Assume no errors yet!
if (!$error) {
    $error = FALSE;
    $qrys = FALSE;
}

// the delete routine is the same for all dataclasses
if ($update_db === 'delfrag' && $del_dataclass = reqQst($_REQUEST, 'dclass')) {
    unset($fields);
    $conf_field_delete['dataclass'] = $del_dataclass;
    $fields[] = $conf_field_delete;
}

// Include the validation functions
include_once ('php/validation_functions.php');

// If the fields are set up loops over them
if ($fields) {
    //first check if we are on a multi    
    foreach ($fields as $field) {
        //first check if we have a multi routine - if so we need to add more fields
        if (reqQst($_REQUEST, $field['classtype']) == 'multi') {
            foreach ($_REQUEST as $key => $value) {     
               $exploded_key = explode('-',$key);
               if (array_key_exists(1,$exploded_key) && is_numeric($exploded_key[1])) {
                    //insert the fields into the field array
                    $insert_field = $field;
                    $insert_field['classtype'] = $key;
                    $insert_field['multi'] = TRUE;
                    $fields[] = $insert_field;
                    //we now need to ensure we have a qtype in the $_REQUEST array
                    if ($temp_qtype = reqQst($_REQUEST, $field['classtype'].'_qtype')) {
                        $_REQUEST[$key.'_qtype'] = $temp_qtype;
                    }
                    //we also need to check if this has a boolean value - if so we need to add it also
                    if ($temp_bv = reqQst($_REQUEST, $field['classtype'].'_bv')) {
                        $_REQUEST[$key.'_bv'] = $temp_bv;
                    }
               }
            }
            //now set the original as qtype as skp
            $_REQUEST[$field['classtype'].'_qtype'] = 'skp';
        }
    }//end of multi check
    foreach ($fields as $field) {
        if ($field['editable'] === TRUE) {
            // only run this if we have an edit function set up for the field and can get a qtype for 
            // it we need to check if we have an xmi field - if so we need to append the xmi_op onto 
            // the classtype
            if($field['classtype'] == 'xmi_list' && array_key_exists('xmi_mod', $field)){
                $field['classtype'] = $field['classtype'] . '_' . $field['xmi_mod'];
            }
            if ($qtype = reqQst($_REQUEST, $field['classtype'].'_qtype')) {
                // We have two was to skip out of validation either from the field settings or the qtype
                if (array_key_exists($qtype . '_validation',$field)) {
                    if ($field[$qtype.'_validation'] != 'none' && $qtype != 'skp') {
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
                                if (!isset($$temp_var_name)) {
                                    $$temp_var_name = $func($validation_vars, $field);
                                }
                                unset ($func);
                                // set up the validation function
                                $func = $validation_vars['vd_func'];
                                $v_res[$validation_vars['var_name']] =
                                    $func(
                                        $$temp_var_name,
                                        $validation_vars,
                                        $field
                                );
                                unset ($func);
                                unset ($$temp_var_name);
                                // if the v_res contains an error add it to the errors
                                if (is_array($v_res[$validation_vars['var_name']])){
                                    if (array_key_exists('err', $v_res[$validation_vars['var_name']])){
                                        if ($v_res[$validation_vars['var_name']]['err'] == 'on') {
                                            $error[] = $v_res[$validation_vars['var_name']];
                                            // also remove it from the array if previously added
                                            unset($qry[$validation_vars['var_name']]);
                                            // if not add it to the valid vars for this field
                                        } elseif ($v_res[$validation_vars['var_name']]['err'] == 'skip') {
                                            // set a flag to make sure we don't add the query
                                            $skip = TRUE;
                                        }
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
    $message[] = "update_db.php: the fields array is not set";
}

// ANON LOGINS
//check if this is an anonymous login - if it is then prevent the edits
// DEV NOTE: This should be a full blown security check, per user per SF (see also micro_view.php)
// DEV NOTE: see ticket #207
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_notauthforedit');
    $anon_login = TRUE;
} else {
    $anon_login = FALSE;
}

// UNIQUE SUBMISSION (no reloads)
// excluding delfrag requests, check to see if this form submission is unique
// request the latest serial from this user's session
$latest_submiss_serial = reqQst($_SESSION, 'submiss_serial');
if ($update_db != 'delfrag') {
    if ($submiss_serial != $latest_submiss_serial) {
        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_formresubmit');
        $dry_run = 1;
        $resubmit = 1;
    } else {
        $dry_run = 0;
        $resubmit = 0;
    }
} else {
    $dry_run = 0;
    $resubmit = 0;
}

// DEBUG
if ($dry_run && !$anon_login && !$resubmit) {
    printPre($qrys);
}
// RUN
// the query routine
if (!$error && $qrys && !$dry_run && !$anon_login) {
    // loop once over the array to ensure that if this is a register set up the keys correctly
    foreach ($qrys as $key => $qry) {
        if ($qry['dataclass'] != 'itemkey') {
            $xqrys[] = $qry;
            unset($qrys[$key]);
        } else {
            // remove any spurious edit itemkey routines
            if ($qry['qtype'] == 'edt') {
                //$xqrys[] = $qry;
                // See note below and remove obsolete code in line above this comment at v1.0
                unset($qrys[$key]);
            } else {
                // add new itemkeys
                if ($qry['dataclass'] == 'itemkey') {
                    if (array_key_exists('modtype', $qry)) {
                        $qry_results[] =
                            addItemKey(
                                $qry['itemkey'],
                                $qry['itemval'],
                                $qry['cre_by'],
                                $qry['cre_on'],
                                $qry['modtype']
                        );
                        if (!isset($qry_results[0]['new_itemvalue'])) {
                            $error[]['vars'] = "The ADD Itemkey went wrong. Query halted";
                            $error[]['vars'] = "Failed SQL: <br/> {$qry_results[0]['failed_sql']}";
                        } else {
                            $new_key = $qry_results[0]['new_itemvalue'];
                        }
                    } else {
                        $qry_results[] =
                            addItemKey(
                                $qry['itemkey'],
                                $qry['itemval'],
                                $qry['cre_by'],
                                $qry['cre_on']
                        );
                        if (!isset($qry_results[0]['new_itemvalue'])) {
                            $error[]['vars'] = "The ADD Itemkey went wrong. Query halted";
                            $error[]['vars'] = "Failed SQL: <br/> {$qry_results[0]['failed_sql']}";
                        } else {
                            $new_key = $qry_results[0]['new_itemvalue'];
                        }
                    }
                unset ($qrys[$key]);
                }
            }
        }
    }
    if (!$error && isset($xqrys)) {
        // now execute all non remaining routines
        foreach ($xqrys as $xkey => $xqry) {
            
            if (isset($new_key)) {
                $xqry['itemval'] = $new_key;
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
                //clean out the temp fields array
                unset ($fields);
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
            // attr, handle erroneous dataclass naming
            if ($xqry['dataclass'] == 'attr') {
                echo "ADMIN ERROR: as of v1.0 dataclass in fields must be declared as 'attribute' not 'attr'<br/>";
                $xqry['dataclass'] = 'attribute';
            }
            // attr - add
            if ($xqry['dataclass'] == 'attribute' && $xqry['qtype'] == 'add') {
                $qry_results[] =
                    addAttr(
                        $xqry['attribute'],
                        $xqry['itemkey'],
                        $xqry['itemval'],
                        $xqry['cre_by'],
                        $xqry['cre_on'],
                        1 //needs fixing
                );
                unset ($xqrys[$xkey]);
            }
            // attr - edt
            if ($xqry['dataclass'] == 'attribute' && $xqry['qtype'] == 'edt') {
                $qry_results[] =
                    edtAttr(
                        $xqry['attribute'],
                        $xqry['bv'],
                        $xqry['frag_id'],
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
                        $xqry['beg'],
                        $xqry['end'],
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
            // xmi - edt
            if ($xqry['dataclass'] == 'xmi' && $xqry['qtype'] == 'edt') {
                $qry_results[] =
                    edtXmi(
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
            //file - add
            if($xqry['dataclass'] == 'file' && $xqry['qtype'] == 'add') {
   
                $file_explode = explode(" ", $xqry['file'][0]);
                
                foreach ($file_explode as $key => $value) {
                    $qry_results[]=
                         addFile(
                              $xqry['itemkey'],
                              $xqry['itemval'],
                              $value,
                              $xqry['cre_by'],
                              $xqry['cre_on']
                    );
                }
                unset ($xqrys[$xkey]);
            }
            //file - edt
            if($xqry['dataclass'] == 'file' && $xqry['qtype'] == 'edt') {
               // $file_explode = explode(" ", $xqry['file']);
                $qry_results[]=
                         edtFile(
                              $xqry['itemkey'],
                              $xqry['itemval'],
                              $xqry['file'],
                              $xqry['cre_by'],
                              $xqry['cre_on']
                );
                unset ($xqrys[$xkey]);
            }
        }
    }
}

if (!$error) {
    if (isset($qry_results)) {
        $message[] = getMarkup('cor_tbl_markup', $lang, 'updatesucc');
    } else {
        $message[] = getMarkup('cor_tbl_markup', $lang, 'andyet');
    }
}
if (!empty($xqrys)) {
    foreach ($xqrys as $xqry) {
        $message[] = "'{$xqry['qtype']}' '{$xqry['dataclass']}' was not executed (no handler in update_db?)";
    }
}

// if we were on a multi routine - we need to clear the temporary fields out of the fields array
if (!empty($fields)) {
    foreach ($fields as $key => $field) {
        if (array_key_exists('multi',$field)) {
            unset($fields[$key]);
        }
    }
}

// after every update, change the submission serial for this session to prevent reloads
$_SESSION['submiss_serial'] = rand(1000000,9999999);

?>
