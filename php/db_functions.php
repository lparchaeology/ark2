<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* db_functions.php
*
* These functions use the PDO package for php
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
* @category   base
* @package    ark
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Michael Johnson <m.johnson@lparchaeology.com>
* @copyright  1999-2013 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/db_functions.php
* @since      File available since Release 1.1
*
* Note: Until v1.1 this file was called get_functions.php. Since v1.1 this is
* expanded to contain all the functions that interact directly with the DB
*
*/

// {{{ dbConnect()

/**
 * connects to a MySQL server, selects the specified DB and sets the client set to UTF8
 *
 * @param string $sql_server  the MySQL server to connect to
 * @param string $sql_user  the MySQL user to connect with
 * @param string $sql_pwd  the password of the $sql_user
 * @param string $ark_db  the name of the database to select
 * @return object $db  the $db object used in other functions
 * @author Guy Hunt
 * @author Stuart Eve
 * @since 0.6
 *
 * Note: this db connect function was an inc script from v0.1 to 0.6.
 * Note: as of ARK v1.1.1 this has been updated to use the PDO connection
 *
 */

function dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db)
{
   $db = NULL;
   // connect to the DB server
    try {
        $db = new PDO("mysql:host=$sql_server;dbname=$ark_db;charset=utf8", $sql_user, $sql_pwd,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        //  now set the appropriate exception modes, etc.
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch(PDOException $ex) {
        // make up error string
        $err = "Error making db connection to $sql_server ";
        $password = "";
        foreach (str_split($sql_pwd) as $id => $dummy){
            if($id==0 || $id == (strlen($sql_pwd)-1)){
                $password .= $dummy;
            } else {
                $password .="*";
            }
        }
        $err .= "using user: $sql_user and password $password server returned error:<br/>";
        dbError($ex->getMessage(),$err);
    }
    // return
    return ($db);
}

// }}}
// {{{ dbPrepareQuery()

/**
 * This function prepares a DBO sql statement
 *
 * @param string $sql_statement - an sql statement prepared for use with PDO 
 * @param string $func - the function name (to be used in any error messages)
 * @return object $sql - the resulting PDOStatement object
 * @author Stuart Eve
 * @since 1.1.1
 *
 *
 */

function dbPrepareQuery($sql_statement,$func)
{
    global $db;
    try {
        $sql = $db->prepare($sql_statement);
    } catch(PDOException $ex) {
        // make up error string
        $err = "Error in query $func";
        dbError($ex->getMessage(),$err);
    }
    if (!isset($sql)){
        // for debuggery
        printPre(array('sql'=>$sql_statement,'func'=>$func));
        return FALSE;
    }
    return $sql;
}
// }}} dbPrepareQuery()
// {{{ dbExecuteQuery()

/**
 * This function executes a DBO sql statement
 *
 * @param object $sql - a properly prepared PDOStatement object (made using dbPrepareQuery())
 * @param array $params - an array that contains the parameters for the query
 * @param string $func - the function name (to be used in any error messages)
 * @return object $sql - the resulting PDOStatement object
 * @author Stuart Eve
 * @since 1.1.1
 *
 *
 */

function dbExecuteQuery($sql,$params,$func)
{
    try {
        $sql->execute($params);
    } catch(PDOException $ex) {
        // make up error string
        $err = "Error in query $func";
        dbError($ex->getMessage(),$err);
    }
    return $sql;
}
// }}} dbExecuteQuery()
// {{{ dbError()

/**
 * This function catches a PDO exception and deals with it appropriately
 *
 * @param string $ex->getMessage()
 * @param string $err OPTIONAL - any extra error messaging that may be useful
 * @author Stuart Eve
 * @since 1.1.1
 *
 * DEV NOTE: this could log to file if we wanted - it is probably insecure to print SQL to screen
 *
 */

function dbError($ex,$err = "")
{
    echo "An Error occurred!"; //user friendly message;
    echo "$err $ex";
}
// }}} dbError()
// {{{ dbRunAddQuery()

/**
 * Runs a DB query, logs if requested, and returns a result array
 *
 * @param string $table The table to insert into
 * @param array $fields The fields to insert
 * @param array $values The values to set the fields to
 * @param string $logtype  The query type to log
 * @param string $log_by  The author of the query
 * @param string $log_on  The timestamp of the query
 * @param string $function  The function name (to be used in any error messages)
 * @return array $result  An array containing results info
 * @author John Layt
 * @since 2.0
 *
 */

function dbRunAddQuery($table, $fields, $values, $logtype, $log_by, $log_on, $function)
{
    global $db, $log;
    // Create the sql
    $fl = implode(', ', $fields);
    $vl = str_repeat('?, ', count($fields) - 1).'?';
    $sql = "
        INSERT INTO $table ($fl)
        VALUES ($vl)
    ";
    // Execute the query
    $stmt = dbPrepareQuery($sql, $function);
    $stmt = dbExecuteQuery($stmt, $values, $function);
    // Prepare the results
    if ($stmt->errorCode() == '00000') {
        $results['new_id'] = $db->lastInsertId();
        $results['success'] = TRUE;
        $results['sql'] = $stmt;
    } else {
        $results['new_id'] = FALSE;
        $results['success'] = FALSE;
        $results['failed_sql'] = $stmt;
    }
    if ($log == 'on') {
        $logvars = 'The sql: '. json_encode($stmt);
        logEvent($logtype, $logvars, $log_by, $log_on);
    }
    return ($results);
}

// }}}
// {{{ dbTimestamp()
/**
 * Returns the db timestamp
 *
 * @param string $timestamp  The timestamp, NOW(), or blank
 * @return string $timestamp  The timestamp
 * @author John Layt
 * @since 2.0
 *
 */

function dbTimestamp($timestamp = NULL)
{
    if (!$timestamp || $timestamp == "NOW()") {
        return gmdate("Y-m-d H:i:s", time());
    }
    return $timestamp;
}
// }}}
// {{{ addAttr()

/**
 * gives add functionality for attributes
 *
 * @param string $attribute  the id of the attribute
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param string $cre_by  the author of this snippet
 * @param string $cre_on  the create date of this snippet
 * @param boolean $bv  TRUE or FALSE
 * @return array $result  an array containing results info
 * @author Guy Hunt
 * @since 0.6
 *
 * NOTE: since 0.6 this has taken add functionality from edtAttr()
 *
 * NOTE: this adds to the cor_tbl_attribute. It does not add to the look up
 * table of attributes.
 *
 */

function addAttr($attribute, $itemkey, $itemvalue, $cre_by, $cre_on, $bv = FALSE)
{
    // config error handling
    if (! $attribute or ! $itemkey or ! $itemvalue or ! $cre_by or ! $cre_on) {
        echo "addAttr: one of the required params is missing";
        return FALSE;
    }

    // prepare the SQL statement
    $cre_on = dbTimestamp($cre_on);
    $table = 'cor_tbl_attribute';
    $fields = array('attribute', 'boolean', 'itemkey', 'itemvalue', 'cre_by', 'cre_on');
    $values = array($attribute, $bv, $itemkey, $itemvalue, $cre_by, $cre_on);
    $logtype = 'addatr';

    // Run the query
    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addAction()

/**
 * adds actions to cor_tbl_action
 *
 * @param int $actiontype  the classtype number
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemval
 * @param string $actor_itemkey  the actor itemkey
 * @param string $actor_itemvalue  the actor itemval
 * @param string $cre_by  the cre by
 * @param string $cre_on  the cre on
 * @return array $result  an array containing results info
 * @author Guy Hunt
 * @since 0.3
 *
 */

function addAction($actiontype, $itemkey, $itemvalue, $actor_itemkey, $actor_itemvalue, $cre_by, $cre_on)
{
    // setup the sql
    $cre_on = dbTimestamp($cre_on);
    $able = 'cor_tbl_action';
    $fields = array('actiontype', 'itemkey', 'itemvalue', 'actor_itemkey', 'actor_itemvalue', 'cre_by', 'cre_on');
    $values = array($actiontype, $itemkey, $itemvalue, $actor_itemkey, $actor_itemvalue, $cre_by, $cre_on);
    $logtype = 'actadd';
    // run query
    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addAlias()

/**
 * add a new Alias
 * 
 * @param string $new_alias the Alias to be added
 * @param string $new_attr_id the id of the item being alias'd
 * @param string $alias_table the table that contains the item being alias'd
 * @param string $lang the alias language
 * @param string $cre_by creator
 * @param string $cre_on date created
 * @return array standard ark results info
 */
function addAlias($new_alias, $new_attr_id, $alias_table, $lang, $cre_by, $cre_on)
{
    // NOW DO THE ALIAS
    $cre_on = dbTimestamp($cre_on);
    $table = 'cor_tbl_alias';
    $fields = array('alias', 'aliastype', 'language', 'item_key', 'itemvalue', 'cre_by', 'cre_on');
    $values = array($new_alias, 1, $lang, $alias_table, $new_attr_id, $cre_by, $cre_on);
    $logtype = 'adnali';

    // Run the query
    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addDate()

/**
 * adds dates
 *
 * @param string $datetype  the id of the datetype
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param string $date  the date to add
 * @param string $cre_by  the new frag creator
 * @param string $cre_on  the new date of creation
 * @return array $result  an array containing results info
 * @author Guy Hunt
 * @since 0.6
 *
 */

function addDate($datetype, $itemkey, $itemvalue, $date, $cre_by, $cre_on) {
    // setup sql
    $cre_on = dbTimestamp($cre_on);
    $table = 'cor_tbl_date';
    $fields = array('datetype', 'itemkey', 'itemvalue', 'date', 'cre_by', 'cre_on');
    $values = array($datetype, $itemkey, $itemvalue, $date, $cre_by, $cre_on);
    $logtype = 'datadd';

    // run query
    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addFile

/**
 * makes insert queries for the dataclass file
 *
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param int $file  the id of the file (from cor_lut_file)
 * @param string $cre_by  the author of this snippet
 * @param string $cre_on  the create date of this snippet
 * @return array $results containing useful feedback including 'success' containing TRUE or FALSE
 * @author Guy Hunt
 * @since 0.6
 *
 */

function addFile($itemkey, $itemvalue, $file, $cre_by, $cre_on)
{
    $cre_on = dbTimestamp($cre_on);
    $table = 'cor_tbl_file';
    $fields = array('itemkey', 'itemvalue', 'file', 'cre_by', 'cre_on');
    $values = array($itemkey, $itemvalue, $file, $cre_by, $cre_on);
    $logtype = 'addfil';
    // Run the query
    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addItemKey()

/**
 * inserts the database entry for an itemkey in all modules
 *
 * @param string $itemkey  the itemkey of the new item
 * @param string $itemvalue  the itemvalue of the new item
 * @param string $cre_by  the user_id of the record creator
 * @param string $cre_on  the creation date for this record
 * @param string $modtype  the modtype (if this module is using types)
 * @return array $result  containing number of affected rows and 'success' set true or false
 * @author Guy Hunt
 * @since 0.1
 *
 */

function addItemKey($itemkey, $itemvalue, $cre_by, $cre_on, $modtype = FALSE)
{
    $mod_short = splitItemkey($itemkey);
    $table = $mod_short.'_tbl_'.$mod_short;
    $mod_cd = $mod_short.'_cd';
    $mod_no = $mod_short.'_no';
    $modtypename = $mod_short.'type';
    $mod_no_val = splitItemval($itemvalue);
    $ste_cd = splitItemval ( $itemvalue, TRUE );
    if ($mod_no_val == 'next') {
        $mod_no_val = getSingle("MAX($mod_no)", $table, 'ste_cd = "'.$ste_cd."\"") + 1;
        $itemvalue = $ste_cd.'_'.$mod_no_val;
    }
    // SQL (if we are using modtypes it is a little different)
    $cre_on = dbTimestamp($cre_on);
    if ($modtype) {
        $fields = array($mod_cd, $mod_no, 'ste_cd', $modtypename, 'cre_by', 'cre_on');
        $values = array($itemvalue, $mod_no_val, $ste_cd, $modtype, $cre_by, $cre_on);
    } else {
        $fields = array($mod_cd, $mod_no, 'ste_cd', 'cre_by', 'cre_on');
        $values = array($itemvalue, $mod_no_val, $ste_cd, $cre_by, $cre_on);
    }
    $logtype = 'keyadd';
    // run the query
    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addMap()

function addMap($map, $cre_by,$cre_on)
{
    global $default_site_cd;
    $ste_cd= reqArkVar('ste_cd', $default_site_cd);
    $table = 'cor_tbl_map';
    // TODO Make id AUTO-INCREMENT
    $next = getSingle("MAX(id)", $table, '1') + 1;
    $cre_on = dbTimestamp($cre_on);
    $fields = array('id', 'cre_by', 'cre_on');
    $values = array($next, $cre_by, $cre_on);
    $logtype = 'addmap';

    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}
// {{{ addMapLayer()

function addMapLayer($map, $cre_by)
{
    $table = 'cor_tbl_maplayer';
    // TODO Make id AUTO-INCREMENT
    $next = getSingle("MAX(id)", $table, '1') + 1;
    $cre_on = dbTimestamp('NOW()');
    $fields = array('id', 'map', 'cre_by', 'cre_on');
    $values = array($next, $map, $cre_by, $cre_on);
    $logtype = 'addmapl';

    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addMarkup()

/**
 * adds markup
 *
 * @param string $nname the nickname of the markup
 * @param string $markup the markup to add
 * @param string $mod_short the module of the markup
 * @param string $lang the language of the markup
 * @param string $description the description of the markup
 * @param string $cre_by the new markup creator
 * @param string $cre_on the new date of creation
 * @return array $results containing useful feedback including 'success' containing TRUE or FALSE
 * @author Stuart Eve
 * @since 0.6
 *
 */

function addMarkup($nname, $markup, $mod_short, $lang, $description, $cre_by, $cre_on)
{
    // setup sql
    $cre_on = dbTimestamp($cre_on);
    $table = 'cor_tbl_markup';
    $fields = array('nname', 'markup', 'mod_short', 'language', 'description', 'cre_by', 'cre_on');
    $values = array($nname, $markup, $mod_short, $lang, $description, $cre_by, $cre_on);
    $logtype = 'addmrk';
    // run query
    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addNumber()

/**
 * adds a number
 *
 * @param string $numtype the id of the numbertype
 * @param string $itemkey the itemkey
 * @param string $itemvalue the itemvalue
 * @param string $num the number to insert
 * @param string $cre_by the author of this snippet
 * @param string $cre_on the create date of this snippet
 * @return void
 * @author Guy Hunt
 * @since 0.6
 *
 */

function addNumber($numtype, $itemkey, $itemvalue, $num, $cre_by, $cre_on)
{
    // make sql
    $cre_on = dbTimestamp($cre_on);
    $table = 'cor_tbl_number';
    $fields = array('numbertype', 'itemkey', 'itemvalue', 'number', 'cre_by', 'cre_on');
    $values = array($numtype, $itemkey, $itemvalue, $num, $cre_by, $cre_on);
    $logtype = 'numadd';
    // run query
    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addSpan()

/**
 * adds a span to cor_tbl_span
 *
 * @param string $spantype  the type number (id of row in cor_lut_spantype)
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param string $beg  the beg column value
 * @param string $end  the end column value
 * @param string $cre_by  the frag creator user_id
 * @param string $cre_on  the frag creation datetime
 * @return array $results  containing standardised results vars
 * @author Guy Hunt
 * @since 0.6
 *
 */

function addSpan($spantype, $itemkey, $itemvalue, $beg, $end, $cre_by, $cre_on)
{
    // make up the sql
    $cre_on = dbTimestamp($cre_on);
    $table = 'cor_tbl_span';
    $fields = array('spantype', 'itemkey', 'itemvalue', 'beg', 'end', 'cre_by', 'cre_on');
    $params = array($spantype, $itemkey, $itemvalue, $beg, $end, $cre_by, $cre_on);
    $logtype = 'spnadd';
    // run the query
    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addSpanAttr()

/**
 * adds a label for a span
 *
 * @param int $span_id the id number of the span frag
 * @param int $spanlabel the id number of the span label
 * @param string $cre_by the new frag creator
 * @param string $cre_on the new date of creation
 * @return array $result the array of result information
 * @author Guy Hunt
 * @since 0.3
 *
 * took over add functionality from edtSpanAttr()
 *
 * Note: bear in mind that this means of attributing frags is now deprecated
 * the correct method is to use chains. However this lives on in the matrix
 * this function could be modified to act as a means to easily chain stuff
 *
 */

function addSpanAttr($span_id, $spanlabel, $cre_by, $cre_on)
{
    // setup sql
    $cre_on = dbTimestamp($cre_on);
    $table = 'cor_tbl_spanattr';
    $fields = array('span', 'spanlabel', 'cre_by', 'cre_on');
    $values = array($span_id, $spanlabel, $cre_by, $cre_on);
    $logtype = 'spatad';
    // run the query
    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addTxt()

/**
 * makes insert queries for the dataclass txt
 *
 * @param string $txttype the id of the texttype
 * @param string $itemkey the itemkey
 * @param string $itemvalue the itemvalue
 * @param string $txt the text to insert
 * @param string $lang the language of this snippet
 * @param string $cre_by the author of this snippet
 * @param string $cre_on the create date of this snippet
 * @return array $results containing useful feedback including 'success' containing TRUE or FALSE
 * @author Guy Hunt
 * @since 0.6
 *
 */

function addTxt($txttype, $itemkey, $itemvalue, $txt, $lang, $cre_by, $cre_on)
{
    if (get_magic_quotes_gpc()) {
        // echo "ADMIN ERROR: Magic Quotes are on... that's not very secure";
        $txt = stripslashes($txt);
    }
    $cre_on = dbTimestamp($cre_on);
    $tables = 'cor_tbl_txt';
    $fields = array('txttype', 'itemkey', 'itemvalue', 'txt', 'language', 'cre_by', 'cre_on');
    $values = array($txttype, $itemkey, $itemvalue, $txt, $lang, $cre_by, $cre_on);
    $logtype = 'txtadd';

    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

// }}}
// {{{ addXmi()

/**
 * loops over a list of item numbers
 *
 * @param string $itemkey  the itemkey of the item you are on
 * @param string $itemvalue  the itemvalue of the item you are on
 * @param string $xmi_itemkey  the itemkey of the mod you are linking to
 * @param string $list  the list of items you want to link to
 * @param string $ste_cd  the site code of listed items set FALSE if sending full itemvals
 * @param string $cre_by  the record creator user_id
 * @param string $cre_on  the creation date of this record
 * @return array $results  an array containing standardised results
 * @author Stuart Eve
 * @since 0.3
 *
 * Note 1: The $ste_cd should only be sent if you are sending mod_no's (that is the number
 * without a site code appended). If you are sending fully resolved itemvalues be sure
 * to set this FALSE
 *
 * Note 2: This has now been updated since version 0.6 to allow for a mixture of numbers
 * and fully resolved itemvalues. It will only append the site code if the value is numeric
 *
 */

function addXmi($itemkey, $itemvalue, $xmi_itemkey, $list, $ste_cd, $cre_by, $cre_on)
{
    // perform a check for $ste_cd
    if (!$ste_cd) {
        echo 'ADMIN ERROR: $ste_cd is required for adding XMIs check your vd settings';
        return FALSE;
    }
    $array = explode(' ', $list);
    $cre_on = dbTimestamp($cre_on);
    $table = 'cor_tbl_xmi';
    $sql_arrays = array();
    // loop over the list
    foreach ($array as $value) {
        if ($value != '') {
            if ($ste_cd && is_numeric($value)) {
                $xmi_itemvalue = $ste_cd.'_'.$value;
            } else {
                $xmi_itemvalue = $value;
            }
            // set up sql
            $sql_arrays [] = array (
                    'fields' => array('itemkey', 'itemvalue', 'xmi_itemkey', 'xmi_itemvalue', 'cre_by', 'cre_on'),
                    'values' => array ($itemkey, $itemvalue, $xmi_itemkey, $xmi_itemvalue, $cre_by, $cre_on )
            );
        }
    }
    // loop over the sql
    foreach ($sql_arrays as $sql_array) {
        // run the query
        $results[] = dbRunAddQuery($table, $sql_array['fields'], $sql_array['values'], $logtype, $cre_by, $cre_on, __FUNCTION__);
    }
    return ($results);
}

// }}}
// {{{ delFrag()

/**
 * deletes fragments from the main class tables
 *
 * @param string $class  the full class name to act on
 * @param int $frag_id  the frag id (row id number)
 * @return array $results  containing some feedback from the db as well as 'success' set TRUE/FALSE
 * @author Guy Hunt
 * @since 0.6
 *
 * Note 1: this function removes the row from the main table and logs
 * this in theory this permits rollbacks and revision history
 * 
 * Note 2: As of v0.8 this can delete a key. Do NOT just delete keys without
 * removing the attached fragments. Use this only within a proper delete routine.
 *
 */

function delFrag($class, $frag_id, $cre_by, $cre_on)
{
    global $db, $log;
    if (!$class or !$frag_id) {
        echo "delFrag: one of the params is set empty/FALSE";
        return FALSE;
    }
    // this routine is to check if we are deleting a key or a frag
    if (isItemkey($class)) {
        $md = splitItemkey($class);
        $tbl = "{$md}_tbl_{$md}";
        $clm = $class;
        $val = $frag_id;
        $logvar_type = 'key';
    } else {
        $tbl = 'cor_tbl_'.$class;
        $clm = 'id';
        $val = $frag_id;
        $logvar_type = FALSE;
    }
    $sql = "
        DELETE FROM $tbl
        WHERE $clm = ?
    ";
    $params = array($val);
    // proper logging
    if ($log == 'on') {
        if ($logvar_type == 'key') {
            $logvars = getRow($tbl, FALSE, "WHERE $clm = '$val'");
        } else {
            $logvars = getRow($tbl, $frag_id , FALSE);
        }
        settype($logvars[$class.'type'], "integer");
        $log_ref =
            array(
                'table',
                'itemkey',
                'itemvalue',
                'type',
                'language'
        );
        $log_refid =
            array(
                'table' => $tbl,
                'itemkey' => $logvars['itemkey'],
                'itemvalue' => $logvars['itemvalue'],
                'type' => $logvars[$class.'type']
        );
        $logtype = $class.'del';
    } else {
        $log_ref = FALSE;
        $log_refid = FALSE;
    }
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $rows = $sql->rowCount();
    if ($rows == 1) {
        $results['success'] = TRUE;
        $results['rows'] = $rows;
        $results['log_ref'] = $log_ref;
        $results['log_refid'] = $log_refid;
    }else {
        $results['success'] = FALSE;
    }
    if (isset($logvars) AND $log_ref) {
        logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }
    return ($results);
}

// }}}
// {{{ chkModType()

/**
 * checks if a module is using types
 *
 * @param string $mod  the three letter mod code to test
 * @return boolean  TRUE meaning it is using types FALSE meaning it isnt
 * @author Guy Hunt
 *
 */

function chkModType($mod)
{
    global $db;
    $tbl = $mod.'_tbl_'.$mod;
    $typecol = $mod.'type';
    // setup sql
    $sql = dbPrepareQuery("SHOW COLUMNS FROM $tbl","chkModType()");
    $sql = dbExecuteQuery($sql,array(),"chkModType()");
    // get results
    if ($cols = $sql->fetch(PDO::FETCH_ASSOC)) {
        $chk = FALSE;
        do {
            if ($cols['Field'] == $typecol) {
                $chk = TRUE;
            }
        } while ($cols = $sql->fetch(PDO::FETCH_ASSOC));
        return ($chk);
    } else {
        return (FALSE);
        echo "No columns were found for table: '$tbl'<br/>SQL: $sql<br/>";
    }
}

// }}}
// {{{ ddAlias()
        
/**
* provides a dropdown menu with language independent aliases. Creates a dd menu with an
* 'id | alias' type setup 
*
* @param mixed $top_val  the value that appears when the page is loaded - mainly useful when on an edit form
* @param int $top_id  the preloaded id - mainly useful when on an edit form
* @param string $lut  the table (not necc an lut) from which we want to get the vars
* @param string $lang  the lang for the aliases
* @param string $dd_name  the name of the select tag (ie the 'name' part of the 'name=value' pair sent to the qrystr)
* @param string $order  OPTIONAL sql in the format 'ORDER BY organisation', if not required then send FALSE
* @param string $return_mode  either return the html code as a string (by sending 'code') 
*                             or do a simple print (by sending 'html'.
* @param string $id_col  OPTIONAL the name of the col to pull back as the 'id' value in the dropdown 
*                        (if not specified the function defaults to 'id')
* @param boolean $dynamic  OPTIONAL if you want a dynamic javascript dd
* @access public
* @since 0.5.1
*/

function ddAlias($top_id, $top_val, $lut, $lang, $dd_name, $order, $return_mode, $id_col = 'id', $dynamic = FALSE)
{
    global $db, $default_lang;
    //Set a default if needed
    if (!$top_val) {
        $top_val = '---select---';
    }
    $sqltext = "
        SELECT cor_tbl_alias.alias, cor_tbl_alias.language, $lut.$id_col
        FROM cor_tbl_alias,$lut
        WHERE cor_tbl_alias.itemkey = ?
        AND cor_tbl_alias.itemvalue = $lut.id
        $order
    ";
    $params = array($lut);
    $sql = dbPrepareQuery($sqltext,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    //build the array to print out to the dropdown
    //first the language results
    while ($ddrow = $sql->fetch(PDO::FETCH_ASSOC)) {
        if($ddrow['language'] == $lang && $default_lang != $lang) {
            $aliases[$ddrow[$id_col]] = $ddrow['alias'];
        } elseif ($ddrow['language'] == $default_lang) {
            $default_aliases[$ddrow[$id_col]] = $ddrow['alias'];
        } else {
            $other_aliases[$ddrow[$id_col]] = $ddrow['alias'];
        }
    }
    //grab all the ones in the default alias array that aren't in the lang array
    if (!empty($default_aliases) && !empty($aliases)) {
        $alias_arr = array_diff_key($default_aliases,$aliases);
        if (!empty($other_aliases)) {
            //now check if there are differences between the other aliases
            $alias_arr2 = array_diff_key($other_aliases,$alias_arr);
            $alias_arr2 = array_diff_key($other_aliases,$default_aliases);
            $alias_arr2 = array_diff_key($other_aliases,$aliases);
            //now merge the three together
            $final_aliases =$aliases+$alias_arr+$alias_arr2;
        } else {
            //now merge the two together
            $final_aliases = $aliases+$alias_arr;
        }
    } elseif (!empty($default_aliases)) {
        if (!empty($other_aliases)) {
            //now check if there are differences between the other aliases
            $alias_arr2 =  array_diff_key($other_aliases,$default_aliases);
            //now merge the two together
            $final_aliases = $default_aliases+$alias_arr2;
        } else {
            $final_aliases = $default_aliases;
        }
    } else {
        $error[] = "Not able to get any aliases in ddAlias";
    }
    if (!empty($final_aliases)) {
        // Sort the dd into alphabetical order (no other options)
        natcasesort($final_aliases);
    } else {
        echo "ddAlias(): There are no aliases for this menu. Check your setup.<br/>SQL was: <br/>$sqltext<br/>";
        return(FALSE);
    }
    
    //----1 PRINT OUTPUT----
    if ($return_mode == 'html') {
        if ($dynamic) {
            printf("
                    <select name=\"$dd_name\" onchange=\"dyn_dd(this.name)\">
                    <option value=\"$top_id\">$top_val</option>
            ");
        } else {
            printf("
                    <select name=\"$dd_name\">
                    <option value=\"$top_id\">$top_val</option>
            ");
        }
       
        foreach ($final_aliases as $key => $value) {
            if (strlen($value) > 25) {
                $value = substr($value, 0, 25).'... ';
            }
            if ($key != $top_id) {
                printf("<option value=\"%s\">%s</option>\n", $key, $value);
            }
        }
        printf('</select>');
    }
    
    //----2 RETURN A STRING----
    if ($return_mode == 'code') {
        if ($dynamic) {
            $dd = "<select name=\"$dd_name\" onchange=\"dyn_dd(this.name)\">\n";
        } else {
            $dd = "<select name=\"$dd_name\">\n";
        }
        
        $dd .= "<option value=\"$top_id\">$top_val</option>\n";
        foreach ($final_aliases as $key => $value) {
            if (strlen($value) > 25) {
                $value = substr($value, 0, 25).'... ';
            }
            if ($value != $top_val) {
                $dd .= "<option value=\"$key\">$value</option>\n";
            }
        }
        $dd .= "</select>";
        return ($dd);
    }
}

// }}}
// {{{ getAllClasstypeAlias(){


/**
 * @param unknown $top_id
 * @param unknown $top_val
 * @param unknown $lut
 * @param unknown $lang
 * @param unknown $dd_name
 * @param unknown $order
 * @param unknown $return_mode
 * @param string $id_col
 * @param string $dynamic
 * @return Ambigous <number, unknown>
 */
function getAllClasstypeAlias($lut, $lang, $id_col = 'id')
{
    global $db, $default_lang;
    
    $sqltext = "
        SELECT cor_tbl_alias.alias, cor_tbl_alias.language, $lut.$id_col
        FROM cor_tbl_alias, $lut
        WHERE cor_tbl_alias.itemkey = ?
        AND cor_tbl_alias.itemvalue = $lut.id
    ";
    $params = array(
                    $lut
    );
    $sql = dbPrepareQuery($sqltext, __FUNCTION__);
    $sql = dbExecuteQuery($sql, $params, __FUNCTION__);
    // build the array to print out to the dropdown
    // first the language results
    while($ddrow = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($ddrow['language'] == $lang && $default_lang != $lang) {
            $aliases[$ddrow[$id_col]] = $ddrow['alias'];
        } elseif ($ddrow['language'] == $default_lang) {
            $default_aliases[$ddrow[$id_col]] = $ddrow['alias'];
        } else {
            $other_aliases[$ddrow[$id_col]] = $ddrow['alias'];
        }
    }
    // grab all the ones in the default alias array that aren't in the lang array
    if (!empty($default_aliases) && !empty($aliases)) {
        $alias_arr = array_diff_key($default_aliases, $aliases);
        if (!empty($other_aliases)) {
            // now check if there are differences between the other aliases
            $alias_arr2 = array_diff_key($other_aliases, $alias_arr);
            $alias_arr2 = array_diff_key($other_aliases, $default_aliases);
            $alias_arr2 = array_diff_key($other_aliases, $aliases);
            // now merge the three together
            $final_aliases = $aliases + $alias_arr + $alias_arr2;
        } else {
            // now merge the two together
            $final_aliases = $aliases + $alias_arr;
        }
    } elseif (!empty($default_aliases)) {
        if (!empty($other_aliases)) {
            // now check if there are differences between the other aliases
            $alias_arr2 = array_diff_key($other_aliases, $default_aliases);
            // now merge the two together
            $final_aliases = $default_aliases + $alias_arr2;
        } else {
            $final_aliases = $default_aliases;
        }
    } else {
        $error[] = "Not able to get any aliases in ddAlias";
    }
    if (!empty($final_aliases)) {
        // Sort the dd into alphabetical order (no other options)
        natcasesort($final_aliases);
    }
    return $final_aliases;
} 

// }}}
// {{{ ddAttr()

/**
 * makes a drop down menu of attributes based on an attribute type
 *
 * @param string $top_id  preload a set value into the top of the menu
 * @param string $top_val  preload a set value into the top of the menu
 * @param string $attributetype  the attribute type
 * @param string $order a custom sort order
 * @param boolean $dynamic  set to true if you want to use a dynamic javascript dd
 * @return string $dd  a valid html <select> element
 * @author Guy Hunt
 * @since 0.4
 *
 * NOTE: attributetype will also be the 'name' of the <select> tag
 *
 * NOTE: completely rewritten as of v0.7
 *
 */

function ddAttr($top_id, $top_val, $attributetype, $return="dd",$order=FALSE, $dynamic=FALSE)
{
    global $db, $lang;
    //Set a default if needed
    if (!$top_val) {
        $top_val = '---select---';
    }
    // set up a dd name
    $dd_name = $attributetype;
    // Handle numeric and text calls
    if (is_numeric($attributetype)) {
        $andclause = "AND b.id = ?";
    } else {
        $andclause = "AND b.attributetype = ?";
    }
    // Set up sort order clauses
    switch ($order) {
        case 'id_dsc':
            $orderclause = 'a.id DESC';
            break;

        case 'id_asc':
            $orderclause = 'a.id ASC';
            break;

        default:
            $orderclause = 'c.alias';
            break;
    }
    // setup the SQL
    $sql = "
    SELECT a.id, c.alias, b.attributetype
    FROM cor_lut_attribute AS a, cor_lut_attributetype AS b, cor_tbl_alias AS c
    WHERE a.id = c.itemvalue
    AND c.itemkey = 'cor_lut_attribute'
    AND a.attributetype = b.id
    AND c.language = ?
    $andclause
    ORDER BY $orderclause
    ";
    $params = array($lang,$attributetype);
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // For DEBUG
    //printPre(array($sql,$params));
    
    switch($return){
        case "dd":
            // Build the dd or return an error
            if ($ddrow = $sql->fetch(PDO::FETCH_ASSOC)) {
                if ($dynamic) {
                    $dd = "<select name=\"$dd_name\" onchange=\"dyn_dd(this.name)\">\n";
                } else {
                    $dd = "<select name=\"$dd_name\">\n";
                }
                $dd .= "<option value=\"$top_id\">$top_val</option>\n";
                do {
                    if ($ddrow['id'] != $top_id) {
                        $dd .= "<option value=\"{$ddrow['id']}\">{$ddrow['alias']}</option>\n";
                    }
                } while ($ddrow = $sql->fetch(PDO::FETCH_ASSOC));
                $dd .= "</select>\n";
                return ($dd);
            } else {
                echo "Error in ddAttr: cannot build a dropdown menu for '$attributetype' (returned no attributes)<br/>";
                // echo "SQL: $sql<br/>";
            }
        case "array":
            $dd=array();
            if ($ddrow = $sql->fetch(PDO::FETCH_ASSOC)) {
                do {
                    $att['value'] = $ddrow['id'];
                    $att['name'] = $ddrow['alias'];
                    $dd[]=$att;
                }  while ($ddrow = $sql->fetch(PDO::FETCH_ASSOC));
                return ($dd);
            } else {
                echo "Error in ddAttr: cannot build a dropdown menu for '$attributetype' (returned no attributes)<br/>";
                // echo "SQL: $sql<br/>";
            }    
    }

}

// }}}
// {{{ edtAction()

/**
 * edits actions
 *
 * @param int $action_id the frag id of teh action to edit
 * @param string $actor_itemkey the actor itemkey
 * @param string $actor_itemvalue the actor itemval
 * @param string $cre_by the cre by
 * @param string $cre_on the cre on
 * @return array $result an array containing results info
 * @author Guy Hunt
 * @since 0.3
 *
 * since 0.6 this has lost it's add/del functionality
 * 
 *
*/

function edtAction($action_id, $actorkey, $actorvalue, $cre_by, $cre_on)
{
    global $db, $log;
    // set up sql
    $cre_on = dbTimestamp($cre_on);
    $sql = "
        UPDATE cor_tbl_action
        SET actor_itemkey = ?, actor_itemvalue = ?, cre_by = ?, cre_on = ?
        WHERE id = ?
    ";
    $params = array($actorkey,$actorvalue,$cre_by,$cre_on,$action_id);
    // log the old entry
    if ($log == 'on') {
        $logvars = getRow('cor_tbl_action', $action_id);
        $log_ref = 'cor_tbl_action';
        $log_refid = $logvars['id'];
        $logtype = 'actedt';
    } else {
        $log_ref = FALSE;
        $log_refid = FALSE;
        $logvars = FALSE;
    }
    // run query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $rows = $sql->rowCount();
    if ($rows == 1) {
        $results['success'] = TRUE;
        $results['rows'] = $rows;
        $results['log_ref'] = $log_ref;
        $results['log_refid'] = $log_refid;
    } else {
        $results['success'] = FALSE;
    }
    if (isset($logvars) AND $log_ref) {
        logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }
    // return
    return ($results);
}

// }}}
// {{{ edtAttr()

/**
 * edits an attribute
 *
 * this functionality is largely of use when using the boolean
 * properties of attributes. as with all the edt and del functions
 * this may only act on a specific frag id which is required. This
 * edit functionality refers to the cor_tbl_attribute not to the
 * lookup which is edited elsewhere
 *
 * @param string $attribute the attribute fragment to update with
 * @param boolean $bv TRUE or FALSE
 * @param string $frag_id the id of this fragment row
 * @param string $cre_by the frag creator user_id
 * @param string $cre_on the frag creation datetime
 * @return array $results containing useful feedback including 'success' containing TRUE or FALSE
 * @author Guy Hunt
 * @since 0.1
 *
 * NOTE: that since 0.6 this function has lost add and del functionality
 *
 */

function edtAttr($attribute, $bv, $frag_id, $cre_by, $cre_on)
{
    // Basics
    global $db, $log;
    // Set up the SQL
    $cre_on = dbTimestamp($cre_on);
    $sql = "
        UPDATE cor_tbl_attribute
        SET attribute = ?, boolean = ?, cre_by = ?, cre_on = ?
        WHERE id = ?
    ";
    $params = array($attribute,$bv,$cre_by,$cre_on,$frag_id);
    // log the old entry
    if ($log == 'on') {
        $logvars = getRow('cor_tbl_attribute', $frag_id);
        $log_ref = 'cor_tbl_attribute';
        $log_refid = $logvars[0];
        $logtype = 'atredt';
    } else {
        $log_ref = FALSE;
        $logvars = FALSE;
        $log_refid = FALSE;
    }
    // run query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $rows = $sql->rowCount();
    if ($rows == 1) {
        $results['success'] = TRUE;
        $results['rows'] = $rows;
        $results['log_ref'] = $log_ref;
        $results['log_refid'] = $log_refid;
    }else {
        $results['success'] = FALSE;
    }
    if (isset($logvars) && $log_ref) {
        logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }
    return ($results);
}

// }}}
// {{{ edtCmapData()

/**
 * edits a row of the cmap_data the data mapping table
 *
 * @param
 * @return void
 * @author Guy Hunt
 * @since
 */

function edtCmapData($db, $cmap, $sourcedata, $sourcelocation, $mapto_tbl, $mapto_class, $mapto_classtype, $mapto_id, $cre_on, $qtype=FALSE)
{
    $cre_on = dbTimestamp($cre_on);
    $sql = "
    INSERT INTO cor_tbl_cmap_data
    (cmap, sourcedata, sourcelocation, mapto_tbl, mapto_class, mapto_classtype, mapto_id, description, cre_by, cre_on)
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ";
    $params = array($cmap, $sourcedata, $sourcelocation, $mapto_tbl, $mapto_class, $mapto_classtype, $mapto_id, 'mapping added automatically by the import function', 'auto', $cre_on);

    $logvars = "A new value was added to cmap_data. The sql: ".json_encode($sql);
    $logtype = 'adcmdt';
    // Dry run
    if ($qtype == 'dry_run') {
        printf ("<br/><h3>edtCmapData() - the cmap data</h3>$sql");
    } else {
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        logEvent($logtype, $logvars, 1, $cre_on);
    }
}

// }}}
// {{{ edtDate()

/**
 * edits dates
 *
 * @param string $date the date fragment to update with
 * @param string $date_id the id of this fragment row
 * @param string $cre_by the frag creator user_id
 * @param string $cre_on the frag creation datetime
 * @return array $results containing useful feedback including 'success' containing TRUE or FALSE
 * @author Guy Hunt
 * @since 0.2
 *
 * NOTE 1: Only specific frags may be edited - identified by row id
 *
 * NOTE 2: Since v0.6 this function has lost add and del functionality
 *
*/

function edtDate($date, $date_id, $cre_by, $cre_on)
{
    global $db, $log;
    // set up sql
    $cre_on = dbTimestamp($cre_on);
    $sql = "
        UPDATE cor_tbl_date
        SET date = ?, cre_by = ?, cre_on = ?
        WHERE id = ?
    ";
    $params = array($date,$cre_by,$cre_on,$date_id);
    // log the old entry
    if ($log == 'on') {
        $logvars = getRow('cor_tbl_date', $date_id);
        $log_ref = 'cor_tbl_date';
        $log_refid = $logvars['id'];
        $logtype = 'datedt';
    } else {
        $log_ref = FALSE;
        $log_refid = FALSE;
    }
    // run query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $rows = $sql->rowCount();
    if ($rows == 1) {
        $results['success'] = TRUE;
        $results['rows'] = $rows;
        $results['log_ref'] = $log_ref;
        $results['log_refid'] = $log_refid;
    } else {
        $results['success'] = FALSE;
    }
    if (isset($logvars) AND $log_ref) {
        logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }
    return ($results);
}

// }}}
// {{{ edtFile()

/**
 * edits one or many files
 *
 * @param string $itemkey the itemkey of the item you are on
 * @param string $itemvalue the itemvalue of the item you are on
 * @param string/array $files a list of the desired files - can be supplied as an array
 * @param string $cre_by the record creator user_id
 * @param string $cre_on the creation date of this record
 * @return array $results an array containing standardised results
 * @author Stuart Eve
 * @since 0.6
 *
 * Note 1: items in the list are checked against a result from the database. if items
 * match exactly they are skipped. If they are not present in the db an add
 * query is requested. If items are present in the db but not in the list a delete
 * query is requested.
 *
 */

function edtFile($itemkey, $itemvalue, $files, $cre_by, $cre_on)
{
    global $db, $log;
    // handle lists of files
    if (!is_array($files)) {
        $array = explode(' ', $files);
        // loop over the list cleaning it up into a proper array
        foreach ($array as $value) {
            if ($value != '') {
                $list_array[] = $value;
            }
        }
    } else {
        $list_array = $files;
    }
    // get an array of the current situation from the db
    $db_files = getFile($itemkey, $itemvalue, $filetype);
    // compare the two arrays
    if (empty($db_files)) {
        $add_file = $list_array;
        $del_file = array();
    } else{
        foreach ($db_files as $key => $file) {
            $old_file[] = $file['id'];
        }
        $ignore_file = array_intersect($list_array,$old_file);
        $add_file = array_diff($list_array,$old_file);
        $del_file = array_diff($old_file,$add_file,$ignore_file);
    }
    //run the adds
    foreach ($add_file as $file) {
        addFile($itemkey, $itemvalue,$file,$cre_by, $cre_on);
    }
    //run the deletes against the id from the original 
    foreach ($del_file as $file){
        delFrag('file', $db_files[$file]['frag_id'], $cre_by, $cre_on);
    }
}

// }}}
// {{{ edtFragKey()

/**
 * edits the itemkey of a frag on dataclass tables (obv. not including keys themselves)
 *
 * @param string $frag_id  the id of the frag
 * @param string $dclass  the dataclass of the fragment to update
 * @param string $new_itemkey  the new itemkey to substitute
 * @param string $new_itemval  the new itemval to substitute
 * @param string $cre_by  the new frag creator
 * @param string $cre_on  the new date of creation
 * @return array $results containing useful feedback including 'success' containing TRUE or FALSE
 * @author Guy Hunt
 * @since 0.8
 *
 * NOTE 1: Only specific frags may be edited - identified by row id
 *
 */

function edtFragKey($frag_id, $dclass, $new_itemkey, $new_itemval, $cre_by, $cre_on) 
{
    global $db, $log;
    // handle non standard dataclass naming
    if ($dclass == 'attr') {
        echo "ADMIN ERROR: as of v1.0 dataclass in fields must be declared as 'attribute' not 'attr'<br/>function edtFragKey()<br/>";
        $dclass = 'attribute';
    }
    // tbl
    $tbl = 'cor_tbl_'.$dclass;
    // set up the sql
    $cre_on = dbTimestamp($cre_on);
    $sql = "
        UPDATE $tbl
        SET itemkey = ?, itemvalue = ?, cre_by = ?, cre_on = ?
        WHERE id = ?
    ";
    $params = array($new_itemkey,$new_itemval,$cre_by,$cre_on,$frag_id);
    // Run the Query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $rows = $sql->rowCount();
    if ($rows > 0) {
        $results['success'] = TRUE;
        $results['rows'] = $rows;
    }else {
        $results['success'] = FALSE;
    }
    return ($results);
}

// }}}
// {{{ edtItemKey()

/**
 * updates the entry for an itemkey
 *
 * @param string $mod_short the three letter mod code
 * @param string $mod_cd_val the fully resolved itemvalue of the item
 * @param string $mod_no_val just the number
 * @param string $ste_cd the site code
 * @param string $cre_by the user_id of the record creator
 * @param string $cre_on the creation date for this record
 * @param string $modtype the modtype (if this module is using types)
 *
 * @return array $result containing number of affected rows and 'success' set true or false
 * @author Guy Hunt
 * @since 0.5
 *
 * FIXME: Currently this is set to simply ignore edits to the cre_on this is to
 * avoid some disturbing behaviour in the matrix.
 *
 * NOTE 1: In effect, this function is mostly of use in editing modtypes. As the edit
 * is based on the itemkey/val pair, it cannot change this pair. It can change the cre_by/
 * cre_on, although as the FIXME note above states, this currently doesn't include cre_on
 * in order to change the itemval use edtItemVal. GH 11/10/2010
 *
 */

function edtItemKey($itemkey, $itemvalue, $cre_by, $cre_on, $modtype=FALSE)
{
    global $db, $log;
    $mod_short = splitItemkey($itemkey);
    $tbl = $mod_short.'_tbl_'.$mod_short;
    $mod_cd = $mod_short.'_cd';
    $mod_no = $mod_short.'_no';
    $modtypename = $mod_short.'type';
    $mod_no_val = splitItemval($itemvalue);
    $itemvalue = $itemvalue;
    $ste_cd = splitItemval($itemvalue, TRUE);
    
    //SQL if we are using modtypes is a little different
    if ($modtype) {
        $sql = "
            UPDATE $tbl
            SET $mod_cd = ?,
                $mod_no = ?,
                ste_cd = ?,
                $modtypename = ?,
                cre_by = ?
            WHERE $mod_cd = ?
        ";
        $params = array($itemvalue,$mod_no_val,$ste_cd,$modtype,$cre_by,$itemvalue);
    } else {
        $sql = "
            UPDATE $tbl
            SET $mod_cd = ?,
                $mod_no = ?,
                ste_cd = ?,
                cre_by = ?
            WHERE $mod_cd = ?
        ";
        $params = array($itemvalue,$mod_no_val,$ste_cd,$cre_by,$itemvalue);
    }
    if ($log == 'on') {
        $logvars = 'The sql: '.json_encode($sql);
        $logtype = 'keyadd';
    }
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $rows = $sql->rowCount();
    if ($rows == 1) {
        $results['success'] = TRUE;
        $results['rows'] = $rows;
    } else {
        $results['success'] = FALSE;
    }
    if (isset($logvars) && $log_ref) {
        logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }
    return ($results);
}

// }}}
// {{{ edtItemVal()

/**
 * updates the itemvalue entry for an item
 *
 * @param string $itemkey  the itemkey of the item you are on
 * @param string $old_itemval  the old itemvalue
 * @param string $new_itemval  the new itemvalue
 * @return array $result  containing number of affected rows and 'success' set true or false
 * @author Guy Hunt
 * @since 0.8
 *
 * NOTE 1: beware, this changes an item and will break the links to all data
 * connected to the old key/val pair. Therefore this should only be used in
 * conjunction with a routine that will prevent bad links and orphaned data
 * such as sf_itemval. GH 11/10/2010
 *
 * NOTE 2: This will update the site code and xxx_no as well, but only based
 * on the new_itemval itself.
 *
 */

function edtItemVal($itemkey, $old_itemval, $new_itemval)
{
    global $db;
    $mod = splitItemkey($itemkey);
    $tbl = $mod.'_tbl_'.$mod;
    $mod_cd_col = $mod.'_cd';
    $mod_no_col = $mod.'_no';
    $new_mod_no_val = splitItemval($new_itemval);
    $ste_cd = splitItemval($new_itemval, TRUE);
    
    //SQL
    $sql = "
        UPDATE $tbl
        SET $mod_cd_col = ?,
            $mod_no_col = ?,
            ste_cd = ?
        WHERE $mod_cd_col = ?
    ";
    $params = array($new_itemval,$new_mod_no_val,$ste_cd,$old_itemval);
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $rows = $sql->rowCount();
    if ($rows == 1) {
        $results['success'] = TRUE;
        $results['rows'] = $rows;
    } else {
        $results['success'] = FALSE;
    }
    return ($results);
}

// }}}
// {{{ edtLut()

/**
* edits look up tables (lut's)
*
* @param
* @return $new_lut_id
* @author Guy Hunt
* @since v0.4
*
* Note 1: This was moved in from the import functions file at v1.1
*
* DEV NOTE: Messy non-standardised function. GH needs to fix this up. GH 30/10/2013
*
*/

function edtLut($db, $table, $new_lut_val, $ark_mod, $attrtype, $lang, $cre_by, $cre_on, $qtype=FALSE)
{
    // 1 - MAKE UP A NICKNAME FOR THE NEW ENTRY
    $remove_this = array(" ","'",",","-","(",")"); 
    $nickname = str_replace($remove_this, '', strtolower($new_lut_val));
    
    // 2 - ADD TO THE LUT AND RETURN THE NEW ATTRIBUTE ID (depending on type)
    $cre_on = dbTimestamp($cre_on);
    if ($table == 'cor_lut_attribute') {
        $sql = "
            INSERT INTO $table (attribute, module, attributetype, cre_by, cre_on)
            VALUES (?, ?, ?, ?, ?)
        ";
        $params = array($nickname,$ark_mod,$attrtype,$cre_by,$cre_on);
    }
    if ($table == 'cxt_lut_cxttype') {
        $sql = "
            INSERT INTO $table (cxttype, cre_by, cre_on)
            VALUES (?, ?, ?)
        ";
        $params = array($nickname,$cre_by,$cre_on);
    }
    if ($table == 'cor_lut_actiontype') {
        $sql = "
            INSERT INTO $table (actiontype, module, cre_by, cre_on)
            VALUES (?, ?, ?, ?)
        ";
        $params = array($nickname,$ark_mod,$cre_by,$cre_on);
    }

    $logvars = "A new value was added to $table. The sql: ".json_encode($sql);
    $logtype = 'adnlut';
    // Dry Runs
    if ($qtype == 'dry_run') {
        printf ("<br/><h3>edtLut() - the lut entry</h3>$sql");
        $new_lut_id = FALSE;
    } else {
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        $new_lut_id = $db->lastInsertId();
        $logvars = $logvars."\nThe new lut id is: $new_lut_id";
        logEvent($logtype, $logvars, $cre_by, $cre_on);
    }
    
    // NOW DO THE ALIAS
    $sql_alias = "
        INSERT INTO cor_tbl_alias (alias, aliastype, language, itemkey, itemvalue, cre_by, cre_on)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ";
    $alias_params = array($new_lut_val, 1, $lang, $table, $new_lut_id, $cre_by, $cre_on);
    
    $logvars = "A new value was added to cor_tbl_alias. The sql: ".json_encode($sql_alias);
    $logtype = 'adnali';
    
    if ($qtype == 'dry_run') {
        printf ("<br/><h3>edtLut() - the Alias</h3>$sql_alias");
    } else {
        $sql_alias = dbPrepareQuery($sql_alias,__FUNCTION__);
        $sql_alias = dbExecuteQuery($sql_alias,$alias_params,__FUNCTION__);
        $new_ali_id = $db->lastInsertId();
        $logvars = $logvars."\nThe new alias id is: $new_ali_id";
        logEvent($logtype, $logvars, $cre_by, $cre_on);
    }
    return($new_lut_id);
}

// }}}
// {{{ edtMarkup()

/**
 * edits markup
 *
 * @param string $id  the id of the markup record
 * @param string $nname  the nickname of the markup
 * @param string $markup  the markup to add
 * @param string $mod_short  the language of the markup
 * @param string $lang the  language of the markup
 * @param string $description  the description of the markup
 * @param string $cre_by  the new markup creator
 * @param string $cre_on  the new date of creation
 * @return array $results  containing useful feedback including 'success' containing TRUE or FALSE
 * @author Stuart Eve
 * @since 0.6
 *
 * NOTE 1: Only specific frags may be edited - identified by row id
 *
 * NOTE 2: Since v0.6 this function has lost add and del functionality
 *
 */

function edtMarkup($id, $nname, $markup, $mod_short, $lang, $description, $cre_by, $cre_on, $dry_run = FALSE)
{
    global $db, $log;
    // set up sql
    $cre_on = dbTimestamp($cre_on);
    $sql = "
        UPDATE cor_tbl_markup
        SET nname = ?, markup = ?, mod_short = ?, language = ?, description = ?, cre_by = ?, cre_on = ?
        WHERE id = ?
    ";
    $params = array($nname,$markup,$mod_short,$lang,$description,$cre_by,$cre_on,$id);
    // log the old entry
    if ($log == 'on') {
        $log_refid = FALSE;
        $logvars = getRow('cor_tbl_markup', $id);
        $log_ref = 'cor_tbl_markup';
        if (array_key_exists(0,$logvars)) {
            $log_refid = $logvars[0];
        }
        $logtype = 'markupedt';
    } else {
        $log_ref = FALSE;
        $log_refid = FALSE;
    }
    // run query
    if (!$dry_run) {
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        $rows = $sql->rowCount();
    } else {
        print "SQL to be run: $sql";
        printPre($params);
    }
    if ($rows == 1) {
        $results['success'] = TRUE;
        $results['rows'] = $rows;
        $results['log_ref'] = $log_ref;
        $results['log_refid'] = $log_refid;
    } else {
        $results['success'] = FALSE;
    }
    if (isset($logvars) && $log_ref) {
        logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }
    return ($results);
}

// }}}
// {{{ edtNumber()

/**
 * edits a number
 *
 * @param string $num_id  the frag_id of the number
 * @param string $num the  number to update with
 * @param string $cre_by  the new frag creator
 * @param string $cre_on  the new date of creation
 * @return array $results  containing useful feedback including 'success' containing TRUE or FALSE
 * @author Guy Hunt
 * @since 0.3
 *
 * NOTE 1: Only specific frags may be edited - identified by row id
 *
 * NOTE 2: Since v0.6 this function has lost add and del functionality
 *
 */
 
function edtNumber($num_id, $num, $cre_by, $cre_on)
{
    global $db, $log;
    // set up sql
    $cre_on = dbTimestamp($cre_on);
    $sql = "
        UPDATE cor_tbl_number
        SET number = ?, cre_by = ?, cre_on = ?
        WHERE id = ?
    ";
    $params = array($num,$cre_by,$cre_on,$num_id);
    // log the previous data
    if ($log == 'on') {
        $logvars = getRow('cor_tbl_number', FALSE , $where);
        $log_ref = 'cor_tbl_number';
        $log_refid = $logvars[0];
        $logtype = 'numedt';
    }
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $rows = $sql->rowCount();
    if ($rows == 1) {
        $result['success'] = TRUE;
        $result['sql'] = $sql;
    } else {
        $result['success'] = FALSE;
        $result['failed_sql'] = $sql;
    }
    if (isset($logvars) && $log_ref) {
        logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }
    return ($result);
}

// }}}
// {{{ edtSpan()

/**
 * edits a span in cor_tbl_span
 *
 * @param string $span_id the frag_id of the span
 * @param string $beg the beg to update with
 * @param string $end the end to update with
 * @param string $cre_by the new frag creator
 * @param string $cre_on the new date of creation
 * @return array $results containing useful feedback including 'success' containing TRUE or FALSE
 * @author Guy Hunt
 * @since 0.3
 *
 * NOTE 1: Only specific frags may be edited - identified by row id
 *
 * NOTE 2: Since v0.6 this function has lost add and del functionality
 *
 * FIXME: edtSpan is incomplete must be fixed
 *
 *
 */
 
function edtSpan($span_id, $beg, $end, $cre_by, $cre_on)
{
    global $db;
    // set up the sql
    $cre_on = dbTimestamp($cre_on);
    $sql = "
        UPDATE cor_tbl_span 
            SET beg = ?
                end = ?
                cre_by = ?
                cre_on = ?
            WHERE id= ?"
        ;
    $params = array($beg,$end,$cre_by,$cre_on,$span_id);
    // logging
    if ($log == 'on') {
        $logvars = getRow('cor_tbl_span', FALSE , "WHERE id = $span_id");
        $log_ref = 'cor_tbl_span';
        $log_refid = $logvars[0];
        $logtype = 'spanedt';
    }
    // run query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $rows = $sql->rowCount();
    if ($result['rows'] == 1) {
        $result['success'] = TRUE;
        $result['new_itemvalue'] = $mod_cd_val;
    } else {
        $result['success'] = FALSE;
        $result['failed_sql'] = $sql;
    }
    if (isset($logvars) && $log_ref) {
        logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }
    return ($result);
}

// }}}
// {{{ edtTxt()

/**
 * makes update queries for the dataclass txt
 *
 * @param string $txt_id  the id of the texttype
 * @param string $txt  the text fragment to update with
 * @param string $lang  the language of the new snippet
 * @param string $cre_by  the new frag creator
 * @param string $cre_on  the new date of creation
 * @return array $results  containing useful feedback including 'success' containing TRUE or FALSE
 * @author Guy Hunt
 * @since 0.1
 *
 * NOTE 1: Only specific frags may be edited - identified by row id
 *
 * NOTE 2: It is anticipated that you will supply the $conf_log_XXX variable to the
 * $log value. However, this does provide the option to override the conf setting in
 * the process script. Do this by specifying on/off rather than simply sending the conf
 *
 * NOTE 3: Since v0.6 this function has lost add and del functionality
 *
 */

function edtTxt($txt_id, $txt, $lang, $cre_by, $cre_on) 
{
    global $db, $log;
    if (get_magic_quotes_gpc()) {
        // echo "Magic Quotes are on... that's not very secure";
        $txt = stripslashes($txt);
    }
    $cre_on = dbTimestamp($cre_on);
    // set up the sql
    $sql = "
        UPDATE cor_tbl_txt
        SET txt = ?, language = ?, cre_by = ?, cre_on = ?
        WHERE id = ?
    ";
    $params = array($txt, $lang, $cre_by, $cre_on,$txt_id);
    
    if ($log == 'on') {
        $logvars = getRow('cor_tbl_txt', $txt_id , FALSE);
        $log_ref = 'cor_tbl_txt';
        $log_refid = $logvars[0];
        $logtype = 'edtsgl';
    } else {
        $log_ref = FALSE;
        $logvars = FALSE;
    }
    // Run the Query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    
    // Handle the results
    $rows = $sql->rowCount();
    if ($rows > 0) {
        $results['success'] = TRUE;
        $results['rows'] = $rows;
    } else {
        $results['success'] = FALSE;
    }
    // Log the edit
    if ($logvars && $log_ref) {
        logCmplxEvent($logtype, $log_ref, $log_refid, $logvars, $cre_by, $cre_on);
    }
    return ($results);
}

// }}}
// {{{ edtXmi()

/**
 * edits one or many XMI links
 *
 * @param string $itemkey  the itemkey of the item you are on
 * @param string $itemvalue  the itemvalue of the item you are on
 * @param string $xmi_itemkey  the itemkey of the mod you are linking to
 * @param string $list  the list of items you want to link to
 * @param string $ste_cd  the site code of listed items set FALSE if sending full itemvals
 * @param string $cre_by  the record creator user_id
 * @param string $cre_on  the creation date of this record
 * @return array $results  an array containing standardised results
 * @author Guy Hunt
 * @author Stuart Eve
 * @since 0.6
 *
 * Note 1: items in the list are checked against a result from the database. if items
 * match exactly they are skipped. If they are not present in the db an add
 * query is requested. If items are present in the db but not in the list a delete
 * query is requested.
 *
 * Note 2: notes in addXmi also apply here
 *
 */

function edtXmi($itemkey, $itemvalue, $xmi_itemkey, $list, $ste_cd, $cre_by, $cre_on)
{
    global $db, $log;
    $mod = substr($xmi_itemkey, 0, 3);
    $array = explode(' ', $list);
    // loop over the list cleaning it up into an array
    foreach ($array as $value) {
        if ($value != '') {
            // test to see if this is is a key
            $elems = explode('_', $value);
            if (count($elems) == 2) {
                $has_ste_cd = TRUE;
            } else {
                $has_ste_cd = FALSE;
            }
            if (!$has_ste_cd) {
                $list_array[] = $ste_cd.'_'.$value;
            } else {
                $list_array[] = $value;
            }
        }
    }
    // get and array of the current situation from the db
    $db_xmi = getXmi($itemkey, $itemvalue, $mod);
    // compare the two arrays
    foreach ($db_xmi as $key => $xmi) {
        $old_xmi[] = $xmi['xmi_itemvalue'];
        $frag_ids[$xmi['xmi_itemvalue']] =  $xmi['id'];
    }
    $ignore_xmi = array_intersect($list_array, $old_xmi);
    $add_xmi = array_diff($list_array, $old_xmi);
    $del_xmi = array_diff($old_xmi, $add_xmi, $ignore_xmi);
    // run the adds
    foreach ($add_xmi as $xmi) {
        addXmi($itemkey, $itemvalue, $xmi_itemkey, $xmi, $ste_cd, $cre_by, $cre_on);
    }
    // run the deletes using the id from the original
    foreach ($del_xmi as $xmi){
        delFrag('xmi', $frag_ids[$xmi], $cre_by, $cre_on);
    }
}

// }}}
// {{{ getSingleText()

/**
 * returns a single snippet of text
 *
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param integer/string $txttype  the txttype of the txt fragement - this can be the number or the nickname
 * @param string $lang  OPTIONAL the language of the the text fragment to be returned
 * @return string $txt  the text fragment
 * @access public
 * @author Guy Hunt
 * @since 0.6
 *
 */

function getSingleText($itemkey, $itemvalue, $txttype, $lang=FALSE)
{
    global $db;
    // Setup
    if ($lang) {
        $andlang = "AND cor_tbl_txt.language = ?";
    } else {
        $andlang = FALSE;
    }
    if (is_numeric($txttype)) {
        $col = 'id';
    } else {
        $col = 'txttype';
    }
    // Setup the SQL
    $sql = "
        SELECT cor_tbl_txt.txt
        FROM cor_tbl_txt, cor_lut_txttype
        WHERE cor_tbl_txt.txttype = cor_lut_txttype.id
        AND cor_lut_txttype.$col = ?
        AND cor_tbl_txt.itemkey = ?
        AND cor_tbl_txt.itemvalue = ?
        $andlang
    ";
    $params = array($txttype,$itemkey,$itemvalue);
    if ($lang) {
        $params[] = $lang;
    }
    // Debug
    // printPre(array($sql,$params));
    
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    
    if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
        $txt = $frow['txt'];
        return($txt);
    } else {
        return(FALSE);
    }
}

// }}}
// {{{ getActor()

/**
 * returns an actor or actors involved in an action linked to an item
 *
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param integer/string $actiontype  OPTIONAL the actionype of the action
 * @param string $actorkey  OPTIONAL the key of the actor (i.e. abk_cd)
 * @return array $actors  array of actor ids
 * @access public
 * @author Guy Hunt
 * @since 0.5.1
 *
 * NOTE: actiontype can be the number or the nickname. FALSE will give you
 * all of the actors associated with the record
 *
 */

function getActor($itemkey, $itemvalue, $actiontype=FALSE, $actorkey=FALSE)
{
    global $db;
    // Setup
    $lut = 'cor_lut_actiontype';
    // numeric actiontypes
    if (is_numeric($actiontype)) {
        // handle actiontypes
        if ($actiontype) {
            $and_actiontype = "AND actiontype = ?";
        } else {
            $and_actiontype = FALSE;
        }
        // handle actorkeys
        if ($actorkey) {
            $and_actorkey = "AND actor_itemkey = ?";
        } else {
            $and_actorkey = FALSE;
        }
        // Set up SQL
        $sql = "
            SELECT *
            FROM cor_tbl_action
            WHERE itemkey = ?
            AND itemvalue = ?
            $and_actiontype
            $and_actorkey
        ";
        $params = array($itemkey,$itemvalue);
        if ($actiontype) {
            $params[] = $actiontype;
        }
        if ($actorkey) {
            $params[] = $actorkey;
        }
         
    // nickname actiontypes
    } else {
        if ($actiontype) {
            $and_actiontype = "AND b.actiontype = ?";
        } else {
            $and_actiontype = FALSE;
        }
        if ($actorkey) {
            $and_actorkey = "AND a.actor_itemkey = ?";
        } else {
            $and_actorkey = FALSE;
        }
        
        $sql = "
            SELECT a.id, a.actiontype, a.itemkey, a.itemvalue, a.actor_itemkey, a.actor_itemvalue
            FROM cor_tbl_action AS a, $lut AS b
            WHERE a.actiontype = b.id
            AND a.itemkey = ?
            AND a.itemvalue = ?
            $and_actiontype
            $and_actorkey
        ";
        $params = array($itemkey,$itemvalue);
        
        if ($actiontype) {
            $params[] = $actiontype;
        }
        if ($actorkey) {
            $params[] = $actorkey;
        }
    }
    // Debug
    // printPre(array($sql,$params));
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results
    if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $actors[] = $frow;
        } while ($frow = $sql->fetch(PDO::FETCH_ASSOC));
        return $actors;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getAction()

/**
 * gets the action(s) undertaken by an actor
 *
 * @param string $actorkey  the itemkey of the actor
 * @param string $actorvalue  the itemvalue of the actor
 * @param string $subjkey  the itemkey of the items being acted on
 * @param string $subjvalue  the itemkey of the item being acted
 * @return array $actions  contains the results direct from cor_tbl_action OR FALSE.
 * @author Guy Hunt
 * @access public
 * @since 0.6
 *
 * Note 1:  abk_cd is the only current actor module
 *
 * Note 2: If the subjkey and subjvalue are set, the actions are restricted to a specific
 * item. If the subjvalue is left as FALSE, then all action on this module are returned.
 * If both are left false then all this actor's actions in the entire ARK are returned
 *
 */

function getAction($actorkey, $actorvalue, $subjkey=FALSE, $subjvalue=FALSE)
{
    global $db;
    $lut = 'cor_lut_actiontype';
    // Set up SQL
    if ($subjkey && $subjvalue) {
        $sql = "
            SELECT *
            FROM cor_tbl_action
            WHERE itemkey = ?
            AND itemvalue = ?
            AND actor_itemkey = ?
            AND actor_itemvalue = ?
        ";
        $params = array($subjkey,$subjvalue,$actorkey,$actorvalue);
    } elseif ($subjkey) {
        $sql = "
            SELECT *
            FROM cor_tbl_action
            WHERE itemkey = ?
            AND actor_itemkey = ?
            AND actor_itemvalue = ?
        ";
        $params = array($subjkey,$actorkey,$actorvalue);
    } else {
        $sql = "
            SELECT *
            FROM cor_tbl_action
            WHERE actor_itemkey = ?
            AND actor_itemvalue = ?
        ";
        $params = array($actorkey,$actorvalue);
    }
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results
    if ($sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $actions[] = $frow;
        } while ($frow = $sql->fetch(PDO::FETCH_ASSOC));
        return $actions;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getActorElem()

/**
 * returns an element of an actor
 *
 * @param string $actor_id the id of the actor (itemvalue in the case of a module)
 * @param string $elem the element to return
 * @param string $actor_itemkey OPTIONAL the module in the user data is located (default is abk)
 * @param string $elemclass OPTIONAL the type of data class of the element (default is 'txt')
 * @return mixed $element the element
 * @access public
 * @author Guy Hunt
 * @since 0.5.1
 *
 * Note 1: In practice all modern ARKs use the abk to store actor data, therefore these options
 * should be removed and made mandatory in the next release (DEV NOTE: GH 30/10/2013 v1.1)
 *
 * DEV NOTE: Have removed erroneous sql calls (which weren't working) (SJE 11/03/2014 v1.1.1)
 *
 */

function getActorElem($actor_id, $elem, $actor_itemkey=FALSE, $elemclass=FALSE) 
{
    global $db;
    if ($actor_itemkey) {
        // NB in this case, the $elem contains the actual classtype eg the txttype or attrtype
        switch ($elemclass) {
            case 'txt':
                $elems = explode(',', $elem);
                // If there is only one element - do as before
                if (!array_key_exists(1, $elems)) {
                    $element = getSingleText($actor_itemkey, $actor_id, $elems[0]);
                } else {
                    // Otherwise count the elemts
                    $elem_count = count($elems);
                    // For each element get the txt and add a comma after each exept the last
                    for ($i=0;$i<$elem_count;$i++) {
                        $element = getSingleText($actor_itemkey, $actor_id, $elems[$i]);
                        if ($i<$elem_count-1) {
                            $element .= ', ';
                        }
                    }
                }
                break;
        }
    }
    // Return Routine
    if ($element) {
        return $element;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getNumber()

/**
 * returns a number
 *
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param mixed $numbertype  the numbertype of the number fragment
 * @return array $numbers  an array of the number(s)
 * @access public
 * @author Guy Hunt
 * @since 0.1
 *
 */

function getNumber($itemkey, $itemvalue, $numbertype)
{
    global $db;
    $lut = 'cor_lut_numbertype';
    if (is_numeric($numbertype)) {
        $sql = "
            SELECT *
            FROM cor_tbl_number
            WHERE itemkey = ?
            AND itemvalue = ?
            AND numbertype = ?
        ";
        $params = array($itemkey,$itemvalue,$numbertype);
    } else {
        $sql = "
            SELECT *
            FROM $lut, cor_tbl_number
            WHERE cor_tbl_number.numbertype = $lut.id
            AND itemkey = ?
            AND cor_tbl_number.itemvalue = ?
            AND $lut.numbertype = ?
        ";
        $params = array($itemkey,$itemvalue,$numbertype);
    }
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle results
    if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $numbers[] = $frow;
        } while ($frow = $sql->fetch(PDO::FETCH_ASSOC));
        return $numbers;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getFile()

/**
 * returns an array of files
 *
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param string $filetype  the filetype (optional)
 * @return array $file  the files
 * @access public
 * @author Stuart Eve
 * @since 0.6
 *
 */

function getFile($itemkey, $itemvalue, $filetype=FALSE)
{
    global $db;
    // Handle filetypes
    $params = array($itemkey,$itemvalue);
    if ($filetype) {
        if (!is_numeric($filetype)) {
            $filetype = getClassType('file', $filetype);
        }
        $filetype_clause = "AND cor_lut_file.filetype = ?";
        array_unshift($params,$filetype); 
    } else {
        $filetype_clause = FALSE;
    }
    // Build the SQL
    $sql = "
        SELECT cor_lut_file.filename, cor_lut_file.uri, cor_lut_file.id, cor_tbl_file.id as frag_id
        FROM cor_tbl_file, cor_lut_file
        WHERE cor_tbl_file.file = cor_lut_file.id
        $filetype_clause
        AND cor_tbl_file.itemkey = ?
        AND cor_tbl_file.itemvalue = ?
    ";
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle results
    if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $files[$frow['id']] = $frow;
        } while ($frow = $sql->fetch(PDO::FETCH_ASSOC));
        return $files;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getFileName()

/**
 * returns an array of filenames
 *
 * @param string $filenr  the lut id number of the file
 * @return array $filenames  the filenames
 * @access public
 * @author Stuart Eve
 * @since 0.6
 *
 */

function getFileName($filenr)
{
    global $db;
    $sql = "
        SELECT *
        FROM cor_lut_file
        WHERE cor_lut_file.id = ?
    ";
    $params = array($filenr);
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle results
    if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $filenames[$frow['id']] = $frow;
        } while ($frow = $sql->fetch(PDO::FETCH_ASSOC));
        return $filenames;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getAllFiles()

/**
 * returns an array of all the files that are attached to all items.
 *
 * @param string $mod  a mod to limit to (OPTIONAL)
 * @return array $files  the files
 * @access public
 * @author Stuart Eve
 * @since 0.6
 *
 * Note 1: Can be limited by mod
 *
 */

function getAllFiles($mod=FALSE)
{
    global $db;
    $sql = "
        SELECT itemkey,itemvalue,file
        FROM cor_tbl_file
    ";
    $params = array();
    if ($mod) {
        $sql .= " WHERE cor_tbl_file.itemkey = ?";
        $params[] = $mod . "_cd";
    }
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle results
    if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $files[] = $frow;
        } while ($frow = $sql->fetch(PDO::FETCH_ASSOC));
        return $files;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getLogVars()

/**
 * gets stored arrays back from the log
 *
 * @param string $ref  the ref (typically the original table name of the data)
 * @param string $refid  the id of the row (typically the original row number of the record)
 * @param string $type  type of retrieval to do (multi/first/last)
 * @return multitype:mixed unknown Ambigous <> |boolean
 * @access public
 * @author Guy Hunt
 * @since 0.1
 *
 * Note 1: The function returns a multidim array of the row in the log table. The vars
 * array is unserialised at this point and is contained within the array element 'vars'.
 * If you would like to refer to the elements of the vars in a normal (similar to
 * mysql_fetch_array) manner, pull this element out of the array immediately after calling
 * the function.
 *
 * Note 2: This function will expect there to be a row in tbl_log, it does NOT have any error
 * handling ability, don't call it unless you have checked that a log record exists for
 * what you are calling as it will break.
 *
 * DEV NOTE: This function has been around since the early days and hasn't been used very
 * extensively. It looks to me like the sql should all be decided at the top and then the
 * query and unserialization done the same for all results. This would return a standardised
 * array format too. (GH 30/10/2013)
 *
 * DEV NOTE: When updating the db_functions I have also tidied this script to address GH's comment
 * above. (SJE 12/03/2013)
 *
 */

function getLogVars($ref, $refid, $type)
{
    global $db;
    if ($type == 'multi') {
        $sql = "
            SELECT id, vars, cre_on, cre_by
            FROM cor_tbl_log
            WHERE ref = ?
            AND refid = ?
        ";
        $params = array($ref,$refid);   
    }
    
    if ($type == 'last') {
        $sql = "
            SELECT id, vars, cre_on, cre_by
            FROM cor_tbl_log
            WHERE ref = ?
            AND refid = ?
            ORDER BY 'cre_on' DESC
        ";
        $params = array($ref,$refid); 
    }
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $vars[] =
                array(
                    'id' => $row['id'],
                    'vars' => unserialize($row['vars']),
                    'mod_on' => $row['cre_on'],
                    'mod_by' => $row['cre_by']
            );
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
        return ($vars);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ getCh()

/**
 * returns an array of frag id's (NOT data) of fragments chained to a record or fragment
 *
 * @param string $dclass  the data class we are interested in eg (txt or attribute)
 * @param string $itemkey  the itemkey of the lead record/frag (xxx_cd for records/tbl_name for frags)
 * @param string $itemvalue  the itemvalue
 * @param mixed $type  the type of the fragment
 * @return array $ch  the chain
 * @access public
 * @author Guy Hunt
 * @since 0.6
 *
 * Note 1: This gets chained frags of a specific dataclass only
 *
 * Note 2: Attributes and XMIs need different SQL as these classes require join syntax
 *
 * Note 3: If type is not set, the function returns all chained frags
 *
 * Note 4: This gets ONLY the frag ids, use getChData() or getChDataByClass() if the data is needed
 *
 */

function getCh($dclass, $itemkey, $itemvalue, $type=FALSE)
{
    global $db;
    $tbl = 'cor_tbl_'.$dclass;
    $classtype = $dclass.'type';
    $lut = 'cor_lut_'.$classtype;
    // handle non standard dataclass naming
    if ($dclass == 'attr') {
        // attr, handle erroneous dataclass naming
        echo "ADMIN ERROR: as of v1.0 dataclass in fields must be declared as 'attribute' not 'attr'<br/>function getCh()<br/>";
        $dclass = 'attribute';
    }
    if ($dclass == 'attribute') {
        if (!$type) {
            $sql = "
                SELECT a.id, a.attribute, b.attributetype
                FROM cor_tbl_attribute AS a, cor_lut_attribute AS b
                WHERE a.attribute = b.id
                AND a.itemkey = ?
                AND a.itemvalue = ?
            ";  
            $params = array($itemkey,$itemvalue);
        } elseif (is_numeric($type)) {
            $sql = "
                SELECT a.id, a.attribute, b.attributetype
                FROM cor_tbl_attribute AS a, cor_lut_attribute AS b
                WHERE a.attribute = b.id
                AND a.itemkey = ?
                AND a.itemvalue = ?
                AND b.attributetype = ?
            ";
            $params = array($itemkey,$itemvalue,$type);
        } else {
            $sql = "
                SELECT a.id, a.attribute, b.attributetype
                FROM cor_tbl_attribute AS a, cor_lut_attribute AS b, cor_lut_attributetype AS c
                WHERE a.attribute = b.id
                AND b.attributetype = c.id
                AND a.itemkey = ?
                AND a.itemvalue = ?
                AND c.attributetype = ?
            ";
            $params = array($itemkey,$itemvalue,$type);
        }
    } elseif ($dclass == 'xmi') {
        // there are no types for XMIs
        $sql = "
            SELECT *
            FROM $tbl
            WHERE ((itemkey = ? AND itemvalue = ?)
            OR (itemkey = ? AND xmi_itemvalue = ?))
        ";
        $params = array($itemkey,$itemvalue,$itemkey,$itemvalue);
    } elseif ($dclass == 'span') {
        // setup sql for spans
        if (!$type) {
            $sql = "
                SELECT *
                FROM $tbl
                WHERE ((itemkey = ? AND itemvalue = ?)
                OR (itemkey = ? AND `beg` = ?)
                OR (itemkey = ? AND `end` = ?))
            ";
            $params = array($itemkey,$itemvalue,$itemkey,$itemvalue,$itemkey,$itemvalue);
        } else { 
            if (!is_numeric($type)) {
                // fetch the spantype id number
                $type = getClassType('span', $type);
            }
            $sql = "
                SELECT *
                FROM $tbl 
                WHERE ((itemkey = ? AND itemvalue = ? AND $classtype = ?)
                OR (itemkey = ? AND `beg` = ? AND $classtype = ?
                OR (itemkey = ? AND `end` = ? AND $classtype = ?)
            ";
            $params = array($itemkey,$itemvalue,$type,$itemkey,$itemvalue,$type,$itemkey,$itemvalue,$type);
        }
    } else {
        // setup sql for all other classes
        if (!$type) {
            $sql = "
                SELECT *
                FROM $tbl
                WHERE itemkey = ?
                AND itemvalue = ?
            ";
            $params = array($itemkey,$itemvalue);
        } elseif (is_numeric($type)) {
            $sql = "
                SELECT *
                FROM $tbl
                WHERE $classtype = ?
                AND itemkey = ?
                AND itemvalue = ?
            ";
            $params = array($type,$itemkey,$itemvalue);
        } else {
            $sql = "
                SELECT $tbl.id, $tbl.$dclass, $tbl.$classtype
                FROM $tbl, $lut
                WHERE $tbl.$classtype = $lut.id
                AND $lut.$classtype = ?
                AND $tbl.itemkey = ?
                AND $tbl.itemvalue = ?
            ";
            $params = array($type,$itemkey,$itemvalue);
        }
    }
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $chn[] = $frow['id'];
        } while ($frow = $sql->fetch(PDO::FETCH_ASSOC));
    } else {
        $chn = FALSE;
    }
    return($chn);
}

// }}}
// {{{ getChDataByClass()

/**
* returns an array of fragments *of a particular class* chained to a record or fragment 
*
* @param string $dclass  the data class we are interested in eg (txt, attribute, etc)
* @param string $itemkey  the itemkey of the lead record/frag (xxx_cd for records/tbl_name for frags)
* @param string $itemvalue  the itemvalue
* @param string $type  the classtype of the fragment
* @param mixed $recursive  set TRUE to make this go recursively down all chains
* @return array $ch  the chain
* @access public
* @author Guy Hunt
* @author Stuart Eve
* @since 0.8
*
* Note 1: Works only for a single dataclass
*
* Note 2: Attribute and File SQL must be handled in a different way as the types require join syntax 
*
* Note 3: Set the recursive flag to TRUE is you want complete chains returned. The default is to
* only return frags from the first level
*
*/

function getChDataByClass($dclass, $itemkey, $itemvalue, $type=FALSE, $recursive=FALSE)
{
    global $db;
    $tbl = 'cor_tbl_'.$dclass;
    $classtype = $dclass.'type';
    $lut = 'cor_lut_'.$classtype;
    if ($dclass == 'attribute') {
        if (!$type) {
            $sql = "
                SELECT a.id, a.attribute, b.attributetype, a.boolean
                FROM cor_tbl_attribute AS a, cor_lut_attribute AS b
                WHERE a.attribute = b.id
                AND a.itemkey = ?
                AND a.itemvalue = ?
            ";
            $params = array($itemkey,$itemvalue);
        } elseif (is_numeric($type)) {
            $sql = "
                SELECT a.id, a.attribute, b.attributetype, a.boolean
                FROM cor_tbl_attribute AS a, cor_lut_attribute AS b
                WHERE a.attribute = b.id
                AND a.itemkey = ?
                AND a.itemvalue = ?
                AND b.attributetype = ?
            ";
            $params = array($itemkey,$itemvalue,$type);
        } else {
            $sql = "
                SELECT a.id, a.attribute, b.attributetype, a.boolean
                FROM cor_tbl_attribute AS a, cor_lut_attribute AS b, cor_lut_attributetype AS c
                WHERE a.attribute = b.id
                AND b.attributetype = c.id
                AND a.itemkey = ?
                AND a.itemvalue = ?
                AND c.attributetype = ?
            ";
            $params = array($itemkey,$itemvalue,$type);
        }
    } elseif ($dclass == 'xmi') {
        if (!$type) {
            $sql = "
                SELECT *
                FROM $tbl
                WHERE ((itemkey = ? AND itemvalue = ?)
                OR (xmi_itemkey = ? AND xmi_itemvalue = ?))
            ";
            $params = array($itemkey,$itemvalue,$itemkey,$itemvalue);
        } else {
            // there are no types for XMIs
        }
    } elseif ($dclass == 'span') {
        // setup sql for spans
        if (!$type) {
            $sql = "
                SELECT *
                FROM $tbl
                WHERE itemkey = ?
                AND ((itemvalue = ?) OR (beg = ?) OR (end = ?))
            ";
            $params = array($itemkey,$itemvalue,$itemvalue,$itemvalue);
        } elseif (is_numeric($type)) {
            $sql = "
                SELECT *
                FROM $tbl
                WHERE itemkey = ?
                AND $classtype = ?
                AND ((itemvalue = ?) OR (beg = ?) OR (end = ?))
            ";
            $params = array($itemkey,$type,$itemvalue,$itemvalue,$itemvalue);
            
        } else {
            $sql = "
                SELECT *
                FROM $tbl, $lut
                WHERE itemkey = ?
                AND $tbl.$classtype = $lut.id
                AND $lut.$classtype = ?
                AND ((itemvalue = ?) OR (beg = ?) OR (end = ?))
            ";
            $params = array($itemkey,$type,$itemvalue,$itemvalue,$itemvalue);
        }
    } elseif ($dclass == 'file') {
         if (!$type) {
                $sql = "
                    SELECT a.id, a.file, b.filetype
                    FROM cor_tbl_file AS a, cor_lut_file AS b
                    WHERE a.file = b.id
                    AND a.itemkey = ?
                    AND a.itemvalue = ?
                "; 
                $params = array($itemkey,$itemvalue);           
            } elseif (is_numeric($type)) {
                $sql = "
                    SELECT a.id, a.file, b.filetype
                    FROM cor_tbl_file AS a, cor_lut_file AS b
                    WHERE a.file = b.id
                    AND a.itemkey = ?
                    AND a.itemvalue = ?
                    AND b.filetype = ?
                ";
                $params = array($itemkey,$itemvalue,$type); 
            } else {
                $sql = "
                    SELECT a.id, a.file, b.filetype
                    FROM cor_tbl_file AS a, cor_lut_file AS b, cor_lut_filetype AS c
                    WHERE a.file = b.id
                    AND b.filetype = c.id
                    AND a.itemkey = ?
                    AND a.itemvalue = ?
                    AND c.filetype = ?
                ";
                $params = array($itemkey,$itemvalue,$type); 
            }
    } else {
        // setup sql for all other classes
        if (!$type) {
            $sql = "
                SELECT *
                FROM $tbl
                WHERE itemkey = ?
                AND itemvalue = ?
            ";
            $params = array($itemkey,$itemvalue);
        } elseif (is_numeric($type)) {
            $sql = "
                SELECT *
                FROM $tbl
                WHERE $classtype = ?
                AND itemkey = ?
                AND itemvalue = ?
            ";
            $params = array($type,$itemkey,$itemvalue);
        } else {
            $sql = "
                SELECT $tbl.id, $tbl.$dclass, $tbl.$classtype
                FROM $tbl, $lut
                WHERE $tbl.$classtype = $lut.id
                AND $lut.$classtype = ?
                AND $tbl.itemkey = ?
                AND $tbl.itemvalue = ?
            ";
            $params = array($type,$itemkey,$itemvalue);
        }
    }
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // cleanly return results
    if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            // setup
            $key = 'cor_tbl_'.$dclass;
            if ($recursive) {
                // Recursive. This will call getChData() which is itself a wrapper for this function. This will
                // therefore loop until $children is returned false by the getChData() func ie the end of chain
                // seek children of this fragment
                if ($children = getChData(FALSE, $key, $frow['id'], $type, $recursive)) {
                    // there must be more to get
                } else {
                    $children = FALSE;
                }
            } else {
                $children = FALSE;
            }
            switch ($dclass) {
                case 'attribute':
                    $chn[] =
                        array(
                            'dataclass' => $dclass,
                            'id' => $frow['id'],
                            $dclass => $frow[$dclass],
                            $classtype => $frow[$classtype],
                            'boolean' => $frow['boolean'],
                            'attached_frags' => $children,
                    );
                    break;
                    
                case 'action':
                    $chn[] =
                        array(
                            'dataclass' => $dclass,
                            'id' => $frow['id'],
                            $dclass => $frow['actiontype'],
                            'actor_itemkey' => $frow['actor_itemkey'],
                            'actor_itemvalue' => $frow['actor_itemvalue'],
                            'attached_frags' => $children,
                    );
                    break;
                    
                case 'span':
                    $chn[] =
                        array(
                            'dataclass' => $dclass,
                            'id' => $frow['id'],
                            $classtype => $frow[$classtype],
                            'beg' => $frow['beg'],
                            'end' => $frow['end'],
                            'attached_frags' => $children,
                    );
                    break;
                    
                case 'xmi':
                    $chn[] =
                        array(
                            'dataclass' => $dclass,
                            'id' => $frow['id'],
                            'itemkey' => $frow['itemkey'],
                            'itemvalue' => $frow['itemvalue'],
                            'xmi_itemkey' => $frow['xmi_itemkey'],
                            'xmi_itemvalue' => $frow['xmi_itemvalue'],
                            'attached_frags' => $children,
                    );
                    break;
                    
                case 'file':
                    $chn[] =
                        array(
                            'dataclass' => $dclass,
                            'id' => $frow['id'],
                            $dclass => $frow[$dclass],
                            $classtype => $frow[$classtype],
                            'file' => $frow['file'],
                            'attached_frags' => $children,
                    );
                    break;
                    
                default:
                    $chn[] =
                        array(
                            'dataclass' => $dclass,
                            'id' => $frow['id'],
                            $dclass => $frow[$dclass],
                            $classtype => $frow[$classtype],
                            'attached_frags' => $children,
                    );
                    break;
            }
        } while ($frow = $sql->fetch(PDO::FETCH_ASSOC));
    } else {
        $chn = FALSE;
    }
    return($chn);
}

// }}}
// {{{ getChData()

/**
 * returns an array of fragments (with data) chained to an item or fragment
 *
 * @param string $dclass  a data class may be specified 
 * @param string $itemkey  the itemkey of the record/frag (xxx_cd for records/tbl_name for frags)
 * @param string $itemvalue  the itemvalue
 * @param string $type  the classtype of the fragment
 * @param mixed $recursive  set TRUE to make this go recursively down all chains
 * @return array $ch  the chain
 * @access public
 * @author Guy Hunt
 * @since 0.6
 *
 * NOTE 1: As of 0.8 this acts as a wrapper for getChDataByClass(). Pre-existing calls to getChData()
 * will not break as a result of this change. This function allows one or many data classes to be
 * consulted.
 * 
 * $dclass - if left empty or set false, all classes are consulted
 * $type - a specific classtype may be specified. If left empty or set false, all types are consulted
 *
 * NOTE 2: Specifying a class or classtype will reduce overheads.
 *
 * NOTE 3: Set the recursive flag to TRUE is you want complete chains returned. The default is to
 * only return frags from the first level
 *
 */

function getChData($dclass, $itemkey, $itemvalue, $type=FALSE, $recursive=FALSE)
{
    $chn = FALSE;
    if ($dclass && $dclass != 'all') {
        $dclasses = array($dclass);
    } else {
        $dclasses = array('action', 'attribute', 'date', 'span', 'txt', 'number', 'xmi', 'file');
    }
    foreach ($dclasses as $key => $dclass) {
        if ($frags = getChDataByClass($dclass, $itemkey, $itemvalue, $type, $recursive)) {
            foreach ($frags as $key => $frag) {
                $chn[] = $frag;
            }
        }
    }
    return($chn);
}

// }}}
// {{{ getChFullUp()

/**
 * reveals the structure of a chain of fragments going upwards
 *
 * @param string $key the key to set in the itemkey column
 * @param string $value the value to set in the itemvalue column
 * @access public
 * @since 0.6
 *
 * Note 1: This uses the getChLinkUp function as a means to crawl up the chain
 * until it hits an itemkey. It returns an array containing the structure of the
 * chain from the start fragment up to the head.
 *
 */

function getChFullUp($key, $value)
{
    // check that the key value are both setup properly
    if (!$key) {
        echo "the key was FALSE in getChFullUp</br>";
        return FALSE;
    }
    if (!$value) {
        echo "the value was FALSE in getChFullUp</br>";
        return FALSE;        
    }
    // put the current link into the chain
    $chain[] =
        array(
            'key' => $key,
            'value' => $value,
    );
    do {
        $current = end($chain);
        $chain[] = getChLinkUp($current['key'], $current['value']);
        $current = end($chain);
    } while (!isItemkey($current['key']));
    // make a final check for the array and reverse
    if ($chain['head'] = end($chain)) {
        $chain = array_reverse($chain);
        return ($chain);
    }
    return FALSE;
}

// }}}
// {{{ getChLinkUp()

/**
 * retrieves a single fragment or item one link further up a data chain.
 * returns an array containing the key value pair of the link
 *
 * @param string $key the key to set in the itemkey column
 * @param string $value the value to set in the itemvalue column
 * @access public
 * @author Guy Hunt
 * @since 0.6
 *
 * Note 1: In explanation of how this works. The key that is passed here (the key
 * in chains is always a table name) is a table. The value is the id in that table.
 * This means that this function can use getRow().
 *
 * Note 2: If a true itemkey itemval pair is passed here the function will Fail
 *
 */

function getChLinkUp($key, $value)
{
    // check that the key value are both setup properly
    if (!$key OR !$value) {
        echo "either the key or value was FALSE in getChLinkUp<br/>";
        return FALSE;
    }
    // getRow is used to pull a row from the target table, see note above
    if ($row = getRow($key, FALSE, "WHERE id = $value")) {
        $link =
            array(
                'key' => $row['itemkey'],
                'value' => $row['itemvalue'],
        );
        return($link);
    } else {
        return FALSE;
    }
    return ($link);
}

// }}}
// {{{ getAttr()

/**
 * returns an element of a specified attr
 *
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param mixed $attribute  the attribute as defined in the lookup table
 * @param string $element  the element of the attribute to get
 * @param string $lang OPTIONAL if an alias is being returned this needs to be filled
 * @return string $att_lmnt  the attribute element
 * @access public
 * @author Guy Hunt
 * @since 0.1
 *
 * Note 1: this function is normally used to return an array containing elements of
 * attributes of a particular type which are attached to an item by its key value pair.
 * The function can handle numeric and textual references to the attribute type
 *
 * Note 2: nb: use getCh to get a list of attrs if you want to go by attribute type
 *
 */

function getAttr($itemkey, $itemvalue, $attribute, $element, $lang = FALSE)
{
    // Basics
    global $db;
    if (!$lang) {
        global $lang;
    }
    // Set up the SQL
    $field = 'a.'.$element;
    if ($element == 'alias') {
        $field = 'b.'.$element;
    }
    // - according to attribute
    if (is_numeric($attribute)) {
        $sql = "
            SELECT $field, b.language
            FROM cor_tbl_attribute AS a, cor_tbl_alias AS b
            WHERE a.attribute = b.itemvalue
            AND b.itemkey = 'cor_lut_attribute'
            AND a.attribute = ?
            AND a.itemkey = ?
            AND a.itemvalue = ?
            AND b.language= ?
        ";
        $params = array($attribute,$itemkey,$itemvalue,$lang);
    } else {
        if ($attribute == 'SINGLE') {
            $sql = "
                SELECT $field, b.language
                FROM cor_tbl_attribute AS a, cor_tbl_alias AS b
                WHERE a.attribute = b.itemvalue
                AND b.itemkey = 'cor_lut_attribute'
                AND a.id = ?
                AND b.language= ?
            ";
            $params = array($itemvalue,$lang);
        } else {
            $sql = "
                SELECT $field, b.language
                FROM cor_tbl_attribute AS a,
                    cor_tbl_alias AS b,
                    cor_lut_attribute AS c
                WHERE a.attribute = b.itemvalue
                AND b.itemkey = 'cor_lut_attribute'
                AND a.attribute = c.id
                AND c.attribute = ?
                AND a.itemkey = ?
                AND a.itemvalue = ?
                AND b.language= ?
            ";
            $params = array($attribute,$itemkey,$itemvalue,$lang);
        }
    }
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results and return
    if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
        $attlmnt = $frow[$element];
        return($attlmnt);
    } else {
        return(FALSE);
    }
}

// }}}
// {{{ getDateARK()

/**
 * returns a styled date
 *
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param mixed $datetype  the datetype (classtype) - id or nickname
 * @param string $datestyle  the style of date to return
 * @return string $date  the date
 * @access public
 * @author Guy Hunt
 * @since 0.1
 *
 * Note 1: in order to provide access to a single record supply the id number into
 * the itemvalue field and set the datetype to 'SINGLE'.
 *
 * Note 2: As of v1.0 this has been renamed as getDateARK() from getActionDate() due
 * to the old name being misleading (this has nothing to do with actions). It cannot
 * be called just getDate() as this name is already taken by a built in PHP function.
 *
 */

function getDateARK($itemkey, $itemvalue, $datetype, $datestyle)
{
    global $db;
    $lut = 'cor_lut_datetype';
    // set up the SQL fr different eventualities
    if (is_numeric($datetype)) {
        $sql = "
            SELECT cor_tbl_date.date
            FROM cor_tbl_date, $lut
            WHERE cor_tbl_date.datetype = $lut.id
            AND $lut.id = ?
            AND itemkey = ?
            AND cor_tbl_date.itemvalue = ?
        ";
        $params = array($datetype,$itemkey,$itemvalue);
    } else {
        if ($datetype == 'SINGLE') {
            $sql = "
                SELECT date
                FROM cor_tbl_date
                WHERE id = ?
            ";
            $params = array($itemvalue);
        } else {
            $sql = "
                SELECT cor_tbl_date.date
                FROM cor_tbl_date, $lut
                WHERE cor_tbl_date.datetype = $lut.id
                AND $lut.datetype = ?
                AND itemkey = ?
                AND cor_tbl_date.itemvalue = ?
            ";
            $params = array($datetype,$itemkey,$itemvalue);
        }
    }
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle the results
    if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
        // the raw date
        $rawdate = $frow['date'];
        // style the date as required
        $date = splitDate($rawdate, $datestyle);
        // return it
        return($date);
    } else {
        // return false
        return(FALSE);
    }
}

// }}}
// {{{ getEXIFData()

/**
 * returns an either an array of the EXIF data from a file or an HTML string
 *
 * @param string $filename  the file to retrieve the EXIF data from
 * @param string $mode  OPTIONAL - the return mode 'array' or 'html' - Default is 'array'
 * @param boolean $map  OPTIONAL - if you want to include a map in the response then send
 *    the name of the saved map here - Default is FALSE
 * @return array $array the EXIF data as a raw array
 * @return string $string the EXIF data as a formatted HTML string
 * @access public
 * @author Stuart Eve
 * @since 1.1
 *
 */

function getEXIFData($filename, $mode = 'array', $map = FALSE)
{
    global $lang;
    $return_array = array();
    $exif_content = '';
    //get orignal filename
    $file_id = basename($filename);
    $file_id = explode('.',$file_id);
    $file_info = getMulti('cor_lut_file',"id={$file_id[0]}");
    $orig_filename = $file_info[0]['filename'];
    if ($file_info[0]['uri'] != FALSE) {
        $orig_filename = $file_info[0]['uri'] . $file_info[0]['filename'];
    }
    //first see if the file is readable
    if (!is_readable($filename)) {
        if ($mode != 'array') {
            //we always want at least the filename
            $mk = getMarkup('cor_tbl_markup', $lang, 'filename');           
            $var = "<div>";
            $var .= "<ul>";
            $var .= "<li class='exif_row'><label class='exif_label'>$mk</label><span class='exif_data'>$orig_filename</span></li>";
            $var .= "</ul>";
            $var .= "</div>";
            return $var;
        } else {
            $return_array['success'] = 0;
            $return_array['error'] = "file is unreadable";
            return($return_array);
        }
    }
    //if it is readable try and get the EXIF data
    $exif = exif_read_data($filename);
    if (!$exif) {
        if ($mode != 'array') {
            //we always want at least the filename
            $mk = getMarkup('cor_tbl_markup', $lang, 'filename');
            $exif_content .= "<li class='exif_row'><label class='exif_label'>$mk</label><span class='exif_data'>$orig_filename</span></li>";
        } else {
            $return_array['success'] = 0;
            $return_array['error'] = "no EXIF data available";
            return($return_array);
        }
    }
    //we have some EXIF data - now decide what to do with it
    //first let's check for and tidyup the GPS coordinates if they are available
    //get the Hemisphere multiplier
    $latM = 1; 
    $longM = 1;
    if (array_key_exists('GPSLatitudeRef', $exif) && $exif["GPSLatitudeRef"] == 'S') {
        $latM = -1;
    }
    if(array_key_exists('GPSLongitudeRef', $exif) && $exif["GPSLongitudeRef"] == 'W') {
        $longM = -1;
    }
    if (array_key_exists('GPSLatitude', $exif) && array_key_exists('GPSLongitude', $exif)) {
        $gps = array();
        //get the GPS data
        $gps['LatDegree']=$exif["GPSLatitude"][0];
        $gps['LatMinute']=$exif["GPSLatitude"][1];
        $gps['LatgSeconds']=$exif["GPSLatitude"][2];
        $gps['LongDegree']=$exif["GPSLongitude"][0];
        $gps['LongMinute']=$exif["GPSLongitude"][1];
        $gps['LongSeconds']=$exif["GPSLongitude"][2];
        
    } else {
        $gps = FALSE;
    }
    if ($gps) {
        //convert strings to numbers
        foreach($gps as $key => $value) {
            $pos = strpos($value, '/');
            if($pos !== false) {
                $temp = explode('/',$value);
                $gps[$key] = $temp[0] / $temp[1];
            }
        }
        //calculate the decimal degree
        $exif['GPSLatitude'] = $latM * ($gps['LatDegree'] + ($gps['LatMinute'] / 60) + ($gps['LatgSeconds'] / 3600));
        $exif['GPSLongitude'] = $longM * ($gps['LongDegree'] + ($gps['LongMinute'] / 60) + ($gps['LongSeconds'] / 3600));
        //in order to get a float for the direction we need to convert the fractional rational
        $img_direction = explode('/', $exif['GPSImgDirection']);
        $exif['GPSImgDirection'] = $img_direction[0] / $img_direction[1];
    }
    //now we have cleaned up, either return the whole array 
    //or an HTML table of the main EXIF tags
    if ($mode == 'array') {
        $return_array = $exif;
        return($exif);
    } else {
        //we always want at least the filename
        $mk = getMarkup('cor_tbl_markup', $lang, 'filename');
        $exif_content .= "<li class='exif_row'><label class='exif_label'>$mk</label><span class='exif_data'>$orig_filename</span></li>";
        
        $mk = getMarkup('cor_tbl_markup', $lang, 'make');
        $exif_content .= "<li class='exif_row'><label class='exif_label'>$mk</label><span class='exif_data'>{$exif['Make']}</span></li>";
        if (array_key_exists('Make',$exif)) {
            $mk = getMarkup('cor_tbl_markup', $lang, 'make');
            $exif_content .= "<li class='exif_row'><label class='exif_label'>$mk</label><span class='exif_data'>{$exif['Make']}</span></li>";
        }
        if (array_key_exists('Model', $exif)) {
            $mk = getMarkup('cor_tbl_markup', $lang, 'model');
            $exif_content .= "<li class='exif_row'><label class='exif_label'>$mk</label><span class='exif_data'>{$exif['Model']}</span></li>";
        }
        if (array_key_exists('ExposureTime', $exif)) {
            $mk = getMarkup('cor_tbl_markup', $lang, 'exposuretime');
            $exif_content .= "<li class='exif_row'><label class='exif_label'>$mk</label><span class='exif_data'>{$exif['ExposureTime']}</span></li>";
        }
        if (array_key_exists('FNumber', $exif)) {
            $mk = getMarkup('cor_tbl_markup', $lang, 'fnumber');
            $efnumber = $exif['FNumber'];
            $efnumber = explode('/', $efnumber);
            $efnumber = $efnumber[0] / $efnumber[1];
            $exif_content .= "<li class='exif_row'><label class='exif_label'>$mk</label><span class='exif_data'>$efnumber</span></li>";
        }
        if (array_key_exists('ISOSpeedRatings',$exif)) {
            $mk = getMarkup('cor_tbl_markup', $lang, 'ISO');
            $exif_content .= "<li class='exif_row'><label class='exif_label'>$mk</label><span class='exif_data'>{$exif['ISOSpeedRatings']}</span></li>";
        }
        if (array_key_exists('DateTime', $exif)) {
            $mk = getMarkup('cor_tbl_markup', $lang, 'date');
            $edate = $exif['DateTime'];
            $date = explode(" ", $edate);
            $fulldate = date('j F Y h:i:s A',strtotime(str_replace(":","-",$date[0])." ".$date[1]));
            $exif_content .= "<li class='exif_row'><label class='exif_label'>$mk</label><span class='exif_data'>$fulldate</span></li>";
        }
        //grab out the 'usual' tags and create a nice list from them DEV NOTE: Labels should be MARKUP!
        $var = "<div>";
        $var .= "<ul>";
        $var .= $exif_content;
        //if we really want to be flashy we can pop in a small map as well
        if ($map && $gps) {
            $var .= "<li>";
            $gps_points = array(
                'x' => $exif['GPSLongitude'],
                'y' => $exif['GPSLatitude'],
                'rot' => $exif['GPSImgDirection'],
            );
            $manual_points[] = $gps_points;
            include_once ('map/map_functions.php');
            //grab the wmc array
            $wmc = getMulti('cor_tbl_wmc', "name = '$map'");
            if (is_array($wmc)) {
                $wmc_code = addslashes($wmc[0]['wmc']);
                $var .= loadWMCMap($wmc_code, $wmc[0]['id'], 'map', 'manual', $manual_points);
            } else {
                echo "ADMIN ERROR: Error with the sf_conf, the map set in background map doesn't seem to exist";
            }
            $var .= "</li>";
        }
        $var .= "</ul>";
        $var .= "</div>";
        return $var;
    }
}

// }}}
// {{{ getXmi()

/**
* gets all the xmi links for a specified itemkey
*
* @param string $itemkey  the itemkey of the parent module
* @param string $itemvalue  the itemvalue
* @param string $mod  OPTIONAL limits results to the specified module
* @return array $array  containing the XMIed items
* @access public
* @author Stuart Eve
* @since 0.5.1
*
*/

function getXmi($itemkey, $itemvalue, $mod=FALSE)
{
    global $db;
    // setup sql
    $sql = "
        SELECT id, itemkey, itemvalue, xmi_itemkey, xmi_itemvalue
        FROM cor_tbl_xmi
        WHERE ((itemkey = ? AND itemvalue = ?)
        OR (xmi_itemkey = ? AND xmi_itemvalue = ?))
    ";
    $params = array($itemkey,$itemvalue,$itemkey,$itemvalue);
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            // if the real pair is in the right side do not look at the value anymore
            if ($row['xmi_itemkey'] != $itemkey) {
                $array[] =
                    array(
                        'id' => $row['id'],
                        'xmi_itemkey' => $row['xmi_itemkey'],
                        'xmi_itemvalue' => $row['xmi_itemvalue']
                );
            } else {
                // otherwise it must be in the other side
                $array[] =
                    array(
                        'id' => $row['id'],
                        'xmi_itemkey' => $row['itemkey'],
                        'xmi_itemvalue' => $row['itemvalue']
                );
            }
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC)); 
    }
    // remove unwanted mods
    if ($mod && isset($array)) {
        $mod = explode(',', $mod);
        foreach ($mod as $mod) {
            $mod = $mod.'_cd';
            foreach ($array as $row) {
                if ($row['xmi_itemkey'] == $mod) {
                    $ret_array[] = $row;
                }
            }
        }
    }
    // Return
    if (isset($ret_array)) {
        // Sort the array into a natural ascending sort order
        $ret_array = sortResArr($ret_array, 'SORT_ASC', 'xmi_itemvalue');
        return($ret_array);
    } else {
        return(FALSE);
    }
}

// }}}
// {{{ getLutIdFromData()

/**
 * tries to get the id of a row in a LUT based data
 *
 * @param string $lut  the name of the look up table
 * @param string $lang  the desired lang
 * @param string $and  NON optional "AND" clause
 * @return void
 * @author Guy Hunt
 * @since 0.4
 *
 * Note 1: the AND clause must be filled in order to specify what to look for and where
 *    eg: "AND cor_tbl_alias.alias = '$valtochkfr'"
 *
 * Note 2: Until v1.1 this was called chkLutId() but as it actually returns
 * the ID it was renamed
 *
 */

function getLutIdFromData($lut, $lang, $and)
{
    global $db, $ark_db;
    // switch database
    // TODO: DEV NOTE
    // use does not work with PDO so db specified in query
    // maybe should make a new PDO object for these things
    // $db->query("use $ark_db");
    // Set up the SQL
    $sql = "
        SELECT $ark_db.$lut.id
        FROM $ark_db.$lut, $ark_db.cor_tbl_alias
        WHERE $ark_db.$lut.id = $ark_db.cor_tbl_alias.itemvalue
        AND $ark_db.cor_tbl_alias.itemkey = ?
        AND $ark_db.cor_tbl_alias.language = ?
        $and
    ";
    $params = array($lut,$lang);
    // run the Query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $lut_id = $row['id'];
        return($lut_id);
    } else {
        return(FALSE);
    }
}

// }}}
// {{{ getModType()

/**
* returns the modtype of an item
*
* @param string $mod  the module you are looking at
* @param string $item  the itemvalue you are checking
* @returns integer $type  the modtype of the item
* @access public
* @author Guy Hunt
* @since 0.5.1
*
*/

function getModType($mod, $item)
{
    global $db;
    // error handling
    if (!isset($mod)) {
        echo "function: getModType<br/>";
        echo "mod is not set correctly";
    }
    if (!isset($item)) {
        echo "function: getModType<br/>";
        echo "item is not set correctly";
    }
    // Check that this mod is using types
    if (!chkModType($mod)) {
        return(FALSE);
    }
    // Setup
    $modtype = $mod.'type';
    $tbl = $mod.'_tbl_'.$mod;
    $col = $mod.'_cd';
    // The SQL
    $sql = "
        SELECT $modtype
        FROM $tbl
        WHERE $col = ?
    ";
    $params = array($item);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results
    if ($raw = $sql->fetch(PDO::FETCH_ASSOC)) {
        $type = $raw[$modtype];
        return ($type);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ getClassType()

/**
 * returns the classtype (switches nname for number and vice versa)
 *
 * @param string $dataclass  the class type you are looking for (i.e 'txt')
 * @param string $rawvar  the var to search with
 * @returns mixed $val  the classtype nname or id
 * @access public
 * @author Guy Hunt
 * @since 0.5.1
 *
 * Note 1: As of v1.1 this guesses the required return mode
 *
 */

function getClassType($dataclass, $rawvar)
{
    global $db;
    if (!$dataclass or !$rawvar) {
        echo "error in getClassType missing var: dataclass: '$dataclass'; rawvar: '$rawvar'";
        return FALSE;
    }
    // handle non standard dataclass naming
    if ($dataclass == 'attr') {
        echo "ADMIN ERROR: as of v1.0 dataclass in fields must be declared as 'attribute' not 'attr'<br/>function getClassType()<br/>";
        $dataclass = 'attribute';
    }
    if (is_numeric($rawvar)) {
        // fetch the nname
        $col = $dataclass.'type';
        $sql = "
            SELECT $col
            FROM cor_lut_{$dataclass}type
            WHERE id = ?
        ";
        $params = array($rawvar);
    } else {
        // return the id
        $col = 'id';
        $sql = "
            SELECT $col
            FROM cor_lut_{$dataclass}type
            WHERE {$dataclass}type = ?
        ";
        $params = array($rawvar);
    }
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle results
    if ($raw = $sql->fetch(PDO::FETCH_ASSOC)) {
        $val = $raw[$col];
        return ($val);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ getSpan()

/**
 * returns the elements of a span of the specified type
 *
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param mixed $spantype  the spantype of the span
 * @return array $span  the span(s) in the format array[0]=>['id'], - the id of the span
 *                                                array[0]=>['beg'], - the beginning value of the span
 *                                                array[0]=>['end'] - the end value of the span
 * @access public
 * @author Stuart Eve
 * @since 0.6
 *
 */

function getSpan($itemkey, $itemvalue, $spantype)
{
    global $db;
    $lut = 'cor_lut_spantype';
    // set up the SQL
    if (is_numeric($spantype)) {
        $sql = "
            SELECT *
            FROM cor_tbl_span
            WHERE itemkey = ?
            AND spantype = ?
            AND ((itemvalue = ?) OR (beg = ?) OR (end = ?))
        ";
        $params = array($itemkey,$spantype,$itemvalue,$itemvalue,$itemvalue);
    } else {
        $sql = "
            SELECT cor_tbl_span.*, $lut.id as 'spantypeid', $lut.spantype
            FROM cor_tbl_span, $lut
            WHERE itemkey = ?
            AND cor_tbl_span.spantype = $lut.id
            AND $lut.spantype = ?
            AND ((itemvalue = ?) OR (beg = ?) OR (end = ?))
        ";
        $params = array($itemkey,$spantype,$itemvalue,$itemvalue,$itemvalue);
    }
    //DEBUG
//     printPre(array($sql,$params));
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle results
    if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $span[] = $frow;
        } while ($frow = $sql->fetch(PDO::FETCH_ASSOC));
        // return
        return $span;
    } else {
        // return
        return FALSE;
    }
}

// }}}
// {{{ getSpanAttr()

/**
 * returns an array of attributes of a span
 *
 * @param integer $span_id  Kthe numeric id of the span
 * @param string $element  the element to return
 * @param integer $aliastype  OPTIONAL the type of the alias ( 1(for)/2(against) )
 * @returns mixed $elem  the requested element
 * @access public
 * @author Guy Hunt
 * @since 0.5.1
 *
 */

function getSpanAttr($span_id, $element, $aliastype=NULL)
{
    global $db, $lang;
    // setup the SQL
    if ($element == 'alias') {
        $sql = "
            SELECT alias
            FROM cor_tbl_spanattr AS a, cor_tbl_alias AS b
            WHERE a.spanlabel = b.itemvalue
            AND b.itemkey = 'cor_lut_spanlabel'
            AND a.span = ?
            AND b.aliastype = ?
            AND b.language= ?
        ";
        $params = array($span_id,$aliastype,$lang);
    } else {
        $sql = "
            SELECT b.$element
            FROM cor_tbl_spanattr AS a, cor_lut_spanlabel AS b
            WHERE a.spanlabel = b.id
            AND a.span = ?
       ";
       $params = array($span_id);
    }
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle results
    if ($attrow = $sql->fetchAll(PDO::FETCH_ASSOC)) {
        return($attrow[0][$element]);
    } else {
        return(FALSE);
    }
}

// }}}
// {{{ getAlias()

/**
 * retrieves the alias of something in the database
 *
 * @param string $tbl  the table in which the thing is held (NOT the alias)
 * @param string $lang  the target language
 * @param string $col  the column in $tbl in which the $src_key resides
 * @param string $src_key  the value to search in $col for
 * @param int $type  the type of alias (see below)
 * @return string $alias  the alias
 * @author Guy Hunt
 * @since 0.4
 *
 * Note 1: This uses a caching system whereby aliases are cached to the session
 *
 * Alias types are:
 *  1 - Normal
 *  2 - Against (used in attributes where the desired alias is opposite type 1)
 *  3 - Span Beg (used for the beginning element of a span)
 *  4 - Span End (used for the end element of a span)
 *  5 - Boolean True (used in the case where you want a word to represent db true)
 *  6 - Boolean False (used in the case where you want a word to represent db false)
 *
 */

function getAlias($tbl, $lang, $col, $src_key, $type)
{
    global $db, $default_lang;
    // check if the requested alias already exists in the cache
    if (array_key_exists('alias_cache', $_SESSION)) {
        if (array_key_exists($tbl.$lang.$col.$src_key.$type, $_SESSION['alias_cache'])) {
            $cache_alias = $_SESSION['alias_cache'][$tbl.$lang.$col.$src_key.$type];
            return $cache_alias;
        }
    }
    // otherwise, make the sql
    $sql = "
        SELECT a.alias, a.language
        FROM cor_tbl_alias AS a, $tbl AS b
        WHERE
        CASE
            WHEN a.language = ? THEN a.language = ?
            ELSE a.language = ?
        END
        AND a.aliastype = ?
        AND a.itemkey = ?
        AND a.itemvalue = b.id
        AND b.$col = ?
    ";
    $params = array($lang,$lang,$default_lang,$type,$tbl,$src_key);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // deal with the results
    if ($alrow = $sql->fetch(PDO::FETCH_ASSOC)) {
        // get back all aliases
        do {
            $aliases[] = $alrow;
        } while($alrow = $sql->fetch(PDO::FETCH_ASSOC));
        // loop over them to sort
        foreach($aliases as $alias_row) {
            if ($alias_row['language'] == $lang) {
                $alias = $alias_row['alias'];
            }
            if ($alias_row['language'] == $default_lang) {
                $default_alias = $alias_row['alias'];
            }
        }
    }
    // return intelligently
    if (isset($alias)) {
        //add to the cache
        $_SESSION['alias_cache'][$tbl.$lang.$col.$src_key.$type] = $alias;
        return ($alias);
    } elseif (isset($default_alias)) {
        //add to the cache
        $_SESSION['alias_cache'][$tbl.$lang.$col.$src_key.$type] = $default_alias;
        return ($default_alias);
    } else {
        return ("getAlias: Returned empty set<br/>");
    }
}

// }}}
// {{{ getAllAliases()

/**
 * retrieves all of the aliases of something in the database, regardless of language
 *
 * @param string $tbl  the table in which the thing is held (NOT the alias)
 * @param string $col  the column in $tbl in which the $src_key resides
 * @param string $src_key  the value to search in $col for
 * @param int $type  the type of alias (see below)
 * @return array $aliases  an array of aliases [0] => ['alias'] = the alias
 *                                                    ['language'] = the language of the alias
 * @author Stuart Eve
 * @since 0.6
 *
 * Alias types are described in the notes of the getAlias() function
 *
 */

function getAllAliases($tbl, $col, $src_key, $type)
{
    global $db;
    // make the sql
    $sql = "
        SELECT a.id, alias,language
        FROM cor_tbl_alias AS a, $tbl AS b
        WHERE
        a.aliastype = ?
        AND a.itemkey = ?
        AND a.itemvalue = b.id
        AND b.$col = ?
    ";
    $params = array($type,$tbl,$src_key);
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);

    if ($alrow = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $aliases[] = $alrow;
        } while($alrow = $sql->fetch(PDO::FETCH_ASSOC));
    }
    if (isset($aliases)) {
        return ($aliases);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ getRow()

/**
 * returns a row from the given table in the format of a mysql_fetch_array()
 *
 * @param string $tbl  the name of the table to look at
 * @param int $id  the optional id number of the row
 * @param string $where  a mysql compliant where clause 
 * @return void
 * @author Guy Hunt
 * @since 0.3
 *
 * Note 1: if you use the optional id param any where clause is ignored and vice versa
 *
 */

function getRow($tbl, $id=FALSE, $where=FALSE)
{
    global $db;
    // sql depends if the id is to be used
    if ($id) {
        $sql = "
            SELECT *
            FROM $tbl
            WHERE id = ?
        ";
        $params = array($id);
    } else {
        $params = array();
        $sql = "
            SELECT *
            FROM $tbl
            $where
        ";
    }
    // run the sql
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // get the row
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        return ($row);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ getSingle()

/**
 * gets a single value in a fairly abstracted way
 *
 * @param string $col  the column in $tbl in which the $src_key resides
 * @param string $tbl  the table in which the thing is held (NOT the alias)
 * @param string $where  a where statement
 * @author Guy Hunt
 * @since 0.2
 *
 */

function getSingle($col, $tbl, $where, $params = array())
{
    global $db;
//     set up SQL
    if ( stristr($where,'where')){
        $where = substr($where, stripos($where,"where")+5);
    }
    $sql = "
        SELECT $col
        FROM $tbl
        WHERE $where
    ";
    // for debug
    // printPre($sql);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $value = $row["$col"];
        return ($value);
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getMulti()

/**
 * gets multiple rows from the db
 *
 * @param string $tbl  the table to get data from
 * @param string $where  a mysql compliant where clause starting after the word WHERE
 * @param string $col  a column to return only results from a single col (faster)
 * @param string $distinct  set to true to only select distinct results (even faster)
 * @return array $res_arr  containing the results or FALSE if there are none
 * @author Guy Hunt
 * @since 0.2
 *
 * Note 1: the db call is faster if you specify a specific column. However this advantage is
 * lost if you need to go back to the db more than once. Therefore getting all cols is
 * faster than running this function twice
 *
 */

function getMulti($tbl, $where, $col=FALSE, $distinct=FALSE)
{
    global $db;
    // make up the sql
    if (!$col) {
        $col = '*';
    }
    if ($distinct == TRUE) {
        $distinct = 'DISTINCT';
    } else {
        $distinct = '';
    }
    $sql = "
        SELECT $distinct $col
        FROM `$tbl`
        WHERE $where
    ";
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,array(),__FUNCTION__);
    // return the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        // create a neat array
        do {
            if ($col == '*') {
                $res_arr[] = $row;
            } else {
                $res_arr[] = $row[$col];
            }
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
        return ($res_arr);
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getFIndex()

/**
 * gets faux indexed data from the db
 *
 * @param string $dataclass  the dataclass
 * @param string $classtype  the classtype
 * @param string $mod  the module to 'index'
 * @return array $fauxdex  containing the results or FALSE if there are none
 * @author Guy Hunt
 * @since 0.9
 *
 */

function getFIndex($dataclass, $classtype, $mod)
{
    global $db, $results_array;
    switch ($dataclass) {
        case 'attribute':
            $sql = "
                SELECT a.attribute, COUNT(a.attribute)
                FROM cor_tbl_attribute AS a, cor_lut_attribute AS b
                WHERE a.attribute = b.id
                AND b.attributetype = ?
                GROUP BY a.attribute
            ";
            $params = array($classtype);
            break;
        
        default:
            echo "DEVELOPER ERROR: calls to getFIndex only support 'attributes' at present";
            break;
    }
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // return the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        // for each hit, get the total of this type
        do {
            $fauxdex[] =
                array(
                    'classtype' => $row['attribute'],
                    'count' => $row['COUNT(a.attribute)']
            );
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
        return ($fauxdex);
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getMarkup()

/**
 * gets a single item of markup
 *
 * @param string $tbl  table in which markup is held
 * @param string $lang  is the desired language
 * @param string $nname  the markup 'nickname'
 * @param boolean $bool  OPTIONAL - if this is set then the function will return
 *                           either true or false instead of the markup itself
 * @return string $markup a string of marked up html
 * @author Guy Hunt
 * @since 0.2
 *
 */

function getMarkup($tbl, $lang, $nname, $bool = FALSE)
{
    // SPECIAL CASE, KEYWORDS:
    // 'this_itemvalue' - just return the current itemvalue as the markup
    if ($nname == 'this_itemvalue') {
        global $item_key, $$item_key;
        return $$item_key;
    }
    // NORMAL MARKUP CALLS
    $markup = FALSE;
    global $db, $default_lang;
    // prepare the SQL statement
    $sql = "SELECT 
            markup,language 
            FROM $tbl 
            WHERE nname =?
    ";
    $params = array($nname);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle the results
    // Select which summary array to isert this snippet
    $lang_markup = array();
    $default_markup = array();
    $other_markup = array();
    if ($mkrow = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            if ($mkrow['language'] == $lang && $default_lang != $lang) {
                $lang_markup[] = $mkrow['markup'];
            } elseif ($mkrow['language'] == $default_lang) {
                $default_markup[] = $mkrow['markup'];
            } else {
                $other_markup[] = $mkrow['markup'];
            }
            $markup = $lang_markup + $default_markup + $other_markup;
            $markup = $markup[0];
        } while ($mkrow = $sql->fetch(PDO::FETCH_ASSOC));
        if ($bool && $markup) {
            $markup = TRUE;
        }
    } else {
        if ($bool) {
            $markup = FALSE;
        } else {
            $markup = "failed to get markup '$nname'";
        }
    }
    return ($markup);
}

// }}}
// {{{ getMetadataByClass()

/**
* returns an array of all the possible entries *of a particular class* within the ARK instance
* this is used to describe the instance using the API
*
* @param string $dclass  the data class we are interested in eg (txt, attribute, etc)
* @param string $type  the classtype of the fragment
* @return array $res  the chain
* @access public
* @author Guy Hunt
* @author Stuart Eve
* @since 1.1
*
* Note 1: Works only for a single dataclass
*
* Note 2: Attribute and File SQL must be handled in a different way as the types require join syntax 
*
* Note 3: XMIs have no types and therefore nothing is returned
*
*
*/

function getMetadataByClass($dclass, $type=FALSE)
{
    global $db;
    $tbl = 'cor_tbl_'.$dclass;
    $classtype = $dclass.'type';
    $lut = 'cor_lut_'.$classtype;
    $res = '';
    // setup sql for all other classes
    if ($dclass != 'xmi') {
        $sql = "
            SELECT *
            FROM $lut
        ";
        // run the query
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        // cleanly return results
        if ($frow = $sql->fetch(PDO::FETCH_ASSOC)) {
            do {
                switch ($dclass) {
                    default:
                        $res[] =
                            array(
                                'dataclass' => $dclass,
                                'id' => $frow['id'],
                                $classtype => $frow[$classtype],
                        );
                        break;
                }
            } while ($frow = $sql->fetch(PDO::FETCH_ASSOC));
        } else {
            $res = FALSE;
        }
    }
    return($res);
}

// }}}
// {{{ getUserAttr

/**
 * gets information about a user
 *
 * @param user_id string  the user id
 * @param element string  the desired element ('full' will return firstname.'_'.lastname)
 * @return void
 * @author Guy Hunt
 * @since
 *
 * Note: The name of the function is confusing. This is nothing to do with attributes
 *
 */

function getUserAttr($user_id, $element)
{
    global $db;
    if ($element == 'full') {
        $select = 'firstname, lastname';
    } else {
        $select = $element;
    }
    // set up SQL
    $sql = "
        SELECT $select
        FROM cor_tbl_users
        WHERE id = ?
    ";
    $params = array($user_id);
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle the results
    $attrow = $sql->fetch(PDO::FETCH_ASSOC);
    if ($element == 'full') {
        $attr = $attrow['firstname'].' '.$attr = $attrow['lastname'];
    } else {
        $attr = $attrow["$element"];
    }
    return ($attr);
}

// }}}
// {{{ getSteCd()

/**
 * gets a site code from one of 3 sources
 *
 * @param $db resource  the db connection
 * @param $cmap_id string  the id number of this CMAP
 * @param $stecd_lut array  parameters of a look up table
 * @return $ste_cd string  the ste_cd
 * @author Guy Hunt
 * @since v0.5
 *
 * $stecd_lut - is OPTIONAL
 *  if this is sent then the function knows that it has to lookup the site
 *  code from db tables. This is an array consisting of:
 *  - 'uid' - the unique id on the uid col
 *  - 'tbl' - the source data table
 *  - 'uid_col' - the column containing the unique id's of this table
 *  - 'raw_stecd_tbl' - the table containing the raw site codes
 *  - 'raw_stecd_col' - the column on this table containing the site codes
 *  - 'raw_stecd_join_col' - the column on the table containing the join values
 *  - 'tbl_stecd_join_col' - the column on the source table containing the join values
 *
 * NOTE: as of v0.8, this handles three options rather than two. The original
 * options were to either pull the fixed site code from the CMAP or to get it
 * from a look up table. This can now also get a site code from a specified
 * column on the source table
 *
 * NOTE: there are two keywords here that are relevant: CHAIN and FALSE.
 *  CHAIN - When data is being chained to other data, the keyword chain prevents the
 *    use of a site code
 *  FALSE - This is a string that must be interpreted as logical false in vars:
 *    'raw_stecd_col' => FALSE, and 'raw_stecd_tbl' => FALSE
 *
 * NOTE: This function has 4 possible outcomes:
 *   CHAIN - if the raw_stecd_col contains the keyword 'CHAIN', this is returned as
 *       the site code
 *   LOOK UP JOIN - if 'raw_stecd_col' AND 'raw_stecd_tbl' have values then a full
 *       look up routine with join is executed
 *   SOURCE TABLE - if 'raw_stecd_col' is a real value but 'raw_stecd_tbl' is FALSE,
 *       then it is the source table that is used for the look up
 *   FIXED - if 'raw_stecd_col' AND 'raw_stecd_tbl' are both FALSE then the system
 *       will get the site code specified for this CMAP
 *
 */

function getSteCd($db, $cmap_id, $stecd_lut=FALSE)
{
    global $ark_db, $sql_server, $sql_user, $sql_pwd, $db;

    // if the $stecd_lut is false set these vars up to prevent errors
    if (!$stecd_lut) {
        $stecd_lut =
        array(
            'raw_stecd_col' => FALSE,
            'raw_stecd_tbl' => FALSE
        );
    }

    // FALSE keyword - needs handling properly on these fields
    if ($stecd_lut['raw_stecd_col'] == 'FALSE') {
        $stecd_lut['raw_stecd_col'] = FALSE;
    }
    if ($stecd_lut['raw_stecd_tbl'] == 'FALSE') {
        $stecd_lut['raw_stecd_tbl'] = FALSE;
    }

    // CHAIN keyword - return it direct and kill the function
    if ($stecd_lut['raw_stecd_col'] == 'CHAIN') {
        $stecd = 'CHAIN';
        return ($stecd);
    } else {
        $ste_cd = FALSE;
    }

    // THE 3 MAIN OPTIONS
    if ($stecd_lut['raw_stecd_col']) {
        // both options need to switch to the source db
        // get the source_db (may be in a whole other db)
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
        $source_db = getCmapDB($db, $cmap_id);
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);

        // LOOK UP JOIN
        if ($stecd_lut['raw_stecd_tbl']) {
            $sql = "
            SELECT {$stecd_lut['raw_stecd_tbl']}.{$stecd_lut['raw_stecd_col']}
                    FROM {$stecd_lut['raw_stecd_tbl']},  {$stecd_lut['tbl']}
                    WHERE  {$stecd_lut['tbl']}.{$stecd_lut['tbl_stecd_join_col']} = ?
                    AND  {$stecd_lut['tbl']}.{$stecd_lut['uid_col']} =  ?
            ";
            $params = array($stecd_lut['raw_stecd_tbl'].$stecd_lut['raw_stecd_join_col'],$stecd_lut['uid']);
                    // SOURCE TABLE
        } else {
            $sql = "
                    SELECT {$stecd_lut['raw_stecd_col']}
                    FROM {$stecd_lut['tbl']}
                    WHERE {$stecd_lut['uid_col']} = ?
            ";
            $params = array($stecd_lut['uid']);
        }
        // RUN CODE for both options
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        // handle results
        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $stecd = $row[$stecd_lut['raw_stecd_col']];
        }
        // FIXED SITE CODE
    } else {
        $sql = "
            SELECT stecd FROM cor_tbl_cmap WHERE id = ?
        ";
        $params = array($cmap_id);
        // RUN CODE for this fixed option
        //$db->query("use $ark_db");
        $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $stecd = $row['stecd'];
        }
    }

   // RETURN - all options
   // return the database to the ark_db
    //$db->query("use $ark_db");
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
    if ($stecd) {
        return $stecd;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getTables()

/**
 * retrieves an array of table names from the specified database
 *
 * @param object $db  a valid db connection
 * @param string $db_name  the database name to use
 * @return array $tables  containing the table names in the specified db
 * @author Guy Hunt
 * @since 0.4
 *
 */

function getTables($db, $db_name)
{
    // Set up SQL
    $sql = "SHOW TABLES FROM $db_name";
    $params = array();
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle results
    if ($row = $sql->fetch(PDO::FETCH_BOTH)) {
        do {
            $tables[] = $row[0];
        } while ($row = $sql->fetch(PDO::FETCH_BOTH));
    }
    return $tables;
}

// }}}
// {{{ getColumns()

/**
 * retrieves an array of column names from the specified database and table
 *
 * @param object $db  a valid db connection
 * @param string $db_name  the database name to use
 * @param string $table_name  the name of the table to get the columns from
 * @return array $columns  containing the table names in the specified db
 * @author Guy Hunt
 * @since 0.4
 *
 */

function getColumns($db, $db_name, $table_name)
{
    // Set up the SQL
    $sql = "SHOW COLUMNS FROM $db_name.$table_name";
    $params = array();
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            // this is a mysql field
            $columns[] = $row['Field'];
        } while($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    return $columns;
}

// }}}
// {{{ getAllItems()

/**
 * retrieves every item in ARK belonging to a specific mod
 *
 * @param string $mod the name of the mod
 * @return array $items containing the results of the query
 * @author Stuart Eve
 * @since 0.6
 *
 */

function getAllItems($mod)
{
    global $db;
    $items = array();
    // Set up the SQL
    $sql = "SELECT * FROM {$mod}_tbl_{$mod}";
    $params = array();
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $items[] = $row;
        } while($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    return $items;
}

// }}}
// {{{ getSfs()

/**
 * gets an array containing all the subforms assigned to an item
 *
 * @param string $mod  the short form of this module
 * @return array $sfs  an array containing the sfs
 * @author Guy Hunt
 * @since v0.8
 *
 * Note 1: Was written for use with the change modtype functionality
 *
 */

function getSfs($mod)
{
    // fetch the settings for this module
    include("config/settings.php");
    include("config/field_settings.php");
    include("config/mod_{$mod}_settings.php");
    // DEV NOTE: This should be handled by a proper object for each module
    $config_cols = array();
    if(isset($conf_dat_detfrm)){
        $config_cols[]=$conf_dat_detfrm;        
    }
    if(is_array($conf_dat_regist)){
        $config_cols[]=$conf_dat_regist;        
    };
    // identify micro_view (mcd) columns for this module
    $micro_view = $mod.'_conf_mcd_cols';
    $micro_view = $$micro_view;
    reset($micro_view);
    // loop over the package and strip out the columns (send to config_cols)
    foreach ($micro_view['columns'] as $key => $col) {
        $config_cols[] = $col;
    }
    // split out the SFs to a new array and ignore dups
    $sfs = array();
    // grab the map pop conf - as this is not in a column 
    $mod_mapconf = $mod.'_map_pop_conf';
    if (isset($$mod_mapconf)){
        $sfs[$mod_mapconf]= $$mod_mapconf;
    }
    // maybe we want to do the same with XMI
    foreach ($config_cols as $key => $col) {
        foreach ($col['subforms'] as $key => $sf) {
            if (!array_key_exists($sf['sf_html_id'], $sfs)) {
                $sfs[$sf['sf_html_id']] = $sf;
            }
            // FRAMES
            // beware of subforms hidden within sf_frame. In this case we will pass any conditions
            // down to the children and mark the subform as a non conflict. sf_frame NEVER contains
            // data.
            // note this only goes down one level. frames within frames will not be handled and
            // will cause errors
            if (array_key_exists('subforms', $sf) && is_array($sf['subforms'])) {
                foreach ($sf['subforms'] as $nested_key => $nested_sf) {
                    if (!array_key_exists($nested_sf['sf_html_id'], $sfs)) {
                        // if the sf_frame has conditions pass them to the child sf
                        if (array_key_exists('op_condition', $sf)) {                        
                            // if the child sf already has conditions then add both sets together
                            if (array_key_exists('op_condition', $nested_sf)) {
                                $new = array_merge($nested_sf['op_condition'], $sf['op_condition']);
                                $nested_sf['op_condition'] = $new;
                                unset ($new);
                            } else {
                                // just put the conditions direct into the nested SF
                                $nested_sf['op_condition'] = $sf['op_condition'];
                            }                        
                        }
                        // add the nested (child) sf to the main array
                        $sfs[$nested_sf['sf_html_id']] = $nested_sf;
                        // mark it as a child
                        $sfs[$nested_sf['sf_html_id']]['frame'] = 'C - '.$sf['sf_html_id'];
                    }
                }
                // mark this sf as a frame
                $sfs[$sf['sf_html_id']]['frame'] = 'F';
                // remove any now unwanted conditions (already passed to nested children)
                $sfs[$sf['sf_html_id']]['op_condition'] = FALSE;
            // events are a special case
            } else if (array_key_exists('events', $sf) && is_array($sf['events'])) {
                //loop over events adding fields
                foreach ($sf['events'] as $event){
                    if(array_key_exists('date', $event)){
                        if(!array_key_exists($event['date']['field_id'],$event)){
                            if($event['date']){
                                $event_fields[$event['date']['field_id']] = $event['date'];
                            }
                        }
                    }
                    if(array_key_exists('action', $event)){
                        if(!array_key_exists($event['action']['field_id'],$event)){
                            if($event['action']){
                                $event_fields[$event['action']['field_id']] = $event['action'];
                            }
                        }
                    }
                }
                $sfs[$sf['sf_html_id']]['fields'] = $event_fields;
                $sfs[$sf['sf_html_id']]['frame'] = FALSE;
            } else {
                // put in a marker to say that this is not frame related
                $sfs[$sf['sf_html_id']]['frame'] = FALSE;
            }
        }
    }
    return($sfs);
}

// }}}
// {{{ getFields()

 /**
  * gets an array containing all the fields assigned to an item
  *
  * @param string $sfs an array containing the sfs returned from getSfs()
  * @return array $fields  an array containing the fields
  * @author Stuart Eve
  * @since v1.1
  *
  * Note 1: This trawls through a getSfs() array an extracts the fields from it
  *
  * DEV NOTE: In the future this function may be rewritten to take account of any updated field storage method
  *           currently it is using the slightly hacky GetSfs() to retrieve the fields
  *
  */

  function getFields($sfs)
  {
      //setup an empty array to contain the fields
      $fields = array();
      //the sfs array is multi-dimensional so first navigate to the fields
      foreach ($sfs as $key => $value) {
          //lets check for modtypes
          if (array_key_exists('op_modtype',$value) && $value['op_modtype'] == TRUE) {
              //we are using modtypes here, so we need to loop through them
              foreach ($value as $modtype_key => $modtype_fields) {
                  if (substr($modtype_key, 0, 4) == "type") {
                      foreach ($value[$modtype_key] as $field) {
                          if (!array_key_exists($field['field_id'], $fields)) {
                              $fields[$field['field_id']] = $field;
                          }
                      }
                  }
              }
          } elseif(array_key_exists('fields',$value)) {
              //if we have found the fields array in the subforms - check if they already exist in output fields array
              //if not then pop them in
              foreach ($value['fields'] as $field) {
                  if(is_array($field)){
                      if (array_key_exists('field_id',$field)) {
                          if (!array_key_exists($field['field_id'], $fields)) {
                              $fields[$field['field_id']] = $field;
                          }
                      }
                  }
              }
          }
      }
      return($fields);
  }

// }}}
// {{{ getRegisterRows()

/**
* gets rows for a register in table mode
*
* @param string $mod_short  the three letter code for this mod
* @param string $itemkey  the three letter code for this mod
* @param string $ste_cd  the three letter code for this mod
* @param string $num_rows  the three letter code for this mod
* @return array $items  the items to be made into register rows
* @author Guy Hunt
* @since v1.1
*
* NOTE 1: The old register script used to make this call directly to the DB. This
* call has been moved out of the script and into this function as part of the drive
* to get all calls to the DB into a single location.
*
*/

function getRegisterRows($mod_short, $itemkey, $ste_cd, $num_rows)
{
    global $db;
    // setup
    $mod_table = $mod_short.'_tbl_'.$mod_short;
    
    // Part 1 - get the row that will be the start point for the table
    // based on an Admin specified number of rows, checks to see how many
    // rows exist.
    // SQL
    $sql = "
        SELECT COUNT($itemkey) as 'count'
        FROM $mod_table
        WHERE ste_cd = ?
    ";
    $params = array($ste_cd);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // fetch the resulting row
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    // DEV NOTE: if this is a fresh register... does $row return false??
    // set the startpoint
    $startpt = $row['count']-$num_rows;
    // in the event that there are less rows than the $num_rows set start to zero
    if ($startpt < 0) {
        $startpt = 0;
    }
    
    // Part 2 - retreive the data starting at the startpoint
    // SQL
    $sql = "
        SELECT $itemkey
        FROM $mod_table
        WHERE ste_cd = ?
        ORDER BY cre_on
        LIMIT ?, ?
    ";
    $params = array($ste_cd,$startpt, $num_rows);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle results
    $items = FALSE;
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $items[] = $row;
        } while($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    // return the items
    return $items;
}

// }}}
// {{{ logCmplxEvent()

/**
 * logs changes to the database with a greater level of complexity 
 *
 * @param string $event  the event code
 * @param string $ref  the reference (typically the table in wich a particular event has occured)
 * @param string $refid  id for that reference (typically the id of a particular row in a particular table)
 * @param string $vars  the vars
 * @param string $cre_by  the record creator user_id
 * @param string $cre_on  the creation date of this record
 * @access public
 * @author Guy Hunt
 * @since 0.1
 *
 */

function logCmplxEvent($event, $ref, $refid, $vars, $cre_by, $cre_on)
{
    global $db;
    $ref = serialize($ref);
    $refid = serialize($refid);
    $vars = serialize($vars);
    $cre_on = dbTimestamp($cre_on);
    // setup the SQL
    $sql = "
        INSERT
        INTO cor_tbl_log (event, ref, refid, vars, cre_by, cre_on)
        VALUES(?, ?, ?, ?, ?, ?)
    ";
    $params = array($event, $ref, $refid, $vars, $cre_by);
    if ($cre_on != "NOW()") {
        $params[] = $cre_on;
    }
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $new_id = $db->lastInsertId();
}

// }}}
// {{{ logEvent()

/**
 * logs changes to the database with a lower level of complexity 
 *
 * @param string $event  the event code
 * @param string $vars  the vars
 * @param string $cre_by  the record creator user_id
 * @param string $cre_on  the creation date of this record
 * @access public
 * @author Guy Hunt
 * @since 0.1
 *
 * Note 1: This doesn't refer to a modified item, so can't be used to handle
 * rollback information. See logCmplxEvent() for further info.
 *
 */

function logEvent($event, $vars, $cre_by, $cre_on)
{
    global $db;
    // setup the SQL
    $cre_on = dbTimestamp($cre_on);
    $sql = "
        INSERT
        INTO cor_tbl_log (event, vars, cre_by, cre_on)
        VALUES(?, ?, ?, ?)
    ";
    $params = array($event,$vars,$cre_by,$cre_on);
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
}

// }}}
// {{{ mkNavLang()

/**
* makes up a navigation list for languages
*
* @param string $qstr  the query string (ie everything after the ?)
* @return string $nav  a resolved xhtml list
* @author Guy Hunt
* @since 0.6
*
* NOTE: This has been available as a script (inc_itemkey_nav.php) since at least
* version 0.2.
*
*/

function mkNavLang($qstr=FALSE)
{
    global $db, $lang, $form_method,$purifier;
    $page = $_SERVER['PHP_SELF'];
    if (!$qstr) {
        if (!empty($_SERVER['QUERY_STRING'])) {
            $params = explode("&", $_SERVER['QUERY_STRING']);
            foreach ($params as $param) {
                $cleanparam = $purifier->purify($param);
                $var = explode("=", $cleanparam);
                if ($var[0] != 'lang') {
                    $newParams[] = $cleanparam;
                }
            }
            if (count($newParams) != 0) {
                $qstr = htmlentities(implode("&", $newParams));
            } else {
                $qstr = FALSE;
                $newParams = FALSE;
            }
        } else {
            $qstr = FALSE;
            $newParams = FALSE;
        }
    }
    $sql = dbPrepareQuery("SELECT * FROM cor_lut_language","mkNavLang()");
    $sql = dbExecuteQuery($sql,array(),"mkNavLang()");
        // Handle the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $langs[] = 
                array(
                    'lang' => $row['language'],
                    'alias' => getAlias('cor_lut_language', $row['language'], 'language', $row['language'], 1)
            );
        } while($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    // Output the list only if more than one language is present
    if (count($langs) > 1) {
        if (count($langs) > 3) {
            $mk_language = getMarkup('cor_tbl_markup', $lang, 'langselector');
            $nav = "<form method=\"$form_method\">\n";
            if ($newParams) {
                foreach ($newParams as $key => $param) {
                    $var = explode("=", $param);
                    $nav .= "<input type=\"hidden\" name=\"{$var[0]}\" value=\"{$var[1]}\">";
                }
            }
            $nav .= "<select name=\"lang\">";
            $nav .= "<option value=\"$lang\">";
            $nav .= "$mk_language";
            $nav .= "</option>\n";
            foreach ($langs as $value) {
                if ($value['lang'] != $lang) {
                    $nav .= "<option value=\"{$value['lang']}\">";
                    $nav .= "{$value['alias']}";
                    $nav .= "</option>\n";
                }
            }
            $nav .= "</select>";
            $nav .= "<button>&gt;&gt;</button>\n";
            $nav .= "</form>\n";
        } else {
            $nav = FALSE;
            foreach ($langs as $value) {
                $nav .= "<span>";            
                $nav .= "<a href=\"$page?$qstr&amp;lang={$value['lang']}\">";
                $nav .= "{$value['alias']}";
                $nav .= "</a>";
                $nav .= "</span>";
            }
        }
        // Return
        return $nav;
    } else {
        return FALSE;
    }
}

// }}}
// {{{
/**
 * adds a filename to cor_tbl_txt
 *
 * @return string $results
 * @author Brandon Tomlinson and Jessica Trelogan
 * @since 1.1?
 *
 */

function registerFileName($txttype, $itemkey, $itemvalue, $file, $lang, $cre_by, $cre_on)
{
    $mod_short = splitItemkey($itemkey);
    $table = $mod_short . '_tbl_' . $mod_short;
    $mod_cd = $mod_short . '_cd';
    $mod_no = $mod_short . '_no';
    $modtypename = $mod_short . 'type';
    $mod_no_val = splitItemval($itemvalue);
    $mod_cd_val = $itemvalue;
    $ste_cd = splitItemval($itemvalue, TRUE);
    if ($mod_no_val == 'next') {
        $mod_no_val = getSingle("MAX($mod_no)", $tbl, '1');
        $mod_cd_val = $ste_cd . '_' . $mod_no_val;
    }
    $cre_on = dbTimestamp($cre_on);

    $tables = 'cor_tbl_txt';
    $fields = array('txttype', 'itemkey', 'itemvalue', 'txt', 'language', 'cre_by', 'cre_on');
    $values = array($txttype, $itemkey, $mod_cd_val, $file, $lang, $cre_by, $cre_on);
    $logtype = 'fileadd';

    // run the query
    return dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}
// }}}

?>
