<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/mod_sec_settings.php
*
* Settings file for the module pln (plan)
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
* @copyright  1999-2012 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/config/ark_cxt/mod_pln_settings.php
* @since      File available since Release 0.6
*/

/* REQUIRED SUBFORMS */

// A subform that handles itemval conflicts raised by $conf_mcd_itemval
$conf_mcd_itemval_conflicts =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'dnarecord', 
        'sf_html_id' => 'pln_itemvalconflict', // Must be unique
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
        'sf_html_id' => 'pln_itemval', // Must be unique
        'script' => 'php/subforms/sf_itemval.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'conflict_res_sf' => 'conf_mcd_itemval_conflicts',
        'fields' =>
            array(
                $conf_field_sec_cd
        ),
    );

/* TEXT SUBFORMS */

$conf_mcd_secdesc =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'desc', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sec_desc', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'sf_nav_type' => 'nmedit',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => 
            array(
                $conf_field_short_desc,
                $conf_field_seclevel
        ),
);

/* ATTRIBUTE SUBFORMS */

$conf_mcd_details =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'secattributes',
        'sf_html_id' => 'secattributes', // Must be unique
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_sf_cssclass' => 'mc_subform attribute',
        'fields' => 
            array(
                $conf_field_locn,
                $conf_field_scale,
        ),
);
/* EVENTS */
$conf_mcd_secmeta =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'meta', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sec_meta', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_event.php',
        'sf_nav_type' => 'nmedit',
        'op_label' => 'space',
        'op_input' => 'save',
        'events' => 
            array(
                $conf_event_drawn
        ),
);

/* XMIs */
$conf_mcd_xmicxt =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_title' => 'cxts', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sec_cxt_display', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'sf_nav_type' => 'nmedit',
        'xmi_mode' => 'auto',
        'xmi_mod' => 'cxt',
        'op_xmi_sorting' => 'natural',
        'fields' =>
            array(
                $conf_field_cxtxmisec
        ),
);
$conf_mcd_xmipln =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_title' => 'secplns', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sec_plan_link', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'sf_nav_type' => 'nmedit',
        'xmi_mode' => 'auto',
        'xmi_mod' => 'pln',
        'fields' =>
            array(
                $conf_field_secxmipln
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

/**  REGISTER
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
        'sf_html_id' => 'sec_cd_register', // Must be unique
        'sf_nav_type' => 'none',
        'script' => 'php/subforms/sf_register_tablet.php',
        'op_label' => 'save',
        'op_input' => 'save',
        'op_reg_mode' => 'tbl',
        'op_sf_cssclass' => 'register', // Applies custom CSS class so it is displayed differently than other subforms
        'fields' =>
            array(
                $conf_field_sec_cd,
                $conf_field_short_desc,
                $conf_field_locn,
                $conf_field_scale,
                $conf_field_cxtxmisec,
                $conf_field_secxmipln,
                $conf_field_drawnby,
                $conf_field_drawnon,
        ),
);

// The column holding the register subform
$conf_dat_regist =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'register_col',
        'subforms' =>
            array(
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

// No optional views in this settings file

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

$conf_dat_detfrm =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' =>
            array(
                $conf_mcd_secdesc,
                $conf_mcd_details,
                $conf_mcd_secmeta,
                $conf_mcd_xmicxt,
                $conf_mcd_xmipln
            ),
);

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
                $conf_mcd_secdesc,
                $conf_mcd_details,
                $conf_mcd_xmicxt,
                $conf_mcd_secmeta
        ),
);

$conf_mcd_col_2 =
    array(
        'col_id' => 'second_column',
        'col_alias' => FALSE,
        'col_type' => 'secondary_col',
        'subforms' => 
            array(
                $conf_mcd_xmipln
        ),
);


// Columns Package
$sec_conf_mcd_cols =
    array(
        'op_display_type' => 'cols',
        'op_top_col' => 'main_column', // string to match the 'col_id'
        'columns' =>
            array(
                  $conf_mcd_col_1,
                  $conf_mcd_col_2
        )
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
* chat - this is typically used to display a snippet of text from a freetext
*  type search. This means that the settings for this are minimal
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
                $conf_field_sec_cd,
                $conf_field_short_desc,
                $conf_field_cxtxmisec,
                $conf_field_drawnby,
                $conf_field_drawnon,
                //$conf_reg_op_view
        ),
);

$conf_mac_text =
    array(
        'fields' =>
            array(
                $conf_field_sec_cd,
                $conf_field_short_desc,
                $conf_field_cxtxmisec,
                $conf_field_drawnby,
                $conf_field_drawnon,
                //$conf_reg_op_view
        ),
);
// Table
$conf_mac_table =
    array(
        'fields' =>
            array(
                $conf_field_sec_cd,
                $conf_field_short_desc,
                $conf_field_cxtxmisec,
                $conf_field_drawnby,
                $conf_field_drawnon,
                //$conf_reg_op_view
        ),
);

// Thumbs
$conf_mac_thumb =
    array(
        'fields' =>
            array(
                $conf_field_pln_cd,
        )
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
        'sf_html_id' => 'mac_pln_userconf', // Must be unique
        'script' => 'php/data_view/subforms/sf_userconfigfields.php',
        'op_label' => 'space',
        'op_input' => 'go',
        'op_modtype' => FALSE,
        'fields' => // these are the fields available to the user - only fields with 'field_id' work
            array(
                $conf_field_sec_cd,
                $conf_field_short_desc,
                $conf_field_seclevel,
                $conf_field_cxtxmisec,
                $conf_field_secxmipln,
                $conf_field_sec_cd,
                $conf_field_short_desc,
                $conf_field_locn,
                $conf_field_scale,
                $conf_field_drawnby,
                $conf_field_drawnon,
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

$pln_xmiconf =
    array(
        'op_xmi_hdrbar' => 'link',
        'op_xmi_label' => TRUE,
        'fields' => 
            array(
                $conf_field_short_desc,
                $conf_field_drawnby,
                $conf_field_drawnon
        )
);


?>