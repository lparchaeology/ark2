<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* subforms/sf_itemsummary.php
*
* global subform for dealing with numbers
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
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Henriette Roued <henriette@roued.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_number.php
* @since      File available since Release 0.6
*
*/


// -- SETUP -- //
// form_id
$form_id = $sf_conf['sf_html_id'].'_form';

$modules = $sf_conf['modules'];

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// -- MARKUP -- //
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

function getMissingNumbers($mod_short){
    if( ob_get_level() > 0 ) ob_flush();
    flush();    
    $sqltext = "SELECT
        CONCAT(z.expected, IF(z.got-1>z.expected, CONCAT('-',z.got-1), '')) AS missing
            FROM (
                SELECT
                    @rownum:=@rownum+1 AS expected,
                        IF(@rownum={$mod_short}_no, 0, @rownum:={$mod_short}_no) AS got
                        FROM
                            (SELECT @rownum:=0) AS a
                                JOIN {$mod_short}_tbl_{$mod_short}
                                ORDER BY {$mod_short}_no
             ) AS z
             WHERE z.got!=0;";
    $params = [];
    $sql = dbPrepareQuery($sqltext,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    $results = $sql->fetchAll(PDO::FETCH_ASSOC);
    $return = "";
    $i = 0;
    foreach ( $results as $result ) {
        $return .= $result['missing'];
        $i++;
        if ($i<count($results)){
            $return .= ", ";
        }
    }
    return $return;
}


// -- STATE SPECFIC -- //
// for each state get specific elements and then produce output
switch ($sf_state) {
    // min states
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
         print("<div id=\"number_viewer\" class=\"{$sf_cssclass}\">");
         // put in the nav
         printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
         if ($error) {
             feedBk('error');
         }
         if ($message) {
             feedBk('message');
         }
         print "</div>";
        break;
        
    // Max Views
    case 'p_max_view':
    case 's_max_view':
        print("<div id=\"number_viewer\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        
        if ($message) {
            feedBk('message');
        }
        
        $summary_table = [];
        foreach ( $modules as $mod_short ) {
            $modkey = $mod_short . '_cd';
            $mod_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $modkey, 1);
            $summary_table['titles'][] = $mod_alias."s";
            
            $tbl = $mod_short . '_tbl_' . $mod_short;
            $mod_no = $mod_short . '_no';
            $highest = getSingle("MAX($mod_no)", $tbl, '1');
            $summary_table['highest'][] = $highest;

            $mod_cd = $mod_short . '_cd';
            $latest = getSingle($mod_no, $tbl, '1 ORDER BY cre_on DESC LIMIT 1');
            $summary_table['latest'][] = $latest;

            $count = getSingle("COUNT($mod_no)", $tbl, '1');
            $summary_table['count'][] = $count;
            
            $countmissing = max(0, $highest - $count);
            $summary_table['countmissing'][] = $countmissing;
            
            $missing = getMissingNumbers($mod_short);
            $summary_table['missing'][] = $missing;
            
        }
        
        $var = "<table class=\"summary_table\">";
        $var .= "<thead>";
        $var .= "<th class=\"label\"><label>Modules</label></th>";
        foreach ($summary_table['titles'] as $cell){
            $var .= "<th>";
            $var .= $cell;
            $var .= "</th>";
        }
        $var .= "</thead>";
        $var .= "<tr>";
        $var .= "<td class=\"label\"><label>Highest</label></td>";
        foreach ($summary_table['highest'] as $cell){
            $var .= "<td>";
            $var .= $cell;
            $var .= "</td>";
        }
        $var .= "</tr>";
        $var .= "<tr>";
        $var .= "<td class=\"label\"><label>Latest</label></td>";
        foreach ($summary_table['latest'] as $cell){
            $var .= "<td>";
            $var .= $cell;
            $var .= "</td>";
        }
        $var .= "</tr>";
        $var .= "<tr>";
        $var .= "<td class=\"label\"><label>Count</label></td>";
        foreach ($summary_table['count'] as $cell){
            $var .= "<td>";
            $var .= $cell;
            $var .= "</td>";
        }
        $var .= "</tr>";
        $var .= "<tr>";
        $var .= "<td class=\"label\"><label>Count Missing</label></td>";
        foreach ($summary_table['countmissing'] as $cell){
            $var .= "<td>";
            $var .= $cell;
            $var .= "</td>";
        }
        $var .= "</tr>";
        $var .= "<tr>";
        $var .= "<td class=\"label\"><label>Missing</label></td>";
        foreach ($summary_table['missing'] as $cell){
            $var .= "<td>";
            $var .= $cell;
            $var .= "</td>";
        }
        $var .= "</tr>";
        $var .= "</table>";
        print($var);
        echo "</div>\n";
        break;
    
    // Max ent and edit
    case 'p_max_edit':
    case 'p_max_ent':
    case 's_max_edit':
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_number\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_itemsummary was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
} // ends switch

unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);

?>