<?php 

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* user_admin/edtuser.php
*
* edit user view that organises global subforms into something specific
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
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/user_admin/edtuser.php
* @since      File available since Release 0.6
*/

?>
<div id="user_admin">
	<div class="record_nav" id="record_nav">
		<div id="itemval_jumper">
		
<?php 

include_once('php/user_admin/inc_user_nav.php'); 

?>
</div>
	</div>
<?php

if(isset($target_user_id) && empty($sf_val)) {
    $sf_key = getUserAttr($target_user_id,'itemkey');
    $sf_val = getUserAttr($target_user_id,'itemvalue');
}
$col = $conf_usredt_col;

// sf's expect $$disp_cols to be set up
// In the case of data entry there is only one col
$disp_cols = 'usredit';
$$disp_cols = array($col);
$cur_col_id = 0;


if (reqArkVar('mlc') != 'php/inc_error.php' && $target_user_id) {

    $admin_ops = array(
                    'frm_action',
                    'show_pw',
                    'show_uname',
                    'update_val',
    );
    foreach ( $col['subforms'] as $cur_sf_id => $sf_conf ) {
        $mod_short = 'abk';
        $permitted = TRUE;
        if (array_key_exists('op_condition', $sf_conf)) {
            $permitted = chkSfCond($item_key, $$item_key, $sf_conf['op_condition']);
        }
        if (array_key_exists('op_checkitemkey', $sf_conf)) {
            if ($sf_conf['op_checkitemkey']) {
                if (!$sf_key || !$sf_val) {
                    $permitted = FALSE;
                }
            }
        }
        foreach ( $admin_ops as $admin_op ) {
            $option_name = 'op_' . $admin_op;
            if (array_key_exists($option_name, $sf_conf)) {
                $$admin_op = $sf_conf[$option_name];
            }
        }
        if (array_key_exists('op_frm_header', $sf_conf)) {
            $frm_header = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_frm_header']);
        }
        $additional_hidden = "";
        if (array_key_exists('op_additional_hidden', $sf_conf)) {
            foreach ( $sf_conf['op_additional_hidden'] as $hidden ) {
                $additional_hidden .= "<input type=\"hidden\" name=\"$hidden\" value=\"{$$hidden}\" />";
            }
        }
        //we are always going to need the target user id
        $additional_hidden .= "<input type=\"hidden\" name=\"user_id\" value=\"{$target_user_id}\" />";
        if ($permitted) {
            $temp_cols = $$disp_cols;
            // col is always 0 for datentry
            $temp_cols[0]['subforms']["$cur_sf_id"]['edit_state'] = 'ent';
            switch($sf_conf['sf_nav_type']) {
                case 'nmedit' :
                    $temp_cols[0]['subforms']["$cur_sf_id"]['sf_nav_type'] = 'name';
                    break;
                case 'full' :
                case 'nmeditmm' :
                    $temp_cols[0]['subforms']["$cur_sf_id"]['sf_nav_type'] = 'nmmm';
                    break;
                case 'nmedit_help' :
                    $temp_cols[0]['subforms']["$cur_sf_id"]['sf_nav_type'] = 'help';
                    break;
                default :
                    break;
            }
            // make the static named disp cols dynamic again
            $$disp_cols = $temp_cols;
            $sf_conf['edit_state'] = 'ent';
            $sf_state = getSfState($col['col_type'], $sf_conf['view_state'], $sf_conf['edit_state']);
            include ($sf_conf['script']);
        }
        unset($permitted);
        unset($sf_state);
    }

    include_once ('php/user_admin/global_subforms/user_form_elements_activate.php');

    if (isset($fields)) {
        include_once ('php/update_db.php');
    }
}
?>
</div>
