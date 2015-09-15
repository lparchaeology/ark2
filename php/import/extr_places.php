<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* import/extr_places.php
*
* extracts places from GIS data
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
* @link       http://ark.lparchaeology.com/svn/php/import/extr_places.php
* @since      File available since Release 0.6
*/
 
//This script is for importing places - these are currently assumed to be 'places' that have some kind of geometry
  //we are presuming that the map object has been set up properly - and are using phpMapScript functions to extract the relevant details and to add them into the database (cor_tbl_places)

include_once('php/map/getmap.php');

$layerObj = $map->getLayerByName('periods');

$layerObj->open();


  //PUT THIS FUNCTION INTO GLOBAL FUNCTIONS

//edtPlace
//    A function to edit Places

//$placetype = id of the placetype 
//$module = the TLC for the module
//$place = the place we are inserting
//$layername = the name of the layer (i.e. map layer) that this place comes from
//$layerid = the id number of the place within the layers 'id' column
//cre_by
//cre_on
//$type = the type of query desired
//$log = the logging switch

function edtPlace($placetype, $module, $place, $layername, $layerid, $cre_by, $cre_on, $type, $log)
{
    global $db;

    $place = mysql_real_escape_string($place);

    if ($type == 'add') {
        $table = 'cor_lut_place';
        $fields = array('place', 'module', 'placetype', 'layername', 'layerid', 'cre_by', 'cre_on');
        $values = array($place, $module, $placetype, $layername, $layerid, $cre_by, $cre_on);
        $logtype = 'txtadd';
        $results = dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
        if ($results['success']) {
            printf("Func: edtPlace<br/>SQL: ".$results['sql']."<br/>");
            return $results['new_id'];
        }
        die("Func: edtPlace<br/>SQL: ".$results['failed_sql']."<br/>");
    }

// if ($type == 'edt') {

// $where = "
// WHERE txttype = $txttype
// AND itemkey = '$itemkey'
// AND itemvalue = '$itemvalue'
// ";

// $sql = "
// UPDATE cor_tbl_txt
// SET txt = '$txt', language = '$lang', cre_by = $cre_by, cre_on = $cre_on
// $where
// ";

// if ($log == 'on') {
// // FIRST GET THE EXISTING DATA SO THAT IT WONT GET LOST
// $logvars = getRow('cor_tbl_txt', FALSE , $where);
// $log_ref = 'cor_tbl_txt';
// $log_refid = $logvars[0];
// $logtype = 'txtedt';
// }

// }

// if ($type == 'del') {

// // Use the txt to carry the del id
// $del_id = $txt;

// $sql = "
// DELETE FROM cor_tbl_txt
// WHERE id = $del_id
// AND itemvalue = '$itemvalue'
// ";

// if ($log == 'on') {
// $logvars = getRow('cor_tbl_txt', $del_id , FALSE);
// settype($logvars['txttype'], "integer");
// $log_ref = array('table', 'itemkey', 'itemvalue', 'type', 'language');
// $log_refid = array('table' => 'cor_tbl_txt', 'itemkey' => $logvars['itemkey'], 'itemvalue' => $logvars['itemvalue'], 'type' => $logvars['txttype']);
// $logtype = 'txtdel';
// }

// }

//For debug
//printf("$sql<br><br><br>");
}


if (!$error) {

  //first we need to request the variables we are trying to import

  //layer
  $layername = reqQst($_REQUEST,'layername');
  //layeridcol
  $layeridcol = reqQst($_REQUEST,'layeridcol');
  //layerattributecol - this is the column in the attribute table that contains the item to be aliased
  $layerattributecol = reqQst($_REQUEST,'layerattributecol');
  //layerattributelang - this is the language that the attribute is in
  $layerattributelang = reqQst($_REQUEST,'layerattributelang');
  //placetype
  $placetype = reqQst($_REQUEST,'placetype');
  //module
  $placemod = reqQst($_REQUEST,'placemod');

  //check we have all these variables

  if($layername && $layeridcol && $layerattributecol && $layerattributelang && $placetype && $placemod){

    //print the header

printf("<p>This is how $layernamewould be formatted for insertion into the Ark table cor_lut_place which holds places</p>");
printf("<table border=\"1\"> <tr><td>id</td><td>place</td><td>module</td><td>placetype</td><td>layername</td><td>layerid</td><td>cre_by</td><td>cre_on</td><td>type</td><td>log</td></tr>");

    //now lets grab the layer

    $layerObj = $map->getLayerByName($layername);

    $map_extent = $map->extent;
    $shape_proj = $layerObj->getProjection();
    $map_proj = $map->getProjection();

    if($map_proj != $shape_proj){

        $map_proj = ms_newprojectionobj("$map_proj");
        $shape_proj = ms_newprojectionobj("$shape_proj");
        $map_extent->project($map_proj,$shape_proj);

    }

$status = $layerObj->whichShapes($map_extent);

    //now we need to run through each shape in the layer and grab the data out to be loaded into the cor_tbl_place

    $status = $layerObj->open();

           while ($shape = $layerObj->nextShape()) {

         $values = $shape->values;

         if($values[$layerattributecol]){

           //set up an array to remove the funny characters (and spaces)
           $remove_this = array(" ","'","-");
           $place = str_replace($remove_this, '', strtolower($values[$layerattributecol])); 
           $place_alias = ucwords(strtolower($values[$layerattributecol]));  

           $place = mysql_real_escape_string($place);
           $place_alias = mysql_real_escape_string($place_alias);

           printf("<tr><td>autonumber</td><td>$place</td><td>$placemod</td><td>$placetype</td><td>$layername</td><td>{$values[$layeridcol]}</td><td>1</td><td>NOW()</td><td>dry_run</td><td>log</td></tr>");

           $place_id = edtPlace($placetype, $placemod, $place, $layername,$values[$layeridcol] ,1,'NOW()', 'add', $log);

           //DEV NOTE: THIS COULD DO WITH BEING CHANGED AS ITS QUITE FASTI-LIKE
           //now check if we need to add the spans
           $spantype = reqQst($_REQUEST,'spantype');
           if($spantype){

               print("<br/>would be adding span: $spantype, 'cor_lut_place', $place_id, {$values['beg']}, {$values['end']}, 1, 'NOW()'<br/>");

               addSpan($spantype, 'cor_lut_place', $place_id, $values['beg'], $values['end'], 1, 'NOW()');
               
           }

           //now set up the alias
            $cre_on = dbTimestamp();
            $table = 'cor_tbl_alias';
            $fields = array('alias', 'aliastype', 'language', 'itemkey', 'itemvalue', 'cre_by', 'cre_on');
            $values = array($place_alias, 1, $layerattributelang, 'cor_lut_place', $place_id, 1, $cre_on);
            $logtype = 'adnali';
            $results = dbRunAddQuery($table, $fields, $values, $logtype, 1, $cre_on, __FUNCTION__);
            printf("Script: import/extr_places.php<br/>SQL: ".$results['sql']."<br/>");

       }//end of if blank

         }//end of while

         $layerObj->close();

         printf("</table>");

   }//end of if all variables
 }//end of if no error

if ($error) {
    feedBk('error');
}
if ($message) {
    feedBk('message');
}



?>
