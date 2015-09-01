<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* user_admin/user_form_elements_pw.php
*
* subform to get password form elements
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
* @link       http://ark.lparchaeology.com/svn/php/user_admin/global_subforms/user_form_elements_pw.php
* @since      File available since Release 0.6
*/

// Raw form elements

$mk_pw = getMarkup('cor_tbl_markup', $lang, 'pw');
$mk_cpw = getMarkup('cor_tbl_markup', $lang, 'cpw');
$mk_savebtn = getMarkup('cor_tbl_markup', $lang, 'save');

?>

<div id="detfrm_edtuserpw" class="mc_subform">
<div class="sf_nav">
<h4><?php echo $frm_header ?></h4>
</div>
<form id = "user_password_form" method="<?php echo $form_method ?>" action="<?php echo $frm_action ?>">
<input type="hidden" name="update_db" value="<?php echo $update_val ?>" />
<?php echo $additional_hidden ?>
<ul>

<li class="row">
<label class="form_label"><?php echo $mk_pw ?></label>
<span class="inp"><input type="password" name="pwd" /></span>
</li>

<li class="row">
<label class="form_label"><?php echo $mk_cpw ?></label>
<span class="inp"><input type="password" name="cpwd" /></span>
</li>

<li class="row">
<label class="form_label">&nbsp;</label>
<span class="inp"><button type="submit"><?php echo $mk_button ?></button></span>
</li>

</ul>
</form>

</div>
