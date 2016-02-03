<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* export_functions.php
*
* contains functions for exporting
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
* @category   export
* @package    ark
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2012 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/export_functions.php
* @since      File available since Release 0.6
*
* Code cleaned and tidied at v1.1
*
*/

// {{{ exportXMLItemList()
    
/**
* returns XML according to the ARK schema created my Henriette
*
* @param array $export_conf  the array of export options
* @param string $mod  the requested mod
* @return array $errors  if there are any errors an array is returned
* @author Henriette Roued Olsen
* @since 0.6
*
* At v1.1 cleaning up of global path vars has probably made this function break
* the function now returns the $file for handling by a subform rather than an
* html message. GH 6/12/12
*
* This code relies on a variable $ark_client being set, not sure what that is GH 6/12/12
*
*/

function exportXMLItemList($export_conf, $mod)
{
    global $lang, $export_dir, $ark_client, $ark_db;
    $file = $export_dir."XML_item_list_export.xml";
    
    // Creating the URL to search the client and get the XML output
    $xml_name = $ark_client.'?method=getItemList&ark_name='.$ark_db.'&mod_key='.$mod.'_cd';
    $xml = new DOMDocument();
    // Loading the XML
    $xml->load($xml_name);
    $xml->save($file);
    //fclose($fh);
    // return the file
    return $file;
}

// }}}
// {{{ exportItemList()
    
/**
* returns XML according to the ARK schema created my Henriette
*
* @param array $export_conf  the array of export options
* @param string $mod  the requested mod
* @return array $errors  if there are any errors an array is returned
* @author Henriette Roued Olsen
* @since 0.6
*
* At v1.1 cleaning up of global path vars has probably made this function break
* the function now returns the $file for handling by a subform rather than an
* html message. GH 6/12/12
*
* This code relies on a variable $ark_client being set, not sure what that is GH 6/12/12
*
*/

function exportItemList($export_conf, $mod)
{
    global $lang, $export_dir, $ark_client, $ark_db;
    $file = $export_dir . "item_list_export.xml";
    //$fh = fopen($file,'w') or die("can't open file");
    // Creating the URL to search the client and get the XML output
    $xml_name = $ark_client.'?method=getItemList&ark_name='.$ark_db.'&mod_key='.$mod.'_cd';
    $xml = new DOMDocument();
    // Loading the XML
    $xml->load($xml_name);
    $xml->save($file);
    //fclose($fh);
    return $file; 
}

// }}}
// {{{ exportXMLItem

/**
* returns a XML according to the ARK schema created by Henriette
*
* @param array $export_conf  the array of export options
* @param string $mod  the requested mod
* @return array $errors  if there are any errors an array is returned
* @author Henriette Roued Olsen
* @since 0.6
*
* This code relies on a variable $ark_client being set, not sure what that is GH 6/12/12
*
*/

function exportXMLItem($export_conf, $mod, $item_val)
{
    global $lang, $export_dir, $ark_client, $ark_db;
    $file = $export_dir . "_item_".$item_val."_export.xml";    
    // Creating the URL to search the client and get the XML output
    $xml_name = $ark_client.'?method=getItem&ark_name='.$ark_db.'&mod_key='.$mod.'_cd&item_value='.$item_val;
    $xml = new DOMDocument();
    // Loading the XML
    $xml->load($xml_name);
    $xml->save($file);
    return $file;
}

// }}}
// {{{ exportMediaRSS()

/**
* returns a media RSS document (basically an RSS feed of images)
*
* @param array $export_conf  the array of export options
* @param string $mod  the requested mod
* @return array $errors  if there are any errors an array is returned
* @author Stuart Eve
* @since 0.6
*
*/

function exportMediaRSS($export_conf, $mod)
{
    // this could need a bit of a boost in terms of processing
    ini_set("max_execution_time", "500");
    ini_set("memory_limit", "50M");
    $var = FALSE;
    // first setup the appropriate headers
    header('Content-type: application/xml; charset="utf-8"',true);
    $var .= '<?xml version="1.0" encoding="utf-8" standalone="yes"?>
                <rss version="2.0" 
                  xmlns:media="http://search.yahoo.com/mrss"
                  xmlns:atom="http://www.w3.org/2005/Atom">
                    <channel>
    
    ';
    
    // now go through the export_conf fields making sure we have a file conf
    foreach ($export_conf['export_fields'] as $key => $value) {
        if ($value['dataclass'] == 'file') {
            $file = TRUE;
        }
    }
    
    if ($file == TRUE) {
        $content = elemMediaRSS($export_conf,$mod);
    } else {
        $var .= "NO FILES IN CONF";
    }
    
    if (isset($content)) {
        $var .= $content;
    }
    
    //now end the RSS feed cleanly
    $var .= '       </channel>
                </rss>';
    print $var;
}

// }}}
// {{{ elemMediaRSS()

/**
* returns elements for a Media RSS feed
*
* @param array $export_conf the array of export options
* @param string $mod  the requested mod
* @return string $elem  the element
* @author Stuart Eve
* @since 0.6
*
*/

function elemMediaRSS($export_conf, $mod)
{
    $web_host = getWebHost();
    global $ark_root_path;
    $elem = '';
    //check if we have a txt field in the export conf to be used as the label
    foreach ($export_conf['export_fields'] as $key => $value) {
        if ($value['dataclass'] == 'txt') {
            $txt_field = $value;
        }
    }
    //now grab all of the files that are attached to this particular mod
    $files = getAllFiles($mod);
    
    //foreach through the files and build up the return elements
    if (is_array($files) && !empty($files)) {
        foreach ($files as $key => $file) {
            if (isset($txt_field)){
                  $title =  resTblTd($txt_field, $file['itemkey'], $file['itemvalue']) . " {$file['itemvalue']}";
            }
            
            $elem .= '
             <item>';
            if (isset($title)) {
                $elem .= "<title>$title</title>";
            } else {
                $elem .= "<title>{$file['itemvalue']}</title>";
            }
            $elem .="
                <link>$web_host/$ark_root_path/micro_view.php?item_key={$mod}_cd&amp;{$mod}_cd={$file['itemvalue']}</link>
                 <media:thumbnail url=\"$web_host/$ark_root_path/data/files/arkthumb_{$file['file']}.jpg\"/>
                 <media:content url=\"$web_host/$ark_root_path/data/files/{$file['file']}.jpg\"/>
             </item>
            ";
        }
    }
    return $elem;
}

// }}}
// {{{ exportCSV()
    
/**
* returns a CSV file containing the csv output of the fields passed
*
* @param array $conf_array  the array of columns
* @param string $results_array  an ARK standard results array
* @return array $uri  this function returns a URI
* @author Stuart Eve
* @author Guy Hunt
* @since 0.6
*
* NOTE: Export Directory MUST include the full server root. This is relative to the filesystem
* and NOT relative to the webserver
*
* As of v0.8 this has been significantly rewritten
*
*/

function exportCSV($results_array, $conf)
{
    // SETUP
    // get the export dir (from settings.php)
    global $export_dir, $lang;
    $error = FALSE;
    $message = FALSE;
    
    // Markup
    $mk_problem_csv_detected = getMarkup('cor_tbl_markup', $lang, 'problem_csv_detected');
    
    // set up a file name and path
    $orig_file = tempnam($export_dir, 'csv');
    if (!file_exists($orig_file)) {
        echo "ADMIN ERROR: Unable to create file on directory: '$export_dir'<br/>";
    }
    $file = $orig_file.'.csv';
    
    // rename the file with the right file extension
    rename($orig_file, $file);
    if (!file_exists($file)) {
        echo "ADMIN ERROR: Unable to rename file<br/>";
    }
    
    // open the file ready for action (file handler)
    $fh = fopen($file, 'w') or die("can't open file");
    
    // META CONFIG
    //check if there is a custom field delimiter in the conf_array
    if (array_key_exists('op_field_delimiter', $conf)){
        $field_delimiter = $conf['op_field_delimiter'];
    } else {
        // default to a comma
        $field_delimiter = ',';
    }
    //check if there is a custom text delimiter in the conf_array
    if (array_key_exists('op_text_delimiter', $conf)){
        $text_delimiter = $conf['op_text_delimiter'];
    } else {
        // default to a double quote
        $text_delimiter = '"';
    }
    
    // FIELDS CONFIG
    // fields
    $fields = $conf['fields'];
    
    // process the column headers
    $headers = resTblTh($fields, 'silent');
    // if clean headers option is set then process these headers
    if (array_key_exists('op_clean_headers', $conf)) {
        foreach ($headers as $key => $value) {
            $headers[$key]['field_alias'] = strtolower(preg_replace('/\s+/','_', $value['field_alias']));
        }
    }
    
    // ---- OUTPUT ---- //
    // set up a var for the returning code
    $var = FALSE;
    
    // HEADERS
    foreach ($headers as $key => $value) {            
        $var .= $text_delimiter.$value['field_alias'].$text_delimiter.$field_delimiter;
    }
    // end the line with a new line character
    $var .= "\n";
    
    // DATA
    // loop over each item in the result set fetching the specified field information
    foreach ($results_array as $key => $item) {
        $itemkey = $item['itemkey'];
        $itemval = $item['itemval'];
        foreach ($fields as $key => $field) {
            $elem = csvElem($field, $itemkey, $itemval);
            // let server handle timeouts
            set_time_limit(0);
            $elem = csvElem($field, $itemkey, $itemval);
            // according to RFC 4180 CSV files with " in fields should escape them with ""
            if($text_delimiter == '"'){
                $elem = doubleNeedle($text_delimiter, $elem);
            }
            if (strpos($elem, $text_delimiter) !== FALSE) {
            
                // this means the delimiter has been found within a field
                $msg =
                    array(
                        'vars' => $mk_problem_csv_detected,
                        'problem_key' => $itemkey,
                        'problem_val' => $itemval,
                        'problem_string' => $elem,
                        'problem_field' => $field,
                );
                $message[] = $msg;
            }
            $var .= $text_delimiter.$elem.$text_delimiter.$field_delimiter;
        }
        // end the line with a new line character
        $var .= "\n";
    }
    
    // write the var to the file
    fwrite($fh, $var);
    
    // Close out the file
    fclose($fh);
    
    // Return the filepath to the download file
    if ($error) {
        return $error;
    } else {
        if ($message) {
            $ret['message'] = $message;
            $ret['file'] = $file;
            return $ret;
        } else {
            return $file;
        }
    }
}

// }}}
// {{{ csvElem()

/**
* returns elements for a CSV file
*
* @param array $field  an ARK field
* @param string $itemkey  an ARK itemkey
* @param string $itemvalue  an ARK itemval
* @return string $elem  the relevant data
* @author Stuart Eve
* @since 0.6
*
* NOTE: As of v0.8 this has been brought more into line with the resTblTd() function
* the main difference here is that data is formatted into tab separated lists for CSV
* whereas resTblTd() puts data into XHTML list elements. GH 21/12/2010
*
* Please try to keep this as close as possible to resTblTd()
*
*/

function csvElem($field, $itemkey, $itemvalue)
{
    global $lang, $registered_files_dir;
    
    // get an itemkey
    if ($field['dataclass'] == 'itemkey') {
        $var = $itemvalue;
    }
    
    // get a modtype
    if ($field['dataclass'] == 'modtype') {
        $mod = substr($itemkey, 0, 3);
        $modtype = $mod.'type';
        $tbl = $mod.'_lut_'.$modtype;
        $var = getModType($mod, $itemvalue);
        $var = getAlias($tbl, $lang, 'id', $var, 1);
    }
    
    // get a txt
    if ($field['dataclass'] == 'txt') {
        // Notes: Originally this made the call without specifying a $lang and hence would
        // pull the first text the function came to. Later we added the $lang variable to
        // the function call. Sadly tho this means that it fails if there is no text of the
        // specified lang and type (This is correct and expected behavoir for getSingleText()).
        // In order to get round this, I have added a handler here to try first for the
        // specified language and then failing that to try for anything.
        // I have a suspicion that this is not the last time this call will prove problematic
        // it may be best for us to allow an op_ on the field to specify what is wanted from this
        // op_xxxx = not set would do what it always did
        // op_xxxx = TRUE would send the global $lang
        // op_xxxx = string would send a specified language
        // GH 11/10/10
        $var = getSingleText($itemkey, $itemvalue, $field['classtype'], $lang);
        if (!$var) {
            $var = getSingleText($itemkey, $itemvalue, $field['classtype']);
        }
    }
    
    // get a number
    if ($field['dataclass'] == 'number') {
        $numbers = getNumber($itemkey, $itemvalue, $field['classtype']);
        if ($numbers) {
            if (count($numbers) > 1) {
                foreach ($numbers as $key => $number) {
                    $var .= "{$numbers['number']}\t";
                }
            } else {
                $var = $numbers[0]['number'];
            }
        } else {
            $var = FALSE;
        }
    }
    
    // get a date
    if ($field['dataclass'] == 'date') {
        $var = getDateARK($itemkey, $itemvalue, $field['classtype'], $field['datestyle']);
    }
    
    // get the actors of an action
    if ($field['dataclass'] == 'action') {
        $elem = FALSE;
        $action_array = getActor($itemkey, $itemvalue,  $field['classtype'], 'abk_cd');
        if($action_array && is_array($action_array)) {
            // if this is a single actor event
            if ($field['actors_style'] == 'single') {
                // Get the actor for this actiontype for this item
                $action = end($action_array);
                $var =
                    getActorElem(
                        $action['actor_itemvalue'],
                        $field['actors_element'],
                        $field['actors_mod'].'_cd',
                        $field['actors_elementclass']
                );
            }
            // if this is a multi actor action list them first
            if ($field['actors_style'] == 'list') {
                // Get the actor id for this actiontype for this item
                $var = '<ul class="actor_list">';
                foreach ($action_array as $action) {
                    $var .= 
                        getActorElem(
                            $action['actor_itemvalue'],
                            $field['actors_element'],
                            'abk_cd',
                            'txt'
                    ) . "\t";
                }
            }
        } else {
            $var = FALSE;
        }
    }
    
    // get attribute
    // attr, handle erroneous dataclass naming
    if ($field['dataclass'] == 'attr') {
        echo "ADMIN ERROR: as of v1.0 dataclass in fields must be declared as 'attribute' not 'attr'<br/>";
        $field['dataclass'] = 'attribute';
    }
    
    if ($field['dataclass'] == 'attribute') {
        // if we have an attribute type we need to get all attributes of the type
        $attrs = getCh('attribute', $itemkey, $itemvalue, $field['classtype']);
        if ($attrs) {
            if (count($attrs) > 1) {
                $var = FALSE;
                foreach ($attrs as $key => $attr) {
                    $attralias = getAttr(FALSE, $attr, 'SINGLE', 'alias', $lang);
                    $var .= "$attralias\t";
                }
            } else {
                $var = getAttr(FALSE, $attrs[0], 'SINGLE', 'alias', $lang);
            }
        } else {
            $var = FALSE;
        }
    }
    if ($field['dataclass'] == 'xmi') {
        $xmi_mod = $field['xmi_mod'];
        $xmi_key = $xmi_mod . '_cd';
        // Includes relevant settings file
        include ('src/settings.php');
        include ('config/field_settings.php');
        include ('config/mod_'.$xmi_mod.'_settings.php');
        $xmi_conf_name = $xmi_mod.'_xmiconf';
        $xmi_conf = $$xmi_conf_name;
        if (array_key_exists('op_disp_full_xmi',$xmi_conf)) {
            $xmi_fields = $xmi_conf['fields'];
            $xmi_fields = resTblTh($xmi_fields, 'silent');
            
            // ---- DATA ---- //
            // Gets the XMIed items linked to this item but in the specified module
            $xmi_list = getXmi($itemkey, $itemvalue, $xmi_mod);
            if ($xmi_list){
            // Process out the required fields for each XMIed item and add to the array
                foreach ($xmi_list as $key => $xmi_item) {
                    foreach ($xmi_fields as $xmi_field) {
                        $xmi_vars[] = csvElem($xmi_field, $xmi_key, $xmi_item['xmi_itemvalue']);
                    }
                    $xmi_list[$key]['xmi_vars'] = $xmi_vars;
                    unset($xmi_vars);
                    // Optional sorting of XMIed items
                    if (array_key_exists('op_xmi_sorting', $xmi_conf)) {
                        $xmi_list[$key]['sort_key'] = csvElem($xmi_conf['op_xmi_sort_field'], $xmi_key, $xmi_item['xmi_itemvalue']);
                    }
                }
            }
            //printPre($xmi_list);
            //echo "xmi_list: " . count($xmi_list);
            if ($xmi_list) {
                $var = '';
                if (count($xmi_list) > 1) {
                    foreach ($xmi_list as $list_key => $list_value) {
                        if (array_key_exists('xmi_vars',$list_value) && !empty($list_value['xmi_vars'])) {
                            foreach ($list_value['xmi_vars'] as $key => $xmi) {
                                $var .= $xmi . ' ';
                            }
                        }
                    }
                } else {
                    if (array_key_exists('xmi_vars',$xmi_list[0]) && !empty($xmi_list[0]['xmi_vars'])) {
                        foreach ($xmi_list[0]['xmi_vars'] as $key => $xmi) {
                            $var .= $xmi . ' ';
                        }
                    } else {
                        $var = $xmi_list[0]['xmi_itemvalue'];
                    }
                }
            } else {
                $var = FALSE;
            }
        } else {
            $xmi_list = getXmi($itemkey, $itemvalue, $field['xmi_mod']);
            if ($xmi_list) {
                if (count($xmi_list) > 1) {
                    foreach ($xmi_list as $key => $xmi) {
                        $var .= $xmi['xmi_itemvalue'];
                    }
                 } else {
                     $var = $xmi_list[0]['xmi_itemvalue'];
                 }
             } else {
                 $var = FALSE;
             }
        }
    }
    // get file list
    if ($field['dataclass'] == 'file') {
        $file_list = getFile($itemkey, $itemvalue);
        if ($file_list) {
            if (count($file_list) > 1) {
                foreach ($file_list as $key => $file) {
                    $var .= "{$file['filename']}\t";
                }
            } else {
                $var = current($file_list);
                $var = $var['filename'];
            }
        } else {
            $var = FALSE;
        }
    }
    
    // get a span
    if ($field['dataclass'] == 'span') {
        $spans = getSpan($itemkey, $itemvalue, $field['classtype']);
        // handle the divider option
        if (array_key_exists('field_op_divider', $field)) {
            $divider = $field['field_op_divider'];
        } else {
            $divider = FALSE;
        }
        // handle the AD/BC modifier option
        if (array_key_exists('field_op_modifier', $field)) {
            $field_op_modifier = $field['field_op_modifier'];
        } else {
            $field_op_modifier = FALSE;
        }
        if ($spans) {
            if (count($spans) > 1) {
                $var = FALSE;
                foreach ($spans as $key => $span) {
                    // an AD/BC modifer may be in use
                    if ($field_op_modifier) {
                        $beg = $span['beg']-2000;
                        $end = $span['end']-2000;
                        // sort out epochs
                        if ($beg > 0) {
                            $start_epoch = 'BC';
                        } else {
                            $start_epoch = 'AD';
                            $beg = abs($beg);
                        }
                        $beg .= $start_epoch;
                        if ($end > 0) {
                            $end_epoch = 'BC';
                        } else {
                            $end_epoch = 'AD';
                            $end = abs($end);
                        }
                        $end .= $end_epoch;
                    } else {
                        if(array_key_exists('beg', $spans)){
                            $beg = $spans['beg'];   
                        }
                        if(array_key_exists('end', $spans)){
                            $beg = $spans['end'];
                        }
                    }
                    $var .= "{$beg}{$divider}{$end}\t";
                }
            } else {
                // an AD/BC modifer may be in use
                if ($field_op_modifier) {
                    $beg = $spans[0]['beg']-2000;
                    $end = $spans[0]['end']-2000;
                    // sort out epochs
                    if ($beg > 0) {
                        $start_epoch = 'BC';
                    } else {
                        $start_epoch = 'AD';
                        $beg = abs($beg);
                    }
                    $beg .= $start_epoch;
                    if ($end > 0) {
                        $end_epoch = 'BC';
                    } else {
                        $end_epoch = 'AD';
                        $end = abs($end);
                    }
                    $end .= $end_epoch;
                } else {
                    $beg = $spans[0]['beg'];
                    $end = $spans[0]['end'];
                }
                $var = "{$beg}{$divider}{$end}";
            }
        } else {
            $var = FALSE;
        }
    }
    
    // get options
    if ($field['dataclass'] == 'op') {
        $var = FALSE;
    }
    
    // return the var
    return ($var);

}

// }}}
// {{{ exportXMLExt

/**
* returns a XML file containing the xml output of the fields passed from data_view
*
* @param array $export_conf  the array of export options
* @param string $mod  the requested mod
* @return array $errors  if there are any errors an array is returned
* @author Henriette Roued
* @since 0.6
*
* At v1.1 cleaning up of global path vars has probably made this function break
* the function now returns the $file for handling by a subform rather than an
* html message. GH 6/12/12
*
*/

function exportXMLExt($export_conf)
{
    // globals
    global $lang, $export_dir;
    // this could need a bit of a boost in terms of processing
    ini_set("max_execution_time", "30000");
    $var = FALSE;
    $rand = rand(1, 200);
    $file = $export_dir."/ARK_export".$rand.".xml";
    $fh = fopen($file,'w') or die("can't open file");
    
    //check if there is a delimiter specified in the conf_array
    if (array_key_exists('op_field_delimiter', $export_conf)){
        $field_delimiter = $export_conf['op_field_delimiter'];
    } else {
        $field_delimiter = ',';
    }
    if (array_key_exists('op_text_delimiter', $export_conf)){
        $text_delimiter = $export_conf['op_text_delimiter'];
    } else {
        $text_delimiter = '"';
    }
    // prepare to output results
    $var .= '<results>';
    foreach ($export_conf as $key => $value) {
        $var .= '<result>';
        foreach($value as $key2 => $value2){
            $$key2 = $value2;
        }
        $itemalias = getAlias('cor_tbl_module', $lang, 'itemkey', $itemkey, 1);
        $var .= '<module>'.$itemalias.'</module>';
        $var .= '<itemkey>'.$itemkey.'</itemkey>';
        $var .= '<itemval>'.$itemval.'</itemval>';
        $var .= '<score>'.$score.'</score>';
        $var .= '</result>';
    }
    // close out
    $var .= '</results>';
    // write the file
    fwrite($fh, $var);
    fclose($fh);
    // return
    return $file;
}

// }}}
// {{{ exportRSS()

/**
* returns an RSS feed for an ARK standard results_array
*
* @param array $results_array  an ARK standard results_array (mixed modules are supported)
* @param array $conf  a config array (see note 2)
* @return array $feed  a valid RSS feed
* @author Stuart Eve
* @author Guy Hunt
* @since 1.0
*
* This function is derived from exportRSSExt() which is now deprecated. It is in fact a fairly major
* rewrite of the function.
*
* NOTE 1: if there are errors, the feed will be returned as an error array (see also exportCSV())
*
* NOTE 2: this conf is sent directly to the call and contains the 5 variables:
*    $feed_mode = $conf['feed_mode'];
*    $limit = $conf['limit'];
*    $feedtitle = $conf['feedtitle'];
*    $feeddesc = $conf['feeddesc'];
*    $feeddisp_mode = $conf['feeddisp_mode'];
*
* NOTE 3: Validate your conf and your results array BEFORE calling this output function
*
*/

function exportRSS($results_array, $conf)
{
    global $lang, $conf_micro_viewer, $conf_data_viewer, $conf_feed_viewer;
    // include fields
    include('config/field_settings.php');
    // get the web host
    $webhost = getWebHost();
    // get back the important conf vars
    $feed_mode = $conf['feed_mode'];
    $limit = $conf['limit'];
    $feedtitle = $conf['feedtitle'];
    $feeddesc = $conf['feeddesc'];
    $feed_id = $conf['feed_id'];
    $feeddisp_mode = $conf['feeddisp_mode'];
    if (array_key_exists('feedfields',$conf)) {
        $feedfields = $conf['feedfields'];
    }
    
    // Set up the vars
    $xml_output = FALSE;
    $xml_header = FALSE;
    $xml_content_output = FALSE;
    $geotag = FALSE;
    
    // XML headers
    $xml_header .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $xml_header .= "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
    $xml_header .= "<channel>\n";
    $xml_header .= "<atom:link href=\"{$webhost}{$conf_feed_viewer}?feed_id=$feed_id\" rel=\"self\"";
    $xml_header .= " type=\"application/rss+xml\" />";
    $xml_header .= "<link>{$webhost}{$conf_data_viewer}?retftrset=$feed_id</link>\n";
    $xml_header .= "<title>ARK RSS Feed: $feedtitle</title>\n";
    $xml_header .= "<description>$feeddesc</description>\n\n\n";
    
    // Loop thru the results_array
    foreach ($results_array as $res_item) {
        if (!is_array($feedfields)) {
            // Get the mod settings for this mod 
            $mod_short = substr($res_item['itemkey'], 0, 3);
            include_once('config/mod_'.$mod_short.'_settings.php');
            $conf_name = "conf_mac_{$feeddisp_mode}";
            $conf_array = $$conf_name;
            $fields = resTblTh($conf_array['fields'], 'silent');
        } else {
            $fields = resTblTh($feedfields, 'silent');
        }
        
        // set up a link to the micro_view of this item
        $item_link = $webhost.$conf_micro_viewer;
        $item_link .= "?item_key={$res_item['itemkey']}&amp;{$res_item['itemkey']}={$res_item['itemval']}";
        // make an alias for the item
        $item_alias = getAlias('cor_tbl_module', $lang, 'itemkey', $res_item['itemkey'], 1);
        // begin XML output for this item
        $xml_content_output .= "<item>\n";
        $xml_content_output .= "<title>{$item_alias}: {$res_item['itemval']}</title>\n";
        $xml_content_output .= "<link>$item_link</link>\n";
        $xml_content_output .= "<guid>$item_link</guid>\n";
        $xml_content_output .= "<description>\n";
        // output each field
        foreach($fields as $field) {
            // make up the val (if not a file or an option)
            $ignore_these_dataclases = array('file', 'op', 'itemkey');
            if (!in_array($field['dataclass'], $ignore_these_dataclases)) {
                // DEV NOTE: this is using the csvElem() func... maybe we ought to have an RSS specific one?
                $val = csvElem($field, $res_item['itemkey'], $res_item['itemval']);
            } else {
                $val = FALSE;
            }
            // check if this field has a geoRSS tag in which case set it up
            if (array_key_exists('op_tag_RSSExt', $field)) {
                $tag = $col['op_tag_RSSExt'];
                // output the field to a var for appending after the description is finished
                $geotag = "<$tag>$val</$tag>\n";
            }
            // output the field
            $xml_content_output .= $val."\n";
        }
        $xml_content_output .= "</description>\n";
        $xml_content_output .= $geotag;
        // close XML content output for this item
        $xml_content_output .= "</item>\n\n";
    }    
    // close XML content output
    $xml_content_output .= "</channel>\n";
    $xml_content_output .= "</rss>";
    // OUTPUT
    // build the feed
    $feed = $xml_header.$xml_content_output;
    // return the feed
    return $feed;
}

// }}}
// {{{ exportPelagios()

/**
* returns a Pelagios compliant RDF N3 feed for an ARK standard results_array
*
* @param array $results_array  an ARK standard results_array (mixed modules are supported)
* @param array $conf  a config array (see note 2)
* @return array $feed  a valid RSS feed
* @author Stuart Eve
* @author Guy Hunt
* @since 1.0
*
* This function is derived from exportrss(). It is in fact a fairly major
* rewrite of the function.
*
* NOTE 1: if there are errors, the feed will be returned as an error array (see also exportCSV())
*
* NOTE 2: this conf is sent directly to the call and contains the 5 variables:
*    $feed_mode = $conf['feed_mode'];
*    $limit = $conf['limit'];
*    $feedtitle = $conf['feedtitle'];
*    $feeddesc = $conf['feeddesc'];
*    $feeddisp_mode = $conf['feeddisp_mode'];
*
* NOTE 3: Validate your conf and your results array BEFORE calling this output function
*
*/

function exportPelagios($results_array, $conf)
{
    // SETUP
    // get the export dir (from settings.php)
    global $export_dir, $lang;
    $error = FALSE;
    $message = FALSE;
     // get the web host
    $webhost = getWebHost();
    
    // Markup
    $mk_problem_rdf_detected = getMarkup('cor_tbl_markup', $lang, 'problem_rdf_detected');
    
    // set up a file name and path - note this will make a file with an n3 extension
    $orig_file = tempnam($export_dir, 'n3');
    if (!file_exists($orig_file)) {
        echo "ADMIN ERROR: Unable to create file on directory: '$export_dir'<br/>";
    }
    $file = $orig_file.'.n3';
    
    // rename the file with the right file extension
    rename($orig_file, $file);
    if (!file_exists($file)) {
        echo "ADMIN ERROR: Unable to rename file<br/>";
    }
    
    // open the file ready for action (file handler)
    $fh = fopen($file, 'w') or die("can't open file");
    
    // FIELDS CONFIG
    // fields
    $fields = $conf['fields'];
    
    // process the column headers
    $headers = resTblTh($fields, 'silent');
    
    // ---- OUTPUT ---- //
    // Set up the vars
    $rdf_output = FALSE;
    $rdf_header = FALSE;
    $rdf_content = FALSE;
    $i = 1;
    $var = FALSE;
    
    // DATA
    // loop over each item in the result set fetching the specified field information
    // Loop thru the results_array
    foreach ($results_array as $key => $res_item) {
        // set up a link to the micro_view of this item
        $uri = $webhost."/micro_view.php";
        $uri .= "?item_key={$res_item['itemkey']}&{$res_item['itemkey']}={$res_item['itemval']}";
        // begin RDF output for this item
        $rdf_content_output = array();
        // loop over fields
        foreach($fields as $field){
            // make up the val (if not a file or an option)
            $ignore_these_dataclases = array('file', 'op', 'itemkey');
            if (!in_array($field['dataclass'], $ignore_these_dataclases)) {
                // DEV NOTE: this is using the csvElem() func... maybe we ought to have an RSS specific one?
                $val = csvElem($field, $res_item['itemkey'], $res_item['itemval']);
            } else {
                $val = FALSE;
            }
            // check if this field has special RDF tags in which case set it up
            // ADMIN NOTE: the possible tags are currently - 'label' - anything else will be exported as dtat (<hasBody>)
            if (array_key_exists('field_op_tag_RDF', $field) && $val != FALSE) {
                if ($field['field_op_tag_RDF'] == "label") {
                    // output the field as a label - escaping any quotes within the data
                    $val = addslashes($val);
                    $rdf_content_output['title'] = "<http://purl.org/dc/terms/title> \"$val\" .\n";
                } else {
                    // output the field as data  - escaping any quotes within the data
                    $val = addslashes($val);
                    $rdf_content_output['body'] = "<http://www.openannotation.org/ns/hasBody> <$val> .\n";
                }
            } else {
                if ($val != FALSE) {
                    // output the field - we are presuming this is a Pleiades URI - sometimes this can be multiple
                    // so explode on spaces (as single URIs should not have them) and then deal with the multiple entries later
                    $explode_val = explode(' ', $val);
                    if (count($explode_val) > 1) {
                        foreach ($explode_val as $body_value) {
                            if ($body_value != '') {
                                $rdf_content_output['multi_body'][] = $body_value;
                            }
                        }
                    } else {
                        $rdf_content_output['body'] = "<http://www.openannotation.org/ns/hasBody> <$val> .\n";
                    }
                }
            }
        }
        $rdf_content_output['target'] = "<http://www.openannotation.org/ns/hasTarget> <$uri> .\n";
        if (count($rdf_content_output) == 3) {
            //first check if we have multiples - if so we need sperate annotations for each
            if (array_key_exists('multi_body',$rdf_content_output)) {
                foreach ($rdf_content_output['multi_body'] as $content_value) {
                    $rdf_item_uri = "<$webhost#set1/annotation$i>";
                    $rdf_content = $rdf_content . $rdf_item_uri . "<http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.openannotation.org/ns/Annotation> .\n";
                    $rdf_content = $rdf_content . $rdf_item_uri . $rdf_content_output['title'];
                    $rdf_content = $rdf_content . $rdf_item_uri . "<http://www.openannotation.org/ns/hasBody> <$content_value> .\n";
                    $rdf_content = $rdf_content . $rdf_item_uri . $rdf_content_output['target'];
                    $i++;
                }
            } else {
                $rdf_item_uri = "<$webhost#set1/annotation$i>";
                $rdf_content = $rdf_content . $rdf_item_uri . "<http://www.w3.org/1999/02/22-rdf-syntax-ns#type> <http://www.openannotation.org/ns/Annotation> .\n";
                $rdf_content = $rdf_content . $rdf_item_uri . $rdf_content_output['title'];
                $rdf_content = $rdf_content . $rdf_item_uri . $rdf_content_output['body'];
                $rdf_content = $rdf_content . $rdf_item_uri . $rdf_content_output['target'];
                // $rdf_content = $rdf_content . $value;
                $i++;
            }
        }  
    } 
    // OUTPUT
    // build the feed
    $var = $rdf_header.$rdf_content;
    
    // write the var to the file
    fwrite($fh, $var);
    
    // Close out the file
    fclose($fh);
    
    // Return the filepath to the download file
    if ($error) {
        return $error;
    } else {
        if ($message) {
            $ret['message'] = $message;
            $ret['file'] = $file;
            return $ret;
        } else {
            return $file;
        }
    }
}

// }}}
// {{{ addFeed()

/**
* sets up a feed and returns a permalink for the feed
*
* @param array $export_conf  the array of export options (or a fully-formed results_array)
* @return array $permalink  permalink of the feed (if there are any errors an array is returned)
* @author Guy Hunt
* @since 1.0
*
* This function is derived from exportRSSExt() which is now deprecated. It is in fact a fairly major
* rewrite of the function.
*
* In line with std. architecture, this add function assumes you have validated the vars you are sending to it
*
*/

function addFeed($filters, $feed_mode, $limit, $feedtitle, $feeddesc, $feeddisp_mode, $feedfields = FALSE)
{
    global $lang, $user_id, $conf_feed_viewer, $anon_login;
    // Markup
    $mk_err_feeddbsave = getMarkup('cor_tbl_markup', $lang, 'err_feeddbsave');
    // presuppose no errors
    $error = FALSE;
    // failsafe checks for globalled vars
    // $conf_feed_viewer
    if (!$conf_feed_viewer) {
        echo 'ADMIN ERROR: your $conf_feed_viewer is not set up correctly<br/>';
        return FALSE;
    }
    // $user_id
    if (!$user_id) {
        echo 'ADMIN ERROR: your $user_id is not set up correctly<br/>';
        return FALSE;
    }
    // if this is an anon login - lock the form down
    if ($anon_login) {
        // for now this is a total lock down
        echo "ADMIN ERROR: Anon logins cannot create feeds";
        return FALSE;
    }
    
    // in order to force the feed_mode and limit to be saved we place these into the filters
    $filters['feed_mode'] = $feed_mode;
    $filters['limit'] = $limit;
    $filters['feedtitle'] = $feedtitle;
    $filters['feeddesc'] = $feeddesc;
    $filters['feeddisp_mode'] = $feeddisp_mode;
    if ($feedfields) {
        $filters['feedfields'] = $feedfields;
    }
    // save the filterset to the db
    $new_feed_id = addFtr($filters, 'feed', $feedtitle, 0, $user_id);
    if ($new_feed_id) {
        $permalink = "{$conf_feed_viewer}?feed_id={$new_feed_id}";
    } else {
        $error[] =
            array(
                'field' => 'addFtr()',
                'vars' => $mk_err_feeddbsave
        );
    }
    
    // return the permalink
    if ($error) {
        $permalink['message'] = $error;
        return $permalink;
    } else {
        return $permalink;
    }
}

// }}}
// {{{ exportAtom()

/**
* returns an XML file containing the xml output of the fields passed from data_view using the Atom schema
*
* @param array $export_conf  the array of export options (or a fully-formed results_array)
* @return array $errors  if there are any errors an array is returned
* @author Stuart Eve
* @since 0.7
*
*
*/
function exportAtom($export_conf)
{
    // globals
    global $lang, $ark_root_path;
    // get the web host
    $webhost = getWebHost();
    // establish the current URL
    $current_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $current_url = htmlentities($current_url);
    // include field settings
    include('config/field_settings.php');
    // establish page var info
    $total_results = $export_conf['total_results'];
    $no_of_pages = $export_conf['total'];
    $current_page = $export_conf['page'];
    $previous_page = $current_page -1;
    if ($previous_page < 1) {
        $previous_page = 1;
    }
    $next_page = $current_page + 1;
    $perpage = ceil($total_results/$no_of_pages);
    $current_index = $perpage*$current_page;
    // replace the full conf with just the paged results
    $export_conf = $export_conf['paged_results'];
    // set the date
    $date = date(DATE_ATOM, time());
    
    //setup the XML headers
    $xml_output = FALSE;
    $xml_header = FALSE;
    $xml_resource_output = FALSE;
    $xml_content_output = FALSE;
    
    $xml_header .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $xml_header .= '<feed xmlns="http://www.w3.org/2005/Atom" xmlns:georss="http://www.georss.org/georss" xmlns:gml="http://www.opengis.net/gml" xmlns:arch="http://ochre.lib.uchicago.edu/schema/SpatialUnit/SpatialUnit.xsd" xmlns:oc="http://www.opencontext.org/database/schema/space_schema_v1.xsd" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:opensearch="http://a9.com/-/spec/opensearch/1.1/">';
    
    $xml_header .= "<opensearch:totalResults>$total_results</opensearch:totalResults>\n
        <opensearch:startIndex>$current_index</opensearch:startIndex>\n
        <opensearch:itemsPerPage>$perpage</opensearch:itemsPerPage>\n
        <link rel=\"self\" href=\"$current_url&amp;page=$current_page\"/>\n
        <link rel=\"first\" href=\"$current_url&amp;page=1\"/>\n
        <link rel=\"last\" href=\"$current_url&amp;page=$no_of_pages\"/>\n";
    
    if ($previous_page != $current_page) {
        $xml_header .= "<link rel=\"previous\" href=\"$current_url&amp;page=$previous_page\"/>\n";
    }
    
    $xml_header .= "<link rel=\"next\" href=\"$current_url&amp;page=$next_page\"/>\n
        <id>$current_url&amp;page=$current_page</id>\n
        <updated>$date</updated>\n";
    
    $xml_header .= "<title>ARK RSS Feed</title>\n";
    
    // Loop thru the results
    foreach ($export_conf as $res_item) {
        // Get the mod settings for this mod 
        $mod_short = $mod_short = substr($res_item['itemkey'], 0, 3);
        include('config/mod_'.$mod_short.'_settings.php');
        $conf_array = $mod_short . "_export_conf";
        $conf_array = $$conf_array;
        if (array_key_exists('AtomExt',$conf_array)) {
            $cols = resTblTh($conf_array['AtomExt']['export_fields'],'silent');
        }
        $item_link = $webhost . $ark_root_path . "/micro_view.php?itemkey={$res_item['itemkey']}&amp;{$res_item['itemkey']}={$res_item['itemval']}";
        $xml_content_output .= "<entry>\n";
        $xml_content_output .= "<title>{$res_item['itemval']}</title>\n";
        $xml_content_output .= "<link href=\"$item_link\"/>\n";
        $xml_content_output .= "<id>$item_link</id><updated>$date</updated>\n";
        $xml_content_output .= "<content type=\"xhtml\">\n";
        foreach ($cols as $col) {
            //check if this has a geoRSS tag
            if(array_key_exists('op_tag_AtomExt',$col)){
                $tag = $col['op_tag_AtomExt'];
                //the author tag is a special one - it needs to be applied outside the content
                if ($tag == 'author') {
                    $td_val = resTblTd($col, $res_item['itemkey'], $res_item['itemval']);
                    $author = '<author><name>' . $td_val . '</name></author>';
                } else {
                    // make the val
                    $td_val = resTblTd($col, $res_item['itemkey'], $res_item['itemval']);
                    $xml_content_output .= "<$tag>$td_val</$tag>\n";
                }
           }
        }
        $xml_content_output .= "</content>";
        if ($author) {
            $xml_content_output .= $author;
        }
        $xml_content_output .= "</entry>\n";
    }
    
    //clean up
    $xml_content_output .= "</feed>";
    $xml_output = $xml_header . $xml_resource_output . $xml_content_output;
    header("Content-Type: application/atom+xml; charset=UTF-8");
    echo $xml_output;
    exit;
}

// }}}
// {{{ exportQgisFilter()

/**
 * returns an XML file containing the xml output of the fields passed from data_view using the Atom schema
 *
 * @param array $export_conf  the array of export options (or a fully-formed results_array)
 * @return array $errors  if there are any errors an array is returned
 * @author Stuart Eve
 * @since 0.7
 *
 *
 */
function exportQgisFilter($results_array, $sf_conf){
	$var = "<div id=\"QgisFilter\" >";
	$count=0;
	foreach ($results_array as $key => $item) {
	    $itemkey = $item['itemkey'];
	    $itemval = $item['itemval'];
	    $var .= " $itemkey = \"$itemval\"";
	    if($count<count($results_array)){
	    	$var .= "OR";
	    	$count +=1 ;
	    }
	}
	$var .="</div>";
	$var .="<script type=\"text/javascript\">
		$(document).ready(function(){
			function SelectText(element) {
                var doc = document,
                text = doc.getElementById(element),
                range, selection;
                console.log(text);
                if (doc.body.createTextRange) {
                    range = document.body.createTextRange();
                    range.moveToElementText(text);
                    range.select();
                } else if (window.getSelection) {
                    selection = window.getSelection();        
                    range = document.createRange();
                    range.selectNodeContents(text);
                    selection.removeAllRanges();
                    selection.addRange(range);
                }
            }
			
			SelectText('QgisFilter');
			$('QgisFilter').hide();
			
			});
			</script>";
	return $var;
}
?>
