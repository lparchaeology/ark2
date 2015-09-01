<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* map_view/left_panel.php
*
* the left panel for the map_view
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
* @category   map
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/map_view/left_panel.php
* @since      File available since Release 0.6
*/

?>

<ul>
<?php

$markup_search='map_instr';

$failed = "failed to get markup '". $markup_search."'";
if(getMarkup('cor_tbl_markup', $lang, $markup_search)!=$failed ){
    $instruction = getMarkup('cor_tbl_markup', $lang, $markup_search);
    printf('<li class="instr" ><h6>'.$alias.' instructions</h6>'.$instruction.'</li>');
}

$mk_clear = getMarkup('cor_tbl_markup', $lang, 'clear');
$mk_refresh = getMarkup('cor_tbl_markup', $lang, 'refresh');
$mk_save= getMarkup('cor_tbl_markup', $lang, 'save');
$mk_export = getMarkup('cor_tbl_markup', $lang, 'export');
?>
</ul>
<!-- The LEFT PANEL -->

<?php
$mk_mapview = getMarkup ( 'cor_tbl_markup', $lang, 'mapview' );

print '<div class="leftpanelwrapper">';
foreach ( $map_view_left_panel ['subforms'] as $subform ) {
	// set the sf_state
	$sf_state = getSfState ( 'left_lanel', $subform ['view_state'], $subform ['edit_state'] );
	// set the sf_conf
	$sf_conf = $subform;
	if (array_key_exists('op_css_class',$subform)){
		$css_class = $subform['op_css_class'];
	} else {
		$css_class = "map_toolbox";
	}
	// if the sf is conditional
	if (array_key_exists ( 'op_condition', $subform )) {
		// check the condition
		if (chkSfCond ( $item_key, $$item_key, $subform ['op_condition'] )) {
			include ($subform ['script']);
		}
	} else {
		include ($subform ['script']);
	}
	// cleanup this sf
	unset ( $sf_state );
	unset ( $subform );
}
print '</div>';
?>

