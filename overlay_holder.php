<?php


/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* overlay_holder.php
*
* a skeleton page structure to hold overlays within lightbox
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
* @since      File available since Release 0.8
*/

use LPArchaeology\ARK;

// INCLUDES
include_once ('src/settings.php');
include_once ('config/map_settings.php');
include_once ('php/global_functions.php');
include_once ('php/validation_functions.php');


// SESSION Start the session
session_name($ark_name);
session_start();


// MANUAL vars needed in this page
$error = FALSE;
$message = FALSE;
$admin_error = FALSE;


// REQUEST vars needed in this page
$lang = reqArkVar('lang', $default_lang);
$view = reqArkVar('view');
$item_key = reqArkVar('item_key', $default_itemkey);
$$item_key = reqQst($_REQUEST, $item_key);
$update_db = reqQst($_REQUEST, 'update_db');
$submiss_serial = reqArkVar('submiss_serial');

// id_to_modify is used by overlays that try to modify the parent page
$id_to_modify = reqQst($_REQUEST, 'id_to_modify');
if (!$id_to_modify) {
    // this is needed for the JQuery, if left as false, then the return_to_sender button won't
    // close the overlay
    $id_to_modify = 'do_nothing';
}

// this may be specified when info is being sent back the parent
$soft_fd_id = reqQst($_REQUEST, 'soft_fd_id');


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


// -- PAGE SETTINGS -- //
$page_conf = ARK\Web\PageConfig::page('overlay_holder');
if (!$page_conf->isValid()) {
    die ('ADMIN ERROR: No config in database for page '.$page_conf->id());
}
// title for this HTML page
$page_title = $ark_name.' - '.$page_conf->title();
// the page's sgrp value
$psgrp = $page_conf->sgrp();
// current code directory (location of any files related to this page)
$cur_code_dir = $page_conf->codeDir();


// -- AUTH -- //
include_once ('php/auth/inc_auth.php');


// -- OTHER -- //
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
    $mod_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $sf_key, 1);
    include_once ("config/mod_{$mod_short}_settings.php");
}

// CONTENT Setup
// Set up a column to hold the subform. NB: Only ONE subform is permitted
// Get the name of the subform
if (!$sf_conf_name = reqQst($_REQUEST,'sf_conf')) {
    echo "ADMIN ERROR: send name of sf_conf to overlay_holder.php<br/>\n";
    $admin_error = TRUE;
}
// Get the sf_conf
if (!isset($$sf_conf_name)) {
    echo "ADMIN ERROR: sf_conf: $sf_conf_name not found by overlay_holder.php in mod_{$mod_short}_settings.php<br/>\n";
    $admin_error = TRUE;
} else {
    $sf_conf = $$sf_conf_name;
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

// MARKUP
$mk_anonoverlayaccess = getMarkup('cor_tbl_markup', $lang, 'anonoverlayaccess');

// Lightbox Reload Behavoir
// this affects the what happens when the lightbox is closed. To change this, set a var
// lboxreload in the querystring of the lightbox 'src' attribute. Permitted options are:
// 1 | 0/FALSE/blank/unset | String which act as follows:
// 1 - This will cause the parent page to reload
// 0/FALSE/blank/unset - any of these will simply close the Lightbox as standard
// String - Any other string will be taken as a URL and the parent page will be redirected to it
// This is dependent on the global ARK js_functions.js file as well as the php.js and lightbox.js ;-)
$lboxreload = reqQst($_REQUEST, 'lboxreload');
// DEV NOTE: This should be made to look in the sf_conf as default and then request as an overide.


// ---- PROCESS ---- //
if ($update_db === 'delfrag') {
    include_once('php/update_db.php');
}

$javascript = mkJavaScriptSource($page_conf->name());

// ---------OUTPUT--------- //

?>

<?php echo "<!DOCTYPE ".$doctype.">" ?>

<html>
<head>
    <!-- title -->
    <title><?php echo $page_title ?></title>
    
    <!-- meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <link href="<?php echo $skin_path ?>/stylesheets/lightbox.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo "$skin_path" ?>/stylesheets/ark_main.css" />
    <link rel="stylesheet" href="<?php echo "$skin_path" ?>/stylesheets/ark_main_responsive.css" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!--[if IE]><script src="lib/js/ie.js"></script><![endif]-->
    <?php echo "$javascript" ?>
    <script type="text/javascript">
        $(document).ready(function(){
            // return a variable from the overlay to the parent
            $("#<?php echo $id_to_modify ?>").click(function(event){
                event.preventDefault();
                // do the value
                var value = $(this).attr('rel');
                $('#<?php echo $id_to_modify ?>', window.parent.document).val(value);
                // do the soft info (if needed)
                var softie = $("#hidden_<?php echo $soft_fd_id ?>").children().html();
                if (softie) {
                    $('#label_<?php echo $id_to_modify ?>', window.parent.document).html(softie);
                };
                // close the lightbox
                $("#bottomNavClose", window.parent.document).click();
            });
        });
    </script>
</head>

<body>

<!-- MAIN CONTENT (the subform) -->
<?php

// always echo this
echo "<div id=\"reloadcarrier\" style=\"display:none;\" lboxreload=\"$lboxreload\"></div>";

if (!$admin_error) {
    // setup an element that the lightbox ca access to identify the lboxload value
    // if this is an anon login - lock the form down
    if (!$display_sf) {
        // for now this is a total lock down
        echo "$mk_anonoverlayaccess";
    } else {
        // set the sf_state
        $sf_state = "overlay"; // forces the sf into overlay mode
        // trick the sfNav if it is being used (most overlay modes don't put in the nav)
        $cur_col_id = '1';
        $cur_sf_id = '1';
        $disp_cols = 'fake';
        $$disp_cols = array('1' => array('subforms' => array('1' => $sf_conf)));
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
<!-- end main -->

</body>
</html>
