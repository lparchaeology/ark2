<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* getFrags.php    
*
* this is a wrapper page to used within the API architecture for get functions
* this page retrieves data fragments attached to an item
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
* @link       http://ark.lparchaeology.com/svn/api/getFrags.php
* @since      File available since Release 1.1
*/

//this file is included by the API wrapper page - the point of this page is to return data from the get functions
//that can be read programmtically. 

//this mainly uses the getChData function - but can also pull back aliases if the correct params are sent

$json = TRUE;

// -- REQUESTS -- //

$dataclass = reqQst($_REQUEST,'dataclass');
$classtype = reqQst($_REQUEST,'classtype');

if ($classtype && !is_numeric($classtype)) {
    $classtype = getClassType($dataclass,$classtype);
}

$aliased = reqQst($_REQUEST,'aliased');

// -- SETUP VARS -- //
$errors = 0;
$accepted_classes = array('action','attribute', 'date', 'span', 'txt', 'number', 'xmi','alias','file','all');
$json_data = array();

//check the parameters and if they are not valid provide feedback
if ($dataclass) {
    //now check that the type is one of the accepted ones
    if (!in_array($dataclass,$accepted_classes)) {
        echo "ADMIN ERROR: There is currently no handler for the requested dataclass. Valid datalasses are: 'action','attribute', 'date', 'span', 'txt', 'number', 'xmi','alias'\n";
        $errors = $errors + 1;
    }
} else {
    echo "ADMIN ERROR: You must supply a dataclass requested using the 'dataclass' parameter in the querystring - please see documentation\n";
    $errors = $errors + 1;
}


//now check we have no errors - if so run the bad boy - this is basically a wrapper for the getChData() function
if ($errors == 0) {
    //first deal with aliases as a special case
    if ($dataclass == 'alias') {
        //if we have an alias request then we need some other variables to be sent
        $alias_tbl = reqQst($_REQUEST,'alias_tbl');
        $alias_lang = reqQst($_REQUEST,'alias_lang');
        if ($alias_lang == FALSE) {
            $alias_lang = $lang;
        }
        $alias_col = reqQst($_REQUEST,'alias_col');
        $alias_src_key = reqQst($_REQUEST,'alias_src_key');
        $alias_type = reqQst($_REQUEST,'alias_type');
        if (!$alias_type) {
           $alias_type = 1;
        }
        //now check we have all the variables - if so run the function
        if ($alias_tbl && $alias_lang && $alias_col && $alias_src_key && $alias_type) {
            $alias = getAlias($alias_tbl,$alias_lang,$alias_col,$alias_src_key,$alias_type);
            echo $alias;
        } else {
            echo "ADMIN ERROR: You do not have enough arguments for the alias function. You need alias_tbl, alias_lang, alias_col, alias_src_key and alias_type";
        }
    } else {
        //there is  special dataclass function called 'all' - this will return all of the datafrags attached to an 
        //item - otherwise just go with the specified dataclass
        if ($dataclass == 'all') {
            foreach ($accepted_classes as $accepted_class) {
                $data = getChData($accepted_class,$item_key,$$item_key,$classtype);
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
                            $alias = getAlias("cor_lut_$dataclass" . "type",$alias_lang,'id',$dataclasstype,$alias_type);
                            if ($dataclass == 'attribute') {
                                $alias = getAlias("cor_lut_$dataclass",$alias_lang,'id',"$value[$dataclass]",$alias_type);
                                $data[$key]['attribute_alias'] = $alias;
                            }
                            $data[$key]['alias'] = $alias;
                        }
                    }
                }
            }
                $json_data[$$item_key][] = $data;
        } else {
             $data = getChData($dataclass,$item_key,$$item_key,$classtype);
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
                            $alias = getAlias("cor_lut_$dataclass" . "type",$alias_lang,'id',$dataclasstype,$alias_type);
                            $data[$key]['alias'] = $alias;
                            if ($dataclass == 'attribute') {
                                $alias = getAlias("cor_lut_$dataclass",$alias_lang,'id',"$value[$dataclass]",$alias_type);
                                $data[$key]['attribute_alias'] = $alias;
                            }
                        }
                    }
                }
            $json_data[$$item_key][] = $data;
        }
       
        //now we need to pretty up the JSON
        $json_data = json_encode($json_data);
        
    }
}

if ($json && $json_data) {
    header('Content-Type: application/json');
    echo $json_data;
}


?>
