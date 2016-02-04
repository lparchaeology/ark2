<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* transcludeSubform.php    
*
* this page transcludes the a subform into rendered HTML
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
* @link       http://ark.lparchaeology.com/svn/api/transcludeSubform.php
* @since      File available since Release 1.1
*/

//this file is included by the API wrapper page


// -- REQUESTS -- //

// SF_KEY the sf_key and sf_val
// in some cases, we may send a different item_key and sf_key
// for example, if we want to use a specific item for auth and focus 
// the sf on a frag.
$sf_key = reqQst($_REQUEST, 'sf_key');
if (!$sf_key) {
    $sf_key = $item_key;
}
$sf_val = reqQst($_REQUEST, 'sf_val');
if (!$sf_val) {
    $sf_val = $$item_key;
}

// -- SETUP VARS -- //
$errors = 0;
$admin_error = '';
$data = array();
$sf_conf_name = '';

//we aren't at this stage going to allow edits so set update_db to 0
$update_db = 0;

// -- OTHER -- // - as we are returning HTML we need to grab skins, etc.
// browser
$browser = browserDetect();
$stylesheet = getStylesheet($browser);
// textile
include_once ('lib/php/classTextile.php');
$textile = new Textile;

// MODULE Setup and settings - where the sf_key is a key, use it as the base for settings
if (isItemkey($sf_key)) {
    $mod_short = substr($sf_key, 0, 3);
} else {
    $mod_short = substr($item_key, 0, 3);
}
if ($mod_short) {
    //Pull mod specific settings
    $module = 'mod_'.$mod_short;
    $mod_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $item_key, 1);
    include_once ("config/mod_{$mod_short}_settings.php");
}

// CONTENT Setup
// Set up a column to hold the subform. NB: Only ONE subform is permitted
// Get the name of the subform
if (!$sf_conf_name = reqQst($_REQUEST,'sf_conf')) {
    echo "ADMIN ERROR: you must supply the name of the requested subform, using 'sf_conf' in querystring. If you don't know the name you can use describeSubforms()<br/>\n";
    $admin_error = TRUE;
}
// Get the sf_conf
$sf_confs = getSfs($mod_short);
if ($sf_conf_name == '' OR !array_key_exists($sf_conf_name, $sf_confs)) {
    echo "ADMIN ERROR: sf_conf: $sf_conf_name not found by transcludeSubform in mod_{$mod_short}_settings.php<br/>\n";
    $admin_error = TRUE;
} else {
    $sf_conf = $sf_confs[$sf_conf_name];
}

// ANON LOGINS
// Access to the page 'overlay_holder' is controlled in the standard ARK manner, however,
// access to a specific subform is controlled via use of an op on the sf_conf. The default
// is a lockdown for the SF for any anon login.
// Edits - the process section on each subform should lockdown any access to the DB for
// anon logins. This flag is used to announce that.
// Assume no access
$display_sf = FALSE;
// Check for anons
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    // flag this as an anon login for the benefit of the SFs that may need this flag
    $anon_login = TRUE;
    // check to see if anons have been allowed to optionally access this SF
    if (array_key_exists('op_anon_overlay_access', $sf_conf)) {
        $display_sf = TRUE;
    }
} else {
    // this is not an anon, so flag that and display the SF
    $anon_login = FALSE;
    $display_sf = TRUE;
}

?>

<?php echo "<!DOCTYPE ".$doctype.">" ?>

<html>
<head>
    <!-- title -->
    <title><?php echo $page_title ?></title>
    
    <!-- meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <!-- stylesheets -->
    <link href="<?php echo $stylesheet ?>" type="text/css" rel="stylesheet"  media="screen" />
    <link href="<?php echo $skin_path ?>/stylesheets/map_view.css" type="text/css" rel="stylesheet" media="print" />
    <link href="<?php echo $skin_path ?>/stylesheets/ark_main_print.css" type="text/css" rel="stylesheet" media="print" />
    <link href="<?php echo $skin_path ?>/stylesheets/lightbox.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo $skin_path ?>/images/ark_favicon.ico" rel="shortcut icon" />
    
    <!-- javascript libraries -->
    <script type="text/javascript" src="<?php echo $ark_lib_path ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $ark_lib_path ?>/js/php.js"></script>
    <script type="text/javascript" src="<?php echo $ark_lib_path ?>/js/prototype.js"></script>
    <script type="text/javascript" src="<?php echo $ark_lib_path ?>/js/scriptaculous.js?load=effects"></script>
    
    <!-- ARK javascript -->
    <script type="text/javascript" src="<?php echo $ark_root_path ?>/js/js_functions.js"></script>
    <script type="text/javascript" src="<?php echo $ark_root_path ?>/js/lightbox.js"></script>
    <script type="text/javascript" src="<?php echo $ark_root_path ?>/js/livesearch.js"></script>
    
    <base target="_parent" />
</head>

<body>

    <!-- THE MAIN AREA -->
    <div id="main" class="">
<?php

if (!$admin_error) {
    // setup an element that the lightbox ca access to identify the lboxload value
    // if this is an anon login - lock the form down
    if (!$display_sf) {
        // for now this is a total lock down
        echo "$mk_anonoverlayaccess";
    } else {
        // set the sf_state
        // DEV NOTE: p_max_view is used here - but it may be better to revive the transclude mode - as we often don't want nav, etc.
        $sf_state = "p_max_view"; // forces the sf into p max mode mode
        // trick the sfNav if it is being used (most overlay modes don't put in the nav)
        if ( $sf_conf['sf_nav_type'] != 'none' ){
            $sf_conf['sf_nav_type'] = 'title';
        }
        $cur_col_id = '1';
        $cur_sf_id = '1';
        $disp_cols = 'fake';
        $$disp_cols = array('1' => array('subforms' => array('1' => $sf_conf), 'col_type'=>'transclude'));
        // if the sf is conditional
        if (array_key_exists('op_condition', $sf_conf)) {
            // check the condition
            if (chkSfCond($item_key, $$item_key, $sf_conf['op_condition'])) {
                include($sf_conf['script']);
            }
        } else {
            include($sf_conf['script']);
        }
    }
}

?>

    </div>

    <!-- end content WRAPPER -->
    </div>


</body>
</html>
