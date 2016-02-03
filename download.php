<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* download.php
*
* provokes a file download for 'files'
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with 
*    archaeological data
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
* @copyright  2007-2011 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/trunk/download.php
* @since      File available since Release 0.7
*
* This file expects to be passed the ARK filename of the file you want to download
* the folder containing these files is set up in settings
*
* eg: http://localhost:8888/ark_working/php/download.php?file=9.jpg
*
* NB: at present this only supports .doc .pdf and .jpg for other filetypes, add below
*
*/

// settings
include('src/settings.php');
include('php/global_functions.php');

// this is sent to the qryst
$filename = reqQst($_REQUEST,'file');

// extract the file extension
$file_extension = strtolower(substr(strrchr($filename,"."),1));

// this token is sent to indicate the filename includes the full path
$fullpath = reqQst($_REQUEST, 'fullpath');

// if the full path hasnt been sent add in the reg files dir path
if (!$fullpath) {
    // set the full path to the file
    if (!isset($registered_files_dir)) {
        echo "ADMIN ERROR: registered_files_dir is not correctly set";
        break;
    }
    $filename = $registered_files_dir.DIRECTORY_SEPARATOR.$filename;
}
$hrbool =reqQst($_REQUEST,'hrname');
//human readable name
if($hrbool){
    $filenumber=explode('.', basename($filename));
    $name = getSingle('filename','cor_lut_file',"where id=$filenumber[0]");
}else{
    $name = basename($filename);
}

// handle file extensions
switch ($file_extension) {
    case 'pdf':
        $ctype = "application/pdf";
        break;
    case 'doc':
        $ctype = "application/doc";
        break;
    case 'jpg':
        $ctype = "application/jpg";
        break;
    case 'csv':
        $ctype = "application/text";
        break;
    case 'tif':
        $ctype = "application/tif";
        break;
    case 'gif':
        $ctype = "application/gif";
    // if the file extension does not match any of the allowed cases kick the request out
    default:
        $filename = FALSE;
        break;
}

// throw out any attempts at hacking
if (!file_exists($filename) or !$filename) {
    session_start();
    session_destroy();
    header('Location: index.php');
}

// do the download
header("Pragma: public"); // required
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // required for certain browsers
header("Content-Type: $ctype");
header("Content-Disposition: attachment; filename=".$name.";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".@filesize($filename));
@readfile("$filename") or die("File not found.");
exit();

?>
