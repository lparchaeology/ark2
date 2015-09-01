<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/page_settings.php
*
* Page specific settings file for this version of ARK
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2012  L - P : Heritage LLP.
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
* @category   admin
* @package    ark
* @author     Mike Johnson <m.johnson@lparchaeology.com>
* @copyright  1999-2014 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/config/map_settings.php
* @since      File available since Release 1.0
*/

$vd_map_chainkey =
array(
                'rq_func' => 'reqManual',
                'vd_func' => 'chkSet',
                'var_name' => 'itemkey',
                'force_var' => 'cor_tbl_map'
);
$vd_maplayer_chainkey =
array(
                'rq_func' => 'reqManual',
                'vd_func' => 'chkSet',
                'var_name' => 'itemkey',
                'force_var' => 'cor_tbl_maplayer'
);
$vd_chainval =
array(
                'rq_func' => 'reqMulti',
                'vd_func' => 'chkSet',
                'var_name' => 'itemval',
                'lv_name' => 'itemval',
                'var_locn' => 'live'
);

$mapchain_txt_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $txt_vd_txttype,
        $txt_vd_txt,
        $vd_map_chainkey,
        $vd_chainval,
        $vd_live_lang
);
// edt txt default validation group
$mapchain_txt_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $txt_vd_txttype,
        $txt_vd_txt,
        $vd_map_chainkey,
        $vd_chainval,
        $vd_frag_id,
        $vd_live_lang
);
$mapchain_attr_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $attr_vd_attributetype,
        $attr_vd_attribute,
        $attr_vd_bv,
        $vd_map_chainkey,
        $vd_chainval,
);

// edt attr default validation group
$mapchain_attr_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $attr_vd_attributetype,
        $attr_vd_attribute,
        $attr_vd_bv,
        $vd_map_chainkey,
        $vd_chainval,
        $vd_frag_id
);

// add number default validation group
$mapchain_number_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $number_vd_numbertype,
        $number_vd_number,
        $vd_map_chainkey,
        $vd_chainval,
);
// edt number default validation group
$mapchain_number_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $number_vd_numbertype,
        $number_vd_number,
        $vd_map_chainkey,
        $vd_chainval,
        $vd_frag_id,
);
$layerchain_txt_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $txt_vd_txttype,
        $txt_vd_txt,
        $vd_maplayer_chainkey,
        $vd_chainval,
        $vd_live_lang
);
// edt txt default validation group
$layerchain_txt_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $txt_vd_txttype,
        $txt_vd_txt,
        $vd_maplayer_chainkey,
        $vd_chainval,
        $vd_frag_id,
        $vd_live_lang
);
$layerchain_attr_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $attr_vd_attributetype,
        $attr_vd_attribute,
        $attr_vd_bv,
        $vd_maplayer_chainkey,
        $vd_chainval,
);

// edt attr default validation group
$layerchain_attr_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $attr_vd_attributetype,
        $attr_vd_attribute,
        $attr_vd_bv,
        $vd_maplayer_chainkey,
        $vd_chainval,
        $vd_frag_id
);

// add number default validation group
$layerchain_number_add_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $number_vd_numbertype,
        $number_vd_number,
        $vd_maplayer_chainkey,
        $vd_chainval,
);
// edt number default validation group
$layerchain_number_edt_validation =
    array(
        $vd_cre_on,
        $vd_log,
        $vd_cre_by,
        $number_vd_numbertype,
        $number_vd_number,
        $vd_maplayer_chainkey,
        $vd_chainval,
        $vd_frag_id,
);
/** MAP Fields
 * These fields are required for a map
 */

// MAPPING TXT
$conf_field_ark_name =
    array(
        'field_id' => 'conf_field_map_name',
        'dataclass' => 'txt',
        'classtype' => 'map_name',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $layerchain_txt_add_validation,
        'edt_validation' => $layerchain_txt_edt_validation,
);

$conf_field_remotename =
    array(
        'field_id' => 'conf_field_remotename',
        'dataclass' => 'txt',
        'classtype' => 'remotename',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $layerchain_txt_add_validation,
        'edt_validation' => $layerchain_txt_edt_validation,
);

$conf_field_mapcenter =
    array(
        'field_id' => 'conf_field_mapcenter',
        'dataclass' => 'txt',
        'classtype' => 'mapcenter',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $mapchain_txt_add_validation,
        'edt_validation' => $mapchain_txt_edt_validation,
);

$conf_field_layeruri =
    array(
        'field_id' => 'conf_field_layeruri',
        'dataclass' => 'txt',
        'classtype' => 'layeruri',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $layerchain_txt_add_validation,
        'edt_validation' => $layerchain_txt_edt_validation,
);

$conf_field_layerstyle =
    array(
        'field_id' => 'conf_field_layerstyle',
        'dataclass' => 'txt',
        'classtype' => 'layerstyle',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $layerchain_txt_add_validation,
        'edt_validation' => $layerchain_txt_edt_validation,
);

// MAPPING ATTRIBUTEs

$conf_field_mapprojection =
    array(
        'field_id' => 'conf_field_projection',
        'dataclass' => 'attribute',
        'classtype' => 'projection',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $mapchain_attr_add_validation,
        'edt_validation' => $mapchain_attr_edt_validation,
);

$conf_field_projection =
array(
                'field_id' => 'conf_field_projection',
                'dataclass' => 'attribute',
                'classtype' => 'projection',
                'aliasinfo' => FALSE,
                'editable' => TRUE,
                'hidden' => FALSE,
                'add_validation' => $layerchain_attr_add_validation,
                'edt_validation' => $layerchain_attr_edt_validation,
);

$conf_field_format =
    array(
        'field_id' => 'conf_field_format',
        'dataclass' => 'attribute',
        'classtype' => 'layerformat',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $layerchain_attr_add_validation,
        'edt_validation' => $layerchain_attr_edt_validation,
);

$conf_field_servertype =
    array(
        'field_id' => 'conf_field_servertype',
        'dataclass' => 'attribute',
        'classtype' => 'servertype',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $layerchain_attr_add_validation,
        'edt_validation' => $layerchain_attr_edt_validation,
);

$conf_field_zoomlevel =
    array(
        'field_id' => 'conf_field_zoomlevel',
        'dataclass' => 'number',
        'classtype' => 'zoomlevel',
        'aliasinfo' => FALSE,
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $mapchain_number_add_validation,
        'edt_validation' => $mapchain_number_edt_validation,
);

/** MAP VIEW
*   These settings control the subforms and left panel in the map view.
*   If using the mapping capabilities, the map view needs configuration in left panel,
*   and a few default settings configured.
*/

// MAP VIEW PAGE SETTINGS
$conf_page_map_view =
    array(
        'name' =>'Map View',
        'title' => 'Map View Page',
        'file' => 'map_view.php',
        'sgrp' => '3',
        'navname' => 'mapviewnav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'php/map_view/',
        'is_visible' => TRUE,
);

// LEFT PANEL
// Mapping sf_confs
$conf_map_layer_manager =
    array(
        'sf_conf_id' => 'conf_map_layer_manager',      
        'view_state' => 'max',
        'edit_state' => 'view', 
        'sf_nav_type' => 'full',
        'sf_title' => 'layermanager', 
        'sf_html_id' => 'layermanager', // Must be unique
        'script' => 'php/map/subforms/sf_layermanager.php',
        'op_class' => 'panel',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_icon' => 'screwdriver.png',
        'op_overlay' => false,
        'op_sf_cssclass' => 'contextmenu',
        'fields' => array(
        )
    );

$conf_map_savemap =
    array(
                'sf_conf_id' => 'conf_map_savemap',
                'view_state' => 'max',
                'edit_state' => 'view',
                'sf_nav_type' => 'nmedit',
                'sf_title' => 'savemap',
                'sf_html_id' => 'savemap', // Must be unique
                'script' => 'php/map/subforms/sf_savemap.php',
                'op_modtype' => FALSE, //if each modtype uses same fields (see below)
                'op_class' => 'overlay',
                'conflict_res_sf' => 'conf_mcd_dnarecord',
                'op_icon' => 'hammer.png',
                'op_overlay' => true,
                'fields' =>
                array(
                    $conf_field_mapcenter,
                    $conf_field_mapprojection,
                    $conf_field_zoomlevel,
                )
);

$conf_map_newlayer =
    array(
        'sf_conf_id' => 'conf_map_newlayer',  
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'newlayer',
        'sf_html_id' => 'newlayer', // Must be unique
        'script' => 'php/map/subforms/sf_newlayer.php',
        'op_class' => 'overlay',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'conflict_res_sf' => 'conf_mcd_dnarecord',
        'op_icon' => 'hammer.png',
        'op_overlay' => true,
        'fields' =>
        array(
            $conf_field_layeruri,
            $conf_field_ark_name,
            $conf_field_format,
            $conf_field_projection,
            $conf_field_remotename,
            $conf_field_servertype,
        )
);

$conf_map_editlayer =
    array(
        'sf_conf_id' => 'conf_map_editlayer',  
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'editlayer',
        'sf_html_id' => 'editlayer', // Must be unique
        'script' => 'php/map/subforms/sf_editlayer.php',
        'op_class' => 'overlay',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'conflict_res_sf' => 'conf_mcd_dnarecord',
        'op_icon' => 'hammer.png',
        'op_overlay' => true,
        'fields' =>
        array(
            $conf_field_layeruri,
            $conf_field_ark_name,
            $conf_field_format,
            $conf_field_projection,
            $conf_field_remotename,
            $conf_field_servertype,
        )
);

$conf_map_serverlayer =
    array(
            'sf_conf_id' => 'conf_map_serverlayer',
            'view_state' => 'max',
            'edit_state' => 'view',
            'sf_nav_type' => 'nmedit',
            'sf_title' => 'newlayer',
            'sf_html_id' => 'newlayer', // Must be unique
            'script' => 'php/map/subforms/sf_serverlayer.php',
            'op_class' => 'overlay',
            'op_modtype' => FALSE, //if each modtype uses same fields (see below)
            'conflict_res_sf' => 'conf_mcd_dnarecord',
            'op_icon' => 'hammer.png',
            'op_overlay' => true,
            'fields' =>
            array(
                    $conf_field_layeruri,
                    $conf_field_ark_name,
                    $conf_field_format,
                    $conf_field_projection,
                    $conf_field_remotename,
                    $conf_field_servertype,
            )
    );
    
$conf_map_choosemap =
array(
                'sf_conf_id' => 'conf_map_choosemap',
                'view_state' => 'max',
                'edit_state' => 'view',
                'sf_nav_type' => 'nmedit',
                'sf_title' => 'choosemap',
                'sf_html_id' => 'choosemap', // Must be unique
                'script' => 'php/map/subforms/sf_choosemap.php',
                'op_modtype' => FALSE, //if each modtype uses same fields (see below)
                'conflict_res_sf' => 'conf_mcd_dnarecord',
                'op_icon' => 'maps.png',
                'op_overlay' => true,
                'fields' =>
                    array(
                                $conf_field_layeruri,
                                $conf_field_ark_name,
                                $conf_field_format,
                                $conf_field_projection,
                                $conf_field_remotename,
                                $conf_field_servertype,
                    )
);
$map_view_left_panel  =
    array(
        'col_id' => 'mavlp',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' =>
            array(
                //$uhlp_subform_profilepane,
                //$conf_map_layer_manager,
        )
);
$conf_mapsf_admintools =
    array(
        'sf_html_id' => 'admintools',
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => '',
        'sf_nav_type' => 'none',
        'script' => 'php/map/subforms/sf_toolbox.php',
        'op_switchmode' => 'edit',
        'fields' => array(
            // fields are geometries. so any module vector layers could be added here
            $conf_field_locs
        ),
        //admin tools wraps several other subform tools - like a frame.
        'subforms' => array(
            $conf_map_layer_manager,
            $conf_map_savemap,
            $conf_map_choosemap,
            //$conf_map_edit
         )
);
$conf_map_admin =
array (
                'sf_html_id' => 'map_view',
                'view_state' => 'max',
                'edit_state' => 'view',
                'sf_title' => '',
                'op_map' => '3',
                'sf_nav_type' => 'none',
                'script' => 'php/map/subforms/sf_ol3map.php',
                'fields' =>
                array (
                                // fields are geometries. so any module vector layers could be added here
                                //$conf_field_rgf_schm,
                ),
                'subforms' =>
                array (
                                $conf_mapsf_admintools,
                                // maps can have subforms within them, so they come onto the max view
                                // sliders and tool boxes are obvious things for this category
                )
);

$conf_sf_thematise = array(
    'sf_conf_id'=>'thematise',
    'sf_title'=>'thematise',
    'sf_html_id'=>'thematise',
    'view_state' => 'max',
    'edit_state' => 'view',
    'op_map'=>FALSE,
    'sf_nav_type' => 'none',
    'op_sf_cssclass' => 'mc_subform map_panelwrapper',
    'script' => 'php/map/subforms/sf_thematise.php',
    'fields' => array(
            $conf_field_locs,
        ),//fields are geometries. so any module vector layers could be added here
    );

$conf_map_layerswitcher =
    array(
            'sf_conf_id' => 'conf_map_layer_manager',      
            'view_state' => 'max',
            'edit_state' => 'view', 
            'sf_nav_type' => 'full',
            'sf_title' => 'layerswitcher', 
            'sf_html_id' => 'layerswitcher', // Must be unique
            'script' => 'php/map/subforms/sf_layermanager.php',
            'op_class' => 'panel',
            'op_overlay' => false,
            'op_sf_cssclass' => 'layerswitcher ',
            'fields' => array(
                $conf_field_locs,
            )
        );
        
        $conf_mapsf_admintools =
            array(
                'sf_html_id' => 'admintools',
                'view_state' => 'max',
                'edit_state' => 'view',
                'sf_title' => '',
                'sf_nav_type' => 'none',
                'script' => 'php/map/subforms/sf_toolbox.php',
                'op_switchmode' => 'edit',
                'fields' => array(
                    // fields are geometries. so any module vector layers could be added here
                    $conf_field_locs
                ),
                //admin tools wraps several other subform tools - like a frame.
                'subforms' => array(
                    $conf_map_layerswitcher,
                    $conf_sf_thematise
                    //$conf_map_edit
                 )
        );
$conf_map_home =
array (
                'sf_html_id' => 'map_view',
                'view_state' => 'max',
                'edit_state' => 'view',
                'sf_title' => '',
                'op_map' => '1',
                'sf_nav_type' => 'none',
                'script' => 'php/map/subforms/sf_ol3map.php',
                'fields' =>
                array (
                                // fields are geometries. so any module vector layers could be added here
                    $conf_field_locs,
                ),
                'subforms' =>
                array (
                    $conf_map_layerswitcher,
                    $conf_sf_thematise
                )
);

/*
  $wxs_qlayers:
  mapping layers for mods - specify in this array the names of the wms/wfs layers 
  that contain the spatial data for each mod. Bear in mind that these layers should
  contain an ark_id column that can be retrieved using a getFeatureInfo request.
  Each layer is a seperate entry in the array containing an array of variables
  'mod' - the mod of the item (without _cd) eg. 'cxt'
  'geom' - the geometry of the layer - eg. 'pt', 'pl' or 'pgn'
  'url' - the full url of the WMS/WFS server that is hosting the layer eg. http://localhost/ark/php/map/ark_wxs_server.php?
*/
$wxs_qlayers = 
    array(
        'cxt' => $conf_field_locs,
    );

/*
  $wxs_query_map - this is the name of a saved map (saved using the map_admin tools), 
  that you want to be the background for the 'View Results as Map'.
  ADMIN NOTE: the $wxs_qlayers array is used to determine which layers can be used to 
  display the spatial data for each mod - therefore those layers HAVE to be available in the saved 
  $wxs_query_map
*/

$wxs_query_map = '2';


?>
