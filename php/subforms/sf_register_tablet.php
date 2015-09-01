<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * subforms/sf_register_tablet.php
*
* a subform to show existing records in a table, and an area at the top to add new ones
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
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Michael Johnson <m.johnson@lparchaeology.com>
* @copyright  1999-2014 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_entry/register.php
* @since      File available since Release 1.2
*
* Note 1: This script is based on the sf_register_tbl subform
*
* Note 2: it is designed for use with arkemical skin or its variants
*
*/
$sf_state =
getSfState(
        'primary_col',
        $sf_conf['view_state'],
        $sf_conf['edit_state']
);

if ($update_db == 'register-'.$sf_key) {
    $fields = $sf_conf['fields'];
    include_once('php/update_db.php');
}
if (array_key_exists('op_scriptpath', $sf_conf)) {
    $scriptpath = $sf_conf['op_scriptpath'];
} else {
    $scriptpath = FALSE;
}
// feedback on process
if (isset($qry_results)) {
    if (isset($qry_results[0]['new_itemvalue'])) {
        // run optional sidecar script
        if ($scriptpath) {
            include_once($scriptpath);
        }
        // set up msg
        if ($sf_state == 'overlay') {
            // no link
            $msg = "New $sf_key: {$qry_results[0]['new_itemvalue']}";
        } else {
            // link to the record
            $msg = "<a href=\"data_entry.php?";
            $msg .= "item_key=$sf_key&amp;";
            $msg .= "$sf_key={$qry_results[0]['new_itemvalue']}\"";
            $msg .= ">New $sf_key: {$qry_results[0]['new_itemvalue']}</a>";
        }
        $message[] = $msg;
        unset ($msg);
    }
}
$fields = resTblTh($sf_conf['fields']);

if ($error) {
    feedBk('error');
}
if ($message) {
    feedBk('message');
}
$register='<div class="thecontent">
                    <div id="helpmain">
                    <div class="inlinehelp">';
echo $register;
                    
//to get the help form to not be in overlay mode - we need to ghost a couple of variables
$sf_state_old = $sf_state;
$fields_old = $fields;
$sf_state = 'overlay';
$sf_conf_old = $sf_conf;
$_REQUEST['help_conf'] = $item_key . "_register";
include ('php/subforms/sf_help.php');
$sf_state = $sf_state_old;
$fields = $fields_old;
$sf_conf = $sf_conf_old;


$register= '</div>';
echo $register;
echo '<div class="addinventory">';
include ('php/subforms/sf_addrecord.php');
echo '</div>
</div>';
echo '<div class="recent_items">';
$sf_conf['link_root'] = 'data_entry.php?view=recorddetail&';
include ('php/subforms/sf_recent_items.php');
echo '</div>';
unset($sf_state);
unset($sf_conf);
?>
