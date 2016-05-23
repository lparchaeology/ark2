<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_view/page_nav.php
*
* nave panel in data view page
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
* @link       http://ark.lparchaeology.com/code/php/data_view/page_nav.php
* @since      File available since Release 0.6
*/

$sf_key = FALSE;
$sf_val = FALSE;

if (isset($mod_short)) {
    $mod_short_store = $mod_short;
}
$mod_short = 'cor';

// ---- OUTPUT ---- //

echo '<!-- BEGIN leftpanel -->';
// TODO Change to HTML5 <nav> with new id/class
echo '<div id="lpanel" class="leftpanel">';

echo "<div id=\"filter_panel\">";
include('php/common/page_nav.php');
echo mkFtrModeNav($ftr_mode);
echo '</div>'; // filter_panel

echo '</div>'; // leftpanel

if (isset($mod_short_store)) {
    $mod_short = $mod_short_store;
} else {
    unset($mod_short);
}

?>
