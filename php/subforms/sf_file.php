<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* subforms/sf_file.php
*
* global subform for dealing with files
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
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2012 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_file.php
* @since      File available since Release 0.6
*
*/


// ---- SETUP ---- //
// op_modtype
if (array_key_exists('op_modtype', $sf_conf)) {
    $modtype = $sf_conf['op_modtype'];
} else {
    $modtype = FALSE;
}
// If modtype is FALSE the fields will only come from one list , if TRUE the 
// fields will come from different field lists. 
if (chkModType($mod_short) && $modtype!=FALSE) {
    $modtype = getModType($mod_short, $sf_val);
    $fields = $sf_conf["type{$modtype}_fields"];
} else {
    $fields = $sf_conf['fields'];
}

// op_sf_cssclass
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// Check that the registered files (host) path has been configured
if ($registered_files_path) {
    $file_host = $registered_files_path;
} else {
    $doc = "http://ark.lparchaeology.com/wiki/index.php/Env_settings.php#.24registered_files_host";
    echo "ADMIN ERROR: registered_files_path is not set. See: $doc<br/>";
    unset ($doc);
}
// Check that the registered files dir path has been configured
if ($registered_files_dir) {
    $file_host = $registered_files_dir;
} else {
    $doc = "http://ark.lparchaeology.com/wiki/index.php/Env_settings.php#.24registered_files_dir";
    echo "ADMIN ERROR: registered_files_dir is not set. See: $doc<br/>";
    unset ($doc);
}

// Get the settings for the files display
// If no settings are included use thumbnails as default
if (array_key_exists('op_display', $sf_conf)) {
    $sf_display = $sf_conf['op_display'];
} else {
    $sf_display = 'thumbs';
}


// ---- PROCESS ---- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id'] && $sf_state != 'transclude') {
    include_once ('php/update_db.php');
}


// ---- COMMON ---- //
// get common elements for all states
// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_no_file = getMarkup('cor_tbl_markup', $lang, 'nofiles');
$mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
if (array_key_exists('op_label', $sf_conf)) {
    $label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);
}
if (array_key_exists('op_input', $sf_conf)) {
    $input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
}
$mk_download = getMarkup('cor_tbl_markup',$lang,'download');

// -- OUTPUT -- //
// An output $var
$var = FALSE;


// -- STATE SPECFIC -- //
// for each state get specific elements and then produce output
switch ($sf_state) {
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        // start the SF
        $var .= "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        $var .= sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        $var .= '</div>';
        break;
        
    case 'p_max_view':
    case 's_max_view':
        // start the SF
        $var .= "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        $var .= sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }    
        // process the fields array
        $fields = resTblTh($fields, 'silent');
        // Set up variables
        $files = array();
        $files_temp = array();
        foreach ($fields as $field) {
            // get existing data
            $files_temp = getFile($sf_key, $sf_val,$field['classtype']);
            // test if there are any files
            if (is_array($files_temp)){
                // link the $field to each file returned
                foreach ($files_temp as $key=>$val){
                    $files_temp[$key]['field']=$field;     
                }
            }
            // package this up into the field so it can be sent to frmElem()
            if(!empty($files_temp)){
                if (!empty($files)) {
                    $files = array_merge($files,$files_temp); 
                    $field['current'] = $files;
                } else {
                    $files = $files_temp;
                    $field['current'] = FALSE;
                }
            }
        }
        if (!empty($files)) {
            // Switch the display based on the subform settings
            switch ($sf_display) {
                case 'imageflow':
                    $var .= "
                            <script type=\"text/javascript\" src=\"$ark_root_path/js/imageflow/imageflow.js\"></script>
                            <div id=\"imageflow\">
                                <div id=\"flowloading\">
                                    <b>Loading images</b><br/>
                                    <img src=\"$ark_root_path/js/imageflow/loading.gif\" width=\"208\" height=\"13\" alt=\"loading\" />
                                </div>";
                    $var .= '   <div id="images">';
                    
                    foreach ($files as $key => $file) {
                        $file_ext = end(explode('.', $file['filename']));
                        $var .= "<a class=\"imagebox\" href=\"{$registered_files_path}/webthumb_{$file['id']}.jpg\" title=\"{$file['filename']}\" >";
                        $var .= "<img id=\"image\" src=\"$ark_root_path/js/imageflow/reflect.php?img={$registered_files_dir}/arkthumb_{$file['id']}.jpg\"";
                        $var .= " alt=\"{$file['filename']}\" long_desc=\"$file_host/{$file['id']}.{$file_ext}\" /> \n</a>";
                    }
                    $var .= '</div>
                            <div id="captions"></div>
                            <div id="scrollbar">
                                <div id="slider"></div>
                            </div>
                            </div>';
                    $mk_download = getMarkup('cor_tbl_markup',$lang,'download');
                    $var .= "<div id=\"download_file\"><a>$mk_download : </a></div>";
                    //$var .= "<script  type=\"text/javascript\">load_imageflow();</script>\n";
                    break;
                    
                default:
                case 'thumbs':
                    $var .= "<ul>";
                    foreach ($files as $key => $file) {
                        $file_ext = strtolower(end(explode('.', $file['filename'])));
                        //check for the thumbnail - if there isn't one then just put in the default
                        if (!file_exists("{$registered_files_dir}/arkthumb_{$file['id']}.jpg")) {
                            $thumb_src = mkThumb($file, 'arkthumb');
                            $webthumb_src = "<li class=\"file_thumbs\">";
                        } else {
                            $thumb = mkThumb($file, 'arkthumb');
                            $thumb_src = "$thumb</a>";
                            $webthumb_src = "<li class=\"file_thumbs\"><a href=\"{$registered_files_path}/webthumb_{$file['id']}.jpg\" class=\"imagebox\" title=\"{$file['filename']}\">";
                        }
                        $var .= $webthumb_src;
                        $var .= $thumb_src;
                        //check if there is a uri - if so that is the link to the original file
                        if ($file['uri']) {
                           $var .= "<a href=\"{$file['uri']}\""; 
                        } else {
                            if (key_exists('op_hrname', $file['field'])){
                                $hrname = "&hrname=".$file['field']['op_hrname'];
                            } else {
                                $hrname = "";
                            }
                            $var .= "<a href=\"download.php?file={$file['id']}.{$file_ext}$hrname\"";
                        }
                        $var .= "alt=\"{$file['filename']}\">";
                        $var .= "<img src=\"$skin_path/images/results/download_sml.png\" alt=\"[$mk_download]\" title=\"Download\" class=\"med\" />";
                        $var .= "</a>";
                        $var .= "</li>";
                    }
                    $var .= "</ul>";
                break;
                case 'list':
                    $var .= "<ul>";
                    foreach ($files as $key => $file) {
                        $var .= "<li class=\"file_list\">";
                        $var .= "<a class=\"imagebox\" href=\"{$registered_files_path}/webthumb_{$file['id']}.jpg\"";
                        $var .= "alt=\"{$file['filename']}\" title=\"{$file['filename']}\">";
                        $var .= "{$file['filename']}</a>";
                        $var .= "<a href=\"download.php?file={$file['id']}.{$file_ext[1]}&hrname={$file['field']['op_hrname']}\"";  
                        $var .= "alt=\"{$file['filename']}\">";
                        $var .= "<img src=\"$skin_path/images/results/download_sml.png\" alt=\"[view]\" title=\"Download\" class=\"med\" />";
                        $var .= "</a>";
                        $var .= "</li>";
                    }
                    $var .= "</ul>";
                    break;
            }
        } else {
            $var .= "<ul><li class='row'><span class='value'>{$mk_no_file}</span></li></ul>";
        }
        // end the subform
        $var .= "</div>\n";
        break;
        
    case 'p_max_edit':
    case 's_max_edit':
    case 'p_max_ent':
        $var .= "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        $var .= sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }    
        // process the fields array
        $fields = resTblTh($fields, 'silent');
        // Set up variables
        $linked_files = array();
        $linked_files_temp = array();
        $batch = array();
        $batch_files_temp = array();
        // loop thru each field
        foreach ($fields as $field) {
            // get existing data
            $linked_files_temp = getFile($sf_key, $sf_val,$field['classtype']);
            // package this up into the field so it can be sent to frmElem()
            if(!empty($linked_files_temp)){
                if (!empty($linked_files)) {
                    $linked_files = array_merge($linked_files,$linked_files_temp); 
                    $field['current'] = $linked_files;
                } else {
                    $linked_files = $linked_files_temp;
                    $field['current'] = $linked_files;
                }
            }
            //check if we are looking for a specific filetype 
            $filetype = $field['classtype'];
            if ($filetype == 'file') {
                $filetype = 0;
            }
            if (!is_numeric($filetype)) {
                $filetype = getSingle('id','cor_lut_filetype',"filetype = '$filetype'");
            }
        }
        if (!empty($linked_files)) {
            $field['current'] = $linked_files;
            $field['routine'] = 'edt';
        }
        // let frmElem wrap the files
        $frm_var = frmElem($field, $sf_key, $sf_val);
        //now put in the currently linked files (as a form)
        $var .= "<div class=\"frm_subform\"><ul>\n";
        $var .= $frm_var;
        $var .= "</ul></div>\n";
        
        $var .= "</div>";
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_file\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for the sf_file subform was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
} // ends switch

echo $var;
unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);

?>
