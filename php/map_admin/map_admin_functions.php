<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* map_admin_functions.php
*
* map admin functions (utilising WMS,WFS and WMC) to build and save new maps
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
* @category   map
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2007 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/map/map_functions.php
* @since      File available since Release 0.6
*/

// {{{ buildJSForm()

/**
* builds a basic JS validated form (BETA Version)
*
* 
* @param array $form_array  a properly formed array containing the needed variables (see documentation)
* @return string $var  a fully resolved html string
* @access public
* @since 0.8
*/
function buildJSForm($form_array)
{
    global $lang, $form_method;
    $var = "<form method=\"$form_method\" action=\"\" id=\"{$form_array['form_id']}\" >\n";
    
    $var .= "<fieldset>";
    $var .= "<ul>";
    
    foreach ($form_array['fields'] as $key => $value) {
        
        //get the markup
        $label = getMarkup('cor_tbl_markup', $lang, $key . '_label');
        $instr = getMarkup('cor_tbl_markup', $lang, $key . '_instr');
        $err = getMarkup('cor_tbl_markup', $lang, $key .'_err');
        
        $type = $value['type'];
        $default = $value['default'];
        $js = '';
        
        if (array_key_exists('js', $value)) {
            foreach ($value['js'] as $js_key => $js_value) {
                $js .= "$js_key=\"$js_value\" ";
            }
        }
        switch ($type) {
            case 'text':
                 $var .= "<li class=\"row\">
                                <label class=\"form_label\">$label</label>
                                <span class=\"inp_instr\"><input type=\"$type\" value=\"$default\" name=\"$key\" $js /></span>
                                <span class=\"instr\">$instr</span>
                          </li>
                    ";
                 break;
            case 'textarea':
                 $var .= "<li class=\"row\">
                                <label class=\"form_label\">$label</label>
                                <span class=\"inp_instr\"><textarea name=\"$key\" cols=\"40\" rows=\"5\" $js>$default</textarea></span>
                                <span class=\"instr\">$instr</span>
                          </li>
                 ";
                 break;
             case 'checkbox':
                  $var .= "<li class=\"row\">
                                 <label class=\"form_label\">$label</label>
                                 <span class=\"inp_instr\"><input type=\"$type\" value=\"$default\" name=\"$key\" $js /></span>
                                 <span class=\"instr\">$instr</span>
                           </li>
                  ";
                  break;
            case 'select':
            case 'select_multi':
                  $var .= "<li class=\"row\">
                                <label class=\"form_label\">$label</label>";
                                 if ($type == 'select_multi') {
                                     $brackets = "[]";
                                     $var .= "<span class=\"inp_instr\"><select multiple=\"multiple\" name=\"$key$brackets\" $js>";
                                 } else {
                                     $var .= "<span class=\"inp_instr\"><select name=\"$key\" $js>";
                                 }

                                 
                  if (array_key_exists('values',$value)) {
                        
                      foreach ($value['values'] as $option_key => $option_value) {
                          if ($option_value == $default) {
                              $var .= "<option value=\"$option_value\" selected=\"selected\">$option_key</option>\n";
                          } else {
                              $var .= "<option value=\"$option_value\">$option_key</option>\n";
                          }
                      }
                        
                  } else {
                      $var .= "<option value=\"$default\">$default</option>";
                  }       
                                 
                  $var .="       </select></span>
                                 <span class=\"instr\">$instr</span>
                           </li>
                  ";
                  break;                 
            case 'hidden':
                  $var .= "<li>
                                <span class=\"inp_instr\"><input type=\"$type\" value=\"$default\" name=\"$key\" $js/></span>
                           </li>
                     ";
                  break;
            
            default:
                # code...
                break;
        }
        
        foreach ($value['vd_funcs'] as $vd_value) {
            switch ($vd_value) {
                case 'req':
                case 'alpha':
                case 'numeric':
                    $validation_print_array[] = "frmvalidator.addValidation(\"$key\",\"$vd_value\",\"$err\");";
                    break;
                    
                //else presume we have custom validation
                default:
                    $validation_print_array[] = "frmvalidator.setAddnlValidationFunction(\"$vd_value\");";
                    break;
            }
        }
    }
    
     // finally - put in the save/options row
        $label = getMarkup('cor_tbl_markup', $lang, $form_array['op_label']);
        $input = $form_array['op_input'];
        $var .= "<li class=\"row\">";
        $var .= "<label class=\"form_label\">$label</label>";
        if ($input != 'none') {
            $input = getMarkup('cor_tbl_markup', $lang, $form_array['op_input']);
            $var .= "<span class=\"inp\">";
            $var .= "<button>$input</button>";
            $var .= "</span>";
        } else {
            $var .= "<span>";
            $var .= "&nbsp";
            $var .= "</span>";
        } 
        $var .= "</li>\n";
    
    $var .= '</ul>
            </fieldset>
            </form>
    ';
    
    //now we need to assemble the validation clauses
    $var .= "<script type=\"text/javascript\">
                var frmvalidator = new Validator(\"{$form_array['form_id']}\");
    ";
    
    foreach ($validation_print_array as $value) {
        $var .= "\n$value";
    }
    
    $var .= "</script>";
    
    return ($var);
    
}
// }}}
// {{{ buildOpenLayersWMC()
        
/**
* takes variables (extents, projection, etc.) and builds a simple OL map
*
* generates a stand-alone html <object> that contains an Openlayers map zoomed and filtered to the requested extents
*
* @param string $extent  the extents of the map in format ("minx,miny,maxx,maxy")
* @param string $scales  the scales of the map in the format ("10000,5000,2500")
* @param string $projection  the display projection in format ("EPSG:27700")
* @param array $urls  an array containing urls to draw data from (with sub-arrays for their layers) 
* @param boolean $openstreetmap  if openstreetmap is true then we are using it as a baselayer
* @param boolean $gmap_api_key  if gmap_api_key is set then we are using Google Maps as a baselayer
* @return string $var  a fully resolved html string
* @access public
* @since 0.8
*/
function buildOpenLayersWMC($extent,$scales,$projection,$urls,$openstreetmap = 0,$gmap_api_key = '')
{
    global $openlayers_path, $browser;
    
    //to get round IE6 transparency problems
    if ($browser == 'OLD_MSIE') {
        $image_format = 'image/gif';
    } else {
        $image_format = 'image/png';
    }
    if ($openstreetmap OR $gmap_api_key) {
         $head =  "
                 <div>
                 <div id=\"map\" class=\"mapview\"></div>
                 <div id=\"map_new\"></div>
                 <div id=\"wmc_code\"></div>
                 <script src=\"$openlayers_path\"></script>
         ";
         
        if ($openstreetmap) {
            # code... 
                $head .= '<!-- bring in the OpenStreetMap OpenLayers layers.
                    Using this hosted file will make sure we are kept up
                     to date with any necessary changes -->
                    <script src="http://www.openstreetmap.org/openlayers/OpenStreetMap.js"></script>
                ';
            // we can only have EITHER google maps or openstreetmap - therefore prefer the opensource and cancel google
            if ($gmap_api_key) {
                $gmap_api_key = FALSE;
            }
        }
        if ($gmap_api_key) {
            $head .= "<script src='http://maps.google.com/maps/api/js?v=3.2&sensor=false'></script>";
        }
        
        if ($projection == 'EPSG:27700') {
            $head .= '<script src="lib/js/OpenLayers.Projection.OrdnanceSurvey.js"></script>';
        }

        $head .= '<script type="text/javascript">';

        $foot = "
                } init();
                    </script>
                </div>";

    } else {

        $head =  "
                <div>
                <div id=\"map\" class=\"mapview\"></div>
                <div id=\"map_new\"></div>
                <div id=\"wmc_code\"></div>
                <script src=\"$openlayers_path\"></script>
        ";
       
        $head .= "  <script type=\"text/javascript\">";

        $foot = "
                } init();
                    </script>
                </div>";
    }

    $var = $head;
    
    $var .= '
        var map
        var map_new = document.getElementById("map_new");
        var format = new OpenLayers.Format.WMC({\'layerOptions\': {buffer: 0}}); 
        function saveWMC(merge) {
            try {
                var text = format.write(map);
                document.getElementById("wmc_code").value = text;
            } catch(err) {
                document.getElementById("wmc_code").innerHTML = err;
            }
        }
        
        function readWMC(merge) {
                    var text = document.getElementById("wmc_code").value;

                    if(merge) {
                        try {
                            map = format.read(text, {map: map});
                        } catch(err) {
                            document.getElementById("wmc_code").value = err;
                        }
                    } else {
                        map.destroy();
                        try {
                            map = format.read(document.getElementById("wmc_code").value,{map:"map"});
                        } catch(err) {
                            document.getElementById("wmc_code").innerHTML = err;
                        }
                    }
                }
        
          
        function init(){
            var scales = ['. $scales . '];
    ';
    if ($openstreetmap OR $gmap_api_key){

        //we need to convert the map_extents if necessary
        if ($projection == 'EPSG:27700') {
            $var .= 'max_bounds = new OpenLayers.Bounds('.$extent.');
                     max_bounds.transform(new OpenLayers.Projection("EPSG:27700"), new  OpenLayers.Projection("EPSG:900913"));
            ';
            
        } else {
            $var .= 'max_bounds = new OpenLayers.Bounds(-20037508.34,-20037508.34,20037508.34,20037508.34);';
        }
        
        $var .= 'map = new OpenLayers.Map ("map", {
                        maxExtent: max_bounds,
                        scales: [' . $scales . '],
                        units: "m",
                        numZoomLevels: 30,
                        projection: new OpenLayers.Projection("'.$projection.'"),
                        displayProjection: new OpenLayers.Projection("'.$projection.'")
                        });
        ';

    } else {
        
        $var .=     
            'max_bounds = new OpenLayers.Bounds('.$extent.');
             map = new OpenLayers.Map("map", {
                projection: new OpenLayers.Projection("'.$projection.'"),
                maxExtent: max_bounds,
                scales: [' . $scales . '],
                units:"m"
            });
        ';
    }                
        
    $var .= '
            map.addControl(new OpenLayers.Control.MousePosition());
            map.addControl(new OpenLayers.Control.LayerSwitcher());
            complete();
    ';
    $var .= "
            }    
            function complete() {
    ";
    if ($openstreetmap OR $gmap_api_key) {

        if ($openstreetmap) {
            $var .= 'OSM = new OpenLayers.Layer.OSM("OSM");
                 map.addLayer(OSM);
            ';
        }
        if ($gmap_api_key) {
            $var .= 'gphy = new OpenLayers.Layer.Google("Google Physical", {type: google.maps.MapTypeId.TERRAIN,sphericalMercator: true});
                     map.addLayer(gphy);
            ';
            $var .= 'gmap = new OpenLayers.Layer.Google("Google Streets", {sphericalMercator: true});
                     map.addLayer(gmap);
            ';
            $var .= 'ghyb = new OpenLayers.Layer.Google("Google Hybrid", {type: google.maps.MapTypeId.HYBRID,sphericalMercator: true,numZoomLevels: 20});
                     map.addLayer(ghyb);
            ';
            $var .= 'gsat = new OpenLayers.Layer.Google("Google Satellite", {type: google.maps.MapTypeId.SATELLITE,sphericalMercator: true,numZoomLevels: 22});
                     map.addLayer(gsat);
            ';
        }
    } 
    $i = 0;
    foreach ($urls as $url => $layers) {
           //check the params of the URL
        $expl_url = explode('?',$layers['url']);
        $url_host = $expl_url[0];
        $expl_url = explode('&',$expl_url[1]);
        $params = array();
        foreach ($expl_url as $param_value) {
            $expl_params = explode('=',$param_value);
            $params[strtoupper($expl_params[0])] = $expl_params[1];
        }
        foreach ($layers['layers'] as $layer) {
            if (array_key_exists('SERVICE', $params) && $params['SERVICE'] == 'WMS') {
                //build the URL back up, but cut off the REQUEST section
                $layer_url = $url_host ."?";
                foreach ($params as $param_name => $param_value) {
                    if ($param_name != 'REQUEST') {
                        $layer_url .= $param_name . '=' . $param_value . "&";
                    }
                }
                if (array_key_exists('sub_layers',$layer)) {
                        foreach ($layer['sub_layers'] as $sub_layer) {
                        $layer_name = $sub_layer['name'];
                        $layer_title = $sub_layer['title'];
                        $var .=    "wms_$layer_name = new OpenLayers.Layer.WMS( 
                                                \"$layer_title\",
                                                \"$layer_url\",
                                                {layers: \"$layer_name\",format: \"$image_format\",transparent: \"true\"}
                                                );\n
                        ";
                        if ($i === 0 && !$openstreetmap && !$gmap_api_key) {
                            $var .= "wms_$layer_name.isBaseLayer = true;\n";
                        } else {
                            $var .= "wms_$layer_name.isBaseLayer = false;\n";
                        }
                        //we need to convert the map_extents if necessary
                        if ($projection == 'EPSG:27700') {
                            $var .= "wms_$layer_name.addOptions('projection: new OpenLayers.Projection(\"EPSG:27700\")');";
                        }

                        $var .= "map.addLayers([wms_$layer_name]);\n";
                        $i++;
                    }
                } else {
                    $layer_name = $layer['name'];
                    $layer_title = $layer['title'];
                    $var .=    "wms_$layer_name = new OpenLayers.Layer.WMS( 
                                            \"$layer_title\",
                                            \"$layer_url\",
                                            {layers: \"$layer_name\",format: \"$image_format\",transparent: \"true\"});\n
                    ";
                    if ($i === 0 && !$openstreetmap && !$gmap_api_key) {
                        $var .= "wms_{$layer['name']}.isBaseLayer = true;\n";
                    } else {
                        $var .= "wms_{$layer['name']}.isBaseLayer = false;\n";
                    }
                    //we need to convert the map_extents if necessary
                    if ($projection == 'EPSG:27700') {
                        $var .= "wms_$layer_name.addOptions('projection: new OpenLayers.Projection(\"EPSG:27700\")');";
                    }

                    $var .= "map.addLayers([wms_$layer_name]);\n";
                    
                    $i++;
                }
            }
        }
    }
    $var .= "map.addControl(new OpenLayers.Control.LayerSwitcher({'ascending':false}));\n";
    $var .= "map.zoomToExtent(max_bounds);\n";
//var .= "map.zoomToMaxExtent();\n";
    $var .= "saveWMC();\n";
    $var .= $foot; 
    return ($var);

}
// }}}
// {{{ mkProgessBar()

/**
* this is used to build a progress bar type interface for stepping through forms 
* 
* @param array $col  a properly formed array containing a column of subform arrays
* @param int $progress  the index of the currently selected subform
* @param string $prog_filename  the name of the variable to send to the qs
* @return string $var  a fully resolved html string
* @author Stuart Eve (stuarteve@lparchaeology.com) 
* @access public
* @since 0.8
*/
function mkProgressBar($col, $progress, $prog_filename)
{
    global $lang, $browser;
    $mk_step = getMarkup('cor_tbl_markup', $lang, 'progress_step');
    $mk_finish = getMarkup('cor_tbl_markup', $lang, 'progress_finish');
    //setup the containers   
    $var = "<div id=\"progress_bar_container\"><ul class=\"prog_bar\">";
        //grab the number of steps needed and work out the li width
        $num_sfs = count($col['subforms']);
        if ($browser == 'OLD_MSIE') {
            $w = 95/$num_sfs . "%";
        } else {
            $w = 100/$num_sfs . "%";
        }
        $w = 100/$num_sfs . "%";
        //loop through the column array
        foreach ($col['subforms'] as $key => $value) {
            //check if we are ont he active page
            $prog_num = $key + 1;
            if ($key + 1 == $num_sfs) {
                $step = $mk_finish;
            } else {
                $step = "$mk_step $prog_num";
            }
            $li_contents = "<a href=\"{$_SERVER['PHP_SELF']}?$prog_filename=$key\">$step</a>";
            if ($key == $progress) {
                $var .= "<li style=\"width:$w\" class=\"current\">$li_contents</li>\n";
            } elseif ($key < $progress) {
                $var .= "<li style=\"width:$w\" class=\"completed\">$li_contents</li>\n";
            } else {
                $var .= "<li style=\"width:$w\" ><a href=\"#\">$step</a></li>\n";
            }
        }
    $var .="</ul></div>";
    return $var;
}
// }}}
?>
