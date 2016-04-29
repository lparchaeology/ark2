<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/settings/server.php
*
* Environment specific settings file for this version of ARK
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2012  L - P : Heritage LLP.
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
* @category   admin
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     John Layt <john@layt.net>
* @copyright  1999-2016 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/php/settings/server.php
* @since      2.0
*
* Copy this file from php/settings/server.php to config/database.php and configure as required
*
* Documentation: http://ark.lparchaeology.com/wiki/index.php/Env_settings.php
*
*/

// -- SERVER SPECIFIC SETTINGS -- //
// Modify this path for your server configuration
// This should be the only change required for a default ARK install

// The server absolute file path to the ark install directory
// Do not include the trailing directory separator
// Linux
//$ark_root_dir = '/srv/www/htdocs/ark';
// Mac or Mamp
//$ark_root_dir = substr(__DIR__,0,-7);
// Mamp
$ark_root_dir = '/Applications/MAMP/htdocs/ark2';
// Windows
//$ark_root_dir = 'C:\ms4w\Apache\htdocs\ark'

// The folder name of THIS instance of ARK (relative to the domain)
$ark_root_path = '/ark2'; // ARK is in subdir of domain root
//$ark_root_path = ''; // ARK is in the domain root

// MYSQL DATABASE CONNECTION

// The mysqlserver
$sql_server = 'localhost:8889';
// The mysql db name of this instance of ark
$ark_db = 'ark_minories';
// The mysql user who will make all the db calls
$sql_user = 'ark_user';
// The mysql user's password
$sql_pwd = 'arkpass';
// DSN (this shouldn;t need adjusting)
$dsn = 'mysql://'.$sql_user.':'.$sql_pwd.'@'.$sql_server.'/'.$ark_db;

?>
