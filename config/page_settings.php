<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* config/page_settings.php
*
* Page specific settings file for this version of ARK
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
* @author     Andy Dufton <a.dufton@lparchaeology.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2012 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/config/page_settings.php
* @since      File available since Release 1.0
*/

/**  NAVIGATION PAGES
*   All top-level pages are stored in the root of the ARK directory
*   Pages listed in this array will appear in the main nav
*/

$conf_pages =
    array(
        'user_home',
        'user_admin',
        'data_entry',
        'data_view',
        'micro_view',
        'alias_admin',
        'markup_admin',
        'import',
        'map_view',
        'resultsmicro_view',
        'overlay_holder',
        'download',
        'feed',
        'transclude_object',
        'chaintable',
        'api',
);

// -- NAV LINKS -- //
// these links will appear in the end of the navbar
$conf_linklist =
    array(
        'file' => 'map_view.php',
        'vars' => 'view=atlas',
        'label' => 'atlas'
);

// List the modules that need to be loaded in this ARK project
$loaded_modules = 
    array(
        'abk',
        'loc',
        'pho',
        'cat',
        'ill',
        'exc',
);
    
// If using mapping, list the modules to load maps for
$loaded_map_modules = 
     array(
         'loc',
);

//  The default item key for this instance of Ark.
$default_itemkey = 'loc_cd';

// -- DEFAULT VIEWERS -- //


// Default $output_mode for the data viewer
$default_output_mode = 'tbl';

/** GLOBAL SUBFORMS
*   Inclusion of subforms for editing record key, deleting records, changing
*   modtypes can be used in multiple pages and are included here rather than
*   in each mod settings
*/

// Default subform configuration for the media browser
$conf_media_browser = 'conf_mac_mediabrowser';
// Setup file media browser
$conf_mac_mediabrowser =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'media_uploader',
        'sf_html_id' => 'mac_mediabrowser', // Must be unique
        'script' => 'php/subforms/sf_mediabrowser.php',
        'op_label' => 'save',
        'op_input' => 'go',
        'op_exif_map' => 'basic'
);

$conf_mac_irodsupload =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'irods_upload', 
        'sf_html_id' => 'irods_upload', // Must be unique
        'script' => 'php/subforms/sf_irodsupload.php',
        // see https://wiki.irods.org/prods_doc/Prods/tutorial_Prods.pkg.html for 
        // documentation on how this works - you will need an irods installation
        // running somewhere else
       // these vaules will be used by ARK to to run the connection function
        'irods_info' => array (
            'irods_webserver' => 'http://%your_irods_url%',           
            'irods_account' => '%server_for_rods_account%',
            'irods_path' => '%the_path_to_your_folder%',
            'irods_user' => '%username%',
            'irods_pwd' => '%passwords%'
        ),
        'op_label' => 'prepfeed',
        'op_input' => 'go',
);

// Default subform configuration for batch file uploads
$conf_batchfileupload = 'conf_mac_irodsupload';
// Setup batch file uploader
$conf_mac_batchfileupload =
    array(
    'view_state' => 'max',
    'edit_state' => 'view',
    'sf_nav_type' => 'none',
    'sf_title' => 'batch_file_upload', 
    'sf_html_id' => 'batch_file_upload', // Must be unique
    'script' => 'php/subforms/sf_batchfileupload.php',
    'op_label' => 'upload',
    'op_input' => 'go',
);


// Subform for the batch file upload  ---- took this from Chers. 
$conf_mac_irodsupload =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'irods_upload', 
        'sf_html_id' => 'irods_upload', // Must be unique
        'script' => 'php/subforms/sf_irodsupload.php',
        'irods_info' => array (
            'irods_webserver' => 'http://web.corral.tacc.utexas.edu/web/',           
            'irods_account' => 'icat.corral.tacc.utexas.edu',
            'irods_path' => '/corralZ/web/',
            'irods_user' => 'trelogan',
            'irods_pwd' => 'FranceBank3928'
        ),
        'op_label' => 'prepfeed',
        'op_input' => 'go',
);

// Setup delete and edit and delete itemval subforms

$conf_mcd_dnarecord =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'dnarecord', 
        'sf_html_id' => 'dna_record', // Must be unique
        'script' => 'php/subforms/sf_dnarecord.php',
        'fields' =>
            array(
        )
);

$conf_mcd_deleterecord =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'delete_record', 
        'sf_html_id' => 'delete_record', // Must be unique
        'script' => 'php/subforms/sf_delete_record.php',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'conflict_res_sf' => 'conf_mcd_dnarecord',
        'fields' =>
            array(
        )
);


/**  USER HOME
*   These settings control the subforms and left panel in the user home
*   The user home needs configuration both for the left panel and for
*   the subforms included in the main area
*/

// PAGE SETTINGS
$conf_page_user_home =
    array(
        'name' =>'User Home',
        'title' => 'User Home Page',
        'file' => 'user_home.php',
        'sgrp' => '1',
        'navname' => 'userhomenav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'php/user_home/',
        'is_visible' => TRUE
);

// LEFT PANEL
// Choose the type of output for the left panel (subforms or linklist)
$uhlpoutput = 'subforms';

// Configure the linklist for the left panel
// (Using subforms for this panel, thus no linklist needed)

// Configure the subforms for the left panel
$uhlp_subform_module =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'mvlpmodlist', 
        'sf_html_id' => 'mvlpmodlist', // Must be unique
        'script' => 'php/subforms/sf_module.php',
        'ark_page'=> 'user_home',
        'fields' => array (
                    'abk',
                    'loc',
                    'cat',
                    'pho',
                    'ill',
                    'exc',
                )
); 

// Group these subforms together into a single left panel array
$user_home_left_panel =
    array(
        'col_id' => 'mvlp',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' =>
            array(
                $uhlp_subform_module
        )
);

/**  MAIN PANEL
*
* settings for the main panel of the user home
*
* Essentially the user home is dealt with in the same way as the micro view
* only using a single settings file (not module specific).
* The page makes use of a series of configured subforms then assembled into
* columns according to this settings file.
*/

// FIELDS SETUP- THIS IS NEEDED FOR A RECORD JUMPER SUBFORM
// NB if using the 'live' mode for jumpers, only one module can be included here
$jumper_list_home[] = 
    array(
        'mode' => 'live',
        'button' => 'go',
        'item_key' => 'loc_cd',
        'default' => FALSE,
        'link' => 'micro_view.php',
);

// SUBFORMS SETUP
// subform for user saved filters
$userhome_my_saved_filters =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'savedfilters',
        'sf_html_id' => 'uhlp_saved_filters', // Must be unique
        'script' => 'php/subforms/sf_mysavedstuff.php',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
    );

$userhome_jumper =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'jumper',
        'sf_html_id' => 'uh_jumper', // Must be unique
        'script' => 'php/subforms/sf_jumper.php',
        'op_sf_cssclass' => 'basic_subform',
        'fields' => $jumper_list_home,
    );

// COLUMNS SETUP
/** Now make up the columns
* The following variables are used here
* col_id = only one column (main_column, second_column)
* col_alias = does column have an alias (FALSE/TRUE)
* col_type = type of column (primary_col, secondary_col)
* subforms = subforms to add to colums
*/

$conf_mcd_col_1 =
    array(
        'col_id' => 'main_column',
        'col_alias' => FALSE,
        'col_type' => 'secondary_col',
        'subforms' => 
            array(
                $userhome_jumper,
                $userhome_my_saved_filters,
            ),
    );

$conf_mcd_col_2 =
    array(
        'col_id' => 'second_column',
        'col_alias' => FALSE,
        'col_type' => 'secondary_col',
        'subforms' => 
            array(
            ),
    );

// COLUMNS PACKAGE
/** Now make up the columns package
* The following variables are used here
* op_display_type = how to display the columns (cols)
* op_top_col = which column is first (main_column)
* columns = array with columns in the order they appear
*/

$userhome_conf_mcd_cols =
    array(
        'op_display_type' => 'cols',
        'op_top_col' => 'main_column',
        'columns' =>
            array(
                $conf_mcd_col_1,
                $conf_mcd_col_2,
        )
);


/**  DATA ENTRY
*   These settings configure the data entry page
*   The data entry requires configuration for both the left panel
*   and the record navigation bar appearing at the top of the main area
*   Further options for advanced file upload are also included below
*/

// PAGE SETTINGS
$conf_page_data_entry =
    array(
        'name' =>'Data Entry',
        'title' => 'Data Entry Page',
        'file' => 'data_entry.php',
        'sgrp' => '1',
        'navname' => 'dataentrynav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'php/data_entry/',
        'is_visible' => TRUE
);

// MINIMISER OPTION
// Set to on if you want to use the data entry 'minimiser' tool
// This tool condenses subforms and offers quick nav in left panel
$minimiser = TRUE;

// GLOBAL SUBFORMS
// These global subforms are for overlay options

// To add a new locationcode
$conf_mcd_newstecode =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'newstecode',
        'sf_html_id' => 'newstecode', // Must be unique
        'script' => 'php/subforms/sf_ste_code.php',
        'fields' =>
            array(
            ),
    );

// To add to a control list
$conf_mcd_addctrllst =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'ctrllst', 
        'sf_html_id' => 'ctrllst', // Must be unique
        'script' => 'php/subforms/sf_ctrl_lst.php',
        'fields' =>
            array(
            ),
    );

// LEFT PANEL
// Choose the type of output for the left panel (subforms or linklist)

$delpoutput = 'subforms';
    
// Configure the linklist for the left panel
// In this example the linklist will be pulled in a sf_linklist, below
// and so links are still needed even using 'subforms' option above
$link_list_admin[] = 
    array(
        'href' => "{$_SERVER['PHP_SELF']}?view=files",
        'mknname' => 'uplfile',
        'img' => 'bigplus.png',
        'css_class' => FALSE,
        'lightbox' => FALSE,
);

// Now configure the subforms to appear in the left panel
$delp_subform_module =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'delpmodlist', 
        'sf_html_id' => 'delpmodlist', // Must be unique
        'script' => 'php/subforms/sf_module.php',
        'ark_page'=> 'data_entry',
        'fields' =>
            array(
                'loc',
                'cat',
                'pho',
                'ill',
                'exc',
        )
);

$delp_subform_admin =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'delpadmin', 
        'sf_html_id' => 'delpadmin', // Must be unique
        'script' => 'php/subforms/sf_linklist.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'op_linktype' => 'icon',
        'op_sf_cssclass' => 'module_list',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'fields' => $link_list_admin
);

// Now package these subforms into an array for the left panel
$data_entry_left_panel =
    array(
        'col_id' => 'delp',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' =>
            array(
                $delp_subform_module,
                $delp_subform_admin
        )
);

// RECORD TOOLBAR
// Controls what navigation and options appear in data entry record toolbar
// First form your buttons into groups and then put them into the conf array

// Navigation options
$group_entry_nav[] =
    array(
        'name' => 'prev',
        'title' => FALSE,
        'type' => 'text',
        'href' => "",
        'css_class' => FALSE,
        'mkname' => 'prev',
        'lightbox' => FALSE,
        'reloadpage' => FALSE,
);
$group_entry_nav[] =
    array(
        'name' => 'ste_cd',
        'title' => FALSE,
        'type' => 'text',
        'href' => "",
        'css_class' => FALSE,
        'mkname' => 'ste_cd',
        'lightbox' => FALSE,
        'reloadpage' => FALSE,
);
$group_entry_nav[] =
    array(
        'name' => 'current',
        'title' => FALSE,
        'type' => 'text',
        'href' => "",
        'css_class' => FALSE,
        'mkname' => 'current',
        'lightbox' => FALSE,
        'reloadpage' => FALSE,
);
$group_entry_nav[] =
    array(
        'name' => 'modtype',
        'title' => FALSE,
        'type' => 'text',
        'href' => "",
        'css_class' => FALSE,
        'mkname' => 'modtype',
        'lightbox' => FALSE,
        'reloadpage' => FALSE,
);
$group_entry_nav[] =
    array(
        'name' => 'next',
        'title' => FALSE,
        'type' => 'text',
        'href' => "",
        'css_class' => FALSE,
        'mkname' => 'next',
        'lightbox' => FALSE,
        'reloadpage' => FALSE,
);
// Administrative options
$group_entry_admin[] =
    array(
        'name' => 'tools',  
        'title' => 'addctrllst',
        'type' => 'img',
        'href' => "overlay_holder.php?sf_conf=conf_mcd_addctrllst&amp;lboxreload=0",
        'css_class' => 'gears colorbox',
        'mkname' => FALSE,
        'lightbox' => 'lightbox|200',
        'reloadpage' => 'data_entry.php',
);
$group_entry_admin[] =
    array(
        'name' => 'delete',
        'title' => 'delete',
        'type' => 'img',
        'href' => FALSE,
        'css_class' => 'delimg',
        'mkname' => 'del',
        'lightbox' => 'lightbox|200',
        'reloadpage' => 'data_entry.php',
);
$group_entry_admin[] =
    array(
        'name' => 'changemod',
        'title' => 'changemod',
        'type' => 'text',
        'href' => FALSE,
        'css_class' => 'recedit',
        'mkname' => 'chngmod',
        'lightbox' => 'lightbox|200',
        'reloadpage' => 'data_entry.php',
);
$group_entry_admin[] =
    array(
        'name' => 'changeval',
        'title' => 'changeval',
        'type' => 'text',
        'href' => FALSE,
        'css_class' => 'recedit',
        'mkname' => 'DEL',
        'lightbox' => 'lightbox|200',
        'reloadpage' => 'data_entry.php',
);
// Now package these groups of options up into a toolbar
$conf_entry_nav =
    array(
        'record_nav' => $group_entry_nav,
        'record_admin' => $group_entry_admin,
);

/**  ADVANCED FILE UPLOAD
*   if 'on' => TRUE advanced file upload dialog is displayed
*   'pattern' -  pattern as regular expression
*   some example expressions:
*   'pattern' => "/\b[a-zA-Z]*\-(([0-9]*)|(([0-9]*)-[a-zA-Z0-9]*))\.[a-zA-Z]{2,4}\b/i" 
*   handles following files xxx-1234.jpg, xxx-1234-yyy.jpg, where xxx can be any letter and yyy any alphanumeric combination
*   'pattern' => "/\bMUS\-(([0-9]*)|(([0-9]*)-[a-zA-Z0-9]*))\.[a-zA-Z]{2,4}\b/i" 
*   handles following files MUS-1234.jpg, MUS-1234-yyy.jpg, where yyy can be any alphanumeric combination
*   NB! only number after first '-' is used as an ID
*/

/**
*
*$fu =
*    array(
*     'on' => TRUE,
*     'pattern' => "/\b[a-zA-Z]*\-(([0-9]*)|(([0-9]*)-[a-z0-9A-Z]*))\.[a-z0-9]{2,4}\b/i", 
*);
*/
$fu =
    array(
     'on' => TRUE,
     'pattern' =>
         array(
             'letternamingconv' => "/\b[a-zA-Z]*\-(([0-9]*)|(([0-9]*)-[a-z0-9A-Z]*))\.[a-z0-9]{2,4}\b/i",
             'reportnamingconv' => "/\b[a-zA-Z]*\-(([0-9]*)|(([0-9]*)-[a-z0-9A-Z]*))\.[a-z0-9]{2,4}\b/i",
             'sfi_namingconv' => "/([a-zA-Z]{2}[0-9]{2}[a-zA-Z]{2})_([0-9]{1,4})/", //sfi_CH01PA_8_A2_m.JPG = chers object photo naming convention, matched to sfi module, which has item keys like: CH01PA_8

            //'pz_ophnamingconv' => "BLAHBLAHBLAH" //PZ75_619M_b6_p37_f16_M.tif  = PZ object photo naming convention; match to lot that has item key like PZ_75.0619

            ),
            //'debug_mode' => TRUE
           // 'pattern' => "/\bMUS-([0-9]*)\.[a-z0-9]{2,4}\b/i",
);

/**  DATA VIEW (SEARCH)
*   These settings configure the data view (or search) page
*   The data view requires configuration for the left panel,
*   the search tools options (results views, download options, etc)
*   as well as some general settings for search results
*/

// PAGE SETTINGS
$conf_page_data_view =
    array(
        'name' =>'Search',
        'title' => 'Search Page',
        'file' => 'data_view.php',
        'sgrp' => '3',
        'navname' => 'searchnav',
        'navlinkvars' => '',
        'cur_code_dir' => 'php/data_view/',
        'is_visible' => TRUE
);

// GENERAL SETTINGS
// Number of rows to display on the data viewer
$conf_viewer_rows = 25;
// Number of pages to display on the data viewer
$conf_num_res_pgs = 5; // best choose an odd number
// Default data viewer page
$conf_data_viewer = $ark_dir."data_view.php";
// Default feed viewer page
$conf_feed_viewer = $ark_dir."feed.php";
// Default search page - search functions will send data thru to this page
$conf_search_viewer = $ark_dir."data_view.php";
// no traverse
$conf_dv_traverse_to = FALSE;


// GLOBAL SUBFORMS
// To export to CSV files
$conf_mac_exportdownloadcsv =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'exportdownloadcsv', 
        'sf_html_id' => 'mac_cxtexportdownloadcsv', // Must be unique
        'script' => 'php/data_view/subforms/sf_exportdownload.php',
        'op_label' => 'prepdl',
        'op_input' => 'go',
        'op_modtype' => FALSE,
        'op_field_delimiter' => ',',
        'op_text_delimiter' => '"',
        'op_clean_headers' => TRUE //use this to force GIS friendly headers
);

// Subform for feed builder
$conf_mac_exportrss =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'exportfeed', 
        'sf_html_id' => 'mac_exportfeed', // Must be unique
        'script' => 'php/data_view/subforms/sf_feedbuilder.php',
        'op_label' => 'prepfeed',
        'op_input' => 'go',
);

// Subform for feed builder
$conf_mac_edit_multi =
    array(
        'view_state' => 'max',
        'edit_state' => 'edit',
        'sf_nav_type' => 'none',
        'sf_title' => 'edit_multi', 
        'sf_html_id' => 'mac_exportfeed', // Must be unique
        'script' => 'php/subforms/sf_edit_multi.php',
        'op_input' => 'go',
);

// GENERAL PAGE SETTINGS
// Number of rows to display on the data viewer
$conf_viewer_rows = 25;
// Number of pages to display on the data viewer
$conf_num_res_pgs = 5; // best choose an odd number
// Default data viewer page
$conf_data_viewer = $ark_dir."data_view.php";
// Default search page - search funtions will send data thru to this page
$conf_search_viewer = $ark_dir."data_view.php";
// Default $output_mode for the data viewer (table, text, map, thumbs)
$default_output_mode = 'table';

// LEFT PANEL
// The left panel for filters is a series of complex subforms

// Linklist for standard item filters
$link_list_stditem[] =
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftype=key&amp;key=1&amp;ftr_id=new", 
        'mknname' => 'filterabk',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);
$link_list_stditem[] =
array(
                'href' => "{$_SERVER['PHP_SELF']}?ftype=key&amp;key=3&amp;ftr_id=new",
                'mknname' => 'filterloc',
                'img' => 'view_mag.png',
                'lightbox' => FALSE,
                'css_class' => FALSE
);
$link_list_stditem[] =
array(
                'href' => "{$_SERVER['PHP_SELF']}?ftype=key&amp;key=4&amp;ftr_id=new",
                'mknname' => 'filtercat',
                'img' => 'view_mag.png',
                'lightbox' => FALSE,
                'css_class' => FALSE
);
$link_list_stditem[] =
array(
                'href' => "{$_SERVER['PHP_SELF']}?ftype=key&amp;key=16&amp;ftr_id=new",
                'mknname' => 'filterpho',
                'img' => 'view_mag.png',
                'lightbox' => FALSE,
                'css_class' => FALSE
);
$link_list_stditem[] =
array(
                'href' => "{$_SERVER['PHP_SELF']}?ftype=key&amp;key=17&amp;ftr_id=new",
                'mknname' => 'filterill',
                'img' => 'view_mag.png',
                'lightbox' => FALSE,
                'css_class' => FALSE
);
// Linklist for standard level criteria
$link_list_stdcriteria[] =
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftype=atr&amp;atrtype=6&amp;bv=1&amp;ftr_id=new", 
        'mknname' => 'ftr_vist_year',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);
$link_list_stdcriteria[] =
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftype=atr&amp;atrtype=8&amp;bv=1&amp;ftr_id=new", 
        'mknname' => 'ftr_land_use',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);
$link_list_stdcriteria[] =
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftype=atr&amp;atrtype=1&amp;bv=1&amp;ftr_id=new", 
        'mknname' => 'ftr_site_type',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);
$link_list_stdcriteria[] =
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftype=atr&amp;atrtype=12&amp;bv=1&amp;ftr_id=new", 
        'mknname' => 'ftr_site_period',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);
// Subform to hold standard item linklist
$dvlp_subform_stditem =
    array(
        'view_state' => 'min',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'dvlp_searchitems', 
        'sf_html_id' => 'dvlp_filters', // Must be unique
        'script' => 'php/subforms/sf_linklist.php',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        // Does the linklist use an icon instead of a label as link
        'op_linktype' => 'link',
        'op_sf_cssclass' => 'ftr_list',
        'fields' => $link_list_stditem
);
// Subform to hold standard criteria linklist
$dvlp_subform_stdcriteria =
    array(
        'view_state' => 'min',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'dvlp_searchcriteria', 
        'sf_html_id' => 'dvlp_filters', // Must be unique
        'script' => 'php/subforms/sf_linklist.php',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        // Does the linklist use an icon instead of a label as link
        'op_linktype' => 'link',
        'op_sf_cssclass' => 'ftr_list',
        'fields' => $link_list_stdcriteria
);

// A linklist to hold different (more raw) filters for advanced users
$link_list_advfilters[] =
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftype=key&amp;ftr_id=new", 
        'mknname' => 'filteritem',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);
$link_list_advfilters[] =
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftype=atr&amp;ftr_id=new", 
        'mknname' => 'filteratt',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);
$link_list_advfilters[] =
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftype=action&amp;ftr_id=new", 
        'mknname' => 'filteractor',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);
$link_list_advfilters[] =
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftype=ftx&amp;ftr_id=new", 
        'mknname' => 'ftx',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);

// Subform to hold a list of raw filters
$dvlp_subform_advfilters =
    array(
        'view_state' => 'min',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'dvlp_filters', 
        'sf_html_id' => 'dvlp_filters', // Must be unique
        'script' => 'php/subforms/sf_linklist.php',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        // Does the linklist use an icon instead of a label as link
        'op_linktype' => 'label',
        'op_sf_cssclass' => 'ftr_list',
        'fields' => $link_list_advfilters
);

// Subform for the filter builder to run in the left panel
$dvlp_filter_builder =
    array(
        'view_state' => 'min',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'dvlp_filters', 
        'sf_html_id' => 'dvlp_filters', // Must be unique
        'script' => 'php/data_view/subforms/sf_buildfilter.php',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        // Does the linklist use an icon instead of a label as link
        'op_sf_cssclass' => 'ftr_subform',
        'op_condition' =>
            array(
                array(
                    'func'=> 'chkTmpFtr',
                    'args'=> FALSE
            ), 
        ),
);

// Subform for the filter builder in an overlay (no condition)
$dvlp_overlay_filter_builder =
    array(
        'view_state' => 'min',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'dvlp_filters', 
        'sf_html_id' => 'dvlp_filter_builder', // Must be unique
        'script' => 'php/data_view/subforms/sf_buildfilter.php',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        // Does the linklist use an icon instead of a label as link
        'op_sf_cssclass' => 'ftr_subform',
);

// Subform for user saved filters
$dvlp_my_saved_filters =
    array(
        'view_state' => 'min',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'savedfilters', 
        'sf_html_id' => 'dvlp_saved_filters', // Must be unique
        'script' => 'php/subforms/sf_mysavedstuff.php',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        'op_sf_cssclass' => 'saved_ftr',
);

// Make a column to hold the subforms
$data_view_left_panel =
    array(
        'col_id' => 'dvlp',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'basic_subforms' =>
            array(
        ),
        'standard_subforms' =>
            array(
                $dvlp_filter_builder,
                $dvlp_subform_stditem,
                $dvlp_subform_stdcriteria,
        ),
        'adv_subforms' =>
            array(
                $dvlp_filter_builder,
                $dvlp_subform_advfilters,
        ),
        'op_dr_subforms' =>
            array(
                $dvlp_my_saved_filters,
        ),
);

// RESULTS TOOLBAR
// Controls what navigation and options appear in data entry record toolbar
// First form your buttons into groups and then put them into the conf array

// Tools
$group_tools[] =
    array(
        'type' => 'img',
        'href' => "overlay_holder.php?sf_conf=conf_mac_userconfigfields&amp;lboxreload=1",
        'css_class' => 'gears colorbox',
        'mkname' => FALSE,
        'lightbox' => 'lightbox',
        'title' => 'configfields',
        'reloadpage' => FALSE,
);


// Display options
$res = "results_mode=disp";
$group_disp[] =
    array(
        'type' => 'img',
        'href' => "{$_SERVER['PHP_SELF']}?$res&amp;disp_mode=text",
        'css_class' => 'text',
        'mkname' => FALSE,
        'lightbox' => FALSE,
        'title' => 'vwtext',  
        'reloadpage' => FALSE,
);
$group_disp[] =
    array(
        'type' => 'img',
        'href' => "{$_SERVER['PHP_SELF']}?$res&amp;disp_mode=table",
        'css_class' => 'table',
        'mkname' => FALSE,
        'lightbox' => FALSE,
        'title' => 'vwtbl',
        'reloadpage' => FALSE,
);
$group_disp[] =
    array(
        'type' => 'img',
        'href' => "{$_SERVER['PHP_SELF']}?$res&amp;disp_mode=thumb",
        'css_class' => 'thumb',
        'mkname' => FALSE,
        'lightbox' => FALSE,
        'title' => 'vwthumb',
        'reloadpage' => FALSE,
);
$group_disp[] =
    array(
        'type' => 'img',
        'href' => "{$_SERVER['PHP_SELF']}?$res&amp;disp_mode=map",
        'css_class' => 'map',
        'mkname' => FALSE,
        'lightbox' => FALSE,
        'title' => 'vwmap',
        'reloadpage' => FALSE,
);
$group_disp[] =
    array(
        'type' => 'newpage',
        'href' => "resultsmicro_view.php?",
        'css_class' => 'printall',
        'mkname' => FALSE,
        'lightbox' => FALSE,
        'title' => 'vwall',
        'reloadpage' => FALSE,
);

// Result Feeds
$res = "results_mode=feed";
$group_feeds[] =
     array(
         'type' => 'text',
         'href' => "overlay_holder.php?$res&amp;feed_mode=RSS&amp;lboxreload=1&amp;sf_conf=conf_mac_exportrss",
         'css_class' => FALSE,
         'mkname' => 'rss',
         'lightbox' => 'lightbox|300',
         'title' => 'rss',
);

// Downloads
$res = "results_mode=dl";
$group_dls[] =
    array(
        'type' => 'text',
        'href' => "overlay_holder.php?$res&amp;dl_mode=csv&amp;lboxreload=1&amp;sf_conf=conf_mac_exportdownloadcsv",
        'css_class' => FALSE,
        'mkname' => 'csv',
        'lightbox' => 'lightbox|200',
        'title' => 'expcsv',
        'reloadpage' => FALSE,
);

// Edit
$group_edit[] =
    array(
        'type' => 'text',
        'href' => "overlay_holder.php",
        'css_class' => 'editbtn',
        'mkname' => 'edit',
        'lightbox' => 'lightbox|200',
        'title' => 'edit',
        'reloadpage' => FALSE,
);

$group_select[] =
    array(
        'type' => 'text',
        'href' => "",
        'css_class' => FALSE,
        'mkname' => 'selectall',
        'lightbox' => FALSE,
        'title' => 'selectall',
        'reloadpage' => FALSE,
);

// Package these button groups up into a toolbar
$conf_results_nav =
    array(
        'tools' => $group_tools,
        'result_views' => $group_disp,
        'result_feeds' => $group_feeds,
        'result_downloads' => $group_dls,
        'result_edit' => $group_edit,
        'result_select' => $group_select,
);

/**  MICRO VIEW (RECORD VIEW)
*   These settings configure the micro view (or record view) page
*   The micro view requires configuration for the left panel,
*   and record nav options as well as some general settings
*/

// PAGE SETTINGS
$conf_page_micro_view =
    array(
        'name' =>'Record View',
        'title' => 'Record View Page',
        'file' => 'micro_view.php',
        'sgrp' => '3',
        'navname' => 'recordviewnav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'php/micro_view/',
        'is_visible' => TRUE
);

// GENERAL SETTINGS
// Default Micro viewer page (used by search result handlers)
$conf_micro_viewer = $ark_dir."micro_view.php";

// LEFT PANEL
// Choose the type of output for the left panel (subforms or linklist)
$mvlpoutput = 'subforms';

// Configure the linklist for the left panel
// (Using subforms for this panel, no linklist needed)

// Configure the subforms for the left panel
$mvlp_subform_module =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'mvlpmodlist', 
        'sf_html_id' => 'mvlpmodlist', // Must be unique
        'script' => 'php/subforms/sf_module.php',
        'ark_page'=> 'micro_view',
        'fields' =>
            array (
                'loc',
                'cat',
                'pho',
                'ill',
                'exc',
        )
);

// Group these subforms into a column array
$micro_view_left_panel =
    array(
        'col_id' => 'mvlp',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' =>
            array(
                $mvlp_subform_module
        )
);

// RECORD TOOLBAR
// Controls what navigation and options appear in data entry record toolbar
// First form your buttons into groups and then put them into the conf array

// Record navigation
$group_nav[] =
    array(
        'name' => 'prev',
        'title' => FALSE,
        'type' => 'text',
        'href' => "",
        'css_class' => FALSE,
        'mkname' => 'prev',
        'lightbox' => FALSE,
        'reloadpage' => FALSE,
);
$group_nav[] =
    array(
        'name' => 'ste_cd',
        'title' => FALSE,
        'type' => 'text',
        'href' => "",
        'css_class' => FALSE,
        'mkname' => 'ste_cd',
        'lightbox' => FALSE,
        'reloadpage' => FALSE,
);
$group_nav[] =
    array(
        'name' => 'current',
        'title' => FALSE,
        'type' => 'text',
        'href' => "",
        'css_class' => FALSE,
        'mkname' => 'current',
        'lightbox' => FALSE,
        'reloadpage' => FALSE,
);
$group_nav[] =
    array(
        'name' => 'modtype',
        'title' => FALSE,
        'type' => 'text',
        'href' => "",
        'css_class' => FALSE,
        'mkname' => 'modtype',
        'lightbox' => FALSE,
        'reloadpage' => FALSE,
);
$group_nav[] =
    array(
        'name' => 'next',
        'title' => FALSE,
        'type' => 'text',
        'href' => "",
        'css_class' => FALSE,
        'mkname' => 'next',
        'lightbox' => FALSE,
        'reloadpage' => FALSE,
);

// Refresh record view
$group_refresh[] =
    array(
        'name' => 'refresh',
        'title' => 'refresh',
        'type' => 'img',
        'href' => "{$_SERVER['PHP_SELF']}?disp_reset=default",
        'css_class' => 'refresh',
        'mkname' => 'reset',
        'lightbox' => FALSE,
        'reloadpage' => FALSE,
);

// Administrative Tools
$group_admin[] =
    array(
        'name' => 'delete',
        'title' => 'delete',
        'type' => 'img',
        'href' => FALSE,
        'css_class' => 'delimg',
        'mkname' => 'del',
        'lightbox' => 'lightbox|200',
        'reloadpage' => FALSE,
);
$group_admin[] =
    array(
        'name' => 'changemod',
        'title' => 'changemod',
        'type' => 'text',
        'href' => FALSE,
        'css_class' => 'recedit',
        'mkname' => 'chgtype',
        'lightbox' => 'lightbox|200',
        'reloadpage' => FALSE,
);
$group_admin[] =
    array(
        'name' => 'changeval',
        'title' => 'changeval',
        'type' => 'text',
        'href' => FALSE,
        'css_class' => 'recedit',
        'mkname' => 'chgkey',
        'lightbox' => 'lightbox|200',
        'reloadpage' => 'micro_entry.php',
);

// Package these button groups up into a toolbar
$conf_record_nav =
    array(
        'record_nav' => $group_nav,
        'record_refresh' => $group_refresh,
        'record_admin' => $group_admin,
);


/** MAP VIEW
*   These settings control the subforms and left panel in the map view.
*   If using the mapping capabilities, the map view needs configuration in left panel,
*   and a few default settings configured.
*/

// MAP VIEW PAGE SETTINGS
$conf_page_map_view =
    array(
        'name' =>'Map View',
        'title' => 'Map View Page',
        'file' => 'map_view.php',
        'sgrp' => '3',
        'navname' => 'mapviewnav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'php/map_view/',
        'is_visible' => TRUE
);

// Mapping timeout in milliseconds- if you are using a slow WxS server set this to be high (default is 1500)
$map_timeout = 5000;

// LEFT PANEL
// Mapping sf_confs
$conf_map_wmcoverlay =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', 
        'sf_nav_type' => 'full',
        'sf_title' => 'interp', 
        'sf_html_id' => 'map_wmcoverlay', // Must be unique
        'script' => 'php/map_admin/subforms/sf_savewmc_overlay.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
        )
    );

$conf_maptopdf =
    array(
        'view_state' => 'max',
        'edit_state' => 'view', 
        'sf_nav_type' => 'full',
        'sf_title' => 'interp', 
        'sf_html_id' => 'map_maptopdf', // Must be unique
        'script' => 'php/map_view/subforms/sf_maptopdf.php',
        'op_label' => 'space',
        'op_input' => 'save',
        'fields' => array(
        )
    );

//the more info button - if you store information about your GIS layers as ARK items then set this to true. 
//Please note you will need to have a 'gis' module and you will need to name your WMS-served GIS layers in the format -
//'contexts_PCO06_123';
$map_more_info_button = FALSE;


/** OTHER PAGES
*   These settings configure the the page settings array for all other pages
*    These can include pages that do not have any other associated configuration needed, 
*    or other commonly hidden pages that are included with the trunk code 
*    (index.php, overlay_holder.php).
*/

// ADMIN PAGES
// ALIAS ADMIN PAGE SETTINGS
$conf_page_alias_admin =
    array(
        'name' =>'Alias Admin',
        'title' => 'Alias Admin Page',
        'file' => 'alias_admin.php',
        'sgrp' => '1',
        'navname' => 'aliasnav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'php/alias_admin/',
        'is_visible' => TRUE
);

// MAP ADMIN PAGE SETTINGS
$conf_page_map_admin =
    array(
        'name' =>'Map Admin',
        'title' => 'Map Admin Page',
        'file' => 'map_admin.php',
        'sgrp' => '2',
        'navname' => 'mapadminnav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'php/map_admin/',
        'is_visible' => TRUE // Set to TRUE if using mapping
);

// MARKUP ADMIN PAGE SETTINGS
$conf_page_markup_admin =
    array(
        'name' =>'Markup Admin',
        'title' => 'Markup Admin Page',
        'file' => 'markup_admin.php',
        'sgrp' => '2',
        'navname' => 'markupnav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'php/markup_admin/',
        'is_visible' => TRUE
);

// USER ADMIN PAGE SETTINGS
$conf_page_user_admin =
    array(
        'name' =>'User Admin',
        'title' => 'User Admin Page',
        'file' => 'user_admin.php',
        'sgrp' => '2',
        'navname' => 'usersnav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'php/user_admin/',
        'is_visible' => TRUE
);

// IMPORT PAGE SETTINGS
$conf_page_import =
    array(
        'name' =>'Import',
        'title' => 'Import Page',
        'file' => 'import.php',
        'sgrp' => '2',
        'navname' => 'importnav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'php/import/',
        'is_visible' => TRUE
);

// HIDDEN PAGES
// FEED PAGE SETTINGS
$conf_page_feed =
    array(
        'name' =>'Feed',
        'title' => 'Feed Page',
        'file' => 'feed.php',
        'sgrp' => '1',
        'navname' => 'feednav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => FALSE,
        'is_visible' => FALSE
);

// DOWNLOAD PAGE SETTINGS
$conf_page_download =
    array(
        'name' =>'Download',
        'title' => 'Download Page',
        'file' => 'download.php',
        'sgrp' => '1',
        'navname' => 'downloadnav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => FALSE,
        'is_visible' => FALSE
);

// TRANSCLUDE PAGE SETTINGS
$conf_page_transclude_object =
    array(
        'name' =>'Transclude',
        'title' => 'Transclude Page',
        'file' => 'transclude_object.php',
        'sgrp' => '3',
        'navname' => 'transcludenav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => FALSE,
        'is_visible' => FALSE
);

// RESULTS MICRO VIEW PAGE SETTINGS
$conf_page_resultsmicro_view =
    array(
        'name' =>'Results Micro View',
        'title' => 'Results Micro View Page',
        'file' => 'resultsmicro_view.php',
        'sgrp' => '1',
        'navname' => 'results_mvnav',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => FALSE,
        'is_visible' => FALSE
);

// OVERLAY HOLDER PAGE SETTINGS
$conf_page_overlay_holder =
    array(
        'name' =>'Overlay Holder',
        'title' => 'Overlay Holder',
        'file' => 'overlay_holder.php',
        'sgrp' => '1',
        'navname' => 'overlayholder',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => FALSE,
        'is_visible' => FALSE
);

// CHAINTABLE SETTINGS
$conf_page_chaintable = 
    array (
        'name' => 'chaintable',
        'title' => 'chaintable',
        'file' => 'chaintable.php',
        'sgrp' => '1',
        'navname' => 'chaintable',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => FALSE,
        'is_visible' => FALSE 
);
    
$conf_page_api = 
    array (
        'name' => 'api',
        'title' => 'api',
        'file' => 'api.php',
        'sgrp' => '3',
        'navname' => 'api',
        'navlinkvars' => '?view=home',
        'cur_code_dir' => 'api/',
        'is_visible' => FALSE 
);

?>
