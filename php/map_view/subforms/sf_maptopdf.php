<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* map_view/subforms/sf_maptopdf.php
*
* a map subform for exporting a map to a pdf
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
* @link       http://ark.lparchaeology.com/svn/php/map_view/subforms/sf_maptopdf.php
* @since      File available since Release 0.8
*
* This SF is (as of v0.8) expected to run in an overlay. Standard states could be
* added to allow this to function as a normal SF if any reason for that became apparent.
*
* The update is handled by a companion update script. This SF provides the user interface
* and feedback.
*
* Getting the right sf_conf requires a small piece of non-standard behavoir. Typically,
* an SF will be passed an sf_conf to it in the form of $sf_conf and it is not required to
* question this. In the case of SFs displayed within the overlay_holder.php, this parent
* script must get an sf_conf based on the name of the variable passed to the querystring.
* As this form may be triggered from a non module specific page (eg data_view.php), it must
* figure out if the result set being exported is the same as the module that overlay_holder
* has selected. If not, the relevant settings file is called and the sf_conf is switched.
*
* NB: overlay_holder.php tries to figure out a module based on the sf_key it is sent. If
* it is not sent an sf_key, it will fall back on a default (as per reqArkVar()).
*
*/

// ---- SETUP ---- //
require('lib/php/fpdf/fpdf_alpha.php');

// request user input vars
$dl_mode = reqQst($_REQUEST, 'dl_mode');

// request variables
$title = reqQst($_REQUEST,'title');
$comment = reqQst($_REQUEST,'comment');
$expsize = reqQst($_REQUEST,'paper');

// ---- PROCESS ---- //
// despite being called update DB, this doesnt interact with the DB, it IS however a process script
$dl_success = FALSE;
if ($update_db === $sf_conf['sf_html_id']) {
    // request variables
    $exdpi = 150;
    $extents = reqQst($_REQUEST,'extents');
    $layers = reqQst($_REQUEST,'layers');
    $scale_text = reqQst($_REQUEST,'scale_text');
    $wms_url = reqQst($_REQUEST,'wms_url');

    // evaluate variables
    //title
    if (!$title) {
        $error[]['vars'] = 'The value "Title" was not set';
    }
    //comment
    if (!$comment) {
        $error[]['vars'] = 'The value "Comment" was not set';
    }
    //paper
    if (!$expsize) {
        $error[]['vars'] = 'The value "Papersize" was not set';
    }

    if (!is_array($error)) {
        // include the companion script
        include_once ('php/map_view/subforms/update_maptopdf.php');
        // flag process as underway
        $process = 'underway';
        // note, the updater will flag success or failure of this process
    } else {
        $process = FALSE;
    }
} else {
    $process = FALSE;
}

// ---- COMMON ---- //
// Labels and so on
$mk_waitmsg = getMarkup('cor_tbl_markup', $lang, 'waitmsg');
$mk_dlsucs = getMarkup('cor_tbl_markup', $lang, 'dlsucs');
$mk_dl = getMarkup('cor_tbl_markup', $lang, 'dl');
$mk_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_reqfileformat = getMarkup('cor_tbl_markup', $lang, 'reqfileformat');
$mk_dlinfo = getMarkup('cor_tbl_markup', $lang, 'dlinfo');
$mk_op_input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
$mk_op_label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);

$mk_name = getMarkup('cor_tbl_markup', $lang, 'map_name');
$mk_comments = getMarkup('cor_tbl_markup', $lang, 'map_comments');
$mk_papersize = getMarkup('cor_tbl_markup', $lang, 'papersize');

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
        $dl_mode = 'mapToPDF';
        // form
        $form = "<form method=\"$form_method\"";
        $form .= " id=\"export_download_overlay\" action=\"{$_SERVER['PHP_SELF']}\">";
        $form .= "<fieldset>";
        $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $form .= "<input type=\"hidden\" name=\"dl_mode\" value=\"$dl_mode\" />";
        $form .= "<input type=\"hidden\" name=\"lboxreload\" value=\"$lboxreload\" />";
        $form .= "<input type=\"hidden\" name=\"sf_key\" value=\"$sf_key\" />";
        $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"$sf_conf_name\" />";
        $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />";
        $form .= "<input id=\"extents\" type=\"hidden\" name=\"extents\" value=\"\" />";
        $form .= "<input id=\"scale_text\" type=\"hidden\" name=\"scale_text\" value=\"\" />";
        $form .= "<input id=\"layers\" type=\"hidden\" name=\"layers\" value=\"\" />";
        $form .= "<input id=\"wms_url\" type=\"hidden\" name=\"wms_url\" value=\"\" />";
        $form .= "<input id=\"tiles_json\" name=\"tiles_json\" type=\"hidden\" value=\"\" />";
        // Contain the input elements in a list
        $form .= "<ul>\n";
        $form .= "<li class=\"row\">";
        $form .= "<label class=\"form_label\">$mk_name</label>";
        $form .= "<span class=\"inp\"><textarea id=\"map_name\" name=\"title\">$title</textarea></span>";
        $form .= "</li>\n";
        $form .= "<li class=\"row\">";
        $form .= "<label class=\"form_label\">$mk_comments</label>";
        $form .= "<span class=\"inp\"><textarea id=\"map_comments\" name=\"comment\">$comment</textarea></span>";
        $form .= "</li>\n";
        $form .= "<li class=\"row\">";
        $form .= "<label class=\"form_label\">$mk_papersize</label>";
        $form .= "<select name=\"paper\">";
        //$form .= "<option value=\"A4\">A4</option>";
        $form .= "<option value=\"A3\">A3</option>";
        //$form .= "<option value=\"A4\">A4</option>";
        $form .= "</select>";
        $form .= "</li>\n";
        $form .= "<li class=\"row\">";
        $form .= "<label class=\"form_label\">$mk_op_label</label>";
        $form .= "<span class=\"inp\"><button type=\"submit\"";
        // on click, this will pass the action to the companion update script (called above)
        // and the JS script will display the waiting message until the update is done
        $form .= " onclick=\"loadingScreen(document.getElementById('js_waiting_message'), document.getElementById('form_holder'))\">";
        $form .= "$mk_op_input</button></span>";
        $form .= "</li>\n";
        $form .= "</ul>\n";
        $form .= "</fieldset>";
        $form .= "</form>\n";
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
            // return feedback to the user
            if ($dl_success) {
                // echo a success message and offer the file for download
                //echo "<h4>$mk_title</h4>";
                echo "<p class=\"downloadinfo\">$mk_dlsucs</p>";
                echo "<div class=\"download\"><a href=\"download.php?fullpath=1&amp;file=$file\">$mk_dl</a></div>\n";
            } else {
                // printPre($error);
                // Note: a more sophisticated 'fail' message would fit here
                // in the meantime, the standard error feedback is already provided (above)
            }
        } else {
            // provide some help and user input
            echo "<div id=\"js_waiting_message\" style=\"display:none\">&nbsp;</div>";
            echo "<div id=\"form_holder\">";
            echo "$js_wait_script\n";
           // echo "<h4>$mk_title</h4>";
            //echo "<p class=\"downloadinfo\">{$mk_reqfileformat}: {$dl_mode}</p>";
            //echo "<p class=\"downloadinfo\">{$mk_dlinfo}</p>";
            echo "$form\n";
            //now fill in the hidden values
            print("<script> 
                extent =  parent.map.getExtent();
                document.getElementById('extents').value = extent.left + ',' + extent.bottom + ',' + extent.right + ',' + extent.top;
                layers = parent.map.layers;
                layer_value = '';
                for (i in layers) {
                    if (typeof layers[i] == 'object' && layers[i].params != null) {
                        
                        if (layers[i].getVisibility() == true && layers[i].params.LAYERS != undefined) {
                            layer_value = layer_value + ',' + layers[i].params.LAYERS;
                        }
                        if (i == layers.length-1) {
                            if (layers[i].getURL(parent.map.getExtent()).substr(0,4) == 'http') {
                                old_layer_param = layers[i].params.LAYERS;
                                layers[i].params.LAYERS = layer_value.substr(1);
                                wms_url = layers[i].getURL(parent.map.getExtent());
                                layers[i].params.LAYERS = old_layer_param;
                            }
                        }
                    } 
                }
                layer_value = layer_value.substr(1);
                document.getElementById('layers').value = layer_value;
                document.getElementById('wms_url').value = wms_url;
                scale_text = parent.document.getElementById('scaleText').innerHTML;
                document.getElementById('scale_text').value = scale_text;

            </script>");
            echo "</div>";
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
        echo "</p>p_max_view and s_max_view are not ready in sf_export_download</p>";
        print("</div>\n");
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_maptopdf\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_maptopdf was incorrectly set</p>\n";
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
