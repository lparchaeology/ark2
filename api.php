<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* api.php    
*
* this is a wrapper page to used within the API architecture
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
* @link       http://ark.lparchaeology.com/svn/api.php
* @since      File available since Release 1.1
*/


// -- INCLUDE SETTINGS AND FUNCTIONS -- //
include('src/settings.php');
include('php/global_functions.php');
include('php/validation_functions.php');
include('php/export_functions.php');
include('php/map/map_functions.php');

// -- SESSION -- //
// Start the session
session_name($ark_name);
session_start();


// -- MANUAL configuration vars for this page -- //
$pagename = 'api';
$error = FALSE;
$message = FALSE;



// -- PAGE SETTINGS -- //
// handle missing config
if (!$pagename) {
    die ('ADMIN ERROR: No $pagename variable setup. Required as of v1.1, supersedes $filename');
}
// handle missing config
$pg_settings_nm = 'conf_page_'.$pagename;
$pg_settings = $$pg_settings_nm;
if (!$pg_settings) {
    die ("ADMIN ERROR: No settings (${$pg_settings_nm})found for the page $pagename");
}
// title for this HTML page
$page_title = $ark_name.' - '.$pg_settings['title'];
// the page's sgrp value
$psgrp = $pg_settings['sgrp'];
// current code directory (location of any files related to this page)
$cur_code_dir = $pg_settings['cur_code_dir'];
//allowed api requests
$allowed_api_requests = 
    array( 
        'getItems',
        'getFrags',
        'getFilter',
        'getFields',
        'putField',
        'describeARK',
        'describeFrags',
        'describeItems',
        'describeFilters',
        'describeSubforms',
        'describeFields',
        'describeClassType',
        'transcludeFilter',
        'transcludeSubform',
        'update_mapfile',
        'XMLParser',
);


// -- AUTH -- //
include_once ('php/auth/inc_auth.php');
// ANON LOGINS
// check for anon logins
//check if this is an anonymous login - if it is then prevent edits
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    $anon_login = TRUE;
} else {
    $anon_login = FALSE;
}
// -- REQUESTS -- //
$lang = reqArkVar('lang', $default_lang);
$item_key = reqQst($_REQUEST, 'item_key');
if ($item_key && array_key_exists($item_key, $authitems) ) {
    $$item_key = reqQst($_REQUEST, $item_key);
    if (!in_array($$item_key,$authitems[$item_key]) AND $$item_key != 'all'){
        $$item_key = FALSE;
    }
} else {
    $$item_key = FALSE;
}

// ---- REQUESTS ---- //
//request the variables needed and put in failsafes

//for the api we need to find out what type of request we are looking for
$request = reqQst($_REQUEST,'req');
if (in_array($request,$allowed_api_requests)) {
    include_once("$cur_code_dir$request.php");
} else {
    echo "ADMIN ERROR: You need to supply a type of request to the API. This can be: ";
    foreach ($allowed_api_requests as $value) {
        echo "$value;\n";
    }
}


?>
