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
*
*
* These arrays contains the info about each field
* Make one array for each field to display each field MUST have the following vars:
*
* dataclass = the data type contained in this field (see wiki for a list of classes)
* classtype = the type within the class eg txttype or datetype
* alias_tbl = the table for the getAlias call
* alias_col = the col for the getAlias call
* alias_src_key = the alias_src_key for the getAlias call
* alias_type = the alias_type for the getAlias call
* editable = set TRUE to process this field in forms set FALSE for display only
* hidden = set true to make the field <input type="hidden" />
* add_validation = validation rules for this field when on an add routine
* edt_validation = validation rules for this field when on an edt routine
*
* The following class specific vars should be used:
* class='action' - actors_type = the actor type to include in the dd
* class='action' - actors_dd = the element of the actors to show in the dd
* class='action' - actors_tbl = the table in which the actors are held
* class='action' - actors_style = whether actor information is displayed in a
* list style ('list') or as a single actor/date pairing ('single') 
*
*/

// VALIDATION
include('vd_settings.php');

/**
* ITEM KEY FIELDS
*
* Before v1.1 many of these fields were in their respective module settings
* files.
*
*/

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
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation,
    );

    $conf_field_cxt_cd =
        array(
        'field_id' => 'conf_field_cxt_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'cxt_cd',
        'module' => 'cxt',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'cxt_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation,
    );

    $conf_field_sgr_cd =
        array(
        'field_id' => 'conf_field_sgr_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'sgr_cd',
        'module' => 'sgr',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'sgr_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation,
    );

    $conf_field_grp_cd =
        array(
        'field_id' => 'conf_field_grp_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'grp_cd',
        'module' => 'grp',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'grp_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation,
    );

    $conf_field_pln_cd =
        array(
        'field_id' => 'conf_field_pln_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'pln_cd',
        'module' => 'pln',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'pln_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation,
    );

    $conf_field_sec_cd =
        array(
        'field_id' => 'conf_field_sec_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'sec_cd',
        'module' => 'sec',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'sec_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation,
    );

    $conf_field_sph_cd =
        array(
        'field_id' => 'conf_field_sph_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'sph_cd',
        'module' => 'sph',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'sph_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation,
    );

    $conf_field_smp_cd =
        array(
        'field_id' => 'conf_field_smp_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'smp_cd',
        'module' => 'smp',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'smp_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation,
    );

    $conf_field_rgf_cd =
        array(
        'field_id' => 'conf_field_rgf_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'rgf_cd',
        'module' => 'rgf',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'rgf_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation,
        );
    
    // This is field is used for changing the itemvalue
    $conf_field_abk_itemval =
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
                    'hidden' => FALSE, // this makes the itemkey hidden in the register
                    'add_validation' => $key_add_validation,
                    'edt_validation' => $key_edt_validation
    );
    
    $conf_field_abktype =
        array(
        'field_id' => 'conf_field_abktype',
        'dataclass' => 'modtype',
        'classtype' => 'abktype',
        'module' => 'abk',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_col',
                    'alias_col' => 'dbname',
                    'alias_src_key' => 'abktype',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => 'none',
        'edt_validation' => 'none',
    );

    $conf_field_abk_cd['add_validation'][] = $key_vd_modtype;
    $conf_field_abk_cd['edt_validation'][] = $key_vd_modtype;

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
        'edt_validation' => 'none',
    );

    $conf_field_cxt_cd['add_validation'][] = $key_vd_modtype;
    $conf_field_cxt_cd['edt_validation'][] = $key_vd_modtype;

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
        'edt_validation' => 'none',
    );

    $conf_field_rgf_cd['add_validation'][] = $key_vd_modtype;
    $conf_field_rgf_cd['edt_validation'][] = $key_vd_modtype;

/**
* TEXT FIELDS
*
*/

    $conf_field_abody =
        array(
        'field_id' => 'conf_field_abody',
        'dataclass' => 'txt',
        'classtype' => 'abody',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'abody',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_afeet =
        array(
        'field_id' => 'conf_field_afeet',
        'dataclass' => 'txt',
        'classtype' => 'afeet',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'afeet',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_ahead =
        array(
        'field_id' => 'conf_field_ahead',
        'dataclass' => 'txt',
        'classtype' => 'ahead',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'ahead',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_alarm =
        array(
        'field_id' => 'conf_field_alarm',
        'dataclass' => 'txt',
        'classtype' => 'alarm',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'alarm',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_alleg =
        array(
        'field_id' => 'conf_field_alleg',
        'dataclass' => 'txt',
        'classtype' => 'alleg',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'alleg',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_ararm =
        array(
        'field_id' => 'conf_field_ararm',
        'dataclass' => 'txt',
        'classtype' => 'ararm',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'ararm',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_arleg =
        array(
        'field_id' => 'conf_field_arleg',
        'dataclass' => 'txt',
        'classtype' => 'arleg',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'arleg',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_base =
        array(
            'field_id' => 'conf_field_base',            
            'dataclass' => 'txt',
            'classtype' => 'base',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'base',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'bond',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_bondmat =
        array(
        'field_id' => 'conf_field_bondmat',
        'dataclass' => 'txt',
        'classtype' => 'bondmat',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'bondmat',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_bosbase =
        array(
            'field_id' => 'conf_field_bosbase',            
            'dataclass' => 'txt',
            'classtype' => 'bosbase',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'bosbase',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'bostop',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'colour',
                    'alias_type' => '1',
            ),
            'editable' => TRUE,
            'hidden' => FALSE,
            'add_validation' => $txt_add_validation,
            'edt_validation' => $txt_edt_validation
    );

    $conf_field_compac =
        array(
            'field_id' => 'conf_field_compac',            
            'dataclass' => 'txt',
            'classtype' => 'compac',
        'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'compac',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'compo',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'corners',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'datingnarrative',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'degen',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_dims =
        array(
            'field_id' => 'conf_field_dims',            
            'dataclass' => 'txt',
            'classtype' => 'dims',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'dims',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'dirface',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_excavtech =
        array(
            'field_id' => 'conf_field_excavtech',            
            'dataclass' => 'txt',
            'classtype' => 'excavtech',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'excavtech',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'finish',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_form =
        array(
        'field_id' => 'conf_field_form',
        'dataclass' => 'txt',
        'classtype' => 'form',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'form',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_grpdatingnarrative =
        array(
            'field_id' => 'conf_field_grpdatingnarrative',            
            'dataclass' => 'txt',
            'classtype' => 'grpdatingnarrative',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'grpdatingnarrative',
                    'alias_type' => '1',
            ),
            'editable' => TRUE,
            'hidden' => FALSE,
            'add_validation' => $txt_add_validation,
            'edt_validation' => $txt_edt_validation
    );

    $conf_field_grpnarrative =
        array(
            'field_id' => 'conf_field_grpnarrative',            
            'dataclass' => 'txt',
            'classtype' => 'grpnarrative',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'grpnarrative',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'inclination',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_inclusions =
        array(
            'field_id' => 'conf_field_inclusions',            
            'dataclass' => 'txt',
            'classtype' => 'inclusions',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'inclusions',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'initials',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'interp',
                    'alias_type' => '1',
            ),
            'editable' => TRUE,
            'hidden' => FALSE,
            'add_validation' => $txt_add_validation,
            'edt_validation' => $txt_edt_validation
    );

    $conf_field_material =
        array(
        'field_id' => 'conf_field_material',
        'dataclass' => 'txt',
        'classtype' => 'material',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'material',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_name =
        array(
            'field_id' => 'conf_field_name',            
            'dataclass' => 'txt',
            'classtype' => 'name',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'name',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'observ',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'orient',
                    'alias_type' => '1',
            ),
            'editable' => TRUE,
            'hidden' => FALSE,
            'add_validation' => $txt_add_validation,
            'edt_validation' => $txt_edt_validation
    );

    $conf_field_plncxt =
        array(
        'field_id' => 'conf_field_plncxt',
        'dataclass' => 'txt',
        'classtype' => 'plancxt',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'plancxt',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_sgrnarrative =
        array(
            'field_id' => 'conf_field_sgrnarrative',            
            'dataclass' => 'txt',
            'classtype' => 'sgrnarrative',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'sgrnarrative',
                    'alias_type' => '1',
            ),
            'editable' => TRUE,
            'hidden' => FALSE,
            'add_validation' => $txt_add_validation,
            'edt_validation' => $txt_edt_validation
    );

    $conf_field_shape =
        array(
            'field_id' => 'conf_field_shape',            
            'dataclass' => 'txt',
            'classtype' => 'shape',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'shape',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'short_desc',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'sides',
                    'alias_type' => '1',
            ),
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
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'sizemat',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_state =
        array(
        'field_id' => 'conf_field_state',
        'dataclass' => 'txt',
        'classtype' => 'state',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'state',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_statusnotes =
        array(
        'field_id' => 'conf_field_statusnotes',
        'dataclass' => 'txt',
        'classtype' => 'statusnotes',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'statusnotes',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_truncation =
        array(
        'field_id' => 'conf_field_truncation',
        'dataclass' => 'txt',
        'classtype' => 'truncation',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'truncation',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_typenotes =
        array(
        'field_id' => 'conf_field_typenotes',
        'dataclass' => 'txt',
        'classtype' => 'typenotes',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'typenotes',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_xrayid =
        array(
        'field_id' => 'conf_field_xrayid',
        'dataclass' => 'txt',
        'classtype' => 'xrayid',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'xrayid',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

/**
* ATTRIBUTE FIELDS
*
*/
    $conf_field_basicinterp =
        array(
        'field_id' => 'conf_field_basicinterp',
        'dataclass' => 'attribute',
        'classtype' => 'basicinterp',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'basicinterp',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'op_display_mode' => 'radio',
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_contamination =
        array(
        'field_id' => 'conf_field_contamination',
        'dataclass' => 'attribute',
        'classtype' => 'contamination',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'contamination',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_cxtbasicinterp =
        array(
        'field_id' => 'conf_field_cxtbasicinterp',
        'dataclass' => 'attribute',
        'classtype' => 'cxtbasicinterp',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'cxtbasicinterp',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_findtype =
        array(
        'field_id' => 'conf_field_findtype',
        'dataclass' => 'attribute',
        'classtype' => 'findtype',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'findtype',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'field_op_hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
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
        'field_op_hidden' => FALSE,
        'op_show_bv_aliases' => '1',
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_grpphase =
        array(
        'field_id' => 'conf_field_grpphase',
        'dataclass' => 'attribute',
        'classtype' => 'grpphase',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'grpphase',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_hfextrac =
        array(
        'field_id' => 'conf_field_hfextrac',
        'dataclass' => 'attribute',
        'classtype' => 'hfextrac',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'hfextrac',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'op_display_mode' => 'checkbox',
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
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
        'field_op_hidden' => FALSE,
        'op_show_bv_aliases' => '1',
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
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
        'field_op_hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_hf_status =
        array(
        'field_id' => 'conf_field_hf_status',
        'dataclass' => 'attribute',
        'classtype' => 'hfstatus',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'hfstatus',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'op_display_mode' => 'radio',
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_lflocn =
        array(
        'field_id' => 'conf_field_lflocn',
        'dataclass' => 'attribute',
        'classtype' => 'lflocn',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'lflocn',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_lf_status =
        array(
        'field_id' => 'conf_field_lf_status',
        'dataclass' => 'attribute',
        'classtype' => 'lfstatus',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'lfstatus',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'op_display_mode' => 'radio',
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_priority =
        array(
        'field_id' => 'conf_field_priority',
        'dataclass' => 'attribute',
        'classtype' => 'priority',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'priority',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_process =
        array(
        'field_id' => 'conf_field_process',
        'dataclass' => 'attribute',
        'classtype' => 'process',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'process',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_provperiod =
        array(
        'field_id' => 'conf_field_provperiod',
        'dataclass' => 'attribute',
        'classtype' => 'provperiod',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'provperiod',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

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
        'op_show_bv_aliases' => '1',
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_rgfbasicinterp =
        array(
        'field_id' => 'conf_field_rgfbasicinterp',
        'dataclass' => 'attribute',
        'classtype' => 'objectmaterial',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'objectmaterial',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_rgfcomment =
        array(
        'field_id' => 'conf_field_rgfcomment',
        'dataclass' => 'txt',
        'classtype' => 'objectcomments',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'objectcomments',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_rgfcompleteness =
        array(
        'field_id' => 'conf_field_rgfcompleteness',
        'dataclass' => 'attribute',
        'classtype' => 'objectcompleteness',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'objectcompleteness',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_rgfdisplay =
        array(
        'field_id' => 'conf_field_rgfdisplay',
        'dataclass' => 'attribute',
        'classtype' => 'objectdisplay',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'objectdisplay',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_rgfmaterial =
        array(
        'field_id' => 'conf_field_rgfmaterial',
        'dataclass' => 'attribute',
        'classtype' => 'objectinterptype',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'objectinterptype',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_rgfperiod =
        array(
        'field_id' => 'conf_field_rgfperiod',
        'dataclass' => 'attribute',
        'classtype' => 'objectperiod',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'objectperiod',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_samplecondition =
        array(
        'field_id' => 'conf_field_samplecondition',
        'dataclass' => 'attribute',
        'classtype' => 'samplecondition',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'sampleconditions',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_samplequestions =
        array(
        'field_id' => 'conf_field_samplequestions',
        'dataclass' => 'txt',
        'classtype' => 'smpques',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_txttype',
                    'alias_col' => 'txttype',
                    'alias_src_key' => 'smpques',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation,
    );

    $conf_field_samplesize =
        array(
        'field_id' => 'conf_field_samplesize',
        'dataclass' => 'attribute',
        'classtype' => 'samplesize',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'samplesize',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_samplestatus =
        array(
        'field_id' => 'conf_field_samplestatus',
        'dataclass' => 'attribute',
        'classtype' => 'samplestatus',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'samplestatus',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_sampletype =
        array(
        'field_id' => 'conf_field_sampletype',
        'dataclass' => 'attribute',
        'classtype' => 'sampletype',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'sampletype',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_spotdate =
        array(
        'field_id' => 'conf_field_spotdate',
        'dataclass' => 'attribute',
        'classtype' => 'spotdate',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'spotdate',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

    $conf_field_subsamples =
        array(
        'field_id' => 'conf_field_subsamples',
        'dataclass' => 'attribute',
        'classtype' => 'subsamples',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_attributetype',
                    'alias_col' => 'attributetype',
                    'alias_src_key' => 'subsamples',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation,
    );

/**
* NUMBER FIELDS
*
*/

    $conf_field_hf_numofbags =
        array(
        'field_id' => 'conf_field_hf_numofbags',
        'dataclass' => 'number',
        'classtype' => 'hf_numofbags',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_numbertype',
                    'alias_col' => 'numbertype',
                    'alias_src_key' => 'hf_numofbags',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation,
    );

    $conf_field_lf_numofbags =
        array(
        'field_id' => 'conf_field_lf_numofbags',
        'dataclass' => 'number',
        'classtype' => 'lf_numofbags',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_numbertype',
                    'alias_col' => 'numbertype',
                    'alias_src_key' => 'lf_numofbags',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation,
    );

    $conf_field_volume =
        array(
        'field_id' => 'conf_field_volume',
        'dataclass' => 'number',
        'classtype' => 'volume',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_numbertype',
                    'alias_col' => 'numbertype',
                    'alias_src_key' => 'volume',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation,
    );

/**
* SPAN FIELDS
*
*/

    $conf_field_sameas =
        array(
        'field_id' => 'conf_field_sameas',
        'dataclass' => 'span',
        'classtype' => 'sameas',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_spantype',
                    'alias_col' => 'spantype',
                    'alias_src_key' => 'sameas',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $span_add_validation,
        'edt_validation' => $span_edt_validation,
    );

    $conf_field_shrgeom =
        array(
        'field_id' => 'conf_field_shrgeom',
        'dataclass' => 'span',
        'classtype' => 'shrgeom',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_spantype',
                    'alias_col' => 'spantype',
                    'alias_src_key' => 'shrgeom',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $span_add_validation,
        'edt_validation' => $span_edt_validation,
    );

/** 
* ACTION FIELDS
*
*
*/

    $conf_field_compiledby =
        array(
        'field_id' => 'conf_field_compiledby',
        'dataclass' => 'action',
        'classtype' => 'compiledby',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_actiontype',
                    'alias_col' => 'actiontype',
                    'alias_src_key' => 'compiledby',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => '',
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation,
    );

    $conf_field_compiledon =
        array(
        'field_id' => 'conf_field_compiledon',
        'dataclass' => 'date',
        'classtype' => 'compiledon',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_datetype',
                    'alias_col' => 'datetype',
                    'alias_src_key' => 'compiledon',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'datestyle' => 'dd,mm,yr',
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation,
    );

    $conf_field_checkedby =
        array(
        'field_id' => 'conf_field_checkedby',
        'dataclass' => 'action',
        'classtype' => 'checkedby',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_actiontype',
                    'alias_col' => 'actiontype',
                    'alias_src_key' => 'checkedby',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => '',
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation,
    );

    $conf_field_datingnarrativeby =
        array(
        'field_id' => 'conf_field_datingnarrativeby',
        'dataclass' => 'action',
        'classtype' => 'datingnarrativeby',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_actiontype',
                    'alias_col' => 'actiontype',
                    'alias_src_key' => 'datingnarrativeby',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => '',
        'add_validation' => $custom_action_add_vd,
        'edt_validation' => $custom_action_edt_vd,
    );

    $conf_field_datingnarrativeon =
        array(
        'field_id' => 'conf_field_datingnarrativeon',
        'dataclass' => 'date',
        'classtype' => 'datingnarrativeon',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_datetype',
                    'alias_col' => 'datetype',
                    'alias_src_key' => 'datingnarrativeon',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'datestyle' => 'dd,mm,yr',
        'add_validation' => $custom_date_add_vd,
        'edt_validation' => $custom_date_edt_vd,
    );

    $conf_field_drawnby =
        array(
        'field_id' => 'conf_field_drawnby',
        'dataclass' => 'action',
        'classtype' => 'drawnby',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_actiontype',
                    'alias_col' => 'actiontype',
                    'alias_src_key' => 'drawnby',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'single',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => '',
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation,
    );

    $conf_field_drawnon =
        array(
        'field_id' => 'conf_field_drawnon',
        'dataclass' => 'date',
        'classtype' => 'drawnon',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_datetype',
                    'alias_col' => 'datetype',
                    'alias_src_key' => 'drawnon',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'datestyle' => 'dd,mm,yr',
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation,
    );

    $conf_field_grpdatingnarrativeby =
        array(
        'field_id' => 'conf_field_grpdatingnarrativeby',
        'dataclass' => 'action',
        'classtype' => 'grpdatingnarrativeby',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_actiontype',
                    'alias_col' => 'actiontype',
                    'alias_src_key' => 'grpdatingnarrativeby',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => '',
        'add_validation' => $custom_action_add_vd,
        'edt_validation' => $custom_action_edt_vd,
    );

    $conf_field_grpdatingnarrativeon =
        array(
        'field_id' => 'conf_field_grpdatingnarrativeon',
        'dataclass' => 'date',
        'classtype' => 'grpdatingnarrativeon',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_datetype',
                    'alias_col' => 'datetype',
                    'alias_src_key' => 'grpdatingnarrativeon',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'datestyle' => 'dd,mm,yr',
        'add_validation' => $custom_date_add_vd,
        'edt_validation' => $custom_date_edt_vd,
    );

    $conf_field_grpnarrativeby =
        array(
        'field_id' => 'conf_field_grpnarrativeby',
        'dataclass' => 'action',
        'classtype' => 'grpnarrativeby',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_actiontype',
                    'alias_col' => 'actiontype',
                    'alias_src_key' => 'grpnarrativeby',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => '',
        'add_validation' => $custom_action_add_vd,
        'edt_validation' => $custom_action_edt_vd,
    );

    $conf_field_grpnarrativeon =
        array(
        'field_id' => 'conf_field_grpnarrativeon',
        'dataclass' => 'date',
        'classtype' => 'grpnarrativeon',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_datetype',
                    'alias_col' => 'datetype',
                    'alias_src_key' => 'grpnarrativeon',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'datestyle' => 'dd,mm,yr',
        'add_validation' => $custom_date_add_vd,
        'edt_validation' => $custom_date_edt_vd,
    );

    $conf_field_interpretedby =
        array(
        'field_id' => 'conf_field_interpretedby',
        'dataclass' => 'action',
        'classtype' => 'interpretedby',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_actiontype',
                    'alias_col' => 'actiontype',
                    'alias_src_key' => 'interpretedby',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => '',
        'add_validation' => $custom_action_add_vd,
        'edt_validation' => $custom_action_edt_vd,
    );

    $conf_field_interpretedon =
        array(
        'field_id' => 'conf_field_interpretedon',
        'dataclass' => 'date',
        'classtype' => 'interpretedon',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_datetype',
                    'alias_col' => 'datetype',
                    'alias_src_key' => 'interpretedon',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'datestyle' => 'dd,mm,yr',
        'add_validation' => $custom_date_add_vd,
        'edt_validation' => $custom_date_edt_vd,
    );

    $conf_field_issuedon =
        array(
        'field_id' => 'conf_field_issuedon',
        'dataclass' => 'date',
        'classtype' => 'issuedon',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_datetype',
                    'alias_col' => 'datetype',
                    'alias_src_key' => 'issuedon',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'datestyle' => 'dd,mm,yr',
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation,
    );

    $conf_field_issuedto =
        array(
        'field_id' => 'conf_field_issuedto',
        'dataclass' => 'action',
        'classtype' => 'issuedto',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_actiontype',
                    'alias_col' => 'actiontype',
                    'alias_src_key' => 'issuedto',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'single',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => '',
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation,
    );

    $conf_field_sgrnarrativeby =
        array(
        'field_id' => 'conf_field_sgrnarrativeby',
        'dataclass' => 'action',
        'classtype' => 'sgrnarrativeby',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_actiontype',
                    'alias_col' => 'actiontype',
                    'alias_src_key' => 'sgrnarrativeby',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => '',
        'add_validation' => $custom_action_add_vd,
        'edt_validation' => $custom_action_edt_vd,
    );

    $conf_field_sgrnarrativeon =
        array(
        'field_id' => 'conf_field_sgrnarrativeon',
        'dataclass' => 'date',
        'classtype' => 'sgrnarrativeon',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_datetype',
                    'alias_col' => 'datetype',
                    'alias_src_key' => 'sgrnarrativeon',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'datestyle' => 'dd,mm,yr',
        'add_validation' => $custom_date_add_vd,
        'edt_validation' => $custom_date_edt_vd,
    );

    $conf_field_takenby =
        array(
        'field_id' => 'conf_field_takenby',
        'dataclass' => 'action',
        'classtype' => 'takenby',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_actiontype',
                    'alias_col' => 'actiontype',
                    'alias_src_key' => 'takenby',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'single',
        'actors_type' => 'people',
        'actors_elementclass' => 'txt',
        'actors_grp' => '',
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation,
    );

    $conf_field_takenon =
        array(
        'field_id' => 'conf_field_takenon',
        'dataclass' => 'date',
        'classtype' => 'takenon',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_datetype',
                    'alias_col' => 'datetype',
                    'alias_src_key' => 'takenon',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'datestyle' => 'dd,mm,yr',
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation,
    );
    
/**
* FILE FIELDS
*
*/

    $conf_field_cxtsheet =
        array(
        'field_id' => 'conf_field_cxtsheet',
        'dataclass' => 'file',
        'classtype' => 'cxtsheet',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_filetype',
                    'alias_col' => 'filetype',
                    'alias_src_key' => 'images',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'op_hrname'=> TRUE,
        'add_validation' => $file_add_validation,
        'edt_validation' => $file_edt_validation,
    );

    $conf_field_file =
        array(
        'field_id' => 'conf_field_file',
        'dataclass' => 'file',
        'classtype' => 'images',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_filetype',
                    'alias_col' => 'filetype',
                    'alias_src_key' => 'images',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $file_add_validation,
        'edt_validation' => $file_edt_validation,
    );

    $conf_field_section =
        array(
        'field_id' => 'conf_field_section',
        'dataclass' => 'file',
        'classtype' => 'section',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_lut_filetype',
                    'alias_col' => 'filetype',
                    'alias_src_key' => 'section',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $file_add_validation,
        'edt_validation' => $file_edt_validation,
    );

/**
* XMI FIELDS
*
*/
    //CXT

    $conf_field_cxtrgfxmi =
        array(
        'field_id' => 'conf_field_cxtrgfxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'rgf_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'cxt',
        'xmi_mod' => 'rgf',
        'op_xmi_itemkey' => 'rgf_cd',
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    $conf_field_cxtsgrxmi =
        array(
        'field_id' => 'conf_field_cxtsgrxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'sgr_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'cxt',
        'xmi_mod' => 'sgr',
        'op_xmi_itemkey' => 'sgr_cd',
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    $conf_field_cxtsmpxmi =
        array(
        'field_id' => 'conf_field_cxtsmpxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'smp_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'cxt',
        'xmi_mod' => 'smp',
        'op_xmi_itemkey' => 'smp_cd',
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    $conf_field_cxtsphxmi =
        array(
        'field_id' => 'conf_field_cxtsphxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'sph_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'cxt',
        'xmi_mod' => 'sph',
        'op_xmi_itemkey' => 'sph_cd',
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    //GRP

    $conf_field_grpsgrxmi =
        array(
        'field_id' => 'conf_field_grpsgrxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'sgr_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'grp',
        'xmi_mod' => 'sgr',
        'op_xmi_itemkey' => 'sgr_cd',
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    //PLN

    $conf_field_plncxtxmi =
        array(
        'field_id' => 'conf_field_plncxtxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'cxt_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'pln',
        'xmi_mod' => 'cxt',
        'op_xmi_itemkey' => 'cxt_cd',
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    //PRNT

    $conf_field_prntcxtxmi =
        array(
            'field_id' => 'conf_field_prntcxtxmi',
            'dataclass' => 'xmi',
            'classtype' => 'xmi_list',
                'aliasinfo' =>
                    array(
                        'alias_tbl' => 'cor_tbl_module',
                        'alias_col' => 'itemkey',
                        'alias_src_key' => 'cxt_cd',
                        'alias_type' => '1',
                    ),
            'editable' => TRUE,
            'hidden' => FALSE,
            'module' => 'cxt',
            'xmi_mod' => 'cxt',
            'op_xmi_itemkey' => 'cxt_cd',
            'add_validation' => $custom_xmi_add_validation,
            'edt_validation' => $xmi_edt_validation,
    );

    //SEC

    $conf_field_seccxtxmi =
        array(
            'field_id' => 'conf_field_seccxtxmi',
            'dataclass' => 'xmi',
            'classtype' => 'xmi_list',
                'aliasinfo' =>
                    array(
                        'alias_tbl' => 'cor_tbl_module',
                        'alias_col' => 'itemkey',
                        'alias_src_key' => 'cxt_cd',
                        'alias_type' => '1',
                    ),
            'editable' => TRUE,
            'hidden' => FALSE,
            'module' => 'sec',
            'xmi_mod' => 'cxt',
            'op_xmi_itemkey' => 'cxt_cd',
            'add_validation' => $xmi_add_validation,
            'edt_validation' => $xmi_edt_validation,
    );

    //SPF

    $conf_field_spfcxtxmi =
        array(
        'field_id' => 'conf_field_spfcxtxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'cxt_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'spf',
        'xmi_mod' => 'cxt',
        'op_xmi_itemkey' => 'cxt_cd',
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    $conf_field_spfspfxmi =
        array(
        'field_id' => 'conf_field_spfspfxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'spf_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'spf',
        'xmi_mod' => 'spf',
        'op_xmi_itemkey' => 'spf_cd',
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    //SGR

    $conf_field_sgrcxtxmi =
        array(
        'field_id' => 'conf_field_sgrcxtxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'cxt_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'sgr',
        'xmi_mod' => 'cxt',
        'op_xmi_itemkey' => 'cxt_cd',
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    $conf_field_sgrgrpxmi =
        array(
        'field_id' => 'conf_field_sgrgrpxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'grp_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'cxt',
        'xmi_mod' => 'sgr',
        'op_xmi_itemkey' => 'grp_cd',
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    //SMP

    $conf_field_smpcxtxmi =
        array(
        'field_id' => 'conf_field_smpcxtxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'cxt_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'smp',
        'xmi_mod' => 'cxt',
        'op_xmi_itemkey' => 'cxt_cd',
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    $conf_field_smpcxtxmi =
        array(
        'field_id' => 'conf_field_smpcxtxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'cxt_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'spf',
        'xmi_mod' => 'cxt',
        'op_xmi_itemkey' => 'cxt_cd',
        'add_validation' => $custom_xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    //SPF

    $conf_field_spfcxtxmi =
        array(
        'field_id' => 'conf_field_spfcxtxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'cxt_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'spf',
        'xmi_mod' => 'cxt',
        'op_xmi_itemkey' => 'cxt_cd',
        'add_validation' => $custom_xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    $conf_field_spfrgfxmi =
        array(
        'field_id' => 'conf_field_spfrgfxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'rgf_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'spf',
        'xmi_mod' => 'rgf',
        'op_xmi_itemkey' => 'rgf_cd',
        'add_validation' => $custom_xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    //SPH

    $conf_field_sphcxtxmi =
        array(
        'field_id' => 'conf_field_sphcxtxmi',
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
            'aliasinfo' =>
                array(
                    'alias_tbl' => 'cor_tbl_module',
                    'alias_col' => 'itemkey',
                    'alias_src_key' => 'cxt_cd',
                    'alias_type' => '1',
                ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'module' => 'sph',
        'xmi_mod' => 'cxt',
        'op_xmi_itemkey' => 'cxt_cd',
        'add_validation' => $custom_xmi_add_validation,
        'edt_validation' => $xmi_edt_validation,
    );

    //RGF

    $conf_field_rgfcxtxmi =
        array(
            'field_id' => 'conf_field_rgfcxtxmi',
            'dataclass' => 'xmi',
            'classtype' => 'xmi_list',
                'aliasinfo' =>
                    array(
                        'alias_tbl' => 'cor_tbl_module',
                        'alias_col' => 'itemkey',
                        'alias_src_key' => 'cxt_cd',
                        'alias_type' => '1',
                    ),
            'editable' => TRUE,
            'hidden' => FALSE,
            'module' => 'rgf',
            'xmi_mod' => 'cxt',
            'op_xmi_itemkey' => 'cxt_cd',
            'add_validation' => $custom_xmi_add_validation,
            'edt_validation' => $xmi_edt_validation,
    );

    $conf_field_rgfspfxmi =
        array(
            'field_id' => 'conf_field_rgfspfxmi',
            'dataclass' => 'xmi',
            'classtype' => 'xmi_list',
                'aliasinfo' =>
                    array(
                        'alias_tbl' => 'cor_tbl_module',
                        'alias_col' => 'itemkey',
                        'alias_src_key' => 'spf_cd',
                        'alias_type' => '1',
                    ),
            'editable' => TRUE,
            'hidden' => FALSE,
            'module' => 'rgf',
            'xmi_mod' => 'spf',
            'op_xmi_itemkey' => 'spf_cd',
            'add_validation' => $custom_xmi_add_validation,
            'edt_validation' => $xmi_edt_validation,
    );

/**
 * EVENTS
 *
 */
 
 $conf_event_compiled = 
     array(
         'type' => 'compiled',
         'date' => $conf_field_compiledon,
         'action' => $conf_field_compiledby
 );

 $conf_event_taken = 
     array(
         'type' => 'compiled',
         'date' => $conf_field_takenon,
         'action' => $conf_field_takenby
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

$conf_reg_op =
    array(
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
        'field_id' => 'conf_field_delete',
        'dataclass' => 'delete',
        'classtype' => 'delete',
        'editable' => TRUE,
        'hidden' => TRUE,
        'del_validation' => $del_validation
);

?>
