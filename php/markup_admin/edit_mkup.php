<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* markup_admin/edit_mkup.php
*
* creates a form to edit existing markup
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
* @category   markup
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/markup_admin/edit_mkup.php
* @since      File available since Release 0.6
*/

$mk_id = reqQst($_REQUEST, 'mk_id');
$translate_lang = reqQst($_REQUEST, 'mk_trans_lang');
$mk = getRow('cor_tbl_markup', $mk_id);

if ($mk_id) {
    $var = "<div class=\"mc_subform\">";
    $var .= "<form method=\"$form_method\" id=\"edit_mkup\" action=\"\" >\n";
    $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
    $var .= "<input type=hidden name=\"update_db\" value=\"mkup\">\n";
    $var .= "<input type=hidden name=\"mk_id\" value=\"$mk_id\">\n";
    $var .= "<ul>\n";
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">ID</label>
                <span class=\"inp\">$mk_id</span>
            </li>\n
    ";
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Nickname</label>
                <span class=\"inp\"><input type=\"text\" name=\"nname\" value=\"{$mk['nname']}\" /></span>
            </li>\n
    ";
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Markup</label>
                <span class=\"inp\"><textarea name=\"markup\">{$mk['markup']}</textarea></span>
            </li>\n
    ";

   $mod_dd = ddSimple($mk['mod_short'],$mk['mod_short'],'cor_tbl_module','shortform','mk_mod',"ORDER BY shortform",FALSE,'shortform');     
    
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Module</label>
                <span class=\"inp\">$mod_dd</span>
            </li>\n
    ";
    
    $lang_dd = ddSimple($mk['language'],$mk['language'],'cor_lut_language','language','mk_lang',"ORDER BY language",FALSE,"language"); 
    
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Language</label>
                <span class=\"inp\">$lang_dd</span>
            </li>\n
    ";

    $var .= "
           <li class=\"row\">
               <label class=\"form_label\">Description</label>
               <span class=\"inp\"><textarea name=\"description\">{$mk['description']}</textarea></span>
           </li>\n
       ";

    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Save</label>
                <span class=\"inp\">
                    <button type=\"submit\">Save</button>
                </span>
            </li>\n
    ";
    $var .= "</ul>\n";
    $var .= "</form>\n";
    $var .= "</div>\n";
} else {
    $var = "no markup is selected";
}

print $var;

?>
