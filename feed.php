<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* feed.php    
*
* this is a wrapper page to produce a feed
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
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/feed.php
* @since      File available since Release 1.0
*/


// -- INCLUDE SETTINGS AND FUNCTIONS -- //
include('src/settings.php');
include('php/global_functions.php');
include('php/validation_functions.php');
include('php/export_functions.php');

// -- SESSION -- //
// Start the session
session_name($ark_name);
session_start();


// -- MANUAL configuration vars for this page -- //
$pagename = 'feed';
$error = FALSE;
$message = FALSE;


// -- REQUESTS -- //
$lang = reqArkVar('lang', $default_lang);


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
include_once ('php/auth/inc_auth.php');
// ANON LOGINS
// check for anon logins
//check if this is an anonymous login - if it is then prevent edits
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    $anon_login = TRUE;
} else {
    $anon_login = FALSE;
}


// -- FEED STUFF -- //
// set up an empty config array
$feed_conf = array();


// ---- REQUESTS ---- //
//request the variables needed and put in failsafes
$feed_id = reqQst($_REQUEST, 'feed_id'); // the filterset to feed
if (!$feed_id) {
    echo "ADMIN ERROR: no feed_id has been set</br>";
    die;
}
// Retreive the feed's filters
$filters = getFtr($feed_id);
if (!$filters) {
    echo "ADMIN ERROR: no filter for feed_id '$feed_id' can be found</br>";
    die;
}
// Querystring overrides otherwise use the saved vars
$feed_mode = reqQst($_REQUEST, 'feed_mode'); // the mode (only RSS or Atom as of v1.0)
if (!$feed_mode) {
    $feed_mode = $filters['feed_mode'];
    unset($filters['feed_mode']);
}
$limit = reqQst($_REQUEST, 'limit'); // the number of records to display
if (!$limit) {
    $limit = $filters['limit'];
    unset($filters['limit']);
}
// get the feed title
$feedtitle = $filters['feedtitle'];
// get the feed description
$feeddesc = $filters['feeddesc'];
// get the feed disp_mode
$feeddisp_mode = $filters['feeddisp_mode'];

// ---- CONF ---- //
$feed_conf['feed_id'] = $feed_id;
$feed_conf['feed_mode'] = $feed_mode;
$feed_conf['limit'] = $limit;
$feed_conf['feedtitle'] = $feedtitle;
$feed_conf['feeddesc'] = $feeddesc;
$feed_conf['feeddisp_mode'] = $feeddisp_mode;


// ---- MARKUP ---- //
$mk_norec = getMarkup('cor_tbl_markup', $lang, 'norec');
$mk_nofilters = getMarkup('cor_tbl_markup', $lang, 'nofilters');


// ---- FILTERS ---- //
// Run the filters
if ($filters) {
    foreach ($filters as $ftr_id => $filter) {
        if (is_int($ftr_id)) {
            $ftype = $filter['ftype'];
            // run the relevant filter
            $func = 'execFlt'.$ftype;
            if ($results_array && $new_res = $func($filter)) {
                $set_operator_func = 'res'.$filter['set_operator'];
                $results_array =
                    $set_operator_func(
                        $new_res,
                        $results_array
                );
            } else {
                $results_array = $func($filter);
            }
            unset($func);
            $oride_page = TRUE;
        }
    }
    // Run the sort order
    if (!array_key_exists('sort_order', $filters)) {
        $sort_order['sort_order'] = FALSE;
        // this puts the sort order to the beginning of the filters array
        $filters = $sort_order + $filters;
    }
    if ($filters['sort_order']) {
        $sort_field = $filters['sort_order']['sort_field'];
        // retrieve the field on which the search is to be performed (check on it carefully)
        // config failsafe
        if (!isset($$sort_field)) {
            // look for it in the module settings
            foreach ($loaded_modules as $key => $mod) {
                include('config/mod_'.$mod.'_settings.php');
            }
        }
        if (isset($$sort_field)) {
            $temp_col['fields'] = $$sort_field;
            $col = resTblTh($temp_col, 'silent');
            foreach ($results_array as $key => $res) {
                $sort_criterium = resTblTd($col['fields'], $res['itemkey'], $res['itemval']);
                $results_array[$key]['sort_on'] = $sort_criterium;
            }
            $results_array = sortResArr($results_array, $filters['sort_order']['sort_type'], 'sort_on');
        } else {
            echo "ADMIN ERROR: Field '$sort_field' cannot be found.";
        }
    }
}


// LIMIT
// trim the feed results array to the limit
if ($results_array) {
    $page_array = pageResults($results_array, 1, $limit);
    // output the paged results to the live var
    $results_array = $page_array['paged_results'];
}


// PRODUCE THE FEED
if ($results_array) {
    // process the results into a feed
    $feed_function = 'export'.$feed_mode;
    $feed = $feed_function($results_array, $feed_conf);
} else {
    $feed = array();
}


// OUTPUT
// add and error handler
if (is_array($feed)) {
    // do something
    echo "ADMIN ERROR: OOPS there's been some sort of fudge up";
} else {
    // output the feed
    header("Content-Type: application/{$feed_mode}+xml; charset=UTF-8");
    echo $feed;
}

?>
