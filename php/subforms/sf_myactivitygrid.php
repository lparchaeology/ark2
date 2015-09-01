<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* /subforms/sf_myactivitygrid.php
*
* a form to display a users recent activity in a nice grid
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
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2014 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_myactivitygrid.php
* @since      File available since Release 1.2
*
*
* this form was first authored for the Digventures project. It uses the API
* to grab the results of a filter and format them into a nice grid
*
*/

// ---- SETUP ---- //

//get the filter results

$var = '';
$active = false;

if (array_key_exists('actiontype',$sf_conf)) {
    $var = '';

    $var .= '<div class="activitygrid">';
    foreach ($sf_conf['actiontype'] as $action) {
    
        //establish the current URL
        $url = getWebHost() . $ark_dir . "api.php?";
        $params = "req=getFilter&ftr_id=new&ftype=action&action=$action&actor=$sf_val&disp_mode=text";

        $json = file_get_contents($url . $params);
        $json = json_decode($json,TRUE);

        //now let us loop through the json and set up the grid
        
        if (is_array($json)) {
        	$active=true;
    
            foreach ($json as $key => $value) {
                $type = getAlias('cor_tbl_module',$lang,'itemkey',$value['itemkey'],1);
                $xmi_mod = substr($value['itemkey'],0,3);
            
                // Includes relevant settings file
                include_once ('config/mod_'.$xmi_mod.'_settings.php');

                //Setup continued
                $xmi_conf_name = $xmi_mod.'_xmiconf';
                $xmi_conf = $$xmi_conf_name;
                $xmi_fields = $xmi_conf['fields'];
                $xmi_fields = resTblTh($xmi_fields, 'silent');
                foreach ($xmi_fields as $xmi_field) {
                
                    switch ($xmi_field['dataclass']) {
                        case 'txt':
                            //lets presume this is the right field for description
                            $desc_field = $xmi_field['field_id'];
                            break;
                        
                        case 'action':
                            //lets presume this is the right field for actor
                              $actor_field = $xmi_field['field_id'];
                              break;
                    
                        case 'date':
                          //lets presume this is the right field for actor
                            $date_field = $xmi_field['field_id'];
                            break;
                
                        default:
                            # code...
                            break;
                    }
                }
            
                //lets grab the fields
            
                $url = getWebHost() . $ark_dir . "api.php?";
                @$params = "req=getFields&fields[]=$desc_field&fields[]=$actor_field&fields[]=$date_field&itemkey={$value['itemkey']}&{$value['itemkey']}={$value['itemval']}";
            
                $field_json = file_get_contents($url . $params);
                $field_json = json_decode($field_json,TRUE);
            
                @$keys = array_keys($field_json);
            
                $desc = $field_json[$keys[0]][0]['current'];
                $user = $field_json[$keys[1]][0]['current'];
                $date = date_create($field_json[$keys[2]][0]['current']);
                $date = date_format($date,"Y/m/d");
                $link_to_item = getWebHost() . $ark_dir . "micro_view.php?item_key={$value['itemkey']}&{$value['itemkey']}={$value['itemval']}";
                $var .= "<a class=\"activityblock\" href=\"$link_to_item\">";
                $var .= "<h4>$type - {$value['itemval']}</h4>";
                $var .= "<p>$desc</p>";
                $var .= "<p class=\"name\">$user<span class=\"date\">$date</span></p>";
            }
        }
    }
    if(!$active){
    	$var .= "<p>No Recent Activity</p>";
    }
    $var .= '</div>';
} else {
    echo "ADMIN ERROR: Please specify an array of one or more actions in the sf_conf";
}


// Labels and so on
$mk_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

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
        echo "This is not yet setup for overlays";
        break;
        
    case 'lpanel':
    case 'p_max_view':
    case 's_max_view':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        printf(sfNav($mk_title, $cur_col_id, $cur_sf_id, $$disp_cols));

        echo $var;

        // close out the sf
        echo "</div>";
        
    break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_rssfeed\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_rssfeed was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;
// ends switch
}
// clean up
unset ($sf_conf);
unset ($sf_state);

?>
