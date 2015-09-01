<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_help.php
*
* global subform for displaying contextual help
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
* @copyright  1999-2014 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_help.php
* @since      File available since Release 1.2
*/

// ---- SETUP ---- //

// OVERLAY MODE
if ($sf_state == 'overlay') {
    // set up anything that is needed
    // the conf of the subform we need help for.
    $help_conf = reqQst($_REQUEST, 'help_conf');
    $edit_help = reqQst($_REQUEST, 'edit_help');
    $mk_id = reqQst($_REQUEST, 'mk_id');
    $overlay = TRUE;
}

// NORMAL MODES
if (!isset($transclude) && !isset($overlay)) {
    $help_conf = reqQst($_REQUEST, 'help_conf');
    $edit_help = reqQst($_REQUEST, 'edit_help');
}


//we need to check if we are on an edit or an add routine
$mode = 'view';
if ($edit_help && is_numeric($mk_id)) {
    $mode = 'edit';
} elseif ($edit_help && !$mk_id) {
    $mode = 'add';
}

// PROCESS
if ($update_db) {
    $process = TRUE;
    include('update_help.php');
    //if we have just processed then set the view mode to 'view'
    $mode = 'view';
} else {
    $process = FALSE;
}

// FIELDS
// The default for modules with several modtypes is to have one field list,
// which is the same for all the differnt modtypes
// If you want to use different field lists for each modtype add to the subform
// settings 'op_modtype'=> TRUE and instead of 'fields' => array( add
// 'type1_fields' => array( for each type. 
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

// CSS
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

//Textile
// The help may want to be textiled... if so check in the sf_conf
if (array_key_exists('op_textile', $sf_conf)) {
    $textile_on = TRUE;
} else {
    $textile_on = FALSE;
}

// Labels
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_nohelp = getMarkup('cor_tbl_markup', $lang, 'nohelp');
$mk_edit = getMarkup('cor_tbl_markup', $lang, 'edit');
$mk_save = getMarkup('cor_tbl_markup', $lang, 'save');

// Get the fields for the subform that we want help for
// sf_help uses cor_tbl_markup to store the help
// first we need to find out what fields we want help for

$sfs = getSfs($mod_short);
foreach ($sfs as $key => $value) {
    if ($value['sf_html_id'] == $help_conf) {
        $help_sf = $value;
    }
}

if (!empty($help_sf)) {
    //check if we have an event - otherwise just load the fields
    if (array_key_exists('events',$help_sf)) {
        foreach ($help_sf['events'] as $event) {
            if (array_key_exists('action',$event)) {
                $help_fields[]=$event['action'];
            }
            if (array_key_exists('date',$event)) {
                $help_fields[]=$event['date'];
            }
        }
    } else {
        $help_fields = $help_sf['fields'];
    }
}

// now loop over the fields hoovering up any attached markup help frags

if (!empty($help_fields)) {
    $help_array = array();
    foreach ($help_fields as $field_key => $field) {
        $mk = array();
        if (!array_key_exists('op_help_markup',$field)) {
            $mk = getRow('cor_tbl_markup', FALSE,"WHERE nname = 'help_{$field['field_id']}'");
            $help_text = getMarkup('cor_tbl_markup', $lang, 'help_' . $field['field_id']);
        } else {
            $mk = getRow('cor_tbl_markup', FALSE,"WHERE nname = '{$field['op_help_nname']}");
            $help_text = getMarkup('cor_tbl_markup', $lang, $field['op_help_nname']);
        }
        if (is_array($mk)) {
            $mk_id = $mk['id'];
        } else {
            $help_text = $mk_nohelp;
            $mk_id = '';
        }
        
 
        $help_array[$field_key] = $help_text;
        
        //process the help_fields ready for output
        $help_fields = resTblTh($help_fields, 'silent');
        
        //now we decide what forms to print out
        
        // if we are just viewing - setup the form
        $form = "<form method=\"POST\" name=\"help_overlay_form\" id=\"help_overlay_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
        $form .= "<fieldset>";
        $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $form .= "<input type=\"hidden\" name=\"overlay\" value=\"true\" />";
        $form .= "<input type=\"hidden\" name=\"sf_conf\" value=\"conf_mcd_help\" />";
        $form .= "<input type=\"hidden\" name=\"help_conf\" value=\"$help_conf\" />";
        $form .= "<input type=\"hidden\" name=\"edit_help\" value=\"{$field['field_id']}\" />";
        $form .= "<input type=\"hidden\" name=\"lang\" value=\"{$lang}\" />";
        $form .= "<input type=\"hidden\" name=\"mk_id\" value=\"{$mk_id}\" />";
        // Contain the input elements in a list
        $form .= "<ul>\n";
        $form .= "<li class=\"row\">";
        // set up a label to use
        $label_var = "<label class=\"form_label\">{$help_fields[$field_key]['field_alias']}</label>";
        $form .= $label_var;
        $var = "";
        if ($textile_on) {
           $var = $textile->TextileThis($help_text);
        } else {
            $var .= $help_text;
        }
        if ($edit_help == $field['field_id'] && $mode == 'edit') {
             $form .= "<input type=hidden name=\"update_db\" value=\"mkup\">\n";
             $form .= "<input type=hidden name=\"mk_id\" value=\"$mk_id\">\n";
             $form .= "<ul>\n";
             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">ID</label>
                         <span class=\"inp\">$mk_id</span>
                     </li>\n
             ";
             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">Nickname</label>
                         <span class=\"inp\"><input type=\"text\" name=\"nname\" value=\"{$mk['nname']}\" /></span>
                     </li>\n
             ";
             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">Markup</label>
                         <span class=\"inp\"><textarea name=\"markup\">{$mk['markup']}</textarea></span>
                     </li>\n
             ";

            $mod_dd = ddSimple($mk['mod_short'],$mk['mod_short'],'cor_tbl_module','shortform','mk_mod',"ORDER BY shortform",FALSE,'shortform');     

             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">Module</label>
                         <span class=\"inp\">$mod_dd</span>
                     </li>\n
             ";

             $lang_dd = ddSimple($mk['language'],$mk['language'],'cor_lut_language','language','mk_lang',"ORDER BY language",FALSE,"language"); 

             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">Language</label>
                         <span class=\"inp\">$lang_dd</span>
                     </li>\n
             ";

             $form .= "
                    <li class=\"row\">
                        <label class=\"form_label\">Description</label>
                        <span class=\"inp\"><textarea name=\"description\">{$mk['description']}</textarea></span>
                    </li>\n
                ";

             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">Save</label>
                         <span class=\"inp\">
                             <button type=\"submit\">Save</button>
                         </span>
                     </li>\n
             ";
             $form .= "</ul>\n";
        } elseif ($edit_help == $field['field_id'] && $mode == 'add') {
            $form .= "<input type=hidden name=\"update_db\" value=\"mkup\">\n";
             $form .= "<input type=hidden name=\"mk_id\" value=\"new_id\">\n";
             $form .= "<br /><ul>\n";
             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">ID</label>
                         <span class=\"inp\">Adding New Help for $edit_help</span>
                     </li>\n
             ";
             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">Nickname</label>
                         <span class=\"inp\"><input type=\"text\" name=\"nname\" value=\"help_$edit_help\"/></span>
                     </li>\n
             ";
             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">Markup</label>
                         <span class=\"inp\"><textarea name=\"markup\"></textarea></span>
                     </li>\n
             ";

             $mod_dd = ddSimple($mod_short,$mod_short,'cor_tbl_module','shortform','mk_mod',"ORDER BY shortform",FALSE,'shortform');     

             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">Module</label>
                         <span class=\"inp\">$mod_dd</span>
                     </li>\n
             ";

             $lang_dd = ddSimple($lang,$lang,'cor_lut_language','language','mk_lang',"ORDER BY language",FALSE,'language'); 

             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">Language</label>
                         <span class=\"inp\">$lang_dd</span>
                     </li>\n
             ";

             $form .= "
                    <li class=\"row\">
                        <label class=\"form_label\">Description</label>
                        <span class=\"inp\"><textarea name=\"description\">Help file for the field $edit_help</textarea></span>
                    </li>\n
                ";

             $form .= "
                     <li class=\"row\">
                         <label class=\"form_label\">Save</label>
                         <span class=\"inp\">
                             <button type=\"submit\">Save</button>
                         </span>
                     </li>\n
             ";
             $form .= "</ul>";
        } else {
            
            $form .= "<span class=\"data\">$var";
            //check if the user is authorised to edit the help
            // Check the user permissions for admin tools
            $admin_int = array_intersect($record_admin_grps, $_SESSION['sgrp_arr']);
            if (!empty($admin_int)) {
               $form .= "<button type=\"submit\" />$mk_edit</button></span>";
            } else {
                $form .= "</span>";
            }
        }
        $form .= "</li>\n";
        $form .= "</ul>\n";
        $form .= "</fieldset>";
        $form .= "</form>\n";
        $help_array[$field_key] = $form;
    }
}

// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_delete = getMarkup('cor_tbl_markup', $lang, 'delete');

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
        
        // output
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        foreach ($help_array as $key => $help_item) {
            echo $help_item;
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
        foreach ($help_array as $key => $help_item) {
            echo $help_item;
        }
        print("</div>\n");
        break;
        
    // Max Edits
    case 'p_max_edit':
    case 's_max_edit':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        foreach ($help_array as $key => $help_item) {
            echo $help_item;
        }
        print("</div>\n");
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_delete_record\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_delete_record was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;

// ends switch
}
// clean up
unset ($sf_conf);
unset ($var);
unset ($sf_state);
unset ($fields);
unset ($alias_lang_info);

?>
