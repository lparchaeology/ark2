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
        'sgrp' => '1',
        'navname' => 'mapviewnav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'php/map_view/',
        'is_visible' => TRUE,
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

$conf_sf_legend = array(
            'sf_html_id'=>'map_legend',
            'view_state' => 'max',
            'edit_state' => 'view',
            'op_map'=>FALSE,
            'sf_nav_type' => 'none',
            'script' => 'php/map/subforms/sf_legend.php',
            'fields' => array(
                ),
        );

$conf_sf_mapslider = array(
            'sf_html_id'=>'map_slider',
            'view_state' => 'max',
            'edit_state' => 'view',
            'op_map'=>FALSE,
            'sf_nav_type' => 'none',
            'script' => 'php/map/subforms/sf_mapslider.php',
            'fields' => array(
                $conf_field_metsur_locs,
                ),//fields are geometries. so any module vector layers could be added here
        );

$conf_map_atlas =
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
                //$conf_field_metsur_locs,
            ),
        'subforms' =>
            array (
                $conf_sf_legend,
                $conf_sf_mapslider,
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
            $conf_field_metsur_locs,
        ),//fields are geometries. so any module vector layers could be added here
    );

$conf_mapsf_tools =
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
                //$conf_field_cxt_schm
            ),
            //admin tools wraps several other subform tools - like a frame.
            'subforms' => array(
                //$conf_map_layer_manager,
                //$conf_map_savemap,
                //$conf_map_choosemap,
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
                $conf_field_metsur_locs,
                $conf_field_metsur_kess,
                $conf_field_metsur_locs_line,
                $conf_field_metsur_locs_poly,
            ),
        'subforms' =>
            array (
                $conf_sf_thematise,
                //$conf_mapsf_tools,
                // maps can have subforms within them, so they come onto the max view
                // sliders and tool boxes are obvious things for this category
            )
);

$conf_map_newlayer =
array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'delete_record',
        'sf_html_id' => 'delete_record', // Must be unique
        'script' => 'php/map/subforms/sf_newlayer.php',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'conflict_res_sf' => 'conf_mcd_dnarecord',
        'fields' =>
        array(
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
    $wxs_qlayers = array(
        'loc_qlayer2' =>
            array(
                'field_id' => 'conf_field_metsur_locs',
                'id' => 'metsur_locs',
                'dataclass' => 'geom',
                'module' => 'loc',
                'type' => 'WFS',
                'url' => 'http://ica.tacc.utexas.edu/geoserver/MetSur/wfs?',
                'name' => 'MetSur:metsur_locs',
                'projection' => "EPSG:900913",
                'op_layer'=> 'MetSur:METSUR_loc_points_merged',
                'op_zoomtolayer' => TRUE,
                'op_serverType'=> 'geoserver',
                'op_query' => 'FALSE',
                'op_buffer' => '500',
                'selectable' =>TRUE,
        ),
        'loc_qlayer3' =>
            array(
                'field_id' => 'conf_field_metsur_locs_line',
                'id' => 'metsur_locs_line',
                'dataclass' => 'geom',
                'module' => 'loc',
                'type' => 'WFS',
                'url' => 'http://ica.tacc.utexas.edu/geoserver/MetSur/wfs?',
                'name' => 'MetSur:metsur_locs_line',
                'projection' => "EPSG:900913",
                'op_layer'=> 'MetSur:divlines_ap_dir',
                'op_zoomtolayer' => TRUE,
                'op_serverType'=> 'geoserver',
                'op_query' => 'FALSE',
                'op_buffer' => '50',
                'selectable' =>TRUE,
        ),
        'loc_qlayer4' =>
            array(
                'field_id' => 'conf_field_metsur_locs_poly',
                'id' => 'metsur_locs_poly',
                'dataclass' => 'geom',
                'module' => 'loc',
                'type' => 'WFS',
                'url' => 'http://ica.tacc.utexas.edu/geoserver/MetSur/wfs?',
                'name' => 'MetSur:metsur_locs_poly',
                'projection' => "EPSG:900913",
                'op_layer'=> 'MetSur:METSUR_loc_areas_merged',
                'op_zoomtolayer' => TRUE,
                'op_serverType'=> 'geoserver',
                'op_query' => 'FALSE',
                'op_buffer' => '50',
                'selectable' =>TRUE,
        ),
    );

    /*
      $wxs_query_map - this is the name of a saved map (saved using the map_admin tools), 
      that you want to be the background for the 'View Results as Map'.
      ADMIN NOTE: the $wxs_qlayers array is used to determine which layers can be used to 
      display the spatial data for each mod - therefore those layers HAVE to be available in the saved 
      $wxs_query_map
    */

    $wxs_query_map = 'ResultsMap';

//the more info button - if you store information about your GIS layers as ARK items then set this to true. 
//Please note you will need to have a 'gis' module and you will need to name your WMS-served GIS layers in the format -
//'contexts_PCO06_123';
$map_more_info_button = FALSE;

?>
