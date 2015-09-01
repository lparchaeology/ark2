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
* @author     Jessica Ogden <j.ogden@lparchaeology.com>
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

// itemkey for mod_abk (Address Book)
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
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

$conf_field_abk_cd['add_validation'][] = $key_vd_modtype;
$conf_field_abk_cd['edt_validation'][] = $key_vd_modtype;

// set up the abktype
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

// itemkey for mod_loc (locations)
$conf_field_loc_cd =
    array(
        'field_id' => 'conf_field_loc_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'loc_cd',
        'module' => 'loc',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'loc_cd',
                'alias_type' => '1',
        ),
        'editable' => TRUE, // if FALSE, update_db will not process this field
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);


$conf_field_loc_cd['add_validation'][] = $key_vd_modtype;
$conf_field_loc_cd['edt_validation'][] = $key_vd_modtype;

// location Type config
$conf_field_loctype =
    array(
        'field_id' => 'conf_field_location_type',
        'dataclass' => 'modtype',
        'classtype' => 'loctype',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_col',
                'alias_col' => 'dbname',
                'alias_src_key' => 'loctype',
                'alias_type' => '1',
        ),
        'editable' => TRUE, // if FALSE, update_db will not process this field
        'hidden' => FALSE,
        'add_validation' => 'none',
        'edt_validation' => 'none'
);

// Itemkey for mod_cat (Catalogued Finds)
$conf_field_cat_cd =
    array(
        'field_id' => 'conf_field_cat_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'cat_cd',
        'module' => 'cat',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'cat_cd',
                'alias_type' => '1',
        ),
        'editable' => TRUE, // if FALSE, update_db will not process this field
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

// itemkey for mod_pho (Photos)
$conf_field_pho_cd =
    array(
        'field_id' => 'conf_field_ _cd',
        'dataclass' => 'itemkey',
        'classtype' => 'pho_cd',
        'module' => 'pho',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'pho_cd',
                'alias_type' => '1',
        ),
        'editable' => TRUE, // if FALSE, update_db will not process this field
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);


$conf_field_pho_cd['add_validation'][] = $key_vd_modtype;
$conf_field_pho_cd['edt_validation'][] = $key_vd_modtype;

//Photype config
$conf_field_photype =
    array(
        'field_id' => 'conf_field_photype',
        'dataclass' => 'modtype',
        'classtype' => 'photype',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_col',
                'alias_col' => 'dbname',
                'alias_src_key' => 'photype',
                'alias_type' => '1',
            ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => 'none',
        'edt_validation' => 'none'
);

// itemkey for mod_ill (Illustrations)
$conf_field_ill_cd =
    array(
        'field_id' => 'conf_field_ _cd',
        'dataclass' => 'itemkey',
        'classtype' => 'ill_cd',
        'module' => 'ill',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'ill_cd',
                'alias_type' => '1',
        ),
        'editable' => TRUE, // if FALSE, update_db will not process this field
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

$conf_field_ill_cd['add_validation'][] = $key_vd_modtype;
$conf_field_ill_cd['edt_validation'][] = $key_vd_modtype;

//Illtype config
$conf_field_illtype =
    array(
        'field_id' => 'conf_field_illtype',
        'dataclass' => 'modtype',
        'classtype' => 'illtype',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_col',
                'alias_col' => 'dbname',
                'alias_src_key' => 'illtype',
                'alias_type' => '1',
            ),
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => 'none',
        'edt_validation' => 'none'
);

// itemkey for mod_cat (Catalogued Finds)
$conf_field_cat_cd =
    array(
        'field_id' => 'conf_field_cat_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'cat_cd',
        'module' => 'cat',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'cat_cd',
                'alias_type' => '1',
        ),
        'editable' => TRUE, // if FALSE, update_db will not process this field
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

// itemkey for mod_exc (excavation units)
$conf_field_exc_cd =
    array(
        'field_id' => 'conf_field_exc_cd',
        'dataclass' => 'itemkey',
        'classtype' => 'exc_cd',
        'module' => 'exc',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_module',
                'alias_col' => 'itemkey',
                'alias_src_key' => 'exc_cd',
                'alias_type' => '1',
        ),
        'editable' => TRUE, // if FALSE, update_db will not process this field
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

$conf_field_exc_cd['add_validation'][] = $key_vd_modtype;
$conf_field_exc_cd['edt_validation'][] = $key_vd_modtype;

// Investigation Type config
$conf_field_exctype =
    array(
        'field_id' => 'conf_field_excav_type',
        'dataclass' => 'modtype',
        'classtype' => 'exctype',
        'aliasinfo' =>
            array(
                'alias_tbl' => 'cor_tbl_col',
                'alias_col' => 'dbname',
                'alias_src_key' => 'exctype',
                'alias_type' => '1',
        ),
        'editable' => TRUE, // if FALSE, update_db will not process this field
        'hidden' => FALSE,
        'add_validation' => 'none',
        'edt_validation' => 'none'
);

// -- TEXT FIELDS -- //

// TXT fields for address book

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

// Bibliography Fields
$conf_field_bib_name=
    array(
        'field_id' => 'conf_field_bib_name',
        'dataclass' => 'txt',
        'classtype' => 'bib_name',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_bib_desc=
    array(
        'field_id' => 'conf_field_bib_desc',
        'dataclass' => 'txt',
        'classtype' => 'bib_desc',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_short_title=
    array(
        'field_id' => 'conf_field_short_title',
        'dataclass' => 'txt',
        'classtype' => 'short_title',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_full_citation=
    array(
        'field_id' => 'conf_field_full_citation',
        'dataclass' => 'txt',
        'classtype' => 'full_citation',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_sherd_date=
    array(
        'field_id' => 'conf_field_bib_desc',
        'dataclass' => 'span',
        'classtype' => 'field_date',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_cat_short=
    array(
        'field_id' => 'conf_field_cat_short',
        'dataclass' => 'txt',
        'classtype' => 'cat_short',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_cat_desc=
    array(
        'field_id' => 'conf_field_cat_desc',
        'dataclass' => 'txt',
        'classtype' => 'cat_desc',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_cat_dim=
    array(
        'field_id' => 'conf_field_cat_dim',
        'dataclass' => 'txt',
        'classtype' => 'cat_dim',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_cat_code=
    array(
        'field_id' => 'conf_field_cat_code',
        'dataclass' => 'txt',
        'classtype' => 'cat_code',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_area=
    array(
        'field_id' => 'conf_field_area',
        'dataclass' => 'txt',
        'classtype' => 'area',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_toponym=
    array(
        'field_id' => 'conf_field_toponym',
        'dataclass' => 'txt',
        'classtype' => 'toponym',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_pho_desc =    
    array(
        'field_id' => 'conf_field_pho_desc',
        'dataclass' => 'txt',
        'classtype' => 'phodesc',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_source=
    array(
        'field_id' => 'conf_field_source',
        'dataclass' => 'txt',
        'classtype' => 'source',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_pho_facing=
    array(
        'field_id' => 'conf_field_pho_facing',
        'dataclass' => 'txt',
        'classtype' => 'pho_facing',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_pho_notes=
    array(
        'field_id' => 'conf_field_pho_notes',
        'dataclass' => 'txt',
        'classtype' => 'phonotes',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_ill_notes=
    array(
        'field_id' => 'conf_field_ill_notes',
        'dataclass' => 'txt',
        'classtype' => 'illnotes',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_gaz_desc=
    array(
        'field_id' => 'conf_field_gaz_desc',
        'dataclass' => 'txt',
        'classtype' => 'gazdesc',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_comments_notes=
    array(
        'field_id' => 'conf_field_comments_notes',
        'dataclass' => 'txt',
        'classtype' => 'comments_notes',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_kes_source=
    array(
        'field_id' => 'conf_field_kes_source',
        'dataclass' => 'txt',
        'classtype' => 'kes_source',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_chronology=
    array(
        'field_id' => 'conf_field_chronology',
        'dataclass' => 'txt',
        'classtype' => 'chronology',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_object_code=
    array(
        'field_id' => 'conf_field_object_code',
        'dataclass' => 'txt',
        'classtype' => 'objectcode',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_condition=
    array(
        'field_id' => 'conf_field_condition',
        'dataclass' => 'txt',
        'classtype' => 'condition',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_file_name=
    array(
        'field_id' => 'conf_field_file_name',
        'dataclass' => 'txt',
        'classtype' => 'file_name',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_cat_diameter=
    array(
        'field_id' => 'conf_field_cat_diameter',
        'dataclass' => 'txt',
        'classtype' => 'cat_diameter',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_cat_weight=
    array(
        'field_id' => 'conf_field_cat_weight',
        'dataclass' => 'txt',
        'classtype' => 'cat_weight',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_lw_thickness=
    array(
        'field_id' => 'conf_field_lw_thickness',
        'dataclass' => 'txt',
        'classtype' => 'lw_thickness',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_lw_width=
    array(
        'field_id' => 'conf_field_lw_width',
        'dataclass' => 'txt',
        'classtype' => 'lw_width',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_lw_height=
    array(
        'field_id' => 'conf_field_lw_height',
        'dataclass' => 'txt',
        'classtype' => 'lw_height',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_lw_stamp=
    array(
        'field_id' => 'conf_field_lw_stamp',
        'dataclass' => 'txt',
        'classtype' => 'lw_stamp',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_amp_hand1=
    array(
        'field_id' => 'conf_field_amp_hand1',
        'dataclass' => 'txt',
        'classtype' => 'amp_hand1',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_amp_hand2=
    array(
        'field_id' => 'conf_field_amp_hand2',
        'dataclass' => 'txt',
        'classtype' => 'amp_hand2',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_amp_micro1=
    array(
        'field_id' => 'conf_field_amp_micro1',
        'dataclass' => 'txt',
        'classtype' => 'amp_micro1',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_amp_micro2=
    array(
        'field_id' => 'conf_field_amp_micro2',
        'dataclass' => 'txt',
        'classtype' => 'amp_micro2',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_amp_petro1=
    array(
        'field_id' => 'conf_field_amp_petro1',
        'dataclass' => 'txt',
        'classtype' => 'amp_petro1',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_amp_petro2=
    array(
        'field_id' => 'conf_field_amp_petro2',
        'dataclass' => 'txt',
        'classtype' => 'amp_petro2',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_amp_petro3=
    array(
        'field_id' => 'conf_field_amp_petro3',
        'dataclass' => 'txt',
        'classtype' => 'amp_petro3',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_cat_fabric=
    array(
        'field_id' => 'conf_field_cat_fabric',
        'dataclass' => 'txt',
        'classtype' => 'cat_fabric',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_coin_orientation=
    array(
        'field_id' => 'conf_field_coin_orientation',
        'dataclass' => 'txt',
        'classtype' => 'orientation',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_coin_obverse=
    array(
        'field_id' => 'conf_field_coin_obverse',
        'dataclass' => 'txt',
        'classtype' => 'coin_obverse',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_coin_reverse=
    array(
        'field_id' => 'conf_field_coin_reverse',
        'dataclass' => 'txt',
        'classtype' => 'coin_reverse',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_observations=
    array(
        'field_id' => 'conf_field_observations',
        'dataclass' => 'txt',
        'classtype' => 'observations',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_museum_number=
    array(
        'field_id' => 'conf_field_museum_number',
        'dataclass' => 'txt',
        'classtype' => 'museum_number',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_pattern_decoration=
    array(
        'field_id' => 'conf_field_pattern_decoration',
        'dataclass' => 'txt',
        'classtype' => 'pattern_decoration',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_figure_decoration=
    array(
        'field_id' => 'conf_field_figure_decoration',
        'dataclass' => 'txt',
        'classtype' => 'figure_decoration',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_attribution=
    array(
        'field_id' => 'conf_field_attribution',
        'dataclass' => 'txt',
        'classtype' => 'attribution',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_fabric_tech=
    array(
        'field_id' => 'conf_field_fabric_tech',
        'dataclass' => 'txt',
        'classtype' => 'fabric_tech',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_date_basis=
    array(
        'field_id' => 'conf_field_date_basis',
        'dataclass' => 'txt',
        'classtype' => 'date_basis',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_sk_age=
    array(
        'field_id' => 'conf_field_sk_age',
        'dataclass' => 'txt',
        'classtype' => 'sk_age',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_sk_dims=
    array(
        'field_id' => 'conf_field_sk_dims',
        'dataclass' => 'txt',
        'classtype' => 'sk_dims',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_ceramic_summary=
    array(
        'field_id' => 'conf_field_ceramic_summary',
        'dataclass' => 'txt',
        'classtype' => 'ceramic_summary',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_other_summary=
    array(
        'field_id' => 'conf_field_other_summary',
        'dataclass' => 'txt',
        'classtype' => 'other_summary',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_skull_dir=
    array(
        'field_id' => 'conf_field_skull_dir',
        'dataclass' => 'txt',
        'classtype' => 'skull_dir',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_sk_sex=
    array(
        'field_id' => 'conf_field_sk_sex',
        'dataclass' => 'txt',
        'classtype' => 'sk_sex',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_fill_finds=
    array(
        'field_id' => 'conf_field_fill_finds',
        'dataclass' => 'txt',
        'classtype' => 'fill_finds',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_orientation=
    array(
        'field_id' => 'conf_field_orientation',
        'dataclass' => 'txt',
        'classtype' => 'orientation',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_other_summary=
    array(
        'field_id' => 'conf_field_other_summary',
        'dataclass' => 'txt',
        'classtype' => 'other_summary',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_fieldwork_id=
    array(
        'field_id' => 'conf_field_fieldwork_id',
        'dataclass' => 'txt',
        'classtype' => 'fieldwork_id',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
//txt fields for plots
$conf_field_otherartefacts =
    array(
        'field_id' => 'conf_field_otherartefacts',
        'dataclass' => 'txt',
        'classtype' => 'otherartefacts',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_topography =
    array(
        'field_id' => 'conf_field_topography',
        'dataclass' => 'txt',
        'classtype' => 'topography',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_stratigraphy =
    array(
        'field_id' => 'conf_field_stratigraphy',
        'dataclass' => 'txt',
        'classtype' => 'stratigraphy',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_disturbance =
    array(
        'field_id' => 'conf_field_disturbance',
        'dataclass' => 'txt',
        'classtype' => 'disturbance',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_tombevidence =
    array(
        'field_id' => 'conf_field_tombevidence',
        'dataclass' => 'txt',
        'classtype' => 'tombevidence',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_recorder =
    array(
        'field_id' => 'conf_field_recorder',
        'dataclass' => 'txt',
        'classtype' => 'recorder',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);
$conf_field_crew =
    array(
        'field_id' => 'conf_field_crew',
        'dataclass' => 'txt',
        'classtype' => 'crew',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


// -- NUMBER FIELDS -- //

$conf_field_elevation=
    array(
        'field_id' => 'conf_field_elevation',
        'dataclass' => 'number',
        'classtype' => 'elevation',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_preservation=
    array(
        'field_id' => 'conf_field_elevation',
        'dataclass' => 'number',
        'classtype' => 'preservation',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_total =
    array(
        'field_id' => 'conf_field_total',        
        'dataclass' => 'number',
        'classtype' => 'total',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_num_examples =
    array(
        'field_id' => 'conf_field_num_examples',        
        'dataclass' => 'number',
        'classtype' => 'num_examples',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

// Number fields for plots

$conf_field_numofbags =
    array(
        'field_id' => 'conf_field_numofbags',        
        'dataclass' => 'number',
        'classtype' => 'numofbags',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_stoniness =
    array(
        'field_id' => 'conf_field_stoniness',        
        'dataclass' => 'number',
        'classtype' => 'stoniness',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_visibility =
    array(
        'field_id' => 'conf_field_num_visibility',        
        'dataclass' => 'number',
        'classtype' => 'visibility',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_depthofplough =
    array(
        'field_id' => 'conf_field_depthofplough',        
        'dataclass' => 'number',
        'classtype' => 'depthofplough',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

//  -- SPAN FIELDS -- //

$conf_field_location_dates =
    array(
        'field_id' => 'conf_field_location_dates',
        'dataclass' => 'span',
        'classtype' => 'location_dates',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $span_add_validation,
        'edt_validation' => $span_edt_validation,
        'field_op_label' => FALSE,
        'field_op_divider' => ' - ',
        'field_op_modifier' => FALSE
);
$conf_field_finddates =
    array(
        'field_id' => 'conf_field_finddates',
        'dataclass' => 'span',
        'classtype' => 'finddates',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $chain_span_add_validation,
        'edt_validation' => $chain_span_edt_validation,
        'field_op_label' => FALSE,
        'field_op_divider' => ' - ',
        'field_op_modifier' => TRUE
);

$conf_field_sk_daterange =
    array(
        'field_id' => 'conf_field_sk_daterange',
        'dataclass' => 'span',
        'classtype' => 'sk_daterange',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $chain_span_add_validation,
        'edt_validation' => $chain_span_edt_validation,
        'field_op_label' => FALSE,
        'field_op_divider' => ' - ',
        'field_op_modifier' => TRUE
);

$conf_field_sk_terminusdaterange =
    array(
        'field_id' => 'conf_field_sk_terminusdaterange',
        'dataclass' => 'span',
        'classtype' => 'sk_terminusdaterange',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $chain_span_add_validation,
        'edt_validation' => $chain_span_edt_validation,
        'field_op_label' => FALSE,
        'field_op_divider' => ' - ',
        'field_op_modifier' => TRUE
);

$conf_field_sk_weighteddaterange =
    array(
        'field_id' => 'conf_field_sk_weighteddaterange',
        'dataclass' => 'span',
        'classtype' => 'sk_weighteddaterange',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $chain_span_add_validation,
        'edt_validation' => $chain_span_edt_validation,
        'field_op_label' => FALSE,
        'field_op_divider' => ' - ',
        'field_op_modifier' => TRUE
);

// ATTRIBUTE FIELDS //

$conf_field_survey=
    array(
        'field_id' => 'conf_field_survey',
        'dataclass' => 'attribute',
        'classtype' => 'survey',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_visit_year=
    array(
        'field_id' => 'conf_field_visit_year',
        'dataclass' => 'attribute',
        'classtype' => 'visit_year',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_sherd_class=
    array(
        'field_id' => 'conf_field_sherd_class',
        'dataclass' => 'attribute',
        'classtype' => 'sherd_class',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $chain_attr_add_validation,
        'edt_validation' => $chain_attr_edt_validation
);

$conf_field_sherd_type=
    array(
        'field_id' => 'conf_field_sherd_type',
        'dataclass' => 'attribute',
        'classtype' => 'sherd_type',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $chain_attr_add_validation,
        'edt_validation' => $chain_attr_edt_validation
);
$conf_field_sherdfunction=
    array(
        'field_id' => 'conf_field_sherdfunction',
        'dataclass' => 'attribute',
        'classtype' => 'sherdfunction',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $chain_attr_add_validation,
        'edt_validation' => $chain_attr_edt_validation
);

$conf_field_sherd_form =
    array(
        'field_id' => 'conf_field_sherd_form',
        'dataclass' => 'attribute',
        'classtype' => 'sherd_form',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $chain_attr_add_validation,
        'edt_validation' => $chain_attr_edt_validation
);

$conf_field_transect=
    array(
        'field_id' => 'conf_field_transect',
        'dataclass' => 'attribute',
        'classtype' => 'transect',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_geomorph=
    array(
        'field_id' => 'conf_field_geomorph',
        'dataclass' => 'attribute',
        'classtype' => 'geomorph',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);            

$conf_field_landuse=
    array(
        'field_id' => 'conf_field_landuse',
        'dataclass' => 'attribute',
        'classtype' => 'landuse',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);   

$conf_field_chrono=
    array(
        'field_id' => 'conf_field_chrono',
        'dataclass' => 'attribute',
        'classtype' => 'chrono',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);    

$conf_field_location_function=
    array(
        'field_id' => 'conf_field_location_function',
        'dataclass' => 'attribute',
        'classtype' => 'site_type',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);     

$conf_field_media=
    array(
        'field_id' => 'conf_field_media',
        'dataclass' => 'attribute',
        'classtype' => 'media',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_project=
    array(
        'field_id' => 'conf_field_project',
        'dataclass' => 'attribute',
        'classtype' => 'project',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_tomb_type=
    array(
        'field_id' => 'conf_field_tomb_type',
        'dataclass' => 'attribute',
        'classtype' => 'tomb_type',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_material=
    array(
        'field_id' => 'conf_field_material',
        'dataclass' => 'attribute',
        'classtype' => 'material',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

// Attribute fields for plots

$conf_field_weathering=
    array(
        'field_id' => 'conf_field_weathering',
        'dataclass' => 'attribute',
        'classtype' => 'weathering',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);
$conf_field_ploughing=
    array(
        'field_id' => 'conf_field_ploughing',
        'dataclass' => 'attribute',
        'classtype' => 'ploughing',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

// -- OPTION FIELDS -- //
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
        'field_id' => 'conf_reg_op_no_qed',
        'dataclass' => 'op',
        'classtype' => 'none',
        'options' => 'view,enter', // use 'check' for the checkbox
        'editable' => FALSE,
        'hidden' => FALSE
);
 
$conf_reg_op_no_enter = 
 array(
        'field_id' => 'conf_reg_op_no_enter',
        'dataclass' => 'op',
        'classtype' => 'none',
        'options' => 'view,qed',
        'editable' => FALSE,
        'hidden' => FALSE
);

$conf_reg_op_view = 
 array(
        'field_id' => 'conf_reg_op_view',
        'dataclass' => 'op',
        'classtype' => 'none',
        'options' => 'view',
        'editable' => FALSE,
        'hidden' => FALSE
);


// IMAGE FIELDS //

$conf_field_images =
  array(
      'field_id' => 'conf_field_images',
      'dataclass' => 'file',
      'classtype' => 'photo',
      'aliasinfo' => FALSE,
      'editable' => TRUE,
      'hidden' => FALSE,
      'add_validation' => $file_add_validation,
      'edt_validation' => $file_edt_validation
);

$conf_field_illus =
  array(
      'field_id' => 'conf_field_images',
      'dataclass' => 'file',
      'classtype' => 'illus',
      'aliasinfo' => FALSE,
      'editable' => TRUE,
      'hidden' => FALSE,
      'add_validation' => $file_add_validation,
      'edt_validation' => $file_edt_validation
);

// XMI FIELDS

$conf_field_catxmiill = 
   array(
       'field_id' => 'conf_field_catxmiill',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'cat_cd',
               'alias_type' => '1',
            ),
       'module' => 'ill',
       'xmi_mod' => 'cat',
       'force_var_itemkey' => 'cat_cd',
       'op_xmi_itemkey' => 'cat_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

$conf_field_catxmipho = 
   array(
       'field_id' => 'conf_field_catxmipho',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'cat_cd',
               'alias_type' => '1',
            ),
       'module' => 'pho',
       'xmi_mod' => 'cat',
       'force_var_itemkey' => 'cat_cd',
       'op_xmi_itemkey' => 'cat_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

$conf_field_catxmiloc = 
   array(
       'field_id' => 'conf_field_catxmiloc',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'cat_cd',
               'alias_type' => '1',
            ),
       'module' => 'loc',
       'xmi_mod' => 'cat',
       'force_var_itemkey' => 'cat_cd',
       'op_xmi_itemkey' => 'cat_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $chain_xmi_add_validation,
       'edt_validation' => $chain_xmi_edt_validation
);

$conf_field_catxmiexc = 
   array(
       'field_id' => 'conf_field_excxmicat',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'cat_cd',
               'alias_type' => '1',
            ),
       'module' => 'exc',
       'xmi_mod' => 'cat',
       'force_var_itemkey' => 'cat_cd',
       'op_xmi_itemkey' => 'cat_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $chain_xmi_add_validation,
       'edt_validation' => $chain_xmi_edt_validation
);

$conf_field_illxmicat = 
   array(
       'field_id' => 'conf_field_illxmiloc',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'ill_cd',
               'alias_type' => '1',
            ),
       'module' => 'cat',
       'xmi_mod' => 'ill',
       'force_var_itemkey' => 'ill_cd',
       'op_xmi_itemkey' => 'ill_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

$conf_field_excxmiloc = 
   array(
       'field_id' => 'conf_field_excxmiloc',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'loc_cd',
               'alias_type' => '1',
            ),
       'module' => 'exc',
       'xmi_mod' => 'loc',
       'force_var_itemkey' => 'loc_cd',
       'op_xmi_itemkey' => 'loc_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

$conf_field_excxmicat = 
   array(
       'field_id' => 'conf_field_excxmicat',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'exc_cd',
               'alias_type' => '1',
            ),
       'module' => 'cat',
       'xmi_mod' => 'exc',
       'force_var_itemkey' => 'exc_cd',
       'op_xmi_itemkey' => 'exc_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

$conf_field_illxmiloc = 
   array(
       'field_id' => 'conf_field_illxmiloc',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'ill_cd',
               'alias_type' => '1',
            ),
       'module' => 'loc',
       'xmi_mod' => 'ill',
       'force_var_itemkey' => 'ill_cd',
       'op_xmi_itemkey' => 'ill_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

$conf_field_phoxmicat = 
   array(
       'field_id' => 'conf_field_phoxmicat',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'pho_cd',
               'alias_type' => '1',
            ),
       'module' => 'cat',
       'xmi_mod' => 'pho',
       'force_var_itemkey' => 'pho_cd',
       'op_xmi_itemkey' => 'pho_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

$conf_field_phoxmiloc = 
   array(
       'field_id' => 'conf_field_phoxmiloc',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'pho_cd',
               'alias_type' => '1',
            ),
       'module' => 'loc',
       'xmi_mod' => 'pho',
       'force_var_itemkey' => 'pho_cd',
       'op_xmi_itemkey' => 'pho_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

$conf_field_locxmiill = 
   array(
       'field_id' => 'conf_field_locxmipho',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'loc_cd',
               'alias_type' => '1',
            ),
       'module' => 'ill',
       'xmi_mod' => 'loc',
       'force_var_itemkey' => 'loc_cd',
       'op_xmi_itemkey' => 'loc_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

$conf_field_locxmipho = 
   array(
       'field_id' => 'conf_field_locxmipho',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'loc_cd',
               'alias_type' => '1',
            ),
       'module' => 'pho',
       'xmi_mod' => 'loc',
       'force_var_itemkey' => 'loc_cd',
       'op_xmi_itemkey' => 'loc_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

$conf_field_locxmicat = 
   array(
       'field_id' => 'conf_field_locxmicat',
       'dataclass' => 'xmi',
       'classtype' => 'xmi_list',
       'aliasinfo' =>
            array(
               'alias_tbl' => 'cor_tbl_module',
               'alias_col' => 'itemkey',
               'alias_src_key' => 'loc_cd',
               'alias_type' => '1',
            ),
       'module' => 'cat',
       'xmi_mod' => 'loc',
       'force_var_itemkey' => 'loc_cd',
       'op_xmi_itemkey' => 'loc_cd',           
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $xmi_add_validation,
       'edt_validation' => $xmi_edt_validation
);

// FILES

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

// DATE FIELDS

$conf_field_pho_created =
    array(
        'field_id' => 'conf_field_pho_created',
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'pho_created',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);

$conf_field_ill_created =
    array(
        'field_id' => 'conf_field_ill_created',
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'ill_created',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);

$conf_field_loc_visited =
    array(
        'field_id' => 'conf_field_loc_visited',
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'loc_visited',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);

// ABK FIELDS

$conf_field_features =
    array(
        'field_id' => 'conf_field_features',
        'dataclass' => 'action',
        'classtype' => 'featured',
        'aliasinfo' => FALSE,
        'actors_mod' => 'abk',
        'actors_type' => 'people',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'displaytxt' => 'name',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_photograph =
    array(
        'field_id' => 'conf_field_photographer',
        'dataclass' => 'action',
        'classtype' => 'photographer',
        'aliasinfo' => FALSE,
        'actors_mod' => 'abk',
        'actors_type' => 'people',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'displaytxt' => 'name',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_illustration=
    array(
        'field_id' => 'conf_field_illustratior',
        'dataclass' => 'action',
        'classtype' => 'illustrator',
        'aliasinfo' => FALSE,
        'actors_mod' => 'abk',
        'actors_type' => 'people',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'displaytxt' => 'name',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_locs =
    array(
        'field_id' => 'conf_field_metsur_locs',
        'id' => 'metsur_locs',
        'dataclass' => 'geom',
        'module' => 'loc',
        'format' => 'WFS',
        'url' => 'http://'.$_SERVER['SERVER_NAME'].'/geoserver/MetSur/wfs?',
        'name' => 'metsur_locs',
        'projection' => "EPSG:900913",
        'op_layer'=> 'METSUR_loc_points_merged',
        'op_zoomtolayer' => FALSE,
        'op_serverType'=> 'geoserver',
        'op_query' => 'FALSE',
        'op_buffer' => '500'
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
        'aliasinfo' => array (
            'alias_tbl' => 'cor_tbl_col',
            'alias_col' => 'dbname',
            'alias_src_key' => 'delete',
            'alias_type' => '1' 
        ),
        'editable' => TRUE,
        'hidden' => TRUE,
        'del_validation' => $del_validation
);

?>
