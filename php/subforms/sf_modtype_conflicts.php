<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_modtype_conflicts.php
*
* global subform that displays the setup (DNA ;-) of a modtype
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
* @since      File available since Release 0.8
*
* This SF also checks for conflicts in the case of a change modtype routine
*
*/

// ---- SETUP ---- //

// OVERLAY MODE
if ($sf_state == 'overlay') {
    // set up anything that is needed
    // IMPORTANT The user MUST pre-arm this form
    $armed = reqQst($_REQUEST, 'armed');
    $overlay = TRUE;
}

// ALL MODES
$modtype = getModtype($mod_short, $sf_val);
$modtype_alias = getAlias($mod_short.'_lut_'.$mod_short.'type', $lang, 'id', $modtype, 1);
$target_modtype = reqQst($_REQUEST, 'modtype');
$target_modtype_alias = getAlias($mod_short.'_lut_'.$mod_short.'type', $lang, 'id', $target_modtype, 1);

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// ---- DATA ----
// do the number crunching (output below)
// get the subforms for this module
$sfs = getSfs($mod_short);
// count them for output later
$num_sfs = count($sfs);
// split out the SFs using op_modtype to define modtype specifc fields
$modtype_sfs = array();
foreach ($sfs as $key => $sf) {
    if (array_key_exists('op_modtype', $sf)) {
        if ($sf['op_modtype']) {
            $modtype_sfs[$key] = $sf;
            $modtype_sfs[$key]['op_modtype'] = 'Modtypes used';
            $sfs[$key]['op_modtype'] = 'Modtypes used';
        } else {
            $sfs[$key]['op_modtype'] = FALSE;
        }
    } else {
        $sfs[$key]['op_modtype'] = FALSE;
    }
}
// split out relevant chkModTypeCond SFs
foreach ($sfs as $key => $sf) {
    // 1 - Are conditions used?
    if (array_key_exists('op_condition', $sf) && $sf['op_condition']) {
        // set a marker for display later
        $sfs[$key]['op_cond_used'] = 'Conditions used';
        // 2 - Is the chkModTypeCond() used?
        // check over all the conditions
        // first set these two markers (to FALSE) before looping over the conditions
        // we assume no conflict unless triggered in the loop
        $sfs[$key]['chkModTypeCond_used'] = FALSE;
        $sfs[$key]['op_condition_conflict'] = FALSE;
        // loop over the conditions
        foreach ($sf['op_condition'] as $cond_key => $cond) {
            if ($cond['func'] == 'chkModTypeCond') {
                // if so, set the marker for display later
                $sfs[$key]['chkModTypeCond_used'] = 'chkModTypeCond used';
                // 3 - is the condition refering to this modtype?
                if ($cond['args'] == $modtype) {
                    $sfs[$key]['op_condition_conflict'] = TRUE;
                    // if all 3 conditions evaluate true, then we need to add this to the
                    // modtype_sfs (assuming it isnt already there)
                    if (!array_key_exists($key, $modtype_sfs)) {
                        $modtype_sfs[$key] = $sf;
                    }
                }
            }
        }
    } else {
        $sfs[$key]['op_cond_used'] = FALSE;
        // also set the markers for questions 2 and 3 to off
        $sfs[$key]['chkModTypeCond_used'] = FALSE;
        $sfs[$key]['op_condition_conflict'] = FALSE;
    }
}
// Count the number of modtype conflicted SFs
$num_modtype_sflist = count($modtype_sfs);

// Now examine each of the conflicted subforms
// First do the op_modtypes (conditional sf's below)
// put informnation for output into an array
$conflicted_frags = array();
// loop over each sf
foreach ($modtype_sfs as $key => $sf) {
    // examine op_modtype tables
    if (array_key_exists('op_modtype', $sf) && $sf['op_modtype']) {
        // Set up three vars to hold data for output
        $conflict_count = 0;
        $conflict_frag_count = 0;
        $prc_fields = array();
        // Get the mod fields
        $mod_fields = $sf["type{$modtype}_fields"];
        foreach ($mod_fields as $fd_key => $field) {
            $field_id = "{$key}-{$field['dataclass']}-{$field['classtype']}";
            $field['this_mod'] = TRUE;
            $field['target_mod'] = FALSE;
            $prc_fields[$field_id] = $field;
        }
        // get the target fields
        $tgt_fields = $sf["type{$target_modtype}_fields"];
        foreach ($tgt_fields as $fd_key => $field) {
            $field_id = "{$key}-{$field['dataclass']}-{$field['classtype']}";
            if (!array_key_exists($field_id, $prc_fields)) {
                $field['target_mod'] = TRUE;
                $field['this_mod'] = FALSE;
                $prc_fields[$field_id] = $field;
            } else {
                $prc_fields[$field_id]['target_mod'] = TRUE;
            }
        }
        // Now process the fields
        foreach ($prc_fields as $fd_key => $field) {
            if ($field['target_mod'] && $field['this_mod']) {
                $prc_fields[$fd_key]['conflict'] = FALSE;
                $prc_fields[$fd_key]['data'] = FALSE;
            }
            if (!$field['target_mod'] && $field['this_mod']) {
                $prc_fields[$fd_key]['conflict'] = TRUE;
                // as there is a possible conflict, check for data
                if ($ch = getCh($field['dataclass'], $sf_key, $sf_val, $field['classtype'])) {
                    $data = array();
                    foreach ($ch as $key => $frag) {
                        $data[$key]['dataclass'] = $field['dataclass'];
                        $data[$key]['frag_id'] = $frag;
                        // record this frag to the conflicted frags array
                        $conflicted_frags[] =
                            array(
                                'dataclass' => $field['dataclass'],
                                'id' => $frag
                        );
                        $conflict_frag_count++;
                    }
                    $prc_fields[$fd_key]['data'] = $data;
                    $conflict_count++;
                } else {
                    $prc_fields[$fd_key]['data'] = FALSE;
                }
            }
            if ($field['target_mod'] && !$field['this_mod']) {
                $prc_fields[$fd_key]['conflict'] = FALSE;
                $prc_fields[$fd_key]['data'] = 'not chkd';
            }
        }
        // place this processed data into an array for output and clean up vars for reuse
        $op_modtype_output[$sf['sf_html_id']]['fields'] = $prc_fields;
        unset($prc_fields);
        $op_modtype_output[$sf['sf_html_id']]['conflict_count'] = $conflict_count;
        unset($conflict_count);
        $op_modtype_output[$sf['sf_html_id']]['conflict_frag_count'] = $conflict_frag_count;
        unset($conflict_frag_count);
    }
    // Now examine conditional sf's
    if (array_key_exists('op_condition', $sf) && $sf['op_condition']) {
        $conflict_frag_count = 0;
        $conflict_count = 0;
        // loop over the relevant fields   
        $fields = $sf['fields'];
        foreach ($fields as $fd_key => $field) {
            $field_id = "{$key}-{$field['dataclass']}-{$field['classtype']}";
            $prc_fields[$field_id] = $field;
        }
        foreach ($prc_fields as $fd_key => $field) {
            if ($ch = getCh($field['dataclass'], $sf_key, $sf_val, $field['classtype'])) {
                $data = array();
                foreach ($ch as $key => $frag) {
                    $data[$key]['dataclass'] = $field['dataclass'];
                    $data[$key]['frag_id'] = $frag;
                    // record this frag to the conflicted frags array
                    $conflicted_frags[] =
                        array(
                            'dataclass' => $field['dataclass'],
                            'id' => $frag
                    );
                    $conflict_frag_count++;
                }
                $prc_fields[$fd_key]['data'] = $data;
                $conflict_count++;
            } else {
                $prc_fields[$fd_key]['data'] = FALSE;
            }
        }
        // place this processed data into an array for output and clean up vars for reuse
        $conditionals_output[$sf['sf_html_id']]['fields'] = $prc_fields;
        unset($prc_fields);
        $conditionals_output[$sf['sf_html_id']]['conflict_count'] = $conflict_count;
        unset($conflict_count);
        $conditionals_output[$sf['sf_html_id']]['conflict_frag_count'] = $conflict_frag_count;
        unset($conflict_frag_count);
    }
}

// ---- PROCESS ---- //
// assumes that update db is being called at the page level
if ($update_db === $sf_conf['sf_html_id']) {
    //include_once ('php/update_db.php');
    // this sf has no edit states
}

// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
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
        echo "<h4>{$mk_reclabel}: {$sf_key} = $sf_val</h4>";
        echo "<p>Current Modtype: {$modtype} - {$modtype_alias}</p>";
        echo "<p>Target Modtype: {$target_modtype} - {$target_modtype_alias}</p>";
        echo "<p>Total subforms: $num_sfs</p>\n<p>Conflicted subforms: $num_modtype_sflist</p>\n";
        // Overview of all subforms
        echo "<br/>\n";
        echo "<h4>Subforms Overview</h4>";
        echo "<table border=\"1\">\n";
        echo "<tr><th>#</th><th>subform</th><th>frame?</th><th>op_mo dtype?</th><th>condi tional?</th><th>chkMod  TypeCond?</th><th>Cond affects?</th><th>Check Conflicts?</th></tr>\n";
        $i = 1;
        foreach ($sfs as $key => $sf) {
            echo "<tr><td>{$i}</td><td>{$sf['sf_html_id']}</td>";
            if ($sf['frame']) {
                echo "<td style=\"color: blue\">{$sf['frame']}</td>";
            } else {
                echo "<td style=\"color: green\">&otimes;</td>";
            }
            if (array_key_exists('op_modtype', $sf) && $sf['op_modtype']) {
                echo "<td style=\"color: green\">&radic;</td>";
            } else {
                echo "<td style=\"color: red\">&times;</td>";
            }
            if ($sf['op_cond_used']) {
                echo "<td style=\"color: green\">&radic;</td>";
            } else {
                echo "<td style=\"color: red\">&times;</td>";
            }
            if ($sf['chkModTypeCond_used']) {
                echo "<td style=\"color: green\">&radic;</td>";
            } else {
                echo "<td style=\"color: red\">&times;</td>";
            }
            if ($sf['op_condition_conflict']) {
                echo "<td style=\"color: green\">&radic; - {$sf['op_condition_conflict']}</td>";
            } else {
                echo "<td style=\"color: red\">&times;</td>";
            }
            if ($sf['op_condition_conflict'] OR $sf['op_modtype']) {
                echo "<td style=\"color: green\">&radic;</td>";
            } else {
                echo "<td style=\"color: red\">&times;</td>";
            }
            echo "</tr>\n";
            $i++;
        }
        unset($i);
        echo "</table>\n";
        echo "<br/>\n<br/>\n";
        // Output analysis to conflicted tables
        echo "<h4>Review of each affected SF</h4>\n";
        // output op_modtype
        if (isset($op_modtype_output)) {
            foreach ($op_modtype_output as $key => $sf) {
                echo "<h5>Subform: {$key}</h5>\n";
                echo "<table border=\"1\">\n";
                echo "<tr><th>#</th><th>Field</th><th>This Mod?</th><th>Target Mod?</th><th>Conflict?</th><th>Data?</th></tr>\n";
                $i = 1;
                // OUTPUT
                foreach ($sf['fields'] as $fd_key => $field) {
                    echo "<tr><td>{$i}</td><td>$fd_key</td>";
                    if ($field['this_mod']) {
                        echo "<td style=\"color: green\">&radic;</td>";
                    } else {
                        echo "<td style=\"color: red\">&times;</td>";
                    }
                    if ($field['target_mod']) {
                        echo "<td style=\"color: green\">&radic;</td>";
                    } else {
                        echo "<td style=\"color: red\">&times;</td>";
                    }
                    if ($field['conflict']) {
                        echo "<td style=\"color: blue\">?? &#x2192;</td>";
                    } else {
                        echo "<td style=\"color: green\">&otimes;</td>";
                    }
                    if (is_array($field['data'])) {
                        echo "<td><ul style=\"color: red;\">";
                        foreach ($field['data'] as $key => $value) {
                            echo "<li>{$value['dataclass']}: {$value['frag_id']}</li>";
                        }
                        echo "</ul></td>\n";
                    } else {
                        echo "<td style=\"color: green\">&otimes;</td>";
                    }
                    echo "</tr>\n";
                    $i++;
                }
                echo "</table>\n";
                echo "<p>Conflicted fields in this subform: {$sf['conflict_count']}</p>\n";
                echo "<p>Conflicted fragments in this subform: {$sf['conflict_frag_count']}</p>\n";
                echo "<br/>\n<br/>\n";
            }
        }
        // output conditional sf's
        if (isset($conditionals_output)) {
            foreach ($conditionals_output as $key => $sf) {
                echo "<h5>Subform: {$key}</h5>\n";
                echo "<table border=\"1\">\n";
                echo "<tr><th>#</th><th>Field</th><th>Data?</th></tr>\n";
                $i = 1;
                // loop over the fields in this sf
                foreach ($sf['fields'] as $fd_key => $field) {
                    echo "<tr><td>{$i}</td><td>$fd_key</td>";
                    if (is_array($field['data'])) {
                        echo "<td><ul style=\"color: red;\">";
                        foreach ($field['data'] as $key => $value) {
                            echo "<li>{$value['dataclass']}: {$value['frag_id']}</li>";
                        }
                        echo "</ul></td>\n";
                    } else {
                        echo "<td style=\"color: green\">&otimes;</td>";
                    }
                    echo "</tr>\n";
                    $i++;
                }
                echo "</table>\n";
                echo "<p>Conflicted fields in this subform: {$sf['conflict_count']}</p>\n";
                echo "<p>Conflicted fragments in this subform: {$sf['conflict_frag_count']}</p>\n";
                echo "<br/>\n<br/>\n";
            }
        }
        // report on the conflicted fragments
        echo "<h4>Summary of conflicted fragments from all SFs</h4>\n";
        echo "<table border=\"1\">\n";
        echo "<tr><th>#</th><th>Frag ID</th><th>Class</th><th>Table</th></tr>\n";
        $i = 1;
        foreach ($conflicted_frags as $key => $frag) {
            $tbl = 'cor_tbl_'.$frag['dataclass'];
            echo "<tr><td>{$i}</td><td>{$frag['id']}</td><td>{$frag['dataclass']}</td><td>$tbl</td></tr>\n";
            $i++;
        }
        echo "</table>\n";
        echo "<br/>\n<br/>\n";
        print("</div>");
        // clean up
        break;
        
    // Max Views
    case 'p_max_view':
    case 's_max_view':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        echo "<h4>{$mk_reclabel}: {$sf_key} = $sf_val</h4>";
        echo "<p>Current Modtype: {$modtype} - {$modtype_alias}</p>";
        echo "<p>Target Modtype: {$target_modtype} - {$target_modtype_alias}</p>";
        echo "<p>Total subforms: $num_sfs</p>\n<p>Conflicted subforms: $num_modtype_sflist</p>\n";
        // Overview of all subforms
        echo "<br/>\n";
        echo "<h4>Subforms Overview</h4>";
        echo "<table border=\"1\">\n";
        echo "<tr><th>#</th><th>subform</th><th>frame?</th><th>op_mo dtype?</th><th>condi tional?</th><th>chkMod  TypeCond?</th><th>Cond affects?</th><th>Check Conflicts?</th></tr>\n";
        $i = 1;
        foreach ($sfs as $key => $sf) {
            echo "<tr><td>{$i}</td><td>{$sf['sf_html_id']}</td>";
            if ($sf['frame']) {
                echo "<td style=\"color: blue\">{$sf['frame']}</td>";
            } else {
                echo "<td style=\"color: green\">&otimes;</td>";
            }
            if (array_key_exists('op_modtype', $sf) && $sf['op_modtype']) {
                echo "<td style=\"color: green\">&radic;</td>";
            } else {
                echo "<td style=\"color: red\">&times;</td>";
            }
            if ($sf['op_cond_used']) {
                echo "<td style=\"color: green\">&radic;</td>";
            } else {
                echo "<td style=\"color: red\">&times;</td>";
            }
            if ($sf['chkModTypeCond_used']) {
                echo "<td style=\"color: green\">&radic;</td>";
            } else {
                echo "<td style=\"color: red\">&times;</td>";
            }
            if ($sf['op_condition_conflict']) {
                echo "<td style=\"color: green\">&radic; - {$sf['op_condition_conflict']}</td>";
            } else {
                echo "<td style=\"color: red\">&times;</td>";
            }
            if ($sf['op_condition_conflict'] OR $sf['op_modtype']) {
                echo "<td style=\"color: green\">&radic;</td>";
            } else {
                echo "<td style=\"color: red\">&times;</td>";
            }
            echo "</tr>\n";
            $i++;
        }
        unset($i);
        echo "</table>\n";
        echo "<br/>\n<br/>\n";
        // Output analysis to conflicted tables
        echo "<h4>Review of each affected SF</h4>\n";
        // output op_modtype
        foreach ($op_modtype_output as $key => $sf) {
            echo "<h5>Subform: {$key}</h5>\n";
            echo "<table border=\"1\">\n";
            echo "<tr><th>#</th><th>Field</th><th>This Mod?</th><th>Target Mod?</th><th>Conflict?</th><th>Data?</th></tr>\n";
            $i = 1;
            // OUTPUT
            foreach ($sf['fields'] as $fd_key => $field) {
                echo "<tr><td>{$i}</td><td>$fd_key</td>";
                if ($field['this_mod']) {
                    echo "<td style=\"color: green\">&radic;</td>";
                } else {
                    echo "<td style=\"color: red\">&times;</td>";
                }
                if ($field['target_mod']) {
                    echo "<td style=\"color: green\">&radic;</td>";
                } else {
                    echo "<td style=\"color: red\">&times;</td>";
                }
                if ($field['conflict']) {
                    echo "<td style=\"color: blue\">?? &#x2192;</td>";
                } else {
                    echo "<td style=\"color: green\">&otimes;</td>";
                }
                if (is_array($field['data'])) {
                    echo "<td><ul style=\"color: red;\">";
                    foreach ($field['data'] as $key => $value) {
                        echo "<li>{$value['dataclass']}: {$value['frag_id']}</li>";
                    }
                    echo "</ul></td>\n";
                } else {
                    echo "<td style=\"color: green\">&otimes;</td>";
                }
                echo "</tr>\n";
                $i++;
            }
            echo "</table>\n";
            echo "<p>Conflicted fields in this subform: {$sf['conflict_count']}</p>\n";
            echo "<p>Conflicted fragments in this subform: {$sf['conflict_frag_count']}</p>\n";
            echo "<br/>\n<br/>\n";
        }
        // output conditional sf's
        foreach ($conditionals_output as $key => $sf) {
            echo "<h5>Subform: {$key}</h5>\n";
            echo "<table border=\"1\">\n";
            echo "<tr><th>#</th><th>Field</th><th>Data?</th></tr>\n";
            $i = 1;
            // loop over the fields in this sf
            foreach ($sf['fields'] as $fd_key => $field) {
                echo "<tr><td>{$i}</td><td>$fd_key</td>";
                if (is_array($field['data'])) {
                    echo "<td><ul style=\"color: red;\">";
                    foreach ($field['data'] as $key => $value) {
                        echo "<li>{$value['dataclass']}: {$value['frag_id']}</li>";
                    }
                    echo "</ul></td>\n";
                } else {
                    echo "<td style=\"color: green\">&otimes;</td>";
                }
                echo "</tr>\n";
                $i++;
            }
            echo "</table>\n";
            echo "<p>Conflicted fields in this subform: {$sf['conflict_count']}</p>\n";
            echo "<p>Conflicted fragments in this subform: {$sf['conflict_frag_count']}</p>\n";
            echo "<br/>\n<br/>\n";
        }
        // report on the conflicted fragments
        echo "<h4>Summary of conflicted fragments from all SFs</h4>\n";
        echo "<table border=\"1\">\n";
        echo "<tr><th>#</th><th>Frag ID</th><th>Class</th><th>Table</th></tr>\n";
        $i = 1;
        foreach ($conflicted_frags as $key => $frag) {
            $tbl = 'cor_tbl_'.$frag['dataclass'];
            echo "<tr><td>{$i}</td><td>{$frag['id']}</td><td>{$frag['dataclass']}</td><td>$tbl</td></tr>\n";
            $i++;
        }
        echo "</table>\n";
        echo "<br/>\n<br/>\n";
        print("</div>");
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_modtype_conflicts\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_modtype_conflicts was incorrectly set</p>\n";
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

?>
