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
* @author     Andy Dufton <a.dufton@lparchaeology.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/config/settings.php
* @since      File available since Release 1.0
*/

/**  NAVIGATION PAGES
*   All top-level pages are stored in the root of the ARK directory
*   By default all pages will appear in the main nav
*   Pages listed in this array will not appear in the main nav
*/ 

$conf_hide_pages =
    array(
        'index.php',
        'overlay_holder.php',
        'export.php',
//        'map_admin.php',
//        'map_view.php',
//        'import.php'
);

// -- NAV LINKS -- //
// these links will appear in the end of the navbar
$conf_linklist =
    array(
        // 'file' => 'index.php',
        // 'vars' => 'logout=true',
        // 'label' => 'logout'
);

// List the modules that need to be loaded in this ARK project
$loaded_modules = 
    array(
        'cxt',
        'sph',
        'pln',
        'gph',
        'ael',
        'spf',
        'cns',
        'abk',
);
    
// Lists the modules to load maps for
$loaded_map_modules = 
     array(
        'cxt',
);

//  The default item key for this instance of Ark.
$default_itemkey = 'cxt_cd';

// -- VIEWERS -- //
// Number of rows to display on the data viewer
$conf_viewer_rows = 25;
// Number of pages to display on the data viewer
$conf_num_res_pgs = 5; // best choose an odd number
// Default Micro viewer page (used by search result handlers)
$conf_micro_viewer = $ark_dir."micro_view.php";
// Default data viewer page
$conf_data_viewer = $ark_dir."data_view.php";
// Default feed viewer page
$conf_feed_viewer = $ark_dir."feed.php";
// Default search page - search funtions will send data thru to this page
$conf_search_viewer = $ark_dir."data_view.php";
// Default $output_mode for the data viewer
$default_output_mode = 'tbl';    
    
//mapping timeout in miliseconds- if you are using a slow WxS server set this to be high (default is 1500)
$map_timeout = 5000;

//mapping sf_confs
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
    
/*
  $wxs_qlayers:
  mapping layers for mods - specify in this array the names of the wms/wfs layers 
  that contain the spatial data for each mod. Bear in mind that these layers should
  contain an ark_id column that can be retrieved using a getFeatureInfo request.
  Each layer is a seperate entry in the array containing an array of variables
  'mod' - the mod of the item (without _cd) eg. 'cxt'
  'geom' - the geometry of the layer - eg. 'pt', 'pl' or 'pgn'
  'url' - the full url of the WMS/WFS server that is hosting the layer eg. http://localhost/ark/php/map/ark_wxs_server.php?
*/
$wxs_qlayers = 
    array(
        'cxt_schm' => array(
                'mod' => 'cxt',
                'geom' => 'pgn',
                'url' => 'http://localhost:8888/ark_su/php/map/ark_wxs_server.php?'
        ),

    );

/*
  $wxs_query_map - this is the name of a saved map (saved using the map_admin tools), 
  that you want to be the background for the 'View Results as Map'.
  ADMIN NOTE: the $wxs_qlayers array is used to determine which layers can be used to 
  display the spatial data for each mod - therefore those layers HAVE to be available in the saved 
  $wxs_query_map
*/

$wxs_query_map = 'Results Map';

//the more info button - if you store information about your GIS layers as ARK items then set this to true. 
//Please note you will need to have a 'gis' module and you will need to name your WMS-served GIS layers in the format -
//'contexts_PCO06_123';
$map_more_info_button = FALSE;
    
    
/** GLOBAL SUBFORMS
*   Inclusion of subforms for editing record key, deleting records, changing
*   modtypes can be used in multiple pages and are included here rather than
*   in each mod settings
*/

// Setup delete and edit and delete itemval subforms

$conf_mcd_dnarecord =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'nmedit',
        'sf_title' => 'dnarecord', 
        'sf_html_id' => 'dna_cxt_record', // Must be unique
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
        'sf_html_id' => 'delete_cxt', // Must be unique
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

// LEFT PANEL
// Choose the type of output for the left panel (subforms or linklist)
$uhlpoutput = 'subforms';

// Configure the linklist for the left panel
// (Using subforms for this panel, no linklist needed)

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
                    'cxt',
                    'ael',
                    'spf',
                    'cns',
                    'sph',
                    'pln',
                    'gph',                    
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
* only using a single settings file (not module specific)
* The page makes use of a series of configured subforms then assembled into
* columns according to this settings file.
*/

// FIELDS SETUP- THIS IS NEEDED FOR A RECORD JUMPER SUBFORM
// NB if using the 'live' mode for jumpers, only one module can be included here
$jumper_list_home[] = 
    array(
        'mode' => 'live',
        'button' => 'go',
        'item_key' => 'cxt_cd',
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

// You can replace this with a feed from ark filter results to show
// latest new records, etc
$userhome_rssfeed =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'tracfeed', 
        'sf_html_id' => 'uh_rssfeed', // Must be unique
        'script' => 'php/subforms/sf_rssfeed.php',
        'op_css_class' => 'basic_subform',
        'feed_url' => array(
//            'http://localhost:8888/ark/feed.php?feed_id=4',
        ),
);

$userhome_tracfeed =
    array(
        'view_state' => 'max',
        'edit_state' => 'view',
        'sf_nav_type' => 'none',
        'sf_title' => 'tracfeed', 
        'sf_html_id' => 'uh_tracfeed', // Must be unique
        'script' => 'php/subforms/sf_rssfeed.php',
        'op_css_class' => 'basic_subform',
        'feed_url' => array(
            'http://localhost:8888/trac/timeline?ticket=on&changeset=on&milestone=on&max=3&daysback=160&format=rss',
        ),
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
        'subforms' => array(
                $userhome_jumper,
                $userhome_my_saved_filters,
        )
);

$conf_mcd_col_2 =
    array(
        'col_id' => 'second_column',
        'col_alias' => FALSE,
        'col_type' => 'secondary_col',
        'subforms' => array(
                $userhome_rssfeed
        )
);

$conf_mcd_col_3 =
    array(
        'col_id' => 'third_column',
        'col_alias' => FALSE,
        'col_type' => 'secondary_col',
        'subforms' => array(
                $userhome_tracfeed
        )
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
//                $conf_mcd_col_2,
                $conf_mcd_col_3
        )        
);


/**  DATA ENTRY
*   These settings configure the data entry page
*   The data entry requires configuration for both the left panel
*   and the record navigation bar appearing at the top of the main area
*   Further options for advanced file upload are also included below
*/

// MINIMISER OPTION
// Set to on if you want to use the data entry 'minimiser' tool
// This tool condenses subforms and offers quick nav in left panel
$minimiser = TRUE;

// GLOBAL SUBFORMS
// These global subforms are for overlay options

// To add a new sitecode
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
        )
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
        )
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
                'cxt',
                'ael',
                'spf',
                'cns',
                'sph',
                'pln',
                'gph',   
                'abk',                
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
        'css_class' => 'gears',
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

$fu =
    array(
     'on' => FALSE,
     'pattern' => "/\b[a-zA-Z]*\-(([0-9]*)|(([0-9]*)-[a-z0-9A-Z]*))\.[a-z0-9]{2,4}\b/i", 
     // 'pattern' => "/\bMUS-([0-9]*)\.[a-z0-9]{2,4}\b/i",
);


/**  DATA VIEW (SEARCH)
*   These settings configure the data view (or search) page
*   The data view requires configuration for the left panel,
*   the search tools options (results views, download options, etc)
*   as well as some general settings for search results
*/

// SUBFORMS
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

// LEFT PANEL
// The left panel for filters is a series of complex subforms

// Configure a linklist of new filter options
$link_list_filters[] = 
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftype=ftx&amp;ftr_id=new", 
        'mknname' => 'ftx',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);
$link_list_filters[] = 
     array(
         'href' => "{$_SERVER['PHP_SELF']}?ftype=key&amp;key=3&amp;ftr_id=new", 
         'mknname' => 'filtercxt',
         'img' => 'view_mag.png',
         'lightbox' => FALSE,
         'css_class' => FALSE
); 
$link_list_filters[] = 
     array(
         'href' => "{$_SERVER['PHP_SELF']}?ftr_id=new&amp;ftype=atr&amp;atrtype=3&amp;op_display=fauxdex&amp;bv=1", 
         'mknname' => 'filtercertype',
         'img' => 'view_mag.png',
         'lightbox' => FALSE,
         'css_class' => FALSE
);
$link_list_filters[] = 
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftr_id=new&amp;ftype=range&amp;spantype=6&amp;selectortype=adbc", 
        'mknname' => 'filterspan',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);
$link_list_filters[] =
    array(
        'href' => "{$_SERVER['PHP_SELF']}?ftype=key&amp;ftr_id=new", 
        'mknname' => 'filterkey',
        'img' => 'view_mag.png',
        'lightbox' => FALSE,
        'css_class' => FALSE
);   
$link_list_filters[] = 
     array(
         'href' => "{$_SERVER['PHP_SELF']}?ftr_id=new&amp;ftype=atr&amp;atrtype=1&amp;op_display=fauxdex&amp;bv=1", 
         'mknname' => 'filterrecstatus',
         'img' => 'view_mag.png',
         'lightbox' => FALSE,
         'css_class' => FALSE
);    
// subform to hold this linklist
$dvlp_subform_filters =
    array(
        'view_state' => 'min',
        'edit_state' => 'view',
        'sf_nav_type' => 'name',
        'sf_title' => 'dvlp_filters', 
        'sf_html_id' => 'dvlp_filters', // Must be unique
        'script' => 'php/subforms/sf_linklist.php',
        'op_modtype' => FALSE, //if each modtype uses same fields (see below)
        // Does the linklist use an icon instead of a label as link
        'op_linktype' => 'icon',
        'op_sf_cssclass' => 'ftr_list',
        'fields' => $link_list_filters
);
// subform for the filter builder to run in the left panel
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
// subform for the filter builder in an overlay (no condition)
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
// subform for user saved filters
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
// make a column to hold the subforms
$data_view_left_panel =
    array(
        'col_id' => 'dvlp',
        'col_alias' => FALSE,
        'col_type' => 'primary_col',
        'subforms' =>
            array(
                $dvlp_filter_builder,
                $dvlp_subform_filters,
                $dvlp_my_saved_filters
        )
);

// RESULTS TOOLBAR
// Controls what navigation and options appear in data entry record toolbar
// First form your buttons into groups and then put them into the conf array

// Tools
$group_tools[] =
    array(
        'type' => 'img',
        'href' => "overlay_holder.php?sf_conf=conf_mac_userconfigfields&amp;lboxreload=1",
        'css_class' => 'gears',
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
         'href' => "overlay_holder.php?$res&amp;feed_mode=rss&amp;lboxreload=1&amp;sf_conf=conf_mac_exportrss",
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

// Package these button groups up into a toolbar
$conf_results_nav =
    array(
        'tools' => $group_tools,
        'result_views' => $group_disp,
        'result_feeds' => $group_feeds,
        'result_downloads' => $group_dls,
);

/**  MICRO VIEW (RECORD VIEW)
*   These settings configure the micro view (or record vie) page
*   The micro view requires configuration for the left panel,
*   and record nav options as well as some general settings
*/

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
                'cxt',
                'ael',
                'spf',
                'cns',
                'sph',
                'pln',
                'gph',   
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

?>