<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* map_view/choose_map.php
*
* the panel for choosing which maps to view
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
* @link       http://ark.lparchaeology.com/svn/php/map_view/choose_map.php
* @since      File available since Release 0.6
*/

//first check if we need to delete any maps
$mk_map_choose= getMarkup('cor_tbl_markup', $lang, 'map_choose_title');
$var = "<div id=\"message\"><p>$mk_map_choose</p></div>\n";
$map_delete = reqQst($_REQUEST,'map_delete');

if ($map_delete) {
    if (is_numeric($map_delete)) {
        $mk_delete_successful = getMarkup('cor_tbl_markup', $lang, 'delete_successful');
        $sql = "
           DELETE
           FROM cor_tbl_wmc
           WHERE
           id = $map_delete
           ";
        $params = array($map_delete);
        $sql = dbPrepareQuery($sql,__FUNCTION__);
        $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
        $rows = $sql->rowCount();
        if ($rows == 1) {
            $results['success'] = TRUE;
            $results['rows'] = $rows;
        }else {
            $results['success'] = FALSE;
        }
        if ($results['success'] == TRUE) {
            $var .= "<div id=\"message\" class=\"message\">$mk_delete_successful</div>";
        }      
    }
}



//get the markup needed
$mk_map_preconf = getMarkup('cor_tbl_markup', $lang, 'map_preconf');
$mk_map_creby = getMarkup('cor_tbl_markup', $lang, 'map_creby');
$mk_map_savedmaps = getMarkup('cor_tbl_markup', $lang, 'map_savedmaps');
$mk_delete = getMarkup('cor_tbl_markup', $lang, 'delete');

//first grab the maps that are public
$var .= "<h2>$mk_map_preconf</h2>";
$var .= "<dl>";
// make the sql
   $sql = "
   SELECT *
   FROM cor_tbl_wmc
   WHERE
   public = 1
   ";
   $params = array();
   $sql = dbPrepareQuery($sql,__FUNCTION__);
   $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
   // run the query
   if ($preconf_row = $sql->fetch(PDO::FETCH_ASSOC)) {
       do {
           $creator = getUserAttr($preconf_row['cre_by'],'full');
           $var .= "<dt><a href=\"{$_SERVER['PHP_SELF']}?map_restart={$preconf_row['id']}\">{$preconf_row['name']}</a></dt>";
           $var .= "<dd>$mk_map_creby $creator on {$preconf_row['cre_on']} | {$preconf_row['comments']}</dd>"; 
       } while($preconf_row = $sql->fetch(PDO::FETCH_ASSOC));
   }
$var .= "</dl>";

//now grab the maps that the user has saved

//first grab the maps that are public
$var .= "<h2>$mk_map_savedmaps</h2>";
$var .= "<dl>";
// make the sql
   $sql = "
   SELECT *
   FROM cor_tbl_wmc
   WHERE
   cre_by = ?
   ";
   $params = array($user_id);
   // run the query
   $sql = dbPrepareQuery($sql,__FUNCTION__);
   $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
   if ($preconf_row = $sql->fetch(PDO::FETCH_ASSOC)) {
       do {
           $creator = getUserAttr($preconf_row['cre_by'],'full');
           $var .= "<dt><a href=\"{$_SERVER['PHP_SELF']}?map_restart={$preconf_row['id']}\">{$preconf_row['name']}</a></dt>";
           $var .= "<dd>$mk_map_creby $creator on {$preconf_row['cre_on']} | {$preconf_row['comments']}
                    <a class=\"delete\" href=\"{$_SERVER['PHP_SELF']}?map_action=choose_map&amp;map_delete={$preconf_row['id']}\">$mk_delete</a>
           </dd>"; 
       } while($preconf_row = $sql->fetch(PDO::FETCH_ASSOC));
   }
$var .= "</dl>";
print $var;
?>
