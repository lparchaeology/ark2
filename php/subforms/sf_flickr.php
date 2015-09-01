<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_flickr.php
*
* subform for displaying photos retrieved from flickr
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_flickr.php
* @since      File available since Release 0.7
*/

/*
* Like all subforms, this expects the following 2 vars:
*  $sf_conf - the fields to display in this sf
*  $sf_state - the state of this subform
* In addition it requires the phpFlickr codebase (http://phpflickr.com/) to be
* included in the folder specified in the PEAR path
*
*/

// ---- MARKUP ---- //
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

// ---- OTHER SETUP ---- //
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}
// start a blank $var
$var = FALSE;


// ---- STATE SPECIFIC ---- //
switch ($sf_state) {
    // Minimised states
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        $var .= "<div class=\"$sf_cssclass\">";
        // put in the nav
        $var .= sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        break;
        
    // Maximised States
    case 'p_max_view':
    case 'p_max_edit':
    case 'p_max_ent':
    case 's_max_view':
    case 's_max_edit':
    case 's_max_ent':
        // Start the sf div
        $var .= "<div class=\"$sf_cssclass\">";
        // Put in the sf_nav
        $var .= sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        require_once("phpFlickr/phpFlickr.php");
        // Create new phpFlickr object
        $f = new phpFlickr($sf_conf['api_key']);
        // set up the 'resultnum'
        if (!array_key_exists('op_resultnum', $sf_conf)) {
            $resultnum = 12;
        } else {
            $resultnum = $sf_conf['op_resultnum'];
        }
        // set up the search val use to search flickr
        $search_val = '';
        // get the search value from the field
        foreach ($sf_conf['fields'] as $key => $value) {
            $search_val = $search_val . " " . resTblTd($value, $sf_key, $sf_val);
        }
        // run the search
        $photos = $f->photos_search(array("text"=>$search_val, "per_page" => $resultnum));
        // handle the results
        foreach ((array)$photos['photo'] as $photo) {
                   $var .= "<a target=\"_blank\" href=http://www.flickr.com/photos/" . $photo['owner'] . 
                       "/" . $photo['id'] .">";
                   $var .= "<img border='0' alt='$photo[title]' src=" . 
                       $f->buildPhotoURL($photo, "Square") . ">";
                   $var .= "</a>";
        }
        $var .= "</div>";
        break;
        
    // in case it is a transclude
    case 'transclude':
        // this is empty
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_flickr\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for 'sf_flickr' was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;

} // ends switch

// now print the sf
print $var

?>
