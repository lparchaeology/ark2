<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* 
*
* sf_baselayer.php
*
* this subform is used to choose 
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with
*    archaeological data
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
* @category   map admin
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2009 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/map_admin/subforms/sf_choose_baselayer.php   
* @since      File available since Release 0.8
*/

//this can be used like a 'normal' subform therefore setup the state

switch ($sf_state) {
    case 'p_max_ent':
    
         $var = "<!-- javascript validation functions -->

            <script src=\"lib/js/gen_validator.js\" type=\"text/javascript\"></script>";
        //the first thing we need to do is check the qs

        $url = reqQst($_REQUEST,'url');
        $layers = reqQst($_REQUEST,'layers');
        $OSM = reqQst($_REQUEST,'OSM');
        $gmap_api_key = reqQst($_REQUEST,'gmap_api_key');
        $reset_legend = reqQst($_REQUEST,'reset_legend');
        
        if ($reset_legend == TRUE) {
            $_SESSION['legend_array'] = array();
        }
        
        $url_array = $sf_conf['defaults'];

        //setup the form array
        //assemble the qs for the JS parsing
        $js_params = $cur_sf_id . "&OSM=$OSM&gmap_api_key=$gmap_api_key";

        $form_array = array(
            'form_id' => $sf_conf['sf_html_id'],
            'class' => 'table_style',
            'op_label' => $sf_conf['op_label'],
            'op_input' => $sf_conf['op_input'],
            'fields' => array(
                 'url' => array(
                     'type' => 'select',
                     'js' => array(
                         'onchange' => "parseGetCapabilities(this,'$js_params')",
                      ),
                     'values' => $url_array,
                     'default' => $url,
                     'vd_funcs' => array(
                         'req',
                     ),
                  ),
                  'sf_id' => array(
                       'type' => 'hidden',
                       'default' => $cur_sf_id,
                       'vd_funcs' => array(
                       ),
                    ),
             ),
        );

        $var .= buildJSForm($form_array);
        
        $var .= "<div><a href=\"{$_SERVER['PHP_SELF']}?&reset_legend=TRUE\" >reset legend</a>";
        
        //pop in a div 
        $var .= "<div id=\"GetCapabilities\"></div>\n";

        $extent_err = getMarkup('cor_tbl_markup', $lang, 'extent_err');
        $scales_err = getMarkup('cor_tbl_markup', $lang, 'scales_err');
        
        print $var;
        unset ($var);
        break;
    }
?>
