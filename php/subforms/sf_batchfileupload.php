<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* subforms/sf_batchfileupload.php
*
* a form (usually used in overlay_holder) to upload files in a batch
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
* @copyright  1999-2012 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_batchfileupload.php
* @since      File available since Release 1.1
*
* This SF is expected to run in an overlay. Standard states could be added to allow this
* to function as a normal SF if any reason for that became apparent.
*
* The form is a multi-part form that undertakes the uploading and processing of files
*
* The sf_conf is very generic, requires no fields and can be assumed to sit in page_settings
*
* NB: overlay_holder.php will try to figure out a module based on the sf_key it is sent. If
* it is not sent an sf_key, it will fall back on a default (as per reqArkVar()).
*
*/

// ---- SETUP ---- //

// the first thing we need to do is figure out what upload we are on 
// and that will let us know what we need to request
$upload_method = reqQst($_REQUEST, 'upload_method');

//then we need to figure out what step we are on
$step = reqQst($_REQUEST, 'sf_step');
if (!$step) {
    $step = 1;
}
$sf_conf_name = reqQst($_REQUEST, 'sf_conf');
$current_form = reqQst($_REQUEST, 'current_form');
if (!$current_form) {
    $current_form = '';
}

$dir = reqQst($_REQUEST, 'dir');
if (!$dir) {
    $dir = $default_upload_dir;
}
$upload_dir = reqQst($_REQUEST, 'upload_dir');
$upload_url = reqQst($_REQUEST, 'upload_url');

$process = FALSE;


//filetype
$filetype = reqQst($_REQUEST, 'filetype');
if (!is_numeric($filetype) && $filetype != FALSE) {
    $filetype = getSingle('id', 'cor_lut_filetype', "filetype = \"$filetype\"");
}

//batch
$batch = reqQst($_REQUEST, 'batch_name');
if (!$batch) {
    $batch = '';
}

//ste_cd
$ste_cd = reqQst($_REQUEST, 'ste_cd');
if (!$ste_cd) {
    $ste_cd = $default_site_cd;
}

//module
$module = reqQst($_REQUEST, 'module');
if (!$module) {
    $module = '';
}
//modtype
$modtype = reqQst($_REQUEST, 'modtype');
if (!$modtype) {
    $modtype = '';
}

//pattern
$pattern = reqQst($_REQUEST, 'pattern_name');

//lboxreload - what happens when we shut the overlay?
$lboxreload = reqQst($_REQUEST, 'lboxreload');


// ---- COMMON ---- //
// Labels and so on
$mk_files_uploaded = getMarkup('cor_tbl_markup', $lang, 'files_uploaded');
$mk_no_files = getMarkup('cor_tbl_markup', $lang, 'no_files');
$mk_batch_instructions_pt1 = getMarkup('cor_tbl_markup', $lang, 'batch_instructions_pt1');
$mk_batch_instructions_pt2 = getMarkup('cor_tbl_markup', $lang, 'batch_instructions_pt2');
$mk_batch_instructions_s = getMarkup('cor_tbl_markup', $lang, 'batch_instructions_s');
$mk_batch_instructions_a = getMarkup('cor_tbl_markup', $lang, 'batch_instructions_a');
$mk_batch_instructions_c = getMarkup('cor_tbl_markup', $lang, 'batch_instructions_c');
$mk_batch_instructions_l = getMarkup('cor_tbl_markup', $lang, 'batch_instructions_l');
$mk_formupload_instructions = getMarkup('cor_tbl_markup', $lang, 'formupload_instructions');
$mk_batchname = getMarkup('cor_tbl_markup', $lang, 'batchname');
$mk_module = getMarkup('cor_tbl_markup', $lang, 'module');
$mk_moduletype = getMarkup('cor_tbl_markup', $lang, 'modtype');
$mk_filetype = getMarkup('cor_tbl_markup', $lang, 'filetype');
$mk_pattern = getMarkup('cor_tbl_markup', $lang, 'pattern');
$mk_ste = getMarkup('cor_tbl_markup', $lang, 'ste_cd');
$mk_upload_method = getMarkup('cor_tbl_markup', $lang, 'upload_method');
$mk_fu_simple = getMarkup('cor_tbl_markup', $lang, 'fu_simple');
$mk_fu_autoreg = getMarkup('cor_tbl_markup', $lang, 'fu_autoreg');
$mk_fu_links = getMarkup('cor_tbl_markup', $lang, 'fu_links');
$mk_fu_linkedonly = getMarkup('cor_tbl_markup', $lang, 'fu_linkedonly');
$mk_curuploaddir = getMarkup('cor_tbl_markup', $lang, 'curuploaddir');
$mk_waitmsg = getMarkup('cor_tbl_markup', $lang, 'waitmsg');
$mk_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_batchurl = getMarkup('cor_tbl_markup', $lang, 'batchurl');
$mk_uploadthisdir = getMarkup('cor_tbl_markup', $lang, 'uploadthisdir');
$mk_uploadmissing = getMarkup('cor_tbl_markup', $lang, 'uploadmissing');
$mk_uploadfromfolder = getMarkup('cor_tbl_markup', $lang, 'batch_uploadfromfolder');
$mk_uploadbyurl = getMarkup('cor_tbl_markup', $lang, 'batch_uploadbyurl');
$mk_batch_instructions_step2 = getMarkup('cor_tbl_markup', $lang, 'batch_instructions_step2');

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

//setup the JS for making the forms appear or disappear
$js_expand_script = "<script type=\"text/javascript\">";
$js_expand_script .= "    function expandUploadForm(id){
                              //get all of the forms on the page
                              jQuery.each(jQuery('.batch_forms'), function(key,div){
                                  if (div.id != id) {
                                      div.hide('fast');
                                  } else {
                                      div.show('slow');
                                  }
                              });
                          }
                          
                          function showModtype(select){
                              //first hide and disable all the modtype forms
                              jQuery.each(jQuery('.batch_hidden_row'), function(key,li){
                                  li.hide('fast');
                               }
                              );
                              jQuery.each(jQuery('[name=\"modtype\"]'), function(key,select){
                                  jQuery(select).attr('disabled', 'disabled');
                               }
                              );
                               //now show the selected modtype form
                               selected_val = jQuery(select).val();
                               modtype_li = jQuery('#' + selected_val);
                               select = modtype_li.find('select');
                               select.removeAttr(\"disabled\");
                               modtype_li.show();
                           }
                           
                          jQuery(document).ready(function(){
                               jQuery.each(jQuery('.batch_forms'), function(key,div){
                                   if (div.id != '$current_form') {
                                       div.hide('fast');
                                   }
                                }
                               );
                               jQuery.each(jQuery('[name=\"module\"]'), function(key,select){
                                    jQuery(select).change(function() {
                                      showModtype(select);
                                    });
                                 }
                               );
                               jQuery.each(jQuery('.batch_hidden_row'), function(key,li){
                                   li.hide('fast');
                                }
                               );
                               jQuery.each(jQuery('[name=\"modtype\"]'), function(key,select){
                                   select.attr('disabled', 'disabled');
                                }
                               );
                          });
";
$js_expand_script .= "</script>";

// ---- STATE SPECFIC
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
        /*this form is really only ever used in overlay mode - it has a number of different steps
         * 1. Choose the location from which to upload files
         * 2. Choose the upload method and supply the correct options for each upload method
         * 3. Run a Dry Run of the process and output the results
         * 4. Run the process itself and output the results
        */
        
        // PROCESS routine | USER INPUT routine (depending on progress)
        //now we need to evaluate that we have all the correct variables for the proposed method
        //if we don't then we reset the step and send the user back - with a useful message!
        if ($step == 2) {
            //by this step we just need the upload directory - so check that
            if (!$upload_url && !$upload_dir) {
                $error[]['vars'] = $mk_uploadmissing;
                $step = 1;
            }
            //if we have a URL check it is valid
            if ($upload_url) {
                if (!@file_get_contents($upload_url)) {
                    $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'unreadableurl');
                    $step = 1;
                }
            }
        }
        if ($step == 3 || $step == 4) {
            //this is upload method specific
            switch ($upload_method) {
                case 's':
                    if (!$batch) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nobatch');
                    }
                    if (!$filetype) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nofiletype');
                    }
                    if (!$ste_cd) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nostecd');
                    }
                    //if there are any errors then we need to flag them up and send the user back a step
                    //otherwise either run the Dry Run - or run the process itself
                    if (is_array($error)) {
                        $step = 2;
                    } else {
                        $process = TRUE;
                    }
                    break;
                case 'a':
                    if (!$batch) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nobatch');
                    }
                    if (!$filetype) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nofiletype');
                    }
                    if (!$ste_cd) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nostecd');
                    }
                    if (!$module) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nomodule');
                    }
                    //if there are any errors then we need to flag them up and send the user back a step
                    //otherwise either run the Dry Run - or run the process itself
                    if (is_array($error)) {
                        $step = 2;
                    } else {
                        $process = TRUE;
                    }
                    break;
                case 'l':
                    if (!$batch) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nobatch');
                    }
                    if (!$filetype) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nofiletype');
                    }
                    if (!$ste_cd) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nostecd');
                    }
                    if (!$pattern) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nopattern');
                    }
                    //if there are any errors then we need to flag them up and send the user back a step
                    //otherwise either run the Dry Run - or run the process itself
                    if (is_array($error)) {
                        $step = 2;
                    } else {
                        $process = TRUE;
                    }
                    break;
                case 'c':
                    if (!$batch) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nobatch');
                    }
                    if (!$filetype) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nofiletype');
                    }
                    if (!$ste_cd) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nostecd');
                    }
                    if (!$pattern) {
                        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nopattern');
                    }
                    //if there are any errors then we need to flag them up and send the user back a step
                    //otherwise either run the Dry Run - or run the process itself
                    if (is_array($error)) {
                        $step = 2;
                    } else {
                        $process = TRUE;
                    }
                    break;
                
                default:
                    $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'nouploadmethod');
                    $step = 2;
                    break;
            }
    
        }
        
        if ($process == TRUE) {
            if ($step == 3) {
                if ($upload_url) {
                    $upload_location = $upload_url;
                } else {
                    $upload_location = $upload_dir;
                }
                $upload_results = 
                    processFilesDry(
                        $upload_location,
                        $batch,
                        $module,
                        $cre_by,
                        'NOW()',
                        $thumbnail_sizes,
                        $registered_files_dir
                );
                $results_table = mkUploadResultsTable($upload_results,TRUE);
            }
            if ($step == 4) {
                if ($upload_url) {
                    $upload_location = $upload_url;
                } else {
                    $upload_location = $upload_dir;
                }
                $upload_results = 
                    processFiles(
                        $upload_location,
                        $batch,
                        $module,
                        $cre_by,
                        'NOW()',
                        $thumbnail_sizes,
                        $registered_files_dir
                );
                $results_table = mkUploadResultsTable($upload_results);
            }
        }
        
        // output
        echo $js_wait_script;
        echo $js_expand_script;
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        echo "<div id=\"js_waiting_message\" style=\"display:none\">&nbsp;</div>";
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        
        //now lets setup the content dependent on the step we are on
        switch ($step) {
            case 1: //choose a folder of files
                //there are two ways to choose a folder - this can either be done via a URL 
                //or it can be navigated to via a directory browser
                $step = $step + 1;
                $var = "<div><p class='batch_form_message'>$mk_batch_instructions_pt1</p>";
                $var .= "<button id='url' class='batch_bigbtn' onclick='expandUploadForm(this.id)'>$mk_uploadbyurl</button></div>";
                //first offer the URL option
                //create a very simple form for the URL
                $var .= "<div id='url' class=\"batch_forms\">";
                $input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
                $form = "<form method=\"$form_method\" id=\"url_browser_form\" action=\"{$_SERVER['PHP_SELF']}\">";
                $form .= "<fieldset>";
                $form .= "<input type=\"hidden\" name=\"lboxreload\" value=\"$lboxreload\" />";
                $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"$sf_conf_name\" />";
                $form .= "<input type=\"hidden\" name=\"sf_step\" value=\"$step\" />";
                $form .= "<input type=\"hidden\" name=\"current_form\" value=\"url\" />";
                // get current vals
                $form_val = "<input type=\"text\" class=\"txt\" name=\"upload_url\"/>";
                $form .= "<ul>";
                $form .= "<li class=\"row\">";
                $form .= "<label class=\"form_label\">$mk_batchurl</label>";
                $form .= "<span class=\"inp\">$form_val<button>$input</button></span>";
                $form .= "</li>\n";
                $form .= "</ul>\n";
                $form .= "</fieldset>";
                $form .= "</form>\n";
                $var .= $form;
                $var .= "</div>";
                $var .= "<div><p class='batch_form_message'>$mk_batch_instructions_pt2</p>";
                $var .= "<button id='file_browser' class='batch_bigbtn' onclick='expandUploadForm(this.id)'>$mk_uploadfromfolder</button></div>";
                $var .= "<div id='file_browser' class=\"batch_forms\">";
                $var .= "<div class='fb_container'>";
                echo $var;
                // include the file browser
                //we will need to send it the full qs as it is as PHP-based filebrowser and therefore reloads on each click
                $qs = "&lboxreload=$lboxreload&sf_conf=$sf_conf_name&sf_step=1&current_form=file_browser";
                include('lib/php/file_browser.php');
                $var = "</div>";
                $var .= "<label class=\"form_label\">$mk_curuploaddir</label>";
                $var .= "<span class=\"value\">$dir <a href=\"{$_SERVER['PHP_SELF']}?lboxreload=$lboxreload&sf_conf=$sf_conf_name&sf_step=$step&upload_dir=$dir\"><button>$mk_uploadthisdir</button></a></span>";
                $var .= "</div>";
                echo $var;
                break;
                
            case 2: //choose an upload method and its associated variables
                //now that we have a URL or an upload directory we can decide what type of upload we want to do
                //first double-check we have an upload directory or URL - otherwise send the user back
                if (!$upload_url && !$upload_dir) {
                    $var = "<div>";
                    $var .= "$mk_uploadmissing<a href=\"{$_SERVER['PHP_SELF']}?lboxreload=$lboxreload&sf_conf=$sf_conf_name&sf_step=1\"><button>$mk_input</button></a>";
                    $var .= "</div>";
                    echo $var;
                } else {
                    //this is a set of four buttons with associated forms - 
                    //the forms will only become visible when the button is pressed
                    $step = $step+1;
                    $var = "<p class='batch_form_message'>$mk_batch_instructions_step2$upload_dir</p>";
                    //first we build the forms - common elements
                    $file_dd = ddSimple('', $filetype, 'cor_lut_filetype', 'filetype', 'filetype', 'filetype');
                    $ste_dd = ddSimple('', $ste_cd, 'cor_tbl_ste', 'id', 'ste_cd', 'id');
                    $mod_dd = ddAlias('', $module, 'cor_tbl_module', $lang, 'module', FALSE, 'code', 'shortform');
                    $form_hidden_vars = "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />";
                    $form_hidden_vars .= "<input type=\"hidden\" name=\"lboxreload\" value=\"$lboxreload\" />";
                    $form_hidden_vars .= "<input type=\"hidden\" name=\"sf_conf\" value=\"$sf_conf_name\" />";
                    $form_hidden_vars .= "<input type=\"hidden\" name=\"sf_step\" value=\"$step\" />";
                    $form_hidden_vars .= "<input type=\"hidden\" name=\"upload_dir\" value=\"$upload_dir\" />";
                    $form_hidden_vars .= "<input type=\"hidden\" name=\"upload_url\" value=\"$upload_url\" />";
                    if (!$filetype) {
                        // batch
                        $form_filetype = "<li class=\"row\"><label class=\"form_label\">$mk_filetype</label>";
                        $form_filetype .= "<span class=\"inp\">";
                        $form_filetype .= $file_dd;
                        $form_filetype .= "</span></li>\n";
                    } else {
                        $form_hidden_vars .= "<input type=\"hidden\" name=\"filetype\" value=\"$filetype\" />";
                        $form_filetype = ''; 
                    }
                    // batch
                    $form_batch = "<li class=\"row\"><label class=\"form_label\">$mk_batchname</label>";
                    $form_batch .= "<span class=\"inp\">";
                    $form_batch .= "<input type=\"text\" value=\"$batch\" name=\"batch_name\" />";
                    $form_batch .= "</span></li>\n";
                    // module
                    $form_module = "<li class=\"row\"><label class=\"form_label\">$mk_module</label>";
                    $form_module .= "<span class=\"inp\">";
                    $form_module .= $mod_dd;
                    $form_module .= "</span></li>\n";
                    // ste_cd
                    $form_stecd = "<li class=\"row\"><label class=\"form_label\">$mk_ste</label>";
                    $form_stecd .= "<span class=\"inp\">";
                    $form_stecd .= $ste_dd;
                    $form_stecd .= "</span></li>\n";
                    // a standard button and label to submit the form
                    $input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
                    $form_submit = "<li class=\"row\">";
                    $form_submit .= "<span class=\"inp\">";
                    $form_submit .= "<button type=\"submit\" onclick=\"loadingScreen(document.getElementById('js_waiting_message'), document.getElementById('form_holder'))\">$input</button>";
                    $form_submit .= "</span></li>\n";
                    
                    //SIMPLE UPLOAD
                    
                    $form_hidden_vars .= "<input type=\"hidden\" name=\"current_form\" value=\"s\" />";
                    
                    //first the button
                    $var .= "<div class='batch_form_wrapper'>";
                    $var .= "<p class='batch_form_message'>$mk_batch_instructions_s</p>";
                    $var .= "<button id='s' class='batch_bigbtn' onclick='expandUploadForm(this.id)'>$mk_fu_simple</button>";
                    $var .= '<div id="s" class="batch_forms">';
                    $var .= "<p class='batch_form_message'>This form is for uploading in simple terms izzit</p>";
                    
                    // output the form
                    $form = "<form method=\"$form_method\" id=\"s\" action=\"{$_SERVER['PHP_SELF']}\">";
                    $form .= "<fieldset>";
                    $form .= $form_hidden_vars;
                    $form .= "<input type=\"hidden\" name=\"upload_method\" value=\"s\" />";
                    $form .= "<ul>";
                    $form .= $form_filetype;
                    $form .= $form_batch;
                    $form .= $form_stecd;
                    $form .= $form_submit;
                    $form .= "</ul>";
                    $form .= "</fieldset>";
                    $form .= "</form>";
                    $var .= $form;
                    $var .= "</div>";
                    $var .= "</div>";
                    
                    //AUTOREGISTER
                    
                    $form_hidden_vars .= "<input type=\"hidden\" name=\"current_form\" value=\"a\" />";
                    
                    //because AutoRegister requires a modtype - we are going to need to make up a bunch of dds foreach
                    //of the modules that need a modtype - that can be laoded dynamically when the option is chosen in
                    //the module drop down
                    //so grab the modules
                    $modtype_dds = array();
                    foreach ($loaded_modules as $key => $value) {
                        if (chkModType($value)) {
                            $tbl = $value.'_lut_'.$value.'type';
                            $modtype_dd = ddAlias('----', FALSE, $tbl, $lang, 'modtype', FALSE, 'code', 'id');
                            $form_modtype = "<li id=\"$value\" class=\"batch_hidden_row\">";
                            $form_modtype .= "<label class=\"form_label\">$mk_moduletype</label>";
                            $form_modtype .= "<span class=\"inp\">";
                            $form_modtype .= $modtype_dd;
                            $form_modtype .= "</span></li>\n";
                            $modtype_dds[$value] = $form_modtype;
                        } 
                    }
                    
                    // check to see if patterns are in play and if so put in the appropriate form elements
                    if (is_array($fu) && $fu['on'] == TRUE) {
                        // if we haven't had a regex pattern pre-set by the admin
                        // offer the choice of pattern here - so grab the fu 
                        // array and make up a dropdown
                        if (!$pattern) {
                            $pattern_dd = "<select name=\"pattern_name\">";
                            $pattern_dd .= "<option value=\"\">---select---</option>\n";
                            foreach ($fu['pattern'] as $key => $value) {
                                $pattern_dd .= "<option value=\"$key\">$key</option>\n";
                            }
                            $pattern_dd .= '</select>';
                            // module
                            $form_pattern = "<li class=\"row\"><label class=\"form_label\">$mk_pattern</label>";
                            $form_pattern .= "<span class=\"inp\">";
                            $form_pattern .= $pattern_dd;
                            $form_pattern .= "</span></li>\n";
                        } else {
                            $form_hidden_vars .= "<input type=\"hidden\" name=\"pattern\" value=\"$pattern\" />";
                            $form_pattern = FALSE;
                        }
                    } else {
                        $form_pattern = FALSE;
                    }
                    //first the button
                    $var .= "<div class='batch_form_wrapper'>";
                    $var .= "<p class='batch_form_message'>$mk_batch_instructions_a</p>";
                    $var .= "<button id='a' class='batch_bigbtn' onclick='expandUploadForm(this.id)'>$mk_fu_autoreg</button>";
                    $var .= '<div id="a" class="batch_forms">';
                    $var .= "<p class='batch_form_message'>This form is for doing an autoregister</p>";
                    
                    // output the form
                    $form = "<form method=\"$form_method\" id=\"a\" action=\"{$_SERVER['PHP_SELF']}\">";
                    $form .= "<fieldset>";
                    $form .= $form_hidden_vars;
                    $form .= "<input type=\"hidden\" name=\"upload_method\" value=\"a\" />";
                    $form .= "<ul>";
                    $form .= $form_filetype;
                    $form .= $form_batch;
                    $form .= $form_stecd;
                    $form .= $form_pattern;
                    $form .= $form_module;
                    //at this point we pop in the modtype_dds if we need them
                    if (!empty($modtype_dds)) {
                        foreach ($modtype_dds as $value) {
                            $form .= $value;
                        }
                    }
                    $form .= $form_submit;
                    $form .= "</ul>";
                    $form .= "</fieldset>";
                    $form .= "</form>";
                    $var .= $form;
                    $var .= "</div>";
                    $var .= "</div>";
                    
                    //CREATE LINKS and LINKED ONLY
                    
                    //first we need to check if we have an fu array set - if not (or the advanced options are off)
                    //then don't even bother putting in the other options
                    
                    if (is_array($fu) && $fu['on'] == TRUE) {
                        // if we haven't had a regex pattern pre-set by the admins we are
                        // going to want to offer the choice of pattern here - so grab the fu 
                        // array and make up a dropdown
                        if (!$pattern) {
                            $pattern_dd = "<select name=\"pattern_name\">";
                            $pattern_dd .= "<option value=\"\">---select---</option>\n";
                            foreach ($fu['pattern'] as $key => $value) {
                                $pattern_dd .= "<option value=\"$key\">$key</option>\n";
                            }
                            $pattern_dd .= '</select>';
                            // module
                            $form_pattern = "<li class=\"row\"><label class=\"form_label\">$mk_pattern</label>";
                            $form_pattern .= "<span class=\"inp\">";
                            $form_pattern .= $pattern_dd;
                            $form_pattern .= "</span></li>\n";
                        } else {
                            $form_hidden_vars .= "<input type=\"hidden\" name=\"pattern\" value=\"$pattern\" />";
                            $form_pattern = FALSE;
                        }
                        
                        //CREATE LINKS
                        $form_hidden_vars .= "<input type=\"hidden\" name=\"current_form\" value=\"c\" />";
                        //first the button
                        $var .= "<div class='batch_form_wrapper'>";
                        $var .= "<p class='batch_form_message'>$mk_batch_instructions_c</p>";
                        $var .= "<button id='c' class='batch_bigbtn' onclick='expandUploadForm(this.id)'>$mk_fu_links</button>";
                        $var .= '<div id="c" class="batch_forms">';
                        // output the form
                        $form = "<form method=\"$form_method\" id=\"c\" action=\"{$_SERVER['PHP_SELF']}\">";
                        $form .= "<fieldset>";
                        $form .= $form_hidden_vars;
                        $form .= "<input type=\"hidden\" name=\"upload_method\" value=\"c\" />";
                        $form .= "<ul>";
                        $form .= $form_filetype;
                        $form .= $form_batch;
                        $form .= $form_stecd;
                        $form .= $form_pattern;
                        $form .= $form_module;
                        $form .= $form_submit;
                        $form .= "</ul>";
                        $form .= "</fieldset>";
                        $form .= "</form>";
                        $var .= $form;
                        $var .= "</div>";
                        $var .= "</div>";

                        //LINKED FILES ONLY
                        $form_hidden_vars .= "<input type=\"hidden\" name=\"current_form\" value=\"l\" />";
                        //first the button
                        $var .= "<div class='batch_form_wrapper'>";
                        $var .= "<p class='batch_form_message'>$mk_batch_instructions_l</p>";
                        $var .= "<button id='l' class='batch_bigbtn' onclick='expandUploadForm(this.id)'>$mk_fu_linkedonly</button>";
                        $var .= '<div id="l" class="batch_forms">';
                        // output the form
                        $form = "<form method=\"$form_method\" id=\"l\" action=\"{$_SERVER['PHP_SELF']}\">";
                        $form .= "<fieldset>";
                        $form .= $form_hidden_vars;
                        $form .= "<input type=\"hidden\" name=\"upload_method\" value=\"l\" />";
                        $form .= "<ul>";
                        $form .= $form_filetype;
                        $form .= $form_batch;
                        $form .= $form_stecd;
                        $form .= $form_pattern;
                        $form .= $form_module;
                        $form .= $form_submit;
                        $form .= "</ul>";
                        $form .= "</fieldset>";
                        $form .= "</form>";
                        $var .= $form;
                        $var .= "</div>";
                        $var .= "</div>";
                    }
                }
                
                
                echo $var;
                break;
            case 3: //run a dry run
                $mk_back = getMarkup('cor_tbl_markup', $lang, 'back');
                $mk_runliveadd = getMarkup('cor_tbl_markup', $lang, 'runliveadd');
                $mk_dryrunresults = getMarkup('cor_tbl_markup', $lang, 'dryrunresults');
                if ($results_table) {
                    $step = $step + 1;
                    $var = "<p class=\"batch_form_message\">$mk_dryrunresults</p>";
                    $var .= $results_table;
                }
                //put in a button to run the Live Add
                $var .= "<div>";
                $var .= "<a href=\"{$_SERVER['PHP_SELF']}?lboxreload=$lboxreload&sf_conf=$sf_conf_name&sf_step=2&upload_url=$upload_url&upload_dir=$upload_dir&module=$module&batch_name=$batch&ste_cd=$ste_cd&filetype=$filetype&pattern_name=$pattern&upload_method=$upload_method&current_form=$current_form\"><button>$mk_back</button></a>";
                 $var .= "<a href=\"{$_SERVER['PHP_SELF']}?lboxreload=$lboxreload&sf_conf=$sf_conf_name&sf_step=$step&upload_dir=$upload_dir&upload_url=$upload_url&module=$module&modtype=$modtype&batch_name=$batch&ste_cd=$ste_cd&filetype=$filetype&pattern_name=$pattern&upload_method=$upload_method\"><button onclick=\"loadingScreen(document.getElementById('js_waiting_message'), document.getElementById('form_holder'))\">$mk_runliveadd</button></a>";
                $var .= "</div>";
                echo $var;
                break;
            case 4: //run the live add
                $mk_liveaddresults = getMarkup('cor_tbl_markup', $lang, 'liveaddresults');
                if ($results_table) {
                    $var = "<p class=\"batch_form_message\">$mk_liveaddresults</p>";
                    $var .= $results_table;
                    echo $var;
                }
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
        echo "<div id=\"sf_batchfileupload\" class=\"{$sf_cssclass}\">\n";
        echo "<p class=\"message\">$mk_norec</p>";
        echo "</div>\n";
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_batchfileupload\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for subform 'sf_batchfileupload' was incorrectly set</p>\n";
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
