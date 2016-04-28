<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* mod_cxt_settings.php
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

//First set  up your types in cxt_lut_cxttype the type id numbers are critical in this script

//DISPLAY STUFF

// TYPE DISPLAY BRACKETS
// TO DISPLAY RECORDS OF DIFFERENT MODTYPES WITH CUSTOM BRACKETS IN NAVIGATION
// The types refer to entries in cxt_lut_cxttype
$conf_br = array('type_1_L' => '(', 'type_1_R' => ')','type_2_L' => '[', 'type_2_R' => ']','type_3_L' => '', 'type_3_R' => '*');

//CUSTOM FIELDS
// Some custom fields set up just for this module

$conf_field_itemkey =
    array(
        'field_id' => 'conf_field_itemkey',            
        'dataclass' => 'itemkey',
        'classtype' => 'cxt_cd', //this is needed to correctly request the qtype
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'cxt_cd',
        'alias_type' => '1',
        'module' => 'cxt',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $key_add_validation,
        'edt_validation' => $key_edt_validation
);

$conf_field_itemkey['add_validation'][] = $key_vd_modtype;
$conf_field_itemkey['edt_validation'][] = $key_vd_modtype;

// MODULE TYPE is needed for this module
$conf_field_cxttype =
    array(
        'field_id' => 'conf_field_cxttype',              
        'dataclass' => 'modtype',
        'classtype' => 'cxttype',
        'alias_tbl' => 'cor_tbl_col',
        'alias_col' => 'dbname',
        'alias_src_key' => 'cxttype',
        'alias_type' => '1',
        'editable' => TRUE,
        'hidden' => FALSE,
		'add_validation' => 'none',
        'edt_validation' => 'none'
);

// XMI fields for linking to other modules
$conf_field_sphxmi = 
    array(
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'sph_cd',
        'alias_type' => '1',
        'module' => 'cxt',
        'xmi_mod' => 'sph',
        'op_xmi_itemkey' => 'sph_cd',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);

$conf_field_plnxmi = 
    array(
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'pln_cd',
        'alias_type' => '1',
        'module' => 'cxt',
        'xmi_mod' => 'pln',
        'op_xmi_itemkey' => 'pln_cd',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);

$conf_field_gphxmi = 
    array(
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'gph_cd',
        'alias_type' => '1',
        'module' => 'cxt',
        'xmi_mod' => 'gph',
        'op_xmi_itemkey' => 'gph_cd',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);

$conf_field_aelxmi = 
    array(
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'ael_cd',
        'alias_type' => '1',
        'module' => 'cxt',
        'xmi_mod' => 'ael',
        'op_xmi_itemkey' => 'ael_cd',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);

$conf_field_spfxmi = 
    array(
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'spf_cd',
        'alias_type' => '1',
        'module' => 'cxt',
        'xmi_mod' => 'spf',
        'op_xmi_itemkey' => 'spf_cd',
        'editable' => TRUE,
        'hidden' => FALSE,
        'add_validation' => $xmi_add_validation,
        'edt_validation' => $xmi_edt_validation
);

$conf_field_cnsxmi = 
    array(
        'dataclass' => 'xmi',
        'classtype' => 'xmi_list',
        'alias_tbl' => 'cor_tbl_module',
        'alias_col' => 'itemkey',
        'alias_src_key' => 'cns_cd',
        'alias_type' => '1',
        'module' => 'cxt',
        'xmi_mod' => 'cns',
        'op_xmi_itemkey' => 'cns_cd',
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

// Setup delete and edit modtype and itemval subforms
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
        )
);

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
        )
);

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

// FIELDS USED FOR ALL SU TYPES
$conf_mcd_description =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'full',
        'sf_title' => 'desc', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_su_description', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
	    'op_modtype' => TRUE,
        'op_input' => 'save',
        'type1_fields' => array(
             $conf_field_critofdistinction,
             $conf_field_excavtech,
             $conf_field_dims,
             $conf_field_compo,             
             $conf_field_colour,
             $conf_field_compac,
             $conf_field_conservation,
             $conf_field_formation,           
             $conf_field_geocomponents,
             $conf_field_orgcomponents,
             $conf_field_artcomponents,
             $conf_field_desc,
             $conf_field_observ,
             $conf_field_chronoelem,
             $conf_field_interp_period,
             $conf_field_phase,
             $conf_field_strat_reliability
        ),
        'type2_fields' => array(
             $conf_field_definition,      
             $conf_field_critofdistinction,      
             $conf_field_conservation, 
             $conf_field_tech,
             $conf_field_finition,
             $conf_field_inclusions,
             $conf_field_dims,     
             $conf_field_mortar,        
             $conf_field_stone,
             $conf_field_h_mortar,   
             $conf_field_bricks,
             $conf_field_cons_mortar,
             $conf_field_h_courses,
             $conf_field_h_5courses,
             $conf_field_desc,
             $conf_field_observ,
             $conf_field_chronoelem,
             $conf_field_interp_period,
             $conf_field_phase
        ),
        'type3_fields' => array(
             $conf_field_definition,             
             $conf_field_excavtech, 
             $conf_field_gravetype,
             $conf_field_gravecover,
             $conf_field_orient,
             $conf_field_conservation,
             $conf_field_condition,
             $conf_field_desc,
             $conf_field_observ,
             $conf_field_interp_period,
             $conf_field_phase,
             $conf_field_assocfinds,
             $conf_field_strat_reliability,
        )
);

$conf_mcd_recstatus =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'recstatus', 
        'sf_html_id' => 'recstatus', // Must be unique
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_recflag
        )
);

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
        'fields' => array(
            $conf_field_interp, 
            $conf_field_interpretedby,
            $conf_field_interpretedon
        )
);

$conf_mcd_short_desc =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_nav_type' => 'name',
        'sf_title' => 'short_desc', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_short_desc', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_definition
        )
);

// FIELDS UNIQUE TO THE HRU
$conf_mcd_hruage =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'hruage', 
        'sf_html_id' => 'hruage', // Must be unique
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '3'
                ),
        ),
        'fields' => array(
            $conf_field_hruage
        )
);

$conf_mcd_hruagecrit =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_nav_type' => 'name',
        'sf_title' => 'hruagecrit', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_hruagecrit', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '3'
                ),
        ),
        'fields' => array(
            $conf_field_agediagnostic
        )
);


$conf_mcd_hrusex =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'hrusex', 
        'sf_html_id' => 'hrusex', // Must be unique
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '3'
                ),
        ),
        'fields' => array(
            $conf_field_hrusex
        )
);

$conf_mcd_hrutxt =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_nav_type' => 'name',
        'sf_title' => 'hrusexcrit', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'hrutxt', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '3'
                ),
        ),
        'fields' => array(
            $conf_field_sexdiagnostic,
            $conf_field_agediagnostic,
            $conf_field_deposnature
        )
);

$conf_mcd_hruattr =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'hrudeposition', 
        'sf_html_id' => 'hruattr', // Must be unique
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '3'
                ),
        ),
        'fields' => array(
            $conf_field_hrusex,
            $conf_field_hruage,
            $conf_field_hrudeposition
        )
);

$conf_mcd_posattr =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'hrudeposition', 
        'sf_html_id' => 'posattr', // Must be unique
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_display_mode' => 'radio',
        'fields' => array(
            $conf_field_hruposition,
            $conf_field_temporo,
            $conf_field_cranio,
            $conf_field_atlante,
            $conf_field_epistrofeo,
        )
);

$conf_mcd_postxt =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_nav_type' => 'name',
        'sf_title' => 'hrudeposnature', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'postxt', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_posn_cranium,
            $conf_field_uppersx,
            $conf_field_handsx,
            $conf_field_upperdx,
            $conf_field_handdx,
            $conf_field_lowersx,
            $conf_field_lowerdx,
            $conf_field_posn_observations,
        )
);

$conf_mcd_decompattr =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'hrudeposition', 
        'sf_html_id' => 'decompattr', // Must be unique
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_decomposition,
        )
);

$conf_mcd_decomptxt =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_nav_type' => 'name',
        'sf_title' => 'hrudeposnature', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'decomptxt', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_thorax,
            $conf_field_sunkensternum,
            $conf_field_pelvis,
            $conf_field_kneedecomp,
            $conf_field_ankledecomp,
            $conf_field_vertclavicle,
            $conf_field_obscapula,
            $conf_field_medhumerus,
            $conf_field_latfemur,
            $conf_field_deposprocesses,
            $conf_field_causecompression
        )
);

$conf_mcd_measuretxt =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_nav_type' => 'name',
        'sf_title' => 'hrudeposnature', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'measuretxt', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_totlength
        )
);

$conf_mcd_measurenum =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_nav_type' => 'name',
        'sf_title' => 'hrudeposnature', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'measurenum', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_number.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
            $conf_field_clavicle,
            $conf_field_humerus,
            $conf_field_radius,
            $conf_field_tibia,
            $conf_field_femur
        )
);

$conf_mcd_articulation =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'articulation', 
        'sf_html_id' => 'hruarticulation', // Must be unique
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_display_mode'=> 'radio',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '3'
                ),
        ),
        'fields' => array(
            $conf_field_cervical,
            $conf_field_dishandsx,
            $conf_field_dishanddx,
            $conf_field_disfootsx,
            $conf_field_disfootdx,
            $conf_field_scapulasx,
            $conf_field_scapuladx,
            $conf_field_atlanto,
            $conf_field_lumbar,
            $conf_field_lumsacrum,
            $conf_field_sacrumsx,
            $conf_field_sacrumdx,
            $conf_field_kneesx,
            $conf_field_kneedx,
            $conf_field_anklesx,
            $conf_field_ankledx,
            $conf_field_tarsalsx,
            $conf_field_tarsaldx,
        )
);

$conf_mcd_deposnature =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_nav_type' => 'name',
        'sf_title' => 'hrudeposnature', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_deposnature', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '3'
                ),
        ),
        'fields' => array(
            $conf_field_deposnature
        )
);

// SUBFORMS RECORDING STRATIGRAPHIC RELATIONSHIPS
$conf_mcd_matrix = 
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'matrix',
        'sf_nav_type' => 'name',
        'sf_html_id' => 'cxt_matrix',
        'script' => 'php/subforms/sf_spanmatrix.php',
        'op_fancylabels' => 'on',
        'op_fancylabel_dir' => 'topdown',
        'op_label' => 'space',
        'op_input' => 'plus_sign',
        'op_spantype' => 'tvector',
        'fields' => array(
        )
);

$conf_mcd_sameas = 
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'othermatrix',
        'sf_html_id' => 'cxt_su_matrix',
        'script' => 'php/subforms/sf_span_rel.php',
        'op_label' => 'space',
        'op_input' => 'plus_sign',
        'op_condition' => array(
                array(
                        'func'=> 'chkFragPresence',
                        'args'=> 'span,sameas'
                ),
        ),
        'fields' => array(
            $conf_field_sameas,
        )
);

$conf_mcd_bondswith = 
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'othermatrix',
        'sf_html_id' => 'cxt_ssu_matrix',
        'script' => 'php/subforms/sf_span_rel.php',
        'op_label' => 'space',
        'op_input' => 'plus_sign',
        'op_condition' => array(
                array(
                        'func'=> 'chkFragPresence',
                        'args'=> 'span,relto'
                ),
        ),
        'fields' => array(
            $conf_field_relto,
        )
);


// SUBFORMS TO DO WITH THE CERAMICS INVENTORY
$conf_mcd_chronology =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'title',
        'sf_title' => 'chrono', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_chronology', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_chronology.php',
        'sf_op_showranges' => TRUE,
        'sf_op_showtl' => FALSE,
        'op_label' => 'save',
        'op_input' => 'save',
        'op_moddif' => TRUE,
        'fields' => array(
            $conf_field_daterange
        )
);

$conf_mcd_ceramic =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'ceramic', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_ceramic', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_assemblage.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_assemblage_type' => 'certype',
        'op_chart' => 'true',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '1'
                ),
        ),
        'fields' => array(
             $conf_field_total             
        )
);

$conf_mcd_certypes =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'desc', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_certypes', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_attr_bytype.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'sf_op_attributetype' => 'certype',
        'fields' => array(
            $conf_field_certype
        )
);

$conf_mcd_potterytxt =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', //not yet setup in sf
        'sf_nav_type' => 'name',
        'sf_title' => 'hrudeposnature', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'potterytxt', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_txt.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_emptyfielddisp' => TRUE,
        'fields' => array(
            $conf_field_potterynotes
        )
);

// EVENT forms to hold record metadata
$conf_mcd_event =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'cxtmeta', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_events', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_event.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'events' => array(
            $conf_event_directed,
            $conf_event_supervised,
            $conf_event_excavated,
            $conf_event_issued,
        )
);

// XMI subforms to link to other modules
$conf_mcd_xmicxtsph =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'site_photo', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_xmi_sph', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'op_input' => 'add',
        'op_lightbox' => TRUE,
        'xmi_mod' => 'sph',
        'xmi_mode' => 'live',
        'fields' => 
            array(
                  $conf_field_sphxmi,
        ),        
);

$conf_mcd_xmicxtpln =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'plan', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_xmi_plnsu', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'op_input' => 'add',
        'op_lightbox' => TRUE,
        'xmi_mod' => 'pln',
        'xmi_mode' => 'live',
        'op_condition' => array(
                array(
                        'func'=> 'chkFragPresence',
                        'args'=> 'xmi,pln'
                ),
        ),
        'fields' => 
            array(
                  $conf_field_plnxmi,
        ),        
);

$conf_mcd_xmicxtgph =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'geophoto', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_xmi_gph', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'op_input' => 'add',
        'op_lightbox' => TRUE,
        'xmi_mod' => 'gph',
        'xmi_mode' => 'live',
        'op_condition' => array(
                array(
                        'func'=> 'chkFragPresence',
                        'args'=> 'xmi,gph'
                ),
        ),
        'fields' => 
            array(
                  $conf_field_gphxmi,
        ),        
);

$conf_mcd_xmicxtspf =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'objects', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_xmi_spf', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'xmi_mod' => 'spf',
        'xmi_mode' => 'live',        
        'op_input' => 'add',
        'op_condition' => array(
                array(
                        'func'=> 'chkFragPresence',
                        'args'=> 'xmi,spf'
                ),
        ),
        'fields' => 
            array(
                  $conf_field_spfxmi,
        ),
);

$conf_mcd_xmicxtael =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'elements', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_xmi_ael', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'xmi_mod' => 'ael',
        'xmi_mode' => 'live',
        'op_label' => 'link',
        'op_input' => 'add',
        'op_condition' => array(
                array(
                        'func'=> 'chkFragPresence',
                        'args'=> 'xmi,ael'
                ),
        ),
        'fields' => 
            array(
                  $conf_field_aelxmi,
        ), 
);

$conf_mcd_xmicxtcns =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'coins', //appears in the titlebar of the subform (mk nname)
        'sf_html_id' => 'cxt_xmi_cns', //the form id tag (must be unique)
        'script' => 'php/subforms/sf_xmi.php',
        'xmi_mod' => 'cns',
        'xmi_mode' => 'live',
        'op_label' => 'link',
        'op_input' => 'add',
        'op_condition' => array(
                array(
                        'func'=> 'chkFragPresence',
                        'args'=> 'xmi,cns'
                ),
        ),
        'fields' => 
            array(
                  $conf_field_cnsxmi,
        ), 
);

//Frame Subforms

$conf_mcd_stratframe =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'cxtstrat', 
        'sf_html_id' => 'cxt_stratframe', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'subforms' => array(
            $conf_mcd_matrix,
            $conf_mcd_sameas,
            $conf_mcd_relto
         )
    );

$conf_mcd_descframe =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'desc', 
        'sf_html_id' => 'cxt_descframe', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'subforms' => array(
            $conf_mcd_description,
            $conf_mcd_hruattr,
            $conf_mcd_hrutxt,
         )
    );

$conf_mcd_positionframe =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'position', 
        'sf_html_id' => 'hru_positionframe', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '3'
                ),
        ),
        'subforms' => array(
            $conf_mcd_posattr,
            $conf_mcd_postxt,
         )
    );

$conf_mcd_decompframe =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'decomp', 
        'sf_html_id' => 'hru_decompframe', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '3'
                ),
        ),
        'subforms' => array(
            $conf_mcd_decomptxt,
            $conf_mcd_decompattr,
         )
    );

$conf_mcd_measureframe =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'measure', 
        'sf_html_id' => 'hru_measureframe', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '3'
                ),
        ),
        'subforms' => array(
            $conf_mcd_measuretxt,
            $conf_mcd_measurenum,

         )
    );

$conf_mcd_basicframe =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'basicinfo', 
        'sf_html_id' => 'cxt_basicframe', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'subforms' => array(
            $conf_mcd_short_desc,
            $conf_mcd_recstatus,
         )
    );

$conf_mcd_ceramicframe =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'ceramic', 
        'sf_html_id' => 'cxt_ceramicsframe', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '1'
                ),
        ),
        'subforms' => array(
            $conf_mcd_chronology,
            $conf_mcd_potterytxt,
            $conf_mcd_certypes,
            $conf_mcd_ceramic,
         )
    );

$conf_mcd_ceramicmicro =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'ceramic', 
        'sf_html_id' => 'cxt_ceramicmicro', // Must be unique
        'script' => 'php/subforms/sf_frame.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_condition' => array(
                array(
                        'func'=> 'chkModTypeCond',
                        'args'=> '1'
                ),
        ),
        'subforms' => array(
            $conf_mcd_chronology,
            $conf_mcd_potterytxt,
            $conf_mcd_ceramic,
         )
    );

    
/** SPATIAL STUFF
*
* Subform: fields as above - extra spatial fields:
*  query_layers:
*  mapping layers for mods - specify in this array the names of the wms/wfs layers 
*  that contain the spatial data for each mod. Bear in mind that these layers should
*  contain an ark_id column that can be retrieved using a getFeatureInfo request.
*  Each layer is a seperate entry in the array containing an array of variables
*  'mod' - the mod of the item (without _cd) eg. 'cxt'
*  'geom' - the geometry of the layer - eg. 'pt', 'pl' or 'pgn'
*  'url' - the full url of the WMS/WFS server that is hosting the layer eg. http://localhost/ark/php/map/ark_wxs_server.php?
*  'style_array' (optional) - an array that contains information about the styling 
*   of the displayed geometry - see http://ark.lparchaeology.com/wiki/index.php/Sf_wfs_spat for info
*
* background_map: this is the name of the map saved using the mapping admin tools that you want to display as the background map
* 
* Optional: 
* op_buffer = the buffer in selected units around main item shape in subform
*
*/

// Spatial viewer (subform)
$conf_mcd_spat = 
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_title' => 'spat_data', 
        'sf_html_id' => 'cxt_spat_display',
        'sf_nav_type' => 'name',
        'script' => 'php/subforms/sf_wfs_spat.php',
        'query_layers' =>
            array (
                // You can uncomment these layers if you wanted to add context specific mapping data
                'cxt_schm' => array(
                        'mod' => 'cxt',
                        'geom' => 'pgn',
                        'url' => 'http://localhost:8888/ark/php/map/ark_wxs_server.php?',
                        'style_array' => 
                                array(
                                'strokeColor' => '"black"',
                                'fillColor' => '"grey"',
                        )
                ),
                // 'cxt_pl' => array(
                //         'mod' => 'cxt',
                //         'geom' => 'pl',
                //         'url' => 'http://localhost:8888/ark/php/map/ark_wxs_server.php?',
                //         'style_array' => 
                //                 array(
                //                 'strokeColor' => '"black"',
                //                 'fillColor' => '"black"'
                //         )
                // ),                
                // 'cxt_levels' => array(
                //         'mod' => 'cxt',
                //         'geom' => 'pt',
                //         'url' => 'http://localhost:8888/ark/php/map/ark_wxs_server.php?',
                //         'style_array' => array(
                //             'strokeColor' => '"black"',
                //             'fillColor' => '"black"',
                //             'pointRadius' => '1',
                //             'labelXOffset' => '20',
                //             'label' => '"${ELEVATION}"',
                //             'fontSize' => '"11px"',
                //             'fontFamily' => '"Arial, monospace"',
                //             'fontWeight' => '"bold"',
                //         )
                // ),                
        ),
        'background_map' => 'Results Map',
        'op_buffer' => 0.25,  
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
        'sf_html_id' => 'cxt_cd_register', //the form id tag (must be unique)
        'script' => 'php/data_entry/register.php',
        'op_label' => 'save',
        'op_input' => 'save',
        'op_reg_mode' => 'tbl',
        'op_no_rows' => 15,
        'fields' => 
            array(
                $conf_field_itemkey,
                $conf_field_cxttype,
                $conf_field_definition,
                $conf_field_issuedto,
                $conf_field_issuedon,
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

// COLUMN PACK FOR DATA ENTRY
$conf_dat_detfrm =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' => array(
            $conf_mcd_basicframe,
            $conf_mcd_descframe,
            $conf_mcd_stratframe,
            $conf_mcd_interp,
            $conf_mcd_event,
            $conf_mcd_ceramicframe,
            $conf_mcd_positionframe,
            $conf_mcd_articulation,
            $conf_mcd_decompframe,
            $conf_mcd_measureframe,
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
// NO OPTIONAL VIEWS IN THIS CONFIG 

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
            $conf_mcd_descframe,
            $conf_mcd_stratframe,
            $conf_mcd_interp,
            $conf_mcd_positionframe,
            $conf_mcd_articulation,
            $conf_mcd_decompframe,
            $conf_mcd_ceramicmicro,
            $conf_mcd_event,
        )
);

$conf_mcd_col_2 =
    array(
        'col_id' => 'second_column',
        'col_alias' => FALSE,
        'col_type' => 'secondary_col',
        'subforms' => array(
            $conf_mcd_basicframe,
            // You may want to use this spatial subform
            // $conf_mcd_spat,
            $conf_mcd_xmicxtsph,
            $conf_mcd_xmicxtpln,
            $conf_mcd_xmicxtgph,
            $conf_mcd_xmicxtspf,
            $conf_mcd_xmicxtael,
            $conf_mcd_xmicxtcns,
        )
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
                $conf_field_cxttype,
                $conf_field_definition,
                $conf_field_issuedto,
                $conf_field_issuedon,
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
                $conf_field_cxttype,
                $conf_field_definition,
                $conf_field_issuedto,
                $conf_field_issuedon,
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
        'sf_html_id' => 'mac_cxtuserconfigfields', // Must be unique
        'script' => 'php/data_view/subforms/sf_userconfigfields.php',
        'op_label' => 'space',
        'op_input' => 'go',
        'op_modtype' => FALSE,
        'fields' => // these are the fields available to the user - only fields with 'field_id' work
            array(
                $conf_field_itemkey,
                $conf_field_cxttype,
                $conf_field_definition,
                $conf_field_issuedto,
                $conf_field_issuedon,
                $conf_field_hrusex,
                $conf_field_hruage,
                $conf_field_hrudeposition
        ),
);  
    
// XMI VIEWER STUFF
//  Any given item may be viewed in a reduced form from within another module
//  this part of the settings file describes how this module represents itself
//  when called into an XMI view

// fields as set up at the top of the settings file. here we simply call them into
// the package

$cxt_xmiconf =
    array(
        'op_xmi_hdrbar' => 'link', // we put optional stuff in here
        'op_xmi_label' => TRUE, // we put optional stuff in here                
        'fields' => 
            array(
            $conf_field_cxttype,                    
            $conf_field_definition
        )
);

?>