<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* subforms/sf_xmi.php
*
* Subform for dealing with xmi links
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_xmi.php
* @since      File available since Release 0.6
*
*
* NOTE 1: since 0.6 this script has been globalised by HRO to work with all modules
*
* NOTE 2: since 0.6 this script has been renamed according to the new naming convention
* that subforms should contain the name of the dataclass within the filename.
*
* NOTE 3: since 1.0 NOTE 2 is no longer valid.
*
* NOTE 4: since 0.7 xmi_mode is set on the sf_conf not globally GH 7/12/12
*
* xmi's don't have classtypes in the typical sense, never the less you need to set your
* classtype in the field setting as 'xmi_list'
*
*/


// -- PROCESS -- //
// Set up fields with or without modtypes
$mod = substr($sf_key, 0, 3);
if (array_key_exists('op_modtype', $sf_conf)) {
    $moddif = $sf_conf['op_modtype'];
} else {
    $moddif = FALSE;
}
if (chkModType($mod) && $moddif) {
    $modtype = getModType($mod, $sf_val);
    $fields = $sf_conf["type{$modtype}_fields"];
} else {
    $fields = $sf_conf['fields'];
}
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db == $sf_conf['sf_html_id']) {
    $_SESSION['current_sgr'] = reqQst($_REQUEST, 'xmi_list_sgr');
    include_once ('php/update_db.php');
    // note fields are reset below // DEV NOTE: not sure if this reset is needed... GH 15/3/2013
    unset ($fields);
    // Set up fields with or without modtypes - second time after the update script has run
    // $mod and $moddif are set at the top of the script
    if (chkModType($mod) && $moddif) {
        $modtype = getModType($mod, $sf_val);
        $fields = $sf_conf["type{$modtype}_fields"];
    } else {
        $fields = $sf_conf['fields'];
    }
}


// -- MARKUP -- //
$mk_noxmi = getMarkup('cor_tbl_markup', $lang, 'noxmi');
$mk_add = getMarkup('cor_tbl_markup', $lang, 'add');
$mk_novalue = getMarkup('cor_tbl_markup', $lang, 'novalue');
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_minisrcinst = getMarkup('cor_tbl_markup', $lang, 'minisrcinst');
$mk_delete = getMarkup('cor_tbl_markup', $lang, 'delete');
$mk_addgrp = getMarkup('cor_tbl_markup', $lang, 'addgrp');

// -- SETUP -- //
// form_id
$form_id = $sf_conf['sf_html_id'].'_form';

// Set up the required vars form the xmi
$xmi_mod = $sf_conf['xmi_mod'];
$xmi_key = $xmi_mod.'_cd';
if (!isset($top_id)) {
    $top_id = FALSE;
}
if (!isset($top_val)) {
    $top_val = FALSE;
}
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}
// Includes relevant settings file
include ('config/mod_'.$xmi_mod.'_settings.php');

//Setup continued
$xmi_conf_name = $xmi_mod.'_xmiconf';
$xmi_conf = $$xmi_conf_name;
$xmi_fields = $xmi_conf['fields'];
$xmi_fields = resTblTh($xmi_fields, 'silent');


// -- DATA -- //
// Gets the XMIed items linked to this item but in the specified module
$xmi_list = getXmi($sf_key, $sf_val, $xmi_mod);

if ($xmi_list){
// Process out the required fields for each XMIed item and add to the array
    foreach ($xmi_list as $key => $xmi_item) {
        foreach ($xmi_fields as $xmi_field) {
            $xmi_vars[] = resTblTd($xmi_field, $xmi_key, $xmi_item['xmi_itemvalue']);
        }
        $xmi_list[$key]['xmi_vars'] = $xmi_vars;
        unset($xmi_vars);
        // Optional sorting of XMIed items
        if (array_key_exists('op_xmi_sorting', $xmi_conf)) {
            $xmi_list[$key]['sort_key'] =
                resFdCurr(
                    $xmi_conf['op_xmi_sort_field'],
                    $xmi_key,
                    $xmi_item['xmi_itemvalue']
            );
        }
    }
}

// an option to define the sf_conf of the register
if (array_key_exists('op_register', $sf_conf)) {
    $register_conf = $sf_conf['op_register'];
    // with a secondary option to specify the location (ie which mod) of the conf
    if (array_key_exists('op_reg_key', $sf_conf)) {
        $reg_key = $sf_conf['op_reg_key'];
    } else {
        $reg_key = $sf_key;
    }
} else {
    $register_conf = FALSE;
}

// Optional sorting of XMIed items
if (array_key_exists('op_xmi_sorting', $xmi_conf)&&!empty($xmi_list)) {
    // ensure that a sort type is specified
    $op_xmi_sorting = $xmi_conf['op_xmi_sorting'];
    if (!is_string($op_xmi_sorting)) {
        $op_xmi_sorting = 'SORT_ASC';
    }
    $xmi_list = sortResArr($xmi_list, $op_xmi_sorting, 'sort_key');
}

// -- LABELS -- //
// Get alias for the xmi itemkey
$xmi_alias =
    getAlias(
        'cor_tbl_module',
        $lang,
        'itemkey',
        $xmi_key,1
);
// Gets the hdrbar setting if there is any set. If not, defaults to list
if (array_key_exists('op_xmi_hdrbar', $xmi_conf)) {
    $hdrbar_type = $xmi_conf['op_xmi_hdrbar'];
}
// Gets the label setting if there is any set
if (array_key_exists('op_xmi_label', $xmi_conf)) {
    $label = $xmi_conf['op_xmi_label'];
} else {
    $label = FALSE;
}


// -- STATE SPECFIC -- //
// for each state get specific elements and then produce output

switch ($sf_state) {
    // MIN views
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
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
    // MAX Views
    case 'p_max_view':
    case 's_max_view':
    case 'xhtml_dump':
    echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
    // put in the navigation bar
    if ($sf_title) {
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
    }
    // Check to see if there are any xmi's in the list - if not go straight to noxmi msg
    if (!empty($xmi_list)) {
        // loop over the list of XMI-ed items
        print("<ul id=\"existing-$xmi_mod\" class=\"xmi_list\">\n");
        foreach ($xmi_list as $xmi_item) {
            // each XMI-ed item is contained in an <li>
            print("<li>\n");
            // --- HDRBAR (The header bar at the top of EACH XMI-ed item(FALSE for no hdrbar)) ---
            // put in the header bar for each one of the XMIed items
            // FULL
            if ($hdrbar_type == 'full') {
                print("<h5>");
                print("{$xmi_alias}: {$xmi_item['xmi_itemvalue']}");
                print("</h5>\n");
            }
            // SHORT
            if ($hdrbar_type == 'short') {
                print("<h5 style=\"width: 100%\">{$xmi_item['xmi_itemvalue']}</h5>\n");
            }
            // LINK
            if ($hdrbar_type == 'link') {
                print("<h5>");
                print("{$xmi_alias}: ");
                print("<a href=\"{$conf_micro_viewer}?item_key={$xmi_item['xmi_itemkey']}");
                print("&amp;{$xmi_item['xmi_itemkey']}={$xmi_item['xmi_itemvalue']}\">");
                print("{$xmi_item['xmi_itemvalue']}");
                print("</a>");
                print("</h5>\n");
            }
            // --- FIELDS --- a list of the fields to display for each XMIed item
            // The fields in this list comes from the settings of the XMIed module itself
            // Contain the fields in a list
            print("<ul id=\"fields-for-{$xmi_item['xmi_itemvalue']}\" class=\"xmi_field\">\n");
            // loop over each field that makes up the XMI item's display
            foreach ($xmi_fields as $xmi_field) {
                $val = resTblTd($xmi_field, $xmi_key, $xmi_item['xmi_itemvalue']);
                print("<li>");
                // Field alias label is optional
                if ($label === TRUE) {
                    print("<label class=\"form_label\">{$xmi_field['field_alias']}</label>");
                }
                print("$val");
                print("</li>\n");
            }
            // End the list of fields for this XMIed item
            print("</ul>\n");
            // End the <li> container for the item
            print("</li>\n");
        }
        // end the list of XMIed items
        print("</ul>\n");
        } else {  //end of xmi check - what do do if there is no xmi's in list
            print("<ul>\n");
            print("<li class=\"row\">\n");
            print("<label class=\"form_label\">{$xmi_alias}</label>");
            print("<span class=\"value\">{$mk_novalue}</span>");
            print("</li>");
            print("</ul>\n");
        //    print("<li class=\"row\">{$mk_noxmi}</li>\n");
        }
    print("</div>\n\n");
    break;

    // --- ENTER and EDIT VIEW ---
    case 'p_max_edit':
    case 'p_max_ent':
    case 's_max_edit':
    case 's_max_ent':
        // This form can only cope with a single field, handle this appropriately
        $nf = count($fields);
        if ($nf > 1) {
            echo "Error: This form can only handle one field you have: $nf fields<br/>";
            printPre($fields);
        } else {
            $field = $fields[0];
        }
        // Begin subform
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // Check to see if there are any xmi's in the list - if not go straight to ADD XMI form
        if (!empty($xmi_list)) {
            // loop over the list of XMI-ed items
            print("<ul id=\"existing-$xmi_mod\" class=\"xmi_list\">\n");
            foreach ($xmi_list as $xmi_item) {
                // make a delete switch
                $del_sw = "<a href=\"{$_SERVER['PHP_SELF']}";
                $del_sw .= "?$sf_key={$sf_val}&amp;update_db=delfrag&amp;dclass=xmi";
                $del_sw .= "&amp;delete_qtype=del&amp;frag_id={$xmi_item['id']}\"";
                $del_sw .= " class=\"smalldelete\">";
                $del_sw .= "<img class=\"smalldelete\"  src=\"$skin_path/images/plusminus/delete_small.png\" alt=\"$mk_delete\" />";
                $del_sw .= "</a>";
                // each XMI-ed item is contained in an <li>
                print("<li>\n");
                // --- HDRBAR (The header bar at the top of EACH XMI-ed item) ---
                // put in the header bar for each one of the XMIed items
                // FULL
                if ($hdrbar_type == 'full') {
                    print("<h5>");
                    print("{$xmi_alias}: {$xmi_item['xmi_itemvalue']}&nbsp;$del_sw");
                    print("</h5>\n");
                }
                if ($hdrbar_type == 'short') {
                    print("<h5>{$xmi_item['xmi_itemvalue']}&nbsp;$del_sw</h5>\n");
                }
                if ($hdrbar_type == 'link') {
                    print("<h5>");
                    print("{$xmi_alias}: ");
                    print("<a href=\"{$conf_micro_viewer}?item_key={$xmi_item['xmi_itemkey']}");
                    print("&amp;{$xmi_item['xmi_itemkey']}={$xmi_item['xmi_itemvalue']}\">");
                    print("{$xmi_item['xmi_itemvalue']}");
                    print("</a>");
                    print("&nbsp;$del_sw");
                    print("</h5>\n");
                }
                // Now a list of the fields to display for each XMIed item
                // The fields in this list comes from the settings of the XMIed module itself
                // Contain the fields in a list
                print("<ul id=\"fields-for-{$xmi_item['xmi_itemvalue']}\" class=\"xmi_field\">\n");
                // loop over each field that makes up the XMI item's display
                foreach ($xmi_fields as $xmi_field) {
                    $val = resTblTd($xmi_field, $xmi_key, $xmi_item['xmi_itemvalue']);
                    print("<li>");
                    if ($label === TRUE) {
                        print("<label class=\"form_label\">{$xmi_field['field_alias']}</label>");
                    }
                    print("$val");
                    print("</li>\n");
                }
                // End the list of fields for this XMIed item
                print("</ul>\n");
                // End the <li> container for the item
                print("</li>\n");
            }
            // end the list of XMIed items
            print("</ul>\n");
        }
        if ($register_conf) {
            $reg = "<div class=\"popup_reg\">\n";
            $reg .= "<a title=\"lbox_title\" href=\"overlay_holder.php?sf_conf=$register_conf";
            $reg .= "&amp;id_to_modify=actor_id_to_add{$sf_conf['sf_html_id']}";
            $reg .= "&amp;lboxreload=0";
            $reg .= $xmi_alias;
            $reg .= "&amp;sf_key=$xmi_key&amp;sf_val=$sf_val\"";
            $reg .= " rel=\"lightbox\" class=\"colorbox\">";
            $reg .= "<img class=\"med\" title=\"$mk_add $xmi_alias\"";
            $reg .= " src=\"{$skin_path}/images/plusminus/bigplus.png\">";
            $reg .= "</a>";
            $reg .= "</div>";
            print $reg;
        }
        // The ADD XMI form (that means ADD an XMI NOT add a new item)
        // The search dialogue contains its own add form ALL others are below
        if ($sf_conf['xmi_mode'] === 'search') {
            // Setup
            // These keys are to focus this subform on a particular key val pair
            $sf_focus = reqArkVar('sf_focus');
            if ($sf_focus == $sf_conf['sf_html_id']) {
                $skey = reqQst($_REQUEST, 'skey');
                $sval = reqQst($_REQUEST, 'sval');
            } else {
                $skey = FALSE;
                $sval = FALSE;
            }
            // Section 1 - The upper part of the SF is a complex edit panel
            // wrap the search in a div
            print("<div class=\"src_wrp\">\n");
            // Sec 1 - Left Hand Side - the mini search (provides its own div)
            $msrc = 'mrsc'.$sf_conf['sf_html_id'];
            $$msrc = reqArkVar($msrc);
            $msrc = 'mrsc'.$sf_conf['sf_html_id'];
            if (array_key_exists('op_src_meta_display', $sf_conf)) {
                $meta_display = $sf_conf['op_src_meta_display'];
            } else {
                $meta_display = FALSE;
            }
            print(mkSearchSimple($msrc, "&amp;sf_focus={$sf_conf['sf_html_id']}", $xmi_mod, $meta_display));
            unset($msrc);
            // Sec 1 - Right Hand Side - a record card
            print("<div class=\"mini_card\">");
            // If there is a focus then display the card - otherwise a helpful message
            if ($skey && $sval) {
                // Set the 'focused item' up as if it were an XMIed item and pull its settings etc.
                $xmi_mod = substr($skey, 0, 3);
                include('config/mod_'.$xmi_mod.'_settings.php');
                $xmi_conf_name = $xmi_mod.'_xmiconf';
                if ($xmi_conf = $$xmi_conf_name) {
                    $xmi_fields = $xmi_conf['fields'];
                    $xmi_fields = resTblTh($xmi_fields, 'silent');
                    $hdrbar_type = $xmi_conf['op_xmi_hdrbar'];
                }
                // Get alias for the focused/xmied itemkey
                $xmi_alias =
                    getAlias(
                        'cor_tbl_module',
                        $lang,
                        'itemkey',
                        $skey,
                        1
                );
                // Print out an XMI like view of the focused item (see sf_xmi.php)
                print("<ul class=\"top\">\n");
                print("<li>\n");
                // See sf_xmi.php for further detail on hdrbars
                if ($hdrbar_type == 'full') {
                    print("<h5>");
                    print("{$xmi_alias}: $sval");
                    print("</h5>\n");
                }
                if ($hdrbar_type == 'short') {
                    print("<h5>{$sval}</h5>\n");
                }
                if ($hdrbar_type == 'link') {
                    print("<h5>");
                    print("{$xmi_alias}: ");
                    print("<a href=\"{$conf_micro_viewer}?item_key=$skey");
                    print("&amp;{$skey}={$sval}\">");
                    print("{$sval}");
                    print("</a>");
                    print("</h5>\n");
                }
                printf("<ul id=\"fields-for-$sval\" class=\"xmi_field\">\n");
                // loop over each field that makes up the XMI item's display
                foreach ($xmi_fields as $xmi_field) {
                    $val = resTblTd($xmi_field, $skey, $sval);
                    print("<li>");
                    //print("<label>{$xmi_field['field_alias']}</label>");
                    print("$val");
                    print("</li>\n");
                }
                print("</ul>\n");
                print("</li>\n");         
                print("</ul>\n");
            // a helpful hint for the user
            } else {
                print("<p>$mk_minisrcinst</p>\n");
            }
            print("</div>\n");
            print("</div>\n");
        }
        // Put in Add form
        print("<form method=\"$form_method\" class=\"xmi_add\" id=\"$form_id\" action=\"{$_SERVER['PHP_SELF']}\">\n");
        print("<fieldset>\n");
        print("<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n");
        print("<input type=\"hidden\" name=\"item_key\" value=\"$sf_key\" />\n");
        print("<input type=\"hidden\" name=\"$sf_key\" value=\"{$sf_val}\" />\n");
        print("<input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />\n");
        print("<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n");
        print("<input type=\"hidden\" name=\"xmi_list_{$xmi_mod}_qtype\" value=\"add\" />");
        // if the xmi mode is search or auto, you don't really need this header
        if ($sf_conf['xmi_mode'] != 'search' && $sf_conf['xmi_mode'] != 'auto' ) {
            echo "<h5>$mk_add - $xmi_alias</h5>";
        }
        // Handle the different ADD types
        // Put in an add XMI of one of the permitted types
        // DD - A dropdown menu of ALL items in the XMI mod
        if ($sf_conf['xmi_mode'] === 'dd') {
            $dd =
                ddItemval(
                    $top_id,
                    $top_val,
                    $xmi_key
            );
            print($dd);
        }
        // DDFANCY - A dropdown menu of ALL items in the XMI mod using ddComplex
        // ddfancy requires 2 additional options to be set in the sf_conf:
        // op_dd_dataclass and op_dd_classtype
        if ($sf_conf['xmi_mode'] === 'ddfancy') {
            //printPre($field);
            $dd =
                ddComplex(
                    $top_id,
                    $top_val,
                    $xmi_mod.'_tbl_'.$xmi_mod, //tbl
                    $field['classtype'].'_'.$field['xmi_mod'], //ddname
                    $sf_conf['op_dd_dataclass'], //dataclass
                    $sf_conf['op_dd_classtype'], //classtype
                    $sf_conf['op_sqlorder'], //sqlorder
                    FALSE, //fragorder NOT IMPLEMENTED
                    $xmi_key //id_col
            );
            print($dd);
        }
        // TEXT - A normal text input field for the itemkey
        if ($sf_conf['xmi_mode'] === 'text') {
            if(reqQst($_SESSION, 'current_sgr')){
                print("<input type=\"text\" name=\"xmi_list_{$xmi_mod}\" value=\"{$_SESSION['current_sgr']}\" />\n");
            } else {
                print("<input type=\"text\" name=\"xmi_list_{$xmi_mod}\" value=\"\" />\n");
            }
        }
        // LIVE - A  live input field for the itemkey
        if ($sf_conf['xmi_mode'] === 'live') {
            $name = 'xmi_list_'.$xmi_mod;
            echo mkSearchType($sf_conf['xmi_mode'], $name, $xmi_key, '', '');
        }
        // SEARCH - put in the hidden fields set from the microsearch (see above)
        if ($sf_conf['xmi_mode'] === 'search') {
            if ($skey) {
                print("<h5>$skey = $sval</h5>\n");
                print("<input type=\"hidden\" name=\"xmi_list_{$xmi_mod}\" value=\"$sval\" />");
            }
        }
        // Autocomplete
        if ($sf_conf['xmi_mode'] === 'auto') {

            if(reqQst($_SESSION, 'current_sgr')){
                print("<input id=\"{$field['field_id']}_auto\" type=\"text\" name=\"xmi_list_{$xmi_mod}\" class=\"jumper\" value = \"{$_SESSION['current_sgr']}\" />");
            } else {
                print("<input id=\"{$field['field_id']}_auto\" type=\"text\" name=\"xmi_list_{$xmi_mod}\" class=\"jumper\" />");
            }
            
            print("<input id=\"{$xmi_mod}_issue_overlay\" type=\"button\" name=\"{$xmi_mod}_issue_overlay\" href=\"#inline_content\" value=\"&raquo;\" tabindex=\"-1\" />");
            $hidden_div = "<div style='display:none'><div id='inline_content' style='padding:10px; background:#fff;'>
            <label>Register Text for New Subgroup</label>
            <textarea id=\"sgr_interp\" name=\"sgr_interp\"></textarea>
            <input id=\"cxt_sgr_display_issue_next\" type=\"button\" name=\"sgr_issue_next\" value=\"&raquo;\" tabindex=\"-1\" />
            </div></div>";
            print($hidden_div);
            $script = "<script> $(document).ready(function(){";
            $script.="console.log('rdy');";
            $script .= "var {$sf_conf['sf_html_id']}Available = [";
            if(array_key_exists($field['op_xmi_itemkey'], $authitems)){
                foreach($authitems[$field['op_xmi_itemkey']] as $item){
                    $script.= '"'.$item.'",';
                }
            }
            $script.= "];
                jQuery( \"#{$field['field_id']}_auto\" ).autocomplete({
                    source: {$sf_conf['sf_html_id']}Available,
                });
                $(\"#{$xmi_mod}_issue_overlay\").colorbox({inline:true, width:\"300px\"});
                jQuery( \"#{$sf_conf['sf_html_id']}_issue_next\" ).click(function(){
                    jQuery( \"#{$sf_conf['sf_html_id']}_issue_next\" ).hide();
                    jQuery( \"#cxt_sgr_submitallbutton\" ).hide();
                    var newItemdata = {
                        itemkey : 'sgr_cd',
                        itemval : 'next',
                        field : 'conf_field_sgr_cd',
                        req : 'putField',
                        sgr_cd_qtype : 'add',
                    }
                    $.ajax({
                        type: \"POST\",
                        url: 'api.php',
                        data: newItemdata, // serializes the form's elements.
                        success: function(data){
                            if(!data.errors){
                                var newItemText = {
                                    itemkey : 'sgr_cd',
                                    itemval : data.qry_results[0].new_itemvalue,
                                    field : 'conf_field_short_desc',
                                    req : 'putField',
                                    short_desc_qtype : 'add',
                                    short_desc : $('#sgr_interp').val(),
                                }
                                $.ajax({
                                    type: \"POST\",
                                    url: 'api.php',
                                    data: newItemText, // serializes the form's elements.
                                    success: function(data){
                                    }
                                });
                                console.log($('#{$field['field_id']}_auto'));
                                $('#{$field['field_id']}_auto').attr('value', data.qry_results[0].new_itemvalue);
                                {$sf_conf['sf_html_id']}Available.push(data.qry_results[0].new_itemvalue);
                                jQuery( \"#cxt_sgr_submitallbutton\" ).show();
                                $.colorbox.close();
                            } else {
                                alert('error');
                            }
                        },
                        fail : function (data){
                            alert('data');
                        }
                    })
                });
            });</script>";
            echo $script;
        }
        // Finish off the form cleanly
        //echo "<button type=\"submit\">$mk_add</button>\n";
        echo "</fieldset>\n";
        echo "</form>\n";
        // Close out the SF
        print("</div>\n\n");
    break;
    
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_xmi\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_xmi was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
} // ends switch

// tidy up
unset ($sf_conf);
unset ($elem);
unset ($sf_state);
unset ($fields);

?>