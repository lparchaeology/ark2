<?php 
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* import/edtcmapdat.php
*
* edits the concordance map data prior to import
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
* @link       http://ark.lparchaeology.com/svn/php/import/edtcmapdat.php
* @since      File available since Release 0.6
*/

?>

<div id="cmap_nav">
<?php
$enable_select = 'true';
include_once('php/import/inc_cmap_nav.php');
?>
</div>

<?php
if (reqArkVar('mlc') != 'php/inc_error.php') {

printf ("<p>Not too sure how to display the map here, could be table by table using the selector on the right.</p>");
printf ("<p>The basic mechanism will be to add mappings to the the current ark values. Thats to say that you would select a current ark value to work with and then apply mappings to it based on data fromt he source db. Each of these would become a target->source pair in a row of the cor_tbl_cmap_data... thoughts please stu...!</p>");

// Connect to the target db and select the rows to loop through

// Should come from the main cmap
$source_db = 'hesm';
$imp_ste_cd = 'NH105';

// This sets up the test to run
$test = 'text';
$test = 'date';

if ($test == 'text') {
// Should come from cor_tbl_cmap_structure (the row for this field)
$table = 'tbl_interpretation';
$uid_col = 'interpretation_id';
$source_col = 'interpretation';
$txttype = 'type_id=manual';
$typemod = 'typemod=manual';
$itemkey = 'itemkey=manual';
$raw_itemval_col = 'context_id';
$log = 'on'; /*sets whether to log the update of this field (optionally could feed it the default)*/
$type = 'dry_run';
$cre_by = 'cre_by=from cmap';
$cre_on = 'cre_on=from cmap';
$data_class = 'text';

// Get yer table headers right
printf("<table border=\"1\"> <tr><td>txttype</td><td>typemod</td><td>itemkey</td><td>itemvalue</td><td>txt</td><td>cre_by</td><td>cre_on</td><td>type</td><td>log</td></tr>");
}
if ($test == 'date') {
// Should come from cor_tbl_cmap_structure (the row for this field)
$table = 'tbl_context';
$uid_col = 'context_id_unique'; /*This is the col that contains the unique ids OF THIS TABLE (primary key)*/
$source_col = 'date_excavated';
$datetype = 'type_id=manual';
$typemod = 'typemod=manual';
$itemkey = 'itemkey=manual';
$raw_itemval_col = 'context_id';
$log = 'on'; /*sets whether to log the update of this field (optionally could feed it the default)*/
$type = 'dry_run';
$cre_by = 'cre_by=from cmap';
$cre_on = 'cre_on=from cmap';
$data_class = 'date';

printf("<table border=\"1\"> <tr><td>datetype</td><td>typemod</td><td>itemkey</td><td>itemvalue</td><td>date</td><td>cre_by</td><td>cre_on</td><td>type</td><td>log</td></tr>");
}

// This is to select out the rows to loop through
$db->query("use $source_db");
$sql = "
SELECT $uid_col
FROM $table
LIMIT 30, 30
";
$params = array();
$sql = dbPrepareQuery($sql,__FUNCTION__);
$sql = dbExecuteQuery($sql,$params,__FUNCTION__);

if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

    do {
        // Get the unique row identifier
        $uid = $row[$uid_col];
        // Text
        if ($data_class == 'text') {
            extrText($db, $txttype, $typemod, $itemkey, $raw_itemval_col, $table, $uid_col, $uid, FALSE, FALSE, $source_col, $imp_ste_cd, $cre_by, $cre_on, $type, $log);
        }
        // Dates
        if ($data_class == 'date') {
            extrDate($db, $datetype, $typemod, $itemkey, $raw_itemval_col, $table, $uid_col, $uid, FALSE, FALSE, $source_col, $imp_ste_cd, $cre_by, $cre_on, $type, $log);
        }
    } while ($row = $sql->fetch(PDO::FETCH_ASSOC));

}

printf("</table>");

$source_db = $ark_db;
$db->query("use $source_db");

}

?>
