<?php

/*
Sample script to import old ARK config.
May require adaptation for individual ARKs.
Follow the migration guide provided for more details.

Migration steps:
- Backup ARK install, config and database
- Update the ARK code
- Create the new database tables using the supplied SQL script
- Create the new config/server.php and config/paths.php files
- Edit the existing config files as per the Requirements section below
- Copy this script to config/
- Populate $pages below with list of pages to import
- Populate $modules below with list of modules to import
- Populate other variables listed under 2.0 config
- Test run with $updates = FALSE, fix any errors reported
- Update run with $updates = TRUE
- Run config/preflight_tests.php
- Test ARK is functioning correctly
- Delete old config files, config/ should only contain server.php and paths.php

Requirements:
- All subforms must have a unique 'sf_html_id' field (preferably prefixed by the module code) which will be used as the subform_id
- All fields must have a unique 'field_id' field
- All events must have a unique 'event_id' field added which will be used as the event_id
- All validation groups must have a unique 'vld_group_id' field added which will be used as the vld_group_id, and the rules array moved into a 'rules' field
- All validation rules must have a unique 'vld_rule_id' field added which will be used as the vld_rule_id
- Any config using sf_module.php or sf_modulelist.php must have the 'fields' key listing the modules renamed to 'modules'
- Any config using sf_linklist.php must have the 'fields' key listing the links renamed to 'links'
- All links in link lists mut have a unique 'link_id' key field added and the 'href' field copied as separate 'path' and 'query' fields, these fields must be single-quoted so they are not evaluated by the import.
- Support for $conf_dat_detfrm has been dropped, any columns, subforms or fields should be used in another config or they will be discarded
- Any settings such as fields, subforms or columns that have been commented out to disable them should be uncommented to allow them to be imported, then disabled using the 'enabled' field in the database.

*/

///////////////////////////////////////////////////////////////////////////////
//                          IMPORT CONFIGURATION                             //
//       Details of the existing ARK 1.2 configuration to be imported        //
///////////////////////////////////////////////////////////////////////////////

$update = TRUE; // If database should be updated
$debug = FALSE; // If debug output should be printed

$pages = array(
    array('page' => 'user_home',         'enabled' => TRUE,  'nav_seq' => 1),
    array('page' => 'data_view',         'enabled' => TRUE,  'nav_seq' => 2),
    array('page' => 'data_entry',        'enabled' => TRUE,  'nav_seq' => 3),
    array('page' => 'micro_view',        'enabled' => TRUE,  'nav_seq' => 4),
    array('page' => 'sgr_view',          'enabled' => TRUE,  'nav_seq' => 5),
    array('page' => 'map_view',          'enabled' => TRUE,  'nav_seq' => 6),
    array('page' => 'user_admin',        'enabled' => TRUE,  'nav_seq' => 7),
    array('page' => 'alias_admin',       'enabled' => TRUE,  'nav_seq' => 8),
    array('page' => 'markup_admin',      'enabled' => TRUE,  'nav_seq' => 9),
    array('page' => 'map_admin',         'enabled' => TRUE,  'nav_seq' => 10),
    array('page' => 'import',            'enabled' => TRUE,  'nav_seq' => 11),
    array('page' => 'resultsmicro_view', 'enabled' => TRUE,  'nav_seq' => 0),
    array('page' => 'overlay_holder',    'enabled' => TRUE,  'nav_seq' => 0),
    array('page' => 'download',          'enabled' => TRUE,  'nav_seq' => 0),
    array('page' => 'feed',              'enabled' => TRUE,  'nav_seq' => 0),
    array('page' => 'transclude_object', 'enabled' => TRUE,  'nav_seq' => 0),
    array('page' => 'api',               'enabled' => TRUE,  'nav_seq' => 0),
    array('page' => 'logout',            'enabled' => TRUE,  'nav_seq' => 0),
);

$modules = array(
    array('mod' => 'abk', 'desc' => 'Address Book'),
    array('mod' => 'cxt', 'desc' => 'Context'),
    array('mod' => 'grp', 'desc' => 'Group'),
    array('mod' => 'pln', 'desc' => 'Plan'),
    array('mod' => 'rgf', 'desc' => 'Registered Find'),
    array('mod' => 'sec', 'desc' => 'Section'),
    array('mod' => 'sgr', 'desc' => 'Subgroup'),
    array('mod' => 'smp', 'desc' => 'Sample'),
    array('mod' => 'sph', 'desc' => 'Site Photo'),
    array('mod' => 'tmb', 'desc' => 'Timber'),
);

// Global subforms in page_settings.php or elsewhere that also need importing
$subforms = array(
    'conf_mac_mediabrowser',
    'conf_mac_batchfileupload',
    'conf_mcd_dnarecord',
    'conf_mcd_deleterecord',
    'conf_mcd_newstecode',
    'conf_mcd_addctrllst',
    'conf_mac_exportdownloadcsv', // mac_exportdownloadcsv
    'conf_mac_exportqgisfilter', // exportqgisfilter
    'conf_mac_exportrss', // mac_exportfeed
);

$display_errors = TRUE;
$upload_max_filesize = '10M';
$version_original = '1.2'; // The original ARK version first installed


///////////////////////////////////////////////////////////////////////////////
//                            IMPORT SCRIPT                                  //
//     Private import script settings and code, only change if required      //
///////////////////////////////////////////////////////////////////////////////

// Load the new server settings
require('server.php');

require('../vendor/autoload.php');
use LPArchaeology\ARK;

// Global database access object
$ado = new ARK\DB\ADO($sql_server, $sql_user, $sql_pwd, $ark_db);

// Config object lists
$mod_subforms = array();
$all_fields = array();
$all_events = array();
$all_links = array();
$all_vld_grps = array();
$all_vld_rules = array();

// Config Tables
$cor_conf_ark = array();
$cor_conf_page = array();
$cor_conf_page_layout = array();
$cor_conf_element = array();
$cor_conf_condition = array();
$cor_conf_group = array();
$cor_conf_subform = array();
$cor_conf_field = array();
$cor_conf_alias = array();
$cor_conf_option = array();
$cor_conf_link = array();
$cor_conf_element_vld = array();
$cor_conf_vld_group = array();
$cor_conf_vld_rule = array();

// Run Import
import();

function import()
{
    print (PHP_EOL.'*** Importing Config ***');
    importArk();
    importPages();
    importModules();
    importGlobals();
    importEvents();
    importDeleteField();
    importFields();
    importLinks();
    importValidationGroups();
    importValidationRules();
    insertTables();
    print (PHP_EOL.'*** Done ***'.PHP_EOL);
}

function importArk()
{
    global $cor_conf_ark, $display_errors, $upload_max_filesize, $version_original;
    // Import the old settings
    global $ark_root_path;
    include_once("settings.php");
    $ark['name'] = $ark_name;
    $ark['markup'] = $arkname_mk;
    $ark['site_code'] = $default_site_cd;
    $ark['display_errors'] = $display_errors;
    $ark['log_ins'] = ($log and $conf_log_add == 'on');
    $ark['log_upd'] = ($log and $conf_log_edt == 'on');
    $ark['log_del'] = ($log and $conf_log_del == 'on');
    $ark['search_mode'] = $mode;
    $ark['search_ftx_mode'] = $ftx_mode;
    if (isset($anonymous_login['username'])) {
        $ark['anon_login'] = TRUE;
        $ark['anon_user'] = $anonymous_login['username'];
    } else {
        $ark['anon_login'] = FALSE;
        $ark['anon_user'] = 'anon';
    }
    if (isset($anonymous_login['password'])) {
        $ark['anon_password'] = $anonymous_login['password'];
    } else {
        $ark['anon_password'] = 'anon';
    }
    $ark['skin'] = $skin;
    $ark['skin_mobile'] = $mobileskin;
    $ark['form_method'] = $form_method;
    $ark['language'] = $default_lang;
    $ark['arkthumb_width'] = $thumbnail_sizes['arkthumb_width'];
    $ark['arkthumb_height'] = $thumbnail_sizes['arkthumb_height'];
    $ark['webthumb_width'] = $thumbnail_sizes['webthumb_width'];
    $ark['webthumb_height'] = $thumbnail_sizes['webthumb_height'];
    $ark['max_upload_size'] = $upload_max_filesize;
    $ark['version_original'] = $version_original;
    $ark['version_database'] = '2.0';
    $cor_conf_ark[] = $ark;
}

function importPages()
{
    global $pages;
    foreach ($pages as $page) {
        importPage($page['page'], $page['enabled'], $page['nav_seq']);
    }
}

function importPage($page_id, $enabled, $nav_seq)
{
    global $mod_subforms, $ark_root_path;
    $mod_subforms = array();
    include("page_settings.php");
    $conf = ${'conf_page_'.$page_id};
    insertPage($page_id, $conf['name'], $conf['title'], $enabled, $conf['is_visible'], $conf['sgrp'], $conf['file'], $conf['cur_code_dir'], $nav_seq, $conf['navname'], $conf['navlinkvars']);

    if (isset(${$page_id.'_page_nav'})) {
        importColumnsLayout($page_id, '', 'page_nav', $conf['name'].' Page Nav', ${$page_id.'_page_nav'});
    }
    foreach ($mod_subforms as $subform) {
        importSubform('page', $subform);
    }
}

function importModules()
{
    global $modules;
    foreach ($modules as $module) {
        importModule($module['mod'], $module['desc']);
    }
}

function importModule($mod, $mod_desc)
{
    global $mod_subforms;
    $mod_subforms = array();
    include("field_settings.php");
    include("mod_{$mod}_settings.php");

    $conf_mcd_cols = ${$mod.'_conf_mcd_cols'};
    importColumnsLayout('micro_view', $mod, 'section', $mod_desc.' Record View Section', $conf_mcd_cols);
    importSingleColumnLayout('data_entry', $mod, 'section', $mod_desc.' Register Section', $conf_dat_regist);

    foreach ($mod_subforms as $subform) {
        importSubform($mod, $subform);
    }
}

function importGlobals()
{
    global $mod_subforms, $subforms, $ark_root_path;
    $mod_subforms = array();
    include("page_settings.php");

    // Import default subforms...
    //$conf_media_browser
    //$conf_batchfileupload

    // Import nav bar lists
    //$conf_entry_nav = array( 'record_nav' => $group_entry_nav, 'record_admin' => $group_entry_admin);

    $subform_confs = array();
    foreach ($subforms as $subform) {
        $subform_confs[] = ${$subform};
    }
    addSubforms($subform_confs);

    foreach ($mod_subforms as $subform) {
        importSubform('cor', $subform);
    }
}

function importColumnsLayout($page_id, $module_id, $layout_role, $desc, $conf)
{
    if (array_key_exists('layout_id', $conf)) {
        $layout_id = $conf['layout_id'];
    } else {
        $layout_id = $page_id.'_'.$module_id.'_'.$layout_role;
    }
    if (array_key_exists('mkname', $conf)) {
        $markup = $conf['mkname'];
    } else {
        $markup = NULL;
    }

    insertLayout($page_id, $module_id, $layout_role, $layout_id);
    insertElement($layout_id, 'layout', $markup, $desc.' Layout');
    insertOption($layout_id, 'op_display_type', 'string', $conf['op_display_type']);
    insertOption($layout_id, 'op_top_col', 'string', $conf['op_top_col']);

    $elem_seq = 0;
    foreach ($conf['columns'] as $column) {
        $col = $elem_seq + 1;
        if (array_key_exists('column_id', $conf)) {
            $column_id = $conf['column_id'];
        } else {
            $column_id = $layout_id.'_col_'.$col;
        }
        importColumn($layout_id, $elem_seq, $column_id, $desc.' Column '.$col, $column);
        $elem_seq = $elem_seq +1;
    }
}

function importSingleColumnLayout($page_id, $module_id, $layout_role, $desc, $conf)
{
    if ($module_id) {
        $layout_id = $page_id.'_'.$module_id.'_'.$layout_role;
    } else {
        $layout_id = $page_id.'_'.$layout_role;
    }

    insertLayout($page_id, $module_id, $layout_role, $layout_id);
    insertElement($layout_id, 'layout', NULL, $desc.' Layout');
    insertOption($layout_id, 'op_display_type', 'string', 'cols');
    insertOption($layout_id, 'op_top_col', 'string', $conf['col_id']);

    importColumn($layout_id, 0, $layout_id.'_col', $desc.' Column', $conf);
}

function importColumn($layout_id, $layout_seq, $column_id, $column_desc, $conf) {
    insertGroupElement($layout_id, $layout_seq, $column_id);
    insertElement($column_id, 'column', NULL, $column_desc);
    insertOption($column_id, 'col_id', 'string', $conf['col_id']);
    insertOption($column_id, 'col_type', 'string', $conf['col_type']);
    insertAlias($column_id, $conf['col_alias']);
    $elem_seq = 0;
    foreach ($conf['subforms'] as $subform) {
        insertGroupElement($column_id, $elem_seq, $subform['sf_html_id']);
        $elem_seq = $elem_seq + 1;
    }
    addSubforms($conf['subforms']);
}

function addSubforms($subforms) {
    global $mod_subforms;
    if (is_array($subforms)) {
        foreach ($subforms as $subform) {
            $subform_id = $subform['sf_html_id'];
            $mod_subforms[$subform_id] = $subform;
            if (array_key_exists('subforms', $subform)) {
                addSubforms($subform['subforms']);
            }
        }
    }
}

function importSubform($mod, $conf)
{
    global $cor_conf_subform;

    if (!array_key_exists('sf_html_id', $conf)) {
        print_r($conf);
        print PHP_EOL.$mod.' - No sf_html_id key!'.PHP_EOL;
        die;
    }

    $subform_id = $conf['sf_html_id'];

    insertElement($subform_id, 'subform', NULL, 'Subform '.$subform_id);

    foreach ($conf as $key => $val) {
        $elem_seq = 0;
        switch ($key) {
            case 'sf_html_id':
                $subform['subform_id'] = $val;
                break;
            case 'op_modtype':
                break;
            case 'sf_nav_type':
                $subform['nav_type'] = $val;
                break;
            case 'sf_title':
                $subform['title'] = $val;
                break;
            case 'op_label':
                $subform['label'] = $val;
                break;
            case 'op_input':
                $subform['input'] = $val;
                break;
            case 'view_state':
            case 'edit_state':
            case 'script':
                $subform[$key] = $val;
                break;

            case 'op_recursive':
            case 'op_moddif':
            case 'op_lightbox':
            case 'op_emptyfielddisp':
            case 'op_clean_headers':
                insertOption($subform_id, $key, 'bool', $val);
                break;
            case 'op_buffer':
                insertOption($subform_id, $key, 'float', $val);
                break;
            case 'op_num_rows':
            case 'op_no_rows':
                insertOption($subform_id, $key, 'int', $val);
                break;
            case 'conflict_res_sf':
            case 'op_fancylabels':
            case 'op_fancylabel_dir':
            case 'op_spantype':
            case 'xmi_mode':
            case 'xmi_mod':
            case 'op_shrgeom_spantype':
            case 'op_sf_cssclass':
            case 'op_default_dir':
            case 'op_message':
            case 'op_reg_mode':
            case 'op_copy_button':
            case 'selectInteraction':
            case 'op_xmi_sorting':
            case 'ark_page':
            case 'href':
            case 'prompt':
            case 'op_exif_map':
            case 'op_field_delimiter':
            case 'op_text_delimiter':
            case 'op_copy':
            case 'op_linktype':
            case 'op_ftr_mode':
            case 'default':
                insertOption($subform_id, $key, 'string', $val);
                break;
            case 'op_map':
                insertOption($subform_id, $key, 'smart', $val);
                break;
            case 'op_xmi_field':
            case 'op_assemblage_type':
                insertOption($subform_id, $key, 'field', $val['field_id']);
                break;

            case 'op_condition':
                $cond_seq = 0;
                foreach ($val as $cond_row) {
                    insertCondition($subform_id, $cond_seq, $cond_row['func'], $cond_row['args']);
                    $cond_seq += 1;
                }
                break;
            case 'modules':
                insertOption($subform_id, $key, 'array', $val);
                break;
            case 'subforms':
                foreach ($val as $sf_item) {
                    insertGroupElement($subform_id, $elem_seq, $sf_item['sf_html_id']);
                    $elem_seq += 1;
                }
                break;
            case 'events':
                foreach ($val as $event_conf) {
                    insertEventElement($subform_id, $elem_seq, $event_conf);
                    $elem_seq += 1;
                }
                break;
            case 'fields':
                foreach ($val as $field_item) {
                    insertFieldElement($subform_id, $elem_seq, $field_item);
                    $elem_seq += 1;
                }
                break;
            case 'links':
                foreach ($val as $link_conf) {
                    insertLinkElement($subform_id, $elem_seq, $link_conf);
                    $elem_seq += 1;
                }
                break;
            default:
                print PHP_EOL.'Import Subform '.$mod.' - '.$subform_id.' - Unknown config key '.$key.' = '.$val.PHP_EOL;
                die;
        }
    }
    $cor_conf_subform[] = $subform;
}

function importEvents()
{
    global $all_events;
    foreach ($all_events as $conf) {
        $event_id = $conf['event_id'];
        $type = $conf['type'];
        $date_conf = $conf['date'];
        $action_conf = $conf['action'];
        insertElement($event_id, 'event', NULL, 'Event '.$type);
        insertOption($event_id, 'type', 'string', $type);
        $elem_seq = 0;
        if ($date_conf) {
            insertFieldElement($event_id, $elem_seq, $date_conf);
            $elem_seq += 1;
        }
        if ($action_conf) {
            insertFieldElement($event_id, $elem_seq, $action_conf);
        }
    }
}

function importLinks()
{
    global $all_links;
    foreach ($all_links as $conf) {
        $link_id = $conf['link_id'];
        insertElement($link_id, 'link', NULL, 'Link '.$link_id);
        insertLink($link_id, $conf);
    }
}

function importDeleteField()
{
    global $all_fields;
    include("field_settings.php");
    $all_fields['conf_field_delete'] = $conf_field_delete;
}

function importFields()
{
    global $all_fields, $cor_conf_field;

    foreach ($all_fields as $field_conf) {
        $field_id = $field_conf['field_id'];
        $field = array();
        insertElement($field_id, 'field', NULL, 'Field '.$field_id);

        foreach ($field_conf as $key => $val) {
            switch ($key) {
                case 'field_id':
                case 'dataclass':
                case 'classtype':
                case 'editable':
                case 'hidden':
                    $field[$key] = $val;
                    break;

                case 'aliasinfo':
                    insertAlias($field_id, $field_conf['aliasinfo']);
                    break;

                case 'add_validation':
                    insertElementValidation($field_id, 'add', $field_conf['add_validation']);
                    break;
                case 'edt_validation':
                    insertElementValidation($field_id, 'edt', $field_conf['edt_validation']);
                    break;
                case 'del_validation':
                    insertElementValidation($field_id, 'del', $field_conf['del_validation']);
                    break;

                case 'op_display_mode':
                case 'module':
                case 'field_op_default':
                case 'datestyle':
                case 'xmi_mod':
                case 'force_var_itemkey':
                case 'op_xmi_itemkey':
                case 'op_pattern':
                case 'op_hrname':
                case 'options':
                case 'attribute':
                // Map stuff
                case 'id':
                case 'format':
                case 'layeruri':
                case 'projection':
                case 'name':
                case 'remotename':
                case 'serverType':
                case 'op_layer':
                case 'op_buffer':
                // Actor stuff
                case 'actors_mod':
                case 'actors_element':
                case 'actors_style':
                case 'actors_type':
                case 'actors_elementclass':
                case 'actors_grp':
                    insertOption($field_id, $key, 'string', $val);
                    break;
                case 'op_show_bv_aliases':
                // Map Stuff
                case 'op_zoomtolayer':
                case 'selectable':
                    insertOption($field_id, $key, 'bool', $val);
                    break;
                default:
                    print PHP_EOL.'Field '.$field_id.' - Unknown option key: '.$key.' = '.$val.PHP_EOL;
                    die;
            }
        }
        $cor_conf_field[] = $field;
    }
}

function importValidationGroups()
{
    global $all_vld_grps;
    foreach ($all_vld_grps as $vld_group_id => $vld_group_conf) {
        $rules = $vld_group_conf['rules'];
        $seq = 0;
        foreach ($rules as $rule) {
            insertValidationGroup($vld_group_id, $seq, $rule);
            $seq += 1;
        }
    }
}

function importValidationRules()
{
    global $all_vld_rules, $cor_conf_vld_rule;
    foreach ($all_vld_rules as $vld_rule_id => $vld_rule_conf) {
        $cor_conf_vld_rule[] = $vld_rule_conf;
    }
}

function insertPage($page_id, $name, $title, $enabled, $visible, $sgrp, $file, $code_dir, $nav_seq, $navname, $nav_link_vars)
{
    global $cor_conf_page;
    $page['page_id'] = $page_id;
    $page['name'] = $name;
    $page['title'] = $title;
    $page['enabled'] = $enabled;
    $page['visible'] = $visible;
    $page['sgrp'] = $sgrp;
    $page['file'] = $file;
    $page['code_dir'] = $code_dir;
    $page['nav_seq'] = $nav_seq;
    $page['navname'] = $navname;
    $page['nav_link_vars'] = $nav_link_vars;
    $cor_conf_page[] = $page;
}

function insertLayout($page_id, $module_id, $layout_role, $layout_id)
{
    global $cor_conf_page_layout;
    $layout['page_id'] = $page_id;
    $layout['module_id'] = $module_id;
    $layout['layout_role'] = $layout_role;
    $layout['layout_id'] = $layout_id;
    $cor_conf_page_layout[] = $layout;
}

function insertElement($element_id, $element_type, $markup, $description)
{
    global $cor_conf_element;
    $group['element_id'] = $element_id;
    $group['element_type'] = $element_type;
    $group['markup'] = $markup;
    $group['description'] = $description;
    $cor_conf_element[] = $group;
}

function insertOption($element_id, $option_id, $type, $value)
{
    global $cor_conf_option;
    if ($element_id == NULL or $element_id == '' or $option_id == NULL or $option_id == '') {
        print(PHP_EOL.'Invalid option '.$element_id.' '.$option_id.' '.$value.PHP_EOL);
        die;
    } else if ($type == 'field' or $type = 'smart') {
        $noop = '';
    } else if (gettype($value) != $type) {
        print(PHP_EOL.'Invalid option, value is not of expected type: '.$element_id.' '.$option_id.' '.$value.PHP_EOL);
        die;
    }
    $option['element_id'] = $element_id;
    $option['option_id'] = $option_id;
    $option['type'] = '';
    if ($type == 'field') {
        $option['type'] = 'field';
        $option['value'] = (string)$value;
    } else if ($type == 'smart' and !$value) {
        $option['value'] = serialize(NULL);
    } else {
        $option['value'] = serialize($value);
    }
    $cor_conf_option[] = $option;
}

function insertCondition($element_id, $seq, $func, $args)
{
    global $cor_conf_condition;
    $cond['element_id'] = $element_id;
    $cond['seq'] = $seq;
    $cond['func'] = $func;
    $cond['args'] = $args;
    $cor_conf_condition[] = $cond;
}

function insertFieldElement($element_id, $seq, $conf)
{
    global $all_fields;
    $field_id = $conf['field_id'];
    $all_fields[$field_id] = $conf;
    insertGroupElement($element_id, $seq, $field_id);
}

function insertEventElement($element_id, $seq, $conf)
{
    global $all_events;
    $event_id = $conf['event_id'];
    $all_events[$event_id] = $conf;
    insertGroupElement($element_id, $seq, $event_id);
}

function insertLinkElement($element_id, $seq, $conf)
{
    global $all_links;
    $link_id = $conf['link_id'];
    $all_links[$link_id] = $conf;
    insertGroupElement($element_id, $seq, $link_id);
}

function insertGroupElement($element_id, $seq, $child_id)
{
    global $cor_conf_group;
    $group['element_id'] = $element_id;
    $group['seq'] = $seq;
    $group['enabled'] = TRUE;
    $group['child_id'] = $child_id;
    $cor_conf_group[] = $group;
}

function insertAlias($element_id, $aliasinfo)
{
    global $cor_conf_alias;
    if (!$element_id or !is_array($aliasinfo)) {
        return;
    }
    $alias['element_id'] = $element_id;
    $alias['tbl'] = $aliasinfo['alias_tbl'];
    $alias['col'] = $aliasinfo['alias_col'];
    $alias['src_key'] = $aliasinfo['alias_src_key'];
    $alias['type'] = $aliasinfo['alias_type'];
    if (array_key_exists('alias_lang', $aliasinfo)) {
        $alias['lang'] = $aliasinfo['alias_lang'];
    }
    $cor_conf_alias[] = $alias;
}

function insertElementValidation($element_id, $vld_role, $vld_group)
{
    if ($vld_group == 'none') {
        return;
    }
    global $cor_conf_element_vld, $all_vld_grps;
    $vld_group_id = $vld_group['vld_group_id'];
    $field_val['element_id'] = $element_id;
    $field_val['vld_role'] = $vld_role;
    $field_val['vld_group_id'] = $vld_group_id;
    $cor_conf_element_vld[] = $field_val;
    $all_vld_grps[$vld_group_id] = $vld_group;
}

function insertValidationGroup($vld_group_id, $seq, $vld_rule_conf)
{
    global $cor_conf_vld_group, $all_vld_rules;
    $vld_rule_id = $vld_rule_conf['vld_rule_id'];
    $vld_grp['vld_group_id'] = $vld_group_id;
    $vld_grp['seq'] = $seq;
    $vld_grp['vld_rule_id'] = $vld_rule_id;
    $cor_conf_vld_group[] = $vld_grp;
    $all_vld_rules[$vld_rule_id] = $vld_rule_conf;
}

function insertLink($link_id, $conf)
{
    global $cor_conf_link;
    $link['link_id'] = $link_id;
    setField($link, 'type', $conf, 'type');
    setField($link, 'name', $conf, 'name');
    setField($link, 'markup', $conf, 'mkname');
    setField($link, 'title', $conf, 'title');
    setField($link, 'link_class', $conf, 'css_class');
    setField($link, 'img_class', $conf, 'img_class');
    setField($link, 'list_class', $conf, 'list_class');
    setBooleanField($link, 'lightbox', $conf, 'lightbox', false);
    setField($link, 'image', $conf, 'img');
    setField($link, 'page', $conf, 'page');
    setField($link, 'reload_page', $conf, 'reload_page');
    serializeField($link, 'query', $conf, 'query', array());
    setField($link, 'link', $conf, 'link');
    $cor_conf_link[] = $link;
}

function setField(&$dest, $dest_key, &$src, $src_key, $default=NULL)
{
    if (array_key_exists($src_key, $src)) {
        $dest[$dest_key] = $src[$src_key];
    } else if ($default != NULL) {
        $dest[$dest_key] = $default;
    }
}

function serializeField(&$dest, $dest_key, &$src, $src_key, $default=NULL)
{
    if (array_key_exists($src_key, $src)) {
        $dest[$dest_key] = serialize($src[$src_key]);
    } else if ($default != NULL) {
        $dest[$dest_key] = serialize($default);
    }
}

function setBooleanField(&$dest, $dest_key, &$src, $src_key, $default=NULL)
{
    if (array_key_exists($src_key, $src)) {
        $dest[$dest_key] = (boolean)$src[$src_key];
    } else if ($default != NULL) {
        $dest[$dest_key] = (boolean)$default;
    }
}

function insertTables()
{
    insertTable('cor_conf_ark');
    insertTable('cor_conf_page');
    insertTable('cor_conf_page_layout');
    insertTable('cor_conf_element');
    insertTable('cor_conf_condition');
    insertTable('cor_conf_group');
    insertTable('cor_conf_subform');
    insertTable('cor_conf_field');
    insertTable('cor_conf_alias');
    insertTable('cor_conf_option');
    insertTable('cor_conf_element_vld');
    insertTable('cor_conf_vld_group');
    insertTable('cor_conf_vld_rule');
    insertTable('cor_conf_link');
}

function insertTable($table)
{
    global $update, $debug, $ado, $$table;
    $rows = $$table;
    print(PHP_EOL.'Insert to table '.$table.' row count '.count($rows).PHP_EOL);
    if ($debug) {
        print(PHP_EOL.$table);
        print_r($rows);
        print(PHP_EOL);
    }
    if ($update) {
        $ado->clear($table);
        if (count($rows) <= 0) {
            print(PHP_EOL.' - No rows to insert');
            return;
        }
        // prepare the SQL statement
        $cre_on = $ado->timestamp('NOW()');
        foreach ($rows as $row) {
            $fields = array();
            $values = array();
            foreach ($row as $field => $value) {
                $fields[] = $field;
                $values[] = $value;
            }
            $result = $ado->insert($table, $fields, $values, 'config', 'import', $cre_on, 'import');
            if (!$result['success']) {
                print(PHP_EOL);
                if ($debug) {
                    print_r($result['sql']);
                    print_r($result['sql']->errorInfo());
                    print(PHP_EOL.'Fields ='.PHP_EOL);
                    print_r($fields);
                    print(PHP_EOL.'Values ='.PHP_EOL);
                    print_r($values);
                }
                //die;
            }
        }
        print(' - OK'.PHP_EOL);
    } else {
        print(' - Updates disabled'.PHP_EOL);
    }
}

?>
