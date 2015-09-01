<?php 
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* import/inc_cmap_nav.php
*
* provides the navigation to select and/or change a concordance map code.
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
* @link       http://ark.lparchaeology.com/svn/php/import/inc_cmap_nav.php
* @since      File available since Release 0.6
*/

// the cmap_id is reqArkVar()ed at the page level
// $cmap_id = reqArkVar('cmap_id'); // do not comment back in

//OFFER FEEDBACK
if (!$cmap_id) {
    $error[] = array('vars' => 'no concordance map is selected');
}

$cmap_details = getRow('cor_tbl_cmap', $cmap_id, FALSE);

//SAVE VALUE TO SESSION
if (isset($phpsessid)) {
    $_SESSION['cmap_id'] = $cmap_id;
}

//OFFER A SELECTOR
if ($enable_select == 'true') {
    //Draw a form with dd and submit
    $dd = ddSimple($cmap_id, $cmap_details['nname'], 'cor_tbl_cmap', 'nname', 'cmap_id', FALSE, 'code');
    $mk_go = getMarkup('cor_tbl_markup', $lang, 'go');
    printf("
        <form method=\"$form_method\" id=\"cmap_selector\" action=\"{$_SERVER['PHP_SELF']}\">
        <span class=\"row\">
        <label class=\"form_label\">Concordance Map: </label>$dd
        <button type=\"submit\">$mk_go</button>
        </span>
        </form>
    ");
}

unset($enable_select);

?>
