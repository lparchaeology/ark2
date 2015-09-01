<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* import/right_panel_extr_test.php
*
* right panel for the extraction tests
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
* @link       http://ark.lparchaeology.com/svn/php/import/right_panel_extr_test.php
* @since      File available since Release 0.6
*/

// NOTE: In order for these forms to work, you need to make sure that the data_entry/global_update.php functions are included into your process script.
if ($cmap_details['id']) {
    $sql = "
        SELECT *
        FROM cor_tbl_cmap_structure
        WHERE cmap = ?
        ORDER BY id ASC
    ";
    $params = array($cmap_details['id']);
    // echo "sql: $sql</br>\n";
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
}

// MARKUP
$mk_datatoolbox = getMarkup('cor_tbl_markup', $lang, 'datatoolbox');


// OUTPUT
echo "<div id=\"rpanel\">";
echo "<h1>$mk_datatoolbox</h1>";

// Show mapped fields as list with links
if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    print("<h5>Fields mapped in: {$cmap_details['nname']}</h5>");
    print("<ul>");
    do {
        $href = "{$_SERVER['PHP_SELF']}?view=extr_test&amp;routine=cmap&amp;row={$row['id']}";
        $li = "<li>";
        $li .= "<a href=\"$href\">";
        $li .= "{$row['tbl']}.{$row['col']} - {$row['class']}";
        $li .= "</a>";
        $li .= "</li>\n";
        echo "$li";
    } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
    print("</ul>");
}
?>


</div>
