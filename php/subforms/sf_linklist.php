<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_linklist.php
*
* global subform for lists of links
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_txt.php
* @since      File available since Release 0.6
*/


// ---- SETUP ---- //

// Force a mod_short
$item_key = reqArkVar('item_key', $default_itemkey);
$mod_short = substr($item_key, 0, 3);

// The default for modules with several modtypes is to have one field list,
// which is the same for all the differnt modtypes
// If you want to use different field lists for each modtype add to the subform
// settings 'op_modtype'=> TRUE and instead of 'links' => array( add
// 'type1_fields' => array( for each type. 
if (array_key_exists('op_modtype', $sf_conf)) {
    $modtype = $sf_conf['op_modtype'];
} else {
    $modtype = FALSE;
}

// If modtype is FALSE the links will only come from one list , if TRUE the
// links will come from different link lists.
if (chkModType($mod_short) && $modtype!=FALSE) {
    $modtype = getModType($mod_short, $sf_val);
    $links = $sf_conf["type{$modtype}_links"];
} else {
    $links = $sf_conf['links'];
}

// this script can be fed a link_list either live or in teh form of links
if (!isset($link_list)) {
    $link_list = $links;
    $cleanup = TRUE;
} else {
    $cleanup = FALSE;
}
// a final check to make sure it is set up
if (!isset($link_list)) {
    echo "ADMIN ERROR: the link list was not set up correctly";
}

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// Check for the type of linklist needed (img or text)
if (array_key_exists('op_linktype', $sf_conf)) {
    $linktype = $sf_conf['op_linktype'];
} else {
    // Use link default
    $linktype = '';
}

// ---- PROCESS ---- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id']) {
    include_once ('php/update_db.php');
}

// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch ($sf_state) {
    // Min Views
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        print("</div>");
    break;
    
    // Max Views
    case 'p_max_ent':
    case 'p_max_view':
    case 's_max_view':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        // wrap the link list in a <ul>
        print("<ul>\n");
        // if we have an item key append it
        if ($item_key && $$item_key) {
            foreach ($link_list as $key => $link) {
                $link_list[$key]['href'] = $link['href']."&amp;$item_key={$$item_key}";
            }
        }
        // this routine to add in the mod
        $alias =
                getAlias(
                    'cor_tbl_module',
                    $lang,
                    'itemkey',
                    $item_key,
                    1
        );
        if ($sf_val != '' && isset($left_key) && $left_key == 'set') {
            printf('<li class="val"><h6>'.$alias.'</h6> '.$sf_val.'</li>');
        }
        // This routine to set instructions if appropriate
        $short_mods = explode('_',$sf_key);
        $short_mod = $short_mods[0];
        $markup_search = $short_mod.'_instr';
        $failed = "failed to get markup '". $markup_search."'";
        if (getMarkup('cor_tbl_markup', $lang, $markup_search) != $failed && $left_instr == 'set') {
            $instruction = getMarkup('cor_tbl_markup', $lang, $markup_search);
            printf('<li class="instr" ><h6>'.$alias.' instructions</h6>'.$instruction.'</li>');
        }
        // Loop over the links
        foreach($link_list as $link) {
            echo mkLink($link, $linktype);
        }
        // Cleanly end list
        print("</ul>");
        print("</div>");
        // clean up
        break;

    // Max Views
    case 'lpanel':
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        // wrap the link list in a <ul>
        print("<ul id=\"{$sf_conf['sf_html_id']}\" class=\"$sf_cssclass\" >\n");
        // Loop over the links
        foreach($link_list as $link) {
            if ($link['list_class']) {
                print("<li class=\"{$link['list_class']}\" >\n");
            } else {
                print("<li>\n");
            }
            echo mkLink($link, $linktype);
            print("</li>\n");
        }
        // Cleanly end list
        print("</ul>");
        // clean up
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_linklist\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_linklist was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;
       
// ends switch
}
// clean up
unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($links);
unset ($alias_lang_info);
if ($cleanup) {
    unset($link_list);
}

?>
