<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/settings.php
*
* stores all of the general settings for the ARK instance
* there are inline comments and therefore most variables should
* be self evident
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2012  L - P : Heritage LLP.
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
* @category   admin
* @package    ark
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2012 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/config/settings.php
* @since      File available since Release 0.1
*
*/


// -- VERSION -- //
$version = '1.1.1';


// -- SERVER ENVIRONMENT -- //
// settings related to your server environment
include('env_settings.php');


// -- GENERAL -- //
// The ARK name - used by the system, so: no spaces, capitals or other funny characters
$ark_name = 'ark';
// The nickname for the markup ARK name that appears on the index page and
// as browser window/tab title
$arkname_mk = 'arkname';


// -- ERROR REPORTING -- //
// ensure that errors are being displayed to screen
if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}
 // main options
// error_reporting(0); // Turn off all error reporting - USE THIS FOR PRODUCTION SITES
//error_reporting(E_ALL); // Report all PHP errors (see changelog) - USE THIS FOR SETUP AND TESTING
// other options
//error_reporting(E_ERROR | E_WARNING | E_PARSE); // Report simple running errors
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); // Reporting E_NOTICE can be good too
// error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE
error_reporting( E_ALL & ~E_DEPRECATED & ~E_STRICT ); // Report Errors which aren't Strict, or Deprecated 


// -- LOGGING -- //
$log = FALSE;
//Logging levels
$conf_log_add = 'on';
$conf_log_edt = 'on';
$conf_log_del = 'on';


// -- LIVE SEARCH CONTROLS -- //
// live = live search 
// dd = drop down menu
// plain = plain text search
$mode = 'live';


// -- DSN -- //
// DSN (this shouldn;t need adjusting)
$dsn = 'mysql://'.$sql_user.':'.$sql_pwd.'@'.$sql_server.'/'.$ark_db;


// -- SECURITY -- //

// Liveuser: 
// These are the names of the liveuser objects. They should be unique per ARK 
// (to prevent cross ark hacking). They need to be called in the code as
// $$liveuser and $$liveuser_admin.
// These values shouldn't need changing
$liveuser = $ark_name . 'usr';
$liveuser_admin = $ark_name . 'usr' . '_admin';
//the path to the login script (relative to the document root)
$loginScript = 'index.php?logout=true';

// Anonymous Logins:
// If these variables are set then you are allowing anonymous logins
// For the tightest security it is best to keep this option commented out
// Bear in mind that this needs to be a real user. You should then define page perms
// and sfilters for the anon user
$anonymous_login['username'] = 'user_gu';
$anonymous_login['password'] = 'anonymous';

// Filter permissions:
// Members of the following (sgrp) groups will have permission to make their own filters public
// and permission to make other users (and their own) filters got private
$ftr_admin_grps =
    array(
        1
);

// Control list permissions:
// Members of the following (sgrp) groups will have permission to add items to controlled lists
$ctrllist_admin_grps =
   array(
       2
);

// Record admin permissions
// Members of the following (sgrp) groups will have access to the advanced record functions
$record_admin_grps =
    array(
        2
);


// -- SKINS -- //
// Skin name
$skin = 'arkologik';
// Skin path
$skin_path = "$ark_dir/skins/$skin";


// -- FILES -- //
// Optional
$thumbnail_sizes =
    array(
        'arkthumb_width' => 150,
        'arkthumb_height' => 150,
        'webthumb_width' => 550,
        'webthumb_height' => 550
);


// -- FORMS -- //

// Method used in forms:
// get = form messages sent via get method - vissible in browser bar.
// post = form message sent via post method - invisible to the user.
$form_method = 'post';
//Default year as a setting for form data entry
$default_year = '2012';
//Default site code
$default_site_cd = 'METSUR';


// -- SEARCH ENGINE -- //
// words to cut out of multi string searches
$conf_non_search_words = array('and', 'in');


// -- FREE TEXT SEARCH MODE -- //
//fancy - this allows complex search options such as +, -, "" (like Google!)
//plain = plain free text search, no fancy options
$ftx_mode = 'fancy';


// -- LANGUAGES -- //
// The default lang
$default_lang = 'en';
// These are the languages in use (in order)
$conf_langs = array('en');


// -- FIELDS -- //
include('field_settings.php');


// -- PAGE SETTINGS -- //
include('page_settings.php');


// -- MAP SETTINGS -- //
include('map_settings.php');


// -- DOCTYPE -- //
// The doctype to use for web output
$doctype = "html \n
     PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n
     \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\"";

?>