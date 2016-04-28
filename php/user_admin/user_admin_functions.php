<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* user_admin_functions.php
*
* Take care to consider where would be the best place for you function.
* Only include it in here if it is genuinely related to user admin.
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
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Andy Dufton <a.dufton@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/global_functions.php
* @since      File available since Release 1.0
*/

// {{{ chkDupUsr()

/**
* checks a username is unique
*
* @param string $username the new username
* @return boolean $result returns TRUE if duplicate found
* @author Andy Dufton
* @since 1.0
*
*/

function chkDupUsr($username)
{
    $sql = "
        SELECT id
        FROM cor_tbl_users
        WHERE username = ?
    ";
    $params = array($username);

    //Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    if ($sql->rowCount() > 0) {
        return(TRUE);
    } else {
        return(FALSE);
    }
}

//}}}
// {{{ chkDupInit()

/**
 * checks if initials are unique
 *
 * @param string $init the new initials
 * @return boolean $result returns TRUE if duplicate found
 * @author Mike Johnson (m.johnson@lparchaeology.com)
 * @since 1.2
 *
 */

function chkDupInit($init)
{
    $sql = "
        SELECT initials
        FROM cor_tbl_users
        WHERE initials = ?
    ";
    $params = array($init);

    //Run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    if ($sql->rowCount() > 0) {
        return(TRUE);
    } else {
        return(FALSE);
    }
}

//}}}
//{{{ makeUsrname()
    
/**
* makes username for cor_tbl_users
*
* @param string $firstname user first name
* @param string $lastname user last name
* @param string $init user initials
* @param string $type optional type of username to create- set
*                     as 'simple' by default for form lastname_init
* @return string $username username value
* @author Guy Hunt
* @since 0.2
*
*/

function makeUsrname($firstname, $lastname, $init, $type)
{
    // make lastname and initials lowercase
    $lastname = strtolower($lastname);
    $init = strtolower($init);
    // clean any spaces in last name
    $lastname = str_replace (' ', '_', $lastname);
    if ($type == 'simple') {
        $username = $lastname.'_'.$init;
    }
    return($username);
}

//}}}

?>
