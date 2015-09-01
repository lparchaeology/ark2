<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_view/subforms/update_feedbuilder.php
*
* process script for creating a feed (paired with a subform)
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
* @category   subforms
* @package    ark
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_view/subforms/update_feedbuilder.php
* @since      File available since Release 1.0
*
* This is the companion update script that goes with the sf_exportdownload.php
* subform. This Subform is expected to be used in an overlay, but could be adjusted
* to work as a standard sf if needed. The user interface and feedback are handled by
* the sf itself.
*
* This update can be used to process a results array into any feed format, but
* this export to feed is performed by an export function in the export_functions.php
* file. The requested $feed_mode must therefore match an existing function.
*
* As of v0.8 the only functions are exportRSS() and exportAtom() (function calls are
* not case sensitive).
*
* This script needs a results array to be made available to it. It expects this
* to be live and called 'results_array'.
*
* Fields and other setup should be made available in the sf_conf itself. See the SF
* for further notes.
*
*/


// ---- MARKUP ---- //
$mk_err_feedmode = getMarkup('cor_tbl_markup', $lang, 'err_feedmode');
$mk_err_feedftr = getMarkup('cor_tbl_markup', $lang, 'err_feedftr');
$mk_err_feedlimit = getMarkup('cor_tbl_markup', $lang, 'err_feedlimit');
$mk_err_feedtitle = getMarkup('cor_tbl_markup', $lang, 'err_feedtitle');
$mk_err_feeddesc = getMarkup('cor_tbl_markup', $lang, 'err_feeddesc');
$mk_err_feeddisp_mode = getMarkup('cor_tbl_markup', $lang, 'err_feeddisp_mode');


// ---- EVALUATION ---- //

// Assume no errors yet!
if (!$error) {
    $error = FALSE;
}

// $limit
if (!$limit) {
    $error[] = array('field' => 'limit', 'vars' => "$mk_err_feedlimit");
}
if (!is_numeric($limit)) {
    $error[] = array('field' => 'limit', 'vars' => "$mk_err_feedlimit");
}
// $filters
if (!$filters) {
    $error[] = array('field' => 'filters', 'vars' => "$mk_err_feedftr");
}
if (!is_array($filters)) {
    $error[] = array('field' => 'filters', 'vars' => "$mk_err_feedftr");
}
// $feed_mode
// accepted modes - DEV NOTE: this should be in config?
$accepted_modes = array('RSS', 'RDF', 'atom');
if (!$feed_mode) {
    $error[] = array('field' => 'feed_mode', 'vars' => "$mk_err_feedmode");
}
if (!in_array($feed_mode, $accepted_modes)) {
    $error[] = array('field' => 'feed_mode', 'vars' => "$mk_err_feedmode");
}
// $feedtitle
if (!$feedtitle) {
    $error[] = array('field' => 'feedtitle', 'vars' => "$mk_err_feedtitle");
}
// $feeddesc
if (!$feeddesc) {
    $error[] = array('field' => 'feeddesc', 'vars' => "$mk_err_feeddesc");
}
// $feeddisp_mode
if (!$feeddisp_mode) {
    $error[] = array('field' => 'feeddisp_mode', 'vars' => "$mk_err_feeddisp_mode");
}
// $feedfields - this are the fields that are currently 'live' when the feed is being saved - in order to ensure that the feed has the same fields as currently specified by the user
if ($feeddisp_mode) {
    $feedfields = reqModSetting(splitItemkey($sf_key),"conf_mac_$feeddisp_mode");
    $feedfields = $feedfields['fields'];
}

// ---- PROCESS ---- //

// start timing the script (see below for further notes)
$time_start = microtime(true);

// run the output function
// print direct to page to avoid the rest of this script
$feed_permalink = addFeed($filters, $feed_mode, $limit, $feedtitle, $feeddesc, $feeddisp_mode, $feedfields);

// errors and messages are returned in an array
// detect this and handle the output as appropriate
if (is_array($feed_permalink)) {
    if (array_key_exists('error', $feed_permalink)) {
        $error[] = $feed_permalink['error'];
    }
    if (array_key_exists('message', $feed_permalink)) {
        $msg = $feed_permalink['message'][0];
        $message[] = $msg['vars'];
        $feed_permalink = FALSE;
    }
}

// if the $feed_permalink is done and we don't have errors then set a flag
if ($feed_permalink && !$error) {
    $feed_success = TRUE;
}

// we want the script to run for a minimum time
$target_time = 5; // in seconds
// find out how long the script took
$time_end = microtime(true);
$time = $time_end - $time_start;
// find out how much time remains (or not)
$leftover_time = $target_time - $time;
// if there is leftover time...
if ($leftover_time > 0) {
    // sleep for the rest of the time
    sleep($leftover_time);
}

?>
