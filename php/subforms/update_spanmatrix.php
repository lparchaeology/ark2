<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* This script is the companion update form for the Span Matrix subform
*
* This file contains the subform which sorts out the update stuff for a matrix based 
* on span type which is defined in cor_lut_spantype and is inserted into the 
* configuration settings as 'op_spantype' => 'NAME OF SPANTYPE'
* The labels must be defined in cor_lut_spanlabels and have aliases that are of 
* aliastype 1 (normal) or 2 (against).
*
* PHP versions 4 and 5
*
* LICENSE: This source file is subject to version 3.0 of the PHP license
* that is available through the world-wide-web at the following URI:
* http://www.php.net/license/3_0.txt.  If you did not receive a copy of
* the PHP License and are unable to obtain it through the web, please
* send a note to license@php.net so we can mail you a copy immediately.
*
* @category   CategoryName
* @package    ark
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Henriette Roued Olsen <henrietteroued@gmail.com>
* @copyright  1999 - 2007 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/LICENSE
* @version    CVS: $Id:$
* @link       http://ark.lparchaeology.com
* @see        NetOther, Net_Sample::Net_Sample()
* @since      File available since Release 0.6
*
* NOTE: Since 0.6 this script has bee globalised by HRO. In order to globalise span label
* checking the set up var is now called $conf_XXX_tvclab where XXX=mod. This should be
* set true for complex rule based checking of relationships. This only applies to the matrix
* not to the simple span adding
*
* NOTE 2: Since 0.6 this script has been renamed sf_spanmatrix.php to reflect the name of the
* dataclass in the subform name as per the new naming convention for sf scripts
*
*/

// ---------- Get Markup ------------

$mk_err_nocxtno = getMarkup('cor_tbl_markup', $lang, 'err_nocxtno');
$mk_err_nocxttype = getMarkup('cor_tbl_markup', $lang, 'err_nocxttype');
$mk_err_noorigby = getMarkup('cor_tbl_markup', $lang, 'err_noorigby');
$mk_err_dategen = getMarkup('cor_tbl_markup', $lang, 'err_dategen');
$mk_err_tvectbeg = getMarkup('cor_tbl_markup', $lang, 'err_tvectbeg');
$mk_err_tvectbeginvalid = getMarkup('cor_tbl_markup', $lang, 'err_tvectbeginvalid');
$mk_err_tvectend = getMarkup('cor_tbl_markup', $lang, 'err_tvectend');
$mk_err_tvectendinvalid = getMarkup('cor_tbl_markup', $lang, 'err_tvectendinvalid');
$mk_err_tvectlab = getMarkup('cor_tbl_markup', $lang, 'err_tvectlab');
$mk_err_spnlablinvalid = getMarkup('cor_tbl_markup', 'en', 'err_spnlablinvalid');
$mk_err_nospanid = getMarkup('cor_tbl_markup', $lang, 'err_nospanid');
$mk_err_duprel = getMarkup('cor_tbl_markup', $lang, 'err_duprel');

//check if this is an anonymous login - if it is then prevent the edits
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    $error[]['vars'] = "Sorry, you are not authorised to edit the data.";
}

// In order to use validation funcs we make use of some of the preset rules
// itemval - request and chkSet
$beg_vars =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'beg',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);
$end_vars =
    array(
        'rq_func' => 'reqItemVal',
        'vd_func' => 'chkSet',
        'var_name' => 'itemval',
        'lv_name' => 'end',
        'var_locn' => 'request',
        'req_keytype' => 'auto',
        'ret_keytype' => 'cd'
);

// ---- REQUEST AND VALIDATION ---- //

if ($update_db == 'sprlad') {
    
    // trip the query needed switch
    $query_needed = 4;
    
    // request variables
    $mod_cd = reqQst($_REQUEST, "$item_key");
    $beg = reqItemVal($beg_vars);
    $end = reqItemVal($end_vars);
    $spanlabelid = reqQst($_REQUEST, 'spanlabelid');
    $spantype = reqQst($_REQUEST, 'spantype');
    // FIX ME: As of 0.6 this request is commented out. This means that the form will
    // pick up the global $item_key for this page. THis is fine as long as this form is
    // not ever used embedded. The prefered method would be to use a preset reqItemKey
    // rule
    // $item_key = 'cxt_cd';
    $ste_cd = reqQst($_SESSION, 'ste_cd');
    $cre_by = $user_id;
    $cre_on = 'NOW()';
    
    // evaluate variables
    //MOD_CD (Itemval)
    // 1 - MUST BE SET
    if (!$mod_cd) {
        $error[] = array('field' => 'itemval', 'vars' => "$mk_err_nocxtno");
    }
    //BEG
    // 1 - MUST BE SET
    if (!$beg) {
        $error[] = array('field' => 'beg', 'vars' => "$mk_err_tvectbeg : $beg");
    }
    //BEG
    // 3 - MUST BE VALID IN THIS SITE CODE
    if (chkValid($beg, $ste_cd, FALSE, $mod_short . '_tbl_' . $mod_short, $item_key)) {
        $error[] = array('field' => 'beg', 'vars' => "$mk_err_tvectbeginvalid : $beg");
    }
    //END
    // 1 - MUST BE SET
    if (!$end) {
        $error[] = array('field' => 'end', 'vars' => "$mk_err_tvectend : $end");
    }
    //END
    // 3 - MUST BE VALID IN THIS SITE CODE
    if (chkValid($end, $ste_cd, FALSE, $mod_short . '_tbl_' . $mod_short, $item_key)) {
        $error[] = array('field' => 'end', 'vars' => "$mk_err_tvectendinvalid : $end");
    }
    
    // OPTION FOR FANCY MATRICES
    if ($conf_att == 'on') {
        //SPANLABELID
        // 1 - MUST BE SET
        if (!$spanlabelid) {
            $error[] = array('field' => 'lab', 'vars' => "$mk_err_tvectlab");
        }
        if ($spanlabelid AND $beg AND $end) {
            //SPANLABELID
            // 2 - MUST BE VALID (MUST BE SET TO CHECK VALIDITY CORRECTY)
            if (chkValid($spanlabelid, FALSE, FALSE, 'cor_lut_spanlabel', 'id')) {
                $error[] = array('field' => 'lab', 'vars' => "$mk_err_tvectlab");
            }
        }
    }
    //UNIQUENESS
    $sql = "
        SELECT id
        FROM cor_tbl_span
        WHERE itemkey = ?
        AND itemvalue = ?
        AND beg = ?
        AND end = ?
        AND spantype = ?
    ";
    $params = array($item_key,$mod_cd,$beg,$end, $spantype);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);

    if ($sql->rowCount() > 0) {
        $error[] = array('field' => 'flag', 'vars' => "$mk_err_duprel");
    } else {
        // blank
    }
}

if ($update_db == 'matadd') {
    
    // trip the query needed switch
    $query_needed = 5;
    
    // request variables
    $mod_cd = reqQst($_REQUEST, "$item_key");
    $beg = reqItemVal($beg_vars);
    $end = reqItemVal($end_vars);
    $spanlabelid = reqQst($_REQUEST, 'spanlabelid');
    $spantype = $conf_span_id;
    //FIX ME: See comment above
    // $item_key = 'cxt_cd';
    $ste_cd = $_SESSION['ste_cd'];
    $cre_by = $user_id;
    $cre_on = 'NOW()';
    // evaluate variables
    //CXT_CD
    // 1 - MUST BE SET
    if (!$mod_cd) {
        $error[] = array('field' => 'mod_cd', 'vars' => "$mk_err_nocxtno");
    }
    //BEG
    // 1 - MUST BE SET
    if (!$beg) {
        $error[] = array('field' => 'beg', 'vars' => "$mk_err_tvectbeg : $beg");
    }
    //BEG
    // 3 - MUST BE VALID IN THIS SITE CODE
    if (chkValid($beg, $ste_cd, FALSE, $mod_short . '_tbl_' . $mod_short, $item_key)) {
        $error[] = array('field' => 'beg', 'vars' => "$mk_err_tvectbeginvalid : $beg");
    }
    //END
    // 1 - MUST BE SET
    if (!$end) {
        $error[] = array('field' => 'end', 'vars' => "$mk_err_tvectend : $end");
    }
    //END
    // 3 - MUST BE VALID IN THIS SITE CODE
    if (chkValid($end, $ste_cd, FALSE, $mod_short . '_tbl_' . $mod_short, $item_key)) {
        $error[] = array('field' => 'end', 'vars' => "$mk_err_tvectendinvalid : $end");
    }
    
    // OPTION FOR FANCY MATRICES
    if ($conf_att == 'on') {
        //SPANLABELID
        // 1 - MUST BE SET
        if (!$spanlabelid) {
            $error[] = array('field' => 'lab', 'vars' => "$mk_err_tvectlab");
        }
        if ($spanlabelid AND $beg AND $end) {
            //SPANLABELID
            // 2 - MUST BE VALID (MUST BE SET TO CHECK VALIDITY CORRECTY)
            if (chkValid($spanlabelid, FALSE, FALSE, 'cor_lut_spanlabel', 'id')) {
                $error[] = array('field' => 'lab', 'vars' => "$mk_err_tvectlab");
            }
            //SPANLABELID
            // 3 - MUST BE VALID FOR THIS TVECT TYPE
            // NOTE: if this matrix does not use or not need labels set this var FALSE in your
            // settings file for the module
            $conf = 'conf_'.$mod_short.'_tvclab';
            if (isset($$conf)) {
                if ($chk_res = chkCxtSpanlabel($ste_cd, $beg, $end, $spanlabelid, $conf_tvclab)) {
                    $error[] = array('field' => 'lab', 'vars' => "$mk_err_spnlablinvalid");
                }
            }
            unset ($conf);
        }
    }
    //UNIQUENESS
    $sql = "
        SELECT id
        FROM cor_tbl_span
        WHERE itemkey = ?
        AND itemvalue = ?
        AND beg = ?
        AND end = ?
        AND spantype = ?
    ";
    $params = array($item_key, $mod_cd, $beg, $end, $spantype);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);

    if ($sql->rowCount() > 0) {
        $error[] = array('field' => 'flag', 'vars' => "$mk_err_duprel");
    } else {
        //blank
    }
}
// ---- EXECUTE ---- //

//OPTION 4 - SPRLAD
// Used when adding spans that are not matrix like

if ($query_needed == 4 && !$error) {
    //make the insert and fill this value with the new id
    $results = addSpan($spantype, $item_key, $mod_cd, $beg, $end, $cre_by, $cre_on);
    $new_span_id = $results['new_id'];
    if ($new_span_id) {
        // Set up the attr edit
        addSpanAttr($new_span_id, $spanlabelid, $cre_by, $cre_on);
    }
}

//OPTION 5 - MATADD
// Used when adding spans that will for a matrix

if ($query_needed == 5 && !$error) {
    //make the insert and fill this value with the new id
    $results = addSpan($spantype, $item_key, $mod_cd, $beg, $end, $cre_by, $cre_on);
    $new_span_id = $results['new_id'];
    if ($conf_att == 'on' && $new_span_id) {
        // Set up the attr edit
        addSpanAttr($new_span_id, $spanlabelid, $cre_by, $cre_on);
    }
}

?>
