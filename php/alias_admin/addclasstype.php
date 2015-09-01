<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* alias_admin/addclasstype.php
*
* adds aliases during the extraction tests
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
* @link       http://ark.lparchaeology.com/svn/php/alias_admin/addclasstype.php
* @since      File available since Release 0.6
*/

// REQUESTS
$cmap_id = reqArkVar('cmap_id');
$oridetype = reqQst($_REQUEST, 'oridetype');

// SETUP
$cmap_details = getRow('cor_tbl_cmap', $cmap_id, FALSE);
$lang_dd = ddSimple('en', FALSE, 'cor_lut_language', 'language', 'new_alias_lang', FALSE, 'code');
$mk_go = getMarkup('cor_tbl_markup', $lang, 'go');


// PROCESS

// This grabs the type of dataclass we are trying to add 
$type = reqQst($_REQUEST, 'type');
$type_nname = reqQst($_REQUEST, 'type_nname');
$type_module = reqQst($_REQUEST, 'type_module');
$new_alias = reqQst($_REQUEST, 'new_alias');
$new_alias_lang = reqQst($_REQUEST, 'new_alias_lang');
$cre_by = $user_id;
$cre_on = gmdate("Y-m-d H:i:s", time());


// if we have all the required fields then we can enter the process routine
if ($type AND $type_nname AND $type_module AND $new_alias AND $new_alias_lang) {
    //DO THE PROCESSING HERE
    //first we need to add the new type
    $sql = "
        INSERT INTO cor_lut_$type ($type, module, cre_by, cre_on)
        VALUES (?,?,?,?)
    ";
    $params = array($type_nname,$type_module,$cre_by, $cre_on);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
    
    // get the $new_id
    $new_id = $db->lastInsertId();
    
    // pre process language
    $alias_lang = getSingle('language', 'cor_lut_language','id = ' . $new_alias_lang);
    
    //now we need to add the alias for this type
    $sql = "
        INSERT INTO cor_tbl_alias (alias, aliastype, language, itemkey, itemvalue, cre_by, cre_on)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ";
    $params = array($new_alias, 1, $alias_lang, "cor_lut_$type", $new_id, $cre_by, $cre_on);
    $sql = dbPrepareQuery($sql,__FUNCTION__);
    $sql = dbExecuteQuery($sql,$params,__FUNCTION__);
}

// A dd of modules
$dd_mods =
    ddSimple(
        FALSE, FALSE, 'cor_tbl_module', 'shortform', 'type_module', FALSE, FALSE, 'shortform');

?>
<div class="addclass_home">
<?php
// OUTPUT
echo "<p>This form will add a new classtype with alias. BEWARE, this form provides very few checks on the quality of the data you are entering. This is intended for the use of administrators. If you add data here it may only be corrected directly in the database</p>";

// FEEDBACK FIRST
if (isset($new_id)) {
    echo "<p>The Newly inserted type id is: $new_id</p>";
    echo "<p>To add another type please use the form below </p>";
}
if ($error) {
    feedBk('error');
}
if ($message) {
    feedBk('message');
}

// PRINT FORM

echo "<form method=\"$form_method\" id=\"alias_selector\" action=\"{$_SERVER['PHP_SELF']}\">";
echo "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";

?>

<ul>
<li class="row"><label class="form_label">Type:</label>
    <select name="type">
        <option value="">---select---</option>
        <option value="actiontype">actiontype</option>
        <option value="attributetype">attributetype</option>
        <option value="datetype">datetype</option>
        <option value="numbertype">numbertype</option>
        <option value="spantype">spantype</option>
        <option value="txttype">txttype</option>
        <option value="placetype">placetype</option>
        <option value="filetype">filetype</option>
    </select>
</li>

<li class="row">
    <label class="form_label">Type Nickname:</label>
    <input type="text" name="type_nname" />
</li>

<li class="row">
    <label class="form_label">Type Alias:</label>
    <input type="text" name="new_alias" />
</li>

<li class="row">
    <label class="form_label">Type Module:</label>
    <?php echo $dd_mods ?>
</li>

<li class="row">
    <label class="form_label">Alias Language:</label>
    <?=$lang_dd?>
</li>

<li class="row">
    <label class="form_label">&nbsp;</label>
    <button type="submit"><?php echo $mk_go ?></button>
</li>

</ul>
</form>

</div>
