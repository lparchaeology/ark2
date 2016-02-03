<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* alias_admin.php
*
* Index page for alias admin module
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
* @category   alias
* @package    ark
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/alias_admin.php
* @since      File available since Release 0.6
*/

use LPArchaeology\ARK;

// -- INCLUDE SETTINGS AND FUNCTIONS -- //
include('src/settings.php');
include('php/global_functions.php');
include('php/validation_functions.php');


// -- SESSION -- //
// Start the session
session_name($ark_name);
session_start();


// -- MANUAL configuration vars for this page -- //
$error = FALSE;
$message = FALSE;


// -- REQUESTS -- //
$lang = reqArkVar('lang', $default_lang);
$view = reqArkVar('view', 'home');
$phpsessid = reqQst($_REQUEST,'PHPSESSID');
$update_db = reqQst($_REQUEST,'update_db');
$submiss_serial = reqArkVar('submiss_serial');


// -- PAGE SETTINGS -- //
$page_conf = ARK\Web\PageConfig::page('alias_admin');
if (!$page_conf->isValid()) {
    die ('ADMIN ERROR: No config in database for page '.$page_conf->id());
}
// title for this HTML page
$page_title = $ark_name.' - '.$page_conf->title();
// the page's sgrp value
$psgrp = $page_conf->sgrp();
// current code directory (location of any files related to this page)
$cur_code_dir = $page_conf->codeDir();

//register the target url
$_SESSION['target_url'] = $_SERVER['REQUEST_URI'];

// -- AUTH -- //
include_once ('php/auth/inc_auth.php');
// ANON LOGINS
// check for anon logins
//check if this is an anonymous login - if it is then prevent edits
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    $anon_login = TRUE;
    header('location:index.php');
}

// -- OTHER -- //
// browser
$browser = browserDetect();
$stylesheet = getStylesheet($browser);


// PART2 - select the relevant page contents

// The 'Page Level' content
//    This selection is based on the value 'view' which is in the session
$plc = $cur_code_dir.$view.'.php';

// Force this into cor
$mod_short = 'cor';
$module = 'mod_cor';

// 2 - ITEM KEY The 'Process Script' held at module level
//    This selection is based on the item key and view

$process = 'php/alias_admin/global_update.php';

$javascript = mkJavaScriptSource($page_conf->name());

$wrapperclass = 'wrp_normal';

// -- PROCESS -- //
if ($update_db) {
    include_once ($process);
}

// ---------OUTPUT--------- //

?>

<?php echo "<!DOCTYPE ".$doctype.">";

include($skin_dir."/templates/inc-header.php"); ?>

<!-- BEGIN leftpanel -->
    <div id="lpanel" class="leftpanel">
        <?php include_once($cur_code_dir.'left_panel.php') ?>
    </div>

<!-- THE MAIN AREA -->
<div id="main" class="main_normal">

<?php
if ($error) {
    feedBk('error');
}
if ($message) {
    feedBk('message');
}
?>


<!-- PAGE LEVEL -->

<div id="page_level"><?php include_once ("$plc") ?></div>


<!-- end MAIN -->
</div>


<!-- ARK FOOTER -->
<?php  include($skin_dir."/templates/inc-footer.php");  ?>


<!-- end CONTENT WRAPPER -->
</div>


</body>
</html>
