<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* map_admin.php
*
* Index for the map admin
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
* @link       http://ark.lparchaeology.com/svn/map_admin.php
* @since      File available since Release 0.6
*/


// PART1 - Basic setup

//this page
$pagename = 'map_admin';

//GLOBAL INCLUDES
include('config/settings.php');
include('config/map_settings.php');
include('php/global_functions.php');
include('php/validation_functions.php');

// Start the session
session_name($ark_name);
session_start();

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

if (array_intersect($record_admin_grps, $_SESSION['sgrp_arr'])) {
    $is_record_admin = TRUE;
} else {
    $is_record_admin = FALSE;
}
// -- OTHER -- //
// browser
$browser = browserDetect();
$stylesheet = getStylesheet($browser);

//GLOBALY required variables
$lang = reqArkVar('lang', $default_lang);
$update_db = reqQst($_REQUEST,'update_db');
$submiss_serial = reqArkVar('submiss_serial');
$view = 'admin';

$main_area_width = 'auto';

// ---------OUTPUT--------- //
$javascript = mkJavaScriptSource($pg_settings['name']);

// ---------OUTPUT--------- //

include($ark_server_path."/skins/".$skin."/templates/inc-header.php");
?>

<!-- BEGIN maincontent -->
<div id="main" class="main_mapadmin">


<!-- THE MAIN AREA -->
<?php

$map_conf_name = "conf_map_".$view;
$sf_conf = $$map_conf_name;
$permitted = TRUE;
if (array_key_exists('op_condition', $sf_conf)) {
	$permitted = chkSfCond($item_key, $$item_key, $sf_conf['op_condition']);
}
if ($permitted) {
    $sf_state = getSfState('primary_col', $sf_conf['view_state'], $sf_conf['edit_state']);
	include ($sf_conf['script']);
}

echo '</div>';
 
include($ark_server_path."/skins/".$skin."/templates/inc-footer.php");

?>
</div>
</body>
</html> 