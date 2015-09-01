<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* settings.php
*
* stores settings for 'fields' for this ARK instance. This makes
* the fields available for use in any subform in any module
* anything module specific ought to be configured in that modules
* settings. Dues to parse order, you may re-use the names of fields
* and they will be overwritten by md specific settings.
*
* PHP versions 4 and 5
*
* LICENSE: INSERT ARK LICENCE HERE
*
* @category   base
* @package    ark
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2007 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @version    CVS: $Id:$
* @link       http://ark.lparchaeology.com/
* @since      0.6
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
* in addition, the following class specific vars may be used:
* class='action' - actors_dd = the element of the actors to show in the dd
* class='action' - actors_tbl = the table in which the actors are held
* class='action' - actors_style = whether actor information is displayed in a
* list style ('list') or as a single actor/date pairing ('single') 
*
*/

// VALIDATION
include('vd_settings.php');

//CUSTOM VALIDATION SETTINGS NEEDED FOR SOME FIELDS
$vd_chainkey =
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
$custom_date_add_vd =
    array(
        $vd_cre_on,
        $vd_cre_by,
        $date_vd_datetype,
        $date_vd_date,
        $date_vd_dateset,
        $vd_chainkey,
        $vd_chainval
);
$custom_date_edt_vd =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $date_vd_datetype,
        $date_vd_date,
        $vd_chainval,
        $vd_frag_id,
        $vd_chainval
);
$custom_action_add_vd =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $action_vd_actor_itemkey,
        $action_vd_5,
        $action_vd_valid,
        $action_vd_6,
        $vd_chainkey,
        $vd_chainval
);
$custom_action_edt_vd =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $action_vd_actor_itemkey,
        $action_vd_5,
        $action_vd_valid,
        $action_vd_6,
        $vd_chainval,
        $vd_frag_id,
        $vd_chainval
);

/**
*
* FIELDS
*
* These arrays contains the info about each field
* Make one array for each field to display each field MUST have the following vars:
*
* VARIABLES FOR FIELD SETUP
* Optional:
* dataclass = the data type contained in this field (action, attribute, date, 
* file, number, span, txt)
* classtype = the type within the class (txttype)
* alias_tbl = look-up-table for type, used in alias call (cor_lut_txttype)
* alias_col = column for type, used in alias call (txttype)
* alias_src_key = value in the type column, used in alias call (desc)
* alias_type = the alias_type for the alias call (1 is normal, 2 is against)
* editable = set TRUE to process this field in forms set FALSE for display only
* hidden = set TRUE to make the field hidden
* add_validation = validation rules for this field when on an add routine
* edt_validation = validation rules for this field when on an edt routine
*
* Class - specific variables
* class='action' - actors_dd = the element of the actors to show in the dd
* class='action' - actors_tbl = the table in which the actors are held
* class='action' - actors_style = whether actor information is displayed in a
* list style ('list') or as a single actor/date pairing ('single') 
*/

// -- TEXT FIELDS -- //

// MODULE SPECIFIC FIELDS

// FOR THE Address book

$conf_field_name =
    array(
        'field_id' => 'conf_field_name',              
        'dataclass' => 'txt',
        'classtype' => 'name',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'name',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'initials',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

// FOR THE CXT MODULE

$conf_field_recflag =
    array(
        'dataclass' => 'attribute',
        'classtype' => 'recflag',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'recflag',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_interp =
    array(
        'field_id' => 'conf_field_interp',              
        'dataclass' => 'txt',
        'classtype' => 'interp',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'interp',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_note =
    array(
        'field_id' => 'conf_field_note',              
        'dataclass' => 'txt',
        'classtype' => 'note',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'note',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'short_desc',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_sutype =
    array(
        'field_id' => 'conf_field_sutype',              
        'dataclass' => 'txt',
        'classtype' => 'sutype',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'sutype',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'compac',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_stone =
    array(
        'field_id' => 'conf_field_stone',              
        'dataclass' => 'txt',
        'classtype' => 'stone',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'stone',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'colour',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'compo',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'dims',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'orient',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'definition',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_critofdistinction =
    array(
        'field_id' => 'conf_field_critofdistinction',              
        'dataclass' => 'txt',
        'classtype' => 'critofdistinction',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'critofdistinction',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_formation =
    array(
        'field_id' => 'conf_field_formation',              
        'dataclass' => 'txt',
        'classtype' => 'formation',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'formation',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_geocomponents =
    array(
        'field_id' => 'conf_field_geocomponents',              
        'dataclass' => 'txt',
        'classtype' => 'geocomponents',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'geocomponents',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_orgcomponents =
    array(
        'field_id' => 'conf_field_orgcomponents',              
        'dataclass' => 'txt',
        'classtype' => 'orgcomponents',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'orgcomponents',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_artcomponents =
    array(
        'field_id' => 'conf_field_artcomponents',              
        'dataclass' => 'txt',
        'classtype' => 'artcomponents',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'artcomponents',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_desc =
    array(
        'field_id' => 'conf_field_desc',              
        'dataclass' => 'txt',
        'classtype' => 'desc',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'desc',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'observ',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'excavtech',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_conservation =
    array(
        'field_id' => 'conf_field_conservation',              
        'dataclass' => 'txt',
        'classtype' => 'conservation',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'conservation',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_static =
    array(
        'field_id' => 'conf_field_static',              
        'dataclass' => 'txt',
        'classtype' => 'static',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'static',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_tech =
    array(
        'field_id' => 'conf_field_tech',              
        'dataclass' => 'txt',
        'classtype' => 'tech',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'tech',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_finition =
    array(
        'field_id' => 'conf_field_finition',              
        'dataclass' => 'txt',
        'classtype' => 'finition',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'finition',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_reuse =
    array(
        'field_id' => 'conf_field_reuse',              
        'dataclass' => 'txt',
        'classtype' => 'reuse',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'reuse',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_misenoeuvre =
    array(
        'field_id' => 'conf_field_misenoeuvre',              
        'dataclass' => 'txt',
        'classtype' => 'misenoeuvre',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'misenoeuvre',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_chronoelem =
    array(
        'field_id' => 'conf_field_chronoelem',              
        'dataclass' => 'txt',
        'classtype' => 'chronoelem',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'chronoelem',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_interp_date =
    array(
        'field_id' => 'conf_field_interp_date',              
        'dataclass' => 'txt',
        'classtype' => 'interp_date',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'interp_date',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_interp_period =
    array(
        'field_id' => 'conf_field_interp_period',              
        'dataclass' => 'txt',
        'classtype' => 'interp_period',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'interp_period',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_phase =
    array(
        'field_id' => 'conf_field_phase',              
        'dataclass' => 'txt',
        'classtype' => 'phase',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'phase',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_strat_reliability =
    array(
        'field_id' => 'conf_field_strat_reliability',              
        'dataclass' => 'txt',
        'classtype' => 'strat_reliability',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'strat_reliability',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_num_courses =
    array(
        'field_id' => 'conf_field_num_courses',              
        'dataclass' => 'txt',
        'classtype' => 'num_courses',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'num_courses',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_mortar =
    array(
        'field_id' => 'conf_field_mortar',              
        'dataclass' => 'txt',
        'classtype' => 'mortar',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'mortar',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_bricks =
    array(
        'field_id' => 'conf_field_bricks',              
        'dataclass' => 'txt',
        'classtype' => 'bricks',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'bricks',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_h_mortar =
    array(
        'field_id' => 'conf_field_h_mortar',              
        'dataclass' => 'txt',
        'classtype' => 'h_mortar',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'h_mortar',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_cons_mortar =
    array(
        'field_id' => 'conf_field_cons_mortar',              
        'dataclass' => 'txt',
        'classtype' => 'cons_mortar',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'cons_mortar',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_h_courses =
    array(
        'field_id' => 'conf_field_h_courses',              
        'dataclass' => 'txt',
        'classtype' => 'h_courses',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'h_courses',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_col_ssu =
    array(
        'field_id' => 'conf_field_col_ssu',              
        'dataclass' => 'txt',
        'classtype' => 'col_ssu',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'col_ssu',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_h_5courses =
    array(
        'field_id' => 'conf_field_h_5courses',              
        'dataclass' => 'txt',
        'classtype' => 'h_5courses',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'h_5courses',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_aggregates =
    array(
        'field_id' => 'conf_field_aggregates',              
        'dataclass' => 'txt',
        'classtype' => 'aggregates',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'aggregates',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'inclusions',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_totlength =
    array(
        'field_id' => 'conf_field_totlength',              
        'dataclass' => 'txt',
        'classtype' => 'totlength',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'totlength',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_wshould =
    array(
        'field_id' => 'conf_field_wshould',              
        'dataclass' => 'txt',
        'classtype' => 'wshould',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'wshould',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_lspine =
    array(
        'field_id' => 'conf_field_lspine',              
        'dataclass' => 'txt',
        'classtype' => 'lspine',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'lspine',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_wpelvis =
    array(
        'field_id' => 'conf_field_wpelvis',              
        'dataclass' => 'txt',
        'classtype' => 'wpelvis',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'wpelvis',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_condition =
    array(
        'field_id' => 'conf_field_condition',              
        'dataclass' => 'txt',
        'classtype' => 'condition',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'condition',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_posn_cranium =
    array(
        'field_id' => 'conf_field_posn_cranium',              
        'dataclass' => 'txt',
        'classtype' => 'posn_cranium',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'posn_cranium',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_posn_arm =
    array(
        'field_id' => 'conf_field_posn_arm',              
        'dataclass' => 'txt',
        'classtype' => 'posn_arm',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'posn_arm',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_posn_leg =
    array(
        'field_id' => 'conf_field_posn_leg',              
        'dataclass' => 'txt',
        'classtype' => 'posn_leg',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'posn_leg',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_pospelvis =
    array(
        'field_id' => 'conf_field_pospelvis',              
        'dataclass' => 'txt',
        'classtype' => 'pospelvis',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'pospelvis',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_age =
    array(
        'field_id' => 'conf_field_age',              
        'dataclass' => 'txt',
        'classtype' => 'age',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'age',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_sex =
    array(
        'field_id' => 'conf_field_sex',              
        'dataclass' => 'txt',
        'classtype' => 'sex',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'sex',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

// FOR POTTERY DETAILS FOR CERAMICS INVENTORY

$conf_field_total =
    array(
        'field_id' => 'conf_field_total',              
        'dataclass' => 'number',
        'classtype' => 'total',
        'alias_tbl' => 'cor_lut_numbertype',
        'alias_col' => 'numbertype',
        'alias_src_key' => 'total',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_certype =
    array(
        'field_id' => 'conf_field_certype',              
        'dataclass' => 'attribute',
        'classtype' => 'certype',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'certype',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_potterynotes =
    array(
        'field_id' => 'conf_field_potterynotes',              
        'dataclass' => 'txt',
        'classtype' => 'potterynotes',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'potterynotes',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

//FOR ANTHROPOLOGICAL SCHEDE OF HRU RECORDS

$conf_field_gravetype =
    array(
        'field_id' => 'conf_field_gravetype',              
        'dataclass' => 'txt',
        'classtype' => 'gravetype',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'gravetype',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_gravecover =
    array(
        'field_id' => 'conf_field_gravecover',              
        'dataclass' => 'txt',
        'classtype' => 'gravecover',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'gravecover',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_assocfinds =
    array(
        'field_id' => 'conf_field_assocfinds',              
        'dataclass' => 'txt',
        'classtype' => 'assocfinds',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'assocfinds',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_hrusex =
    array(
        'field_id' => 'conf_field_hrusex',              
        'dataclass' => 'attribute',
        'classtype' => 'hrusex',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'hrusex',
        'alias_type' => '1',
        'op_display_mode' => 'radio',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_sexdiagnostic =
    array(
        'field_id' => 'conf_field_sexdiagnostic',              
        'dataclass' => 'txt',
        'classtype' => 'sexdiagnostic',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'sexdiagnostic',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_hruage =
    array(
        'field_id' => 'conf_field_hruage',              
        'dataclass' => 'attribute',
        'classtype' => 'hruage',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'hruage',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_agediagnostic =
    array(
        'field_id' => 'conf_field_agediagnostic',              
        'dataclass' => 'txt',
        'classtype' => 'agediagnostic',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'agediagnostic',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_hrudeposition =
    array(
        'field_id' => 'conf_field_hrudeposition',              
        'dataclass' => 'attribute',
        'classtype' => 'hrudeposition',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'hrudeposition',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_deposnature =
    array(
        'field_id' => 'conf_field_deposnature',              
        'dataclass' => 'txt',
        'classtype' => 'deposnature',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'deposnature',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


$conf_field_hruposition =
    array(
        'field_id' => 'conf_field_hruposition',              
        'dataclass' => 'attribute',
        'classtype' => 'hruposition',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'hruposition',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_temporo =
    array(
        'field_id' => 'conf_field_temporo',              
        'dataclass' => 'attribute',
        'classtype' => 'temporo',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'temporo',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_cranio =
    array(
        'field_id' => 'conf_field_cranio',              
        'dataclass' => 'attribute',
        'classtype' => 'cranio',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'cranio',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_atlante =
    array(
        'field_id' => 'conf_field_atlante',              
        'dataclass' => 'attribute',
        'classtype' => 'atlante',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'atlante',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_epistrofeo =
    array(
        'field_id' => 'conf_field_epistrofeo',              
        'dataclass' => 'attribute',
        'classtype' => 'epistrofeo',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'epistrofeo',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_posn_cranium =
    array(
        'field_id' => 'conf_field_posn_cranium',              
        'dataclass' => 'txt',
        'classtype' => 'posn_cranium',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'posn_cranium',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_uppersx =
    array(
        'field_id' => 'conf_field_uppersx',              
        'dataclass' => 'txt',
        'classtype' => 'uppersx',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'uppersx',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_handsx =
    array(
        'field_id' => 'conf_field_handsx',              
        'dataclass' => 'txt',
        'classtype' => 'handsx',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'handsx',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_upperdx =
    array(
        'field_id' => 'conf_field_upperdx',              
        'dataclass' => 'txt',
        'classtype' => 'upperdx',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'upperdx',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


$conf_field_handdx =
    array(
        'field_id' => 'conf_field_handdx',              
        'dataclass' => 'txt',
        'classtype' => 'handdx',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'handdx',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


$conf_field_lowersx =
    array(
        'field_id' => 'conf_field_lowersx',              
        'dataclass' => 'txt',
        'classtype' => 'lowersx',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'lowersx',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_lowerdx =
    array(
        'field_id' => 'conf_field_lowerdx',              
        'dataclass' => 'txt',
        'classtype' => 'lowerdx',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'lowerdx',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


$conf_field_posn_observations =
    array(
        'field_id' => 'conf_field_observations',              
        'dataclass' => 'txt',
        'classtype' => 'posn_observations',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'posn_observations',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_effectsdecomp =
    array(
        'field_id' => 'conf_field_effectsdecomp',              
        'dataclass' => 'attribute',
        'classtype' => 'effectsdecomp',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'effectsdecomp',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_thorax =
    array(
        'field_id' => 'conf_field_thorax',              
        'dataclass' => 'txt',
        'classtype' => 'thorax',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'thorax',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_sunkensternum =
    array(
        'field_id' => 'conf_field_sunkensternum',              
        'dataclass' => 'txt',
        'classtype' => 'sunkensternum',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'sunkensternum',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_pelvis =
    array(
        'field_id' => 'conf_field_pelvis',              
        'dataclass' => 'txt',
        'classtype' => 'pelvis',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'pelvis',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_kneedecomp =
    array(
        'field_id' => 'conf_field_kneedecomp',              
        'dataclass' => 'txt',
        'classtype' => 'kneedecomp',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'kneedecomp',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_ankledecomp =
    array(
        'field_id' => 'conf_field_ankledecomp',              
        'dataclass' => 'txt',
        'classtype' => 'ankledecomp',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'ankledecomp',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_vertclavicle =
    array(
        'field_id' => 'conf_field_vertclavicle',              
        'dataclass' => 'txt',
        'classtype' => 'vertclavicle',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'vertclavicle',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_obscapula =
    array(
        'field_id' => 'conf_field_obscapula',              
        'dataclass' => 'txt',
        'classtype' => 'obscapula',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'obscapula',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_medhumerus =
    array(
        'field_id' => 'conf_field_medhumerus',              
        'dataclass' => 'txt',
        'classtype' => 'medhumerus',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'medhumerus',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_latfemur =
    array(
        'field_id' => 'conf_field_latfemur',              
        'dataclass' => 'txt',
        'classtype' => 'latfemur',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'latfemur',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_deposprocesses =
    array(
        'field_id' => 'conf_field_deposprocesses',              
        'dataclass' => 'txt',
        'classtype' => 'deposprocesses',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'deposprocesses',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_causecompression =
    array(
        'field_id' => 'conf_field_causecompression',              
        'dataclass' => 'txt',
        'classtype' => 'causecompression',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'causecompression',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_decomposition =
    array(
        'field_id' => 'conf_field_decomposition',              
        'dataclass' => 'attribute',
        'classtype' => 'decomposition',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'decomposition',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_totlength =
    array(
        'field_id' => 'conf_field_totlength',              
        'dataclass' => 'txt',
        'classtype' => 'totlength',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'totlength',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_clavicle =
    array(
        'field_id' => 'conf_field_clavicle',              
        'dataclass' => 'number',
        'classtype' => 'clavicle',
        'alias_tbl' => 'cor_lut_numbertype',
        'alias_col' => 'numbertype',
        'alias_src_key' => 'clavicle',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_humerus =
    array(
        'field_id' => 'conf_field_humerus',              
        'dataclass' => 'number',
        'classtype' => 'humerus',
        'alias_tbl' => 'cor_lut_numbertype',
        'alias_col' => 'numbertype',
        'alias_src_key' => 'humerus',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);
$conf_field_radius =
    array(
        'field_id' => 'conf_field_radius',              
        'dataclass' => 'number',
        'classtype' => 'radius',
        'alias_tbl' => 'cor_lut_numbertype',
        'alias_col' => 'numbertype',
        'alias_src_key' => 'radius',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);
$conf_field_tibia =
    array(
        'field_id' => 'conf_field_tibia',              
        'dataclass' => 'number',
        'classtype' => 'tibia',
        'alias_tbl' => 'cor_lut_numbertype',
        'alias_col' => 'numbertype',
        'alias_src_key' => 'tibia',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);
$conf_field_femur =
    array(
        'field_id' => 'conf_field_femur',              
        'dataclass' => 'number',
        'classtype' => 'femur',
        'alias_tbl' => 'cor_lut_numbertype',
        'alias_col' => 'numbertype',
        'alias_src_key' => 'femur',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $number_add_validation,
        'edt_validation' => $number_edt_validation
);

$conf_field_cervical =
    array(
        'field_id' => 'conf_field_cervical',              
        'dataclass' => 'attribute',
        'classtype' => 'cervical',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'cervical',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_dishandsx =
    array(
        'field_id' => 'conf_field_dishandsx',              
        'dataclass' => 'attribute',
        'classtype' => 'dishandsx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'dishandsx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_dishanddx =
    array(
        'field_id' => 'conf_field_dishanddx',              
        'dataclass' => 'attribute',
        'classtype' => 'dishanddx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'dishanddx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_disfootsx =
    array(
        'field_id' => 'conf_field_disfootsx',              
        'dataclass' => 'attribute',
        'classtype' => 'disfootsx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'disfootsx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);


$conf_field_disfootdx =
    array(
        'field_id' => 'conf_field_disfootdx',              
        'dataclass' => 'attribute',
        'classtype' => 'disfootdx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'disfootdx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);


$conf_field_scapulasx =
    array(
        'field_id' => 'conf_field_scapulasx',              
        'dataclass' => 'attribute',
        'classtype' => 'scapulasx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'scapulasx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_scapuladx =
    array(
        'field_id' => 'conf_field_scapuladx',              
        'dataclass' => 'attribute',
        'classtype' => 'scapuladx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'scapuladx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_atlanto =
    array(
        'field_id' => 'conf_field_atlanto',              
        'dataclass' => 'attribute',
        'classtype' => 'atlanto',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'atlanto',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_lumbar =
    array(
        'field_id' => 'conf_field_lumbar',              
        'dataclass' => 'attribute',
        'classtype' => 'lumbar',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'lumbar',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_lumsacrum =
    array(
        'field_id' => 'conf_field_lumsacrum',              
        'dataclass' => 'attribute',
        'classtype' => 'lumsacrum',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'lumsacrum',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_sacrumsx =
    array(
        'field_id' => 'conf_field_sacrumsx',              
        'dataclass' => 'attribute',
        'classtype' => 'sacrumsx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'sacrumsx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_sacrumdx =
    array(
        'field_id' => 'conf_field_sacrumdx',              
        'dataclass' => 'attribute',
        'classtype' => 'sacrumdx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'sacrumdx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_kneesx =
    array(
        'field_id' => 'conf_field_kneesx',              
        'dataclass' => 'attribute',
        'classtype' => 'kneesx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'kneesx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_kneedx =
    array(
        'field_id' => 'conf_field_kneedx',              
        'dataclass' => 'attribute',
        'classtype' => 'kneedx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'kneedx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_anklesx =
    array(
        'field_id' => 'conf_field_anklesx',              
        'dataclass' => 'attribute',
        'classtype' => 'anklesx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'anklesx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_ankledx =
    array(
        'field_id' => 'conf_field_ankledx',              
        'dataclass' => 'attribute',
        'classtype' => 'ankledx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'ankledx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_tarsalsx =
    array(
        'field_id' => 'conf_field_tarsalsx',              
        'dataclass' => 'attribute',
        'classtype' => 'tarsalsx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'tarsalsx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_tarsaldx =
    array(
        'field_id' => 'conf_field_tarsaldx',              
        'dataclass' => 'attribute',
        'classtype' => 'tarsaldx',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'tarsaldx',
        'op_display_mode' => 'radio',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);


// FIELDS FOR THE SPF MODULE

$conf_field_damage =
    array(
        'field_id' => 'conf_field_damage',              
        'dataclass' => 'attribute',
        'classtype' => 'damage',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'damage',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_spfcondition =
    array(
        'field_id' => 'conf_field_spfcondition',              
        'dataclass' => 'attribute',
        'classtype' => 'condition',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'condition',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_work =
    array(
        'field_id' => 'conf_field_work',              
        'dataclass' => 'attribute',
        'classtype' => 'work',
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'work',
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_attributetype',
        'alias_col' => 'attributetype',
        'alias_src_key' => 'priority',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $attr_add_validation,
        'edt_validation' => $attr_edt_validation
);

$conf_field_material =
    array(
        'field_id' => 'conf_field_material',              
        'dataclass' => 'txt',
        'classtype' => 'material',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'material',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_cons_int =
    array(
        'field_id' => 'conf_field_cons_int',              
        'dataclass' => 'txt',
        'classtype' => 'cons_int',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'cons_int',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_storage =
    array(
        'field_id' => 'conf_field_storage',              
        'dataclass' => 'txt',
        'classtype' => 'storage',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'storage',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


//FOR MOD AEL


$conf_field_amount =
    array(
        'field_id' => 'conf_field_amount',              
        'dataclass' => 'txt',
        'classtype' => 'amount',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'amount',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


$conf_field_length =
    array(
        'field_id' => 'conf_field_length',              
        'dataclass' => 'txt',
        'classtype' => 'length',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'length',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


$conf_field_height =
    array(
        'field_id' => 'conf_field_height',              
        'dataclass' => 'txt',
        'classtype' => 'height',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'height',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


$conf_field_width =
    array(
        'field_id' => 'conf_field_width',              
        'dataclass' => 'txt',
        'classtype' => 'width',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'width',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


$conf_field_depth =
    array(
        'field_id' => 'conf_field_depth',              
        'dataclass' => 'txt',
        'classtype' => 'depth',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'depth',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


$conf_field_slength =
    array(
        'field_id' => 'conf_field_length',              
        'dataclass' => 'txt',
        'classtype' => 'slength',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'slength',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


$conf_field_thick =
    array(
        'field_id' => 'conf_field_thick',              
        'dataclass' => 'txt',
        'classtype' => 'thick',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'thick',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);


//FOR MOD CNS

$conf_field_denomination =
    array(
        'field_id' => 'conf_field_denomination',              
        'dataclass' => 'txt',
        'classtype' => 'denomination',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'denomination',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_obverse =
    array(
        'field_id' => 'conf_field_obverse',              
        'dataclass' => 'txt',
        'classtype' => 'obverse',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'obverse',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_reverse =
    array(
        'field_id' => 'conf_field_reverse',              
        'dataclass' => 'txt',
        'classtype' => 'reverse',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'reverse',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_diameter =
    array(
        'field_id' => 'conf_field_diameter',              
        'dataclass' => 'txt',
        'classtype' => 'diameter',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'diameter',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_weight =
    array(
        'field_id' => 'conf_field_weight',              
        'dataclass' => 'txt',
        'classtype' => 'weight',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'weight',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_metal =
    array(
        'field_id' => 'conf_field_metal',              
        'dataclass' => 'txt',
        'classtype' => 'metal',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'metal',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_date =
    array(
        'field_id' => 'conf_field_date',              
        'dataclass' => 'txt',
        'classtype' => 'date',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'date',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_reference =
    array(
        'field_id' => 'conf_field_reference',              
        'dataclass' => 'txt',
        'classtype' => 'reference',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'reference',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

$conf_field_mint =
    array(
        'field_id' => 'conf_field_mint',              
        'dataclass' => 'txt',
        'classtype' => 'mint',
        'alias_tbl' => 'cor_lut_txttype',
        'alias_col' => 'txttype',
        'alias_src_key' => 'mint',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $txt_add_validation,
        'edt_validation' => $txt_edt_validation
);

//FILE FIELDS

 $conf_field_images =
   array(
       'field_id' => 'conf_field_images',             
       'dataclass' => 'file',
       'classtype' => 'images',
       'alias_tbl' => 'cor_lut_filetype',
       'alias_col' => 'filetype',
       'alias_src_key' => 'images',
       'alias_type' => '1',
       'editable' => TRUE,
       'hidden' => FALSE,
       'add_validation' => $file_add_validation,
       'edt_validation' => $file_edt_validation
 );


// SPAN FIELDS

$conf_field_relto =
    array(
        'dataclass' => 'span',
        'classtype' => 'relatedto',
        'alias_tbl' => 'cor_lut_spantype',
        'alias_col' => 'spantype',
        'alias_src_key' => 'relatedto',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $span_add_validation,
        'edt_validation' => $span_edt_validation
);

$conf_field_sameas =
    array(
        'dataclass' => 'span',
        'classtype' => 'sameas',
        'alias_tbl' => 'cor_lut_spantype',
        'alias_col' => 'spantype',
        'alias_src_key' => 'sameas',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $span_add_validation,
        'edt_validation' => $span_edt_validation
);

$conf_field_comparanda =
    array(
        'dataclass' => 'span',
        'classtype' => 'comparanda',
        'alias_tbl' => 'cor_lut_spantype',
        'alias_col' => 'spantype',
        'alias_src_key' => 'comparanda',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $span_add_validation,
        'edt_validation' => $span_edt_validation
);

$conf_field_aelcomparanda =
    array(
        'dataclass' => 'span',
        'classtype' => 'aelcomparanda',
        'alias_tbl' => 'cor_lut_spantype',
        'alias_col' => 'spantype',
        'alias_src_key' => 'aelcomparanda',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $span_add_validation,
        'edt_validation' => $span_edt_validation
);

$conf_field_daterange =
    array(
        'dataclass' => 'span',
        'classtype' => 'daterange',
        'alias_tbl' => 'cor_lut_spantype',
        'alias_col' => 'spantype',
        'alias_src_key' => 'daterange',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $span_add_validation,
        'edt_validation' => $span_edt_validation,
        'field_op_label' => TRUE,
        'field_op_divider' => ' - ',
        'field_op_modifier' => TRUE
);


//DATE AND ACTION FIELDS

$conf_field_issuedto = 
    array(
        'field_id' => 'conf_field_issuedto',              
        'dataclass' => 'action',
        'classtype' => 'issuedto',
        'alias_tbl' => 'cor_lut_actiontype',
        'alias_col' => 'actiontype',
        'alias_src_key' => 'issuedto',
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'single',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_issuedon =
    array(
        'field_id' => 'conf_field_issuedon',              
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'issuedon',
        'alias_tbl' => 'cor_lut_datetype',
        'alias_col' => 'datetype',
        'alias_src_key' => 'issuedon',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);


$conf_field_registeredby = 
    array(
        'field_id' => 'conf_field_registeredby',              
        'dataclass' => 'action',
        'classtype' => 'registeredby',
        'alias_tbl' => 'cor_lut_actiontype',
        'alias_col' => 'actiontype',
        'alias_src_key' => 'registeredby',
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'single',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_registeredon =
    array(
        'field_id' => 'conf_field_registeredon',              
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'registeredon',
        'alias_tbl' => 'cor_lut_datetype',
        'alias_col' => 'datetype',
        'alias_src_key' => 'registeredon',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);

$conf_field_drawnby = 
    array(
        'field_id' => 'conf_field_drawnby',              
        'dataclass' => 'action',
        'classtype' => 'drawnby',
        'alias_tbl' => 'cor_lut_actiontype',
        'alias_col' => 'actiontype',
        'alias_src_key' => 'drawnby',
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'single',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_datetype',
        'alias_col' => 'datetype',
        'alias_src_key' => 'drawnon',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);

$conf_field_takenby = 
    array(
        'field_id' => 'conf_field_takenby',              
        'dataclass' => 'action',
        'classtype' => 'takenby',
        'alias_tbl' => 'cor_lut_actiontype',
        'alias_col' => 'actiontype',
        'alias_src_key' => 'takenby',
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'single',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'alias_type' => '1',
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
        'alias_tbl' => 'cor_lut_datetype',
        'alias_col' => 'datetype',
        'alias_src_key' => 'takenon',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
); 
    
$conf_field_supervisedby = 
    array(
        'field_id' => 'conf_field_supervisedby',              
        'dataclass' => 'action',
        'classtype' => 'supervisedby',
        'alias_tbl' => 'cor_lut_actiontype',
        'alias_col' => 'actiontype',
        'alias_src_key' => 'supervisedby',
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_excavatedon =
    array(
        'field_id' => 'conf_field_excavatedon',              
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'excavatedon',
        'alias_tbl' => 'cor_lut_datetype',
        'alias_col' => 'datetype',
        'alias_src_key' => 'excavatedon',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);

$conf_field_enteredon =
    array(
        'field_id' => 'conf_field_enteredon',              
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'enteredon',
        'alias_tbl' => 'cor_lut_datetype',
        'alias_col' => 'datetype',
        'alias_src_key' => 'enteredon',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);

$conf_field_enteredby = 
    array(
        'field_id' => 'conf_field_enteredby',              
        'dataclass' => 'action',
        'classtype' => 'enteredby',
        'alias_tbl' => 'cor_lut_actiontype',
        'alias_col' => 'actiontype',
        'alias_src_key' => 'enteredby',
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_directedby = 
    array(
        'field_id' => 'conf_field_directedby',              
        'dataclass' => 'action',
        'classtype' => 'directedby',
        'alias_tbl' => 'cor_lut_actiontype',
        'alias_col' => 'actiontype',
        'alias_src_key' => 'directedby',
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_restoredby = 
    array(
        'field_id' => 'conf_field_restoredby',              
        'dataclass' => 'action',
        'classtype' => 'restoredby',
        'alias_tbl' => 'cor_lut_actiontype',
        'alias_col' => 'actiontype',
        'alias_src_key' => 'restoredby',
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_recordedby = 
    array(
        'field_id' => 'conf_field_recordedby',              
        'dataclass' => 'action',
        'classtype' => 'recordedby',
        'alias_tbl' => 'cor_lut_actiontype',
        'alias_col' => 'actiontype',
        'alias_src_key' => 'recordedby',
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $action_add_validation,
        'edt_validation' => $action_edt_validation
);

$conf_field_recordedon =
    array(
        'field_id' => 'conf_field_recordedon',              
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'recordedon',
        'alias_tbl' => 'cor_lut_datetype',
        'alias_col' => 'datetype',
        'alias_src_key' => 'recordedon',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $date_add_validation,
        'edt_validation' => $date_edt_validation
);
    
$conf_field_interpretedon =
    array(
        'field_id' => 'conf_field_interpretedon',              
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'interpretedon',
        'alias_tbl' => 'cor_lut_datetype',
        'alias_col' => 'datetype',
        'alias_src_key' => 'interpretedon',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $custom_date_add_vd,
        'edt_validation' => $custom_date_edt_vd
);

$conf_field_notedon =
    array(
        'field_id' => 'conf_field_notedon',              
        'dataclass' => 'date',
        'datestyle' => 'dd,mm,yr',
        'classtype' => 'notedon',
        'alias_tbl' => 'cor_lut_datetype',
        'alias_col' => 'datetype',
        'alias_src_key' => 'notedon',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $custom_date_add_vd,
        'edt_validation' => $custom_date_edt_vd
);
    
$conf_field_interpretedby = 
    array(
        'field_id' => 'conf_field_interpretedby',          
        'dataclass' => 'action',
        'classtype' => 'interpretedby',
        'alias_tbl' => 'cor_lut_actiontype',
        'alias_col' => 'actiontype',
        'alias_src_key' => 'interpretedby',
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $custom_action_add_vd,
        'edt_validation' => $custom_action_edt_vd
);

$conf_field_notedby = 
    array(
        'field_id' => 'conf_field_notedby',              
        'dataclass' => 'action',
        'classtype' => 'notedby',
        'alias_tbl' => 'cor_lut_actiontype',
        'alias_col' => 'actiontype',
        'alias_src_key' => 'notedby',
        'actors_mod' => 'abk',
        'actors_element' => 'name',
        'actors_style' => 'list',
        'actors_elementclass' => 'txt',
        'actors_grp' => FALSE,
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $custom_action_add_vd,
        'edt_validation' => $custom_action_edt_vd
);    

/** EVENT FIELDS 
* Event fields are effectively wrappers for action/date fields.  All fields
* must be set up above.
*
* One can also use actions and dates without having the event wrapper, but this
* allows one to group multiple events into a single subform.
*/

$conf_event_directed = 
    array(
        'type' => 'directed',
        'date' => FALSE,
        'action' => $conf_field_directedby
);

$conf_event_supervised = 
    array(
        'type' => 'supervised',
        'date' => FALSE,
        'action' => $conf_field_supervisedby
);

$conf_event_excavated = 
    array(
        'type' => 'excavated',
        'date' => $conf_field_excavatedon,
        'action' => FALSE
);

$conf_event_entered = 
    array(
        'type' => 'entered',
        'date' => $conf_field_enteredon,
        'action' => $conf_field_enteredby
);

$conf_event_registered = 
    array(
        'type' => 'registered',
        'date' => $conf_field_registeredon,
        'action' => $conf_field_registeredby
);

$conf_event_restored = 
    array(
        'type' => 'restored',
        'date' => FALSE,
        'action' => $conf_field_restoredby
);

$conf_event_issued = 
    array(
        'type' => 'issued',
        'date' => $conf_field_issuedon,
        'action' => $conf_field_issuedto,
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

$conf_event_recorded = 
    array(
        'type' => 'drawn',
        'date' => $conf_field_recordedon,
        'action' => $conf_field_recordedby
);
    
//OPTION FIELDS
    
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
 
 $conf_reg_op_no_enter = 
 array(
        'dataclass' => 'op',
        'classtype' => 'none',
        'options' => 'view,qed',
        'editable' => FALSE,
        'hidden' => FALSE
);

 $conf_reg_op_qed_only = 
 array(
        'dataclass' => 'op',
        'classtype' => 'none',
        'options' => 'qed',
        'editable' => FALSE,
        'hidden' => FALSE
);

 $conf_reg_op_view_only = 
 array(
        'dataclass' => 'op',
        'classtype' => 'none',
        'options' => 'view',
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