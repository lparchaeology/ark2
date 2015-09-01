<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* resultsmicro_view.php
*
* Multi-record screen dump - used for printing all records in a resultset
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
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/micro_view.php
* @since      File available since Release 0.6
*/


// -- INCLUDE SETTINGS AND FUNCTIONS -- //
include('config/settings.php');
include('php/global_functions.php');
include('php/validation_functions.php');


// -- SESSION -- //
// Start the session
session_name($ark_name);
session_start();


// -- MANUAL configuration vars for this page -- //
$pagename = 'resultsmicro_view';
$error = FALSE;
$message = FALSE;


// -- REQUESTS -- //
$lang = reqArkVar('lang', $default_lang);
$view = reqArkVar('view');
$ste_cd = reqArkVar('ste_cd', $default_site_cd);
$item_key = reqArkVar('item_key', $default_itemkey);
$$item_key = reqQst($_REQUEST, $item_key);
$update_db = reqQst($_REQUEST, 'update_db');
$submiss_serial = reqArkVar('submiss_serial');
$quickedit = reqQst($_REQUEST, 'quickedit'); // quickedit for forms
$cre_by = reqQst($_SESSION,'user_id'); // user info for forms
$cre_by_name = reqQst($_SESSION,'soft_name'); // user info for forms


// -- SF_KEY & SF_VAL -- //
// setup the sf_key and sf_val
$sf_key = $item_key;
$sf_val = $$item_key;


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


// -- AUTH -- //
$db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
include_once ('php/auth/inc_auth.php');
// ANON LOGINS
// check for anon logins
//check if this is an anonymous login - if it is then prevent edits
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    $anon_login = TRUE;
} else {
    $anon_login = FALSE;
}


// -- OTHER -- //
// browser
$browser = browserDetect();
$stylesheet = getStylesheet($browser);
// textile
include_once ('lib/php/classTextile.php');
$textile = new Textile;


// Custom Page Title (included here to use data in the page title)
$page_title = $page_title;

// ---------OUTPUT--------- //

?>

<?php echo "<!DOCTYPE ".$doctype.">" ?>

<html>
<head>
<title><?php echo $page_title ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?php echo $stylesheet ?>" type="text/css" rel="stylesheet"  media="screen" />
<link href="<?php echo $skin_path ?>/stylesheets/ark_main_print.css" type="text/css" rel="stylesheet" media="print" />
<link href="<?php echo $skin_path ?>/stylesheets/lightbox.css" type="text/css" rel="stylesheet" />
<link href="<?php echo $skin_path ?>/images/ark_favicon.ico" rel="shortcut icon" />

</head>

<body>

<!-- THE CONTENT WRAPPER -->
<div id="wrapper" class="wrp_mcrview">

<!-- HEADER -->
<div id="hdr-print">
    <img src="skins/<?php echo $skin ?>/images/logo.png" alt="logo" />
</div>

<!-- MAIN CONTENT (IN COLUMNS) -->
<div id="main" class="main_mcrview">

<?php
if (is_array($error)) {
    feedBk('error');
}
$message = FALSE;
if ($message) {
    feedBk('message');
}
if (!$error) {
    $item_loop = $_SESSION['results_array'];
    foreach($item_loop as $this_record) {
        $item_key = reqQst($this_record, 'itemkey');
        $$item_key = reqQst($this_record, 'itemval');
        $sf_key = $item_key;
        $sf_val = $$item_key;
        
        // set the mod_short for this item
        $mod_short = substr($sf_key, 0, 3);
        // pull mod settings
        include_once ("config/mod_{$mod_short}_settings.php");
        // Make the display array for this record based on mod settings
        $conf_mcd_cols = $mod_short.'_conf_mcd_cols';
        // Set the display columns to loop over
        // This is specific to the module of this item
        $disp_cols_array = $$conf_mcd_cols;
        $disp_cols = 'disp';
        $$disp_cols = $disp_cols_array['columns'];
        // Make the RESULTS NAV
        $record_nav = mkprtRecordNav($conf_record_nav, 'micro_view', FALSE);
        // print a div to contain both columns for print break purposes
        printf("<div id=\"printbrk\">\n");
        echo $record_nav;
        foreach($disp_cols_array['columns'] as $cur_col_id => $disp_col) {
            // print a proper div for the column
            printf("<div id=\"column-{$disp_col['col_id']}\" class=\"{$disp_col['col_type']}\">\n");
            // a title for the column (either the results of a field or markup)
            if (array_key_exists('col_mkname', $disp_col)) {
                if (!is_array($disp_col['col_mkname'])) {
                    $mk_col_mkname = getMarkup('cor_tbl_markup', $lang, $disp_col['col_mkname']);
                } else {
                    $field = $disp_col['col_mkname'];
                    $mk_col_mkname = resTblTd($disp_col['col_mkname'], $sf_key, $sf_val);
                }
                echo "<h1>$mk_col_mkname</h1>\n\n";
            }
            $cur_col_subforms = $disp_col['subforms'];
            foreach($cur_col_subforms as $cur_sf_id => $cur_col_subform) {
                // set the sf_conf
                $sf_conf = $cur_col_subform;
                // Set the navigation type to title only for all subforms
                $cur_col_subform['sf_nav_type'] = 'title';
                // set the sf_state to be max view at all times
                $sf_state = 'p_max_view';
                // if the sf is conditional
                if (array_key_exists('op_condition', $cur_col_subform)) {
                    // check the condition
                    if (chkSfCond($item_key, $$item_key, $cur_col_subform['op_condition'])) {
                        include($cur_col_subform['script']);
                    }   
                } else {
                    include($cur_col_subform['script']);
                }
                // cleanup this sf
                unset($sf_state);
                unset($cur_col_subform);
            }
            unset($cur_col_subforms);
            printf("</div>\n\n");
        }
        printf("</div>\n\n");
    }
}

?>
<!-- end main -->
</div>

<!-- end wrapper -->
</div>

</body>
</html>
