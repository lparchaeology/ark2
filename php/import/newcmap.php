<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* import/newcmap.php
*
* creates a new concordance map
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
* @category   import
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/import/editcmap.php
* @since      File available since Release 0.8
*
* This behaves like a subform. It could be turned into a subform if so desired
*
*/

// PROCESS
// is done at the page level

// MARKUP
$mk_save = getMarkup('cor_tbl_markup', $lang, 'save');
$mk_recsucs = getMarkup('cor_tbl_markup', $lang, 'recsucs');

// FETCH DATA
// get a list of DBs for this server
$db_list = $db->query('SHOW DATABASES');


// OUTPUT
// put in a fresh form
if (!$update_db) {
    // form
    $form = "<div id=\"newcmap_home\">";
    $form .= "<form method=\"$form_method\" class=\"mc_subform\" name=\"new_cmap_form\" id=\"new_cmap_form\" action=\"{$_SERVER['PHP_SELF']}\" \">";
    $form .= "<fieldset>";
    $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
    $form .= "<input type=\"hidden\" name=\"update_db\" value=\"addcmp\" />";
    // Contain the input elements in a list
    $form .= "<ul>\n";
    $form .= "<li class=\"row\">";
    $form .= "<label class=\"form_label\">Nickname</label>";
    $form .= "<input type=\"text\" name=\"nickname\" value=\"\" />\n";
    $form .= "</li>\n";
    $form .= "<li class=\"row\">";
    $form .= "<label class=\"form_label\">Description</label>";
    $form .= "<textarea id=\"cmap_desc\" name=\"cmap_desc\" rows=\"4\" cols=\"30\" >\n";
    $form .= "</textarea>\n";
    $form .= "</li>\n";
    $form .= "<li class=\"row\">";
    $form .= "<label class=\"form_label\">Source DB</label>";
    $form .= "<select name=\"source_db\">\n";
    $form .= "<option value=\"0\">-----</option>\n";
    while ($row = $db_list->fetch(PDO::FETCH_ASSOC)) {
        $form .= "<option value=\"{$row['Database']}\">{$row['Database']}</option>\n";
    }
    $form .= "</select>\n";
    $form .= "</li>\n";
    $form .= "<li class=\"row\">";
    $form .= "<label class=\"form_label\">(target) Site Code</label>";
    $form .= ddSimple($ste_cd, $ste_cd, 'cor_tbl_ste', 'id', 'ste_cd', '', 'code');
    $form .= "</li>\n";
    $form .= "<li class=\"row\">";
    $form .= "<label class=\"form_label\">&nbsp;</label>";
    $form .= "<span class=\"inp\"><button type=\"submit\" />$mk_save</button></span>";
    $form .= "</li>\n";
    $form .= "</ul>\n";
    $form .= "</fieldset>";
    $form .= "</form>\n";
    $form .= "</div>\n";
    // print it
    echo "$form";
}

?>
