<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_view/subforms/update_exportdownload.php
*
* process script for creating a download (paired with a subform)
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
* @link       http://ark.lparchaeology.com/svn/php/data_view/subforms/update_exportdownload.php
* @since      File available since Release 0.8
*
* This is the companion update script that goes with the sf_exportdownload.php
* subform. This Subform is expected to be used in an overlay, but could be adjusted
* to work as a standard sf if needed. The user interface and feedback are handled by
* the sf itself.
*
* This update can be used to process a results array into any file format, but
* this export to file is performed by an export function in the export_functions.php
* file. The requested $dl_mode must therefore match an existing function.
*
* As of v0.8 the only function is exportCSV.php (function calls are not case
* sensitive).
*
* This script needs a results array to be made available to it. It expects this
* to be live and called 'results_array'.
*
* Fields and other setup should be made available in the sf_conf itself. See the SF
* for further notes.
*
*/

// ---------- Evaluation ------------

// Assume no errors yet!
if (!$error) {
    $error = FALSE;
}

// start timing the script (see below for further notes)
$time_start = microtime(true);

// Markup
$mk_problem_item = getMarkup('cor_tbl_markup', $lang, 'problem_item');
$mk_problem_string = getMarkup('cor_tbl_markup', $lang, 'problem_string');

// ---- PROCESS ---- //

// select the function to be used to return the exported results
$export_func = 'export'.$dl_mode;

// modify the fields in the sf_conf so that they contain the live view fields
// VIEW & CONF
$results_mode = reqQst($_SESSION, 'results_mode');
$disp_mode = reqQst($_SESSION, 'disp_mode');
// this form can only be used to change the fields if we are on a $results_mode == 'disp'
if ($results_mode == 'disp') {
    // there can be several disp modes and we need to have one set
    if (!$disp_mode) {
        echo "ADMIN ERROR: There was no disp_mode set";
    } else {
        // get the 'conf_mac_XXX' array for this module
        $conf_name = 'conf_mac_'.$disp_mode;
        $conf = reqModSetting($mod_short, $conf_name);
        // DEV NOTE: config failsafe
        foreach ($conf['fields'] as $key => $field) {
            if (!array_key_exists('field_id', $field)) {
                $conf['fields'][$key]['field_id'] = 'not_set';
            }
        }
        // eliminate the options column
        foreach ($conf['fields'] as $field) {
            if ($field['dataclass'] != 'op') {
                $sf_conf['fields'][] = $field;
            }
        }
    }
} else {
    echo "ADMIN ERROR: The results mode must be disp for this form to work<br/>";
}

// run the output function
// print direct to page to avoid the rest of this script
$dl = $export_func($results_array, $sf_conf);

// errors and messages are returned in an array
// detect this and handle the output as appropriate
if (is_array($dl)) {
    if (array_key_exists('error', $dl)) {
        $error[] = $dl['error'];
    }
    if (array_key_exists('message', $dl)) {
        $msg = $dl['message'][0];
        $message[] = $msg['vars'];
        $message[] = "$mk_problem_item: {$msg['problem_key']} - {$msg['problem_val']}";
        $message[] = "$mk_problem_string: '{$msg['problem_string']}'";
        $dl = $dl['file'];
    }
}

// if the $dl is done and we don't have errors then set a flag to
// put the 
if ($dl && !$error) {
    $dl_success = TRUE;
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
