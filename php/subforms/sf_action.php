<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* subforms/sf_action.php
*
* subform for handling actors and their actions
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
* @category   season
* @package    ark
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_action.php
* @since      File available since Release 0.7
*/


// ---- SETUP ---- //

// an option to define the sf_conf of the register
if (array_key_exists('op_register', $sf_conf)) {
    $register_conf = $sf_conf['op_register'];
    // with a secondary option to specify the location (ie which mod) of the conf
    if (array_key_exists('op_reg_key', $sf_conf)) {
        $reg_key = $sf_conf['op_reg_key'];
    } else {
        $reg_key = $sf_key;
    }
} else {
    $register_conf = FALSE;
}

// an option to define the sf_conf of the microsearch overlay
if (array_key_exists('op_microsearch', $sf_conf)) {
    $microsearch_conf = $sf_conf['op_microsearch'];
} else {
    $microsearch_conf = FALSE;
}

// an optional 'soft' info field to return from the search overlay
if (array_key_exists('op_soft_fd_id', $sf_conf)) {
    $soft_fd_id = $sf_conf['op_soft_fd_id'];
    $soft_field = "&amp;soft_fd_id=$soft_fd_id";
} else {
    $soft_fd_id = FALSE;
    $soft_field = FALSE;
}


// ---- PROCESS ---- //

// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id']) {
    $events = $sf_conf['events'];
    foreach ($events as $event) {
        $qst = reqQst($_REQUEST, 'event_type');
        if ($event['type'] === $qst) {
            if (reqQst($_REQUEST, 'event_elem') === 'action') {
                $fields[] = $event['action'];
            }
            if (reqQst($_REQUEST, 'event_elem') === 'date') {
                $fields[] = $event['date'];
            }
        } else {
            $fields = FALSE;
            $message[] = "Event type: '{$event['type']}' in config doesnt match: '$qst' in qstr";
        }
    }
    include_once ('php/update_db.php');
    unset($fields, $qst);
    unset($events);
}

// ---- RETRIEVE INFO ---- //

// Get the first event
$event = $sf_conf['events'][0];
// Make it into fields
$fields[] = $event['action'];
// Process the fields
//$fields = resTblTh($fields, 'silent');
// we know we only have one field
$field = $fields[0];

// dyn alows us to work with many actions, else clause uses a single named classtype
if ($field['classtype'] == 'dyn') {
    // get the list of ALL the actors who have acted on this item
    $actors_array = getActor($sf_key, $sf_val, FALSE, 'abk_cd');
    // Weed out actions that we aren't interested in
    if (array_key_exists('op_exclude_actions', $sf_conf)) {
        $exclude_list = explode(',', $sf_conf['op_exclude_actions']);
    } else {
        $exclude_list = FALSE;
    }
    // Do some pre-processing
    if ($actors_array && $field['classtype'] == 'dyn') {
        foreach ($actors_array as $key => $actor) {
            $alias = getAlias('cor_lut_actiontype', $lang, 'id', $actor['actiontype'], 1);
            // This allows admins to specify 1 or 2 elements of the abk to display
            if (array_key_exists('displaytxt', $field)) {
                $elemtxttype1 = $field['displaytxt'];
                $elem1 = getActorElem($actor['actor_itemvalue'], $elemtxttype1, 'abk_cd', 'txt');
            } else {
                echo "ADMIN ERROR: 'displaytxt' is obligatory as of v0.7 in action fields<br/>";
                $elem1 = FALSE;
            }
            if (array_key_exists('op_displaytxt2', $field)) {
                $elemtsttype2 = $field['op_displaytxt2'];
                $elem2 = getActorElem($actor['actor_itemvalue'], $elemtsttype2, 'abk_cd', 'txt');
            } else {
                $elem2 = FALSE;
            }
            // Stick the bits together
            $name = FALSE;
            if ($elem1) {
                $name = $elem1;
            }
            if ($elem2) {
                $name = $elem2;
            }
            if ($elem1 && $elem2) {
                $name = $elem1.' - '.$elem2;
            }
            // Place the info into an array for future reference
            $actors_array[$key]['name'] = $name;
            $actors_array[$key]['action'] = $alias;
            $actors_array[$key]['sort_key'] = $alias.'-'.$name;
            // Exclude actions in the exclude list
            if ($exclude_list) {
                if (in_array($actor['actiontype'], $exclude_list)) {
                    unset ($actors_array[$key]);
                }
            }
        }
    }
} else {
    $actors_array = getActor($sf_key, $sf_val, $field['classtype'], 'abk_cd');
    if (!empty($actors_array)) {
        foreach ($actors_array as $key => $actor) {
            $alias = getAlias('cor_lut_actiontype', $lang, 'id', $actor['actiontype'], 1);
            $aname = getActorElem($actor['actor_itemvalue'], 'name', 'abk_cd', 'txt');
            $org = getActorElem($actor['actor_itemvalue'], 'organisation', 'abk_cd', 'txt');
            if ($aname) {
                $name = $aname;
            }
            if ($org) {
                $name = $org;
            }
            if ($aname && $org) {
                $name = $aname.' - '.$org;
            }
            $actors_array[$key]['name'] = $name;
            $actors_array[$key]['action'] = $alias;
            $actors_array[$key]['sort_key'] = $name;
        }
    }
}

// Sort the array
if (isset($actors_array) && !empty($actors_array)) {
    $actors_array = sortResArr($actors_array, 'SORT_ASC', 'sort_key');
}

// General Stuff
if ($field['classtype'] == 'dyn') {
    $sf_name = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
} else {
    $sf_name = getAlias('cor_lut_actiontype', $lang, 'actiontype', $field['classtype'], 1);
}
$mk_save = getMarkup('cor_tbl_markup', $lang, 'save');
$mk_add = getMarkup('cor_tbl_markup', $lang, 'add');
$mk_addabk = getMarkup('cor_tbl_markup', $lang, 'abkregister');
$mk_srcabk = getMarkup('cor_tbl_markup', $lang, 'srcabk');
$mk_delete = getMarkup('cor_tbl_markup', $lang,'delete');

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// ---- OUTPUT ---- //

// ---- STATE SPECFIC ---- //
// for each state get specific elements and then produce output

switch ($sf_state) {
    // MAX Views
    case 'p_max_view':
    case 's_max_view':
        echo "<div id=\"sf_{$sf_conf['sf_html_id']}_{$sf_val}\" class=\"{$sf_cssclass}\">";
        print(sfNav($sf_name, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($actors_array) {
            print("<ul>\n");
            foreach ($actors_array as $tmbr) {
                $alias = $tmbr['action'];
                $name = $tmbr['name'];
                $out_p = "<li id=\"cor_tbl_action-frag-{$tmbr['id']}\" class=\"row\">";
                $out_p .= "<label class=\"data_label\">$alias:</label><span class=\"data\">$name</span>";
                $out_p .= "</li>\n";
                print($out_p);
                unset($out_p);
                unset($name);
                unset($alias);
            }
            print("</ul>\n");
        }
        print("</div>\n\n");
        break;
        
    // MAX Edit
    case 'p_max_edit':
    case 'p_max_ent':
        // These keys are to focus this subform on a particular key val pair
        $sf_focus = reqArkVar('sf_focus');
        if ($sf_focus == $sf_conf['sf_html_id']) {
            $skey = reqQst($_REQUEST, 'skey');
            $sval = reqQst($_REQUEST, 'sval');
        } else {
            $skey = FALSE;
            $sval = FALSE;
        }
        print("<div id=\"sf_actors_$sf_val\" class=\"{$sf_cssclass}\">");
        print(sfNav($sf_name, $cur_col_id, $cur_sf_id, $$disp_cols));
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // Section 1 - The upper part of the SF: list actors
        if ($actors_array) {
            print("<ul>\n");
            foreach ($actors_array as $key => $actor) {
                $alias = getAlias('cor_lut_actiontype', $lang, 'id', $actor['actiontype'], 1);
                $aname = getActorElem($actor['actor_itemvalue'], 'name', 'abk_cd', 'txt');
                $frag_id = $actor['id'];
                $actor = getActorElem($actor['actor_itemvalue'], 'organisation', 'abk_cd', 'txt');
                if ($aname && $actor) {
                    $catname = $aname.' - '.$actor;
                    $aname = FALSE;
                    $actor = FALSE;
                } else {
                    $catname = FALSE;
                }
                // Delete option
                $del_sw = "<a href=\"{$_SERVER['PHP_SELF']}";
                $del_sw .= "?$item_key={$$item_key}&amp;update_db=delfrag&amp;dclass=action";
                $del_sw .= "&amp;delete_qtype=del&amp;frag_id={$frag_id}\">";
                $del_sw .= "<img class=\"smalldelete\" ";
                $del_sw .= "src=\"{$skin_path}/images/plusminus/delete_small.png\" alt=\"$mk_delete\" />";
                $del_sw .= "</a>";
                $out_p = "<li class=\"row\">";
                $out_p .= "<label class=\"form_label\">$alias:</label><span class=\"data\">";
                $out_p .= " $catname$aname$actor $del_sw</span>";
                $out_p .= "</li>\n";
                print($out_p);
                unset($out_p);
                unset($aname);
                unset($tmbr);
                unset($catname);
                unset($alias);
            }
            print("</ul>\n");
        }
        
        // Section 2 - The form
        
        // buttons to launch the register and the search
        if ($register_conf || $microsearch_conf) {
            $reg = "<div class=\"popup_reg\">\n";
            if ($register_conf) {
                $reg .= "<a title=\"lbox_title\" href=\"overlay_holder.php?sf_conf=$register_conf";
                $reg .= "&amp;id_to_modify=actor_id_to_add{$sf_conf['sf_html_id']}";
                $reg .= "&amp;lboxreload=0";
                $reg .= $soft_field;
                $reg .= "&amp;sf_key=$reg_key&amp;sf_val=$sf_val\"";
                $reg .= " rel=\"lightbox\">";
                $reg .= "<img class=\"med\" title=\"$mk_addabk\"";
                $reg .= " src=\"{$skin_path}/images/plusminus/bigplus.png\">";
                $reg .= "</a>";
            }
            if ($microsearch_conf) {
                $reg .= "<a title=\"lbox_title\" href=\"overlay_holder.php?sf_conf=$microsearch_conf";
                $reg .= "&amp;id_to_modify=actor_id_to_add{$sf_conf['sf_html_id']}";
                $reg .= "&amp;lboxreload=0";
                $reg .= $soft_field;
                $reg .= "&amp;sf_key=$sf_key&amp;sf_val=$sf_val\"";
                $reg .= " rel=\"lightbox\">";
                $reg .= "<img class=\"med\" title=\"$mk_srcabk\"";
                $reg .= " src=\"{$skin_path}/images/plusminus/view_mag.png\">";
                $reg .= "</a>";
            }
            $reg .= "</div>\n";
        } else {
            $reg = FALSE;
        }
        
        // "dyn" mode allows the user to select the actiontype from a list
        if ($field['classtype'] == 'dyn') {
            // DEV NOTE: This dd is pulling actions that are on the exclude list!
            $actiontypeelem =
                ddAlias(
                    FALSE,
                    FALSE,
                    'cor_lut_actiontype',
                    $lang,
                    $field['classtype'].'_actiontype',
                    'ORDER BY cor_tbl_alias.alias',
                    'code'
            );
        } else {
            $actiontypeelem = "<input type=\"hidden\" name=\"actiontype\" value=\"{$field['classtype']}\" />\n";
            $class_alias = getAlias(
                'cor_lut_actiontype',
                $lang,
                'actiontype',
                $field['classtype'],
                1
        );
            $actiontypeelem .= "<label class=\"form_label\">{$class_alias}</label>\n";
        }
        // make up the form
        $label = getMarkup('cor_tbl_markup', $lang, $sf_conf['op_label']);
        $form = "<form method=\"$form_method\" class=\"xmi_add\"";
        $form .= "id=\"{$sf_conf['sf_html_id']}_role\" action=\"{$_SERVER['PHP_SELF']}\">\n";
        $form .= "<input type=\"hidden\" name=\"submiss_serial\" value=\"{$_SESSION['submiss_serial']}\" />\n";
        $form .= "<input type=\"hidden\" name=\"item_key\" value=\"$item_key\" />\n";
        $form .= "<input type=\"hidden\" name=\"$item_key\" value=\"{$$item_key}\" />\n";
        $form .= "<input type=\"hidden\" name=\"sf_focus\" value=\"{$sf_conf['sf_html_id']}\" />\n";
        $form .= "<input type=\"hidden\" name=\"sf_key\" value=\"{$sf_key}\" />\n";
        $form .= "<input type=\"hidden\" name=\"sf_val\" value=\"{$sf_val}\" />\n";
        $form .= "<input type=\"hidden\" name=\"itemval\" value=\"{$sf_val}\" />\n";
        $form .= "<input type=\"hidden\" name=\"event_elem\" value=\"action\" />\n";
        $form .= "<input type=\"hidden\" name=\"event_type\" value=\"{$event['type']}\" />\n";
        $form .= "<input type=\"hidden\" name=\"update_db\" value=\"{$sf_conf['sf_html_id']}\" />\n";
        $form .= "<input type=\"hidden\" name=\"{$field['classtype']}_qtype\" value=\"add\" />\n";
        $form .= "<span class=\"inp\">";
        $form .= "<input id=\"actor_id_to_add{$sf_conf['sf_html_id']}\" type=\"text\" name=\"{$field['classtype']}\" value=\"$sval\" />\n";
        $form .= "$reg</span>";
        $form .= "<label id=\"label_actor_id_to_add{$sf_conf['sf_html_id']}\" class=\"form_label\">$label</label>";
        $form .= $actiontypeelem;
        $form .= "<button type=\"submit\">$mk_save</button>\n";
        $form .= "</form>";
        
        
        echo $form;
        echo "</div>\n\n";
        break;
        
    // MIN views
    case 'min_view':
        print("<div id=\"sf_action_{$sf_val}\" class=\"{$sf_cssclass}\">");
        print(sfNav($sf_name, $cur_col_id, $cur_sf_id, $$disp_cols));
        //end div and linefeeds
        print("</div>\n\n");
        break;
        
    // a default - in case the sf_state is incorrect
    default:
        echo "<div id=\"sf_action\" class=\"{$sf_cssclass}\">\n";
        echo "<h3>No SF State</h3>\n";
        echo "<p>ADMIN ERROR: the sf_state for sf_action was incorrectly set</p>\n";
        echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
        echo "</div>\n";
        break;
        
}

unset ($event, $fields, $field);

?>
