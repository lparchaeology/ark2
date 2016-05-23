<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* validation_functions.php
*
* holds validation functions for validating data entry and data viewing
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
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/validation_functions.php
* @since      File available since Release 0.6
*
* Note, functions are divided into two sections as follows:
* 1 - Request functions. These functions which are module independent are
*  used to request a var from the session, the querystring or from 'live' vars.
*  They return either a value or FALSE. Use caution with the value ZERO
*
* 2 - Validation functions. These expect to be passed the var to validate and an
*  array containing any further required variables for the validation process.
*  These return either the var or an array containing error information.
*
*/


// {{{ reqMulti()

/**
* cleanly requests a var returning FALSE 
*
* @param array $var  containing settings about this validation element
* @param array $field_settings  containing all the settings for this field
* @return string $var  the requested var
* @author Guy Hunt
* @since 0.5
*
* Returns the var if it is present otherwise returns false
* Essentially a wrapper function for reqQst the non std function
*
*/

function reqMulti($vars, $field_settings=FALSE)
{
    $lv_name = $vars['lv_name'];
    if ($lv_name == 'dyn_field') {
        $lv_name = $field_settings['classtype'];
    }
    if ($lv_name == 'dyn_field_suffix') {
        $lv_name = $field_settings['classtype'] . '_' . $vars['var_name'];
    }
    $var_locn = $vars['var_locn'];
    if ($var_locn == 'session') {
        $var = reqQst($_SESSION, $lv_name);
    }
    if ($var_locn == 'request') {
        $var = reqQst($_REQUEST, $lv_name);
    }
    if ($var_locn == 'live') {
        global $$lv_name;
        $var = $$lv_name;
    }
    if ($var === FALSE) {
        return FALSE;
    } else {
        return ($var);
    }
}

// }}}
// {{{ reqItemList()

/**
* this is for requesting an itemlist
*
* @param array $var  containing settings about this validation element
* @param array $field_settings  containing all the settings for this field
* @return string $var  the requested var
* @author Stuart Eve
* @since 0.6
*
* Returns the var if it is present otherwise returns false
* Essentially a wrapper function for reqMulti
*
*/

function reqItemList($vars, $field_settings)
{
    //build the request var
    $vars['lv_name'] = $vars['lv_name'] . '_' . $field_settings['xmi_mod'];
    $var = reqMulti($vars, $field_settings);
    return $var;
}

// }}}
// {{{ reqClassType()

/**
* requests a classtype number based on the field settings
*
* @param array $var  containing settings about this validation element
* @param array $field_settings  containing all the settings for this field
* @return string $var  the classtype number or FALSE
* @author Guy Hunt
* @since 0.5
*/

function reqClassType($vars, $field_settings)
{
    // basics
    $lv_name = $vars['lv_name'];
    // get the basic request
    $rawvar = reqQst($field_settings, $lv_name);
    // explode on '-' the seperator for multi classtypes to check for multiple updates
    // if the seperator is not present then it won't fall over
    $rawvar = explode('-', $rawvar);
    $rawvar = $rawvar[0];
    // check this isnt already a number (unlikely as this is human configged)
    if (is_numeric($rawvar)) {
        $var = $rawvar;
    } else {
        $var = getClassType($field_settings['dataclass'], $rawvar);
    }
    if (!$var) {
        return FALSE;
    } else {
        return ($var);
    }
} 

// }}}
// {{{ reqField()

/**
* set a var from the vars in the field settings array
*
* @param array $var  containing settings about this validation element
* @param array $field_settings  containing all the settings for this field
* @return string $var  the var or FALSE
* @author Guy Hunt
* @since 0.5
*
*/

function reqField($vars, $field_settings)
{
    $force_var = $field_settings[$vars['force_var']];
    $var = $force_var;
    if (!$var) {
        return FALSE;
    } else {
        return ($var);
    }
}

// }}}
// {{{ reqManual()

/**
* sets a var to a manual setting from the field array
*
* @param array $var  containing settings about this validation element
* @param array $field_settings  containing all the settings for this field
* @return string $var  the var or FALSE
* @author Guy Hunt
* @since 0.5
*
*/

function reqManual($vars, $field_settings=FALSE)
{
    $force_var = $vars['force_var'];
    $var = $force_var;
    if (!$var) {
        return FALSE;
    } else {
        return ($var);
    }
}

// }}}
// {{{ reqItemVal()

/**
* requests a particular form of an itemvalue
*
* @param array $var  containing settings about this validation element
* @param array $field_settings  containing all the settings for this field
* @return string $var  the var or FALSE
* @author Guy Hunt
* @since 0.5
*
* Note: essentially a wrapper for the reqMulti() function to better handle itemkeys
* Note2: As of v1.1 this has been modified to perform a rigorous check (!== FALSE) 
* on the $item_no in the 'auto' routine. This evaluates an $item_no of 0 (zero) as TRUE.
* GH + JO 3/7/13
*
*/

function reqItemVal($vars, $field_settings=FALSE)
{
    $req_keytype = $vars['req_keytype'];
    $ret_keytype = $vars['ret_keytype'];
    $var_name = $vars['var_name'];
    $locn = $vars['var_locn'];
    // REQUEST RAW
    if ($raw_var = reqMulti($vars)) {
        // PROCESS RAW
        if ($req_keytype == 'cd') {
            $item_no = splitItemval($raw_var);
            $ste_cd = splitItemval($raw_var, TRUE);
        }
        if ($req_keytype == 'no') {
            $item_no = $raw_var;
            $ste_cd = reqQst($_SESSION, 'ste_cd');
        }
        if ($req_keytype == 'auto') {
            // try to work out if the raw_var has a cd already
            $item_no = splitItemval($raw_var);
            if ($item_no !== FALSE) {
                // the item split therefore it is a full code
                // set up ste_cd and item_no
                $ste_cd = splitItemval($raw_var, TRUE);
            } else {
                // the item didn't split therefore it is just a number
                // set up ste_cd and item_no
                $item_no = $raw_var;
                $ste_cd = reqQst($_SESSION, 'ste_cd');
            }
        }
        // OUTPUT
        if ($ret_keytype == 'cd') {
            if ($ste_cd && $item_no !== FALSE) {
                // needs sticking together
                $var = $ste_cd.'_'.$item_no;
            }
        } elseif ($ret_keytype == 'no' AND $item_no) {
            $var = $item_no;
        } else {
            $var = FALSE;
        }
    } else {
        $var = FALSE;
    }
    // Return
    if (!$var) {
        return FALSE;
    } else {
        return ($var);
    }
}

// }}}
// {{{ reqDate()

/**
* requests dates from the an array (typically the qstr)
*
* @param array $vars  the settings for this element of a field
* @param array $field_settings  the settings of the field itself
* @return string $date  the date in the normal datetime format
* @author Guy Hunt
* @since 0.5
*
* The date can be split and formatted using other date handlers
*
*/

function reqDate($vars, $field_settings)
{
    //some setup
    $location = $vars['var_locn'];
    $prefix = $field_settings['classtype'];
    //make the requests (prefixing if needed)
    if ($prefix) {
    $f_yr = reqQst($_REQUEST, $prefix.'_yr');
    $f_mm = reqQst($_REQUEST, $prefix.'_mm');
    $f_dd = reqQst($_REQUEST, $prefix.'_dd');
    $f_hr = reqQst($_REQUEST, $prefix.'_hr');
    $f_mi = reqQst($_REQUEST, $prefix.'_mi');
    $f_ss = reqQst($_REQUEST, $prefix.'_ss');
    } else {
    $f_yr = reqQst($_REQUEST, 'yr');
    $f_mm = reqQst($_REQUEST, 'mm');
    $f_dd = reqQst($_REQUEST, 'dd');
    $f_hr = reqQst($_REQUEST, 'hr');
    $f_mi = reqQst($_REQUEST, 'mi');
    $f_ss = reqQst($_REQUEST, 'ss');
    }
    //handle the date elements putting in zeros as needed
    if (!$f_yr OR $f_yr == 'yr' OR $f_yr == '0000' OR !is_numeric($f_yr)) {
    $f_yr = '0000';
    }
    if (!$f_mm OR $f_mm == 'mm' OR $f_mm == '00' OR !is_numeric($f_mm)) {
    $f_mm = '00';
    }
    if (!$f_dd OR $f_dd == 'dd' OR $f_dd == '00' OR !is_numeric($f_dd)) {
    $f_dd = '00';
    }
    if (!$f_hr OR $f_hr == 'hr' OR $f_yr == '00' OR !is_numeric($f_hr)) {
    $f_hr = '00';
    }
    if (!$f_mi OR $f_mi == 'mi' OR $f_mi == '00' OR !is_numeric($f_mi)) {
    $f_mi = '00';
    }
    if (!$f_ss OR $f_ss == 'ss' OR $f_ss == '00' OR !is_numeric($f_ss)) {
    $f_ss = '00';
    }
    //build the date from the elements
    $date = $f_yr.'-'.$f_mm.'-'.$f_dd.' '.$f_hr.':'.$f_mi.':'.$f_ss;
    if ($date) {
        return($date);
    } else {
        return(FALSE);
    }
}

// }}}
// {{{ reqDateRange()

/**
* requests the parts of a date range and applies an AD/BC modifier
*
* @param array $vars  the settings for this element of a field
* @param array $field_settings  the settings of the field itself
* @return string $var  the year modified if needed
* @author Guy Hunt
* @since 0.6
*
* at present (0.6) this function isnt handling real dates, just years
* it would probably be possible to improve this but it would mean editing
* the frmElem function responsible for submitting spans
*
*/

function reqDateRange($vars, $field_settings)
{
    // some setup
    $location = $vars['var_locn'];
    $prefix = $field_settings['classtype'];
    $prefix2 = $vars['lv_name'];
    // make the requests
    $var = reqQst($_REQUEST, $prefix.'_'.$prefix2);
    // handle the AD/BC modifier option
    if (array_key_exists('field_op_modifier', $field_settings)) {
        $field_op_modifier = $field_settings['field_op_modifier'];
    } else {
        $field_op_modifier = FALSE;
    }
    if ($field_op_modifier) {
        $modifier = reqQst($_REQUEST, $prefix.'_'.$prefix2.'_modifier');
    } else {
        $modifier = FALSE;
    }
    if ($modifier == 'ad') {
        $var = 2000-$var;
        return $var;
    } elseif ($modifier == 'bc') {
        $var = 2000+$var;
        return $var;
    } else {
        return $var;
    }
}

// }}}
// {{{ reqFragId()

/**
* requests a fragment id which is needed in edit and delete routines
*
* @param array $vars  contains variables specific to this var
* @param array $field_settings  contains settings specific to the entire field
* @return int $id  the id of the fragment
* @author Guy Hunt
* @since 0.6
*
*/

function reqFragId($vars, $field_settings)
{
    $lv_name = $field_settings['classtype'].'_'.$vars['lv_name'];
    $var_locn = $vars['var_locn'];
    if ($var_locn == 'session') {
        $var = reqQst($_SESSION, $lv_name);
    }
    if ($var_locn == 'request') {
        $var = reqQst($_REQUEST, $lv_name);
    }
    if ($var_locn == 'live') {
        global $$lv_name;
        $var = $$lv_name;
    }
    if (!$var) {
        return FALSE;
    } else {
        return ($var);
    }
}

// }}}
// {{{ reqAuto()

/**
* requests value, trying the session first, then the request string
*
* @param array $vars  contains variables specific to this var
* @param array $field_settings  contains settings specific to the entire field
* @return int $id  the id of the fragment
* @author Mike Johnson
* @since 1.2
*
*/

function reqAuto($vars, $field_settings=FALSE)
{
    $lv_name = $vars['lv_name'];
    if ($lv_name == 'dyn_field') {
        $lv_name = $field_settings['classtype'];
    }
    if ($lv_name == 'dyn_field_suffix') {
        $lv_name = $field_settings['classtype'] . '_' . $vars['var_name'];
    }
    $var = reqQst($_SESSION, $lv_name);
    if(!isset($var)){
        $var = reqQst($_REQUEST, $lv_name);
    }
    if ($var === FALSE) {
        return FALSE;
    } else {
        return ($var);
    }
}

// }}
// {{{ chkSet()

/**
* checks to if a value is 'set' ie not null or false or empty
*
* This code was updated to prevent submission of blank values for v0.8
* To allow blanks or empties use chkSkipBlank() function isntead
* To allow boolean values (null) use chkSetBool() function instead 
*
* @param string $var  the var to check
* @param array $val_vars  the validation vars
* @param arrat $var  the field vars
* @return string $var  the var itself if its ok or errors if not
* @author Guy Hunt
* @since 0.5
*
*/

function chkSet($var, $val_vars, $field_vars)
{
    $var_name = $val_vars['var_name'];
    if (!isset($var) or $var === FALSE) {
        $var =
            array(
                'field' => $var_name,
                'vars' => "The $var_name {$field_vars['classtype']} was not set or was empty",
                'err' => 'on'
        );
    }
    return ($var);
}

// }}}
// {{{chkSetBool()

/**
* checks to if a boolean value is 'set' ie not false or empty
* 
* Non-boolean variables should use chkSet() func instead
*
* @param string $var  the var to check
* @param array $val_vars  the validation vars
* @param arrat $var  the field vars
* @return string $var  the var itself if its ok or errors if not
* @author Andy Dufton
* @since 0.8
*
*/

function chkSetBool($var, $val_vars, $field_vars)
{
    $var_name = $val_vars['var_name'];
    if (!isset($var) or $var === FALSE) {
        $var =
            array(
                'field' => $var_name,
                'vars' => "The $var_name {$field_vars['classtype']} was not set or was empty",
                'err' => 'on'
        );
    }
    return ($var);
}

// }}}
// {{{ chkNumeric()

/**
* checks to see if a var is numeric
*
* @param array $var  containing settings about this validation element
* @param array $field_settings  containing all the settings for this field
* @return string $var  the var or FALSE
* @author Guy Hunt
* @since 0.5
*
*/

function chkNumeric($var, $val_vars, $field_vars)
{
    $var_name = $val_vars['var_name'];
    // check for numerics but allow the magic word next
    if (!is_numeric($var) AND $var != 'next') {
        $var =
            array(
                'field' => $var_name,
                'vars' => "The value $var is not numeric", 'err' => 'on'
        );
    }
    return ($var);
}

// }}}
// {{{ chkDuplicate()

/**
* checks for the presence of an itemvalue in the db
*
* @param array $var  containing settings about this validation element
* @param array $field_settings  containing all the settings for this field
* @return string $var  the var or FALSE
* @author Guy Hunt
* @since 0.5
*
*/

function chkDuplicate($var, $val_vars, $field_vars)
{
    $item_cd = $var;
    $mod = $field_vars['module'];
    $tbl = $mod.'_tbl_'.$mod;
    $clm = $mod.'_cd';
    $var_name = $val_vars['var_name'];
    // Set up the SQL
    $sql = "
        SELECT $clm
        FROM $tbl
        WHERE $clm = ?
    ";
    $params = array($item_cd);
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the result
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $var =
            array(
                'field' => $var_name,
                'vars' => "The value $var_name = $var was duplicate", 'err' => 'on'
        );
    }
    // Return
    return ($var);
}

// }}}
// {{{ chkDate()

/**
* checks a string to see if it complies with certain date criteria 
*
* @param string $var  containing the string to check
* @param array $val_vars  containing the validation criteria
* @param array $field_vars  containing the field criteria
* @return string $date  a valid date (or FALSE)
* @author Guy Hunt
* @since 0.5
*
*/

function chkDate($var, $val_vars, $field_vars)
{
    $var_name = $val_vars['var_name'];
    $format = $field_vars['datestyle'];
    
    // HACKED - NEEDS ABSTRACTING
    if ($format == 'dd,mm,yr') {
        $dd = splitDate($var, 'dd');
        $mm = splitDate($var, 'mm');
        $yr = splitDate($var, 'yr');
        if (!checkdate($mm, $dd, $yr)) {
            $var = array('field' => $var_name, 'vars' => "The $var_name = $var is not valid", 'err' => 'on');
        }
    }
    if ($format == 'mm,dd,yr') {
        $dd = splitDate($var, 'dd');
        $mm = splitDate($var, 'mm');
        $yr = splitDate($var, 'yr');
        if (!checkdate($mm, $dd, $yr)) {
            $var = array('field' => $var_name, 'vars' => "The $var_name = $var is not valid", 'err' => 'on');
        }
    }
    // Return
    return ($var);
}

// }}}
// {{{ chkDateSet()

/**
* checks a date string to see if is set
*
* @param string $var  containing the string to check
* @param array $val_vars  containing the validation criteria
* @param array $field_vars  containing the field criteria
* @return string $date  a valid date (or FALSE)
* @author Guy Hunt
* @since 0.6
*/

function chkDateSet($var, $val_vars, $field_vars)
{

    $var_name = $val_vars['var_name'];
    if ($var == '0000-00-00 00:00:00') {
            $var = array('field' => $var_name, 'vars' => "The $var_name = $var is not set", 'err' => 'on');
    }
    // Return var
    return ($var);
}

// }}}
// {{{ chkChDown()

/**
* checks for a downward chain attached to a fragment
*
* @param string $var  containing the string to check
* @param array $val_vars  containing the validation criteria
* @param array $field_vars  containing the field criteria
* @return string $var  a list of chained frags (or FALSE)
* @author Guy Hunt
* @since 0.6
*
*/

function chkChDown($var, $val_vars, $field_vars)
{
    $chain = FALSE;
    $frag_key = 'cor_tbl_'.$field_vars['dataclass'];
    if ($ch = getCh('txt', $frag_key, $var)) {
        $chain[] = $ch;
    }
    if ($ch = getCh('number', $frag_key, $var)) {
        $chain[] = $ch;
    }
    if ($ch = getCh('attribute', $frag_key, $var)) {
        $chain[] = $ch;
    }
    if ($ch = getCh('span', $frag_key, $var)) {
        $chain[] = $ch;
    }
    if ($ch = getCh('date', $frag_key, $var)) {
        $chain[] = $ch;
    }
    if ($ch = getCh('action', $frag_key, $var)) {
        $chain[] = $ch;
    }
    $var_name = $val_vars['var_name'];
    if ($chain) {
        $var = array(
            'field' => $var_name,
            'vars' => "The {$field_vars['dataclass']} $var_name: $var has fragments linked to it",
            'chain' => $chain,
            'delete_dclass' => $field_vars['dataclass'],
            'delete_id' => $var,
            'err' => 'on'
        );
    }
    // Return var
    return ($var);
}

// }}}
// {{{ chkFalse()

/**
* checks a var to see if it is FALSE
*
* @param string $var  containing the string to check
* @param array $val_vars  containing the validation criteria
* @param array $field_vars  containing the field criteria
* @return string $var  a valid date (or FALSE)
* @author Guy Hunt
* @since 0.6
*
*/

function chkFalse($var, $val_vars, $field_vars)
{
    $var_name = $val_vars['var_name'];
    if ($var === FALSE) {
        return ($var);
    } else {
        $var = array('field' => $var_name, 'vars' => "The $var_name = $var is not FALSE", 'err' => 'on');
        return ($var);
    }
}

// }}}
// {{{ chkDupDouble()

/**
* checks for the presence of a pair of values
*
* @param string $val1  the first value to check
* @param string $col1  the column in which the first value is located
* @param string $val2  the second value to check
* @param string $col2  the column in which the second value is located
* @param string $tbl  the table in which the items reside
* @return string $var  the var or FALSE
* @author Guy Hunt
* @since 0.4
*
* FIX ME: This is a NON standard chk function call
*
*/

function chkDupDouble($col1, $val1, $col2, $val2, $tbl)
{
    // Set up SQL
    $sql = "
        SELECT id
        FROM $tbl
        WHERE $col1 = ?
        AND $col2 = ?
    ";
    $params = array($val1,$val2);
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the result
    if ($sql->rowCount() > 0) {
        return(TRUE);
    } else {
        return(FALSE);
    }
}

// }}}
// {{{ chkDupSimple()

/**
* checks for the presence of an existing value of any type
*
* @param string $item  item to check for
* @param string $tbl  the table
* @param string $col  the column
* @return TRUE FALSE
* @author Guy Hunt
* @since 0.4
*
* FIX ME: This is a NON standard chk function call
*
*/

function chkDupSimple($item, $tbl, $col)
{
    // Set up the SQL
    $sql = "
        SELECT $col
        FROM $tbl
        WHERE $col = ?
    ";
    $params = array($item);
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    if ($sql->rowCount() > 0) {
        return(TRUE);
    } else {
        return(FALSE);
    }
}

// }}}
// {{{ chkDupStr()

/**
* checks for the presence of duplicate strings
*
* @param string $dup  the string to check
* @param string $col  the column in which the suspected duplicates reside
* @param string $tbl  the table in which the suspected duplicates reside
* @param string $sql  an optional sql 'WHERE' statement
* @param string $element  an optional element
* @param string $params  this is the type of string matching to run on the value
* @return array $dup_array  possible duplicate strings in the format id => alias
* @author Guy Hunt
* @since 0.3
*
* FIX ME: This is a NON standard chk function call
* FIX ME: This function is surely OBSOLTETE?
*
* NOTE 1: LANGUAGES the alias returned will be the $col specified to this
* function. IF you want to display more than one language take the id and use 
* the get alias function in a foreach loop after running this function.
*
* NOTE 2: This function has been written with the aim of reducing duplicate addtions
* to luts. It may be possible to hack it to serve other purposes.
* 
* NOTE 3: The params option should contain an array of the types of check
* to be carried out
*
*/

function chkDupStr($dup, $col, $tbl, $sql, $element, $params)
{
    if (!$element) {
        $element = $col;
    }
    // Set up the SQL
    $sql = "
        SELECT id, $col
        FROM $tbl
        $sql
    ";
    $sql_params = array();
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$sql_params,__FUNCTION__);

    // Handle results
    if ($frow =$sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            // Perform the checks
            //Check Type 1 - case sensitive preg match
            if (in_array(1, $params)) {
                if (preg_match("/$dup/", $frow[$col])) {
                    $dup_array[] = $frow["$element"];
                }
            }
            //Check Type 2 - case INsensitive preg match
            if (in_array(2, $params)){
                if (preg_match("/$dup/i", $frow[$col])) {
                    $dup_array[] = $frow["$element"];
                }
            }
            //Check Type 3 - case INsensitive preg match Reversed
            if (in_array(3, $params)) {
                $existing = $frow["$col"];
                if (preg_match("/$existing/i", $dup)){
                    $dup_array[] = $frow["$element"];
                }
            }
        } while ($frow = $sql->fetch(PDO::FETCH_ASSOC));
        // Compact the array to unique and return
        if ($dup_array) {
            return(array_unique($dup_array));
        } else {
            return(FALSE);
        }
    } else {
        return(FALSE);
    }
}

// }}}// {{{ chkSgrList()

/**
 * a thing for checking many to one relationships - needs generalising
 *
 * @param string $var  containing the list to check
 * @param array $val_vars  containing the validation criteria
 * @param array $field_vars  containing the field criteria
 * @return string $ret_list  a reordered list containing only valid itemvalues
 * @author Stuart Eve
 * @since 0.6
 *
 */

function chkSgrList($var, $val_vars, $field_vars)
{
    global $ste_cd, $sf_val;
    $errs = FALSE;
    $var_name = $val_vars['var_name'];
    $xmi_mod = $field_vars['xmi_mod'];
    // first explode the item list
    $exp_list = explode (' ', trim($var));
    if(count($exp_list) == 1 && empty($exp_list[0])){
        $errs[] =
        array(
                        'field' => $var_name,
                        'vars' => "$var_name was blank",
                        'err' => 'skip'
        );
    } else
    if (count($exp_list) > 1) {
        $errs[] =
        array(
                        'field' => $var_name,
                        'vars' => "Subgroups can only have one context",
                        'err' => 'on'
        );
    } else 
    // foreach through the list checking if each item is valid.
    // If it is then add it to the return list, otherwise add it a string
    // to be sent to the messages array
    if (count($exp_list) == 1) {
        $ret_list = FALSE;
        $value = $exp_list[0];
        if (is_numeric($value)) {
            $valid =
            chkValid(
                    FALSE,
                    $ste_cd,
                    $value,
                    $xmi_mod . '_tbl_' . $xmi_mod,
                    $xmi_mod . '_cd'
            );
        } else {
            $valid =
            chkValid(
                    $value,
                    FALSE,
                    FALSE,
                    $xmi_mod . '_tbl_' . $xmi_mod,
                    $xmi_mod . '_cd'
            );
        }
        if (!$value) {
            // The value is blank - send a skip error
            $valid = FALSE;
            $var =
            array(
                'field' => $val_vars['var_name'],
                'vars' => "The {$val_vars['var_name']} was set to skip",
                'err' => 'skip'
                        );
            return ($var);
        }
        $otherXmis = getXmi('cxt_cd',$sf_val,'sgr');

        if (is_array($otherXmis)) {
            $valid = FALSE;
            $errs[] =
            array(
                            'field' => $var_name,
                            'vars' => "context can only have one Subgroup, <a href=\"\">refresh<a> to see subgroups already added",
                            'err' => 'on'
            );
        }
        if ($valid == FALSE) {
            $ret_list .= $value.' ';
        } else {
            $errs[] =
            array(
                            'field' => $var_name,
                            'vars' => "The item '$value' is not a valid $xmi_mod. ",
                            'err' => 'on'
            );
        }
    } else {
        $errs[] =
        array(
                        'field' => $var_name,
                        'vars' => "The list doesn't not appear to be a space separated list",
                        'err' => 'on'
        );
    }
    if ($errs) {
        $ret_errs =
        array(
                        'field' => $var_name,
                        'vars' => FALSE,
                        'err' => 'on'
        );
        foreach ($errs as $err) {
            $ret_errs['vars'] .= $err['vars'];
        }
        return $ret_errs;
    } else {
        $ret_list = rtrim($ret_list);
        return $ret_list;
    }
}

// }}}
// {{{ chkCxtSgrList()

/**
 * a thing for checking many to one relationships - needs generalising
 *
 * @param string $var  containing the list to check
 * @param array $val_vars  containing the validation criteria
 * @param array $field_vars  containing the field criteria
 * @return string $ret_list  a reordered list containing only valid itemvalues
 * @author Stuart Eve
 * @since 0.6
 *
 */

function chkCxtSgrList($var, $val_vars, $field_vars)
{
    global $ste_cd, $sf_val;
    $errs = FALSE;
    $var_name = $val_vars['var_name'];
    $xmi_mod = $field_vars['xmi_mod'];
    // first explode the item list
    $exp_list = explode (' ', trim($var));
    if(count($exp_list) == 1 && empty($exp_list[0])){
        $errs[] =
        array(
                        'field' => $var_name,
                        'vars' => "$var_name was blank",
                        'err' => 'skip'
        );
    } else
    if (count($exp_list) > 1) {
        $errs[] =
        array(
                        'field' => $var_name,
                        'vars' => "Subgroups can only have one context",
                        'err' => 'on'
        );
    } else 
    // foreach through the list checking if each item is valid.
    // If it is then add it to the return list, otherwise add it a string
    // to be sent to the messages array
    if (count($exp_list) == 1) {
        $ret_list = FALSE;
        $value = $exp_list[0];
        if (is_numeric($value)) {
            $valid =
            chkValid(
                    FALSE,
                    $ste_cd,
                    $value,
                    $xmi_mod . '_tbl_' . $xmi_mod,
                    $xmi_mod . '_cd'
            );
        } else {
            $valid =
            chkValid(
                    $value,
                    FALSE,
                    FALSE,
                    $xmi_mod . '_tbl_' . $xmi_mod,
                    $xmi_mod . '_cd'
            );
        }
        if (!$value) {
            // The value is blank - send a skip error
            $valid = FALSE;
            $var =
            array(
                'field' => $val_vars['var_name'],
                'vars' => "The {$val_vars['var_name']} was set to skip",
                'err' => 'skip'
                        );
            return ($var);
        }
        $otherXmis = getXmi('cxt_cd',$value,'sgr');
        if (is_array($otherXmis)) {
            $valid = FALSE;
            $errs[] =
            array(
                            'field' => $var_name,
                            'vars' => "Context already in Subgroup <a href=\"sgr_cd/{$otherXmis[0]['xmi_itemvalue']}\">{$otherXmis[0]['xmi_itemvalue']}</a>",
                            'err' => 'on'
            );
        }
        if ($valid == FALSE) {
            $ret_list .= $value.' ';
        } else {
            $errs[] =
            array(
                            'field' => $var_name,
                            'vars' => "The item '$value' is not a valid $xmi_mod. ",
                            'err' => 'on'
            );
        }
    } else {
        $errs[] =
        array(
                        'field' => $var_name,
                        'vars' => "The list doesn't not appear to be a space separated list",
                        'err' => 'on'
        );
    }
    if ($errs) {
        $ret_errs =
        array(
                        'field' => $var_name,
                        'vars' => FALSE,
                        'err' => 'on'
        );
        foreach ($errs as $err) {
            $ret_errs['vars'] .= $err['vars'];
        }
        return $ret_errs;
    } else {
        $ret_list = rtrim($ret_list);
        return $ret_list;
    }
}

// }}}
// {{{ chkValid()

/**
* checks for the presence and uniqueness of an item_value in the db
*
* @param string $item_val  the full item value 'ste_item'
* @param string $ste_cd  just the site code (IF ITEM_CD IS NOT SET)
* @param string $item_id  just the second part of an item value (IF ITEM_CD IS NOT SET)
* @param string $tbl  the table in which we want to check
* @param string $clm  the column in which the item resides
* @return TRUE FALSE
* @author Guy Hunt
* @since 0.4
*
* NOTE 1: If you want to check an item_val you must set it. 
* If you want to check ste_cd/no DON'T set item_val
* This is an either or option
*
* NOTE 2: It is possible to hack this function to check for just about anything
* do it by spoofing the $item_cd, $tbl and $clm values (see also note 1)
*
*/

function chkValid($item_val, $ste_cd, $item_id, $tbl, $clm)
{
    // if there is no item_cd, set it from the ste_cd and item_id
    if (!$item_val) {
        $item_val = $ste_cd.'_'.$item_id;
    }
    // setup the SQL
    $sql = "
        SELECT $clm
        FROM $tbl
        WHERE $clm = ?
    ";
    $params = array($item_val);
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    
    // handle the result
    if ($sql->rowCount() == 1) {
        // in this case this item exists and is unique on this db
        return(FALSE);
    } else {
        return(TRUE);
    }
}

// }}}
// {{{ chkAbk()

/**
* checks to see if a submitted value is valid in the abk
*
* @param string $var  containing the string to check
* @param array $val_vars  containing the validation criteria
* @param array $field_vars  containing the field criteria
* @return string $var  a valid date (or FALSE)
* @author Guy Hunt
* @since 0.6
*
*/

function chkAbk($var, $val_vars, $field_vars)
{
    // allow a skip routine
    if ($var == 'skip') {
        $var =
            array(
                'field' => $val_vars['var_name'],
                'vars' => "The {$val_vars['var_name']} was set to skip",
                'err' => 'skip'
        );
        return ($var);
    }
    $sql = "
    SELECT abk_cd
    FROM abk_tbl_abk
    WHERE abk_cd = ?
    ";
    $params = array($var);
    //Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    if ($sql->rowCount() == 1) {
        return ($var);
    } else {
        $var =
             array(
                 'field' => $val_vars['var_name'],
                 'vars' => "The value {$val_vars['var_name']} = $var is not valid",
                 'err' => 'on'
        );
        return ($var);
    }
}

// }}}
// {{{ chkSkipBlank()

/**
* checks to see if a submitted value is blank and skip this field if it is
*
* @param string $var  containing the string to check
* @param array $val_vars  containing the validation criteria
* @param array $field_vars  containing the field criteria
* @return string $var  a valid date (or FALSE)
* @author Guy Hunt
* @since 0.6
*
*/

function chkSkipBlank($var, $val_vars, $field_vars)
{
    $var_name = $val_vars['var_name'];
    // check
    if (!isset($var) or !$var) {
        $var = 
            array(
                'field' => $var_name,
                'vars' => "The $var_name {$field_vars['classtype']} was not set",
                'err' => 'skip'
        );
    }
    return ($var);
}

// }}}
// {{{ chkSkipBlankAndDup()

/**
 * checks to see if a submitted value is blank or duplicate and skip this field if it is
 *
 * @param string $var  containing the string to check
 * @param array $val_vars  containing the validation criteria
 * @param array $field_vars  containing the field criteria
 * @return string $var  a valid date (or FALSE)
 * @author Guy Hunt
 * @author Mike Johnson
 * @since 1.2
 *
 */

function chkSkipBlankAndDup($var, $val_vars, $field_vars)
{
    global $sf_key, $sf_val;

    $var_name = $val_vars['var_name'];
    
    if(isset($sf_val)){
        $existing_txts = getChData('txt', $sf_key, $sf_val, $field_vars['classtype']);
        if(is_array($existing_txts)){
            foreach($existing_txts as $existing){
                if($existing['txt'] === $var){
                    $var =
                        array(
                            'field' => $var_name,
                            'vars' => "This text frag has already been added id ={$existing['id']}",
                            'err' => 'skip'
                        );
                }
            }
        }
    }
    // check
    if (!isset($var) or !$var) {
        $var =
        array(
                        'field' => $var_name,
                        'vars' => "The $var_name {$field_vars['classtype']} was not set",
                        'err' => 'skip'
                                );
    }
    return ($var);
}
// {{{ chkItemList()

/**
* takes an list of items (usually from an XMI), explodes the list and checks if all of the itemvalues are valid
*
* @param string $var  containing the list to check
* @param array $val_vars  containing the validation criteria
* @param array $field_vars  containing the field criteria
* @return string $ret_list  a reordered list containing only the valid itemvalues
* @author Stuart Eve
* @since 0.6
*
*/

function chkItemList($var, $val_vars, $field_vars)
{
    global $ste_cd;
    $errs = FALSE;
    $var_name = $val_vars['var_name'];
    $xmi_mod = $field_vars['xmi_mod'];
    //first explode the item list
    $exp_list = explode (' ', trim($var));
    // foreach through the list checking if each item is valid. 
    // If it is then add it to the return list, otherwise add it a string
    // to be sent to the messages array
    if (count($exp_list >= 1)) {
        $ret_list = FALSE;
        foreach($exp_list as $value) {
            // test to see if this is is a key
            $elems = explode('_', $value);
            if (count($elems) == 2) {
                $has_ste_cd = TRUE;
            } else {
                $has_ste_cd = FALSE;
            }
            if (!$has_ste_cd) {
                $valid =
                    chkValid(
                        FALSE,
                        $ste_cd,
                        $value,
                        $xmi_mod . '_tbl_' . $xmi_mod,
                        $xmi_mod . '_cd'
                ); 
            } else {
                $valid =
                    chkValid(
                        $value,
                        FALSE,
                        FALSE,
                        $xmi_mod . '_tbl_' . $xmi_mod,
                        $xmi_mod . '_cd'
                ); 
            }
            if ($valid == FALSE) {
                $ret_list .= $value.' ';
            } else {
                $errs[] = 
                    array(
                        'field' => $var_name,
                        'vars' => "The item '$value' is not a valid $xmi_mod. ",
                        'err' => 'on'
                );
            }
        }
    } else {
        $errs[] = 
            array(
                'field' => $var_name,
                'vars' => "The list doesn't not appear to be a space separated list",
                'err' => 'on'
        );
    }
    if ($errs) {
        $ret_errs =
            array(
                'field' => $var_name,
                'vars' => FALSE,
                'err' => 'on'
        );
        foreach ($errs as $err) {
            $ret_errs['vars'] .= $err['vars'];
        }
        return $ret_errs;
    } else {
        $ret_list = rtrim($ret_list);
        return $ret_list;
    }
}

// }}}
// {{{ chkItemListAllowBlank()

/**
* takes an list of items (usually from an XMI), explodes the list and checks
* if all of the itemvalues are valid but this will allow blanks
*
* @param string $var  containing the list to check
* @param array $val_vars  containing the validation criteria
* @param array $field_vars  containing the field criteria
* @return string $ret_list  a reordered list containing only valid itemvalues
* @author Stuart Eve
* @since 0.6
*
*/

function chkItemListAllowBlank($var, $val_vars, $field_vars)
{
    global $ste_cd;
    $errs = FALSE;
    $var_name = $val_vars['var_name'];
    $xmi_mod = $field_vars['xmi_mod'];
    // first explode the item list
    $exp_list = explode (' ', trim($var));
    // foreach through the list checking if each item is valid. 
    // If it is then add it to the return list, otherwise add it a string
    // to be sent to the messages array
    if (count($exp_list >= 1)) {
        $ret_list = FALSE;
        foreach($exp_list as $value) {
            if (is_numeric($value)) {
                $valid =
                    chkValid(
                        FALSE,
                        $ste_cd,
                        $value,
                        $xmi_mod . '_tbl_' . $xmi_mod,
                        $xmi_mod . '_cd'
                ); 
            } else {
                $valid =
                    chkValid(
                        $value,
                        FALSE,
                        FALSE,
                        $xmi_mod . '_tbl_' . $xmi_mod,
                        $xmi_mod . '_cd'
                ); 
            }
            if (!$value) {
                // The value is blank - send a skip error
                $valid = FALSE;
                $var =
                    array(
                        'field' => $val_vars['var_name'],
                        'vars' => "The {$val_vars['var_name']} was set to skip",
                        'err' => 'skip'
                );
                return ($var);
            }
            if ($valid == FALSE) {
                $ret_list .= $value.' ';
            } else {
                $errs[] = 
                    array(
                        'field' => $var_name,
                        'vars' => "The item '$value' is not a valid $xmi_mod. ",
                        'err' => 'on'
                );
            }
        }
    } else {
        $errs[] = 
            array(
                'field' => $var_name,
                'vars' => "The list doesn't not appear to be a space separated list",
                'err' => 'on'
        );
    }
    if ($errs) {
        $ret_errs =
            array(
                'field' => $var_name,
                'vars' => FALSE,
                'err' => 'on'
        );
        foreach ($errs as $err) {
            $ret_errs['vars'] .= $err['vars'];
        }
        return $ret_errs;
    } else {
        $ret_list = rtrim($ret_list);
        return $ret_list;
    }
}

// }}}
// {{{ chkSfCond()

/**
* this evaluates the display conditions set on the subform, runs the appropriate function 
* and then handles the return value
*
* @param string $itemkey  the itemkey
* @param string $itemvalue  the itemvalue
* @param string $sf_cond  the sf_condition array 
* @author Stuart Eve
* @since 0.7
*
*/

function chkSfCond($itemkey, $itemvalue, $sf_cond) {
    foreach ($sf_cond as $key => $value) {
        $func = $value['func'];
        if (!$func($itemkey,$itemvalue,$value['args'])) {
            return FALSE;
        }
    }
    return TRUE;
}

/// }}}
// {{{ chkFtrMode()

/**
* Check if subform should be show for the current filter mode
*
* @param string $itemkey  the itemkey
* @param string $itemvalue  the itemvalue
* @param string array $args  This takes a comma separated list of args
* @return boolean $return  If the subform should be shown
* @author John Layt
* @since 2.0
*
*/

function chkFtrMode($itemkey, $itemvalue, $args)
{
    global $sf_conf, $ftr_mode, $page_conf;
    // Don't show if not on data_view and there are no filters
    if ($page_conf->id() != 'data_view' and !reqQst($_SESSION, 'filters')) {
        return FALSE;
    }
    return ($sf_conf['op_ftr_mode'] == 'default' || $sf_conf['op_ftr_mode'] == $ftr_mode);
}

/// }}}
/// {{{ chkFragPresence()

/**
* checks to see if a frag (of any type) is attached to an item.
*
* @param string $itemkey  the itemkey
* @param string $itemvalue  the itemvalue
* @param array $args  This takes a comma separated list of args
* @return boolean $return  the boolean return - TRUE if frag is present
* @author Stuart Eve
* @author Andrew Dufton
* @author Guy Hunt
* @since 0.7
*
* This function basically runs the appropriate get function and evaluates the result
*
* NOTE: specific behaviour of attributes is commented below. Do NOT use this to check for
* 'any attribute of a given type' use it only to check for specific attributes. (Code fix
* by AJD) GH 19-08-2010
*
* DEV NOTE: it would be quite easy to adapt this to handle the 'any attribute of a given
* type' situation as well as the specified attribute. Code it within the attribute case.
*
*/

function chkFragPresence($itemkey, $itemvalue, $args) 
{
    // explode the args
    $args = explode(',',$args);
    $dataclass = trim($args[0]);
    $classtype = trim($args[1]);
    if (isset($args[2])) {
        $frag_value = trim($args[2]);
    }
    // set return to false to presume that the condition isn't evaluating
    $return = FALSE;
    
    // attr, handle erroneous dataclass naming
    if ($dataclass == 'attr') {
        echo "ADMIN ERROR: as of v1.0 dataclass in conditions must be declared as 'attribute' not 'attr'<br/>function chkFragPresence()<br/>";
        $dataclass = 'attribute';
    }
    
    // Handles multiple dataclasses
    switch ($dataclass) {
        // dataclass = attribute
        // Note: This function checks for the presence of a fragment. In the case of attr
        // this means that the function checks for the presence of an attribute NOT 'the 
        // presence of any attribute in a given type'.
        case 'attribute':
            global $lang;
            if ($frag_value) {
                $return =
                    getAttr(
                        $itemkey,
                        $itemvalue,
                        $frag_value,
                        'alias',
                        $lang
                );
            }
            break;
            
        // dataclass = txt
        case 'txt':
            $return =
                getSingleText(
                    $itemkey,
                    $itemvalue,
                    $classtype
            );
            break;
            
        // dataclass = xmi
        case 'xmi':
            $return = getXmi($itemkey, $itemvalue, $classtype);
            break;
            
        // dataclass = number
        case 'number':
            $return = getNumber($itemkey, $itemvalue, $classtype);
            break;
            
        // dataclass = span
        case 'span':
            $return = getSpan($itemkey, $itemvalue, $classtype);
            break;
            
        // dataclass = file
        case 'file':
            $return = getFile($itemkey, $itemvalue, $classtype);
            break;
            
        // Default
        default:
            $return = FALSE;
            break;
    }
    if ($return != FALSE) {
        $return = TRUE;
    }
    return $return;
}

// }}}
// {{{ chkBool()

/**
* checks the boolean of an attribute
*
* @param string $itemkey  the itemkey
* @param string $itemvalue  the itemvalue
* @param array $args  this should only have one argument (the id of the attribute you are after)
* @return boolean $return  the boolean return - TRUE if frag is present
* @author Guy Hunt
* @since 1.1
*
* Note: "NOT SET" evaluates as FALSE
*
*/

function chkBool($itemkey, $itemvalue, $args) {
    $return = FALSE;
    // handle the args
    $attribute = $args;
    // try to get the attribute
    $frag = getAttr($itemkey, $itemvalue, $attribute, 'boolean');
    // return
    return $frag;
}

// }}}
// {{{ chkModTypeCond()

/**
* checks the modtype - basically acts as a wrapper to getModType
*
* @param string $itemkey  the itemkey
* @param string $itemvalue  the itemvalue
* @param array $args  this should only have one argument (the id of the modtype you are after)
* @return boolean $return  the boolean return - TRUE if frag is present
* @author Stuart Eve
* @since 0.7
*
*/

function chkModTypeCond($itemkey, $itemvalue, $args) {
    
    // set return to false to presume that the condition isn't evaluating
    $return = FALSE;
    
    $modtype = $args;
    $mod =  splitItemkey($itemkey);
    //get the modtype of the itemkey/itemval pair
    $item_modtype = getModType($mod, $itemvalue);
    
    if ($modtype == $item_modtype) {
        $return = TRUE;
    }
    if ($return != FALSE) {
        $return = TRUE;
    }
    return $return;
}

// }}}
// {{{ chkSteCdCond()

/**
 * checks the ste_cd
 *
 * @param string $itemkey  the itemkey
 * @param string $itemvalue  the itemvalue
 * @param array $args  this should only have one argument (the id of the modtype you are after)
 * @return boolean $return  the boolean return - TRUE if frag is present
 * @author Michael Johnson
 * @since 1.2
 *
 */

function chkSteCdCond($itemkey, $itemvalue, $args) {

    // set return to false to presume that the condition isn't evaluating
    $test_cd = $args;
    $ste_cd =  splitItemval($itemvalue, TRUE);

    return ($test_cd===$ste_cd);
}

// }}}
// {{{ chkPathRemote()

/**
* tests if a path contains a remote URL type scheme
*
* @param string $path  the path to be tested
* @return boolean TRUE if remote, FALSE if not
* @author Michael Johnson (m.johnson@lparchaeology.com)
* @since 1.1
*
* This is used as a check by the processFiles() function
*
*/
 
function chkPathRemote($path)
{
    // list of remote protocol schemes
    $nonlocalschemes =
        array(
            'http',
            'rtps',
            'ftp',
            'https',
            'sftp',
            'ssl',
            'tls',
            'ssh',
            'spdy',
    );
    // attempt to extract the protocol scheme from the url
    $scheme = parse_url($path, PHP_URL_SCHEME);
    // test if scheme is in the nonlocalschemes list
    if (in_array($scheme, $nonlocalschemes)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ chkGroupPerm()

/**
* checks the permissions of the group
*
* @param string $itemkey  the itemkey
* @param string $itemvalue  the itemvalue
* @param array $args  this is an array of the group ids that will be allowed to see this form
* @return boolean $return  the boolean return - TRUE if frag is present
* @author Stuart Eve
* @since 0.7
*
*/

function chkGroupPerm($itemkey, $itemvalue, $args)
{
    //set return to false to presume that the condition isn't evaluating
    $return = FALSE;
    
    //compare the sgrp_arr of the user with the array sent in the args
    $array_intersect = array_intersect($args, $_SESSION['sgrp_arr']);
    
    if (!empty($array_intersect)) {
        $return = TRUE;
    }
    if ($return != FALSE) {
        $return = TRUE;
    }
    return $return;
}

// }}}
// {{{ chkUserPerm()

/**
* checks the permissions of the user
*
* @param string $itemkey  the itemkey
* @param string $itemvalue  the itemvalue
* @param array $args  this is an array of the user ids that will be allowed to see this form
* @return boolean $return  the boolean return - TRUE if frag is present
* @author Stuart Eve
* @since 0.7
*
*/

function chkUserPerm($itemkey, $itemvalue, $args) {
    global $user_id;
    
    //set return to false to presume that the condition isn't evaluating
    
    $return = FALSE;
    
    //compare the user_id with the array sent in the args
    if (in_array($user_id,$args)) {
        $return = TRUE;
    }
    if ($return != FALSE) {
        $return = TRUE;
    }
    return $return;
}

// }}}
// {{{ chkTmpFtr()

/**
* checks to see if there is a temporary filter in play
*
* @param string $blank1  not needed
* @param string $blank2  not needed
* @param array $args  not needed either
* @return true or false
* @author Guy Hunt
* @since v0.9
*
*/

function chkTmpFtr($blank1, $blank2, $args)
{
    if (isset($_SESSION['filters'])) {
        $filters = $_SESSION['filters'];
        if ($filters) {
            foreach ($_SESSION['filters'] as $key => $filter) {
                if (!is_int($key) &&
                        $key != 'traverse_to' &&
                        $key != 'sort_order' &&
                        $key != 'nname' &&
                        $key != 'cre_by') {
                    return TRUE;
                }
            }
        }
        return FALSE;
    } else {
        return FALSE;
    }
}

// }}}

?>
