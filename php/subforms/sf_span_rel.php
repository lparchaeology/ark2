<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* subforms/sf_span_rel.php
*
* global subform for relationships not appropriate for matrix
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_span_rel.php
* @since      File available since Release 0.6
*
*/


// -- OPTIONS -- //
// get common elements for all states

if (array_key_exists('op_fancylabels', $sf_conf)) {
    $conf_att = $sf_conf['op_fancylabels'];
} else {
    $conf_att = FALSE;
}

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}


// -- COMMON -- //
// flag $dd as false
$dd = FALSE;

// Set up fields
$fields = $sf_conf['fields'];

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$op_input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
$op_label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);
$mk_noxmi = getMarkup('cor_tbl_markup', $lang, 'noxmi');
$mk_delete = getMarkup('cor_tbl_markup', $lang,'delete');

// form_id
$form_id = $sf_conf['sf_html_id'].'_form';


// -- PROCESS -- //
// this sf uses the 'companion script' method
if ($update_db == 'sprlad') {
    include_once('php/validation_functions.php');
    include_once('php/subforms/update_spanmatrix.php');
}


// -- STATE SPECFIC -- //
// for each state get specific elements and then produce output

// ---- OUTPUT ---- //

switch ($sf_state) {
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if (isset($error)) {
            feedBk('error');
        }
        if (isset($message)) {
            feedBk('message');
        }
        break;
        
    case 'p_max_view':
    case 's_max_view':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if (isset($error)) {
            feedBk('error');
        }
        if (isset($message)) {
            feedBk('message');
        }
        // a list of fields
        printf("<ul id=\"fields\" class=\"hz_list\">");
        // process fields
        $fields = resTblTh($fields, 'silent');
        // loop over each field
        foreach ($fields as $field) {
            // get current spans
            $current = getSpan($sf_key, $sf_val, $field['classtype']);
            if ($current) {
                $elem = "<ul id=\"rels\">\n";
                foreach ($current as $rel) {
                    // diplay the other end of the span (not this end)
                    if ($rel['beg'] == $sf_val) {
                        $displ = $rel['end'];
                    } else {
                        $displ = $rel['beg'];
                    }
                    $elem .= "<li><a class=\"ltr\" href=\"{$_SERVER['PHP_SELF']}?";
                    $elem .= "item_key=$sf_key&amp;$sf_key=$displ\">$displ</a>";
                    $elem .= "</li>\n";
                }
                $elem .= "</ul>\n";
            } else {
                $elem = FALSE;
            }
            // output for this field
            // if we have current put them in
            if ($current) {
                echo("<li class=\"row\">");
                echo "<h5>{$field['field_alias']}</h5>";
                echo $elem;
                echo("</li>");
            // else put in a message
            } else {
                echo("<li class=\"row\">");
                echo "<h5>{$field['field_alias']}</h5>";
                echo "<p>{$mk_noxmi}</p>";
                echo("</li>");
            }
        }
        print("</ul>");
        break;
        
    case 's_max_edit':
    case 'p_max_edit':
    case 'p_max_ent':
    case 's_max_ent':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");    
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        printf("<ul id=\"fields\" class=\"hz_list\">");
        // process fields
        $fields = resTblTh($fields, 'silent');
        // loop over each field
        foreach ($fields as $field) {
            // get current spans
            $current = getSpan($sf_key, $sf_val, $field['classtype']);
            // set up a dd menu if needed
            if (array_key_exists('op_dd', $sf_conf)) {
                $dd =
                    ddSimple(
                        $top_id,
                        $top_val,
                        $mod_short.'_tbl_'.$mod_short,
                        $sf_key,
                        'end',
                        '',
                        'code',
                        $sf_key
                );
            }
            // prepare list
            print("<li class=\"hz_list\">");
            // handle these the rels
            if ($current) {
                $elem = "<ul id=\"rels\">\n";
                foreach ($current as $rel) {
                    // diplay the other end of the span (not this end)
                    if ($rel['beg'] == $sf_val) {
                        $displ = $rel['end'];
                    } else {
                        $displ = $rel['beg'];
                    }
                    $elem .= "<li><a class=\"ltr\" href=\"{$_SERVER['PHP_SELF']}?item_key=$sf_key";
                    $elem .= "&amp;$sf_key=$displ\">$displ</a>";
                    $elem .= "<a href=\"{$_SERVER['PHP_SELF']}?";
                    $elem .= "$sf_key={$sf_val}&amp;frag_id={$rel['id']}";
                    $elem .= "&amp;update_db=delfrag&amp;delete_qtype=del&amp;dclass=span\">";
                    $elem .= "<img class=\"smalldelete\"";
                    $elem .= "src=\"$skin_path/images/plusminus/delete_small.png\" alt=\"$mk_delete\" />";
                    $elem .= "</a></li>\n";
                }
                $elem .= "</ul>\n";
            } else {
                $elem = FALSE;
            }
            $elem .= "<input type=\"hidden\" name=\"beg\" value=\"{$sf_val}\" />";
            $type_no = getSingle('id', 'cor_lut_spantype', "spantype = '{$field['classtype']}'");
            $elem .= "<input type=\"hidden\" name=\"spanlabelid\" value=\"$type_no\" />";
            $elem .= "<input type=\"hidden\" name=\"spantype\" value=\"$type_no\" />";
            if ($dd) {
                $elem .= $dd;   
            } else {
                $elem .= "<input type=\"text\" class=\"span_rel_input\" name=\"end\" />";
            }
            // make a form
            printf("
                <form method=\"$form_method\" id=\"$form_id\" action=\"{$_SERVER['PHP_SELF']}\">
                <input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n
                <input type=\"hidden\" name=\"item_key\" value=\"$sf_key\" />
                <input type=\"hidden\" name=\"$sf_key\" value=\"{$sf_val}\" />
                <input type=\"hidden\" name=\"update_db\" value=\"sprlad\" />\n
            ");
            $input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
            echo "<h5>{$field['field_alias']}</h5>";
            echo "$elem";
            echo "<button type=\"submit\">+</button>";
            echo "</form>";
            print("</li>");
            unset($field, $fields);
        }
        print("</ul>");
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_span_rel\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_span_rel was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
}

echo "</div>\n\n";

?>
