<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_geo_number.php
*
* subform for dealing with numbers, this form also allows a link to be added to process coordinates into a GML file
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
* @author     Henriette Roued <henriette@roued.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_geo_number.php
* @since      File available since Release 0.7
*
*/


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

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

// form_id
$form_id = $sf_conf['sf_html_id'].'_form';


// -- PROCESS -- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id']) {
    include_once ('php/update_db.php');
}


// -- STATE SPECFIC -- //
// for each state get specific elements and then produce output
switch ($sf_state) {
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        print("<div id=\"number_viewer\" class=\"mc_subform\">");
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        print "</div>";
        break;
        
    case 'p_max_view':
    case 's_max_view':
        print("<div id=\"number_viewer\" class=\"mc_subform\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
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
            $type_no = getSingle('id', 'cor_lut_numbertype', "numbertype = '{$field['classtype']}'");
            if ($current =
                getRow(
                    'cor_tbl_number',
                    FALSE,
                    "WHERE itemkey = '$sf_key' AND itemvalue = '{$sf_val}' AND numbertype = $type_no"
            )) {
                $field['current'] =
                    array(
                        'id' => $current['id'],
                        'current' => $current['number']
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
        
    case 'p_max_edit':
    case 'p_max_ent':
    case 's_max_edit':
        //check if we are on a geo processing call
        $geo_process = reqQst($_REQUEST, 'geo_process');
        if ($geo_process) {
            include_once ('php/map/map_functions.php');
            // now check we have the right variables in the sf_conf
            if (array_key_exists('op_gml_location', $sf_conf) AND array_key_exists('op_coord_fields', $sf_conf) AND array_key_exists('op_projection', $sf_conf)) {
                mkGMLFile($sf_key, $sf_conf['op_gml_location'],$sf_conf['op_coord_fields'],$sf_conf['op_projection']);
            } else {
                $error[]['vars'] = "Not enough parameters in subform conf to process to GML";
            }
        }
        // put in the nav
        print("<div id=\"number_viewer\" class=\"mc_subform\">");
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // process the fields array
        $fields = resTblTh($fields, 'silent');
        printf("
        <form method=\"$form_method\" id=\"$form_id\" action=\"{$_SERVER['PHP_SELF']}\">
        <fieldset>
            <input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n
            <input type=\"hidden\" name=\"item_key\" value=\"$sf_key\" />
            <input type=\"hidden\" name=\"$sf_key\" value=\"{$sf_val}\" />
            <input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />
            <input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />
            <input type=\"hidden\" name=\"geo_process\" value=\"true\" />\n
        ");
        printf("<ul>\n");
        // loop thru each field
        foreach ($fields AS $field) {
            //attempt to get 'current'
            $type_no = getSingle('id', 'cor_lut_numbertype', "numbertype = '{$field['classtype']}'");
            if ($current =
                getRow(
                    'cor_tbl_number',
                    FALSE,
                    "WHERE itemkey = '$sf_key' AND itemvalue = '{$sf_val}' AND numbertype = $type_no"
            )) {
                $field['current'] =
                    array(
                        'id' => $current['id'],
                        'number' => $current['number']
                );
            } else {
                $field['current'] = FALSE;
            }
            $val = frmElem($field, $sf_key, $sf_val);
            //try to get the current value
            print("
                <li class=\"row\">
                    <label class=\"form_label\">{$field['field_alias']}</label>
                    <span class=\"inp\">$val</span>
                </li>\n
            ");
        }
        // put in the options row
        $label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);
        $input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
        print("
            <li class=\"row\">
                <label class=\"form_label\">$label</label>
                <span class=\"inp\">
                    <button type=\"submit\">$input</button>
                </span>
            </li>\n"
        );
        print("
            </ul>
            </fieldset>
            </form>
            </div>\n
        ");
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_geo_number\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_geo_number was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
} // ends switch

unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);

?>
