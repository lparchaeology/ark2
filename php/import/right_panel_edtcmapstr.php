<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* import/right_panel_edtcmapstr.php
*
* right panel for the view edtcmapstr
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
* @link       http://ark.lparchaeology.com/svn/php/import/right_panel_edtcmapstr.php
* @since      File available since Release 0.6
*/

$all_tbls = getTables($cmap_details['sourcedb']);
$import_tbls = array();
foreach ($all_tbls as $key => $tbl) {
    if (substr($tbl, 0 , 6) == 'import') {
        $import_tbls[] = $tbl;
    }
}

?>

<div id="rpanel">

<h1>Import Tables</h1>
<p class="message">This is a list of all 'import' tables on the source DB for this Concordance map. This includes unmapped tables and fields.</p>
<?php
echo "<ul class=\"importfields\">\n";
foreach ($import_tbls as $key => $tbl) {
echo "<li>$tbl <a href=\"{$_SERVER['PHP_SELF']}?table=$tbl\"><img src=\"$skin_path/images/plusminus/edit.png\" class=\"sml\" alt=\"[ed]\"/></a></li>\n";
}
?>
</ul>

</div>
