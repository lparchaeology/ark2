<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_websites.php
*
* subform for displaying links to websites prefilled with parameters from ARK database
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
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_websites.php
* @since      File available since Release 0.7
*/

/*
* Like all subforms, this expects the following 2 vars:
*  $sf_conf - the fields to display in this sf
*  $sf_state - the state of this subform
* In addition it requires the phpFlickr codebase (http://phpflickr.com/) to be included in the folder specified in the PEAR path
*/

// setup a var
$var = FALSE;

$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

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
        
        // loop through the websites in the conf
        foreach ($sf_conf['websites'] as $key => $website) {
            $url = $website['url'];
            foreach ($website['params'] as $param) {
                // get the value from the field
                $field = $param['fields'];
                $search_val = urlencode(resTblTd($field,$sf_key, $sf_val));
                $url .= "{$param['variable']}$search_val";
            }
            $urls_array[$key]['title'] = $website['title'];
            $urls_array[$key]['href'] = $url;
        }
        
        $var .= "<div><ul>";
        foreach ($urls_array as $url) {
                   $var .= "<li><a class=more target=\"_blank\" href={$url['href']}>";
                   $var .= "{$url['title']}";
                   $var .= "</a></li>";
        }
        $var .= "</ul></div>";
        $var .= "</div>\n";
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_websites\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_websites was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
    } // ends switch
$var .= "</div>";
print $var

?>
