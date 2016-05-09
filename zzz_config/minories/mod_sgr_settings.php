<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* mod_sgr_settings.php
*
* stores all of the module settings for the ARK instance
* there are inline comments and therefore most variables should
* be self evident
* This settings file is used on a per module basis and there should be one copy
* per module (named mod_MOD_settings.php)
*
* PHP versions 4 and 5
*
* LICENSE: INSERT ARK LICENCE HERE
*
* @category   base
* @package    ark
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2007 L - P : Partnership Ltd.
* @license    http://www.lparchaeology.com/license
* @version    CVS: $Id:$
* @link       http://www.lparchaeology.com/LINK TO HELP FILE
* @since      File available since Release 0.1
*/




// DATA ENTRY STUFF

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
* Note: custom validation
*
*  In order to add custom validation rules on a use per use basis of a field
*  the additional or custom rules may be inserted into the validation arrays for
*  each field using the following shorthand syntax. This must be done before
*  adding the field to the suform
*  $field['add_validation][] = $my_custom_rule;
*
* view_state = the default view state (min or max)
* edit_state = the default edit state (edit or entry or view)
* sf_title = this is the nickname of markup to display in the title bar of the sf
* sf_html_id = this is the tag to apply to the <form> element of the subform
* script = the script to use on this subform
*
* Options:
* op_label = the label for the options row of the form (markup nname)
* op_input = the label to appear in the button (markup nname)
* op_register_mod = embedded registers need this
* op_subform_style = embedded registers need this set true to display like an sf
* op_xmi_mod = the xmi viewer needs this to know which module to display
* sf_op_attributetype = attribute displaying forms may use this
*/

$conf_mcd_itemval_conflicts =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'dnarecord', 
        'sf_html_id' => 'sgr_itemvalconflict', // Must be unique
        'script' => 'php/subforms/sf_dnarecord.php',
        'op_recursive' => FALSE,
        'fields' =>
            array(          
        )
);        
$conf_mcd_itemval =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'itemval', 
        'sf_html_id' => 'sgr_itemval', // Must be unique
        'script' => 'php/subforms/sf_itemval.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'conflict_res_sf' => 'conf_mcd_itemval_conflicts',
        'fields' =>
            array(
                $conf_field_rgf_cd
        )
);


$conf_mcd_description =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'sgr_reg_desc', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sgr_su_description', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_short_desc
        )
);

$conf_mcd_cxt =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'cxts', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sgr_xmi_cxts', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'op_label' => 'link',
        'op_input' => 'add',
        'xmi_mod' => 'cxt',
        'xmi_mode' => 'live',
        'op_xmi_hdrbar' => 'short',
        'fields' => array(
            $conf_field_sgrcxtxmi
        )
);

$conf_mcd_cxt_tbl =
array(
        'view_state' => 'max',
        'edit_state' => 'edit',
        'sf_title' => 'cxttbl', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sgr_cxttbl', //the form id tag (must be unique)
        'sf_nav_type' => 'nmedit',
        'script' => 'php/subforms/sf_xmitable.php',
        'op_assemblage_type' =>  $conf_field_sgrcxtxmi,    // the field of data attached to the item
        'default' => '0', //the default value for creating new records
        'op_label' => 'space',
        'op_input' => 'save',
        'op_xmi_field' => $conf_field_sgrcxtxmi,
        'fields' => array(
                $conf_field_sgrcxtxmi,
                $conf_field_cxtbasicinterp,
                $conf_field_process,
                $conf_field_interp,
        ),
);

$conf_mcd_grp =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_title' => 'group', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sgr_grp_display', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'sf_nav_type' => 'nmedit',
        'op_register' => 'conf_mcd_reggrp',
        'xmi_mode' => 'live',
        'xmi_mod' => 'grp',
        'fields' =>
            array(
                $conf_field_sgrgrpxmi
        )
);


$conf_mcd_sgrmatrix = 
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'sgrmatrix',
        'sf_nav_type' => 'nmedit',
        'sf_html_id' => 'sgr_matrix',
        'script' => 'php/subforms/sf_spanmatrix.php',
        'op_fancylabels' => 'off',
        'op_fancylabel_dir' => 'topdown',
        'op_label' => 'space',
        'op_input' => 'plus_sign',
        'op_spantype' => 'tvector',
        'fields' => array(
        )
);
/*
$conf_mcd_sgrplancxt = 
   array(
       'view_state' => 'max',
       'edit_state' => 'view',
       'sf_title' => 'plancxt',
       'sf_html_id' => 'sgr_plancxt',
       'sf_nav_type' => 'nmedit',
       'script' => 'php/subforms/sf_txt.php',
       'op_label' => 'space',
       'op_input' => 'save',
       'op_emptyfielddisp' => 1,
       'fields' => array(
           $conf_field_plancxt
       )
);
*/
$conf_mcd_sgrnarrative =
    array(
        'view_state' => 'max',
        'edit_state' => 'edit', 
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'sgrnarrative', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sgr_narrative', //the form id tag (must be unique)
        'script' => 'php/sgr_view/subforms/sf_interp.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_copy_button' => 'sgr_su_description',
        'fields' => array(
            $conf_field_sgrnarrative, 
            $conf_field_sgrnarrativeby,
            $conf_field_sgrnarrativeon
        )
);
$conf_mcd_datingnarrative =
    array(
        'view_state' => 'max',
        'edit_state' => 'edit', 
        'sf_nav_type' => 'none',
        'sf_title' => 'datingnarrative', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sgr_dating_narrative', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_datingnarrative, 
            //$conf_field_datingnarrativeby,
            //$conf_field_datingnarrativeon
        )
);

$conf_mcd_under_construction =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_nav_type' => 'none',
        'sf_title' => 'message', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sgr_message', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_message.php',
        'op_message' => 'under_construction',
);

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
*/


// Subform Package
$conf_register =
    array(
        'view_state' => 'max',
        'edit_state' => 'edit',
        'sf_title' => 'register', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sgr_cd_register', //the form id tag (must be unique)
        'sf_nav_type' => 'none',
        'script' => 'php/subforms/sf_register_tbl.php',
        'op_label' => 'save',
        'op_input' => 'save',
        'op_reg_mode' => 'tbl',
        'op_no_rows' => 5,
        //'op_mk_instructions' => 'cxt_reg_instructions',
        'fields' => 
            array(
                $conf_field_sgr_cd,
                $conf_field_short_desc,
                $conf_field_sgrcxtxmi,
                $conf_reg_op_no_enter
        )
);

/* The column holding the register subform. */
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
*/



//FIX ME: This matrix setup needs to be entered into the subform.
//Matrix

//This sets whether the temporal vectors will have attributes
#$conf_tvector_att = 'on';
$conf_tvector_att = 'off';

//This set whether labels should be current context-centric or should follow top to bottom
#$conf_tvector_att_dir = 'topdown';
#$conf_tvector_att_dir = 'centric';

//Same As
// This sets whether we have a same as option available in the stratigraphy area of the detfrm
$conf_sameas = 'on';
// This sets the id number fo the spantype same as. This is liable to be different depending on your setup of ark. It is the id in cor_lut_spantype.
$conf_spantype_id = 2;

//Bonds with
//This sets whether we have a related to option available in the stratigraphy area of the detfrm
$conf_relatedto = 'on';
//This sets the id number for the spantype related to.  This is liable to be different depending on your setup of ark.  It is the id in the cor_lut_spantype.
$conf_spantype_id = 3;

//If $conf_tvector_att = 'on' then you need to set up validation arrarys for each context type
// 	The array number must be in the format XtoX with no spaces
// 	The array should contain prohibited label id numbers from cor_lut_spanlable
// 	Put values into the array of labels prohibited for that context pairing

// NOTE: As the system is prohibitive, your lists don't have to be exhaustive.
// 	You may choose to ban only likely confusion areas.
// 	To make a cmprehensive list, consider using a spreadsheet program (see wiki)

//THE FOLLOWING HAVE BEEN DISABLE AS IT IS EXPECTED THE SU/SSU SYSTEM DOES NOT REQUIRE PROHIBITIVE STRATIGRAPHIC
//RELATIONSHIP PAIRING, AND THE DIRECTORS HAVE EXPRESSED NO INTEREST IN HAVING SUCH LIMITATIONS

//Context type 1
//$conf_1to1 = array(2, 3, 4);
//$conf_1to2 = array(2, 3, 5, 6);
//$conf_1to3 = array(2, 3, 4, 6);
//Context type 2
//$conf_2to1 = array(1, 3, 5, 6);
//$conf_2to2 = array(1, 4);
//$conf_2to3 = array(1, 4, 6);
//Context type 3
//$conf_3to1 = array(1, 3, 5, 6);
//$conf_3to2 = array(1, 4, 6);
//$conf_3to3 = array(1, 4);
//Context type 4 (SU)
//Context type 5 (SSU)
//A convenient package of all of the above
//$conf_tvclab = array('1to1' => $conf_1to1, '1to2' => $conf_1to2, '1to3' => $conf_1to3, '2to1' => $conf_2to1, '2to2' => $conf_2to2, '2to3' => //$conf_2to3, '3to1' => $conf_3to1, '3to2' => $conf_3to2, '3to3' => $conf_3to3);
$conf_tvclab = FALSE;

/* Now we will need to make a columns package, much like with the Micro View */

$conf_dat_detfrm =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' => array(
            $conf_mcd_under_construction,
            // $conf_mcd_cxt,
            // $conf_mcd_sgrmatrix,
            // $conf_mcd_sgrnarrative,
        )
);


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
*/ 

// Columns
//  col_id = the html id attribute to set for the div of the column
//  col_alias = the words to display in to users int he column header
// FIXME:
// col_alias should be renamed col_name and make use of markup. This is
// NOT an alias and this is currently language dependant
//  col_type = the html class attribute of the column div (must match a valid css class)
//  subforms = an array of subforms in the order they are displayed

$conf_mcd_col_1 =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' => array(
            $conf_mcd_description,
            $conf_mcd_sgrnarrative,
        )
);

$conf_mcd_col_2 =
    array(
        'col_id' => 'second_column',
        'col_alias' => FALSE,
        'col_type' => 'secondary_col',
        'subforms' => array(
            //$conf_mcd_datingnarrative,
            $conf_mcd_sgrmatrix,
            //$conf_mcd_grp,
        )
);
$conf_mcd_col_3 =
    array(
        'col_id' => 'third_column',
        'col_alias' => FALSE,
        'col_type' => 'tertiary_col',
        'subforms' =>
        array(
            $conf_mcd_cxt_tbl,
        ),
);
// Columns Package
$sgr_conf_mcd_cols =
    array(
        'op_display_type' => 'cols',
        'op_top_col' => 'main_column', // string to match the 'col_id'
        'columns' =>
            array(
                $conf_mcd_col_1,
                $conf_mcd_col_2,
                $conf_mcd_col_3
        )        
);

//Spatial viewer (subform)

//decide if you want to show a reference map when the spatial subform is in primary column

$refmap_show = TRUE;

//set this to TRUE if you want the maps to display on default, else leave as FALSE

$view_map_default = TRUE;

//This is for setting up the params from the reference map

$refmap_type = 'SCALE'; //choose if you want to zoom to 'SCALE' or 'SHAPE' - i.e. if you want to always have the ref map zoomed to a set scale or if you
			  //want it to zoom the outline of a specific shape
$refmap_scale = 500; //leave this NULL if you are zooming to a shape, else use an int i.e. 500 for 1:500
$refmap_width = 200; // (OPTIONAL) this is an optional value for specifiying a non-default width (if not specified the value is taken from the $map object)
$refmap_height = 200; // (OPTIONAL) this is an optional value for specifiying a non-default height (if not specified the value is taken from the $map object)
$refmap_layer = NULL; //OPTIONAL (only should be used if zoomtype SHAPE is stated)  - the name of the layer to zoom to
$refmap_field = NULL; //OPTIONAL (only should be used if zoomtype SHAPE  is stated)  - the name of attribute field of the shape to zoom to
$refmap_fieldvalue = NULL; //OPTIONAL (only should be used if zoomtype SHAPE is stated)  - the value in the attribute field of the shape to zoom to


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
* chat - this is typically used to display a snippet of text from a freetext
*  type search. This means that the settings for this are minimal
*
* map - this displays a map of the results with marker labels for each item
*
*/

// Table
//  This is basically a subform package and follows the subform rules
$conf_mac_table =
    array(
        'op_no_rows' => 25,
        'fields' =>
            array(
                $conf_field_sgr_cd,
                $conf_field_short_desc,
                $conf_field_sgrcxtxmi,
                $conf_reg_op_no_enter
        )
);

// Text
//  This is basically a subform package and follows the subform rules
$conf_mac_text =
    array(
        'op_no_rows' => 25,
        'fields' =>
            array(
                $conf_field_short_desc,
                $conf_field_sgrcxtxmi,
                $conf_reg_op_no_enter
        )
);    

// Thumbs
//  This is basically a subform package and follows the subform rules
$conf_mac_thumb =
    array(
        'op_no_rows' => 25,
        'fields' =>
            array(
                $conf_field_rgf_cd,
        )
);

/**
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
        'sf_html_id' => 'mac_sgruserconfigfields', // Must be unique
        'script' => 'php/data_view/subforms/sf_userconfigfields.php',
        'op_label' => 'space',
        'op_input' => 'go',
        'op_modtype' => FALSE,
        'fields' => // these are the fields available to the user - only fields with 'field_id' work
            array(
                $conf_field_rgf_cd,
                $conf_field_short_desc,
                $conf_field_sgrcxtxmi,
                $conf_field_sgrnarrative,
                $conf_field_datingnarrative
        ),
);   
    

// XMI VIEWER STUFF
//  Any given item may be viewed in a reduced form from within another module
//  this part of the settings file describes how this module represents itself
//  when called into an XMI view

// fields as set up at the top of the settings file. here we simply call them into
// the package

$sgr_xmiconf =
    array(
        'op_xmi_hdrbar' => 'link', // we put optional stuff in here 
        'op_xmi_label' => TRUE, // we put optional stuff in here           
        'fields' => 
            array(
                $conf_field_short_desc,
        )
);
$sgr_map_pop_conf =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'mappop',
        'sf_html_id' => 'sgr_mappop', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_sf_cssclass' => 'popup_frame',
        'op_input' => 'save',
        'subforms' => 
            array(
                $conf_mcd_cxt,
        ),
);

/** TRANSCLUDE API STUFF
* Special config to use when an external app calls the tranclude API
*/

$conf_api_narrative =
    array(
        'view_state' => 'max',
        'edit_state' => 'edit', //not yet setup in sf
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'api_narrative', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sgr_api_narrative', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' =>
            array(
                $conf_field_sgrnarrative,
            ),
    );

$conf_api_cxt_tbl =
array(
        'view_state' => 'max',
        'edit_state' => 'edit',
        'sf_title' => 'api_cxttbl', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'sgr_api_cxttbl', //the form id tag (must be unique)
        'sf_nav_type' => 'nmedit',
        'script' => 'php/subforms/sf_xmitable.php',
        'op_assemblage_type' =>  $conf_field_sgrcxtxmi,    // the field of data attached to the item
        'default' => '0', //the default value for creating new records
        'op_label' => 'space',
        'op_input' => 'save',
        'op_xmi_field' => $conf_field_sgrcxtxmi,
        'fields' => array(
                $conf_field_sgrcxtxmi,
                $conf_field_interp,
        ),
);

$sgr_api_sum_conf =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'apisum',
        'sf_html_id' => 'sgr_apisum', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_sf_cssclass' => 'popup_frame',
        'op_input' => 'save',
        'subforms' =>
            array(
                $conf_mcd_description,
                $conf_api_narrative,
                $conf_api_cxt_tbl,
        ),
);

?>
