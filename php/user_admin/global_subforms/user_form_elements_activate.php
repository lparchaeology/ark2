<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* user_admin/user_form_elements_activate.php
*
* subform to activite user form elements
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
* @category   user
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/user_admin/global_subforms/user_form_elements_activate.php
* @since      File available since Release 0.6
*/


$mk_enable = getMarkup('cor_tbl_markup', $lang, 'enable');

//Get the current status of the user
$row = getRow('cor_tbl_users', $target_user_id, FALSE);
$status = $row['account_enabled'];

if ($status == 1) {
$img_stat = 'on';
$update_state = 'usrdis';
$mk_msg = getMarkup('cor_tbl_markup', $lang, 'accena');
} else {
$img_stat = 'off';
$update_state = 'usrena';
$mk_msg = getMarkup('cor_tbl_markup', $lang, 'accdis');
}

?>

<div id="detfrm_edtuseractivate" class="mc_subform">
<div class="sf_nav">
<?php printf ("<h4>$mk_enable</h4>\n") ?>
</div>
<?php printf ("<h5 style=\"padding:5px\">$mk_msg | <a href=\"$_SERVER[PHP_SELF]?update_db=$update_state&amp;user_id=$target_user_id\"><img src=\"$skin_path/images/onoff/chk_$img_stat.png\" alt=\"on/off_swtich\"></a></h5>\n") ?>
</div>
