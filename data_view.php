<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* data_view.php
*
* Index page for data view
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
* @link       http://ark.lparchaeology.com/svn/data_view.php
* @since      File available since Release 0.6
*
*
* NOTES: This page has three different required and persistent UI control variables. These
* are NOT the same and should NOT be used interchangeably. They are as follows:
* - $view: governs the ARK standard 'view' set up (not really used in this page but needed
*     for reasons of standardisation, plus could also be useful at some point)
* - $ftr_mode: this controls the type of user interface offered. The settings for this are
*     basic|standard|advanced. This mostly affects the way that filters are presented and
*     the level of tools presented to the user. Note that 'basic' mode also affects $disp_mode
* - $disp_mode: governs the way that results are presented to the user. Feeds are now handled
*     by feed.php and downloads are also handled in an overlay (at present). Therefore the main
*     current use of this var is to set up the chat|table|thumb|text display options for the
*     results themselves.
*
*/


// -- INCLUDE SETTINGS AND FUNCTIONS -- //
include('config/settings.php');
include('config/map_settings.php');
include('php/global_functions.php');
include('php/validation_functions.php');


// -- SESSION -- //
// Start the session
session_name($ark_name);
session_start();


// -- MANUAL configuration vars for this page -- //
$pagename = 'data_view';
$error = FALSE;
$message = FALSE;


// -- REQUESTS -- //
$lang = reqArkVar('lang', $default_lang);
$view = reqArkVar('view'); // beware! this is not really used by data_view (left in for standardisation) GH 24/11/11
$ftr_mode = reqArkVar('ftr_mode', 'standard'); // this is page specific... move out of this block? GH 24/11/11
$results_mode = reqArkVar('results_mode', 'disp'); // this is page specific... move out of this block? GH 24/11/11
$ste_cd = reqArkVar('ste_cd', $default_site_cd);
$phpsessid = reqQst($_REQUEST, 'PHPSESSID');
$update_db = reqQst($_REQUEST, 'update_db');
$submiss_serial = reqArkVar('submiss_serial');
$perpage = reqArkVar('perpage', $conf_viewer_rows);
$page = reqArkVar('page', '1'); // Request the current page (default to page 1)
// also flag up changes to perpage
$perpage_test = reqQst($_REQUEST, 'perpage');
// a special case for feeds
$limit = reqQst($_REQUEST, 'limit');
if ($limit) {
    $perpage = $limit;
    $perpage_test = TRUE;
}


// -- PAGE SETTINGS -- //
// handle missing config
if (!$pagename) {
    die ('ADMIN ERROR: No $pagename variable setup. Required as of v1.1, supersedes $filename');
}
// handle missing config
$pg_settings_nm = 'conf_page_'.$pagename;
$pg_settings = $$pg_settings_nm;
if (!$pg_settings) {
    die ("ADMIN ERROR: No settings (${$pg_settings_nm})found for the page $pagename");
}
// title for this HTML page
$page_title = $ark_name.' - '.$pg_settings['title'];
// the page's sgrp value
$psgrp = $pg_settings['sgrp'];
// current code directory (location of any files related to this page)
$cur_code_dir = $pg_settings['cur_code_dir'];

//register the target url
$_SESSION['target_url'] = $_SERVER['REQUEST_URI'];

// -- AUTH -- //
$db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
include_once ('php/auth/inc_auth.php');

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


// ---- MARKUP ---- //
$mk_norec = getMarkup('cor_tbl_markup', $lang, 'norec');
$mk_nofilters = getMarkup('cor_tbl_markup', $lang, 'nofilters');

// ---- EDITS ----- //
if ($update_db === "update_multi" ){
    $itemvalues = reqQst($_REQUEST,"multi_edit_itemvalues");
    $itemvalues = json_decode($itemvalues);
    $current_mod = "";
    $field_name = reqQst($_REQUEST,"field");
    $field = $$field_name;
    $fields[] = $field;
    foreach ($itemvalues as $itemvalue){
        $item = explode("_", $itemvalue);
        if($current_mod != $item[0]){
            $mod_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $item[0]."_".$item[1], 1);
        }
        $item_key = $item[0]."_".$item[1];
        $itemval = $item[2]."_".$item[3];
        $_REQUEST['itemval'] = $itemval;
        $cur = resFdCurr($field, $item_key, $itemval);
        if($cur){
            $_REQUEST[$field['classtype'].'_qtype'] = 'edt';
            $_REQUEST[$field['classtype'].'_id'] = $cur[0]['id'];
        } else {
            $_REQUEST[$field['classtype'].'_qtype'] = 'add';
        }
        include('php/update_db.php');
        $submiss_serial = $_SESSION['submiss_serial'];
    }
    // after looping over every update, change the submission serial for this session to prevent reloads
    $submiss_serial = rand(1000000,9999999);
    $_SESSION['submiss_serial'] = $submiss_serial;
}

// ---- FILTERS ---- //
// Run the filters by including filters.php
$filters_exec = 'off';
include_once ($cur_code_dir.'filters.php');


// ---- COUNT RESULTS ---- //
// note the number of results for future reference
if ($results_array) {
    $total_results = count($results_array);
} else {
    $total_results = 0;
}

// ---- UI STUFF ---- //
// NOTES: $view is NOT the same as $ftr_mode is NOT the same as $disp_mode see doc header

// RESULTS MODE

// display modes for on screen results
// disp_mode=chat
// disp_mode=table
// disp_mode=text
// disp_mode=thumb
// disp_mode=map
$disp_mode = reqArkVar('disp_mode', 'table');
$mk_disp_mode = getMarkup('cor_tbl_markup', $lang, $disp_mode);

if ($disp_mode == 'map'){
    $perpage = 'inf';
}

// ---- PAGINATION ---- //
// allow an override to reset to page 1 eg. if the filters have been exec'ed
// also reset to page 1 if the perpage is changed
if (isset($oride_page) or $perpage_test) {
    $page = 1;
}

// do the pagination
// NOTE: overide to remove pagination: $perpage == 'inf'
if ($results_array && $perpage && $perpage != 'inf') {
    // save out the results unpaged for future use
    $_SESSION['unpaged_results_array'] = $results_array;
    // page the results
    $page_array = pageResults($results_array, $page, $perpage);
    // output the paged results to the live var
    $results_array = $page_array['paged_results'];
    // flag paging as having taken place
    $pg = 'on';
} else {
    // flag paging as not having taken place
    $pg = FALSE;
}

// feeds
// Handled by feed.php

// downloads
// Handled by download.php

// RESULTS NAV
$results_nav = mkResultsNav($conf_results_nav, $ftr_mode, $mk_disp_mode);

// ---- PROCCESS RESULTS ---- //

// select the function to be used to return the exported results
$mk_func = 'mkResults'.ucfirst($disp_mode);
// if there are results - run the output function
if ($results_array) {
    $result_output = $mk_func($results_array, $filters);
} else {
    // no results have been returned
    if ($filters_exec == 'on') {
        $message[] = $mk_norec;
    } else {
        // Offer a message saying to add a filter
        $message[] = $mk_nofilters;
        // manually send this msg to the main area (left panel will report and remove the $message[] above)
        $result_output = "<div class=\"dv_feedback\"><div id=\"message\"><p>$mk_nofilters</p></div></div>\n";
    }
}

// paging nav
if ($pg == 'on' && $result_output) {
    // make the paging nav the vars are:
    // current pg no|total num of pages|number of res perpage|number of pages listed
    $result_output .=
        mkNavPage($page, $page_array['total'], $perpage, $conf_num_res_pgs, $total_results);
}
// if the perpage is set to infinity, we need to display the reduced nav
if ($results_array && $perpage == 'inf') {
    $result_output .=
        mkNavPage($page, 0, $perpage, $conf_num_res_pgs, $total_results);
}

$javascript = mkJavaScriptSource($pg_settings['name']);
$skin = reqArkVar('skin', $skin);
$skin_path = "$ark_skins_path/$skin";

$wrapperclass = "wrp_results";

// ---------OUTPUT--------- //

include($skin_dir."/templates/inc-header.php");

?>

<div id="lpanel" class="leftpanel">
<?php
include($cur_code_dir."/filter_panel.php");
?>
</div>
<div class="data_view_content">




<!-- THE MAIN AREA -->
<div id="main" class="main_results">



<?php
// the results nav
echo "$results_nav";

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
?>

</div>
</div>

<?php
    include($skin_dir."/templates/inc-footer.php"); ?>


<!-- end content WRAPPER -->
</div>
<?php echo "$javascript";
?>
    <script type="text/javascript">
        $(document).ready(function(){
            // drawer toggle script
            $(".dr_toggle").click(function(){
                console.log("test");
                var $marginLefty = $(".dr");
                $marginLefty.animate({
                    marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ?
                        $marginLefty.outerWidth() :
                        0
                });
                $("#filter_panel").toggleClass('dr_shadows');
                $("div.dr").toggleClass('dr_shadows');
                return false;
            });
            $("ul#ftr_options .save").click(function(e){
                e.preventDefault();
                console.log("test");
                var $marginLefty = $(".dr");
                $marginLefty.animate({
                    marginLeft: parseInt($marginLefty.css('marginLeft'),10) == 0 ?
                        $marginLefty.outerWidth() :
                        0
                });
                $("#filter_panel").toggleClass('dr_shadows');
                $("div.dr").toggleClass('dr_shadows');
                return false;
            });
        });
        
        $(window).load(function(){
            // set heights in left panel
            var main_ht = $("#main").height();
            var lpanel_ht = $("#lpanel").height();
            var largest_child = 0;
            $('#lpanel').children().each(function() {
                var ht = $(this).height();
                if (ht > largest_child) {
                    largest_child = ht;
                };
            });
            var largest = max(main_ht, largest_child, lpanel_ht);
            console.log ("largest: " + largest);
            // set all the heights to the same thing
            $('#lpanel').children().each(function() {
                $(this).height(largest);
            });
            $('#lpanel').height(largest);
            $('#main').height(largest);
        });
    </script>

    <?php
// ---- GET SOME JS VARIABLES FOR EDITING ----- //
$current_mod = "";
if( is_array($results_array) ){
    foreach ($results_array as $key => $val){
        $mod_short = substr($val['itemkey'], 0, 3);
        if($mod_short != $current_mod){
            $current_mod = $mod_short;
            $conf = reqModSetting($mod_short, "conf_mac_$disp_mode");
            $fields = $conf['fields'];
        }
    }

    $fieldsJs = "<script>var fields = [";
    $fieldAliasJs = "<script>var fieldAlias = [";
    $editpanels = "<div class=\"editpanel\">";

    foreach ($fields as $field){
        if (in_array($field['dataclass'], array('attribute','txt','number'))){
            $fieldsJs .= "'{$field['field_id']}',";
            $field['alias'] = getAlias('cor_lut_'.$field['dataclass'].'type', $lang, $field['dataclass'].'type', $field['classtype'], 1);
            $fieldAliasJs .= "'{$field['alias']}',";
            $element = frmElem($field,$mod_short);
            $editpanels .= "<div id=\"edit_field_{$field['field_id']}\" class=\"edit_field_colorbox\">";
            $editpanels .= "Editing {$field['alias']} for ";
            $editpanels .= "<div class=\"edit_field_itemkeys\"></div>";
            $editpanels .= "<form action=\"\" method=\"POST\">";
            $editpanels .= "<input type=\"hidden\" value=\"\" name=\"multi_edit_itemvalues\" class=\"multi_edit_itemkeys\"></input>";
            $editpanels .= "<input type=\"hidden\" value=\"update_multi\" name=\"update_db\"></input>";
            $editpanels .= "<input type=\"hidden\" value=\"$submiss_serial\" name=\"submiss_serial\"></input>";
            $editpanels .= "<input type=\"hidden\" value=\"{$field['field_id']}\" name=\"field\"></input>";
            $editpanels .= $element;
            $editpanels .= "<button>submit</button>";
            $editpanels .= "</div></form>";
        } else if (in_array($field['dataclass'], array('xmi'))){
            $fieldsJs .= "'{$field['field_id']}',";
            $field['alias'] = getAlias(
                                    'cor_tbl_module',
                                    $lang,
                                    'itemkey',
                                    "{$field['xmi_mod']}_cd",
                                    1
                            );
            $fieldAliasJs .= "'{$field['alias']}',";
            $element = frmElem($field,$mod_short);
            $editpanels .= "<div id=\"edit_field_{$field['field_id']}\" class=\"edit_field_colorbox\">";
            $editpanels .= "Editing {$field['alias']} for ";
            $editpanels .= "<div class=\"edit_field_itemkeys\"></div>";
            $editpanels .= "<form action=\"\" method=\"POST\">";
            $editpanels .= "<input type=\"hidden\" value=\"\" name=\"multi_edit_itemvalues\" class=\"multi_edit_itemkeys\"></input>";
            $editpanels .= "<input type=\"hidden\" value=\"update_multi\" name=\"update_db\"></input>";
            $editpanels .= "<input type=\"hidden\" value=\"$submiss_serial\" name=\"submiss_serial\"></input>";
            $editpanels .= "<input type=\"hidden\" value=\"{$field['field_id']}\" name=\"field\"></input>";
            $editpanels .= $element;
            $editpanels .= "<button>submit</button>";
            $editpanels .= "</div></form>";
        }
    }
    $editpanels .= "</div>";

    $fieldsJs = substr($fieldsJs,0,-1);
    $fieldsJs .= "];console.log('conf_mac_$disp_mode');</script>";

    $fieldAliasJs = substr($fieldAliasJs,0,-1);
    $fieldAliasJs .= "];</script>";

    echo $editpanels;
    echo $fieldsJs;
    echo $fieldAliasJs;
}
?>
<script type="text/javascript" src="<?php echo $ark_root_path ?>/js/multi_edit.js"></script>
       
</body>
</html>
