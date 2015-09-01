<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* subforms/sf_embedmedia.php
*
* a subform for embedding media into a subform
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2007  L - P : Partnership Ltd.
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
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2012 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_entry/register.php
* @since      File available since Release 1.1
*
*/


// ---- SETUP ---- //

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// optional width
if (array_key_exists('op_media_width', $sf_conf)) {
    $media_width = $sf_conf['op_media_width'];
} else {
    $media_width = '420';
}

// optional height
if (array_key_exists('op_media_height', $sf_conf)) {
    $media_height = $sf_conf['op_media_height'];
} else {
    $media_height = '315';
}


// ---- COMMON ---- //
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);


// ---- PROCESS ---- //
if ($update_db == $sf_conf['sf_html_id']) {
    echo "ADMIN ERROR: sf_embedmedia cannot edit the database<br/>";
}


// ---- OUTPUT ---- //
$fields = resTblTh($sf_conf['fields'], 'silent');
$out_p = FALSE;
foreach ($fields as $key => $field) {
    $frag_list = getFile($sf_key, $sf_val, $field['classtype']);
    if ($frag_list) {
        $out_p .= "<div id=\"{$field['classtype']}\">";
        foreach ($frag_list as $key => $frag) {
            if (strpos($frag['uri'], '.youtube.')) {
                parse_str(parse_url($frag['uri'], PHP_URL_QUERY), $frag_vars);
                $out_p .= "<iframe width=\"$media_width\" height=\"$media_height\"";
                $out_p .= " src=\"http://www.youtube.com/embed/{$frag_vars['v']}\"";
                $out_p .= " frameborder=\"0\" allowfullscreen></iframe>\n";
            }
            if (strpos($frag['uri'], '.vimeo.')) {
                $out_p .= "<iframe src=\"{$frag['uri']}\" ";
                $out_p .= "width=\"$media_width\" height=\"$media_height\" frameborder=\"0\" ";
                $out_p .= "webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
            }
        }
        $out_p .= "</div>";
    }
}
if (!$out_p) {
    $mk_no_file = getMarkup('cor_tbl_markup', $lang, 'no_file');
    $message[] = $mk_no_file;
}

// STATE SPECFIC
// for each state get specific elements and then produce output
switch ($sf_state) {
    // Min Views
    case 'min_view':
        // start the SF
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        echo sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        // feedback
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        echo "</div>";
        break;
        
    // Max Views
    case 'p_max_view':
    case 's_max_view':
        // start the SF
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        echo sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        // feedback
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        echo $out_p;
        echo "</div>";
        break;
        
    // Max Edit
    case 'p_max_edit':
    case 's_max_edit':
        // start the SF
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        echo sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        // feedback
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        $var = FALSE;
        foreach ($fields as $key => $field) {
            $var .= "<a rel=\"lightbox\" href=\"overlay_holder.php?lboxreload=1";
            $var .= "&amp;sf_conf=conf_mac_mediabrowser&amp;link_file=item";
            $var .= "&amp;sf_val=$sf_val&amp;sf_key=$sf_key&amp;filetype={$field['classtype']}\">";
            $var .= "<img src=\"$skin_path/images/recordnav/addfile.png\"";
            $var .= " alt=\"media_browser\" class=\"med\"/>";
            $var .= "</a>";
        }
        echo $var;
        echo $out_p;
        echo "</div>";
        break;
    
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_embedmedia\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_embedmedia was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
}

?>
