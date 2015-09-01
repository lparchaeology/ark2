<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* 
*
* sf_savewmc.php
*
* this subform is used to build and zoom a map and finally save it out to a WMC document 
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
* @link       http://ark.lparchaeology.com/svn/php/map_admin/subforms/sf_savewmc.php   
* @since      File available since Release 0.8
*/

//this form is used to build the OpenLayers map from the supplied params
//we presume it is at the end of the other map_admin subforms 
//therefore we first fill the variables needed

if (is_array($temp_user_input)) {
    foreach ($temp_user_input as $key => $value) {
        foreach ($value as $key2 => $value2) {
            $$key2 = $value2;
        }
    }
} else {
    $error[] = "There is a Problem with your form - you need to go back and correctly complete the previous steps";
}

//this can be used like a 'normal' subform therefore setup the state
$OSM = reqQst($_REQUEST,'OSM');
$gmap_api_key = reqQst($_REQUEST,'gmap_api_key');

switch ($sf_state) {
    case 'p_max_ent':
        //now we can build up the Openlayers map - send the variables to the function
        $map_code = buildOpenLayersWMC($extent,$scales,$projection,$map_display_layers['servers'],$OSM,$gmap_api_key);
        $var = $map_code;
        $var .= "<a href=\"overlay_holder.php?lboxreload=FALSE&amp;sf_conf=conf_map_wmcoverlay&amp;scales=$scales&amp;projection=$projection&amp;OSM=$OSM&amp;gmap_api_key=$gmap_api_key\" rel=\"lightbox|200\"><button onclick=\"saveWMC()\" type=\"submit\">Save Map</button></a>";
            $var .= "<button onclick=\"readWMC()\">reload map</button>";
        print $var;
        unset ($var);
        break;
    }
?>
