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


// setup the ajax URL for the processing
$mk_jsonexplanation = getMarkup('cor_tbl_markup', $lang, 'jsonexplanation');
// This is just going to pass the file by POST to the update_mediabrowserscript
// using the options built above
echo '<div id="main" class="media_browser">
        <div class = "mc_subform">
        <h1>Enter JSON URL</h1>
        <p>'.$mk_jsonexplanation.'</p>
<form action="import.php?view=json_import" method="post"
enctype="multipart/form-data">
<ul><li>
<label for="file">URL:</label>
<input type="text" name="filename" id="file"><br>
</li></ul>
                <input type="submit" name="submit" value="Submit">
</form>
</div>
</div>';
?>