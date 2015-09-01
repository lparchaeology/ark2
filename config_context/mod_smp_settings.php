<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/mod_smp_settings.php
*
* Settings file for the module smp (samples)
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
* @link       http://ark.lparchaeology.com/svn/config/ark_cxt/mod_smp_settings.php
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
        'sf_html_id' => 'smp_itemvalconflict', // Must be unique
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
        'sf_html_id' => 'smp_itemval', // Must be unique
        'script' => 'php/subforms/sf_itemval.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'conflict_res_sf' => 'conf_mcd_itemval_conflicts',
        'fields' =>
            array(
                $conf_field_smp_cd
        ),
);


/* TEXT SUBFORMS */

// Sample questions
$conf_mcd_samplequestions =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'samplequestions', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_questions', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => 
            array(
                $conf_field_position,
                $conf_field_samplequestions
        )
);

$conf_mcd_smp_short_desc =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'desc', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_short_desc', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' =>
            array(
                $conf_field_short_desc
        ),
);

$conf_mcd_description =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'smpdesc', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_desc', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_emptyfielddisp' => TRUE,
        'op_label' => 'space',
        'op_input' => 'save',
        'fields'   =>  
            array(
                $conf_field_position,
        ),
);

$conf_mcd_statusnotes =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'notes', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_statusnotes', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_emptyfielddisp' => TRUE,
        'fields' =>
            array(
                $conf_field_statusnotes,
                $conf_field_typenotes
        ),
);

$conf_mcd_othercoments =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'other', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_othercomments', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_emptyfielddisp' => TRUE,
        'fields' =>
            array(
                $conf_field_othercomments,
        ),
);

/* ATTRIBUTE SUBFORMS */

$conf_mcd_samplecondition =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'samplecondition', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_cond', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => 
            array(
                $conf_field_samplecondition,
                $conf_field_contamination,
                $conf_field_samplesize,
                $conf_field_subsamples,
            ),
    );

$conf_mcd_subsamples =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'subsamples_boolean', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_subsamples', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => 
            array(
                $conf_field_subsamples
            ),
    );

$conf_mcd_samplestatus =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'samplestatus', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_samplestatus', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' =>
            array(
                $conf_field_samplestatus,
                $conf_field_priority,
                $conf_field_sampletype
            ),
    );

$conf_mcd_hvyfracextrac =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'smp_hfextrac', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_hfextrac', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' =>
            array(
                $conf_field_hfextrac,
            ),
    );

$conf_mcd_hvyfracstatus =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'fractionstatus', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_hfstatus', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' =>
            array(
                $conf_field_hf_status,
            ),
    );

$conf_mcd_lghfracstatus =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'fractionstatus', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_lfstatus', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' =>
            array(
                $conf_field_lf_status,
            ),
    );

$conf_mcd_flotlocn =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'lightfractionlocn', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_lflocn', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' =>
            array(
                $conf_field_lflocn,
            ),
    );

$conf_mcd_flotrec =
    array(
        'view_state' => 'max',
        'edit_state' => 'edit',
        'sf_nav_type' => 'none',
        'sf_title' => 'blank', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_lgh_fr_rec', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_boolean.php',
        'op_label' => 'link',
        'op_input' => 'add',
        'fields' =>
            array(
                $conf_field_flotrec
            ),
    );

$conf_mcd_hvyfracass =
    array(
        'view_state' => 'max',
        'edit_state' => 'edit',
        'sf_nav_type' => 'none',
        'sf_title' => 'blank', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_hvy_fr_ass', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_boolean.php',
        'op_label' => 'link',
        'op_input' => 'add',
        'fields' =>
            array(
                $conf_field_hfass
        ),
);

/* NUMBER SUBFORMS */

$conf_mcd_volume =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'volume', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_volume', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_number.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => 
            array(
                $conf_field_volume
            )
    );

$conf_mcd_hvynumberofbags =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'numofbags', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_numofbags', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_number.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' =>
            array(
                $conf_field_hf_numofbags,
            ),
    );

$conf_mcd_lghnumberofbags =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'numofbags', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_numofbags', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_number.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' =>
            array(
                $conf_field_lf_numofbags
            ),
    );

/* XMI SUBFORMS */

$conf_mcd_xmicxt =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'cxts', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_xmi_cxts', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'xmi_mod' => 'cxt',
        'xmi_mode' => 'live',
        'op_label' => 'link',
        'op_input' => 'add',
        'fields' => 
            array(
                $conf_field_cxtxmismp
            ),
    );

	$conf_mcd_share =
	array(
	        'view_state' => 'max',
	        'edit_state' => 'view',
	        'sf_nav_type' => 'name',
	        'sf_title' => 'share', //appears in the titlebar of the subform (mk nname)
	        'sf_html_id' => 'share_buttons', //the form id tag (must be unique)
	        'script' => 'php/subforms/sf_socialshare.php',
	        'fields' =>
	        array(
	        ),
	);

/* EVENT SUBFORMS */

$conf_mcd_event =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'meta', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_events', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_event.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'events' => 
            array(
                $conf_event_taken,
                $conf_event_checked,
        ),
);

/* FRAME SUBFORMS */
// Frames hold multiple subforms of any type. Acts as a content wrapper.

$conf_mcd_descfrm =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'desc', 
        'sf_html_id' => 'desc_frame', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'subforms' =>
            array(
                $conf_mcd_samplequestions,
                $conf_mcd_samplecondition,
        ),
);

$conf_mcd_hvyfracfrm =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'hvyfrac', 
        'sf_html_id' => 'hvy_fracfrm', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'subforms' =>
            array(
                $conf_mcd_hvyfracass,
                $conf_mcd_hvyfracstatus,
                $conf_mcd_hvyfracextrac,
                $conf_mcd_hvynumberofbags,
            ),
    );

$conf_mcd_lghfracfrm =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'lghfrac', 
        'sf_html_id' => 'lgh_fracfrm', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'subforms' =>
            array(
                $conf_mcd_flotrec,
                $conf_mcd_lghfracstatus,
                $conf_mcd_lghnumberofbags,
                $conf_mcd_flotlocn,
            ),
    );

$conf_mcd_statusframe =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'samplestatus', 
        'sf_html_id' => 'status_frame', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
		'op_sf_cssclass' => 'officeuse mc_subform',
        'subforms' =>
            array(
                $conf_mcd_samplestatus,
                $conf_mcd_statusnotes,
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
        'sf_title' => 'register', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'smp_cd_register', //the form id tag (must be unique)
        'sf_nav_type' => 'none',
        'script' => 'php/subforms/sf_register_tbl.php',
        'op_label' => 'save',
        'op_input' => 'save',
        'op_no_rows' => 15, // relevant to tbl not sgl
        'op_sf_cssclass' => 'register',
        'fields' => 
            array(
                $conf_field_smp_cd,
                $conf_field_short_desc,
                $conf_field_cxtxmismp,
                $conf_field_takenby,
                $conf_field_takenon,
		$conf_reg_op,
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
            ),
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

$conf_dat_detfrm =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' => 
            array(
                $conf_mcd_xmicxt,
                $conf_mcd_descfrm,
				$conf_mcd_othercoments,
                $conf_mcd_volume,
                $conf_mcd_event,
                $conf_mcd_statusframe,
                //$conf_mcd_lghfracfrm,
                //$conf_mcd_hvyfracfrm,
            ),
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

$conf_mcd_col_1 =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' => 
            array(
                $conf_mcd_descfrm,
                $conf_mcd_xmicxt,
                $conf_mcd_volume,
                $conf_mcd_lghfracfrm,
                $conf_mcd_hvyfracfrm,
                $conf_mcd_event,
            ),
    );

$conf_mcd_col_2 =
    array(
        'col_id' => 'second_column',
        'col_alias' => FALSE,
        'col_type' => 'secondary_col',
        'subforms' =>
            array(
                // $conf_mcd_share,
                $conf_mcd_smp_short_desc,
                $conf_mcd_statusframe,
            ),
    );

// Columns Package
$smp_conf_mcd_cols =
    array(
        'op_display_type' => 'cols',
        'op_top_col' => 'main_column', // string to match the 'col_id'
        'columns' =>
            array(
                $conf_mcd_col_1,
                $conf_mcd_col_2
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
                $conf_field_smp_cd,
                $conf_field_short_desc,
                $conf_field_cxtxmismp,
                $conf_field_takenby,
                $conf_field_takenon,
               // $conf_reg_op_view
            ),
    );

// Text
$conf_mac_text =
    array(
        'fields' =>
            array(
                $conf_field_short_desc,
                $conf_field_takenby,
                $conf_field_takenon,
                //$conf_reg_op_view
            ),
    );
    
// Thumbs
$conf_mac_thumb =
    array(
        'fields' =>
            array(
                $conf_field_smp_cd,
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
        'sf_html_id' => 'mac_smpuserconf', // Must be unique
        'script' => 'php/data_view/subforms/sf_userconfigfields.php',
        'op_label' => 'space',
        'op_input' => 'go',
        'op_modtype' => FALSE,
        'fields' => // these are the fields available to the user - only fields with 'field_id' work
            array(
                $conf_field_smp_cd,
                $conf_field_position,
                $conf_field_samplequestions,
                $conf_field_short_desc,
                $conf_field_position,
                $conf_field_statusnotes,
                $conf_field_typenotes,
                $conf_field_othercomments,
                $conf_field_samplecondition,
                $conf_field_contamination,
                $conf_field_samplesize,
                $conf_field_subsamples,
                $conf_field_subsamples,
                $conf_field_samplestatus,
                $conf_field_priority,
                $conf_field_sampletype,
                $conf_field_hfextrac,
                $conf_field_hf_status,
                $conf_field_lf_status,
                $conf_field_lflocn,
                $conf_field_flotrec,
                $conf_field_hfass,
                $conf_field_volume,
                $conf_field_hf_numofbags,
                $conf_field_lf_numofbags,
                $conf_field_cxtxmismp,
                $conf_field_takenby,
                $conf_field_takenon,
            ),
    );

/** XMI VIEWER STUFF
* Any given item may be viewed in a reduced form within another module -
* this part of the settings file describes how this module represents itself
* when called into an XMI view from another module
*
* VARIABLES FOR XMI SUBFORM
* Optional:
* op_xmi_hdrbar = how to display the header bar (link, name, full)
* op_xmi_label = record label or not (TRUE/FALSE)
*
* Fields:
* fields as set up in the field_settings file. Here we simply call them into
* the package
*/

$smp_xmiconf =
    array(
        'op_xmi_hdrbar' => 'link',
        'op_xmi_label' => TRUE,
        'fields' => 
            array(
                $conf_field_short_desc,
                $conf_field_cxtxmismp,
                $conf_field_takenby,
                $conf_field_takenon,
            ),
    );


?>