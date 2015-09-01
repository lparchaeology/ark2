<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/mod_cxt_settings.php
*
* Settings file for the module cxt (context)
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
* @link       http://ark.lparchaeology.com/svn/config/ark_cxt/mod_cxt_settings.php
* @since      File available since Release 0.6
*/

/** TYPE DISPLAY BRACKETS
*
* This is specific to the context module and allows the display to be altered depending
* on the context type. It will put curly braces around fills, and brackets around cuts.
* The types refer to the ID entries in cxt_lut_cxttype.
*
*/

$conf_br = 
    array(
        'type_2_L' => '(',
        'type_2_R' => ')',
        'type_1_L' => '[',
        'type_1_R' => ']',
        'type_6_L' => '*',
        'type_6_R' => '*',
        'type_4_L' => '',
        'type_4_R' => ''
    );

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
        'sf_html_id' => 'cxt_itemvalconflict', // Must be unique
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
        'sf_html_id' => 'cxt_itemval', // Must be unique
        'script' => 'php/subforms/sf_itemval.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'conflict_res_sf' => 'conf_mcd_itemval_conflicts',
        'fields' =>
            array(
                $conf_field_cxt_cd
            ),
    );

// A subform which handles modtype conflict issues raised by $conf_mcd_abktype,
// used in when editing modtype
$conf_mcd_modtype_conflicts =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'cxttypeconflicts', 
        'sf_html_id' => 'cxt_modtypeconflict', // Must be unique
        'script' => 'php/subforms/sf_modtype_conflicts.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'fields' =>
            array(
                $conf_field_cxttype
            ),
    );

// A subform to make the module modtype editable
$conf_mcd_modtype =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'cxttype', 
        'sf_html_id' => 'cxt_modtype', // Must be unique
        'script' => 'php/subforms/sf_modtype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'conflict_res_sf' => 'conf_mcd_modtype_conflicts',
        'fields' =>
            array(
                $conf_field_cxttype
            ),
    );

/* TEXT SUBFORMS */

// Basic descriptive subforms
$conf_mcd_short_desc =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'desc', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_short_desc', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => 
            array(
                $conf_field_short_desc
            ),
    );

// Detailed description varies based on context type
$conf_mcd_description =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'desc', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_su_desc', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_modtype' => TRUE, // allows different fields to be displayed based on modtype
        'type1_fields' =>
            array(
                $conf_field_shape,
                $conf_field_corners,
                $conf_field_dims,
                $conf_field_bostop,
                $conf_field_sides,
                $conf_field_bosbase,
                $conf_field_base,
                $conf_field_orient,
                $conf_field_inclination,
                $conf_field_truncation,
                $conf_field_observ
            ),
        'type2_fields' =>
            array(
                $conf_field_compac,
                $conf_field_colour,
                $conf_field_compo,
                $conf_field_inclusions,
                $conf_field_dims,
                $conf_field_observ,
                $conf_field_excavtech
            ),
        'type3_fields' =>
            array(
                $conf_field_material,
                $conf_field_sizemat,
                $conf_field_finish,
                $conf_field_bond,
                $conf_field_form,
                $conf_field_dirface,
                $conf_field_bondmat,
                $conf_field_dims,
                $conf_field_observ
            ),
        'type4_fields' =>
            array(
                $conf_field_abody,
                $conf_field_ahead,
                $conf_field_ararm,
                $conf_field_alarm,
                $conf_field_arleg,
                $conf_field_alleg,
                $conf_field_afeet,
                $conf_field_degen,
                $conf_field_state,
                $conf_field_observ
            ),
        'type5_fields' => 
            array(
                $conf_field_type, 
                $conf_field_setting,
                $conf_field_orient,
                $conf_field_cross, 
                $conf_field_cond,
                $conf_field_dims,
                $conf_field_conv, 
                $conf_field_tmarks,
                $conf_field_jfit,
                $conf_field_imarks,
                $conf_field_streat,
                $conf_field_observ,
                $conf_field_excavtech
            ),
    );

$conf_mcd_reusetxt =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'full',
        'sf_title' => 'reusetxt', 
        'sf_html_id' => 'reusetxt', // Must be unique
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_emptyfielddisp' => TRUE, // displays the field even if it's not populated
        'fields' =>
            array(
                $conf_field_reusetxt
            ),
    );

/* INTERPRETATION */

// Requires a text, action, and date field all wrapped in sf_interp
$conf_mcd_interp =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'interp', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_interp', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_interp.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => 
            array(
                $conf_field_interp, 
                $conf_field_interpretedby,
                $conf_field_interpretedon
            ),
    );

/* ATTRIBUTES */

$conf_mcd_tmbrxsec =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'bark',
        'sf_html_id' => 'bark', // Must be unique
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => 
            array(
                $conf_field_tmbrxsec
            ),
    );

//Record complete flag
$conf_mcd_reccomplete =
    array(
        'view_state' => 'max',
        'edit_state' => 'edit',
        'sf_nav_type' => 'none',
        'sf_title' => 'blank', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_reccomplete', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_boolean.php',
        'op_label' => 'space',
        'op_input' => 'edt',
        'fields' =>
            array(
                $conf_field_reccomplete
            ),
    );

$conf_mcd_reuseattr =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'reuseattr',
        'sf_html_id' => 'reuseattr', // Must be unique
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => 
            array(
                $conf_field_reuseattr
            ),
    );

// Find types
$conf_mcd_findtypes =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'finds', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_findtypes', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_moddif' => TRUE,
        'fields' => 
            array(
                $conf_field_findtype
            ),
    );

// Basic interpretation and dating
$conf_mcd_basicinterp =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'basicinterp', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_basicinterp', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_moddif' => TRUE,
        'fields' => 
            array(
                $conf_field_cxtbasicinterp,
                $conf_field_provperiod
            ),
    );

// Spatial subform to display mapping data (local or otherwise)
$conf_mcd_spat = 
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'spat_data', 
        'sf_html_id' => 'cxt_spat_display',
        'sf_nav_type' => 'name',
        'script' => 'php/subforms/sf_wfs_spat.php',
        'query_layers' =>
            array(
            // You may want to comment out these lines to add your spatial data
            //     'cxt_schm' => array(
            //     'mod' => 'cxt',
            //     'geom' => 'pgn',
            //     'url' =>        'http://www.lparchaeology.com/prescot/ark/php/map/ark_wxs_server.php?'
            // ),
            // 'cxt_pl' => array(
            // 'mod' => 'cxt',
            // 'geom' => 'pl',
            // 'url' => 'http://www.lparchaeology.com/prescot/ark/php/map/ark_wxs_server.php?'
            // ),
            ),
        'background_map' => 'Results Map', // must an existing map set up using map admin page
        'op_buffer' => 0.5,
    );

/* EVENTS */

$conf_mcd_event =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'meta', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_events', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_event.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'events' => 
            array(
                $conf_event_issued,
                $conf_event_compiled,
                $conf_event_checked,
            ),
    );

/* SPANS */

// Stratigraphic relationships
$conf_mcd_matrix = 
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'matrix',
        'sf_nav_type' => 'nmedit',
        'sf_html_id' => 'cxt_matrix',
        'script' => 'php/subforms/sf_spanmatrix.php',
        'op_fancylabels' => 'off',
        'op_fancylabel_dir' => 'topdown',
        'op_label' => 'space',
        'op_input' => 'plus_sign',
        'op_spantype' => 'tvector',
        'fields' =>
            array(
            ),
    );

// Same as relationships
$conf_mcd_span_rels = 
   array(
       'view_state' => 'max',
       'edit_state' => 'view',
       'sf_title' => 'othermatrix',
       'sf_html_id' => 'cxt_other_matrix',
       'sf_nav_type' => 'nmedit',
       'script' => 'php/subforms/sf_span_rel.php',
       'op_label' => 'space',
       'op_input' => 'plus_sign',
       'op_condition' => // condition to check for sameas
           array(
               array(
                   'func'=> 'chkFragPresence',
                   'args'=> 'span,sameas'
               ),
           ),
       'fields' =>
           array(
               $conf_field_sameas
           ),
);

/* XMIs */

// Display site photo links
$conf_mcd_sphxmi =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', // not yet setup in sf
        'sf_title' => 'site_photo', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_sph_display', // the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'sf_nav_type' => 'nmedit',
        'xmi_mode' => 'live',
        'xmi_mod' => 'sph',
        'op_lightbox' => TRUE,
        'op_condition' =>
            array(
                array(
                    'func'=> 'chkFragPresence',
                    'args'=> 'xmi,sph'
                ),
            ),
        'fields' =>
            array(
                $conf_field_sphxmicxt
            ),
    );

// Display plan links
$conf_mcd_plnxmi =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_title' => 'plan', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_pln_display', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'sf_nav_type' => 'nmedit',
        'xmi_mode' => 'live',
        'xmi_mod' => 'pln',
        'op_lightbox' => TRUE,
        'op_condition' =>
            array(
                array(
                    'func'=> 'chkFragPresence',
                    'args'=> 'xmi,pln'
                ),
            ),
        'fields' =>
            array(
                $conf_field_plnxmicxt
            ),
);

// Display sample links
$conf_mcd_smp =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_title' => 'samples', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_smp_display', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'sf_nav_type' => 'nmedit',
        'xmi_mode' => 'live',
        'xmi_mod' => 'smp',
        'op_lightbox' => TRUE,
        'op_condition' =>
            array(
                array(
                    'func'=> 'chkFragPresence',
                    'args'=> 'xmi,smp'
                ),
            ),
        'fields' =>
            array(
                $conf_field_smpxmicxt
            ),
    );

// Display registered finds links
$conf_mcd_rgf =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_title' => 'objects', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_rgf_display', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'sf_nav_type' => 'nmedit',
        'xmi_mode' => 'live',
        'xmi_mod' => 'rgf',
        'op_condition' =>
            array(
                array(
                    'func'=> 'chkFragPresence',
                    'args'=> 'xmi,rgf'
                ),
            ),
        'fields' =>
            array(
                $conf_field_rgfxmicxt
            ),
    );

/* FRAMES */
// Frames hold multiple subforms of any type. Acts as a content wrapper.

// A frame to hold the both matrices, on stratigraphic and other same as.
$conf_mcd_matrixframe =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'matrix', 
        'sf_html_id' => 'cxt_matrixframe', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'subforms' => 
            array(
                $conf_mcd_matrix,
                $conf_mcd_span_rels
            ),
    );

// A frame to hold context type timber subforms, conditional to the modtype presence
$conf_mcd_timberframe =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'timber',
        'sf_html_id' => 'cxt_timberframe', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' =>
            array(
                array(
                    'func'=> 'chkModTypeCond',
                    'args'=> '5'
                ),
            ),
        'subforms' => 
            array(
                $conf_mcd_reuseattr,
                $conf_mcd_reusetxt,
                $conf_mcd_tmbrxsec
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
        'sf_html_id' => 'cxt_cd_register', //the form id tag (must be unique)
        'sf_nav_type' => 'none',
        'script' => 'php/subforms/sf_register_tbl.php',
        'op_label' => 'save',
        'op_input' => 'save',
        'op_no_rows' => 15, // relevant to tbl not sgl
        'op_sf_cssclass' => 'register',
        'fields' => 
            array(
                $conf_field_cxt_cd,
                $conf_field_cxttype,
                $conf_field_short_desc,
                $conf_field_issuedto,
                $conf_field_issuedon,
                $conf_reg_op
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
                $conf_mcd_description,
                $conf_mcd_timberframe,
                $conf_mcd_matrixframe,
                $conf_mcd_interp,
                $conf_mcd_basicinterp,
                $conf_mcd_findtypes,
                $conf_mcd_event
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
                $conf_mcd_interp,
                $conf_mcd_matrixframe,
                $conf_mcd_description,
                $conf_mcd_timberframe,
                $conf_mcd_findtypes,
                $conf_mcd_event
            ),
    );

$conf_mcd_col_2 =
    array(
        'col_id' => 'second_column',
        'col_alias' => FALSE,
        'col_type' => 'secondary_col',
        'subforms' => 
            array(
                $conf_mcd_short_desc,
                $conf_mcd_reccomplete,
                $conf_mcd_basicinterp,
                // You may want to remove this comment
                // $conf_mcd_spat,
                $conf_mcd_sphxmi,
                $conf_mcd_plnxmi,
                $conf_mcd_smp,
                $conf_mcd_rgf
            ),
    );

// Columns Package
$cxt_conf_mcd_cols =
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
                $conf_field_cxt_cd,
                $conf_field_cxttype,
                $conf_field_short_desc,
                $conf_field_issuedto,
                $conf_field_issuedon,
                $conf_reg_op_view
        )
);

// Text
$conf_mac_text =
    array(
        'fields' =>
            array(
                $conf_field_cxttype,
                $conf_field_short_desc,
                $conf_field_issuedto,
                $conf_field_issuedon,
                $conf_reg_op_view
        )
);    

// Thumbs
$conf_mac_thumb =
    array(
        'fields' =>
            array(
                $conf_field_cxt_cd,
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
        'sf_html_id' => 'mac_cxtuserconfigfields', // Must be unique
        'script' => 'php/data_view/subforms/sf_userconfigfields.php',
        'op_label' => 'space',
        'op_input' => 'go',
        'op_modtype' => FALSE,
        'fields' => // these are the fields available to the user - only fields with 'field_id' work
            array(
                $conf_field_cxt_cd,
                $conf_field_cxttype,
                $conf_field_short_desc,
                $conf_field_issuedto,
                $conf_field_issuedon,
                $conf_field_cxtbasicinterp,
                $conf_field_provperiod,
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

$cxt_xmiconf =
    array(
        'op_xmi_hdrbar' => 'link',
        'op_xmi_label' => TRUE,
        'fields' => 
            array(
                $conf_field_short_desc,
                $conf_field_issuedto,
                $conf_field_issuedon,
        )
);


?>
