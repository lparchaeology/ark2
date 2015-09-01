<?php 

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* markup_admin/viewalias.php
*
* Views aliases during process of editing markup
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
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://www.lparchaeology.com/license
* @link       http://www.lparchaeology.com/svn/php/markup_admin/viewalias.php
* @since      File available since Release 0.6
*/

$type = reqQst($_REQUEST, 'type');
$class_id = reqQst($_REQUEST, 'class_id');

if (!$error) {
    printf ("<p>This is used to add an alias to a new type</p>");

//print out the form

$lang_dd = ddSimple('en', FALSE, 'cor_lut_language', 'language', 'new_alias_lang', FALSE, 'code');
$mk_go = getMarkup('cor_tbl_markup', $lang, 'go');

$var = "
    <form method=\"$form_method\" id=\"alias_selector\" action=\"$_SERVER[PHP_SELF]\">
        <ul>
            <li><span class=\"input\">Select Class Type:
                    <select name=\"type\">";
if ($type) {
    $var.= "<option value=\"$type\">$type</option>";
} else {
    $var.= "<option value=\"\">---select---</option>";
}

$var .= "
<option value=\"action\">Action</option>
<option value=\"attribute\">Attribute</option>
<option value=\"date\">Date</option>
<option value=\"number\">Number</option>
<option value=\"span\">Span</option>
<option value=\"txt\">Text</option>
<option value=\"place\">Place</option>
</select>
</span></li>";

 if($type){

     if($class_id){

         $type_dd = ddSimple(FALSE, $class_id, 'cor_lut_' . $type . 'type', $type . 'type', 'class_id', FALSE, 'code');

     }else{

         $type_dd = ddSimple(FALSE, FALSE, 'cor_lut_' . $type . 'type', $type . 'type', 'class_id', FALSE, 'code');

     }

    $var = $var . '<li><span class="input">Select ' . $type_dd . '</span></li>';
 }

$var .= "
<li><span class=\"input\"><button type=\"submit\">$mk_go</button>
</span></li>
</ul>
</form>
";

 if($class_id){

     //we now need to build the subform to display the class item and all of its aliases

     //grab all of the aliases (regardless of language)

     $aliases = getAllAliases('cor_lut_' . $type .'type','id',$class_id,1);

     if($aliases != FALSE){

         $var .= "<table><tr><th>en</th><th>it</th><tr>";

         foreach($aliases as $alias){

             $var .= "<tr><td>{$alias['alias']}</td><td>blahhh</td></tr>";

         }
         $var .= "</table>";
     }

 }

if ($error) {
    feedBk('error');
}
if ($message) {
    feedBk('message');
}

 printf($var);
}

?>
