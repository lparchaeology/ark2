<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* data_view/subforms/sf_geonames.php
*
* a data_view subform querying the GeoNames service
*
* PHP versions 4 and 5
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
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
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2011 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/data_view/subforms/sf_geonames.php
* @since      File available since Release 1.1
*
*/

/** 
*    This subform queries the GeoNames online service, retrieving geographical
*    information, when supplied with coordinate fields
*
*    NOTE: This form has no edit mode set - as it used for viewing data, not editing it
*/


// -- OPTIONS -- //
// op_modtype
if (array_key_exists('op_modtype', $sf_conf)) {
    $modtype = $sf_conf['op_modtype'];
} else {
    $modtype = FALSE;
}

// If modtype is FALSE the fields will only come from one list , if TRUE the 
// fields will come from different field lists. 
if (chkModType($mod_short) && $modtype!=FALSE) {
    $modtype = getModType($mod_short, $sf_val);
    $fields = $sf_conf["type{$modtype}_fields"];
} else {
    $fields = $sf_conf['fields'];
}

// op_sf_cssclass
// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$form_id = $sf_conf['sf_html_id'];


// ---- SETUP ---- //

// get the GeoNames feed document
// we need a lat,long coord pair if this is not present then the form won't work
// NOTE: this coordinate pair HAS to be in Lat Long WGS84 (EPSG:4326) this form
// does NOT reproject the coordinates 

if (array_key_exists('coord_fields', $sf_conf) && count($sf_conf['coord_fields']) == 2) {
    
    // start building the GeoNames URL
    // get the lat longs from the coord fields
    $lng = resFdCurr($sf_conf['coord_fields'][0],$sf_key,$sf_val);
    $lng = $lng[0]['current'];
    $lat = resFdCurr($sf_conf['coord_fields'][1],$sf_key,$sf_val);
    $lat = $lat[0]['current'];
    
    //now lets check if the coords are not in WGS84 projection - if not we may be able to convert them
    
    if (array_key_exists('op_coord_projection', $sf_conf)) { 
        $coord_projection = $sf_conf['op_coord_projection'];
        //include the projection code - we are using a PHP port of the proj4js library
        include('lib/php/proj4php/proj4php.php');
        $proj4 = new Proj4php();
        $src_proj = new Proj4phpProj($coord_projection,$proj4);
        $dest_proj = new Proj4phpProj('EPSG:4326',$proj4);
        $point = new proj4phpPoint($lat,$lng);
        echo "Source : ".$point->toShortString()." in OSGB36 <br>";
        $pointDest = $proj4->transform($src_proj,$dest_proj,$point);
        echo "Conversion : ".$pointDest->toShortString()." in WGS84<br><br>";
    }
    //if we have a username specified in the conf use it - otherwise use the demo user (note this user has restrictions on the geonames API)
    if (array_key_exists('op_geonames_user', $sf_conf)) {
        $geonames_user = $sf_conf['op_geonames_user'];
    } else {
        $geonames_user = 'demo';
    }
    // we can configure which feature codes we want to bring back
    if (array_key_exists('op_fcodes', $sf_conf)) {
        $fcodes = $sf_conf['op_fcodes'];
    } else {
        $fcodes =
            array(
                'ADM1' => 'geonames_ADM1',
                'ADM2' => 'geonames_ADM2', 
                'ADM3' => 'geonames_ADM3',
            );
    }
    
    $feed_var = '';
    $dom = new DOMDocument();
    $url = "http://api.geonames.org/extendedFindNearby?lat=$lat&lng=$lng&username=$geonames_user";
    $geoname_feed = file_get_contents($url);
    try {
        if (!$dom->loadXML($geoname_feed)) {
            throw new Exception($err_markup);
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
        //exit();
    }
    $array_dom = dom_to_array($dom);
    //as the GeoNames response should always be standard - this array should be standardised
    //therefore output the items one by one
    $feed_var .= '<div class="frm_subform">';
    $feed_var .= "<ul>";
    //$feed_var .= '<li class="recordarea">';
    if (array_key_exists('geonames', $array_dom) && array_key_exists('geoname', $array_dom['geonames'])) {
        foreach ($array_dom['geonames']['geoname'] as $key => $geoname) {
            if (array_key_exists($geoname['fcode'], $fcodes)) {
                //grab the markup for the label
                $mk_label = getMarkup('cor_tbl_markup',$lang, $fcodes[$geoname['fcode']]);
                $feed_var .= "<li class=\"row\">
                              <label class=\"form_label\">$mk_label</label>
                              <span class=\"data\">{$geoname['name']}</span></li>
                ";
            }
        }
    }
    $feed_var .= "</ul>";
    $feed_var .= "</div>";
} else {
    echo "ADMIN ERROR: You need the coord_fields array in your sf_conf AND";
    echo " it has to contain only two fields holding coordinates in lat long (WGS84 EPSG:)<br/>";
}


// ---- STATE SPECFIC
// for each state get specific elements and then produce output
switch ($sf_state) {
    // Overlays
    case 'overlay':
        echo "ADMIN ERROR: sf_geonames is not yet setup for overlays";
        break;
        
    case 'lpanel':
    case 'p_max_view':
    case 's_max_view':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        echo $feed_var;
        // close out the sf
        echo "</div>";
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_geonames\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_geonames was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
}

// clean up
unset ($sf_conf);
unset ($sf_state);

?>
