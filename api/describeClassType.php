<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* describeARK.php    
*
* this is a wrapper page to used within the API architecture to get
* some metadata about the ARK instance
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
* @link       http://ark.lparchaeology.com/svn/api/describeARK.php
* @since      File available since Release 1.1
*/

//this file is included by the API wrapper page

// -- REQUESTS -- //

$format = reqQst($_REQUEST, 'format');

if (!$format) {
    $format = 'json';
}

// -- SETUP VARS -- //
$errors = 0;
$class = reqQst($_REQUEST, 'class');
if ($class){
    $lut= "cor_lut_{$class}type";
    $data = getAllClasstypeAlias($lut, $lang);
} else {
    $errors = 1;
}

//now check we have no errors
if ($errors == 0) {
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
} else {
    echo "There was a problem with your request.";
}


?>
