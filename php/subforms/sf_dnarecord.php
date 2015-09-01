<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_dnarecord.php
*
* shows the DNA of a record (lists everything in a record as array and table)
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
* @link       http://ark.lparchaeology.com/svn/trunk/php/subforms/sf_dnarecord.php
* @since      File available since Release 1.0
*/

// ---- SETUP ---- //

// OVERLAY MODE
if ($sf_state == 'overlay') {
    // set up anything that is needed
    // IMPORTANT The user MUST pre-arm this form
    $armed = reqQst($_REQUEST, 'armed');
    $overlay = TRUE;
}

// NORMAL MODES
if (!isset($transclude) && !isset($overlay)) {
    // IMPORTANT The user MUST pre-arm this form
    $armed = reqQst($_REQUEST, 'armed');
}

// RECURSIVE MODE
// as a default, this form will check recursively down an entire record tree
// as an option this can be set to only go down 1 level from the specified sf_key sf_val
if (array_key_exists('op_recursive', $sf_conf)) {
    $recursive = $sf_conf['op_recursive'];
} else {
    $recursive = 'R';
}

// CSS CLASS
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// GET DATA for this record
$record =
    array(
        'itemkey' => $sf_key,
        'itemvalue' => $sf_val,
        'data' => 0,
);
// if there are frags, get the chained data
if ($data_chains = getChData(FALSE, $sf_key, $sf_val, FALSE, $recursive)) {
    $record['data'] = $data_chains;
} else {
    $record['data'] = FALSE;
}
$frags = array();
collateFrags($record['data'], 'frags');
$num_frags = count($frags);

// ---- PROCESS ---- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id']) {
    include_once ('php/update_db.php');
}

// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_rectree = getMarkup('cor_tbl_markup', $lang, 'rectree');
$mk_reclabel = getMarkup('cor_tbl_markup', $lang, 'reclabel');
$mk_numfrags = getMarkup('cor_tbl_markup', $lang, 'numfrags');

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
    
    // Overlay View
    case 'overlay':
        // OUTPUT
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        echo "<h5>{$mk_reclabel}: {$sf_key} = $sf_val</h5>";
        echo "<p>{$mk_numfrags}: {$num_frags}</p>";
        echo "<table border=\"1\">\n";
        echo "<tr><th>#</th><th>table</th><th>id</th><th>child frags?</th></tr>\n";
        $i = 1;
        foreach ($frags as $key => $frag) {
            if ($frag['attached_frags']) {
                $children = "YES";
            } else {
                $children = "NO";
            }
            echo "<tr><td>{$i}</td><td>{$frag['table']}</td><td>{$frag['id']}</td><td>{$children}</td></tr>\n";
            $i++;
        }
        echo "</table>\n";
        echo "<p>$mk_rectree</p>";
        // DEBUG
        // printPre($record);
        print("</div>");
        break;
        
    // Max Views
    case 'p_max_view':
    case 's_max_view':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        echo "<h4>{$mk_reclabel}: {$sf_key} = $sf_val</h4>";
        echo "<p>{$mk_numfrags}: {$num_frags}</p>";
        echo "<table border=\"1\">\n";
        echo "<tr><th>#</th><th>table</th><th>id</th><th>child frags?</th></tr>\n";
        $i = 1;
        foreach ($frags as $key => $frag) {
            if ($frag['attached_frags']) {
                $children = "YES";
            } else {
                $children = "NO";
            }
            echo "<tr><td>{$i}</td><td>{$frag['table']}</td><td>{$frag['id']}</td><td>{$children}</td></tr>\n";
            $i++;
        }
        echo "</table>\n";
        echo "<p>$mk_rectree</p>";
        printPre($record);
        print("</div>");
        // clean up
        break;

    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_dnarecord\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_dnarecord was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'.</p>\n";
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

?>
