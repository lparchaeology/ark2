<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* markup_admin/add_mkup.php
*
* form to add new markup
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
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/markup_admin/add_mkup.php
* @since      File available since Release 0.6
*/

//this form can be used to add a totally new markup entry - but it can also be pre-filled with entries if (for example you want to translate a pre-existing markup entry)

$old_mk_id = reqQst($_REQUEST, 'old_mk_id');
$translate_lang = reqQst($_REQUEST, 'mk_trans_lang');
$nname = reqQst($_REQUEST, 'nname');
$description = reqQst($_REQUEST, 'description');
$markup = reqQst($_REQUEST, 'markup');
$old_lang = reqQst($_REQUEST, 'mk_lang');
$old_mod = reqQst($_REQUEST, 'mk_mod');

if ($old_mk_id) {
    $mk = getRow('cor_tbl_markup', $old_mk_id);
    $var = "<form method=\"$form_method\" id=\"add_mkup\" action=\"\" >\n";
    $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
    $var .= "<input type=hidden name=\"update_db\" value=\"mkup\">\n";
    $var .= "<input type=hidden name=\"mk_id\" value=\"new_id\">\n";
    $var .= "<input type=hidden name=\"old_mk_id\" value=\"$old_mk_id\">\n";
    $var .= "<input type=hidden name=\"nname\" value=\"{$mk['nname']}\">\n";
    $var .= "<input type=hidden name=\"description\" value=\"{$mk['description']}\">\n";
    $var .= "<div class=\"mc_subform\"><ul>\n";
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">ID</label>
                <span class=\"inp\">NEW MARKUP</span>
            </li>\n
    ";
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Nickname</label>
                <span class=\"inp\">{$mk['nname']}</span>
            </li>\n
    ";
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Markup</label>
                <span class=\"inp\"><textarea name=\"markup\"></textarea>
                <label class=\"prompt\">{$mk['markup']}</label></span>
            </li>\n
    ";

    $mod_dd = ddSimple($old_mod,'','cor_tbl_module','shortform','mk_mod',"ORDER BY shortform",FALSE,'shortform');     
    
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Module</label>
                <span class=\"inp\">$mod_dd</span>
            </li>\n
    ";    
    
    if ($translate_lang != FALSE) {
        $lang_dd = ddSimple($translate_lang,$translate_lang,'cor_lut_language','language','mk_lang',"ORDER BY language",FALSE,'language'); 
    } else {
        $lang_dd = ddSimple($mk['language'],$mk['language'],'cor_lut_language','language','mk_lang',"ORDER BY language",FALSE,'language'); 
    }
    
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Language</label>
                <span class=\"inp\">$lang_dd</span>
            </li>\n
    ";

    $var .= "
           <li class=\"row\">
               <label class=\"form_label\">Description</label>
               <span class=\"inp\">{$mk['description']}</span>
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
    $var .= "</ul></div>\n";
    $var .= "</form>\n";
} else {
    
    $var = "<form method=\"$form_method\" id=\"edit_mkup\" action=\"\" >\n";
    $var .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
    $var .= "<input type=hidden name=\"update_db\" value=\"mkup\">\n";
    $var .= "<input type=hidden name=\"mk_id\" value=\"new_id\">\n";
    $var .= "<br /><div class=\"mc_subform\"><ul>\n";
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">ID</label>
                <span class=\"inp\">NEW MARKUP</span>
            </li>\n
    ";
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Nickname</label>
                <span class=\"inp\"><input type=\"text\" name=\"nname\" />$nname</span>
            </li>\n
    ";
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Markup</label>
                <span class=\"inp\"><textarea name=\"markup\">$markup</textarea></span>
            </li>\n
    ";

    $mod_dd = ddSimple($old_mod,'','cor_tbl_module','shortform','mk_mod',"ORDER BY shortform",FALSE,'shortform');     
    
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Module</label>
                <span class=\"inp\">$mod_dd</span>
            </li>\n
    ";
    
    $lang_dd = ddSimple($old_lang,'','cor_lut_language','language','mk_lang',"ORDER BY language",FALSE,'language'); 
    
    $var .= "
            <li class=\"row\">
                <label class=\"form_label\">Language</label>
                <span class=\"inp\">$lang_dd</span>
            </li>\n
    ";

    $var .= "
           <li class=\"row\">
               <label class=\"form_label\">Description</label>
               <span class=\"inp\"><textarea name=\"description\">$description</textarea></span>
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
    $var .= "</ul></div>\n";
    $var .= "</form>\n";
}
print $var;
?>
