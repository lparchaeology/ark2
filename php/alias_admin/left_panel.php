<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* alias_admin/left_panel.php
*
* left panel for use in the alias admin page
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
* @category   admin
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/alias_admin/left_panel.php
* @since      File available since Release 0.6
*/

?>

<h1><?=getMarkup('cor_tbl_markup', $lang, 'aliasadminoptions')?></h1>

<div class="leftpanelwrapper">
<ul class="importlpanel">
<?php
    $var = "<ul>";

    // Add an icon for adding users
    $add_markup = getMarkup('cor_tbl_markup', $lang, 'addclasstype');
    $var .= "<li><a href=\"{$_SERVER['PHP_SELF']}?view=addclasstype\">";
    $var .= $add_markup;
    $var .= "</a></li>";
    // Add an icon for editing users
    $edit_markup = getMarkup('cor_tbl_markup', $lang, 'edtalias');
    $var .= "<li><a href=\"{$_SERVER['PHP_SELF']}?view=viewalias\">";
    $var .= $edit_markup;
    $var .= "</a></li>";

    print $var;
?>
</ul>
</div>
