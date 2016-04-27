<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/settings.php
*
* Stores all of the general settings for the ARK instance
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Heritage LLP.
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
* @author     John Layt <john@layt.net>
* @copyright  1999-2016 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/src/settings.php
* @since      0.1
*
*/

// -- VERSION -- //
// Change this version with every ARK release
$version = '1.2.90';

// -- SERVER ENVIRONMENT -- //
// Settings related to your server environment
include('config/server.php');
include('config/paths.php');

// Composer Autoloader
require('vendor/autoload.php');

use LPArchaeology\ARK;

// -- DATABASE CONNECTION -- //
// Global database access object
$ado = new ARK\DB\ADO($sql_server, $sql_user, $sql_pwd, $ark_db);
// TODO Remove when fully migrated
include_once('php/db_functions.php');
$db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);

// -- CONFIGURATION -- //
// Obtain the ARK config from the database
$ark = new ARK\DB\ArkConfig();

// -- GENERAL -- //
// The ARK config name
$ark_name = $ark->name();
// The markup for the ARK name
$arkname_mk = $ark->markup();
//Default site code
$default_site_cd = $ark->defaultSiteCode();

// -- ERROR REPORTING -- //
ini_set('display_errors', $ark->displayErrors());
// TODO Move to database
// error_reporting(0); // Turn off all error - USE THIS FOR PRODUCTION SITES
error_reporting(E_ALL  & ~E_DEPRECATED & ~E_STRICT);

// -- LOGGING -- //
//Logging levels
$log_ins = $ark->logInserts();
$log_upd = $ark->logUpdates();
$log_del = $ark->logDeletes();

// -- SEARCH -- //
// Search controls mode - live / dd / plain
$search_mode = $ark->searchMode();
// Free text search mode fancy/plain
$search_ftx_mode = $ark->searchFreeTextMode();

// -- FORMS -- //
// Method used in forms get/post
$form_method = $ark->formMethod();

// -- LANGUAGES -- //
// The default lang
$default_lang = $ark->defaultLanguage();

// -- SKINS -- //
// Skin names
$skin = $ark->defaultSkin();
$skin_path = $ark->defaultSkinPath();
$skin_dir = $ark->defaultSkinDir();

// -- FILES -- //
// Max upload size
ini_set('upload_max_filesize', $ark->maxUploadSize());
// Thumbnail sizes
$thumbnail_sizes = $ark->thumbnailSizes();

// -- SECURITY -- //
// Liveuser: 
// These are the names of the liveuser objects. They should be unique per ARK 
// (to prevent cross ark hacking). They need to be called in the code as
// $$liveuser and $$liveuser_admin.
// These values shouldn't need changing
$liveuser = $ark_name . 'usr';
$liveuser_admin = $liveuser . '_admin';
//the path to the login script (relative to the document root)
$loginScript = 'index.php';

// Anonymous Logins:
if ($ark->anonymousLogin()) {
    $anonymous_login['username'] = $ark->anonymousUser();
    $anonymous_login['password'] = $ark->anonymousPassword();
}

// TODO These group permissions should be configured elsewhere!
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
        2,
        4
);

// TODO Remaining settings copied from config/page_settings.php, remove when fully migrated
// *** PAGE SETTINGS *** //
include('config/page_settings.php');

// -- NAV LINKS -- //
// these links will appear in the end of the navbar
$conf_linklist =
    array(
        // 'file' => 'index.php',
        // 'vars' => 'logout=true',
        // 'label' => 'logout'
);

// -- MODULES -- //
// List the modules that need to be loaded in this ARK project
$loaded_modules = array();
foreach ($ark->modules() as $module) {
    $loaded_modules[] = $module->id();
}

// If using mapping, list the modules to load maps for
$loaded_map_modules = array();

//Proxy Host - sometimes if you are using remote mapservers - you may need a proxy host to get around the JS single domain
// security policy. The setup is here:http://trac.osgeo.org/openlayers/wiki/FrequentlyAskedQuestions#HowdoIsetupaProxyHost
$proxy_host = TRUE;

//  The default item key for this instance of Ark.
$default_itemkey = 'cxt_cd';

// -- DEFAULT VIEWERS -- //

$default_media_browser = 'mac_mediabrowser'; // TODO make table based, load in import
$default_batch_file_upload = 'batch_file_upload'; // TODO make table based, load in import

// MINIMISER OPTION
// Set to on if you want to use the data entry 'minimiser' tool
// This tool condenses subforms and offers quick nav in left panel
$minimiser = false;

/**  ADVANCED FILE UPLOAD
*   if 'on' => TRUE advanced file upload dialog is displayed
*   'pattern' -  pattern as regular expression
*   some example expressions:
*   'pattern' => "/\b[a-zA-Z]*\-(([0-9]*)|(([0-9]*)-[a-zA-Z0-9]*))\.[a-zA-Z]{2,4}\b/i" 
*   handles following files xxx-1234.jpg, xxx-1234-yyy.jpg, where xxx can be any letter and yyy any alphanumeric combination
*   'pattern' => "/\bMUS\-(([0-9]*)|(([0-9]*)-[a-zA-Z0-9]*))\.[a-zA-Z]{2,4}\b/i" 
*   handles following files MUS-1234.jpg, MUS-1234-yyy.jpg, where yyy can be any alphanumeric combination
*   NB! only number after first '-' is used as an ID
*/

$fu =
    array(
     'on' => TRUE,
     'pattern' => array(
         'basic'=>"/\b[a-zA-Z]*[-_]?(([0-9]*)|(([0-9]*)[-_]?[a-z0-9A-Z]*))\.[a-z0-9]{2,4}\b/i",
         'item_no'=>"/\b[a-z0-9A-Z]*[_][0-9]*\.[a-z0-9]{2,4}\b/i",
     ),
     'metadata_conf' => array(
         array(
            'regexp' => "/<dc:creator>\s*<rdf:Seq>\s*<rdf:li>(.+)<\/rdf:li>\s*<\/rdf:Seq>\s*<\/dc:creator>/",
            'field' => 'conf_field_takenby'
         ),
         array(
            'regexp' => "/<dc:title>\s*<rdf:Alt>\s*<rdf:li xml:lang=\"x-default\">(.+)<\/rdf:li>\s*<\/rdf:Alt>\s*<\/dc:title>/",
            'field' => 'conf_field_short_desc'
         ),
         array(
            'regexp' => "/b<xap:CreateDate>\"(.[^\"]+)/",
            'field' => 'conf_field_takenon'
         )
     )
);

/** PDF THUMBNAILS
*Image magick and phMagick must be installed on your server for these to work -check config/preflight_checks.php 
* sets the number of pages that will make up the thumbnail of the pdf starting from the first page and
* how they will be arranged
* eg.   width 1, height 1 will be the first page on its own.
*       width 2, height 1 will be the firt two pages side by side
*       width 1, height 3 will be the first five pages in a vertical column
*
* if there are more than one row and column then pages are layer left to right then top to bottom (the same manner as text)
* see the phMagick documentation for details http://www.phmagick.org/examples/examples/tabstrip/comment-page-1#comment-2649
*
*/
$pdfthumbgrid = array(
    'width' => 2,
    'height' => 1
);

// GENERAL PAGE SETTINGS
// Number of rows to display on the data viewer
$conf_viewer_rows = 25;
// Number of pages to display on the data viewer
$conf_num_res_pgs = 5; // best choose an odd number
// Default data viewer page
$conf_data_viewer = $ark_root_path."/data_view.php";
// Default feed viewer page
$conf_feed_viewer = $ark_root_path."/feed.php";
// Default search page - search funtions will send data thru to this page
$conf_search_viewer = $ark_root_path."/data_view.php";
// Default $output_mode for the data viewer (table, text, map, thumbs)
$default_output_mode = 'table';


// *** MAP SETTINGS *** //
// TODO Remove when fully migrated
include('config/map_settings.php');

// -- DOCTYPE -- //
// The doctype to use for web output
$doctype = "html \n
     PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n
     \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\"";

?>
