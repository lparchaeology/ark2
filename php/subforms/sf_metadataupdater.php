<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_metadataupdater.php
*
* Subform for attributes
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
* @author     Michael Johnson <m.johnson@lparchaeology.com>
* @copyright  1999-2014 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_metadataupdater.php
* @since      File available since Release 1.1.1
*
*/

include_once 'php/import/import_functions.php';

// {{{ logarray()

/**
 * 
 * Takes a string or array and returns a series of javascript strings that
 * will print the given array to the console in an easily readable way.
 * Similar functionality to PrintPre, but by using the console allows debugging on 
 * a live site witohut interrupting other workflows on the page.
 * 
 * The function calls itself recursively printing arrays within arrays with
 * human readable indentation.
 * 
 * @param string or array $input the value(s) to be printed to the console
 * @param number $depth the number of tabstops
 * @return string JavaScript inside <script> tags
 */

function logarray($input, $depth=0){
    $return = "";
    // there are 4 spaces in a tab, so multiply depth by 4
    $tabs=$depth*4;
    $tab="";
    // count down through the tabs adding a space to our strin until we have enough
    while($tabs>0){
        $tab .=" ";
        $tabs -=1;
    }
    // if our input is an array, 
    if(is_array($input)){
        // then we are going to have to get the stuff out of it
        foreach ($input as $k=>$v){
            // put js to print the key to the console into the return string
            $return .= "<script>console.log(\"$tab$k =>\")</script>";
            // then feed the contents into logarray, indented one more
            $return .= logarray($v, $depth+1);
        }
    // Its probably a string then,
    } else {
        // add the js to print it to the console to our return string anyway
        $return .= "<script>console.log(\"$tab$input\")</script>";
    }
    // return the string, so that the caller can handle it appropriately
    return $return;
}
// }}}

// ---- COMMON ---- //
// get common elements for all states

// The default for modules with several modtypes is to have one field list,
// which is the same for all the different modtypes
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
if (chkModType($mod_short) && $modtype != FALSE) {
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

// op_emptyfielddisp
// this allows us to control the way empty fields are displayed in 'view' modes of this sf.
// as an op_ this is NOT required
// if not set, the default is to simply not display unset fields.
if (array_key_exists('op_emptyfielddisp', $sf_conf)) {
    $emptyfielddisp = $sf_conf['op_emptyfielddisp'];
} else {
    $emptyfielddisp = FALSE;
}

// ---- PROCESS ---- //
// update db is called at the page level
if ($update_db == $sf_conf['sf_html_id']) {
    include_once ('php/update_db.php');
}
$update_db ="";


// Get IRODS info from the sub form
$irods_info = $sf_conf['irods_info'];

// the Prods library is required to get the existing metadata
require_once("lib/php/prods/src/Prods.inc.php");

// create a new account
$irods_account = new RODSAccount($irods_info['irods_account'], 1247, $irods_info['irods_user'], $irods_info['irods_pwd']);

//get the field out of its array
foreach ($fields as $field){ 
    // get the files attached to the object
    $filearray = getFile($sf_key, $sf_val,$field['classtype']);
    //there should only be one file, so this will just use the last one
    if(is_array($filearray)){
        foreach ($filearray as $currentfile){
            $file = $currentfile;
        }
    }
}
if (isset($file)){
    // The uri is a link to the web frontend of corral, replace this with the file path on iRods
    $filepath = str_replace('http://web.corral.tacc.utexas.edu', '/corralZ', $file['uri']);
    
    //try to get the file on irods
    try{
        $myfile=new ProdsFile($irods_account,$filepath,FALSE);
        // get the metadata for the file so we can use it later
        $metadata=$myfile->getMeta();
    }catch(Exception $e){
        printError($e);
    }
} else {
    $metadata = array();
}

// some useful variables
// the table row index
$rows = 0;
// an empty array to hold the table we will generate
$metatable = array();
// an empty array to put terms into, to stop repetition
$extractedterms = array();
// an empty error message (so far)
$error_message='';

// get the mapping arrays out of the conf
foreach ( $sf_conf['metadata'] as $mapping ) {
    // unpack the mappings
    $ark = $mapping[1];
    $irods = $mapping[0];
    
    // set the row numbers which start the same, but ark or irods may end up longer
    $irodsrow = $rows;
    $arkrow = $rows;    
    // get ARK terms
    // if $ark is an array, we will assume it is a field conf
    if (is_array($ark)) {
        // different dataclasses are handled differently, 
        switch($ark['dataclass']) {
            case 'attribute' :
                // get the attributes,
                $attributes = getCh('attribute', $sf_key, $sf_val, $ark['classtype']);
                // if there are some,
                if ($attributes) {
                    // loop over them,
                    foreach ( $attributes as $att ) {
                        // grab out the alias, which is what we want on iRods 
                        $alias = getAttr(FALSE, $att, 'SINGLE', 'alias', $lang);
                        // Add the values into right place in the 2D metatable array
                        $metatable[$arkrow]['field'] = $ark['field_id'];
                        $metatable[$arkrow]['classtype'] = $ark['classtype'];
                        $metatable[$arkrow]['dataclass'] = $ark['dataclass'];
                        $metatable[$arkrow]['arkdata'] = "$alias";
                        $metatable[$arkrow]['arkid'] = $att;
                        $metatable[$arkrow]['itemkey'] = $item_key;
                        $metatable[$arkrow]['itemval'] = $$item_key;
                        $metatable[$arkrow]['term'] = $irods;
                        // increase the row count by one for each attribute
                        $arkrow += 1;
                    }
                }
                break;
            case 'txt' :
                //get the text
                $txt = getSingleText($sf_key, $sf_val, $ark['classtype'], $lang);
                // get the id of the text, so that we can update it
                $id = getSingle("id", "cor_tbl_txt", "txt=\"$txt\" and itemkey='$sf_key' and itemvalue='$sf_val'");
                // Add the values into right place in the 2D metatable array$metatable[$arkrow]['field'] = $ark['field_id'];
                $metatable[$arkrow]['classtype'] = $ark['classtype'];
                $metatable[$arkrow]['dataclass'] = $ark['dataclass'];
                $metatable[$arkrow]['arkdata'] = $txt;
                $metatable[$arkrow]['arkid'] = $id;
                $metatable[$arkrow]['itemkey'] = $item_key;
                $metatable[$arkrow]['itemval'] = $$item_key;
                $metatable[$arkrow]['term'] = $irods;
                $metatable[$arkrow]['field'] = $ark['field_id'];
                // only one text is returned by getSingleText
                $arkrow += 1;
                break;
            case 'xmi' :
                // get the XMI's (cross(X) Module Inferface)
                $xmi_list = getXmi($sf_key, $sf_val, $ark['xmi_mod']);
                // check there are some
                if ($xmi_list){
                    // loop over them
                    foreach ($xmi_list as $xmi){
                        // add the relevant details
                        $metatable[$arkrow]['field'] = $ark['field_id'];
                        $metatable[$arkrow]['classtype'] = $ark['classtype'];
                        $metatable[$arkrow]['dataclass'] = $ark['dataclass'];
                        $metatable[$arkrow]['arkdata'] = $xmi['xmi_itemvalue'];
                        $metatable[$arkrow]['arkid'] = $xmi['id'];
                        $metatable[$arkrow]['itemkey'] = $item_key;
                        $metatable[$arkrow]['itemval'] = $$item_key;
                        $metatable[$arkrow]['term'] = $irods;
                        // increase the ark row count by one for each
                        $arkrow += 1;
                    }
                }
                break;
            // things that aren't proper fields will be caught by default
            default :
            // ERROR $ark has no dataclass
                $error_message .= "ERROR $ark is not a valid field<br>";
        }
    // if mapping[1] isn't a field mapping[2] might be, for xmi data
    } else if(array_key_exists(2,$mapping)){
        if (is_array($mapping[2])){
            // we are going to be using mapping[2] as the field so overwrite $ark
            $ark =$mapping[2];
            // get the xmis of the mod type defined in the conf (as a short code)
            $xmi_list = getXmi($sf_key, $sf_val, $mapping[1]);
            // If we have any hits
            if($xmi_list){
                // loop over the attached modules
                foreach ($xmi_list as $xmi){
                    switch($ark['dataclass']) {
                    	case 'attribute':
                    	    // get the attributes
                    	    $attributes = getCh('attribute',$xmi['xmi_itemkey'], $xmi['xmi_itemvalue'], $ark['classtype']);
                    	    // loop over them
                    	    if ($attributes) {
                    	        foreach ( $attributes as $att ) {
                    	            // get the alias, this is what we want ot add to iRods
                    	            $alias = getAttr(FALSE, $att, 'SINGLE', 'alias', $lang);
                    	            $metatable[$arkrow]['field'] = $ark['field_id'];
                    	            $metatable[$arkrow]['classtype'] = $ark['classtype'];
                    	            $metatable[$arkrow]['dataclass'] = $ark['dataclass'];
                    	            $metatable[$arkrow]['arkdata'] = "$alias";
                    	            $metatable[$arkrow]['arkid'] = $att;
                    	            // itemkey/val different here so that the sf pushes changes thru xmi
                    	            $metatable[$arkrow]['itemkey'] = $xmi['xmi_itemkey'];
                    	            $metatable[$arkrow]['itemval'] = $xmi['xmi_itemvalue'];
                    	            $metatable[$arkrow]['term'] = $irods;
                    	            // increase ark row count for each attribute
                    	            $arkrow += 1;
                    	        }
                    	    }
                    	    break;
                    	default :
                            // ERROR $ark has no dataclass
                            $error_message .= "ERROR $ark is not a valid field<br>";
                    }
                }
            }
        }  
    // for everything else   
    } else {
        // Use the value in the config as a string, allows us to send module specific 
        // terms to iRods
        $metatable[$rows]['arkdata'] = $ark;
        $metatable[$rows]['term'] = $irods;
    }
    
    // get the irods terms
    // loop over the metadata from earlier
    foreach ( $metadata as $meta ) {
        // check if the term is attached to the file, and wether we have already extracted it
        if ($meta->name == $irods && !in_array($irods, $extractedterms)) {
            // add irods terms to table
            $metatable[$irodsrow]['irodsdata'] = $meta->value;
            $metatable[$irodsrow]['term'] = $irods;
            // if there is no field for this irod term, set that up
            if (!array_key_exists('field', $metatable[$irodsrow])) {
                if (is_array($ark)){
                    $metatable[$irodsrow]['field'] = $ark['field_id'];
                    $metatable[$irodsrow]['classtype'] = $ark['classtype'];
                    $metatable[$irodsrow]['dataclass'] = $ark['dataclass'];
                } else {
                $metatable[$irodsrow]['field'] = "no_field";
                $metatable[$irodsrow]['classtype'] = "no_classtype";
                }
            }
            // attributes will need the respective ARK id so they can be added
            if (array_key_exists('dataclass',$metatable[$irodsrow])){
                if($metatable[$irodsrow]['dataclass']=='attribute'){
                    // try to get an id for an existing attribute of this classtype
                    $irodsid = getLutIdFromData("cor_lut_".$metatable[$irodsrow]['dataclass'],'en',"AND cor_tbl_alias.alias = '{$meta->value}'");
                    // if there isn't on, we need to add it
                    if(!$irodsid){
                        // get the classtype id s
                        $classtypeid = getClassType($metatable[$irodsrow]['dataclass'], $metatable[$irodsrow]['classtype']);
                        // create a new entry in the lut table
                        $irodsid = edtLut("cor_lut_".$metatable[$irodsrow]['dataclass'], $meta->value, $mod_short, $classtypeid, $lang, $user_id, "NOW()");
                    }
                    // test it again
                    if (!$irodsid) {
                        // no id, set up a filler string, and register an error
                        $irodsid = "noid";
                        $error_message .= "No id found or created for attribute {$meta->value}<br>";
                    }
                    // add it into the table
                    $metatable[$irodsrow]['irodsid'] = $irodsid;
                }
            }
            // increment for each meta that has been added
            $irodsrow += 1;
        }
    }
    
    // add this term into the array so we won't process it again
    $extractedterms[] = $irods;
    // set the next row to the maximum of either the irods or ark before we start on a new mapping
    $rows = max(array(
                    $irodsrow,
                    $arkrow
    ));
}
unset($extractedterms);
// matching the metadata array
// loop through each row the metatable 
// we will make rows where terms and values are the same line up
// No matches yet
$matches = array();
foreach ( $metatable as $key => $meta ) {
    // check if there is data to match
    if(array_key_exists('arkdata',$meta)){
        $term = $meta['term'];
        $field= $meta['field'];
        //for each row go through all the rows again
        foreach ( $metatable as $k => $search ) {
            // check if there is data to match
            if(array_key_exists('irodsdata',$search)){
                // if the keys are different and the terms match, then check values
                if ($k != $key && $search['term'] == $term) {
                    if (in_array($key, $matches)){
                    // we already found this match
                        continue;
                    // look for a match
                    }else if ($search['irodsdata'] == $meta['arkdata'] && $search['irodsdata'] != "") {
                        // use a temp value to swap the two values
                        $temp = @$metatable[$k]['irodsdata'];
                        $metatable[$k]['irodsdata'] = @$metatable[$key]['irodsdata'];
                        $metatable[$key]['irodsdata'] = $temp;
                        $matches[]=$k;
                        print(logarray("matched row $k to row $key"));
                    }
                }
            }
        }
    }
}
// after sorting the metatable, scrap any empty rows
foreach ($metatable as $key=>$meta){
    if (@$meta['arkdata']=='' && @$meta['irodsdata']==''){
        unset($metatable[$key]);
    }
}
print(logarray($metatable));

// ---- MARKUP ----
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_noattr = getMarkup('cor_tbl_markup', $lang, 'noattr');


// ---- STATE SPECFIC
// for each state get specific elements and then produce output
switch ($sf_state) {
    // minimised views
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        printf("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        printf("</div>");
        // end the min views
        break;
        
    // maximised edit and enter routines
    case 'p_max_edit':
    case 's_max_edit':
    case 'p_max_ent':
    case 's_max_ent':
        printf("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        // process the fields array
        //$fields = resTblTh($sf_conf['fields'], 'silent');
        // Headers
        printf("Metadata is extracted from other fields and will be available on update");
        break;
        
    // maximised views
    case 'p_max_view':
    case 's_max_view':
    case 'xhtml_dump':
        // start the sf div
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if(!$filepath){
            $filepath='';
        }
        // some useful doc elements
        $var = "<span style=\"display:none\" id=\"filename\">$filepath</span>";
        $var .= "<span id=\"metadatamessage\">$error_message</span>";
        //start up the table
        $var .= '<table class="metadata">';
        $var.= '<tr><th>';
        $var .= getMarkup('cor_tbl_markup', $lang, "metaterm");
        $var.= '</th><th>';
        $var .= getMarkup('cor_tbl_markup', $lang, "arkmetamessage");
        $var .= "</th><th></th><th></th><th>";
        $var .= getMarkup('cor_tbl_markup', $lang, "irodsmetamessage");
        $var .= "</th></tr>";
        // set first row as 1. $row is not a reference to the key in the metatable
        $row=1;

        //render the table, one row at a time
        foreach ($metatable as $meta){
            $required_terms = array('arkdata','irodsdata','arkid','irodsid');
            foreach ($required_terms as $key){
                if (!array_key_exists($key,$meta)){
                    $meta[$key]="";
                }
            }
            // Create JSON objects for the buttons
            $arkbutton = json_encode(
                    array(
                        "field"=>$meta['field'],
                        "classtype"=>$meta['classtype'],
                        "itemkey"=>$item_key,
                        "itemval"=>$$item_key,
                        "ark"=>$meta['arkdata'],
                        "irods"=>$meta['irodsdata'],
                        "id"=>$meta['arkid'],
                        "attrid"=>$meta['irodsid'],
                    )
                );
            $irodsbutton = json_encode(
                    array(
                        "term" => $meta['term'],
                        "filename" => $filepath,
                        "ark" => $meta['arkdata'],
                        "irods" => $meta['irodsdata'],
                        "account" => $irods_account,
                    )
                );
            $var.="<script> window.arkbutton$row = $arkbutton;\n";
            $var.="window.irodsbutton$row = $irodsbutton</script>";
            $htmlarkdata = htmlentities($meta['arkdata']);
            $htmlirodsdata = htmlentities($meta['irodsdata']);
            // the term
            $var .= "<tr id=\"row$row\"><td >{$meta['term']}</td>";
            // the ark td, with and info and a value span
            $var .= "<td><span id=\"ark:$row\" class=\"arkdnd\" >{$htmlarkdata}</span></td>";
            // the toArk button, with onclick JS function built with php variables
            $var .= "<td><button onclick=\"toArk(window.arkbutton$row)\"><</button></td>";
            // the toIrods button, with onclick JS function built with php variables
            $var .= "<td><button onclick=\"toIrods(window.irodsbutton$row)\">></button></td>";
            // the irods td, just the value in a box
            $var .= "<td><span id=\"irod:$row\" class=\"iroddnd\">{$htmlirodsdata}</span></td></tr>";
            // count the rows, to keep all the ids unique
            $row +=1;
        }
        
        // close the table
        $var .= '</table>'; 
        
        // DEV NOTE: This style needs to be moved into the csss files
        // we need the padding so that we have something to drop onto in the case of an empty row 
        $var .= '<style>
        .iroddnd {cursor: pointer; display:block; padding:10px;}
        .arkdnd {cursor: pointer; display:block; padding:10px;}
        .metatable {cell-padding:10px;}
        </style>';
        $var .= "<script type=\"text/javascript\" src=\"".$ark_dir."mod_code/js/irodsmetaupdater.js\"></script>";

        $var .= "<script type=\"text/javascript\">console.log(document.getElementById(\"filename\").innerHTML)</script>";
        
        // output the sf
        print $var;
        // close the sf div
        echo "</div>\n";
        // clean up
        unset ($sf_conf);
        unset ($val);
        unset ($sf_state);
        unset ($fields);
        break;
    
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_attribute_by_type\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_attribute_by_type was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
    // do some cleanup - applies to all cases
    unset ($sf_conf);
    unset ($val);
    unset ($sf_state);
    unset ($fields);
}

?>
