<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* import/import_functions.php
*
* contains the import functions
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
* @link       http://ark.lparchaeology.com/svn/php/import/import_functions.php
* @since      File available since Release 0.6
*/

// {{{ extrTxt()

/**
 * extracts information from a source (import) database about a text fragment
 *
 * @param object $db  a valid mysql connection
 * @param integer $cmap  the id of the current concordance map
 * @param integer $uid  the id of the column in the source table we are looking at
 * @param array $cmap_struc_info  array containing all of the relevant values from the structure map
 * @param array $cmap_info  array containing all of the relevant values from the concordance map table   
 *
 * @return integer  the new id of the text fragment (or FALSE on error)
 * @author Guy Hunt
 * @author Stuart Eve
 * @since 0.4
 *
 */

function extrTxt($db, $cmap, $uid, $cmap_struc_info, $cmap_info)
{
    global $sql_server, $sql_user, $sql_pwd, $ark_db, $i, $db;
    
    $lang = $cmap_struc_info['lang'];
    $txttype = $cmap_struc_info['type'];
    $itemkey = $cmap_struc_info['itemkey'];
    $raw_itemval_col = $cmap_struc_info['raw_itemval_col'];
    $tbl_itemval_join_col = $cmap_struc_info['tbl_itemval_join_col'];
    $raw_itemval_tbl = $cmap_struc_info['raw_itemval_tbl'];
    $raw_itemval_join_col = $cmap_struc_info['raw_itemval_join_col'];
    $tbl = $cmap_struc_info['tbl'];
    $uid_col = $cmap_struc_info['uid_col'];
    $txt_col = $cmap_struc_info['col'];
    $cre_by = $cmap_info['import_cre_by'];
    $cre_on = dateNow($cmap_info['import_cre_on']);
    $type = $cmap_info['type'];
    $log = $cmap_struc_info['log'];
    $notset = explode(',', $cmap_struc_info['notset']);

    // ste_cd
    $stecd_lut = buildStecdLut($uid, $tbl, $cmap_struc_info);
    $imp_ste_cd = getSteCd($db, $cmap, $stecd_lut);
    
    // $source_db
    $source_db = getCmapDB($db, $cmap);
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
    // $db->dbExecuteQuery$source_db");
    
    // $uid_col
    //check if the uid is a number or a alphanumeric code
    if (!is_numeric($uid) AND substr($uid,0,1) != "'") {
        $uid = "'$uid'";
    }
    //$db
    // No further processing
    
    // $txttype
    // Manually selected from the form. The lut will be populated prior to the import
    
    // $itemkey
    // Manually selected in the form
    
    // $itemval
    $itemval =
        getItemVal(
            $db,
            $imp_ste_cd,
            $raw_itemval_col,
            $tbl_itemval_join_col,
            $raw_itemval_tbl,
            $raw_itemval_join_col,
            $tbl,
            $uid_col,
            $uid
    );
    if (!$itemval) {
        $errs = $errs." Itemval not set on row $uid";
    }
    
    //TXT - $txt_col|$tbl|$uid_col|$uid
    // This is to get the text itself and do any processing on it to prepare it for the insert
    
    $txt=GetSingle($txt_col,$tbl,"$uid_col = $uid");
    
    // Preprocess out blanks and nulls according to user prefs
    if (in_array('BLANK', $notset) && !$txt) {
        $txt = NULL;
    }
    if (in_array($txt, $notset, TRUE)) {
        $txt = NULL;
    }
    // Preprocess the txt to fit into ark
    // $text = someprocess($txt)
    // if (!is_null($txt)) {
    //     $txt = strtolower($txt);
    //     $txt = ucfirst($txt);
    // }
    
    // $cre_by
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $cre_on
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $type
    // This is the action to perform on this text add/edt/del/dry_run
    
    // ---- RUN THE UPDATE ----
    // Dry Runs
    if ($type == 'dry_run' && $txt !== NULL) {
        print("<tr>");
        echo "<td>$i</td>";
        print("<td>$txttype</td>");
        print("<td>$itemkey</td>");
        print("<td>$itemval</td>");
        print("<td>$txt</td>");
        print("<td>$lang</td>");
        print("<td>$cre_by</td>");
        print("<td>$cre_on</td>");
        print("<td>$type</td>");
        print("<td>$log</td>");
        print("</tr>\n");
        // incrememt the counter
        $i++;
    }
    // Live Add
    if ($type == 'add' AND $txt !== NULL) {
        // Run the edtTxt()
        global $ark_db;
        // $db->query("use $ark_db");
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
        $ret =
            addTxt(
                $txttype,
                $itemkey,
                $itemval,
                $txt,
                $lang,
                $cre_by,
                $cre_on
        );
        return ($ret[0]['new_id']);
    }
}

// }}}
// {{{ extrNum()

/**
* extracts numbers and sends to addNum()
*
* @param object $db  a valid mysql connection
* @param integer $cmap  the id of the current concordance map
* @param integer $uid  the id of the column in the source table we are looking at
* @param array $cmap_struc_info  array containing all of the relevant values from the structure map
* @param array $cmap_info  array containing all of the relevant values from the concordance map table   
*
* @return integer  the new id of the text fragment (or FALSE on error)
* @author Guy Hunt
* @author Stuart Eve
* @since 0.4
*
*/

function extrNum($db, $cmap, $uid, $cmap_struc_info, $cmap_info)
{
    global $sql_server, $sql_user, $sql_pwd, $ark_db, $i, $db;
    
    $numtype = $cmap_struc_info['type'];
    $itemkey = $cmap_struc_info['itemkey'];
    $raw_itemval_col = $cmap_struc_info['raw_itemval_col'];
    $tbl_itemval_join_col = $cmap_struc_info['tbl_itemval_join_col'];
    $raw_itemval_tbl = $cmap_struc_info['raw_itemval_tbl'];
    $raw_itemval_join_col = $cmap_struc_info['raw_itemval_join_col'];
    $tbl = $cmap_struc_info['tbl'];
    $uid_col = $cmap_struc_info['uid_col'];
    $source_col = $cmap_struc_info['col'];
    $cre_by = $cmap_info['import_cre_by'];
    $cre_on = dateNow($cmap_info['import_cre_on']);
    $type = $cmap_info['type'];
    $log = $cmap_struc_info['log'];
    $notset = explode(',', $cmap_struc_info['notset']);
    if (array_key_exists('chain',$cmap_struc_info)) {
        $chain = $cmap_struc_info['chain'];
        $chain_itemkey_col = $source_col . '_itemkey';
        $chain_itemval_col = $source_col . '_itemval';
        $chain_itemkey = 'cor_tbl_number';
    }

    // ste_cd
    $stecd_lut = buildStecdLut($uid, $tbl, $cmap_struc_info);
    $imp_ste_cd = getSteCd($db, $cmap, $stecd_lut);

    $source_db = getCmapDB($db, $cmap);
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
    // $db->query("use $source_db");
    
    //check if the uid is a number or a alphanumeric code

     if (!is_numeric($uid) AND substr($uid,0,1) != "'") {
         $uid = "'$uid'";
     }
    
    //$db
    // No further processing
    
    // $numtype
    // Manually selected from the form. The lut will be populated prior to the import
    
    // $itemkey
    // Manually selected in the form
    
    // $itemval
    $itemval =
        getItemVal(
            $db,
            $imp_ste_cd,
            $raw_itemval_col,
            $tbl_itemval_join_col,
            $raw_itemval_tbl,
            $raw_itemval_join_col,
            $tbl,
            $uid_col,
            $uid
    );
    if (!$itemval) {
        $errs = $errs." Itemval not set on row $uid";
    }
    
    //NUM - $source_col|$tbl|$uid_col|$uid
    // This is to get the text itself and do any processing on it to prepare it for the insert
    
    $sql = "
        SELECT $source_col
        FROM $tbl
        WHERE $uid_col = ?
    ";
    $params = array($uid);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $num = $row[$source_col];
    } else {
        printf('Cant get raw number');
    }
    
//     $num = getSingle($source_col, $tbl, "$uid_col = $uid");
    // Preprocess out blanks and nulls according to user prefs
    if (in_array($num, $notset, TRUE)){
        $num = NULL;
    }
    
    // Preprocess the num to fit into ark
    // $num = someprocess($num)
    
    // $cre_by
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $cre_on
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $type
    // This is the action to perform on this text add/edt/del/dry_run
    
    // ---- RUN THE UPDATE ----
    // Dry run
    if ($type == 'dry_run' && $num !== NULL) {
        print("<tr>");
        echo "<td>$i</td>";
        print("<td>$numtype</td>");
        print("<td>$itemkey</td>");
        print("<td>$itemval</td>");
        print("<td>$num</td>");
        print("<td>$cre_by</td>");
        print("<td>$cre_on</td>");
        print("<td>$type</td>");
        print("<td>$log</td>");
        print("</tr>\n");
        if (isset($errs)){
            return($errs);
        }
        // incrememt the counter
        $i++;
    }
    // Live add
    if ($type == 'add' && $num !== NULL) {
        // Run the edtNum()
        global $ark_db, $source_db;    
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
        // $db->query("use $source_db");
        $ret = addNumber($numtype, $itemkey, $itemval, $num, $cre_by, $cre_on, $type, $log);
        if ($chain) {
            //this is going to need to be chained - 
            //therefore insert the new ids into the relevant fields in the import db table
            $source_db = getCmapDB($db, $cmap);
            $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
            $sql = "
                UPDATE $tbl
                SET $chain_itemkey_col = ?, $chain_itemval_col = ?
                WHERE $uid_col = ?
            ";
            $params = array($chain_itemkey,$ret['new_id'],$uid);
            $sql = dbPrepareQuery($sql,__FUNCTION__);
            $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
            
        }
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
        // $db->query("use $source_db");
        return ($ret['new_id']);
    }
}

// }}}
// {{{ extrAttrA()

/**
* extracts type A Atrributes (boolean like attributes)
*
* @param object $db  the source db
* @param string $cmap  the cmap
* @param string $uid  the unique id if this row
* @param array $cmap_struc_info  array of info about the structure
* @param array $cmap_info  array of info about the cmap
* @return string $ret  the new id of the fragment
* @author Guy Hunt
* @since 0.4
*
*/

function extrAttrA($db, $cmap, $uid, $cmap_struc_info, $cmap_info)
{
    global $sql_server, $sql_user, $sql_pwd, $ark_db, $i, $db;
    // Basic set up
    $attribute = $cmap_struc_info['type'];
    $itemkey = $cmap_struc_info['itemkey'];
    $raw_itemval_col = $cmap_struc_info['raw_itemval_col'];
    $tbl_itemval_join_col = $cmap_struc_info['tbl_itemval_join_col'];
    $raw_itemval_tbl = $cmap_struc_info['raw_itemval_tbl'];
    $raw_itemval_join_col = $cmap_struc_info['raw_itemval_join_col'];
    $tbl = $cmap_struc_info['tbl'];
    $uid_col = $cmap_struc_info['uid_col'];
    $bool_col = $cmap_struc_info['col'];
    $cre_by = $cmap_info['import_cre_by'];
    $cre_on = dateNow($cmap_info['import_cre_on']);
    $type = $cmap_info['type'];
    $log = $cmap_struc_info['log'];
    // Set up for this function
    $b_true = explode(',', $cmap_struc_info['true']);
    $b_false = explode(',', $cmap_struc_info['false']);
    $b_notset = explode(',', $cmap_struc_info['notset']);
    $b_arr = array('b_true' => $b_true, 'b_false' => $b_false, 'b_notset' => $b_notset);

    // ste_cd
    $stecd_lut = buildStecdLut($uid, $tbl, $cmap_struc_info);
    $imp_ste_cd = getSteCd($db, $cmap, $stecd_lut);

    $source_db = getCmapDB($db, $cmap);
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
    // $db->query("use $source_db");
    
    //check if the uid is a number or a alphanumeric code

     if (!is_numeric($uid) AND substr($uid,0,1) != "'") {
         $uid = "'$uid'";
     }
    
    //$db
    // No further processing
    
    // $attribute
    // Manually selected from the form. The lut will be populated prior to the import
    
    // $itemkey
    // Manually selected in the form
    
    // $itemval
    $itemval =
        getItemVal(
            $db,
            $imp_ste_cd,
            $raw_itemval_col,
            $tbl_itemval_join_col,
            $raw_itemval_tbl,
            $raw_itemval_join_col,
            $tbl,
            $uid_col,
            $uid
    );
    if (!$itemval) {
        $errs = $errs." Itemval not set on row $uid";
    }
    
    // $cre_by
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $cre_on
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $type
    // This is the action to perform on this text add/edt/del/dry_run
    
    //BOOL - $bool_col|$uid_tbl|$uid_col|$uid
    // This is to get the boolean value and to prepare it for the insert
    
    $sql = "
        SELECT $bool_col
        FROM $tbl
        WHERE $uid_col = ?
    ";
    $params = array($uid);

    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $bv = $row["$bool_col"];
    } else {
        $error[] = 'Cant get raw bool';
    }
    
    // Preprocess the bool to fit into ark ($bo = 1|0|FALSE)
    $bo = FALSE;
    if ($bv === NULL) {
        $bv = 'db_null';
    }
    if (in_array($bv, $b_arr['b_true'], TRUE)) {
        $bo = 1;
    } elseif (in_array($bv, $b_arr['b_false'], TRUE)) {
        $bo = 0;
    } elseif (in_array($bv, $b_arr['b_notset'], TRUE)) {
        $bo = 'notset';
    }
    
    // ---- RUN THE UPDATE ----
    // Dry run
    if ($type == 'dry_run' AND $bo !== 'notset') {
        print("<tr>");
        echo "<td>$i</td>";
        print("<td>$attribute</td>");
        print("<td>$itemkey</td>");
        print("<td>$itemval</td>");
        print("<td>$cre_by</td>");
        print("<td>$cre_on</td>");
        print("<td>$type</td>");
        print("<td>$log</td>");
        print("<td>$bo</td>");
        print("</tr>\n");
        // incrememt the counter
        $i++;
    }
    // Live Add
    if ($type == 'add' AND $bo !== 'notset') {
        global $ark_db;
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
        // $db->query("use $ark_db");
        // Run the addAttr()
        $ret = addAttr($attribute, $itemkey, $itemval, $cre_by, $cre_on, $bo);
        if ($ret[0]['success']) {
                    return ($ret[0]['new_id']);
        } else {
            return(FALSE);
        }
    }
}

// }}}
// {{{ extrAttrB()

/**
* extracting type B Atrributes (attributes linking to lut data)
*
* @param object $db  the source db
* @param string $cmap  the cmap
* @param string $uid  the unique id if this row
* @param array $cmap_struc_info  array of info about the structure
* @param array $cmap_info  array of info about the cmap
* @return string $ret  the new id of the fragment
* @author Guy Hunt
* @since 0.4
*
* NOTE: at v1.1 this was modified to include checks for class and classtype
*
*/
// Function for extracting type B Atrributes (attributes linking to lut data)

function extrAttrB($extract_db, $cmap, $uid, $cmap_struc_info, $cmap_info)
{
    global $sql_server, $sql_user, $sql_pwd, $ark_db, $i, $chain, $db;
    
    $lut_tbl = $cmap_struc_info['lut_tbl'];
    $lut_idcol = $cmap_struc_info['lut_idcol'];
    $lut_valcol = $cmap_struc_info['lut_valcol'];
    $attrtype = $cmap_struc_info['type'];
    $ark_target_lut = 'cor_lut_attribute';
    $source_col = $cmap_struc_info['col'];
    $itemkey = $cmap_struc_info['itemkey'];
    $raw_itemval_col = $cmap_struc_info['raw_itemval_col'];
    $tbl_itemval_join_col = $cmap_struc_info['tbl_itemval_join_col'];
    $raw_itemval_tbl = $cmap_struc_info['raw_itemval_tbl'];
    $raw_itemval_join_col = $cmap_struc_info['raw_itemval_join_col'];
    $tbl = $cmap_struc_info['tbl'];
    $uid_col = $cmap_struc_info['uid_col'];
    $ark_mod = $cmap_struc_info['ark_mod'];
    $lang = $cmap_struc_info['lang'];
    $cre_by = $cmap_info['import_cre_by'];
    $cre_on = dateNow($cmap_info['import_cre_on']);
    $type = $cmap_info['type'];
    $log = $cmap_struc_info['log'];
    $notset = explode(',', $cmap_struc_info['notset']);
    // set up the class and classtype
    $dclass = 'attribute';
    $classtype = $cmap_struc_info['type'];
    // ALWAYS true
    $boolp = 1;
    if (array_key_exists('chain',$cmap_struc_info)) {
        $chain = $cmap_struc_info['chain'];
        $chain_itemkey_col = $source_col . '_itemkey';
        $chain_itemval_col = $source_col . '_itemval';
        $chain_itemkey = 'cor_tbl_attribute';
    }
    
    // ste_cd
    $stecd_lut = buildStecdLut($uid, $tbl, $cmap_struc_info);
    $imp_ste_cd = getSteCd($db, $cmap, $stecd_lut);
    // check if the uid is a number or a alphanumeric code
    
     if (!is_numeric($uid) AND substr($uid,0,1) != "'") {
         $uid = "'$uid'";
     }
    
    //$db
    // No further processing
    
    // ATTRIBUTE - $lut_tbl|$lut_idcol|$lut_id|$lut_valcol
    // First get the current value from the table either a link_ref or raw data (all treated same)
    if ($raw_current_val = getSingle($source_col, $tbl, "$uid_col = $uid"));
        $raw_current_val=mysql_real_escape_string($raw_current_val);
    // Get an Ark number for this based on the fruit of a function
    if (!$raw_current_val OR in_array($raw_current_val, $notset, TRUE)) {
        $attribute = NULL;
    } else {
        $attribute =
            processLutEntry(
                $db,
                $cmap,
                $lut_tbl,
                $lut_idcol,
                $raw_current_val,
                $lut_valcol,
                'cor_lut_attribute',
                $ark_mod,
                $dclass,
                $attrtype,
                $lang,
                $cre_by,
                $cre_on,
                $type
        );
    }
    
    // $itemkey
    // Manually selected in the form
    
    // $itemval

    $itemval =
        getItemVal(
            $db,
            $imp_ste_cd,
            $raw_itemval_col,
            $tbl_itemval_join_col,
            $raw_itemval_tbl,
            $raw_itemval_join_col,
            $tbl,
            $uid_col,
            $uid
    );
    if (!$itemval) {
        $errs = $errs." Itemval not set on row $uid";
    }
    // check if this is the result of a chain - if so the ste_cd should be blank
    if (substr($itemkey,0,7) == 'cor_tbl') {
        // this is a chain, therefore remove the stecd
        $itemval = splitItemVal($itemval);
    }
    // $cre_by
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $cre_on
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $type
    // This is the action to perform on this text add/edt/del/dry_run
    
    // ---- RUN THE UPDATE ----
    
    if ($type == 'dry_run' AND $attribute !== NULL) {
        printf("<tr>");
        echo "<td>$i</td>";
        print("<td>$attribute</td>");
        print("<td>$itemkey</td>");
        print("<td>$itemval</td>");
        print("<td>$cre_by</td>");
        print("<td>$cre_on</td>");
        print("<td>$type</td>");
        print("<td>$log</td>");
        print("<td>$boolp</td>");
        print("</tr>\n");
        // incrememt the counter
        $i++;
    }
    
    if ($type == 'add' AND $attribute !== NULL) {


        // Run the addAttr()
        $ret = addAttr($attribute, $itemkey, $itemval, $cre_by, $cre_on, $boolp);
        if ($chain) {
            //this is going to need to be chained -
            //therefore insert the new ids into the relevant fields in the import db table
            $source_db = getCmapDB($db, $cmap);
            printPre($source_db);
            $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
            $db->query("use $source_db");
            $sql = "
            UPDATE $tbl
            SET $chain_itemkey_col = ?, $chain_itemval_col = ?
            WHERE $uid_col = ?
            ";
            $params = array($chain_itemkey,$ret[0]['new_id'],$uid);
            $sql = dbPrepareQuery($sql,__FUNCTION__ . "adding chain data");
            $sql = dbExecuteQuery($sql,$params,__FUNCTION__. "adding chain data");
        
        }
        return ($ret[0]['new_id']);
    }
}

// }}}
// {{{ extrFrAli()

/**
* extracts Aliases of data fragments
*
* @param object $db  the source db
* @param string $cmap  the cmap
* @param string $uid  the unique id if this row
* @param array $cmap_struc_info  array of info about the structure
* @param array $cmap_info  array of info about the cmap
* @return string $ret  the new id of the fragment
* @author Guy Hunt
* @since 0.4
*
*/

function extrFrAli($db, $cmap, $uid, $cmap_struc_info, $cmap_info, $type=FALSE)
{
    global $sql_server, $sql_user, $sql_pwd, $ark_db, $i, $db;
    
    $source_db = getCmapDB($db, $cmap);
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
    // $db->query("use $source_db");
    // in the case of aliases the itemkey is in effect the name of the table
    $itemkey = $cmap_struc_info['itemkey'];
    $itemval = $cmap_struc_info['itemkey'];
    $col = $cmap_struc_info['col'];
    $tbl = $cmap_struc_info['tbl'];
    $uid_col = $cmap_struc_info['uid_col'];
    $lang = $cmap_struc_info['lang'];
    $raw_itemval_col = $cmap_struc_info['raw_itemval_col'];
    $cre_by = $cmap_info['import_cre_by'];
    $cre_on = dateNow($cmap_info['import_cre_on']);
    $type = $cmap_info['type'];
    // set up the class and classtype
    $dclass = $cmap_struc_info['class'];
    // clean out non std behavoir
    if ($dclass == 'attra' or $dclass == 'attrb') {
        $dclass = 'attribute';
    }
    $classtype = $cmap_struc_info['type'];
    
    // ste_cd
    $stecd_lut = buildStecdLut($uid, $tbl, $cmap_struc_info);
    $imp_ste_cd = getSteCd($db, $cmap, $stecd_lut);
    
    // FIRST - GET BACK THE REAL VALUE

    $realdata= getSingle($col, $tbl, "$uid_col = '$uid'");
    if (!$realdata) {
        print("Real data in $tbl.$col row $uid is blank, FALSE or Null<br/>");
        return(FALSE);
    }
    
    // SECOND - CHECK TO SEE IF THIS IS ALREADY IN THE MAP for this class (tbl) and classtype
    $ark_cmap_data = getCmapData("$tbl.$col", $realdata, $dclass, $classtype);
    if ($ark_cmap_data) {
        $msg = "$lang alias $realdata in CMAP";
    }
    
    // THIRD - If NOT IN THE CMAP CHECK TO SEE IF THIS IS ALREADY IN THE ARK LUT
    if (!$ark_cmap_data) {
        $wherefrag = $realdata;
        $ark_lut_id =
            getLutIdFromData(
                'cor_lut_attribute',
                $lang,
                "AND attributetype = '$classtype' AND cor_tbl_alias.alias = '$wherefrag'"
        );
        if ($ark_lut_id) {
            $ark_cmap_data =
                array(
                    'mapto_id' => $ark_lut_id,
                    'mapto_tbl' => $tbl,
                    'mapto_class' => $dclass,
                    'mapto_classtype' => $classtype,
                    'cre_by' => 'LUT'
            );
            $msg = "$lang alias $realdata in cor_lut_attribute: $ark_lut_id";
        }
    }
    
    // FOURTH - If not in MAP or ARK LUT check to see if the alias can be linked
    if (!$ark_cmap_data) {
        // GET THE EXISTING TABLE AND ID OF THE (EXISTING) DATA TO BE ALIASED
        //$db->query("use $source_db");
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
        $ex_attr = getSingle($raw_itemval_col, $tbl, "$uid_col = $uid");
        // $db->query("use $ark_db");
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
        $ex_attr_id = getSingle('itemvalue', 'cor_tbl_alias', "alias = '$ex_attr'");
        if($itemkey == 'UNKNOWN'){
            $itemkey = getSingle('itemkey', 'cor_tbl_alias', "alias = '$ex_attr'");
        }
        if ($ex_attr_id && $ex_attr) {
            // INSERT THE NEW ALIAS REFERENCING THE EXISTING TABLE AND ID
            $sql = "
                INSERT INTO cor_tbl_alias
                (alias, aliastype, language, itemkey, itemvalue, cre_by, cre_on)
                VALUES 
                (?, ?, ?, ?, ?, ?, NOW())
            ";
            $params = array($realdata, 1, $lang, $itemkey, $ex_attr_id, $cre_by);
            $logvars = "A new value was added to cor_tbl_alias.";
            $logvars .= "The sql: ". serialize($sql);
            $logtype = 'adnali';
            //Handle the alias insert
            if ($type == 'dry_run') {
                $msg = "$lang alias '$realdata' will be added for '$ex_attr'<br/><br/>";
                $msg .= "$sql_alias<br/><br/>";
            } else {
                $sql = dbPrepareQuery($sql,__FUNCTION__);
                $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
                $new_ali_id = $db->lastInsertId();
                $logvars = $logvars."\nThe new alias id is: $new_ali_id";
                logEvent($logtype, $logvars, $cre_by, $cre_on);
                // Add this new value to the cmap_data
                edtCmapData(
                    $db,
                    $cmap,
                    $realdata,
                    "$tbl.$col",
                    $dclass,
                    $classtype,
                    'cor_lut_attribute',
                    $ex_attr_id,
                    $cre_on,
                    $type
                );
                // NOW run chk again to cleanly collect the data
                $ark_cmap_data = getCmapData("$tbl.$col", $realdata, $dclass, $classtype);
                $msg = "$lang alias $realdata has been added for $ex_attr";
            }
        } else {
            $msg = "It can't be added as an alias as there is nothing to link it to.<br/>";
            $msg .= "The value: $ex_attr is not in the table of aliases<br/>";
            $msg .= "Manually add this to the control list<br/>";
        }
    }
    // RETURN
    if (!$ark_cmap_data) {
        //Error
        //Some error handling function (log?)
        // return FALSE;
    }
    // Send some user output
    printf ("The real value is $realdata<br/>$msg<br/><br/>");
}

// }}}
// {{{ extrDate()

/**
* extracts information from a source db and sends this to the edtDate() function
*
* @param object $db  the source db
* @param string $cmap  the cmap
* @param string $uid  the unique id if this row
* @param array $cmap_struc_info  array of info about the structure
* @param array $cmap_info  array of info about the cmap
* @return string $ret  the new id of the fragment
* @author Guy Hunt
* @since 0.4
*
*/

function extrDate($db, $cmap, $uid, $cmap_struc_info, $cmap_info)
{
    global $sql_server, $sql_user, $sql_pwd, $ark_db, $i, $db;
    
    $datetype = $cmap_struc_info['type'];
    $itemkey = $cmap_struc_info['itemkey'];
    $raw_itemval_col = $cmap_struc_info['raw_itemval_col'];
    $tbl_itemval_join_col = $cmap_struc_info['tbl_itemval_join_col'];
    $raw_itemval_tbl = $cmap_struc_info['raw_itemval_tbl'];
    $raw_itemval_join_col = $cmap_struc_info['raw_itemval_join_col'];
    $tbl = $cmap_struc_info['tbl'];
    $uid_col = $cmap_struc_info['uid_col'];
    $source_col = $cmap_struc_info['col'];
    $cre_by = $cmap_info['import_cre_by'];
    $cre_on = dateNow($cmap_info['import_cre_on']);
    $type = $cmap_info['type'];
    $log = $cmap_struc_info['log'];
    $notset = explode(',', $cmap_struc_info['notset']);

    // ste_cd
    $stecd_lut = buildStecdLut($uid, $tbl, $cmap_struc_info);
    $imp_ste_cd = getSteCd($db, $cmap, $stecd_lut);
 
    $source_db = getCmapDB($db, $cmap);
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
    // $db->query("use $source_db");
    
    //check if the uid is a number or a alphanumeric code

     if (!is_numeric($uid) AND substr($uid,0,1) != "'") {
         $uid = "'$uid'";
     }
    
    //$db
    // No further processing
    
    // $datetype
    // Manually selected from the form. The lut must be populated prior to the import
    
    // $itemkey
    // Manually selected in the form
    
    // $itemval
    $itemval =
        getItemVal(
            $db,
            $imp_ste_cd,
            $raw_itemval_col,
            $tbl_itemval_join_col,
            $raw_itemval_tbl,
            $raw_itemval_join_col,
            $tbl,
            $uid_col,
            $uid
    );
    if (!$itemval) {
        $errs = $errs." Itemval not set on row $uid";
    }
    
    //DATE - $source_col|$tbl|$uid_col|$uid
    // This is to get the text itself and do any processing on it to prepare it for the insert

    $date = getSingle($source_col,$tbl,"$uid_col = $uid");
    
    // Preprocess out blanks and nulls according to user prefs
    if (in_array($date, $notset, TRUE)) {
        $date = NULL;
    }
    
    // HACK
    // this should be done before you even try to import the data
    //if ($date != NULL) {
    //    $date = $date.'-00-00 00:00:00';
    //}
    
    // $cre_by
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $cre_on
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $type
    // This is the action to perform on this text add/edt/del/dry_run
    
    // ---- RUN THE UPDATE ----
    // Dry runs
    if ($type == 'dry_run' && $date !== NULL) {
        print("<tr>");
        echo "<td>$i</td>";
        print("<td>$datetype</td>");
        print("<td>$itemkey</td>");
        print("<td>$itemval</td>");
        print("<td>$date</td>");
        print("<td>$cre_by</td>");
        print("<td>$cre_on</td>");
        print("<td>$type</td>");
        print("<td>$log</td>");
        print("</tr>\n");
        if (isset($errs)) {
            return($errs);
        }
        // incrememt the counter
        $i++;
    }
    // Live Add
    if ($type == 'add' && $date !== NULL) {
        // Run the addDate()    $source_db = getCmapDB($db, $cmap);
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
        // $db->query("use $source_db");
        $ret = addDate($datetype, $itemkey, $itemval, $date, $cre_by, $cre_on);
        return ($ret['new_id']);
    }
}

// }}}
// {{{ extrSpan()

/**
* extracts information from a source db and sends this to addSpan()
*
* @param object $db  the source db
* @param string $cmap  the cmap
* @param string $uid  the unique id if this row
* @param array $cmap_struc_info  array of info about the structure
* @param array $cmap_info  array of info about the cmap
* @return string $ret  the new id of the fragment
* @author Guy Hunt
* @since 0.4
*
**/

function extrSpan($db, $cmap, $uid, $cmap_struc_info, $cmap_info)
{
    global $sql_server, $sql_user, $sql_pwd, $ark_db, $i;
    $spantype = $cmap_struc_info['type'];
    $itemkey = $cmap_struc_info['itemkey'];
    $raw_itemval_col = $cmap_struc_info['raw_itemval_col'];
    $tbl_itemval_join_col = $cmap_struc_info['tbl_itemval_join_col'];
    $raw_itemval_tbl = $cmap_struc_info['raw_itemval_tbl'];
    $raw_itemval_join_col = $cmap_struc_info['raw_itemval_join_col'];
    $tbl = $cmap_struc_info['tbl'];
    $uid_col = $cmap_struc_info['uid_col'];
    $beg_source_col = $cmap_struc_info['col'];
    $end_source_col = $cmap_struc_info['end_source_col'];
    $cre_by = $cmap_info['import_cre_by'];
    $cre_on = dateNow($cmap_info['import_cre_on']);
    $type = $cmap_info['type'];
    $log = $cmap_struc_info['log'];

    if (array_key_exists('raw_stecd_col', $cmap_struc_info)) {
        $stecd_lut = buildStecdLut($uid,$tbl,$cmap_struc_info);
        $imp_ste_cd = getSteCd($db, $cmap, $stecd_lut);
    } else {
        $imp_ste_cd = getSteCd($db, $cmap);
    }
 
    $source_db = getCmapDB($db, $cmap);
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
    //$db->query("use $source_db");

    //check if the uid is a number or a alphanumeric code

     if (!is_numeric($uid) AND substr($uid,0,1) != "'") {
         $uid = "'$uid'";
     }
    
    // $db
    // No further processing
    
    // $spantype
    // Manually selected from the cmap. The lut must be populated prior to the import
    
    // $itemkey
    // Manually selected in the form
    
    // ITEMVAL - $raw_itemval_col|$tbl|$uid_col|$uid|$expl|$frag_no
    // First get the raw-itemval for the row we are on within the table we are on
    
   $itemval =
        getItemVal(
            $db,
            $imp_ste_cd,
            $raw_itemval_col,
            $tbl_itemval_join_col,
            $raw_itemval_tbl,
            $raw_itemval_join_col,
            $tbl,
            $uid_col,
            $uid
    );
    if (!$itemval) {
        $errs = $errs." Itemval not set on row $uid";
    }
    
    // $beg
    // Comes raw from the beg_source_col of this table
    $beg = getSingle($beg_source_col, $tbl, "$uid_col = $uid");
    
    // $end
    // Comes raw from the end_source_col of this table
    $end = getSingle($end_source_col, $tbl, "$uid_col = $uid");
    
    // $cre_by
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $cre_on
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $type
    // This is the action to perform on this text add/edt/del/dry_run
    
    // $log
    // Comes raw from cmap_struc to this funct
    

    // check if this is the result of a chain - if so the ste_cd should be blank
    if (substr($itemkey,0,7) == 'cor_tbl') {
        // this is a chain, therefore remove the stecd
        $itemval = splitItemVal($itemval);
    }
    
    // ---- RUN THE UPDATE ----
    // Dry Run
    if ($type == 'dry_run') {
        print("<tr>");
        echo "<td>$i</td>";
        print("<td>$spantype</td>");
        print("<td>$itemkey</td>");
        print("<td>$itemval</td>");
        print("<td>$beg</td>");
        print("<td>$end</td>");
        print("<td>$cre_by</td>");
        print("<td>$cre_on</td>");
        print("<td>$type</td>");
        print("<td>$log</td>");
        print("</tr>\n");
        // incrememt the counter
        $i++;
    }
    // Live Add
    if ($type == 'add') {
        // Run the edtNum()
        global $ark_db;

        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
//         $db->query("use $ark_db");
        $ret = addSpan($spantype, $itemkey, $itemval, $beg, $end, $cre_by, $cre_on);
        return($ret['new_id']);
    }
}

// }}}
// {{{ extrXmi()

/**
* extracts information from a source db and sends this to edtXmi()
*
* @param object $db  the source db
* @param string $cmap  the cmap
* @param string $uid  the unique id if this row
* @param array $cmap_struc_info  array of info about the structure
* @param array $cmap_info  array of info about the cmap
* @return string $ret  the new id of the fragment
* @author Guy Hunt
* @since 0.4
*
*/

function extrXmi($db, $cmap, $uid, $cmap_struc_info, $cmap_info)
{
    global $sql_server, $sql_user, $sql_pwd, $ark_db, $i, $db;
    
    $itemkey = $cmap_struc_info['itemkey'];
    $raw_itemval_col = $cmap_struc_info['raw_itemval_col'];
    $tbl_itemval_join_col = $cmap_struc_info['tbl_itemval_join_col'];
    $raw_itemval_tbl = $cmap_struc_info['raw_itemval_tbl'];
    $raw_itemval_join_col = $cmap_struc_info['raw_itemval_join_col'];
    $tbl = $cmap_struc_info['tbl'];
    $uid_col = $cmap_struc_info['uid_col'];
    $cre_by = $cmap_info['import_cre_by'];
    $cre_on = dateNow($cmap_info['import_cre_on']);
    $type = $cmap_info['type'];
    $log = $cmap_struc_info['log'];
    $xmi_itemkey = $cmap_struc_info['xmi_itemkey'];
    $xmi_itemval_col = $cmap_struc_info['xmi_itemval_col'];
    $notset = explode(',', $cmap_struc_info['notset']);
    
    // $ste_cd
    // This permits multiple site codes to be imported based on a 
    // column in the source table
    // also handle the FALSE keyword
    if ($cmap_struc_info['raw_stecd_col'] && $cmap_struc_info['raw_stecd_col'] != 'FALSE') {
        $stecd_lut = buildStecdLut($uid,$tbl,$cmap_struc_info);
        $imp_ste_cd = getSteCd($db, $cmap, $stecd_lut);
    } else {
        $imp_ste_cd = getSteCd($db, $cmap);
    }
    
    // $source_db
    $source_db = getCmapDB($db, $cmap);
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
    // $db->query("use $source_db");
    
    // $uid_col
    //check if the uid is a number or a alphanumeric code
    if (!is_numeric($uid) AND substr($uid,0,1) != "'") {
        $uid = "'$uid'";
    }
    
    // $db
    // No further processing
    
    // $spantype
    // Manually selected from the cmap. The lut must be populated prior to the import
    
    // $itemkey
    // Manually selected in the form
    
    // ITEMVAL - $raw_itemval_col|$tbl|$uid_col|$uid|$expl|$frag_no
    // $itemval
    $itemval =
        getItemVal(
            $db,
            $imp_ste_cd,
            $raw_itemval_col,
            $tbl_itemval_join_col,
            $raw_itemval_tbl,
            $raw_itemval_join_col,
            $tbl,
            $uid_col,
            $uid
    );
    if (in_array($itemval, $notset, TRUE)) {
        $itemval = NULL;
    }
    if (!$itemval) {
        $errs = $errs." Itemval not set on row $uid";
    }
    
    // $xmi_itemkey
    // Comes manually set from the xmi_item_key of the cmap_struc
    

    // check if this is the result of a chain - if so the ste_cd should be blank
    if (substr($itemkey,0,7) == 'cor_tbl') {
        // this is a chain, therefore remove the stecd
        $itemval = splitItemVal($itemval);
    }
    
    // $list
    // Comes raw from the xmi_itemval_col of this table
    $list = getSingle($xmi_itemval_col, $tbl, "$uid_col = $uid");
    if (in_array($list, $notset, TRUE)) {
        $list = NULL;
    }
    
    // $cre_by
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $cre_on
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $type
    // This is the action to perform on this text add/edt/del/dry_run
    
    // $log
    // Comes raw from cmap_struc to this funct
    
    // ---- RUN THE UPDATE ----
    // Dry run
    if ($type == 'dry_run' && $itemval != NULL && $list != NULL) {
        print("<tr>");
        echo "<td>$i</td>";
        print("<td>$itemkey</td>");
        print("<td>$itemval</td>");
        print("<td>$xmi_itemkey</td>");
        print("<td>$list</td>");
        print("<td>$imp_ste_cd</td>");
        print("<td>$cre_by</td>");
        print("<td>$cre_on</td>");
        print("<td>$type</td>");
        print("<td>$log</td>");
        print("</tr>\n");
        // incrememt the counter
        $i++;
    }
    // Live add
    if ($type == 'add' && $itemval != NULL && $list != NULL) {
        // Run the addXmi()
        global $ark_db;
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
//         $db->query("use $ark_db");
        $ret = addXmi($itemkey, $itemval, $xmi_itemkey, $list, $imp_ste_cd, $cre_by, $cre_on);
        return ($ret[0]['new_id']);
    }
}

// }}}
// {{{ extrKey()

/**
* extracts information from a source (import) database about a standard key
*
* @param object $db  a valid mysql connection
* @param integer $cmap  the id of the current concordance map
* @param integer $uid  the id of the column in the source table we are looking at
* @param array $cmap_struc_info  array containing all of the relevant values from the structure map
* @param array $cmap_info  array containing all of the relevant values from the concordance map table   
* @return string  the new itemvalue (or FALSE on error)
* @author Guy Hunt
* @author Stuart Eve
* @since 0.5
*
*/

function extrKey($db, $cmap, $uid, $cmap_struc_info, $cmap_info)
{
    global $sql_server, $sql_user, $sql_pwd, $ark_db, $i, $db;
    $tbl = $cmap_struc_info['tbl'];
    $uid_col = $cmap_struc_info['uid_col'];
    $source_col = $cmap_struc_info['col'];
    $itemkey = $cmap_struc_info['itemkey'];
    $log = $cmap_struc_info['log'];
    $type = $cmap_info['type'];
    $cre_by = $cmap_info['import_cre_by'];
    $cre_on = dateNow($cmap_info['import_cre_on']);
    $mod_short = reset(explode('_', $itemkey));
    
    // ste_cd
    $stecd_lut = buildStecdLut($uid, $tbl, $cmap_struc_info);
    $imp_ste_cd = getSteCd($db, $cmap, $stecd_lut);
    
    // source_db
    $source_db = getCmapDB($db, $cmap);
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
    // $db->query("use $source_db");
    
    // uid_col
    //check if the uid is a number or a alphanumeric code
    if (!is_numeric($uid)) {
        $uid = "'$uid'";
    }
    
    // $xxx_no - The cleaned up number

    $raw_key=getSingle($source_col,$tbl,"$uid_col = $uid");
    // process this raw key into a true Ark itemkey
    //  1 - strip out any erroneous stuff
    //FIX ME: Not yet implemented
    /*if ($expl && $raw_key) {
        $frags = explode($expl, $raw_itemval);
        $raw_key = $frags[$frag_no];
    }*/
    //  2 - Stick the ste_cd to the front
    $mod_no = $raw_key;
    $mod_cd = $imp_ste_cd.'_'.$raw_key;
    
    // $ste_cd - no further process
    $ste_cd = $imp_ste_cd;
    
    // $cre_by
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $cre_on
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $type
    // This is the action to perform on this text add/edt/del/dry_run
    
    // ---- RUN THE UPDATE ----
    // Dry run
    if ($type == 'dry_run') {
        printf("<tr>");
        echo "<td>$i</td>";
        print("<td>$mod_short</td>");
        print("<td>$mod_cd</td>");
        print("<td>$mod_no</td>");
        print("<td>$ste_cd</td>");
        print("<td>$cre_by</td>");
        print("<td>$cre_on</td>");
        print("<td>$type</td>");
        print("<td>$log</td>");
        print("</tr>\n");
        // incrememt the counter
        $i++;
    }
    // Live add
    if ($type == 'add') {
        // Run the addItemKey()
        global $ark_db;
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
        // $db->query("use $ark_db");
        $ret = addItemKey($mod_short . '_cd', $mod_cd, $cre_by, $cre_on);
        return ($ret['new_itemvalue']);
    }
}

// }}}
// {{{ extrAction()

/**
* extract information from a source db about actors
*
* @param object $db  a valid mysql connection
* @param integer $cmap  the id of the current concordance map
* @param integer $uid  the id of the column in the source table we are looking at
* @param array $cmap_struc_info  array containing all of the relevant values from the structure map
* @param array $cmap_info  array containing all of the relevant values from the concordance map table   
* @return string  the new itemvalue (or FALSE on error)
* @author Guy Hunt
* @author Stuart Eve
* @since 0.5
*
* NOTE: presupposes they are in an addressbook rather than system users, meaning
*       that they are being almost xmi-ed by means of the cor_tbl_action
*
* NOTE: Having looked over this function (21/09/2010) it looks like this could do with some further
* refinement to bring this into line with the other functions. The ability to automatically bring in
* actiontypes seems a bit like overkill. Also the ste_cd is always applied to the values coming in. GH
*
* NOTE: in order to use a fixed action type for all rows, this must be done by specifying
* 'force_ark_lut_id' as the lut_tbl and then putting the id number of the action type into the 
* lut_val_col. GH
*
* Due to these complications, no user interface was implemented for this import type as of v0.8. GH
*
* NOTE: since 1.1 this was renamed extrAction() from extrActionXmi() as this in fact has nothing
* to do with XMIs and non standard naming prevented simple class based function calls GH 26/6/13
*
*/

function extrAction($db, $cmap, $uid, $cmap_struc_info, $cmap_info)
{
    global $sql_server, $sql_user, $sql_pwd, $ark_db, $i, $db;
    // Set up
    $lut_tbl = $cmap_struc_info['lut_tbl'];
    $lut_idcol = $cmap_struc_info['lut_idcol'];
    $lut_valcol = $cmap_struc_info['lut_valcol'];
    $actiontype = $cmap_struc_info['type'];
    $ark_target_lut = 'cor_lut_attribute';
    $source_col = $cmap_struc_info['col'];
    $itemkey = $cmap_struc_info['itemkey'];
    $raw_itemval_col = $cmap_struc_info['raw_itemval_col'];
    $tbl_itemval_join_col = $cmap_struc_info['tbl_itemval_join_col'];
    $raw_itemval_tbl = $cmap_struc_info['raw_itemval_tbl'];
    $raw_itemval_join_col = $cmap_struc_info['raw_itemval_join_col'];
    $tbl = $cmap_struc_info['tbl'];
    $uid_col = $cmap_struc_info['uid_col'];
    $ark_mod = $cmap_struc_info['ark_mod'];
    $lang = $cmap_struc_info['lang'];
    $cre_by = $cmap_info['import_cre_by'];
    $cre_on = dateNow($cmap_info['import_cre_on']);
    $type = $cmap_info['type'];
    $log = $cmap_struc_info['log'];
    $notset = explode(',', $cmap_struc_info['notset']);
    $xmi_itemkey = $cmap_struc_info['xmi_itemkey'];
    $xmi_itemval_col = $cmap_struc_info['xmi_itemval_col'];

    // ste_cd
    $stecd_lut = buildStecdLut($uid, $tbl, $cmap_struc_info);
    $imp_ste_cd = getSteCd($db, $cmap, $stecd_lut);

    $source_db = getCmapDB($db, $cmap);
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
    // $db->query("use $source_db");
    
    //$db
    // No further processing
    
    //check if the uid is a number or a alphanumeric code

     if (!is_numeric($uid) AND substr($uid,0,1) != "'") {
         $uid = "'$uid'";
     }
    // ACTIONTYPE - $lut_tbl|$lut_idcol|$lut_id|$lut_valcol
    // we can either use a look up (like for an attribute) or force the id number
    if ($lut_tbl == 'force_ark_lut_id') {
        $actiontype = $lut_valcol;
    } else {
        // First get the current value from the table either a link_ref or raw data (all treated same)
        $raw_current_val = getSingle($source_col, $tbl, "$uid_col = $uid");
        // Get an Ark number for this based on the fruit of a function
        if (!$raw_current_val OR in_array($raw_current_val, $notset, TRUE)) {
            $actiontype = NULL;
        } else {
            $actiontype =
                processLutEntry (
                    $db,
                    $cmap,
                    $lut_tbl,
                    $lut_idcol,
                    $raw_current_val,
                    $lut_valcol,
                    'cor_lut_actiontype',
                    $ark_mod,
                    'action',
                    $actiontype,
                    $lang,
                    $cre_by,
                    $cre_on,
                    $type
            );
        }
    }
    
    // $itemkey
    // Manually selected in the form
    
    // $itemval
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
    // $db->query("use $source_db");
    $itemval =
        getItemVal(
            $db,
            $imp_ste_cd,
            $raw_itemval_col,
            $tbl_itemval_join_col,
            $raw_itemval_tbl,
            $raw_itemval_join_col,
            $tbl,
            $uid_col,
            $uid
    );
    if (!$itemval) {
        $itemval = " Itemval not set on row $uid";
    }
    
    // $actorkey
    // Manually selected in the form
    $actorkey = $xmi_itemkey;
    
    // $actorval
    // Comes raw from the xmi_itemval_col of this table
    $actor_raw = getSingle($xmi_itemval_col, $tbl, "$uid_col = $uid");
    
    // Preprocess out blanks and nulls according to user prefs
    if (in_array($actor_raw, $notset, TRUE)){
       $actor_raw = NULL;
    }
    

    
    if ($actor_raw != NULL) {
        // Stick the ste_cd to the front
        // ste_cd
        $stecd_lut = buildStecdLut($uid, $tbl, $cmap_struc_info);
        $imp_ste_cd = getSteCd($db, $cmap, $stecd_lut);
        $actorval = $actor_ste_cd.'_'.$actor_raw;
    }

    
    // $cre_by
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $cre_on
    // This should be set by the global cmap to something meaningful and sent prepared to this function
    
    // $type
    // This is the action to perform on this text add/edt/del/dry_run
    
    // ---- RUN THE UPDATE ----
    // Dry run
    if ($type == 'dry_run' AND $actiontype !== NULL AND $actorval) {
        print("<tr>");
        echo "<td>$i</td>";
        print("<td>$actiontype</td>");
        print("<td>$itemkey</td>");
        print("<td>$itemval</td>");
        print("<td>$actorkey</td>");
        print("<td>$actorval</td>");
        print("<td>$cre_by</td>");
        print("<td>$cre_on</td>");
        print("<td>$type</td>");
        print("<td>$log</td>");
        print("</tr>\n");
        // incrememt the counter
        $i++;
    }
    // Live add
    if ($type == 'add' AND $actiontype !== NULL AND $actorval) {
        // Run the edtActor()
        global $ark_db;
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
        // $db->query("use $ark_db");
        $ret =
            addAction(
                $actiontype,
                $itemkey,
                $itemval,
                $actorkey,
                $actorval,
                $cre_by,
                $cre_on
        );
        return ($ret['new_id']);
    }
}

// }}}
// {{{ getCmapData()

/**
* gets data mapping vars from the cmap_data
*
* @param string $sourcelocation  the name of the table that holds the data
* @param string $sourcedata  the data to search for
* @return array $row  the row in the cmap_data table that contains the requested source
* @author Guy Hunt
* @since 0.5
*/

function getCmapData($sourcelocation, $sourcedata, $dclass, $classtype) {
    
    global $db,$sql_server, $sql_user, $sql_pwd,$ark_db;
    
    $tempdb = $db;
    
    $db=dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);

    $where= "WHERE sourcelocation = '$sourcelocation'
            AND sourcedata = '$sourcedata'
            AND mapto_class = '$dclass'
            AND mapto_classtype = '$classtype'
    ";
    $row = getRow('cor_tbl_cmap_data',FALSE, $where);
    
    $db = $tempdb;
    // handle results
    if ($row) {
        return($row);
    } else {
        return(FALSE);
    }
}



// {{{ processLutEntry()

/**
* processes an LUT entry, returning an ID
*
* @param object $db  a valid mysql connection
* TBC
* @return integer  the new id of the text fragment (or FALSE on error)
* @author Guy Hunt
* @since 0.4
*
* Note 1: name getAttId() up to v1.1, but isn't specific to attributes nor is it a get function!
*
*/

function processLutEntry($db, $cmap, $lut_tbl, $lut_idcol, $lut_id, $lut_valcol, $ark_lut, $ark_mod, $dclass, $classtype, $lang, $cre_by, $cre_on, $qtype=FALSE)
{
    // setup
    $ctype_col = $dclass.'type';
    
    // FIRST - GET BACK THE REAL VALUE
    $lutrealdata = getSingle($lut_valcol, $lut_tbl, "$lut_idcol = '$lut_id'");
    if (!$lutrealdata) {
        echo "Cant get real lut value<br/>";
        echo "Table: $lut_tbl - Column: $lut_valcol - WHERE $lut_idcol = '$lut_id'<br/>";
        echo "Clean up this record before import<br/>";
        return(FALSE);
    }
    $lutrealdata=mysql_real_escape_string($lutrealdata);
    // SECOND - CHECK TO SEE IF THIS IS ALREADY IN THE MAP
    $ark_cmap_data = getCmapData("$lut_tbl.$lut_valcol", $lutrealdata, $dclass, $classtype);
    
    // THIRD - If NOT IN THE MAP CHECK TO SEE IF THIS IS ALREADY IN THE ARK LUT
    if (!$ark_cmap_data) {
        $table = $ark_lut;
        $wherefrag=$lutrealdata;
        $ark_lut_id =
            getLutIdFromData(
                $table,
                $lang,
                "AND $ctype_col = '$classtype' AND cor_tbl_alias.alias = '$wherefrag'"
        );
        if ($ark_lut_id) {
            $ark_cmap_data =
                array(
                    'mapto_id' => $ark_lut_id,
                    'mapto_tbl' => $table,
                    'mapto_class' => $dclass,
                    'mapto_classtype' => $classtype,
                    'cre_by' => 'LUT');
        }
    }
    
    // FOURTH - IF NOT IN THE MAP OR THE ARK LUT ADD IT AND ADD TO THE MAP AND CHECK AGAIN
    if (!$ark_cmap_data) {
        // Do an insert to the ark lut and return the new id
        $ark_new_lut_id =
            edtLut(
                $db,
                $ark_lut,
                $lutrealdata,
                $ark_mod,
                $classtype,
                $lang,
                $cre_by,
                $cre_on,
                $qtype
        );
        // Add this new value to the cmap_data
        edtCmapData(
            $db,
            $cmap,
            $lutrealdata,
            "$lut_tbl.$lut_valcol",
            $table,
            $dclass,
            $classtype,
            $ark_new_lut_id,
            $cre_on,
            $qtype
        );
        // NOW run get again to cleanly collect the data
        $ark_cmap_data =
            getCmapData(
                "$lut_tbl.$lut_valcol",
                $lutrealdata,
                $dclass,
                $classtype
        );
    }
    // Return
    if (!$ark_cmap_data) {
        //Error
        //Some error handling function (log?)
    }
    $mapto_id = $ark_cmap_data['mapto_id'];    
    return($mapto_id);
}

// }}}
// {{{ getCmapDB()

/**
* retrieves the name of the source db for a cmap using the id
*
* @param object $db  the current db connection
* @param string $id  the cmap id
* @return void
* @author Guy Hunt
* @since 0.4
*/

function getCmapDB($db, $id)
{
    $where = " id = $id";
    $sourcedb=getSingle("sourcedb", "cor_tbl_cmap", $where);
    if ($sourcedb) {
        return $sourcedb;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getItemVal()

/**
* gets an itemvalue from a source db
*
* @param string $raw_itemval_col
* @param string $raw_itemval_tbl
* @param string $raw_itemval_join_col
* @param string $tbl_itemval_join_col
* @param string $uid_tbl
* @param string $uid_col
* @param string $uid
* @return string $itemval  an ARK itemvalue
* @author Guy Hunt
* @since 0.5
*
* This function can make up the 
*/

function getItemVal($db, $imp_ste_cd, $raw_itemval_col, $tbl_itemval_join_col, $raw_itemval_tbl, $raw_itemval_join_col, $tbl, $uid_col, $uid)
{
    
    //check if the uid is a number or a alphanumeric code
    if (!is_numeric($uid) AND substr($uid,0,1) != "'") {
        // if a string wrap it in quotes for mysql
        $uid = "'$uid'";
    }
    // Set up SQL
    if ($raw_itemval_tbl == 'FALSE') {
        /*
        $sql = "
            SELECT $raw_itemval_col
            FROM $tbl
            WHERE $uid_col = $uid
        ";
        */ 
        $raw_itemval=getSingle($raw_itemval_col,$tbl,"$uid_col = $uid");
    } else {
        /*
        $sql = "
            SELECT $raw_itemval_tbl.$raw_itemval_col
            FROM $raw_itemval_tbl, $tbl
            WHERE $tbl.$tbl_itemval_join_col = $raw_itemval_tbl.$raw_itemval_join_col
            AND $tbl.$uid_col = $uid
        ";
        */ 
        $where = "$tbl.$tbl_itemval_join_col = $raw_itemval_tbl.$raw_itemval_join_col
                  AND $tbl.$uid_col = $uid";
        $raw_itemval=getSingle($raw_itemval_tbl.".".$raw_itemval_col,$raw_itemval_tbl.", ".$tbl,$where);
    }
    // Second - process this raw key into a true Ark itemkey
    $test_ste_cd = splitItemval($raw_itemval, TRUE);
    if ($raw_itemval_col != 'ark_id' OR $test_ste_cd != $imp_ste_cd ) {
        //  1 - Stick the ste_cd to the front
        $itemval = $imp_ste_cd.'_'.$raw_itemval;
    } else {
        $itemval = $raw_itemval;
    }
    // Third - return
    return ($itemval);
}

// }}}
// {{{ chkForField()

/**
* check the cmap for a field
*
* @param object $db  a valid db connection
* @param string $cmap  the cmap
* @param string $tbl  the table
* @param string $col  the colum
* @return void
* @author Guy Hunt
* @since 0.4
*
*/
function chkForField($db, $cmap, $tbl, $col)
{
    $where= "where tbl = '$tbl'
        AND col = '$col'
        AND cmap = $cmap
    ";
    $row= getRow("cor_tbl_cmap_structure", FALSE, $where);
    if ($row){
        return $row;  
    }else{
        return (FALSE);
    }
}

//this function is used to build the stecdlut array for use with getSteCd

function buildStecdLut($uid, $table, $cmap_struc_info)
{
    $stecd_lut['uid'] = $uid;
    $stecd_lut['tbl'] = $table;
    $stecd_lut['uid_col'] = $cmap_struc_info['uid_col'];
    $stecd_lut['raw_stecd_tbl'] = $cmap_struc_info['raw_stecd_tbl'];
    $stecd_lut['raw_stecd_col'] = $cmap_struc_info['raw_stecd_col'];
    $stecd_lut['raw_stecd_join_col'] = $cmap_struc_info['raw_stecd_join_col'];
    $stecd_lut['tbl_stecd_join_col'] = $cmap_struc_info['tbl_stecd_join_col'];
    return $stecd_lut;
}

?>
