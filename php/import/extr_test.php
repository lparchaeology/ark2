<?php 
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* import/extr_test.php
*
* sets up the main interface for running import extraction tests and provides the
* functionality to run dry runs or live additions.
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
* @category   import
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/import/extr_test.php
* @since      File available since Release 0.6
*/

$cmap_id = reqArkVar('cmap_id');
$outcome = FALSE;
$err_array = array();
$res_array = array();
$cmap_info = array();

// GET INFO ABOUT THIS CMAP
$cmap_details = getRow('cor_tbl_cmap', $cmap_id, FALSE);

// GET A USER OVER RIDE FOR THE TYPE
$oridetype = reqQst($_REQUEST, 'oridetype');

?>

<div id="cmap_nav">
<?php
$enable_select = 'true';
include('php/import/inc_cmap_nav.php');
?>
</div>

<?php

printf ("<p>The column headers match the vars required by the edt function.</p>");
// This sets up the test to run
$routine = reqQst($_REQUEST, 'routine');
$chain = reqQst($_REQUEST, 'chain');
// ON THE FLY TESTING
if ($routine == 'cmap') {
    $cmap = $cmap_details['id'];
    $row = reqQst($_REQUEST, 'row');
    $hotrow = $row;
}

// MANUAL TESTS
if ($routine == 'cxtkey') {
    // Should come from cor_tbl_cmap_structure (the row for this field)
    $table = 'tbl_context';
    // $uid_col is the col that contains the unique ids OF THIS TABLE (primary key)
    $uid_col = 'context_id_unique, context_type_id'; 
    $source_col = 'context_id';
    $itemkey = 'cxt_cd';
    $log = 'on'; /*sets whether to log the update of this field */
    $type = 'dry_run';
    $cre_by = 1;
    $cre_on = 'NOW()';
    $data_class = 'cxtkey';
    $lang = $lang;
    $cmap = 1;
}

// RUN THE TEST

// GET THE CMAP STUFF
if (isset($cmap) && isset($row)) {
    // Stuff from CMAP
    $cmap_info = getRow('cor_tbl_cmap',$cmap);
    // check for a user override
    if ($oridetype) {
        $cmap_info['type'] = $oridetype;
    }
    // Stuff from CMAP_STRUCTURE
    $cmap_struc_info = getRow('cor_tbl_cmap_structure', $row);
}

if (isset($cmap) && isset($cmap_struc_info)) {
    // GET THE DATA
    // select the right source
    $source_db = getCmapDB($cmap);
    $db = dbConnect($sql_server, $sql_user, $sql_pwd, $source_db);
    // set up the sql
    $sql = "
        SELECT {$cmap_struc_info['uid_col']}
        FROM {$cmap_struc_info['tbl']}
    ";
    $params = array();
    // run the query
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
}

// SET UP STANDARD HEADERS FOR EACH CLASS

// UNIVERSAL form bits
if (isset($cmap_struc_info) && isset($cmap_info)) {
    // get some vars for the edit link
    // itemval joins
    if ($cmap_struc_info['raw_itemval_tbl'] && $cmap_struc_info['raw_itemval_tbl'] != 'FALSE') {
        $join = 'join';
    } else {
        $join = 'nojoin';
    }
    // ste_cd joins
    if ($cmap_struc_info['raw_stecd_col'] && $cmap_struc_info['raw_stecd_col'] != 'FALSE') {
        if ($cmap_struc_info['raw_stecd_tbl'] && $cmap_struc_info['raw_stecd_tbl'] != 'FALSE') {
            $ste_join = 'nojoin';
        } else {
            $ste_join = 'join';
        }
    } else {
        $ste_join = 'fixed';
    }
    if ($chain == 1) {
        echo ("<h5> This {$cmap_struc_info['class']} will be the first link in a chain - please ensure you have the following fields in your IMPORT database - a VARCHAR(255) field called '{$cmap_struc_info['col']}_itemkey' and a INT field called '{$cmap_struc_info['col']}_itemval'</h5>");
        $cmap_struc_info['chain'] = 1;
    }
    $univ_hdr = "<h5>table.column: {$cmap_struc_info['tbl']}.{$cmap_struc_info['col']} <a href=\"{$_SERVER['PHP_SELF']}?view=edtcmapstr&amp;table={$cmap_struc_info['tbl']}&amp;field={$cmap_struc_info['col']}&amp;ste_join=$ste_join&amp;join=$join&amp;import_class={$cmap_struc_info['class']}\"><img src=\"$skin_path/images/plusminus/edit.png\" class=\"sml\" alt=\"[ed]\"/></a></h5>\n";
}

// CLASS DEPENDENT
if (isset($cmap_struc_info) && isset($cmap_info)) {
    // KEY
    if ($cmap_struc_info['class'] == 'key' && $cmap_info['type'] == 'dry_run') {
        // intro
        $header = $univ_hdr;
        $header .= "<p>This is how \"{$cmap_struc_info['tbl']}.{$cmap_struc_info['col']}\" ";
        $header .= "would be formatted for insertion into Ark. These are keys of modules </p>\n";
        // the table
        $header .= "<table border=\"1\" class=\"importtest\">\n";
        $header .= "<tr>";
        $header .= "<td>#</td>";
        $header .= "<td>mod short</td>";
        $header .= "<td>{$cmap_struc_info['itemkey']}</td>";
        $header .= "<td>number</td>";
        $header .= "<td>ste_cd</td>";
        $header .= "<td>cre_by</td>";
        $header .= "<td>cre_on</td>";
        $header .= "<td>type</td>";
        $header .= "<td>log</td>";
        $header .= "</tr>\n";
        echo "$header";
    }
    // MODKEY
    if ($cmap_struc_info['class'] == 'modkey' && $cmap_info['type'] == 'dry_run') {
        // intro
        $header = $univ_hdr;
        $header .= "<p>This is how \"{$cmap_struc_info['tbl']}.{$cmap_struc_info['col']}\" ";
        $header .= "would be formatted for insertion into Ark. These are item keys of a module that is using modtypes. NOTE: the modtype data will NOT be inserted by this import action. You must configure the relevant field in your source data for import as the modtype.</p>\n";
        // the table
        $header .= "<table border=\"1\" class=\"importtest\">\n";
        $header .= "<tr>";
        $header .= "<td>#</td>";
        $header .= "<td>mod short</td>";
        $header .= "<td>{$cmap_struc_info['itemkey']}</td>";
        $header .= "<td>number</td>";
        $header .= "<td>ste_cd</td>";
        $header .= "<td>cre_by</td>";
        $header .= "<td>cre_on</td>";
        $header .= "<td>type</td>";
        $header .= "<td>log</td>";
        $header .= "</tr>\n";
        echo "$header";
    }
    // SPAN
    if ($cmap_struc_info['class'] == 'span' && $cmap_info['type'] == 'dry_run') {
        // intro
        $header = $univ_hdr;
        $header .= "<p>This is how \"{$cmap_struc_info['tbl']}.{$cmap_struc_info['col']}\" ";
        $header .= "would be formatted for insertion as spans into Ark.</p>\n";
        $header .= "<p>Note that you must have manually set up the span type (spantype) for this";
        $header .= "type of span</p>";
        $header .= "<p>Spans rely on having raw data in both the beginning field and end field. ";
        $header .= "This data must be pre-processed as it will be entered into ark AS IS</p>";
        $header .= "<p>Only add a mapping for the 'beginning' of spans. In this mapping the column";
        $header .= " containing the 'end' data is specified as 'end_source_col'. Do not map 'ends' as ";
        $header .= "this will duplicate entry</p>";
        // table
        $header .= "<table border=\"1\" class=\"importtest\">\n";
        $header .= "<tr>";
        $header .= "<td>#</td>";
        $header .= "<td>spantype</td>";
        $header .= "<td>itemkey</td>";
        $header .= "<td>itemvalue</td>";
        $header .= "<td>beg</td>";
        $header .= "<td>end</td>";
        $header .= "<td>cre_by</td>";
        $header .= "<td>cre_on</td>";
        $header .= "<td>type</td>";
        $header .= "<td>log</td>";
        $header .= "</tr>\n";
        print($header);
    }
    // ATTRA
    if ($cmap_struc_info['class'] == 'attra' && $cmap_info['type'] == 'dry_run') {
        // intro
        $header = $univ_hdr;
        $header .= "<p>This is how \"{$cmap_struc_info['tbl']}.{$cmap_struc_info['col']}\" ";
        $header .= "would be formatted for insertion into Ark. These are attributes (known as";
        $header .= "type A (boolean) for import purposes) </p>\n";
        $header .= "<p>Note that you must have previously set up the attribute itself</p>";
        // the table
        $header .= "<table border=\"1\"class=\"importtest\">\n";
        $header .= "<tr>";
        $header .= "<td>#</td>";
        $header .= "<td>attribute</td>";
        $header .= "<td>itemkey</td>";
        $header .= "<td>itemvalue</td>";
        $header .= "<td>cre_by</td>";
        $header .= "<td>cre_on</td>";
        $header .= "<td>type</td>";
        $header .= "<td>log</td>";
        $header .= "<td>bool</td>";
        $header .= "</tr>\n";
        echo "$header";
    }
    // ATTRB
    if ($cmap_struc_info['class'] == 'attrb' && $cmap_info['type'] == 'dry_run') {
        // intro
        $header = $univ_hdr;
        $header .= "<p>This is how \"{$cmap_struc_info['tbl']}.{$cmap_struc_info['col']}\" ";
        $header .= "would be formatted for insertion into Ark. These are attributes (known as";
        $header .= "type B for import purposes) </p>\n";
        $header .= "<p>Note that you must have manually set up the attribute type for this";
        $header .= "attribute</p>";
        // the table
        $header .= "<table border=\"1\" class=\"importtest\">\n";
        $header .= "<tr>";
        $header .= "<td>#</td>";
        $header .= "<td>attribute</td>";
        $header .= "<td>itemkey</td>";
        $header .= "<td>itemvalue</td>";
        $header .= "<td>cre_by</td>";
        $header .= "<td>cre_on</td>";
        $header .= "<td>type</td>";
        $header .= "<td>log</td>";
        $header .= "<td>bool</td>";
        $header .= "</tr>\n";
        echo "$header";
    }
    // DATe
    if ($cmap_struc_info['class'] == 'date' AND $cmap_info['type'] == 'dry_run') {
        // intro
        $header = $univ_hdr;
        $header .= "<p>This is how \"{$cmap_struc_info['tbl']}.{$cmap_struc_info['col']}\" ";
        $header .= "would be formatted for insertion as dates into Ark.</p>\n";
        $header .= "<p>Note that you must have manually set up the date type (datetype) for this";
        $header .= "type of date</p>";
        // table
        $header .= "<table border=\"1\" class=\"importtest\">\n";
        $header .= "<tr>";
        $header .= "<td>#</td>";
        $header .= "<td>datetype</td>";
        $header .= "<td>itemkey</td>";
        $header .= "<td>itemvalue</td>";
        $header .= "<td>date</td>";
        $header .= "<td>cre_by</td>";
        $header .= "<td>cre_on</td>";
        $header .= "<td>type</td>";
        $header .= "<td>log</td>";
        $header .= "</tr>\n";
        echo "$header";
    }
    // TXT
    if ($cmap_struc_info['class'] == 'txt' AND $cmap_info['type'] == 'dry_run') {
        // intro
        $header = $univ_hdr;
        $header .= "<p>This is how \"{$cmap_struc_info['tbl']}.{$cmap_struc_info['col']}\" ";
        $header .= "would be formatted for insertion as text into Ark.</p>\n";
        $header .= "<p>Note that you must have manually set up the text type (txttype) for this";
        $header .= "type of text</p>";
        // table
        $header .= "<table border=\"1\" class=\"importtest\">\n";
        $header .= "<tr>";
        $header .= "<td>#</td>";
        $header .= "<td>txttype</td>";
        $header .= "<td>itemkey</td>";
        $header .= "<td>itemvalue</td>";
        $header .= "<td>txt</td>";
        $header .= "<td>lang</td>";
        $header .= "<td>cre_by</td>";
        $header .= "<td>cre_on</td>";
        $header .= "<td>type</td>";
        $header .= "<td>log</td>";
        $header .= "</tr>\n";
        echo "$header";
    }
    // NUM
    if ($cmap_struc_info['class'] == 'num' AND $cmap_info['type'] == 'dry_run') {
        // intro
        $header = $univ_hdr;
        $header .= "<p>This is how \"{$cmap_struc_info['tbl']}.{$cmap_struc_info['col']}\" ";
        $header .= "would be formatted for insertion as numbers into Ark.</p>\n";
        $header .= "<p>Note that you must have manually set up the number type (numbertype) for this";
        $header .= "type of number</p>";
        // table
        $header .= "<table border=\"1\" class=\"importtest\">\n";
        $header .= "<tr>";
        $header .= "<td>#</td>";
        $header .= "<td>numtype</td>";
        $header .= "<td>itemkey</td>";
        $header .= "<td>itemvalue</td>";
        $header .= "<td>num</td>";
        $header .= "<td>cre_by</td>";
        $header .= "<td>cre_on</td>";
        $header .= "<td>type</td>";
        $header .= "<td>log</td>";
        $header .= "</tr>\n";
        echo "$header";
    }
    // XMI
    if ($cmap_struc_info['class'] == 'xmi' && $cmap_info['type'] == 'dry_run') {
        // intro
        $header = $univ_hdr;
        $header .= "<p>This is how \"{$cmap_struc_info['tbl']}.{$cmap_struc_info['col']}\" ";
        $header .= "would be formatted for insertion into ARK table cor_tbl_xmi. ";
        $header .= "This holds relationships between itemkeys of different modules.</p>\n";
        // table
        $header .= "<table border=\"1\" class=\"importtest\">\n";
        $header .= "<tr>";
        $header .= "<td>#</td>";
        $header .= "<td>itemkey</td>";
        $header .= "<td>itemvalue</td>";
        $header .= "<td>xmi_itemkey</td>";
        $header .= "<td>list to lnk</td>";
        $header .= "<td>imp_ste_cd</td>";
        $header .= "<td>cre_by</td>";
        $header .= "<td>cre_on</td>";
        $header .= "<td>type</td>";
        $header .= "<td>log</td>";
        $header .= "</tr>\n";
        print($header);
    }
    // ACTION-XMI
    if ($cmap_struc_info['class'] == 'action' AND $cmap_info['type'] == 'dry_run') {
        // intro
        $header = "<p>This is how {$cmap_struc_info['tbl']}.{$cmap_struc_info['col']}";
        $header .= "would be formatted for insertion into Ark table cor_tbl_action which";
        $header .= " holds actions. Actions link actors and the actions they do to items. </p>\n";
        $header .= "<p>CMAP: {$cmap_details['nname']}</p>";
        // table
        $header .= "<table border=\"1\" class=\"importtest\">\n";
        $header .= "<tr>";
        $header .= "<td>#</td>";
        $header .= "<td>actiontype</td>";
        $header .= "<td>itemkey</td>";
        $header .= "<td>itemval</td>";
        $header .= "<td>actorkey</td>";
        $header .= "<td>actorvalue</td>";
        $header .= "<td>cre_by</td>";
        $header .= "<td>cre_on</td>";
        $header .= "<td>type</td>";
        $header .= "<td>log</td>";
        $header .= "</tr>\n";
        printf($header);
    }
}
// Set a counter
$i = 1;
// LOOP THROUGH THE SOURCE DATA

if (isset($sql) && $row = $sql->fetch(PDO::FETCH_ASSOC)) {
    do {
        // Get the unique row identifier
        $col_uid_temp = $cmap_struc_info['uid_col'];
        $uid = $row[$col_uid_temp];
        unset($col_uid_temp);
        // SELECT WHICH FUNC TO RUN
        // Key using modtypes
        if ($cmap_struc_info['class'] == 'modkey') {
            $outcome = extrKey($cmap, $uid, $cmap_struc_info, $cmap_info);
        }
        // Key (all other mods)
        if ($cmap_struc_info['class'] == 'key') {
            $outcome = extrKey($cmap, $uid, $cmap_struc_info, $cmap_info);
        }
        // Txt
        if ($cmap_struc_info['class'] == 'txt') {
            $outcome = extrTxt($cmap, $uid, $cmap_struc_info, $cmap_info);
        }
        // Dates
        if ($cmap_struc_info['class'] == 'date') {
            $outcome = extrDate($cmap, $uid, $cmap_struc_info, $cmap_info);
        }
        // Numbers
        if ($cmap_struc_info['class'] == 'num') {
            $outcome = extrNum($cmap, $uid, $cmap_struc_info, $cmap_info);
        }
        // Attr
        if ($cmap_struc_info['class'] == 'attra') {
            $outcome = extrAttrA($cmap, $uid, $cmap_struc_info, $cmap_info);
        }
        if ($cmap_struc_info['class'] == 'attrb') {
            $outcome = extrAttrB($cmap, $uid, $cmap_struc_info, $cmap_info);
        }
        // Spans
        if ($cmap_struc_info['class'] == 'span') {
            $outcome = extrSpan($cmap, $uid, $cmap_struc_info, $cmap_info);
        }
        // XMIs
        if ($cmap_struc_info['class'] == 'xmi') {
            $outcome = extrXmi($cmap, $uid, $cmap_struc_info, $cmap_info);
        }
        // Aliases
        if ($cmap_struc_info['class'] == 'alias') {
            $outcome = extrFrAli($cmap, $uid, $cmap_struc_info, $cmap_info);
        }
        // Actors
        if ($cmap_struc_info['class'] == 'action') {
            $outcome = extrAction($cmap, $uid, $cmap_struc_info, $cmap_info);
        }
        
        // return some feedback
        if (!$outcome) {
            $msg = "{$cmap_struc_info['tbl']}.{$cmap_struc_info['col']} ";
            $msg.= "row: $uid NOT Imported (probably NULL in source)";
            $err_array[] = $msg;
            unset($msg);
        } else {
            $res_array[] = $outcome;
        }
    } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
} else {
    //probably there is no cmap strucutre info setup
    printf("<p>It looks like you have no setup any CMAP Structure Info - so there is nothing to test!</p>\n");
}

if (array_key_exists('type', $cmap_info)) {
    //end the add routines neatly
    if ($cmap_info['type'] == 'add' && $cmap_struc_info['class'] != 'alias') {
        $rows = count($res_array);
        $last = end($res_array);
        $start = reset($res_array);
        $errs = count($err_array);
        $tot_rows = $rows+$errs;
        $msg = "<p>$tot_rows rows have been attempted from";
        $msg .= " {$cmap_struc_info['tbl']}.{$cmap_struc_info['col']}";
        $msg .= " of the cmap: {$cmap_details['nname']}</p>\n";
        $msg .= "<p>Number of rows successfuly inserted: $rows</p>\n";
        $msg .= "<p>First row id: $start</p>\n";
        $msg .= "<p>Last row id: $last</p>\n";
        print($msg);
        if ($errs > 0) {
            printf("<p>Number of non-imported rows: $errs</p>\n");
            foreach ($err_array as $err) {
                printf("<p>$err</p>\n");
            }
        }
    }
    
    //end the dry runs neatly
    if ($cmap_info['type'] == 'dry_run') {
        printf("</table>\n");
        printf("<p>In order to now insert this data please click the button below</p>\n");
        $href = "{$_SERVER['PHP_SELF']}?view=extr_test&amp;routine=cmap&amp;row=$hotrow&amp;oridetype=add&amp;chain=$chain";
        printf("<p><a href=\"$href\" class=\"delete\">RUN LIVE ADD</a></p>\n");
    }
}

if ($error) {
    feedBk('error');
}
if ($message) {
    feedBk('message');
}
$db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);

?>
