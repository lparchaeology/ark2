<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* auth/auth_functions.php
*
* holds all of the functions related to auth within ARK
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
* @category   auth
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/auth/auth_functions.php
* @since      File available since Release 0.6
*/

// {{{ getPermUserId()
        
/**
* retrieves the permUserId from the liveuser tables. Use this function
* when you need to know what a ARK user id is when mapped to the
* liveuser tables.
* 
* @param integer $user_id  the id you are looking for (this is the id of the user id cor_tbl_users)
* @param string $auth_container  this is the auth container that the id relates to. 
*                The default value is ARK_USERS
* @return integer $perm_user_id  the perm user id or FALSE on failure.
* @access public
* @author Stuart Eve
* @since 0.6
*/

function getPermUserId($user_id,$auth_container = 'ARK_USERS')
{
    //first get the liveuser perm_user_id
    $sql = "
        SELECT perm_user_id 
        FROM cor_lvu_perm_users 
        WHERE auth_user_id=? 
        AND auth_container_name=?
    ";
    $params = array($user_id, $auth_container);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $perm_user_id = $row['perm_user_id'];
        return $perm_user_id;
    } else {
        return FALSE;
    }
}

// }}}
// {{{ getAuthItems()

/**
* creates an array containing the items that the user is able to view. If the item is
* not in the array then the user will not be able to view/edit it.
* 
* @param array $filter  OPTIONAL a results_array from the result of a filter or filterset
*                       this will be cleaned and returned as a properly formed authitems array       
* @return array $authitems  array containing all of the authorised items
* @access public
* @author Stuart Eve
* @since 0.6
*
* NOTE: This replaced an inc_script at v0.6. Obsolete inc_script was only removed in v1.1 GH 20/4/2012
*
* NOTE: At v1.1 the params on this function were changed to remove an obsolete option called 'modules'.
* this legacy option allowed admins to specify a restricted set of modules instead of a proper sfilter.
* As sfilters can accomplish this, the option has been removed. GH 20/4/2012
*
*/

function getAuthItems($filter_results = FALSE)
{
    global $loaded_modules, $user_id;
    // if filter results_array has been sent pre-process it
    if ($filter_results) {
        // put results into the authitems array
        $authitems = $filter_results;
        // set up this cre by clause to restrict the subsequent $loaded_modules to items
        // owned by this user
        $where_cre_by = "WHERE cre_by = $user_id";
    } else {
        // if filter results are not in play, don't bother with this where clause
        $where_cre_by = FALSE;
    }
    // foreach through the loaded_modules creating the authitems array
    foreach ($loaded_modules as $module) {
        // set up a couple of handy vars
        $table = $module.'_tbl_'.$module;
        $itemkey = $module . '_cd';
        // prepare the SQL statement
        $sql = "
            SELECT $itemkey FROM $table $where_cre_by 
            ORDER BY $itemkey
        ";
        $params = array();
        
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        // Run the query
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        
        // Handle results for this module
        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            do {
                $authitems[$itemkey][] = $row[$itemkey];
            } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
        }
    }
    // post process the authitems array and return
    if (isset($authitems)) {
        // Sort the array
        // foreach through the array sorting the arrays
        foreach ($authitems as $key => $items) {
            natsort($authitems[$key]);
            // natsort retains the original key association which we don't want
            $authitems[$key] = array_values($authitems[$key]);
        }
        return $authitems;
    } else {
        return FALSE;
    }
}

//}}}
// {{{ getSfilter()
        
/**
* checks if a security filter is set for the user and if so it runs the filter and returns 
* the results array. This can then be sent to the getAuthItems function.
* 
* @param integer $sfilter_id the id of the security filter for that user
*
* @return array $filter_results  array formulated as a results_array
* @access public
* @author Stuart Eve
* @since 0.6
*/

function getSfilter($sfilter_id)
{
    //get the filter array
    $sfilter = getFtr($sfilter_id);
    if ($sfilter) {
        foreach ($sfilter AS $ftr_id => $filter) {
            if (is_int($ftr_id)) {
                $ftype = $filter['ftype'];
                // run the relevant filter
                $func = 'execFlt'.$ftype;
                if (isset($results_array) && $new_res = $func($filter,1)) {
                    $results_array = resIntersectSimple($new_res, $results_array);
                } else {
                    $results_array = $func($filter,1);
                }
                unset($func);
            }
        }
        foreach($results_array as $key => $result) {
            $itemkey = $result['itemkey'];
            $filter_results[$itemkey][] = $result['itemvalue'];
        }
        return $filter_results;    
    } else {
        return FALSE;
    }
}

//}}}
?>
