<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/field_settings.php
*
* stores settings for 'fields' for this ARK instance. This makes
* the fields available for use in any subform in any module, as of v1.1
* all fields go in this file, and no longer in any of the mod_settings.
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
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2012 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/config/field_settings.php
* @since      File available since Release 0.6
*/

/**
*
* VALIDATION RULES
*
*/

include('vd_settings.php');

// CUSTOM VALIDATION
//CUSTOM VALIDATION

// this action is chained to a fragment not an item therefore
// it needs a special itemkey/value pair, not the standard one

$vd_txtchainkey =
    array(
        'rq_func' => 'reqManual',
        'vd_func' => 'chkSet',
        'var_name' => 'itemkey',
        'force_var' => 'cor_tbl_txt'
);
$vd_chainval =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'interp_id',
        'var_locn' => 'request'
);

$custom_action_add_vd =
    array(
        $vd_cre_on,
        $vd_cre_by,
        $action_vd_actor_itemkey,
        $action_vd_5,
        $action_vd_valid,
        $action_vd_6,
        $vd_txtchainkey,
        $vd_chainval
);

$custom_action_edt_vd =
    array(
        $vd_cre_on,
        $vd_cre_by,
        $action_vd_actor_itemkey,
        $action_vd_5,
        $action_vd_valid,
        $action_vd_6,
        $vd_txtchainkey,
        $vd_frag_id,
        $vd_chainval
);

$custom_date_add_vd =
    array(
        $vd_cre_on,
        $vd_cre_by,
        $date_vd_datetype,
        $date_vd_date,
        $date_vd_dateset,
        $vd_txtchainkey,
        $vd_chainval
);

$custom_date_edt_vd =
    array(
        $vd_cre_on,
        $vd_cre_by,
        $date_vd_datetype,
        $date_vd_date,
        $vd_txtchainkey,
        $vd_frag_id,
        $vd_chainval
);

$vd_attrchainkey =
array(
                'rq_func' => 'reqManual',
                'vd_func' => 'chkSet',
                'var_name' => 'itemkey',
                'force_var' => 'cor_tbl_attribute'
);
$vd_attrchainval =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'itemval',
        'var_locn' => 'request'
);

// add number chain2attribute validation group
$chain_number_add_validation =
array(
                $vd_cre_on,
                $vd_log,
                $vd_ste_cd,
                $vd_cre_by,
                $number_vd_numbertype,
                $number_vd_number,
                $vd_attrchainkey,
                $vd_attrchainval,
);
// edt number default validation group
$chain_number_edt_validation =
array(
                $vd_cre_on,
                $vd_log,
                $vd_ste_cd,
                $vd_cre_by,
                $number_vd_numbertype,
                $number_vd_number,
                $vd_attrchainkey,
                $vd_chainval,
                $vd_attrchainval,
);
// add txt default validation group
$chain_txt_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $txt_vd_txttype,
        $txt_vd_txt,
        $vd_attrchainkey,
        $vd_chainval,
        $vd_live_lang
);
// edt txt default validation group
$chain_txt_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $txt_vd_txttype,
        $txt_vd_txt,
        $vd_attrchainkey,
        $vd_chainval,
        $vd_frag_id,
        $vd_live_lang
);
// add xmi default validation group
$chain_xmi_add_validation =
array(
                $vd_attrchainkey,
                $vd_chainval,
                $xmi_vd_xmi_itemkey,
                $xmi_vd_xmi_itemlist,
                $vd_log,
                $vd_ste_cd,
                $vd_cre_on,
                $vd_cre_by
);

// edt xmi default validation group
$chain_xmi_edt_validation =
array(
                $vd_attrchainkey,
                $vd_chainval,
                $xmi_vd_xmi_itemkey,
                $xmi_vd_xmi_itemlist,
                $vd_log,
                $vd_ste_cd,
                $vd_cre_on,
                $vd_cre_by
);
/**
*
* FIELDS
*
* These arrays contain the info about each field.
*
* See the documentation for further information about what to put into
* each field: required vars, field_op vars and class specific vars.
*
* Documentation: http://ark.lparchaeology.com/wiki/index.php/Field_settings.php
*
* As of v1.1 all fields go in this file. No fields go in the mod settings.
*
*/

// -- ITEM KEY FIELDS -- //

/**
*
* Before v1.1 many of these fields were in their respective module settings
* files.
*
*/

// Itemkey for mod_abk (Address Book)
$conf_field_abk_cd =
    array(
        'field_id' => 'conf_field_abk_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'abk_cd',
        'module' => 'abk',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'abk_cd',
                'alias_type' => '1',
        ),
        'editable' => TRUE, // if FALSE, update_db will not process this field
        'hidden' => 'issuenext', // this makes the itemkey hidden in the register
        'field_op_default' => 'next', // and defaults to the next available number
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

$conf_field_abk_cd['add_validation'][] = $key_vd_modtype;
$conf_field_abk_cd['edt_validation'][] = $key_vd_modtype;

// Set up the abktype (Address Book)
$conf_field_abktype =
    array(
        'field_id' => 'conf_field_abktype',
        'dataclass' => 'modtype',
        'classtype' => 'abktype',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_col',
                'alias_col' => 'dbname',
                'alias_src_key' => 'abktype',
                'alias_type' => '1',
        ),
        'editable' => TRUE, // if FALSE, update_db will not process this field
        'hidden' => FALSE,
        'add_validation' => 'none',
        'edt_validation' => 'none'
);

// Itemkey for mod_cxt (Contexts)
$conf_field_cxt_cd =
    array(
       'field_id' => 'conf_field_cxt_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'cxt_cd', //this is needed to correctly request the qtype
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'cxt_cd',
                'alias_type' => '1',
        ),
        'module' => 'cxt',
        'editable' => TRUE,
        'hidden' => FALSE,
        'field_op_default' => 'next', // and defaults to the next available number
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

$conf_field_cxt_cd['add_validation'][] = $key_vd_modtype;
$conf_field_cxt_cd['edt_validation'][] = $key_vd_modtype;

// Set up the cxttype (Contexts)
$conf_field_cxttype =
    array(
        'field_id' => 'conf_field_cxttype',
        'dataclass' => 'modtype',
        'classtype' => 'cxttype',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_col',
                'alias_col' => 'dbname',
                'alias_src_key' => 'cxttype',
                'alias_type' => '1',
            ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => 'none',
        'edt_validation' => 'none'
);

// Itemkey for mod_pln (Plans)
$conf_field_pln_cd =
    array(
        'field_id' => 'conf_field_pln_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'pln_cd', //this is needed to correctly request the qtype
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'pln_cd',
                'alias_type' => '1',
            ),
        'module' => 'pln',
        'editable' => TRUE,
        'hidden' => FALSE,
        // 'field_op_default' => 'next', // and defaults to the next available number
        'add_validation' => $key_add_validation_loose,
        'edt_validation' => $key_edt_validation
);

// Itemkey for mod_sec (Sections)
$conf_field_sec_cd =
    array(
        'field_id' => 'conf_field_sec_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'sec_cd', //this is needed to correctly request the qtype
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'sec_cd',
                'alias_type' => '1',
            ),
        'module' => 'sec',
        'editable' => TRUE,
        'hidden' => FALSE,
        'field_op_default' => 'next', // and defaults to the next available number
        'add_validation' => $key_add_validation_loose,
        'edt_validation' => $key_edt_validation
);

// Itemkey for mod_rgf (Registered finds)
$conf_field_rgf_cd =
    array(
        'field_id' => 'conf_field_rgf_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'rgf_cd', //this is needed to correctly request the qtype
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'rgf_cd',
                'alias_type' => '1',
            ),
        'module' => 'rgf',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

$conf_field_rgf_cd['add_validation'][] = $key_vd_modtype;
$conf_field_rgf_cd['edt_validation'][] = $key_vd_modtype;

// Set up the rgftype (Registered finds)
$conf_field_rgftype =
    array(
        'field_id' => 'conf_field_rgftype',
        'dataclass' => 'modtype',
        'classtype' => 'rgftype',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_col',
                'alias_col' => 'dbname',
                'alias_src_key' => 'rgftype',
                'alias_type' => '1',
            ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => 'none',
        'edt_validation' => 'none'
);

// Itemkey for mod_smp (Samples)
$conf_field_smp_cd =
    array(
        'field_id' => 'conf_field_smp_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'smp_cd', //this is needed to correctly request the qtype
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'smp_cd',
                'alias_type' => '1',
            ),
        'module' => 'smp',
        'editable' => TRUE,
        'hidden' => FALSE,
        'field_op_default' => 'next', // and defaults to the next available number
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

// Itemkey for mod_sph (Site Photos)
$conf_field_sph_cd =
    array(
        'field_id' => 'conf_field_sph_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'sph_cd', //this is needed to correctly request the qtype
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'sph_cd',
                'alias_type' => '1',
            ),
        'module' => 'sph',
        'editable' => TRUE,
        'hidden' => FALSE,
        'field_op_default' => 'next',
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);
// -- XMI FIELDS -- //

// XMI for Site photos (SPH)
// link SPH -> CXT (used in mod_cxt SFs)
$conf_field_sphxmicxt = 
   array(
       'field_id' => 'conf_field_sphxmicxt',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'sph_cd',
               'alias_type' => '1',
            ),
       'module' => 'cxt',
       'xmi_mod' => 'sph',
       'force_var_itemkey' => 'sph_cd',
       'op_xmi_itemkey' => 'sph_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

// XMI for Samples (smp)
// link SMP -> CXT (used in mod_cxt SFs)
$conf_field_smpxmicxt = 
   array(
       'field_id' => 'conf_field_smpxmicxt',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
                  'alias_tbl' => 'cor_tbl_module',
                  'alias_col' => 'itemkey',
                  'alias_src_key' => 'smp_cd',
                  'alias_type' => '1',
            ),
       'module' => 'cxt',
       'xmi_mod' => 'smp',
       'force_var_itemkey' => 'smp_cd',
       'op_xmi_itemkey' => 'smp_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $chain_xmi_add_validation,
       'edt_validation' => $chain_xmi_edt_validation
);

// XMI for Registered finds (rgf)
// link RGF -> CXT (used in mod_cxt SFs)
$conf_field_rgfxmicxt = 
   array(
       'field_id' => 'conf_field_rgfxmicxt',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
                 'alias_tbl' => 'cor_tbl_module',
                 'alias_col' => 'itemkey',
                 'alias_src_key' => 'rgf_cd',
                 'alias_type' => '1',
             ),
       'module' => 'cxt',
       'xmi_mod' => 'rgf',
       'force_var_itemkey' => 'rgf_cd',
       'op_xmi_itemkey' => 'rgf_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

// XMI for Plans (pln)
// link PLN -> CXT (used in mod_cxt SFs)
$conf_field_plnxmicxt = 
   array(
       'field_id' => 'conf_field_plnxmicxt',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'pln_cd',
                'alias_type' => '1',
            ),
       'module' => 'cxt',
       'xmi_mod' => 'pln',
       'force_var_itemkey' => 'pln_cd',
       'op_xmi_itemkey' => 'pln_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

// XMI for Contexts (cxt)
// link CXT -> PLN (used in mod_pln SFs)
$conf_field_cxtxmipln = 
    array(
        'field_id' => 'conf_field_cxtxmipln',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'aliasinfo' =>
             array(
                 'alias_tbl' => 'cor_tbl_module',
                 'alias_col' => 'itemkey',
                 'alias_src_key' => 'cxt_cd',
                 'alias_type' => '1',
             ),
        'module' => 'pln',
        'xmi_mod' => 'cxt',
        'force_var_itemkey' => 'cxt_cd',
        'op_xmi_itemkey' => 'cxt_cd',            
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);
// link CXT -> SEC (used in mod_sec SFs)
$conf_field_cxtxmisec = 
    array(
        'field_id' => 'conf_field_cxtxmisec',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'aliasinfo' =>
             array(
                 'alias_tbl' => 'cor_tbl_module',
                 'alias_col' => 'itemkey',
                 'alias_src_key' => 'cxt_cd',
                 'alias_type' => '1',
             ),
        'module' => 'sec',
        'xmi_mod' => 'cxt',
        'force_var_itemkey' => 'cxt_cd',
        'op_xmi_itemkey' => 'cxt_cd',            
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);
// link SEC -> PLN (used in mod_sec SFs) showing which plan contains the section locn info
$conf_field_secxmipln = 
    array(
        'field_id' => 'conf_field_secxmipln',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'aliasinfo' =>
             array(
                 'alias_tbl' => 'cor_tbl_module',
                 'alias_col' => 'itemkey',
                 'alias_src_key' => 'pln_cd',
                 'alias_type' => '1',
        ),
        'module' => 'sec',
        'xmi_mod' => 'pln',
        'force_var_itemkey' => 'pln_cd',
        'op_xmi_itemkey' => 'pln_cd',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);

// XMI for Contexts (cxt)
// link CXT -> RGF (used in mod_rgf SFs)
$conf_field_cxtxmirgf = 
    array(
        'field_id' => 'conf_field_cxtxmirgf',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'aliasinfo' =>
             array(
                 'alias_tbl' => 'cor_tbl_module',
                 'alias_col' => 'itemkey',
                 'alias_src_key' => 'cxt_cd',
                 'alias_type' => '1',
             ),
        'module' => 'rgf',
        'xmi_mod' => 'cxt',
        'force_var_itemkey' => 'cxt_cd',
        'op_xmi_itemkey' => 'cxt_cd',            
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);

// XMI for Contexts (cxt)
// link CXT -> SMP (used in mod_smp SFs)
$conf_field_cxtxmismp =
    array(
        'field_id' => 'conf_field_cxtxmismp',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'aliasinfo' =>
             array(
                 'alias_tbl' => 'cor_tbl_module',
                 'alias_col' => 'itemkey',
                 'alias_src_key' => 'cxt_cd',
                 'alias_type' => '1',
             ),
        'module' => 'smp',
        'xmi_mod' => 'cxt',
        'force_var_itemkey' => 'cxt_cd',
        'op_xmi_itemkey' => 'cxt_cd',            
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);

// XMI for Contexts (cxt)
// link CXT -> SPH (used in mod_sph SFs)
$conf_field_cxtxmisph = 
    array(
        'field_id' => 'conf_field_cxtxmisph',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'aliasinfo' =>
             array(
                 'alias_tbl' => 'cor_tbl_module',
                 'alias_col' => 'itemkey',
                 'alias_src_key' => 'cxt_cd',
                 'alias_type' => '1',
             ),
        'module' => 'sph',
        'xmi_mod' => 'cxt',
        'force_var_itemkey' => 'cxt_cd',
        'op_xmi_itemkey' => 'cxt_cd',
        'op_pattern' => 'pattern = "[0-9 ]*" type="number"',  
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);

// XMI for Contexts (cxt)
// link CXT -> SPH (used in mod_sph SFs)
$conf_field_cxtxmisgr = 
    array(
        'field_id' => 'conf_field_cxtxmisgr',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'aliasinfo' =>
             array(
                 'alias_tbl' => 'cor_tbl_module',
                 'alias_col' => 'itemkey',
                 'alias_src_key' => 'cxt_cd',
                 'alias_type' => '1',
             ),
        'module' => 'sgr',
        'xmi_mod' => 'cxt',
        'force_var_itemkey' => 'cxt_cd',
        'op_xmi_itemkey' => 'cxt_cd',        
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);
// -- TEXT FIELDS -- //

// TXT fields for address book module

$conf_field_name =
    array(
        'field_id' => 'conf_field_name',
        'dataclass' => 'txt',
        'classtype' => 'name',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_initials =
    array(
        'field_id' => 'conf_field_initials',
        'dataclass' => 'txt',
        'classtype' => 'initials',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

// TXT fields for the context module

$conf_field_desc =
    array(
        'field_id' => 'conf_field_desc',
        'dataclass' => 'txt',
        'classtype' => 'desc',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_interp =
    array(
        'field_id' => 'conf_field_interp',
        'dataclass' => 'txt',
        'classtype' => 'interp',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_sgrnarrative =
    array(
        'field_id' => 'conf_field_sgrnarrative',
        'dataclass' => 'txt',
        'classtype' => 'sgrnarrative',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_datingnarrative =
    array(
        'field_id' => 'conf_field_datingnarrative',
        'dataclass' => 'txt',
        'classtype' => 'datingnarrative',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_short_desc =
    array(
        'field_id' => 'conf_field_short_desc',
        'dataclass' => 'txt',
        'classtype' => 'short_desc',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

// TXT fields needed for context type fill

$conf_field_compac =
    array(
        'field_id' => 'conf_field_compac',
        'dataclass' => 'txt',
        'classtype' => 'compac',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_colour =
    array(
        'field_id' => 'conf_field_colour',
        'dataclass' => 'txt',
        'classtype' => 'colour',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_compo =
    array(
        'field_id' => 'conf_field_compo',
        'dataclass' => 'txt',
        'classtype' => 'compo',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_inclusions =
    array(
        'field_id' => 'conf_field_inclusions',
        'dataclass' => 'txt',
        'classtype' => 'inclusions',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_dims =
    array(
        'field_id' => 'conf_field_dims',
        'dataclass' => 'txt',
        'classtype' => 'dims',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_observ =
    array(
        'field_id' => 'conf_field_observ',
        'dataclass' => 'txt',
        'classtype' => 'observ',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_excavtech =
    array(
        'field_id' => 'conf_field_excavtech',
        'dataclass' => 'txt',
        'classtype' => 'excavtech',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

// TXT fields needed for context type cut

$conf_field_shape =
    array(
        'field_id' => 'conf_field_shape',
        'dataclass' => 'txt',
        'classtype' => 'shape',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_corners =
    array(
        'field_id' => 'conf_field_corners',
        'dataclass' => 'txt',
        'classtype' => 'corners',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_bostop =
    array(
        'field_id' => 'conf_field_bostop',
        'dataclass' => 'txt',
        'classtype' => 'bostop',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_sides =
    array(
        'field_id' => 'conf_field_sides',
        'dataclass' => 'txt',
        'classtype' => 'sides',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_bosbase =
    array(
        'field_id' => 'conf_field_bosbase',
        'dataclass' => 'txt',
        'classtype' => 'bosbase',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_base =
    array(
        'field_id' => 'conf_field_base',
        'dataclass' => 'txt',
        'classtype' => 'base',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_orient =
    array(
        'field_id' => 'conf_field_orient',
        'dataclass' => 'txt',
        'classtype' => 'orient',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_inclination =
    array(
        'field_id' => 'conf_field_inclination',
        'dataclass' => 'txt',
        'classtype' => 'inclination',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_truncation =
    array(
        'field_id' => 'conf_field_truncation',
        'dataclass' => 'txt',
        'classtype' => 'truncation',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

// TXT fields needed for context type masonry

$conf_field_material =
    array(
        'field_id' => 'conf_field_material',
        'dataclass' => 'txt',
        'classtype' => 'material',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_sizemat =
    array(
        'field_id' => 'conf_field_sizemat',
        'dataclass' => 'txt',
        'classtype' => 'sizemat',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_finish =
    array(
        'field_id' => 'conf_field_finish',
        'dataclass' => 'txt',
        'classtype' => 'finish',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_bond =
    array(
        'field_id' => 'conf_field_bond',
        'dataclass' => 'txt',
        'classtype' => 'bond',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_form =
    array(
        'field_id' => 'conf_field_form',
        'dataclass' => 'txt',
        'classtype' => 'form',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_dirface =
    array(
        'field_id' => 'conf_field_dirface',
        'dataclass' => 'txt',
        'classtype' => 'dirface',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_bondmat =
    array(
        'field_id' => 'conf_field_bondmat',
        'dataclass' => 'txt',
        'classtype' => 'bondmat',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_definition =
    array(
        'field_id' => 'conf_field_definition',
        'dataclass' => 'txt',
        'classtype' => 'definition',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

// TXT fields for context type skeleton

$conf_field_abody =
    array(
        'field_id' => 'conf_field_abody',
        'dataclass' => 'txt',
        'classtype' => 'abody',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_ahead =
    array(
        'field_id' => 'conf_field_ahead',
        'dataclass' => 'txt',
        'classtype' => 'ahead',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_ararm =
    array(
        'field_id' => 'conf_field_ararm',
        'dataclass' => 'txt',
        'classtype' => 'ararm',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_alarm =
    array(
        'field_id' => 'conf_field_alarm',
        'dataclass' => 'txt',
        'classtype' => 'alarm',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_arleg =
    array(
        'field_id' => 'conf_field_arleg',
        'dataclass' => 'txt',
        'classtype' => 'arleg',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_alleg =
    array(
        'field_id' => 'conf_field_alleg',
        'dataclass' => 'txt',
        'classtype' => 'alleg',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_afeet =
    array(
        'field_id' => 'conf_field_afeet',
        'dataclass' => 'txt',
        'classtype' => 'afeet',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_degen =
    array(
        'field_id' => 'conf_field_degen',
        'dataclass' => 'txt',
        'classtype' => 'degen',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_state =
    array(
        'field_id' => 'conf_field_state',
        'dataclass' => 'txt',
        'classtype' => 'state',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

// TXT fields for context type timber

$conf_field_type =
    array(
        'field_id' => 'conf_field_type',
        'dataclass' => 'txt',
        'classtype' => 'type',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_setting =
    array(
        'field_id' => 'conf_field_setting',
        'dataclass' => 'txt',
        'classtype' => 'setting',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_cross =
    array(
        'field_id' => 'conf_field_cross',
        'dataclass' => 'txt',
        'classtype' => 'cross',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_cond =
    array(
        'field_id' => 'conf_field_cond',
        'dataclass' => 'txt',
        'classtype' => 'cond',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_conv =
    array(
        'field_id' => 'conf_field_conv',
        'dataclass' => 'txt',
        'classtype' => 'conv',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_tmarks =
    array(
        'field_id' => 'conf_field_tmarks',
        'dataclass' => 'txt',
        'classtype' => 'tmarks',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_jfit =
    array(
        'field_id' => 'conf_field_jfit',
        'dataclass' => 'txt',
        'classtype' => 'jfit',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_imarks =
    array(
        'field_id' => 'conf_field_imarks',
        'dataclass' => 'txt',
        'classtype' => 'imarks',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_streat =
    array(
        'field_id' => 'conf_field_streat',
        'dataclass' => 'txt',
        'classtype' => 'streat',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_reusetxt =
    array(
        'field_id' => 'conf_field_reusetxt',
        'dataclass' => 'txt',
        'classtype' => 'reusetxt',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

// TXT fields for registered finds module (rgf)

$conf_field_xrayid =
    array(
        'field_id' => 'conf_field_xrayid',
        'dataclass' => 'txt',
        'classtype' => 'xrayid',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_rgfcomment =
    array(
        'field_id' => 'conf_field_rgfcomment',
        'dataclass' => 'txt',
        'classtype' => 'objectcomments',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

// TXT fields for samples module (smp)

$conf_field_samplequestions =
    array(
        'field_id' => 'conf_field_samplequestions',
        'dataclass' => 'txt',
        'classtype' => 'smpques',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_statusnotes =
    array(
        'field_id' => 'conf_field_statusnotes',
        'dataclass' => 'txt',
        'classtype' => 'statusnotes',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_position =
    array(
        'field_id' => 'conf_field_position',
        'dataclass' => 'txt',
        'classtype' => 'smpposition',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_typenotes =
    array(
        'field_id' => 'conf_field_typenotes',
        'dataclass' => 'txt',
        'classtype' => 'typenotes',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_seclevel =
    array(
        'field_id' => 'conf_field_seclevel',
        'dataclass' => 'txt',
        'classtype' => 'seclevel',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_othercomments =
    array(
        'field_id' => 'conf_field_othercomments',
        'dataclass' => 'txt',
        'classtype' => 'othercomments',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

// -- ATTRIBUTE FIELDS -- //

// BOOLEAN ATTRIBUTE fields for context type timber

$conf_field_tmbrxsec =
    array(
        'field_id' => 'conf_field_tmbrxsec',
        'dataclass' => 'attribute',
        'classtype' => 'tmbrxsec',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_reuseattr =
    array(
        'field_id' => 'conf_field_reuseattr',
        'dataclass' => 'attribute',
        'classtype' => 'reuseattr',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'op_display_mode'=> 'radio',
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

// OTHER ATTRIBUTE fields


// Locn, TP Gr. Sq. etc.
$conf_field_locn =
    array(
        'field_id' => 'conf_field_locn',
        'dataclass' => 'attribute',
        'classtype' => 'toponymattr',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_facing =
    array(
        'field_id' => 'conf_field_facing',
        'dataclass' => 'attribute',
        'classtype' => 'facing',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_scalebar =
    array(
        'field_id' => 'conf_field_scalebar',
        'dataclass' => 'attribute',
        'classtype' => 'scalebar',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_scale =
    array(
        'field_id' => 'conf_field_scale',
        'dataclass' => 'attribute',
        'classtype' => 'scale',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

// Provisional period
$conf_field_provperiod =
    array(
        'field_id' => 'conf_field_provperiod',
        'dataclass' => 'attribute',
        'classtype' => 'provperiod',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

// Boolean ATTRIBUTE fields

// Record complete flag
$conf_field_reccomplete =
    array(
        'field_id' => 'conf_field_reccomplete',
        'dataclass' => 'attribute',
        'classtype' => 'recflag',
        'attribute' => 'reccomplete',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_lut_attribute',
                'alias_col' => 'attribute',
                'alias_src_key' => 'reccomplete',
                'alias_type' => '1',
        ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'op_show_bv_aliases' => TRUE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_recflag =
    array(
        'field_id' => 'conf_field_recflag',
        'dataclass' => 'attribute',
        'classtype' => 'recflag',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_lut_attributetype',
                'alias_col' => 'attributetype',
                'alias_src_key' => 'recflag',
                'alias_type' => '1',
        ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_cxt_schm =
    array(
                'field_id' => 'conf_field_cxt_schm',
                'id' => 'conf_field_cxt_schm',
                'dataclass' => 'geom',
                'module' => 'cxt',
                'format' => 'geojson',
                'layeruri' => 'data/mapping/cxt_schm.geojson',
                'projection' => 'epsg:900913',
                'name' => 'cxt_schm',
                'op_serverType'=> 'localfile',
                'op_zoomtolayer' => TRUE,
                'selectable' => TRUE,
    );
$conf_field_cxt_schm_geos =
    array(
                'field_id' => 'conf_field_cxt_schm_geos',
                'id' => 'conf_field_cxt_schm_geos',
                'dataclass' => 'geom',
                'module' => 'cxt',
                'format' => 'wfs',
                'layeruri' => 'http://lpmapserver.dyndns.org:8080/geoserver/Minories/wfs',
                //'layeruri' => 'http://100minories.lparchaeology.com/lpmapserver/Minories/wfs',
                'projection' => 'epsg:900913',
                'name' => 'MNO12_context_mpg',
                'remotename' => 'MNO12_context_mpg',
                'serverType'=> 'geoserver',
                //'serverType'=> 'other',
                'op_layer' => 'MNO12_context_mpg',
                'op_zoomtolayer' => TRUE,
                'op_buffer' => 0.5,
                'hidden' => TRUE,
                'selectable' => TRUE,
    );
$conf_field_rgf_schm =
    array(
                'field_id' => 'conf_field_rgf_schm',
                'id' => 'conf_field_rgf_schm',
                'dataclass' => 'geom',
                'module' => 'rgf',
                'format' => 'geojson',
                'layeruri' => 'data/mapping/MDFinds900913.geojson',
                'projection' => 'epsg:900913',
                'name' => 'Finds',
                'op_serverType'=> 'localfile',
                'op_zoomtolayer' => TRUE,
                'op_buffer' =>20,
                'selectable' => TRUE
    );
// Find types for context module
$conf_field_findtype =
    array(
        'field_id' => 'conf_field_findtype',
        'dataclass' => 'attribute',
        'classtype' => 'findtype',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

// Basic interpretation for context module
$conf_field_cxtbasicinterp =
    array(
        'field_id' => 'conf_field_cxtbasicinterp',
        'dataclass' => 'attribute',
        'classtype' => 'cxtbasicinterp',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

// ATTRIBUTE fields for registered finds (rgf)

// Basic interp
$conf_field_rgfbasicinterp =
    array(
        'field_id' => 'conf_field_rgfbasicinterp',
        'dataclass' => 'attribute',
        'classtype' => 'objectmaterial',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_rgfmaterial =
    array(
        'field_id' => 'conf_field_rgfmaterial',
        'dataclass' => 'attribute',
        'classtype' => 'objectinterptype',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_rgfperiod =
    array(
        'field_id' => 'conf_field_rgfperiod',
        'dataclass' => 'attribute',
        'classtype' => 'objectperiod',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_rgfcompleteness =
    array(
        'field_id' => 'conf_field_rgfcompleteness',
        'dataclass' => 'attribute',
        'classtype' => 'objectcompleteness',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_rgfdisplay =
    array(
        'field_id' => 'conf_field_rgfdisplay',
        'dataclass' => 'attribute',
        'classtype' => 'objectdisplay',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

// ATTRIBUTE fields for samples (smp)

$conf_field_samplecondition =
    array(
        'field_id' => 'conf_field_samplecondition',
        'dataclass' => 'attribute',
        'classtype' => 'samplecondition',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_samplestatus =
    array(
        'field_id' => 'conf_field_samplestatus',
        'dataclass' => 'attribute',
        'classtype' => 'samplestatus',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_sampletype =
    array(
        'field_id' => 'conf_field_sampletype',
        'dataclass' => 'attribute',
        'classtype' => 'sampletype',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_priority =
    array(
        'field_id' => 'conf_field_priority',
        'dataclass' => 'attribute',
        'classtype' => 'priority',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_hf_status =
    array(
        'field_id' => 'conf_field_hf_status',
        'dataclass' => 'attribute',
        'classtype' => 'hfstatus',
        'aliasinfo' => FALSE,
        'op_display_mode' => 'radio', // Optional display as radio buttons
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_lf_status =
    array(
        'field_id' => 'conf_field_lf_status',
        'dataclass' => 'attribute',
        'classtype' => 'lfstatus',
        'aliasinfo' => FALSE,
        'op_display_mode' => 'radio', // Optional display as radio buttons
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_flotrec =
    array(
        'field_id' => 'conf_field_flotrec',
        'dataclass' => 'attribute',
        'classtype' => 'smpflag',
        'attribute' => 'lghfrac_rec',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_lut_attribute',
                'alias_col' => 'attribute',
                'alias_src_key' => 'lghfrac_rec',
                'alias_type' => '1',
        ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'op_show_bv_aliases' => TRUE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_hfass =
    array(
        'field_id' => 'conf_field_hfass',
        'dataclass' => 'attribute',
        'classtype' => 'smpflag',
        'attribute' => 'hfass',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_lut_attribute',
                'alias_col' => 'attribute',
                'alias_src_key' => 'hfass',
                'alias_type' => '1',
        ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'op_show_bv_aliases' => TRUE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_hfextrac =
    array(
        'field_id' => 'conf_field_hfextrac',
        'dataclass' => 'attribute',
        'classtype' => 'hfextrac',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'op_display_mode' => 'checkbox', // Optional display as checkboxes
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_lflocn =
    array(
        'field_id' => 'conf_field_lflocn',
        'dataclass' => 'attribute',
        'classtype' => 'lflocn',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_contamination =
    array(
        'field_id' => 'conf_field_contamination',
        'dataclass' => 'attribute',
        'classtype' => 'contamination',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_samplesize =
    array(
        'field_id' => 'conf_field_samplesize',
        'dataclass' => 'attribute',
        'classtype' => 'samplesize',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_subsamples =
    array(
        'field_id' => 'conf_field_subsamples',
        'dataclass' => 'attribute',
        'classtype' => 'subsamples',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);



// -- NUMBER FIELDS -- //

// NUMBER fields for samples (smp)

$conf_field_volume =
    array(
        'field_id' => 'conf_field_volume',
        'dataclass' => 'number',
        'classtype' => 'volume',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_hf_numofbags =
    array(
        'field_id' => 'conf_field_hf_bags',
        'dataclass' => 'number',
        'classtype' => 'hf_numofbags',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_lf_numofbags =
    array(
        'field_id' => 'conf_field_lf_bags',
        'dataclass' => 'number',
        'classtype' => 'lf_numofbags',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_weight =
array(
                'field_id' => 'conf_field_weight',
                'dataclass' => 'number',
                'classtype' => 'weight',
                'aliasinfo' => FALSE,
                'editable' => TRUE,
                'hidden' => FALSE,
                'add_validation' => $chain_number_add_validation,
                'edt_validation' => $chain_number_edt_validation
);

$conf_field_count =
array(
                'field_id' => 'conf_field_count',
                'dataclass' => 'number',
                'classtype' => 'count',
                'aliasinfo' => FALSE,
                'editable' => TRUE,
                'hidden' => FALSE,
                'add_validation' => $chain_number_add_validation,
                'edt_validation' => $chain_number_edt_validation
);
// -- SPAN FIELDS -- //

$conf_field_sameas =
   array(
       'field_id' => 'conf_field_sameas',
       'dataclass' => 'span',
       'classtype' => 'sameas',
       'aliasinfo' => FALSE,
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $span_add_validation,
       'edt_validation' => $span_edt_validation
);

// -- ACTION AND DATE FIELDS -- //

// Issued
$conf_field_issuedto = 
    array(
        'field_id' => 'conf_field_issuedto',
        'dataclass' => 'action',
        'classtype' => 'issuedto',
        'aliasinfo' => FALSE,
        'actors_mod' => 'abk',
        'actors_type' => 'people',
        'actors_element' => 'name',
        'actors_style' => 'single',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        //'field_op_default' => 'user', // keyword 'user' defaults it to the current logged in user
        //'field_op_default' => 'MNO12_3', // specify the ABK item
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_issuedon =
    array(
        'field_id' => 'conf_field_issuedon',
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'issuedon',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'field_op_default' => 'now',
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);

// Drawn
$conf_field_drawnby = 
    array(
        'field_id' => 'conf_field_drawnby',
        'dataclass' => 'action',
        'classtype' => 'drawnby',
        'aliasinfo' => FALSE,
        'actors_mod' => 'abk',
        'actors_type' => 'people',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_drawnon =
    array(
        'field_id' => 'conf_field_drawnon',
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'drawnon',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);

// Taken
$conf_field_takenby = 
    array(
        'field_id' => 'conf_field_takenby',
        'dataclass' => 'action',
        'classtype' => 'takenby',
        'aliasinfo' => FALSE,
        'actors_mod' => 'abk',
        'actors_type' => 'people',
        'actors_element' => 'name',
        'actors_style' => 'single',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_takenon =
    array(
        'field_id' => 'conf_field_takenon',
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'takenon',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'field_op_default' => 'now',
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);

// Compiled
$conf_field_compiledby = 
    array(
        'field_id' => 'conf_field_compiledby',
        'dataclass' => 'action',
        'classtype' => 'compiledby',
        'aliasinfo' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_compiledon =
    array(
        'field_id' => 'conf_field_compiledon',
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'compiledon',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);

// Checked
$conf_field_checkedby = 
    array(
        'field_id' => 'conf_field_checkedby',
        'dataclass' => 'action',
        'classtype' => 'checkedby',
        'aliasinfo' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

// Interpreted
$conf_field_interpretedby = 
    array(
        'field_id' => 'conf_field_interpretedby',
        'dataclass' => 'action',
        'classtype' => 'interpretedby',
        'aliasinfo' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $custom_action_add_vd,
        'edt_validation' => $custom_action_edt_vd
);

$conf_field_interpretedon =
    array(
        'field_id' => 'conf_field_interpretedon',
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'interpretedon',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $custom_date_add_vd,
        'edt_validation' => $custom_date_edt_vd
);

// Strat Narrative
$conf_field_sgrnarrativeby = 
    array(
        'field_id' => 'conf_field_sgrnarrativeby',
        'dataclass' => 'action',
        'classtype' => 'sgrnarrativeby',
        'aliasinfo' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $custom_action_add_vd,
        'edt_validation' => $custom_action_edt_vd
);

$conf_field_sgrnarrativeon =
    array(
        'field_id' => 'conf_field_sgrnarrativeon',
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'sgrnarrativeon',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $custom_date_add_vd,
        'edt_validation' => $custom_date_edt_vd
);

// Dating Narrative
$conf_field_datingnarrativeby = 
    array(
        'field_id' => 'conf_field_datingnarrativeby',
        'dataclass' => 'action',
        'classtype' => 'datingnarrativeby',
        'aliasinfo' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $custom_action_add_vd,
        'edt_validation' => $custom_action_edt_vd
);

$conf_field_datingnarrativeon =
    array(
        'field_id' => 'conf_field_datingnarrativeon',
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'datingnarrativeon',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $custom_date_add_vd,
        'edt_validation' => $custom_date_edt_vd
);

/** EVENT FIELDS 
* Event fields are effectively wrappers for action/date fields.  All fields
* must be set up above.
*
* One can also use actions and dates without having the event wrapper, but this
* allows one to group multiple events into a single subform.
*/

$conf_event_compiled = 
    array(
        'type' => 'compiled',
        'date' => $conf_field_compiledon,
        'action' => $conf_field_compiledby
);

$conf_event_taken = 
    array(
        'type' => 'taken',
        'date' => $conf_field_takenon,
        'action' => $conf_field_takenby
);

$conf_event_drawn = 
    array(
        'type' => 'drawn',
        'date' => $conf_field_drawnon,
        'action' => $conf_field_drawnby
);

$conf_event_checked = 
    array(
        'type' => 'checked',
        'date' => $conf_field_checkedby,
        'action' => FALSE
);

$conf_event_issued = 
    array(
        'type' => 'issued',
        'date' => $conf_field_issuedon,
        'action' => $conf_field_issuedto
);

// -- FILE FIELDS -- //

$conf_field_file =
  array(
      'dataclass' => 'file',
      'classtype' => 'images',
      'aliasinfo' => FALSE,
      'editable' => TRUE,
      'hidden' => FALSE,
      'add_validation' => $file_add_validation,
      'edt_validation' => $file_edt_validation
);

// -- OPTIONAL FIELDS -- //

/** OPTIONAL FIELDS
* Optional fields are used in registers and viewing modes
* in the results view to navigate between views.
*/

$conf_reg_op =
    array(
    	'field_id' => 'conf_reg_op',
        'dataclass' => 'op',
        'classtype' => 'none',
        'options' => 'view,enter,qed',
        'editable' => FALSE,
        'hidden' => FALSE
);
$conf_reg_op_no_qed = 
    array(
        'dataclass' => 'op',
        'classtype' => 'none',
        'options' => 'view,enter',
        'editable' => FALSE,
        'hidden' => FALSE
);
$conf_reg_op_view = 
    array(
        'dataclass' => 'op',
        'classtype' => 'none',
        'options' => 'view',
        'editable' => FALSE,
        'hidden' => FALSE
); 
$conf_reg_op_no_enter = 
    array(
        'dataclass' => 'op',
        'classtype' => 'none',
        'options' => 'view,qed',
        'editable' => FALSE,
        'hidden' => FALSE
);


/** DELETE FIELD
*
* For the delete frag routine, the following validation vars are required
* DO NOT PUT THIS INTO A SUBFORM
*
*/

$conf_field_delete = 
    array(
        'dataclass' => 'delete',
        'classtype' => 'delete',
        'editable' => TRUE,
        'hidden' => TRUE,
        'del_validation' => $del_validation
);

?>