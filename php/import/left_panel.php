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

//Left panel in data entry will be a list of data entry options

?>

<h1><?=getMarkup('cor_tbl_markup', $lang, 'importoptions')?></h1>
<h1><?=getMarkup('cor_tbl_markup', $lang, 'dbimport')?></h1>
<ul class="importlpanel">
    <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>?view=newcmap">New Concordance Map</a></li>
    <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>?view=edtcmap">Edit Concordance Map</a></li>
    <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>?view=edtcmapstr">Edit Structure Map</a></li>
    <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>?view=extr_test">Extraction Test and Import</a></li>
</ul>
<h1><?=getMarkup('cor_tbl_markup', $lang, 'jsonimport')?></h1>
<ul class="importlpanel">
    <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>?view=json_picker">Pick Json File</a></li>
    <li><a href="<?php echo $_SERVER['PHP_SELF'] ?>?view=json_import">Import Json</a></li>
</ul>
    
