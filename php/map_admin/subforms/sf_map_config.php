<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* 
*
* main_content.php
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
* @link       http://ark.lparchaeology.com/svn/php/map_admin/main_content.php   
* @since      File available since Release 0.8
*/

//this can be used like a 'normal' subform therefore setup the state

switch ($sf_state) {
    case 'p_max_ent':
        //the first thing we need to do is setup a form to ensure we have all the basic mapping
        //we need at the very least: extents, scales, a base layer and a projection

        //this takes the js form validation

        $var = "<!-- javascript validation functions -->

        <script src=\"lib/js/gen_validator.js\" type=\"text/javascript\"></script>";

        //check the qs
        $extent = reqQst($_REQUEST,'extent');
        $scales = reqQst($_REQUEST,'scales');
        $projection = reqQst($_REQUEST,'projection');

        //check the temporary user input

        if (is_array($temp_user_input) && array_key_exists($cur_sf_id, $temp_user_input)) {
            if ($extent == '') {
                $extent = $temp_user_input[$cur_sf_id]['extent'];
            }
            if ($scales == '') {
                $scales = $temp_user_input[$cur_sf_id]['scales'];
            }
            if ($projection == '') {
                $projection = $temp_user_input[$cur_sf_id]['projection'];
            }
        }
        //check if we have all these - if so load them into the running array 
        if ($extent && $scales && $projection) {
            if (!is_array($temp_user_input)) {
                $_SESSION['temp_user_input'][$cur_sf_id] = array(
                    'extent' => $extent,
                    'scales' => $scales,
                    'projection' => $projection  
                );
            } else {
                $_SESSION['temp_user_input'][$cur_sf_id] = array(
                    'extent' => $extent,
                    'scales' => $scales,
                    'projection' => $projection  
                );
            }
        }

        if ($extent == '' && array_key_exists('extent',$sf_conf['defaults'])) {
            $extent = $sf_conf['defaults']['extent'];
        }

        if ($scales == '' && array_key_exists('scales',$sf_conf['defaults'])) {
            $scales = $sf_conf['defaults']['scales'];
        }
        
        if ($projection == '') {
            $projection = 'EPSG:4326';
        }
        //setup the form array
        $projection_array = $sf_conf['defaults']['projection'];

        $form_array = array(
            'form_id' => $sf_conf['sf_html_id'],
            'class' => 'table_style',
            'op_label' => $sf_conf['op_label'],
            'op_input' => $sf_conf['op_input'],
            'fields' => array(
                'extent' => array(
                    'type' => 'text',
                    'default' => $extent,
                    'vd_funcs' => array(
                        'req',
                        'DoExtentScalesValidation',
                    ),
                 ),
                 'scales' => array(
                    'type' => 'textarea',
                    'default' => $scales,
                    'vd_funcs' => array(
                        'req',
                        'DoExtentScalesValidation',
                    ),
                 ),
                 'projection' => array(
                     'type' => 'select',
                     'values' => $projection_array,
                     'default' => $projection,
                     'vd_funcs' => array(
                         'req',
                     ),
                  ),
                  'OSM' => array(
                       'type' => 'checkbox',
                       'default' => 1,
                       'vd_funcs' => array(
                       ),
                  ),
                  'gmap_api_key' => array(
                     'type' => 'textarea',
                     'default' => '',
                     'vd_funcs' => array(
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

        //now add the custom validation functions (NOTE: SHOULD BE DONE VIA SOME KIND OF CONF?)

        //first some custom validation to deal with the scales and extents

        $extent_err = getMarkup('cor_tbl_markup', $lang, 'extent_err');
        $scales_err = getMarkup('cor_tbl_markup', $lang, 'scales_err');

        $var .= '<script type="text/javascript">
                    function DoExtentScalesValidation()
                    {
                        var frm = document.forms["map_config"];
                        var expl_extent = frm.extent.value.split(",");
                        if(expl_extent.length != 4)
                        {
                            sfm_show_error_msg("'. $extent_err . '",frm.extent);
                            return false;
                        }
                        if(parseFloat(expl_extent[0]) > parseFloat(expl_extent[2]))
                        {
                            sfm_show_error_msg("'. $extent_err . '",frm.extent);
                            return false;
                        }
                
                        if(parseFloat(expl_extent[1]) > parseFloat(expl_extent[3]))
                        {
                            sfm_show_error_msg("'. $extent_err . '",frm.extent);
                            return false;
                        }
                
                        //now check the scales 
                        var expl_scales = frm.scales.value.split(",");
                
                        if(expl_scales.length <= 1)
                        {
                            sfm_show_error_msg("'. $scales_err . '",frm.scales);
                            return false;
                        }
                
                        //if we have passed all these tests - everything is ok!
                        return true;

                    }
                 </script>
        ';
        print $var;
        unset ($var);
        break;
    }
?>
