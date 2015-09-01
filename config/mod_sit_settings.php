<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/mod_sit_settings.php
*
* Settings file for the module sit (sites)
* This settings file is used on a per module basis and there should be one copy
* per module (named mod_MOD_settings.php)
* stores all of the module settings for the ARK instance
* there are inline comments and therefore most variables should
* be self evident
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
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Jessica Ogden <j.ogden@lparchaeology.com>
* @copyright  1999-2012 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @since      File available since Release 0.6
*/


/**  SUBFORMS
*
* describe the subforms and the vars they need to display properly
*
* 1 - set up any validation rules you need in the vd_settings file
*
* 2 - set up any fields to put into the form. generally these go into 
*  the field_settings file as this means they can be used by other modules
*
* 3 - add in any custom validation
*
* 4 - set up the form using the standard subform format. The form is an array
*  containing variables that define the form using an array of fields
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
* op_label = the label for the options row of the form usually 'save' or 'space' (markup nname)
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

/* REQUIRED SUBFORMS */

// A subform that handles itemval conflicts raised by $conf_mcd_itemval
$conf_mcd_itemval_conflicts =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'dnarecord', 
        'sf_html_id' => 'sit_itemvalconflict', // Must be unique
        'script' => 'php/subforms/sf_dnarecord.php',
        'op_recursive' => FALSE,
        'fields' =>
            array(
            ),
    );

// A subform that makes the itemvalue editable
$conf_mcd_itemval =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'itemval', 
        'sf_html_id' => 'sit_itemval', // Must be unique
        'script' => 'php/subforms/sf_itemval.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'conflict_res_sf' => 'conf_mcd_itemval_conflicts',
        'fields' =>
            array(
                $conf_field_sit_cd
            ),
    );


/* TEXT SUBFORMS */

// A text subform for the Site area
    $conf_mcd_site_area =
        array(
            'view_state' => 'max',
            'edit_state' => 'view',
            'sf_title' => 'area', 
            'sf_html_id' => 'sit_area', // Must be unique
            'script' => 'php/subforms/sf_txt.php',
            'sf_nav_type' => 'name',
            'op_label' => 'space',
            'op_input' => 'save',
            'fields' => 
                array(
                    $conf_field_area,
                ),
        );

// A text subform for the Site toponym
    $conf_mcd_site_toponym =
        array(
            'view_state' => 'max',
            'edit_state' => 'view',
            'sf_title' => 'area', 
            'sf_html_id' => 'sit_area', // Must be unique
            'script' => 'php/subforms/sf_txt.php',
            'sf_nav_type' => 'name',
            'op_label' => 'space',
            'op_input' => 'save',
            'fields' => 
                array(
                    $conf_field_toponym,
                ),
        );


/* ATTR SUBFORMS */

$conf_mcd_site_detail =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'full',
        'sf_title' => 'site_detail',
        'sf_html_id' => 'site_detail', // Must be unique
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_visit_year,
            $conf_field_geomorph,
            $conf_field_transect,
            $conf_field_landuse,
        )
);


/* DATES SUBFORM */

// A span subform, for the site date ranges
$conf_mcd_site_dates = 
        array(
            'view_state' => 'max',
            'edit_state' => 'view',
            'sf_nav_type' => 'name',
            'sf_title' => 'chrono', //appears in the titlebar of the subform (mk nname)
            'sf_html_id' => 'sit_cd_chronology', //the form id tag (must be unique)
            'script' => 'php/subforms/sf_chronology.php',
            'sf_op_showranges' => TRUE,
            'sf_op_showtl' => TRUE,
            'op_tl_width' => '675',
            'op_label' => 'save',
            'op_input' => 'save',
            'fields' =>
                array(
                    $conf_field_site_dates
                
            )
    );

/* ASSEMBLAGE SUBFORMS */

$conf_mcd_chrono_function =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'chrono-function', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'chrono-function', //the form id tag (must be unique)
        'sf_nav_type' => 'nmedit',
        'script' => 'php/subforms/sf_chaintable.php',
        'op_assemblage_type' =>  $conf_field_chrono,// the field of data attached to the item
        // 'op_chart' => 'yes',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_chrono,
            $conf_field_site_function,
        ),
);

$conf_mcd_assemblage =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'assemblage', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'pottery_ass', //the form id tag (must be unique)
        'sf_nav_type' => 'nmedit',
        'script' => 'php/subforms/sf_chaintable.php',
        'op_assemblage_type' =>  $conf_field_total,// the field of data attached to the item
        // 'op_chart' => 'yes',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_sherd_class,
            $conf_field_sherd_type,
            $conf_field_sherd_form,
            $conf_field_find_dates,
            $conf_field_sherdfunction,
            $conf_field_catxmisit,
            $conf_field_total,
        ),
);

$conf_mcd_sub_totals =
        array(
            'view_state' => 'max',
            'edit_state' => 'view',
            'sf_title' => 'sub_totals', //appears in the titlebar of the subform (mk nname)
            'sf_html_id' => 'sub_totals', //the form id tag (must be unique)
            'sf_nav_type' => 'none',
            'script' => 'php/subforms/sf_assemblage.php',
            'op_assemblage_type' => 'total',
            'op_chaintype' => 'num_to_att',
            'op_default_type_display' => array(  //this is the default attribute breakdown to display
                                            3,
                                            4,
                                          ),
           // 'op_chart' => 'yes',
            'op_label' => 'space',
            'op_input' => 'save',
            'fields' => array(
                 $conf_field_total             
            ),
    );

/* NUMBER SUBFORM */

$conf_mcd_elevation =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'full',
        'sf_title' => 'elevation', 
        'sf_html_id' => 'site_elevation', // Must be unique
        'script' => 'php/subforms/sf_number.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_elevation
        )
);
 
 
/* SITE DETAIL SUBFORM */

$conf_mcd_site_detail_frame =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'site_detail_frame', 
        'sf_html_id' => 'site_detail_frame', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
            array(
                'func'=> 'chkGroupPerm',
                'args'=> array(
                    2
                )
            ),
        ),
        'subforms' => array(
            $conf_mcd_site_toponym,
            $conf_mcd_site_detail,
            $conf_mcd_site_area,
            $conf_mcd_elevation,
         )
    );

$conf_mcd_ceramic_frame =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'ceramic_ass_frame', 
        'sf_html_id' => 'ceramic_ass_frame', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
    'op_condition' => array(
        array(
            'func'=> 'chkGroupPerm',
            'args'=> array(
                2
            )
        ),
    ),
        'subforms' => array(
            $conf_mcd_assemblage,
            $conf_mcd_sub_totals,
         )
    );
    
// XMI SUBFORMS

$conf_mcd_phoxmi =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_title' => 'site_photo', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sit_pho_display', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'sf_nav_type' => 'nmedit',
        'xmi_mod' => 'pho',
        'xmi_mode' => 'live',
        'op_lightbox' => TRUE,
        'fields' => array(
            $conf_field_phoxmisit,
        ),
	);

/**  DATA ENTRY FORMS
*
* Used for entering further details on items already issued in this module.
*
* The data entry form needs a different package for each of its different views.
* The data entry area has two fixed views, with an option for additional views.
*     -Registers
*     -Detfrm (for detailed record entry)
*     -Optional (eg. Materials Inventory)
* Each of these three things is essentially many subforms contained within a single
* column.
*/

/**  REGIsteR
*
* A form used for issuing new items to this module
*
* As of v1.1 the register is now a standard subform with standard conf
*
*/

// Register Subform Conf
$conf_register =
    array(
        'view_state' => 'max',
        'edit_state' => 'edit',
        'sf_title' => 'register', 
        'sf_html_id' => 'sit_cd_register', // Must be unique
        'sf_nav_type' => 'none',
        'script' => 'php/subforms/sf_register_tbl.php',
        'op_label' => 'save',
        'op_input' => 'save',
        'op_reg_mode' => 'tbl',
        'op_sf_cssclass' => 'register', // Applies custom CSS class so it is displayed differently than other subforms
        'fields' =>
            array(
                $conf_field_sit_cd,
                $conf_reg_op_no_enter
            ),
);
    
// The column holding the register subform
$conf_dat_regist =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'register_col',
        'subforms' => array(
            $conf_register
        )
);

/**  DETFRM 
*
* A form used for rapid data entry of a single record.
*
* The detfrm is a series of subforms contained within a single column.
*
* 1 - set up any validation rules you need in the vd_settings file.
*
* 2 - set up any fields to put into the form. generally these ought to go into 
*  the field_settings file as this means they can be used by other modules.
*
* 3 - add in any custom validation
*
* 4 - set up the form using the standard subform format. The form is an array
*  containing variables that define the form with an array of fields
*
* Note: custom validation
*
*  In order to add custom validation rules on a case-by-case use of a specific field
*  the additional or custom rules may be inserted into the validation arrays for
*  each field using the following shorthand syntax. This must be done before
*  adding the field to the subform
*  $field['add_validation][] = $my_custom_rule;
*
* VARIABLES FOR DETFRM COLUMN
*
* col_id = only one column (main_column)
* col_alias = does column have an alias (FALSE/TRUE)
* col_type = type of column (single_col)
* subforms = subforms to add to columns
*
*/

// COLUMN PACK FOR DATA ENTRY
$conf_dat_detfrm =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' =>
            array( 
                // $conf_mcd_site_desc,
                $conf_mcd_site_detail_frame,
                $conf_mcd_chrono_function,
                $conf_mcd_phoxmi,
                // $conf_mcd_ceramic_frame,
            )
);

/**  OPTIONAL VIEWS
*
* Optional views, like the two previous, are displayed in a single column for
* rapid data entry.  Different optional views can be defined by the administrator.
*
* Additional custom validation is generally required for custom views.
*
* 1 - set up any validation rules you need in the vd_settings file. Anything mod
*  specific ought to go in this settings file, example syntax is given below.
*
* 2 - set up any fields to put into the form. generally these ought to go into 
*  the field_settings file as this means they can be used by other modules.
*
* 3 - add in any custom validation
*
* 4 - set up the form using the standard subform format. The form is an array
*  containing variables that define the form with an array of fields
*
* Note: custom validation
*
*  In order to add custom validation rules on a case-by-case use of a specific field
*  the additional or custom rules may be inserted into the validation arrays for
*  each field using the following shorthand syntax. This must be done before
*  adding the field to the subform
*  $field['add_validation][] = $my_custom_rule;
*/

// No optional views in this settings file

/**  MICRO VIEW (RECORD VIEW)
*
* settings for the micro view page
*
* essentially the micro view page is used to display all data associated with a single record. 
* This page makes use of the subforms set up above and assembles them into columns
* according to the settings given in this section. First the subforms are
* packaged into columns and then these are packaged together on the page
*
* 1 - make up columns
*
* 2 - package columns into an array
*
* 3 - set display options
*
* The micro view setup can have more than one column.
*
* VARIABLES FOR MICRO VIEW COLUMNS
*
* col_id = only one column (main_column, second_column)
* col_alias = does column have an alias (FALSE/TRUE)
* col_type = type of column (primary_col, secondary_col)
* subforms = subforms to add to columns
*
*
* VARIABLES FOR COLUMNS PACKAGE
*
* op_display_type = how to display the columns (cols)
* op_top_col = which column is first (main_column)
* columns = array with columns in the order they appear
*/ 

// Columns setup
$conf_mcd_col_1 =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' => 
            array(
                $conf_mcd_site_detail_frame,
                $conf_mcd_chrono_function,
                $conf_mcd_ceramic_frame,
                $conf_mcd_phoxmi,
            ),
);

// Columns Package
$sit_conf_mcd_cols =
    array(
        'op_display_type' => 'cols',
        'op_top_col' => 'main_column', 
        'columns' =>
            array(
                  $conf_mcd_col_1,
            ),
);

/**  DATA VIEW (SEARCH)
*
* settings for the data view page
*
* the data view page is used to display many records from different modules
* often simultaneously. This means that each module must know what to display
* in this context. The data view page can display in several formats:
*
* table - a table of search results
*
* text - extended text fields for search results
*
* thumb - thumbnails view, replaces thumb with icon for records without files
*
* map - this displays a map of the results with marker labels for each item (must be using mapping capabilities)
*
*
* VARIABLES FOR SEARCH RESULTS SUBFORM
* fields = fields to go in the results array
*
*/

// These are all basically subforms and follow the usual subform rules

// Table
$conf_mac_table =
    array(
        'fields' =>
            array(
                $conf_field_sit_cd,
                $conf_field_transect,
                $conf_reg_op_view
            ),
    );

// Text
$conf_mac_text =
    array(
        'fields' =>
            array(
                $conf_reg_op_view
            ),
    );

// Thumbs
$conf_mac_thumb =
    array(
        'fields' =>
            array(
                $conf_field_sit_cd,
            ),
    );

/** USER CUSTOMISED RESULTS FIELDS
*
* As of v0.8 the user can add fields to any of the views available on the data view
* page. This is the sf_conf for the subform that is used to add/remove fields.
*
* The fields listed here are the fields that the admin wishes to make available to
* the user as options for adding to the view. Keeping the list short can help to
* make the user interface easier to understand.
*
* Fields in this list MUST have field_id set up (correctly) in field_settings
*
*/

// Add fields to the current view subform
$conf_mac_userconfigfields =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'userconfigfields', 
        'sf_html_id' => 'mac_sit_userconf', // Must be unique
        'script' => 'php/data_view/subforms/sf_userconfigfields.php',
        'op_label' => 'space',
        'op_input' => 'go',
        'op_modtype' => FALSE,
        'fields' => // these are the fields available to the user - only fields with 'field_id' correctly set work
            array(
                $conf_field_sit_cd
        ),
);

/** XMI VIEWER STUFF
* Any given item may be viewed in a reduced form within another module -
* this part of the settings file describes how this module represents itself
* when called into an XMI view from another module
*
* VARIABLES FOR XMI SUBFORM
* Optional:
* op_xmi_hdrbar = how to display the header bar (link, name)
* op_xmi_label = record label or not (TRUE/FALSE)
*
* Fields:
* fields as set up in the field_settings file. Here we simply call them into
* the package
*/

$sit_xmiconf =
    array(
        'op_xmi_hdrbar' => 'link',
        'op_xmi_label' => TRUE,
        'fields' => 
            array(
                $conf_field_chrono,
            )
        );


?>
