<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* conf.php
*
* LiveUser conf
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with 
*    archaeological data.
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
* @copyright  1999-2011 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/trunk/php/auth/liveuser/conf.php
* @since      File available since Release 0.6
*
*/

require_once 'MDB2.php';
require_once 'LiveUser.php';
require_once 'LiveUser/Admin.php';

// Plase configure the $dsn in your environment settings
// eg:
//$dsn = '{dbtype}://{user}:{passwd}@{dbhost}/{dbname}';
//$dsn = 'mysql://sql_php_user:test@localhost/fasti_db2';

$auth_db = MDB2::connect($dsn);

if (PEAR::isError($auth_db)) {
    echo $auth_db->getMessage() . ' ' . $auth_db->getUserInfo();
}

$auth_db->setFetchMode(MDB2_FETCHMODE_ASSOC);

include_once('liveuser_rights.php');


$lu_conf =
    array(
             'firstname' => '',
             'lastname' => '',
             'initials' => '',
             'sfilter' => '',
             'email' => '',
        'debug' => true,
        'session'  => array(
            'name'     => 'PHPSESSION',
            'varname'  => 'ludata'
        ),
        'login' => array(
            'force'    => false,
        ),
        'logout' => array(
            'destroy'  => true,
        ),
        'authContainers' => array(
           
                'ARK_USERS' => array(
                'type'          => 'MDB2',
                'expireTime'    => 2009000,
                'idleTime'      => 2001800,
                     'prefix' => '',
                'storage' => array(
                    'dsn' => $dsn,
                    'alias' => array(
                                  'handle' => 'username',
                                  'passwd' => 'password',
                                  'is_active' => 'account_enabled',
                                  'auth_user_id' => 'id',
                                  'firstname' => 'firstname',
                                  'lastname' => 'lastname',
                                  'initials' => 'initials',
                                  'sfilter' => 'sfilter',
                                  'email' => 'email',
                                  'users' => 'cor_tbl_users',
                    ),
                    'fields' => array(
                                'auth_user_id' => 'integer',
                        'lastlogin' => 'timestamp',
                        'is_active' => 'boolean',
                                'firstname' => 'text',
                                'lastname' => 'text',
                                'initials' => 'text',
                                'sfilter' => 'integer',
                                'email' => 'text',

                    ),
                    'tables' => array(
                        'users' => array(
                            'fields' => array(
                             'is_active' => false,
                                      'firstname' => false,
                                      'lastname' => false,
                                      'initials' => false,
                                      'sfilter' => false,
                                      'email' => false,
                                      'auth_user_id' => false,
                            ),
                        ),
                    ),
                )
            )



        ),
    'permContainer' => array(
        'type' => 'Complex',
        'storage' => array('MDB2' => array('dsn' => $dsn, 'prefix' => 'cor_lvu_')),
    ),
);

?>
