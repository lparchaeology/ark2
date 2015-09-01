<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* markup_admin/view_mkup
*
* a script to act as a view of a single item of markup
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
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/markup_admin/view_mkup.php
* @since      File available since Release 0.6
*/
if (!isset($mk_id)) {
    $mk_id = reqQst($_REQUEST, 'mk_id');
}

$var = "<br /><div class=\"mc_subform\">";
if ($mk_id) {
    $mk = getRow('cor_tbl_markup', $mk_id);
    $var .= "<ul>";
    $var .= "<li class=\"row\"><label class=\"form_label\">ID</label><span class=\"value\">{$mk['id']}</span></li>\n";
    $var .= "<li class=\"row\"><label class=\"form_label\">Nickname</label><span class=\"value\">{$mk['nname']}</span></li>\n";
    $var .= "<li class=\"row\"><label class=\"form_label\">Markup</label><span class=\"value\">{$mk['markup']}</span></li>\n";
    $var .= "<li class=\"row\"><label class=\"form_label\">Module</label><span class=\"value\">{$mk['mod_short']}</span></li>\n";    
    $var .= "<li class=\"row\"><label class=\"form_label\">Language</label><span class=\"value\">{$mk['language']}</span></li>\n";
    $var .= "<li class=\"row\"><label class=\"form_label\">Description</label><span class=\"value\">{$mk['description']}</span></li>\n";
    $var .= "<li class=\"row\"><label class=\"form_label\">Created By</label><span class=\"value\">{$mk['cre_by']}</li></span>\n";
    $var .= "<li class=\"row\"><label class=\"form_label\">Created On</label><span class=\"value\">{$mk['cre_on']}</li></span>\n";
    $var .= "</ul>\n";                
} else {
    $var .= "no markup is selected";
}

$var .= "<p><a href=\"{$_SERVER['PHP_SELF']}?view=edit_mkup&amp;mk_id=$mk_id\">Edit this Markup</a></p>";

//now lets see if this markup needs translating

$untranslated_langs = chkTranslation('markup',$mk_id);

if (!empty($untranslated_langs)){
    foreach ($untranslated_langs as $lang){
        $var .= "<p><a href=\"{$_SERVER['PHP_SELF']}?view=add_mkup&amp;old_mk_id=$mk_id&amp;mk_trans_lang=$lang\">Translate this Markup into $lang </a></p>";
    }
}

$var .= "<p><a href=\"{$_SERVER['PHP_SELF']}?view=edit_mkup&amp;mk_del=$mk_id&amp;update_db=mkup\">Delete this Markup</a></p>";

$var .= "</div>";
print $var;

?>
