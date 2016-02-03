<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* index.php
*
* Main index of Ark installation
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
* @link       http://ark.lparchaeology.com/svn/index.php
* @since      File available since Release 0.6
*/

// INCLUDES
include('src/settings.php');
include('php/global_functions.php');
$lang = $default_lang;


//THE ENTIRE INDEX PAGE IS A FUNCTION
function login_page($errorMessage) {

include('src/settings.php');

if(!file_exists($ark_root_dir.'/skins/'.$skin.'/templates/login_page.php')){
    header('Location: config/preflight_checks.php');
}

// PART1 - Basic setup
global $skin, $arkname, $lang;

// pagename
$pagename = 'user_home';

//MARKUP
$mk_arkname = getMarkup('cor_tbl_markup', $lang, $arkname_mk);
$mk_splash = getMarkup('cor_tbl_markup', $lang, 'splash');

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

$browser = browserDetect();
$stylesheet = getStylesheet($browser);
$page_title = $mk_arkname;
$cwidth = reqQst($_REQUEST, 'nwidth');

// ---------OUTPUT--------- //
include_once($ark_root_dir.'/skins/'.$skin.'/templates/login_page.php');

}

//DO AUTHENTICATION

// This is the part of the script checks auth status and does the redirections as appropriate
include_once ('src/settings.php');

//LOGOUT ROUTINE
$logout = reqQst($_REQUEST,'logout');
if ($logout) {
    @session_destroy();
    session_name($ark_name);
    session_start();
    $_SESSION['authorised']=FALSE;
    $_SESSION['loginMessage'] = 'You logged out';
}
if (!isset($_SESSION)){
    session_name($ark_name);
    session_start();
}
$target_url = reqQst($_SESSION, 'target_url');

require_once ('php/auth/liveuser/conf.php');
require_once ('php/auth/liveuser/createlu.php');
if ($$liveuser->isLoggedIn()) {
    $_SESSION['authorised'] = TRUE;
} else {
    $_SESSION['authorised'] = FALSE;
}
$_SESSION['target_url'] = $target_url;

if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    $anon_login = TRUE;
}
//LOGIN AUTHENTICATION
if (reqQst($_SESSION, 'authorised')&&!isset($anon_login)) {
    //there is a user logged in
    if ($target_url && $target_url!=$ark_root_path.'/index.php') {
        header("Location: $target_url");
    } else {
        header("Location: user_home.php");
    }
} else {
    // Unauthorised login attempt
    if ($_SESSION && !$logout) {
        if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            if (end(split('/', $_SERVER['HTTP_REFERER'])) == 'index.php') {
                $_SESSION['loginMessage'] = "Sorry, we couldn't find an account with that username and password.";
            } else if(@$anon_login){
                
                 header("Location: data_view.php");
            }
        } 
    } 
    // No session established, no POST variables
    // Display the login form and any error message
    login_page(reqQst($_SESSION, 'loginMessage'));
    session_destroy();
    }

?>
