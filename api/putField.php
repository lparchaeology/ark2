<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* putField.php    
*
* this is a wrapper page to used within the API architecture for put functions
* this page acts as a wrapper for update_db and allows adds/edits/deletes
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
* @link       http://ark.lparchaeology.com/svn/api/putField.php
* @since      File available since Release 1.1
*/

//this file is included by the API wrapper page - the point of this page is enable adds/edits/deletes of
//frags programmtically

//PLEASE use this API carefully as it will actually do what it says and you may delete all your data!

// -- SETUP -- //

$all_fields = array();

// -- REQUESTS -- //

//as we are wrapping the API request for use within update_db we need to send the API certain things

//field_name - this is the name of the field we are trying to edit - this can be retrieved using describeFields()
$field_name = reqQst($_REQUEST,'field');
if (!$field_name) {
    echo "ADMIN ERROR: No field variable was specified";
    $errors = $errors + 1;
}
//we may also be trying to delete a frag - if we are then we want to send an update_db variable to the update_db script
$update_db = reqQst($_REQUEST,'update_db');
if (!$update_db) {
    $update_db = '';
}

$submiss_serial = $_SESSION['submiss_serial'];

//this is the type of return requested - the default is a JSON array
$format = reqQst($_REQUEST, 'format');
if (!$format) {
    $format = 'json';
}

// -- SETUP VARS -- //
$errors = 0;
$json_data = array();
$fields = array();
$output_data = array();

//check the parameters and if they are not valid provide feedback
//we will have to get the fields array for the specified module so first grab that

//first check if we are dealing with chained things - if we are then we're going to need to loop through 
//all the modules to get all the fields

$available_mods = getMulti('cor_tbl_module', '1', 'itemkey');
$available_mods[] = 'all';

if (substr($item_key,0,7) == 'cor_tbl' || substr($item_key,0,7) == 'cor_lut' || !$item_key ) {
    $req_mod = 'all';
} else {
    $req_mod = splitItemKey($item_key);
}

if ($req_mod == 'all' ) {
    // remove the cor table
    $available_mods = array_diff($available_mods, array("cor_cd"));
    
    foreach ($available_mods as $key => $looped_mod) {
        if ($looped_mod != 'all') {
            $looped_mod = splitItemKey($looped_mod);
            $data = getSfs($looped_mod);
            //now we need to check if there are any conditions on the SFs if there are and they are not satisfied (i.e.
            //the user is not authorised to see the form) then don't pull it back
            foreach ($data as $sf_key => $sf) {
                // if the sf is conditional
                if (array_key_exists('op_condition', $sf)) {
                    // check the condition - if not satisfied kill it out of the array
                    if (is_array($sf['op_condition'])&&splitItemKey($item_key)==$looped_mod){
                        if (!chkSfCond($item_key, $$item_key, $sf['op_condition'])) {
                            unset($data[$sf_key]);
                        }
                    }
                }
            }
            if (!empty($data)) {
                $fields = getFields($data);
            }
            
            if (!empty($fields)) {
                 $all_fields = $all_fields + $fields;
            }
        }
    }
} else {
    $data = getSfs($req_mod);
    //now we need to check if there are any conditions on the SFs if there are and they are not satisfied (i.e.
    //the user is not authorised to see the form) then don't pull it back
    foreach ($data as $sf_key => $sf) {
        // if the sf is conditional
        if (array_key_exists('op_condition', $sf)) {
            // check the condition - if not satisfied kill it out of the array
            if (is_array($sf['op_condition'])){
                if (!chkSfCond($item_key, $$item_key, $sf['op_condition'])) {
                    unset($data[$sf_key]);
                }
            }
        }
    }
    $all_fields = getFields($data);
}


if ($all_fields) {
    //now check that the type is one of the accepted ones - if so load it up into the fields array
    if (!array_key_exists($field_name,$all_fields)) {
        echo "ADMIN ERROR: it would seem that $field_name is not a valid field for module $req_mod or your user does not have access to it\n";
        $errors = $errors + 1;
    } else {
        unset($fields);
        $fields[] = $all_fields[$field_name];
    }
} else {
    echo "ADMIN ERROR: it seems there are no fields available for the specified module ($req_mod)\n";
    $errors = $errors + 1;
}

//now check we have no errors - if so run the bad boy
if ($errors == 0) {
    
    //we have a set of clean fields - so run them through the update_db script
    include_once ('php/update_db.php');
    $output_data['messages'] = $message;
    $output_data['errors'] = $error;
    if(isset($qry_results)){
        $output_data['qry_results'] = $qry_results;
    }
}

if ($output_data) {
    switch ($format) {
        case 'json':
            //we need to pretty up the JSON
            $output_data = json_encode($output_data);
            header('Content-Type: application/json');
            echo $output_data;
            break;

        default:
            printPre($output_data);
            break;
    }
}


?>
