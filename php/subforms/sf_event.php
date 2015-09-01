<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_event.php
*
* Subform for dealing with events
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
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @author     Henriette Roued <henriette@roued.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_event.php
* @since      File available since Release 0.6
*
* NOTE 1: since 0.6 this script has been adapted to handle dates and actions in combination 
* and alone by HRO.
* 
*/


// ---- SETUP ---- //

// Gets the events settings array from the field_settings.php
$events = $sf_conf['events'];
unset($fields);

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}


// ---- PROCESS ---- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id']) {
    foreach ($events as $event) {
        if ($event['type'] === reqQst($_REQUEST, 'event_type')) {
            // If event only has and action then the action will be updated
            if (reqQst($_REQUEST, 'event_elem') === 'action') {
                $fields[] = $event['action'];
            }
            // If the event only has a date then the date will only be updated
            if (reqQst($_REQUEST, 'event_elem') === 'date') {
                $fields[] = $event['date'];
            }
            // If the event both has an action and a date then the event element is event and both the date and the action will be updated if available
            if (reqQst($_REQUEST, 'event_elem') === 'event') {
                $action_classtype = $event['action']['classtype'];
                $date_classtype = $event['date']['classtype'];
                // If and action is sent - the action is updated
                if (reqQst($_REQUEST, $action_classtype) != ''){
                    $fields[] = $event['action'];
                }
                $date_classtype_dd = $date_classtype . '_dd';
                $date_classtype_mm = $date_classtype . '_mm';
                $date_classtype_yr = $date_classtype . '_yr';
                // If the three date bits are sent then the date is updated. 
                if (reqQst($_REQUEST, $date_classtype_dd) != ''
                    && reqQst($_REQUEST, $date_classtype_mm) != ''
                    && reqQst($_REQUEST, $date_classtype_yr) != '')
                {
                    $fields[] = $event['date'];
                }
                
            }
        }
    }
    include_once ('php/update_db.php');
    unset($fields);
}


// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

// form_id
$form_id = $sf_conf['sf_html_id'].'_form';

// Handle date and/or action being missing
foreach ($events as $key => $event) {
    if (!array_key_exists('date', $event)) {
        $events[$key]['date'] = FALSE;
    }
    if (!array_key_exists('action', $event)) {
        $events[$key]['action'] = FALSE;
    }
}


// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch ($sf_state) {
    case 'p_max_view':
    case 's_max_view':
        // start the SF
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        print(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
           feedBk('message');
        }
        // this lists the events side by side
        $var = "<ul id=\"events\" class=\"hz_list\">\n";
        foreach ($events as $event) {
            // wrap each event in an <li>
            $var .= "<li>\n";
            if (array_key_exists('action', $event) && $event['action'] != FALSE) {
                // process the action
                // take the event and put it into a fields array
                $fields[] = $event['action'];
                $fields = resTblTh($fields, 'silent');
                // we know we only have one field
                $field = $fields[0];
                // check if there is a current vlaue for this field and add to the field
                if ($cur_val = resFdCurr($field, $sf_key, $sf_val)) {
                    $field['current'] = $cur_val;
                } else {
                    $field['current'] = FALSE;
                }
                // process an appropriate form elem
                $elem = resTblTd($field, $sf_key, $sf_val);
                if (!$elem){
                    $elem = "<span class=\"data\">- -</span>";
                }
                $var .= "<h5>{$field['field_alias']}</h5>\n";
                $var .= "$elem\n";
                unset($field, $fields, $elem);
            }
            if (array_key_exists('date', $event) && $event['date'] != FALSE) {
                // process the date
                // take the event and put it into a fields array
                $fields[] = $event['date'];
                $fields = resTblTh($fields, 'silent');
                // we know we only have one field
                $field = $fields[0];
                // check if there is a current value for this field and add to the field
                if ($cur_val = resFdCurr($field, $sf_key, $sf_val)) {
                    $field['current'] = $cur_val;
                } else {
                    $field['current'] = FALSE;
                }
                // process an appropriate form elem
                $elem = resTblTd($field, $sf_key, $sf_val);
                if (!$elem){
                    $elem = "<span class=\"data\">- -</span>";
                }
                $var .= "<h5>{$field['field_alias']}</h5>\n";
                $var .= "$elem\n";
                unset($field, $fields,$elem);      
            }
            // close out the list item for this event
            $var .= "</li>\n";
        }
        // close out the list of events
        $var .= "</ul>\n";
        print $var;
        echo "</div>\n";
        break;
        
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        // start the SF
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        echo "</div>\n";
        break;
        
    case 's_max_edit':
    case 'p_max_edit':
    case 'p_max_ent':
        // start the SF
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">";
        // put in the nav
        printf(sfNav($sf_title, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        printf("<ul id=\"events\" class=\"hz_list\">\n");
        foreach ($events as $event) {
            // Each event subform can contain more than one event (set of date and action) 
            // and these will be listed next to each other here. 
            print("<li class=\"hz_list\">");
            // If an event consists of both an action and a date 
            if ($event['action'] && $event['date']) {
                // process the action
                // take the event and put it into a fields array
                $fieldsA[] = $event['action'];
                $fieldsA = resTblTh($fieldsA, 'silent');
                // we know we only have one field
                $fieldA = $fieldsA[0];
                // check if there is a current vlaue for this field and add to the field
                if ($cur_val = resFdCurr($fieldA, $sf_key, $sf_val)) {
                    $fieldA['current'] = $cur_val;
                } else {
                    $fieldA['current'] = FALSE;
                }
                // process the date
                // take the event and put it into the fields array
                $fieldsD[] = $event['date'];
                $fieldsD = resTblTh($fieldsD, 'silent');
                // we know we only have one field
                $fieldD = $fieldsD[0];
                // check if there is a current value for this field and add to the field
                if ($cur_val = resFdCurr($fieldD, $sf_key, $sf_val)) {
                    $fieldD['current'] = $cur_val;
                } else {
                    $fieldD['current'] = FALSE;
                }
                // make a form
                printf("
                    <form method=\"$form_method\" id=\"{$event['type']}\" action=\"{$_SERVER['PHP_SELF']}\">
                    <input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n
                    <input type=\"hidden\" name=\"item_key\" value=\"$item_key\" />
                    <input type=\"hidden\" name=\"$item_key\" value=\"{$$item_key}\" />
                    <input type=\"hidden\" name=\"sf_key\" value=\"{$sf_key}\" />
                    <input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />
                    <input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n
                    <input type=\"hidden\" name=\"event_type\" value=\"{$event['type']}\" />\n
                    <input type=\"hidden\" name=\"event_elem\" value=\"event\" />\n
                ");
                // process an appropriate form elem
                $elemA = frmElem($fieldA, $sf_key, $sf_val);
                $elemD = frmElem($fieldD, $sf_key, $sf_val);
                $input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
                echo "<h5>{$fieldA['field_alias']}</h5>";
                echo "$elemA";
                echo "<br/>";
                echo "<h5>{$fieldD['field_alias']}</h5>";
                echo "$elemD";
                echo "<button type=\"submit\">$input</button>";
                echo "</form>";
                unset($fieldA, $fieldsA);
                unset($fieldD, $fieldsD);
            }
            
            if ($event['action'] && !$event['date']) {
                // process the action
                // take the event and put it into a fields array
                unset($fields);
                $fields[] = $event['action'];
                $fields = resTblTh($fields, 'silent');
                // we know we only have one field
                $field = $fields[0];
                // check if there is a current vlaue for this field and add to the field
                if ($cur_val = resFdCurr($field, $sf_key, $sf_val)) {
                    $field['current'] = $cur_val;
                } else {
                    $field['current'] = FALSE;
                }
                // make a form
                printf("
                    <form method=\"$form_method\" id=\"{$form_id}-action\" action=\"{$_SERVER['PHP_SELF']}\">
                    <input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n
                    <input type=\"hidden\" name=\"item_key\" value=\"$item_key\" />
                    <input type=\"hidden\" name=\"$item_key\" value=\"{$$item_key}\" />
                    <input type=\"hidden\" name=\"sf_key\" value=\"{$sf_key}\" />
                    <input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />
                    <input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n
                    <input type=\"hidden\" name=\"event_type\" value=\"{$event['type']}\" />\n
                    <input type=\"hidden\" name=\"event_elem\" value=\"action\" />\n
                ");
                // process an appropriate form elem
                $elem = frmElem($field, $sf_key, $sf_val);
                $input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
                echo "<h5>{$field['field_alias']}</h5>";
                echo "$elem";
                echo "<button type=\"submit\">$input</button>";
                echo "</form>";
                unset($field, $fields);
            }
            if ($event['date'] && !$event['action']) {
                // process the date
                // take the event and put it into a fields array
                $fields[] = $event['date'];
                $fields = resTblTh($fields, 'silent');
                // we know we only have one field
                $field = $fields[0];
                // check if there is a current value for this field and add to the field
                if ($cur_val = resFdCurr($field, $sf_key, $sf_val)) {
                    $field['current'] = $cur_val;
                } else {
                    $field['current'] = FALSE;
                }
                // make a form
                printf("
                    <form method=\"$form_method\" id=\"{$form_id}-date\" action=\"{$_SERVER['PHP_SELF']}\">
                    <input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n
                    <input type=\"hidden\" name=\"item_key\" value=\"$item_key\" />
                    <input type=\"hidden\" name=\"$item_key\" value=\"{$$item_key}\" />
                    <input type=\"hidden\" name=\"sf_key\" value=\"{$sf_key}\" />
                    <input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />
                    <input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n
                    <input type=\"hidden\" name=\"event_type\" value=\"{$event['type']}\" />\n
                    <input type=\"hidden\" name=\"event_elem\" value=\"date\" />\n
                ");
                // process and appropriate form elem
                $elem = frmElem($field, $sf_key, $sf_val);
                $input = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_input']);
                echo "<h5>{$field['field_alias']}</h5>\n";
                echo "$elem";
                echo "<button type=\"submit\">$input</button>\n";
                echo "</form>\n";
                unset($field, $fields);
            }
            // close the list item
            print("</li>\n");
        }
        printf("</ul>\n");
        echo "</div>\n";
        // end this case
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_event\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_event was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
} // ends switch

?>
