<?php 

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* user_home/edtmyuser.php
*
* the editmyuser view, organises various bits of subform into something meaningful
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
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/user_home/edtmyuser.php
* @since      File available since Release 0.6
*/

// This view makes use of code belonging to the user_admin pages. This will not work without the user_admin code installed

if ($update_db) {
    include('php/user_admin/global_update.php');
}

if (!$error) {
    
    $frm_action = $_SERVER['PHP_SELF'];
    $frm_header = getMarkup('cor_tbl_markup', $lang, 'edt_user');
    $update_val = 'edtusr';
    $show_pw = 'off';
    $show_uname = 'on';
    $mk_button = getMarkup('cor_tbl_markup', $lang, 'save');
    $additional_hidden = "<input type=\"hidden\" name=\"user_id\" value=\"$user_id\" />";
    include('php/user_admin/global_subforms/user_form_elements.php');
    
    $frm_action = $_SERVER['PHP_SELF'];
    $frm_header = getMarkup('cor_tbl_markup', $lang, 'change_pw');
    $update_val = 'edtpwd';
    $mk_button = getMarkup('cor_tbl_markup', $lang, 'save');
    $additional_hidden = "<input type=\"hidden\" name=\"user_id\" value=\"$user_id\" />";
    include('php/user_admin/global_subforms/user_form_elements_pw.php');
    
    // Only if the user that has logged in has admin right can they change their own group. 
    if (isset($groups[2])) {
        $frm_action = $_SERVER['PHP_SELF'];
        $frm_header = getMarkup('cor_tbl_markup', $lang, 'edt_sgrps');
        $update_val = 'adsgrp';
        $mk_button = getMarkup('cor_tbl_markup', $lang, 'save');
        $additional_hidden = "<input type=\"hidden\" name=\"user_id\" value=\"$user_id\" />";
        include_once('php/user_admin/global_subforms/user_form_elements_sgrp.php');
    }
}

?>
