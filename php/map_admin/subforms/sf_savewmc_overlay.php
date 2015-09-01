<?
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* 
*
* update_savewmc_overlay.php
*
* this script updates the saved WMC document
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with
*    archaeological data
*    Copyright (C) 2007  L - P : Partnership Ltd.
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
* @category   base
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2007 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/update_savewmc_overlay.php
* @since      File available since Release 0.6
*/

// INCLUDES

$legend_array = reqArkVar('legend_array');
//now we have to go through the legend array and sort out what layers are on and which are off
$layer_status = reqQst($_REQUEST,'layers');
$layer_status = explode('|',$layer_status);
foreach ($layer_status as $key => $value) {
    $layer = explode(':',$value);
    if (array_key_exists(0,$layer) && array_key_exists(1,$layer)) {
        $layer_status_array[$layer[0]] = $layer[1];
    }
}

if (!is_array($legend_array)) {
    $legend_array = unserialize($legend_array);
}

foreach ($legend_array['servers'] as $key => $value) {
    foreach ($value['layers'] as $layer_key => $layer_value) {
        if (array_key_exists('sub_layers',$layer_value)) {
            foreach ($layer_value['sub_layers'] as $sublayer_key => $sublayer_value) {
                if (array_key_exists($sublayer_value['title'],$layer_status_array)) {
                   $legend_array['servers'][$key]['layers'][$layer_key]['sub_layers'][$sublayer_key]['status'] = $layer_status_array[$sublayer_value['title']];
                }
            }
        } else {
            if (array_key_exists($layer_value['title'],$layer_status_array)) {
                    $legend_array['servers'][$key]['layers'][$layer_key]['status'] = $layer_status_array[$layer_value['title']];
            }
        }
    }
}

$legend_array = serialize($legend_array);

//REQUESTS
$wmc = reqQst($_REQUEST,'wmc');
$user_id = reqQst($_REQUEST,'user_id');
$name = reqQst($_REQUEST,'map_name');
$comments = reqQst($_REQUEST,'map_comments');
$public = reqQst($_REQUEST,'map_public');
$lboxreload= reqQst($_REQUEST,'lboxreload');
if (!$public) {
    $public = 0;
}
$scales = reqQst($_REQUEST,'scales');
$extents = reqQst($_REQUEST,'extents');
$projection = reqQst($_REQUEST,'projection');
$OSM = reqQst($_REQUEST,'OSM');
$gmap_api_key = reqQst($_REQUEST,'gmap_api_key');
$zoom = reqQst($_REQUEST,'zoom');
$mk_savesuccessful = getMarkup('cor_tbl_markup', $lang, 'savesuccessful');
$mk_saveproblem = getMarkup('cor_tbl_markup', $lang, 'saveproblem');

if ($OSM != 1) {
    $OSM = 0;
}
if (!isset($gmap_api_key)) {
    $gmap_api_key = '';
}

$comments = mysql_real_escape_string($comments);
if (get_magic_quotes_gpc()) {
    echo "ADMIN ERROR - Magic Quotes are on... that's not very secure";
    $comments = stripslashes($comments);
}
$cre_on = "NOW()";

if ($cre_on == "NOW()") {
    $cre_on = gmdate("Y-m-d H:i:s", time());
}

$sql = "
    INSERT INTO cor_tbl_wmc (name, comments, wmc,scales, extents, projection, zoom, legend_array, OSM, gmap_api_key,public, cre_by, cre_on)
    VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?)
";
$params = array($name, $comments, $wmc, $scales, $extents,$projection, $zoom, $legend_array, $OSM, $gmap_api_key, $public, $user_id, $cre_on);
//For debug
   
$sql = dbPrepareQuery($sql,__FUNCTION__);
// Log vars
if ($log == 'on') {
   $logvars = 'The sql: '. json_encode($sql);
   $logtype = 'addatr';
}
// Run the query
$sql = dbExecuteQuery($sql,$params,__FUNCTION__);
// Handle the results
$new_id = $db->lastInsertId();
   
if ($new_id) {
    $results[] =
        array(
            'new_id' => $new_id,
            'success' => TRUE,
            'sql' => $sql
    );
}else {
    $results[] =
        array(
            'new_id' => FALSE,
            'success' => FALSE,
            'failed_sql' => $sql
    );
}

if ($results[0]['success'] == TRUE) {
    $update_success = TRUE;
    $message = $mk_savesuccessful;
    $_SESSION['legend_array'] = unserialize($legend_array);
} else {
    $update_success = FALSE;
    $message = $mk_saveproblem;
}



?>
