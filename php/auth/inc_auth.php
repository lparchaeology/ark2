<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* auth/inc_auth.php
*
* handles the ARK authentication. It checks for username and passwords
* and creates a user if applicable. It also checks to see if the user
* has permission to view the page and if not sends them back to the
* login page.
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
* @category   auth
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/auth/inc_auth.php
* @since      File available since Release 0.6
*/

//include the functions
require_once ('php/auth/auth_functions.php');
require_once ('php/filter_functions.php');

//setup the LiveUser variables
require_once ('php/auth/liveuser/conf.php');
require_once ('php/auth/liveuser/createlu.php');

//check if there is a user - if not then send it to login in
if (!$$liveuser->isLoggedIn()) {
    header("Location: $loginScript");
} else {
    $_SESSION['authorised'] = TRUE;
}

//now we set up variables about the user to be used throughout the application
$user_id =  $$liveuser->getProperty('auth_user_id');
$soft_name = getSingle('firstname', 'cor_tbl_users', 'id = ' . $user_id ) . " " .  getSingle('lastname', 'cor_tbl_users', 'id = ' . $user_id );
$first_name = $$liveuser->getProperty('firstname');
$sfilter_id = $$liveuser->getProperty('sfilter');
$cre_by = $user_id;

//lets make the sgrp array using the LiveUserAdmin
//DEV NOTE: There seems to be an error with the subgroups in LiveUser - therefore
//currently you have to add the user to every group

$params =
    array( 
        'filters' =>
            array(
                'perm_user_id' => $$liveuser->getProperty('perm_user_id'),
        ), 
        'subgroups' => 'hierarchy',
        'hierarchy' => 1,
        'rekey' => 1,
);

$groups = $$liveuser_admin->perm->getGroups($params);

foreach ($groups as $key => $group) {
    //add the group into the security group array
    $sgrp_arr[] = $key;
    //now go through its subgroups adding those
    if (array_key_exists('subgroups',$group)) {
        $sub_group_arr = $group['subgroups'];
        do {
            if (isset($subgroup['subgroups'])) {
                $sub_group_arr = $subgroup['subgroups'];
            }
            if ($sub_group_arr){
                foreach ($sub_group_arr as $sub_key => $subgroup){
                    $sgrp_arr[] = $sub_key;
                }
            }
        } while (isset($subgroup['subgroups']));
    }
}

// save the sgrp array to the session
$_SESSION['sgrp_arr'] = $sgrp_arr;


// get a list of pages this user is permitted access
$conf_pages = LPArchaeology\ARK\Web\PageConfig::pages();
foreach ($conf_pages as $auth_pg) {
    if ($auth_pg->isValid() and in_array($auth_pg->sgrp(), $sgrp_arr)) {
        $authorised_pages[] = $auth_pg;
    } else {
        echo "ADMIN ERROR: No config in database for page ".$auth_pg->id()."<br/>";
    }
}

// check to see if the current page is in the authorised list
if (in_array($psgrp, $sgrp_arr)) {
    $authorised = TRUE;
} else {
    $authorised = FALSE;
}

// Handle an unauthorised situation
if (!$authorised) {
   //Might wanna change this so it grabs the title of the page from the database!
   $_SESSION["loginMessage"] = "You are not authorised to access the URL " . $_SERVER['REQUEST_URI'];
   //register the target url
   $_SESSION['target_url'] = $_SERVER['REQUEST_URI'];
   $_SESSION['authorised'] = FALSE;
   // Head back to the login page
   header("Location: " . $loginScript);
   exit;
}

// AUTH ITEMS
// Decide if sfilters are in place
// DEV NOTE: If your filter_id is 0 you may run into problems
if ($sfilter_id != 0) {
    // if sfilters are in play, get the results and pass them on
    $sfilter_results = getSfilter($sfilter_id);
    $authitems = getAuthItems($sfilter_results);
} else {
    // otherwise just get the defaults
    $authitems = getAuthItems();
}

// if we a specific item key then check if it is valid
if (isset($item_key)) {
    // The key id in the array
    if ($$item_key && $authitems && $$item_key != 'next' && substr($item_key, 0, 7) != 'cor_tbl' && substr($item_key, 0, 7) != 'cor_lut') {
        $mod_array = reqQst($authitems, $item_key);
        if ($mod_array) {
            $itemkey_check = in_array($$item_key, $mod_array);
        } else {
            $itemkey_check = FALSE;
        }
        if (!$itemkey_check || !$mod_array) {
            $mk = getMarkup('cor_tbl_markup', $lang, 'notinauthitems');
            $error[] = array(
                            'vars' => $mk . ": " . $item_key . " - " . $$item_key
            );
        }
    }
}

?>
