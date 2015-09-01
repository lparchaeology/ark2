<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* describeFields.php    
*
* this is a wrapper page to used within the API architecture for get functions
* this page describes what fields are available within the ARK instance
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
* @category   api
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/api/describeSubforms.php
* @since      File available since Release 1.1
*/

//this file is included by the API wrapper page - the point of this page is to return data from the get functions
//that can be read programmtically. 

// -- REQUESTS -- //

$format = reqQst($_REQUEST, 'format');

if (!$format) {
    $format = 'json';
}

// -- SETUP VARS -- //
$errors = 0;
$output_data = array();

//as we will  be getting a list of subforms per module - we need to check that the supplied itemkey is valid

$available_mods = getMulti('cor_tbl_module', '1=1', 'itemkey');
$available_mods[] = 'all';

//check the parameters and if they are not valid provide feedback
if (!in_array($item_key,$available_mods)) {
    //now check that the type is one of the accepted ones
    echo "ADMIN ERROR: The itemkey you have requested is not valid, valid itemkeys from this ARK instance are:\n";
    foreach ($available_mods as $req_mod) {
        echo "$req_mod \n";
    }
    $errors = $errors + 1;
} else {
    $req_mod = splitItemKey($item_key);
}

//now check we have no errors - if so run the bad boy - this is basically a wrapper for the getSfs() function
if ($errors == 0) {
    
    //now run getSfs() for the mods

    if ($req_mod == 'all') {
        foreach ($available_mods as $looped_mod) {
            if ($looped_mod != 'all') {
                $looped_mod = splitItemKey($looped_mod);
                $data = getSfs($looped_mod);
                //now we need to check if there are any conditions on the SFs if there are and they are not satisfied (i.e.
                //the user is not authorised to see the form) then don't pull it back
                
                //DEV NOTE: This is calling for an itemkey and itemvalue - it is being sent spurious ones at the moment as they
                //          are not available in this script. This MAY cause problems...
//                 foreach ($data as $sf_key => $sf) {
//                     // if the sf is conditional
//                     if (array_key_exists('op_condition', $sf) && is_array($sf['op_condition'])) {
//                         // check the condition - if not satisfied kill it out of the array
//                         if (!chkSfCond($item_key, $$item_key, $sf['op_condition'])) {
//                             unset($data[$sf_key]);
//                         }
//                     }
//                 }
                if (!empty($data)) {
                    $fields = getFields($data);
                }
                
                if (!empty($fields)) {
                     $output_data = $output_data + $fields;
                }
            }
        }
    } else {
        $data = getSfs($req_mod);
        //now we need to check if there are any conditions on the SFs if there are and they are not satisfied (i.e.
        //the user is not authorised to see the form) then don't pull it back
        
        //DEV NOTE: This is calling for an itemkey and itemvalue - it is being sent spurious ones at the moment as they
        //          are not available in this script. This MAY cause problems...
        foreach ($data as $sf_key => $sf) {
            // if the sf is conditional
            if (array_key_exists('op_condition', $sf) && is_array($sf['op_condition'])) {
                // check the condition - if not satisfied kill it out of the array
                if (!chkSfCond($item_key, $$item_key, $sf['op_condition'])) {
                    unset($data[$sf_key]);
                }
            }
        }
        $output_data = getFields($data);
    }
    
    //in order to make this more useful for the putField() API call we can parse the vd_functions and let the API user
    //know what querystring requests putField might need.
    
    foreach ($output_data as $key => $field) {
        //first the add validation
        if (array_key_exists('add_validation',$field) && is_array($field['add_validation'])) {
            //first figure out the user-admin'd required variables
            foreach ($field['add_validation'] as $vd) {
                if (array_key_exists('var_locn',$vd) && $vd['var_locn'] == 'request') {
                    if ($vd['lv_name'] == 'dyn_field' || $vd['lv_name'] == 'dyn_field_suffix') {
                        //throw in a catch here for chkSkipBlank - DEV NOTE: This is to deal with inconsistent behaviour in vd_funcs
                        if ($vd['vd_func'] == 'chkSkipBlank') {
                            $output_data[$key]['add_variables'][] = $field['classtype'];
                        } else {
                            $output_data[$key]['add_variables'][] = $field['classtype'] . '_' .$vd['var_name'];
                        }
                    } else {
                        $output_data[$key]['add_variables'][] = $vd['var_name'];
                    }
                }
            }
            //now add in the qtype
            $output_data[$key]['add_variables'][] = $field['classtype']. '_qtype';
            //and lastly remind about the need for the itemkey and field name
            $output_data[$key]['add_variables'][] = 'field';
            $output_data[$key]['add_variables'][] = 'item_key';
        }
        //next do the edt validation
        if (array_key_exists('edt_validation',$field) && is_array($field['edt_validation'])) {
            //first figure out the user-admin'd required variables
            foreach ($field['edt_validation'] as $vd) {
                if (array_key_exists('var_locn',$vd) && $vd['var_locn'] == 'request') {
                    if ($vd['lv_name'] == 'dyn_field' || $vd['lv_name'] == 'dyn_field_suffix') {
                        //throw in a catch here for chkSkipBlank - DEV NOTE: This is to deal with inconsistent behaviour in vd_funcs
                        if ($vd['vd_func'] == 'chkSkipBlank') {
                            $output_data[$key]['edt_variables'][] = $field['classtype'];
                        } else {
                            $output_data[$key]['edt_variables'][] = $field['classtype'] . '_' .$vd['var_name'];
                        }
                    } elseif ($vd['var_name'] == 'frag_id') {
                        $output_data[$key]['edt_variables'][] = $field['classtype']. '_id';
                    } else {
                        $output_data[$key]['edt_variables'][] = $vd['var_name'];
                    }
                }
            }
            //now add in the qtype
            $output_data[$key]['edt_variables'][] = $field['classtype']. '_qtype';
            //and lastly remind about the need for the itemkey and field name
            $output_data[$key]['edt_variables'][] = 'field';
            $output_data[$key]['edt_variables'][] = 'item_key';
        }
    }

    if ($output_data) {
        switch ($format) {
            case 'json':
                //we need to pretty up the JSON
                $output_data = json_encode($output_data);
                header('Content-Type: application/json');;
                echo $output_data;
                break;

            default:
                printPre($output_data);
                break;
        }
    }    
}


?>
