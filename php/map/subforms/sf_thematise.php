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

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// MARKUP
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_none = getMarkup('cor_tbl_markup', $lang, 'none');
$mk_themeexplain = getMarkup('cor_tbl_markup', $lang, 'themeatiseexplain');


$available_attributetypes = array();

if(!array_key_exists('json_array', $_SESSION)){
    $sqltext = "select a.itemvalue, a.attribute as attributeid, c.alias, b.attribute, b.attributetype, d.alias as typealias 
        from 
            cor_tbl_attribute a, cor_lut_attribute b, cor_tbl_alias c, cor_tbl_alias d 
        where a.itemkey=? 
            and a.attribute = b.id 
            and c.itemkey='cor_lut_attribute' 
            and c.itemvalue = b.id 
            and d.itemkey='cor_lut_attributetype' 
            and d.itemvalue = b.attributetype";

    $params = array($sf_conf['fields'][0]['module'].'_cd');
    // run the query
    $sql = dbPrepareQuery($sqltext,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        // create a neat array
        do {
            $res_arr[$row['itemvalue']][$row['attributetype']] = array('attribute' => $row['attributeid'], 'aliases'=>array('en'=>$row['alias']));
            if(!in_array($row['attributetype'],$available_attributetypes)){
                $available_attributetypes[] = $row['attributetype'];
            }
        } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    }
    $json_array = json_encode($res_arr);
    $_SESSION['available_attributetypes'] = $available_attributetypes;
    $_SESSION['json_array'] = $json_array;
} else {
    $json_array = $_SESSION['json_array'];
    $available_attributetypes = $_SESSION['available_attributetypes'];
}

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
        
        include('js_thematise.php');
        
        echo "<div class=\"map_panel\">";
        
        echo "<h4>Themeatise</h4>";
        echo $mk_themeexplain;
        echo "<ul class=\"attribute_options\">";
        echo "<li><button id=\"thematise\" class=\"thematisebtn btn\" value=\"none\">$mk_none</button></li>";
        foreach ($available_attributetypes as $attributetype){
            $attributetypealias = getAlias('cor_lut_attributetype', $lang, 'id', $attributetype, 1);
            echo "<li><button id=\"thematise\" class=\"thematisebtn btn\" value=\"$attributetype\">$attributetypealias</button></li>";
        }
        echo "</ul>";
        echo "<div id=\"legend_panel\"><ul>";
        
        echo "</ul></div>";
        
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
