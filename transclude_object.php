<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* transclude_object.php    
*
* this is a wrapper page to produce an object to be transcluded (built from a sf_conf)
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
* @category   base
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/transclude_object.php
* @since      File available since Release 0.6
*/

// INCLUDES
include_once ('config/settings.php');
include_once ('php/global_functions.php');
$db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);

//request the variables needed

$transclude_val = reqQst($_REQUEST, 'transclude');

if ($transclude_val == 'filter') {
    //filters can be requested via nickname or direct from the number
    $filter = reqQst($_REQUEST,'filter');
    if ($filter) {
        if (is_numeric($filter)) {
            $retftrset = $filter;
        } else {
            $retftrset = getSingle('id','cor_tbl_filter', "nname = '$filter'");
        }
    } else {
        echo "ERROR: You must set a filter variable in the querystring";
    }
    $output_mode = reqQst($_REQUEST,'output_mode');
    $width = reqQst($_REQUEST,'width');
    $height = reqQst($_REQUEST,'height');
    if (!$width) {
        $width = '100%';
    }
    if (!$height) {
        $height = '100%';
    }
    
    //write the object tag
    $var = " <!DOCTYPE $doctype?>

     <html>
     <head></head>
     <body>
     <object style=\"width: $width; height: $height\" data=\"data_view.php?transclude=yes&amp;output_mode=$output_mode&amp;retftrset=$retftrset\" type=\"text/html\">
     </object>
     </body>
     </html>
     ";
    
} else {
    
    $sf_val = reqQst($_REQUEST,'sf_val');
    $sf_key = reqQst($_REQUEST,'sf_key');
    $sf_conf_name = reqQst($_REQUEST,'sf_conf');
    $width = reqQst($_REQUEST,'width');
    $height = reqQst($_REQUEST,'height');

    //get the path of the subform file needed
    $mod = splitItemKey($sf_key);
    include ("config/mod_" . $mod . "_settings.php");
    $sf_conf = $$sf_conf_name;
    $script = $sf_conf['script'];

    if (!$width) {
        $width = '100%';
    }
    if (!$height) {
        $height = '100%';
    }

    //write the object tag

   $var = " <!DOCTYPE $doctype?>

    <html>
    <head></head>
    <body>
    <object style=\"width: $width; height: $height\" data=\"$script?sf_conf=$sf_conf_name&amp;sf_key=$sf_key&amp;sf_val=$sf_val&amp;transclude=yes\" type=\"text/html\">
    </object>
    </body>
    </html>
    ";
}

print $var;

?>
