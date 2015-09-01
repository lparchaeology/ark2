<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/update_assemblage.php
*
* Subform for updating assemblage information
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
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Henriette Roued <henriette@roued.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/update_assemblage.php
* @since      File available since Release 0.6
*/

// ---------- Get Global Updates for data_entry ------------

include ('php/mod_cxt/update_detfrm.php');
// Include the validation functions
include_once ('php/validation_functions.php');

// --- Request Variables --- //
$frag_id = reqQst($_REQUEST, 'frag_id');
$fragtype = 'attribute';

$ste_cd = $_SESSION['ste_cd'];
$cre_by = $user_id;
$cre_on = 'NOW()';

//check if this is an anonymous login - if it is then prevent the edits
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    $error[]['vars'] = "Sorry, you are not authorised to edit the data.";
}

// --- Dynamic variables --- //
foreach ($fields as $field) {
    //Make a compound field name
    $num_field = $field['classtype'];
    //request the submitted number
    $form_num = reqQst($_REQUEST, $num_field);
    // Check for submitted number and see if it is numeric    
    if ($form_num) {
        if (!is_numeric($form_num)) {
            $error[] = 
            array(
            'field' => $num_field,
            'vars' => "The value '$form_num' is not numeric",
            'err' => 'on'
            );
        }
    }
    // Request the current number of the form 
    $current = getNumber('cor_tbl_attribute', $frag_id, $field['classtype']);
    // If there has been submitted a number
    if ($form_num) {
        // And if there is already a number in the form    
        if ($current) {
            // Get the row id of the current number    
            $current_id = $current[0][0];
            $current = $current[0]['number'];
            // Change the current number to the submitted number
            $qry_1[] =
            array(
            'dataclass' => 'number',
            'qtype' => 'edt',
            'frag_id' => $current_id,
            'number' => $form_num,
            'cre_by' => $cre_by,
            'cre_on' => $cre_on
            );
        // If there is no current number in the form then add the submitted number instead
        } else {
            $vd_numbertype =
            array(
            'rq_func' => 'reqClassType',
            'vd_func' => 'chkSet',
            'var_name' => 'numbertype',
            'lv_name' => 'classtype',
            'var_locn' => 'field'
            );
            $qry_1[] =
            array(
            'dataclass' => 'number',
            'qtype' => 'add',
            'numbertype' => reqClassType($vd_numbertype, $field),
            'itemkey' => 'cor_tbl_attribute',
            'itemval' => $frag_id,
            'number' => $form_num,
            'cre_by' => $cre_by,
            'cre_on' => $cre_on
            );
            unset($vd_numbertype);
        }
    }
}
// ---------- Execution ------------

// If there are no errors and the query has been set
if (!$error && $qry_1) {
    //Walk through the queries
    foreach ($qry_1 as $xqry) {
        // number - edt
        if ($xqry['dataclass'] == 'number' && $xqry['qtype'] == 'edt') {
            $qry_results[] =
                edtNumber(
                    $xqry['frag_id'],
                    $xqry['number'],
                    $xqry['cre_by'],
                    $xqry['cre_on']
            );
        }
        // number - add
        if ($xqry['dataclass'] == 'number' && $xqry['qtype'] == 'add') {
            $qry_results[] =
                addNumber(
                    $xqry['numbertype'],
                    $xqry['itemkey'],
                    $xqry['itemval'],
                    $xqry['number'],
                    $xqry['cre_by'],
                    $xqry['cre_on']
            );
        }
    }
}

?>
