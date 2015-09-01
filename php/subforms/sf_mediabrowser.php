<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_mediabrowser.php
*
* a form (usually used in overlay_holder) to choose from the files uploaded (and to upload a single local file)
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_mediabrowser.php
* @since      File available since Release 1.0
*
* This SF is expected to run in an overlay. Standard states could be added to allow this
* to function as a normal SF if any reason for that became apparent.
*
* The form returns a list of file_ids to a parent form for processing by the normal means
*
* The sf_conf is very generic, requires no fields and can be assumed to sit in page_settings
*
* NB: overlay_holder.php will try to figure out a module based on the sf_key it is sent. If
* it is not sent an sf_key, it will fall back on a default (as per reqArkVar()).
*
*/

// ---- SETUP ---- //

// this form uses jQuery tabbing to divide the content up into different parts.
// request current tab if there isn't one then default to from_comp
$tab = reqQst($_REQUEST, 'tab');
$sf_conf_name = reqQst($_REQUEST, 'sf_conf');
if(array_key_exists('op_notabs', $sf_conf)){
    $tab = $sf_conf['op_notabs'];
    $showtabs = FALSE;
} else {
    $showtabs= TRUE;
}
if (!$tab) {
    $tab = 'from_comp';
}
$filetype = reqQst($_REQUEST, 'filetype');
if (!is_numeric($filetype) && $filetype != FALSE) {
    $filetype = getSingle('id', 'cor_lut_filetype', "filetype = \"$filetype\"");
}

if (!$filetype) {
    $filetype = 1;
}

if (!isset($filesize_limit)) {
    $filesize_limit = (int)(ini_get('upload_max_filesize'));
}

$link_file = reqQst($_REQUEST, 'link_file');
if ($link_file == 'item') {
    $sf_key = reqQst($_REQUEST, 'sf_key');
    $sf_val = reqQst($_REQUEST, 'sf_val');
}
$lboxreload = reqQst($_REQUEST, 'lboxreload');
$process = FALSE;


// ---- PROCESS ---- //
// process is called asynchronously using a jQuery Ajax call to the process script


// ---- COMMON ---- //
// Labels and so on

// get a list of all the markup we need
$mk_list = array(
                'waitmsg', 
                'reqfileformat', 
                'norec', 
                'draghere', 
                'beingthumbed',
                'uploadsuccess',
                'uploadsuccessnocrunch',
                'uploadfailure', 
                'uploadfailureadmin', 
                'urllinking', 
                'urllinkingnocrunch', 
                'linksuccess', 
                'urllabel',
                'ipadwarning'
);

//loop over the list assigning mk to a variable of the same name
foreach ($mk_list as $required_mk){
    $mk_name = 'mk_'.$required_mk;
    $$mk_name =  getMarkup('cor_tbl_markup', $lang, $required_mk);
}

//conf based mk needs to be dealt with separately
$mk_title =  getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_op_input =  getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
$mk_op_label =  getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);

//as these are used in JS buttons we need to make sure we escape out the special chars 
//(especially if the markup is not present)
$mk_moreinfo = addslashes(getMarkup('cor_tbl_markup', $lang, 'moreinfo'));
$mk_lessinfo = addslashes(getMarkup('cor_tbl_markup', $lang, 'lessinfo'));
$mk_linkfiles = addslashes(getMarkup('cor_tbl_markup', $lang, 'linkfiles'));

// get common elements for all states 
// CSS
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// this JS script is printed into the html to allow the waiting message to display
$js_wait_script = "<script>
function loadingScreen(element, form_holder) {
    element.style.display = 'block';
    element.innerHTML = '<div class=\"waiting\">$mk_waitmsg</div>';
    form_holder.style.display = 'none';
    return true;
}
</script>";


// -- PHP VARS -> JS -- //
// make any PHP vars needed within JS available as global scope vars
$phpvars =
    array(
        'filesize_limit' => $filesize_limit,
        'upload_dir_plus_trailing_slash' => $default_upload_dir.$fs_slash,
        'skin_path' => $skin_path,
);
// return and echo this javascript
$js_code = mkJsVars($phpvars, 'phpvars');
echo $js_code;
// now make the markup into its own JSON object (purely for ease of reference)
$markup =
    array(
        'mk_uploadfailure' => $mk_uploadfailure,
        'mk_uploadfailureadmin' => $mk_uploadfailureadmin,
        'mk_beingthumbed' => $mk_beingthumbed,
        'mk_linksuccess' => $mk_linksuccess,
        'mk_keyval_pair' => " $sf_key $sf_val", // slightly hacky GH 9/12/12
        'mk_uploadsuccess' => $mk_uploadsuccess,
        'mk_uploadsuccessnocrunch' => $mk_uploadsuccessnocrunch,
        'mk_uploadsuccess' => $mk_uploadsuccess,
);
// return and echo this javascript
$js_code = mkJsVars($markup, 'markup');
echo $js_code;
// NOTE: the ajax url is formed using the same method, but is state specific


// -- STATE SPECFIC -- //
// for each state get specific elements and then produce output

switch ($sf_state) {
    // Min Views
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        print("</div>");
        break;
        
    // Overlay Views
    case 'overlay':
        /*this form is really only ever used in overlay mode - it is divided into different tabbed sections
         * 1. From Computer ('from_comp') - This is for uploading a single file from the client computer
         * 2. From URL('from_URL') - This is for copying from a remote URI
         * 3. From Media Library('from_ML') - For selecting files from all of the files already in cor_lut_file
        */
        
        // output
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // PROCESS routine | USER INPUT routine (depending on progress)
        if ($process) {
            
        } else {
            // provide some help and user input
            echo "<div id=\"js_waiting_message\" style=\"display:none\">&nbsp;</div>";
            echo "<div id=\"form_holder\">";
            echo "$js_wait_script\n";
            echo "<h4>$mk_title</h4>";
            echo "</div>";
        }
        
        // build the tabs - code and config follow the naim nav
        $tab_options = array();
        //the from_comp tab
        $tab_options['from_comp'] = 
            array(
                'name' => 'From Computer',
                'title' => 'From Computer', //this should be Markup
                'file' => 'overlay_holder.php',
                'sgrp' => 1,
                'navname' => 'from_comp',
                'navlinkvars' => "?lboxreload=$lboxreload&amp;sf_conf=$sf_conf_name&amp;tab=from_comp&amp;link_file=$link_file&amp;sf_key=$sf_key&amp;sf_val=$sf_val&amp;filetype=$filetype",
                'cur_code_dir' => 'php/subforms/',
                'is_visible' => 1
        );
        //the from_url tab
        $tab_options['from_url'] = 
            array(
                'name' => 'From URL',
                'title' => 'From URL', //this should be Markup
                'file' => 'overlay_holder.php',
                'sgrp' => 1,
                'navname' => 'from_url',
                'navlinkvars' => "?lboxreload=$lboxreload&amp;sf_conf=$sf_conf_name&amp;tab=from_url&amp;link_file=$link_file&amp;sf_key=$sf_key&amp;sf_val=$sf_val&amp;filetype=$filetype",
                'cur_code_dir' => 'php/subforms/',
                'is_visible' => 1
        );
        //the from_ML tab
        $tab_options['from_ML'] = 
            array(
                'name' => 'From Media Library',
                'title' => 'From Media Library', //this should be Markup
                'file' => 'overlay_holder.php',
                'sgrp' => 1,
                'navname' => 'from_ML',
                'navlinkvars' => "?lboxreload=$lboxreload&amp;sf_conf=$sf_conf_name&amp;tab=from_ML&amp;link_file=$link_file&amp;sf_key=$sf_key&amp;sf_val=$sf_val&amp;filetype=$filetype",
                'cur_code_dir' => 'php/subforms/',
                'is_visible' => 1
        );
        $tab_options['from_ipad'] = 
            array(
                'name' => 'From iPad',
                'title' => 'From iPad', //this should be Markup
                'file' => 'overlay_holder.php',
                'sgrp' => 1,
                'navname' => 'from_ipad',
                'navlinkvars' => "?lboxreload=$lboxreload&amp;sf_conf=$sf_conf_name&amp;tab=from_ipad&amp;link_file=$link_file&amp;sf_key=$sf_key&amp;sf_val=$sf_val&amp;filetype=$filetype",
                'cur_code_dir' => 'php/subforms/',
                'is_visible' => 1
        );
        //now set the active tab
        if ($tab != FALSE && array_key_exists($tab, $tab_options)) {
            $tab_options[$tab]['active'] = TRUE;
        }
        
        if ( $showtabs ) {
            $var = '<div id="navcontainer" class="navcontainer">';
            $var .= mkNavMain($tab_options, FALSE, TRUE);
            $var .= '</div>';
            echo $var;
        }
        
        //now lets setup the content dependent on the tab
        switch ($tab) {
            case 'from_comp':
                // setup the ajax URL for the processing
                $ajax_url = "php/subforms/update_mediabrowser.php?";
                $ajax_url .= "mode=$tab&upload_method=s&filetype=$filetype";
                // add needed vars to the ajax URL
                if ($link_file == 'item') {
                    $ajax_url .= "&link_file=$link_file";
                    $ajax_url .= "&sf_key=$sf_key&sf_val=$sf_val";
                } elseif ($link_file == 'register') {
                     $ajax_url .= "&link_file=$link_file";
                }
                // make ajax_url available as global scope var
                $phpvars = array('ajax_url' => $ajax_url);
                // return and echo this javascript
                $js_code = mkJsVars($phpvars, 'ajax');
                echo $js_code;
                echo "<div id=\"main\" class=\"media_browser\"><p class=\"message\">$mk_draghere</p>";
                // add in the file valum fileuploader JS from library
                $var = "<script type=\"text/javascript\" src=\"lib/js/valums-fileuploader/client/fileuploader.js\"></script>";
                // add in the ARK file upload handler JS code
                $var .= "<script type=\"text/javascript\" src=\"js/ark_file_upload_handler.js\"></script>";
                $var .= "<div id=\"file-uploader\" class=\"drop-zone\">
                    <noscript>
                        <p>Please enable JavaScript to use file uploader.</p>
                        <!-- or put a simple form for upload here -->
                    </noscript>
                </div>";
                echo $var;
                break;
                
            case 'from_url':
                // setup the ajax URL for the processing
                $ajax_url = "php/subforms/update_mediabrowser.php?";
                $ajax_url .= "mode=$tab&upload_method=s&filetype=$filetype";
                // add needed vars to the ajax URL
                if ($link_file == 'item') {
                    $ajax_url .= "&link_file=$link_file";
                    $ajax_url .= "&sf_key=$sf_key&sf_val=$sf_val";
                } elseif ($link_file == 'register') {
                     $ajax_url .= "&link_file=$link_file";
                }
                
                // CASE-SPECIFIC REQUESTS
                $url = reqQst($_REQUEST, 'url');
                
                $var = "<link href=\"lib/js/valums-fileuploader/client/fileuploader.css\" type=\"text/css\" rel=\"stylesheet\" />"; //DEV NOTE: Include in Skin CSS
                $var .= "<div id=\"main\" class=\"media_browser\">";
                // if we have a URL it means that we have already run the form - therefore we need to go and process
                if ($url) {
                    $var .= "
                    <script type=\"text/javascript\">    
                    jQuery.noConflict(); // start substituting $ for jQuery
                    //create the function to create the nice view for the register
                    function formatFilesRegister(file,filename,crunched) {
                        parent.document.getElementById('mb_fileform').value = parent.document.getElementById('mb_fileform').value + ' ' + file;
                        if (crunched == true) {
                            //we have a thumbnail so include it
                            thumb = '<img src=\"data/files/arkthumb_' + file + '\" alt=\"file_image\"/></a>';
                        } else {
                            thumb = '<img src=\"$skin_path/images/results/thumb_default.png\" alt=\"icon\" class=\"icon\" title=\"' + filename + '\"/>';
                        }
                        file_list = '<li class=\"file_list\">'+ thumb + '<a target=\"\" href=\"data/files/webthumb_' + file + '.jpg\" alt=\"' + filename + '\" title=\"' + filename + '\">' + filename + '</a></li>';
                        jQuery(parent.document.getElementById('mb_file_list')).append(file_list);
                    }
                    jQuery(document).ready(function(){
                        //first we want to give some feedback
                        jQuery(\"<span id='$url' class='qq-upload-file'>$url</span><span id='upload_feedback' class='qq-upload-spinner'></span>\").insertAfter(document.getElementById('url_browser_form'));
                        fileName = '$url';
                        filename_elem = jQuery(document.getElementById('$url'));
                        // now run the process asynchronously and give appropriate feedback
                        jQuery.ajax({
                             url:    '$ajax_url&filename=$url',
                             success: function(result) {
                                    //parse the results JSON array
                                    var result_obj = jQuery.parseJSON(result);
                                    if (result_obj.process.lut.results.success == 1) {
                                        //check if it has been linked
                                        if (result_obj.linked == 1) {
                                            linkedtext = \" $mk_linksuccess $sf_key $sf_val\"
                                        } else if (result_obj.linked == 'register') {
                                            if (result_obj.crunch.arkthumb !== undefined){
                                                crunched = true;
                                            } else {
                                                crunched = false;
                                            }
                                            formatFilesRegister(result_obj.process.lut.results.new_id,fileName,crunched);
                                            linkedtext = \" $mk_linksuccess\";
                                        } else {
                                            linkedtext = \"\";
                                        }
                                        //check if it has been crunched as well
                                        if (result_obj.crunch.arkthumb !== undefined) {
                                            filename_elem.text(fileName + \" $mk_urllinking\" + linkedtext);
                                            jQuery(filename_elem).next().remove();
                                        } else {
                                            filename_elem.text(fileName + \" $mk_urllinkingnocrunch [error= \" + result_obj.crunch.convertible + \"]\" + linkedtext);
                                            jQuery(filename_elem).next().remove();
                                        }
                                    } else {
                                        filename_elem.text(fileName + \" $mk_uploadfailure\" + result_obj.process.lut.results.error);
                                        jQuery(filename_elem).next().remove();
                                    }
                             },
                             async:   true
                        });
                    
                    });
                    </script>
                    ";
                }
                $var .= "<div class=\"url_browser\">"; 
                //create a very simple form for the URL
                $form = "<form method=\"$form_method\" id=\"url_browser_form\" action=\"{$_SERVER['PHP_SELF']}\">";
                $form .= "<fieldset>";
                $form .= "<input type=\"hidden\" name=\"lboxreload\" value=\"$lboxreload\" />";
                $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"$sf_conf_name\" />";
                $form .= "<input type=\"hidden\" name=\"tab\" value=\"$tab\" />";
                $form .= "<input type=\"hidden\" name=\"link_file\" value=\"$link_file\" />";
                $form .= "<input type=\"hidden\" name=\"filetype\" value=\"$filetype\" />";
                $form .= "<input type=\"hidden\" name=\"sf_key\" value=\"$sf_key\" />";
                $form .= "<input type=\"hidden\" name=\"sf_val\" value=\"$sf_val\" />";
                // get current vals
                $form_val = "<input type=\"text\" class=\"txt\" name=\"url\"/>";
                $form .= "<li class=\"row\">";
                $form .= "<label class=\"form_label\">$mk_urllabel</label>";
                $form .= "<span class=\"inp\">$form_val</span>";
                $form .= "</li>\n";
                // finally - put in the save/options row
                $label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);
                $input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
                $form .= "<li class=\"row\">";
                $form .= "<label class=\"form_label\">$label</label>";
                $form .= "<span class=\"inp\">";
                $form .= "<button>$input</button>";
                $form .= "</span>";
                $form .= "</li>\n";
                $form .= "</ul>\n";
                $form .= "</fieldset>";
                $form .= "</form>\n";
                $var .= $form;
                $var .= "</div>"; //end url_browser 
                $var .= "</div>"; //end media_browser
                echo $var;
                break;
                
            case 'from_ML':
                // setup the ajax URL for the processing
                $ajax_url = "php/subforms/update_mediabrowser.php?";
                $ajax_url .= "mode=$tab";
                // add needed vars to the ajax URL
                if ($link_file == 'item') {
                    $ajax_url .= "&link_file=$link_file&sf_key=$sf_key&sf_val=$sf_val&filetype=$filetype";
                } elseif ($link_file == 'register') {
                     $ajax_url .= "&link_file=$link_file&filetype=$filetype";
                }
                //first we want to get an array of all the files - so that we can send it for sorting via the javascript
                //this array is limted by the filetype. DEV NOTE: Should we offer ALL files?
                $all_files = getMulti('cor_lut_file', "filetype=$filetype");
                $batch_array = array();
                $mod_array = array();
                $date_array = array();
                $cre_by_array = array();
                $all_files_array = $all_files;
                //now tidy this all up a bit so we can have arrays of filtered items with the file id's as the keys
                foreach ($all_files as $key => $file) {
                    if ($file['batch'] != FALSE) {
                        $batch_array[$file['batch']][$file['id']] = $file;
                    }
                    if ($file['module'] != FALSE) {
                        $mod_array[$file['module']][$file['id']] = $file;
                    }
                    if ($file['cre_by'] != FALSE) {
                        //get the fullname of the person
                        $user = getUserAttr($file['cre_by'],'full');
                        $cre_by_array[$user][$file['id']] = $file;
                    }
                    if ($file['cre_on'] != FALSE) {
                        $date = strtotime($file['cre_on']);
                        $date = getdate($date);
                        $fulldate = $date['weekday'] . " " . $date['mday'] . " " . $date['month'] . " " . $date['year'];
                        $date_array[$fulldate][$file['id']] = $file;
                    }
                    $all_files_array_rekey[$file['id']] = $file;
                }
                // stick all the arrays into one big array for JSON'ing
                $json_array =
                    array(
                        'all_files' => $all_files_array_rekey,
                        'batch' => $batch_array,
                        'mod' => $mod_array,
                        'date' => $date_array,
                        'cre_by' => $cre_by_array
                );
                // encode it
                $json_array = json_encode($json_array);
                
                // now we need to get the currently linked files (if any)
                if ($link_file == 'item') {
                    $linked_files = getFile($sf_key, $sf_val,$filetype);
                } else {
                    $linked_files = FALSE;
                }
                // encode it
                $json_linked_files = json_encode($linked_files);
                
                //now we double check if we want to include a small map with the EXIF data
                if (array_key_exists('op_exif_map', $sf_conf)) {
                    $exif_map = $sf_conf['op_exif_map'];
                } else {
                    $exif_map = FALSE;
                }
                
                $js_script = "
                
                <script type=\"text/javascript\">
                var linked_files;
                var link_file_mode = '$link_file';
                jQuery(document).ready(function(){
                    linked_files = $json_linked_files;
                    if (linked_files === false) {
                        linked_files = {};
                    }
                    buildLinkedFiles(linked_files);
                });
                function getCurrentSelection(){
                    var selected = false;
                    jQuery.each(jQuery('select'), function(key,select_val){
                        if (select_val.selectedIndex != 0) {
                            selected = select_val;
                        }
                    });
                    return selected;
                }
                function formatFilesRegister(file,filename,crunched) {
                    parent.document.getElementById('mb_fileform').value = parent.document.getElementById('mb_fileform').value + ' ' + file;
                    if (crunched == true) {
                        //we have a thumbnail so include it
                        thumb = '<img src=\"data/files/arkthumb_' + file + '\" alt=\"file_image\"/></a>';
                    } else {
                        thumb = '<img src=\"$skin_path/images/results/thumb_default.png\" alt=\"icon\" class=\"icon\" title=\"' + filename + '\"/>';
                    }
                    file_list = '<li class=\"file_list\">'+ thumb + '<a target=\"\" href=\"data/files/webthumb_' + file + '.jpg\" alt=\"' + filename + '\" title=\"' + filename + '\">' + filename + '</a></li>';
                    jQuery(parent.document.getElementById('mb_file_list')).append(file_list);
                }
                //this function hops over an array and matches up the ARK id with the object key
                //supplied with an ARK id it gives back the id of the object
                function getRelKeyid(rel,array){
                    var id = false;
                    jQuery.each(array, function(j, value) {
                        if (value.id == parseInt(rel)) {
                            id = j;
                        }
                    });
                    return id;
                }
                //this function heads off and gets the EXIF data for the file
                function getEXIFhtml(url,file_id){
                    var html = false;
                    jQuery.ajax({
                         url:    url +'&exif_id=' + file_id + '&map=$exif_map',
                         success: function(result) {
                            html = result;
                         },
                         async:   false
                     });
                    if (html != false) {
                        return html;
                    } else {
                        return false;
                    }
                }
                //this function assembles the content when the more info button is pressed
                //we want to add in a nice little div that prints out the exif data - and
                //we want to expand the thumb
                function moreInfo(button){
                    //first expand the thumb by replacing with the webthumb
                    thumb = button.parent().find('img');
                    thumb.attr('src', 'data/files/webthumb_' + button.attr('id') + '.jpg');
                    thumb.switchClass('hover_thumb','hover_thumb_more',500);
                    //if we have exif_data then append it
                    exif_data = getEXIFhtml('$ajax_url',button.attr('id'));
                    exif_data = jQuery('<div class =\"exif_data\" id=\"exif_info\">' + exif_data + '</div>');
                    exif_data.insertAfter(thumb);
                    //finally set the more info button to be less info!
                    button.html('$mk_lessinfo');
                    button.unbind('click');
                    button.click(function(){
                        lessInfo(jQuery(this));
                    });
                    
                }
                //this function cleans up the content when the less info button is pressed
                function lessInfo(button){
                    //first expand the thumb by replacing with the webthumb
                    thumb = button.parent().find('img');
                    thumb.attr('src', 'data/files/arkthumb_' + button.attr('id') + '.jpg');
                    thumb.switchClass('hover_thumb_more','hover_thumb',500);
                    exif_info = jQuery('#exif_info');
                    exif_info.remove();
                    //finally set the less info button to be less info!
                    button.html('$mk_moreinfo');
                    button.unbind('click');
                    button.click(function(){
                        moreInfo(jQuery(this));
                    });
                    
                }
                function buildLinkedFiles(linked_files,select){
                    if (linked_files.length != ''){
                        linked_list = jQuery('<ul id=\"ml_linkedfiles\" class=\"hz_list\">');
                        jQuery.each(linked_files, function(i, val) {
                            thumb = jQuery('<img class =\"linked_file\" rel=\"' + val.id + ' \" src=\"data/files/arkthumb_' + val.id + '.jpg\" alt=\"no_thumbnail_available\"/>');
                            thumb.error(function() {
                              this.src = '$skin_path/images/results/thumb_default.png';
                            });
                            
                            linked_li = jQuery('<li class=\"hz_list\">');
                            linked_li.append(thumb);
                            linked_list.append(linked_li);
                        });
                        jQuery(\"#ml_linkedfiles\").replaceWith(linked_list);
                        //set up the submit button for updating either the register or the item itself
                        jQuery(\"#ml_linkedfiles\").append('<button id=\"ml_submit\">$mk_linkfiles</button>');
                        jQuery(\".linked_file\").click(
                              function(){
                                jQuery(this).animate({opacity: \"0\"}, 300);
                                thumb = jQuery(this);
                                var remove_li = jQuery(thumb.parent());
                                remove_li.remove();
                                linked_files_key = getRelKeyid(thumb.attr('rel'),linked_files);
                                if (linked_files_key != false) {
                                    delete linked_files[linked_files_key];
                                }
                                //reset the Media Library so that it updates the list again
                                current_selection = getCurrentSelection();
                                if (current_selection != false) {
                                    updateML(current_selection);
                                }
                        });
                        jQuery(\"#ml_submit\").click(
                            function(){
                                json_linked_files = JSON.stringify(linked_files);
                                if (link_file_mode == 'register') {
                                    jQuery.each(linked_files, function(i, val) {
                                        formatFilesRegister(val.id,val.filename,true);
                                        jQuery(\"#bottomNavClose\", window.parent.document).click();
                                    });
                                } else {
                                    jQuery.ajax({
                                        url: '$ajax_url',
                                        type: 'POST',
                                        data: 'linked_files=' + escape(json_linked_files),
                                    })
                                    jQuery(\"#bottomNavClose\", window.parent.document).click();
                                }
                            }
                        );
                                
                    }
                }
                function updateML(select){
                    dd_name = select.name;
                    dd_value = select.options[select.selectedIndex].value;
                    //first reset the other DDs so it doesn't look like you are multi-filtering
                    jQuery.each(jQuery('select'), function(key,select_val){
                        if (select_val.name != dd_name) {
                            select_val.selectedIndex = 0;
                        }
                    });
                    print = 1;
                    file_array = $json_array;
                    current_array = file_array[dd_name][dd_value];
                    file_list = jQuery('<ul id=\"ML\" class=\"file_list\"></ul>');
                    jQuery.each(current_array, function(i, val) { 
                        //first check if we have this in the linked files
                        jQuery.each(linked_files, function(j, link_file) {
                            if (link_file.id == val.id && print != 0) {
                                print = 0;
                                return false;
                            } else {
                                print = 1;
                            }
                        });
                        if (print == 1) {
                            //build the thumb
                            thumb = '<img rel=\"' + val.id + '\"class=\"hover_thumb\" src=\"data/files/arkthumb_' + val.id + '\" alt=\"no_thumbnail_available\"/>';
                            thumb = jQuery(thumb);
                            thumb.error(function() {
                              this.src = '$skin_path/images/results/thumb_default.png';
                            });
                            //build the more_info button
                            more_info = jQuery('<button id=\"' + val.id + '\">$mk_moreinfo</button>');
                            li = jQuery('<li \"class=\"file_list\">');
                            //build up the whole package and add to the current file list
                            li.append(thumb);
                            more_info.click(function(){
                                moreInfo(jQuery(this));
                            });
                            li.append(more_info);
                            file_list.append(li);
                        }
                    });
                    jQuery(\"#ML\").replaceWith(file_list);
                    jQuery(\".hover_thumb\").click(
                          function(){
                            jQuery(this).animate({opacity: \"0\"}, 300);
                            thumb = jQuery(this);
                            linked_files[thumb.attr('rel')] = file_array['all_files'][thumb.attr('rel')];
                            var remove_li = jQuery(thumb.parent());
                            remove_li.remove();
                            buildLinkedFiles(linked_files,select);
                        }  
                    );
                    
                }
                </script>
                ";
                echo $js_script;
                // Build the dropdowns
                echo "<div class=\"ML_dropdowns\">";
                // batch
                // $batch_array = ksort($batch_array);
                $batch_dd = "<select name=\"batch\" onchange=\"updateML(this);\">\n";
                $batch_dd .= "<option value=\"Select Batch\">Select Batch</option>\n";
                foreach ($batch_array as $key => $value) {
                    $batch_dd .= "<option value=\"$key\">$key</option>\n";
                }
                $batch_dd .= "</select>\n";
                echo $batch_dd;
                $mod_dd = "<select name=\"mod\" onchange=\"updateML(this);\">\n";
                $mod_dd .= "<option value=\"Select Module\">Select Module</option>\n";
                foreach ($mod_array as $key => $value) {
                    $mod_dd .= "<option value=\"$key\">$key</option>\n";
                }
                $mod_dd .= "</select>\n";
                echo $mod_dd;
                $date_dd = "<select name=\"date\" onchange=\"updateML(this);\">\n";
                $date_dd .= "<option value=\"Select Date\">Select Date</option>\n";
                foreach ($date_array as $key => $value) {
                    $date_dd .= "<option value=\"$key\">$key</option>\n";
                }
                $date_dd .= "</select>\n";
                echo $date_dd;
                $cre_by_dd = "<select name=\"cre_by\" onchange=\"updateML(this);\">\n";
                $cre_by_dd .= "<option value=\"Uploaded By\">Uploaded By</option>\n";
                foreach ($cre_by_array as $key => $value) {
                    $cre_by_dd .= "<option value=\"$key\">$key</option>\n";
                }
                $cre_by_dd .= "</select>\n";
                echo $cre_by_dd;
                echo "</div>";
                //now Johnson them up for use with the JS
                $all_files_array = json_encode($all_files_array);
                $batch_array = json_encode($batch_array);
                $mod_array = json_encode($mod_array);
                $date_array = json_encode($date_array);
                $cre_by_array = json_encode($cre_by_array);
                $var = "<div id=\"main\" class=\"media_browser\">";
                //this is where we put the already linked files
                $var .= "<div class=\"ml_linkedfiles\">";
                $var .= "<ul id=\"ml_linkedfiles\" class=\"hz_list\">";
                $var .= "</div>"; //end ml_linkedfiles
                $var .= "<div class=\"ml_browser\">";
                $var .= "<ul id=\"ML\" class=\"file_list\">";
                $var .= "</ul>";
                $var .= "</div>"; //end ml_browser 
                $var .= "</div>"; //end media_browser
                echo $var;
                break;

                case 'from_ipad':
                    // setup the ajax URL for the processing
                    $ajax_url = "php/subforms/update_mediabrowser.php?";
                    $ajax_url .= "mode=$tab&upload_method=s&filetype=$filetype";
                    // add needed vars to the ajax URL
                    if ($link_file == 'item') {
                        $ajax_url .= "&link_file=$link_file";
                        $ajax_url .= "&sf_key=$sf_key&sf_val=$sf_val";
                    } elseif ($link_file == 'register') {
                        $ajax_url .= "&link_file=$link_file";
                    }
                    // This is just going to pass the file by POST to the update_mediabrowserscript
                    // using the options built above
                    echo "<div id=\"main\" class=\"media_browser\"><p>$mk_ipadwarning</p>
                       <form action=\"$ajax_url\" method=\"post\"
                            enctype=\"multipart/form-data\">
                            <ul>
                            <li class=\"row\">
                            <label for=\"file\">Filename:</label>
                            <input type=\"file\" name=\"file\" accept=\"image/*\" id=\"file\"><br>
                            <input type=\"submit\" name=\"submit\" value=\"Submit\">
                        </form>
                    </div>";
                break;
                
            default:
                # code...
                break;
        }
        print("</div>\n");
        
        // exit
        break;
        
    // Max Views
    case 'p_max_view':
    case 's_max_view':
        // in the case that thsi form is not editable, just put in the nav
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        echo "<p>p_max_view and s_max_view are not ready in sf_mediabrowser_download</p>";
        print("</div>\n");
        break;
        
    // no_results - in case there are no results
    case 'no_results':
        echo "<div id=\"sf_feedbuilder\" class=\"{$sf_cssclass}\">\n";
        echo "<p class=\"message\">$mk_norec</p>";
        echo "</div>\n";
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_feedbuilder\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for subform 'sf_feedbuilder' was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;
       
// ends switch
}

// clean up
unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);
unset ($alias_lang_info);

?>
