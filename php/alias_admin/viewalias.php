<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* view_alias.php
*
* prints and updates a form to add aliases to classtypes
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2007  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <
*
* @category   import
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2007 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/alias_admin/viewalias.php
* @since      File available since Release 0.6
*
* DEV NOTE: This is essentially a subform and should be recoded as such with view and edit states
*/

$type = reqQst($_REQUEST, 'type');
$class_id = reqQst($_REQUEST, 'class_id');
$quickedit = reqQst($_REQUEST, 'quickedit');

if (!$error) {
    // DEV NOTE: markup required here
    print("<div class=\"addclass_home\">");
    print("<p>This is used to edit aliases for a type</p>");
    // PART 1: OUTPUT TYPE
    if (isset($new_id)) {
        print('<p>');
        print("The new type id (for use in the cmap_struc_info table) is: $new_id");
        print("</p>");
        print('<p>To add another type please use the form below </p>');
    }
    //print out the form
    $lang_dd =
        ddSimple(
            'en',
            FALSE,
            'cor_lut_language',
            'language',
            'new_alias_lang',
            FALSE,
            'code'
    );
    $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
    $var = "<form method=\"$form_method\" id=\"alias_selector\" action=\"$_SERVER[PHP_SELF]\">";
    $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
    $var .= "<ul>";
    $var .= "<li class=\"row\">";
    $var .= "<label class=\"form_label\">Select  data class:</label>";
    $var .= "<select name=\"type\">\n";
    $types = array(
        'action' => 'Action',
        'attribute' => 'Attribute', //DEV NOTE: This is a mistake, this acts on TYPES not ATTRIBUTES
        'date' => 'Date',
        'number' => 'Number',
        'span' => 'Span',
        'txt' => 'Text',
        'place' => 'Place',
        );
    if ($type) {
        $var.= "<option value=\"$type\">$types[$type]</option>\n";
    } else {
        $var.= "<option value=\"\">---select---</option>\n";
    }
    foreach($types as $type_key => $type_val){
      $var .= "<option value=\"$type_key\">$type_val</option>\n";   
    }
 
    $var .= "</select>\n";
    $var .= "</li>\n";
    // PART 2 OPTION CLASS ID
    if ($type) {
        if ($class_id) {
            $class_name =  getSingle($type . 'type', 'cor_lut_' . $type . 'type', 'id='.$class_id);
            $type_dd =
                ddSimple(
                    FALSE,
                    $class_name,
                    'cor_lut_' . $type . 'type', $type . 'type',
                    'class_id',
                    FALSE,
                    'code'
            );
        } else {
            $type_dd =
                ddSimple(
                    FALSE,
                    FALSE,
                    'cor_lut_' . $type . 'type',
                    $type . 'type',
                    'class_id',
                    FALSE,
                    'code'
            );
        }
        $var .= "<li class=\"row\"><label class=\"form_label\">Select type:</label> $type_dd</li>\n";
    }
    $var .= "<li><button type=\"submit\" style=\"margin: 10px 10px 10px 250px\">$mk_go</button></li>\n";
    $var .= "</ul>";
    $var .= "</form>";
    
    // PART 3 OPTION ALIASES
    if ($class_id) {
        // if the class is set build the subform to display the class item and all of its aliases
        // grab all of the aliases (regardless of language)
        $aliases =
        getAllAliases(
            'cor_lut_' . $type .'type',
            'id',
            $class_id,
            1
            );
        // If the classtype is attribute, also get the aliases for individual attributes
        if ($type == 'attribute') {
        $aliasesattr = 
        getAllAliases(
            'cor_lut_' . $type ,
            'attributetype',
            $class_id,
            1
            );
            $aliases=array_merge($aliases,$aliasesattr);
        }
        $var .= "<form method=\"$form_method\" id=\"edt_alias\" action=\"{$_SERVER['PHP_SELF']}\">\n";
        $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $var .= "<table border=\"1\" class=\"register_tbl\">\n";
        // Print the header row
        $var .= "<tr><th>Alias</th><th>Language</th><th>options</th></tr>";
        // If there are any aliases for this record
        if ($aliases != FALSE) {
            // For each alias    
            foreach($aliases as $key => $row) {
                // If the alias is set to quickedit
                if ($quickedit == $row['id']) {
                    //print_r($row);
                    $var .='<tr>';
                    $var .= "<input type=\"hidden\" name=\"update_db\" value=\"register-{$class_id}\" />\n";
                    $var .= "<input type=\"hidden\" name=\"qtype\" value=\"edt\" />\n";
                    $var .= "<input type=\"hidden\" name=\"class_id\" value=\"$class_id\" />\n";
                    $var .= "<input type=\"hidden\" name=\"type\" value=\"$type\" />\n";
                    $var .= "<input type=\"hidden\" name=\"edt\" value=\"$quickedit\" />\n";
                    $alias_edt = '<input name="new_alias" type="text" value="'.$row['alias'].'"/>';
                    $lang_edt = ddSimple($row['language'],$row['language'],'cor_lut_language','language','alias_lang',"ORDER BY language",FALSE,'language'); 
                    $var .= "<td>{$alias_edt}</td><td>{$lang_edt}</td>";
                    $mk_edit = getMarkup('cor_tbl_markup', $lang, 'go');
                    $var .= "<td><button type=\"submit\">$mk_go</button></td>";
                    $var .="</tr>\n";
                }else{
                    $var .='<tr>';
                    $var .= "<td>{$row['alias']}</td><td>{$row['language']}</td>";
                    $mk_edit = getMarkup('cor_tbl_markup', $lang, 'edit');
                    $var .= "<td><a href=\"{$_SERVER['PHP_SELF']}?qtype=edt&quickedit={$row['id']}&type=$type&class_id=$class_id\"><button type=\"button\" >$mk_edit</button></a>";
                    $var .= "<a href=\"{$_SERVER['PHP_SELF']}?update_db=delfrag&qtype=del&frag_id={$row['id']}&type=$type&class_id=$class_id\">
            <img alt=\"on/off_swtich\" src=\"{$skin_path}/images/plusminus/minus.png\"/>
</a></td>";
                    $var .="</tr>\n";
                }
            }
        }
        // print out the add row if there is no qedit on
        if (empty($quickedit)) {
            // start row
            $var .= '<tr>';
            // put in hidden for the normal form
            $var .= "<input type=\"hidden\" name=\"update_db\" value=\"register-{$class_id}\" />\n";
            $var .= "<input type=\"hidden\" name=\"qtype\" value=\"add\" />\n";
            $var .= "<input type=\"hidden\" name=\"class_id\" value=\"$class_id\" />\n";
            $var .= "<input type=\"hidden\" name=\"type\" value=\"$type\" />\n";
            $var .= "<td><input type=\"textarea\" name=\"new_alias\"/></td>\n";
            $lang_dd = ddSimple('','','cor_lut_language','language','alias_lang',"ORDER BY language",FALSE,'language'); 
            $mk_save = getMarkup('cor_tbl_markup', $lang, 'save');
            $var .= "<td>$lang_dd</td>\n";
            $var .= "<td><button type=\"submit\">$mk_save</button></td>\n";
            // end the row
            $var .= "</tr>\n";
        }
        $var .= "</table>\n";
        $var .= "</form>\n";
        if ($error) {
            feedBk('error');
        }
    }
    // output the forms
    print($var);
    print("</div>");
}

?>
