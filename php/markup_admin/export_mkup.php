<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* markup_admin/export_mkup.php
*
* used to batch export markup
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
* @category   markup_admin
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2011 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/trunk/php/markup_admin/export_mkup.php
* @since      File available since Release 1.0
*/


include('../../config/settings.php');
include('../global_functions.php');
$db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);


$headers = "
    <!DOCTYPE html
         PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
         \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
    <html>
    <head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
    <link rel=\"shortcut icon\" href=\"{$skin_path}/images/ark_favicon.ico\" />
    </head>
    <body>
";

$new_type = 40;
$output = reqArkVar('output', 'raw');

// SQL
$sql = "
    SELECT *
    FROM cor_lut_language
";
$params = array();
// Run the query
$sql = dbPrepareQuery($sql,__FUNCTION__);
$sql = dbExecuteQuery($sql,$params,__FUNCTION__);
// Handle the results
if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    do {
        $langs[] =
            array(
                'lang' => $row['language']
        );
    } while ($row = $sql->fetch(PDO::FETCH_ASSOC));
}

// SQL to get all the items that need changing
// if working on the key table just select all
$sql = "
    SELECT *
    FROM `cor_tbl_markup`
    GROUP BY nname
";
$params = array();
// Run the query
$sql = dbPrepareQuery($sql,__FUNCTION__);
$sql = dbExecuteQuery($sql,$params,__FUNCTION__);
// Handle the results
$count = 0;
$update_count = 0;
if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    // Headers
    if ($output == 'XHTML') {
        echo "$headers";
        echo "<table border=1>\n";
        echo "<tr/>\n";
        echo "<th>nname</th>";
        foreach ($langs as $lang) {
            print("<th>{$lang['lang']}</th>");
        }
        echo "</tr>\n";
    }
    if ($output == 'csv') {
        header ("Content-type: application/csv\nContent-Disposition:
        \"inline; filename=ARK_markup.csv");
        echo "nname,";
        foreach ($langs as $lang) {
            print("{$lang['lang']},");
        }
        echo "\n\n";
    }
    // Body
    do {
        if ($output == 'XHTML') {
            $nname = $row['nname'];
            echo "<tr/>\n";
            echo "<td>$nname</td>";
            foreach ($langs as $lang) {
                $mk_up_row = getRow('cor_tbl_markup', FALSE, "WHERE nname = '$nname' AND language = '{$lang['lang']}'");
                $mk_up = $mk_up_row['markup'];
                if (!$mk_up) {
                    $mk_up = '&nbsp;';
                }
                print("<th>$mk_up</th>");
            }
            echo "</tr>\n";
        }
        if ($output == 'csv') {
            $nname = $row['nname'];
            echo "$nname,";
            foreach ($langs as $lang) {
                $mk_up_row = getRow('cor_tbl_markup', FALSE, "WHERE nname = '$nname' AND language = '{$lang['lang']}'");
                $mk_up = $mk_up_row['markup'];
                if (!$alias) {
                    $alias = '';
                }
                print("$mk_up,");
            }
            echo ";\n";
        }
        if ($output == 'raw') {
            echo "Nname: {$row['nname']}<br/>\n";
            echo "<br/>\n";
        }
        $count++;
    } while ($row=$sql->fetch(PDO::FETCH_ASSOC));
    // Footers
    if ($output == 'XHTML') {
        echo "</table>\n";
    }
    if ($output == 'csv') {
        echo "EoF\n";
    }
}

echo "Number of Markup Entries: $count<br/>\n";

?>
