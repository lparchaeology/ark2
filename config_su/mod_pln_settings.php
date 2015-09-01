<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* mod_pln_settings.php
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


// READ THE WIKI BEFORE EDITING THIS FILE

// DEV NOTE: IF YOU ADD TO THIS FILE ADD A WIKI ENTRY

// Custom Fields
$conf_field_itemkey =
    array(
        'field_id' => 'conf_field_itemkey',               
        'dataclass' => 'itemkey',
        'classtype' => 'pln_cd', //this is needed to correctly request the qtype
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'pln_cd',
        'alias_type' => '1',
        'module' => 'pln',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

// XMI to link to context module
$conf_field_cxtxmi = 
    array(
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'cxt_cd',
        'alias_type' => '1',
        'module' => 'pln',
        'xmi_mod' => 'cxt',
        'op_xmi_itemkey' => 'cxt_cd',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
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
        'sf_html_id' => 'cxt_itemvalconflict', // Must be unique
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
        'sf_html_id' => 'cxt_itemval', // Must be unique
        'script' => 'php/subforms/sf_itemval.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'conflict_res_sf' => 'conf_mcd_itemval_conflicts',
        'fields' =>
            array(
                $conf_field_itemkey
        )
);

$conf_mcd_pln =
  array(
      'op_moddif' => FALSE,
      'view_state' => 'max',
      'edit_state' => 'view',
      'sf_title' => 'plan', //appears in the titlebar of the subform (mk nname)
      'sf_html_id' => 'pln_img_display', //the form id tag (must be unique)
      'script' => 'php/subforms/sf_file.php',
      'sf_nav_type' => 'nmedit',
      'op_lightbox' => TRUE,
      'op_default_dir' => 'data/files',
      'op_label' => 'link',
      'op_input' => 'update',
      'fields' => array(
          $conf_field_images
      ),
 );

$conf_mcd_plndesc =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'desc', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'pln_img_desc', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'edit',
        'fields' => array(
            $conf_field_short_desc
        )       
);

$conf_mcd_plnevent =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'cxtmeta', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'pln_event_desc', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_event.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'events' => array(
            $conf_event_drawn
        )       
);

$conf_mcd_xmipln =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'cxts', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'pln_xmi_cxts', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'xmi_mod' => 'cxt',
        'xmi_mode' => 'live',        
        'op_label' => 'link',
        'op_input' => 'add',
        'fields' => array(
            $conf_field_cxtxmi
        ),  
);


/**  REGISTER
*
* A form used for issuing new items to this module
*
* The register is essentially just another subform. In most uses it is simply
* used as a standalone form. However it may be used in an embedded form
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
*/


// Subform Package
$conf_register =
    array(
        'view_state' => 'max',
        'edit_state' => 'edit',
        'sf_title' => 'register', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'pln_cd_register', //the form id tag (must be unique)
        'script' => 'php/data_entry/register.php',
        'op_label' => 'save',
        'op_input' => 'save',
        'op_reg_mode' => 'tbl',
        'op_no_rows' => 15,
        'fields' => 
            array(
                $conf_field_itemkey,
                $conf_field_short_desc,
                $conf_field_cxtxmi,
                $conf_field_drawnby,
                $conf_field_drawnon,
                $conf_reg_op_qed_only
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
            $conf_mcd_pln,
            $conf_mcd_plndesc,
        )
);

$conf_mcd_col_2 =
    array(
        'col_id' => 'second_column',
        'col_alias' => FALSE,
        'col_type' => 'secondary_col',
        'subforms' => array(
            $conf_mcd_xmipln,            
            $conf_mcd_plnevent,
        )
);


// Columns Package
$pln_conf_mcd_cols =
    array(
        'op_display_type' => 'cols',
        'op_top_col' => 'main_column', // string to match the 'col_id'
        'columns' =>
            array(
                $conf_mcd_col_1,
                $conf_mcd_col_2
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
        'op_no_rows' => 15,
        'fields' =>
            array(
                $conf_field_itemkey,
                $conf_field_short_desc,
                $conf_field_cxtxmi,
                $conf_field_images,
                $conf_reg_op_view_only
        )
);
// Text
//  This is basically a subform package and follows the subform rules
$conf_mac_text =
    array(
        'op_no_rows' => 15,
        'fields' =>
            array(
                $conf_field_itemkey,
                $conf_field_short_desc,
                $conf_field_cxtxmi,
                $conf_field_images,
                $conf_reg_op_view_only
        )
);
// Thumbs
//  This is basically a subform package and follows the subform rules
$conf_mac_thumb =
    array(
        'op_no_rows' => 15,
        'fields' =>
            array(
                $conf_field_itemkey,
                $conf_field_images,
        )
);    

/** USER CONFIG OF SEARCH RESULT FIELDS
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
                $conf_field_short_desc,
                $conf_field_cxtxmi,
                $conf_field_images,
                $conf_field_drawnby,
                $conf_field_drawnon,
        ),
);


// XMI VIEWER STUFF
//  Any given item may be viewed in a reduced form from within another module
//  this part of the settings file describes how this module represents itself
//  when called into an XMI view

// fields as set up at the top of the settings file. here we simply call them into
// the package

$pln_xmiconf =
    array(
        'op_xmi_hdrbar' => 'link', // we put optional stuff in here 
        'op_xmi_label' => FALSE, // we put optional stuff in here           
        'fields' => 
            array(
                $conf_field_images,
        )
);

?>