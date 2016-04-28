<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/vd_settings.php
*
* Validation settings file for this version of ARK
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2012 L - P : Heritage LLP.
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
* @copyright  1999-2012 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/config/vd_settings.php
* @since      File available since Release 0.6
*/

/**
* VALIDATION
*   Each array sets up request and validation checks for each param needed by edtXxx()
*   You MUST therefore run at least one check for every var needed by the edtXxx func
*   You may set up as many validation checks for each var as you like
*   To see what each edtXxx function needs please see the documentation for that func
*   THESE ARE THE ARK-WIDE defaults. 
*   To run additional or alternative validation on a per form basis, set that up in the mod_settings
*
*   IMPORTANT: Stuff should be set in this order:
*      1 - Manual Stuff
*      2 - Session/Live stuff like 'constants': cre_by, ste_cd etc
*      3 - Requests for User defined vars eg form submitted stuff
*      4 - Compound items which rely on earlier stuff (eg Itemvalues that might need catting)
*/


// FIRST GENERIC STUFF USED BY MOST/MANY edtXxx() funcs

// 1 - Manual Stuff
// cre_on - request and chkSet
$vd_cre_on =
    array(
        'rq_func' => 'reqManual',
        'vd_func' => 'chkSet',
        'var_name' => 'cre_on',
        'force_var' => 'NOW()'
);
// log - request and chkSet
$vd_log =
    array(
        'rq_func' => 'reqManual',
        'vd_func' => 'chkSet',
        'var_name' => 'log',
        'force_var' => $conf_log_add
);
// 2 - Session/Live stuff
// cre_by - request and chkSet
$vd_cre_by = 
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'cre_by',
        'lv_name' => 'user_id',
        'var_locn' => 'live'
);
// lang - request and chkSet
$vd_live_lang = 
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'lang',
        'lv_name' => 'lang',
        'var_locn' => 'live'
);
// ste_cd - request and chkSet
$vd_ste_cd = array('rq_func' => 'reqMulti', 'vd_func' => 'chkSet', 'var_name' => 'ste_cd', 'lv_name' => 'ste_cd', 'var_locn' => 'session');
// 3 - Forms
// itemkey - request and chkSet
$vd_key =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'itemkey',
        'lv_name' => 'item_key',
        'var_locn' => 'live'
);
// 4 - Compound items
// frag_id - request and chkSet - needed on most edit routines
$vd_frag_id =
    array(
        'rq_func' => 'reqFragId',
        'vd_func' => 'chkSet',
        'var_name' => 'frag_id',
        'lv_name' => 'id',
        'var_locn' => 'request',
);


// SECOND STUFF SPECIFIC TO EACH CLASS

// edtItemKey()
// 1 - Manual Stuff
// none
// 2 - Session/Live stuff
// mod_short - request and chkSet
$key_vd_mod_short =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'mod_short',
        'lv_name' => 'mod_short',
        'var_locn' => 'live'
);
// itemkey - request and chkSet
$key_vd_mod_short =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'itemkey',
        'lv_name' => 'item_key',
        'var_locn' => 'live'
);
// 3 - Forms
// modtype - request and chkSet
$key_vd_modtype =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'modtype',
        'lv_name' => 'modtype',
        'var_locn' => 'request'
);
// 4 - Compound items
// itemval - request and chkSet
$key_vd_itemval_a =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);
// itemval - request and chkDuplicate
$key_vd_itemval_b =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkDuplicate',
        'var_name' => 'itemval',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);
// mod_no_val - request and chkSet
$key_vd_mod_no_val_a =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'mod_no_val',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'no'
);
// mod_no_val - request and chkNumeric
$key_vd_mod_no_val_b =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkNumeric',
        'var_name' => 'mod_no_val',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'no'
);

// add ItemKey default validation group
$key_add_validation =
    array(
        $vd_ste_cd,
        $key_vd_mod_short,
        $key_vd_itemval_a,
        $key_vd_itemval_b,
        $key_vd_mod_no_val_a,
        $key_vd_mod_no_val_b,
        $vd_cre_by,
        $vd_cre_on
);
$key_add_validation_loose =
    array(
        $vd_ste_cd,
        $key_vd_mod_short,
        $key_vd_itemval_a,
        $key_vd_itemval_b,
        $key_vd_mod_no_val_a,
        //$key_vd_mod_no_val_b,
        $vd_cre_by,
        $vd_cre_on
);

// edt ItemKey default validation group
$key_edt_validation =
    array(
        $vd_ste_cd,
        $key_vd_mod_short,
        $key_vd_itemval_a,
        $key_vd_mod_no_val_a,
        $vd_cre_by,
        $vd_cre_on,
        $vd_log
);

//modType
$modtype_add_validation = 
    array(
        $key_vd_modtype,
        $key_vd_mod_short,
        $key_vd_itemval_a,
        $vd_cre_by,
        $vd_cre_on
);

$modtype_edt_validation = 
    array(
        $key_vd_modtype,
        $key_vd_modtype,
        $key_vd_mod_short,
        $key_vd_itemval_a,
        $vd_cre_by,
        $vd_cre_on
);

// edtTxt()
// $txttype, $itemkey, $itemvalue, $txt, $lang, $cre_by, $cre_on, $type, $log
// 1 - Manual Stuff
// none
// 2 - Session/Live stuff
// none
// 3 - Forms
// txttype - request and chkSet
$txt_vd_txttype =
    array(
        'rq_func' => 'reqClassType',
        'vd_func' => 'chkSet',
        'var_name' => 'txttype',
        'lv_name' => 'classtype',
        'var_locn' => 'field'
);
// txt - request and chkSet
$txt_vd_txt =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSkipBlank',
        'var_name' => 'txt',
        'lv_name' => 'dyn_field',
        'var_locn' => 'request'
);
// txt - request and chkSet
$txt_vd_requiredtxt =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'txt',
        'lv_name' => 'dyn_field',
        'var_locn' => 'request'
);
// 4 - Compound items
// itemkey - request and chkSet
$txt_vd_key =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'itemkey',
        'lv_name' => 'item_key',
        'var_locn' => 'live'
);
// itemval - request and chkSet
$txt_vd_val =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);
// add txt default validation group
$txt_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $txt_vd_txttype,
        $txt_vd_txt,
        $txt_vd_key,
        $txt_vd_val,
        $vd_live_lang
);
// edt txt default validation group
$txt_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $txt_vd_txttype,
        $txt_vd_txt,
        $txt_vd_key,
        $txt_vd_val,
        $vd_frag_id,
        $vd_live_lang
);

// edtNumber()
// $numbertype, $itemkey, $itemvalue, $number, $lang, $cre_by, $cre_on, $type, $log
// 1 - Manual Stuff
// none
// 2 - Session/Live stuff
// none
// 3 - Forms
// numbertype - request and chkSet
$number_vd_numbertype =
    array(
        'rq_func' => 'reqClassType',
        'vd_func' => 'chkSet',
        'var_name' => 'numbertype',
        'lv_name' => 'classtype',
        'var_locn' => 'field'
);
// number - request and chkSet
$number_vd_number =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'number',
        'lv_name' => 'dyn_field',
        'var_locn' => 'request'
);
// 4 - Compound items
// itemkey - request and chkSet
$number_vd_key =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'itemkey',
        'lv_name' => 'item_key',
        'var_locn' => 'live'
);
// itemval - request and chkSet
$number_vd_val =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);
// add number default validation group
$number_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $number_vd_numbertype,
        $number_vd_number,
        $number_vd_key,
        $number_vd_val,
);
// edt number default validation group
$number_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $number_vd_numbertype,
        $number_vd_number,
        $number_vd_key,
        $number_vd_val,
        $vd_frag_id,
);


// edtDate()
// $datetype, $itemkey, $itemvalue, $date, $cre_by, $cre_on, $type, $log
// 1 - Manual Stuff
// none
// 2 - Session/Live stuff
// none
// 3 - Forms
// datetype - request and chkSet
$date_vd_datetype =
    array(
        'rq_func' => 'reqClassType',
        'vd_func' => 'chkSet',
        'var_name' => 'datetype',
        'lv_name' => 'classtype',
        'var_locn' => 'field'
);
// date - request and chkDate
$date_vd_date =
    array(
        'rq_func' => 'reqDate',
        'vd_func' => 'chkDate',
        'var_name' => 'date',
        'lv_name' => 'dyn_field',
        'var_locn' => 'request'
);
// date - request and chkSet
$date_vd_dateset =
    array(
        'rq_func' => 'reqDate',
        'vd_func' => 'chkDateSet',
        'var_name' => 'date',
        'lv_name' => 'dyn_field',
        'var_locn' => 'request'
);
// 4 - Compound items
// itemkey - request and chkSet
$date_vd_key =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'itemkey',
        'lv_name' => 'item_key',
        'var_locn' => 'live'
);
// itemval - request and chkSet
$date_vd_val =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);

// add date default validation group
$date_add_validation =
    array(
        $vd_cre_on,
        $vd_cre_by,
        $date_vd_datetype,
        $date_vd_date,
        $date_vd_dateset,
        $date_vd_key,
        $date_vd_val
);

// edt date default validation group
$date_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $date_vd_datetype,
        $date_vd_date,
        $date_vd_key,
        $vd_frag_id,
        $date_vd_val
);


// edtAction()
// $actiontype, $itemkey, $itemvalue, $actor, $cre_by, $cre_on, $type, $log)
// 1 - Manual Stuff
// none
// 2 - Session/Live stuff
// none
// 3 - Forms
// actiontype - request and chkSet
$action_vd_5 =
    array(
        'rq_func' => 'reqClassType',
        'vd_func' => 'chkSet',
        'var_name' => 'actiontype',
        'lv_name' => 'classtype',
        'var_locn' => 'field'
);
// actor itemkey
$action_vd_actor_itemkey =
    array(
        'rq_func' => 'reqManual',
        'vd_func' => 'chkSet',
        'var_name' => 'actor_itemkey',
        'force_var' => 'abk_cd'
);
// actor - request and chkSet
$action_vd_6 =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'actor',
        'lv_name' => 'dyn_field',
        'var_locn' => 'request'
);
// actor - request and chkSet
$action_vd_valid =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkAbk',
        'var_name' => 'actor',
        'lv_name' => 'dyn_field',
        'var_locn' => 'request'
);
//    compound form vars
$action_vd_7 =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'itemkey',
        'lv_name' => 'item_key',
        'var_locn' => 'live'
);
$action_vd_8 =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);
// add action default validation group
$action_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $action_vd_actor_itemkey,
        $action_vd_5,
        $action_vd_valid,
        $action_vd_6,
        $action_vd_7,
        $action_vd_8
);
// edt action default validation group
$action_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $action_vd_actor_itemkey,
        $action_vd_5,
        $action_vd_valid,
        $action_vd_6,
        $action_vd_7,
        $vd_frag_id,
        $action_vd_8
);

// edtAttr()
// 1 - Manual Stuff
// none
// 2 - Session/Live stuff
// none
// 3 - Forms
// attributetype - request and chkSet
$attr_vd_attributetype =
    array(
        'rq_func' => 'reqClassType',
        'vd_func' => 'chkSet',
        'var_name' => 'attributetype',
        'lv_name' => 'classtype',
        'var_locn' => 'field'
);
// attr - request and chkSet
$attr_vd_attribute =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'attribute',
        'lv_name' => 'dyn_field',
        'var_locn' => 'request'
);
// bv - request and chkSet
$attr_vd_bv =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'bv',
        'lv_name' => 'dyn_field_suffix',
        'var_locn' => 'request'
);
// 4 - Compound items
// itemkey - request and chkSet
$attr_vd_key =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'itemkey',
        'lv_name' => 'item_key',
        'var_locn' => 'live'
);
// itemval - request and chkSet
$attr_vd_val =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);
// add attr default validation group
$attr_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $attr_vd_attributetype,
        $attr_vd_attribute,
        $attr_vd_bv,
        $attr_vd_key,
        $attr_vd_val
);
// edt attr default validation group
$attr_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $attr_vd_attributetype,
        $attr_vd_attribute,
        $attr_vd_bv,
        $attr_vd_key,
        $attr_vd_val,
        $vd_frag_id
);

// edtSpan()
// 1 - Manual Stuff
// none
// 2 - Session/Live stuff
// none
// 3 - Forms
// spantype - request and chkSet
$span_vd_spantype =
    array(
        'rq_func' => 'reqClassType',
        'vd_func' => 'chkSet',
        'var_name' => 'spantype',
        'lv_name' => 'classtype',
        'var_locn' => 'field'
);
// daterange_beg - request and chkSet
$span_vd_dr_beg =
    array(
        'rq_func' => 'reqDateRange',
        'vd_func' => 'chkSet',
        'var_name' => 'beg',
        'lv_name' => 'beg',
        'var_locn' => 'request'
);
// daterange end - request and chkSet
$span_vd_dr_end =
    array(
        'rq_func' => 'reqDateRange',
        'vd_func' => 'chkSet',
        'var_name' => 'end',
        'lv_name' => 'end',
        'var_locn' => 'request'
);
// 4 - Compound items
// itemkey - request and chkSet
$span_vd_key =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'itemkey',
        'lv_name' => 'item_key',
        'var_locn' => 'live'
);
// itemval - request and chkSet
$span_vd_val =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);
// add span default validation group
$span_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $span_vd_spantype,
        $span_vd_dr_beg,
        $span_vd_dr_end,
        $span_vd_key,
        $span_vd_val
);
// edt span default validation group
$span_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_by,
        $span_vd_spantype,
        $span_vd_dr_beg,
        $span_vd_dr_end,
        $vd_frag_id
);

// edtXmi()
// 1 - Manual Stuff
// none
// 2 - Session/Live stuff
// none
// 3 - Forms

$xmi_vd_itemkey =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'itemkey',
        'lv_name' => 'item_key',
        'var_locn' => 'live'
);
$xmi_vd_itemval =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'itemval',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);

$xmi_vd_xmi_itemkey =
    array(
        'rq_func' => 'reqField',
        'vd_func' => 'chkSet',
        'var_name' => 'xmi_itemkey',
        'force_var' => 'op_xmi_itemkey'
      );

$xmi_vd_xmi_itemlist =
    array(
        'rq_func' => 'reqItemList',
        'vd_func' => 'chkItemListAllowBlank',
        'var_name' => 'xmi_list',
        'lv_name' => 'xmi_list',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);

// add xmi default validation group
$xmi_add_validation =
    array(
        $xmi_vd_itemkey,
        $xmi_vd_itemval,
        $xmi_vd_xmi_itemkey,
        $xmi_vd_xmi_itemlist,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_on,
        $vd_cre_by
);

// edt xmi default validation group
$xmi_edt_validation =
    array(
        $xmi_vd_itemkey,
        $xmi_vd_itemval,
        $xmi_vd_xmi_itemkey,
        $xmi_vd_xmi_itemlist,
        $vd_log,
        $vd_ste_cd,
        $vd_cre_on,
        $vd_cre_by
);

// DELETIONS
// 1 - Manual Stuff
// none
// 2 - Session/Live stuff
// none
// 3 - Forms

$del_vd_frag_id =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkSet',
        'var_name' => 'frag_id',
        'lv_name' => 'frag_id',
        'var_locn' => 'request'
);
$del_vd_frag_id_2 =
    array(
        'rq_func' => 'reqMulti',
        'vd_func' => 'chkChDown',
        'var_name' => 'frag_id',
        'lv_name' => 'frag_id',
        'var_locn' => 'request'
);
// add xmi default validation group
$del_validation =
    array(
        $del_vd_frag_id,
        $del_vd_frag_id_2,
        $vd_cre_on,
        $vd_cre_by
);

//for file uploads
// file - request and chkSet
 $file_vd_file =
   array(
       'rq_func' => 'reqMulti',
       'vd_func' => 'chkSkipBlank',
       'var_name' => 'file',
       'lv_name' => 'dyn_field',
       'var_locn' => 'request'
 );
 // file - request and chkSet
 $file_vd_requiredfile =
   array(
       'rq_func' => 'reqMulti',
       'vd_func' => 'chkSet',
       'var_name' => 'file',
       'lv_name' => 'dyn_field',
       'var_locn' => 'request'
 );
 // 4 - Compound items
 // itemkey - request and chkSet
 $file_vd_key =
   array(
       'rq_func' => 'reqMulti',
       'vd_func' => 'chkSet',
       'var_name' => 'itemkey',
       'lv_name' => 'item_key',
       'var_locn' => 'live'
 );
 // file - request and chkSet
 $file_vd_val =
   array(
       'rq_func' => 'reqItemVal',
       'vd_func' => 'chkSet',
       'var_name' => 'itemval',
       'lv_name' => 'itemval',
       'var_locn' => 'request',
       'req_keytype' => 'auto',
       'ret_keytype' => 'cd'
 );
 // add file default validation group
 $file_add_validation =
   array(
       $vd_cre_on,
       $vd_log,
       $vd_ste_cd,
       $vd_cre_by,
       $file_vd_file,
       $file_vd_key,
       $file_vd_val,
 );
 // edt file default validation group
 $file_edt_validation =
   array(
       $vd_cre_on,
       $vd_log,
       $vd_ste_cd,
       $vd_cre_by,
       $file_vd_file,
       $file_vd_key,
       $file_vd_val,
     //  $vd_frag_id,
 );

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
                 $vd_attrchainval,
         $vd_frag_id,
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
 // conf_field_cxtxmi has custom validation to allow us to skip linking contexts where sph's are not of contexts
 // add xmi default validation group
 $custom_xmi_add_validation =
     array(
         $xmi_vd_itemkey,
         $xmi_vd_itemval,
         $xmi_vd_xmi_itemkey,
         $vd_ste_cd,
         $vd_cre_on,
         $vd_cre_by
 );
 
?>