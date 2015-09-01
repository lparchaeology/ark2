<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_view/subforms/sf_buildfilter.php
*
* a data_view subform for building up a filter
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
* @category   subforms
* @package    ark
* @author     Henriette Roued <henriette@roued.com>
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_view/subforms/sf_exportdownload.php
* @since      File available since Release 0.8
*
* This SF is expected to run in an overlay or in the left panel. Standard states could be
* added to allow this to function as a normal SF if any reason for that became apparent.
*
* Getting the right sf_conf requires a small piece of non-standard behavoir. Typically,
* an SF will be passed an sf_conf to it in the form of $sf_conf and it is not required to
* question this. In the case of SFs displayed within the overlay_holder.php, this parent
* script must get an sf_conf based on the name of the variable passed to the querystring.
* As this form may be triggered from a non module specific page (eg data_view.php), it must
* figure out if the result set being exported is the same as the module that overlay_holder
* has selected. If not, the relevant settings file is called and the sf_conf is switched.
*
* NB: overlay_holder.php tries to figure out a module based on the sf_key it is sent. If
* it is not sent an sf_key, it will fall back on a default (as per reqArkVar()).
*
*/


// ---- PROCESS ---- //
// process is done by filters.php
include_once('php/data_view/filters.php');


// ---- COMMON ---- //
// get common elements for all states
// get the temporary filter that is being built
if (!$new_ftr_added) {
    $filter = $filters[$ftr_id];
}
// if the option is set to force this SF to display a particular filter
if (array_key_exists('op_filter', $sf_conf)) {
    $filter =
        array(
            'ftype' => $sf_conf['op_filter'],
            'set_operator' => 'intersect',
    );
    // attempt to preload any arguments
    if (array_key_exists('op_filter_args', $sf_conf)) {
        foreach ($sf_conf['op_filter_args'] as $arg => $var) {
            $filter[$arg] = $var;
        }
    }
}
// Labels and so on
$mk_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_filteradded = getMarkup('cor_tbl_markup', $lang, 'filteradded');

// CSS
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}


// ---- STATE SPECFIC
// for each state get specific elements and then produce output
switch ($sf_state) {
    
    // Overlays
    case 'overlay':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        if (!$new_ftr_added) {
            $ftype = $filter['ftype'];
            // display the relevant filter
            $func = 'dispFlt'.$ftype;
            $func($filter, $ftr_id);
            unset($func);
        } else {
            $message[] = $mk_filteradded;
        }
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        echo "</div>";
        break;
        
    case 'p_max_view':
    case 'lpanel':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        printf(sfNav($mk_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        $ftype = $filter['ftype'];
        // display the relevant filter
        $func = 'dispFlt'.$ftype;
        $func($filter, $ftr_id);
        unset($func);
        echo "</div>";
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_buildfilter\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_buildfilter was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;
// ends switch
}
// clean up
unset ($sf_conf);
unset ($sf_state);

?>
