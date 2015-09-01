<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* describeItems.php    
*
* this is a wrapper page to used within the API architecture for get functions
* this page describes what modules are available within the ARK instance
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
* @link       http://ark.lparchaeology.com/svn/api/describeItems.php
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

$data = getMulti('cor_tbl_module', '1=1');

//now check we have no errors - if so run the bad boy - this is basically a wrapper for the getAllItems() function
if ($errors == 0) {
    //grab the aliases for the modules
    $alias_type = reqQst($_REQUEST,'alias_type');
    if (!$alias_type) {
        $alias_type = 1;
    }
    if ($data) {
        foreach ($data as $key => $value) {
            $aliases = getAllAliases("cor_tbl_module", 'id', $value['id'], $alias_type);
            $data[$key]['aliases'] = $aliases;
        }
    }
    $output_data = $data;

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
