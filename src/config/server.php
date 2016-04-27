<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkdb/config/server.php
*
* Server specific config file for this install of ARK
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Heritage LLP.
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
* @link       http://ark.lparchaeology.com/code/php/arkdb/config/server.php
* @since      2.0
*
*/

// -- SERVER SETTINGS -- //
// Modify these settings for your server configuration
// These should be the only changse required for a default ARK install

// HTTP SERVER SETTINGS
// The absolute file path to the ark install directory
// Do not include the trailing directory separator
// Linux
$ark_root_dir = '/srv/www/htdocs/ark';
// Mac
//$ark_root_dir = substr(__DIR__,0,-7);
// Mamp
//$ark_root_dir = /Applications/MAMP/htdocs/ark;
// Windows
//$ark_root_dir = 'C:\ms4w\Apache\htdocs\ark'

// The URL path to the ARK install relative to the domain hostname
$ark_root_path = '/ark'; // ARK is in subdir of domain root
//$ark_root_path = ''; // ARK is in the domain root

// MYSQL DATABASE CONNECTION
// The mysqlserver
$sql_server = 'localhost';
// The mysql db name of this instance of ark
$ark_db = 'ark';
// The mysql user who will make all the db calls
$sql_user = 'user';
// The mysql user's password
$sql_pwd = 'password';
// DSN (this shouldn;t need adjusting)
$dsn = 'mysql://'.$sql_user.':'.$sql_pwd.'@'.$sql_server.'/'.$ark_db;

?>
