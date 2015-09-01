<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_newlayer.php
*
* mapping subform for adding a new layer
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
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_txt.php
* @since      File available since Release 0.6
*/

//Need the mapping stuff!


include_once('php/map/map_functions.php');

// ---- SETUP ---- //
$sf_cssclass = reqQst( $sf_conf, 'op_cssclass');
if (!$sf_cssclass){
	$sf_cssclass = 'mc_subform';
};
// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_addThisLayer = getMarkup('cor_tbl_markup', $lang, 'addThisLayer');
$mk_go = getMarkup('cor_tbl_markup', $lang, 'go');

$map = reqQst($_SESSION, 'map');

if (!$map) {
    $mapId = reqArkVar('mapId');
    if ($mapId) {
        $map = getMap($mapId);
        $_SESSION['map'] = $map;
    } else {
        echo getMarkup('cor_tbl_markup', $lang, 'nomaprequested');
    }
} else {
    $mapId = $map['id'];
}

$fields = resTblTh($sf_conf['fields'], 'silent');
// Check the user permissions for admin tools
$admin_int = array_intersect($record_admin_grps, $_SESSION['sgrp_arr']);
if (!empty($admin_int)) {
    $is_record_admin = TRUE;
} else {
    $is_record_admin = FALSE;
}
// -- PROCESS -- //
if ($update_db === $sf_conf['sf_html_id']) {
    $itemkey = 'cor_tbl_maplayer';
    $itemval = $sf_val;
    include_once ('php/update_db.php');
    if ($error) {
        feedBk('error');
    }
    if ($message) {
        feedBk('message');
    }
    if(!$error){
        $map['layers'] = getLayers($mapId);
        $_SESSION['map']=$map;
    }
}

// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch ($sf_state) {
    // Min Views
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        print("</div>");
    break;
    
    // Overlay Views
    // Max Edits
    case 'p_max_edit':
    case 's_max_edit':
    case 'overlay':
        // form
        $form = "<form method=\"POST\" name=\"{$sf_conf['sf_html_id']}\" id=\"{$sf_conf['sf_html_id']}\" action=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}\" \">";
        $form.="<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\">";
        $form.="<fieldset><ul>";
		foreach ($fields as $field){
		    $field['current'] = resFdCurr($field, $sf_key, $sf_val);
		    $val = frmElem($field, $sf_key, $sf_val);
            $form .= "<li class=\"row\">";
            $form .= "<label class=\"form_label\">{$field['field_alias']}</label>";
            $form .= "<span class=\"inp\">$val</span>";
            $form .= "</li>\n";
		}
        $form .= "<li class=\"row\">";
		$form.="</ul></div>";
		$form.="<ul><li class=\"row\"><button id=\"submit\">$mk_go</button></li></ul>";
        // output
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        echo "$form\n";
        print("</div>");
        // exit
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_delete_record\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_delete_record was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;

// ends switch
}
// clean up
unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);
unset ($alias_lang_info);

?>
