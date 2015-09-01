<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * subforms/sf_savemap.php
 *
 * mapping subform for adding a new layer
 *
 * PHP versions 4 and 5
 *
 * LICENSE:
 * ARK - The Archaeological Recording Kit.
 * An open-source framework for displaying and working with archaeological data
 * Copyright (C) 2008 L - P : Partnership Ltd.
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category subforms
 * @package ark
 * @author Henriette Roued <henriette@roued.com>
 * @author Stuart Eve <stuarteve@lparchaeology.com>
 * @author Guy Hunt <guy.hunt@lparchaeology.com>
 * @copyright 1999-2008 L - P : Partnership Ltd.
 * @license http://ark.lparchaeology.com/license
 * @link http://ark.lparchaeology.com/svn/php/subforms/sf_txt.php
 * @since File available since Release 0.6
 *       
 */

// Need the mapping stuff!
include_once ('php/map/map_functions.php');

// ---- SETUP ---- //
$sf_cssclass = reqQst($sf_conf, 'op_cssclass');
if (!$sf_cssclass) {
    $sf_cssclass = 'mc_subform';
}
;
// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_save_map_as = getMarkup('cor_tbl_markup', $lang, 'savemapas');
$mk_save_map = getMarkup('cor_tbl_markup', $lang, 'savemap');
$mk_currentlayers = getMarkup('cor_tbl_markup', $lang, 'currentlayers');
$mk_mapsaved = getMarkup('cor_tbl_markup', $lang, 'mapsaved');
$mk_close = getMarkup('cor_tbl_markup', $lang, 'close');

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

$view = 'edit';

// -- PROCESS -- //
if ($update_db === $sf_conf['sf_html_id'] && $is_record_admin) {
    $itemkey = 'cor_tbl_map';
    $mapId = reqQst($_REQUEST,'map_id');
    if ($mapId=='new'){
        $result = addMap($mapId, $user_id, 'NOW()');
        if($result['success']){
            $itemval = $result['new_itemvalue'];
            $mapId = $result['new_itemvalue'];
            addAlias(reqQst($_REQUEST, 'map_alias'), $mapId, 'cor_tbl_map', $lang, $user_id, "NOW()");
        }
    } else {
        $itemval = $mapId;
    }
    $view = "process";
    include_once ('php/update_db.php');
    if ($error) {
        feedBk('error');
    }
    if ($message) {
        feedBk('message');
    }
    if (!$error) {
        $duplayers = duplicateLayers($mapId, reqQst($_REQUEST, 'layerlist'));
        if ($duplayers){
            $map['id'] = $mapId;
            $map['layers'] = $duplayers;
            $_SESSION['map'] = $map;
        }
    }
}

// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch($sf_state) {
    // Min Views
    case 'min_view' :
    case 'min_edit' :
    case 'min_ent' :
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
    case 'p_max_edit' :
    case 's_max_edit' :
    case 'overlay' :

        include ('js_savemap.php');
        
        if ($view == "edit") {
            $currentlayers = "<label for=\"layer_list\">$mk_currentlayers</label>";
            $currentlayers .= "<ul id=\"layer_list\">";
            $layers = "";
            foreach ( $map['layers'] as $key => $layer ) {
                $currentlayers .= "<li>";
                $currentlayers .= $layer['name'];
                $layers .= "{$layer['id']} ";
                $currentlayers .= "</li>";
            }
            $currentlayers .= "</ul>";
            $currentlayers .= "<input type=\"hidden\" name=\"layerlist\" value=\"{$layers}\">";
            // form
            $form = "<form method=\"POST\" name=\"{$sf_conf['sf_html_id']}\" id=\"{$sf_conf['sf_html_id']}\" action=\"{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}\" \">";
            $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\">";
            $form .= "<fieldset><ul>";
            foreach ( $fields as $field ) {
                $val = frmElem($field, $sf_key, $sf_val);
                $form .= "<li class=\"row\">";
                $form .= "<label class=\"form_label\">{$field['field_alias']}</label>";
                $form .= "<span class=\"inp\">$val</span>";
                $form .= "</li>\n";
            }
            $form .= "<li class=\"row\">$currentlayers</row>";
            $form .= "</ul></fieldset>";
            $form .= "<fieldset>";
            $form .= "<label>$mk_save_map_as</label>";
            $form .= "<ul>";
            $form .= "<li class=\"row\">";
            $form .= allMapsDD();
            $form .= "</li>";
            $form .= "<li class=\"row\">";
            $form .= "<input type=\"text\" name=\"map_alias\" value=\"\" /></li>";
            $form .= "<li class=\"row\"><button>$mk_save_map</button></li>";
            $form .= "</ul></fieldset>";
            $form .= "</form>\n";
            // output
            print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
            echo "$form\n";
            print("</div>\n");
        } else {
            print ($mk_mapsaved);
            $button = "<a id=\"close\" class=\"btn\" href=\"{$ark_dir}map_view.php?mapId={$mapId}&reset_map=true\">$mk_close</a>";
            print $button;
        }
        break;
    
    // a default - in case the sf_state is incorrect
    default :
        echo "<div id=\"sf_delete_record\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_delete_record was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
    
    // ends switch
}
// clean up
unset($sf_conf);
unset($val);
unset($sf_state);
unset($fields);
unset($alias_lang_info);

?>
