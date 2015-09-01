<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* user_admin/left_panel.php
*
* left panel for user admin
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
* @category   user
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/user_admin/left_panel.php
* @since      File available since Release 0.6
*/

?>

<h1><?=getMarkup('cor_tbl_markup', $lang, 'useradminoptions')?></h1>

<ul class="module_list">
<?php 
    $mk_user = getMarkup('cor_tbl_markup', $lang, 'user');
    $var = "<li>";
    $var .= "<label>{$mk_user}</label>\n";
    // Add an icon for adding users
    $img = "<img src=\"$skin_path/images/plusminus/bigplus.png\" title=\"Add User\" class=\"med\" />";
    $var .= "<a href=\"{$_SERVER['PHP_SELF']}?view=addusrl\">";
    $var .= $img;
    $var .= "</a>";
    // Add an icon for editing users
    $img = "<img src=\"$skin_path/images/plusminus/edit.png\" title=\"Edit User\" class=\"med\" />";
    $var .= "<a href=\"{$_SERVER['PHP_SELF']}?view=edtuser\">";
    $var .= $img;
    $var .= "</a>";
    $var .= "</li>";
    echo $var;
?>
</ul>
