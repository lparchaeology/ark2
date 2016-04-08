<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_attr_bytype.php
*
* Subform for attributes
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_attr_bytype.php
* @since      File available since Release 0.6
*
*/

// ---- COMMON ---- //
// get common elements for all states

// The default for modules with several modtypes is to have one field list,
// which is the same for all the different modtypes
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
if (chkModType($mod_short) && $modtype != FALSE) {
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

// op_emptyfielddisp
// this allows us to control the way empty fields are displayed in 'view' modes of this sf.
// as an op_ this is NOT required
// if not set, the default is to simply not display unset fields.
if (array_key_exists('op_emptyfielddisp', $sf_conf)) {
    $emptyfielddisp = $sf_conf['op_emptyfielddisp'];
} else {
    $emptyfielddisp = FALSE;
}

// ---- PROCESS ---- //
// update db is called at the page level
if ($update_db == $sf_conf['sf_html_id']) {
    include_once ('php/update_db.php');
}

// get the attrs for each field
foreach ($fields as $key => $field) {
    $attributes = getCh('attribute', $sf_key, $sf_val, $field['classtype']);
    if ($attributes) {
        foreach ($attributes AS $att) {
            $alias = getAttr(FALSE, $att, 'SINGLE', 'alias', $lang);
            $atts[] = array('id' => $att, 'alias' => $alias);
        }
        //add them to the field
        $fields[$key]['attrs'] = $atts;
        unset($atts);
    }
    // In most cases where there is a single field in this sf, the header bar is used to
    // display the alias of the attributetype in question. Where there is more than one
    // field, the alias needs to be added in for display. Also if the sf is within a frame,
    // it will also need an alias, as the headerbar will be turned off.
    if (count($fields) > 1 or isset($sf_frame_used)) {
        $alias_classtype = getAlias('cor_lut_attributetype', $lang, 'attributetype', $field['classtype'], 1);
        $fields[$key]['alias_classtype'] = $alias_classtype;
    }
}
unset($key);


// ---- MARKUP ----
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_noattr = getMarkup('cor_tbl_markup', $lang, 'noattr');


// ---- STATE SPECFIC
// for each state get specific elements and then produce output
switch ($sf_state) {
    // minimised views
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        printf("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        printf("</div>");
        // end the min views
        break;
        
    // maximised edit and enter routines
    case 'p_max_edit':
    case 's_max_edit':
    case 'p_max_ent':
    case 's_max_ent':
        // process the fields array
        //$fields = resTblTh($sf_conf['fields'], 'silent');
        // Headers
        printf("<script type=\"text/javascript\" src=\"js/dyn_dd.js\"></script>\n");
        printf("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        // if there are existing attributes make a list of them otherwise just show a form
        // the fields are contained in an unnumbered list
        $var = "<ul id=\"{$sf_conf['sf_html_id']}_fields\" class=\"field_list\">\n";
        foreach ($fields as $field_key => $field) {
            // check if the field has a display_op in it - so we know what type of form to construct
            if (array_key_exists('op_display_mode', $field)) { 
                $display_mode = $field['op_display_mode'];
            } else {
                $display_mode = 'dyn_dd';
            }
            // use a method appropriate to the display mode
            switch ($display_mode) {
                // 'dynamic' JS dropdowns
                case 'dyn_dd':
                    // each field is contained in a list item element - <li>
                    $var .= "<li id=\"{$field['classtype']}\" class=\"row\">\n";
                    // if we want to display and alias for the attribute type
                    if (array_key_exists('alias_classtype', $field)) { 
                        $var .= "<label class=\"form_label\">{$field['alias_classtype']}</label>";
                    }
                    // establish if there are attributes already set for this field
                    if (array_key_exists('attrs', $field)) {
                        $attrs = $field['attrs'];
                    } else {
                        $attrs = FALSE;
                    }
                    // if there are existing attributes loop over them
                    if ($attrs) {
                          // make an hz_list of them
                        $var .= "<ul id=\"existing_attrs_{$field_key}\" class=\"attr_list\" >\n";
                        foreach ($attrs as $attr) {
                            $attr_id = $attr['id'];
                            $alias = $attr['alias'];
                            $var .= "<li>";
                            $var .= "<label class=\"attr_label\">$alias</label>";
                            // make a delete option if appropriate
                            $del_sw ="<span class=\"value\">";
                            $del_sw .= "<a href=\"{$_SERVER['PHP_SELF']}";
                            $del_sw .= "?item_key=$sf_key&amp;$sf_key={$sf_val}";
                            $del_sw .= "&amp;update_db=delfrag&amp;dclass=attribute";
                            $del_sw .= "&amp;delete_qtype=del&amp;frag_id=$attr_id\">";
                            $del_sw .= "<img class=\"smalldelete\" src=\"$skin_path/images/plusminus/delete_small.png\" alt=\"delete\" />";
                            $del_sw .= "</a>";
                            $del_sw .= "</span>";
                            // put the sw into the main var
                            $var .= $del_sw;
                            $var .= "</li>\n";
                        }
                        // close out the list of existing attrs and cleanup
                        $var .= "</ul>\n";
                        unset ($attrs);
                    }
                    // if this option is on, put in an add to list form
                    if (array_key_exists('op_editctrllist', $sf_conf)) {
                        // if authorised, put in an add to ctrl list option
                        $int = array_intersect($ctrllist_admin_grps, $_SESSION['sgrp_arr']);
                        if (!empty($int)) {
                            $is_list_admin = TRUE;
                        } else {
                            $is_list_admin = FALSE;
                        }
                        if ($is_list_admin) {
                            // put in an add to list option
                            include_once('php/subforms/sf_ctrl_lst.php');
                        }
                    }
                    // make a form to add new attributes
                    $classtype = $field['classtype'];
                    $form = "<form method=\"$form_method\" id=\"add_{$sf_conf['sf_html_id']}_{$field_key}\"";
                    $form .= " action=\"$_SERVER[PHP_SELF]#{$sf_conf['sf_html_id']}\" class=\"attr_form\">\n";
                    $form .= "<fieldset>\n";
                    $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                    $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n";
                    $form .= "<input type=\"hidden\" name=\"{$classtype}_qtype\" value=\"add\" />\n";
                    // in order to allow many forms on the same subform, 
                    // we need the update_db to know that is should not update the other fields
                    foreach ($fields as $fkey => $field) {
                        if ($field_key != $fkey) {
                            // put in a qtype to stop this field from being edited
                            $form .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"skp\" />\n";
                        }
                    }
                    $form .= "<input type=\"hidden\" name=\"{$classtype}_bv\" value=\"1\" />\n";
                    $form .= "<input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />\n";
                    $form .= "<input type=\"hidden\" name=\"{$sf_key}\" value=\"{$sf_val}\" />\n";
                    // get the attributetype number to feed to the ddAlias()
                    $type_no =
                        getSingle(
                            'id',
                            'cor_lut_attributetype',
                            "attributetype = '$classtype'"
                    );
                    // make up an appropriate drop down menu
                    // if an op is set then make use of ddAttr() otherwise use ddAlias()
                    if (array_key_exists('op_dd_order', $sf_conf)) {
                        if ($display_mode == 'dyn_dd') {
                            $attrdd =
                                ddAttr(
                                    FALSE,
                                    FALSE,
                                    $classtype,
                                    $sf_conf['op_dd_order'],
                                    TRUE
                            );
                        } else {
                            $attrdd =
                                ddAttr(
                                    FALSE,
                                    FALSE,
                                    $classtype,
                                    $sf_conf['op_dd_order']
                            );
                        }
                    // else use ddAlias()
                    } else {
                        // default (Aliased and sorted in a natural sort order of the visible elems)
                        if ($display_mode == 'dyn_dd') {
                            $attrdd =
                                ddAlias(
                                    FALSE,
                                    FALSE,
                                    'cor_lut_attribute',
                                    $lang,
                                    $classtype,
                                    "AND attributetype = $type_no ORDER BY cor_tbl_alias.alias",
                                    'code',
                                    'id',
                                    TRUE
                            );
                        } else {
                             $attrdd =
                                ddAlias(
                                    FALSE,
                                    FALSE,
                                    'cor_lut_attribute',
                                    $lang,
                                    $classtype,
                                    "AND attributetype = $type_no ORDER BY cor_tbl_alias.alias",
                                    'code'
                            );
                        }
                    }
                    $form .= $attrdd;
                    // put in a button
                    //  $form .= "<input type=\"submit\" class=\"clean_but\" value=\"+\" />\n";
                    $form .= "</fieldset>\n";
                    $form .= "</form>\n";
                    // add the form to the var
                    $var .= $form;
                    // close of the field's container row
                    $var .= "</li>\n";
                    // close the dyn_dd case
                    break;
                case 'static_dd':
                        $classtype = $field['classtype'];
                        $type_no = getClassType($field['dataclass'], $field['classtype']);
                        // each field is contained in a list item element - <li>
                        $var .= "<li id=\"$classtype\" class=\"row\">\n";
                        // if we want to display and alias for the attribute type
                        if (array_key_exists('alias_classtype', $field)) {
                            $var .= "<label class=\"form_label\">{$field['alias_classtype']}</label>";
                        }
                        // establish if there are attributes already set for this field
                        if (array_key_exists('attrs', $field)) {
                            $attrs = $field['attrs'];
                        } else {
                            $attrs = FALSE;
                        }
                        // if there are existing attributes loop over them
                        if ($attrs) {
                            foreach ($attrs as $attr) {
                                $attribute_id = getSingle('attribute', 'cor_tbl_attribute', 'id = ?', array($attr['id']));
                                $form = "<form method=\"$form_method\" id=\"add_{$sf_conf['sf_html_id']}_{$field_key}\"";
                                $form .= " action=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}\" class=\"attr_form\">\n";
                                $form .= "<fieldset>\n";
                                $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                                $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n";
                                $form .= "<input type=\"hidden\" name=\"{$classtype}_qtype\" value=\"edt\" />\n";
                                $form .= "<input type=\"hidden\" name=\"{$classtype}_bv\" value=\"1\" />\n";
                                $form .= "<input type=\"hidden\" name=\"itemval\" value=\"$sf_val\" />\n";
                                $form .= "<input type=\"hidden\" name=\"{$field['classtype']}_id\" value=\"{$attr['id']}\" />\n";
                                $form .= "<input type=\"hidden\" name=\"{$field['classtype']}\" value=\"$attribute_id\" />\n";
                                foreach ($fields as $fkey => $field) {
                                    if ($field_key != $fkey) {
                                        // put in a qtype to stop this field from being edited
                                        $form .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"skp\" />\n";
                                    }
                                }
                                $attr_id = $attr['id'];
                                $alias = $attr['alias'];
                                $attrdd =
                                    ddAlias(
                                            $attribute_id,
                                            $attr['alias'],
                                            'cor_lut_attribute',
                                            $lang,
                                            $classtype,
                                            "AND attributetype = $type_no ORDER BY cor_tbl_alias.alias",
                                            'code',
                                            'id',
                                            TRUE
                                    );
                                $form .= $attrdd;
                                unset($attrdd);
                                // make a delete option if appropriate
                                $del_sw ="<span class=\"value\">";
                                $del_sw .= "<a href=\"{$_SERVER['PHP_SELF']}";
                                $del_sw .= "?item_key=$sf_key&amp;$sf_key={$sf_val}";
                                $del_sw .= "&amp;update_db=delfrag&amp;dclass=attribute";
                                $del_sw .= "&amp;delete_qtype=del&amp;frag_id=$attr_id\">";
                                $del_sw .= "<img class=\"smalldelete\" src=\"$skin_path/images/plusminus/delete_small.png\" alt=\"delete\" />";
                                $del_sw .= "</a>";
                                $del_sw .= "</span>";
                                // put the sw into the main var
                                $form .= $del_sw;
                                // put in a button
                                //$form .= "<input type=\"submit\" class=\"clean_but\" value=\"+\" />\n";
                                $form .= "</fieldset>\n";
                                $form .= "</form>\n";
                            }
                        } else {
                            // make a form to add new attributes
                            $classtype = $field['classtype'];
                            $form = "<form method=\"$form_method\" id=\"add_{$sf_conf['sf_html_id']}_{$field_key}\"";
                            $form .= " action=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}\" class=\"attr_form\">\n";
                            $form .= "<fieldset>\n";
                            $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                            $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n";
                            $form .= "<input type=\"hidden\" name=\"{$classtype}_qtype\" value=\"add\" />\n";
                            // in order to allow many forms on the same subform,
                            // we need the update_db to know that is should not update the other fields
                            foreach ($fields as $fkey => $field) {
                                if ($field_key != $fkey) {
                                    // put in a qtype to stop this field from being edited
                                    $form .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"skp\" />\n";
                                }
                            }
                            $form .= "<input type=\"hidden\" name=\"{$classtype}_bv\" value=\"1\" />\n";
                            $form .= "<input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />\n";
                            $form .= "<input type=\"hidden\" name=\"{$sf_key}\" value=\"{$sf_val}\" />\n";
                            // get the attributetype number to feed to the ddAlias()
                            $type_no =
                            getSingle(
                                    'id',
                                    'cor_lut_attributetype',
                                    "attributetype = '$classtype'"
                            );
                            // make up an appropriate drop down menu
                            $attrdd =
                                    ddAlias(
                                            FALSE,
                                            FALSE,
                                            'cor_lut_attribute',
                                            $lang,
                                            $classtype,
                                            "AND attributetype = $type_no ORDER BY cor_tbl_alias.alias",
                                            'code',
                                            'id',
                                            TRUE
                                    );
                            $form .= $attrdd;
                            //$form .= "<input type=\"submit\" class=\"clean_but\" value=\"+\" />\n";
                            $form .= "</fieldset>\n";
                            $form .= "</form>\n";
                        }
                        // if this option is on, put in an add to list form
                        if (array_key_exists('op_editctrllist', $sf_conf)) {
                            // if authorised, put in an add to ctrl list option
                            $int = array_intersect($ctrllist_admin_grps, $_SESSION['sgrp_arr']);
                            if (!empty($int)) {
                                $is_list_admin = TRUE;
                            } else {
                                $is_list_admin = FALSE;
                            }
                            if ($is_list_admin) {
                                // put in an add to list option
                                include_once('php/subforms/sf_ctrl_lst.php');
                            }
                        } 
                        // add the form to the var
                        $var .= $form;
                        // close of the field's container row
                        $var .= "</li>\n";
                        // close the dyn_dd case
                        break;
                    
                // a 'radio button' mode
                case 'radio':
                    $var .= "<li id=\"{$field['classtype']}\" class=\"row\">\n";
                    // if we want to display and alias for the attribute type
                    if (array_key_exists('alias_classtype', $field)) { 
                        $var .= "<label class=\"form_label\">{$field['alias_classtype']}</label>";
                    }
                    // With a radio button form element we want to first grab all of the attributes of
                    // the specified type establish if there are attributes already set for this field
                    if (array_key_exists('attrs', $field)) {
                        $attrs = $field['attrs'];
                    } else {
                        $attrs = FALSE;
                    }
                    // a radio button should only have one attribute attached
                    if (count($attrs) > 1) {
                        $var .= "<h5>There is more than one attribute already set for";
                        $var .= " this item in this attribute type. Please contact your Administrator</h5>";
                        // DEV NOTE: This should be MARKUP
                    }
                    // check if any of these attributes are already attached
                    if (!empty($attrs)) {
                        $current_att_id = $attrs[0]['id'];
                        // we now need the lut_attribute id of this attribute
                        $attached_att_id = getRow('cor_tbl_attribute',$current_att_id);
                        $attached_att_id = $attached_att_id['attribute'];
                    } else {
                        $attached_att_id = FALSE;
                    }
                    $attributetype = $field['classtype'];
                    // Handle numeric and text calls
                    if (is_numeric($attributetype)) {
                        $andclause = "AND b.id = '$attributetype'";
                    } else {
                        $andclause = "AND b.attributetype = '$attributetype'";
                    }
                    // setup the SQL
                    $sql = "
                        SELECT a.id, c.alias, b.attributetype
                        FROM cor_lut_attribute AS a, cor_lut_attributetype AS b, cor_tbl_alias AS c
                        WHERE a.id = c.itemvalue
                        AND c.itemkey = 'cor_lut_attribute'
                        AND a.attributetype = b.id
                        AND c.language = ?
                        $andclause
                    ";
                    $params = array($lang);
                    // Run the query
                    $sql = dbPrepareQuery($sql,__FUNCTION__);
                    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
                    // Build the radio buttons
                    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                        // make a form to add new radios
                        $classtype = $field['classtype'];
                        $form = "<form method=\"$form_method\"";
                        $form .= " action=\"#\" id=\"add_{$sf_conf['sf_html_id']}_{$field_key}\">\n";
                        $form .= "<fieldset>\n";
                        $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
                        $form .= "<input type=\"hidden\" name=\"{$classtype}_bv\" value=\"1\" />\n";
                        $form .= "<input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />\n";
                        $form .= "<input type=\"hidden\" name=\"{$sf_key}\" value=\"{$sf_val}\" />\n";
                        $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n";
                        $form .= "<input type=\"hidden\" name=\"{$classtype}_qtype\" value=\"add\" />\n";
                        do { 
                            if ($row['id'] == $attached_att_id) {
                                $form .= "<input name=\"$attributetype\" id=\"original_$current_att_id\"";
                                $form .= " type=\"radio\" value=\"{$row['id']}\" checked=\"checked\" />";
                                $form .= "<label class=\"radio_label\">{$row['alias']}</label> \n";
                            } else {
                                $form .= "<input onclick=\"update_radio(this)\" name=\"$attributetype\"";
                                $form .= " type=\"radio\" value=\"{$row['id']}\" />";
                                $form .= "<label class=\"radio_label\">{$row['alias']}</label>\n";
                            }
                        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
                        $form .= "</fieldset>\n";
                        $form .= "</form>\n";
                    } else {
                        echo "ADMIN ERROR: reported by sf_attr_bytype<br/>";
                        echo "The attribute type '$attributetype' returned no attributes<br/>";
                        echo "SQL: $sql<br/>";
                    }
                    // add the form to the var
                    $var .= $form;
                    // close of the field's container row
                    $var .= "</li>\n";
                    // close the 'radio' case
                    break;
                    
                // a 'checkbox' option
                case 'checkbox':
                    $var .= "<li id=\"{$field['classtype']}\" class=\"row\">\n";
                    // if we want to display and alias for the attribute type
                    if (array_key_exists('alias_classtype', $field)) { 
                        $var .= "<label class=\"form_label\">{$field['alias_classtype']}</label>";
                    }
                    // with a checkbox button form element we want to first grab all of the attributes
                    // of the specified type establish if there are attributes already set for this field
                    if (array_key_exists('attrs', $field)) {
                        $attrs = $field['attrs'];
                    } else {
                        $attrs = FALSE;
                    }
                    //check if any of these attributes are already attached
                    if (!empty($attrs)) {
                        foreach ($attrs as $attr) {
                            $current_att_id = $attr['id'];
                            //we now need the lut_attribute id of this attribute
                            $attached_att_id = getRow('cor_tbl_attribute',$current_att_id);
                            $attached_att_id = $attached_att_id['attribute'];
                            //now make an array that has all the attached ids and their original frag numbers
                            $attached_att_ids[$attached_att_id] = $current_att_id;
                        }
                    } else {
                        $attached_att_ids = array();
                        $attached_att_id = FALSE;
                    }
                    $attributetype = $field['classtype'];
                    // Handle numeric and text calls
                       if (is_numeric($attributetype)) {
                           $andclause = "AND b.id = '$attributetype'";
                       } else {
                           $andclause = "AND b.attributetype = '$attributetype'";
                       }
                    // setup the SQL
                    $sqltext = "
                        SELECT a.id, c.alias, b.attributetype
                        FROM cor_lut_attribute AS a, cor_lut_attributetype AS b, cor_tbl_alias AS c
                        WHERE a.id = c.itemvalue
                        AND c.itemkey = 'cor_lut_attribute'
                        AND a.attributetype = b.id
                        AND c.language = ?
                        $andclause
                    ";
                    // For Debug
                    $params = array($lang);
                    // Run the query
                    $sql = dbPrepareQuery($sqltext,__FUNCTION__);
                    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
                    // Build the radio buttons
                    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                        // make a form to add new radios
                        $classtype = $field['classtype'];
                        $form = "<form  method=\"$form_method\" ";
                        $form .= "action=\"#\" id=\"add_{$sf_conf['sf_html_id']}_{$field_key}\">\n";
                        $form .= "<fieldset>\n";
                        $form .= "<input type=\"hidden\" name=\"{$classtype}_bv\" value=\"1\" />\n";
                        $form .= "<input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />\n";
                        $form .= "<input type=\"hidden\" name=\"{$sf_key}\" value=\"{$sf_val}\" />\n";
                        $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n";
                        $form .= "<input type=\"hidden\" name=\"{$classtype}_qtype\" value=\"add\" />\n";
                        $form .= "<ul class=\"checkboxes\">\n";
                        do {
                            $form .= "<li>";
                            if (array_key_exists($row['id'],$attached_att_ids)) {
                                $row_id = $row['id'];
                                $form .= "<input onclick=\"update_checkbox(this)\"  name=\"$attributetype\"";
                                $form .= " id=\"original_{$attached_att_ids[$row_id]}\" type=\"checkbox\"";
                                $form .= " value=\"{$row['id']}\" checked=\"checked\" />";
                                $form .= "<label>{$row['alias']}</label> \n";
                            } else {
                                $form .= "<input onclick=\"update_checkbox(this)\" name=\"$attributetype\"";
                                $form .= " type=\"checkbox\" value=\"{$row['id']}\" />";
                                $form .= "<label>{$row['alias']}</label> \n";
                            }
                            $form .= "</li>\n";
                        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
                        $form .= "</ul>\n";
                        $form .= "</fieldset>\n";
                        $form .= "</form>\n";
                    } else {
                        echo "Error in sf_attr_bytype: type '$attributetype' returned no attributes<br/>";
                        echo "SQL: $sqltext<br/>";
                    }
                    // add the form to the var
                    $var .= $form;
                    // close of the field's container row
                    $var .= "</li>\n";
                    // close the 'checkbox' case
                    break;
                
                // a default
                default:
                    echo "Error: No valid display_mode set. The var contained '$display_mode'";
                    break;
            }
        }
        // close out the list of fields
        $var .= "</ul>\n";
        // print the var to screen
        echo "$var";
        // place the js submt button
        $input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
        $update_db_var = $sf_conf['sf_html_id'];
        //print("<button onclick=\"javascript: js_submit('$update_db_var')\"> $input </button>");
        // close the subform div and cleanup
        print("</div>\n");
        unset ($sf_conf);
        unset ($val);
        unset ($sf_state);
        unset ($fields);
        // close out the max edit and max ent case
        break;
        
    // maximised views
    case 'p_max_view':
    case 's_max_view':
    case 'xhtml_dump':
        // start the sf div
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        // start an hz list
        $var = "\n<ul class=\"field_list\">";
        $field_var = FALSE;
        $label_var = FALSE;
        $att_var = FALSE;
        $attrs = array();
        foreach ($fields as $field) {
            // set up attributes
            if (array_key_exists('attrs', $field)){
                   $attrs = $field['attrs'];
            }
            // set up a label for the field if needed
            if (array_key_exists('alias_classtype', $field) && isset($attrs)) { 
                $label_var = "<label class=\"form_label\">{$field['alias_classtype']}</label>";
            }
            if (!empty($attrs)) {
                // this first li is for the attr field as a whole
                $field_var = "<li class=\"row\">\n";
                // add the label if needed
                $field_var .= $label_var;
                // this list is to contain the attributes themselves
                $field_var .= "<span class=\"data\"><ul class=\"attr_list\">\n";
                foreach ($attrs as $attr) {
                    $attr_id = $attr['id'];                   
                    //get the lut_attribute id of this attribute
                    $att_lut_id = getRow('cor_tbl_attribute',$attr_id);
                    $att_lut_id = $att_lut_id['attribute'];
                    //get the lut_attributetype id of this attribute
                    $att_lut_typeid = getRow('cor_lut_attribute',$att_lut_id);
                    $att_lut_typeid = $att_lut_typeid['attributetype'];
                    $alias = $attr['alias'];
                    $att_var .= "<li>";
                    $att_var .= "<a href=\"data_view.php?ftr_mode=standard&reset=1&results_mode=disp";
                    $att_var .= "&disp_mode=table&ftype=atr&amp;atrtype=$att_lut_typeid&amp;";
                    $att_var .= "atr=$att_lut_id&bv=1&ftr_id=new\">";
                    $att_var .= "$alias";
                    $att_var .= "</a></li>\n";
                    $field_var .= $att_var;
                    $att_var = FALSE;
                }
                $attrs = FALSE;
                // close out the list of attrs
                $field_var .= "</ul></span>\n";
                // close out this attr field
                $field_var .= "</li>\n";
            } else {
                if ($emptyfielddisp) {
                    if (is_string($emptyfielddisp)) {
                        // If 'op_emptyfielddisp' is set to a string, look for that nname string in cor_tbl_markup and add the label with markup
                        $mk_emptyfielddisp = getMarkup('cor_tbl_markup', $lang, $emptyfielddisp);
                        $field_var = "<li class=\"row\">\n";
                        $field_var .= $label_var;
                        $field_var .= "<span class=\"data\">$mk_emptyfielddisp</span>";
                        $field_var .= "</li>\n";
                    } else {
                        // If 'op_emptyfielddisp' is set to TRUE just add in the label with no message
                        $field_var = "<li class=\"row\">\n";
                        $field_var .= $label_var;
                        $field_var .= "<span class=\"data\">&nbsp;</span>";
                        $field_var .= "</li>\n";
                    }
                } else {
                    // If 'op_emptyfielddisp' is not set or set to FALSE just turn off visibility of <li> item to prevent empty <ul> 
                    $field_var = "<li style=\"display:none\">&nbsp;</li>";
                }
            }
            $var .= $field_var;
            unset($field_var);
        }
        $var .= "\n</ul>";
        // output the sf
        print $var;
        // close the sf div
        echo "</div>\n";
        // clean up
        unset ($sf_conf);
        unset ($val);
        unset ($sf_state);
        unset ($fields);
        break;
    
    // a FASTI customised view
    case 'fasti_custom':
        printf("<div id=\"sf_monument\" class=\"{$sf_cssclass}\">");
        printf("<h5>$sf_name</h5>");
        printf("<ul id=\"monument\">");
        if ($attrs) {
          foreach ($attrs as $attr) {
            $attr = getAttr(FALSE, $attr, 'SINGLE', 'alias', $lang);
            printf("<li class=\"data\"><span class=\"data\">$attr</span></li>\n");
          }
        }
        echo "</ul>\n";
        echo "</div>\n";
        break;
    
    // a dump view used to dump an entire record to simple XHTML
    case 'xhtml_dump':
        echo "<div id=\"sf_monument\" class=\"fasti_subform\">\n";
        echo "<h3>$alias_mon</h3>\n";
        echo "<ul class=\"data\">";
        if ($attrs) {
            foreach ($attrs as $attr) {
                $attr = getAttr(FALSE, $attr, 'SINGLE', 'alias', $lang);
                printf("<li class=\"data\"><span class=\"data\">$attr</span></li>\n");
            }
        }
        echo "</ul>";
        echo "</div>";
        break;
        
    
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_attribute_by_type\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_attribute_by_type was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
    // do some cleanup - applies to all cases
    unset ($sf_conf);
    unset ($val);
    unset ($sf_state);
    unset ($fields);
}

?>