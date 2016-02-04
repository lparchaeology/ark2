<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_assemblage.php
*
* Subform for dealing with assemblage information
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_assemblage.php
* @since      File available since Release 0.6
*
*/


// ---- SETUP ---- //

// The default for modules with several modtypes is to have one field list,
// which is the same for all the differnt modtypes
// If you want to use different field lists for each modtype add to the subform
// settings 'op_modtype'=> TRUE and instead of 'fields' => array( add
// 'type1_fields' => array( for each type. 
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

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

//check if we are using a chart
if (array_key_exists('op_chart',$sf_conf) && $sf_conf['op_chart'] == TRUE) {
    $chart = TRUE;
} else {
    $chart = FALSE;
}

// ---- PROCESS ---- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id']) {
    include_once ('php/subforms/update_assemblage.php');
}

// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_save = getMarkup('cor_tbl_markup', $lang, 'save');

// form_id
$form_id = $sf_conf['sf_html_id'].'_form';


// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch ($sf_state) {
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
    printf("<div id=\"div-{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
    // put in the nav
    printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
    if ($error) {
        feedBk('error');
    }
    if ($message) {
        feedBk('message');
    }
    printf('</div>');
    break;

    case 'p_max_view':
    case 's_max_view':
    
        if ($chart == TRUE) {
            echo('<script language="javascript" type="text/javascript" src="lib/js/flot/jquery.flot.js"></script>
                    <script language="javascript" type="text/javascript" src="lib/js/flot/jquery.flot.pie.js"></script>'
                );
        }

        printf("<div id=\"div-{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n");
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        
        // first decide what type of assemblage we are dealing with - is it chained with 
        // attributes to numbers (att_to_num), or numbers to attributes (num_to_att)?
        
        if (array_key_exists('op_chaintype', $sf_conf)) {
            $chaintype = $sf_conf['op_chaintype'];
        } else {
            $chaintype = 'att_to_num';
        }
        
        if ($chaintype == 'att_to_num') {
            if ($chart == TRUE){
            //    include('lib/php/libchart/libchart.php');
            //    if ($sf_state == 'p_max_view'){
            //        $chart = new PieChart(500, 250);
            //    }else{
            //        $chart = new PieChart(250, 125);
            //    } 
            }
            // Extract and make up the rows array.
            // This is the list of assemblagetypes attached to this item
            $type_no = getSingle('id', 'cor_lut_attributetype', "attributetype = '{$sf_conf['op_assemblage_type']}'");
            $sql = "
                SELECT a.id
                FROM cor_tbl_attribute AS a, cor_lut_attribute AS b
                WHERE a.attribute = b.id
                AND a.itemkey = ?
                AND a.itemvalue = ?
                AND b.attributetype = ?
            ";
            $params = array($sf_key,$sf_val,$type_no);
            $sql = dbPrepareQuery($sql,__FUNCTION__);
            $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
            if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                //this is for each attribute
                do {
                    $id = $row['id'];
                    $alias = getAttr(FALSE, $id, 'SINGLE', 'alias', $lang);
                    $rows[] = array('id' => $id, 'alias' => $alias);
                } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
            } else {
                $rows = FALSE;
            }

            if ($rows) {
                // print out a table
                printf("<table class=\"assemblage\">\n");
                // make up the columns array
                $fields = resTblTh($fields, 'silent');
                // as a non standard header row this needs the header manually printed
                print("<tr><th>&nbsp;</th>");
                foreach ($fields as $field) {
                    print("<th>{$field['field_alias']}</th>");
                }
                print("</tr>\n");
                // loop over each row looping over each field within it
                foreach($rows AS $row) {
                    //get the label for the row
                    $label = $row['alias'];
                    // begin row and give a label field
                    print("<tr>");
                    print("<td><label>$label</label></td>");
                    // loop thru the columns
                    foreach ($fields AS $field) {
                        $alias = getAlias('cor_lut_numbertype', $lang, 'id', $field, 1);
                        //try to get the current value
                        $type_no = getSingle('id', 'cor_lut_numbertype', "numbertype = '{$field['classtype']}'");
                        //try to get the current value
                        $current = 
                            getSingle(
                                'number',
                                'cor_tbl_number',
                                "itemkey = 'cor_tbl_attribute' AND itemvalue = '{$row['id']}' AND numbertype = $type_no"
                        );
                        printf("<td>");
                        if (isset($current)){
                            print($current);
                        }
                        printf("</td>");
                    }
                    // close the row
                    print("</tr>\n");

              //      if(isset($chart)){
            //            $chart->addPoint(new Point("$label ($current)", $current));
              //      }
                }
                // end the table
                printf("</table>\n");

                if ($chart == TRUE){
                //    $chart->setTitle($sf_title);
                  //  $chart->render("lib/php/libchart/chart_tmp/" . session_id() . $sf_conf['op_assemblage_type'] . ".png");
                //    printf("<img src=\"lib/php/libchart/chart_tmp/" . session_id() . $sf_conf['op_assemblage_type'] . ".png\">");
                }

            } else {
                echo "<label class=\"form_label\">$sf_title</label>";
                echo "<span class=\"data\">There are no results for this record</span>";
            }
        } else { //this is if we have numbers with attributes chained
            // Extract and make up the rows array.
            // This is the list of assemblagetypes attached to this item
            //$type_no = getSingle('id', 'cor_lut_numbertype', "numbertype = '{$sf_conf['op_assemblage_type']}'");
            if ($chart){
                if ($sf_state == 'p_max_view'){
                    $chart_width = "400px";
                    $chart_height = "250px";
                }else{
                    $chart_width = "150px";
                    $chart_height = "125px";
                } 
            }
            $numbers = getNumber($sf_key, $sf_val, $sf_conf['op_assemblage_type']);
            // if we have numbers attached then start the processing - if not then print no records
            if (is_array($numbers)) {
                //setup 3 empty arrays - to hold all the consolidated counts
                $attributes = array();
                $att_types = array();
                $att_merge = array();
                $total_num = 0;
                $mk_total = getMarkup('cor_tbl_markup', $lang, 'total');
                $var = '';
                foreach ($numbers as $key => $value) {
                    $total_num = $total_num + $value['number'];
                    //grab the attributes attached to this number
                    $attrs = getChData('attribute','cor_tbl_number',$value['id']);
                    if (is_array($attrs)) {
                        if (isset($sf_conf['op_chart'])){

                        }
                        $unique_attrs = '';
                        //now pop them into the arrays of total counts
                        foreach ($attrs as $attr) {
                            //build the breakdown by type
                            if (array_key_exists($attr['attributetype'],$att_types)) {
                                $att_types[$attr['attributetype']] = $att_types[$attr['attributetype']] + $value['number'];
                            } else {
                                $att_types[$attr['attributetype']] = $value['number'];
                            }
                            //build the breakdown by individual attribute
                            if (array_key_exists($attr['attribute'],$attributes)) {
                                $attributes[$attr['attribute']] = $attributes[$attr['attribute']] + $value['number'];
                            } else {
                                $attributes[$attr['attribute']] = $value['number'];
                            }
                            //build the chained (i.e. unique) records
                            $unique_attrs .= '_' . $attr['attribute'];
                        }
                        $unique_attrs = ltrim($unique_attrs,'_');
                        $att_merge[$unique_attrs] = $value['number'];
                    }
                }
                $var .= "<h5>$mk_total = $total_num</h5>";

                if (!empty($attributes)) {
                    $attributes = array_reverse($attributes, TRUE);
                    //set up a new array to print these
                    $print_attributes = array();
                    if ($chart) {
                        $chart_data = array();
                    }
                    foreach ($attributes as $key => $value) {
                        $att_type = getSingle('attributetype', 'cor_lut_attribute', "id = $key");
                        if (in_array($att_type,$sf_conf['op_default_type_display'])) {
                            $print_attributes[$att_type][$key] = $value;
                        }
                    }
                    //now sort the $print_attributes so they come out in the order specified
                    $temp_print = array();
                    foreach ($sf_conf['op_default_type_display'] as $disp_val) {
                        $temp_print[$disp_val] = $print_attributes[$disp_val];
                    }
                    $print_attributes = $temp_print;
                    $var .= "<div>";
                    foreach ($print_attributes as $key => $value) {
                        $tbl_hdr = getAlias('cor_lut_attributetype', $lang, 'id', $key, 1);
                        $var .= "<label class='form_label'>$tbl_hdr</label>";
                        $var .= "<table class='assemblage'>";
                        $var .= "<tr><th></th><th>$mk_total</th></tr>";
                        foreach ($value as $val_key => $val_value) {
                            $alias = getAlias('cor_lut_attribute', $lang, 'id', $val_key, 1);
                            if($chart){
                                $chart_data[$alias] = $val_value;
                            }
                            $var .= "<tr>";
                            $var .= "<td>";
                            $var .= "$alias";
                            $var .= "</td>";
                            $var .= "<td>$val_value</td>";
                            $var .= "</tr>";
                        }
                        $var .= "</table>";
                        if ($chart){
                            //build up the json
                            $chart_data_json = '';
                            foreach ($chart_data as $chart_key => $chart_value) {
                                //make sure we don't have double qoutes
                                $chart_key = str_replace("\"", '', $chart_key);
                                $chart_value = str_replace("\"", '', $chart_value);
                                $chart_data_json .= "{label: \"$chart_key\", data: $chart_value},";
                            }
                            
                            $var .= "
                                <script type=\"text/javascript\">
                                    jQuery(document).ready(function () {
                                        var data = [$chart_data_json];
                                        jQuery.plot(jQuery(\"#chart$key\"), data, {
                                             series: {
                                                pie: {
                                                    show: true,
                                                    combine: {
                                                        color: '#999',
                                                        threshold: 0.1
                                                    }
                                                }
                                             },
                                             legend: {
                                                show: false
                                             },
                                        });
                                    });
                                </script>
                            
                                <div id=\"chart$key\" style=\"width:$chart_width; height:$chart_height\"></div>
                            ";
                            
                          //  $chart->setTitle($sf_title);
                        //    $chart->render("lib/php/libchart/chart_tmp/" . session_id() . $val_key . ".png");
                          //  $var .= ("<img src=\"lib/php/libchart/chart_tmp/" . session_id() . $val_key . ".png\">");
                          $chart_data = array();
                        }
                    }
                    $var .= "</div>";
                }
                echo $var;
            } else {
                echo "<ul><li class='row'><span>There are no results for this record</span></li></ul>";
            }
        }

        printf("</div>\n\n");

        //---- CLEAN-UP ----
        unset($print_attributes);
        unset($rows);
        //unset($chart);

        break;
        
    case 'p_max_edit':
        printf("<div id=\"div-{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        $link = $ark_root_path.'/data_entry.php?'.$sf_key.'='.$sf_val.'&view=detfrm&item_key='.$sf_key;
        printf('<p>Totals will be calculated when editing is complete</p>');
        printf("</div>\n\n");
        break;
        
    case 'p_max_ent':
    case 's_max_edit':
        printf("<div id=\"div-{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // Extract and make up the rows array.
        // This is the list of attribute types attached to this record
        $type_no = getSingle('id', 'cor_lut_attributetype', "attributetype = '{$sf_conf['op_assemblage_type']}'");
        $sql = "
            SELECT a.id
            FROM cor_tbl_attribute AS a, cor_lut_attribute AS b
            WHERE a.attribute = b.id
            AND a.itemkey = ?
            AND a.itemvalue = ?
            AND b.attributetype = ?
        ";
        $params = array($sf_key,$sf_val,$type_no);
        // DEV NOTE: deprecated call to DB from subform (also doesnt use std db call syntax)
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            //this is for each attribute
            do {
                $id = $row['id'];
                $alias = getAttr(FALSE, $id, 'SINGLE', 'alias', $lang);
                $rows[] = array('id' => $id, 'alias' => $alias);
            } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
        } else {
            $rows = FALSE;
        }
        
        if ($rows) {
            // print out a table
            printf("<table class=\"assemblage\">\n");
            // make up the columns array
            $fields = resTblTh($fields, 'silent');
            // as a non standard header row this needs the header manually printed
            print("<tr><th>&nbsp;</th>");
            foreach ($fields as $field) {
                print("<th>{$field['field_alias']}</th>");
            }
            print("</tr>");
            // loop over each row looping over each field within it
            foreach($rows AS $row) {
                //get the label for the row
                $label = $row['alias'];
                // begin row and give a label field
                print("<form method=\"$form_method\" id=\"$form_id\" action=\"{$_SERVER['PHP_SELF']}\">\n");
                print("<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n");
                print("<input type=\"hidden\" name=\"$sf_key\" value=\"" . $sf_val ."\">");
                print("<input type=\"hidden\" name=\"itemkey\" value=\"cor_tbl_attribute\">");
                print("<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\">");

                print("<tr>");
                print("<td><label class=\"form_label\">$label</label></td>");
                // loop thru the columns
                foreach ($fields AS $field) {
                    //try to get the current value
                    $type_no = getSingle('id', 'cor_lut_numbertype', "numbertype = '{$field['classtype']}'");
                    //try to get the current value
                    $current = getSingle(
                              'id',
                              'cor_tbl_number',
                              "itemkey = 'cor_tbl_attribute' AND itemvalue = '{$row['id']}' AND numbertype = $type_no"
                         );
                    if(!empty($current)){
                        $field['current']['id'] = $current;
                        $val = "<input type=\"hidden\" name=\"frag_id\" value=\"{$row['id']}\">\n";
                    }else{
                        $val = "<input type=\"hidden\" name=\"frag_id\" value=\"{$row['id']}\">\n";
                    }
                    //$val .= frmElem($field,'cor_tbl_attribute',$row['id']);
                    $number = getNumber('cor_tbl_attribute', $row['id'],$field['classtype']);
                    $number_var = "<input type=\"text\" class=\"number\" name=\"{$field['classtype']}\" value=\"{$number[0]['number']}\" />\n";
                    // establish if there are numbers attached to the attribute, if so insert delete button
                    if (!empty($number)) {
                         // Set up code for the delete button
                        $del_sw = "<a href=\"{$_SERVER['PHP_SELF']}";
                        $del_sw .= "?$sf_key=$sf_val&amp;";
                        $del_sw .= "update_db=delfrag&amp;dclass=number";
                        $del_sw .= "&amp;delete_qtype=del&amp;";
                        $del_sw .= "frag_id={$field['current']['id']}\">\n";
                        $del_sw .= "<img class=\"smalldelete\" src=\"$skin_path/images/plusminus/delete_small.png\"";
                        $del_sw .= " alt=\"[-]\" />";
                        $del_sw .= "</a>\n";
                        $number_var .= "$del_sw\n";
                    } else {
                        $del_sw = FALSE;
                    }
                    $val .= $number_var;
                    $val .= "<input type=\"hidden\" name=\"{$field['classtype']}_id\" value=\"{$field['current']['id']}\" />\n";
                    $val .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"edt\" />\n";
                    print("<td>");
                    print("<span class=\"input\">");
                    print($val);
                    print("</span>");
                    print("</td>");
                }
                // close the row
                printf("<td><button type=\"submit\">$mk_save</button></tr></form>\n");
            }
            // end the table
            printf("</table>\n");
        } else {
            // echo "There are no findtypes for this record"; // DEV NOTE: Commented out, as not needed and is generic, yet specific enough to not apply in all use cases. Needs to be markup/option to display message like sf_text here. JO 3/6/12
            $rows = FALSE;
        }
        // end SF
        printf("</div>\n\n");
        // clean up
        unset($rows);
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_assemblage\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_assemblage was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
} // ends switch

unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);

?>