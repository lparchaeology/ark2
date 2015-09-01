<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_view/subforms/sf_userconfigfields.php
*
* a data_view subform for allowing users to modify the fields within a particular 'view'
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
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_view/subforms/sf_exportdownload.php
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
// include the export funcs
include_once('php/export_functions.php');

// request user input vars
$reset = reqQst($_REQUEST, 'reset');
$field_id = reqQst($_REQUEST, 'field_id');
$update_type = reqQst($_REQUEST, 'update_type');

// SF_CONF
// See notes above
// 1 - attempt to use the resuts array
// get the results_array from the session
$results_array = reqQst($_SESSION, 'unpaged_results_array');
// if the results are good
if (is_array($results_array)) {
    // get the first 'item' in the $results_array
    $item = reset($results_array);
    // get the itemkey of this item
    $actual_itemkey = $item['itemkey'];
} else {
    $actual_itemkey = $default_itemkey;
}
// compare the current sf_key to the actual item key
if ($sf_key != $actual_itemkey) {
    // switch to the correct sf_key (the form below will pass this on as the sf_key)
    $sf_key = $actual_itemkey;
    // get a mod short
    $mod_short = substr($sf_key, 0, 3);    
    $sf_conf = reqModSetting($mod_short, $sf_conf_name);
} else {
    // get a mod short
    $mod_short = substr($sf_key, 0, 3);
}

// VIEW & CONF
$results_mode = reqQst($_SESSION, 'results_mode');
$disp_mode = reqQst($_SESSION, 'disp_mode');
// this form can only be used to change the fields if we are on a $results_mode == 'disp'
if ($results_mode == 'disp') {
    // there can be several disp modes and we need to have one set
    if (!$disp_mode) {
        echo "ADMIN ERROR: There was no disp_mode set";
    } else {
        // get the 'conf_mac_text' array for this module
        $conf_name = 'conf_mac_'.$disp_mode;
        $conf = reqModSetting($mod_short, $conf_name);
        // DEV NOTE: config failsafe
        foreach ($conf['fields'] as $key => $field) {
            if (!array_key_exists('field_id', $field)) {
                $conf['fields'][$key]['field_id'] = 'not_set';
            }
        }
    }
} else {
    echo "ADMIN ERROR: The results mode must be disp for this form to work<br/>";
}


// ---- PROCESS ---- //
// despite being called update DB, this doesnt interact with the DB, it IS however a process script
// this modifies the conf in both the live script and in the $mod_cxt in the session
$update_success = FALSE;
if ($update_db === $sf_conf['sf_html_id']) {
    // ---- PROCESS ---- //
    // DEV NOTE: as process is so simple here, there is no companion script
    // resets
    if ($reset) {
        // Unset the session version
        unsetModSetting($mod_short, $conf_name);
        // and then reload it
        $conf = reqModSetting($mod_short, $conf_name);
        // DEV NOTE: config failsafe
        foreach ($conf['fields'] as $key => $field) {
            if (!array_key_exists('field_id', $field)) {
                $conf['fields'][$key]['field_id'] = 'not_set';
            }
        }
    }
    // remove fields
    if ($field_id && $update_type == 'remove') {
        foreach ($conf['fields'] as $key => $field) {
            if ($field['field_id'] == $field_id) {
                // unset live
                unset($conf['fields'][$key]);
                // and push the new conf back to the session
                if (setModSetting($mod_short, $conf_name, $conf)) {
                    $update_success = TRUE;
                } else {
                    echo "ADMIN ERROR: Unable to set the mod_obj settings in session<br/>";
                }
            }
        }
    }
    // add fields
    if ($field_id && $update_type == 'add') {
        foreach ($sf_conf['fields'] as $key => $new_fd) {
            // DEV NOTE: config failsafe
            if (!array_key_exists('field_id', $new_fd)) {
                $new_fd['field_id'] = 'not_set';
            }
            if ($new_fd['field_id'] == $field_id) {
                // remove last field- options    
                $last_field = array_pop($conf['fields']);    
                // insert this field into the live and session vars
                // set live
                $conf['fields'][] = $new_fd;
                // and now put back the last field - options
                $conf['fields'][] = $last_field;
                // and push the new conf back to the session
                if (setModSetting($mod_short, $conf_name, $conf)) {
                    $update_success = TRUE;
                } else {
                    echo "ADMIN ERROR: Unable to set the mod_obj settings in session<br/>";
                }
            }
        }
    }
    // flag process as underway
    $process = TRUE;
    // note, the updater will flag success or failure of this process
} else {
    $process = FALSE;
}


// ---- FIELDS ---- //
// process the fields array
$fields = resTblTh($conf['fields'], 'silent');


// ---- COMMON ---- //
// Labels and so on
$mk_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_addfield = getMarkup('cor_tbl_markup', $lang, 'addfield');
$mk_fieldconfiginfo = getMarkup('cor_tbl_markup', $lang, 'fieldconfiginfo');
$mk_resetresultsinfo = getMarkup('cor_tbl_markup', $lang, 'resetresultsinfo');
$mk_op_input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
$mk_op_label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);

// get common elements for all states
// CSS
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}


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
        // table of the current fields
        $list = "<ul>\n";
        $img = "<img src=\"$skin_path/images/plusminus/minus.png\" alt=\"[-]\" class=\"sml\" />";
        foreach ($fields as $key => $field) {
            // an option to remove fields if field_id is ok
            if ($field['field_id'] && $field['field_id'] != 'not_set') {
                $remove_field = "<a href= \"{$_SERVER['PHP_SELF']}";
                $remove_field .= "?update_db={$sf_conf['sf_html_id']}";
                $remove_field .= "&amp;update_type=remove";
                $remove_field .= "&amp;lboxreload=$lboxreload";
                $remove_field .= "&amp;sf_key=$sf_key";
                $remove_field .= "&amp;field_id={$field['field_id']}";
                $remove_field .= "&amp;sf_conf=$sf_conf_name\">";
                $remove_field .= "$img</a>";
            } else {
                $remove_field = FALSE;
            }
            if ($field['dataclass'] != 'op') {
                // the table row
                $list .= "<li class=\"row\"><label class=\"form_label\">{$field['field_alias']}</label>";
                $list .= "$remove_field</li>\n";
            }
        }
        $list .= "</ul>\n";
        // dd_fields - a dd menu of the possible fields
        $dd_fields = "<select name=\"field_id\">\n";
        $dd_fields .= "<option value=\"0\">---select---</option>\n";
        $new_fds = resTblTh($sf_conf['fields'], 'silent');
        foreach ($new_fds as $key => $new_fd) {
            if (array_key_exists('field_id', $new_fd)) {
                $dd_fields .= "<option value=\"{$new_fd['field_id']}\">";
                $dd_fields .= "{$new_fd['field_alias']}</option>\n";
            }
        }
        $dd_fields .= "</select>\n";
        // form
        $form = "<form method=\"$form_method\"";
        $form .= " id=\"export_download_overlay\" action=\"{$_SERVER['PHP_SELF']}\">";
        $form .= "<fieldset>";
        $form .= "<input type=\"hidden\" name=\"lboxreload\" value=\"$lboxreload\" />";
        $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $form .= "<input type=\"hidden\" name=\"sf_key\" value=\"$sf_key\" />";
        $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"$sf_conf_name\" />";
        $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />";
        $form .= "<input type=\"hidden\" name=\"update_type\" value=\"add\" />";
        $form .= "<ul>\n";
        $form .= "<li class=\"row\">";
        $form .= "<label class=\"form_label\">$mk_addfield</label>";
        $form .= "<span class=\"inp\">$dd_fields</span>";
        $form .= "</li>\n";
        $form .= "<li class=\"row\">";
        $form .= "<label class=\"form_label\">$mk_op_label</label>";
        $form .= "<span class=\"inp\"><button type=\"submit\">";
        $form .= "$mk_op_input</button></span>";
        $form .= "</li>\n";
        $form .= "</ul>\n";
        $form .= "</fieldset>";
        $form .= "</form>\n";
        // reset option
        $reset = "<a class=\"clean_but\" href= \"{$_SERVER['PHP_SELF']}";
        $reset .= "?update_db={$sf_conf['sf_html_id']}";
        $reset .= "&amp;lboxreload=$lboxreload";
        $reset .= "&amp;sf_key=$sf_key";
        $reset .= "&amp;reset=1";
        $reset .= "&amp;sf_conf=$sf_conf_name\">";
        $reset .= "[reset]</a>";
        // ---- OUTPUT ---- //
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // USER INPUT routine
        echo "<div id=\"form_holder\">";
        echo "<h4>$mk_title</h4>";
        echo "<p class=\"downloadinfo\">{$mk_fieldconfiginfo}</p>";
        echo "<p class=\"downloadinfo\">{$mk_resetresultsinfo}$reset</p>";
        echo "$list";
        echo "<br/><br/>";
        echo "$form\n";
        echo "</div>";
        // close SF
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
       echo "<div id=\"sf_userconfigfields\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for this subform was incorrectly set</p>\n";
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

?>
