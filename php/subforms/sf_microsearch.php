<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* subforms/sf_microsearch.php
*
* used in an overlay, this sf gives simple searching and feedsback an item_value
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
* @author     Guy Hunt <guy.hunt@lparchaeology.com>
* @copyright  1999-2012 L - P : Heritage LLP.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/subforms/sf_txt.php
* @since      File available since Release 1.1
*
* NOTE: this can only be used in an overlay. It is not an edit type of SF and
* requires no key or val.
*
*/


// -- OPTIONS -- //

// If an optional CSS class has been specified, use it. Otherwise set a default
if (array_key_exists('op_sf_cssclass', $sf_conf)) {
    $sf_cssclass = $sf_conf['op_sf_cssclass'];
} else {
    $sf_cssclass = 'mc_subform';
}

// if an optional restriction to a specific module is in use
if (array_key_exists('op_restrict_to_mod', $sf_conf)) {
    $restrict_to_mod = $sf_conf['op_restrict_to_mod'];
} else {
    $restrict_to_mod = FALSE;
}

// if an optional display of meta is specified, use it
if (array_key_exists('op_src_meta_display', $sf_conf)) {
    $meta_display = $sf_conf['op_src_meta_display'];
} else {
    $meta_display = FALSE;
}


// -- PROCESS -- //
if ($update_db === $sf_conf['sf_html_id']) {
    include_once('php/update_db.php');
}

// -- COMMON -- //
// get common elements for all states

// Labels and so on
$sf_title = getMarkup('cor_tbl_markup', $lang, $sf_conf['sf_title']);
$mk_minisrcinst = getMarkup('cor_tbl_markup', $lang, 'minisrcinst');

// These keys are to focus this subform on a particular key val pair
$sf_focus = reqArkVar('sf_focus');
if ($sf_focus == $sf_conf['sf_html_id']) {
    $skey = reqQst($_REQUEST, 'skey');
    $sval = reqQst($_REQUEST, 'sval');
} else {
    $skey = FALSE;
    $sval = FALSE;
}


// -- STATE SPECFIC -- //
// for each state get specific elements and then produce output

switch ($sf_state) {
    
    // Overlay
    case 'overlay':
        echo "<div id=\"{$sf_conf['sf_html_id']}\" class=\"{$sf_cssclass}\">\n";
        if ($error) {
            feedBk('error');
        }
        if ($message) {
            feedBk('message');
        }
        // Sec 1 - Left Hand Side - the mini search (provides its own div)
        $msrc = 'mrsc'.$sf_conf['sf_html_id'];
        $$msrc = reqArkVar($msrc);
        $msrc = 'mrsc'.$sf_conf['sf_html_id'];
        // on the left put in a simple search
        print(mkSearchSimple($msrc, "&amp;sf_focus={$sf_conf['sf_html_id']}", $restrict_to_mod, $meta_display));
        unset($msrc);
        // Sec 1 - Right Hand Side - a record card and role chooser
        print("<div class=\"mini_card\">");
        // If there is a focus then display the card - otherwise a helpful message
        if ($skey && $sval) {
            // Set the 'focused item' up as if it were an XMIed item and pull its settings etc.
            $xmi_mod = substr($skey, 0, 3);
            include('config/mod_'.$xmi_mod.'_settings.php');
            $xmi_conf_name = $xmi_mod.'_xmiconf';
            if ($xmi_conf = $$xmi_conf_name) {
                $xmi_fields = $xmi_conf['fields'];
                $xmi_fields = resTblTh($xmi_fields, 'silent');
                $hdrbar_type = $xmi_conf['op_xmi_hdrbar'];
            }
            // Get alias for the focused/xmied itemkey
            $xmi_alias =
                getAlias(
                    'cor_tbl_module',
                    $lang,
                    'itemkey',
                    $skey,
                    1
            );
            if ($soft_fd_id) {
                $softinfo = resTblTd($$soft_fd_id, $skey, $sval);
                if ($softinfo) {
                    $softinfo = "<div id=\"hidden_$soft_fd_id\" style=\"display: none\">$softinfo</div>";
                    echo $softinfo;
                }
            }
            print("<ul class=\"top\">\n");
            print("<li>\n");
            print("<h5 class=\"return_to_sender\"><a id=\"$id_to_modify\" rel=\"$sval\" href=\"#\">");
            print("{$xmi_alias}: $sval");
            print("</a></h5>\n");
            printf("<ul id=\"fields-for-$sval\" class=\"xmi_field\">\n");
            // loop over each field that makes up the XMI item's display
            foreach ($xmi_fields as $xmi_field) {
                $val = resTblTd($xmi_field, $skey, $sval);
                print("<li class=\"row\">");
                print("<label class=\"form_label\">{$xmi_field['field_alias']}</label>");
                print("$val");
                print("</li>\n");
            }
            print("</ul>\n");
            print("</li>\n");         
            print("</ul>\n");
        // a helpful hint for the user
        } else {
            print("<p>$mk_minisrcinst</p>\n");
        }
        break;
        
    // a default - in case the sf_state is incorrect
   default:
       echo "<div id=\"sf_microsearch\" class=\"{$sf_cssclass}\">\n";
       echo "<h3>No SF State</h3>\n";
       echo "<p>ADMIN ERROR: the sf_state for sf_microsearch was incorrectly set</p>\n";
       echo "<p>The var 'sf_state' contained '$sf_state'.</p>\n";
       echo "</div>\n";
       break;
       
}

// clean up
unset ($sf_conf);
unset ($val);
unset ($sf_state);
unset ($fields);
unset ($alias_lang_info);

?>
