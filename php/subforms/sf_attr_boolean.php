<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_attr_boolean.php
*
* Subform to display boolean values of an attribute
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
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_attr_boolean.php
* @since      File available since Release 0.6
*/


// ---- PROCESS ---- //
// Slightly non standard call to update DB here. Although several boolean fields
// can be put into a subform, only one can be modified at a time. This routine
// ensures that only one field (defined by field_id) is submitted to the process
// script. GH 16/05/2012
if ($update_db) {
    $all_fields = $sf_conf['fields'];
    $fields = array();
    foreach ($all_fields as $key => $field) {
        if ($field['field_id'] == $update_db) {
            $fields[] = $field;
        }
    }
    if (!empty($fields)) {
        include_once ('php/update_db.php');
    }
    unset ($fields);
}


// ---- COMMON ---- //
// get common elements for all states

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

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

foreach ($fields as $key => $field) {
    // first get the value DEV NOTE: fix this getAttr call (it's flabby)
    $fields[$key]['current']['attr_bool'] = getAttr($sf_key, $sf_val,  $field['attribute'], 'boolean');
    $fields[$key]['current']['frag_id'] = getAttr($sf_key, $sf_val,  $field['attribute'], 'id');
    // second alias the value if the op_show_bv_aliases is set
    // bv = 1 alias
    if ($fields[$key]['current']['attr_bool'] === '1') {
        if (array_key_exists('op_show_bv_aliases', $field)) {
            $fields[$key]['current']['alias_bool'] = 
                getAlias('cor_lut_attribute', $lang, 'attribute', $field['attribute'], 5);
        } else {
            $fields[$key]['current']['alias_bool'] = FALSE;
        }
    }
    // bv = 0 alias
    if ($fields[$key]['current']['attr_bool'] === '0') {
        if (array_key_exists('op_show_bv_aliases', $field)) {
            $fields[$key]['current']['alias_bool'] = 
                getAlias('cor_lut_attribute', $lang, 'attribute', $field['attribute'], 6);
        } else {
            $fields[$key]['current']['alias_bool'] = FALSE;
        }
    }
    // put in markup for not set
    if ($fields[$key]['current']['attr_bool'] === FALSE) {
        if (array_key_exists('op_show_bv_aliases',$field)) {
            $fields[$key]['current']['alias_bool'] = getMarkup('cor_tbl_markup', $lang, 'notset');
        } else {
            $fields[$key]['current']['alias_bool'] = FALSE;
        }
    }
    $fields[$key]['current']['alias_attr'] = getAlias('cor_lut_attribute', $lang, 'attribute',  $field['attribute'], 1);
}
// get the markup name of the subform
$sf_name = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);


// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch ($sf_state) {
    
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        break;
        
    case 'p_max_ent':
    case 's_max_ent':
    case 'p_max_edit':
    case 's_max_edit':
        // process the fields array
        $fields = resTblTh($fields, 'silent');
        // Headers
        printf("<div id=\"div-{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n");
        printf(sfNav($sf_name, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // a list to hold the fields
        printf("<ul id=\"{$sf_conf['sf_html_id']}_list\">\n");
        // loop over each field and put in a new form
        foreach ($fields as $key => $field) {
            // list item to hold the form
            print("<li class=\"row\">");
            // set up the form
            print("<form method=\"$form_method\" id=\"{$sf_conf['sf_html_id']}\" action=\"{$_SERVER['PHP_SELF']}\">\n");
            print("<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n");
            print("<input type=\"hidden\" name=\"item_key\" value=\"$sf_key\" />\n");
            print("<input type=\"hidden\" name=\"$sf_key\" value=\"{$sf_val}\" />\n");
            print("<input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />\n");
            print("<input type=\"hidden\" name=\"update_db\" value=\"{$field['field_id']}\" />\n");
            print("<label class=\"form_label\">{$field['current']['alias_attr']}</label>");
            $val = frmElem($field, $sf_key, $sf_val);
            print($val);
            //close the form
            print("</form>\n");
            // close the list item
            print("</li>\n");
        }
        // close list
        printf("</ul>\n");
        // end the div
        print("</div>\n\n");
        break;
        
    // MAX views
    case 'p_max_view':
    case 's_max_view':
        print("<div id=\"div-{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        print(sfNav($sf_name, $cur_col_id, $cur_sf_id, $$disp_cols));
        print("<ul>\n");
        foreach ($fields as $field) {
            print("<li class=\"row\"><label class=\"form_label\">{$field['current']['alias_attr']}</label>");
            if ($field['current']['alias_bool'] != FALSE) {
                print("<span class=\"data\">{$field['current']['alias_bool']}</span></li>\n");
            } else {
                //check what state the boolean is in
                if ($field['current']['attr_bool'] == '1') {
                    $bool_image = 'chk_on.png';
                }
                if ($field['current']['attr_bool'] == '0') {
                    $bool_image = 'chk_off.png';
                }
                if ($field['current']['attr_bool'] == FALSE) {
                    $bool_image = 'chk_na.png';
                }
                if (!isset($bool_image)) {
                    echo "ADMIN ERROR: No boolean for this attribute<br/>\n";
                }
                print("<img src=\"$skin_path/images/onoff/$bool_image\"");
                print("alt=\"on/off_switch\" />");
            }
        }
        print("</ul>\n");
        print("</div>\n\n");
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_attr_boolean\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_attr_boolean was incorrectly set</p>\n";
        echo "<p>The var 'sf_state contained' '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
} // End the switch

// Clean Up
unset($sf_conf);
unset($val);
unset($sf_state);
unset($fields);
unset($field);

?>
