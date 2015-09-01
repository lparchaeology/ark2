<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_qrtag.php
*
* subform for displaying a qr tag for the item
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
* @copyright  1999-2011 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/trunk/php/subforms/sf_flickr.php
* @since      File available since Release 0.7
*
*/


// ---- SETUP ---- //
$var = FALSE;

// Markup etc.
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);


// ---- OUTPUT ---- //
// state dependant
switch ($sf_state) {
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        // start the SF
        $var .= "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        $var .= sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        $var .= "</div>\n";
        break;
        
    case 'p_max_view':
    case 'p_max_edit':
    case 'p_max_ent':
    case 's_max_view':
    case 's_max_edit':
    case 's_max_ent':
        // start the SF
        $var .= "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        $var .= sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        $web_host = getWebHost();
        $target_url = "$web_host/$ark_dir/micro_view.php?&item_key=$sf_key&$sf_key=$sf_val";
        $target_url = rawurlencode($target_url);
        $var .= "<a target=\"_blank\">";
        $var .= "<img border='0' alt='qrtag' src='lib/php/qr_img/php/qr_img.php?d=$target_url&e=M&v=AUTO&s=3'></a>";
        $var .= "</div>\n";
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_qrtag\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_qrtag was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
    } // ends switch

// echo
echo $var

?>
