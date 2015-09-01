<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* map/ark_wxs_server.php
*
* This file is used to receive requests for serving the WMS data -
* it cannot be browsed - instead it either returns an image (PNG) or a GML file 
*
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
* @category   map
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/map/ark_wxs_server.php
* @since      File available since Release 0.6
*/

//GLOBAL INCLUDES
include_once ('../../config/settings.php');
if (!extension_loaded('MapScript')){
  if (strtoupper(substr(PHP_OS, 0,3) == 'WIN')){
     dl('php_mapscript.dll');
  }else{
     dl('php_mapscript.so'); 
  }
}

$request = ms_newowsrequestobj();
$buffer = FALSE;

//now we need to set up the request parameters and loop through them adding them to the request object
foreach ($_REQUEST as $key =>$value)    {
    $cleanvalue = reqQst($_REQUEST,$value);
    $request->setParameter($key,$cleanvalue);
}
ms_ioinstallstdouttobuffer();

//this mapfile path is set in config/settings
if ($request->getValueByName('SERVICE') == 'WMS') {
    $oMap = ms_newMapobj("$ark_wms_map");
}
if ($request->getValueByName('SERVICE') == 'WFS') {
    $oMap = ms_newMapobj("$ark_wfs_map");
}
$oMap->owsdispatch($request);
$contenttype = ms_iostripstdoutbuffercontenttype();
//print $contenttype;
if ($contenttype == 'image/png') {
    header('Content-type: image/png; mode=24bit');
    ms_iogetStdoutBufferBytes();
    $buffer = 'image';
}
if ($contenttype == 'image/png; mode=24bit') {
    header('Content-type: image/png; mode=24bit');
    ms_iogetStdoutBufferBytes();
    $buffer = 'image';
}
if ($contenttype == 'image/gif') {
    header('Content-type: image/gif');
    ms_iogetStdoutBufferBytes();
    $buffer = 'image';
}
if ($contenttype == 'application/vnd.ogc.wms_xml') {
    $buffer = ms_iogetstdoutbufferstring();
    header('Content-type: text/xml ');
    header('Access-Control-Allow-Origin: *');
    echo $buffer;
}
if ($contenttype == 'application/vnd.ogc.gml') {
    $buffer = ms_iogetstdoutbufferstring();
    header('Content-type: text/xml');
    header('Access-Control-Allow-Origin: *');
    echo $buffer;
}
if ($contenttype == 'application/vnd.ogc.se_xml') {
    $buffer = ms_iogetstdoutbufferstring();
    header('Content-type: text/xml');
    header('Access-Control-Allow-Origin: *');
    echo $buffer;
}
if ($contenttype == 'text/xml') {
    $buffer = ms_iogetstdoutbufferstring();
    header('Content-type: text/xml');
    header('Access-Control-Allow-Origin: *');
    echo $buffer;
}
if ($contenttype == 'text/html') {
    $buffer = ms_iogetstdoutbufferstring();
    header('Content-type: text/html');
    echo $buffer;
}

if (!$buffer) {
    $buffer = ms_iogetstdoutbufferstring();
    header('Content-type: text/html');
    echo $buffer;
}

ms_ioresethandlers();

?>
