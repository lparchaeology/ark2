<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* import/right_panel_edtcmapdat.php
*
* right panel for the view edit cmap data
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
* @link       http://ark.lparchaeology.com/svn/php/import/right_panel_edtcmapdat.php
* @since      File available since Release 0.6
*/

// NOTE: In order for these forms to work, you need to make sure that the data_entry/global_update.php functions are included into your process script.

$cmap_details = getRow($db, 'cor_tbl_cmap', $cmap_id, FALSE);

?>

<div id="rpanel">

<h1><?=getMarkup('cor_tbl_markup', $lang, 'datatoolbox')?></h1>
<p>This is where the Right Panel for view edtcmapdat should go </p>
</div>
