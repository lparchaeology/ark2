<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* mod_cns_settings.php
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


// DATA ENTRY STUFF

// Custom Fields
$conf_field_itemkey =
    array(
        'field_id' => 'conf_field_itemkey',               
        'dataclass' => 'itemkey',
        'classtype' => 'cns_cd', //this is needed to correctly request the qtype
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'cns_cd',
        'alias_type' => '1',
        'module' => 'cns',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);


$conf_field_cxtxmi = 
    array(
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'cxt_cd',
        'alias_type' => '1',
        'module' => 'cns',
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


$conf_mcd_cnsdesc =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'desc', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cns_description', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
             $conf_field_definition,
             $conf_field_denomination,            
             $conf_field_metal,
             $conf_field_weight,
             $conf_field_diameter,
             $conf_field_obverse,
             $conf_field_reverse,
             $conf_field_mint,
             $conf_field_date,
             $conf_field_reference
        )
);

$conf_mcd_cnsnote =
    array(
        'view_state' => 'max',
        'sf_nav_type' => 'nmedit',
        'edit_state' => 'view', //not yet setup in sf
        'sf_title' => 'note', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cns_interp', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_interp.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_note, 
            $conf_field_notedby,
            $conf_field_notedon
        )
);

$conf_mcd_cnsevent =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'cxtmeta', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cns_events', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_event.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'events' => array(
            $conf_event_supervised,
            $conf_event_restored,
            $conf_event_registered
        )
);

$conf_mcd_cph =
  array(
      'op_moddif' => FALSE,
      'view_state' => 'max',
      'edit_state' => 'view',
      'sf_title' => 'photo', //appears in the titlebar of the subform (mk nname)
      'sf_html_id' => 'cns_img_display', //the form id tag (must be unique)
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

$conf_mcd_xmicns =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'cxts', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cns_xmi_cxts', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'op_label' => 'link',
        'op_input' => 'add',
        'fields' => array(
             $conf_field_cxtxmi,
        ),
        'xmi_mod' => 'cxt',
        'xmi_mode' => 'live',               
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
        'sf_html_id' => 'cns_cd_register', //the form id tag (must be unique)
        'script' => 'php/data_entry/register.php',
        'op_label' => 'save',
        'op_input' => 'save',
        'op_reg_mode' => 'tbl',
        'op_no_rows' => 15,
        'fields' => 
            array(
                $conf_field_itemkey,
                $conf_field_definition,
                $conf_field_cxtxmi,
                $conf_field_registeredby,
                $conf_field_registeredon,
                $conf_reg_op
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

/* Now we will need to make a columns package, much like with the Micro View */

$conf_dat_detfrm =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' => array(
            $conf_mcd_cnsdesc,
            $conf_mcd_xmicns,
            $conf_mcd_cnsnote,
            $conf_mcd_cnsevent
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
            $conf_mcd_cph,
            $conf_mcd_cnsdesc,
            $conf_mcd_cnsnote,
        )
);

$conf_mcd_col_2 =
    array(
        'col_id' => 'second_column',
        'col_alias' => FALSE,
        'col_type' => 'secondary_col',
        'subforms' => array(
            $conf_mcd_xmicns,
            $conf_mcd_cnsevent,
        )
);

// Columns Package
$cns_conf_mcd_cols =
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
        'op_no_rows' => 25,
        'fields' =>
            array(
                $conf_field_itemkey,
                $conf_field_definition,
                $conf_field_cxtxmi,
                $conf_field_images,                
                $conf_field_registeredby,
                $conf_field_registeredon,
                $conf_reg_op_no_qed
        )
);

// Text
//  This is basically a subform package and follows the subform rules
$conf_mac_text =
    array(
        'op_no_rows' => 25,
        'fields' =>
            array(
                $conf_field_itemkey,
                $conf_field_definition,
                $conf_field_cxtxmi,
                $conf_field_images,                
                $conf_field_registeredby,
                $conf_field_registeredon,
                $conf_reg_op_no_qed
        )
);
  
// Thumbs
//  This is basically a subform package and follows the subform rules
$conf_mac_thumb =
    array(
        'op_no_rows' => 25,
        'fields' =>
            array(
                $conf_field_itemkey,
                $conf_field_images
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
                $conf_field_definition,
                $conf_field_cxtxmi,
                $conf_field_images,                
                $conf_field_registeredby,
                $conf_field_registeredon,
        ),
);

    
// XMI VIEWER STUFF
//  Any given item may be viewed in a reduced form from within another module
//  this part of the settings file describes how this module represents itself
//  when called into an XMI view

// fields as set up at the top of the settings file. here we simply call them into
// the package

$cns_xmiconf =
    array(
        'op_xmi_hdrbar' => 'link', // we put optional stuff in here      
        'op_xmi_label' => TRUE, // we put optional stuff in here     
        'fields' => 
            array(
                $conf_field_images,    
                $conf_field_definition,
                $conf_field_date
        )
);

?>