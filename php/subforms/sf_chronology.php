<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* /subforms/sf_chronology.php
*
* A subform to add or display a chronology (span of dates)
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
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Andy Dufton <a.dufton@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/mod_fst/subforms/chronology.php
* @since      File available since Release 0.6
*
*/


// ---- PROCESS ---- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db == $sf_conf['sf_html_id']) {
    $fields = $sf_conf['fields'];
    // continue as normal
    include_once ('php/update_db.php');
    unset ($fields);
}


// ---- OPTIONS ---- //

// OP_MODTYPE
// Set up fields with or without modtypes
$mod = substr($item_key, 0, 3);
if (array_key_exists('op_modtype', $sf_conf)) {
    $modtype = $sf_conf['op_modtype'];
} else {
    $modtype = FALSE;
}
if (chkModType($mod) && $modtype!=FALSE) {
    $modtype = getModType($mod, $$item_key);
    $fields = $sf_conf["type{$modtype}_fields"];
} else {
    $fields = $sf_conf['fields'];
}

// OP_SF_CSSCLASS
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// OP_FIELD_LABEL
// an option to toggle the label which is displayed for the field
// -- Do NOT confuse this with the 'field option' for spans: 'field_op_label'
// TRUE|1|unset (DEFAULT) = display the field alias as normal
// string = use a piece of markup in place of the field alias
// FALSE|0 = do not display the label at all
// Note: to display an 'empty' or 'blank' <label> tag, send markup containing &nbsp;
if (array_key_exists('op_field_label', $sf_conf)) {
    // fill the var with the setting (could be FALSE)
    $op_field_label = $sf_conf['op_field_label'];
    // if the var is a string, fetch markup
    if (is_string($op_field_label)) {
        $field_label = getMarkup('cor_tbl_markup', $lang, $op_field_label);
    } else {
        $field_label = FALSE;
    }
} else {
    // default
    $op_field_label = TRUE;
    $field_label = FALSE;
}

// SF_OP_SHOWTL
// an option to show or hide the timeline, default to hide
if (array_key_exists('sf_op_showtl', $sf_conf)) {
    $showtl = $sf_conf['sf_op_showtl'];
} else {
    $showtl = FALSE;
}

// SF_OP_TL_WIDTH
// an option to show or hide the timeline, default to hide
if (array_key_exists('op_tl_width', $sf_conf)) {
    $tl_width = $sf_conf['op_tl_width'];
} else {
    $tl_width = '500'; // a default
}


// ---- COMMON ELEMENTS ---- //
// date ranges - the date range spans
//  nb: one or many attributes always true
$spans = getSpan($item_key, $$item_key, $fields[0]['classtype']);
$alias_dr = getAlias('cor_lut_spantype', $lang, 'spantype', $fields[0]['classtype'], 1);

// form_id
$form_id = $sf_conf['sf_html_id'].'_form';


// ---- MARKUP ---- //
// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);


// ---- STATE SPECFIC ---- //
// for each state get specific elements and then produce output
switch ($sf_state) {
    // MIN views
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        print("<div id=\"{$sf_conf['sf_html_id']}_viewer\" class=\"{$sf_cssclass}\">\n");
        // Print the navigation bar only
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        print("</div>\n\n");
        break;
        
    case 'p_max_view':
        // DEV NOTE: this part of this subform is not in the standard architecture.
        //  this sf should call resTblTd() at this point NOT just paste all this code
        //  directly into the subform. This has been ticketed for overhaul
        //  GH 9/9/11
        print("<div id=\"sf_chronology\" class=\"{$sf_cssclass}\">\n");
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        
        // process the fields
        $fields = resTblTh($fields, 'silent');
        // list date ranges as numbers
        if ($sf_conf['sf_op_showranges']) {
            // loop thru the fields
            foreach ($fields as $field) {
                // get aliases for the beg and end
                if ($field['field_op_label']) {
                    $field['b_label'] =
                        getAlias(
                            'cor_lut_spantype',
                            $lang,
                            'spantype',
                            $field['classtype'],
                            4
                    );
                    $field['e_label'] =
                        getAlias(
                            'cor_lut_spantype',
                            $lang,
                            'spantype',
                            $field['classtype'],
                            3
                    );
                }
                // if we have spans put in the fields
                if ($spans) {
                    // All cases need this stuff
                    if ($field['field_op_label']) {
                        $b_label = "<label>{$field['b_label']}</label>\n";
                        $e_label = "<label>{$field['e_label']}</label>\n";
                    } else {
                        $b_label = FALSE;
                        $e_label = FALSE;    
                    }
                    // handle the divider option
                    if (array_key_exists('field_op_divider', $field)) {
                        $divider = $field['field_op_divider'];
                    } else {
                        $divider = FALSE;
                    }
                    // handle the AD/BC modifier option
                    if (array_key_exists('field_op_modifier', $field)) {
                        $field_op_modifier = $field['field_op_modifier'];
                    } else {
                        $field_op_modifier = FALSE;
                    }
                    if ($field_op_modifier) {
                        $b_modifier = "<select name=\"{$field['classtype']}_beg_modifier\">\n";
                        $b_modifier .= "<option value=\"ad\">AD</option>\n";
                        $b_modifier .= "<option value=\"bc\">BC</option>\n";
                        $b_modifier .= "</select>\n";
                        $e_modifier = "<select name=\"{$field['classtype']}_end_modifier\">\n";
                        $e_modifier .= "<option value=\"ad\">AD</option>\n";
                        $e_modifier .= "<option value=\"bc\">BC</option>\n";
                        $e_modifier .= "</select>\n";
                    } else {
                        $b_modifier = FALSE;
                        $e_modifier = FALSE;
                    }
                    //make a list of the existing spans
                    $var = "<ul id=\"date_ranges\">\n";
                    foreach ($spans as $span) {
                        // if a modifier is set, modify the output before it gets to the user
                        // this should be abstracted to work fo other types of modifier
                        if ($field_op_modifier) {
                            $start = $span['beg']-2000;
                            $end = $span['end']-2000;
                            // sort out epochs
                            if ($start > 0) {
                                $start_epoch = 'BC';
                            } else {
                                $start_epoch = 'AD';
                                $start = abs($start);
                            }
                            if ($end > 0) {
                                $end_epoch = 'BC';
                            } else {
                                $end_epoch = 'AD';
                                $end = abs($end);
                            }
                            // if the beginning and end are the same just display a single. GH 9/9/11
                            if ($start == $end) {
                                $start_epoch = FALSE;
                                $divider = FALSE;
                                $end = FALSE;
                                $end_epoch = FALSE;
                            }
                            // Set up the var 
                            $var .= "<li class=\"row\">";
                            $var .= "$start $start_epoch";
                            $var .= $divider;
                            $var .= "$end $end_epoch</li>\n";
                        } else {
                            // if the beginning and end are the same just display a single. GH 9/9/11
                            if ($span['beg'] == $span['end']) {
                                $divider = FALSE;
                                $span['end'] = FALSE;
                            }
                            $var .= "<li class=\"row\">{$span['beg']}";
                            $var .= $divider;
                            $var .= "{$span['end']}</li>\n";
                        }
                    }
                    $var .= "</ul>\n";
                    // build the var into an ARK standard display format
                    $output = "<div class=\"row\">";
                    if ($op_field_label) {
                        // if field_label has been set up above to carry markup, use it
                        if (!$field_label) {
                            // otherwise use the field alias (default)
                            $field_label = $field['field_alias'];
                        }
                        $output .= "<label class=\"form_label\">$field_label</label>";
                    }
                    $output .= "<span class=\"data\">$var</span>\n";
                    $output .= "</div>\n";
                    // echo the output
                    echo "$output";
                }
            }
        }
        // timeline
        if ($spans && $showtl) {
            $tl = mkTl($spans, $tl_width);
            printf ($tl);
        }
        print("</div>\n");
        break;
        
    // FASTI Custom
    case 'fasti_custom':
        print("<div id=\"sf_chronology\" class=\"{$sf_cssclass}\">");
        if ($spans) {
            $tl = mkTl($spans, '420');
            printf ($tl);
        }
        print("</div>");
        break;
        
    // Data Entry and Edits
    case 'p_max_edit':
    case 'p_max_ent':    
        print("<div id=\"sf_chronology\" class=\"{$sf_cssclass}\">");
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        // feedback
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // process the fields
        $fields = resTblTh($fields, 'silent');
        // the EDT routine (only if we already have spans)
        // loop thru the fields
        foreach ($fields as $field) {
            // get aliases for the beg and end
            if ($field['field_op_label']) {
                $field['b_label'] = getAlias('cor_lut_spantype', $lang, 'spantype', $field['classtype'], 3);
                $field['e_label'] = getAlias('cor_lut_spantype', $lang, 'spantype', $field['classtype'], 4);
            }
            // if we have spans put in the fields
            if ($spans) {
                $field['current'] = $spans;
                printf("<ul id=\"spans\">");
                $val = frmElem($field, $item_key, $$item_key);
                print("
                    <li class=\"row\">
                        <label class=\"form_label\">{$field['field_alias']}</label>
                        $val
                    </li>
                ");
                printf("</ul>\n");
            }
        }
        // the ADD routine
        // start the form
        printf("<form method=\"$form_method\" id=\"$form_id\" style=\"float:left\" action=\"{$_SERVER['PHP_SELF']}\">\n");
        print("<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n");
        printf("<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n");
        printf("<input type=\"hidden\" name=\"item_key\" value=\"$item_key\" />\n");
        printf("<input type=\"hidden\" name=\"itemval\" value=\"{$$item_key}\" />\n");
        printf("<input type=\"hidden\" name=\"$item_key\" value=\"{$$item_key}\" />\n");
        // start list
        printf('<ul>');
        // loop thru the fields
        foreach($fields AS $key => $field) {
            // get aliases for the beg and end
            if ($field['field_op_label']) {
                $field['b_label'] = getAlias('cor_lut_spantype', $lang, 'spantype', $field['classtype'], 3);
                $field['e_label'] = getAlias('cor_lut_spantype', $lang, 'spantype', $field['classtype'], 4);
            }
            // set current to FALSE to force an add routine
            $field['current'] = FALSE;
            $val = frmElem($field, $item_key, $$item_key);
            $label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);
            // print the field
            print("
                <li class=\"row\">
                    <label class=\"form_label\">{$field['field_alias']}</label>
                    <span class=\"inp\">$val</span>
                </li>
            ");
        }
        // put in the options row
        $input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
        print("
            <li class=\"row\">
                <label class=\"form_label\">&nbsp;</label>
                <span class=\"inp\">
                    <button type=\"submit\">$input</button>
                </span>
            </li>\n"
        );    
        // end the list
        printf("</ul>\n");
        // end the form
        printf("</form>\n");
        // Timeline
        if ($spans && $showtl) {
            $tl = mkTl($spans, $tl_width);
            printf ($tl);
        }
        print("</div>");
        break;
        
    // XHTML Dump
    case 'xhtml_dump':
        // DEV NOTE: this part of this subform is not in the standard architecture.
        //  this sf should call resTblTd() at this point NOT just paste all this code
        //  directly into the subform. This has been ticketed for overhaul
        //  GH 9/9/11
        print("<div id=\"sf_chronology\" class=\"{$sf_cssclass}\">\n");
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        
        // process the fields
        $fields = resTblTh($fields, 'silent');
        // list date ranges as numbers
        if ($sf_conf['sf_op_showranges']) {
            // loop thru the fields
            foreach ($fields as $field) {
                // get aliases for the beg and end
                if ($field['field_op_label']) {
                    $field['b_label'] =
                        getAlias(
                            'cor_lut_spantype',
                            $lang,
                            'spantype',
                            $field['classtype'],
                            4
                    );
                    $field['e_label'] =
                        getAlias(
                            'cor_lut_spantype',
                            $lang,
                            'spantype',
                            $field['classtype'],
                            3
                    );
                }
                // if we have spans put in the fields
                if ($spans) {
                    // All cases need this stuff
                    if ($field['field_op_label']) {
                        $b_label = "<label>{$field['b_label']}</label>\n";
                        $e_label = "<label>{$field['e_label']}</label>\n";
                    } else {
                        $b_label = FALSE;
                        $e_label = FALSE;    
                    }
                    // handle the divider option
                    if (array_key_exists('field_op_divider', $field)) {
                        $divider = $field['field_op_divider'];
                    } else {
                        $divider = FALSE;
                    }
                    // handle the AD/BC modifier option
                    if (array_key_exists('field_op_modifier', $field)) {
                        $field_op_modifier = $field['field_op_modifier'];
                    } else {
                        $field_op_modifier = FALSE;
                    }
                    if ($field_op_modifier) {
                        $b_modifier = "<select name=\"{$field['classtype']}_beg_modifier\">\n";
                        $b_modifier .= "<option value=\"ad\">AD</option>\n";
                        $b_modifier .= "<option value=\"bc\">BC</option>\n";
                        $b_modifier .= "</select>\n";
                        $e_modifier = "<select name=\"{$field['classtype']}_end_modifier\">\n";
                        $e_modifier .= "<option value=\"ad\">AD</option>\n";
                        $e_modifier .= "<option value=\"bc\">BC</option>\n";
                        $e_modifier .= "</select>\n";
                    } else {
                        $b_modifier = FALSE;
                        $e_modifier = FALSE;
                    }
                    //make a list of the existing spans
                    $var = "<ul id=\"date_ranges\">\n";
                    foreach ($spans as $span) {
                        // if a modifier is set, modify the output before it gets to the user
                        // this should be abstracted to work fo other types of modifier
                        if ($field_op_modifier) {
                            $start = $span['beg']-2000;
                            $end = $span['end']-2000;
                            // sort out epochs
                            if ($start > 0) {
                                $start_epoch = 'BC';
                            } else {
                                $start_epoch = 'AD';
                                $start = abs($start);
                            }
                            if ($end > 0) {
                                $end_epoch = 'BC';
                            } else {
                                $end_epoch = 'AD';
                                $end = abs($end);
                            }
                            // if the beginning and end are the same just display a single. GH 9/9/11
                            if ($start == $end) {
                                $start_epoch = FALSE;
                                $divider = FALSE;
                                $end = FALSE;
                                $end_epoch = FALSE;
                            }
                            // Set up the var 
                            $var .= "<li class=\"row\">";
                            $var .= "$start $start_epoch";
                            $var .= $divider;
                            $var .= "$end $end_epoch</li>\n";
                        } else {
                            // if the beginning and end are the same just display a single. GH 9/9/11
                            if ($span['beg'] == $span['end']) {
                                $divider = FALSE;
                                $span['end'] = FALSE;
                            }
                            $var .= "<li class=\"row\">{$span['beg']}";
                            $var .= $divider;
                            $var .= "{$span['end']}</li>\n";
                        }
                    }
                    $var .= "</ul>\n";
                    // build the var into an ARK standard display format
                    $output = "<div class=\"row\">";
                    if ($op_field_label) {
                        // if field_label has been set up above to carry markup, use it
                        if (!$field_label) {
                            // otherwise use the field alias (default)
                            $field_label = $field['field_alias'];
                        }
                        $output .= "<label class=\"form_label\">$field_label</label>";
                    }
                    $output .= "<span class=\"data\">$var</span>\n";
                    $output .= "</div>\n";
                    // echo the output
                    echo "$output";
                }
            }
        }
        // timeline
        if ($spans && $showtl) {
            $tl = mkTl($spans, $tl_width);
            printf ($tl);
        }
        print("</div>\n");
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_chronology\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_chronology was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;

}

unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);

?>
