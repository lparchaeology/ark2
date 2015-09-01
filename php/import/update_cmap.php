<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* import/global_update.php
*
* global update script for import
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
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/user_admin/global_update.php
* @since      File available since Release 0.8
*/

// MARKUP
$mk_err_varnotset = getMarkup('cor_tbl_markup', $lang, 'err_varnotset');
$mk_err_varnotvalid = getMarkup('cor_tbl_markup', $lang, 'err_varnotvalid');
$mk_recsucs = getMarkup('cor_tbl_markup', $lang, 'recsucs');
$mk_recedtsucs = getMarkup('cor_tbl_markup', $lang, 'recedtsucs');
$mk_recdelsucs = getMarkup('cor_tbl_markup', $lang, 'recdelsucs');

// COMMON REQUESTS
$import_class = reqQst($_REQUEST, 'import_class');
//$cmap_id; //should be live
$tbl = reqArkVar('table');
$col = reqQst($_REQUEST, 'field');
$uid_col = reqQst($_REQUEST, 'uid_col');
$itemkey = reqQst($_REQUEST, 'itemkey');
$raw_itemval_tbl = reqQst($_REQUEST, 'raw_itemval_tbl');
$raw_itemval_col = reqQst($_REQUEST, 'raw_itemval_col');
$raw_itemval_join_col = reqQst($_REQUEST, 'raw_itemval_join_col');
$tbl_itemval_join_col = reqQst($_REQUEST, 'tbl_itemval_join_col');
$type = reqQst($_REQUEST, 'type');
$frmlang = reqQst($_REQUEST, 'frmlang');
$true = reqQst($_REQUEST, 'true');
$false = reqQst($_REQUEST, 'false');
$notset = reqQst($_REQUEST, 'notset');
$lut_tbl = reqQst($_REQUEST, 'lut_tbl');
$lut_idcol = reqQst($_REQUEST, 'lut_idcol');
$lut_valcol = reqQst($_REQUEST, 'lut_valcol');
$end_source_col = reqQst($_REQUEST, 'end_source_col');
$xmi_itemkey = reqQst($_REQUEST, 'xmi_itemkey');
$xmi_itemval_col = reqQst($_REQUEST, 'xmi_itemval_col');
$raw_stecd_col = reqQst($_REQUEST, 'raw_stecd_col');
$raw_stecd_tbl = reqQst($_REQUEST, 'raw_stecd_tbl');
$raw_stecd_join_col = reqQst($_REQUEST, 'raw_stecd_join_col');
$tbl_stecd_join_col = reqQst($_REQUEST, 'tbl_stecd_join_col');
$ark_mod = FALSE;
$log = 'YES';
$del_frag = reqQst($_REQUEST, 'del_frag');
$frag_id = reqQst($_REQUEST, 'frag_id');

// DRY RUNS
//$dry_run = TRUE;
$dry_run = FALSE;

//OPTION 1 - ADDCMP = ADD CMAP
if ($update_db == 'addcmp') {
    // trip the query needed switch
    $query_needed = 'G1';
    // request variables
    $nickname = reqQst($_REQUEST,'nickname');
    $cmap_desc = reqQst($_REQUEST,'cmap_desc');
    $source_db = reqQst($_REQUEST,'source_db');
    $ste_cd = reqQst($_REQUEST,'ste_cd');
    $cre_by = $user_id;
    $cre_on = gmdate("Y-m-d H:i:s", time());;
    $import_cre_by = $user_id;
    $import_cre_on = gmdate("Y-m-d H:i:s", time());;
    // This is not currently in use 9/9/2010 GH
    $type = 'dry_run';
    
    // evaluate variables

    //NICKNAME
    // 1 - MUST BE SET
    if (!$nickname) {
        $error[] = array('field' => 'nickname', 'vars' => "$mk_err_varnotset: 'nickname'");
    }
    // KILL SPACES
    $nickname = str_replace (' ', '', $nickname);
    // FORCE Lower case
    $nickname = strtolower($nickname);

    //CMAP_DESC
    // whatever
    
    //SOURCE DB
    // 1 - MUST BE SET
    if (!$source_db) {
        $error[] = array('field' => 'source_db', 'vars' => "$mk_err_varnotset: 'source_db'");
    }
    // 2 - MUST BE VALID
    $db_list = $db->query( 'SHOW DATABASES' );
    
    while ($row = $db_list->fetch(PDO::FETCH_ASSOC)) {
         $dbs[] = $row['Database'];
    }
    if (!in_array($source_db, $dbs)) {
        $error[] = array('field' => 'source_db', 'vars' => "$mk_err_varnotvalid: 'source_db'");
    }
    //IMPORT_CRE_BY
    // 1 - MUST BE SET
    if (!$import_cre_by) {
        $error[] = array('field' => 'import_cre_by', 'vars' => "$mk_err_varnotset: 'import_cre_by'");
    }
    //CRE_BY
    // 1 - MUST BE SET
    if (!$cre_by) {
        $error[] = array('field' => 'cre_by', 'vars' => "$mk_err_varnotset: 'cre_by'");
    }
    // Both cre_on's and 'type' have been manually set in this script; no need to evaluate
}

//OPTION 2 - EDTCMP = EDDIT CMAP
if ($update_db == 'edtcmp') {
    // trip the query needed switch
    $query_needed = 'G2';

    // request variables
    $nickname = reqQst($_REQUEST,'nickname');
    $cmap_desc = reqQst($_REQUEST,'cmap_desc');
    $source_db = reqQst($_REQUEST,'source_db');
    $ste_cd = reqQst($_REQUEST,'ste_cd');
    $cre_by = $user_id;
    $cre_on = gmdate("Y-m-d H:i:s", time());;
    $import_cre_by = $user_id;
    $import_cre_on = gmdate("Y-m-d H:i:s", time());;
    // This is not currently in use 9/9/2010 GH
    $type = 'dry_run';
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //NICKNAME
    // 1 - MUST BE SET
    if (!$nickname) {
        $error[] = array('field' => 'nickname', 'vars' => "$mk_err_varnotset: 'nickname'");
    }
    // KILL SPACES
    $nickname = str_replace (' ', '', $nickname);
    // FORCE Lower case
    $nickname = strtolower($nickname);

    //CMAP_DESC
    // whatever
    
    //SOURCE DB
    // 1 - MUST BE SET
    if (!$source_db) {
        $error[] = array('field' => 'source_db', 'vars' => "$mk_err_varnotset: 'source_db'");
    }
    // 2 - MUST BE VALID
    $db_list = $db->query( 'SHOW DATABASES' );
    while ($row = $db_list->fetch(PDO::FETCH_ASSOC)) {
         $dbs[] = $row['Database'];
    }
    if (!in_array($source_db, $dbs)) {
        $error[] = array('field' => 'source_db', 'vars' => "$mk_err_varnotvalid: 'source_db'");
    }
    //IMPORT_CRE_BY
    // 1 - MUST BE SET
    if (!$import_cre_by) {
        $error[] = array('field' => 'import_cre_by', 'vars' => "$mk_err_varnotset: 'import_cre_by'");
    }
    //CRE_BY
    // 1 - MUST BE SET
    if (!$cre_by) {
        $error[] = array('field' => 'cre_by', 'vars' => "$mk_err_varnotset: 'cre_by'");
    }
    // Both cre_on's and 'type' have been manually set in this script; no need to evaluate

}

//OPTION 3 - DELCMP = DELETE CMAP
if ($update_db == 'edtusr') {
    // trip the query needed switch
    $query_needed = 'G3';
}

//OPTION 4 - ADSXMI = ADd to Structure map XMI
if ($update_db == 'adsxmi') {
    // trip the query needed switch
    $query_needed = 'G4';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type - NOT USED
    // $lang - NOT USED
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $lut_idcol - NOT USED
    // $lut_valcol - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey
    // 1 - MUST BE SET
    if (!$xmi_itemkey) {
        $error[] = array('field' => 'xmi_itemkey', 'vars' => "$mk_err_varnotset: 'xmi_itemkey'");
    }
    // $xmi_itemval_col
    // 1 - MUST BE SET
    if (!$xmi_itemval_col) {
        $error[] = array('field' => 'xmi_itemval_col', 'vars' => "$mk_err_varnotset: 'xmi_itemval_col'");
    }
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 5 - EDSXMI = EDit Structure map XMI
if ($update_db == 'edsxmi') {
    // trip the query needed switch
    $query_needed = 'G5';
    // request variables is made at top of script
    
    // evaluate variables
    //FRAG_ID
    // 1 - MUST BE SET
    if (!$frag_id) {
        $error[] = array('field' => 'frag_id', 'vars' => "$mk_err_varnotset: 'frag_id'");
    }
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type - NOT USED
    // $lang - NOT USED
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $lut_idcol - NOT USED
    // $lut_valcol - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey
    // 1 - MUST BE SET
    if (!$xmi_itemkey) {
        $error[] = array('field' => 'xmi_itemkey', 'vars' => "$mk_err_varnotset: 'xmi_itemkey'");
    }
    // $xmi_itemval_col
    // 1 - MUST BE SET
    if (!$xmi_itemval_col) {
        $error[] = array('field' => 'xmi_itemval_col', 'vars' => "$mk_err_varnotset: 'xmi_itemval_col'");
    }
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 6 - DELCMS = DELete from the CMap Structure
if ($update_db == 'delcms') {
    // trip the query needed switch
    $query_needed = 'G6';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    // $del_frag
    // 1 - MUST BE SET
    if (!$del_frag) {
        $error[] = array('field' => 'del_frag', 'vars' => "$mk_err_varnotset: 'del_frag'");
    }
}

//OPTION 7 - ADSKEY = ADd to Structure map KEY
if ($update_db == 'adskey') {
    // trip the query needed switch
    $query_needed = 'G4';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type - NOT USED
    // $lang - NOT USED
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $lut_idcol - NOT USED
    // $lut_valcol - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // ALL 4 need to be permissive and alow blanks
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
}

//OPTION 8 - EDSKEY = EDit Structure map KEY
if ($update_db == 'edskey') {
    // trip the query needed switch
    $query_needed = 'G5';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type - NOT USED
    // $lang - NOT USED
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $lut_idcol - NOT USED
    // $lut_valcol - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // ALL 4 need to be permissive and alow blanks
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
}

//OPTION 9 - ADSATA = ADd to Structure map ATribute A
if ($update_db == 'adsata') {
    // trip the query needed switch
    $query_needed = 'G4';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $lang - NOT USED
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 10 - EDSATA = EDit Structure map ATribute A
if ($update_db == 'edsata') {
    // trip the query needed switch
    $query_needed = 'G5';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $lang - NOT USED
    // $true
    
    // $false
    
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 11 - ADSATB = ADd to Structure map ATribute B
if ($update_db == 'adsatb') {
    // trip the query needed switch
    $query_needed = 'G4';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $frmlang
    // 1 - MUST BE SET
    if (!$frmlang) {
        $error[] = array('field' => 'frmlang', 'vars' => "$mk_err_varnotset: 'frmlang'");
    }
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl
    if (!$lut_tbl) {
        $error[] = array('field' => 'lut_tbl', 'vars' => "$mk_err_varnotset: 'lut_tbl'");
    }
    // $lut_idcol
    if (!$lut_idcol) {
        $error[] = array('field' => 'lut_idcol', 'vars' => "$mk_err_varnotset: 'lut_idcol'");
    }
    // $lut_valcol
    if (!$lut_valcol) {
        $error[] = array('field' => 'lut_valcol', 'vars' => "$mk_err_varnotset: 'lut_valcol'");
    }
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 12 - EDSATB = EDit Structure map ATribute B
if ($update_db == 'edsatb') {
    // trip the query needed switch
    $query_needed = 'G5';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $frmlang
    // 1 - MUST BE SET
    if (!$frmlang) {
        $error[] = array('field' => 'frmlang', 'vars' => "$mk_err_varnotset: 'frmlang'");
    }
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl
    if (!$lut_tbl) {
        $error[] = array('field' => 'lut_tbl', 'vars' => "$mk_err_varnotset: 'lut_tbl'");
    }
    // $lut_idcol
    if (!$lut_idcol) {
        $error[] = array('field' => 'lut_idcol', 'vars' => "$mk_err_varnotset: 'lut_idcol'");
    }
    // $lut_valcol
    if (!$lut_valcol) {
        $error[] = array('field' => 'lut_valcol', 'vars' => "$mk_err_varnotset: 'lut_valcol'");
    }
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 13 - ADSNUM = ADd to Structure map NUMber
if ($update_db == 'adsnum') {
    // trip the query needed switch
    $query_needed = 'G4';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $lang - NOT USED
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 14 - EDSNUM = EDit Structure map NUMber
if ($update_db == 'edsnum') {
    // trip the query needed switch
    $query_needed = 'G5';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $lang - NOT USED
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 15 - ADSTXT = ADd to Structure map TeXT
if ($update_db == 'adstxt') {
    // trip the query needed switch
    $query_needed = 'G4';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $frmlang
    // 1 - MUST BE SET
    if (!$frmlang) {
        $error[] = array('field' => 'frmlang', 'vars' => "$mk_err_varnotset: 'frmlang'");
    }
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 16 - EDSTXT = EDit Structure map TeXT
if ($update_db == 'edstxt') {
    // trip the query needed switch
    $query_needed = 'G5';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $lang - NOT USED
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 17 - ADSDAT = ADd to Structure map DATe
if ($update_db == 'adsdat') {
    // trip the query needed switch
    $query_needed = 'G4';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $frmlang
    // DELETED CLAUSE. frmlang is not required for date fields. JO.
    
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 18 - EDSDAT = EDit Structure map DATe
if ($update_db == 'edsdat') {
    // trip the query needed switch
    $query_needed = 'G5';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $lang - NOT USED
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 19 - ADSSPN = ADd to Structure map SPaN
if ($update_db == 'adsspn') {
    // trip the query needed switch
    $query_needed = 'G4';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $lang - NOT USED
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $end_source_col
    if (!$end_source_col) {
        $error[] = array('field' => 'end_source_col', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

//OPTION 20 - EDSSPN = EDit Structure map SPaN
if ($update_db == 'edsspn') {
    // trip the query needed switch
    $query_needed = 'G5';
    // request variables is made at top of script
    
    // evaluate variables
    //CMAP_ID
    // 1 - MUST BE SET
    if (!$cmap_id) {
        $error[] = array('field' => 'cmap_id', 'vars' => "$mk_err_varnotset: 'cmap_id'");
    }
    //TBL
    // 1 - MUST BE SET
    if (!$tbl) {
        $error[] = array('field' => 'tbl', 'vars' => "$mk_err_varnotset: 'tbl'");
    }
    //COL
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'col', 'vars' => "$mk_err_varnotset: 'col'");
    }
    //CLASS
    // 1 - MUST BE SET
    if (!$import_class) {
        $error[] = array('field' => 'import_class', 'vars' => "$mk_err_varnotset: 'import_class'");
    }
    //UID_COL
    // 1 - MUST BE SET
    if (!$uid_col) {
        $error[] = array('field' => 'uid_col', 'vars' => "$mk_err_varnotset: 'uid_col'");
    }
    //ITEMKEY
    // 1 - MUST BE SET
    if (!$col) {
        $error[] = array('field' => 'itemkey', 'vars' => "$mk_err_varnotset: 'itemkey'");
    }
    //RAW_ITEMVAL_TBL - IF FALSE THEN THATS OK
    //RAW_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //TBL_ITEMVAL_JOIN_COL - IF FALSE THEN THATS OK
    //RAW_TEMVAL_COL
    // 1 - MUST BE SET
    if (!$raw_itemval_col) {
        $error[] = array('field' => 'raw_itemval_col', 'vars' => "$mk_err_varnotset: 'raw_itemval_col'");
    }
    // $type
    if (!$type) {
        $error[] = array('field' => 'type', 'vars' => "$mk_err_varnotset: 'type'");
    }
    // $lang - NOT USED
    // $true - NOT USED
    // $false - NOT USED
    // $notset
    // needs to be permissive i think???
    // $lut_tbl - NOT USED
    // $end_source_col - NOT USED
    // $xmi_itemkey - NOT USED
    // $xmi_itemval_col - NOT USED
    // raw_stecd_tbl
    // raw_stecd_col
    // raw_stecd_join_col
    // tbl_stecd_join_col
    // ALL 4 need to be permissive and alow blanks
}

// ---------- Execution ------------

//OPTION 1 - ADDCMP
if ($query_needed == 'G1' AND !$error) {
    // setup the sql
    $sql = "
        INSERT INTO cor_tbl_cmap (nname, description, sourcedb, stecd, import_cre_by, import_cre_on, type, cre_by, cre_on)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";
    $params = array($nickname, $cmap_desc, $source_db, $ste_cd, $import_cre_by, $import_cre_on, $type, $cre_by, $cre_on);
    if ($dry_run) {
        $message[] = $sql;
    } else {
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        $affected_rows = $sql->rowCount();
        if ($affected_rows == 1) {
            $message[] = $mk_recsucs;
        }
    }
}

//OPTION 2 - EDTCMP
if ($query_needed == 'G2' AND !$error) {
    // setup SQL
    $sql = "
        UPDATE cor_tbl_cmap
        SET
            nname = ?, 
            description = ?, 
            sourcedb = ?, 
            stecd = ?, 
            import_cre_by = ?, 
            import_cre_on = ?, 
            type = ?, 
            cre_by = ?, 
            cre_on = ? 
        WHERE id = ?
    ";
    $params = array($nickname, $cmap_desc, $source_db, $ste_cd, $import_cre_by, $import_cre_on, $type, $cre_by, $cre_on, $cmap_id);
    if ($dry_run) {
        $message[] = $sql;
    } else {
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        $affected_rows = $sql->rowCount();
        if ($affected_rows == 1) {
            $message[] = $mk_recedtsucs;
        }
    }
}

//OPTION 3 - DELCMP
if ($query_needed == 'G3' AND empty($error)) {
    // not ready yet (or maybe ever)
    echo "Deletion of CMAPs is not possible at this time";
}

//OPTION 4 - ADSXXX Various Add Operations
if ($query_needed == 'G4' AND !$error) {
    // setup the sql
    $sql = "
        INSERT INTO cor_tbl_cmap_structure (
            `cmap`, 
            `tbl`, 
            `col`, 
            `class`, 
            `uid_col`, 
            `itemkey`, 
            `raw_itemval_tbl`, 
            `raw_itemval_col`, 
            `raw_itemval_join_col`, 
            `tbl_itemval_join_col`, 
            `type`, 
            `lang`, 
            `true`, 
            `false`, 
            `notset`,
            `lut_tbl`,
            `lut_idcol`,
            `lut_valcol`,
            `end_source_col`,
            `xmi_itemkey`, 
            `xmi_itemval_col`, 
            `raw_stecd_tbl`, 
            `raw_stecd_col`, 
            `raw_stecd_join_col`, 
            `tbl_stecd_join_col`, 
            `ark_mod`, 
            `log`)
        VALUES (
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?)
    ";
    $params = array($cmap_id, 
        $tbl, 
        $col, 
        $import_class, 
        $uid_col, 
        $itemkey, 
        $raw_itemval_tbl, 
        $raw_itemval_col, 
        $raw_itemval_join_col, 
        $tbl_itemval_join_col, 
        $type, 
        $frmlang, 
        $true, 
        $false, 
        $notset, 
        $lut_tbl, 
        $lut_idcol, 
        $lut_valcol, 
        $end_source_col, 
        $xmi_itemkey, 
        $xmi_itemval_col, 
        $raw_stecd_tbl, 
        $raw_stecd_col, 
        $raw_stecd_join_col, 
        $tbl_stecd_join_col, 
        $ark_mod, 
        $log
    );
    if ($dry_run) {
        $message[] = $sql;
    } else {
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        $affected_rows = $sql->rowCount();
        if ($affected_rows == 1) {
            $message[] = $mk_recsucs;
        }
    }
}

//OPTION 5 - EDSXXX Various Edit Operations
if ($query_needed == 'G5' AND !$error) {
    // setup the sql
    // setup SQL
    $sql = "
        UPDATE cor_tbl_cmap_structure
        SET
            `cmap` = ?,
            `tbl` = ?,
            `col` = ?,
            `class` = ?,
            `uid_col` = ?,
            `itemkey` = ?,
            `raw_itemval_tbl` = ?,
            `raw_itemval_col` = ?,
            `raw_itemval_join_col` = ?,
            `tbl_itemval_join_col` = ?,
            `type` = ?, 
            `lang` = ?, 
            `true` = ?, 
            `false` = ?, 
            `notset` = ?,
            `lut_tbl` = ?,
            `lut_idcol` = ?,
            `lut_valcol` = ?,
            `end_source_col` = ?,
            `xmi_itemkey` = ?,
            `xmi_itemval_col` = ?,
            `raw_stecd_tbl` = ?,
            `raw_stecd_col` = ?,
            `raw_stecd_join_col` = ?,
            `tbl_stecd_join_col` = ?,
            `ark_mod` = ?,
            `log` = ?
        WHERE id = ?
    ";
    $params = array($cmap_id, 
        $tbl, 
        $col, 
        $import_class, 
        $uid_col, 
        $itemkey, 
        $raw_itemval_tbl, 
        $raw_itemval_col, 
        $raw_itemval_join_col, 
        $tbl_itemval_join_col, 
        $type, 
        $frmlang, 
        $true, 
        $false, 
        $notset, 
        $lut_tbl, 
        $lut_idcol, 
        $lut_valcol, 
        $end_source_col, 
        $xmi_itemkey, 
        $xmi_itemval_col, 
        $raw_stecd_tbl, 
        $raw_stecd_col, 
        $raw_stecd_join_col, 
        $tbl_stecd_join_col, 
        $ark_mod, 
        $log,
        $frag_id
    );
if ($dry_run) {
    $message[] = $sql;
} else {
    // Run the Query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $affected_rows = $sql->rowCount();
    if ($affected_rows == 1) {
        $message[] = $mk_recedtsucs;
    }
}
}

//OPTION 6 - DELCMS
if ($query_needed == 'G6' AND !$error) {
    $results =
        delFrag(
            'cmap_structure',
            $del_frag,
            1,
            'NOW()'
    );
    if ($results['success']) {
        $message[] = $mk_recdelsucs;
    }
}

?>
