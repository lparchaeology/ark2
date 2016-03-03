<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* php/micro_view/section_header.php
*
* Section header for micro_view page
*
* PHP versions 5 and 7
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
* @author     John Layt <john@layt.net>
* @copyright  1999-2016 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/php/micro_view/section_header.php
* @since      2.0
*/


// If no Itemkey or Itemval - give feedback cleanly to the user
if (!$sf_key) {
    $message[] = 'Select a form...';
} elseif (!$sf_val) {
    $message [] = 'Search for a ' . $mod_alias . ' item...';
} else {
    // TODO Make a HTML5 <header> and change id/class
    echo "<div id=\"record_nav\" class=\"record_nav\">\n";
    // Get the module alias
    $mod_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $item_key, 1);
    echo "<label>{$mod_alias}</label>\n";
    echo "<ul id=\"current\">\n";
    $item_xpl = explode('_', $sf_val);
    $item_ste_cd = $item_xpl[0];
    if (isset($conf_br) && chkModtype($mod_short)) {
        $item_num = modBr($sf_key, $sf_val, $conf_br);
    } else {
        $item_num = $item_xpl[1];
    }
    echo "<li class=\"current\">$item_ste_cd</li>\n";
    echo "<li class=\"current\">$item_num</li>\n";
    if (chkModtype($mod_short)) {
        $modtype = getModType($mod_short, $sf_val);
        if ($modtype) {
            $modtype_alias = getAlias($mod_short.'_lut_'.$mod_short.'type', $lang, 'id', $modtype, 1);
            echo "<li class=\"current\">$modtype_alias</li>\n";
        }
    }
    echo "</ul>\n";
    echo "</div>\n";
}

?>
