<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* describeSubforms.php    
*
* this is a wrapper page to used within the API architecture for get functions
* this page describes what subforms are available within the ARK instance
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
    foreach ($available_mods as $mod) {
        echo "$mod \n";
    }
    $errors = $errors + 1;
} else {
    $mod = splitItemKey($item_key);
}

//now check we have no errors - if so run the bad boy - this is basically a wrapper for the getSfs() function
if ($errors == 0) {
    
    //now run getSfs() for the mods

    if ($mod == 'all') {
        foreach ($available_mods as $looped_mod) {
            if ($looped_mod != 'all') {
                $looped_mod = splitItemKey($looped_mod);
                $data = getSfs($looped_mod);
                //now we need to check if there are any conditions on the SFs if there are and they are not satisfied (i.e.
                //the user is not authorised to see the form) then don't pull it back
                
                //DEV NOTE: This is calling for an itemkey and itemvalue - it is being sent spurious ones at the moment as they
                //          are not available in this script. This MAY cause problems...
                foreach ($data as $sf_key => $sf) {
                    // if the sf is conditional
                    if (array_key_exists('op_condition', $sf)) {
                        // check the condition - if not satisfied kill it out of the array
                        if (!chkSfCond($item_key, $$item_key, $sf['op_condition'])) {
                            unset($data[$sf_key]);
                        }
                    }
                }
                if (!empty($data)) {
                     $output_data[$looped_mod] = $data;
                }
            }
        }
    } else {
        $data = getSfs($mod);
        //now we need to check if there are any conditions on the SFs if there are and they are not satisfied (i.e.
        //the user is not authorised to see the form) then don't pull it back
        
        //DEV NOTE: This is calling for an itemkey and itemvalue - it is being sent spurious ones at the moment as they
        //          are not available in this script. This MAY cause problems...
        foreach ($data as $sf_key => $sf) {
            // if the sf is conditional
            if (array_key_exists('op_condition', $sf)) {
                // check the condition - if not satisfied kill it out of the array
                if (!chkSfCond($item_key, $$item_key, $sf['op_condition'])) {
                    unset($data[$sf_key]);
                }
            }
        }
        $output_data = $data;
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
