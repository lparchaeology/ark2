<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* import/left_panel.php
*
* sets up left panel for the import tools
*
* PHP versions 1 and 5
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
* @link       http://ark.lparchaeology.com/svn/php/import/left_panel.php
* @since      File available since Release 0.6
*/


// setup the ajax URL for the processing
$mk_jsonresult = getMarkup('cor_tbl_markup', $lang, 'jsonresult');
$jsondata = reqQst($_POST, "data");
$dataclass = reqQst($_POST, "dataclass");
$fieldname = reqQst($_POST, "field");
$itemkey = reqQst($_POST, "itemkey");
$importmodtype = reqQst($_POST, "modtype");

$modcd = explode("_",$itemkey);
$mod = $modcd[0];
$field = $$fieldname;
$data = json_decode($jsondata,true);
array_shift($data);
global $user_id;
$cre_by = $user_id;
$cre_on = gmdate("Y-m-d H:i:s", time());
$resulttable=array();

foreach ($data as $itemvalue => $value){
    
    if (is_array($value)){
        continue;
    }

    $table = $mod."_tbl_".$mod;
    $valid = chkValid($itemvalue,FALSE,FALSE,$table,$mod."_cd");
    if ($valid){
        addItemKey($mod."_cd", $itemvalue, $cre_by, $cre_on, $importmodtype);
        $message['id'] = "created new item ".$itemvalue;
    } else {
        $message['id'] = $itemvalue." already exists, adding to it";
    }
    // for attributes resolve the text into an attribute id
    switch($dataclass) {
        case 'action' :
            $actorkey = $field['actors_mod'] . "_cd";
            $classtypeid = getClassType($dataclass, $field['classtype']);
            $actorclasstypeid = getClassType($field['actors_elementclass'], $field['actors_element']);
            $where = "`itemkey` = \"" . $actorkey . "\"";
            $where .= " AND `" . $field['actors_elementclass'] . "` = \"" . $value . "\"";
            $where .= " AND `" . $field['actors_elementclass'] . "type` = " . $actorclasstypeid . "";
            $actorvalue = getSingle('itemvalue', "cor_tbl_" . $field['actors_elementclass'], $where);
            $return = addAction($classtypeid, $itemkey, $itemvalue, $actorkey, $actorvalue, $cre_by, $cre_on);
            if ($return['success'] == 1) {
                $message['added'] = "$value ($actorvalue) added";
            } else {
                $message['added'] = "Error on $value ($actorvalue)";
            }
            break;
        case 'attribute' :
            // get the classtype id s
            $classtypeid = getClassType($dataclass, $field['classtype']);
            // try to get an id for an existing attribute of this classtype
            $attrid = getLutIdFromData("cor_lut_" . $dataclass, $lang, "AND cor_tbl_alias.alias = '$value' AND cor_lut_" . $dataclass.".attributetype=".$classtypeid);
            // if there isn't on, we need to add it
            if (!$attrid) {
                // create a new entry in the lut table
                $attrid = edtLut($db, "cor_lut_" . $dataclass, $value, $mod_short, $classtypeid, $lang, $user_id, "NOW()");
            }
            // test it again
            if (!$attrid) {
                // no id, set up a filler string, and register an error
                $attrid = "noid";
                $error_message .= "No id found or created for attribute $value<br>";
            }
            $return = addAttr($attrid, $itemkey, $itemvalue, $cre_by, $cre_on, '1');
            if ($return[0]['success'] == 1) {
                $message['added'] = $value . " added";
            }
            break;
        case 'date' :
            $classtypeid = getClassType($dataclass, $field['classtype']);
            $return = addDate($classtypeid, $itemkey, $itemvalue, $value, $cre_by, $cre_on);
            if ($return['success'] == 1) {
                $message['added'] = "$value added";
            } else {
                $message['added'] = "Error on $value";
            }
            break;
        case 'number' :
            if (!is_numeric($field['classtype'])) {
                $numtype = getClassType('number', $field['classtype']);
            } else {
                $numtype = $field['classtype'];
            }
            $return = addNumber($numtype, $itemkey, $itemvalue, $value, $cre_by, $cre_on);
            if ($return['success'] == 1) {
                $message['added'] = $value . " added";
            } else {
                $message['added'] = 'failed on:' . $return['failed_sql'];
            }
            break;
        case 'txt' :
            $txttype = getClassType('txt', $field['classtype']);
            $return = addTxt($txttype, $itemkey, $itemvalue, $value, $lang, $cre_by, $cre_on);
            if ($return[0]['success'] == 1) {
                $message['added'] = $value . " added";
            }
            break;
        case 'xmi' :
            $xmi_itemkey = reqQst($field, 'force_var_itemkey');
            $return = addXmi($itemkey, $itemvalue, $xmi_itemkey, $value, $ste_cd, $cre_by, $cre_on);
            if ($return[0]['success'] == 1) {
                $message['added'] = $value . " added";
            }
            break;
        default :
            $error['success'] = FALSE;
            $error['vars'] = getMarkup('cor_tbl_markup', $lang, 'dataclassnotsupported');
    }
    
    $resulttable[$itemvalue] = $message;
}

// This is just going to pass the file by POST to the update_mediabrowserscript
// using the options built above
echo '<div id="main" class="media_browser">
        <div class = "mc_subform">
        <h1>JSON Import result</h1>
        <p>'.$mk_jsonresult.'</p>';

print "<table class=\"importtest\">";

foreach($resulttable as $row){
    print "<tr>";
    print "<td>{$row['id']}</td>";
    print "<td>{$row['added']}</td>";
    print "</tr>";
}
print "</table></div></div>";
?>
