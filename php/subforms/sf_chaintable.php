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
* @author     Michael Johnson <m.johnson@lparchaeology.com>
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

// FUNCTIONS

if(!function_exists('collapseChainTable')){

// {{{ collapseChainTable()

/**
 * collapses a chain table, in a similar way to mysql 'group by'
 *
 * @param array $table_array the 2D table to be collapsed
 * @param array $sf_conf The subform config
 * @return array the collapsed 2D table for display
 * @author Michael Johnson (m.johnson@lparchaeology.com)
 * @since v1.1
 */
function collapseChainTable($table_array,$sf_conf)
{
    // just a dummy for now

    return $table_array;
}
//}}}
}
if(!function_exists('edtChainTable')){
//{{{ edtChainTable()

/**
 * returns javascript for handling chain tables,
 *
 * @param array $fields the fields included in the table
 * @param array $authitems a list of authorised items, for usi in drop down menus
 * @return string  javascript
 * @author Michael Johnson
 * @since v1.1
 */
function edtChainTable($fields, $authitems){
    $js="<script type=\"text/javascript\">";
    $js.= "TableKit.options.editAjaxURI = 'php/subforms/sf_update_chaintable.php';";
    foreach ($fields as $field){
        if ($field['dataclass']=='attribute'){
            $js.= mkTablekitAttributeDD($field);
        }
        if ($field['dataclass']=='xmi'){
            $js.= "var availableTags = [";
            foreach($authitems[$field['op_xmi_itemkey']] as $item){
                $js.= '"'.$item.'",';
            }
            $js.= "];";
        }
    }

    $js.="</script>";
    return $js;
}

//}}}
}
if(!function_exists('mkCellContents')){
// {{{ mkCellContents()

/**
 *
 * Creates a fragment of marked up info from a frag and a field
 *
 * @param  $frag
 * @param unknown $field
 * @return multitype:unknown Ambigous <string, boolean, string>
 */
function mkCellContents($frag,$field){
    $tbl="cor_tbl_".$frag['dataclass'];
    $row=getRow($tbl,$frag['id']);
    $content=resTblTd($field, $row['itemkey'], $row['itemvalue']);
    $return = array(
                    "class"   => $field['dataclass'],
                    "id"      => $row['id'],
                    "content" => $content,
    );
    return $return;
}

// }}}
}
if(!function_exists('mkChainTable')){
// {{{ mkChainTable()

/**
 *
 * Makes an 2D table that is used by sf_chaintable
 *
 * @param array $array  a two dimensional array (a table)
 * @param array $fields  an array of fields that will be the columns of the table
 * @return string $table the table
 * @author Michael Johnson
 * @since v1.1
 *
 * Note: this function handles the sorting and display of a table, the contents of the 2D array
 * can be created without concern for display. The $array classtypes must be in the same format
 * as the classtypes in the $fields (ie numeric codes or string descriptions)
 */

 function mkChainTable($chain_tree,$sf_conf){
     global $lang;
     $table_array = array();
     $chain_tree = array_filter($chain_tree);
     if (empty($chain_tree)) {
         return FALSE;
     }
     foreach ($chain_tree as $key=> $lvl1) {

         $new_row = array();
         // get primary items (lvl1): these are defined in sf_conf and are linked to the item
         if (chkFragTypeAndClass($lvl1,$sf_conf['op_assemblage_type'])){
             // unless the dataclass is 'number' a number attached to a fragment will be a reference to a lut
             if ($lvl1['dataclass']!='number' && is_numeric($lvl1[$lvl1['dataclass']])){
                 //get the lut_attributetype id of this attribute
                 $att_lut_typeid = getRow('cor_lut_attribute',$lvl1[$lvl1['dataclass']]);
                 $att_lut_typeid = $att_lut_typeid['attributetype'];
                 $alias = getAlias('cor_lut_'.$lvl1['dataclass'],$lang,'id',$lvl1[$lvl1['dataclass']],1);
                 if($lvl1['dataclass']=='attribute'){
                     $content = "<a href=\"data_view.php?ftr_mode=standard&reset=1&results_mode=disp";
                     $content .= "&disp_mode=table&ftype=atr&amp;atrtype=$att_lut_typeid&amp;";
                     $content .= "atr={$lvl1[$lvl1['dataclass']]}&bv=1&ftr_id=new\">";
                     $content .= $alias;
                 } else {
                     $content = $alias;
                 }
             } else{
                 // if the content is text, or the dataclass is number, just add the content
                 $content = $lvl1[$lvl1['dataclass']];
             }
             $primary_cell= array(
                 'class'=>$lvl1['dataclass'],
                 'id'=>$lvl1['id'],
                 'content'=>$content
             );
             // add primary items to table. Table column key is the frag classtype
             $classtype = $sf_conf['op_assemblage_type']['classtype'];
             $new_row[$classtype] = $primary_cell;
             // check for attached arrays
             if (is_array($lvl1['attached_frags'])){
                 // loop throught the attached arrays
                 foreach($lvl1['attached_frags'] as $lvl2){
                     // we need the classtype to get the relevant stuff out of the array-this changes depending on the class of the fragment
                     $classtype=$lvl2['dataclass']."type";
                     // check if we are interested in fragments of this classtype
                     if (chkFragInCols($lvl2,$sf_conf['fields'])){
                         foreach($sf_conf['fields'] as $column){
                             if (chkFragTypeAndClass($lvl2,$column)){
                                 if($lvl2['dataclass']=='xmi'){
                                     if(@$lvl2['similis']){
                                         $new_row['similis_xmi_list']=mkCellContents($lvl2,$column);
                                     } else {
                                         $new_row[$column['classtype']]=mkCellContents($lvl2,$column);
                                     }
                                 } else {
                                     $new_row[$column['classtype']]=mkCellContents($lvl2,$column);
                                 }
                             }
                         }
                     }
                 }
             }
             if (array_key_exists('op_sum_field', $sf_conf)) {
                 $sum_classtype = $sf_conf['op_sum_field']['classtype'];
                 $match = false;
                 //printPre("</br>Matching for {$new_row['quantcount']['id']}");
                 foreach ( $table_array as $root_key => $existing ) {
                     //printPre("checking against {$root_key}");
                     foreach ( $existing as $key => $cell ) {
                         if (count($existing)!=count($new_row)){
                             $match = false;
                             continue (1);
                         }
                         if ($key != $sum_classtype && array_key_exists($key,$new_row)) {
                             if ($cell['content'] == $new_row[$key]['content']) {
                                // printPre("matched $key");
                                 $match = $root_key;
                             } else {
                                 // printPre("didn't match $key");
                                 $match = false;
                                 continue (2);
                             }
                         }
                     }
                     if ($match){
                         // once we have a match stop looking
                         break (1);
                     }
                 }
                 
                 if (!$match) {
                     $table_array[$lvl1['id']] = $new_row;
                 } else {
                     $sub = $table_array[$match][$sum_classtype]['content'];
                     $running = str_replace("<span class=\"data\">", "", str_replace("</span>", "", $sub));
                     $new_number = str_replace("<span class=\"data\">", "", str_replace("</span>", "", $new_row[$sum_classtype]['content']));
                     $sum = $running + $new_number;
                     $running = "<span class=\"data\">" . $sum . "</span>";
                     $table_array[$root_key][$sum_classtype]['content'] = $running;
                 }
             } else {
                     $table_array[$lvl1['id']] = $new_row;
             }
         }
     }
     return $table_array;
 }

// }}}
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

$root_field = reqQst($sf_conf, 'op_assemblage_type');

// --- BUILD THE ASSEMBLAGE

$chaintableid = $sf_conf['sf_html_id'].$sf_key.$sf_val;

//check the session
$table_array = reqQst($_SESSION, $chaintableid);
$table_array = FALSE;
$similis = FALSE;

// nothing in the session? Lets build it
if (!$table_array) {
    // start by getting all the root data
    $chain_tree = getChData($root_field['dataclass'], $sf_key, $sf_val, $root_field['classtype']);
    $root_table = 'cor_tbl_' . $root_field['dataclass'];
    //if there are any roots lets build the tree
    if ($chain_tree) {
        // loop over each of nodes attached to the root
        foreach ( $chain_tree as $index => $root ) {
            // clear out the classes queried so we call each table just once
            $classesqueried = array();
            foreach ( $fields as $field ) {
                // we want to do all the fields attached to our root, root is already done
                if ($field['field_id'] !== $root_field['field_id']) {
                    // check we haven't done this class already
                    $class = $field['dataclass'];
                    if (!in_array($class, $classesqueried)) {
                        // get the data for this class
                        $branch = getChDataByClass($class, $root_table, $root['id'], FALSE);
                        // make sure we don't call this table again
                        $classesqueried[] = $class;
                        // if we have data decide what to do
                        if (is_array($branch)) {
                            // if we already have some, merge branch into the tree
                            if($class=='xmi'){
                                $reverse = getXmi($branch[0]['xmi_itemkey'], $branch[0]['xmi_itemvalue'], 'loc');
                                if($reverse[0]['xmi_itemvalue']!=$sf_val){
                                    $branch[0]['similis'] = true;
                                    $similis=true;
                                }
                            }
                            if (is_array($chain_tree[$index]['attached_frags'])) {
                                $chain_tree[$index]['attached_frags'] = array_merge($branch, $chain_tree[$index]['attached_frags']);
                            } else {
                                // otherwise this branch is the start of the tree
                                $chain_tree[$index]['attached_frags'] = $branch;
                            }
                        }
                    }
                }
            }
        }
        $table_array = mkChainTable($chain_tree, $sf_conf);
    } else {
        $table_array = FALSE;
    }
    // create a array to contain our table
    // $_SESSION[$chaintableid] = $table_array;
}
/*
if ($table_array) {
    $clean_fields = $sf_conf['fields'];
    foreach ($clean_fields as $key => $field){
        foreach($table_array as $row){
            if(array_key_exists($field['classtype'], $row)){
                if ($field['dataclass']=='txt'){
                    if($row[$field['classtype']]['content']===''){
                        continue(1);
                    }
                }
                continue(2);
            }
        }
        unset($clean_fields[$key]);
    }
    $fields = $clean_fields;
}
*/
if ($table_array) {
    $clean_fields = $sf_conf['fields'];
    foreach ($clean_fields as $key => $field){
        if($field['classtype']=='xmi_list' && $similis){
            $field_similis = array(array(
                'field_id'=>'form_similis',
                'dataclass' => 'xmi',
                 'classtype' => 'similis_xmi_list',
                 'aliasinfo' =>
                        array(
                           'alias_tbl' => 'cor_tbl_module',
                           'alias_col' => 'itemkey',
                           'alias_src_key' => 'cat_cd',
                           'alias_type' => '1',
                        ),
                   'module' => 'pho',
                   'xmi_mod' => 'cat',
                   'force_var_itemkey' => 'cat_cd',
                   'op_xmi_itemkey' => 'cat_cd',           
                   'editable' => TRUE,
                   'hidden' => FALSE,
                   'add_validation' => $xmi_add_validation,
                   'edt_validation' => $xmi_edt_validation
            ));
            array_splice($clean_fields, $key, 0, $field_similis);
        }
    }
    foreach ($clean_fields as $key => $field){
        foreach($table_array as $row){
            //printPre($row);
            if(array_key_exists($field['classtype'], $row)){
                if ($field['dataclass']=='txt'){
                    if($row[$field['classtype']]['content']===''){
                        continue(1);
                    }
                }
                continue(2);
            }
        }
        unset($clean_fields[$key]);
    }
    $fields = $clean_fields;
}

// printPre($fields);
// ---- STATE SPECFIC
// for each state get specific elements and then produce output
if (in_array($sf_state, array('min_view','min_edit','min_ent'))){

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
} else if (in_array($sf_state, array('p_max_view','s_max_view','p_max_edit','p_max_ent','s_max_edit'))){

        // Set up the div
        $div="<div id=\"div-{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n";
        // put in the nav
        $div.=sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols);
        $div.="<script src={$ark_lib_path}/js/jquery.tablesorter.min.js></script>";
        $div.="<script src={$ark_lib_path}/js/jquery.tablesorter.widget-editable.js></script>";

        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        if(!$table_array){
            $table = "";
        } else {
            // initialise the table and put in headers
            $table = "<table id=\"".$sf_conf['sf_html_id']."_table\" class=\"sortable";
            if(in_array($sf_state, array('p_max_edit','p_max_ent','s_max_edit'))){
                $table.=" editable";
            }     
            $table.="\">";

            if(in_array($sf_state, array('p_max_edit','p_max_ent','s_max_edit'))){
                //$fields[]= $conf_field_delete;
            }
             
            $headarray= resTblTh($fields);
            foreach($headarray as $key => $field){
                if($field['classtype']=='similis_xmi_list'){
                    $headarray[$key]['field_alias'] = 'Similar to';
                }
            }
            $table .= mkTblTh($headarray);

            // iterate over each row in $array table
            foreach($table_array as $row){
                // get row id-depends on primary frag
                $rowid= $row[$sf_conf['op_assemblage_type']['classtype']];
                $rowidstring=$rowid['class']."-".$rowid['id'];
                $table.="<tr id=\"".$rowidstring."-row\">";
                // iterate over each column, columns sorted in order of $fields
                foreach($fields as $field){
                    if ($field['classtype']=='xmi'){
                        $content = $row['similis'];
                    }
                    // if there is no data for this column just make a blank cell
                    if(!array_key_exists($field['classtype'],$row)){
                        if ($field['classtype']=='delete'){
                            $table.= "<td class=\"nocol\">";
                            $table.= "<a class=\"delete\" href=\"#\"";
                            $table .= "onclick=\"deletefrag('".$rowidstring."', '".$sf_conf['op_assemblage_type']['field_id']."'); return false\">delete</a>";
                            $table.= "</td>";
                        }
                        $id= "id=\"".$sf_conf['sf_html_id']."_table-cell-empty\"";
                        $table .="<td ".$id."></td>";
                        continue;
                    }
                    // get the content for this cell which is stored in the table array
                    $content = $row[$field['classtype']];
                    // define the id of the cell
                    $id= "id=\"".$sf_conf['sf_html_id']."_table-cell-".$content['class']."-".$content['id']."\"";
                    $hiddenid = "<input type=\"hidden\" name=\"{$content['class']}_id\" value=\"{$content['id']}\" />\n";
                    // make the cell
                    $table.="<td ".$id.">".$content['content'].$hiddenid."</td>";
                    unset($id);
                }

                $table.= "</tr>";
            }
            $table .="</table>";
            }
            echo $div.$table."</div>";
            include ('js_chaintable.php');
            /*
            echo "<button onclick=\"addNewRecord".$sf_conf['sf_html_id']."()\">";
            echo getMarkup('cor_tbl_markup', $lang, 'add');
            echo "</button>";
            */

//     case 'p_max_edit':
//     case 'p_max_ent':
//     case 's_max_edit':


} // ends switch

unset ($sf_conf);
unset ($table);
unset ($sf_state);
unset ($fields);
unset ($table_array);
if( ob_get_level() > 0 ) ob_flush();
flush();

?>
