<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/mod_abk_settings.php
*
* Settings file for the module abk (address book)
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
* @link       http://ark.lparchaeology.com/svn/php/config/mod_abk_settings.php
* @since      File available since Release 0.6
*/
/** CUSTOM FIELDS
*
* most fields will be setup in fields_settings.php, however a couple are classed 
* as custon fields and are setup here.
* conf_field_itemkey is always setup for each module in the module setting
* conf_field_modtype may also be setup here if there is any modtypes for the module
* conf_field_modxmi - custom fields for xmi also should be in this settings file is present
*
* Note: custom validation
*
*  In order to add custom validation rules on a use per use basis of a field
*  the additional or custom rules may be inserted into the validation arrays for
*  each field using the following shorthand syntax. This must be done before
*  adding the field to the subform
*  $field['add_validation][] = $my_custom_rule;
*/
$conf_field_itemkey =
    array(
        'field_id' => 'conf_field_itemkey',
        'dataclass' => 'itemkey',
        'classtype' => 'abk_cd', 
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'abk_cd',
        'alias_type' => '1',
        'module' => 'abk',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

$conf_field_itemkey['add_validation'][] = $key_vd_modtype;
$conf_field_itemkey['edt_validation'][] = $key_vd_modtype;

$conf_field_abktype =
    array(
        'field_id' => 'conf_field_abktype',
        'dataclass' => 'modtype',
        'classtype' => 'abktype',
        'alias_tbl' => 'cor_tbl_col',
        'alias_col' => 'dbname',
        'alias_src_key' => 'abktype',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => 'none',
        'edt_validation' => 'none'
);   

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
* For 2 modtypes with differnt fields enable op_modtype with TRUE:
* 'type1_fields' => array($field1, $field2),
* 'type2_fields' => array($field2, $field3)
* If using modtypes with one fields list disable or leave out op_modtype 
* and use the plain fields list.
*/

$conf_mcd_abkdesc =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'desc', 
        'sf_html_id' => 'abk_abk_desc', // Must be unique
        'script' => 'php/subforms/sf_txt.php',
        'sf_nav_type' => 'name',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_name,
            $conf_field_initials,            
        )       
);

/** SPATIAL STUFF
*
* Subform: fields as above - extra spatial fields:
* wfs_layers = layers from the mapserver/mapfiles/ark_wfs.map to use in this subform
* wms_layers = layers from the mapserver/mapfiles/ark_wms.map to use in this subform
* The wms layers acts as the background while the wfs layers will zoon in on the relevant item.
* Optional: 
* op_buffer = the buffer in selected units around main item shape in subform
*
*/

// No spatial settings

/**  DATA ENTRY FORM
*
* A form used for entering further details on items already issued in this module.
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
* The register is essentially a subform contained with a column. In most uses 
* it is used as a standalone form. However it may be used in an embedded form
* within another module's pages. In this case, some additional custom validation
* is generally required
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
* Note: custom validation
*
*  In order to add custom validation rules on a use per use basis of a field
*  the additional or custom rules may be inserted into the validation arrays for
*  each field using the following shorthand syntax. This must be done before
*  adding the field to the suform
*  $field['add_validation][] = $my_custom_rule;
*
*  e.g. if you want to add in a required modtype for an itemkey you would set up
*  the field and then add in the $key_vd_modtype validation function to the field
*  using $conf_field_itemkey['add_validation'][] = $key_vd_modtype;
*
* VARIABLES FOR REGISTER SUBFORM
* Mandatory:
* view_state = the default view state (min or max)
* edit_state = the default edit state (edit or entry or view)
* sf_title = this is the nickname of markup to display in the title bar of the sf
* sf_html_id = the form id tag (must be unique)
* script = the script to use on this subform
*
* Optional:
* op_label = the label for the options row of the form (markup nname)
* op_input = the label to appear in the button (markup nname)
* op_reg_mod = register mode (tbl)
* op_no_rows = no. of rows in the register
*
* VARIABLES FOR REGISTER COLUMN
*
* col_id = only one column (main_column)
* col_alias = does column have an alias (FALSE/TRUE)
* col_type = type of column (register_col)
* subforms = subforms to add to colums, in this case only one (conf_register)
*
*/

// Subform Package
$conf_register =
    array(
        'view_state' => 'max',
        'edit_state' => 'edit',
        'sf_title' => 'register', 
        'sf_html_id' => 'abk_cd_register', // Must be unique
        'script' => 'php/data_entry/register.php',
        'op_label' => 'save',
        'op_input' => 'save',
        'op_reg_mode' => 'tbl',
        'op_no_rows' => 15,
        'fields' => 
            array(
                $conf_field_itemkey,
                $conf_field_abktype,
                $conf_field_name,
                $conf_field_initials,
                $conf_reg_op_no_enter
        )
);
    
// COLUMN WITH REGISTER SUBFORM
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
* The detfrm is a series of subforms contained within a column. 
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
* Note: custom validation
*
*  In order to add custom validation rules on a use per use basis of a field
*  the additional or custom rules may be inserted into the validation arrays for
*  each field using the following shorthand syntax. This must be done before
*  adding the field to the suform
*  $field['add_validation][] = $my_custom_rule;
*
* VARIABLES FOR DETFRM COLUMN
*
* col_id = only one column (main_column)
* col_alias = does column have an alias (FALSE/TRUE)
* col_type = type of column (single_col)
* subforms = subforms to add to colums
*
*/

// No data entry

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
*  the field_settings file as this means they can be used by other modules. mod
*  specific fields may go into this file at the top in the 'fields' section.
*
* 3 - add in any custom validation
*
* 4 - set up the form using the standard subform format. The form is an array
*  containing variables that define the form an an array of fields
*
* Note: custom validation
*
*  In order to add custom validation rules on a use per use basis of a field
*  the additional or custom rules may be inserted into the validation arrays for
*  each field using the following shorthand syntax. This must be done before
*  adding the field to the suform
*  $field['add_validation][] = $my_custom_rule;
*/

// No optional views in this settings file

/**  MICRO VIEW
*
* settings for the micro view page
*
* essentially the micro view page is used to display a single record. This page
* makes use of the subforms set up above and assembles them into columns
* according to the settings given in this section. First the subforms are
* packaged into columns and then these are packaged together ofr convenience
*
* 1 - make up columns
*
* 2 - package columns into an array
*
* 3 - set display options
*
* The microview setup often has more that one column.
*
* VARIABLES FOR MICROVIEW COLUMNS
*
* col_id = only one column (main_column, second_column)
* col_alias = does column have an alias (FALSE/TRUE)
* col_type = type of column (primary_col, secondary_col)
* subforms = subforms to add to colums
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
        'subforms' => array(
            $conf_mcd_abkdesc,
        )
);

// Columns Package
$abk_conf_mcd_cols =
    array(
        'op_display_type' => 'cols',
        'op_top_col' => 'main_column', 
        'columns' =>
            array(
                  $conf_mcd_col_1,
        )        
);

/**  DATA VIEW
*
* settings for the data view page
*
* the dataview page is used to display many records from different modules
* often simultaneously. This means that each mdule must know what to display
* in this context. The data view page can display in several formats:
*
* table - the data is expressed as a series of xhtml tables. Each module
*  needs to know what columns to display and how to make up the column headers
*  for each column (field)
*
* VARIABLES FOR SEARCH RESULTS SUBFORM
* fields = fields to go in the results array
*
* table - a table of search results
*
* text - extended text fields for search results
*
* thumb - thumbnails view, replaces thumb with icon for records without files
*
* map - this displays a map of the results with marker labels for each item
*
* chat - this is typically used to display a snippet of text from a freetext
*  type search. This means that the settings for this are minimal
*
*/

// Table
//  This is basically a subform package and follows the subform rules
$conf_mac_table =
    array(
        'fields' =>
            array(
                $conf_field_itemkey,
                $conf_field_name,
                $conf_field_initials,
                $conf_reg_op_view_only
        )
);

// Text
//  This is basically a subform package and follows the subform rules
$conf_mac_text =
    array(
        'fields' =>
            array(
                $conf_field_itemkey,
                $conf_field_name,
                $conf_field_initials,
                $conf_reg_op_view_only
        )
);

// Thumbs
//  This is basically a subform package and follows the subform rules
$conf_mac_thumb =
    array(
        'fields' =>
            array(
                $conf_field_itemkey,
        )
);

/** USER CUSTOMISED RESULTS FIELDS
*
* As of v0.8 the user can add fields to any of the views available on the data_view
* page. This is the sf_conf for the subform that is used to add/remove fields.
*
* The fields listed here are the fields that the admin wishes to make available to
* the user as options for adding to the view. Keeping the list short can help to
* make the user interface easier to understand.
*
* Fields in this list MUST have field_id set up (correctly)
*
*/
// Add fields to the current view subform
$conf_mac_userconfigfields =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'userconfigfields', 
        'sf_html_id' => 'mac_cxtuserconfigfields', // Must be unique
        'script' => 'php/data_view/subforms/sf_userconfigfields.php',
        'op_label' => 'space',
        'op_input' => 'go',
        'op_modtype' => FALSE,
        'fields' => // these are the fields available to the user - only fields with 'field_id' work
            array(
                $conf_field_itemkey,
                $conf_field_name,
                $conf_field_initials,
        ),
);

/** XMI VIEWER STUFF
* Any given item may be viewed in a reduced form from within another module
* this part of the settings file describes how this module represents itself
* when called into an XMI view
*
* VARIABLES FOR XMI SUBFORM
* Optional:
* op_xmi_hdrbar = how to display the header bar (link)
* op_xmi_label = label or not (TRUE/FALSE)
*
* Fields:
* fields as set up at the top of the settings file. Here we simply call them into
* the package
*/

$abk_xmiconf =
    array(
        'op_xmi_hdrbar' => 'link', // we put optional stuff in here 
        'op_xmi_label' => TRUE, // we put optional stuff in here           
        'fields' => 
            array(
            $conf_field_name,
            $conf_field_initials,
            )
        );

?>