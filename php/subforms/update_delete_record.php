<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/update_delete_record.php
*
* process script for deleting an entire record (paired with a subform)
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_interp.php
* @since      File available since Release 0.8
*/

// ---------- Evaluation ------------

// Assume no errors yet!
if (!$error) {
    $error = FALSE;
    $qrys = FALSE;
}

// data will be supplied by the subform in most cases
// IF however this is called at page level, it need to gather data
if (!isset($record)) {
    // Get the data for the record
    $record =
        array(
            'itemkey' => $delete_key,
            'itemvalue' => $delete_val,
            'data' => 0,
    );
    // if there are frags, get the chained data
    if ($data_chains = getChData(FALSE, $delete_key, $delete_val, FALSE, 'R')) {
        $record['data'] = $data_chains;
        // Collate this data into a flat array of frags
        unset($del_frags);
        $del_frags = array();
        collateFrags($record['data'], 'del_frags');
        // Count them
        $num_del_frags = count($del_frags);
    } else {
        $record['data'] = FALSE;
        $num_del_frags = 0;
        $del_frags = FALSE;
    }
}

// Include the validation functions
include_once ('php/validation_functions.php');

// ---- QUERIES ---- //
// if there are no frags to handle, go straight to the itemkey
if (!isset($del_frags) or !is_array($del_frags) or count($del_frags) < 1) {
    $qrys = FALSE;
    // check to see if this item code is valid
    $mod = splitItemkey($delete_key);
    if (!chkValid($delete_val, FALSE, FALSE, $mod.'_tbl_'.$mod, $delete_key)) {
        // finally add in the item itself
        $qry =
            array(
                'qtype' => 'del',
                'dataclass' => $delete_key,
                'frag_id' => $delete_val,
                'cre_by' => $user_id,
                'cre_on' => 'NOW()'
        );
        $qrys[] = $qry;
    } else {
        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_notvalid');
    }
} else {
    foreach ($del_frags as $key => $frag) {
        $qry =
            array(
                'qtype' => 'del',
                'dataclass' => $frag['dataclass'],
                'frag_id' => $frag['id'],
                'cre_by' => $user_id,
                'cre_on' => 'NOW()'
        );
        $qrys[] = $qry;
    }
    // finally add in the item itself
    // check to see if the head of the chain is a proper item
    if (isItemkey($delete_key)) {
        // for itemkeys put in a query as follows
        $qry =
            array(
                'qtype' => 'del',
                'dataclass' => $delete_key,
                'frag_id' => $delete_val,
                'cre_by' => $user_id,
                'cre_on' => 'NOW()'
        );
        $qrys[] = $qry;
    } else {
        // for other frags, get the dataclass back from the delete_key
        $split = split('_', $delete_key);
        if ($split[0] == 'cor' && $split[1] == 'tbl') {
            $key = $split[2];
        }
        $qry =
            array(
                'qtype' => 'del',
                'dataclass' => $key,
                'frag_id' => $delete_val,
                'cre_by' => $user_id,
                'cre_on' => 'NOW()'
        );
        unset ($split);
        unset ($key);
        $qrys[] = $qry;
    }
}

//check if this is an anonymous login - if it is then prevent the edits
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']) {
    $error[]['vars'] = "Sorry, you are not authorised to edit the data.";
} else {
    $dry_run = FALSE;
}
// put this on for dev
if ($dry_run) {
    printPre($qrys);
}
// the query routine
if (!$error && $qrys && !$dry_run) {
    if (!$error) {
        // execute the delete frag routines
        foreach ($qrys as $key => $qry) {
            // ALL CLASSES - del
            if ($qry['dataclass'] != 'delete' && $qry['qtype'] == 'del') {
                $qry_results[] =
                    delFrag(
                        $qry['dataclass'],
                        $qry['frag_id'],
                        $qry['cre_by'],
                        $qry['cre_on']
                );
                unset ($qrys[$key]);
            }
        }
    }
}

if (!$error && !isset($qry_results)) {
    $message[] = getMarkup('cor_tbl_markup', $lang, 'andyet');
}
if (!empty($qrys) && !$dry_run) {
    foreach ($qrys as $qry) {
        $message[] = "'{$qry['qtype']}' '{$qry['dataclass']}' was not executed (no handler in update_delete_record?)";
    }
}

if (isset($qry_results) && count($qry_results) == $num_del_frags+1) {
    $message[] = getMarkup('cor_tbl_markup', $lang, 'err_recwasdel');
    $delete_success = TRUE;
} else {
    $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_delfail');    
    $delete_success = FALSE;
}

?>
