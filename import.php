<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* import.php
*
* Index for the import pages
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
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/import.php
* @since      File available since Release 0.6
*/

// INCLUDES
include('config/settings.php');
include('php/global_functions.php');
include('php/validation_functions.php');
include('php/import/import_functions.php');

// SESSION Start the session
session_name($ark_name);
session_start();

// PHP settings 
ini_set('include_path', ini_get('include_path').':/usr/share/php5/PEAR');

// MANUAL vars needed in this page
$pagename = 'import';
$error = FALSE;
$message = FALSE;

// Force this page into the core module 'cor'
$mod_short = 'cor';
$module = 'mod_cor';


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

// set no timeout- Apache default will pick it up anything over 5 mins 
set_time_limit(0);

// REQUEST required variables
$lang = reqArkVar('lang', $default_lang);
$view = reqArkVar('view','home');
$phpsessid = reqQst($_REQUEST,'PHPSESSID');
$update_db = reqQst($_REQUEST,'update_db');
$submiss_serial = reqArkVar('submiss_serial');
$cmap_id = reqArkVar('cmap_id');

// PAGE CONTENT - select the relevant page contents
$plc = $cur_code_dir.$view.'.php';

// PROCESS
if ($update_db) {
    include('php/import/update_cmap.php');
}

$javascript = mkJavaScriptSource($pg_settings['name']);


// ---------OUTPUT--------- //

include($skin_dir."/templates/inc-header.php");

?>
<!-- BEGIN leftpanel -->
<div id="lpanel" class="leftpanel">

  <?php include_once($cur_code_dir.'left_panel.php') ?>
  
</div>
<!-- THE MAIN AREA -->
<div id="main" class="main_normal">

<?php
if (is_array($error)) {
    feedBk('error');
}
if ($message) {
    feedBk('message');
}

// non standard way to call the site code on this page
mkSteCdNav(); // This option will simply set the ste_cd with not user option

?>

<!-- PAGE LEVEL -->
<div id="page_level">
    <?php include("$plc") ?>
</div>

<!-- The 'RIGHT' PANEL -->
<?php 
if ($cmap_id && $view != 'edtcmap' && $view != 'newcmap' && $view != 'home' && $view != 'addclasstype' && $view !='json_import' && $view !='json_picker') {
    include($cur_code_dir.'right_panel_'.$view.'.php');
}

// CONTENT WRAPPER
 echo '</div>'; 
   
// ARK FOOTER
include($skin_dir."/templates/inc-footer.php");

    ?>
<!-- end CONTENT WRAPPER -->
</div>

</body>
</html>
<?php
//reset default timeout
set_time_limit(30);
?>
