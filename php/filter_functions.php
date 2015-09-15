<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* filter_functions.php
*
* holds filter functions
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
* @link       http://ark.lparchaeology.com/svn/php/filter_functions.php
* @since      File available since Release 0.5
*
* This code was written as some of the last development work before we 
* adopted the PEAR coding standard as part of the v0.6 release. Uncommented
* functions are therefore largely "v0.5" code. This was all sketched out by
* GH in order to get FASTI going in around 2006/07.
*
*/

// FILTER FUNCTIONS

// --------------- //
// 1 - THE FILTERS //
// --------------- //

// Filters require a trio of functions:
//  1 - buildFltxxx() to build up a function from one or many submit routines and add to $filters
//  2 - execFltxxx() to execute the filter onto a result set
//  3 - dispFltxxx() to display the filter


// --- FREETEXT --- //

// {{{ buildFltFtx()

/**
* builds elements into a text search filter
*
* @param array $filter  an ARK standard filter array containing the required params
* @param array $qstr  the contents of the querystring
* @return array $filters  an ARK standard filters array
* @author Guy Hunt
* @since 0.5
*
*/

function buildFltFtx($filters, $qstr)
{
    // get the ftr_id
    $ftr_id = reqQst($qstr, 'ftr_id');
    if (!$ftr_id) {
        echo "ADMIN ERROR: From v0.9 all actions on filters require the ftr_id to be sent";
    }
    // request all the potential elements of the filter
    $src = reqQst($qstr, 'src');
    // and the set_operator (if sent)
    $set_op = reqQst($qstr, 'set_op');
    if (!$set_op) {
        $set_op = 'intersect';
    }
    
    // see if this filter already exists
    if (!array_key_exists($ftr_id, $filters)) {
        // add it
        $filters[$ftr_id] = array('ftype' => 'ftx');
    }
    // call the filter up from the array
    $filter = $filters[$ftr_id];
    
    // try to add elements to the filter
    if ($src) {
        $filter['src'] = $src;
    }
    // add in the set operator
    $filter['set_operator'] = $set_op;
    // verify filter complete - if verified add to $filters
    $num_elements = 3;
    $new_filters = verAddFtr($filters, $filter, $ftr_id, $num_elements);
    
    // return
    if ($new_filters) {
        return($new_filters);
    } else {
        $filters[$ftr_id] = $filter;
        return($filters);
    }
}

// }}}
// {{{ execFltftx()

/**
* executes a free text search across the db
*
* @param array $filter  an ARK standard filter array containing the required params
* @param boolean $simple  a switch to return the results as hits or ARK 'results_array'
* @return array $results_array  a standard ARK results array
* @author Guy Hunt
* @since 0.5
*
*/

function execFltftx($filter, $simple=FALSE)
{
    global $db, $lang, $ftx_mode;
    $src = $filter['src'];
    $hits = FALSE;
    $results_array = FALSE;
    // Strip out illegal characters
    if (get_magic_quotes_gpc()) {
        //echo "Magic Quotes are on... that's not very secure";
        $src = stripslashes($src);
    }
    // Handle the search mode
    if (!$ftx_mode) {
        $ftx_mode = 'normal';
    }
    // 1a - Search the normal text
    // Setup SQL
    if ($ftx_mode == 'fancy') {
        $sql = "
            SELECT id, itemkey, itemvalue, txt, txttype,
            MATCH (txt, itemvalue) AGAINST (? IN BOOLEAN MODE) AS score
            FROM cor_tbl_txt
            WHERE MATCH (txt, itemvalue) AGAINST (? IN BOOLEAN MODE)
        ";
        $params = array($src,$src);
    } else {
        $sql = "
            SELECT id, itemkey, itemvalue, txt, txttype,
            MATCH (txt) AGAINST (?) AS score
            FROM cor_tbl_txt
            WHERE MATCH (txt) AGAINST (?)
        ";
        $params = array($src,$src);
    }
    if (substr($src,0,1)=='*'){
        $qrytxt=str_replace('*', '%',$src);
        $sql = "
            SELECT id, itemkey, itemvalue, txt, txttype,
            1 AS score
            FROM cor_tbl_txt
            WHERE txt like ?
        ";
        $params = array($qrytxt);
    }
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__ . "1a");
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__ . "1a");
    // Handle results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $type_alias = getAlias('cor_lut_txttype', $lang, 'id', $row['txttype'], 1);
            $hits[] =
                array(
                    'keyvalpr' => "{$row['itemkey']}{$row['itemvalue']}",
                    // uses to the power of function to up the return on exact matches JO 23/04/13
                    'score' => pow($row['score'],4),
                    'frag_id' => $row['id'],
                    'frag_class' => 'txt',
                    'itemkey' => $row['itemkey'],
                    'itemvalue' => $row['itemvalue'],
                    'frag' => $row['txt'],
                    'type' => $row['txttype'],
                    'type_alias' => $type_alias
            );
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    // 1b - Look for exact matches
    // Setup SQL
    $sql = "
        SELECT id, itemkey, itemvalue, txt, txttype
        FROM cor_tbl_txt
        WHERE txt LIKE ?
    ";
    $params = array("%$src%");
    
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__ . "1b");
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__ . "1b");
    // Handle results
    unset($row);
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if ($hits){
            do {
                foreach ($hits as $key => $hit) {
                    if ($hit['frag_id'] == $row['id']) {
                        $hits[$key]['score'] = $hits[$key]['score'] + 150;
                    }
                }
           } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
        }
    }
    // 1c - search aliased attributes
    // Set up SQL
    $sql = "
        SELECT cor_tbl_attribute.id, cor_lut_attribute.attributetype, cor_tbl_attribute.itemkey, cor_tbl_attribute.itemvalue, cor_tbl_attribute.attribute, cor_tbl_alias.alias, MATCH (alias) AGAINST (? IN BOOLEAN MODE) AS score
        FROM cor_tbl_attribute, cor_tbl_alias, cor_lut_attribute
        WHERE cor_tbl_attribute.attribute = cor_tbl_alias.itemvalue
        AND cor_lut_attribute.id = cor_tbl_attribute.attribute
        AND cor_tbl_alias.itemkey = 'cor_lut_attribute'
        AND MATCH (alias) AGAINST (? IN BOOLEAN MODE)
    ";
    $params = array($src,$src);
    // Run the Query
    $sql = dbPrepareQuery($sql,__FUNCTION__ . "1c");
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__ . "1c");
    // Handle the results
    $oneswegot = array();
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $blah = $row['itemkey'].'-'.$row['itemvalue'];
            if (!array_key_exists($blah, $oneswegot)) {
            $type_alias = getAlias('cor_lut_attributetype', $lang, 'id', $row['attributetype'], 1);
            $hits[] =
                array(
                    'keyvalpr' => "{$row['itemkey']}{$row['itemvalue']}",
                    'score' => 4,
                    'frag_id' => $row['id'],
                    'frag_class' => 'txt',
                    'itemkey' => $row['itemkey'],
                    'itemvalue' => $row['itemvalue'],
                    'frag' => $row['alias'],
                    'type' => $row['attribute'],
                    'type_alias' => $type_alias
            );
                $oneswegot[$blah] = $row['attribute'];
            }
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    // 1d - Search the keys (by searching on the text table)
    // Setup SQL
    $sql = "
        SELECT id, itemkey, itemvalue
        FROM cor_tbl_txt
        WHERE itemvalue LIKE ?
    ";
    $params = array("%$src%");
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__ . "1d");
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__ . "1d");
    // Handle results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $type_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $row['itemkey'], 1);
            $hits[] =
                array(
                    'keyvalpr' => "{$row['itemkey']}{$row['itemvalue']}",
                    'score' => 100,
                    'frag_id' => $row['id'],
                    'frag_class' => 'key',
                    'itemkey' => $row['itemkey'],
                    'itemvalue' => $row['itemvalue'],
                    'frag' => $row['itemvalue'],
                    'type' => 'key',
                    'type_alias' => $type_alias
            );
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    // 1d - search aliased actions
    
    
    // 1e - search filenames
    // Set up SQL
    $sql = "
          SELECT cor_tbl_file.id, cor_lut_file.filetype, cor_lut_file.filename, cor_tbl_file.itemkey, cor_tbl_file.itemvalue, cor_tbl_file.file, MATCH (filename) AGAINST  (? IN BOOLEAN MODE) AS score
          FROM cor_tbl_file, cor_lut_file
          WHERE cor_lut_file.id = cor_tbl_file.file
          AND MATCH (filename) AGAINST (? IN BOOLEAN MODE)
    ";
    $params = array($src,$src);
    // Run the Query
    $sql = dbPrepareQuery($sql,__FUNCTION__ . "1e");
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__ . "1e");
    // Handle the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
          $type_alias = getAlias('cor_lut_filetype', $lang, 'id', $row['filetype'], 1);
          $hits[] =
              array(
                  'keyvalpr' => "{$row['itemkey']}{$row['itemvalue']}",
                  'score' => 4,
                  'frag_id' => $row['id'],
                  'frag_class' => 'txt',
                  'itemkey' => $row['itemkey'],
                  'itemvalue' => $row['itemvalue'],
                  'frag' => $row['filename'],
                  'type' => $row['file'],
                  'type_alias' => $type_alias
          );
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    // 2 - process the hits array
    //if we are on a simple routine we just return the hits array raw
    if ($hits && $simple) {
        return $hits;
    }
    //otherwise process it
    if ($hits) {
        $results_array = prcsHits($hits);
    }
    // 3 - Sort the results array
    if ($results_array) {
        $results_array = sortResArr($results_array);
    }
    // 4 - Return
    if ($results_array) {
        return($results_array);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ dispFltFtx()

/**
* displays a filter dialogue for free text searches
*
* @param array $filter  an ARK standard filter array containing the required params
* @return void
* @author Guy Hunt
* @since 0.5
*
*/

function dispFltFtx($filter, $filter_id)
{
    global $lang, $form_method, $view, $sf_conf_name;
    // handle overlay modes
    $overlay_inp = mkOverlayInp($sf_conf_name);
    // handle the id
    $ftr_id_inp = mkFtrIdInp($filter_id);
    // markup
    $mk_search = getMarkup('cor_tbl_markup', $lang, 'search');
    $mk_ftrftx = getMarkup('cor_tbl_markup', $lang, 'ftx');
    // Step 1 - A search box
    if (!isset($filter['src'])) {
        $var = "<label>{$mk_ftrftx}</label>";
        $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">\n";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= $overlay_inp;
        $var .= $ftr_id_inp;
        $var .= "<span class=\"row\">";
        $var .= "<input type=\"text\" name=\"src\" value=\"\" />";
        $var .= "<button type=\"submit\">$mk_search</button>";
        $var .= "</span></form>";
    // COMPLETED - the completed filter display
    } else {
        $var = "<label>{$mk_ftrftx} - \"{$filter['src']}\"</label>";
    }
    // OUTPUT the var
    echo $var;
    // DELETE option
    if (!$overlay_inp) {
        echo dispDelOp($filter_id);
    }
}

// }}}
// {{{
// {{{ buildFltTxt()

// --- TEXT TYPE --- //

/**
*
* builds elements into a text search filter
*
* @param array $filter  an ARK standard filter array containing the required params
* @param array $qstr  the contents of the querystring
* @return array $filters  an ARK standard filters array
* @author Andrew Dufton
* @author Guy Hunt
* @since 0.8
*
*/

function buildFltTxt($filters, $qstr)
{
    // get the ftr_id
    $ftr_id = reqQst($qstr, 'ftr_id');
    if (!$ftr_id) {
        echo "ADMIN ERROR: From v0.9 all actions on filters require the ftr_id to be sent";
    }
    // request all the potential elements of the filter
    $txt = reqQst($qstr, 'txt');
    $txttype = reqQst($qstr, 'txttype');
    // and the set_operator (if sent)
    $set_op = reqQst($qstr, 'set_op');
    if (!$set_op) {
        $set_op = 'intersect';
    }
    
    // see if this filter already exists
    if (!array_key_exists($ftr_id, $filters)) {
        // add it
        $filters[$ftr_id] = array('ftype' => 'txt');
    }
    // call the filter up from the array
    $filter = $filters[$ftr_id];
    
    // try to add elements to the filter
    if ($txt) {
        $filter['txt'] = $txt;
    }
    if ($txttype) {
        $filter['txttype'] = $txttype;
    }
    // add in the set operator
    $filter['set_operator'] = $set_op;
    // verify filter complete - if verified add to $filters
    $num_elements = 4;
    $new_filters = verAddFtr($filters, $filter, $ftr_id, $num_elements);
    
    // return
    if ($new_filters) {
        return($new_filters);
    } else {
        $filters[$ftr_id] = $filter;
        return($filters);
    }
}

// }}}
// {{{ execFltTxt()

/**
* executes a text by type filter
*
* @param array $filter  the filter
* @param string $simple  a flag to just return the hits raw
* @return array $results_array  a standard ARK results array
* @author Andrew Dufton
* @author Guy Hunt
* @since v0.8
*
*/

function execFltTxt($filter, $simple=FALSE)
{
    global $db, $lang, $ftx_mode;
    $txt = $filter['txt'];
    $txttype = $filter['txttype'];
    $hits = FALSE;
    $results_array = FALSE;
    // Remove any illegal characters from query string
    if (get_magic_quotes_gpc()) {
        //echo "Magic Quotes are on... that's not very secure";
        $txt = stripslashes($txt);
    }
    // Handle the search mode
    if (!$ftx_mode) {
        $ftx_mode = 'normal';
    }
    // Search the text table
    // Setup SQL
    if ($ftx_mode == 'fancy') {
        $sql = "
            SELECT id, itemkey, itemvalue, txt, txttype, MATCH (txt) AGAINST (? IN BOOLEAN MODE) AS score
            FROM cor_tbl_txt
            WHERE MATCH (txt) AGAINST (? IN BOOLEAN MODE) AND txttype= ?
        ";
        $params = array($txt,$txt,$txttype);
    } else {
        $sql = "
            SELECT id, itemkey, itemvalue, txt, txttype, MATCH (txt) AGAINST (?) AS score
            FROM cor_tbl_txt
            WHERE MATCH (txt) AGAINST (?) AND txttype= ?
        ";
        $params = array($txt,$txt,$txttype);
    }
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $type_alias = getAlias('cor_lut_txttype', $lang, 'id', $row['txttype'], 1);
            $hits[] =
                array(
                    'keyvalpr' => "{$row['itemkey']}{$row['itemvalue']}",
                    'score' => $row['score'],
                    'frag_id' => $row['id'],
                    'frag_class' => 'txt',
                    'itemkey' => $row['itemkey'],
                    'itemvalue' => $row['itemvalue'],
                    'frag' => $row['txt'],
                    'type' => $row['txttype'],
                    'type_alias' => $type_alias
            );
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    
    // 2 - process the hits array
    //if we are on a simple routine we just return the hits array raw
    if ($hits && $simple) {
        return $hits;
    }
    if ($hits) {
        $results_array = prcsHits($hits);
    }
    
    // 3 - Sort the results array
    if ($results_array) {
        $results_array = sortResArr($results_array);
    }
    
    // 4 - Return
    if ($results_array) {
        return($results_array);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ dispFltTtx()

/**
* displays a filter dialogue for free text searches
*
* @param array $filter  an ARK standard filter array containing the required params
* @param string $filter_id  the filter id
* @return void
* @author Andrew Dufton
* @author Guy Hunt
* @since 0.5
*
*/

function dispFltTxt($filter, $filter_id)
{
    global $lang, $form_method, $view, $sf_conf_name;
    // handle overlay modes
    $overlay_inp = mkOverlayInp($sf_conf_name);
    // handle the id
    $ftr_id_inp = mkFtrIdInp($filter_id);
    // markup
    $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
    $mk_search = getMarkup('cor_tbl_markup', $lang, 'search');
    $mk_ftrtxt = getMarkup('cor_tbl_markup', $lang, 'filtertxt');
    // ARG 1 - Texttype
    if (!isset($filter['txttype'])) {
        $ddt = ddAlias(FALSE, FALSE, 'cor_lut_txttype', $lang, 'txttype', FALSE, 'code');
        $var = "<label>{$mk_ftrtxt}</label>";
        $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= $overlay_inp;
        $var .= $ftr_id_inp;
        $var .= "<span class=\"row\">";
        $var .= "<span class=\"input\">$ddt</span>";
        $var .= "<span class=\"input\"><button type=\"submit\">";
        $var .= "$mk_go";
        $var .= "</button></span></span></form>";
    } else {
        $alias = getAlias('cor_lut_txttype', $lang, 'id', $filter['txttype'], 1);
        $var = "<label>{$alias} - </label>";
    }
    // ARG 2 - A search term
    if (!isset($filter['txt']) && isset($filter['txttype'])) {
        $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= $overlay_inp;
        $var .= $ftr_id_inp;
        $var .= "<span class=\"row\">";
        $var .= "<input type=\"text\" name=\"txt\" value=\"\" />";
        $var .= "<span class=\"input\"><button type=\"submit\">$mk_search</button></span>";
        $var .= "</span></form>";
    // COMPLETED - Display completed filter
    } elseif (isset($filter['txt'])) {
        $alias = getAlias('cor_lut_txttype', $lang, 'id', $filter['txttype'], 1);
        $var = "<label>{$alias} - </label>";
        $var .= "<label>\"{$filter['txt']}\"</label>";
    }
    // OUTPUT the var
    echo $var;
    // DELETE option
    if (!$overlay_inp) {
        echo dispDelOp($filter_id);
    }
}

// }}}
// {{{ buildFltKey

// --- ITEM KEY --- //

/**
* builds elements into a itemkey search filter
*
* @param array $filter  an ARK standard filter array containing the required params
* @param array $qstr  the contents of the querystring
* @return array $filters  an ARK standard filters array
* @author Guy Hunt
* @since 0.5
*
*/

function buildFltKey($filters, $qstr)
{
    // get the ftr_id
    $ftr_id = reqQst($qstr, 'ftr_id');
    if (!$ftr_id) {
        echo "ADMIN ERROR: From v0.9 all actions on filters require the ftr_id to be sent";
    }
    // request all the potential elements of the filter
    $key = reqQst($qstr, 'key');
    // request all the potential elements of the filter
    $ktype = reqQst($qstr, 'ktype');
    // and the set_operator (if sent)
    $set_op = reqQst($qstr, 'set_op');
    if (!$set_op) {
        $set_op = 'intersect';
    }
    
    // see if this filter already exists
    if (!array_key_exists($ftr_id, $filters)) {
        // add it
        $filters[$ftr_id] = array('ftype' => 'key');
    }
    // call the filter up from the array
    $filter = $filters[$ftr_id];
    
    // try to add elements to the filter
    if ($key) {
        $filter['key'] = $key;
        // if this key doesnt use modtypes then we can just guess the ktype automatically
        $mod = getSingle('shortform', 'cor_tbl_module', "id = $key");
        if (!chkModtype($mod)) {
            $ktype = 'all';
        }
    }
    if ($ktype) {
        $filter['ktype'] = $ktype;
    }
    
    // add in the set operator
    $filter['set_operator'] = $set_op;
    // verify filter complete - if verified add to $filters
    $num_elements = 4;
    $new_filters = verAddFtr($filters, $filter, $ftr_id, $num_elements);
    
    // return
    if ($new_filters) {
        return($new_filters);
    } else {
        $filters[$ftr_id] = $filter;
        return($filters);
    }
}

// }}}
// {{{ execFltkey()

/**
* executes an itemkey based filter
*
* @param array $filter  the ARK standard settings for the filter
* @param boolean $simple  a switch to allow a hits array to be returned raw
* @return $array $results_array  an ARK standard results array
* @author Guy Hunt
* @since v0.4
*
* NOTE: $filter should contain:
*       key - the module key either the id of the module or the 3 letter mod code
*       type - the filter type (should be set to 'key')
*
*/

function execFltkey($filter, $simple=FALSE)
{
    global $db, $lang;
    $hits = FALSE;
    $results_array = FALSE;
    $where = FALSE;
    // Set up
    $key = $filter['key'];
    if (is_numeric($key)) {
        // Get the code we need
        $key = getSingle('shortform', 'cor_tbl_module', "id = $key");
    }
    // Check to see if we are using a subtype
    $ktype = $filter['ktype'];
    if (is_numeric($ktype)) {
        // add a where clause
        $ktypecol = $key.'type';
        $where = "WHERE $ktypecol = $ktype";
    }
    // 1 - Pull back the valid items for this key
    $tbl = $key.'_tbl_'.$key;
    $sql = "
        SELECT *
        FROM $tbl
        $where
    ";
    $params = array();
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        // See if the key has a type
        $modtype = chkModtype($key);
        do {            
            // Set up the basics of the item_key
            $item_key = $key.'_cd';
            $item_value = $row[$item_key];
            $type_alias =
                getAlias(
                    'cor_tbl_module',
                    $lang,
                    'itemkey',
                    $item_key,
                    1
            );
            $hits[] =
                array(
                    'keyvalpr' => $item_key.$item_value,
                    'score' => 1,
                    'frag_id' => 'n/a',
                    'frag_class' => 'key',
                    'itemkey' => $item_key,
                    'itemvalue' => $item_value,
                    'frag' => $row[$item_key],
                    'type' => 'key',
                    'type_alias' => $type_alias
            );
            // If the key has a type, get the type and add it as a second hit for the item
            if ($modtype == 'true') {
                $frag =
                    getAlias(
                        $key.'_lut_'.$key.'type',
                        $lang,
                        'id',
                        getModType($key, $item_value),
                        1
                );
                $type_alias =
                    getAlias(
                        'cor_tbl_col',
                        $lang,
                        'dbname',
                        $key.'type',
                        1
                );
                $hits[] =
                    array(
                        'keyvalpr' => $item_key.$item_value,
                        'score' => 0,
                        'frag_id' => 'n/a',
                        'frag_class' => 'modtype',
                        'itemkey' => $item_key,
                        'itemvalue' => $item_value,
                        'frag' => $frag,
                        'type' => 'key',
                        'type_alias' =>
                        $type_alias
                );
            }
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    // 2 - process the hits array
    //if we are on a simple routine we just return the hits array raw
    if($hits && $simple){
        return $hits;
    }
    if ($hits) {
        $results_array = prcsHits($hits);
    }
    // 3 - Sort the results array
    if ($results_array) {
        $results_array = sortResArr($results_array, 'ITEMVAL', 'itemval');
    }
    // 4 - Return
    if ($results_array) {
        return($results_array);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ dispFltKey()

/**
* display a user interface for itemkey searches
*
* @param array $filter  an ARK standard filter array containing the required params
* @param string $filter_id  the filter id
* @return void
* @author Guy Hunt
* @since 0.5
*
*/

function dispFltKey($filter, $filter_id)
{
    global $lang, $form_method, $view, $sf_conf_name, $loaded_modules;
    // handle overlay modes
    $overlay_inp = mkOverlayInp($sf_conf_name);
    // handle filter id
    $ftr_id_inp = mkFtrIdInp($filter_id);
    // markup
    $mk_search = getMarkup('cor_tbl_markup', $lang, 'search');
    $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
    $mk_ftrkey = getMarkup('cor_tbl_markup', $lang, 'filteritem');
    
    // a DD menu of items
    $mod_select = "<select name=\"key\">\n";
    $mod_select .= "<option value=\"\">-----</option>\n";
    foreach ($loaded_modules as $key => $mod_short) {
        $mod_id = getSingle('id', 'cor_tbl_module', "shortform = '$mod_short'");
        $mod_alias = getAlias('cor_tbl_module', $lang, 'shortform', $mod_short, 1);
        $mod_select .= "<option value=\"$mod_id\">$mod_alias</option>\n";
    }
    $mod_select .= "</select>\n";
        
    // Arg 1 - The key
    if (!isset($filter['key'])) {
        $var = "<label>{$mk_ftrkey}</label>";
        $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= $overlay_inp;
        $var .= $ftr_id_inp;
        $var .= "<span class=\"row\">";
        $var .= "<span class=\"input\">$mod_select</span>";
        $var .= "<span class=\"input\"><button type=\"submit\">";
        $var .= "$mk_go";
        $var .= "</button></span></span></form>";
    } else {
        $alias = getAlias('cor_tbl_module',$lang,'id',$filter['key'],1);
        $var = "<label>$alias</label>";
    }
    // Arg 2 - The modtype
    if (!isset($filter['ktype']) && isset($filter['key'])) {
        // sort out the mod
        $mod = $filter['key'];
        if (is_numeric($mod)) {
            // Get the code we need
            $mod = getSingle('shortform', 'cor_tbl_module', "id = $mod");
        }        
        // only if this key has subtypes
        if (chkModType($mod)) {
            // give a dd
            $typtbl = $mod.'_lut_'.$mod.'type';
            $typcol = $mod.'type';
            $dd2 = ddAlias('all', 'All types', $typtbl, $lang, 'ktype', FALSE, 'code');
            // add the form to the var string
            $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
            $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
            $var .= $overlay_inp;
            $var .= $ftr_id_inp;
            $var .= "<span class=\"row\"><span class=\"input\">$dd2</span>";
            $var .= "<span class=\"input\"><button type=\"submit\">$mk_search</button></span>";
            $var .= "</span></form>";
        } else {
            // assume ktype all
            $var = "<label>$alias</label>";
            $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
            $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
            $var .= $overlay_inp;
            $var .= $ftr_id_inp;
            $var .= "<input type=\"hidden\" name=\"ktype\" value=\"all\" />";
            $var .= "<span class=\"ftr_input\">";
            $var .= "<button type=\"submit\">$mk_search</button></span>";
            $var .= "</form>";
        }
    // COMPLETED - Display a completed filter
    } elseif (isset($filter['ktype'])) {
        $alias = getAlias('cor_tbl_module', $lang, 'id', $filter['key'], 1);
        $var = "<label>$alias</label>";
        if ($filter['ktype'] != 'all') {
            // sort out the mod
            $mod = $filter['key'];
            if (is_numeric($mod)) {
                // Get the code we need
                $mod = getSingle('shortform', 'cor_tbl_module', "id = $mod");
            }
            $typtbl = $mod.'_lut_'.$mod.'type';
            $alias = getAlias($typtbl,$lang,'id',$filter['ktype'],1);
            $var .= "<label> - {$alias}</label>";        
        } else {
            $var .= "<label> - All</label>";       
        }
    }
    // OUTPUT the var
    echo $var;
    // DELETE option
    if (!$overlay_inp) {
        echo dispDelOp($filter_id);
    }
}

// }}}
// {{{ buildFltAtr

/**
* builds elements into an attribute filter
*
* @param array $filter  an ARK standard filter array containing the required params
* @param array $qstr  the contents of the querystring
* @return array $filters  an ARK standard filters array
* @author Guy Hunt
* @since 0.5
*
*/

function buildFltAtr($filters, $qstr)
{
    // get the ftr_id
    $ftr_id = reqQst($qstr, 'ftr_id');
    if (!$ftr_id) {
        echo "ADMIN ERROR: From v0.9 all actions on filters require the ftr_id to be sent";
    }
    // request all the potential elements of the filter
    $atrtype = reqQst($qstr, 'atrtype');
    $atr = reqQst($qstr, 'atr');
    $bv = reqQst($qstr, 'bv');
    // and the set_operator (if sent)
    $set_op = reqQst($qstr, 'set_op');
    if (!$set_op) {
        $set_op = 'intersect';
    }
    
    // see if this filter already exists
    if (!array_key_exists($ftr_id, $filters)) {
        // add it
        $filters[$ftr_id] = array('ftype' => 'atr');
    }
    // call the filter up from the array
    $filter = $filters[$ftr_id];
    
    // try to add elements to the filter
    if ($atr) {
        $filter['atr'] = $atr;
    }
    if ($bv) {
        $filter['bv'] = $bv;
    }
    if ($atrtype) {
        $filter['atrtype'] = $atrtype;
    }
    // add in the set operator
    $filter['set_operator'] = $set_op;
    
    // verify filter complete - if verified add to $filters
    $num_elements = 5;
    $new_filters = verAddFtr($filters, $filter, $ftr_id, $num_elements);
    // return
    if ($new_filters) {
        return($new_filters);
    } else {
        $filters[$ftr_id] = $filter;
        return($filters);
    }
}

// }}}
// {{{ execFltAtr()

/**
* executes an attribute based filter
*
* @param array $filter  the ARK standard settings for the filter
* @param boolean $simple  a switch to allow a hits array to be returned raw
* @return $array $results_array  an ARK standard results array
* @author Guy Hunt
* @since v0.4
*
* NOTE: $filter should contain:
*       key - the module key either the id of the module or the 3 letter mod code
*       type - the filter type (should be set to 'key')
*
*/

function execFltAtr($filter, $simple=FALSE)
{
    global $db, $lang;
    $hits = FALSE;
    $results_array = FALSE;
    
    $atr = $filter['atr'];
    // Must be numeric
    if (!is_numeric($atr) && $atr != 'all') {
        // Get the code we need
        $atr = getSingle('id', 'cor_lut_attribute', "attribute = $atr");
    }
    $bv = $filter['bv'];
    if ($bv == 'zero') {
        // Get the code we need
        $bv = (int)0;
    }
    // 1 - Pull back the key value pairs with this attribute attached
    // set up the SQL according to where we are looking at a single atr or all atrs of a type
    if ($atr == 'all') {
        $sql = "
            SELECT a.itemkey, a.itemvalue, a.attribute, b.attributetype
            FROM cor_tbl_attribute AS a, cor_lut_attribute AS b
            WHERE a.attribute = b.id
            AND b.attributetype = ?
            AND a.boolean = ?
        ";
        $params = array($filter['atrtype'],$bv);
    } else {
        $sql = "
            SELECT itemkey, itemvalue
            FROM cor_tbl_attribute
            WHERE attribute = ?
            AND boolean = ?
        ";
        $params = array($atr,$bv);
    }
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        //The type alias for the snippet is actualy the alias of the attribute type
        $type_alias = getAlias('cor_lut_attributetype', $lang, 'id', $filter['atrtype'], 1);
        // Aliases are handled differently depending on whether this is all or a single
        if ($atr != 'all') {
            // The frag is always the same too
            $frag = getAlias('cor_lut_attribute', $lang, 'id', $atr, 1);
        }
        do {
            if ($atr == 'all') {
                // use a 
                $frag = getAlias('cor_lut_attribute', $lang, 'id', $row['attribute'], 1);
            }
            $item_key = $row['itemkey'];
            $item_value = $row['itemvalue'];
            $hits[] =
                array(
                    'keyvalpr' => $item_key.$item_value,
                    'score' => 1,
                    'frag_id' => 'n/a',
                    'frag_class' => 'attribute',
                    'itemkey' => $item_key,
                    'itemvalue' => $item_value,
                    'frag' => $frag,
                    'type' => $type_alias,
                    'type_alias' => $type_alias
            );
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    
    // 2 - process the hits array
    //if we are on a simple routine we just return the hits array raw
    if ($hits && $simple) {
        return $hits;
    }
    if ($hits) {
        $results_array = prcsHits($hits);
    }
    
    // 3 - Sort the results array
    if ($results_array) {
        $results_array = sortResArr($results_array);
    }
    
    // 4 - Return
    if ($results_array) {
        return($results_array);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ dispFltAtr()

/**
* display a user interface for attribute searches
*
* @param array $filter  an ARK standard filter array containing the required params
* @param string $filter_id  the filter id
* @return void
* @author Guy Hunt
* @since 0.5
*
*/

function dispFltAtr($filter, $filter_id)
{
    global $lang, $form_method, $view, $sf_conf_name;
    // handle overlay modes
    $overlay_inp = mkOverlayInp($sf_conf_name);
    // handle filter id
    $ftr_id_inp = mkFtrIdInp($filter_id);
    // handle display options
    $op_display = reqQst($filter, 'op_display');
    // markup
    $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
    $mk_ftrtitle = getMarkup('cor_tbl_markup', $lang, $filter['ftype']);
    $mk_all = getMarkup('cor_tbl_markup', $lang, 'all');
    // ARG 1 - The attribute type
    if (!isset($filter['atrtype'])) {
        // make a DD menu of attribute types
        $ddt =
            ddAlias(
                FALSE,
                FALSE,
                'cor_lut_attributetype',
                $lang,
                'atrtype',
                FALSE,
                'code'
        );
        // make the form
        $var = "<label>{$mk_ftrtitle}</label>";
        $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= $overlay_inp;
        $var .= $ftr_id_inp;
        $var .= "<span class=\"row\">";
        $var .= "<span class=\"input\">$ddt</span>";
        $var .= "<span class=\"input\"><button type=\"submit\">";
        $var .= "$mk_go";
        $var .= "</button></span></span></form>";
    } else {
        // display the arg
        $alias = getAlias('cor_lut_attributetype', $lang, 'id', $filter['atrtype'], 1);
        $var = "<label>$alias</label>";
    }
    // ARG 2 - The attribute
    if (!isset($filter['atr']) && isset($filter['atrtype'])) {
        switch ($op_display) {
            case 'fauxdex':
                // a faux indexed list of attributes
                // get the attributes for this attribute type
                $attrs =
                    getFIndex('attribute', $filter['atrtype'], FALSE);
                // make up repeated bit of the link to put this var into the qstr
                $link = "{$_SERVER['PHP_SELF']}?";
                $link .= mkOverlayInp($sf_conf_name, 'href');
                $link .= "&amp;";
                $link .= mkFtrIdInp($filter_id, 'href');
                $link .= "&amp;";
                if ($attrs) {
                    // start an output UL
                    $var .= "<ul class=\"attr_index\">";
                    // finish the link with the 'all' default
                    $all_default = $link;
                    $all_default .= 'atr=all';
                    // put the default into the top li
                    $var .= "<li><a href=\"$all_default\">";
                    $var .= "$mk_all</a></li>\n";
                    foreach ($attrs as $key => $attr) {
                        // alias this attribute
                        $alias = getAlias('cor_lut_attribute', $lang, 'id', $attr['classtype'], 1);   
                        // finish off the link with the relevant id
                        $thislink = $link;
                        $thislink .= "atr={$attr['classtype']}";
                        // put it all together
                        $var .= "<li><a href=\"$thislink\">";
                        $var .= "$alias <i>&#40;{$attr['count']}&#41;</i></a></li>\n";
                    }
                    $var .= "</ul>";
                } else {
                    $var .= "No Attributes Applied";
                }
                break;
            
            case 'linklist':
                // list of attributes
                // get the attributes for this attribute type
                $attrs =
                    getMulti('cor_lut_attribute', "attributetype = {$filter['atrtype']}", 'id');
                // make up a link to put this var into the qstr
                $link = "{$_SERVER['PHP_SELF']}?";
                $link .= mkOverlayInp($sf_conf_name, 'href');
                $link .= "&amp;";
                $link .= mkFtrIdInp($filter_id, 'href');
                $link .= "&amp;";
                // start an output UL
                $var .= "<ul>";
                // put in the 'all' default
                $all_default = $link;
                $all_default .= 'atr=all';
                // put the default into the top li
                $var .= "<li><a href=\"$all_default\">";
                $var .= "$mk_all</a></li>\n";
                foreach ($attrs as $key => $attr) {
                    // alias this attribute
                    $alias = getAlias('cor_lut_attribute', $lang, 'id', $attr, 1);   
                    // finish off the link with the relevant id
                    $thislink = $link;
                    $thislink .= "atr={$attr['classtype']}";
                    // put it all together
                    $var .= "<li><a href=\"$thislink\">";
                    $var .= "$alias</a></li>\n";
                }
                $var .= "</ul>";
                break;
            
            case 'dd':
            default:
                // DD menu
                // make a DD menu of attributes of this type
                $dda =
                    ddAlias(
                        'all',
                        $mk_all,
                        'cor_lut_attribute',
                        $lang,
                        'atr',
                        "AND cor_lut_attribute.attributetype = {$filter['atrtype']}",
                        'code'
                );
                // display a form
                $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
                $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                $var .= $overlay_inp;
                $var .= $ftr_id_inp;
                $var .= "<span class=\"row\">";
                $var .= "<span class=\"input\">$dda</span>";
                $var .= "<span class=\"input\"><button type=\"submit\">";
                $var .= "$mk_go";
                $var .= "</button></span></span></form>";
                break;
        }
    } elseif (isset($filter['atr'])) {
        if ($filter['atr'] != 'all') {
            $alias = getAlias('cor_lut_attribute', $lang, 'id', $filter['atr'], 1);
        } else {
            $alias = getAlias('cor_lut_attributetype', $lang, 'id', $filter['atrtype'], 1);
            $alias .= " - $mk_all";
        }
        // The attributetype alias
        $alias = getAlias('cor_lut_attributetype', $lang, 'id', $filter['atrtype'], 1);
        $var = "<label>{$alias} - </label>";
        // The search attribute itself
        if ($filter['atr'] == 'all') {
            $alias = getMarkup('cor_tbl_markup', $lang, 'all');
        } else {
            $alias = getAlias('cor_lut_attribute', $lang, 'id', $filter['atr'], 1);
        }
        $var .= "<label>$alias</label>";        
    }
    // ARG 3 - the Boolean Value
    if (!isset($filter['bv']) && isset($filter['atrtype']) AND isset($filter['atr'])) {
        // display a toggle
        $link = mkFtrIdInp($filter_id, 'href');
        $link .= "&amp;";
        $link .= mkOverlayInp($sf_conf_name, 'href');
        $var .= "<a class=\"clean_but\" ";
        $var .= "href=\"{$_SERVER['PHP_SELF']}?bv=1&amp;$link\">true</a>";
        $var .= "&nbsp;<a class=\"clean_but\" ";
        $var .= "href=\"{$_SERVER['PHP_SELF']}?bv=zero&amp;$link\">false</a>\n";
    } elseif (isset($filter['bv'])) {
        if ($filter['bv'] == 1) {
            //printf("Arg3: True<br/>");
        } else {
            //printf("Arg3: False<br/>");
        }
    }
    // OUTPUT the var
    echo $var;
    // DELETE option
    if (!$overlay_inp) {
        echo dispDelOp($filter_id);
    }
}

// }}}
// {{{ buildFltstecd()

// --- SITECODE--- //

/**
* builds elements into a sitecode search filter
*
* @param array $filter  an ARK standard filter array containing the required params
* @return void
* @author Stuart Eve
* @since 0.6
*
*/

function buildFltstecd($filters, $qstr)
{
    // get the ftr_id
    $ftr_id = reqQst($qstr, 'ftr_id');
    if (!$ftr_id) {
        echo "ADMIN ERROR: From v0.9 all actions on filters require the ftr_id to be sent";
    }
    // request all the potential elements of the filter
    $scode = reqQst($qstr, 'scode');
    // and the set_operator (if sent)
    $set_op = reqQst($qstr, 'set_op');
    if (!$set_op) {
        $set_op = 'intersect';
    }
    
    // see if this filter already exists
    if (!array_key_exists($ftr_id, $filters)) {
        // add it
        $filters[$ftr_id] = array('ftype' => 'stecd');
    }
    // call the filter up from the array
    $filter = $filters[$ftr_id];
    
    // try to add elements to the filter
    if ($scode) {
        $filter['scode'] = $scode;
    }
    // add in the set operator
    $filter['set_operator'] = $set_op;
    // verify filter complete - if verified add to $filters
    $num_elements = 3;
    $new_filters = verAddFtr($filters, $filter, $ftr_id, $num_elements);
    // return
    if ($new_filters) {
        return($new_filters);
    } else {
        $filters[$ftr_id] = $filter;
        return($filters);
    }
}

// }}}
// {{{ execFltstecd()

/**
* executes a site code search across the db
*
* @param array $filter  an ARK standard filter array containing the required params
* @param boolean $simple  a switch to return the results as hits or ARK 'results_array'
* @return array $results_array  a standard ARK results array
* @author Stuart Eve
* @since 0.6
*
*/

function execFltstecd($filter, $simple=FALSE)
{
    global $db, $lang, $loaded_modules;
    $scode = $filter['scode'];
    $hits = FALSE;
    $results_array = FALSE;
    // 1 - run a series of sql queries building the hits array as we go
    foreach ($loaded_modules as $value) {
        // sort out the mod
        $mod = $value;
        if (is_numeric($mod)) {
        // Get the code we need
        $mod = getSingle('shortform', 'cor_tbl_module', "id = $mod");
        }
        // Setup SQL
        $sql = "
            SELECT *
            FROM {$value}_tbl_{$value}
            WHERE ste_cd = ?";
        $params = array($scode);
        // Run the query
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        
        // Handle results
        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
             $modtype = chkModtype($mod);
                do {
                    // Set up the basics of the item_key
                    $item_key = $mod . '_cd';
                    $item_value = $row[$item_key];
                    $type_alias =
                        getAlias(
                            'cor_tbl_module',
                            $lang,
                            'itemkey',
                            $item_key,
                            1
                    );
                    $hits[] =
                        array(
                            'keyvalpr' => $item_key.$item_value,
                            'score' => 1,
                            'frag_id' => 'n/a',
                            'frag_class' => 'key',
                            'itemkey' => $item_key,
                            'itemvalue' => $item_value,
                            'frag' => $row[$item_key],
                            'type' => 'key',
                            'type_alias' => $type_alias
                    );
                    // If the key has a type, get the type and add it as a second hit for the item
                    if ($modtype == 'true'){
                        $frag =
                            getAlias(
                                $mod.'_lut_'.$mod.'type',
                                $lang,
                                'id',
                                getModType($mod, $item_value),
                                1
                        );
                        $type_alias =
                            getAlias(
                                'cor_tbl_col',
                                $lang,
                                'dbname',
                                $mod.'type',
                                1
                        );
                        $hits[] =
                            array(
                                'keyvalpr' => $item_key.$item_value,
                                'score' => 0,
                                'frag_id' => 'n/a',
                                'frag_class' => 'modtype',
                                'itemkey' => $item_key,
                                'itemvalue' => $item_value,
                                'frag' => $frag,
                                'type' => 'key',
                                'type_alias' =>
                                $type_alias
                        );
                    }
                } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
        }
    }
  
    // 2 - process the hits array
    //if we are on a simple routine we just return the hits array raw
    if ($hits && $simple) {
        return $hits;
    }
    //otherwise process it
    if ($hits) {
        $results_array = prcsHits($hits);
    }
    // 3 - Sort the results array
    if ($results_array) {
        $results_array = sortResArr($results_array);
    }
    // 4 - Return
    if ($results_array) {
        return($results_array);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ dispFltstecd()

/**
* displays a filter dialogue for Site Code searches
*
* @param array $filter  an ARK standard filter array containing the required params
* @return void
* @author Stuart Eve
* @since 0.6
*/

function dispFltstecd($filter, $filter_id)
{
    global $lang, $form_method, $view, $sf_conf_name;
    // handle overlay modes
    $overlay_inp = mkOverlayInp($sf_conf_name);
    // handle filter id
    $ftr_id_inp = mkFtrIdInp($filter_id);
    // markup
    $mk_search = getMarkup('cor_tbl_markup', $lang, 'search');
    $mk_stecd = getMarkup('cor_tbl_markup', $lang, 'ste_cd');
    $mod_dd =
        ddSimple(
            FALSE,
            FALSE,
            'cor_tbl_ste',
            'id',
            'scode',
            FALSE
    );

    if (!isset($filter['scode'])) {
        $var = "<label>{$mk_stecd}</label>";
        $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">\n";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= $overlay_inp;
        $var .= $ftr_id_inp;
        $var .= "<span class=\"row\">";
        $var .= $mod_dd;
        $var .= "<button type=\"submit\">$mk_search</button>";
        $var .= "</span></form>";
    } else {
        $var = "<label>{$mk_stecd} - {$filter['scode']}</label>";
    }

    // OUTPUT the var
    echo $var;
    // DELETE option
    if (!$overlay_inp) {
        echo dispDelOp($filter_id);
    }
}

// }}}

/** --- PLACE --- //
 * buildFltPlace()
 * To build the existing search filter into a self contained array
 * This filter is used when you want to query against a place.
 *
 * @param array $filters the existing array of filters
 * @param array $qstr - the $_REQUEST array
 * @return array the array containing the new filters. FALSE if
 *               there was an error.
 * @access public
 * @since 0.6
 */

function buildFltPlace($filters, $qstr) 
{
    // get the ftr_id
    $ftr_id = reqQst($qstr, 'ftr_id');
    if (!$ftr_id) {
        echo "ADMIN ERROR: From v0.9 all actions on filters require the ftr_id to be sent";
    }
    // request all the potential elements of the filter
    $placetype = reqQst($qstr, 'placetype');
    $place = reqQst($qstr, 'place');
    // and the set_operator (if sent)
    $set_op = reqQst($qstr, 'set_op');
    if (!$set_op) {
        $set_op = 'intersect';
    }
    
    // see if this filter already exists
    if (!array_key_exists($ftr_id, $filters)) {
        // add it
        $filters[$ftr_id] = array('ftype' => 'place');
    }
    // call the filter up from the array
    $filter = $filters[$ftr_id];
    
    // try to add elements to the filter
    if ($place) {
        $filter['place'] = $place;
    }
    if ($placetype) {
        $filter['placetype'] = $placetype;
    }
    // add in the set operator
    $filter['set_operator'] = $set_op;
    
    // verify filter complete - if verified add to $filters
    $num_elements = 4;
    $new_filters = verAddFtr($filters, $filter, $ftr_id, $num_elements);
    // return
    if ($new_filters) {
        return($new_filters);
    } else {
        $filters[$ftr_id] = $filter;
        return($filters);
    }
}

// {{{ execFltPlace()

/**
* executes a place spatial filter
*
* @param array $filter  an array of the filter vars
* @param mapObj $map  the current map object
* @param array $mods  this is an array of short mod codes for 
*                        the modules containing spatial data 
* @return array $return_array  the results array. FALSE if
*                               there was an error.
* @access public
* @since 0.6
*/

function execFltPlace($filter,$simple=FALSE) 
{
    //this uses some mapping functions - so include the map_functions
    include_once ('map/map_functions.php');
    global $db, $lang,$wxs_qlayers;
    $valid_itemvals = array();
    $hits = FALSE;
    $results_array = FALSE;
    
    $place = $filter['place'];
    // Must be numeric
    if (!is_numeric($place) && $place != 'all') {
        // Get the code we need
        $place = getSingle('id', 'cor_lut_place', "place = $place");
    }
    // 1 - If we are looking for all the places of a certain type we need to get an array of places
    if ($place == 'all') {
        $sql = "
            SELECT *
            FROM cor_lut_place
            WHERE placetype = ?
        ";
        $params = array($filter['placetype']);
    } else {
        $sql = "
            SELECT *
            FROM cor_lut_place
            WHERE id = ?
        ";
        $params = array($place);
    }

    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    //now we have our places for each one we need to run an intersect filter for each one against the queryable layers
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            //first grab the geometry of the place by running a query to the WFS server
            $wfs_place_query = "{$row['spatial_server_uri']}&VERSION=1.1.0&SERVICE=WFS&REQUEST=GetFeature&TYPENAME={$row['layername']}&FILTER=<Filter><PropertyIsEqualTo><PropertyName>ark_id</PropertyName><Literal>{$row['layerid']}</Literal></PropertyIsEqualTo></Filter>";
            $gml = @file_get_contents($wfs_place_query, 0);
            
            $debugjs= "<script>console.log( 'Debug Objects (placequery): ";
            $debugjs.=$wfs_place_query;
            $debugjs.="' );</script>";

            //now we have to grab the geometry out
            //DEV NOTE: PUT IN HANDLER FOR OTHER WFS SERVER TYPES (NOT JUST MAPSERVER)
            $geometry_namespace = 'ms:msGeometry';
            $geometry = parseGeometry($gml,$geometry_namespace);
            $debugjs.= "<script>console.log( \"Debug Objects (gml): ";
            $debugjs.=$gml;
            $debugjs.="\" );</script>";
            $debugjs.= "<script>console.log( 'Debug Objects (geometry): ";
            $debugjs.=$geometry;
            $debugjs.="' );</script>";
            //now foreach through the query layers - getting the intersects
            foreach ($wxs_qlayers as $key => $layer) {
                $wfs_intersect_query = "&VERSION=1.1.0&SERVICE=WFS&REQUEST=GetFeature&TYPENAME=$key&FILTER=<Filter><Intersects><PropertyName>Geometry</PropertyName>$geometry</Intersects></Filter>";
                //these queries can get quite big so lets POST it
                $opts = array('http' =>
                    array(
                        'method'  => 'POST',
                        'header'  => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $wfs_intersect_query
                    )
                );
                $context  = stream_context_create($opts);
                $gml = @file_get_contents($layer['url'], 0,$context);
                if ($gml) {
                
                $debugjs.= "<script>console.log( 'Debug Objects (query): ";
                $debugjs.=$wfs_intersect_query;
                $debugjs.="' );</script>";
                $debugjs.= "<script>console.log( 'Debug Objects (uri): ";
                $debugjs.=$layer['url'];
                $debugjs.="' );</script>";
                
                //for DEBUG
                //echo $debugjs;

                    $valid_itemvals[$row['id']][$layer['mod'] . '_cd'] = parseArkIDs($gml);
                }
            }

        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    
    if (!empty($valid_itemvals)) {
        foreach ($valid_itemvals as $place_key => $place_itemvals) {
            //The type alias for the snippet is actualy the alias of the attribute type
            $type_alias = getAlias('cor_lut_placetype', $lang, 'id', $filter['placetype'], 1);
            // Aliases are handled differently depending on whether this is all or a single
            if ($place != 'all') {
                // The frag is always the same too
                $frag = getAlias('cor_lut_place', $lang, 'id', $place_key, 1);
            }
            foreach ($place_itemvals as $mod => $itemvals) {
                foreach ($itemvals as $value) {
                    if ($place == 'all') {
                           // use a 
                           $frag = getAlias('cor_lut_place', $lang, 'id', $place_key, 1);
                       }
                       $item_key = $mod;
                       $item_value = $value;
                       $hits[] =
                           array(
                               'keyvalpr' => $item_key.$item_value,
                               'score' => 1,
                               'frag_id' => 'n/a',
                               'frag_class' => 'place',
                               'itemkey' => $item_key,
                               'itemvalue' => $item_value,
                               'frag' => $frag,
                               'type' => $type_alias,
                               'type_alias' => $type_alias
                       );
                }
            }
        }
    }
    
    // 2 - process the hits array
    //if we are on a simple routine we just return the hits array raw
    if ($hits && $simple) {
        return $hits;
    }
    if ($hits) {
        $results_array = prcsHits($hits);
    }
    
    // 3 - Sort the results array
    if ($results_array) {
        $results_array = sortResArr($results_array);
    }
    
    // 4 - Return
    if ($results_array) {
        return($results_array);
    } else {
        return (FALSE);
    }
}

// }}}

/**
 * dispFltPlace()
 * displays the place search filter dialogue.
 *
 * @param array $filter  an array of the filter vars
 * @param int $filter_id the id of the filter
 * @access public
 * @since 0.6
 */

function dispFltPlace($filter, $filter_id)
{
    global $lang, $form_method, $view, $sf_conf_name;
    // handle overlay modes
    $overlay_inp = mkOverlayInp($sf_conf_name);
    // handle filter id
    $ftr_id_inp = mkFtrIdInp($filter_id);
    // handle display options
    $op_display = reqQst($filter, 'op_display');
    // markup
    $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
    $mk_ftrtitle = getMarkup('cor_tbl_markup', $lang, $filter['ftype']);
    $mk_all = getMarkup('cor_tbl_markup', $lang, 'all');
    // ARG 1 - The attribute type
    if (!isset($filter['placetype'])) {
        // make a DD menu of attribute types
        $ddt =
            ddAlias(
                FALSE,
                FALSE,
                'cor_lut_placetype',
                $lang,
                'placetype',
                FALSE,
                'code'
        );
        // make the form
        $var = "<label>{$mk_ftrtitle}</label>";
        $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= $overlay_inp;
        $var .= $ftr_id_inp;
        $var .= "<span class=\"row\">";
        $var .= "<span class=\"input\">$ddt</span>";
        $var .= "<span class=\"input\"><button type=\"submit\">";
        $var .= "$mk_go";
        $var .= "</button></span></span></form>";
    } else {
        // display the arg
        $alias = getAlias('cor_lut_placetype', $lang, 'id', $filter['placetype'], 1);
        $var = "<label>$alias</label>";
    }
    // ARG 2 - The attribute
    if (!isset($filter['place']) && isset($filter['placetype'])) {
        switch ($op_display) {
            case 'linklist':
                // list of places
                // get the places for this place type
                $places =
                    getMulti('cor_lut_place', "placetype = {$filter['placetype']}", 'id');
                // make up a link to put this var into the qstr
                $link = "{$_SERVER['PHP_SELF']}?";
                $link .= mkOverlayInp($sf_conf_name, 'href');
                $link .= "&amp;";
                $link .= mkFtrIdInp($filter_id, 'href');
                $link .= "&amp;";
                // start an output UL
                $var .= "<ul>";
                // put in the 'all' default
                $all_default = $link;
                $all_default .= 'atr=all';
                // put the default into the top li
                $var .= "<li><a href=\"$all_default\">";
                $var .= "$mk_all</a></li>\n";
                foreach ($placess as $key => $attr) {
                    // alias this attribute
                    $alias = getAlias('cor_lut_place', $lang, 'id', $attr, 1);   
                    // finish off the link with the relevant id
                    $thislink = $link;
                    $thislink .= "place={$place['classtype']}";
                    // put it all together
                    $var .= "<li><a href=\"$thislink\">";
                    $var .= "$alias</a></li>\n";
                }
                $var .= "</ul>";
                break;
            
            case 'dd':
            default:
                // DD menu
                // make a DD menu of attributes of this type
                $dda =
                    ddAlias(
                        'all',
                        $mk_all,
                        'cor_lut_place',
                        $lang,
                        'place',
                        "AND cor_lut_place.placetype = {$filter['placetype']}",
                        'code'
                );
                // display a form
                $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
                $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                $var .= $overlay_inp;
                $var .= $ftr_id_inp;
                $var .= "<span class=\"row\">";
                $var .= "<span class=\"input\">$dda</span>";
                $var .= "<span class=\"input\"><button type=\"submit\">";
                $var .= "$mk_go";
                $var .= "</button></span></span></form>";
                break;
        }
    } elseif (isset($filter['place'])) {
        if ($filter['place'] != 'all') {
            $alias = getAlias('cor_lut_place', $lang, 'id', $filter['place'], 1);
        } else {
            $alias = getAlias('cor_lut_placetype', $lang, 'id', $filter['placetype'], 1);
            $alias .= " - $mk_all";
        }
        // The placetype alias
        $alias = getAlias('cor_lut_placetype', $lang, 'id', $filter['placetype'], 1);
        $var = "<label>{$alias} - </label>";
        // The search attribute itself
        if ($filter['place'] == 'all') {
            $alias = getMarkup('cor_tbl_markup', $lang, 'all');
        } else {
            $alias = getAlias('cor_lut_place', $lang, 'id', $filter['place'], 1);
        }
        $var .= "<label>$alias</label>";        
    }
    // OUTPUT the var
    echo $var;
    // DELETE option
    if (!$overlay_inp) {
        echo dispDelOp($filter_id);
    }
}

// --- RANGES --- //

// {{{ buildFltRange()

/**
* builds elements into a 'range' search filter
*
* @param array $filter  an ARK standard filter array containing the required params
* @return void
* @author Guy Hunt
* @since 0.7
*
*/

function buildFltRange($filters, $qstr)
{
    // get the ftr_id
    $ftr_id = reqQst($qstr, 'ftr_id');
    if (!$ftr_id) {
        echo "ADMIN ERROR: From v0.9 all actions on filters require the ftr_id to be sent";
    }
    // request all the potential elements of the filter
    $selectortype = reqQst($qstr, 'selectortype');
    $spantype = reqQst($qstr, 'spantype');
    $beg = reqQst($qstr, 'beg');
    $end = reqQst($qstr, 'end');
    $beg_mod = reqQst($qstr, 'beg_mod');
    $end_mod = reqQst($qstr, 'end_mod');
    // and the set_operator (if sent)
    $set_op = reqQst($qstr, 'set_op');
    if (!$set_op) {
        $set_op = 'intersect';
    }
    
    // see if this filter already exists
    if (!array_key_exists($ftr_id, $filters)) {
        // add it
        $filters[$ftr_id] = array('ftype' => 'range');
    }
    // call the filter up from the array
    $filter = $filters[$ftr_id];
    
    // try to add elements to the filter
    if ($spantype) {
        $filter['spantype'] = $spantype;
    }
    if ($selectortype) {
        $filter['selectortype'] = $selectortype;
    }
    if ($beg) {
        $filter['beg'] = $beg;
    }
    if ($end) {
        $filter['end'] = $end;
    }
    if ($beg_mod) {
        $filter['beg_mod'] = $beg_mod;
    }
    if ($end_mod) {
        $filter['end_mod'] = $end_mod;
    }
    // add in the set operator
    $filter['set_operator'] = $set_op;
    // Set the number of required elements
    if (isset($filter['selectortype'])) {
        if ($filter['selectortype'] == 'adbc') {
            $num_elements = 8;
        } else {
            $num_elements = 6;
        }
    } else {
        // make it a spuriously high number that will always cause validation to fail
        $num_elements = 666;
    }
    // verify filter complete - if verified add to $filters
    $new_filters = verAddFtr($filters, $filter, $ftr_id, $num_elements);
    // return
    if ($new_filters) {
        return($new_filters);
    } else {
        $filters[$ftr_id] = $filter;
        return($filters);
    }
}

// }}}
// {{{ execFltRange()

/**
* executes a range based filter
*
* @param array $filter  the ARK standard settings for the filter
* @param boolean $simple  a switch to allow a hits array to be returned raw
* @return $array $results_array  an ARK standard results array
* @author Guy Hunt
* @since v0.7
*
*/

function execFltRange($filter, $simple=FALSE)
{
    global $db, $lang;
    $hits = FALSE;
    $results_array = FALSE;
    // Type alias
    $type_alias = getAlias('cor_lut_spantype', $lang, 'id', $filter['spantype'], 1);
    // Set up the range that will be acting as the search key
    $range = array();
    $range['beg'] = $filter['beg'];
    $range['end'] = $filter['end'];
    //check if these values need to be modified
    if ($filter['selectortype'] == 'adbc') {
        if ($filter['beg_mod'] == 'ad') {
            $range['beg'] = 2000 - $range['beg'];
        }
        if ($filter['beg_mod'] == 'bc') {
            $range['beg'] = $range['beg'] + 2000;
        }
        if ($filter['end_mod'] == 'ad') {
            $range['end'] = 2000 - $range['end'];
        }
        if ($filter['end_mod'] == 'bc') {
            $range['end'] = $range['end'] + 2000;
        }
    }
    // 1 - Pull back all items with spans of this type
    $sql = "
        SELECT *
        FROM cor_tbl_span
        WHERE spantype = ?
    ";
    $params = array($filter['spantype']);
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            // if the AD/BC modifier is in use then send 'reverse' to the function
            if ($filter['selectortype'] == 'adbc') {
                $span_result = compareSpans($row, $range, TRUE);
            } else {
                $span_result = compareSpans($row, $range);
            }
            if ($span_result == TRUE AND isItemKey($row['itemkey'])) {
                // the frag depends on the adbc modifier (see also sf_chronology.php)
                if ($filter['selectortype'] == 'adbc') {
                    $frbeg = $row['beg']-2000;
                    $frend = $row['end']-2000;
                    // sort out epochs
                    if ($frbeg > 0) {
                        $start_epoch = 'BC';
                    } else {
                        $start_epoch = 'AD';
                        $frbeg = abs($frbeg);
                    }
                    if ($frend > 0) {
                        $end_epoch = 'BC';
                    } else {
                        $end_epoch = 'AD';
                        $frend = abs($frend);
                    }
                    // Set up the var 
                    $frag = "$frbeg $start_epoch";
                    $frag .= ' - ';
                    $frag .= "$frend $end_epoch";
                } else {
                    $frag = $row['beg'].' - '.$row['end'];
                }
                $hits[] =
                    array(
                        'keyvalpr' => "{$row['itemkey']}{$row['itemvalue']}",
                        'score' => 1,
                        'frag_id' => $row['id'],
                        'frag_class' => 'span',
                        'itemkey' => $row['itemkey'],
                        'itemvalue' => $row['itemvalue'],
                        'frag' => $frag,
                        'type' => $row['spantype'],
                        'type_alias' => $type_alias
                );
            }
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    // 2 - process the hits array
    //if we are on a simple routine we just return the hits array raw
    if($hits && $simple) {
        return $hits;
    }
    if ($hits) {
        $results_array = prcsHits($hits);
    }
    // 3 - Sort the results array
    if ($results_array) {
        $results_array = sortResArr($results_array, 'ITEMVAL', 'itemval');
    }
    // 4 - Return
    if ($results_array) {
        return($results_array);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ dispFltRange()

/**
* displays a 'range' filter. This will search the db for values matching a defined range
*
* @param array $filter  an ARK standard filter array containing the required params
* @return void
* @author Guy Hunt
* @since 0.7
*
*/

function dispFltRange($filter, $filter_id)
{
    global $lang, $form_method, $view, $sf_conf_name;
    // handle overlay modes
    $overlay_inp = mkOverlayInp($sf_conf_name);
    // handle filter id
    $ftr_id_inp = mkFtrIdInp($filter_id);
    // markup
    $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
    $mk_search = getMarkup('cor_tbl_markup', $lang, 'search');
    $mk_ftrrange = getMarkup('cor_tbl_markup', $lang, 'filterspan');
    // output
    // ARG 1 - Spantype
    if (!isset($filter['spantype'])) {
        // make a dd of spantypes
        $dd =
            ddAlias(
                FALSE,
                FALSE,
                'cor_lut_spantype',
                $lang,
                'spantype',
                'AND cor_tbl_alias.aliastype = 1',
                'code'
        );
        // make var
        $var = "<label>{$mk_ftrrange}</label>";
        $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= $overlay_inp;
        $var .= $ftr_id_inp;
        $var .= "<span class=\"row\">";
        $var .= "<span class=\"input\">$dd</span>";
        $var .= "<span class=\"input\"><button type=\"submit\">$mk_go</button></span>";
        $var .= "</span></form>";
    } else {
        $type_alias = getAlias('cor_lut_spantype', $lang, 'id', $filter['spantype'], 1);
        $var = "<label>{$type_alias}</label>";
    }
    // ARG 2 - Range Selector Type (this is currently always set to ad/bc)
    if (!isset($filter['selectortype']) && isset($filter['spantype'])) {
        $ddt = "<select name=\"selectortype\">\n";
        $ddt .= "    <option value=\"adbc\">AD/BC Modifier</option>\n";
        $ddt .= "    <option value=\"plain\">Plain</option>\n";
        //$ddt .= "    <option value=\"grph\">Graphical</option>\n";
        $ddt .= "</select>\n";
        $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= $overlay_inp;
        $var .= $ftr_id_inp;
        $var .= "<span class=\"row\">";
        $var .= "<span class=\"input\">$ddt</span>";
        $var .= "<span class=\"input\"><button type=\"submit\">$mk_go</button></span>";
        $var .= "</span></form>";
    } elseif (isset($filter['selectortype'])) {
        $var = "<label>{$type_alias}</label>";
    }
    // ARG 3 - A Range selector
    // this form has to control two vars, so we run the logic first
    $range_set = FALSE;
    if (isset($filter['beg']) AND isset($filter['end'])) {
        $range_set = TRUE;
    }else {
        if (isset($filter['beg'])) {
            $form_beg = $filter['beg'];
        } else {
            $form_beg = FALSE;
        }
        if (isset($filter['end'])) {
            $form_end = $filter['end'];
        } else {
            $form_end = FALSE;
        }
        $range_set = FALSE;
    }
    if (isset($filter['selectortype']) AND !$range_set) {
        if ($filter['selectortype'] == 'adbc') {
            // Set up a dd for beg_mod - handle it if already set
            $beg_mod_dd = "<select name=\"beg_mod\" style=\"width: 50px\">\n";
            if (isset($filter['beg_mod'])) {
                $disp = strtoupper($filter['beg_mod']);
                $beg_mod_dd .= "<option value=\"{$filter['beg_mod']}\">$disp</option>\n";
                $beg_mod_dd .= "<option value=\"\">---</option>\n";
                $beg_mod_dd .= "<option value=\"ad\">AD</option>\n";
                $beg_mod_dd .= "<option value=\"bc\">BC</option>\n";
            } else {
                $beg_mod_dd .= "<option value=\"ad\">AD</option>\n";
                $beg_mod_dd .= "<option value=\"bc\">BC</option>\n";
            }
            $beg_mod_dd .= "</select>\n</span>";
            // Set up a dd for end_mod - handle it if already set
            $end_mod_dd = "<select name=\"end_mod\" style=\"width: 50px\" >\n";            
            if (isset($filter['end_mod'])) {
                $disp = strtoupper($filter['end_mod']);
                $end_mod_dd .= "<option value=\"{$filter['end_mod']}\">$disp</option>\n";
                $end_mod_dd .= "<option value=\"\">---</option>\n";
                $end_mod_dd .= "<option value=\"ad\">AD</option>\n";
                $end_mod_dd .= "<option value=\"bc\">BC</option>\n";
            } else {
                $end_mod_dd .= "<option value=\"ad\">AD</option>\n";
                $end_mod_dd .= "<option value=\"bc\">BC</option>\n";
            }
            $end_mod_dd .= "</select>\n</span>";
            $span_form = "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">\n";
            $span_form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
            $span_form .= $overlay_inp;
            $span_form .= $ftr_id_inp;
            $span_form .= "<span class=\"row\">";
            $span_form .= "<input type=\"text\" name=\"beg\" value=\"$form_beg\"  style=\"width: 75px\" />";
            $span_form .= $beg_mod_dd;
            $span_form .= "<span class=\"row\">";
            $span_form .= "<input type=\"text\" name=\"end\" value=\"$form_end\"  style=\"width: 75px\" />";
            $span_form .= $end_mod_dd;
            $span_form .= "<button type=\"submit\">$mk_search</button>";
            $span_form .= "</span>\n";
            $span_form .= "</form>\n";
            $var .= $span_form;           
        }
        if ($filter['selectortype'] == 'plain') {
            $span_form = "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">\n";
            $span_form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
            $span_form .= $overlay_inp;
            $span_form .= $ftr_id_inp;
            $span_form .= "<input type=\"hidden\" name=\"selectortype\" value=\"plain\" />";
            $span_form .= "<span class=\"row\">";
            $span_form .= "<input type=\"text\" name=\"beg\" value=\"$form_beg\"  style=\"width: 75px\" />";
            $span_form .= "<span class=\"row\">";
            $span_form .= "<input type=\"text\" name=\"end\" value=\"$form_end\"  style=\"width: 75px\" />";
            $span_form .= "<button type=\"submit\">$mk_search</button>";
            $span_form .= "</span>\n";
            $span_form .= "</form>\n";
            $var .= $span_form;
        }
        if ($filter['selectortype'] == 'grph') {
            echo "Come off it... like we've had time to develop that! Try Plain or AD/BC mode<br/>";
        }
    // COMPLETED - Display a completed filter
    } elseif ($range_set) {
        if ($filter['selectortype'] == 'adbc') {
            $beg_mod = strtoupper($filter['beg_mod']);
            $end_mod = strtoupper($filter['end_mod']);
            $var .= "<label>{$filter['beg']}{$beg_mod} - {$filter['end']}{$end_mod}</label>";
        } else {
            $var .= "<label>{$filter['beg']} - {$filter['end']}";
        }
    }
    // OUTPUT the var
    echo $var;
    // DELETE option
    if (!$overlay_inp) {
        echo dispDelOp($filter_id);
    }
}

// }}}
// {{{

// --- ACTION--- //

// {{{ buildFltAction()

/**
* builds elements into a action search filter
*
* @param array $filter  an ARK standard filter array containing the required params
* @return void
* @author Stuart Eve
* @since 0.6
*
*/

function buildFltAction($filters, $qstr)
{
    // get the ftr_id
    $ftr_id = reqQst($qstr, 'ftr_id');
    if (!$ftr_id) {
        echo "ADMIN ERROR: From v0.9 all actions on filters require the ftr_id to be sent";
    }
    // request all the potential elements of the filter
    $action = reqQst($qstr, 'action');
    // request all the potential elements of the filter
    $actor = reqQst($qstr, 'actor');
    // and the set_operator (if sent)
    $set_op = reqQst($qstr, 'set_op');
    if (!$set_op) {
        $set_op = 'intersect';
    }
    
    // see if this filter already exists
    if (!array_key_exists($ftr_id, $filters)) {
        // add it
        $filters[$ftr_id] = array('ftype' => 'action');
    }
    // call the filter up from the array
    $filter = $filters[$ftr_id];
    
    // try to add elements to the filter
    if ($action) {
        $filter['action'] = $action;
    }
    if ($actor) {
        $filter['actor'] = $actor;
    }
    
    // add in the set operator
    $filter['set_operator'] = $set_op;
    // verify filter complete - if verified add to $filters
    $num_elements = 4;
    $new_filters = verAddFtr($filters, $filter, $ftr_id, $num_elements);
    
    // return
    if ($new_filters) {
        return($new_filters);
    } else {
        $filters[$ftr_id] = $filter;
        return($filters);
    }
}

// }}}
// {{{ execFltAction()

/**
* executes an action based filter
*
* @param array $filter  the ARK standard settings for the filter
* @param boolean $simple  a switch to allow a hits array to be returned raw
* @return $array $results_array  an ARK standard results array
* @author Stuart Eve
* @since v0.6
*
* NOTE: $filter should contain:
*       action - the action
*       actor - the actor
*
*/

function execFltAction($filter, $simple=FALSE)
{
    global $db, $lang;
    $hits = FALSE;
    $results_array = FALSE;
    $where = FALSE;
    // Set up
    $action = $filter['action'];
    if (is_numeric($action)) {
        // Get the alias we need
        $type_alias = getSingle('actiontype', 'cor_lut_actiontype', "id = $action");
    }
    $frag = getAlias('cor_lut_actiontype', $lang, 'id', $action, 1);
    // Check to see if we are searching for a specific actor
    $actor = $filter['actor'];
    if ($actor) {
        $frag .= " : $actor";
        if ($actor != 'All Actors') {
            $where = " AND actor_itemvalue = '$actor'";
        }
    }
    //make the sql
    $sql = "
        SELECT *
        FROM cor_tbl_action
        WHERE actiontype = ?
        $where
    ";
    $params = array($action);
    
    // Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // Handle the results
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        do {
            $item_key = $row['itemkey'];
            $item_value = $row['itemvalue'];
            $hits[] =
                array(
                    'keyvalpr' => $item_key.$item_value, 
                     'score' => 1, 
                    'frag_id' => 'n/a', 
                    'frag_class' => 'action',
                    'itemkey' => $item_key, 
                    'itemvalue' => $item_value, 
                    'frag' => $frag, 
                    'type' => $type_alias, 
                    'type_alias' => $type_alias
            );
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    // 2 - process the hits array
    //if we are on a simple routine we just return the hits array raw
    if($hits && $simple){
        return $hits;
    }
    if ($hits) {
        $results_array = prcsHits($hits);
    }
    // 3 - Sort the results array
    if ($results_array) {
        $results_array = sortResArr($results_array);
    }
    // 4 - Return
    if ($results_array) {
        return($results_array);
    } else {
        return (FALSE);
    }
}

// }}}
// {{{ dispFltAction()

/**
* displays a filter dialogue for action searches
*
* @param array $filter  an ARK standard filter array containing the required params
* @return void
* @author Stuart Eve
* @since 0.6
*/
function dispFltAction($filter, $filter_id)
{
    global $lang, $form_method, $ftr_mode, $sf_conf_name;
    // handle overlay modes
    $overlay_inp = mkOverlayInp($sf_conf_name);
    // handle filter id
    $ftr_id_inp = mkFtrIdInp($filter_id);
    $username = reqQst($_SESSION['ludata']['auth']['propertyValues'], 'handle');
    $mk_search = getMarkup('cor_tbl_markup', $lang, 'search');
    $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
    $mk_ftractor = getMarkup('cor_tbl_markup', $lang, 'filteractor');
    // a DD of actiontypes
    $dd = ddAlias(FALSE, FALSE, 'cor_lut_actiontype', $lang, 'action', FALSE, 'code');
    switch ($ftr_mode) {
        case 'standard':
        case 'advanced':
            // ARG 1 - the action(type)
            if (!isset($filter['action'])) {
                $var = "<label>{$mk_ftractor}</label>";
                $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
                $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                $var .= $overlay_inp;
                $var .= $ftr_id_inp;
                $var .= "<span class=\"row\">";
                $var .= "<span class=\"input\">$dd</span>";
                $var .= "<span class=\"input\"><button type=\"submit\">$mk_go</button></span>";
                $var .= "</span></form>";
            } else {
                $alias = getAlias('cor_lut_actiontype',$lang,'id',$filter['action'],1);
                $var = "<label>{$alias}</label>";
            }
            // ARG 2 - the actor
            if (!isset($filter['actor']) AND isset($filter['action'])) {    
                $dd2 = ddActor('actor', 'abk', 'name', 'txt', 'All Actors', 'all', 0, $filter['action']); 
                // Set up the form
                $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
                $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                $var .= $overlay_inp;
                $var .= $ftr_id_inp;
                $var .= "<span class=\"row\">";
                $var .= "<span class=\"input\">$dd2</span>";
                $var .= "<span class=\"input\"><button type=\"submit\">$mk_search</button></span>";
                $var .= "</span></form>";
            // COMPLETED - Display a completed filter
            } elseif (isset($filter['actor'])) {
                $alias = getAlias('cor_lut_actiontype',$lang,'id',$filter['action'],1);
                $var = "<label>{$alias} - </label>";
                include('config/settings.php');
                include_once('config/mod_abk_settings.php');
                if ($filter['actor'] != 'All Actors') {
                    $txttype = $abk_xmiconf['fields'][0]['classtype'];
                    $alias = getSingleText('abk_cd', $filter['actor'], $txttype);
                    unset($txttype);
                    $var .= "<label>$alias</label>";
                } else {
                    $var .= "<label>All</label>";
                }
            }
            break;
    }
    // OUTPUT the var
    echo $var;
    // DELETE option
    if (!$overlay_inp) {
        echo dispDelOp($filter_id);
    }
}

// }}}
// {{{ buildFltManual()

/**
* builds a filter that manually creates result set from a list of item keys
*
* @param array $filters - the existing array of filters
* @param array $qstr - the $_REQUEST array
* @return void
* @author Guy Hunt
* @since v0.8
*
*/

function buildFltManual($filters, $qstr)
{
    // get the ftr_id
    $ftr_id = reqQst($qstr, 'ftr_id');
    if (!$ftr_id) {
        echo "ADMIN ERROR: From v0.9 all actions on filters require the ftr_id to be sent";
    }
    // request all the potential elements of the filter
    // itemkey
    $key = reqQst($qstr, 'key');
    // val_list
    $val_list = reqQst($qstr, 'val_list');
    // and the set_operator (if sent)
    $set_op = reqQst($qstr, 'set_op');
    if (!$set_op) {
        $set_op = 'intersect';
    }
    
    // see if this filter already exists
    if (!array_key_exists($ftr_id, $filters)) {
        // add it
        $filters[$ftr_id] = array('ftype' => 'manual');
    }
    // call the filter up from the array
    $filter = $filters[$ftr_id];
    
    // try to add elements to the filter
    if ($key) {
        if (is_numeric($key)) {
            // Get the code we need
            $key = getSingle('shortform', 'cor_tbl_module', "id = $key");
        }
        $filter['key'] = $key;
    }
    if ($val_list) {
        $filter['val_list'] = $val_list;
    }
    
    // add in the set operator
    $filter['set_operator'] = $set_op;
    // verify filter complete - if verified add to $filters
    $num_elements = 4;
    $new_filters = verAddFtr($filters, $filter, $ftr_id, $num_elements);
    
    // return
    if ($new_filters) {
        return($new_filters);
    } else {
        $filters[$ftr_id] = $filter;
        return($filters);
    }
}

// }}}
// {{{ execFltManual

/**
* executes an manual itemkey/val based filter
*
* @param array $filter  the ARK standard settings for the filter
* @param boolean $simple  a switch to allow a hits array to be returned raw
* @return $array $results_array  an ARK standard results array
* @author Guy Hunt
* @since v0.4
*
* NOTE: $filter should contain:
*       key - the module key (the 3 letter mod code)
*       type - the filter type (should be set to 'key')
*
*/

function execFltManual($filter, $simple=FALSE)
{
    global $db, $lang;
    $hits = FALSE;
    $results_array = FALSE;
    $where = FALSE;
    // Set up
    $key = $filter['key'];
    // look at the list of items
    $val_list = $filter['val_list'];
    $val_array = explode(' ', $val_list);
    // See if the key has a type
    $modtype = chkModtype($key);
    // As this is a list of key/val pairs already... no DB lookup is needed
    // loop over the list going straight to hits
    // Handle the results
    foreach ($val_array as $val) {
        // Set up the basics of the item_key
        $item_key = $key.'_cd';
        $item_value = $val;
        $type_alias =
            getAlias(
                'cor_tbl_module',
                $lang,
                'itemkey',
                $item_key,
                1
        );
        $hits[] =
            array(
                'keyvalpr' => $item_key.$item_value,
                'score' => 1,
                'frag_id' => 'n/a',
                'frag_class' => 'key',
                'itemkey' => $item_key,
                'itemvalue' => $item_value,
                'frag' => $item_key,
                'type' => 'key',
                'type_alias' => $type_alias
        );
        // If the key has a type, get the type and add it as a second hit for the item
        if ($modtype == 'true') {
            $frag =
                getAlias(
                    $key.'_lut_'.$key.'type',
                    $lang,
                    'id',
                    getModType($key, $item_value),
                    1
            );
            $type_alias =
                getAlias(
                    'cor_tbl_col',
                    $lang,
                    'dbname',
                    $key.'type',
                    1
            );
            $hits[] =
                array(
                    'keyvalpr' => $item_key.$item_value,
                    'score' => 0,
                    'frag_id' => 'n/a',
                    'frag_class' => 'modtype',
                    'itemkey' => $item_key,
                    'itemvalue' => $item_value,
                    'frag' => $frag,
                    'type' => 'key',
                    'type_alias' =>
                    $type_alias
            );
        }
    }
    
    // 2 - process the hits array
    //if we are on a simple routine we just return the hits array raw
    if ($hits && $simple) {
        return $hits;
    }
    if ($hits) {
        $results_array = prcsHits($hits);
    }
    // 3 - Sort the results array
    if ($results_array) {
        $results_array = sortResArr($results_array, 'ITEMVAL', 'itemval');
    }
    // 4 - Return
    if ($results_array) {
        return($results_array);
    } else {
        return (FALSE);
    }
}

// {{{ dispFltManual()

/**
* displays a dialogue for the manual item filter
*
* @param array $filter  the filter
* @param string $filter_id  the filter id
* @return void
* @author Guy Hunt
* @since v0.8
*
*/

function dispFltManual($filter, $filter_id)
{
    global $lang, $form_method, $view, $sf_conf_name;
    // handle overlay modes
    // handle overlay modes
    $overlay_inp = mkOverlayInp($sf_conf_name);
    // handle the id
    $ftr_id_inp = mkFtrIdInp($filter_id);
    
    // markup
    $mk_search = getMarkup('cor_tbl_markup', $lang, 'search');
    $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
    $mk_filtertype = getMarkup('cor_tbl_markup', $lang, 'filtertype');
    
    // the dropdown menu
    $dd = ddAlias(FALSE, FALSE, 'cor_tbl_module', $lang, 'key', FALSE, 'code');
    
    // set up a var
    $var = "<label>{$mk_filtertype}{$filter['ftype']}</label>";
    // display stuff
    if (!isset($filter['key'])) {
        $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= $overlay_inp;
        $var .= $ftr_id_inp;
        $var .= "<span class=\"row\">";
        $var .= "<span class=\"input\">$dd</span>";
        $var .= "<span class=\"input\"><button type=\"submit\">";
        $var .= "$mk_go";
        $var .= "</button></span></span></form>";
    } else {
        $alias = getAlias('cor_tbl_module', $lang, 'itemkey', $filter['key'].'_cd', 1);
        $var .= "<label>Arg1: $alias</label>";
    }

    if (!isset($filter['val_list']) and isset($filter['key'])) {
        // sort out the mod
        $mod = $filter['key'];
        if (is_numeric($mod)) {
            // Get the code we need
            $mod = getSingle('shortform', 'cor_tbl_module', "id = $mod");
        }
        // ARG 2 - The val_list
        // make the form
        $var .= "<form method=\"$form_method\" action=\"{$_SERVER['PHP_SELF']}\">";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= $overlay_inp;
        $var .= $ftr_id_inp;
        $var .= "<span class=\"row\">";
        $var .= "<span class=\"input\"><textarea name=\"val_list\" rows=\"8\" cols=\"40\"></textarea></span>";
        $var .= "<span class=\"input\"><button type=\"submit\">$mk_search</button></span>";
        $var .= "</span>";
        $var .= "</form>";
    } elseif (isset($filter['val_list'])) {
        $var .= "<label>Arg2: {$filter['val_list']}</label>";
    }
    // OUTPUT the var
    echo $var;
    // DELETE option
    if (!$overlay_inp) {
        echo dispDelOp($filter_id);
    }
}

// }}}
// {{{ verAddFtr()

/**
* verifies a filter and adds it to the filters array
* 
* @param array $filters - the existing array of filters
* @param array $filter  the filter
* @param string $filter_id  the filter id
* @param string $num_elements  the number of elements (not including OPs)
* @access public
* @author Guy Hunt
* @since 0.5.1
*
* Note: Function tidied up and documented at v1.1 by GH, but existed since
*  at least v0.5
*
* Note 2: Function no ignores any optional "op_" elements in the array
*
*/

function verAddFtr($filters, $filter, $ftr_id, $num_elements)
{
    // count the non op_ elements of the array
    $i = 0;
    foreach ($filter as $arg_name => $arg) {
        if (substr($arg_name, 0, 3) != 'op_') {
            $i++;
        }
    }
    // verify filter complete
    if ($i == $num_elements) {
        // add the filter to the end position in the array
        $filters[] = $filter;
        // clear the temp filter off the filters
        unset ($filters[$ftr_id]);
        // return
        return($filters);
    } else {
        return(FALSE);
    }
}

// }}}


// --------------- //
// 2 - GENERAL FNC //
// --------------- //

// {{{ prcsHits()
        
/**
* processes hits into a properly formed results array
* 
* @param array $hits  the hits array
* @return array $result_array  the properly formed results_array.
* @access public
* @author Guy Hunt
* @author Stuart Eve
* @since 0.5.1
*/

function prcsHits($hits)
{
    global $authitems, $traverse_to;
    // 1 - handle 'traverse XMI' requests this is a pre-process and will add overhead
    if (!isset($traverse_to)||$traverse_to=='FALSE') {
        $traverse_to = FALSE;
    }
    foreach ($hits as $key => $hit) {
        if (!isItemKey($hit['itemkey'])) {
            //we are probably dealing with a chain
            $chain = getChFullUp($hit['itemkey'], $hit['itemvalue']);
            if (array_key_exists('head',$chain)) {
                $itemkey = $chain['head']['key'];
                $itemvalue = $chain['head']['value'];
                $hit['itemkey'] = $itemkey;
                $hit['itemvalue'] = $itemvalue;
            }
        }
        if ($traverse_to) {
            if ($hit['itemkey'] != $traverse_to) {
                $trav_to_mod = substr($traverse_to, 0, 3);
                $trav_end = getXmi($hit['itemkey'], $hit['itemvalue'], $trav_to_mod);
                if ($trav_end) {
                    if (count($trav_end) > 1) {
                        foreach ($trav_end as $end_key => $end_pt) {
                            // update this hit for this end point
                            $hit['keyvalpr'] = $end_pt['xmi_itemkey'].$end_pt['xmi_itemvalue'];
                            $hit['itemkey'] = $end_pt['xmi_itemkey'];
                            $hit['itemvalue'] = $end_pt['xmi_itemvalue'];
                            // update the hits array with the revised hit
                            $hits[] = $hit;
                        }
                        // remove the original hit
                        unset ($hits[$key]);
                    } else {
                        // update the hit with the new end point
                        $hits[$key]['keyvalpr'] = $trav_end[0]['xmi_itemkey'].$trav_end[0]['xmi_itemvalue'];
                        $hits[$key]['itemkey'] = $trav_end[0]['xmi_itemkey'];
                        $hits[$key]['itemvalue'] = $trav_end[0]['xmi_itemvalue'];
                    }
                } else {
                    // discard this hit because there is no linkage to the traverse to module
                    unset($hits[$key]);
                }
            }
        }
    }
    // 2 - Process the hits array
    // loop over each hit processing as required
    foreach ($hits as $hit) {
        $itemkey = $hit['itemkey'];
        $itemvalue = $hit['itemvalue'];
        //check to see if this is chained - if it is then traverse chain until you hit the parent item
        if (!isItemKey($itemkey)) {
            //we are probably dealing with a chain
            $chain = getChFullUp($itemkey, $itemvalue);
            if (array_key_exists('head',$chain)) {
                $itemkey = $chain['head']['key'];
                $itemvalue = $chain['head']['value'];
                $hit['itemkey'] = $itemkey;
                $hit['itemvalue'] = $itemvalue;
            }
        }
        // process the hit
        if (array_key_exists($itemkey, $authitems)) {
            // check if the hit is authorised
            if (in_array($itemvalue, $authitems[$itemkey])) {
                // make up the snippet
                $newsnip = 
                    array(
                        'type' => $hit['type_alias'],
                        'snip' => $hit['frag'],
                        'class' => $hit['frag_class']
                );
                // Check to see if this itemkey=itemvalue pair is already in the results array
                if (isset($results_array) AND array_key_exists($hit['keyvalpr'], $results_array)) {
                    // if it is: increment the score and add the frag to the snippets
                    //     make up and edit the existing row
                    $results_array[$hit['keyvalpr']]['snippets'][] = $newsnip;
                    $results_array[$hit['keyvalpr']]['score'] = $results_array[$hit['keyvalpr']]['score']+$hit['score'];
                } else {
                    // if it isnt: insert a new entry for it
                    //  make up and insert the record
                    $new_key = $hit['itemkey'].$hit['itemvalue'];
                    $results_array[$new_key] = 
                    array(
                        'itemkey' => $hit['itemkey'],
                        'itemval' => $hit['itemvalue'],
                        'score' => $hit['score'],
                        'snippets' => array($newsnip)
                    );
                }
                unset ($newsnip);
            }
        }
    }
    if (isset($results_array)) {
        return ($results_array);
    }
}

// }}}

// }}}
// {{{ prcsHitsMod()
        
/**
* processes hits into a properly formed results array limiting the results to a single mod
* 
* @param array $hits  the hits array
* @param string $mod  the mod to limit to
* @return array $result_array  the properly formed results_array.
* @access public
* @author Guy Hunt
* @author Stuart Eve
* @since 0.5.1
*
* NOTE: This is NOT the preferred method. The correct method is to use two filters to
* achieve this result. This is a specialised function for the mini search
*/

function prcsHitsMod($hits, $mod)
{
    global $authitems;
    // catch empty sets
    $results_array = FALSE;
    $mod_short = substr($mod, 0, 3);
    // loop over each hit processing as required
    // allow the admin to specify fields to put at the top of every result (meta about that item)
    $meta_fields_name = 'conf_'.$mod_short.'_res_meta_fields';
    include ("config/settings.php");
    include ("config/field_settings.php");
    include ("config/mod_{$mod_short}_settings.php");
    if (isset($$meta_fields_name)) {
        $meta = $$meta_fields_name;
        $meta_fields = $meta['fields'];
    } else {
        $meta_fields = FALSE;
    }
    // silently process the meta fields if needed
    if (is_array($meta_fields)) {
        $meta_fields = resTblTh($meta_fields, 'silent');
    }
    // now iterate over each hit
    foreach ($hits as $hit) {
        $itemkey = $hit['itemkey'];
        $itemvalue = $hit['itemvalue'];
        // check if the hit is authorised
        if (in_array($itemvalue, $authitems[$itemkey]) && $itemkey == $mod) {
            // make up the snippet
            $newsnip = 
                array(
                    'type' => $hit['type_alias'],
                    'snip' => $hit['frag'],
                    'class' => $hit['frag_class']
            );
            // Check to see if this itemkey=itemvalue pair is already in the results array
            if ($results_array AND array_key_exists($hit['keyvalpr'], $results_array)) {
                // if it is: increment the score and add the frag to the snippets
                //     make up and edit the existing row
                $results_array[$hit['keyvalpr']]['snippets'][] = $newsnip;
                $results_array[$hit['keyvalpr']]['score'] = $results_array[$hit['keyvalpr']]['score']+$hit['score'];
            } else {
                // if it isnt: insert a new entry for it
                //  make up and insert the record
                $new_key = $hit['itemkey'].$hit['itemvalue'];
                // allow meta fields for each result item (see above)
                if (is_array($meta_fields)) {
                    unset($meta);
                    $meta = array();
                    // get the relevant data
                    foreach ($meta_fields as $key => $field) {
                        // get the alias and value for this field
                        $meta_val = resTblTd($field, $hit['itemkey'], $hit['itemvalue']);
                        if ($meta_val) {
                            $meta_alias = $field['field_alias'];
                            $meta[] =
                                array(
                                    'meta_alias' => $meta_alias,
                                    'meta_val' => $meta_val,
                            );
                        }
                    }
                } else {
                    $meta = FALSE;
                }
                $results_array[$new_key] = 
                    array(
                        'itemkey' => $hit['itemkey'],
                        'itemval' => $hit['itemvalue'],
                        'item_meta' => $meta,
                        'score' => $hit['score'],
                        'snippets' => array($newsnip)
                );
            }
            unset ($newsnip);
        }
    }
    return ($results_array);
}

// }}}
// getFtr()
//  To return a filter
//
// Funtion takes the following args:
//     $id - the id of the filter in question

// {{{ getFtr()
        
/**
* returns a filter from the database
* 
* @param integer $id  the id of the filter 
* @return array $filter  an array containing the nickname of the filter
* @access public
* @author Guy Hunt
* @since 0.6
*/

function getFtr($id) {

  $row = getRow('cor_tbl_filter', $id);

  if($row){
     // unserialize the stored filter
     $filter = unserialize($row['filter']);
     // add in its nickname
     $filter['nname'] = $row['nname'];
     // add in its creator id
     $filter['cre_by'] = $row['cre_by'];
     // return it
     return($filter);
  }else{

     return FALSE;

  }

}

// }}}
// {{{ addFtr()

/**
* addFtr()
*
* adds a filter to the database
*
* @param array $filter  the filter itself
* @param string $type  indicates whether the filter is a 'set' or 'single'
* @param string $nname  a string to display as a nickname for this once saved
* @param int $sgrp  a number indicating the group that has access to this
* @param int $cre_by  the user id of the creator
* @return int $new_id  the new id of the filter
* @author Guy Hunt
* @since v0.7
*
* Note: This was added at v0.7 to inherit the add functionality of the edtFtr()
* function. This brings it in line with the other ARK add/edt/del db functions
*
*/

function addFtr($filter, $type, $nname, $sgrp, $cre_by)
{
    // serialize the filter for storage
    $filter = serialize($filter);
    $cre_on = dbTimestamp();
    $table = 'cor_tbl_filter';
    $fields = array('filter', 'type', 'nname', 'sgrp', 'cre_by', 'cre_on');
    $values = array($filter, $type, $nname, $sgrp, $cre_by, $cre_on);
    $logtype = 'addalias';
    $results = dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
    return $results['new_id'];
}
// }}}
// {{{ edtFtr()

/**
* edtFtr()
*
* edits a filter in the database
*
* @param array $filter  a valid Ark filter array
* @param string $nname  a string to display as a nickname for this once saved
* @param int $sgrp  a number indicating the group that has access to this
* @param int $f_id  the id of the filter
* @return array $success  a standard ARK success array
* @author Guy Hunt
* @since v0.5
*
* Note 1: As of v0.7 to this looses add and del functionality which moves to
* dedicated functions. This brings it in line with the other ARK add/edt/del
* db functions
*
* Note 2: NB - VALIDATE your data BEFORE calling this function please
*
*/

function edtFtr($filter, $nname, $sgrp, $f_id)
{
    global $db;
    // serialize the filter array for storage
    $filter = serialize($filter);
    // create some SQL
    $sql = "
        UPDATE cor_tbl_filter
        SET filter = ?, nname = ?, sgrp = ?
        WHERE id = ?
    ";
    $params = array($filter,$nname,$sgrp,$f_id);
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // provide feedback
    $rows = $sql->rowCount();
    if ($rows == 1) {
        $results['success'] = TRUE;
        $results['rows'] = $rows;
    }else {
        $results['success'] = FALSE;
    }
}

// }}}
// {{{ delFtr()

/**
* delFtr()
*
* removes a filter from the database
*
* @param array $f_id  the filter id
* @return array $success  a standard ARK success array
* @author Guy Hunt
* @since v0.7
*
* Note: This was added at v0.7 to inherit the del functionality of the edtFtr()
* function. This brings it in line with the other ARK add/edt/del db functions
*
*/

function delFtr($f_id)
{
    global $db;
    // create some SQL
    $sql = "
        DELETE FROM cor_tbl_filter
        WHERE id = ?
    ";
    $params = array($f_id);
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    // handle feedback
    $rows = $sql->rowCount();
    if ($rows == 1) {
        $results['success'] = TRUE;
        $results['rows'] = $rows;
    }else {
        $results['success'] = FALSE;
    }
}
// }}}

// filterUrl()
//  To turn a filter into a url
//
// Funtion takes the following args:
//     $filter - the filter to transform

function filterUrl($filter) {

$nname = $filter['nname'];
unset ($filter['nname']);
$nname = str_replace(" ", "_", $nname);

$url = 'nname='.$nname;

foreach ($filter AS $key => $var) {

$url = $url.'&amp;'.$key.'='.$var;

}

return ($url);

}


// dispSaveOp()
//  To display the save filter form
//
// Funtion takes the following args:
//     $filter_id - the filter to save (id from the filters array not the db)

function dispSaveOp($filter_id, $target = FALSE)
{
    global $lang, $form_method;
    $mk_save = getMarkup('cor_tbl_markup', $lang, 'save');
    // see if this is numeric. should be an id, but may be the keyword 'set' for a filterset
    if (is_int($filter_id)) {
        $filter_id = 'id_'.$filter_id;
    }
    if ($target){
        $action = $target;
    } else {
        $action = $_SERVER['PHP_SELF'];
    }
    $var = "<form id=\"save_ftr_frm\" method=\"$form_method\" action=\"$action\">";
    $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
    $var .= "<input type=\"hidden\" name=\"output_mode\" value=\"table\" />";
    $var .= "<input type=\"hidden\" name=\"saveftr\" value=\"$filter_id\" />";
    $var .= "<span>";
    $var .= "<span class=\"input\"><input type=\"text\" name=\"nname\" value=\"\" style=\"width:35%\" /></span>";
    $var .= "<span class=\"input\"><button id=\"save_ftr_btn\" type=\"submit\">$mk_save</button></span>";
    $var .= "</span></form>";
    return $var;
}

// {{{ countFilters()

/**
* counts the completed filters in a filters array
*
* @param array $filters  the filters array
* @return string $num  the number
* @author Guy Hunt
* @since v0.9
*
*/

function countFilters($filters)
{
    if ($filters) {
        foreach($filters as $key => $filter) {
            if (!is_int($key)) {
                unset($filters[$key]);
            }
        }
        return count($filters);
    } else {
        return 0;
    }
}

// }}}
// {{{ mkOverlayInp()

/**
* makes a code snippet to handle lightbox overlay code
*
* @param string $sf_conf_name  the name of the sf_conf array
* @param string $mode  form for forms and href for hrefs
* @return string $var  html snippet or FALSE
* @author Guy Hunt
* @since v0.9
*
*/

function mkOverlayInp($sf_conf_name, $mode=FALSE)
{
    if ($sf_conf_name) {
        // if there is an sf_conf_name then this is an overlay try to get the lboxreload param from live
        global  $lboxreload;
        switch ($mode) {
            case 'href':
                $overlay_inp = "sf_conf=$sf_conf_name";
                $overlay_inp .= "&amp;lboxreload=$lboxreload";
                break;
                
            case 'form':
            default:
                $overlay_inp = "<input type=\"hidden\" name=\"sf_conf\" value=\"$sf_conf_name\" />";
                $overlay_inp .= "<input type=\"hidden\" name=\"lboxreload\" value=\"$lboxreload\" />";
                break;
        }
        return $overlay_inp;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ mkFtrIdInp()

/**
* makes a code snippet to handle filter ids
*
* @param string $ftr_id  the id
* @param string $mode  form for forms and href for hrefs
* @return string $var  html snippet or FALSE
* @author Guy Hunt
* @since v0.9
*
*/

function mkFtrIdInp($ftr_id, $mode=FALSE)
{
    if ($ftr_id) {
        switch ($mode) {
            case 'href':
                $ftr_id_inp = "ftr_id=$ftr_id";
                break;
                
            case 'form':
            default:
                $ftr_id_inp = "<input type=\"hidden\" name=\"ftr_id\" value=\"$ftr_id\" />";
                break;
        }
        return $ftr_id_inp;
    } else {
        return FALSE;
    }
}

// }}}
// {{{

/**
* displays a delete link for filter builder functions
*
* @param string $filter_id  the id number of the filter
* @return string $del_op  a resolved XHTML string
* @author Guy Hunt
* @since 0.4
*
*/

function dispDelOp($filter_id)
{
    global $lang, $skin_path;
    $del_op = "<span class=\"del_op\">";
    $del_op .= "<a href=\"{$_SERVER['PHP_SELF']}?";
    $del_op .= "resetftr=id_$filter_id\">";
    $del_op .= "<img src=\"$skin_path/images/plusminus/bigminus.png\" alt=\"[-]\" class=\"med\" />";
    $del_op .= "</a></span>";
    return($del_op);
}

// }}}
// {{{ dispSetOperator

/**
* returns the set operator for the given filter
*
* @param array $filter  the filter
* @return string $set_op  a resolved XHTML string
* @author Guy Hunt
* @since 0.8
*
*/

function dispSetOperator($filter, $filter_id)
{
    global $skin_path;
    // Set up the defaults
    $intersect_class = "intersect_off";
    $complement_class = "complement_off";
    $union_class = "union_off";
    // set up the current case
    $set_operator = $filter['set_operator'];
    switch ($set_operator) {
        case 'intersect':
            $intersect_class = "intersect_on";
            break;
            
        case 'complement':
            $complement_class = "complement_on";
            break;
            
        case 'union':
            $union_class = "union_on";
            break;
            
        default:
            echo "ADMIN ERROR: Something went wrong in dispSetOperator<br/>";
            break;
    }
    // Assemble output
    $set_op = "<span class=\"filter_set_operator\">";
    // intersect
    $set_op .= "<a class=\"$intersect_class\" href=\"{$_SERVER['PHP_SELF']}?";
    $set_op .= "chg_ftr_id=$filter_id&amp;chg_set_op=intersect\">";
    $set_op .= "<img src=\"$skin_path/images/filters/{$intersect_class}.png\" alt=\"[-]\" title=\"{$intersect_class}\"/>";
    $set_op .= "</a>\n";
    // complement
    $set_op .= "<a class=\"$complement_class\" href=\"{$_SERVER['PHP_SELF']}?";
    $set_op .= "chg_ftr_id=$filter_id&amp;chg_set_op=complement\">";
    $set_op .= "<img src=\"$skin_path/images/filters/{$complement_class}.png\" alt=\"[-]\" title=\"{$complement_class}\"/>";
    $set_op .= "</a>\n";
    // union
    $set_op .= "<a class=\"$union_class\" href=\"{$_SERVER['PHP_SELF']}?";
    $set_op .= "chg_ftr_id=$filter_id&amp;chg_set_op=union\">";
    $set_op .= "<img src=\"$skin_path/images/filters/{$union_class}.png\" alt=\"[-]\" title=\"{$union_class}\"/>";
    $set_op .= "</a>\n";
    // close the holder
    $set_op .= "</span>\n";
    // return the var
    return($set_op);
}

// }}}
// {{{ mkFtrModeNav()

/**
* makes a nav used to set the view mode of the filter panel
*
* @param string $view  the view mode
* @return $var string  the nav xhtml
* @author Guy Hunt
* @since v0.8
*
*
*/

function mkFtrModeNav($ftr_mode)
{
    global $lang, $conf_data_viewer;
    if (!$ftr_mode) {
        $ftr_mode = 'standard';
        echo 'ADMIN ERROR: no valid $view is set';
    }
    $var = "<div id=\"ftr_mode_nav\">\n";
    switch ($ftr_mode) {
        case 'basic':
            $var .= "<a href=\"$conf_data_viewer?ftr_mode=standard&amp;disp_mode=table\">Filter these results</a>\n";
            break;
        case 'standard':
            $var .= "<a href=\"$conf_data_viewer?ftr_mode=advanced\">Advanced options</a>\n";
            break;
        case 'advanced':
            $var .= "<a href=\"$conf_data_viewer?ftr_mode=standard\">Standard options</a>\n";
            break;
    }
    $var .= "</div>\n";
    return $var;
}

// }}}
// {{{ resIntersect()

/**
* intersects results arrays in a similar way that the array_intersect() PHP function should
*
* @param array $arr1  the first array
* @param array $arr2  the second array
* @return array $res  the joined results array
* @author Guy Hunt
* @since 0.4
*
* Note: Bear in mind that this function expects ARK standard results arrays not
* any old multidim array.
*/

function resIntersect($arr1, $arr2)
{
    // setup the res array
    $res = array();
    // loop over the first array
    foreach($arr1 as $key => $value) {
        if (array_key_exists($key, $arr2)) {
            // this puts snippets from the element in arr2 into the element in arr1
            foreach ($arr2[$key]['snippets'] as $snip) {
                array_push($arr1[$key]['snippets'], $snip);
            }
            // this combines the scores
            $arr1[$key]['score'] = $arr1[$key]['score']+$arr2[$key]['score'];
            // this puts the element into the return array
            $res[$key] = $arr1[$key];
        }
    }
    return $res;
}

// }}}
// {{{ resComplement()

/**
* produces the complement (set theory for 'subtract') of two result sets
*
* @param array $arr1  the first ARK standard results_array
* @param array $arr2  the second ARK standard results_array
* @return array $arr1  the resulting (reduced) ARK standard results_array
* @author Guy Hunt
* @since v0.8
*
*/

function resComplement($arr1, $arr2)
{
    // loop over the second array
    foreach($arr1 as $key => $value) {
        // if it is present, unset it
        if (array_key_exists($key, $arr2)) {
            unset($arr2[$key]);
        }
    }
    return $arr2;
}

// }}}
// {{{ resIntersectSimple()

/**
* intersects multidim arrays
*
* @param array $arr1  the first array
* @param array $arr2  the second array
* @return array $res  the intersected array
* @author Guy Hunt
* @since v0.5
*
* Note: Something similar to this should be available as a PHP native function
* from PHP5 onwards. Check to see if this is now obsolete
*
*/

function resIntersectSimple($arr1, $arr2)
{
    $res = array();
    foreach($arr1 as $key=>$value) {
        $push = true;
        for ($i = 1; $i < func_num_args(); $i++) {
            $actArray = func_get_arg($i);
            if (gettype($actArray) != 'array') return false;
            if (!array_key_exists($key, $actArray)) $push = false;
        }
        if ($push) {    
            // This to put the element into the return array
            $res[$key] = $arr1[$key];
        }
    }
    return $res;
}

// }}}
// {{{ resUnion()

/**
* unions two results sets
*
* @param array $arr1  the first array
* @param array $arr2  the second array
* @return array $res  the returned array
* @author Guy Hunt
* @since v0.8
*
* In this case, we want to return a single unified array of all the results
* from both arrays. In the case of having results in both, we need to add the
* hits together.
*
*/

function resUnion($arr1, $arr2)
{
    // setup the res array
    $res = $arr2;
    // loop over the first array
    foreach($arr1 as $key => $value) {
        // if the item is already in the array, combine it
        if (array_key_exists($key, $arr2)) {
            // this puts snippets from the element in arr2 into the element in arr1
            foreach ($arr2[$key]['snippets'] as $snip) {
                array_push($arr1[$key]['snippets'], $snip);
            }
            // this combines the scores
            $arr1[$key]['score'] = $arr1[$key]['score']+$arr2[$key]['score'];
            // this puts the element into the return array
            $res[$key] = $arr1[$key];
        // otherwise just add it in
        } else {
            $res[$key] = $arr1[$key];
        }
    }
    return $res;
}

// }}}

?>
