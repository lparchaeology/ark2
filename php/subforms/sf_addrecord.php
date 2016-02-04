<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* subforms/sf_addrecord.php
*
* a subform to register new items in a tablet-style view
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2007  L - P : Partnership Ltd.
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
* @category   subforms
* @package    ark
* @author     Michael Johnson <m.johnson@lparchaeology.com>
* @copyright  1999-2014 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_addrecord.php
* @since      File available since Release 1.2
*
*/

$mkduplicate= getMarkup('cor_tbl_markup', $lang, 'duplicate');
$mksave = getMarkup('cor_tbl_markup', $lang, 'save');

echo '<form id="register-'.$mod_short.'_cd" action="'.$ark_root_path.'/data_entry.php?view=regist&item_key='.$mod_short.'_cd" method="post">';
// put in hidden for the normal form
echo "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
echo "<input type=\"hidden\" name=\"$item_key\" value=\"{$$item_key}\" />\n";
echo "<input type=\"hidden\" name=\"sf_lang\" value=\"$lang\" />\n";
echo "<input type=\"hidden\" name=\"update_db\" value=\"register-{$item_key}\" />\n";
echo "<input type=\"hidden\" name=\"qtype\" value=\"add\" />\n";

if(!isset($fields)){
    $fields = $sf_conf['fields'];
}

// loop thru the cols
foreach($fields as $field) {
    switch ($field ['dataclass']) {
		case 'itemkey' :
			$itemval = reqArkVar ( 'itemval', FALSE );
			if ($itemval) {
				if ($itemval == 'next') {
					$field ['field_op_default'] = 'next';
				} else {
					if (strpos ( $itemval, '_' )) {
						$number = split ( '_', $itemval );
					} else {
						$number = array (
								$ste_cd,
								$itemval 
						);
					}
					
					$next = $number [1] + 1;
					$itemval = $number [0] . '_' . $next;
					$field ['field_op_default'] = $itemval;
				}
			}
			break;
		case 'modtype' :
			$field ['field_op_default'] = reqArkVar ( 'modtype' );
			break;
		case 'date' :
			break;
		case 'xmi' :
			$xmi_list_name = "xmi_list_" . $field['xmi_mod'];
			$field ['field_op_default'] = reqArkVar ( $xmi_list_name );
			break;
		default :
			$field ['field_op_default'] = reqArkVar ( $field ['classtype'] );
	}

    if ($field['dataclass']=='date'){
        echo '<div class="fieldhalf datefield">';
    } else {
        echo '<div class="fieldhalf">';
    }
    // check for defaults
    if (array_key_exists('default', $field)) {
        $default = $field['default'];
    } else {
        $default = FALSE;
    }
    // check if field is valid
    if(array_key_exists('field_id', $field)){
        // make the val
        $td_val = frmElem($field, $sf_key, $$sf_key);
        // for the first col put in the hidden fields too
        } else if(array_key_exists('type', $field)){
    // handle events    
    } else {
        printPre(array('Error with field, must have field id'=>$field));
    }
    echo "<label>{$field['field_alias']}:</label>";
    if ($field['dataclass'] == 'file') {
        $file_selection = TRUE;
    }
    // print the item
    echo $td_val;
    echo '</div>';
    
}
if ($item_key==='cxt_cd'){
    echo '<div class="btn" id="duplicate" >'.$mkduplicate.'</div>';
}
echo '<div class="submitfull"><input class="submit submitsmall" type="submit" value="'.$mksave.'"></div>';
echo '</form>';


?>
