<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/update_mediabrowser.php
*
* process script for the media browser
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
* @category   subforms
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/update_mediabrowser.php
* @since      File available since Release 1.1
*
* This is the companion update script that goes with the sf_mediabrowser.php
* subform. This Subform is expected to be used in an overlay, but could be adjusted
* to work as a standard sf if needed. The user interface and feedback are handled by
* the sf itself.
*
* This script runs a host of different file processing functions, dependent
* on what instructions it is given. It is sometimes run asynchronously and therefore
* simply returns a JSON array for the subform to parse
*
* Fields and other setup should be made available in the sf_conf itself. See the SF
* for further notes.
*
* DEV NOTE: THIS NEEDS INC_AUTH
*
*/


// -- INCLUDE SETTINGS AND FUNCTIONS -- //
include('../../config/settings.php');
include('../global_functions.php');
include('../validation_functions.php');

// SESSION Start the session
session_name($ark_name);
session_start();

// REQUEST vars needed in this page
$lang = reqArkVar('lang', $default_lang);
$update_db = reqQst($_REQUEST, 'update_db');
$filename = reqQst($_REQUEST, 'filename');
$filetype = reqQst($_REQUEST, 'filetype');
$mode = reqQst($_REQUEST, 'mode');
$link_file = reqQst($_REQUEST, 'link_file');


// -- AUTH -- //
$db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
// DEV NOTE: THIS NEEDS AUTH TO GET THE CRE_BY
$cre_by = 1;

if ($link_file == 'item') {
    $sf_key = reqQst($_REQUEST, 'sf_key');
    $sf_val = reqQst($_REQUEST, 'sf_val');
}

$exif_id = reqQst($_REQUEST, 'exif_id');
if ($exif_id) {
    $map = reqQst($_REQUEST, 'map');
    $exif_array = getExifData("$registered_files_dir$exif_id.jpg", 'html', $map);
    if (is_array($exif_array) && $exif_array['success'] == 0) {
        echo "<ul class=\"exif_data\"><li class=\"exif_row\"><span class=\"exif_data\">No EXIF Data Available</span></li></ul>";
    } else {
        echo $exif_array;
    }
    exit;
}

// -- EVALUATION -- //

// Assume no errors yet!
if (empty($error)) {
    $error = FALSE;
}

// -- PROCESS -- //

// if we are running a single file upload then let's grab the filename and start the processing
if ($mode == 'from_comp' || $mode == 'from_ipad') {
    // iPad mode we get the file out of the php $_FILES array
    if ($mode == 'from_ipad') {
        echo "<img src=\"$skin_path/images/loading.gif\"/>";
        // move it from where it is, to the upload dir, using the name the filename token 'camera' created
        move_uploaded_file($_FILES["file"]["tmp_name"], $default_upload_dir . DIRECTORY_SEPARATOR . $_FILES["file"]["name"]);
        $filename = $_FILES["file"]["name"];
    }
    $file_array = array(
                    $filename
    );
    $filetype = reqQst($_REQUEST, 'filetype');
    $result = processFiles($default_upload_dir, 'from_comp', FALSE, $cre_by, 'NOW()', $thumbnail_sizes, FALSE, $file_array);
    // look for errors coming back from processFiles()
    if (@array_key_exists('err', $result['setup'])) {
        // a setup error has occured
        $return_result = $result;
    } else {
        // no setup errors so look at the file
        if (array_key_exists('err', $result['files'][$filename])) {
            // the results array will carry this err info to the JSON
            // flag that nothing was linked
            $linked_results = FALSE;
        } else {
            // now check if we also want to link the file to an item
            if ($link_file == 'item' && $result['files'][$filename]['process']['lut']['results']['success'] == 1) {
                $linked_results = addFile($sf_key, $sf_val, $result['files'][$filename]['process']['lut']['results']['new_id'], $cre_by, 'NOW()');
            } else {
                $linked_results = FALSE;
            }
        }
        // we don't need the whole process array - just the parts needed for the feedback on the sf
        $return_result = $result['files'][$filename];
        // return feedback on whether the file was linked
        if (is_array($linked_results) && $linked_results[0]['success'] == TRUE) {
            $return_result['linked'] = TRUE;
        } elseif ($link_file == 'register') {
            $return_result['linked'] = 'register';
        } else {
            $return_result['linked'] = FALSE;
        }
        // for the iPad script this is not very ajazzy so just reload the parent and close the lightbox
        // remember we already tested for errors in the return from file processed
        // so just test for linked here
        if ($mode == 'from_ipad' && $return_result['linked']) {
            echo "<script>parent.location.reload();window.close();
                    window.history.back();</script>";
        }
    }
}
if ($mode == 'from_url') {
    //as this is going to be a url we need to strip it out a bit before processing
    $uri_root = dirname($filename);
    $filename = basename($filename);
    $file_array = array(
        $filename,
        'uri_root' => $uri_root
    );
    $result = processFiles($default_upload_dir, 'from_url', FALSE, $cre_by, 'NOW()', FALSE, FALSE, $file_array);
    // lets check if we have had a success
    if (array_key_exists('process',$result['files'][$filename])) {
        if (array_key_exists('uri_id',$result['files'][$filename]['process']['lut']['results'])) {
            $process_success = TRUE;
            $file_id = $result['files'][$filename]['process']['lut']['results']['uri_id'];
            //now we just ghost in the uri_id as the 'new_id' so that the sf can deal with it
            $result['files'][$filename]['process']['lut']['results']['new_id'] = $file_id;
            $result['files'][$filename]['process']['lut']['results']['success'] = TRUE;
        } elseif ($result['files'][$filename]['process']['lut']['results']['success'] == TRUE) {
            $process_success = TRUE;
            $file_id = $result['files'][$filename]['process']['lut']['results']['new_id'];
        }
    } else {
        $process_success = FALSE;
        $result['files'][$filename]['process']['lut']['results']['success'] = FALSE;
    }
     //now check if we also want to link the file to an item
    if ($link_file == 'item' && $link_file && $process_success == TRUE) {
        $result['files'][$filename]['process']['lut']['results']['success'] = TRUE;
        $linked_results = addFile($sf_key, $sf_val, $file_id, $cre_by, 'NOW()');
    } else {
        $linked_results = FALSE;
    }
    
    //we don't need the whole process array - just the parts needed for the feedback on the sf
    $return_result = $result['files'][$filename];
    if (is_array($linked_results) && $linked_results[0]['success'] == TRUE) {
        $return_result['linked'] = TRUE;
    } elseif ($link_file == 'register')  {
        $return_result['linked'] = 'register';    
    } else {
        $return_result['linked'] = FALSE;
    }
}
if ($mode == 'from_ML') {
    $return_result = '';
    $linked_files = $_REQUEST['linked_files'];
    //now decode this JSON as an array
    $linked_files = json_decode($linked_files,TRUE);
    //now we have an array of the files that we want linked to this item
    //REMEMBER the user could have taken some files out!
    //so we first grab all the files that are linked to the item
    $current_files = getFile($sf_key, $sf_val, $filetype);
    foreach ($linked_files as $key => $value) {
        //first check that this one isn't already linked - we can do this by seeing if the
        //requested file is already in current files (the keys are the file_ids)
        if (!array_key_exists($key,$current_files)) {
            echo "I want to add {$value['id']}<br />";
            $return_result[] = addFile($sf_key, $sf_val, $key, $cre_by, 'NOW()');
        }
        //now remove it from the $current_files array to leave us with the files we want to be removed
        unset($current_files[$key]);
    }
    //now we should be left with the linked_files array containing files that the user 
    //has removed using the media browser - get rid of those
    printPre($current_files);
    if (is_array($current_files)) {
        foreach ($current_files as $key => $value) {
            echo "I want to delete {$value['frag_id']}<br />";
            delFrag('file',$value['frag_id'],$cre_by,'NOW()');
        }
    }
}

// ---- RETURN ---- //

if ($mode !='from_ipad'){
    echo htmlspecialchars(json_encode($return_result), ENT_NOQUOTES);
}
?>
