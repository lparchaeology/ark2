<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_view/subforms/sf_feedbuilder.php
*
* a data_view subform for creating a feed from search criteria
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
* @link       http://ark.lparchaeology.com/svn/php/data_view/subforms/sf_feedbuilder.php
* @since      File available since Release 1.0
*
* This SF is expected to run in an overlay. Standard states could be added to allow this
* to function as a normal SF if any reason for that became apparent.
*
* The update is handled by a companion update script. This SF provides the user interface
* and feedback.
*
* The sf_conf is very generic, requires no fields and can be assumed to sit in page_settings
*
* NB: overlay_holder.php will try to figure out a module based on the sf_key it is sent. If
* it is not sent an sf_key, it will fall back on a default (as per reqArkVar()).
*
*/

// ---- SETUP ---- //
// include the export funcs
include_once('php/export_functions.php');
include_once('php/filter_functions.php');

// request user input vars
$feed_mode = reqQst($_REQUEST, 'feed_mode');
$feedtitle = reqQst($_REQUEST, 'feedtitle');
$feeddesc = reqQst($_REQUEST, 'feeddesc');

// Get filters from session
$filters = reqQst($_SESSION, 'filters');

// get the results_array from the session
$results_array = reqQst($_SESSION, 'unpaged_results_array');

// get the number of results "per page" from the session
$limit = reqArkVar('perpage', $conf_viewer_rows);

// get the disp_mode from the session
$disp_mode = reqArkVar('disp_mode', 'table');
$feeddisp_mode = $disp_mode;

// check that the results are good
if (!is_array($results_array)) {
    $sf_state = 'no_results';
} else {
    // SF_CONF
    // See notes above
    // find if the key in the results matches the mod we are on (probably the session mod)
    // get the first 'item' in the $results_array
    $item = reset($results_array);
    // get the itemkey of this item
    $actual_itemkey = $item['itemkey'];
    // compare the sf_key to the actually required key
    if ($sf_key != $actual_itemkey) {
        // switch to the correct sf_key (the form below will pass this on as the sf_key)
        $sf_key = $actual_itemkey;
    }
}

// ---- PROCESS ---- //
// despite being called update DB, this doesnt interact with the DB, it IS however a process script
$feed_success = FALSE;
if ($update_db === $sf_conf['sf_html_id']) {
    // include the companion script
    include_once ('php/data_view/subforms/update_feedbuilder.php');
    // flag process as underway
    $process = 'underway';
    // note, the updater will flag success or failure of this process
} else {
    $process = FALSE;
}

// ---- COMMON ---- //
// Labels and so on
$mk_waitmsg = getMarkup('cor_tbl_markup', $lang, 'waitmsg');
$mk_feedsucs = getMarkup('cor_tbl_markup', $lang, 'feedsucs');
$mk_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_reqfileformat = getMarkup('cor_tbl_markup', $lang, 'reqfileformat');
$mk_feedinfo = getMarkup('cor_tbl_markup', $lang, 'feedinfo');
$mk_feedtitle = getMarkup('cor_tbl_markup', $lang, 'feedtitle');
$mk_feeddesc = getMarkup('cor_tbl_markup', $lang, 'feeddesc');
$mk_op_input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
$mk_op_label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);
$mk_norec = getMarkup('cor_tbl_markup', $lang, 'norec');
$mk_num_pages = getMarkup('cor_tbl_markup', $lang, 'num_pages');
$mk_limit = getMarkup('cor_tbl_markup', $lang, 'limit');
$mk_feedview = getMarkup('cor_tbl_markup', $lang, 'feedview');
$mk_feedlink = getMarkup('cor_tbl_markup', $lang, 'feedlink');

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
        // form
        $form = "<form method=\"$form_method\"";
        $form .= " id=\"export_download_overlay\" action=\"{$_SERVER['PHP_SELF']}\">";
        $form .= "<fieldset>";
        $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $form .= "<input type=\"hidden\" name=\"feed_mode\" value=\"$feed_mode\" />";
        $form .= "<input type=\"hidden\" name=\"limit\" value=\"$limit\" />";
        $form .= "<input type=\"hidden\" name=\"lboxreload\" value=\"$lboxreload\" />";
        $form .= "<input type=\"hidden\" name=\"sf_key\" value=\"$sf_key\" />";
        $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"$sf_conf_name\" />";
        $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />";
        // Contain the input elements in a list
        $form .= "<ul>\n";
        $form .= "<li class=\"row\">";
        $form .= "<label class=\"form_label\">$mk_feedtitle</label>";
        $form .= "<span class=\"inp\">";
        $form .= "<input type=\"text\" name=\"feedtitle\" />";
        $form .= "</span>";
        $form .= "</li>\n";
        $form .= "<li class=\"row\">";
        $form .= "<label class=\"form_label\">$mk_feeddesc</label>";
        $form .= "<span class=\"inp\">";
        $form .= "<textarea name=\"feeddesc\" rows=\"5\" cols=\"12\" ></textarea>";
        $form .= "</span>";
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
            if ($feed_success) {
                // echo a success message and offer the file for download
                echo "<h4>$mk_title</h4>";
                echo "<p class=\"downloadinfo\">$mk_feedsucs</p>";
                $webhost = getWebHost();
                echo "<p class=\"downloadinfo\">{$webhost}$feed_permalink</p>";
                echo "<div class=\"download\"><ul id=\"result_feeds\"><li><a href=\"$feed_permalink\" target=\"_blank\">";
                echo "$mk_feedlink: $feedtitle</a></li></ul></div>\n";
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
            echo "<h4>$mk_title</h4>";
            echo "<p class=\"downloadinfo\">{$mk_reqfileformat}: {$feed_mode}</p>";
            echo "<p class=\"downloadinfo\">{$mk_limit}: {$limit}</p>";
            echo "<p class=\"downloadinfo\">{$mk_feedview}: {$disp_mode}</p>";
            echo "<p class=\"downloadinfo\">{$mk_feedinfo}</p>";
            echo "$form\n";
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
        echo "<p>p_max_view and s_max_view are not ready in sf_export_download</p>";
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
