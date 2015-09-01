<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* map/getwmcmap.php
*
* gets a WMC map either from one already saved in the session or runs the script to create a whole new one
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
* @category   map
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/map/getwmcmap.php
* @since      File available since Release 0.6
*/

//Get a map and create the $map object
//This can either be:
//the current mapfile (held in session)
//A specified mapfile to restart from
//A new map built from the database
//Or failing that a fallback default map (built from database as specified in global settings)

$temp_map = reqQst($_SESSION,'map_temp_map');
//DEV NOTE: Does this need to grabbed somewhere further up??
$restart = reqQst($_REQUEST,'map_restart');

//Now check if we want to restart the map directly from a saved WMC map (for instance a saved user map) or build one from the database

if ($restart) {
    if (is_numeric($restart)) {
        //we can assume that we want to recreate a map from the db and restart is the numerical value for the WMC map in cor_tbl_wmc
        $maptype = $restart;
        $_SESSION['map_temp_map'] = $maptype;     
    }

} else {
    $maptype = $temp_map;
}

if ($maptype) {
    //now retrieve the map
    $sql = "
    SELECT *
    FROM cor_tbl_wmc
    WHERE id = ?
    ";
    $params = array($maptype);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);

    //Make the row available to rest of script
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $wmc = $row;
    }
    
} else {
    $maptype = FALSE;
}

?>
