<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkdb/config/paths.php
*
* Environment specific config file for this install of ARK
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
* @link       http://ark.lparchaeology.com/code/php/settings/server.php
* @since      2.0
*
*/

include('config/server.php');

// -- DEFAULT SERVER PATHS -- //
// You should not need normally to edit these settings
// * All variables ending in _dir are absolute paths to directories in the filesystem
// * All variables endign in _path are URL paths relative to the hostname
// None of these paths should end in a directory separator

// ROOT PATHS
// The path to the installed external libraries
$ark_lib_dir = $ark_root_dir.'/lib';
$ark_lib_path = $ark_root_path.'/lib';

// INSTALLED PACKAGES
// The path to the PEAR installation
$pear_path = $ark_lib_dir.'/php/pear';
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.$pear_path);
// The path to phMagick, comment this out to turn off image conversion
$phmagick_file = $ark_lib_dir.'/php/phmagick/phmagick.php';

// GENERAL PATHS
// Skins are stored in this folder
$ark_skins_dir = $ark_root_dir.'/skins';
$ark_skins_path = $ark_root_path.'/skins';
// Files are stored in this folder
$registered_files_dir = $ark_root_dir.'/data/files';
$registered_files_path = $ark_root_path.'/data/files';
// Folder where uploads are stored by file processes. This is browsable on batch uploads.
$default_upload_dir = $ark_root_dir.'/data/uploads';
// Exported files directory
$export_dir =  $ark_root_dir.'/data/tmp';

// MAPPING DIRECTORIES
// Path to temp directory (server)
$ark_maptemp_dir = $ark_root_dir.'/mapserver/tmp';
// Path to temp directory (web)
$ark_maptemp_path = '/mapserver/tmp';
// Path to OpenLayers on local or remote server
// $openlayers_path = $ark_lib_path.'/js/openlayers/OpenLayers.js';
$openlayers_path = 'http://openlayers.org/api/OpenLayers.js"></script><script src="'.$ark_lib_path.'/js/openlayers/deprecated.js';
// Path to WMS mapfile (server) if using mapserver via the ark_wxs_server.php script
$ark_wms_map = $ark_root_dir.'/config/ark.map';
// Path to WFS mapfile (server) if using mapserver via the ark_wxs_server.php script
$ark_wfs_map = $ark_root_dir.'/config/ark.map';

?>
