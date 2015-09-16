<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* alias_admin/global_update.php
* Update script for the alias admin page
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
* @category   base
* @package    ark
* @author     Henriette Roued <henriette@roued.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/alias_admin/update_alias.php
* @since      File available since Release 0.6
*/

$qtype = reqQst($_REQUEST,'qtype');

$error = array();

//OPTION 1 - ADD
if ($qtype == 'add') {
    // trip the query needed switch
    $query_needed = 'G1';
    // request variables
    $new_alias = reqQst($_REQUEST,'new_alias');
    $alias_lang = reqQst($_REQUEST,'alias_lang');
    $type = reqQst($_REQUEST,'type');
    $class_id = reqQst($_REQUEST,'class_id');
    $item_val= 'cor_lut_'.$type.'type';
    $cre_by = $user_id;
    $cre_on = dbTimestamp();
    //Alias
    // 1 - MUST BE SET
    if (!$new_alias) {
        $error[] = array('field' => 'new_alias', 'vars' => "no new alias");
    }
    
    //Language
    // 1 - MUST BE SET
    if (!$alias_lang) {
        $error[] = array('field' => 'alias_lang', 'vars' => "no language");
    }
}
//OPTION 2 - EDIT
if ($qtype == 'edt') {
    // trip the query needed switch
    $query_needed = 'G2';
    // request variables
    $new_alias = reqQst($_REQUEST,'new_alias');
    $alias_lang = reqQst($_REQUEST,'alias_lang');
    $type = reqQst($_REQUEST,'type');
    $edt = reqQst($_REQUEST,'edt');
    $class_id = reqQst($_REQUEST,'class_id');
    $item_val= 'cor_lut_'.$type.'type';
    $cre_by = $user_id;
    $cre_on = dbTimestamp();
    
    //Alias
    // 1 - MUST BE SET
    if (!$new_alias) {
        $error[] = array('field' => 'new_alias', 'vars' => "no new alias");
    }
    
    //Language
    // 1 - MUST BE SET
    if (!$alias_lang) {
        $error[] = array('field' => 'alias_lang', 'vars' => "no language");
    }
}
//PART 3 OPTION DELETE
if ($qtype == 'del') {
    // trip the query needed switch
    $query_needed = 'G3';
    $frag_id = reqQst($_REQUEST,'frag_id');
    $cre_by = $user_id;
    $cre_on = dbTimestamp();
}

// ---------- Execution ------------

//OPTION 1 - ADD ALIAS

if ($query_needed == 'G1' AND !$error) {
    $table = 'cor_tbl_alias';
    $fields = array('alias', 'aliastype', 'language', 'itemkey', 'itemvalue', 'cre_by', 'cre_on');
    $values = array($new_alias, 1, $alias_lang, $item_val, $class_id, $cre_by, $cre_on);
    $logtype = 'addalias';
    $results = dbRunAddQuery($table, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

//OPTION 2 - EDT ALIAS

if ($query_needed == 'G2' AND !$error) {
    $table = 'cor_tbl_alias';
    $fields = array('alias', 'language', 'cre_by', 'cre_on');
    $values = array($new_alias, $alias_lang, $cre_by, $cre_on);
    $logtype = 'aliasedt';
    $results = dbUpdateSingleIdRow($table, $edt, $fields, $values, $logtype, $cre_by, $cre_on, __FUNCTION__);
}

//OPTION 3 - DELETE ALIAS
if ($query_needed == 'G3') {
    delFrag(
        'alias',
        $frag_id,
        $cre_by,
        $cre_on
        );
}


?>
