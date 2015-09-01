<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* import/edtcmapstr.php
*
* edits the concordance map structure
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
* @category   import
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/import/edtcmapstr.php
* @since      File available since Release 0.6
*/

// REQUESTS
$table = reqArkVar('table');
if (!$table) {
    $error[] = array('vars' => "no table is set");
}
// field is not an ARK var as it may be duplicated between tables
$field = reqQst($_REQUEST, 'field');
// these are also required live
$import_class = reqQst($_REQUEST, 'import_class');
$join = reqQst($_REQUEST, 'join');
$ste_join = reqQst($_REQUEST, 'ste_join');

//MANUAL
$update = 'add';

// TYPES 
$import_classs =
    array(
        'key' => 'Itemkey',
        'modkey' => 'Itemkey (using modtypes)',
        'action' => 'Action',
        'attra' => 'Attribute (A - boolean)',
        'attrb' => 'Attribute (B)',
        'date' => 'Date',
        'num' => 'Number',
        'span' => 'Span',
        'txt' => 'Txt',
        'xmi' => 'XMI',
);
$dd_types = "<select name=\"import_class\">\n";
$dd_types .= "<option value=\"\">-----</option>\n";
foreach ($import_classs as $key => $class) {
    $dd_types .= "<option value=\"$key\">$class</option>\n";
}
$dd_types .= "</select>\n";


// OUTPUT (annoyingly in the wrong place due to the nav calling the cmap_details)
// put in a cmap selector
$enable_select = 'true';
include('php/import/inc_cmap_nav.php');


// DATA
// try to get infor for this if we are cleared for edits
if ($import_class && $join && $ste_join && $cmap_struc_info = chkForField($db, $cmap_id, $table, $field)) {
    $update = 'edit';
    // now fill in the vars for the forms (requested above)
    $uid_col = $cmap_struc_info['uid_col'];
    $itemkey = $cmap_struc_info['itemkey'];
    $raw_itemval_tbl = $cmap_struc_info['raw_itemval_tbl'];
    $raw_itemval_col = $cmap_struc_info['raw_itemval_col'];
    $raw_itemval_join_col = $cmap_struc_info['raw_itemval_join_col'];
    $tbl_itemval_join_col = $cmap_struc_info['tbl_itemval_join_col'];
    $type = $cmap_struc_info['type'];
    $frmlang = $cmap_struc_info['lang'];
    $true = $cmap_struc_info['true'];
    $false = $cmap_struc_info['false'];
    $notset = $cmap_struc_info['notset'];
    $lut_tbl = $cmap_struc_info['lut_tbl'];
    $lut_idcol = $cmap_struc_info['lut_idcol'];
    $lut_valcol = $cmap_struc_info['lut_valcol'];
    $end_source_col = $cmap_struc_info['end_source_col'];
    $xmi_itemkey = $cmap_struc_info['xmi_itemkey'];
    $xmi_itemval_col = $cmap_struc_info['xmi_itemval_col'];
    $raw_stecd_col = $cmap_struc_info['raw_stecd_col'];
    $raw_stecd_tbl = $cmap_struc_info['raw_stecd_tbl'];
    $raw_stecd_join_col = $cmap_struc_info['raw_stecd_join_col'];
    $tbl_stecd_join_col = $cmap_struc_info['tbl_stecd_join_col'];
}
// setup a selector for columns on this table
$cols_select = FALSE;
if ($table) {
    if ($import_cols = getColumns($db, $cmap_details['sourcedb'], $table)) {
        // make a dd of these columns for use if needed
        foreach ($import_cols as $key => $col) {
            $cols_select .= "<option value=\"$col\">$col</option>\n";
        }
    }
} else {
    $import_cols = FALSE;
}
// ITEMKEYS
if (!isset($itemkey)) {
    $itemkey = FALSE;
}
// list loaded modules
foreach ($loaded_modules as $key => $val) {
    $code = $val.'_cd';
    $import_keys[$code] = $code;
}
// list classes that can be used as chain keys
// $import_classs set up at the top of this script

// build both into  dd menu
$dd_itemkey = "<select name=\"itemkey\">\n";
if (isset($itemkey)) {
    $dd_itemkey .= "<option value=\"$itemkey\">$itemkey</option>\n";
} else {
    $dd_itemkey .= "<option value=\"\">---select---</option>\n";
}
foreach ($import_keys as $key => $itemkey) {
    $dd_itemkey .= "<option value=\"$itemkey\">$itemkey</option>\n";
}
$dd_itemkey .= "<option value=\"\">------</option>\n";
foreach ($import_classs as $key => $class) {
    // clean up references to attra and attrb
    if (substr($key, 0, 4) == 'attr') {
        $class = 'attribute';
        $key = 'attribute';
    }
    // sanitize
    $class = strtolower($class);
    $tbl = 'cor_tbl_'.$class;
    // exclude the key pseudo class
    if ($key != 'key' && $key != 'modkey') {
        $dd_itemkey .= "<option value=\"$tbl\">$tbl</option>\n";
    }
}
$dd_itemkey .= "</select>\n";

// MARKUP
$mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
$mk_save = getMarkup('cor_tbl_markup', $lang, 'save');

// FORMS based on import class
// ITEMVAL UNIVERSAL
// if the class is a key then the raw item val must be in this table, durr!
if ($import_class == 'key' OR $import_class == 'modkey') {
    $join = 'nojoin';
}
// first we set up some universal fields used in the raw item val
// In joins these fields are editable, in non joins they are hidden
if ($join == 'join') {
    // raw_itemval_col
    $join_fds = "<li class=\"row\">";
    $join_fds .= "<label class=\"form_label\">raw_itemval_col</label>";
    $join_fds .= "<select name=\"raw_itemval_col\">\n";
    if ($raw_itemval_col) {
        $join_fds .= "<option value=\"$raw_itemval_col\">$raw_itemval_col</option>\n";
    } else {
        $join_fds .= "<option value=\"\">---select---</option>\n";
    }
    $join_fds .= $cols_select;
    $join_fds .= "</select>\n";
    $join_fds .= "</li>\n";
    // raw_itemval_tbl
    $join_fds .= "<li class=\"row\">";
    $join_fds .= "<label class=\"form_label\">raw_itemval_tbl</label>";
    $join_fds .= "<input type=\"text\" name=\"raw_itemval_tbl\" value=\"FALSE\" />\n";
    $join_fds .= "</li>\n";
    // raw_itemval_join_col
    $join_fds .= "<li class=\"row\">";
    $join_fds .= "<label class=\"form_label\">raw_itemval_join_col</label>";
    $join_fds .= "<input type=\"text\" name=\"raw_itemval_join_col\" value=\"\" />\n";
    $join_fds .= "</li>\n";
    // tbl_itemval_join_col
    $join_fds .= "<li class=\"row\">";
    $join_fds .= "<label class=\"form_label\">tbl_itemval_join_col</label>";
    $join_fds .= "<input type=\"text\" name=\"tbl_itemval_join_col\" value=\"\" />\n";
    $join_fds .= "</li>\n";
} else {
    // raw_itemval_col
    // key routines are never joined and are never editable
    if ($import_class == 'key' OR $import_class == 'modkey') {
        $join_fds = "<input type=\"hidden\" name=\"raw_itemval_col\" value=\"$field\" />\n";
    // everything else uses a dd selector
    } else {
        $join_fds = "<li class=\"row\">";
        $join_fds .= "<label class=\"form_label\">raw_itemval_col</label>";
        $join_fds .= "<select name=\"raw_itemval_col\">\n";
        if (!isset($raw_itemval_col)) {
            $raw_itemval_col = FALSE;
        }
        if ($raw_itemval_col) {
            $join_fds .= "<option value=\"$raw_itemval_col\">$raw_itemval_col</option>\n";
        } else {
            $join_fds .= "<option value=\"\">---select---</option>\n";
        }
        $join_fds .= $cols_select;
        $join_fds .= "</select>\n";
        $join_fds .= "</li>\n";
    }

    // raw_itemval_tbl
    $join_fds .= "<input type=\"hidden\" name=\"raw_itemval_tbl\" value=\"FALSE\" />\n";
    // raw_itemval_join_col
    $join_fds .= "<input type=\"hidden\" name=\"raw_itemval_join_col\" value=\"\" />\n";
    // tbl_itemval_join_col
    $join_fds .= "<input type=\"hidden\" name=\"tbl_itemval_join_col\" value=\"\" />\n";
}
// STE_CD UNIVERSAL
// In joins these fields are editable, in non joins they are hidden
switch ($ste_join) {
    case 'join':
        // raw_stecd_col
        $ste_fds = "<li class=\"row\">";
        $ste_fds .= "<label class=\"form_label\">raw_stecd_col</label>";
        $ste_fds .= "<input type=\"text\" name=\"raw_stecd_col\" value=\"\" />\n";
        $ste_fds .= "</li>\n";
        // raw_stecd_tbl
        $ste_fds .= "<li class=\"row\">";
        $ste_fds .= "<label class=\"form_label\">raw_stecd_tbl</label>";
        $ste_fds .= "<input type=\"text\" name=\"raw_stecd_tbl\" value=\"\" />\n";
        $ste_fds .= "</li>\n";
        // raw_stecd_join_col
        $ste_fds .= "<li class=\"row\">";
        $ste_fds .= "<label class=\"form_label\">raw_stecd_join_col</label>";
        $ste_fds .= "<input type=\"text\" name=\"raw_stecd_join_col\" value=\"\" />\n";
        $ste_fds .= "</li>\n";
        // tbl_stecd_join_col
        $ste_fds .= "<li class=\"row\">";
        $ste_fds .= "<label class=\"form_label\">tbl_stecd_join_col</label>";
        $ste_fds .= "<input type=\"text\" name=\"tbl_stecd_join_col\" value=\"\" />\n";
        $ste_fds .= "</li>\n";
        break;
        
    case 'nojoin':
        // raw_stecd_col
        $ste_fds = "<li class=\"row\">";
        $ste_fds .= "<label class=\"form_label\">raw_stecd_col</label>";
        $ste_fds .= "<select name=\"raw_stecd_col\">\n";
        if ($raw_stecd_col) {
            $ste_fds .= "<option value=\"$raw_stecd_col\">$raw_stecd_col</option>\n";
        } else {
            $ste_fds .= "<option value=\"\">---select---</option>\n";
        }
        $ste_fds .= $cols_select;
        $ste_fds .= "</select>\n";
        $ste_fds .= "</li>\n";
        // raw_stecd_tbl
        $ste_fds .= "<input type=\"hidden\" name=\"raw_stecd_tbl\" value=\"FALSE\" />\n";
        // raw_stecd_join_col
        $ste_fds .= "<input type=\"hidden\" name=\"raw_itemval_join_col\" value=\"FALSE\" />\n";
        // tbl_stecd_join_col
        $ste_fds .= "<input type=\"hidden\" name=\"tbl_itemval_join_col\" value=\"FALSE\" />\n";
        break;
    
    case 'fixed':
        // raw_itemval_col
        $ste_fds = "<input type=\"hidden\" name=\"raw_stecd_col\" value=\"FALSE\" />\n";
        // raw_stecd_tbl
        $ste_fds .= "<input type=\"hidden\" name=\"raw_stecd_tbl\" value=\"FALSE\" />\n";
        // raw_stecd_join_col
        $ste_fds .= "<input type=\"hidden\" name=\"raw_itemval_join_col\" value=\"FALSE\" />\n";
        // tbl_stecd_join_col
        $ste_fds .= "<input type=\"hidden\" name=\"tbl_itemval_join_col\" value=\"FALSE\" />\n";
        break;
    
    default:
        $ste_fds = FALSE;
        break;
}

// UID_COL - UNIVERSAL
$univ_uid = "<li class=\"row\">";
$univ_uid .= "<label class=\"form_label\">UID Column</label>";
$univ_uid .= "<select name=\"uid_col\">\n";
if (!isset($uid_col)) {
    $uid_col = FALSE;
}
if ($uid_col) {
    $univ_uid .= "<option value=\"$uid_col\">$uid_col</option>\n";
} else {
    $univ_uid .= "<option value=\"\">---select---</option>\n";
}
$univ_uid .= $cols_select;
$univ_uid .= "</select>\n";
$univ_uid .= "</li>\n";

// SUBMIT - UNIVERSAL
$univ_submit = "<li class=\"row\">";
$univ_submit .= "<label class=\"form_label\">&nbsp;</label>";
$univ_submit .= "<span class=\"inp\"><button type=\"submit\" />$mk_save</button></span>";
$univ_submit .= "</li>\n";

// LANG (frmLANG) - UNIVERSAL
$univ_lang = "<li class=\"row\">";
$univ_lang .= "<label class=\"form_label\">Lang</label>";
if (!isset($frmlang)) {
    $frmlang = FALSE;
}
$dd_lang =
    ddSimple(
        $frmlang, 
        $frmlang,
        'cor_lut_language',
        'language',
        'frmlang',
        "ORDER BY language",
        FALSE,
        'language'
);
$univ_lang .= $dd_lang;
$univ_lang .= "</li>\n";

// NOT SET - UNIVERSAL
// notset
if (!isset($notset)) {
    $notset = FALSE;
}
$univ_notset = "<li class=\"row\">";
$univ_notset .= "<label class=\"form_label\">\"notset\"</label>";
$univ_notset .= "<input type=\"text\" name=\"notset\" value=\"$notset\" />\n";
$univ_notset .= "</li>\n";

// HIDDEN FIELDS - UNIVERSAL
$univ_hidden = "<input type=\"hidden\" name=\"field\" value=\"$field\" />\n";
$univ_hidden .= "<input type=\"hidden\" name=\"join\" value=\"$join\" />\n";
$univ_hidden .= "<input type=\"hidden\" name=\"ste_join\" value=\"$ste_join\" />\n";
$univ_hidden .= "<input type=\"hidden\" name=\"import_class\" value=\"$import_class\" />\n";

// CLASS SPECIFIC ASSEMBLY
switch ($import_class) {
    case 'txt':
        $main_form = "<form method=\"$form_method\" name=\"new_cmap_form\" id=\"new_cmap_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
        $main_form .= "<fieldset>";
        $main_form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        if ($update == 'add') {
            $update = 'adskey';
        } else {
            $update = 'edskey';
            // put in a frag id
            $main_form .= "<input type=\"hidden\" name=\"frag_id\" value=\"{$cmap_struc_info['id']}\" />";
        }
        $main_form .= "<input type=\"hidden\" name=\"update_db\" value=\"$update\" />";
        // hidden vars
        $main_form .= $univ_hidden;
        // Contain the input elements in a list
        $main_form .= "<ul>\n";
        // uid_col
        $main_form .= $univ_uid;
        // itemkey
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Itemkey</label>";
        $main_form .= $dd_itemkey;
        $main_form .= "</li>\n";
        // Raw Item Val - and joins if needed
        $main_form .= $join_fds;
        // SITE CODE - and joins if needed
        $main_form .= $ste_fds;
        // type - txttype
        if (!isset($type)) {
            $type = FALSE;
            $type_alias = FALSE;
        } elseif ($type) {
            $type_alias = getAlias('cor_lut_txttype', $lang, 'id', $type, 1);
        }
        $dd_txttypes =
            ddAlias(
                $type,
                $type_alias,
                'cor_lut_txttype',
                $lang,
                'type',
                FALSE,
                'code',
                'id'
        );
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Text Type</label>";
        $main_form .= $dd_txttypes;
        $main_form .= "</li>\n";
        // lang
        $main_form .= $univ_lang;
        // true - N/A
        // false - N/A
        // lut_tbl - N/A
        // lut_idcol - N/A
        // lut_valcol - N/A
        // end_source_col - N/A
        // xmi_itemkey - N/A
        // xmi_itemval_col - N/A
        // ark_mod is not now used and log is always on at present
        // notset
        $main_form .= $univ_notset;
        
        // offer the chain link
        $main_form .= "<li>";
        $main_form .= "<p>If attributes are to be chained to this item then click <a href=\"{$_SERVER['PHP_SELF']}?view=extr_test&amp;routine=cmap&amp;row={$cmap_struc_info['id']}&amp;chain=1\">[here] </a></p>";
        $main_form .= "</li>";
         // SUBMIT
        $main_form .= $univ_submit;
        $main_form .= "</ul>\n";
        $main_form .= "</fieldset>";
        $main_form .= "</form>\n";
        break;

    case 'modkey':
    case 'key':
        $main_form = "<form method=\"$form_method\" name=\"new_cmap_form\" id=\"new_cmap_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
        $main_form .= "<fieldset>";
        $main_form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        if ($update == 'add') {
            $update = 'adskey';
        } else {
            $update = 'edskey';
            // put in a frag id
            $main_form .= "<input type=\"hidden\" name=\"frag_id\" value=\"{$cmap_struc_info['id']}\" />";
        }
        $main_form .= "<input type=\"hidden\" name=\"update_db\" value=\"$update\" />";
        // hidden vars
        $main_form .= $univ_hidden;
        // Contain the input elements in a list
        $main_form .= "<ul>\n";
        // uid_col
        $main_form .= $univ_uid;
        // itemkey
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Itemkey</label>";
        $main_form .= $dd_itemkey;
        $main_form .= "</li>\n";
        // Raw Item Val - and joins if needed
        $main_form .= $join_fds;
        // SITE CODE - and joins if needed
        $main_form .= $ste_fds;
        // type - NB XMI's have no classtypes
        // lang - N/A
        // true - N/A
        // false - N/A
        // lut_tbl - N/A
        // lut_idcol - N/A
        // lut_valcol - N/A
        // end_source_col - N/A
        // xmi_itemkey
        // xmi_itemval_col
        // ark_mod is not now used and log is always on at present
        // notset - not currently implemented for this import type
        // SUBMIT
        $main_form .= $univ_submit;
        $main_form .= "</ul>\n";
        $main_form .= "</fieldset>";
        $main_form .= "</form>\n";
        break;

    case 'xmi':
        // the form
        $main_form = "<form method=\"$form_method\" id=\"new_cmapstrc_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
        $main_form .= "<fieldset>";
        $main_form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        // a dd for xmi_itemkey
        if (!isset($xmi_itemkey)) {
            $xmi_itemkey = FALSE;
        }
        $dd_xmiitemkey =
            ddSimple(
                $xmi_itemkey,
                $xmi_itemkey,
                'cor_tbl_module',
                'itemkey', 
                'xmi_itemkey',
                FALSE,
                FALSE,
                'itemkey'
        );
        if ($update == 'add') {
            $update = 'adsxmi';
        } else {
            $update = 'edsxmi';
            // put in a frag id
            $main_form .= "<input type=\"hidden\" name=\"frag_id\" value=\"{$cmap_struc_info['id']}\" />";
        }
        $main_form .= "<input type=\"hidden\" name=\"update_db\" value=\"$update\" />";
        // hidden vars
        $main_form .= $univ_hidden;
        // Contain the input elements in a list
        $main_form .= "<ul>\n";
        // uid_col
        $main_form .= $univ_uid;
        // itemkey
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Itemkey</label>";
        $main_form .= $dd_itemkey;
        $main_form .= "</li>\n";
        // Raw Item Val - and joins if needed
        $main_form .= $join_fds;
        // SITE CODE - and joins if needed
        $main_form .= $ste_fds;
        // type - NB XMI's have no classtypes
        // lang - N/A
        // true - N/A
        // false - N/A
        // lut_tbl - N/A
        // lut_idcol - N/A
        // lut_valcol - N/A
        // end_source_col - N/A
        // xmi_itemkey
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">xmi_itemkey</label>";
        $main_form .= $dd_xmiitemkey;
        $main_form .= "</li>\n";
        // xmi_itemval_col
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">xmi_itemval_col</label>";
        $main_form .= "<select name=\"xmi_itemval_col\">\n";
        if (!isset($xmi_itemval_col)) {
            $xmi_itemval_col = FALSE;
        }
        if ($xmi_itemval_col) {
            $main_form .= "<option value=\"$xmi_itemval_col\">$xmi_itemval_col</option>\n";
        } else {
            $main_form .= "<option value=\"\">---select---</option>\n";
        }
        $main_form .= $cols_select;
        $main_form .= "</select>\n";
        $main_form .= "</li>\n";
        // ark_mod is not now used and log is always on at present
        // notset
        $main_form .= $univ_notset;
        // SUBMIT
        $main_form .= $univ_submit;
        $main_form .= "</ul>\n";
        $main_form .= "</fieldset>";
        $main_form .= "</form>\n";
        break;

    case 'attra':
        $main_form = "<form method=\"$form_method\" name=\"new_cmap_form\" id=\"new_cmap_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
        $main_form .= "<fieldset>";
        $main_form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        if ($update == 'add') {
            $update = 'adsata';
        } else {
            $update = 'edsata';
            // put in a frag id
            $main_form .= "<input type=\"hidden\" name=\"frag_id\" value=\"{$cmap_struc_info['id']}\" />";
        }
        $main_form .= "<input type=\"hidden\" name=\"update_db\" value=\"$update\" />";
        // hidden vars
        $main_form .= $univ_hidden;
        // Contain the input elements in a list
        $main_form .= "<ul>\n";
        // uid_col
        $main_form .= $univ_uid;
        // itemkey
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Itemkey</label>";
        $main_form .= $dd_itemkey;
        $main_form .= "</li>\n";
        // Raw Item Val - and joins if needed
        $main_form .= $join_fds;
        // SITE CODE - and joins if needed
        $main_form .= $ste_fds;
        // type - numtype
        if (!isset($type)) {
            $type = FALSE;
            $type_alias = FALSE;
        } elseif ($type) {
            $type_alias = getAlias('cor_lut_attribute', $lang, 'id', $type, 1);
        }
        $dd_attrs =
            ddAlias(
                $type,
                $type_alias,
                'cor_lut_attribute',
                $lang,
                'type',
                FALSE,
                'code',
                'id'
        );
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Attribute</label>";
        $main_form .= $dd_attrs;
        $main_form .= "</li>\n";
        // lang - N/A
        // true
        if (!isset($true)) {
            $true = FALSE;
        }
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">true</label>";
        $main_form .= "<input type=\"text\" name=\"true\" value=\"$true\" />\n";
        $main_form .= "</li>\n";
        // false - N/A
        if (!isset($false)) {
            $false = FALSE;
        }
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">false</label>";
        $main_form .= "<input type=\"text\" name=\"false\" value=\"$false\" />\n";
        $main_form .= "</li>\n";
        // lut_tbl - N/A
        // lut_idcol - N/A
        // lut_valcol - N/A
        // end_source_col - N/A
        // xmi_itemkey - N/A
        // xmi_itemval_col - N/A
        // ark_mod is not now used and log is always on at present
        // notset
        $main_form .= $univ_notset;
        // SUBMIT
        $main_form .= $univ_submit;
        $main_form .= "</ul>\n";
        $main_form .= "</fieldset>";
        $main_form .= "</form>\n";
        break;

    case 'attrb':
        $main_form = "<form method=\"$form_method\" name=\"new_cmap_form\" id=\"new_cmap_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
        $main_form .= "<fieldset>";
        $main_form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        if ($update == 'add') {
            $update = 'adsatb';
        } else {
            $update = 'edsatb';
            // put in a frag id
            $main_form .= "<input type=\"hidden\" name=\"frag_id\" value=\"{$cmap_struc_info['id']}\" />";
        }
        $main_form .= "<input type=\"hidden\" name=\"update_db\" value=\"$update\" />";
        // hidden vars
        $main_form .= $univ_hidden;
        // Contain the input elements in a list
        $main_form .= "<ul>\n";
        // uid_col
        $main_form .= $univ_uid;
        // itemkey
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Itemkey</label>";
        $main_form .= $dd_itemkey;
        $main_form .= "</li>\n";
        // Raw Item Val - and joins if needed
        $main_form .= $join_fds;
        // SITE CODE - and joins if needed
        $main_form .= $ste_fds;
        // type - the attribute type
        if (!isset($type)) {
            $type = FALSE;
            $type_alias = FALSE;
        } elseif ($type) {
            $type_alias = getAlias('cor_lut_attributetype', $lang, 'id', $type, 1);
        }
        $dd_attrtype =
            ddAlias($type, $type_alias, 'cor_lut_attributetype', $lang, 'type', FALSE, 'code');
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Attribute Type</label>";
        $main_form .= $dd_attrtype;
        $main_form .= "</li>\n";
        // lang
        $main_form .= $univ_lang;
        // true - N/A
        // false - N/A
        // lut_tbl - N/A
        if (!isset($lut_tbl)) {
            $lut_tbl = FALSE;
        }
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">lut_tbl</label>";
        $main_form .= "<input type=\"text\" name=\"lut_tbl\" value=\"$lut_tbl\" />\n";
        $main_form .= "</li>\n";
        // lut_idcol - N/A
        if (!isset($lut_idcol)) {
            $lut_idcol = FALSE;
        }
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">lut_idcol</label>";
        $main_form .= "<input type=\"text\" name=\"lut_idcol\" value=\"$lut_idcol\" />\n";
        $main_form .= "</li>\n";
        // lut_valcol - N/A
        if (!isset($lut_valcol)) {
            $lut_valcol = FALSE;
        }
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">lut_valcol</label>";
        $main_form .= "<input type=\"text\" name=\"lut_valcol\" value=\"$lut_valcol\" />\n";
        $main_form .= "</li>\n";
        
        // offer the chain link
        $main_form .= "<li>";
        $main_form .= "<p>If attributes are to be chained to this number then click <a href=\"{$_SERVER['PHP_SELF']}?view=extr_test&amp;routine=cmap&amp;row={$cmap_struc_info['id']}&amp;chain=1\">[here] </a></p>";
        $main_form .= "</li>";
        
        // end_source_col - N/A
        // xmi_itemkey
        // xmi_itemval_col
        // ark_mod is not now used and log is always on at present
        // notset - not currently implemented for this import type
        // SUBMIT
        $main_form .= $univ_submit;
        $main_form .= "</ul>\n";
        $main_form .= "</fieldset>";
        $main_form .= "</form>\n";
        $main_form .= "<p>If the human readable data for this attribute is in this table and not in a joined table, the lut_tbl should be filled out with this table name and the idcol and val col with the name of the column holding the data.</p>\n";
        break;

    case 'num':
        $main_form = "<form method=\"$form_method\" name=\"new_cmap_form\" id=\"new_cmap_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
        $main_form .= "<fieldset>";
        $main_form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        if ($update == 'add') {
            $update = 'adsnum';
        } else {
            $update = 'edsnum';
            // put in a frag id
            $main_form .= "<input type=\"hidden\" name=\"frag_id\" value=\"{$cmap_struc_info['id']}\" />";
        }
        $main_form .= "<input type=\"hidden\" name=\"update_db\" value=\"$update\" />";
        // hidden vars
        $main_form .= $univ_hidden;
        // Contain the input elements in a list
        $main_form .= "<ul>\n";
        // uid_col
        $main_form .= $univ_uid;
        // itemkey
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Itemkey</label>";
        $main_form .= $dd_itemkey;
        $main_form .= "</li>\n";
        // Raw Item Val - and joins if needed
        $main_form .= $join_fds;
        // SITE CODE - and joins if needed
        $main_form .= $ste_fds;
        // type - numtype
        if (!isset($type)) {
            $type = FALSE;
            $type_alias = FALSE;
        } elseif ($type) {
            $type_alias = getAlias('cor_lut_numbertype', $lang, 'id', $type, 1);
        }
        $dd_numtypes =
            ddAlias(
                $type,
                $type_alias,
                'cor_lut_numbertype',
                $lang,
                'type',
                FALSE,
                'code',
                'id'
        );
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Number Type</label>";
        $main_form .= $dd_numtypes;
        $main_form .= "</li>\n";
        // offer the chain link
        $main_form .= "<li>";
        $main_form .= "<p>If attributes are to be chained to this number then click <a href=\"{$_SERVER['PHP_SELF']}?view=extr_test&amp;routine=cmap&amp;row={$cmap_struc_info['id']}&amp;chain=1\">[here] </a></p>";
        $main_form .= "</li>";
        // lang - N/A

        // true - N/A
        // false - N/A
        // lut_tbl - N/A
        // lut_idcol - N/A
        // lut_valcol - N/A
        // end_source_col - N/A
        // xmi_itemkey - N/A
        // xmi_itemval_col - N/A
        // ark_mod is not now used and log is always on at present
        // notset
        $main_form .= $univ_notset;
        // SUBMIT
        $main_form .= $univ_submit;
        $main_form .= "</ul>\n";
        $main_form .= "</fieldset>";
        $main_form .= "</form>\n";
        break;

    case 'date':
        $main_form = "<form method=\"$form_method\" name=\"new_cmap_form\" id=\"new_cmap_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
        $main_form .= "<fieldset>";
        $main_form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        if ($update == 'add') {
            $update = 'adsdat';
        } else {
            $update = 'edsdat';
            // put in a frag id
            $main_form .= "<input type=\"hidden\" name=\"frag_id\" value=\"{$cmap_struc_info['id']}\" />";
        }
        $main_form .= "<input type=\"hidden\" name=\"update_db\" value=\"$update\" />";
        // hidden vars
        $main_form .= $univ_hidden;
        // Contain the input elements in a list
        $main_form .= "<ul>\n";
        // uid_col
        $main_form .= $univ_uid;
        // itemkey
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Itemkey</label>";
        $main_form .= $dd_itemkey;
        $main_form .= "</li>\n";
        // Raw Item Val - and joins if needed
        $main_form .= $join_fds;
        // SITE CODE - and joins if needed
        $main_form .= $ste_fds;
        // type - numtype
        if (!isset($type)) {
            $type = FALSE;
            $type_alias = FALSE;
        } elseif ($type) {
            $type_alias = getAlias('cor_lut_datetype', $lang, 'id', $type, 1);
        }
        $dd_datetypes =
            ddAlias(
                $type,
                $type_alias,
                'cor_lut_datetype',
                $lang,
                'type',
                FALSE,
                'code',
                'id'
        );
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Date Type</label>";
        $main_form .= $dd_datetypes;
        $main_form .= "</li>\n";
        // lang - N/A

        // true - N/A
        // false - N/A
        // lut_tbl - N/A
        // lut_idcol - N/A
        // lut_valcol - N/A
        // end_source_col - N/A
        // xmi_itemkey - N/A
        // xmi_itemval_col - N/A
        // ark_mod is not now used and log is always on at present
        // notset
        $main_form .= $univ_notset;
        // SUBMIT
        $main_form .= $univ_submit;
        $main_form .= "</ul>\n";
        $main_form .= "</fieldset>";
        $main_form .= "</form>\n";
        break;

    case 'span':
        $main_form = "<form method=\"$form_method\" name=\"new_cmap_form\" id=\"new_cmap_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
        $main_form .= "<fieldset>";
        $main_form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        if ($update == 'add') {
            $update = 'adsspn';
        } else {
            $update = 'edsspn';
            // put in a frag id
            $main_form .= "<input type=\"hidden\" name=\"frag_id\" value=\"{$cmap_struc_info['id']}\" />";
        }
        $main_form .= "<input type=\"hidden\" name=\"update_db\" value=\"$update\" />";
        // hidden vars
        $main_form .= $univ_hidden;
        // Contain the input elements in a list
        $main_form .= "<ul>\n";
        // uid_col
        $main_form .= $univ_uid;
        // itemkey
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Itemkey</label>";
        $main_form .= $dd_itemkey;
        $main_form .= "</li>\n";
        // Raw Item Val - and joins if needed
        $main_form .= $join_fds;
        // SITE CODE - and joins if needed
        $main_form .= $ste_fds;
        // type - numtype
        if (!isset($type)) {
            $type = FALSE;
            $type_alias = FALSE;
        } elseif ($type) {
            $type_alias = getAlias('cor_lut_spantype', $lang, 'id', $type, 1);
        }
        $dd_spantypes =
            ddAlias(
                $type,
                $type_alias,
                'cor_lut_spantype',
                $lang,
                'type',
                FALSE,
                'code',
                'id'
        );
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">Span Type</label>";
        $main_form .= $dd_spantypes;
        $main_form .= "</li>\n";
        // lang - N/A
        // true - N/A
        // false - N/A
        // lut_tbl - N/A
        // lut_idcol - N/A
        // lut_valcol - N/A
        // end_source_col
        $main_form .= "<li class=\"row\">";
        $main_form .= "<label class=\"form_label\">end_source_col</label>";
        $main_form .= "<select name=\"end_source_col\">\n";
        if (!isset($end_source_col)) {
            $end_source_col = FALSE;
        }
        if ($end_source_col) {
            $main_form .= "<option value=\"$end_source_col\">$end_source_col</option>\n";
        } else {
            $main_form .= "<option value=\"\">---select---</option>\n";
        }
        $main_form .= $cols_select;
        $main_form .= "</select>\n";
        $main_form .= "</li>\n";
        // xmi_itemkey - N/A
        // xmi_itemval_col - N/A
        // ark_mod is not now used and log is always on at present
        // notset - not currently implemented for this import type
        // SUBMIT
        $main_form .= $univ_submit;
        $main_form .= "</ul>\n";
        $main_form .= "</fieldset>";
        $main_form .= "</form>\n";
        break;

    default:
        $main_form = "<p>Sorry, import class '$import_class' doesn't have a form yet. Please edit the cmap using phpMyAdmin</p>";
        $join = TRUE;
        break;
}
// OUTPUT (proper)
if ($import_cols) {
    printf ("<p>The following fields are in this table. Mapped fields are highlighted</p>");
    // which table are we on?
    echo "<h4>Table: $table</h4>";
    // loop over the fields of this table showing a little display for each one
    foreach ($import_cols as $key => $column) {
        // edit routine
        if ($column == $field) {
            // first check status
            $in_map = chkForField($db, $cmap_details['id'], $table, $column);
            // if not in the map this is an add routine
            if (!$in_map) {
                echo "<div class=\"mc_subform\">\n";
                // header
                echo "<h4>$column <a href=\"{$_SERVER['PHP_SELF']}?field=$column\">[reset]</a></h4>\n";
                // if we havent yet got an import type, we need one
                if (!$import_class) {
                    echo "<p>Select the ARK data class which this field will become</p>\n";
                    $form = "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">\n";
                    $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                    $form .= "<input type=\"hidden\" name=\"field\" value=\"$field\" />\n";
                    $form .= "<span class=\"row\">";
                    $form .= "<span class=\"input\">$dd_types</span>";
                    $form .= "<span class=\"input\"><button type=\"submit\">$mk_go</button></span>";
                    $form .= "</span>\n";
                    $form .= "</form>\n";
                    echo "$form";
                } elseif($import_class && !$join) {
                    echo "<h5>Class: $import_class</h5>\n";
                    echo "<p>Is the raw item val column in this table or in another table?</p>"; //XXX
                    $form = "<form method=\"$form_method\" style=\"padding:4px; font-size: 0.8em;\" action=\"{$_SERVER['PHP_SELF']}\">\n";
                    $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                    $form .= "<input type=\"hidden\" name=\"field\" value=\"$field\" />\n";
                    $form .= "<input type=\"hidden\" name=\"import_class\" value=\"$import_class\" />\n";
                    $form .= "<span class=\"row\">";
                    $form .= "<label class=\"form_label\">This Table</label>";
                    $form .= "<input name=\"join\" value=\"nojoin\" type=\"radio\" />";
                    $form .= "</span>\n";
                    $form .= "<span class=\"row\">";
                    $form .= "<label class=\"form_label\">Join Table</label>";
                    $form .= "<input name=\"join\" value=\"join\" type=\"radio\" />";
                    $form .= "</span>\n";
                    $form .= "<span class=\"row\">";
                    $form .= "<label class=\"form_label\">&nbsp;</label>";
                    $form .= "<button type=\"submit\">$mk_go</button></span>";
                    $form .= "</span>\n";
                    $form .= "</form>\n";
                    echo "$form";
                } elseif($import_class && $join && !$ste_join) {
                    echo "<h5>Class: $import_class</h5>\n";
                    echo "<p>Should the site code for this itemval be fixed as the site code specified in the CMAP ({$cmap_details['stecd']}) for all records, extracted from a column in this table or extracted from a column in another table?</p>"; //XXX
                    $form = "<form method=\"$form_method\" style=\"padding:4px; font-size: 0.8em;\" action=\"{$_SERVER['PHP_SELF']}\">\n";
                    $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                    $form .= "<input type=\"hidden\" name=\"field\" value=\"$field\" />\n";
                    $form .= "<input type=\"hidden\" name=\"import_class\" value=\"$import_class\" />\n";
                    $form .= "<input type=\"hidden\" name=\"join\" value=\"$join\" />\n";
                    $form .= "<span class=\"row\">";
                    $form .= "<label class=\"form_label\">Fixed ({$cmap_details['stecd']})</label>";
                    $form .= "<input name=\"ste_join\" value=\"fixed\" type=\"radio\" />";
                    $form .= "</span>\n";
                    $form .= "<span class=\"row\">";
                    $form .= "<label class=\"form_label\">From this table</label>";
                    $form .= "<input name=\"ste_join\" value=\"nojoin\" type=\"radio\" />";
                    $form .= "</span>\n";
                    $form .= "<span class=\"row\">";
                    $form .= "<label class=\"form_label\">From a join table</label>";
                    $form .= "<input name=\"ste_join\" value=\"join\" type=\"radio\" />";
                    $form .= "</span>\n";
                    $form .= "<span class=\"row\">";
                    $form .= "<label class=\"form_label\">&nbsp;</label>";
                    $form .= "<button type=\"submit\">$mk_go</button></span>";
                    $form .= "</span>\n";
                    $form .= "</form>\n";
                    echo "$form";
                // forms for each type are set up above
                }else {
                    echo "<h5>Class: $import_class</h5>\n";
                    // forms for each type are set up above
                    echo "$main_form";
                }
                echo "</div>\n";
            // if in the map already this is an edit routine
            } else {
                echo "<div class=\"import_field\">\n";
                // header
                $hdr = "<h4>$column ";
                //$hdr .= "<a href=\"{$_SERVER['PHP_SELF']}?field=$column\">[reset]</a>";
                $hdr .= "<a href=\"{$_SERVER['PHP_SELF']}?view=extr_test&amp;routine=cmap&amp;row={$in_map['id']}\">[test] </a>";
                $hdr .= "<a href=\"{$_SERVER['PHP_SELF']}?update_db=delcms&amp;del_frag={$in_map['id']}\">[delete] </a>";
                $hdr .= "</h4>\n";
                echo "$hdr";
                echo "$main_form";
                echo "</div>\n";
            }
        // else a view routine
        } else {
            // first check status
            $in_map = chkForField($db, $cmap_details['id'], $table, $column);
            // display this field
            if (!$in_map) {
                echo "<div class=\"mc_subform\">\n";
                $ste_join_lk = FALSE;
                $join_lk = FALSE;
                $import_cl_lk = FALSE;
            } else {
                echo "<div class=\"import_field\">\n";
                // get some vars for the edit link
                // itemval joins
                if ($in_map['raw_itemval_tbl'] && $in_map['raw_itemval_tbl'] != 'FALSE') {
                    $join_lk = 'join=join';
                } else {
                    $join_lk = 'join=nojoin';
                }
                // ste_cd joins
                if ($in_map['raw_stecd_col'] && $in_map['raw_stecd_col'] != 'FALSE') {
                    if ($in_map['raw_stecd_tbl'] && $in_map['raw_stecd_tbl'] != 'FALSE') {
                        $ste_join_lk = 'ste_join=nojoin';
                    } else {
                        $ste_join_lk = 'ste_join=join';
                    }
                } else {
                    $ste_join_lk = 'ste_join=fixed';
                }
                // import_class
                $import_cl_lk = "import_class={$in_map['class']}";
            }

            // header
            echo "<h4>$column <a href=\"{$_SERVER['PHP_SELF']}?field=$column&amp;$join_lk&amp;$ste_join_lk&amp;$import_cl_lk\"><img src=\"$skin_path/images/plusminus/edit.png\" class=\"sml\" alt=\"[ed]\"/></a></h4>\n";
            if ($in_map) {
                printf ("<p>Field Mapped in {$cmap_details['nname']}</p>");
                echo "<p>Click to run test extraction: <a href=\"{$_SERVER['PHP_SELF']}?view=extr_test&amp;routine=cmap&amp;row={$in_map['id']}\">[test]</a></p>";
            } else {
                printf ("<p>Field is not mapped in this cmap (cmap_id: $cmap_id - {$cmap_details['nname']}) </p>");
            }
            echo "</div>\n";
        }
    }
}

?>
