<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
* map/query_wrapper.php
*
* a wrapper script for pulling together results from a click-to-query map
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
* @category   map
* @package    ark
* @author     Stuart Eve <stuarteve@lparchaeology.com>
* @copyright  1999-2008 L - P : Partnership Ltd.
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/svn/php/map/query_wrapper.php
* @since      File available since Release 0.6
*/

//NOTE: This script basically uses the sf_xmi methodology to produce the query result

$_SESSION = array();
global $wxs_qlayers;
include('../../config/settings.php');
include('../../config/env_settings.php');
include('../global_functions.php');
//DEV NOTE: need to detect browser manually due to class location bug in global_funcs
$browser = reqQst($_SESSION, 'browser');
include_once ('../../lib/php/Browser.php');
$browser_detail = new Browser();
if (!$browser) {
    $browser = reqQst($_SERVER, 'HTTP_USER_AGENT');
    if (stristr($browser, "MSIE") || stristr($browser, "Internet Explorer")) {
        if ($browser_detail->getVersion() > 6) {
            $browser = 'MSIE';
        } else {
            $browser = 'OLD_MSIE';
        }
    } elseif (stristr($browser, "Mozilla")) {
        $browser = 'MOZ';
    } else {
        //the default other is the msie stylesheet
        $browser = 'OTHER';
    }
}
$stylesheet = getStylesheet($browser);
$db = dbConnect($sql_server, $sql_user, $sql_pwd, $ark_db);
$layer = reqQst($_REQUEST,'layer');
$itemval = reqQst($_REQUEST,'ark_id');
//get the mod settings
$mod = $wxs_qlayers[$layer]['mod'];
include("../../config/mod_{$mod}_settings.php");
$itemkey = $mod . '_cd';

$xmi_conf_name = $mod.'_xmiconf';
$xmi_conf = $$xmi_conf_name;
$xmi_fields = $xmi_conf['fields'];
$xmi_fields = resTblTh($xmi_fields, 'silent');
// Get alias for the itemkey
$itemkey_alias =
    getAlias(
        'cor_tbl_module',
        $lang,
        'itemkey',
        $itemkey,1
);

$var = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
        <head>';
$var .= "<script type=\"text/javascript\" src=\"$ark_root_path/js/imageflow/imageflow.js\"></script>\n";
//$var .= "<script type=\"text/javascript\" src=\"$ark_root_path/js/lightbox.js\"></script>\n";
$var .= "<link href=\"$ark_root_path/$stylesheet\" type=\"text/css\" rel=\"stylesheet\" />";
$var .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"ark/skins/$skin/stylesheets/lightbox.css\" />";
$var .= "</head>\n";
$var .= '<body>';
$var .= "<div id=\"{$xmi_conf_name}_xmi_viewer\" class=\"mc_subform\" style=\"width:250px\">\n";
$var .= "<ul id=\"existing-$mod\" class=\"xmi_list\">\n";
//$var .= "<h2 style=\"width: 100%\">";
$var .= "<label class=\"data_label\">{$itemkey_alias} </label>";
$var .= "<span class=\"data\"><a href=\"{$conf_micro_viewer}?item_key={$itemkey}";
$var .= "&amp;{$itemkey}={$itemval}\" target=\"_blank\">";
$var .= "{$itemval}";
$var .= "</a></span>";
//$var .= "</h2>\n";
$var .= "<ul id=\"fields-for-{$itemval}\" class=\"xmi_field\">\n";
 // loop over each field that makes up the XMI item's display
 foreach ($xmi_fields as $xmi_field) {
     $val = resTblTd($xmi_field, $itemkey, $itemval);
    if($val){
         $var .= "<li>";
         $var .= "<label class=\"form_label\">{$xmi_field['field_alias']}</label>";
         $var .= $val;
         $var .= "</li>\n";
    }
 }
 // End the list of fields for this XMIed item
$var .= "</ul>\n";
 // End the <li> container for the item
$var .= "</li>\n";
$var .= "</ul>\n";
$var .= "</div>\n";
$var .= '</body></html>';

print $var;

?>
