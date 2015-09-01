<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/mod_admin_settings.php
*
* Settings file for the map_admin page
* stores all of the settings for the ARK instance of mapping_admin page
* there are inline comments and therefore most variables should
* be self evident
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
* @category   admin
* @package    ark
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/config/map_admin_settings.php
* @since      File available since Release 0.8
*/

/**  SUBFORMS
*
* describe the subforms and the vars they need to display properly
*
* 1 - set up any validation rules you need in the vd_settings file. Anything mod
*  specific ought to go in this settings file, example syntax is given below.
*
* 2 - set up any fields to put into the form. generally these ought to go into 
*  the field_settings file as this means they can be used by other modules. mod
*  specific fields may go into this file at the top in the 'fields' section.
*
* 3 - add in any custom validation
*
* 4 - set up the form using the standard subform format. The form is an array
*  containing variables that define the form an an array of fields
*
*
* VARIABLES FOR SUBFORMS:
* Mandatory:
* view_state = the default view state (min or max)
* edit_state = the default edit state (edit or entry or view)
* sf_nav_type = how to display the navigation in the subform (full, name or none) 
* sf_title = this is the nickname of markup to display in the title bar of the sf
* sf_html_id = the form id tag (must be unique)
* script = the script to use on this subform
*
* Optional:
* op_label = the label for the options row of the form (markup nname)
* op_input = the label to appear in the button (markup nname)
* op_register_mod = embedded registers need this
* op_subform_style = embedded registers need this set TRUE to display like an sf
* op_xmi_mod = the xmi viewer needs this to know which module to display
* op_modtype = TRUE = using different fields for each modtype, FALSE = using one fields list for all different modtypes. 
* op_lightbox = using lightbox in this subform (TRUE/FALSE)
* Spans: 
* op_fancylabels = fancy labels for a span or not (off or on)
* op_fancylabel_dir = direction of the span (topdown or centric)
* op_spantype = name of the spantype (table: cor_lut_spantype, field: spantype)

*
* Fields:
* The fields array is a collection of fields that display in the subform. 
* 'fields' => array($field1, $field2)
* If using modtypes for this module you can have one fields array for each modtype. 
* For 2 modtypes with different fields, enable op_modtype with TRUE:
* 'type1_fields' => array($field1, $field2),
* 'type2_fields' => array($field2, $field3)
* If using modtypes with one fields list disable or leave out op_modtype 
* and use the plain fields list.
*/

$map_config_defaults =
    array(
        'extent' => '-230499,1512,904356,1234385',
        'scales' => '1000,750,500,250,150,100,50,25,10,5',
        'projection' => array(
                'British National Grid' => 'EPSG:27700',
                'WGS Lat Long (EPSG:4326)' => 'EPSG:4326',
                'Google Mercator (EPSG:900913)' => 'EPSG:900913',
        )
    );

$conf_mcd_map_config =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'desc', 
        'sf_html_id' => 'map_config', // Must be unique
        'script' => 'php/map_admin/subforms/sf_map_config.php',
        'sf_nav_type' => 'name',
        'op_label' => 'space',
        'op_input' => 'go',
        'defaults' => $map_config_defaults,
        'fields' => array(       
        )       
);

$map_layers_defaults = array(
    '-------' => '',
    'fasti' => 'http://lpmapserver.dyndns.org/cgi-bin/mapserv?map=/home/www/mapserver/fasti/fasti.map&request=getcapabilities&service=wms',
    'DMS Solutions' => 'http://www2.dmsolutions.ca/cgi-bin/mswms_gmap?Service=WMS&VERSION=1.1.0',
);

$conf_mcd_map_layers =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'desc', 
        'sf_html_id' => 'map_layers', // Must be unique
        'script' => 'php/map_admin/subforms/sf_baselayer.php',
        'sf_nav_type' => 'name',
        'op_label' => 'space',
        'op_input' => 'go',
        'defaults' => $map_layers_defaults,     
        'fields' => array(       
        )       
);

$conf_mcd_map_wmc =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'desc', 
        'sf_html_id' => 'map_layers', // Must be unique
        'script' => 'php/map_admin/subforms/sf_savewmc.php',
        'sf_nav_type' => 'name',
        'op_label' => 'space',
        'op_input' => 'go',
        'fields' => array(       
        )       
);

// COLUMN PACK FOR DATA ENTRY
$conf_dat_detfrm =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' => array(
            $conf_mcd_map_config,
            $conf_mcd_map_layers,
            $conf_mcd_map_wmc,
        )
        
);



?>
