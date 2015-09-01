<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* describeFrags.php    
*
* this is a wrapper page to used within the API architecture for GET functions
* this page describes the data fragments available to query
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
* @link       http://ark.lparchaeology.com/svn/api/describeFrags.php
* @since      File available since Release 1.1
*/

//this file is included by the API wrapper page - the point of this page is to describe the possible data available for data fragments
//that can be read programmtically. 

// -- REQUESTS -- //

$dataclass = reqQst($_REQUEST,'dataclass');
$classtype = reqQst($_REQUEST,'classtype');
$aliased = reqQst($_REQUEST,'aliased');

$format = reqQst($_REQUEST, 'format');

if (!$format) {
    $format = 'json';
}

// -- SETUP VARS -- //
$errors = 0;
$accepted_classes = array('action','attribute', 'date', 'span', 'txt', 'number','alias','file','all');
$output_data = array();

//check the parameters and if they are not valid provide feedback
if ($dataclass) {
    //now check that the type is one of the accepted ones
    if (!in_array($dataclass,$accepted_classes)) {
        echo "ADMIN ERROR: There is currently no handler for the requested dataclass. Valid datalasses are: 'action','attribute', 'date', 'span', 'txt', 'number', 'alias'\n";
        $errors = $errors + 1;
    }
} else {
    echo "ADMIN ERROR: You must supply a dataclass requested using the 'dataclass' parameter in the querystring - please see documentation\n";
    $errors = $errors + 1;
}


//now check we have no errors - if so run the bad boy - this is basically a wrapper for the getMetadataByClass() function
if ($errors == 0) {
    //there is special dataclass function called 'all' - this will return a list of all the datafrag types 
    //available within this ARK instance - otherwise just go with the specified dataclass
    if ($dataclass == 'all') {
        foreach ($accepted_classes as $accepted_class) {
            if ($accepted_class != 'all') {
                $data = getMetadataByClass($accepted_class);
                if ($aliased) {
                    $alias_lang = reqQst($_REQUEST,'alias_lang');
                    if ($alias_lang == FALSE) {
                        $alias_lang = $lang;
                    }
                    $alias_type = reqQst($_REQUEST,'alias_type');
                    if (!$alias_type) {
                       $alias_type = 1;
                    }
                    if ($data) {
                        foreach ($data as $key => $value) {
                            $dataclass = $value['dataclass'];
                            $dataclasstype = $value[$dataclass . "type"];
                            $aliases = getAllAliases("cor_lut_$dataclass" . 'type', $dataclass . "type", $dataclasstype, $alias_type);
                            $data[$key]['aliases'] = $aliases;
                        }
                    }
                }
                $output_data[$accepted_class] = $data;
            }
        }
    } elseif ($dataclass == 'attribute') {
        //if we are looking to describe attributes then we may also want to list out the attributes themselves (not just the types)
        //we check this by seeing if a classtype has been sent - if it has then use this to list out the attributes - otherwise just
        //list the types as normal
        if ($classtype) {
            if (!is_numeric($classtype)) {
                $classtype = getClassType('attribute',$classtype);
            }
            $data = getMulti('cor_lut_attribute', "attributetype = $classtype");
            if ($aliased) {
                $alias_type = reqQst($_REQUEST,'alias_type');
                if (!$alias_type) {
                   $alias_type = 1;
                }
                if ($data) {
                    foreach ($data as $key => $value) {
                        $aliases = getAllAliases("cor_lut_attribute", 'id', $value['id'], $alias_type);
                        $data[$key]['aliases'] = $aliases;
                    }
                }
            }
            $output_data[getClassType('attribute',$classtype)] = $data;
        } else {
            $data = getMetadataByClass($dataclass);
            if ($aliased) {
                $alias_type = reqQst($_REQUEST,'alias_type');
                if (!$alias_type) {
                   $alias_type = 1;
                }
                if ($data) {
                    foreach ($data as $key => $value) {
                        $dataclass = $value['dataclass'];
                        $dataclasstype = $value[$dataclass . "type"];
                        $aliases = getAllAliases("cor_lut_$dataclass" . 'type', $dataclass . "type", $dataclasstype, $alias_type);
                        $data[$key]['aliases'] = $aliases;
                    }
                }
            }
            $output_data[$dataclass] = $data;
        }
   } else {
         $data = getMetadataByClass($dataclass);
            if ($aliased) {
                $alias_lang = reqQst($_REQUEST,'alias_lang');
                if ($alias_lang == FALSE) {
                    $alias_lang = $lang;
                }
                $alias_type = reqQst($_REQUEST,'alias_type');
                if (!$alias_type) {
                   $alias_type = 1;
                }
                if ($data) {
                    foreach ($data as $key => $value) {
                        $dataclass = $value['dataclass'];
                        $dataclasstype = $value[$dataclass . "type"];
                        $aliases = getAllAliases("cor_lut_$dataclass" . 'type', $dataclass . "type", $dataclasstype, $alias_type);
                        $data[$key]['aliases'] = $aliases;
                    }
                }
            }
        $output_data[$dataclass] = $data;       
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
