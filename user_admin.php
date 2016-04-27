<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* user_admin.php    
*
* The index of the user administration
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
* @category   user
* @package    ark
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/user_admin.php
* @since      File available since Release 0.6
*/

// -- INCLUDE SETTINGS AND FUNCTIONS -- //
include('config/settings.php');
include('config/user_admin_settings.php');
include('php/global_functions.php');
include('php/validation_functions.php');
include('php/user_admin/user_admin_functions.php');


// -- SESSION -- //
// Start the session
session_name($ark_name);
session_start();


// -- MANUAL configuration vars for this page -- //
$pagename = 'user_admin';
$error = FALSE;
$message = FALSE;


// -- REQUESTS -- //
$lang = reqArkVar('lang', $default_lang);
$view = reqArkVar('view', 'home');
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

//register the target url
$_SESSION['target_url'] = $_SERVER['REQUEST_URI'];

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

// PART2 - select the relevant page contents

// 1 - VIEW The 'Page Level' content (in this case the form)
//    This selection is based on the value 'view' which is in the session


$plc = $cur_code_dir.$view.'.php';

// Force this into cor
$mod_short = 'cor';
$module = 'mod_cor';

// -- MARKUP -- //

if ($view == 'adduser' OR $view == 'addusrl') {
    $title_markup = getMarkup('cor_tbl_markup', $lang, 'adduser');
} elseif ($view == 'edtuser') {
    $title_markup = getMarkup('cor_tbl_markup', $lang, 'edituser');
} else {
    $title_markup = getMarkup('cor_tbl_markup', $lang, 'user_admin');
}
// -- PROCESS -- //
// The 'Process Script' held at module level
$process = 'php/user_admin/global_update.php';

if($sf_val && $sf_key ){
    $user_id = getSingle('id','cor_tbl_users', "itemkey=? and itemvalue = ?",array($sf_key, $sf_val));
}

// if required, run the update script
if ($update_db) {
    include_once($process);
}


// ---------OUTPUT--------- //

$javascript = mkJavaScriptSource($pg_settings['name']);

include($ark_server_path."/skins/".$skin."/templates/inc-header.php");
?>

<!-- BEGIN leftpanel -->
    <div id="lpanel" class="leftpanel">
        <?php include_once($cur_code_dir.'left_panel.php') ?>
    </div>
    
    <!-- BEGIN maincontent -->
    <div id="main" class="main_normal">

<!-- DYNAMIC NAVIGATION -->

<div id="page_level">

<?php 
//echo '<div class="addinventory">';
if(isset($plc)) include_once ("$plc");

echo '</div>';

?></div>

<!-- ARK FOOTER -->
<?php  include($ark_server_path."/skins/".$skin."/templates/inc-footer.php");  ?>

</body>
</html>