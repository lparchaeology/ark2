<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_threedframe.php
*
* inculdes a fram with a reference to a 3d object in the cloud
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
* @author     Mike Johnson <m.johnson@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_txt.php
* @since      File available since Release 0.6
*/


// -- SETUP -- //

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
if (chkModType($mod_short) && $modtype) {
    $modtype = getModType($mod_short, $sf_val);
    $fields = $sf_conf["type{$modtype}_fields"];
} else {
    $fields = $sf_conf['fields'];
}

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// This allows us to specify a lang for the texts
// Note that this will set sf_lang although it may set it FALSE
// Do NOT refer to $lang after this point
if (array_key_exists('op_sf_lang', $sf_conf)) {
    $sf_lang = $sf_conf['op_sf_lang'];
    // check if the sf_lang differs from the live lang
    if ($sf_lang != $lang && $sf_lang) {
        $alias_lang_info = "<span class=\"error\">&nbsp;($sf_lang)</span>";
        // DEV NOTE: we need to overhaul the user feedback system
        // $message[] = "WARNING: this sf is editing data in language: $sf_lang";
    } else {
        $alias_lang_info = FALSE;
    }
    if (!$sf_lang) {
        $lang_sql = "AND language = '$lang'";
    } else {
        $lang_sql = "AND language = '$sf_lang'";
    }
    $lang_sql = "AND language = '$lang'";
    
} else {
    $sf_lang = $lang;
    $alias_lang_info = FALSE;
    $lang_sql = "AND language = '$lang'";
}
// This allows us to exclude texts in a certain lang
if (array_key_exists('op_sf_exclude_lang', $sf_conf)) {
    $sf_exclude_lang = $sf_conf['op_sf_exclude_lang'];;
} else {
    $sf_exclude_lang = FALSE;
}
// Selection of language (or Not)
// if sf_lang is SET to FALSE, a selector should be put in
// if sf_lang is TRUE a hidden field should be used
if (!$sf_lang) {
    $lang_input = FALSE;
    $dd_lang =
        ddSimple(
            $lang, //$summary_data['lang'],
            $lang, //$summary_data['lang'],
            'cor_lut_language',
            'language',
            'sf_lang',
            '',
            FALSE,
            'language'
    );
} else {
    $lang_input = "<input type=\"hidden\" name=\"sf_lang\" value=\"$sf_lang\" />";
    $dd_lang = FALSE;
}

// op_emptyfielddisp
// this allows us to control the way empty fields are displayed in 'view' modes of this sf.
// as an op_ this is NOT required
// if not set, the default is to simply not display unset fields.
if (array_key_exists('op_emptyfielddisp', $sf_conf)) {
    $emptyfielddisp = $sf_conf['op_emptyfielddisp'];
} else {
    $emptyfielddisp = FALSE;
}


// -- PROCESS -- //
if ($update_db === $sf_conf['sf_html_id']) {
    include_once('php/update_db.php');
}

// -- COMMON -- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_sf_txt_incompl = getMarkup('cor_tbl_markup', $lang, 'sf_txt_incompl');
$mk_langselector = getMarkup('cor_tbl_markup', $lang, 'langselector');

// form_id
$form_id = $sf_conf['sf_html_id'].'_form';


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
        
    // Max Views
    case 'lpanel':
    case 'p_max_view':
    case 's_max_view':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        $var = "";
        // process the fields array
       $sf_completed = FALSE;
       foreach ($fields as $field) {
            // process the field for display
            $frametext = getSingleText($sf_key, $sf_val, $field['classtype'], $lang);
            $frames = split(" ",$frametext);
            if ($frametext) {
                foreach($frames as $frame){
                	$var .= "<iframe src=\"https://p3d.in/e/";
                	$var .= $frame;
                	$var .= "\" width=\"100%\" height=\"480px\" frameborder=\"0\"";
                	$var .= "seamless allowfullscreen webkitallowfullscreen></iframe>";
                }
                // set the switch showing that something has been filled in on this sf
                $sf_completed = TRUE;
            }
        } if(!$sf_completed) {
            $var = getMarkup('cor_tbl_markup', 'en','nomodels');
		}
		// OUTPUT the var
		echo $var;
		unset ( $val );
        print("</div>");
        // clean up
        unset($sf_completed);
        break;
        
    // Edits
    case 'p_max_edit':
    case 'p_max_ent':
    case 's_max_edit':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // process the fields array
        $fields = resTblTh($fields, 'silent');
        $form = "<form method=\"$form_method\" id=\"$form_id\" action=\"{$_SERVER['PHP_SELF']}\">";
        $form .= "<fieldset>";
        $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $form .= "<input type=\"hidden\" name=\"item_key\" value=\"$sf_key\" />";
        $form .= "<input type=\"hidden\" name=\"$sf_key\" value=\"{$sf_val}\" />";
        $form .= "<input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />";
        $form .= $lang_input;
        $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n";
        $form .= "";
        // Contain the input elements in a list
        $form .= "<ul>\n";
        // loop thru each field
        foreach ($fields as $field) {
            //attempt to get 'current'
            $type_no = getSingle('id', 'cor_lut_txttype', "txttype = '{$field['classtype']}'");
            if ($current =
                    getRow(
                        'cor_tbl_txt',
                        FALSE,
                        "WHERE itemkey = '$sf_key' AND itemvalue = '{$sf_val}' AND txttype = $type_no"
                )) {
                $field['current'][] =
                    array(
                        'id' => $current['id'],
                        'current' => $current['txt'],
                        'txt' => $current['txt']
                );
            } else {
                $field['current'] = FALSE;
            }
            // get current vals
            $val = frmElem($field, $sf_key, $sf_val);
            $form .= "<li class=\"row\">";
            $form .= "<label class=\"form_label\">{$field['field_alias']}$alias_lang_info</label>";
            $form .= "<span class=\"inp\">$val</span>";
            $form .= "</li>\n";
        }
        // before closing out the form add in a lang selector if required by the sf_conf
        if ($dd_lang) {
            $form .= "<li class=\"row\">";
            $form .= "<label class=\"form_label\">$mk_langselector</label>";
            $form .= "<span class=\"inp\">$dd_lang</span></li>\n";
        }
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
        // print out the form
        print("$form");
        // close the div
        print("</div>");
        break;
    
    // Transclude State
    case 'transclude':
    
        $var = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
              <html xmlns="http://www.w3.org/1999/xhtml" lang="de">
              <head>';
        $var .= "<script language=\"JavaScript\" type=\"text/javascript\" src=\"$ark_dir/js/imageflow/imageflow.js\"></script>\n";
        $var .= "<script type=\"text/javascript\" src=\"$ark_dir/js/lightbox.js\"></script>\n";
        $var .= "<link href=\"$ark_dir/$stylesheet\" type=\"text/css\" rel=\"stylesheet\" />";
        $var .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"ark/skins/$skin/stylesheets/lightbox.css\" />";
        $var .= "</head>\n";
        $var .= '<body>';
        print $var;
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        // print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // process the fields array
        $fields = resTblTh($fields, 'silent');
        print("<ul>\n");
        // loop thru each field
        foreach ($fields as $field) {
            //attempt to get 'current'
            $type_no = getSingle('id', 'cor_lut_txttype', "txttype = '{$field['classtype']}'");
            if ($current =
                    getRow(
                        'cor_tbl_txt',
                        FALSE,
                        "WHERE itemkey = '$sf_key' AND itemvalue = '{$sf_val}' AND txttype = $type_no"
            )) {
               $field['current'] =
                   array(
                       'id' => $current['id'],
                       'current' => $current['txt']
                );
            } else {
                $field['current'] = FALSE;
            }
            //try to get the current value
            $val = resTblTd($field, $sf_key, $sf_val);
            if ($val) {
                print("
                    <li class=\"row\">
                        <label class=\"form_label\">{$field['field_alias']}</label>
                        <span class=\"inp\">$val</span>
                    </li>\n
                ");        
            }
        }
        print("</ul>\n");
        print("</div>");
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_txt\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_txt was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'.</p>\n";
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
