<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/update_itemval.php
*
* process script for changing an itemval (paired with a subform)
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
    // ---- DATA ----
    // do some validation on this key
    if (!chkValid($target_itemval, FALSE, FALSE, $mod.'_tbl_'.$mod, $mod.'_cd')) {
        $armed = FALSE;
        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_notvalid');
    }
    // do the number crunching (output below)
    $record =
        array(
            'itemkey' => $sf_key,
            'itemvalue' => $sf_val,
            'target_itemvalue' => $target_itemval,
            'data' => 0,
    );
    // if there are frags, get the chained data
    if ($data_chains = getChData(FALSE, $sf_key, $sf_val)) {
        $record['data'] = $data_chains;
    } else {
        $record['data'] = FALSE;
    }
    $frags = array();
    collateFrags($record['data'], 'frags');
    $conflicted_frag_count = count($frags);
}

// Include the validation functions
include_once ('php/validation_functions.php');

// ---- QUERIES ---- //
// if there are no frags to handle, go straight to the itemkey
if (!isset($frags) or !is_array($frags) or count($frags) < 1) {
    $qrys = FALSE;
    // ITEMKEY
    $qry =
        array(
            'qtype' => 'edt',
            'dataclass' => 'itemkey',
            'itemkey' => $sf_key,
            'old_itemval' => $sf_val,
            'new_itemval' => $target_itemval,
    );
    $qrys[] = $qry;
    unset ($qry);
} else {
    // loop over the frags
    foreach ($frags as $key => $frag) {
        $qry =
            array(
                'qtype' => 'edt',
                'dataclass' => $frag['dataclass'],
                'frag_id' => $frag['id'],
                'new_itemkey' => $sf_key,
                'new_itemval' => $target_itemval,
                'cre_by' => $user_id,
                'cre_on' => 'NOW()'
        );
        $qrys[] = $qry;
    }
    // then add in the item itself
    // check to see if the head of the chain is a proper item
    if (isItemkey($sf_key)) {
        // for itemkeys put in a query as follows
        $qry =
            array(
                'qtype' => 'edt',
                'dataclass' => 'itemkey',
                'itemkey' => $sf_key,
                'old_itemval' => $sf_val,
                'new_itemval' => $target_itemval,
        );
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
            // ITEMKEYS - will be edited
            if ($qry['dataclass'] == 'itemkey' && $qry['qtype'] == 'edt') {
                $qry_results[] =
                    edtItemVal(
                        $qry['itemkey'],
                        $qry['old_itemval'],
                        $qry['new_itemval']
                );
                unset ($qrys[$key]);
            }
            // FRAGS - will be edited
            if ($qry['dataclass'] != 'itemkey' && $qry['qtype'] == 'edt') {
                $qry_results[] =
                    edtFragKey(
                        $qry['frag_id'],
                        $qry['dataclass'],
                        $qry['new_itemkey'],
                        $qry['new_itemval'],
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
        $message[] = "'{$qry['qtype']}' '{$qry['dataclass']}' was not executed (no handler in update_itemval?)";
    }
}

if (isset($qry_results) && count($qry_results) == $conflicted_frag_count+1) {
    $message[] = getMarkup('cor_tbl_markup', $lang, 'valchgsuccs');
    $update_success = TRUE;
    // pass the new sf_val down to prevent subsequent sf's from breaking
    $sf_val = $target_itemval;
} else {
    $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_valchgfail');    
    $update_success = FALSE;
}

?>
