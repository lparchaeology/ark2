<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* user_home.php    
*
* Index for the home page for users
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
* @author     Mike Johnson <m.johnson@lparchaeology.com>
* @copyright  1999-2014 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/user_home.php
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
$pagename = 'user_home';
$error = FALSE;
$message = FALSE;


// -- REQUESTS -- //
$lang = reqArkVar('lang', $default_lang);
$view = reqArkVar('view');
$ste_cd = reqArkVar('ste_cd', $default_site_cd);
$item_key = reqArkVar('item_key', $default_itemkey);
$$item_key = reqQst($_REQUEST, $item_key);
// Some variables are needed by all subforms and so are included here
$mod_short = substr($item_key, 0, 3);
$update_db = reqQst($_REQUEST, 'update_db');
$submiss_serial = reqArkVar('submiss_serial');


// -- SF_KEY & SF_VAL -- //
$sf_key = $item_key;
$sf_val = FALSE;


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


// Get Markup
$mk_welcome = getMarkup('cor_tbl_markup', $lang, 'welcome');
$mk_user_home = getMarkup('cor_tbl_markup', $lang, 'user_home');
$mk_choose_lang = getMarkup('cor_tbl_markup', $lang, 'choose_lang');

// check for anon logins
//check if this is an anonymous login - if it is then prevent the edits
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    $anon_login = TRUE;
} else {
    $anon_login = FALSE;
}

// PART2 - select the relevant page contents
include_once ("config/page_settings.php");

// PART3 - DISP ARRAY
//    This is based on an array from the page settings
// $conf_mcd_cols - settings array for these views the settings
$conf_mcd_cols = $userhome_conf_mcd_cols;

// $disp_cols - the name of the cols for the user_home
$disp_cols = 'uh_disp_cols';

// now fill this variable variable with the columns
$$disp_cols = $conf_mcd_cols['columns'];

// Temporarily store the disp_cols before the left_panel to be recovered later
$temp_disp_cols = $$disp_cols;

$javascript = mkJavaScriptSource($pg_settings['name']);

// ---------OUTPUT--------- //

echo "<!DOCTYPE ".$doctype.">";

include($ark_server_path."/skins/".$skin."/templates/inc-header.php");
?>

<!-- BEGIN leftpanel -->
    <div id="lpanel" class="leftpanel">
        <?php include_once($cur_code_dir.'left_panel.php') ?>
    </div>
    
<!-- BEGIN maincontent -->
    <div id="main" class="main_mcrview">

<!-- Set up a welcome message --> 
<div id="message">
    <p><?php echo $mk_welcome ."<strong>"; echo $first_name;?></strong></p>
</div>

<?php


if (is_array($error)) {
    feedBk('error');
}
if ($message) {
    feedBk('message');
}

if (!$error) {
    $tcolarr = $conf_mcd_cols;
    // Recover the disp_cols
    $$disp_cols = $temp_disp_cols;
    $conf_col_view = $tcolarr['op_display_type'];
    // Column view
    if ($conf_col_view == 'cols') {
        foreach($$disp_cols as $cur_col_id => $disp_col) {
            // print a proper div for the column
            printf("<div id=\"column-{$disp_col['col_id']}\" class=\"{$disp_col['col_type']}\">\n");
            // if we want an alias for the columns print it here (set up in mod_settings)
            if ($disp_col['col_alias']) {
                print("<h1>{$disp_col['col_alias']}</h1>\n\n");
            }
            $cur_col_subforms = $disp_col['subforms'];
            foreach($cur_col_subforms as $cur_sf_id => $cur_col_subform) {
                // if this is an anon login - set the edit options to be OFF (unless it is 'none')
                if ($anon_login && $cur_col_subform['sf_nav_type'] != 'none') {
                    // temporarily make the cols static
                    $temp_cols = $$disp_cols;
                    // fix the new sf_nav_type
                    $temp_cols[$cur_col_id]['subforms'][$cur_sf_id]['sf_nav_type'] = 'name';
                    // make the static named disp cols dynamic again
                    $$disp_cols = $temp_cols;
                }
                // set the sf_state
                $sf_state = 
                    getSfState(
                        $disp_col['col_type'],
                        $cur_col_subform['view_state'],
                        $cur_col_subform['edit_state']
                );
                // set the sf_conf
                $sf_conf = $cur_col_subform;
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
    }
    // Tabs view
    $tcolarr = $conf_mcd_cols;
    if ($conf_col_view == 'tabs') {
        // specify a default in the columns package
        $current_tab_col = reqArkVar('curcol', $tcolarr['op_top_col']);
        if ($current_tab_col == 'zero') {
            $current_tab_col = '0';
        }
        $nav = FALSE;
            foreach($disp_cols as $cur_col_id => $disp_col) {
                // loop over the columns building the nav
                if ($disp_col['col_alias'] == 'Site Stuff') {
                    $nav .= "<li><a href=\"{$_SERVER['PHP_SELF']}";
                    $nav .= "?{$sf_key}={$sf_val}";
                    $nav .= "&amp;curcol={$disp_col['col_id']}\">";
                    $nav .= "$sitename</a></li>\n";
                }else {
                    $nav .= "<li><a href=\"{$_SERVER['PHP_SELF']}";
                    $nav .= "?{$sf_key}={$sf_val}";
                    $nav .= "&amp;curcol={$disp_col['col_id']}\">";
                    $nav .= "{$disp_col['col_alias']}</a></li>\n";
                }
            }
            // print the nav
            printf("<div id=\"column-{$disp_col['col_id']}\" class=\"{$disp_col['col_type']}\">\n");
            printf("<div id=\"tabnav\">\n<ul>\n$nav</ul>\n</div>\n\n");
            // loop over the subforms for the active column
            foreach($disp_cols as $cur_col_id => $disp_col) {
                if ($disp_col['col_id'] == $current_tab_col) {
                    $cur_col_subforms = $disp_col['subforms'];
                    if (substr($disp_col['col_id'], 0,6) == $xmi_tab_mod .'_cd') {
                        $xmi_tab = array($xmi_tab_mod . '_cd' => substr($disp_col['col_id'], 7));
                        $sf_key = key($xmi_tab);
                        $sf_val = $xmi_tab[$sf_key];
                    }
                    foreach($cur_col_subforms as $cur_sf_id => $cur_col_subform) {
                        // if this is an anon login - set the edit options to be OFF
                        if ($anon_login) {
                            // temporarily make the cols static
                            $temp_cols = $disp_cols;
                            // fix the new sf_nav_type
                            $temp_cols[$cur_col_id]['subforms'][$cur_sf_id]['sf_nav_type'] = 'name';
                            // make the static named disp cols dynamic again
                            $$disp_cols = $temp_cols;
                        }
                        if (array_key_exists('op_condition', $cur_col_subform)) {
                            if (chkSfCond($item_key, $$item_key, $cur_col_subform['op_condition'])) {
                                $sf_state = 
                                    getSfState(
                                        $disp_col['col_type'],
                                        $cur_col_subform['view_state'],
                                        $cur_col_subform['edit_state']
                                );
                                $sf_conf = $cur_col_subform;
                                include($cur_col_subform['script']);
                                unset ($sf_state);
                                unset($cur_col_subform);
                            }
                        } else {
                            $sf_state = 
                                getSfState(
                                    $disp_col['col_type'],
                                    $cur_col_subform['view_state'],
                                    $cur_col_subform['edit_state']
                            );
                            $sf_conf = $cur_col_subform;
                            include($cur_col_subform['script']);
                            unset ($sf_state);
                            unset($cur_col_subform);
                        }
                    }
                    unset($cur_col_subforms);
                }
        }
        printf("</div>\n\n");
    }
}

?>

<!-- end MAIN -->
</div>


<!-- ARK FOOTER -->
<?php  include($ark_server_path."/skins/".$skin."/templates/inc-footer.php");  ?>


<!-- end WRAPPER -->
</div>


</body>
</html>
