<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* user_admin/user_form_elements.php
*
* subform to get raw form elements for user update
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
* @link       http://ark.lparchaeology.com/svn/php/user_admin/global_subforms/user_form_elements.php
* @since      File available since Release 0.6
*/


// getUserInfo
//this function takes a userid and 

// Raw form elements

$mk_uname = getMarkup('cor_tbl_markup', $lang, 'uname');
$mk_fname = getMarkup('cor_tbl_markup', $lang, 'fname');
$mk_lname = getMarkup('cor_tbl_markup', $lang, 'lname');
$mk_init = getMarkup('cor_tbl_markup', $lang, 'init');
$mk_email = getMarkup('cor_tbl_markup', $lang, 'email');
$mk_pw = getMarkup('cor_tbl_markup', $lang, 'pw');
$mk_cpw = getMarkup('cor_tbl_markup', $lang, 'cpw');
$mk_newabk = getMarkup('cor_tbl_markup', $lang, 'newabk');
$mk_button = getMarkup('cor_tbl_markup', $lang, 'save');

$fname = reqArkVar('fname',FALSE);
$lname = reqArkVar('lname',FALSE);
$email = reqArkVar('email',FALSE);
$init = reqArkVar('init',FALSE);
$uname = reqArkVar('uname',FALSE);

if (isset($target_user_id) && $view != 'addusrl') {
$uname = getUserAttr($target_user_id,'username');
$fname = getUserAttr($target_user_id,'firstname');
$lname = getUserAttr($target_user_id,'lastname');
$init =  getUserAttr($target_user_id,'initials');
$email = getUserAttr($target_user_id,'email');
}

$form_rows[] = array('type' => 'text', 'label' => $mk_init, 'name' => 'init', 'value' => $init);
$form_rows[] = array('type' => 'text', 'label' => $mk_fname, 'name' => 'fname', 'value' => $fname);
$form_rows[] = array('type' => 'text', 'label' => $mk_lname, 'name' => 'lname', 'value' => $lname);

if($show_pw == 'on'){
$form_rows[] = array('type' => 'password', 'label' => $mk_pw, 'name' => 'pw', 'value' => '');
$form_rows[] = array('type' => 'password', 'label' => $mk_cpw, 'name' => 'cpw', 'value' => '');
}

$form_rows[] = array('type' => 'text', 'label' => $mk_email, 'name' => 'email', 'value' => $email);
?>

<div id="detfrm_edtuser" class="mc_subform">
	<div class="sf_nav">
		<h4><?php echo $frm_header ?></h4>
	</div>
	<form id="user_elements_form" method="<?php echo $form_method ?>"
		action="<?php echo $frm_action ?>">
		<input type="hidden" name="update_db"
			value="<?php echo $update_val ?>" />
<?php 
if (isset($additional_hidden)) {
    printf($additional_hidden);
}

?>
<ul>

<?php
    // It is set as a variable before this form is initiated.
if (isset($show_uname) && $show_uname == 'on') {
    if ($update_val == 'adusrl') {
        $uname_elem = '<input type="text" name="uname" value="'.$uname.'"></input>';
    } else {
        $uname_elem = '<span class="data">'.$uname.'</span>';
    }
    printf("
<li class=\"row\">
<label class=\"form_label\">$mk_uname</label>
<span class=\"inp\">$uname_elem </span>
</li>
");
}

foreach ($form_rows AS $row) {
printf("
<li class=\"row\">
<label class=\"form_label\">{$row['label']}</label>
<span class=\"inp\"><input type=\"{$row['type']}\" name=\"{$row['name']}\" value=\"{$row['value']}\" /></span>
</li>
");
}

if ($update_val == 'adusrl') {
printf("
<li class=\"row\">
<label class=\"form_label\">$mk_newabk</label>
<span class=\"inp\"><input type=\"checkbox\" name=\"newabk\" value=\"newabk\" checked=true/></span>
</li>
");
}
?>

<li class="row"><label class="form_label">&nbsp;</label> <span
				class="inp"><button type="submit"><?php echo $mk_button ?></button></span>
			</li>
		</ul>
	</form>

</div>
