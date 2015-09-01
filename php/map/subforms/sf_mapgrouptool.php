<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_mapgrouptools.php
*
* subform for creating groups of spatial entities
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_wfs_spat.php
* @since      File available since Release 0.6
*/

// ---- SETUP ---- //
// a fresh var
$var = FALSE;

$geomfield = $field;

$mod_short = $sf_conf['target_module'];
$sf_key = $mod_short."_cd";
$sf_val = FALSE;
include_once 'config/mod_'.$mod_short.'_settings.php';

$subform = $sf_conf['subform'];
$subform = $$subform;

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// MARKUP
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$addnewlayer = getMarkup('cor_tbl_markup', $lang, 'addnewlayer');
$mk_go = getMarkup('cor_tbl_markup', $lang, 'save');
$mk_clear = getMarkup('cor_tbl_markup', $lang, 'clear');
$mk_addtocontainer = getMarkup('cor_tbl_markup', $lang, 'addtocontainer');
$mk_working = getMarkup('cor_tbl_markup', $lang, 'working');

// ---- OUTPUT ---- //
switch ($sf_state) {
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
    case 's_max_view':
        $var .= "<div class=\"{$sf_cssclass}\">";
        // put in the nav
        $var .= sfNav($sf_title, $cur_col_id, $sf_conf['sf_conf_id'], $$disp_cols);
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        break;

    case 'p_max_view':
    case 'p_max_edit':
    case 'p_max_ent':
    case 's_max_edit':
    case 's_max_ent':
    case 'lpanel':
        echo "<div id=\"{$sf_conf['sf_conf_id']}\" class=\"{$sf_cssclass}\">\n";
        echo "<div id=\"subforms\">\n";
        $sf_state = "s_max_edit"; // forces the sf into p max mode mode
        //keep current sf_conf safe
        $sf_conf_store = $sf_conf;
        $sf_conf = $subform;
        $cur_col_id = '1';
        $cur_sf_id = '1';
        $disp_cols = 'fake';
        $$disp_cols = array('1' => array('subforms' => array('1' => $subform), 'col_type'=>'transclude'));
        
        // if the sf is conditional
        if (array_key_exists('op_condition', $sf_conf)) {
            // check the condition
            if (chkSfCond($sf_key, $sf_val, $sf_conf['op_condition'])) {
                include($sf_conf['script']);
                $form_id = $sf_conf['sf_html_id']."_form"; 
            }
        } else {
            $form_id = $sf_conf['sf_html_id']."_form";
            include($sf_conf['script']);
        }

        $sf_conf = $sf_conf_store;
        include('js_mapgrouptool.php');
        
        $grouptoolpanel = "<div id=\"xmi_panel\"></div>";        

        $grouptoolpanel .= "<label>$mk_addtocontainer</label>";
        $grouptoolpanel .= "<input id=\"textselect_ark_id\" autocomplete=\"on\"></input>";
		$grouptoolpanel .= "<div id=\"group_container\" class=\"group_container\">";
		$grouptoolpanel .= "</div></div>";
		print $grouptoolpanel;
		
		$gopanel = "<div id=\"group_admin\"><h3>";
		$gopanel .= "<div id=\"working\"> $mk_working</div>";
		$gopanel .= "<a id=\"clearbtn\" class=\"delete\">$mk_clear</a>";
		$gopanel .= "<a id=\"gobtn\" class=\"delete\">$mk_go</a>";
		$gopanel .= "</h3><div id=\"message\" class=\"message\"></div>";
		print $gopanel;
		
       
        break;
        
    case 'transclude':
        echo "<div id=\"sf_layermanager\" class=\"{$css_class}\">\n";
        echo "<h3>No Transclude </h3>\n";
        echo "<p>ADMIN ERROR: There is no transclude option available for this subform</p>\n";
        echo "</div>\n";
        break;
        
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_wfs_spat\" class=\"{$css_class}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_wfs_spat was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
} // ends switch

// close SF
$var .= "</div>";
// echo
echo $var;
 unset($sf_conf);
 unset($sf_state);
?>
