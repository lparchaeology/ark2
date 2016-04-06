<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_view/subforms/sf_maysavedstuff.php
*
* a data_view subform displaying lists of saved stuff
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
* @category   subforms
* @package    ark
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_view/subforms/sf_exportdownload.php
* @since      File available since Release 0.8
*
* This SF is expected to run in an overlay or in the left panel. Standard states could be
* added to allow this to function as a normal SF if any reason for that became apparent.
*
* Getting the right sf_conf requires a small piece of non-standard behavoir. Typically,
* an SF will be passed an sf_conf to it in the form of $sf_conf and it is not required to
* question this. In the case of SFs displayed within the overlay_holder.php, this parent
* script must get an sf_conf based on the name of the variable passed to the querystring.
* As this form may be triggered from a non module specific page (eg data_view.php), it must
* figure out if the result set being exported is the same as the module that overlay_holder
* has selected. If not, the relevant settings file is called and the sf_conf is switched.
*
* NB: overlay_holder.php tries to figure out a module based on the sf_key it is sent. If
* it is not sent an sf_key, it will fall back on a default (as per reqArkVar()).
*
*/

// ---- SETUP ---- //
// there are three admin configurable switches:
// 1 - sgrp
// valid options: FALSE | unset | sgrp number
// this will be used to restrict the returned items to a specific group such as public or admins
if (array_key_exists('op_sgrp', $sf_conf)) {
    $sgrp = $sf_conf['op_sgrp'];
} else {
    $sgrp = FALSE;
}
// 2 - sglorset
// valid options: FALSE | unset | string: 'single'; 'set'
if (array_key_exists('op_sglorset', $sf_conf)) {
    $sglorset = $sf_conf['op_sglorset'];
} else {
    $sglorset = FALSE;
}
// 3 - user_id or not
// valid options: FALSE | unset | string: and id number
if (array_key_exists('op_user_id', $sf_conf)) {
    $op_user_id = $sf_conf['op_user_id'];
} else {
    $op_user_id = FALSE;
}

// handle the case that the filter view mode isn't set up by the conf
if (!array_key_exists('op_ftr_mode', $sf_conf)) {
    $ftr_mode = 'standard';
} else {
    $ftr_mode = $sf_conf['op_ftr_mode'];
}

$mk_publicfilters = getMarkup('cor_tbl_markup', $lang, 'publicfilters');
$mk_savedfilters = getMarkup('cor_tbl_markup', $lang, 'savedfilters');
$mk_your = getMarkup('cor_tbl_markup', $lang, 'your');

// ---- PROCESS ---- //
// process is done by filters.php
include_once('php/data_view/filters.php');


// ---- COMMON ---- //
// get common elements for all states

//$filters = getMulti('cor_tbl_filter', "cre_by = $user_id AND sgrp != 3");
$filters = getMulti('cor_tbl_filter', "cre_by = $user_id AND type != 'feed' AND sgrp != 3");
//$filters = getMulti('cor_tbl_filter', "cre_by = {$user_id} AND type = 'set' AND sgrp != 3");
//$filters = getMulti('cor_tbl_filter', "sgrp = 3 AND type = 'single'");
//$filters = getMulti('cor_tbl_filter', "sgrp = 3 AND type = 'set'");

// make the filters into a resolved list item
$filter_ul = FALSE;
if ($filters) {
    $filter_ul .= "<ul class=\"ftr_list\">";
    foreach ($filters as $filter) {
        // loop thru them all getting the filters
        $ftr_array = getFtr($filter['id']);
        // make a filter url up
        $ftr_url = "retftrset={$filter['id']}";
        // print a link for the filter
        $filter_ul .= "<li><label>";
        $filter_ul .= "<a href=\"{$_SERVER['PHP_SELF']}?$ftr_url\">";
        $filter_ul .= "{$ftr_array['nname']}</a></label>";
        $filter_ul .= "&nbsp;";
        // delete option
        $del_sw = "<a href=\"{$_SERVER['PHP_SELF']}?delftr={$filter['id']}\" class=\"deletebtn\">&nbsp;</a>";
        // if this person is an admin put in a 'make public' option
        $pub_sw = "<a href=\"{$_SERVER['PHP_SELF']}?publicftr={$filter['id']}\">";
        $pub_sw .= "<img src=\"$skin_path/images/results/public.png\" class=\"med\" alt=\"[-]\" />";
        $pub_sw .= "</a>";
        // if this person is an admin put in a 'make public' option
        if ($is_an_admin) {
            
        }
        // if this person owns this filter put in a delete option
        if ($is_an_admin) {
            
        }
        $filter_ul .= "</li>\n";
    }
    $filter_ul .= "</ul>";
}

// Labels and so on
$mk_your = getMarkup('cor_tbl_markup', $lang, 'your');
$mk_savedfilters = getMarkup('cor_tbl_markup', $lang, 'savedfilters');

// CSS
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}


// ---- STATE SPECFIC
// for each state get specific elements and then produce output
switch ($sf_state) {
    // Overlays
    case 'overlay':
        $sv = "<ul><li id=\"save_ftr\">";
        $mk_saveas = getMarkup('cor_tbl_markup', $lang, 'saveas');
        $sv .= "<label>$mk_saveas</label>";
        // save a filterset
        $sv .= dispSaveOp('set', 'data_view.php');
        // close out cleanly
        $sv .= "</li></ul>";
        echo $sv;
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        echo "<h4>{$mk_your} {$mk_savedfilters}</h4>";
        // The standard filters will not differentiate between single filters or filter sets
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // make the filters into a resolved list item
        $filter_ul = FALSE;
        if ($filters) {
            $filter_ul .= "<ul class=\"ftr_list\">";
            foreach ($filters as $filter) {
                // loop thru them all getting the filters
                $ftr_array = getFtr($filter['id']);
                // make a filter url up
                $ftr_url = "retftrset={$filter['id']}";
                // print a link for the filter
                $filter_ul .= "<li><label>";
                $filter_ul .= "<a href=\"{$_SERVER['PHP_SELF']}?$ftr_url&amp;sf_conf=$sf_conf_name\">";
                $filter_ul .= "{$ftr_array['nname']}</a></label>";
                $filter_ul .= "&nbsp;";
                // delete option
                $del_sw = "<a href=\"{$_SERVER['PHP_SELF']}?delftr={$filter['id']}&amp;sf_conf=$sf_conf_name\" class=\"deletebtn\">&nbsp;</a>";
                // if this person is an admin put in a 'make public' option
                $pub_sw = "<a href=\"{$_SERVER['PHP_SELF']}?publicftr={$filter['id']}\">";
                $pub_sw .= "<img src=\"$skin_path/images/results/public.png\" class=\"med\" alt=\"[-]\" />";
                $pub_sw .= "</a>";
                // if this person is an admin put in a 'make public' option
                if ($is_an_admin) {

                }
                // if this person owns this filter put in a delete option
                if ($is_an_admin) {
                    $filter_ul .= $del_sw;
                }
                $filter_ul .= "</li>\n";
            }
            $filter_ul .= "</ul>";
        }
        echo "$filter_ul";
        echo "</div>";
        break;
        
    case 'lpanel':
    case 'p_max_view':
    case 's_max_view':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        printf(sfNav($mk_your.' '.$mk_savedfilters, $cur_col_id, $cur_sf_id, $$disp_cols));
        
        // ----------------
        // SAVED FILTERS
        switch ($ftr_mode) {
            case 'standard':
                if ($filters) {
                    echo "<ul class=\"ftr_list\" >";
                    foreach ($filters as $filter) {
                        // loop thru them all getting the filters
                        $tmp_ftr = getFtr($filter['id']);
                        // make a filter url up
                        // $ftr_url = filterUrl($tmp_ftr); As of v1.0 this is deprecated but still works
                        // make url
                        $ftr_url = "retftrset={$filter['id']}";
                        // print a link for the filter
                        printf("<li><label>");
                        print("<a href=\"{$conf_search_viewer}?ftr_mode=standard&amp;$ftr_url\">");
                        print("{$tmp_ftr['nname']}</a></label>");
                        print("&nbsp;");
                        // delete option
                        print("<a href=\"{$conf_search_viewer}?delftr={$filter['id']}\" class=\"deletebtn\">&nbsp;</a>");
                        // if this person is an admin put in a 'make public' option
                        // For now we won't be using public options in the standard filter panel
                        // if ($is_an_admin) {
                        //     print("<a href=\"{$_SERVER['PHP_SELF']}?publicftr={$filter['id']}\">");
                        //     print("<img src=\"$skin_path/images/results/public.png\" class=\"med\" alt=\"[-]\" />");
                        //     print("</a>");
                        // }
                        print("</li>\n");
                    }
                    echo "</ul>";
                }
                break;
                
            case 'advanced':
                echo "<h4>{$mk_your} {$mk_savedfilters}</h4>";
                // Single Filters
                $p_ftrs = getMulti('cor_tbl_filter', "cre_by = $user_id AND type = 'single' AND sgrp != 3");
                if ($p_ftrs) {
                    echo "<ul class=\"ftr_list\" >";
                    foreach ($p_ftrs as $filter) {
                        // loop thru them all getting the filters
                        $tmp_ftr = getFtr($filter['id']);
                        // make a filter url up
                        $ftr_url = filterUrl($tmp_ftr);
                        // print a link for the filter
                        printf("<li><label>");
                        print("<a href=\"{$_SERVER['PHP_SELF']}?$ftr_url\">");
                        print("{$tmp_ftr['nname']}</a></label>");
                        print("&nbsp;");
                        // delete option
                        print("<a href=\"{$_SERVER['PHP_SELF']}?delftr={$filter['id']}\" class=\"deletebtn\">&nbsp;</a>");
                        // if this person is an admin put in a 'make public' option
                        if ($is_an_admin) {
                            print("<a href=\"{$_SERVER['PHP_SELF']}?publicftr={$filter['id']}\">");
                            print("<img src=\"$skin_path/images/results/public.png\" class=\"med\" alt=\"[-]\" />");
                            print("</a>");
                        }
                        print("</li>\n");
                    }
                    echo "</ul>";
                }
                break;
        }
        
        // PUBLIC SAVED SEARCHES
        switch($view) {
        case 'standard':
        // FOR NOW WE WON'T INCLUDE ANY SAVED FILTERS IN STANDARD MODE
        break;
        case 'advanced':
        echo "<h4>$mk_publicfilters</h4>";
        echo "<ul class=\"ftr_list\">";
        // Single Filters
        $p_ftrs = getMulti('cor_tbl_filter', "sgrp = 3 AND type = 'single'");
        if ($p_ftrs) {
            foreach ($p_ftrs as $id) {
                // loop thru them all getting the filters
                $tmp_ftr = getFtr($id['id']);
                // make a filter url up
                $ftr_url = filterUrl($tmp_ftr);
                // print a link for the filter
                printf("<li><label>");
                print("<a href=\"{$_SERVER['PHP_SELF']}?$ftr_url\">");
                print("{$tmp_ftr['nname']}</a></label>");
                // if this user created this public filter give a 'make private' option
                if ($tmp_ftr['cre_by'] == $user_id) {
                    print("<a href=\"{$_SERVER['PHP_SELF']}?pvrftr={$filter['id']}\">");
                    print("<img src=\"$skin_path/images/results/public.png\" class=\"med\" alt=\"[-]\" />");
                    print("</a>");
                }
                print("</li>");
            }
        }
        // FilterSets
        $p_ftrs = getMulti('cor_tbl_filter', "sgrp = 3 AND type = 'set'");
        if ($p_ftrs) {
            foreach ($p_ftrs as $id) {
                // loop thru them all getting the filters
                $tmp_ftrs = getFtr($id['id']);
                // make a filter url up
                $ftr_url = "retftrset={$id['id']}";
                // print a link for the filter
                printf("<li><label>[s]&nbsp;");
                print("<a href=\"{$_SERVER['PHP_SELF']}?$ftr_url\">");
                print("{$tmp_ftrs['nname']}</a></label>");
                // if this user created this public filter give a 'make private' option
                if ($tmp_ftr['cre_by'] == $user_id) {
                    print("<a href=\"{$_SERVER['PHP_SELF']}?pvrftr={$filter['id']}\">");
                    print("<img src=\"$skin_path/images/results/public.png\" class=\"med\" alt=\"[-]\" />");
                    print("</a>");
                }
                print("</li>");
            }
        }
        break;
        }
        // ----------------
        
        // close out the sf
        echo "</div>";
    break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_mysavedstuff\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_mysavedstuff was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;
       
// ends switch
}
// clean up
unset ($sf_conf);
unset ($sf_state);

?>
