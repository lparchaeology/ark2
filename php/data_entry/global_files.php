<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_entry/global_files.php
*
* file to deal with uploading files
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
* @category   data_entry
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_entry/global_files.php
* @since      File available since Release 0.6
*
* NOTE 1: Major mods by GH at v1.1 to make this more like the current subform
* architecture.
*
* DEV NOTE: This script should be made into a proper SF
*/


// -- SETUP -- //

// requests
$cre_by = reqQst($_SESSION,'user_id');
$cre_by_name = reqQst($_SESSION,'soft_name');
$upload_dir = reqQst($_REQUEST, 'dir');
$batch_name = reqQst($_REQUEST, 'batch_name');
$module = reqQst($_REQUEST, 'module');
$upload_dir = reqArkVar('upload_dir', $default_upload_dir);
// filebrowser needs its own dir variable (could be merged? GH Dec 2011)
$dir = reqQst($_REQUEST, 'dir');
if (!$dir) {
    $dir = $upload_dir;
}

// markup
$mk_files_uploaded = getMarkup('cor_tbl_markup', $lang, 'files_uploaded');
$mk_no_files = getMarkup('cor_tbl_markup', $lang, 'no_files');
$mk_formupload_instructions = getMarkup('cor_tbl_markup', $lang, 'formupload_instructions');
$mk_batchname = getMarkup('cor_tbl_markup', $lang, 'batchname');
$mk_module = getMarkup('cor_tbl_markup', $lang, 'module');
$mk_filetype = getMarkup('cor_tbl_markup', $lang, 'filetype');
$mk_ste = getMarkup('cor_tbl_markup', $lang, 'ste');
$mk_upload_method = getMarkup('cor_tbl_markup', $lang, 'upload_method');
$mk_fu_simple = getMarkup('cor_tbl_markup', $lang, 'fu_simple');
$mk_fu_autoreg = getMarkup('cor_tbl_markup', $lang, 'fu_autoreg');
$mk_fu_links = getMarkup('cor_tbl_markup', $lang, 'fu_links');
$mk_fu_linkedonly = getMarkup('cor_tbl_markup', $lang, 'fu_linkedonly');
$mk_curuploaddir = getMarkup('cor_tbl_markup', $lang, 'curuploaddir');
$mk_waitmsg = getMarkup('cor_tbl_markup', $lang, 'waitmsg');
// label and input should come from an sf_conf (in a standard SF)
$label = getMarkup('cor_tbl_markup', $lang, 'space');
$input = getMarkup('cor_tbl_markup', $lang, 'save');

// set an output var
$var = FALSE;


// -- PROCESS -- //

if ($batch_name && $upload_dir && $module) {
    if (!isset($thumbnail_sizes)) {
        $thumbnail_sizes = FALSE;
    }
    if (!isset($registered_files_dir)) {
        $registered_files_dir = FALSE;
    }
    $upload_results = 
        processFiles(
            $dir,
            $batch_name,
            $module,
            $user_id,
            'NOW()',
            $thumbnail_sizes,
            $registered_files_dir
    );
    echo mkUploadResultsTable($upload_results,TRUE);
    printPre($upload_results);

} else {
    $upload_results = FALSE;
}

// get the list of files for the selected directory
$file_list = @dirList($dir);
// if it is empty inform the user and prevent the form from displaying
if (empty($file_list)) {
    $var .= "<div><p>$mk_no_files $upload_dir</p></div>";
    $output_form = FALSE;
} else {
    $output_form = TRUE;
}

// if no errors have been noted, put in the normal form instructions
if (!$error) {
    $message[] = $mk_formupload_instructions;
}


// -- OUTPUT -- //

// start a subform
echo "<div class=\"mc_subform\">\n";
echo "<a rel=\"lightbox\" href=\"overlay_holder.php?lboxreload=1&subform_id=$default_batch_file_upload\"><img src=\"$skin_path/images/recordnav/addfile.png\" alt=\"media_browser\" class=\"med\"/></a>";

// provide feedback to the user
if ($error) {
    feedBk('error');
}
if ($message) {
    feedBk('message');
}
// make up the form
if ($output_form) {
    // make up DD menus
    $mod_dd = ddAlias('', '', 'cor_tbl_module', $lang, 'module', FALSE, 'code', 'shortform');
    // if $fu is 'on' make up further DDs
    if ($fu['on']) {
        $file_dd = ddSimple('', '', 'cor_lut_filetype', 'filetype', 'filetype', 'filetype');
        $ste_dd = ddSimple('', '', 'cor_tbl_ste', 'id', 'ste_cd', 'id');
        $dd_fu_method = "<select name=\"upload_method\">";
        $dd_fu_method .= "<option value=\"s\" ".ddSelected('upload_method','s').">$mk_fu_simple</option>";
        $dd_fu_method .= "<option value=\"a\" ".ddSelected('upload_method','a').">$mk_fu_autoreg</option>";
        $dd_fu_method .= "<option value=\"c\" ".ddSelected('upload_method','c').">$mk_fu_links</option>";
        $dd_fu_method .= "<option value=\"l\" ".ddSelected('upload_method','l').">$mk_fu_linkedonly</option>";
        $dd_fu_method .= "</select>";
    }
    // output the form
    $var .= "<div><form method=\"$form_method\" id=\"file_upload\" action=\"{$_SERVER['PHP_SELF']}\" />\n";
    $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
    // start a list of fields
    $var .= "<ul>\n";
    // batch
    $var .= "<li class=\"row\"><label class=\"form_label\">$mk_batchname</label>";
    $var .= "<span class=\"inp\">";
    $var .= "<input type=\"text\" value=\"$batch_name\" name=\"batch_name\" />";
    $var .= "</span></li>\n";
    // module
    $var .= "<li class=\"row\"><label class=\"form_label\">$mk_module</label>";
    $var .= "<span class=\"inp\">";
    $var .= $mod_dd;
    $var .= "</span></li>\n";
    // if $fu is 'on' display further options
    if ($fu['on']) {
        // filetype
        $var .= "<li class=\"row\"><label class=\"form_label\">$mk_filetype</label>";
        $var .= "<span class=\"inp\">";
        $var .= $file_dd;
        $var .= "<span class=\"inp\">";
        $var .= "</span></li>\n";
        // site code
        $var .= "<li class=\"row\"><label class=\"form_label\">$mk_ste</label>";
        $var .= "<span class=\"inp\">";
        $var .= $ste_dd;
        $var .= "<span class=\"inp\">";
        $var .= "</span></li>\n";
        // file upload method
        $var .= "<li class=\"row\"><label class=\"form_label\">$mk_upload_method</label>";
        $var .= "<span class=\"inp\">";
        $var .= $dd_fu_method;
        $var .= "<span class=\"inp\">";
        $var .= "</span></li>\n";
    }
    // show the folder to be used and put in a hidden var for it
    $var .= "<li class=\"row\"><label class=\"form_label\">$mk_curuploaddir</label>";
    $var .= "<span class=\"inp\">";
    $var .= "<input type=\"hidden\" value=\"$dir\" name=\"dir\" /><b>$dir</b>";
    $var .= "<span class=\"inp\">";
    $var .= "</span></li>\n";
    // a standard button and label to submit the form
    $var .= "<li class=\"row\"><label class=\"form_label\">$label</label>";
    $var .= "<span class=\"inp\">";
    $var .= "<button>$input</button>";
    $var .= "</span></li>\n";
    // close out the field list
    $var .= "</ul>\n";
    // close out the form
    $var .= "</form></div>\n";
}

// output to screen
echo $var;

// include the file browser
include('file_browser.php');

// close out the subform
echo "</div>\n";

?>
