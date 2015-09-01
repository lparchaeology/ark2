<div id="detfrm_edtusersgrp" class="mc_subform">

<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* user_admin/user_form_elements_sgrp.php
*
* subform to get user group form elements
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
* @link       http://ark.lparchaeology.com/svn/php/user_admin/global_subforms/user_form_elements_sgrp.php
* @since      File available since Release 0.6
*/



//Get a dd of sgrps
$dd = ddSimple(FALSE, FALSE, 'cor_lvu_groups', 'group_define_name', 'group_id', FALSE, 'code', 'group_id');

$mk_edt_sgrps = getMarkup('cor_tbl_markup', $lang, 'edt_sgrps');
$mk_savebtn = getMarkup('cor_tbl_markup', $lang, 'save');

$perm_user_id = getPermUserId($target_user_id);

$params = array( 'filters' => array(
                 'perm_user_id' => $perm_user_id
                ) );

$edt_groups = $$liveuser_admin->perm->getGroups($params);


printf ("
        <div class=\"sf_nav\">
        <h4>$mk_edt_sgrps</h4>\n
        </div>");

printf("\n\n
<form id =\"user_sgrp_form\" method=\"$form_method\" action=\"$_SERVER[PHP_SELF]\">\n
<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n
<input type=\"hidden\" name=\"update_db\" value=\"adsgrp\" />\n
<input type=\"hidden\" name=\"user_id\" value=\"$target_user_id\" />\n
<ul class=\"group_list\" style=\"padding:5px\">\n");

foreach ($edt_groups as $edt_group){
//Get the current row information
$sgrp_alias = getAlias('cor_tbl_sgrp', $lang, 'id', $edt_group['group_id'], 1);

printf("<li class=\"row\">$sgrp_alias <a class=\"smalldelete\" href=\"$_SERVER[PHP_SELF]?update_db=dlsgrp&amp;sgrp_id={$edt_group['group_id']}&amp;user_id=$target_user_id\">
<img class=\"smalldelete\" alt=\"X\" src=\"{$skin_path}/images/plusminus/delete_small.png\">
</a></li>\n");

}

printf("
<li>$dd <button type=\"submit\">+</button></li>\n
</ul>\n
</form>\n");

?>

</div>
