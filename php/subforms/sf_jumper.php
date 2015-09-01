<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_module.php
*
* global subform for module navigation for entry and viewing
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
* @author     Andy Dufton <a.dufton@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_txt.php
* @since      File available since Release 0.8
*/


// ---- SETUP ---- //

// Modtypes
if (array_key_exists('op_modtype', $sf_conf)) {
    $modtype = $sf_conf['op_modtype'];
} else {
    $modtype = FALSE;
}
// If modtype is FALSE the fields will only come from one list , if TRUE the 
// fields will come from different field lists. 
if (chkModType($mod_short) && $modtype!=FALSE) {
    $modtype = getModType($mod_short, $sf_val);
    $fields = $sf_conf["type{$modtype}_fields"];
} else {
    $fields = $sf_conf['fields'];
}
// this script can be fed a link_list either live or in the form of fields
if (!isset($jumper_list)) {
    $jumper_list = $fields;
    $cleanup = TRUE;
} else {
    $cleanup = FALSE;
}

// a final check to make sure it is set up
if (!isset($jumper_list)) {
    echo "ADMIN ERROR: the module list was not set up correctly";
}

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
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
    // No Min Views needed for this custom lpanel form
    // Max Views
    case 'p_max_view':
    case 's_max_view':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        // wrap the link list in a <ul>
        print("<ul>\n");  
        // Loop over the modules
        //Debug
        // printPre($jumper_list);
        foreach($jumper_list as $jump) {
            if($jump['item_key']=='auto'){
                $jump['item_key']=reqArkVar('item_key');
            }
            echo mkNavItem($jump['mode'], $jump['button'], $jump['item_key'], $jump['default'], $jump['link']);    
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
        print("<ul id=\"{$sf_conf['sf_html_id']}\">\n");
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
        foreach($jumper_list as $jump) {
            echo $left_panel = mkNavItem($jump['mode'], $jump['button'], $jump['item_key'], $jump['default'], $jump['link']);   
        }
        // Cleanly end list
        print("</ul>");
        // clean up
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_jumper\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_jumper was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;
       
// ends switch
}
// clean up
unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);
unset ($alias_lang_info);
if ($cleanup) {
    unset($jumper_list);
}

?>
