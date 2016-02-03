<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* map_view.php
*
* Index for the map view
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
* @link       http://ark.lparchaeology.com/svn/map_view.php
* @since      File available since Release 0.6
*/

use LPArchaeology\ARK;

//GLOBAL INCLUDES
include('src/settings.php');
include('config/map_settings.php');
include('php/global_functions.php');
include('php/validation_functions.php');

// Start the session
session_name($ark_name);
session_start();

// -- PAGE SETTINGS -- //
$page_conf = ARK\Web\PageConfig::page('map_view');
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
$view = reqArkVar('view', 'home');
$update_db = reqQst($_REQUEST,'update_db');
$submiss_serial = reqArkVar('submiss_serial');

$main_area_width = 'auto';

// ---------OUTPUT--------- //
$javascript = mkJavaScriptSource($page_conf->name());

// ---------OUTPUT--------- //

include($skin_dir."/templates/inc-header.php");
?>

<!-- BEGIN maincontent -->
<div id="main" class="main_mapview">


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
 
include($skin_dir."/templates/inc-footer.php");

?>
</div>
</body>
</html> 
