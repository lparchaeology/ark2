<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_linklist.php
*
* global subform for lists of links
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
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_txt.php
* @since      File available since Release 0.6
*/


// ---- SETUP ---- //

// Force a mod_short
$item_key = reqArkVar('item_key', $default_itemkey);
$mod_short = substr($item_key, 0, 3);

// The default for modules with several modtypes is to have one field list,
// which is the same for all the differnt modtypes
// If you want to use different field lists for each modtype add to the subform
// settings 'op_modtype'=> TRUE and instead of 'fields' => array( add
// 'type1_fields' => array( for each type. 
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

// a final check to make sure it is set up
if (!isset($sf_conf['fields'])) {
    echo "ADMIN ERROR: the fields module list was not set up correctly";
}

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// Check for the type of linklist needed (img or text)
if (array_key_exists('op_linktype', $sf_conf)) {
    $linktype = $sf_conf['op_linktype'];
} else {
    // Set as text as default
    $linktype = 'text';
}

// ---- PROCESS ---- //
// assumes that update db is being called at the page level qtype is called on a per field basis
if ($update_db === $sf_conf['sf_html_id']) {
    include_once ('php/update_db.php');
}

// ---- COMMON ---- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);

// ---- STATE SPECFIC
// for each state get specific elements and then produce output

switch ($sf_state) {
    // Min Views
    case 'min_view':
    case 'min_edit':
    case 'min_ent':
        print("<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">");
        // put in the nav
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        print("</div>");
        break;
    
    // Max Views
    case 'p_max_ent' :
    case 'p_max_view' :
    case 's_max_view' :
    case 'lpanel' :
        // put in the nav
        ?>
        <div id="<?php echo $sf_conf['sf_html_id']?>" class="menubtn"><a href="#"><?php echo $sf_title ?></a></div>
        <nav id="<?php echo $sf_conf['sf_html_id']?>_nav" class="sidemenu">
        <div class="prompt"><?php echo getMarkup('cor_tbl_markup', $lang, $sf_conf['prompt'])?></div>
        <?php
        $modulelist = "<ul>";
        if (isset($modshort)) {
            $old_mod_short = $modshort;
        }
        foreach ( $sf_conf['fields'] as $modshort ) {
            $id = getSingle('id', 'cor_tbl_module', "where shortform = '{$modshort}'");
            $moditem = "<a href=\"{$sf_conf['href']}&amp;reset=1&amp;ftr_id=new&amp;ftype=key&amp;ktype=all&amp;key=$id\">";
            $moditem .= getAlias('cor_tbl_module', $lang, 'itemkey', $modshort . '_cd', 1);
            $moditem .= "</a>";
            
            $modulelist .= "<li>{$moditem}</li>";
        }
        if (isset($old_mod_short)) {
            $modshort = $old_mod_short;
        }
        $modulelist .= "</ul>";
        print $modulelist;
        print("</nav>");
        // clean up
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_linklist\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_linklist was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'</p>\n";
       echo "</div>\n";
       break;
       
// ends switch
}
// clean up
unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);
unset ($alias_lang_info);

?>
