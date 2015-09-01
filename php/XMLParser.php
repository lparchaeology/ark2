<?
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* 
*
* XMLParser.php
*
* this script requests a remote XML document and parses it - it is used for the WMS/WFS mapping
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with
*    archaeological data
*    Copyright (C) 2007  L - P : Partnership Ltd.
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
* @copyright  1999-2007 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/XMLParser.php
* @since      File available since Release 0.6
*/

// INCLUDES
include_once ('global_functions.php');
include_once ('../config/settings.php');
include_once ('map_admin/map_admin_functions.php');
include_once ('map/map_functions.php');
$db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
// SESSION Start the session
// Start the session
session_name($ark_name);
session_start();

// PHP settings 
ini_set('include_path', ini_get('include_path').':/usr/share/php5/PEAR');

// MANUAL vars needed in this page
$pagename = 'XMLParser';

// REQUEST vars needed in this page
$lang = reqArkVar('lang', $default_lang);
$view = reqArkVar('view');

//this script is normally called by an asynchronous JS call
//it needs 2 variables the url of the remote host and the type of XML to expect

$extra_params = array();
$type = reqQst($_REQUEST,'type');
$sf_id = reqQst($_REQUEST,'sf_id');
$OSM = reqQst($_REQUEST,'OSM');
$gmap_api_key = reqQst($_REQUEST,'gmap_api_key');
if ($sf_id) {
    $extra_params['sf_id'] = $sf_id;
} 

if ($OSM) {
    $extra_params['OSM'] = $OSM;
}

if ($gmap_api_key) {
    $extra_params['gmap_api_key'] = $gmap_api_key;
}

if ($type) {
    
    switch ($type) {
        case 'GetCapabilities':
            $url = reqQst($_REQUEST,'url');
            if ($url) {
                //if this is a getCapabilities then we are attempting to build a legend
                $var = parseGetCap($url,$extra_params,TRUE);
                print $var;
            }
            break;
        case 'GetFeatureInfo':
            $gml = reqQst($_REQUEST,'gml');
            if ($gml) {
                //if this is a getCapabilities then we are attempting to build a legend
                $var = parseGetFeatureInfo($gml);
                print $var;
            }
            break;

        default:
            print "ADMIN ERROR: nothing to parse";
            break;
    }
}
?>
