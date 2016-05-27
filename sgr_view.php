<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* micro_view.php
*
* Index for micro view
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
* @category   base
* @package    ark
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/micro_view.php
* @since      File available since Release 0.6
*
*/

use LPArchaeology\ARK;

// -- INCLUDE SETTINGS AND FUNCTIONS -- //
include('src/settings.php');
include('php/global_functions.php');
include('php/validation_functions.php');


// -- SESSION -- //
// Start the session
session_name($ark_name);
session_start();


// -- MANUAL configuration vars for this page -- //
$error = FALSE;
$message = FALSE;


// -- REQUESTS -- //
$lang = reqArkVar('lang', $default_lang);
$view = reqArkVar('view');
$ste_cd = reqArkVar('ste_cd', $default_site_cd);
// sgr_view is ONLY relevant to contexts, so this is fixed 
$item_key = 'cxt_cd';
$$item_key = reqArkVar($item_key, False);
$update_db = reqQst($_REQUEST, 'update_db');
$submiss_serial = reqArkVar('submiss_serial');
$quickedit = reqQst($_REQUEST, 'quickedit'); // quickedit for forms
$cre_by = reqQst($_SESSION,'user_id'); // user info for forms
$cre_by_name = reqQst($_SESSION,'soft_name'); // user info for forms
$ftr_mode = reqArkVar('ftr_mode', 'standard'); // this is page specific... move out of this block? GH 24/11/11


// -- SF_KEY & SF_VAL -- //
// setup the sf_key and sf_val
$sf_key = $item_key;
$sf_val = $$item_key;

// -- PAGE SETTINGS -- //
$page_conf = ARK\Web\PageConfig::page('sgr_view');
if (!$page_conf->isValid()) {
    die ('ADMIN ERROR: No config in database for page '.$page_conf->id());
}
// title for this HTML page
$page_title = $ark_name.' - '.$page_conf->title();
// the page's sgrp value
$psgrp = $page_conf->sgrp();
// current code directory (location of any files related to this page)
$cur_code_dir = $page_conf->codeDir();

// -- AUTH -- //
include_once ('php/auth/inc_auth.php');

//register the target url
$_SESSION['target_url'] = $_SERVER['REQUEST_URI'];

// ANON LOGINS
// check for anon logins
//check if this is an anonymous login - if it is then prevent edits
if (isset($anonymous_login['username']) && $$liveuser->getProperty('handle') == $anonymous_login['username']){
    $anon_login = TRUE;
} else {
    $anon_login = FALSE;
}


// -- OTHER -- //
// browser
$browser = browserDetect();
$stylesheet = getStylesheet($browser);
// textile
include_once ('lib/php/classTextile.php');
$textile = new Textile;


// -- MARKUP -- //
$mk_go = getMarkup('cor_tbl_markup', $lang, 'go');


// -- MODULE -- //
// select module based on the item key
$mod_short = substr($sf_key, 0, 3);
if ($mod_short) {
    //Pull mod specific settings
    $module = 'mod_'.$mod_short;
    $mod_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $sf_key, 1);
    include_once ("config/mod_{$mod_short}_settings.php");
}


// PART3 - DISP ARRAY
//    This is based on an array per mod in the session or alternatively the settings

// Set up names of variable variables
// $disp_cols - the live name of the cols for the current module
$disp_cols = $mod_short.'_sgr_disp_cols';
// $conf_mcd_cols - settings array for this module from the mod settings
$conf_mcd_cols = $mod_short.'_conf_sgr_cols';

if (!$sf_val){
    // $disp_cols - the live name of the cols for the current module
    $disp_cols = 'sgrhome_disp_cols';
    // $conf_mcd_cols - settings array for this module from the mod settings
    $conf_mcd_cols = 'conf_sgr_home';
}


// first check for a setup in the session
$$disp_cols = reqQst($_SESSION, $disp_cols);

// handle reset request
$disp_reset = reqQst($_REQUEST,'disp_reset');
if ($disp_reset == 'default') {
    // kill the existing dis_cols to force a revert to settings
    $$disp_cols = FALSE;
}

// handle changes of item (in tab view we need to force a reload)
if ($$disp_cols) {
    // go back to the live column package variable
    $col_pkg = $$conf_mcd_cols;
    if (array_key_exists('op_display_type', $col_pkg)) {
        if ($col_pkg['op_display_type'] == 'tabs') {
            // if the record has changed, force a reload
            $tmp = $$disp_cols;
            if ($tmp[0]['col_sf_val'] != $$item_key) {
                // kill the existing dis_cols to force a revert to settings
                $$disp_cols = FALSE;
            }
        }
    }
}

// if the disp_cols are not present, get them fresh from settings
if (!$$disp_cols) {
    // go back to the live column package variable
    $col_pkg = $$conf_mcd_cols;
    $$disp_cols = $col_pkg['columns'];
    // if this is a tab view routine, pre-process these now
    if (array_key_exists('op_display_type', $col_pkg)) {
        $conf_col_view = $col_pkg['op_display_type'];
    } else {
        $conf_col_view = 'cols';
    }
    if ($conf_col_view == 'tabs') {
        // process the columns (which may contain embedded or XMI columns)
        $$disp_cols = prcsTabCols($$disp_cols);
        $_SESSION[$disp_cols] = $$disp_cols;
    }
    unset($col_pkg);
}

// PART4 - Handle requests to change the subform state
$sf_nav = reqQst($_REQUEST,'sf_nav');

// PART4a - Handle requests to change the view state
if ($sf_nav == 'min' OR  $sf_nav == 'max') {
    // temporarily make the dynamically named disp cols static
    $temp_cols = $$disp_cols;
    
    // Get the col and row of the sf
    $col = reqQst($_REQUEST,'col_id');
    $row = reqQst($_REQUEST,'sf_id');
    $temp_cols["$col"]['subforms']["$row"]['view_state'] = $sf_nav;
    
    // make the static named disp cols dynamic again
    $$disp_cols = $temp_cols;
    
    unset($temp_cols);
    unset($col);
    unset($row);
}

// PART4b - Handle requests to change the edit state
if ($sf_nav == 'edit' OR  $sf_nav == 'view' OR  $sf_nav == 'ent') {
    // temporarily make the dynamically named disp cols static    
    $temp_cols = $$disp_cols;
    
    // Get the col and row of the sf
    $col = reqQst($_REQUEST, 'col_id');
    $row = reqQst($_REQUEST, 'sf_id');
    $temp_cols[$col]['subforms'][$row]['edit_state'] = $sf_nav;
    
    // make the static named disp cols dynamic again
    $$disp_cols = $temp_cols;
    // clean up
    unset($temp_cols);
    unset($col);
    unset($row);
}


// PART4c - Handle requests to change the subform column
if ($sf_nav == 'mv_col_r' || $sf_nav == 'mv_col_l') {
    
    // temporarily make the dynamically named disp cols static
    $temp_cols = $$disp_cols;
    
    // Get the col and row of the sf
    $col = reqQst($_REQUEST,'col_id');
    $row = reqQst($_REQUEST,'sf_id');
    
    // set up the target
    if ($sf_nav == 'mv_col_r') {
        $tgt_col = $col+1;
    }
    if ($sf_nav == 'mv_col_l') {
        $tgt_col = $col-1;
    }
    
    // remove the subform from the column and hold in a var
    $tmp_sf = $temp_cols["$col"]['subforms']["$row"];
    unset ($temp_cols["$col"]['subforms']["$row"]);
    
    // un_shift the tmp array into the top of the target col
    array_unshift($temp_cols["$tgt_col"]['subforms'], $tmp_sf);
    
    // make the static named disp cols dynamic again
    $$disp_cols = $temp_cols;
    
    unset($temp_cols);
    unset($tmp_sf);
    unset($col);
    unset($tgt_col);
    unset($row);
}

// PART4d - Handle requests to change the subform row
if ($sf_nav == 'mv_up' OR $sf_nav == 'mv_dn') {
    // temporarily make the dynamically named disp cols static
    $temp_cols = $$disp_cols;
    
    // Get the col and row of the sf
    $col = reqQst($_REQUEST,'col_id');
    $row = reqQst($_REQUEST,'sf_id');
    
    // set up the target
    if ($sf_nav == 'mv_up') {
    //get key of sf above
    $tgt_row = $row-1;
    }
    if ($sf_nav == 'mv_dn') {
    $tgt_row = $row+1;
    }
    
    // extract the arrays to swap
    $tmp_sf = $temp_cols["$col"]['subforms']["$row"];
    $tmp_old = $temp_cols["$col"]['subforms']["$tgt_row"];
    
    // now reinsert them swapped over
    $temp_cols["$col"]['subforms'][$row] = $tmp_old;
    $temp_cols["$col"]['subforms'][$tgt_row] = $tmp_sf;
    
    // make the static named disp cols dynamic again
    $$disp_cols = $temp_cols;
    
    // clean up
    unset($temp_cols);
    unset($tgt_row);
    unset($row);
    unset($col);
}


// PART5 - Handle requests to change the subform state
$col_nav = reqQst($_REQUEST,'col_nav');


// PART6 - save variables to the session
//The disp cols
$_SESSION[$disp_cols] = $$disp_cols;


// PART7 - Make the RESULTS NAV
$record_nav = mkRecordNav($conf_sgr_nav, 'micro_view', 'sgr_view');


// PART8 - Custom Page Title
// this is done so far down the page in order to use data in the page title
$page_title = $page_title.': '.$$item_key;


// -- PROCESS -- //
// We process delete related routines at the top of the page so as to avoid conflicts
// delfrag - makes routine updates of individual fragments
if ($update_db === 'delfrag') {
    include_once('php/update_db.php');
    // if a frag has other frags chained to it, the user needs to confirm the delete
    // this is supported using an overlay. First check to see if the error is a chain
    // error
    if ($error) {
        foreach ($error as $key => $err) {
            if (array_key_exists('chain', $err)) {
                $mk_confirmdel = getMarkup('cor_tbl_markup', $lang, 'confirmdel');
                $mk_delete = getMarkup('cor_tbl_markup', $lang, 'delete');
                $redirecturl = "{$_SERVER['PHP_SELF']}?item_key=$item_key&amp;$item_key={$$item_key}";
                $redirecturl = urlencode($redirecturl);
                $error[]['vars'] = "$mk_confirmdel: <a href=\"overlay_holder.php?overlay=true&amp;item_key={$item_key}&amp;{$item_key}={$$item_key}&amp;delete_key=cor_tbl_{$err['delete_dclass']}&amp;delete_val={$err['delete_id']}&amp;lang=$lang&amp;sf_conf=conf_mcd_deleterecord&amp;lboxreload=$redirecturl\" rel=\"lightbox\">$mk_delete</a>";
            }
        }
    }
}
// delete_XXX - makes deletions of entire records
$dynamic_delete_name = 'delete_'.$mod_short;
if ($update_db === $dynamic_delete_name) {
    $delete_key = reqQst($_REQUEST, 'delete_key');
    $delete_val = reqQst($_REQUEST, 'delete_val');
    include_once ('php/subforms/update_delete_record.php');
    if ($delete_success) {
        $error[]['vars'] = getMarkup('cor_tbl_markup', $lang, 'err_recwasdel');
        $message = FALSE;
    }
}

$javascript = mkJavaScriptSource($pg_settings['name']);
// -- OUTPUT-- //
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
    if (isset($mobileskin)){
        $skin = $mobileskin;
    }
}

$skin = reqArkVar('skin', $skin);
$skin_path = "$ark_skins_path/$skin";

include($skin_dir."/templates/inc-header.php");
include('php/common/page_nav.php');

?>

<!-- BEGIN maincontent -->
    <div id="main" class="main_mcrview">

<?php
echo "$record_nav";

// feedback
if ($error) {
    echo "<div class=\"dv_feedback\">\n";
    feedBk('error');
    echo "</div>\n";
}
if ($message) {
    echo "<div class=\"dv_feedback\">\n";
    feedBk('message');
    echo "</div>\n";
}

// the results
if (isset($result_output)) {
    echo "$result_output";
}
 
// If no Itemkey or Itemval - give feedback cleanly to the user
if (!$sf_key) {
    $message[] = 'Select a form...';
}
if (!$sf_val && $sf_key) {
    $message [] = 'Search for a ' . $mod_alias . ' item...';
}

//<!-- MAIN CONTENT (IN COLUMNS) -->
// feedback
if ($error) {
    echo "<div class=\"dv_feedback\">\n";
    feedBk('error');
    echo "</div>\n";
}
if ($message) {
    echo "<div class=\"dv_feedback\">\n";
    feedBk('message');
    echo "</div>\n";
}

// the main area subforms
if (!$error) {
    // conf_mcd_cols - this is the entire package
    $tcolarr = $$conf_mcd_cols;
    // set up the type of view required (default to 'cols')
    if (array_key_exists('op_display_type', $tcolarr)) {
        $conf_col_view = $tcolarr['op_display_type'];
    } else {
        $conf_col_view = 'cols';
    }
    
    // ---- Column view ---- //
    if ($conf_col_view == 'cols') {
        foreach($$disp_cols as $cur_col_id => $disp_col) {
            // optional css classes
            if (array_key_exists('op_css_class', $disp_col)) {
                $css_class = $disp_col['op_css_class'];
            } else {
                $css_class = $disp_col['col_type'];
            }
            // OUTPUT
            printf("<div id=\"column-{$disp_col['col_id']}\" class=\"$css_class\">\n");
                // a title for the column (either the results of a field or markup)
            if (isset ( $col )) {
                if ($col ['col_mkname']) {
                    if (! is_array ( $col ['col_mkname'] )) {
                        $mk_col_mkname = getMarkup ( 'cor_tbl_markup', $lang, $col ['col_mkname'] );
                    } else {
                        $field = $col ['col_mkname'];
                        $mk_col_mkname = resTblTd ( $col ['col_mkname'], $sf_key, $sf_val );
                    }
                    echo "<h1>$mk_col_mkname</h1>\n\n";
                }
            }
            // extract the subforms from the column
            $cur_col_subforms = $disp_col['subforms'];
            foreach($cur_col_subforms as $cur_sf_id => $cur_col_subform) {
                // if this is an anon login - set the edit options to be OFF
                // DEV NOTE: This should be a full blown security check per user per SF
                // DEV NOTE: see ticket #207
                if (!array_intersect($record_admin_grps, $_SESSION['sgrp_arr'])) {
                    // temporarily make the cols static
                    $temp_cols = $$disp_cols;
                    // change the sf_nav (unless it is already set to 'none')
                    if ($cur_col_subform['sf_nav_type'] != 'none') {
                        // fix the new sf_nav_type
                        $temp_cols[$cur_col_id]['subforms'][$cur_sf_id]['sf_nav_type'] = 'name';
                    }
                    // force the edit state in the main array
                    $temp_cols[$cur_col_id]['subforms'][$cur_sf_id]['edit_state'] = 'view';
                    // force this copy of the $cur_col_subform['edit_state']
                    $cur_col_subform['edit_state'] = 'view';
                    // make the static named disp cols dynamic again
                    $$disp_cols = $temp_cols;
                }
                // set the sf_state
                $sf_state = 
                    getSfState(
                        $disp_col['col_type'],
                        $cur_col_subform['view_state'],
                        $cur_col_subform['edit_state']
                );
                // set the sf_conf
                $sf_conf = $cur_col_subform;
                // if the sf is conditional
                if (array_key_exists('op_condition', $cur_col_subform)) {
                    // check the condition
                    if (chkSfCond($item_key, $$item_key, $cur_col_subform['op_condition'])) {
                        include($cur_col_subform['script']);
                    }
                } else {
                    include($cur_col_subform['script']);
                }
                // cleanup this sf
                unset($sf_state);
                unset($cur_col_subform);
            }
            unset($cur_col_subforms);
            printf("</div>\n\n");
        }
    }
    
    // ---- Tabs view ---- //
    if ($conf_col_view == 'tabs') {
        // specify a default current tab
        if (!array_key_exists('op_top_col', $tcolarr)) {
            $default = 'main_column';
        } else {
            $default = $tcolarr['op_top_col'];
        }
        $curcol = reqArkVar('curcol', $default);
        if ($curcol == 'zero') {
            $curcol = '0';
        }
        // this routine is used to transform the human readable 'col_id' into
        // the numerical array key of the current column within the cols array
        foreach ($$disp_cols as $key => $col) {
            if ($col['col_id'] == $curcol) {
                $temp_var = $key;
            }
        }
        if (!isset($temp_var)) {
            // this means the curcol is not found in this sites columns (eg a season from another site)
            $curcol = $default;
            $temp_var = '0';
        }
        $cur_col_id = $temp_var;
        unset ($temp_var);
        // make up the tab nav
        $nav = mkMvTabNav($$disp_cols);
        // print the nav
        printf("<div id=\"tabnav\">\n<ul>\n$nav</ul>\n</div>\n\n");
        // loop over the columns until we hit the relevant one
        foreach ($$disp_cols as $col_key => $disp_col) {
            // if the column matches the curcol/cur_col_id it is the right one to display
            if ($disp_col['col_id'] == $curcol) {
                // extract the subforms
                $cur_col_subforms = $disp_col['subforms'];
                // optional css classes
                if (array_key_exists('op_css_class', $disp_col)) {
                    $css_class = $disp_col['op_css_class'];
                } else {
                    $css_class = $disp_col['col_type'];
                }
                // set up the sf_key and sf_nav for this column (key might not be the same as the page)
                $sf_key = $disp_col['col_sf_key'];
                $sf_val = $disp_col['col_sf_val'];
                // OUTPUT
                printf("<div id=\"column-{$disp_col['col_id']}\" class=\"$css_class\">\n");
                // loop over the subforms for the active column
                foreach($cur_col_subforms as $cur_sf_id => $cur_col_subform) {
                    // if this is an anon login - set the edit options to be OFF
                    // DEV NOTE: This should be a full blown security check per user per SF
                    // DEV NOTE: see ticket #207
                    if ($anon_login) {
                        // change the sf_nav (unless it is already set to 'none')
                        if ($cur_col_subform['sf_nav_type'] != 'none') {
                            // fix the new sf_nav_type
                            $disp_col['subforms'][$cur_sf_id]['sf_nav_type'] = 'name';
                        }
                        // force the edit state in the main array
                        $disp_col['subforms'][$cur_sf_id]['edit_state'] = 'view';
                        // force this copy of the $cur_col_subform['edit_state']
                        $cur_col_subform['edit_state'] = 'view';
                    }
                    if (array_key_exists('op_condition', $cur_col_subform)) {
                        if (chkSfCond($item_key, $$item_key, $cur_col_subform['op_condition'])) {
                            $sf_state = 
                                getSfState(
                                    $disp_col['col_type'],
                                    $cur_col_subform['view_state'],
                                    $cur_col_subform['edit_state']
                            );
                            $sf_conf = $cur_col_subform;
                            include($cur_col_subform['script']);
                            unset ($sf_state);
                            unset($cur_col_subform);
                        }
                    } else {
                        $sf_state = 
                            getSfState(
                                $disp_col['col_type'],
                                $cur_col_subform['view_state'],
                                $cur_col_subform['edit_state']
                        );
                        $sf_conf = $cur_col_subform;
                        include($cur_col_subform['script']);
                        unset ($sf_state);
                        unset($cur_col_subform);
                    }
                }
                unset($cur_col_subforms);
                printf("</div>\n\n");
            }
        }
    }
}

?>
<!-- ARK FOOTER -->
<?php  include($skin_dir."/templates/inc-footer.php");  ?>
    
