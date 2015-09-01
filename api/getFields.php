<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* getField.php    
*
* this is a wrapper page to used within the API architecture for get functions
* this page retrieves the value of a field attached to an item
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
* @link       http://ark.lparchaeology.com/svn/api/getField.php
* @since      File available since Release 1.1
*/

//this file is included by the API wrapper page - the point of this page is to return data from the get functions
//that can be read programmtically. 

//this mainly uses the resRdCurr() function - but can also pull back aliases if the correct params are sent

// -- REQUESTS -- //

//this can be sent as an array in the querystring, if it is sent as a single value pop it into an array anyway
//to make processing easier

$field_name = reqQst($_REQUEST,'fields');
if (!is_array($field_name)) {
    $field_names[] = $field_name;
} else {
    $field_names = $field_name;
}

$aliased = reqQst($_REQUEST,'aliased');

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
$mod = splitItemKey($item_key);
$sfs = getSfs($mod);

if ($$item_key == 'all') {
    $all_items = getAllItems($mod);
}
if ($mod == 'all' ) {
    foreach ($available_mods as $looped_mod) {
        if ($looped_mod != 'all') {
            $looped_mod = splitItemKey($looped_mod);
            $data = getSfs($looped_mod);
            //now we need to check if there are any conditions on the SFs if there are and they are not satisfied (i.e.
            //the user is not authorised to see the form) then don't pull it back
            
            foreach ($data as $sf_key => $sf) {
                // if the sf is conditional
                if (array_key_exists('op_condition', $sf) && is_array($sf['op_condition'])) {
                    // check the condition - if not satisfied kill it out of the array
                    if (!chkSfCond($item_key, $$item_key, $sf['op_condition'])) {
                        unset($data[$sf_key]);
                    }
                }
            }
        }
    }
} else {
    foreach ($sfs as $sf_key => $sf) {
        // if the sf is conditional
        if (array_key_exists('op_condition', $sf) && is_array($sf['op_condition'])) {
            // check the condition - if not satisfied kill it out of the array
            if (!chkSfCond($item_key, $$item_key, $sf['op_condition'])) {
                unset($sfs[$sf_key]);
            }
        }
    }
}

if (!empty($sfs)) {
    $all_fields = getFields($sfs);
} else {
    echo "ADMIN ERROR: it would seem the item_key is not valid or you do not have access to that/those field(s)";
    $errors = $errors + 1;
}

if ($all_fields) {
    //now check that the type is one of the accepted ones - if so load it up into the fields array
    foreach ($field_names as $field_name) {
        if (!array_key_exists($field_name,$all_fields)) {
            echo "ADMIN ERROR: it would seem that $field_name is not a valid field for module $mod or your user does not have access to it\n";
            $errors = $errors + 1;
        } else {
            $fields[] = $all_fields[$field_name];
        }
    }
} else {
    echo "ADMIN ERROR: it seems there are no fields available for the specified module ($mod)\n";
    $errors = $errors + 1;
}

//now check we have no errors - if so run the bad boy - this is basically a wrapper for the getChData() function
if ($errors == 0) {
    //if we are looking for the field[s] for all the items we need to loop this
    if ($$item_key == 'all') {
        //first check if we want these fields aliased - if we do send it resTblTh()
        if ($aliased) {
            $fields = resTblTh($fields);
        }
         foreach ($fields as $key => $field) {
             //now we go through the fields array getting the values
             foreach ($all_items as $item) {
                 $values = resFdCurr($field, $item_key, $item[$item_key]);
                 //add the alias if we have it
                 if ($aliased) {
                     //there is a special case here for attributes as it is useful to retrieve the alias of the attribute as well
                     $values['aliases'][$lang] = $field['field_alias'];
                 }
                 $field_id = $field['field_id'];
                 $output_data[$item[$item_key]][$field_id] = $values;
             }
          }
    } else {
        //first check if we want these fields aliased - if we do send it resTblTh()
        if ($aliased) {
            $fields = resTblTh($fields);
        }
        //now we go through the fields array getting the values
        foreach ($fields as $key => $field) {
            $values = resFdCurr($field, $item_key, $$item_key);
            //add the alias if we have it
            if ($aliased) {
                //there is a special case here for attributes as it is useful to retrieve the alias of the attribute as well
                $values['aliases'][$lang] = $field['field_alias'];
            }
            $output_data[] = $values;
        }
        
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


?>
