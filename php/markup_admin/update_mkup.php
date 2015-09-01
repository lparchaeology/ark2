<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* markup_admin/update_mkup.php
*
* processes adds or edits to markup
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
* @category   markup
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2011 L - P : Partnership LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/trunk/php/markup_admin/update_mkup.php
* @since      File available since Release 0.6
*/

// --- Request Variables --- //
//addMarkup($nname, $markup, $lang, $description, $cre_by, $cre_on)
$mk_id = reqQst($_REQUEST,'mk_id');
$nname = reqQst($_REQUEST,'nname');
$markup = reqQst($_REQUEST,'markup');
$mk_lang = reqQst($_REQUEST,'mk_lang');
$mk_mod = reqQst($_REQUEST,'mk_mod');
$description = reqQst($_REQUEST,'description');
$mk_del = reqQst($_REQUEST,'mk_del');
if ($update_db == 'mk_edt'){
    $old_mk_id = reqQst($_REQUEST,'old_mk_id');
}
$cre_by = $user_id;
$cre_on = 'NOW()';

if ($mk_del == FALSE){
    //load these into an array
    $var_array = array(
        'mk_id' => $mk_id,
        'nname' => $nname,
        'markup' => $markup,
        'mk_lang' => $mk_lang,
        'mk_mod' => $mk_mod,
        'description' => $description,
    );

    //check if we have any blanks
    foreach ($var_array as $key => $var){
        if (!isset($var) OR $var == NULL OR $var == FALSE){
            $error[]['vars'] = "$key was not set";
        }
    }

    if (!$error){
    // run the add/edit scripts

        if($mk_id == 'new_id' ){
            $results = addMarkup($nname, $markup, $mk_mod, $mk_lang, $description, $cre_by, $cre_on);
            $mk_id = $results['new_id'];
            $view = 'view_mkup';
        }else{
            $results = edtMarkup($mk_id, $nname, $markup, $mk_mod, $mk_lang, $description, $cre_by, $cre_on);
            $view = 'view_mkup';
        }
    
    }
}else{
    delFrag('markup', $mk_del, $cre_by, $cre_on);
    $message[] = "markup $mk_del deleted";
    $view = 'home';
}

?>
