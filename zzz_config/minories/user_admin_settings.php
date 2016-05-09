<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/user_admin_settings.php
*
* User Admin specific settings file for this version of ARK
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2012  L - P : Heritage LLP.
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
* @category   admin
* @package    ark
* @author     Michael Johnson <m.johnson@lparchaeology.com>
* @copyright  1999-2014 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/config/user_admin_settings.php
* @since      File available since Release 1.2
*/

$link_list_useradmin =array();

$link_list_useradmin[] =
array(
                'href' => "{$_SERVER['PHP_SELF']}?view=addusrl",
                'mknname' => 'adduser',
                'css_class' => FALSE,
                'lightbox' => FALSE
);

$link_list_useradmin[] =
array(
                'href' => "{$_SERVER['PHP_SELF']}?view=edtuser",
                'mknname' => 'edituser',
                'css_class' => FALSE,
                'lightbox' => FALSE
);

$ualp_subform_useradmin =
array(
                'view_state' => 'max',
                'edit_state' => 'view',
                'sf_nav_type' => 'none',
                'sf_title' => 'edt_user',
                'sf_html_id' => 'delpadmin', // Must be unique
                'script' => 'php/subforms/sf_linklist.php',
                'op_sf_cssclass' => 'menulnk',
                //type uses same fields (see below)
                'links' => $link_list_useradmin
);

$user_admin_left_panel =
    array(
        'col_id' => 'delp',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' =>
            array(
                // $uhlp_subform_profilepane,
                $ualp_subform_useradmin,
                ),
);

//These are a bit like subforms

$conf_sf_userdetails=
    array(
        'sf_html_id' => 'user_details', // Must be unique
        'sf_nav_type' => 'name',
        'view_state' => 'max',
        'edit_state' => 'edit',
        'op_frm_action' => $_SERVER['PHP_SELF'],
        'op_frm_header' => 'edt_user',
        'op_update_val' => 'edtusr',
        'op_show_pw' => 'off',
        'op_show_uname' => 'on',
        'op_mk_button' => 'save',
        'op_additional_hidden' => array('user_id'),
        'script' => 'php/user_admin/global_subforms/user_form_elements.php',
);

$conf_sf_userinfo =
array(
                'view_state' => 'max',
                'edit_state' => 'view',
                'sf_title' => 'info',
                'sf_html_id' => 'user_info', // Must be unique
                'script' => 'php/subforms/sf_txt.php',
                'sf_nav_type' => 'name',
                'op_label' => 'space',
                'op_input' => 'save',
                'op_checkitemkey' => TRUE,
                'fields' =>
                array(
                                $conf_field_name,
                                $conf_field_initials,
                ),
);
$conf_sf_password=
    array(
        'sf_html_id' => 'user_password', // Must be unique
        'sf_nav_type' => 'name',
        'view_state' => 'max',
        'edit_state' => 'edit',
        'op_frm_action' => $_SERVER['PHP_SELF'],
        'op_frm_header' => 'change_pw',
        'op_update_val' => 'edtpwd',
        'op_mk_button' => 'save',
        'op_additional_hidden' => array('user_id'),
        'script' => 'php/user_admin/global_subforms/user_form_elements_pw.php',
);

$conf_sf_sgrp=
    array(
        'sf_html_id' => 'user_sgrp', // Must be unique
        'sf_nav_type' => 'name',
        'view_state' => 'max',
        'edit_state' => 'edit',
        'op_frm_action' => $_SERVER['PHP_SELF'],
        'op_frm_header' => 'edt_sgrps',
        'op_update_val' => 'adsgrp',
        'op_mk_button' => 'save',
        'op_additional_hidden' => array('user_id'),
        'script' => 'php/user_admin/global_subforms/user_form_elements_sgrp.php',
);

$conf_usredt_col =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' => 
            array(
                $conf_sf_userdetails,
                $conf_sf_userinfo,
                $conf_sf_password,
                $conf_sf_sgrp
            ),
);

$conf_usredt_view =
    array(
       'op_display_type' => 'cols',
       'op_top_col' => 'main_column',
       'columns' =>
           array(
               $conf_usredt_col
            ),
);

