<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/env_settings.php
*
* Environment specific settings file for this version of ARK
*
* PHP versions 4 and 5
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
* @copyright  1999-2012 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/config/env_settings.php
* @since      File available since Release 0.1
*
*
* ARK ships with 3 sample setups for: windows, mac and linux
* First set the server switch to the type of server you are using.
* Second, go through each setting and make sure that the paths are all set up correctly
* for your particular sevrer type.
* 
* Documentation: http://ark.lparchaeology.com/wiki/index.php/Env_settings.php
*
* NOTE: It is possible to add more cases if needed. Just copy the information from 
* another case and ensure the details are correct.
*
*/

// -- SERVER SPECIFIC SETTINGS -- //

// Server type flag:
$server = 'mac';

// Server Specific Settings:
switch($server){
    case 'windows':
        // GENERAL PATHS
        // The folder name of THIS instance of ARK (relative to the domain)
        $ark_dir = '/ark/';
        // The server path to the ark directory
        $ark_server_path = 'C:\ms4w\Apache\htdocs\ark';
        // The path to the PEAR installation
        $pear_path = 'C:\ms4w\Apache\htdocs\ark\lib\php\pear';
        
        // FILE DIRECTORIES
        // Files are stored in this folder. It must be relative to the server's filesystem root (eg. C:).
        $registered_files_dir = $ark_server_path.'\data\files';
        // Path to the files folder relative to this virtual host's docroot
        $registered_files_host = $ark_dir.'data/files/';
        // Folder where uploads are stored by file processes. This is browsable on batch uploads.
        $default_upload_dir = 'C:\ms4w\Apache\htdocs\ark\data\uploads';
        // Exported files directory
        $export_dir = 'C:\ms4w\Apache\htdocs\ark\data\tmp';
        // phMagick comment this in to turn image conversion on. See Documentation.
        // $phMagickDir = $ark_server_path.'\lib\php\phmagick\phmagick.php';
        
        // MAPPING DIRECTORIES
        // Path to temp directory (server)
        $ark_maptemp_dir = 'C:\ms4w\Apache\htdocs\ark\mapserver\tmp';
        // Path to temp directory (web)
        $ark_web_maptemp_dir = '/ark/mapserver/tmp/';
        // Path to OpenLayers on local or remote server
        $openlayers_path = '/ark/mapserver/openlayers_2.10/OpenLayers.js'; // local
        //$openlayers_path = 'http://openlayers.org/api/OpenLayers.js'; // remote
        // Path to WMS mapfile (server) if using mapserver via the ark_wxs_server.php script
        $ark_wms_map = 'C:\ms4w\Apache\htdocs\ark\config\ark.map';
        // Path to WFS mapfile (server) if using mapserver via the ark_wxs_server.php script
        $ark_wfs_map = 'C:\ms4w\Apache\htdocs\ark\config\ark.map';
        
        // FILESYSTEM
        // indicate how paths should be separated
        $fs_path_sep = ';';
        // indicate how folders are spearated in a path
        $fs_slash = '\\';
        
        break;
        
    case 'mac':
        // GENERAL PATHS
        // The folder name of THIS instance of ARK (relative to the domain)
        $ark_dir = '/devtrunk/';
        // The server path to the ark directory
        $ark_server_path = substr(__DIR__,0,-7);
        // The path to the PEAR installation
        $pear_path = $ark_server_path.'/lib/php/pear';
        
        // FILE DIRECTORIES
        // Files are stored in this folder. It must be relative to the server's filesystem root ("/").
        $registered_files_dir = $ark_server_path.'/data/files';
        // Path to the files folder relative to this virtual host's docroot
        $registered_files_host = $ark_dir.'data/files/';
        // Folder where uploads are stored by file processes. This is browsable on batch uploads.
        $default_upload_dir = '/Applications/MAMP/htdocs/trunk/data/uploads';
        // Exported files directory
        $export_dir = '/Applications/MAMP/htdocs/trunk/data/tmp';
        // phMagick comment this in to turn image conversion on. See Documentation.
        $phMagickDir = $ark_server_path.'/lib/php/phmagick/phmagick.php';
        
        // MAPPING DIRECTORIES
        // Path to temp directory (server)
        $ark_maptemp_dir = '/Applications/MAMP/htdocs/'.$ark_dir.'mapserver/tmp';
        // Path to temp directory (web)
        $ark_web_maptemp_dir = 'mapserver/tmp/';
        // Path to OpenLayers on local or remote server
        // $openlayers_path = 'mapserver/openlayers_2.10/OpenLayers.js'; // local
        $openlayers_path = 'http://openlayers.org/api/OpenLayers.js"></script><script src="'.$ark_dir.'lib/js/openlayers/deprecated.js';
        // $openlayers_path = 'http://openlayers.org/api/OpenLayers.js'; // remote
        // Path to WMS mapfile (server) if using mapserver via the ark_wxs_server.php script
        $ark_wms_map = '/Applications/MAMP/htdocs/ark/config/ark.map';
        // Path to WFS mapfile (server) if using mapserver via the ark_wxs_server.php script
        $ark_wfs_map = '/Applications/MAMP/htdocs/ark/config/ark.map';
        
        // FILESYSTEM
        // indicate how paths should be separated
        $fs_path_sep = ':';
        // indicate how folders are spearated in a path
        $fs_slash = '/';
        
        break;
        
    case 'linux':
        // GENERAL PATHS
        // The folder name of THIS instance of ARK (relative to the domain)
        $ark_dir = '/arkv1_1/';
        // The server path to the ark directory
        $ark_server_path = '/srv/www/lparchaeology-vhost-docroot/arkv1_1';
        // The path to the PEAR installation
        $pear_path = $ark_server_path.'/lib/php/pear';
        
        // FILE DIRECTORIES
        // Files are stored in this folder. It must be relative to the server's filesystem root ("/").
        $registered_files_dir = $ark_server_path.'/data/files';
        // Path to the files folder relative to this virtual host's docroot
        $registered_files_host = $ark_dir.'data/files/';
        // Folder where uploads are stored by file processes. This is browsable on batch uploads.
        $default_upload_dir = $ark_server_path.'/data/uploads';
        // Exported files directory
        $export_dir =  $ark_server_path.'/data/tmp';
        // phMagick comment this in to turn image conversion on. See Documentation.
        $phMagickDir = $ark_server_path.'/lib/php/phmagick/phmagick.php';
        
        // MAPPING DIRECTORIES
        // Path to temp directory (server)
        $ark_maptemp_dir = '/srv/www/htdocs/'.$ark_dir.'mapserver/tmp';
        // Path to temp directory (web)
        $ark_web_maptemp_dir = 'mapserver/tmp/';
        // Path to OpenLayers on local or remote server
        // $openlayers_path = $ark_dir.'lib/js/openlayers/OpenLayers.js';
        $openlayers_path = 'http://openlayers.org/api/OpenLayers.js"></script><script src="'.$ark_dir.'lib/js/openlayers/deprecated.js';
        // Path to WMS mapfile (server) if using mapserver via the ark_wxs_server.php script
        $ark_wms_map = '/srv/www/htdocs/ark/config/ark.map';
        // Path to WFS mapfile (server) if using mapserver via the ark_wxs_server.php script
        $ark_wfs_map = '/srv/www/htdocs/ark/config/ark.map';
        
        // FILESYSTEM
        // indicate how paths should be separated
        $fs_path_sep = ':';
        // indicate how folders are spearated in a path
        $fs_slash = '/';
        
        break;
}


// -- NON SERVER SPECIFIC ENVIRONMENT SETTINGS -- //

// MYSQL DATABASE CONNECTION
// The mysqlserver
$sql_server = 'localhost';
// The mysql db name of this instance of ark
$ark_db = 'ark1_2_fieldwalking';
// The mysql user who will make all the db calls
$sql_user = 'arkuser';
// The mysql user's password
$sql_pwd = 'password';

?>