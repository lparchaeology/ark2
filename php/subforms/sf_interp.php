<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_interp.php
*
* Subform for entering interpretative text
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_interp.php
* @since      File available since Release 0.6
*/


// -- REQUESTS -- //
$quickedit = reqQst($_REQUEST, 'quickedit');


// -- OPTIONS -- //
// This allows us to specify a lang for the texts
if (array_key_exists('op_sf_lang', $sf_conf)) {
    $sf_lang = $sf_conf['op_sf_lang'];
} else {
    $sf_lang = $lang;
}

// This allows us to exclude texts in a certain lang
if (array_key_exists('op_sf_exclude_lang', $sf_conf)) {
    $sf_exclude_lang = $sf_conf['op_sf_exclude_lang'];;
} else {
    $sf_exclude_lang = FALSE;
}

if (array_key_exists('op_user_lang_overide', $sf_conf)) {
    $user_lang_oride = $sf_conf['op_user_lang_overide'];
} else {
    $user_lang_oride = FALSE;
}

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


// -- PROCESS -- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id']) {
    include_once ('php/subforms/update_interp.php');
}


// -- COMMON -- //
// get common elements for all states

// get back the interp texts
$interp_texts = getChData('txt', $sf_key, $sf_val, $fields[0]['classtype']);

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_nointerps = getMarkup('cor_tbl_markup', $lang, 'no_interps');
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$op_input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
$op_label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);

// form_id
$form_id = $sf_conf['sf_html_id'].'_form';


// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch ($sf_state) {
    // Min
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n");
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        print("</div>\n");
        break;
        
    // Max View
    case 'p_max_view':
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
        $fields_copy = $fields;
        // start a list
        printf("<ul>\n");
        if ($interp_texts) {
            // loop over the existing interps
            foreach ($interp_texts as $interp) {
                print("<li class=\"recordarea\">\n");
                print("<ul>\n");
                // 1 - deal with the text field
                // get 'current'
                $fields[0]['current'] = array('id' => $interp['id'], 'current' => $interp['txt']);
                $val = $interp['txt'];
                // print it
                print("
                    <li class=\"row\">
                        <label class=\"form_label\">{$fields[0]['field_alias']}</label>
                        <span class=\"data\">$val</span>
                    </li>\n
                ");
                // 2 - deal with the actor field
                // attempt to get 'current'
                $val = resTblTd($fields[1], 'cor_tbl_txt', $interp['id']);
                if ($val) {
                    print("
                        <li class=\"row\">
                            <label class=\"form_label\">{$fields[1]['field_alias']}</label>
                            $val
                        </li>\n
                    ");
                }
                // 3 - deal with the date field
                // attempt to get 'current'
                $val = resTblTd($fields[2], 'cor_tbl_txt', $interp['id']);
                if ($val) {
                    print("
                        <li class=\"row\">
                            <label class=\"form_label\">{$fields[2]['field_alias']}</label>
                            $val
                        </li>\n");
                }
                // end the list of fields
                print("        </ul>\n");
                // end this interp
                print("    </li>\n");
                // unset stuff
                unset ($sf_title);
            }
        // show a message indicating that there are no interps
        } else {
            print("
                <li class=\"row\">
                    <label class=\"form_label\">&nbsp;</label>
                    <span class=\"data\">$mk_nointerps</span>
                </li>\n
            ");
        }
        // end the list of interps
        print("</ul>");
        unset ($field, $fields, $sf_title);
        print("</div>\n");
        break;
    
    // MAX EDIT AND ENT
    case 'p_max_edit':
    case 'p_max_ent':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n");
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
        $fields_copy = $fields;
        // put the interps into an unnumbered list
        printf("<ul>\n");
        if ($interp_texts) {
            // loop over the existing interps
            foreach ($interp_texts as $interp) {
                // Quickedit is used to allow a single existing interp to be edited
                if ($interp['id'] == $quickedit) {
                    print("<li class=\"recordarea\">");
                    printf("
                        <form method=\"$form_method\" id=\"{$form_id}-qed\" action=\"{$_SERVER['PHP_SELF']}\">
                        <fieldset>
                        <input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n
                        <input type=\"hidden\" name=\"item_key\" value=\"$sf_key\" />
                        <input type=\"hidden\" name=\"$sf_key\" value=\"{$sf_val}\" />
                        <input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />
                        <input type=\"hidden\" name=\"interp_id\" value=\"{$interp['id']}\" />
                        <input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n
                    ");
                    if (!$user_lang_oride) {
                        //This op switch allows a user selection of lang for the text
                        //If it is false we want to use the sf_lang as normal
                        //DEV NOTE: the user switch itself is not yet built
                        print("<input type=\"hidden\" name=\"sf_lang\" value=\"$sf_lang\" />\n");
                    }
                    // the elements of the form are contained within a list
                    print("<ul>");
                    // 1 - deal with the text field
                    // get 'current'
                    unset($current);
                    $current[] =
                        array(
                            'id' => $interp['id'],
                            'current' => $interp['txt'],
                            'txt' => $interp['txt']
                    );
                    $fields[0]['current'] = $current;
                    $val = frmElem($fields[0], $sf_key, $sf_val);
                    // print it
                    print("
                        <li class=\"row\">
                            <label class=\"form_label\">{$fields[0]['field_alias']}</label>
                            <span class=\"inp\">$val</span>
                        </li>\n
                    ");
                    // 2 - deal with the actor field
                    // attempt to get 'current'
                    $fields[1]['current'] = resFdCurr($fields[1], 'cor_tbl_txt', $interp['id']);
                    $val = frmElem($fields[1], $sf_key, $sf_val);
                    if ($val) {
                        print("
                            <li class=\"row\">
                                <label class=\"form_label\">{$fields[1]['field_alias']}</label>
                                $val
                            </li>\n
                        ");
                    }
                    // 3 - deal with the date field
                    // attempt to get 'current'
                    $fields[2]['current'] = resFdCurr($fields[2], 'cor_tbl_txt', $interp['id']);
                    $val = frmElem($fields[2], $sf_key, $sf_val);
                    if ($val) {
                        print("
                            <li class=\"row\">
                                <label class=\"form_label\">{$fields[2]['field_alias']}</label>
                                <span class=\"inp\">$val</span>
                            </li>\n
                        ");
                    }
                    // put in options
                    print("
                        <li class=\"row\">
                            <label class=\"form_label\">$op_label</label>
                            <span class=\"inp\"><button type=\"submit\">$op_input</button></span>
                        </li>\n
                    ");
                    // end the list of fields
                    print("</ul>");
                    // end the fieldset
                    print("</fieldset>");
                    // end the form
                    print("</form>");
                    // end this interp
                    print("</li>");
                // if not on quickedit print a view of the interp
                } else {
                    print("<li class=\"recordarea\">");
                    print("<ul id=\"fields\">");
                    // 1 - deal with the text field
                    // get 'current'
                    $current[] =
                        array(
                            'id' => $interp['id'],
                            'current' => $interp['txt'],
                            'txt' => $interp['txt']
                    );
                    $fields[0]['current'] = $current;
                    // print it
                    print("
                        <li class=\"row\">
                            <label class=\"form_label\">{$fields[0]['field_alias']}</label>
                            <span class=\"data\">{$interp['txt']}</span>
                        </li>\n
                    ");
                    // 2 - deal with the actor field
                    // attempt to get 'current'
                    $val = resTblTd($fields[1], 'cor_tbl_txt', $interp['id']);
                    if ($val) {
                        print("
                            <li class=\"row\">
                                <label class=\"form_label\">{$fields[1]['field_alias']}</label>
                                $val
                            </li>\n
                        ");
                    }
                    // 3 - deal with the date field
                    // attempt to get 'current'
                    $val = resTblTd($fields[2], 'cor_tbl_txt', $interp['id']);
                    if ($val) {
                        print("
                            <li class=\"row\">
                                <label class=\"form_label\">{$fields[2]['field_alias']}</label>
                                $val
                            </li>\n
                        ");
                    }
                    // 4 - deal with the edit option
                    $qedlabel = getMarkup('cor_tbl_markup', $lang, 'qed');
                    $img = "<img src=\"$skin_path/images/plusminus/edit.png\" alt=\"$qedlabel\" class=\"med\" />";
                    $qed = "<a href=\"{$_SERVER['PHP_SELF']}?$sf_key={$sf_val}&amp;quickedit={$interp['id']}\">";
                    $qed .= "$img</a>";
                    print("
                        <li class=\"row\">
                            <label class=\"form_label\">&nbsp;</label>
                            <span class=\"inp\">$qed</span>
                        </li>\n
                    ");
                    // end the list of fields
                    print("</ul>");
                    // end this interp
                    print("</li>");
                }
                // unset the current
                unset($fields[0]['current'], $current);
                //printPre($fields[0]['current']); // "{$fields[0]['current']}";
            
                // unset stuff
                unset ($sf_title, $val);
            }
        }
        // put in a blank form to add an interp if the quickedit hasnt been called
        if (!$quickedit) {
            print("<li class=\"recordarea\">");
            // make a form
            printf("
                <form method=\"$form_method\" id=\"$form_id\" action=\"{$_SERVER['PHP_SELF']}\">
                <input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n
                <input type=\"hidden\" name=\"item_key\" value=\"$sf_key\" />
                <input type=\"hidden\" name=\"$sf_key\" value=\"{$sf_val}\" />
                <input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />
                <input type=\"hidden\" name=\"interp_id\" value=\"next\" />
                <input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n
            ");
            if (!$user_lang_oride) {
                //This op switch allows a user selection of lang for the text
                //If it is false we want to use the sf_lang as normal
                //DEV NOTE: the user switch itself is not yet built
                print("<input type=\"hidden\" name=\"sf_lang\" value=\"$sf_lang\" />\n");
            }
            print("<ul>\n");
            foreach ($fields_copy as $field) {
                $val = frmElem($field, $sf_key, $sf_val);
                //try to get the current value
                print("
                    <li class=\"row\">
                        <label class=\"form_label\">{$field['field_alias']}</label>
                        <span class=\"inp\">$val</span>
                    </li>\n
                ");
            }
            // put in options
            print("
                <li class=\"row\">
                    <label class=\"form_label\">$op_label</label>
                    <span class=\"inp\"><button type=\"submit\">$op_input</button></span>
                </li>\n
            ");
            // end the list of fields
            print("</ul>\n");
            // end the form
            print("</form>");
            // end this interp
            print("</li>\n");
        }
        // end the list of interps
        print("</ul>\n");
        unset ($field, $fields, $sf_title);
        print("</div>\n");
        break;
        
    // TRANSCLUDE
    case 'transclude':
        print("<div id=\"sf_interp\" class=\"{$sf_cssclass}\">");
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // process the fields array
        $fields = resTblTh($fields, 'silent');
        $fields_copy = $fields;
        // start a list
        printf("<ul>\n");
        if ($interp_texts) {
           // loop over the existing interps
           foreach ($interp_texts as $interp) {
               print("    <li class=\"recordarea\">\n");
               print("        <ul>\n");
               // 1 - deal with the text field
               // get 'current'
               $fields[0]['current'] = array('id' => $interp['id'], 'current' => $interp['txt']);
               $val = $interp['txt'];
               // print it
               print("
                   <li class=\"row\">
                       <label class=\"form_label\">{$fields[0]['field_alias']}</label>
                       <span class=\"data\">$val</span>
                   </li>\n
               ");
               // 2 - deal with the actor field
               // attempt to get 'current'
               $val = resTblTd($fields[1], 'cor_tbl_txt', $interp['id']);
               if ($val) {
                   print("
                       <li class=\"row\">
                           <label class=\"form_label\">{$fields[1]['field_alias']}</label>
                           $val
                       </li>\n
                   ");
               }
               // 3 - deal with the date field
               // attempt to get 'current'
               $val = resTblTd($fields[2], 'cor_tbl_txt', $interp['id']);
               if ($val) {
                   print("
                       <li class=\"row\">
                           <label class=\"form_label\">{$fields[2]['field_alias']}</label>
                           $val
                       </li>\n");
               }
               // end the list of fields
               print("        </ul>\n");
               // end this interp
               print("    </li>\n");
               // unset stuff
               unset ($sf_title);
           }
        // show a message indicating that there are no interps
        } else {
           print("
               <li class=\"row\">
                   <label class=\"form_label\">&nbsp;</label>
                   <span class=\"data\">$mk_nointerps</span>
               </li>\n
           ");
        }
        // end the list of interps
        print("</ul>");
        unset ($field, $fields, $sf_title);
        print("</div>\n");
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_interp\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_interp was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'.</p>\n";
        echo "</div>\n";
        break;
        
// end switch
}

?>
